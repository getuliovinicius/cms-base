<?php
// VERIFICACAO SE EXISTE UM LOGIN ATIVO ######################################################
if (!isset($_SESSION)) {
	session_start();
}

// Checa a validade do login na classe loginUsuario
require_once '../classes/login-usuario.php';
if (!loginUsuario::verificaLogin()) {
	setcookie('erroLogin', 'Autenticação necessária.', time() + 10, '/administracao/login/');
	header('Location: /administracao/login');
	exit;
} else {
	require_once '../include/login/php/login-atualiza.php';
}

// ###########################################################################################

// DEFINE QUAL PAGINA SERA CARREGADA ATRAVES DE URLs AMIGAVEIS ###############################

require_once '../classes/administracao-url-amigavel.php';
$setModulo = (isset($_GET['setModulo'])) ? $_GET['setModulo'] : "painel";
$urlAmigavel = new urlAmigavel();
$urlAmigavel->setModulo($setModulo);
$modulo = $urlAmigavel->carregaModulo();

include $modulo['pagina'];

// ###########################################################################################
?>