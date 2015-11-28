<?php
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
<html>
<head>
<meta charset="utf-8">
<meta name="author" content="Getulio Vinicius">
<!-- TemplateBeginEditable name="doctitle" -->
<title><?php echo $siteTitulo; ?> - Administração | #####</title>
<!-- TemplateEndEditable -->
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" type="text/css" media="screen" href="/cms-base/administracao/css/estilo.css"/>
<!-- TemplateBeginEditable name="head" -->
<script type="text/javascript" src="/cms-base/js/administracao/menu-modulos.js"></script>
<!-- TemplateEndEditable -->
</head>

<body>
<div id="todaPagina">
	<!-- INICIO DO CABECALHO -->
	<header id="cabecalho">
		<div id="cabecalhoLogo">
			<p><strong><a href="/cms-base/administracao" title="Página inicial da administração do site."><?php echo $siteTitulo; ?></a></strong></p>
		</div>
		<div id="cabecalhoLogin">
			<!-- TemplateBeginEditable name="cabecalhoLogin" -->
			<?php include '../include/login/php/login-dados.php'; ?>
			<!-- TemplateEndEditable -->
		</div>
	</header>
	<!-- FIM DO CABECALHO -->
	<!-- INICIO DO CONTEUDO -->
	<section id="conteudo">
		<aside id="conteudoLateral">
			<!-- TemplateBeginEditable name="conteudoNavegacao" -->
			<?php include '../include/administracao/php/administracao-menu.php'; ?>
			<script type="text/javascript">
				menuAcao('administracao');
			</script>
			<!-- TemplateEndEditable -->
		</aside>
		<section id="conteudoAplicacao">
			<!-- TemplateBeginEditable name="conteudoAplicacao" -->
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
	</section>
	<!-- FIM DO CONTEUDO -->
	<!-- INICIO DO RODAPE -->
	<footer id="rodape">
		<!-- TemplateBeginEditable name="rodape" -->
		<?php include '../include/administracao/html/administracao-rodape.html'; ?>
		<!-- TemplateEndEditable -->
	</footer>
	<!-- FIM DO RODAPE -->
</div>
</body>
</html>
