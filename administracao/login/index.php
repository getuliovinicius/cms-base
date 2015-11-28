<?php
/* ###########################################################
FORMULARIO DE ACESSO A AREA ADMINISTRATIVA
CRIACAO: 08/05/2012
########################################################### */

// VERIFICACAO SE JA EXISTE UM LOGIN ATIVO ###################################################

if (!isset($_SESSION)) {
	session_start();
}
if (isset($_SESSION['loginSitecmsADM'])) {
	header('Location: /cms-base/administracao');
	exit;
} else {
	session_destroy();
}	

// ###########################################################################################

// DEFINICAO DO FUZO E DA DATA ###############################################################

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL,"pt_BR");
$dataCompleta = strftime("%A, %d de %B de %Y");

// ###########################################################################################

// DELETAR O INSTALADOR ######################################################################

include '../../include/login/php/deletar-instalador.php';

// ###########################################################################################

// CARREGA O ARQUIVO cabecalho.php ###########################################################

include '../../include/geral/php/cabecalho.php';

// ###########################################################################################
?>
<!DOCTYPE HTML>
<html lang="pt-br"><!-- InstanceBegin template="/Templates/login.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<meta name="author" content="Getulio Vinicus">
<!-- InstanceBeginEditable name="doctitle" -->
<title><?php echo $siteTitulo; ?> - Administração | Login</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" type="text/css" media="screen" href="/cms-base/administracao/login/css/estilo.css" />
<!-- InstanceEndEditable -->
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
		<!-- InstanceBeginEditable name="formulario" -->
		<fieldset id="formularioLogin">
			<h1><img src="/cms-base/imagens/administracao/icones/login.png" width="16" height="16" alt="Login"> Login</h1>
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
		</fieldset>
		<!-- InstanceEndEditable -->
	</section>
	<!-- FIM DO CONTEUDO -->
	<!-- INICIO DO RODAPE -->
	<footer id="rodape">
		<?php include '../../include/login/html/login-rodape.html'; ?>
	</footer>
	<!-- FIM DO RODAPE -->
</div>
</body>
<!-- InstanceEnd --></html>
