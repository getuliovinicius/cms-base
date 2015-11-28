<?php
// CONSULTAS A BASE DE DADOS #################################################################

// determina o nivel de permissao do usuário
if (in_array(6, $sessaoPermissoes)) {
	$sqlUsuarios = "
	SELECT usrId, usrEmail, usrNome, usrLogin, usrAtivo, usrRoot
	FROM usuarios
	ORDER BY usrNome;
	";
	$listaUsuarios = "../include/administracao/php/usuarios-lista-todos.php";
} else {
	$sqlUsuarios = "
	SELECT usrId, usrEmail, usrNome
	FROM usuarios
	WHERE usrRoot = 'n'
	AND usrAtivo = 's'
	ORDER BY usrNome;
	";
	$listaUsuarios = "../include/administracao/php/usuarios-lista-ativos.php";
}
// buscar usuarios
require_once '../classes/sql-funcoes.php';
$sqlFuncoes = new sqlFuncoes();
$sqlFuncoes->setSql($sqlUsuarios);
$usrDados = $sqlFuncoes->listaRegistros();

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
<title><?php echo $siteTitulo; ?> - Administração | Usuários</title>
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
				<p><a href="/cms-base/administracao">Painel</a> &gt; Usuários</p>
			</nav>
			<h1><img src="/cms-base/imagens/administracao/icones/usuarios.png" alt="Usuários" width="16" height="16"> Usuários</h1>
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
require_once $listaUsuarios;
?>
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
<!-- InstanceEnd -->
</html>