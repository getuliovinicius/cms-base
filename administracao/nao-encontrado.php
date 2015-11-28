<?php
// NAO EXIBE PAGINAS DE ERRO 404 SE NAO ESTIVER LOGADO #######################################
if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION['loginSitecmsADM'])) {
	setcookie('erroLogin', 'Autenticação nescessária.', time() + 10, '/cms-base/administracao/login/');
	header('Location: /cms-base/administracao/login');
	exit;
} elseif (!isset($sessaoId)) {
	require_once '../include/login/php/login-atualiza.php';
}

// ###########################################################################################

// DEFINE ERRORDOCUMENT 404 ##################################################################

header("HTTP/1.1 404 Not Found");

// ###########################################################################################

// CARREGA O ARQUIVO cabecalho.php ###########################################################

include '../include/geral/php/cabecalho.php';

// ###########################################################################################

// DEFINICAO DO FUZO E DA DATA ###############################################################

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL,"pt_BR");
$dataCompleta = strftime("%A, %d de %B de %Y");

// ###########################################################################################
?>
<!DOCTYPE HTML>
<html><!-- InstanceBegin template="/Templates/administracao.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<meta name="author" content="Getulio Vinicius">
<!-- InstanceBeginEditable name="doctitle" -->
<title><?php echo $siteTitulo; ?> - Administração | Não encontrado</title>
<!-- InstanceEndEditable -->
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" type="text/css" media="screen" href="/cms-base/administracao/css/estilo.css"/>
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
</head>

<body>
<div id="todaPagina">
	<!-- INICIO DO CABECALHO -->
	<header id="cabecalho">
		<div id="cabecalhoLogo">
			<p><strong><a href="/cms-base/administracao" title="Página inicial da administração do site."><?php echo $siteTitulo; ?></a></strong></p>
		</div>
		<div id="cabecalhoLogin">
			<!-- InstanceBeginEditable name="cabecalhoLogin" -->
			<?php include '../include/login/php/login-dados.php'; ?>
		<!-- InstanceEndEditable -->
		</div>
	</header>
	<!-- FIM DO CABECALHO -->
	<!-- INICIO DO CONTEUDO -->
	<section id="conteudo">
		<aside id="conteudoLateral">
			<!-- InstanceBeginEditable name="conteudoNavegacao" -->
			<?php include '../include/administracao/php/administracao-menu.php'; ?>
			<!-- InstanceEndEditable -->
		</aside>
		<section id="conteudoAplicacao">
			<!-- InstanceBeginEditable name="conteudoAplicacao" -->
			<hgroup>
				<h1><?php echo $siteTitulo; ?></h1>
				<h2>Lamentamos</h2>
			</hgroup>
			<p>N&atilde;o foi poss&iacute;vel localizar a p&aacute;gina: &quot; <em><?php echo "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?></em> &quot;. </p>
			<!-- InstanceEndEditable -->
		</section>
	</section>
	<!-- FIM DO CONTEUDO -->
	<!-- INICIO DO RODAPE -->
	<footer id="rodape">
		<!-- InstanceBeginEditable name="rodape" -->
		<?php include '../include/administracao/html/administracao-rodape.html'; ?>
		<!-- InstanceEndEditable -->
	</footer>
	<!-- FIM DO RODAPE -->
</div>
</body>
<!-- InstanceEnd --></html>
