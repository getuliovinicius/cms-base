<?php
/* ###########################################################
ARUIVO ALVO DO FORMULARIO DE LOGIN NO SISTEMA
RESPONSAVEL PELA VALIDACAO DOS DADOS ENVIADOS
CRIACAO:		12/05/2012
ATUALIZACAO:	29/05/2012
########################################################### */

// VERIFICA SE FOI PREENCHIDO UM FORMULARIO ##################################################

// retorna mensagem de erro
if (getenv("REQUEST_METHOD") != "POST") {
	setcookie('erroLogin', 'Autenticação necessária.', time() + 10, '/administracao/login/');
	header('Location: /administracao/login/');
	exit;
}

// ###########################################################################################

// PERSISTENCIA DE DADOS #####################################################################

$usrLogin = !empty($_POST['usrLogin']) ? trim($_POST['usrLogin']) : NULL;
$usrSenha = !empty($_POST['usrSenha']) ? trim($_POST['usrSenha']) : NULL;
$acao = $_POST['acao'];

// ###########################################################################################

// CHECAR SE TODA PERSSISTENCIA FOI VALIDA ###################################################

if (ctype_alpha($usrLogin) and ctype_alnum($usrSenha) and $acao == 'login-cms-base') {
	$usrSenha = md5($usrSenha);
} else {
	session_destroy();
	setcookie('erroLogin', 'Usu&aacute;rio ou senha incorreto(s).', time() + 10, '/administracao/login/');
	header('Location: /administracao/login/');
	exit;
}

// ###########################################################################################

// BUSCAR O USUARIO NA BASE DE DADOS #########################################################

require_once '../../classes/login-usuario.php';
$loginUsuario = new loginUsuario();
$loginUsuario->setUsrLogin($usrLogin);
$loginUsuario->setUsrSenha($usrSenha);
$usrDados = $loginUsuario->login();
unset($loginUsuario);

// ###########################################################################################

// CHECA A VALIDADE DO LOGIN E REGISTRA O ACESSO #############################################

if (empty($usrDados)) {
	setcookie('erroLogin', 'Usuário ou senha incorreto(s).', time() + 10, '/administracao/login/');
	header('Location: /administracao/login/');
	exit;
} else {
	$loginUsuario = new loginUsuario();
	$loginUsuario->registraAcesso($usrDados[0]);
	unset($loginUsuario);
}

// ###########################################################################################

// GERA LISTA DE PERMISSOES MENUS ############################################################ 

$loginUsuario = new loginUsuario();
$permissoes = $loginUsuario->listaPermissoes($usrDados[0]);
$sessaoPermissoes = array();
for ($p = 0; $p < count($permissoes); $p++) {
	$sessaoPermissoes[] = $permissoes[$p]['acaoId'];
}
$sessaoMenu = array();
for ($p = 0; $p < count($permissoes); $p++) {
	if ($permissoes[$p]['acaoIndex'] == "s") {
		$sessaoMenu[$permissoes[$p]['moduloId']]['moduloDescricao'] = $permissoes[$p]['acaoDescricao'];
		$sessaoMenu[$permissoes[$p]['moduloId']]['moduloPagina'] = $permissoes[$p]['acaoPagina'];
	} elseif ($permissoes[$p]['acaoIndex'] == "n" and $permissoes[$p]['acaoMenu'] == "s") {
		$sessaoMenu[$permissoes[$p]['moduloId']]['moduloAcoes'][$permissoes[$p]['acaoId']]['acaoDescricao'] = $permissoes[$p]['acaoDescricao'];
		$sessaoMenu[$permissoes[$p]['moduloId']]['moduloAcoes'][$permissoes[$p]['acaoId']]['acaoPagina'] = $permissoes[$p]['acaoPagina'];
	}
}

// ###########################################################################################

// CRIA UMA SESSAO PARA O USUARIO ############################################################

// variaveis da sessao
$sessaoId = $usrDados[0];
$sessaoLogin = $usrDados[1];
$sessaoRoot = $usrDados[2];
$sessaoHora = time();
$sessaoIp = $_SERVER['REMOTE_ADDR'];
$sessaoChave = "00c6040e5e3d3936d53886a2e9f1c551";
$sessaoChave = md5($sessaoLogin . $sessaoHora . $sessaoIp . $sessaoChave);
$_SESSION['loginSitecmsADM'] = array('sessaoId' => $sessaoId, 'sessaoLogin' => $sessaoLogin, 'sessaoRoot' => $sessaoRoot, 'sessaoPermissoes' => $sessaoPermissoes, 'sessaoMenu' => $sessaoMenu, 'sessaoHora' => $sessaoHora, 'sessaoChave' => $sessaoChave);

// ###########################################################################################

// REDIRECIONA PARA A PAGINA DA ADMINISTRACAO ################################################

header('Location: /administracao');
exit;

// ###########################################################################################
?>