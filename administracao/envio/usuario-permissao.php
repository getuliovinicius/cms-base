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

if (!in_array(5, $sessaoPermissoes)) {
	// retorna mensagem de erro
	setcookie('msgErro[privilegio]', 'Acesso restrito a usuários com permissão.', time() + 10, '/administracao/usuarios');
	header('Location: /administracao/usuarios');
	exit;
}

// ###########################################################################################

// VERIFICA SE FOI PREENCHIDO UM FORMULARIO ##################################################

if (getenv("REQUEST_METHOD") != "POST" or !$_POST['permissao']) {
	// retorna mensagem de erro
	header('Location: /administracao/nao-encontrado');
	exit;
}

// ###########################################################################################

// VERIFICA A EXISTENCIA DO USUARIO ##########################################################

$usrId = (ctype_digit($_POST['usrId'])) ? $_POST['usrId'] : 0;
$sqlUsuario = "
SELECT usrLogin
FROM usuarios
WHERE usrId = " . $usrId . "
AND	usrRoot = 'n';
";
require_once '../../classes/sql-funcoes.php';
$sqlFuncoes = new sqlFuncoes();
$sqlFuncoes->setSql($sqlUsuario);
$usrDados = $sqlFuncoes->listaRegistros(true);
if (empty($usrDados)) {
	setcookie('msgErro[usrId]', 'Registro do usuário não encontrado.', time() + 10, '/administracao/usuarios');
	header('Location: /administracao/usuarios');
	exit;
}
unset($sqlFuncoes);

// ###########################################################################################

// SETA AS PERMISSOES DO USUARIO #############################################################

// gera lista de permissoes atuais
$sql = "
SELECT acaoId
FROM modulos_permissao
WHERE usrId =" . $usrId . "
ORDER BY moduloId, acaoId;
";
$sqlFuncoes = new sqlFuncoes();
$sqlFuncoes->setSql($sql);
$permissoes = $sqlFuncoes->listaRegistros();
unset($sqlFuncoes);
$permissoesAtuais = array();
for ($p = 0; $p < count($permissoes); $p++) {
	$permissoesAtuais[] = $permissoes[$p]['acaoId'];
}

// gera lista de todas as permissoes possiveis para o usuario
$sql = "
SELECT acaoId, moduloId, acaoPagina
FROM modulos_acao
WHERE usrRoot = 'n'
AND acaoRestrita = 's'
ORDER BY moduloId, acaoId ASC;
";
$sqlFuncoes = new sqlFuncoes();
$sqlFuncoes->setSql($sql);
$permissoesPossiveis = $sqlFuncoes->listaRegistros();
unset($sqlFuncoes);

// ###########################################################################################

// ALATERA AS PERMISSOES NO BANCO DE DADOS ###################################################

foreach ($permissoesPossiveis as $chave => $permissao) {
	if (in_array($permissao['acaoId'], $permissoesAtuais) and !array_key_exists($permissao['acaoPagina'], $_POST)) {
		$sql = "
		DELETE
		FROM modulos_permissao
		WHERE acaoId = " . $permissao['acaoId'] . "
		AND usrId = " . $usrId . "
		LIMIT 1;
		";
		$sqlFuncoes = new sqlFuncoes();
		$sqlFuncoes->setSql($sql);
		$sqlFuncoes->excluiRegistro();
		unset($sqlFuncoes);
	} elseif (!in_array($permissao['acaoId'], $permissoesAtuais) and array_key_exists($permissao['acaoPagina'], $_POST)) {
		$sql = "
		INSERT INTO modulos_permissao
			(acaoId, moduloId, usrId)
		VALUES
			(" . $permissao['acaoId'] . ", "  . $permissao['moduloId'] . ", " . $usrId . ");
		";
		$sqlFuncoes = new sqlFuncoes();
		$sqlFuncoes->setSql($sql);
		$sqlFuncoes->incluiRegisto();
		unset($sqlFuncoes);
	}
}

// ###########################################################################################

// REDIRECIONA PARA A PAGINA DE PERMISSOES DO USUARIO ########################################

setcookie('msgOk', 'Permissões alteradas com sucessos.', time() + 10, '/administracao/usuario-permissao/');
header("Location: /administracao/usuario-permissao/" . $usrId);
exit;

// ###########################################################################################

?>