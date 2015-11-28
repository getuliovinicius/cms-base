<?php
/* ###########################################################
ARQUIVO DE CONCLUSAO DA INSTALACAO DO SITE
CRIACAO 	20/05/2012
ATUALIZADO 	20/05/2012
########################################################### */

// VERIFICA SE A 3 PARTE FOI CONCLUIDA #######################################################

if (isset($_COOKIE['instalacao'])) {
	// carrega o arquivo com o titulo do site
	include '../include/geral/php/cabecalho.php';
	if ($siteTitulo != $_COOKIE['instalacao']) {
		setcookie('msgErro[formulario]', 'Inicie a instala&ccedil;&atilde;o.', time() + 10, '/cms-base/instalacao/');
		header('Location: /cms-base/instalacao/');
		exit;
	}
} else {
	setcookie('msgErro[formulario]', 'Inicie a instala&ccedil;&atilde;o.', time() + 10, '/cms-base/instalacao/');
	header('Location: /cms-base/instalacao/');
	exit;
}

// ###########################################################################################

// DEFINICAO DO FUZO E DA DATA ###############################################################

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL,"pt_BR");
$dataCompleta = strftime("%A, %d de %B de %Y");

// ###########################################################################################
?>
<!DOCTYPE HTML>
<html lang="pt-br"><!-- InstanceBegin template="/Templates/instalacao.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<meta name="author" content="Getulio Vinicius">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Instalação CMS-Base | Fim</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<meta name="robots" content="noindex,nofollow" />
<link href="/cms-base/instalacao/css/estilo.css" rel="stylesheet" type="text/css" media="screen">
</head>
<body>
<div id="todaPagina">
	<!-- INICIO DO CABECALHO -->
	<header id="cabecalho">
		<!-- InstanceBeginEditable name="cabecalho" -->
		<h1>CMS-Base | Instalação completa.</h1>
		<!-- InstanceEndEditable -->
	</header>
	<!-- FIM DO CABECALHO -->
	<!-- INICIO DO FORMULARIO -->
	<section id="conteudo">
		<!-- InstanceBeginEditable name="formulario" -->
		<h1>O site "<?php echo $siteTitulo; ?>" esta configurado!</h1>
		<p class="msgOk"><strong>A 3ª Parte foi conclu&iacute;da com sucesso!</strong></p>
		<p>Obrigado por ter instalado o gerenciador de sites <strong>CMS-Base</strong>. Esperamos que use-o durante muito tempo.</p>
		<p>Dedique mais 5 minutos para <a href="/cms-base/documentacao/notas-versao" title="Clique para ler as notas da versão."><strong>LER AS NOTAS DA VERSÃO</strong></a>.</p>
		<p>Você pode acessar o painel de controle pelo endereço <strong>"http://<?php echo $_SERVER['HTTP_HOST']; ?>/cms-base/administracao"</strong> ou agora mesmo seguindo o link:</p>
		<p><a href="/cms-base/administracao/login" title="Clique para fazer login e administrar o site."><strong>CLIQUE AQUI PARA ACESSAR O PAINEL DE CONTROLE</strong></a></p>
		<p><strong>Atenciosamente, Getulio Vinicius.</strong></p>
		<!-- InstanceEndEditable -->
	</section>
	<!-- FIM DO FORMULARIO -->
	<!-- INICIO DO RODAPE -->
	<footer id="rodape">
		<p><strong>CMS-Base 1.0</strong> desenvolvido por <a href="http://twitter.com/getuliovinits" title="Perfil no twitter" target="_blank">Getulio Vinicius</a>.</p>
	</footer>
	<!-- FIM DO RODAPE -->
</div>
</body>
<!-- InstanceEnd --></html>
