<?php
/* ###########################################################
CLASSE DE AUTENTICACAO NO SISTEMA
CRIACAO:		11/05/2012
ATUALIZACAO:	29/05/2012
FONTE: http://www.videolog.tv/pixelcomcafe
########################################################### */

require_once 'sql-funcoes.php';

class loginUsuario {
	private $usrLogin, $usrSenha;
	
	public function __construct() {
		if (!isset($_SESSION)) {
			session_start();
		}
	}
	
	// METODO: login no sitema
	public function login() {
		// autentica o usuario
		$sql = "
		SELECT usrId, usrLogin, usrRoot
		FROM usuarios
		WHERE usrLogin = '" . $this->getUsrLogin() . "' AND usrSenha = '" . $this->getUsrSenha() . "' AND usrAtivo = 's';
		";
		$sqlFuncoes = new sqlFuncoes();
		$sqlFuncoes->setSql($sql);
		$usrDados = $sqlFuncoes->listaRegistros(true);
		return $usrDados;		
	}
	
	// METODO: registra o acesso do usuario
	public function registraAcesso($usrId) {
		unset($sqlFuncoes);
		$sql = "
		INSERT INTO acessos (acessoIp,usrId)
		VALUES ('" . $_SERVER['REMOTE_ADDR'] . "','" . $usrId . "');
		";
		$sqlFuncoes = new sqlFuncoes();
		$sqlFuncoes->setSql($sql);
		$sqlFuncoes->incluiRegisto();
	}
	
	// METODO: gera array com permissoes
	public function listaPermissoes($usrId) {
		$sql = "
		SELECT ma.acaoId, ma.moduloId, ma.acaoDescricao, ma.acaoPagina,	ma.acaoIndex, ma.acaoMenu
		FROM modulos_permissao AS mp
		INNER JOIN modulos_acao AS ma ON mp.acaoId = ma.acaoId
		AND mp.usrId =" . $usrId . "
		ORDER BY ma.moduloId, ma.acaoId;
		";
		$sqlFuncoes = new sqlFuncoes();
		$sqlFuncoes->setSql($sql);
		return $sqlFuncoes->listaRegistros();
	}
	
	// METODO: verifica a existencia de um login ativo
	public static function verificaLogin() {
		if (isset($_SESSION) and isset($_SESSION['loginSitecmsADM']) and !empty($_SESSION['loginSitecmsADM'])) {
			return true;
		} else {
			return false;
		}
	}
	
	// METODO: logof do sistema
	public function logoff() {
		unset($_SESSION['loginSitecmsADM']);
		session_unset();
		session_destroy();
	}
	
	// ENCAPSULAMENTOS
	// set
	public function setUsrLogin($variavel) { $this->usrLogin = $variavel; }
	public function setUsrSenha($variavel) { $this->usrSenha = $variavel; }
	// get
	public function getUsrLogin() { return $this->usrLogin; }
	public function getUsrSenha() { return $this->usrSenha; }
}
?>