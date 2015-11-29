<?php
/* ###########################################################
FORMULARIO DE CONFIGURACAO DO TITULO E DESCRICAO DO SITE
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
<title>Instalação CMS-Base | 1ª parte</title>
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
		<h1>CMS-Base | 1ª Parte da instalação - Título e descrição do site</h1>
		<!-- InstanceEndEditable -->
	</header>
	<!-- FIM DO CABECALHO -->
	<!-- INICIO DO FORMULARIO -->
	<section id="conteudo">
		<!-- InstanceBeginEditable name="formulario" -->
		<h1>Preencha o formulário para configurar o nome do site.</h1>
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
		<form action="/instalacao/cfg-titulo-site.php" method="post" name="titulo" id="titulo">
			<div class="formLinhas">
				<p>
					<label for="siteTitulo"><strong>(*) Título:</strong></label><br>
					<input type="text" name="siteTitulo" id="siteTitulo" placeholder="Digite o título do site." required tabindex="1">
				</p>
			</div>
			<div class="formLinhas">
				<p>
					<label for="siteSlogan"><strong>(*) Slogan:</strong></label><br>
					<input type="text" name="siteSlogan" id="siteSlogan" placeholder="Digite um slogan para o site." required tabindex="2">
				</p>
			</div>
			<div class="formLinhas">
				<p>
					<label for="siteDescricao"><strong>(*) Descrição:</strong></label><br>
					<textarea name="siteDescricao" id="siteDescricao" cols="50" rows="2" tabindex="3" placeholder="Faça uma breve descrição do seu site. Isto irá ajudar na divulgação do site nos mecanismos de pesquisa." required></textarea>
				</p>
			</div>
			<div class="formLinhas">
				<p>
					<label for="sitePalavraschave"><strong>(*) Palavras chave:</strong></label><br>
					<textarea name="sitePalavraschave" id="sitePalavraschave" cols="50" rows="2" tabindex="4" placeholder="Digite algumas palavras que caracterizam seu site ou que provavelmente irá surgir mais vezes no coteúdo." required></textarea>
				</p>
			</div>
			<div  class="formLinhas">
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
		<p><strong>CMS-Base 0.5</strong> desenvolvido por <a href="http://twitter.com/getuliovinits" title="Perfil no twitter" target="_blank">Getulio Vinicius</a>.</p>
	</footer>
	<!-- FIM DO RODAPE -->
</div>
</body>
<!-- InstanceEnd --></html>
