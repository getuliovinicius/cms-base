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

// VERIFICA A PERMISSAO DE ACESSO ############################################################

if (!in_array(7, $sessaoPermissoes)) {
	// retorna mensagem de erro
	setcookie('msgErro[privilegio]', 'Acesso restrito a usuários com permissão.', time() + 10, '/cms-base/administracao/');
	header('Location: /cms-base/administracao/');
	exit;
}

// ###########################################################################################

// VERIFICA SE FOI PREENCHIDO UM FORMULARIO ##################################################

if (getenv("REQUEST_METHOD") != "POST" or !$_POST['titulo']) {
	// retorna mensagem de erro
	header('Location: /cms-base/administracao/nao-encontrado');
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
if (empty($_POST['siteEmail'])) {
	$erro['siteEmail'] = "O campo <strong>E-MAIL</strong> n&atilde;o foi preenchido.";
} else {
	if (filter_var($_POST['siteEmail'], FILTER_VALIDATE_EMAIL)) {
		$testeEmail = explode("@",$_POST['siteEmail']);
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
			$siteEmail = $usuarioEmail . "@" . $dominioEmail;
		} else {
			$erro['siteEmail'] = "O campo <strong>E-MAIL</strong> n&atilde;o continha um endere&ccedil;o v&aacute;lido. Usu&Aacute;rio e Dom&iacute;nio";
		}
	} else {
		$erro['siteEmail'] = "O campo <strong>E-MAIL</strong> n&atilde;o continha um endere&ccedil;o v&aacute;lido. Filtro";
	}
}	

// validar nome
if (empty($_POST['siteAutor'])) {
	$erro['siteAutor'] = "O campo <strong>NOME</strong> n&atilde;o foi preenchido.";
} elseif (alfanumerico($_POST['siteAutor']) == FALSE) {
	$erro['siteAutor'] = "O campo <strong>NOME</strong> deve conter apenas letras.";
} else {
	$siteAutor = $_POST['siteAutor'];
}

// validar titulo do site
if (empty($_POST['siteTitulo'])) {
	$erro['siteTitulo'] = "O campo <strong>T&Iacute;TULO DO SITE</strong> n&atilde;o foi preenchido.";
} else {
	if (alfanumerico($_POST['siteTitulo']) != FALSE) {
		$siteTitulo = $_POST['siteTitulo'];
	} else {
		$erro['siteTitulo'] = "O campo <strong>T&Iacute;TULO DO SITE</strong> deve conter apenas letras e ou numeros.";
	}
}

// validar o slogan do site
if (empty($_POST['siteSlogan'])) {
	$erro['siteSlogan'] = "O campo <strong>SLOGAN SITE</strong> n&atilde;o foi preenchido.";
} else {
	$siteSlogan = strip_tags($_POST['siteSlogan']);
}

// validar a descricao do site
if (empty($_POST['siteDescricao'])) {
	$erro['siteDescricao'] = "O campo <strong>DESCRI&Ccedil;&Atilde;O DO SITE</strong> n&atilde;o foi preenchido.";
} else {
	$siteDescricao = strip_tags($_POST['siteDescricao']);
}

// validar as palavras chave do site
if (empty($_POST['sitePalavraschave'])) {
	$erro['sitePalavraschave'] = "O campo <strong>PALAVRAS CHAVE</strong> n&atilde;o foi preenchido.";
} else {
	$sitePalavraschave = strip_tags($_POST['sitePalavraschave']);
}

// ###########################################################################################

// CHECAR SE TODA PERSSISTENCIA FOI VALIDA ###################################################

if (count($erro) != 0) {
	// retorna msgErro
	foreach ($erro as $idErro => $msgErro) {
		setcookie("msgErro['$idErro']", $msgErro, time() + 10, '/cms-base/administracao/configuracoes/');
	}
	header('Location: /cms-base/administracao/configuracoes/');
	exit;
}

// ###########################################################################################

// GERAR O ARUIVO cabacalho.php ##############################################################

$cabecalho = "<?php\n";
$cabecalho .= "$" . "siteTitulo = \"" . $siteTitulo . "\";\n";
$cabecalho .= "$" . "siteSlogan = \"" . $siteSlogan . "\";\n";
$cabecalho .= "$" . "siteDescricao = \"" . $siteDescricao . "\";\n";
$cabecalho .= "$" . "sitePalavraschave = \"" . $sitePalavraschave . "\";\n";
$cabecalho .= "$" . "siteAutor = \"" . $siteAutor . "\";\n";
$cabecalho .= "$" . "siteEmail = \"" . $siteEmail . "\";\n";
$cabecalho .= "$" . "siteUrlcompleta = " . "$" . "_SERVER['HTTP_HOST'] . " . "$" . "_SERVER['REQUEST_URI'];\n";
$cabecalho .= "?>";
$arquivoCabecalho = fopen($_SERVER['DOCUMENT_ROOT'] . "/cms-base/include/geral/php/cabecalho.php","w+"); 
fwrite($arquivoCabecalho,$cabecalho);
fclose($arquivoCabecalho);

// ###########################################################################################

// REDIRECIONA PARA A PAGINA DE CONFIGURACOES ################################################

setcookie('msgOk', 'Configurações salvas com sucesso.', time() + 10, '/cms-base/administracao/configuracoes/');
header('Location: /cms-base/administracao/configuracoes/');
exit;

// ###########################################################################################
?>