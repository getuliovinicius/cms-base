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
<html lang="pt-br"><!-- InstanceBegin template="/Templates/documentacao.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<meta name="author" content="Getulio Vinicus">
<!-- InstanceBeginEditable name="doctitle" -->
<title>CMS-Base - Documentação | Início</title>
<!-- InstanceEndEditable -->
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" type="text/css" media="screen" href="/cms-base/documentacao/css/estilo.css"/>
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
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
			<!-- InstanceBeginEditable name="conteudoAplicacao" -->
			<h1>Sobre o CMS-Base</h1>
			<h2>História</h2>
			<p>O CMS-Base começou a ser desenvolvido em 2009 como projeto pessoal do professor de matemática que vos escreve. Na época não era intensão criar um gerenciador de conteúdo, e sim um site no estilo de um Blog que exibisse histórias em quadrinhos de autoria conjunta de Fábio Fernando e Marcos Lourival, ambos meus tios.</p>
			<p>O site de histórias em quadrinhos já não existe mais, no entanto, no fim de suas atividades uma espécie de gerenciador de conteúdo primitiva estava em uso. Este gerenciador foi aprimorado para que pudesse servir de base para outros sites.</p>
			<p>Hoje a <strong>versão 1.0</strong> encontra-se estável para uso em cadeia de produção. Algumas possíveis correções serão informadas em versões de atualização da 1.0, e sua versão 2.0 com novos recursos encontra-se em fase desenvolvimento alpha.</p>
			<h2>Licença</h2>
			<p>Atualmente sua licença de uso é comercializada.</p>
			<!-- InstanceEndEditable -->
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
<!-- InstanceEnd --></html>
