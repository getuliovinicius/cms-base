<?php
/* ###########################################################
ARQUIVO DE INICIO DE APRESENTACAO E INSTALACAO DO SITE
CRIACAO 	20/05/2012
ATUALIZADO 	20/05/2012
########################################################### */

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
<title>CMS-Base</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<meta name="robots" content="noindex,nofollow" />
<link href="/instalacao/css/estilo.css" rel="stylesheet" type="text/css" media="screen">
</head>
<body>
<div id="todaPagina">
	<!-- INICIO DO CABECALHO -->
	<header id="cabecalho">
		<!-- InstanceBeginEditable name="cabecalho" -->
		<hgroup>
			<h1>CMS-Base</h1>
			<h2>Um gerenciador de conteúdo fácil.</h2>
		</hgroup>
		<!-- InstanceEndEditable -->
	</header>
	<!-- FIM DO CABECALHO -->
	<!-- INICIO DO FORMULARIO -->
	<section id="conteudo">
		<!-- InstanceBeginEditable name="formulario" -->
		<h1>Hora de começar</h1>
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
		<p><strong>Você esta prestes a instalar um gerenciador de conteúdo para sites. Veja os pré-requisitos:</strong></p>
		<ol>
			<li>É nescessário ter um servidor web Apache com suporte a <strong>PHP, </strong>e com o <strong>&quot;rewrite_module&quot;</strong> ativo.</li>
			<li>Um <strong>banco de dados</strong> limpo em um servidor <strong>MySQL</strong> e um <strong>usuário</strong> com todas as permissões de acesso a este banco.</li>
			<li>Um endereço de <strong>e-mail </strong>válido para o administrador do gerenciador de conteúdo.</li>
		</ol>
		<p><strong><a href="/instalacao/primeira-parte.php">SE TUDO ESTIVE OK, CLIQUE AQUI PARA INICIAR A INSTALAÇÃO.</a></strong></p>
		<p><strong>Observação 1:</strong> Se por ventura for nescessário reiniciar a instalação antes de sua conclusão, você deve certificar-se que o banco de dados que irá receber a instalação esteja limpo.</p>
		<p><strong>Observação 2:</strong> Caso queira reinstalar o gerenciador futuramente, todas as configurações atuais serão perdidas, e somente backups manuais poderam restaura-las.</p>
		<!-- InstanceEndEditable -->
	</section>
	<!-- FIM DO FORMULARIO -->
	<!-- INICIO DO RODAPE -->
	<footer id="rodape">
		<p><strong>CMS-Base 0.5</strong> desenvolvido por <a href="http://twitter.com/getuliovinits" title="Perfil no twitter" target="_blank">Getulio Vinicius</a>.</p>
	</footer>
	<!-- FIM DO RODAPE -->
</div>
</body>
<!-- InstanceEnd --></html>
