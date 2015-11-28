<?php
/* ###########################################################
ARQUIVO ALVO DO FORMULARIO DE CONFIGURACAO DO TITULO E DESCRICAO DO SITE
CRIACAO 	20/05/2012
ATUALIZADO 	20/05/2012
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

// validar titulo do site
if (empty($_POST['siteTitulo'])) {
	$erro['siteTitulo'] = "O campo <strong>T&Iacute;TULO DO SITE</strong> n&atilde;o foi preenchido.";
} else {
	if (alfanumerico($_POST['siteTitulo']) != FALSE) {
		$siteTitulo = $_POST['siteTitulo'];
	} else {
		$erro['siteTitulo'] = "O campo <strong>T&Iacute;TULO DO SITE</strong> deve conter apenas letras e ou numeros.";
	}
}

// validar o slogan do site
if (empty($_POST['siteSlogan'])) {
	$erro['siteSlogan'] = "O campo <strong>SLOGAN SITE</strong> n&atilde;o foi preenchido.";
} else {
	$siteSlogan = strip_tags($_POST['siteSlogan']);
}

// validar a descricao do site
if (empty($_POST['siteDescricao'])) {
	$erro['siteDescricao'] = "O campo <strong>DESCRI&Ccedil;&Atilde;O DO SITE</strong> n&atilde;o foi preenchido.";
} else {
	$siteDescricao = strip_tags($_POST['siteDescricao']);
}

// validar as palavras chave do site
if (empty($_POST['sitePalavraschave'])) {
	$erro['sitePalavraschave'] = "O campo <strong>PALAVRAS CHAVE</strong> n&atilde;o foi preenchido.";
} else {
	$sitePalavraschave = strip_tags($_POST['sitePalavraschave']);
}

// ###########################################################################################

// CHECAR SE TODA PERSSISTENCIA FOI VALIDA ###################################################

if (count($erro) != 0) {
	// retorna msgErro
	foreach ($erro as $idErro => $msgErro) {
		setcookie("msgErro['$idErro']", $msgErro, time() + 10, '/cms-base/instalacao/primeira-parte.php');
	}
	header('Location: /cms-base/instalacao/primeira-parte.php');
	exit;
}

// ###########################################################################################

// CRIACAO DOS ARQUIVOS CRSF #################################################################

// GERAR O ARUIVO cabacalho.php
$cabecalho = "<?php\n";
$cabecalho .= "$" . "siteTitulo = \"" . $siteTitulo . "\";\n";
$cabecalho .= "$" . "siteSlogan = \"" . $siteSlogan . "\";\n";
$cabecalho .= "$" . "siteDescricao = \"" . $siteDescricao . "\";\n";
$cabecalho .= "$" . "sitePalavraschave = \"" . $sitePalavraschave . "\";\n";
$arquivoCabecalho = fopen($_SERVER['DOCUMENT_ROOT'] . "/cms-base/include/geral/php/cabecalho.php","w+"); 
fwrite($arquivoCabecalho,$cabecalho);
fclose($arquivoCabecalho);

// GERAR O ARQUIVO robots.txt
$robots = "User-agent: *\n";
$robots .= "Disallow: /*?\n";
$robots .= "Disallow: /*.php$\n";
$robots .= "Disallow: /cms-base/administracao/\n";
$robots .= "Sitemap: http://" . $_SERVER['HTTP_HOST'] . "/cms-base/sitemap.xml";
$arquivoRobots = fopen($_SERVER['DOCUMENT_ROOT'] . "/robots.txt","w+"); 
fwrite($arquivoRobots,$robots);
fclose($arquivoRobots);

// GERAR O ARQUIVO sitemap.xml
$sitemap = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$sitemap .= "<urlset\n";
$sitemap .= "      xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\n";
$sitemap .= "      xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n";
$sitemap .= "      xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9\n";
$sitemap .= "            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
$sitemap .= "<url><loc>http://" . $_SERVER['HTTP_HOST'] . "/</loc><lastmod>" . strftime("%Y-%m-%d") . "</lastmod><changefreq>weekly</changefreq><priority>1.0</priority></url>\n";
$sitemap .= "<url><loc>http://" . $_SERVER['HTTP_HOST'] . "/contato</loc><priority>0.7</priority></url>\n";
$sitemap .= "<url><loc>http://" . $_SERVER['HTTP_HOST'] . "/sitemap</loc><lastmod>" . strftime("%Y-%m-%d") . "</lastmod><changefreq>weekly</changefreq><priority>0.7</priority></url>\n";
$sitemap .= "</urlset>";
$arquivoSitemap = fopen($_SERVER['DOCUMENT_ROOT'] . "/cms-base/sitemap.xml","w+"); 
fwrite($arquivoSitemap,$sitemap);
fclose($arquivoSitemap);

// GERAR O ARQUIVO feed.xml
$rss = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$rss .= "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
$rss .= "<channel>\n";
$rss .= "<title>" . $siteTitulo . "</title>\n";
$rss .= "<link>http://" . $_SERVER['HTTP_HOST'] . "</link>\n";
$rss .= "<description>" . $siteDescricao . "</description>\n";
$rss .= "<lastBuildDate>" . date(DATE_RFC2822) . "</lastBuildDate>\n";
$rss .= "<language>pt-br</language>\n";
$rss .= "<atom:link href=\"http://" . $_SERVER['HTTP_HOST'] . "/feed.xml\" rel=\"self\" type=\"application/rss+xml\" />\n";
$rss .= "</channel>\n</rss>\n";
$arquivoFeed = fopen($_SERVER['DOCUMENT_ROOT'] . "/cms-base/feed.xml","w+"); 
fwrite($arquivoFeed,$rss);
fclose($arquivoFeed);

// ###########################################################################################

// CHECAR A CRIACAO DOS ARQUIVOS CRSF ########################################################

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/cms-base/include/geral/php/cabecalho.php") == true and file_exists($_SERVER['DOCUMENT_ROOT'] . "/robots.txt") == true and file_exists($_SERVER['DOCUMENT_ROOT'] . "/cms-base/sitemap.xml") == true and file_exists($_SERVER['DOCUMENT_ROOT'] . "/cms-base/sitemap.xml") == true) {
	setcookie('instalacao', $siteTitulo, time() + 10, '/cms-base/instalacao/segunda-parte.php');
	header('Location: /cms-base/instalacao/segunda-parte.php');
	exit;	
} else {
	setcookie('msgErro[siteArquivosCRSF]', 'Por motivos não previstos, o T&Iacute;TULO DO SITE e as demais configura&ccedil;&otilde;es descritivas n&atilde;o foram salvas.', time() + 10, '/cms-base/instalacao/primeira-parte.php');
	header('Location: /cms-base/instalacao/primeira-parte.php');
	exit;
}

// ###########################################################################################
?>