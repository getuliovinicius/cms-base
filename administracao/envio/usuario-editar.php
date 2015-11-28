<?php
// VERIFICACAO SE EXISTE UM LOGIN ATIVO ######################################################
if (!isset($_SESSION)) {
	session_start();
}

// Checa a validade do login na classe loginUsuario
require_once '../../classes/login-usuario.php';
if (!loginUsuario::verificaLogin()) {
	setcookie('erroLogin', 'Autenticação nescessária.', time() + 10, '/cms-base/administracao/login/');
	header('Location: /cms-base/administracao/login');
} else {
	require_once '../../include/login/php/login-atualiza.php';
}

// ###########################################################################################

// VERIFICA SE FOI PREENCHIDO UM FORMULARIO ##################################################

if (getenv("REQUEST_METHOD") != "POST" or !$_POST['editar']) {
	// retorna erro
	header('Location: /cms-base/administracao/nao-encontrado');
	exit;
}

// ###########################################################################################

// VERIFICA A PERMISSAO DE ACESSO ############################################################

if (in_array(6, $sessaoPermissoes) and isset($_POST['usrId']) and ctype_digit($_POST['usrId'])) {
	$usrId = $_POST['usrId'];
} else if (!in_array(6, $sessaoPermissoes) and isset($_POST['usrId']) and $_POST['usrId'] == $sessaoId) {
	$usrId = $_POST['usrId'];
} else {
	// retorna mensagem de erro
	setcookie('msgErro[privilegio]', 'Acesso restrito a usuários com permissão.', time() + 10, '/cms-base/administracao/usuarios');
	header('Location: /cms-base/administracao/usuarios');
	exit;
}


// ###########################################################################################

// FUNCOES ###################################################################################

// validar strings alfanumericas
function alfanumerico($string) {
	$buscaCaracteres = array("Â","À","Á","Ä","Ã","â","ã","à","á","ä","ª","Ê","È","É","Ë","ê","è","é","ë","Î","Í","Ì","Ï","î","í","ì","ï","Ô","Õ","Ò","Ó","Ö","ô","õ","ò","ó","ö","º","Û","Ù","Ú","Ü","û","ú","ù","ü","Ç","ç"," ");
	$substituiCaracteres = array("A","A","A","A","A","a","a","a","a","a","a","E","E","E","E","e","e","e","e","I","I","I","I","i","i","i","i","O","O","O","O","O","o","o","o","o","o","o","U","U","U","U","u","u","u","u","C","c","-");
	$string = str_replace($buscaCaracteres, $substituiCaracteres, $string);
	if (ctype_alnum(str_replace("-","a", $string))) {
		return strtolower($string);
	} else {
		return FALSE;
	}
}

// ###########################################################################################

// PERSISTENCIA DE DADOS #####################################################################

// define array para os erros
$erro = array();

// validar o email
if (empty($_POST['usrEmail'])) {
	$erro['usrEmail'] = "<strong>E-MAIL:</strong> O campo n&atilde;o foi preenchido.";
} else {
	if (filter_var($_POST['usrEmail'], FILTER_VALIDATE_EMAIL)) {
		$testeEmail = explode("@",$_POST['usrEmail']);
		if (ctype_alnum($testeEmail[0])) {
			$usuarioEmail = $testeEmail[0];
		} else {
			$buscaCaracteres = array(".", "_", "-");
			$caracteres = str_replace($buscaCaracteres, "a", $testeEmail[0]);
			if (ctype_alnum($caracteres)) {
				$usuarioEmail = $testeEmail[0];
			}
		}
		@$sock = fsockopen($testeEmail[1], 80);
		if($sock) {
			fclose($sock);
			$dominioEmail = strtolower($testeEmail[1]);
		}
		if (isset($usuarioEmail, $dominioEmail)) {
			$usrEmail = $usuarioEmail . "@" . $dominioEmail;
		} else {
			$erro['usrEmail'] = "<strong>E-MAIL:</strong> O campo n&atilde;o continha um endere&ccedil;o v&aacute;lido.";
		}
	} else {
		$erro['usrEmail'] = "<strong>E-MAIL:</strong> O campo n&atilde;o continha um endere&ccedil;o v&aacute;lido. Filtro";
	}
}

// validar nome
if (empty($_POST['usrNome'])) {
	$erro['usrNome'] = "<strong>NOME:</strong> O campo n&atilde;o foi preenchido.";
} elseif (alfanumerico($_POST['usrNome']) == FALSE) {
	$erro['usrNome'] = "<strong>NOME:</strong> O campo deve conter apenas letras.";
} else {
	$usrNome = $_POST['usrNome'];
}

// validar o usuario
if (empty($_POST['usrLogin']) or !ctype_alpha($_POST['usrLogin'])) {
	$erro['usrLogin'] = "<strong>USU&Aacute;RIO:</strong> O campo n&atilde;o foi preenchido de forma correta. Deve conter apenas letras.";
} else {
	require_once '../../classes/sql-funcoes.php';
	$sqlUsuario = "
	SELECT COUNT(*) AS total
	FROM usuarios
	WHERE usrLogin = '" . $_POST['usrLogin'] . "'
	AND usrId != " . $usrId . ";
	";
	$sqlFuncoes = new sqlFuncoes();
	$sqlFuncoes->setSql($sqlUsuario);
	if ($sqlFuncoes->contaRegistros("total") != 0) {
		$erro['usrLogin'] = "<strong>USU&Aacute;RIO:</strong> Esse login j&aacute; existe. Tente outro.";
	} else {
		$usrLogin = $_POST['usrLogin'];
	}
	unset($sqlFuncoes);
}

// validar apelido
if (empty($_POST['usrApelido']) and $usrNome) {
	$usrApelido = explode(" ",$usrNome);
	$usrApelidourl = alfanumerico($usrApelido[0]);
	$usrApelido = $usrApelido[0];
} elseif (alfanumerico($_POST['usrApelido']) != FALSE) {
	$usrApelido = $_POST['usrApelido'];
	$usrApelidourl = alfanumerico($_POST['usrApelido']);
} else {
	$erro['usrApelido'] = "<strong>APELIDO:</strong> O campo deve conter apenas letras e ou numeros.";
}

// validar a descricao
if (empty($_POST['usrDescricao'])) {
	$usrDescricao = "<strong>DESCRI&Ccedil;&Atilde;O:</strong> O campo n&atilde;o foio preenchido.";
} else {
	$usrDescricao = (!get_magic_quotes_gpc()) ? addslashes($_POST['usrDescricao']) : $_POST['usrDescricao'];
}

// validar a meta descricao
if (empty($_POST['usrMetadescricao'])) {
	$erro['usrMetadescricao'] = "<strong>META DESCRI&Ccedil;&Atilde;O:</strong> O campo n&atilde;o foi preenchido.";
} else {
	$usrMetadescricao = (!get_magic_quotes_gpc()) ? addslashes($_POST['usrMetadescricao']) : $_POST['usrMetadescricao'];
	$usrMetadescricao = strip_tags($usrMetadescricao);
}

// validar palavras chave
if (empty($_POST['usrPalavraschave'])) {
	$erro['usrPalavraschave'] = "<strong>PALAVRAS CHAVE:</strong> O campo n&atilde;o foi preenchido.";
} else {
	$usrPalavraschave = (!get_magic_quotes_gpc()) ? addslashes($_POST['usrPalavraschave']) : $_POST['usrPalavraschave'];
	$usrPalavraschave = strip_tags($usrPalavraschave);
}

// validar ativo
if (empty($_POST['usrAtivo'])) {
	$erro['usrAtivo'] = "<strong>ATIVO:</strong> Marque uma das duas op&ccedil;&otilde;es.";
} elseif ($_POST['usrAtivo'] == "s" or $_POST['usrAtivo'] == "n") {
	$usrAtivo = $_POST['usrAtivo'];
} else {
	$erro['usrAtivo'] = "<strong>Ativo:</strong> O campo possui informa&ccedil;&atilde;o incorreta.";
}

// ###########################################################################################

// CHECAR SE TODA PERSSISTENCIA FOI VALIDA ###################################################

if (count($erro) != 0) {
	// retorna msgErro
	foreach ($erro as $idErro => $msgErro) {
		setcookie("msgErro['$idErro']", $msgErro, time() + 10, '/cms-base/administracao/usuario-editar/' . $usrId);
	}
	header("Location: /cms-base/administracao/usuario-editar/" . $usrId);
	exit;
}	

// ###########################################################################################

// EDITAR USUARIO NA BASE DE DADOS ###########################################################

$sqlUsuario = "
UPDATE usuarios
SET usrEmail = '$usrEmail', usrNome = '$usrNome', usrLogin = '$usrLogin', usrApelido = '$usrApelido', usrApelidourl = '$usrApelidourl', usrDescricao = '$usrDescricao', usrMetadescricao = '$usrMetadescricao', usrPalavraschave = '$usrPalavraschave', usrAtivo = '$usrAtivo'
WHERE usrId = '$usrId'
LIMIT 1;
";
$sqlFuncoes = new sqlFuncoes();
$sqlFuncoes->setSql($sqlUsuario);
$sqlFuncoes->atualizaRegistro();
unset($sqlFuncoes);

// ###########################################################################################

// RETORNA PARA A PAGINA DE EDICAO DO USUARIO ################################################

setcookie('msgOk', 'Altera&ccedil;&otilde;es no cadastro do usu&aacute;rio realizadas com sucesso.', time() + 10, '/cms-base/administracao/usuario-editar/' . $usrId);
header("Location: /cms-base/administracao/usuario-editar/" . $usrId);
exit;

// ###########################################################################################
?>