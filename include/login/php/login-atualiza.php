<?php
/* ###########################################################
INCLUDE ATUALIZA A SESSAO DO USUARIO
CRIACAO:		12/05/2012
ATUALIZACAO:	21/05/2012
########################################################### */

$sessaoId = $_SESSION['loginSitecmsADM']['sessaoId'];
$sessaoLogin = $_SESSION['loginSitecmsADM']['sessaoLogin'];
$sessaoRoot = $_SESSION['loginSitecmsADM']['sessaoRoot'];
$sessaoPermissoes = $_SESSION['loginSitecmsADM']['sessaoPermissoes'];
$sessaoMenu = $_SESSION['loginSitecmsADM']['sessaoMenu'];
$sessaoHora = $_SESSION['loginSitecmsADM']['sessaoHora'];
$sessaoIp = $_SERVER['REMOTE_ADDR'];
$sessaoChave = "00c6040e5e3d3936d53886a2e9f1c551";
if ($_SESSION['loginSitecmsADM']['sessaoChave'] != md5($sessaoLogin . $sessaoHora . $sessaoIp . $sessaoChave)) {
	unset($_SESSION['loginSitecmsADM']);
	session_unset();
	session_destroy();
	setcookie('erroLogin', 'A SESSÃO EXPIROU.', time() + 10, '/cms-base/administracao/login/');
	header('Location: /cms-base/administracao/login');
	exit;
}
$sessaoHora = time();
$sessaoChave = md5($sessaoLogin . $sessaoHora . $sessaoIp . $sessaoChave);
$_SESSION['loginSitecmsADM'] = array('sessaoId' => $sessaoId, 'sessaoLogin' => $sessaoLogin, 'sessaoRoot' => $sessaoRoot, 'sessaoPermissoes' => $sessaoPermissoes, 'sessaoMenu' => $sessaoMenu, 'sessaoHora' => $sessaoHora, 'sessaoChave' => $sessaoChave);

// pra caso de debug
//echo "<pre>";
//print_r($_SESSION['loginSitecmsADM']);
//echo "<pre>";
//exit;  
?>