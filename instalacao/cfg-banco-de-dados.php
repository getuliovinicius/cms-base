<?php
/* ###########################################################
ARQUIVO ALVO DO FORMULARIO DE CONFIGURACAO DO BANCO DE DADOS DO SITE
CRIACAO 	20/05/2012
ATUALIZADO 	22/05/2012
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

// validar o servidor
if (empty($_POST['servidor'])) {
	$erro['servidor'] = "O campo <strong>SERVIDOR</strong> n&atilde;o foi preenchido.";
} else {
	if (alfanumerico($_POST['servidor']) != FALSE) {
		$servidor = $_POST['servidor'];
	} else {
		$erro['servidor'] = "O campo <strong>SERVIDOR</strong> deve conter apenas letras e ou numeros.";
	}
}

// validar o banco de dados
if (empty($_POST['banco'])) {
	$erro['banco'] = "O campo <strong>BANCO DE DADOS</strong> n&atilde;o foi preenchido.";
} else {
	if (alfanumerico($_POST['banco']) != FALSE) {
		$banco = $_POST['banco'];
	} else {
		$erro['banco'] = "O campo <strong>BANCO DE DADOS</strong> deve conter apenas letras e ou numeros.";
	}
}

// validar o usuario do banco de dados
if (empty($_POST['usuario'])) {
	$erro['usuario'] = "O campo <strong>USU&Aacute;RIO</strong> n&atilde;o foi preenchido.";
} else {
	if (alfanumerico($_POST['usuario']) != FALSE) {
		$usuario = $_POST['usuario'];
	} else {
		$erro['usuario'] = "O campo <strong>USU&Aacute;RIO</strong> deve conter apenas letras e ou numeros.";
	}
}

// validar senha de acesso do usuario ao banco de dados
if (empty($_POST['senha'])) {
	$erro['senha'] = "O campo <strong>SENHA</strong> n&atilde;o foi preenchido.";
} else {
	if (alfanumerico($_POST['senha']) != FALSE) {
		$senha = trim($_POST['senha']);
	} else {
		$erro['senha'] = "O campo <strong>SENHA</strong> deve conter apenas letras e ou numeros.";
	}
}

// ###########################################################################################

// CHECAR SE TODA PERSSISTENCIA FOI VALIDA ###################################################

if (count($erro) != 0)  {
	// retorna msgErro
	foreach ($erro as $idErro => $msgErro) {
		setcookie("msgErro['$idErro']", $msgErro, time() + 10, '/cms-base/instalacao/segunda-parte.php');
	}
	setcookie('instalacao', $siteTitulo, time() + 10, '/cms-base/instalacao/segunda-parte.php');
	header('Location: /cms-base/instalacao/segunda-parte.php');
	exit;
} else {
	// testa a conexao com o servidor do banco de dados
	$testeConexao = mysql_connect($servidor, $usuario, $senha);
	if (!$testeConexao) {
		$erro['banco'] = "Não foi poss&iacute;vel conectar ao servidor do Banco de Dados: " . mysql_error();
		setcookie('msgErro[banco]', $erro['banco'], time() + 10, '/cms-base/instalacao/segunda-parte.php');
		setcookie('instalacao', $siteTitulo, time() + 10, '/cms-base/instalacao/segunda-parte.php');
		header('Location: /cms-base/instalacao/segunda-parte.php');
		exit;
	}
	// testa a selecao da base de dados informada
	$testeBase = mysql_select_db($banco);
	if (!$testeBase) {
		$erro['banco'] = "Não foi poss&iacute;vel conectar ao Banco de Dados informado: " . mysql_error();
		setcookie('msgErro[banco]', $erro['banco'], time() + 10, '/cms-base/instalacao/segunda-parte.php');
		setcookie('instalacao', $siteTitulo, time() + 10, '/cms-base/instalacao/segunda-parte.php');
		header('Location: /cms-base/instalacao/segunda-parte.php');
		exit;
	}
}
mysql_close($testeConexao);

// ###########################################################################################

// GERAR O ARUIVO mysql-conecta.php ##########################################################

$mysqlConecta = "<?php\n";
$mysqlConecta .= "/* ###########################################################\n";
$mysqlConecta .= "CLASSE DE CONEXAO COM O MYSQL\n";
$mysqlConecta .= "CRIACAO: 11/05/2012\n";
$mysqlConecta .= "FONTE: http://www.videolog.tv/pixelcomcafe\n";
$mysqlConecta .= "########################################################### */\n";
$mysqlConecta .= "\n";
$mysqlConecta .= "abstract class mysqlConecta {\n";
$mysqlConecta .= "	private $" . "mysqlHost, $" . "mysqlUsuario, $" . "mysqlSenha, $" . "mysqlBanco, $" . "conexao, $" . "erro;\n";
$mysqlConecta .= "\n";
$mysqlConecta .= "	public function __construct() {\n";
$mysqlConecta .= "		$" . "this->setHost(\"" . $servidor . "\");\n";
$mysqlConecta .= "		$" . "this->setUsuario(\"" . $usuario . "\");\n";
$mysqlConecta .= "		$" . "this->setSenha(\"" . $senha . "\");\n";
$mysqlConecta .= "		$" . "this->setBanco(\"" . $banco . "\");\n";
$mysqlConecta .= "		if (!$" . "this->conecta()) {\n";
$mysqlConecta .= "			die(\"<strong>Erro durante a conexão com a base de dados:</strong> \" . $" . "this->getErro());\n";
$mysqlConecta .= "		}\n";
$mysqlConecta .= "	}\n";
$mysqlConecta .= "\n";
$mysqlConecta .= "	public function __destruct() {\n";
$mysqlConecta .= "		$" . "this->desconecta();\n";
$mysqlConecta .= "	}\n";
$mysqlConecta .= "\n";
$mysqlConecta .= "	// conecta o banco de dados\n";
$mysqlConecta .= "	public function conecta() {\n";
$mysqlConecta .= "		try {\n";
$mysqlConecta .= "			$" . "conexao = mysql_connect($" . "this->getHost(), $" . "this->getUsuario(), $" . "this->getSenha());\n";
$mysqlConecta .= "			mysql_query(\"SET NAMES 'utf8'\", $" . "conexao);\n";
$mysqlConecta .= "			$" . "bancoDeDados = mysql_select_db($" . "this->getBanco(),$" . "conexao);\n";
$mysqlConecta .= "			$" . "this->setConexao($" . "conexao);\n";
$mysqlConecta .= "			return true;\n";
$mysqlConecta .= "		} catch (Exception $" . "erro) {\n";
$mysqlConecta .= "			$" . "this->setErro($" . "erro->getMessage());\n";
$mysqlConecta .= "			return false;\n";
$mysqlConecta .= "		}\n";
$mysqlConecta .= "	}\n";
$mysqlConecta .= "\n";
$mysqlConecta .= "	// desconecta o banco de dados\n";
$mysqlConecta .= "	public function desconecta() {\n";
$mysqlConecta .= "		mysql_close($" . "this->getConexao());\n";
$mysqlConecta .= "	}\n";
$mysqlConecta .= "\n";
$mysqlConecta .= "	// ENCAPSULAMENTOS\n";
$mysqlConecta .= "	// set\n";
$mysqlConecta .= "	private function setHost($" . "variavel) { $" . "this->mysqlHost = $" . "variavel; }\n";
$mysqlConecta .= "	private function setUsuario($" . "variavel) { $" . "this->mysqlUsuario = $" . "variavel; }\n";
$mysqlConecta .= "	private function setSenha($" . "variavel) { $" . "this->mysqlSenha = $" . "variavel; }\n";
$mysqlConecta .= "	private function setBanco($" . "variavel) { $" . "this->mysqlBanco = $" . "variavel; }\n";
$mysqlConecta .= "	private function setConexao($" . "variavel) { $" . "this->conexao = $" . "variavel; }\n";
$mysqlConecta .= "	private function setErro($" . "variavel) { $" . "this->erro = $" . "variavel; }\n";
$mysqlConecta .= "	// get\n";
$mysqlConecta .= "	private function getHost() { return $" . "this->mysqlHost; }\n";
$mysqlConecta .= "	private function getUsuario() { return $" . "this->mysqlUsuario; }\n";
$mysqlConecta .= "	private function getSenha() { return $" . "this->mysqlSenha; }\n";
$mysqlConecta .= "	private function getBanco() { return $" . "this->mysqlBanco; }\n";
$mysqlConecta .= "	private function getConexao() { return $" . "this->conexao; }\n";
$mysqlConecta .= "	private function getErro() { return $" . "this->erro; }\n";
$mysqlConecta .= "}\n";
$mysqlConecta .= "?>";
$arquivoConecta = fopen($_SERVER['DOCUMENT_ROOT'] . "/cms-base/classes/mysql-conecta.php","w+"); 
fwrite($arquivoConecta,$mysqlConecta);
fclose($arquivoConecta);

// ###########################################################################################

// CHECAR A CRIACAO DO ARQUIVO mysql-conecta.php #############################################

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/cms-base/classes/mysql-conecta.php") == true) {
	setcookie('msgErro[siteArquivoconecta]', 'Por motivos não previstos, a CONEX&Atilde;O com o banco de dados não foi salva.', time() + 10, '/cms-base/instalacao/');
	header('Location: /cms-base/instalacao/');
	exit;
}

// ###########################################################################################

// CRIAR AS TABELAS DO BANCO DE DADOS ########################################################

$sqlTabelas = array();

// usuarios
$sqlTabelas['usuarios'] = "
CREATE TABLE usuarios (
	usrId mediumint(9) NOT NULL AUTO_INCREMENT,
	usrDatacricao timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	usrEmail varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	usrNome varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	usrLogin char(10) COLLATE utf8_unicode_ci NOT NULL,
	usrApelido varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	usrApelidourl varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	usrFoto varchar(100) COLLATE utf8_unicode_ci NOT NULL,
	usrDescricao text COLLATE utf8_unicode_ci NOT NULL,
	usrMetadescricao text COLLATE utf8_unicode_ci NOT NULL,
	usrPalavraschave text COLLATE utf8_unicode_ci NOT NULL,
	usrSenha varchar(32) COLLATE utf8_unicode_ci NOT NULL,
	usrAtivo char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 's',
	usrRoot char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
	PRIMARY KEY (usrId),
	UNIQUE KEY usrEmail_UNIQUE (usrEmail),
	UNIQUE KEY usrLogin_UNIQUE (usrLogin),
	UNIQUE KEY usrApelidourl_UNIQUE (usrApelidourl),
	KEY usrApelido (usrApelido)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;
";

// acessos
$sqlTabelas['acessos'] = "
CREATE TABLE acessos (
	acessoId mediumint(9) NOT NULL AUTO_INCREMENT,
	acessoData timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	acessoIp char(15) COLLATE utf8_unicode_ci NOT NULL,
	usrId mediumint(9) NOT NULL,
	PRIMARY KEY (acessoId),
	KEY usrId (usrId)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;
";

// modulos
$sqlTabelas['modulos'] = "
CREATE TABLE modulos (
	moduloId mediumint(9) NOT NULL AUTO_INCREMENT,
	moduloDescricao varchar(100) COLLATE utf8_unicode_ci NOT NULL,
	PRIMARY KEY (moduloId)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;
";

// modulos dados
$sqlTabelas['modulosDados'] = "
INSERT INTO modulos
	(moduloId, moduloDescricao)
VALUES
	(1, 'Painel'),
	(2, 'Usuários'),
	(3, 'Configurações');
";

// modulos_acao
$sqlTabelas['modulos_acao'] = "
CREATE TABLE modulos_acao (
	acaoId mediumint(9) NOT NULL AUTO_INCREMENT,
	moduloId mediumint(9) NOT NULL,
	acaoDescricao varchar(100) COLLATE utf8_unicode_ci NOT NULL,
	acaoPagina varchar(100) COLLATE utf8_unicode_ci NOT NULL,
	acaoIndex char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
	acaoMenu char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 's',
	acaoRestrita char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 's',
	usrRoot char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
	PRIMARY KEY (acaoId),
	UNIQUE KEY acaoPagina (acaoPagina),
	KEY moduloId (moduloId)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;
";

// modulos_acaoDados
$sqlTabelas['modulos_acaoDados'] = "
INSERT INTO modulos_acao
	(moduloId, acaoDescricao, acaoPagina, acaoIndex, acaoMenu, acaoRestrita, usrRoot)
VALUES
	(1, 'Painel', 'painel', 's', 's', 'n', 'n'),
	(2, 'Usuários',	'usuarios', 's', 's', 'n', 'n'),
	(2, 'Alterar sua senha', 'usuario-alterar-senha', 'n', 's', 'n', 'n'),
	(2, 'Editar seus dados', 'usuario-editar', 'n', 's', 'n', 'n'),
	(2, 'Editar permissões', 'usuario-permissao', 'n', 'n', 's', 's'),
	(2, 'Novo usuário', 'usuario-novo', 'n', 's', 's', 's'),
	(3, 'Configurações', 'configuracoes', 's', 's', 's', 's');
";

// modulos_permissao
$sqlTabelas['modulos_permissao'] = "
CREATE TABLE modulos_permissao (
	permissaoId mediumint(9) NOT NULL AUTO_INCREMENT,
	acaoId mediumint(9) NOT NULL,
	moduloId mediumint(9) NOT NULL,
	usrId mediumint(9) NOT NULL,
	PRIMARY KEY (permissaoId)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;
";

require_once '../classes/sql-funcoes.php';
foreach ($sqlTabelas as $tabela => $sql) {
	$sqlFuncoes = new sqlFuncoes();
	$sqlFuncoes->setSql($sql);
	$sqlFuncoes->criarTabela();
	unset($sqlFuncoes);
}

// ###########################################################################################

// REDIRECIONA PARA A TERCEIRA PARTE DA INSTALACAO ###########################################

setcookie('instalacao', $siteTitulo, time() + 10, '/cms-base/instalacao/terceira-parte.php');
header('Location: /cms-base/instalacao/terceira-parte.php');
exit;	

// ###########################################################################################
?>