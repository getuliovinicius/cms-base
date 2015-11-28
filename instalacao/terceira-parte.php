<?php
/* ###########################################################
FORMULARIO DE CONFIGURACAO DO ADMINISTRADOR DO SITE
CRIACAO 	20/05/2012
ATUALIZADO 	20/05/2012
########################################################### */

// VERIFICA SE A 2 PARTE FOI CONCLUIDA #######################################################

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
<title>Instalação CMS-Base | 3ª parte</title>
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
		<h1>CMS-Base | 3ª Parte da instalação - Administrador</h1>
		<!-- InstanceEndEditable -->
	</header>
	<!-- FIM DO CABECALHO -->
	<!-- INICIO DO FORMULARIO -->
	<section id="conteudo">
		<!-- InstanceBeginEditable name="formulario" -->
		<h1>Preencha o formulário para criar uma conta de administra&ccedil;&atilde;o do site <?php echo $siteTitulo; ?>".</h1>
		<p class="msgOk"><strong>A 2ª Parte foi conclu&iacute;da com sucesso!</strong></p>
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
		<form action="/cms-base/instalacao/cfg-administrador.php" method="post" name="administrador">
			<input name="siteTitulo" type="hidden" value="<?php echo $siteTitulo; ?>">
			<div class="formLinhas">
				<p>
					<label for="usrEmail"><strong>(*) E-mail:</strong></label><br>
					<input type="email" name="usrEmail" id="usrEmail" tabindex="1" maxlength="45" placeholder="Digite o e-mail do administrador do site." required>
				</p>
			</div>
			<div class="formLinhas">
				<p>
					<label for="usrNome"><strong>(*) Nome:</strong></label><br>
					<input type="text" name="usrNome" id="usrNome" tabindex="2" maxlength="45" placeholder="Digite o nome do usuário administrador." required>
				</p>
			</div>
			<div class="formLinhas">
				<p>
					<label for="usrApelido"><strong>Apelido:</strong></label><br>
					<input name="usrApelido" type="text" id="usrApelido" tabindex="3" maxlength="30" placeholder="Digite um apelido para o usuário. (opcional)">
				</p>
			</div>
			<div class="formLinhas">
				<p>
					<label for="usrLogin"><strong>(*) Usuário de login:</strong></label><br>
					<input name="usrLogin" type="text" id="usrLogin" tabindex="4" maxlength="10" placeholder="Sem espaços e no máximo 10 letras minúsculas." required>
				</p>
			</div>
			<div class="formLinhas">
				<p>
					<label for="usrSenha1"><strong>(*) Senha:</strong></label><br>
					<input name="usrSenha1" type="password" id="usrSenha1" tabindex="5" maxlength="32" placeholder="Apenas letras e números" required>
				</p>
			</div>
			<div class="formLinhas">
				<p>
					<label for="usrSenha2"><strong>(*) Confirme a senha:</strong></label><br>
					<input name="usrSenha2" type="password" id="usrSenha2" tabindex="6" maxlength="32" placeholder="Apenas letras e números" required>
				</p>
			</div>
			<div class="formLinhas">
				<p>
					<input type="submit" name="avancar" id="avancar" value="   Avançar >>   " tabindex="7">
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
