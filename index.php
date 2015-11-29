<?php
// DEFINICAO DO FUZO E DA DATA ###############################################################

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL,"pt_BR");
$dataCompleta = strftime("%A, %d de %B de %Y");

// ###########################################################################################

// CARREGA O ARQUIVO cabecalho.php ###########################################################

include 'include/geral/php/cabecalho.php';

// ###########################################################################################
?>
<!DOCTYPE HTML>
<html><!-- InstanceBegin template="/Templates/site.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<meta name="author" content="<?php echo $siteAutor; ?>">
<!-- InstanceBeginEditable name="doctitle" -->
<title><?php echo $siteTitulo . $siteSlogan; ?></title>
<!-- InstanceEndEditable -->
<meta name="robots" content="index,follow" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/estilo.css"/>
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
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
			<!-- InstanceBeginEditable name="conteudoAplicacao" -->
			<hgroup>
				<h1>CMS-Base</h1>
				<h2>Site em Construção</h2>
			</hgroup>
			<p><a href="/administracao">Administração</a></p>
			<!-- InstanceEndEditable -->
		</section>
		<aside id="conteudoLateral">
			<!-- InstanceBeginEditable name="conteudoNavegacao" -->
			<h2>Barra Lateral</h2>
			<!-- InstanceEndEditable -->
		</aside>
	</section>
	<!-- FIM DO CONTEUDO -->
	<!-- INICIO DO RODAPE -->
	<footer id="rodape">
		<?php include 'include/site/html/site-rodape.html'; ?>
	</footer>
	<!-- FIM DO RODAPE -->
</div>
</body>
<!-- InstanceEnd --></html>
