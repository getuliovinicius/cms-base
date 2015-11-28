<?php
// DEFINICAO DO FUZO E DA DATA ###############################################################

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL,"pt_BR");
$dataCompleta = strftime("%A, %d de %B de %Y");

// ###########################################################################################

// CARREGA O ARQUIVO cabecalho.php ###########################################################

include '../include/geral/php/cabecalho.php';

// ###########################################################################################
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="author" content="<?php echo $siteAutor; ?>">
<!-- TemplateBeginEditable name="doctitle" -->
<title><?php echo $siteTitulo; ?>  | #####</title>
<!-- TemplateEndEditable -->
<meta name="robots" content="index,follow" />
<link rel="stylesheet" type="text/css" media="screen" href="/cms-base/css/estilo.css"/>
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
</head>

<body>
<div id="todaPagina">
	<!-- INICIO DO CABECALHO -->
	<header id="cabecalho">
		<div id="cabecalhoLogo">
			<h1><a href="/" title="Página inicial do site."><?php echo $siteTitulo; ?></a></h1>
		</div>
		<div id="cabecalhoLinks">
			<p>Deve receber banners ou links.</p>
		</div>
	</header>
	<!-- FIM DO CABECALHO -->
	<!-- INICIO DO CONTEUDO -->
	<section id="conteudo">
		<section id="conteudoAplicacao">
			<!-- TemplateBeginEditable name="conteudoAplicacao" -->
			<h1>Aqui vai o conteúdo em Destaque na página</h1>
<?php
// mensagens de confirmacao
if (isset($_COOKIE['msgOk'])) {
	echo "<p class=\"msgOk\">" . $_COOKIE['msgOk'] . "</p>";
}
if (isset($_COOKIE['msgErro'])) {
	echo "<p class=\"msgErro\">";
	echo "-- ERROS --<br>";
	foreach ($_COOKIE['msgErro'] as $cok => $val) {
		echo $val . "<br>";
	}
	echo "<p>";
}
?>
			<!-- TemplateEndEditable -->
		</section>
		<aside id="conteudoLateral">
			<!-- TemplateBeginEditable name="conteudoNavegacao" -->
			<h2>Barra Lateral</h2>
			<!-- TemplateEndEditable -->
		</aside>
	</section>
	<!-- FIM DO CONTEUDO -->
	<!-- INICIO DO RODAPE -->
	<footer id="rodape">
		<?php include '../include/site/html/site-rodape.html'; ?>
	</footer>
	<!-- FIM DO RODAPE -->
</div>
</body>
</html>
