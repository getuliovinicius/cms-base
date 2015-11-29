<?php
// VERIFICACAO SE EXISTE UM LOGIN ATIVO ######################################################
if (!isset($_SESSION)) {
	session_start();
}

// Checa a validade do login na classe loginUsuario
require_once '../../classes/login-usuario.php';
if (!loginUsuario::verificaLogin()) {
	setcookie('erroLogin', 'Autenticação nescessária.', time() + 10, '/administracao/login/');
	header('Location: /administracao/login');
} else {
	require_once '../../include/login/php/login-atualiza.php';
}

// ###########################################################################################

// VERIFICA A PERMISSAO DE ACESSO ############################################################

if (!in_array(6, $sessaoPermissoes)) {
	// retorna mensagem de erro
	setcookie('msgErro[privilegio]', 'Acesso restrito a usuários com permissão.', time() + 10, '/administracao/usuarios');
	header('Location: /administracao/usuarios');
	exit;
}

// ###########################################################################################

// VERIFICA SE FOI PREENCHIDO UM FORMULARIO ##################################################

if (getenv("REQUEST_METHOD") != "POST" or !$_POST['cadastrar']) {
	// retorna mensagem de erro
	header('Location: /administracao/nao-encontrado');
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
	$sqlUsuario = "
	SELECT COUNT(*) AS total
	FROM usuarios
	WHERE usrLogin = '" . $_POST['usrLogin'] . "';
	";
	require_once '../../classes/sql-funcoes.php';
	$sqlFuncoes = new sqlFuncoes();
	$sqlFuncoes->setSql($sqlUsuario);
	if ($sqlFuncoes->contaRegistros("total") > 0) {
		$erro['usrLogin'] = "<strong>USU&Aacute;RIO:</strong> O login \"$_POST[usrLogin]\" já existe. Tente outro.";
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

// validar a foto
$testeFoto = ($_FILES['usrFoto']['size'] > 0) ? $_FILES['usrFoto'] : FALSE;
if ($testeFoto == FALSE) {
	$erro['usrFoto'] = "<strong>FOTO:</strong> Voc&ecirc; n&atilde;o anexou um arquivo.";
} elseif (!preg_match("/^jpeg|gif|png$/", $testeFoto["type"])) {
	$erro['usrFoto'] = "<strong>FOTO:</strong> Arquivo em formato inv&aacute;lido! O arquivo deve terextens&atilde;o jpg, gif ou png.";
} elseif ($testeFoto["size"] > 106883) {
	$erro['usrFoto'] = "<strong>FOTO:</strong> O arquivo deve ter no m&aacute;ximo '100KB'.";
} else {
	$usrFoto = $_FILES['usrFoto'];
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

// validar a Palavras chave
if (empty($_POST['usrPalavraschave'])) {
	$erro['usrPalavraschave'] = "<strong>PALAVRAS CHAVE:</strong> O campo n&atilde;o foi preenchido.";
} else {
	$usrPalavraschave = (!get_magic_quotes_gpc()) ? addslashes($_POST['usrPalavraschave']) : $_POST['usrPalavraschave'];
	$usrPalavraschave = strip_tags($usrPalavraschave);
}

// validar a senha
if (empty($_POST['usrSenha1']) or ($_POST['usrSenha1'] != $_POST['usrSenha2'])) {
	$erro['usrSenha'] = "<strong>SENHA:</strong> Entre com a mesma sequ&ecirc;ncia de caracteres nos campos  senha e confirme a senha. Ambos devem ser preenchidos.";
} elseif (!ctype_alnum($_POST['usrSenha1'])) {
	$erro['usrSenha'] = "<strong>SENHA:</strong> Preencha apenas com letras e (ou) n&uacute;meros.";
} else {
	$usrSenha = trim($_POST['usrSenha1']);
	$usrSenha = md5($usrSenha);
}

// ###########################################################################################

// CHECAR SE TODA PERSSISTENCIA FOI VALIDA ###################################################

if (count($erro) != 0) {
	// retorna msgErro
	foreach ($erro as $idErro => $msgErro) {
		setcookie("msgErro['$idErro']", $msgErro, time() + 10, '/administracao/usuario-novo');
	}
	header('Location: /administracao/usuario-novo');
	exit;
}	

// ###########################################################################################

// PREPARAR O UPLOAD DA FOTO #################################################################

$fotoNome = explode('.', $usrFoto["name"]);
$fotoNome = strtolower($usrApelidourl . "-" . time() . "." . $fotoNome[1]);
$fotoDiretorio = $_SERVER['DOCUMENT_ROOT'] . "cms-base/imagens/usuarios/" . $fotoNome;
$fotoEndereco = "/imagens/usuarios/" . $fotoNome;

// ###########################################################################################

// CADASTRAR USUARIO NA BASE DE DADOS ########################################################

$sqlUsuario = "
INSERT INTO usuarios
	(usrEmail, usrNome, usrLogin, usrApelido, usrApelidourl, usrFoto, usrDescricao, usrMetadescricao, usrPalavraschave, usrSenha)
VALUES
	('$usrEmail', '$usrNome', '$usrLogin', '$usrApelido', '$usrApelidourl', '$fotoEndereco', '$usrDescricao', '$usrMetadescricao', '$usrPalavraschave', '$usrSenha');
";
$sqlFuncoes = new sqlFuncoes();
$sqlFuncoes->setSql($sqlUsuario);
$usrId = $sqlFuncoes->incluiRegisto(true);
unset($sqlFuncoes);

// inclui permissoes para o usuario
$sql = "
SELECT acaoId, moduloId
FROM modulos_acao
WHERE acaoRestrita = 'n'
ORDER BY moduloId, acaoId ASC;
";
$sqlFuncoes = new sqlFuncoes();
$sqlFuncoes->setSql($sql);
$acoes = $sqlFuncoes->listaRegistros();
unset($sqlFuncoes);
foreach ($acoes as $chave => $valor) {
	$sql = "
	INSERT INTO modulos_permissao (acaoId, moduloId, usrId)
	VALUES ('$valor[acaoId]', '$valor[moduloId]', '$usrId');
	";
	$sqlFuncoes = new sqlFuncoes();
	$sqlFuncoes->setSql($sql);
	$sqlFuncoes->incluiRegisto();
	unset($sqlFuncoes);
}

// ###########################################################################################

// UPLOAD DA FOTO ############################################################################

move_uploaded_file($usrFoto["tmp_name"], $fotoDiretorio);

// ###########################################################################################

// REDIRECIONA PARA A PAGINA DE PERMISSOES DO USUARIO ########################################

setcookie('msgOk', 'Usu&aacute;rio cadastrado com sucesso.', time() + 10, '/administracao/usuario-permissao/');
header("Location: /administracao/usuario-permissao/" . $usrId);
exit;

// ###########################################################################################
?>