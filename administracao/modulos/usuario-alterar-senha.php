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
<html><!-- InstanceBegin template="/Templates/administracao.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<meta name="author" content="Getulio Vinicius">
<!-- InstanceBeginEditable name="doctitle" -->
<title><?php echo $siteTitulo; ?> - Administração | Alterar senha</title>
<!-- InstanceEndEditable -->
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" type="text/css" media="screen" href="/cms-base/administracao/css/estilo.css"/>
<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript" src="/cms-base/js/administracao/menu-modulos.js"></script>
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
			<script type="text/javascript">
				menuAcao('usuarios');
			</script>
			<!-- InstanceEndEditable -->
		</aside>
		<section id="conteudoAplicacao">
			<!-- InstanceBeginEditable name="conteudoAplicacao" -->
			<nav class="fontPequena">
				<p><a href="/cms-base/administracao">Painel</a> &gt; <a href="/cms-base/administracao/usuarios">Usuários</a> &gt; Alterar senha</p>
			</nav>
			<h1><img src="/cms-base/imagens/administracao/icones/usuario-alterar-senha.png" alt="Senha" width="16" height="16"> Alterar senha</h1>
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
			<p>A senha do usuário " <strong><?php echo $sessaoLogin; ?></strong> " será afetada.</p>
			<form name="alterar-senha" id="alterar-senha" action="/cms-base/administracao/envio/usuario-alterar-senha.php" method="post">
				<input name="usrId" type="hidden" value="<?php echo $sessaoId; ?>" />
				<div class="formLinhas">
					<p>
						<label for="usrSenhaatual"><strong>(*) Senha atual:</strong></label><br>
						<input type="password" name="usrSenhaatual" id="usrSenhaatual" maxlength="32" tabindex="1" placeholder="Sua senha atual" required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrSenha1"><strong>(*) Nova senha:</strong></label><br>
						<input type="password" name="usrSenha1" id="usrSenha1" maxlength="32" tabindex="2" placeholder="Apenas alfanuméricos." required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrSenha2"><strong>(*) Confirme a nova senha:</strong></label><br>
						<input type="password" name="usrSenha2" id="usrSenha2" maxlength="32"  tabindex="3" placeholder="Apenas alfanuméricos." required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<input type="submit" name="alterar-senha" value="  Alerar senha >>  " tabindex="4">
					</p>
				</div>
			</form>
			<p>(*) campos obrigatórios</p>
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
