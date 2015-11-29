<?php
/* ###########################################################
ARQUIVO ALVO DO LINK SAIR NA AREA ADMINISTRATIVA
RESPONSAVEL POR DESTRUIR A SESSAO "loginSitecmsADM"
CRIACAO: 12/05/2012
########################################################### */

require_once '../../classes/login-usuario.php';
$loginUsuario = new loginUsuario();
$loginUsuario->logoff();
header('Location: /administracao/login/');
?>