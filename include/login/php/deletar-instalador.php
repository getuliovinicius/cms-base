<?php
/* ###########################################################
INCLUDE VERIFICA SE O SITE FOI INSTALADO
CRIACAO: 12/05/2012
########################################################### */

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/classes/mysql-conecta.php")) {
	if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/instalacao")) {
		/*unlink($_SERVER['DOCUMENT_ROOT'] . "/instalacao/css/estilo.css");
		unlink($_SERVER['DOCUMENT_ROOT'] . "/instalacao/index.php");
		unlink($_SERVER['DOCUMENT_ROOT'] . "/instalacao/primeira-parte.php");
		unlink($_SERVER['DOCUMENT_ROOT'] . "/instalacao/segunda-parte.php");
		unlink($_SERVER['DOCUMENT_ROOT'] . "/instalacao/terceira-parte.php");
		unlink($_SERVER['DOCUMENT_ROOT'] . "/instalacao/cfg-titulo-site.php");
		unlink($_SERVER['DOCUMENT_ROOT'] . "/instalacao/cfg-administrador.php");
		unlink($_SERVER['DOCUMENT_ROOT'] . "/instalacao/cfg-banco-de-dados.php");
		unlink($_SERVER['DOCUMENT_ROOT'] . "/instalacao/concluir.php");
		rmdir($_SERVER['DOCUMENT_ROOT'] . "/instalacao/css");
		rmdir($_SERVER['DOCUMENT_ROOT'] . "/instalacao");*/
	}
} else {
	header('Location: /instalacao');
	exit;
}
?>