<?php
/* ###########################################################
INCLUDE VERIFICA SE O SITE FOI INSTALADO
CRIACAO: 12/05/2012
########################################################### */

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/cms-base/classes/mysql-conecta.php")) {
	if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/cms-base/instalacao")) {
		/*unlink($_SERVER['DOCUMENT_ROOT'] . "/cms-base/instalacao/css/estilo.css");
		unlink($_SERVER['DOCUMENT_ROOT'] . "/cms-base/instalacao/index.php");
		unlink($_SERVER['DOCUMENT_ROOT'] . "/cms-base/instalacao/primeira-parte.php");
		unlink($_SERVER['DOCUMENT_ROOT'] . "/cms-base/instalacao/segunda-parte.php");
		unlink($_SERVER['DOCUMENT_ROOT'] . "/cms-base/instalacao/terceira-parte.php");
		unlink($_SERVER['DOCUMENT_ROOT'] . "/cms-base/instalacao/cfg-titulo-site.php");
		unlink($_SERVER['DOCUMENT_ROOT'] . "/cms-base/instalacao/cfg-administrador.php");
		unlink($_SERVER['DOCUMENT_ROOT'] . "/cms-base/instalacao/cfg-banco-de-dados.php");
		unlink($_SERVER['DOCUMENT_ROOT'] . "/cms-base/instalacao/concluir.php");
		rmdir($_SERVER['DOCUMENT_ROOT'] . "/cms-base/instalacao/css");
		rmdir($_SERVER['DOCUMENT_ROOT'] . "/cms-base/instalacao");*/
	}
} else {
	header('Location: /cms-base/instalacao');
	exit;
}
?>