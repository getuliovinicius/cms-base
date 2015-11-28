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
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="author" content="Getulio Vinicus">
<!-- TemplateBeginEditable name="doctitle" -->
<title>CMS-Base - Documentação</title>
<!-- TemplateEndEditable -->
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" type="text/css" media="screen" href="/cms-base/documentacao/css/estilo.css"/>
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
</head>
<body>
<div id="todaPagina">
	<!-- INICIO DO CABECALHO -->
	<header id="cabecalho">
		<hgroup>
			<h1>Documentação do gerenciador de conteúdo CMS-Base</h1>
			<h2>Ativo no site "<a href="/" title="Página inicial"><strong><?php echo $siteTitulo; ?></strong></a>"</h2>
		</hgroup>
	</header>
	<!-- FIM DO CABECALHO -->
	<!-- INICIO DO CONTEUDO -->
	<section id="conteudo">
		<aside id="conteudoLateral">
			<?php include '../include/documentacao/html/documentacao-menu.html'; ?>
		</aside>
		<article id="conteudoAplicacao">
			<!-- TemplateBeginEditable name="conteudoAplicacao" -->
			<h1>Conteúdo em destaque.</h1>
			<!-- TemplateEndEditable -->
		</article>
	</section>
	<!-- FIM DO CONTEUDO -->
	<!-- INICIO DO RODAPE -->
	<footer id="rodape">
		<?php include '../include/documentacao/html/documentacao-rodape.html'; ?>
	</footer>
	<!-- FIM DO RODAPE -->
</div>
</body>
</html>
