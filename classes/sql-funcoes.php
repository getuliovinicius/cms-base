<?php
/* ###########################################################
CLASSE DE FUNCOES SQL
CRIACAO:		11/05/2012
ATUALIZACAO:	23/05/2012
FONTE: http://www.videolog.tv/pixelcomcafe
########################################################### */

require_once 'mysql-conecta.php';

class sqlFuncoes extends mysqlConecta {
	private $sql;
	private $conexao;
	
	// SELECT
	
	// METODO: lista registros apos uma consulta	
	public function listaRegistros($umRegistro=false) {
		$sql = $this->getSql();
		$conexao = $this->getConexao();
		$query = mysqli_query($conexao, $sql, MYSQLI_USE_RESULT) or die ("<strong>Erro ao executar query: </strong>" . $sql . "<br>" . mysqli_error($conexao));
		$resultado = array();
		if ($umRegistro) {
			$registro = mysqli_fetch_row($query);
			mysqli_free_result($query);
			$resultado = $registro;			
		} else {
			while ($registros = mysqli_fetch_assoc($query)) {
				$resultado[] = $registros;
			}
			mysqli_free_result($query);
		}
		return $resultado;
	}
	
	// METODO: conta a quantidade de registros segundo as condicoes
	public function contaRegistros($campo) {
		$sql = $this->getSql();
		$conexao = $this->getConexao();
		$query = mysqli_query($conexao, $sql, MYSQLI_USE_RESULT) or die ("<strong>Erro ao executar query: </strong>" . $sql . "<br>" . mysqli_error($conexao));
		$resultado = mysqli_result($query, 0, $campo);
		mysqli_free_result($query);
		return $resultado;
	}
	
	// INSERT

	// METODO: inclui um registo no banco de dados
	public function incluiRegisto($insertId=false) {
		$sql = $this->getSql();
		$conexao = $this->getConexao();
		$query = mysqli_query($conexao, $sql, MYSQLI_USE_RESULT) or die ("<strong>Erro ao executar query: </strong>" . $sql . "<br>" . mysqli_error($conexao));
		if ($insertId) {
			return mysqli_insert_id();
		}
	}
	
	// UPDATE
	
	// METODO: atualiza um registro no banco de dados
	public function atualizaRegistro() {
		$sql = $this->getSql();
		$conexao = $this->getConexao();
		$query = mysqli_query($conexao, $sql, MYSQLI_USE_RESULT) or die ("<strong>Erro ao executar query: </strong>" . $sql . "<br>" . mysqli_error($conexao));
	}
	
	// DELETE
	
	// METODO: exclui um registro no banco de dados
	public function excluiRegistro() {
		$sql = $this->getSql();
		$conexao = $this->getConexao();
		$query = mysqli_query($conexao, $sql, MYSQLI_USE_RESULT) or die ("<strong>Erro ao executar query: </strong>" . $sql . "<br>" . mysqli_error($conexao));
	}

	// CREATE
	
	// METODO: cria tabela no banco de dados
	public function criarTabela() {
		$sql = $this->getSql();
		$conexao = $this->getConexao();
		$query = mysqli_query($conexao, $sql, MYSQLI_USE_RESULT) or die ("<strong>Erro ao executar query: </strong>" . $sql . "<br>" . mysqli_error($conexao));
	}
	
	// ENCAPSULAMENTOS
	// set
	public function setSql($variavel) { $this->sql = $variavel; }
	// get
	public function getSql() { return $this->sql; }
}
?>