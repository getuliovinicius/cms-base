<?php
// VERIFICA A PERMISSAO DE ACESSO ############################################################

if (!in_array(6, $sessaoPermissoes)) {
	// retorna mensagem de erro
	setcookie('msgErro[privilegio]', 'Acesso restrito a usuários com permissão.', time() + 10, '/cms-base/administracao/usuarios');
	header('Location: /cms-base/administracao/usuarios');
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
<title><?php echo $siteTitulo; ?> - Administração | Novo usuário</title>
<!-- InstanceEndEditable -->
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" type="text/css" media="screen" href="/cms-base/administracao/css/estilo.css"/>
<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript" src="/cms-base/js/administracao/menu-modulos.js"></script>
<script type="text/javascript" src="/cms-base/js/administracao/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	language : "pt",
	mode : "specific_textareas",
	editor_selector : "tinyMCE",
	theme : "advanced",
	plugins : "autolink,emotions,wordcount,tabfocus",
	theme_advanced_buttons1 : "undo,redo,separator,formatselect,separator,bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,separator,bullist,numlist,separator,outdent,indent,blockquote,separator,link,unlink,anchor,image,emotions,separator,code",
	theme_advanced_buttons2 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	tab_focus : ':prev,:next'
});
</script>
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
<!--
			<p>O campo apelido serve para criar possíveis links para o perfil do usuário, caso não seja preenchido, a primeira parte do nome será utilizada em seu lugar.</p>
			<p>A foto é obrigatória e preferencialmente deve ter as seguinte medidas: 102px de largura por 136px de altura.</p>
			<p>O campo descrição do usuário serve exatamente para criar um perfil a ser exibido ou não no site de acordo com as preferências gerais definidas pelo administrador.</p>
			<p>Os campos meta descrição e palavras chave são importantes para facilitar a descoberta da página pelos sistemas de busca na internet. Também de acordo com as preferências gerais definidas pelo administrador.</p>
			<p>O campo edita postagens, define se o usuário será ou não editor do site, sendo assim seu perfil poderá ser exibido no site apenas se for editor, caso contrário não será exibido. Uma vez que o perfil seja definido como editor, não poderá ser desfeito.</p>
			<p><strong>Resta fazer:</strong></p>
			<p>Quando for possível editar a foto após o upload para que fique com a largura igual a 102px.</p>
-->
			<!-- InstanceEndEditable -->
		</aside>
		<section id="conteudoAplicacao">
			<!-- InstanceBeginEditable name="conteudoAplicacao" -->
			<nav class="fontPequena">
				<p><a href="/cms-base/administracao">Painel</a> &gt; <a href="/cms-base/administracao/usuarios">Usuários</a> &gt; Novo usuário</p>
			</nav>
			<h1><img src="/cms-base/imagens/administracao/icones/usuario-novo.png" alt="Novo usuário" width="16" height="16"> Cadastrar novo usu&aacute;rio</h1>
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
			<form name="usuario-novo" id="usuario-novo" action="/cms-base/administracao/envio/usuario-novo.php" method="post" enctype="multipart/form-data">
				<div class="formLinhas">
					<p>
						<label for="usrEmail"><strong>(*) E-mail:</strong></label><br>
						<input type="email" name="usrEmail" id="usrEmail" maxlength="45" tabindex="1" placeholder="Digite um endereço de e-mail." required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrNome"><strong>(*) Nome completo:</strong></label><br>
						<input type="text" name="usrNome" id="usrNome" maxlength="45" tabindex="2" placeholder="Digite o nome do usuário." required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrLogin"><strong>(*) Usuário de login:</strong></label><br>
						<input type="text" name="usrLogin" id="usrLogin" maxlength="10" tabindex="3" placeholder="Digite um nome de usuário para efetuar login no site." required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrApelido"><strong>Apelido:</strong></label><br>
						<input name="usrApelido" type="text" id="usrApelido" maxlength="30" tabindex="4" placeholder="Digite um apelido para o usuário. (opcional)" title="Digite um apelido para aparecer nas postagens do site. Caso não digite será usado a primeira parte do nome.">
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrFoto"><strong>(*) Foto (jpg ou png):</strong></label><br>
						<input type="file" name="usrFoto" id="usrFoto" tabindex="5" required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrDescricao"><strong>(*)Descrição:</strong></label><br>
						<textarea name="usrDescricao" id="usrDescricao" cols="50" rows="15" tabindex="6" class="tinyMCE"></textarea>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrMetadescricao"><strong>(*)Meta Descrição:</strong></label><br>
						<textarea name="usrMetadescricao" id="usrMetadescricao" tabindex="7" cols="50" rows="2" placeholder="Digite uma descrição resumida para o usuário." required></textarea>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrPalavraschave"><strong>(*)Palavras Chave:</strong></label><br>
						<textarea name="usrPalavraschave" id="usrPalavraschave" tabindex="8" cols="50" rows="2" placeholder="Digite palavras separadas por virgulas." required></textarea>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrSenha1"><strong>(*) Senha:</strong></label><br>
						<input type="password" name="usrSenha1" id="usrSenha1" tabindex="9" maxlength="32" placeholder="Digite uma senha para efetuar login no site." required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrSenha2"><strong>(*) Confirme a senha:</strong></label><br>
						<input type="password" name="usrSenha2" id="usrSenha2" tabindex="10" maxlength="32" placeholder="Confirme a senha para efetuar login no site." required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<input type="submit" name="cadastrar" tabindex="13"  value="   Cadastrar usuário >>   ">
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
