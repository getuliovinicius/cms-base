<?php
/* ###########################################################
CLASSE DE CONEXAO COM O MYSQL
CRIACAO: 11/05/2012
FONTE: http://www.videolog.tv/pixelcomcafe
########################################################### */

abstract class mysqlConecta {
	private $mysqlHost, $mysqlUsuario, $mysqlSenha, $mysqlBanco, $conexao, $erro;

	public function __construct() {
		$this->setHost("localhost");
		$this->setUsuario("cmsbase");
		$this->setSenha("5BT2DWLpLzWpezt3");
		$this->setBanco("cmsbase");
		if (!$this->conecta()) {
			die("<strong>Erro durante a conexão com a base de dados:</strong> " . $this->getErro());
		}
	}

	public function __destruct() {
		$this->desconecta();
	}

	// conecta o banco de dados
	public function conecta() {
		try {
			$conexao = mysql_connect($this->getHost(), $this->getUsuario(), $this->getSenha());
			mysql_query("SET NAMES 'utf8'", $conexao);
			$bancoDeDados = mysql_select_db($this->getBanco(),$conexao);
			$this->setConexao($conexao);
			return true;
		} catch (Exception $erro) {
			$this->setErro($erro->getMessage());
			return false;
		}
	}

	// desconecta o banco de dados
	public function desconecta() {
		mysql_close($this->getConexao());
	}

	// ENCAPSULAMENTOS
	// set
	private function setHost($variavel) { $this->mysqlHost = $variavel; }
	private function setUsuario($variavel) { $this->mysqlUsuario = $variavel; }
	private function setSenha($variavel) { $this->mysqlSenha = $variavel; }
	private function setBanco($variavel) { $this->mysqlBanco = $variavel; }
	private function setConexao($variavel) { $this->conexao = $variavel; }
	private function setErro($variavel) { $this->erro = $variavel; }
	// get
	private function getHost() { return $this->mysqlHost; }
	private function getUsuario() { return $this->mysqlUsuario; }
	private function getSenha() { return $this->mysqlSenha; }
	private function getBanco() { return $this->mysqlBanco; }
	private function getConexao() { return $this->conexao; }
	private function getErro() { return $this->erro; }
}
?>