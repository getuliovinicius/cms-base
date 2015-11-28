<?php
/* ###########################################################
ARQUIVO ALVO DO FORMULARIO DE CONFIGURACAO DO ADMINISTRADOR DO SITE
CRIACAO 	20/05/2012
ATUALIZADO 	20/05/2012
########################################################### */

// VERIFICA SE FOI PREENCHIDO UM FORMULARIO ##################################################

// retorna mensagem de erro
if (getenv("REQUEST_METHOD") != "POST" or !$_POST['avancar']) {
	setcookie('msgErro[formulario]', 'Inicie a instala&ccedil;&atilde;o.', time() + 10, '/cms-base/instalacao/');
	header('Location: /cms-base/instalacao/');
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

// o titulo do site desta vez nao e verificado
$siteTitulo = $_POST['siteTitulo'];

// validar o email
if (empty($_POST['usrEmail'])) {
	$erro['usrEmail'] = "O campo <strong>E-MAIL</strong> n&atilde;o foi preenchido.";
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
			$erro['usrEmail'] = "O campo <strong>E-MAIL</strong> n&atilde;o continha um endere&ccedil;o v&aacute;lido. Usu&Aacute;rio e Dom&iacute;nio";
		}
	} else {
		$erro['usrEmail'] = "O campo <strong>E-MAIL</strong> n&atilde;o continha um endere&ccedil;o v&aacute;lido. Filtro";
	}
}	

// validar nome
if (empty($_POST['usrNome'])) {
	$erro['usrNome'] = "O campo <strong>NOME</strong> n&atilde;o foi preenchido.";
} elseif (alfanumerico($_POST['usrNome']) == FALSE) {
	$erro['usrNome'] = "O campo <strong>NOME</strong> deve conter apenas letras.";
} else {
	$usrNome = $_POST['usrNome'];
}

// validar apelido
if (empty($_POST['usrApelido']) and !empty($_POST['usrNome'])) {
	$ap = explode(" ",$_POST['usrNome']);
	$usrApelido = $ap[0];
	$usrApelidourl = alfanumerico($ap[0]);
} elseif (!empty($_POST['usrApelido'])) {
	$usrApelidourl = alfanumerico($_POST['usrApelido']);
	if ($usrApelidourl != FALSE) {
		$usrApelido = $_POST['usrApelido'];
	} else {
		$erro['usrApelido'] = "O campo <strong>APELIDO</strong> deve conter apenas letras e ou numeros.";
	}
}

// validar o usuario
if (empty($_POST['usrLogin'])) {
	$erro['usrLogin'] = "O campo <strong>USU&Aacute;RIO</strong> n&atilde;o foi preenchido.";
} else {
	if (ctype_alpha($_POST['usrLogin'])) {
		$usrLogin = $_POST['usrLogin'];
	} else {
		$erro['usrLogin'] = "O campo <strong>USU&Aacute;RIO</strong> deve conter apenas letras.";
	}
}

// validar a imagem
$usrFoto = "/cms-base/imagens/usuarios/administrador.png";

// validar a descricao
$usrDescricao = "Administrador do site.";

// validar a metaDescricao
$usrMetadescricao = "Administrador do site.";

// validar palavraschave
$usrPalavraschave = "Administrador";

// validar a senha
if (empty($_POST['usrSenha1']) or ($_POST['usrSenha1'] != $_POST['usrSenha2'])) {
	$erro['senha'] = "Entre com a mesma sequ&ecirc;ncia de caracteres nos campos <strong>SENHA</strong> e <strong>CONFIRME A SENHA</strong>. Ambos devem ser preenchidos.";
} elseif (!ctype_alnum($_POST['usrSenha1'])) {
	$erro['senha'] = "Preencha apenas com letras e (ou) n&uacute;meros os campos <strong>SENHA</strong> e <strong>CONFIRME A SENHA</strong>.";
} else {
	$usrSenha = trim($_POST['usrSenha1']);
	$usrSenha = md5($usrSenha);
}

// ###########################################################################################

// CHECAR SE TODA PERSSISTENCIA FOI VALIDA ###################################################

if (count($erro) != 0) {
	// retorna msgErro
	foreach ($erro as $idErro => $msgErro) {
		setcookie("msgErro['$idErro']", $msgErro, time() + 10, '/cms-base/instalacao/terceira-parte.php');
	}
	setcookie('instalacao', $siteTitulo, time() + 10, '/cms-base/instalacao/terceira-parte.php');
	header('Location: /cms-base/instalacao/terceira-parte.php');
	exit;
}

// CRIAR O USUARIO ADMINISTRADOR #############################################################

require_once '../classes/sql-funcoes.php';

// inclui administrador no banco de dados
$sql = "
INSERT INTO usuarios 
	(usrEmail, usrNome, usrLogin, usrApelido, usrApelidourl, usrFoto, usrDescricao, usrMetadescricao, usrPalavraschave, usrSenha, usrAtivo, usrRoot)
VALUES
	('$usrEmail', '$usrNome', '$usrLogin', '$usrApelido', '$usrApelidourl', '$usrFoto', '$usrDescricao', '$usrMetadescricao', '$usrPalavraschave', '$usrSenha', 's', 's');
";
$sqlFuncoes = new sqlFuncoes();
$sqlFuncoes->setSql($sql);
$usrId = $sqlFuncoes->incluiRegisto(true);
unset($sqlFuncoes);

// inclui permissoes para administrador
$sql = "
SELECT acaoId, moduloId
FROM modulos_acao
ORDER BY moduloId ASC;
";
$sqlFuncoes = new sqlFuncoes();
$sqlFuncoes->setSql($sql);
$acoes = $sqlFuncoes->listaRegistros();
unset($sqlFuncoes);
foreach ($acoes as $chave => $valor) {
	$sql = "
	INSERT INTO modulos_permissao (acaoId, moduloId, usrId)
	VALUES ($valor[acaoId], $valor[moduloId], $usrId);
	";
	$sqlFuncoes = new sqlFuncoes();
	$sqlFuncoes->setSql($sql);
	$sqlFuncoes->incluiRegisto();
	unset($sqlFuncoes);
}

// ###########################################################################################

// CRIACAO DOS ARQUIVO CAH ###################################################################

// COMPLETAR O ARQUIVO cabecalho.php
$cabecalho .= "$" . "siteAutor = \"" . $usrNome . "\";\n";
$cabecalho .= "$" . "siteEmail = \"" . $usrEmail . "\";\n";
$cabecalho .= "$" . "siteUrlcompleta = " . "$" . "_SERVER['HTTP_HOST'] . " . "$" . "_SERVER['REQUEST_URI'];\n";
$cabecalho .= "?>";
$arquivoCabecalho = fopen($_SERVER['DOCUMENT_ROOT'] . "/cms-base/include/geral/php/cabecalho.php","a"); 
fwrite($arquivoCabecalho,$cabecalho);
fclose($arquivoCabecalho);

// ATIVAR O HTACCESS
copy($_SERVER['DOCUMENT_ROOT'] . "/cms-base.htaccess", $_SERVER['DOCUMENT_ROOT'] . "/.htaccess");

// ###########################################################################################

// CHECAR A CRIACAO DOS ARQUIVOS CH ##########################################################

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/cms-base/include/geral/php/cabecalho.php") == true and file_exists($_SERVER['DOCUMENT_ROOT'] . "/.htaccess") == true) {
	setcookie('instalacao', $siteTitulo, time() + 10, '/cms-base/instalacao/concluir.php');
	header('Location: /cms-base/instalacao/concluir.php');
	exit;	
} else {
	setcookie('msgErro[siteArquivosCAH]', 'Por motivos não previstos, o ADMINISTRADOR do site não foi salvo.', time() + 10, '/cms-base/instalacao/');
	header('Location: /cms-base/instalacao/');
	exit;
}

// ###########################################################################################
?>