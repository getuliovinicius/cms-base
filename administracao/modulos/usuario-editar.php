<?php
// VERIFICA A PERMISSAO DE ACESSO ############################################################

if (in_array(6, $sessaoPermissoes) and isset($modulo['paginaId'])) {
	$usrId = $modulo['paginaId'];
} else if (!in_array(6, $sessaoPermissoes) and isset($modulo['paginaId']) and $modulo['paginaId'] == $sessaoId) {
	$usrId = $sessaoId;
} else if (!isset($modulo['paginaId'])) {
	$usrId = $sessaoId;
} else {
	// retorna mensagem de erro
	setcookie('msgErro[privilegio]', 'Acesso restrito a usuários com permissão.', time() + 10, '/administracao/usuarios');
	header('Location: /administracao/usuarios');
	exit;
}


// ###########################################################################################

// VERIFICA A EXISTENCIA DO USUARIO ##########################################################

$sqlUsuario = "
SELECT usrId, usrEmail, usrNome, usrLogin, usrApelido, usrFoto, usrDescricao, usrMetadescricao, usrPalavraschave, usrAtivo, usrRoot
FROM usuarios
WHERE usrId = " . $usrId . "
";
require_once '../classes/sql-funcoes.php';
$sqlFuncoes = new sqlFuncoes();
$sqlFuncoes->setSql($sqlUsuario);
$usrDados = $sqlFuncoes->listaRegistros(true);
if (empty($usrDados)) {
	setcookie('msgErro[usrId]', 'Registro do usuário não encontrado.', time() + 10, '/administracao/usuarios');
	header('Location: /administracao/usuarios');
	exit;
}
unset($sqlFuncoes);

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
<title><?php echo $siteTitulo; ?> - Administração | Editar usuário</title>
<!-- InstanceEndEditable -->
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" type="text/css" media="screen" href="/administracao/css/estilo.css"/>
<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript" src="/js/administracao/menu-modulos.js"></script>
<script type="text/javascript" src="/js/administracao/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	language : "pt",
	mode : "specific_textareas",
	editor_selector : "tinyMCE",
	theme : "advanced",
	plugins : "autolink,emotions,wordcount",
	theme_advanced_buttons1 : "undo,redo,separator,formatselect,separator,bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,separator,bullist,numlist,separator,outdent,indent,blockquote,separator,link,unlink,anchor,image,emotions,separator,code",
	theme_advanced_buttons2 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
});
</script>
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
				menuAcao('usuarios');
			</script>
			<!--<h2>Informações</h2>
			<p>Nesta edição a foto é independente do perfil, você pode ou não troca-la. As medidas devem ser preferencialmente: 102px de largura por 136px de altura.</p>
			<p>O campo apelido serve para criar possíveis links para o perfil do usuário, caso não seja preenchido, a primeira parte do nome será utilizada em seu lugar.</p>
			<p>O campo descrição do usuário serve exatamente para criar um perfil a ser exibido ou não no site de acordo com as preferências gerais definidas pelo administrador.</p>
			<p>Os campos meta descrição e palavras chave são importantes para facilitar a descoberta da página pelos sistemas de busca na internet. Também de acordo com as preferências gerais definidas pelo administrador.</p>
			<p>O campo edita postagens, define se o usuário será ou não editor do site, sendo assim seu perfil poderá ser exibido no site apenas se for editor, caso contrário não será exibido. Uma vez que o perfil seja definido como editor, não poderá ser desfeito.</p>
			<p><strong>Resta fazer:</strong></p>
			<p>Quando for possível editar a foto após o upload para que fique com a largura igual a 102px.</p>-->
			
			<!-- InstanceEndEditable -->
		</aside>
		<section id="conteudoAplicacao">
			<!-- InstanceBeginEditable name="conteudoAplicacao" -->
			<nav class="fontPequena">
				<p class="fontPequena"><a href="/administracao">Painel</a> &gt; <a href="/administracao/usuarios">Usuários</a> &gt; Editar usuário</p>
			</nav>
			<h1 class="destaqueAplicacao"><img src="/imagens/administracao/icones/usuario-editar.png" alt="Editar usuário" width="16" height="16" /> Editar dados do usu&aacute;rio "<?php echo $usrDados[2]; ?>"</h1>
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
			<h2>Foto</h2>
			<form name="usuario-editar-foto" id="usuario-editar-foto" action="/administracao/envio/usuario-editar-foto.php" method="post" enctype="multipart/form-data">
				<input name="usrId" type="hidden" value="<?php echo $usrDados[0]; ?>">
				<input name="usrFotoantiga" type="hidden" value="<?php echo $usrDados[5]; ?>">
				<input name="usrApelido" type="hidden" value="<?php echo $usrDados[4]; ?>">
				<div class="formLinhas">
					<p>
						<label for="usrFoto"><strong>Foto (jpg ou png):</strong></label><br>
						<img src="<?php echo $usrDados[5]; ?>" alt="Foto" width="102" height="136"><br>
						<input type="file" name="usrFoto" id="usrFoto" tabindex="1" required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<input type="submit" name="editar-foto" value=" Trocar foto >> " tabindex="2">
					</p>
				</div>
			</form>
			<h2>Outros Dados</h2>
			<form name="usuario-editar" id="usuario-editar" action="/administracao/envio/usuario-editar.php" method="post">
				<input name="usrId" type="hidden" value="<?php echo $usrDados[0]; ?>">
				<div class="formLinhas">
					<p>
						<label for="usrEmail"><strong>(*) E-mail:</strong></label><br>
						<input type="email" name="usrEmail" id="usrEmail" maxlength="45" tabindex="3" value="<?php echo $usrDados[1]; ?>" required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrNome"><strong>(*) Nome Completo:</strong></label><br>
						<input type="text" name="usrNome" id="usrNome" maxlength="45" tabindex="4" value="<?php echo $usrDados[2]; ?>" required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrLogin"><strong>(*) Usuário de login:</strong></label><br>
						<input type="text" name="usrLogin" id="usrLogin" maxlength="10" tabindex="5" value="<?php echo $usrDados[3]; ?>" required>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrApelido"><strong>Apelido:</strong></label><br>
						<input type="text" name="usrApelido" id="usrApelido" maxlength="45" tabindex="6" value="<?php echo $usrDados[4]; ?>" title="Opcional">
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrDescricao"><strong>(*)Descrição:</strong></label><br>
						<textarea name="usrDescricao" id="usrDescricao" cols="50" rows="15" tabindex="7" class="tinyMCE"><?php echo $usrDados[6]; ?></textarea>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrMetadescricao"><strong>(*)Meta Descrição:</strong></label><br>
						<textarea name="usrMetadescricao" id="usrMetadescricao" cols="50" rows="2" tabindex="8" required><?php echo $usrDados[7]; ?></textarea>
					</p>
				</div>
				<div class="formLinhas">
					<p>
						<label for="usrPalavraschave"><strong>(*)Palavras Chave:</strong></label><br>
						<textarea name="usrPalavraschave" id="usrPalavraschave" cols="50" rows="2" tabindex="9" required><?php echo $usrDados[8]; ?></textarea>
					</p>
				</div>
<?php
if ($sessaoId != $usrId) {
?>
				<div class="formLinhas">
					<fieldset>
					<legend><strong>(*) Ativo?</strong></legend>
<?php
switch ($usrDados[9]) {
    case "s":
?>
					<label>
						<input type="radio" name="usrAtivo" id="usrAtivo-sim" tabindex="13" value="s" checked required>Sim
					</label><br>
					<label>
						<input type="radio" name="usrAtivo" id="usrAtivo-nao" tabindex="14" value="n" required>Não
					</label>
<?php
		break;
    case "n":
?>	
					<label>
						<input type="radio" name="usrAtivo" id="usrAtivo-sim" tabindex="13" value="s" required>Sim
					</label><br>
					<label>
						<input type="radio" name="usrAtivo" id="usrAtivo-nao" tabindex="14" value="n" checked required>Não
					</label>
<?php
		break;
}
?>
					</fieldset>
				</div>
<?php
} else {
?>
				<input name="usrAtivo" type="hidden" value="s" />
<?php
}
?>
				<div class="formLinhas">
					<p>
						<input type="submit" name="editar" tabindex="15" value="  Salvar edição >>  ">
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
