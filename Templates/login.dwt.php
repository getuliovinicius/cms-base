<?php
// DEFINICAO DO FUZO E DA DATA ###############################################################

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL,"pt_BR");
$dataCompleta = strftime("%A, %d de %B de %Y");

// ###########################################################################################

// DELETAR O INSTALADOR ######################################################################

include '../include/login/php/deletar-instalador.php';

// ###########################################################################################

// VERIFICACAO SE JA EXISTE UM LOGIN ATIVO ###################################################

if (!isset($_SESSION)) {
	session_start();
}
if (isset($_SESSION['MeuLoginADM'])) {
	header('Location: /cms-base/administracao');
	exit;
} else {
	session_destroy();
}	

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
<title><?php echo $siteTitulo; ?> - Administração | Login</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" type="text/css" media="screen" href="/cms-base/administracao/login/css/estilo.css" />
<!-- TemplateEndEditable -->
</head>

<body>
<div id="todaPagina">
	<!-- INICIO DO CABECALHO -->
	<header id="cabecalho">
		<hgroup>
			<h1><a href="/" title="Página inicial"><strong><?php echo $siteTitulo; ?></strong></a></h1>
			<h2>Painel de Controle</h2>
		</hgroup>
	</header>
	<!-- FIM DO CABECALHO -->
	<!-- INICIO DO CONTEUDO -->
	<section id="conteudo">
		<!-- TemplateBeginEditable name="formulario" -->
		<div id="formularioLogin">
			<h1>Login</h1>
<?php
	if (isset($_COOKIE['erroLogin'])) {
		echo "<p class='msgErro'>";
		echo $_COOKIE['erroLogin'];
		echo "</p>";
	}
?>			
			<form name="login" method="post" action="/cms-base/administracao/login/login.php">
				<input type="hidden" name="acao" value="login-cms-base">
				<div class="formLinhas">
					<p>
						<label for="usrLogin"><strong>Usu&aacute;rio:</strong></label><br>
						<input type="text" name="usrLogin" id="usrLogin" maxlength="10" tabindex="1" required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrSenha"><strong>Senha:</strong></label><br>
						<input type="password" name="usrSenha" id="usrSenha" maxlength="32" tabindex="2" required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<input type="submit" name="entrar" value="   Entrar >>   " tabindex="3">
					</p>
				</div>
			</form>
			<p><a href="#">Esqueceu a senha?</a></p>
		</div>
		<!-- TemplateEndEditable -->
	</section>
	<!-- FIM DO CONTEUDO -->
	<!-- INICIO DO RODAPE -->
	<footer id="rodape">
		<?php include '../include/login/html/login-rodape.html'; ?>
	</footer>
	<!-- FIM DO RODAPE -->
</div>
</body>
</html>
