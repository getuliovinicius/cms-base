<?php
/* ###########################################################
FORMULARIO DE CONFIGURACAO DO BANCO DE DADOS DO SITE
CRIACAO 	20/05/2012
ATUALIZADO 	20/05/2012
########################################################### */

// VERIFICA SE A 1 PARTE FOI CONCLUIDA #######################################################

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
<title>Instalação CMS-Base | 2ª parte</title>
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
			<h1>CMS-Base | 2ª Parte da instalação - Banco de Dados</h1>
		<!-- InstanceEndEditable -->
	</header>
	<!-- FIM DO CABECALHO -->
	<!-- INICIO DO FORMULARIO -->
	<section id="conteudo">
		<!-- InstanceBeginEditable name="formulario" -->
		<h1>Preencha o formulário para configurar o Banco de Dados do site "<?php echo $siteTitulo; ?>".</h1>
		<p class="msgOk"><strong>A 1ª Parte foi conclu&iacute;da com sucesso!</strong></p>
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
		<form action="/cms-base/instalacao/cfg-banco-de-dados.php" method="post" name="bancodedados">
			<input name="siteTitulo" type="hidden" value="<?php echo $siteTitulo; ?>">
			<div class="formLinhas">
				<p>
					<label for="servidor"><strong>(*) Servidor:</strong></label><br>
					<input type="text" name="servidor" id="servidor" tabindex="1" placeholder="Digite o caminho do servidor MySQL." required>
				</p>
			</div>
			<div class="formLinhas">
				<p>
					<label for="banco"><strong>(*) Banco de dados:</strong></label><br>
					<input type="text" name="banco" id="banco" tabindex="2" placeholder="Digite o nome do banco de dados." required>
				</p>
			</div>
			<div class="formLinhas">
				<p>
					<label for="usuario"><strong>(*) Usuário:</strong></label><br>
					<input type="text" name="usuario" id="usuario" tabindex="3" placeholder="Digite o usuário de acesso ao banco de dados." required>
				</p>
			</div>
			<div class="formLinhas">
				<p>
					<label for="senha"><strong>(*) Senha:</strong></label><br>
					<input type="password" name="senha" id="senha" tabindex="4" placeholder="Digite a senha de acesso ao banco de dados." required>
				</p>
			</div>
			<div class="formLinhas">
				<p>
					<input type="submit" name="avancar" id="avancar" value="   Avançar >>   " tabindex="5">
				</p>
			</div>
		</form>
		<p>(*) campos obrigatórios</p>
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
