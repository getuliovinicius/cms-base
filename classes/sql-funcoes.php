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
	
	// SELECT
	
	// METODO: lista registros apos uma consulta	
	public function listaRegistros($umRegistro=false) {
		$sql = $this->getSql();
		$query = mysql_query($sql) or die ("<strong>Erro ao executar query: </strong>" . $sql . "<br>" . mysql_error());
		$resultado = array();
		if ($umRegistro) {
			$registro = mysql_fetch_row($query);
			mysql_free_result($query);
			$resultado = $registro;			
		} else {
			while ($registros = mysql_fetch_assoc($query)) {
				$resultado[] = $registros;
			}
			mysql_free_result($query);
		}
		return $resultado;
	}
	
	// METODO: conta a quantidade de registros segundo as condicoes
	public function contaRegistros($campo) {
		$sql = $this->getSql();
		$query = mysql_query($sql) or die ("<strong>Erro ao executar query: </strong>" . $sql . "<br>" . mysql_error());
		$resultado = mysql_result($query, 0, $campo);
		mysql_free_result($query);
		return $resultado;
	}
	
	// INSERT

	// METODO: inclui um registo no banco de dados
	public function incluiRegisto($insertId=false) {
		$sql = $this->getSql();
		$query = mysql_query($sql) or die ("<strong>Erro ao executar query: </strong>" . $sql . "<br>" . mysql_error());
		if ($insertId) {
			return mysql_insert_id();
		}
	}
	
	// UPDATE
	
	// METODO: atualiza um registro no banco de dados
	public function atualizaRegistro() {
		$sql = $this->getSql();
		$query = mysql_query($sql) or die ("<strong>Erro ao executar query: </strong>" . $sql . "<br>" . mysql_error());
	}
	
	// DELETE
	
	// METODO: exclui um registro no banco de dados
	public function excluiRegistro() {
		$sql = $this->getSql();
		$query = mysql_query($sql) or die ("<strong>Erro ao executar query: </strong>" . $sql . "<br>" . mysql_error());
	}

	// CREATE
	
	// METODO: cria tabela no banco de dados
	public function criarTabela() {
		$sql = $this->getSql();
		$query = mysql_query($sql) or die ("<strong>Erro ao executar query: </strong>" . $sql . "<br>" . mysql_error());
	}
	
	// ENCAPSULAMENTOS
	// set
	public function setSql($variavel) { $this->sql = $variavel; }
	// get
	public function getSql() { return $this->sql; }
}
?>