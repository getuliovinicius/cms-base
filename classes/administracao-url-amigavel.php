<?php
/* ###########################################################
CLASSE DE CARREGAMENTO DE PAGINAS POR URLs AMIGAVEIS
CRIACAO: 12/05/2012
FONTE: http://www.mxmasters.com.br/video-aulas/php/trabalhando-com-url-amigavel-com-php/
########################################################### */

class urlAmigavel {
	private $modulo;

	public function carregaModulo() {
		// lista as paginas existentes
		$modulosExistentes = array();
		if ($diretorio = opendir($_SERVER['DOCUMENT_ROOT'] . "/administracao/modulos/")) {
			while (false !== ($arquivo = readdir($diretorio))) {
				if (is_file("modulos/" . $arquivo) and preg_match("/php/i", $arquivo)) {
					$modulosExistentes[] = substr($arquivo, 0, -4);
				}
			}
			closedir($diretorio);
			clearstatcache();
		}		
		// checa a existencia da pagina solicitada
		$modulo = array();
		if (substr_count($this->getModulo(), "/") == 0) {		
			$modulo['pagina'] = in_array($this->getModulo(), $modulosExistentes) ? "modulos/" . $this->getModulo() . ".php" : "nao-encontrado.php";			
		} elseif (substr_count($this->getModulo(), "/") == 1) {
			$url = explode("/", $this->getModulo());
			$modulo['pagina'] = in_array($url[0], $modulosExistentes) ? "modulos/" . $url[0] . ".php" : "nao-encontrado.php";
			$modulo['paginaId'] = (ctype_digit($url[1])) ? $url[1] : "0";
		} else {
			$moduloPagina['pagina'] = "nao-encontrado.php";
		}
		// retorna a urlAmigavel
		return $modulo;		
	}

	// ENCAPSULAMENTOS
	// set
	public function setModulo($variavel) { $this->modulo = $variavel; }
	// get
	public function getModulo() { return $this->modulo; }
}
?>