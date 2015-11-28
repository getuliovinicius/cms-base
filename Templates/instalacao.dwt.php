<?php
// DEFINICAO DO FUZO E DA DATA ###############################################################

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL,"pt_BR");
$dataCompleta = strftime("%A, %d de %B de %Y");

// ###########################################################################################
?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="author" content="Getulio Vinicius">
<!-- TemplateBeginEditable name="doctitle" -->
<title>CMS-Base! Um gerenciador de conteúdo fácil.</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
<meta name="robots" content="noindex,nofollow" />
<link href="/cms-base/instalacao/css/estilo.css" rel="stylesheet" type="text/css" media="screen">
</head>
<body>
<div id="todaPagina">
	<!-- INICIO DO CABECALHO -->
	<header id="cabecalho">
		<!-- TemplateBeginEditable name="cabecalho" -->
			<hgroup>
				<h1>CMS-Base</h1>
				<h2>Um gerenciador de conteúdo fácil.</h2>
			</hgroup>
		<!-- TemplateEndEditable -->
	</header>
	<!-- FIM DO CABECALHO -->
	<!-- INICIO DO FORMULARIO -->
	<section id="conteudo">
		<!-- TemplateBeginEditable name="formulario" -->
		<h2>Área do conteúdo que deve ser nodificada</h2>
<?php
// retorno dos erros na instalacao
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
	<!-- FIM DO FORMULARIO -->
	<!-- INICIO DO RODAPE -->
	<footer id="rodape">
		<p><strong>CMS-Base 1.0</strong> desenvolvido por <a href="http://twitter.com/getuliovinits" title="Perfil no twitter" target="_blank">Getulio Vinicius</a>.</p>
	</footer>
	<!-- FIM DO RODAPE -->
</div>
</body>
</html>
