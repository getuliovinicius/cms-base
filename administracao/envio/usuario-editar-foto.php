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

// VERIFICA SE FOI PREENCHIDO UM FORMULARIO ##################################################

if (getenv("REQUEST_METHOD") != "POST" or !$_POST['editar-foto']) {
	// retorna erro
	header('Location: /administracao/nao-encontrado');
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
	setcookie('msgErro[privilegio]', 'Acesso restrito a usuários com permissão.', time() + 10, '/administracao/usuarios');
	header('Location: /administracao/usuarios');
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

// checar se existe a foto antiga
if (empty($_POST['usrFotoantiga'])) {
	$erro['usrFotoantiga'] = "<strong>FOTO ANTIGA:</strong> A troca n&atilde;o foi poss&iacute;vel. Imposs&iacute;vel localizar a foto antiga";
} elseif (!file_exists($_SERVER['DOCUMENT_ROOT'] . $_POST['usrFotoantiga'])) {
	$erro['imagemAntiga'] = "<strong>FOTO ANTIGA:</strong> N&atilde;o foi encontrada.";
} else {
	$usrFotoantiga = $_POST['usrFotoantiga'];
}

// validar apelido
if (empty($_POST['usrApelido'])) {
	$erro['usrApelido'] = "<strong>APELIDO:</strong> A troca n&atilde;o foi poss&iacute;vel. Imposs&iacute;vel identificar usu&aacute;rio.";
} else {
	$usrApelidourl = alfanumerico($_POST['usrApelido']);
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

// ###########################################################################################

// CHECAR SE TODA PERSSISTENCIA FOI VALIDA ###################################################

if (count($erro) != 0) {
	// retorna msgErro
	foreach ($erro as $idErro => $msgErro) {
		setcookie("msgErro['$idErro']", $msgErro, time() + 10, '/administracao/usuario-editar/' . $usrId);
	}
	header("Location: /administracao/usuario-editar/" . $usrId);
	exit;
}	

// ###########################################################################################

// PREPARAR O UPLOAD DA FOTO #################################################################

$fotoNome = explode('.', $usrFoto["name"]);
$fotoNome = strtolower($usrApelidourl . "-" . time() . "." . $fotoNome[1]);
$fotoDiretorio = $_SERVER['DOCUMENT_ROOT'] . "cms-base/imagens/usuarios/" . $fotoNome;
$fotoEndereco = "/imagens/usuarios/" . $fotoNome;

// ###########################################################################################

// EDITAR USUARIO NA BASE DE DADOS ###########################################################

require_once '../../classes/sql-funcoes.php';
$sqlUsuario = "
UPDATE usuarios
SET usrFoto = '$fotoEndereco'
WHERE usrId = '$usrId'
LIMIT 1;
";
$sqlFuncoes = new sqlFuncoes();
$sqlFuncoes->setSql($sqlUsuario);
$sqlFuncoes->atualizaRegistro();
unset($sqlFuncoes);

// ###########################################################################################

// DELETAR FOTO ANTIGA #######################################################################

unlink($_SERVER['DOCUMENT_ROOT'] . $usrFotoantiga);

// ###########################################################################################

// UPLOAD DA NOVA FOTO #######################################################################

move_uploaded_file($usrFoto["tmp_name"], $fotoDiretorio);		

// ###########################################################################################

// RETORNA PARA A PAGINA DE EDICAO DO USUARIO ################################################

setcookie('msgOk', 'A <strong>FOTO</strong> do usu&aacute;rio foi alterada com sucesso.<br />', time() + 10, '/administracao/usuario-editar/' . $usrId);
	header("Location: /administracao/usuario-editar/" . $usrId);
exit;

?>