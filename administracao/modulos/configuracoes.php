<?php
// VERIFICA A PERMISSAO DE ACESSO ############################################################

if (!in_array(7, $sessaoPermissoes)) {
	// retorna mensagem de erro
	setcookie('msgErro[privilegio]', 'Acesso restrito a usuários com permissão.', time() + 10, '/administracao');
	header('Location: /administracao');
	exit;
}

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
<title><?php echo $siteTitulo; ?> - Administração | Configurações</title>
<!-- InstanceEndEditable -->
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" type="text/css" media="screen" href="/administracao/css/estilo.css"/>
<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript" src="/js/administracao/menu-modulos.js"></script>
<!-- InstanceEndEditable -->
</head>

<body>
<div id="todaPagina">
	<!-- INICIO DO CABECALHO -->
	<header id="cabecalho">
		<div id="cabecalhoLogo">
			<p><strong><a href="/administracao" title="Página inicial da administração do site."><?php echo $siteTitulo; ?></a></strong></p>
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
				menuAcao('configuracoes');
			</script>
			<!-- InstanceEndEditable -->
		</aside>
		<section id="conteudoAplicacao">
			<!-- InstanceBeginEditable name="conteudoAplicacao" -->
			<nav class="fontPequena">
				<p><a href="/administracao">Painel</a> &gt; Configurações</p>
			</nav>
			<hgroup>
				<h1><img src="/imagens/administracao/icones/configuracoes.png" width="16" height="16" alt="Configurações"> Configurações</h1>
				<h2>Título e descrição do site</h2>
			</hgroup>
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
			<form name="titulo" method="post" action="/administracao/envio/cfg-titulo-site.php">
				<input type="hidden" name="siteEmail" value="<?php echo $siteEmail; ?>">
				<input type="hidden" name="siteAutor" value="<?php echo $siteAutor; ?>">
				<div class="formLinhas">
					<p>
						<label for="siteTitulo"><strong>(*) Título do Blog:</strong></label><br>
						<input type="text" name="siteTitulo" id="siteTitulo" tabindex="1" maxlength="50" title="Digite um título para seu Blog." value="<?php echo $siteTitulo; ?>" required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="siteSlogan"><strong>(*) Slogan do Blog:</strong></label><br>
						<input type="text" name="siteSlogan" id="siteSlogan" tabindex="2" maxlength="50" title="Digite uma frase que sirva de slogan para o Blog, algo que chame a atenção das pessoas." value="<?php echo $siteSlogan; ?>" required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="siteDescricao"><strong>(*) Descrição:</strong></label><br>
						<textarea name="siteDescricao" id="siteDescricao" cols="50" rows="2" tabindex="3" placeholder="Faça uma breve descrição do seu site. Isto irá ajudar na divulgação do site nos mecanismos de pesquisa." required><?php echo $siteDescricao; ?></textarea>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="sitePalavraschave"><strong>(*) Palavras chave:</strong></label><br>
						<textarea name="sitePalavraschave" id="sitePalavraschave" cols="50" rows="2" tabindex="4" placeholder="Digite algumas palavras que caracterizam seu site ou que provavelmente irá surgir mais vezes no coteúdo." required><?php echo $sitePalavraschave; ?></textarea>
					</p>
				</div>
				<div  class="formLinhas">
					<p>
						<input type="submit" name="titulo" id="titulo" value="   Salvar >>   " tabindex="5">
					</p>
				</div>
			</table>
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
