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

if (getenv("REQUEST_METHOD") != "POST" or !$_POST['alterar-senha']) {
	// retorna erro
	header('Location: /cms-base/administracao/nao-encontrado');
	exit;
}

// ###########################################################################################

// TESTA A ID DO USUARIO #####################################################################

if (empty($_POST['usrId']) or !ctype_digit($_POST['usrId'])) {
	// retorna erro
	header('Location: /cms-base/administracao/nao-encontrado');
	exit;
} else {
	$usrId = $_POST['usrId'];
}

// ###########################################################################################

// VERIFICA A PERMISSAO DE ACESSO ############################################################

if ($sessaoId != $usrId) {
	// retorna mensagem de erro
	setcookie('msgErro[privilegio]', 'Apenas o usu&aacute;rio da sess&atilde;o atual pode ter sua senha alterada no momento.', time() + 10, '/cms-base/administracao/usuarios');
	header('Location: /cms-base/administracao/usuarios');
	exit;
}

// ###########################################################################################

// PERSISTENCIA DE DADOS

// array para receber os erros
$erro = array();

// validar a senha atual
if (empty($_POST['usrSenhaatual'])) {
	$erro['usrSenhaatual'] = "<strong>SENHA ATUAL:</strong> O campo n&atilde;o foi preenchido.";
} elseif (!ctype_alnum($_POST['usrSenhaatual'])) {
	$erro['usrSenhaatual'] = "<strong>SENHA ATUAL:</strong> Preencha apenas com letras e (ou) n&uacute;meros.";
} else {
	$usrSenhaatual = md5($_POST['usrSenhaatual']);
	require_once '../../classes/sql-funcoes.php';
	$sqlUsuario = "
	SELECT COUNT(*) AS total
	FROM usuarios
	WHERE usrId = " . $usrId . "
	AND usrSenha = '" . $usrSenhaatual . "';
	";
	$sqlFuncoes = new sqlFuncoes();
	$sqlFuncoes->setSql($sqlUsuario);
	if ($sqlFuncoes->contaRegistros("total") != 1) {
		$erro['usrSenhaatual'] = "<strong>SENHA ATUAL:</strong> N&atilde;o confere com a senha do usuário da sess&atilde;o atual.";
	}
	unset($sqlFuncoes);
}

// validar a senha
if (empty($_POST['usrSenha1']) or ($_POST['usrSenha1'] != $_POST['usrSenha2'])) {
	$erro['usrSenha'] = "<strong>SENHA:</strong> Entre com a mesma sequ&ecirc;ncia de caracteres nos campos  senha e confirme a senha. Ambos devem ser preenchidos.";
} elseif (!ctype_alnum($_POST['usrSenha1'])) {
	$erro['usrSenha'] = "<strong>SENHA:</strong> Preencha apenas com letras e (ou) n&uacute;meros.";
} else {
	$usrSenha = md5($_POST['usrSenha1']);
}

// ###########################################################################################

// CHECAR SE TODA PERSSISTENCIA FOI VALIDA ###################################################

if (count($erro) != 0) {
	// retorna msgErro
	foreach ($erro as $idErro => $msgErro) {
		setcookie("msgErro['$idErro']", $msgErro, time() + 10, '/cms-base/administracao/usuario-alterar-senha');
	}
	header('Location: /cms-base/administracao/usuario-alterar-senha');
	exit;
}	

// ###########################################################################################

// EDITAR USUARIO NA BASE DE DADOS ###########################################################

$sqlUsuario = "
UPDATE usuarios
SET usrSenha = '$usrSenha'
WHERE usrId = $usrId
AND	usrSenha = '$usrSenhaatual'
LIMIT 1;
";
$sqlFuncoes = new sqlFuncoes();
$sqlFuncoes->setSql($sqlUsuario);
$sqlFuncoes->atualizaRegistro();
unset($sqlFuncoes);

// ###########################################################################################

// RETORNA PARA A PAGINA DE EDICAO DO USUARIO ################################################

setcookie('msgOk', 'Altera&ccedil;&otilde;es na senha do usu&aacute;rio <strong>' . $sessaoUsuario . '</strong> realizada com sucesso.', time() + 10, '/cms-base/administracao/usuario-alterar-senha');
header('Location: /cms-base/administracao/usuario-alterar-senha');
exit;

// ###########################################################################################
?>