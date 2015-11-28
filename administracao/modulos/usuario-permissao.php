<?php
// VERIFICA A PERMISSAO DE ACESSO ############################################################

if (!in_array(5, $sessaoPermissoes)) {
	// retorna mensagem de erro
	setcookie('msgErro[privilegio]', 'Acesso restrito a usuários com permissão.', time() + 10, '/cms-base/administracao/usuarios');
	header('Location: /cms-base/administracao/usuarios');
	exit;
}

// ###########################################################################################

// VERIFICA A EXISTENCIA DO USUARIO ##########################################################

$usrId = $modulo['paginaId'];
$sqlUsuario = "
SELECT usrLogin
FROM usuarios
WHERE usrId = " . $usrId . "
AND	usrRoot = 'n';
";
require_once '../classes/sql-funcoes.php';
$sqlFuncoes = new sqlFuncoes();
$sqlFuncoes->setSql($sqlUsuario);
$usrDados = $sqlFuncoes->listaRegistros(true);
if (empty($usrDados)) {
	setcookie('msgErro[usrId]', 'Registro do usuário não encontrado.', time() + 10, '/cms-base/administracao/usuarios');
	header('Location: /cms-base/administracao/usuarios');
	exit;
}
unset($sqlFuncoes);

// ###########################################################################################

// SETA AS PERMISSOES DO USUARIO #############################################################

// gera lista de permissoes atuais
$sql = "
SELECT acaoId
FROM modulos_permissao
WHERE usrId =" . $usrId . "
ORDER BY moduloId, acaoId;
";
$sqlFuncoes = new sqlFuncoes();
$sqlFuncoes->setSql($sql);
$permissoes = $sqlFuncoes->listaRegistros();
unset($sqlFuncoes);
$permissoesAtuais = array();
for ($p = 0; $p < count($permissoes); $p++) {
	$permissoesAtuais[] = $permissoes[$p]['acaoId'];
}

// gera lista de todas as permissoes possiveis para o usuario
$sql = "
SELECT ma.moduloId, m.moduloDescricao, ma.acaoId, ma.acaoDescricao, ma.acaoPagina, ma.acaoIndex
FROM modulos_acao AS ma
INNER JOIN modulos AS m ON ma.moduloId = m.moduloId
AND ma.acaoRestrita = 's'
AND	ma.usrRoot = 'n'
ORDER BY ma.moduloId, ma.acaoId ASC;
";
$sqlFuncoes = new sqlFuncoes();
$sqlFuncoes->setSql($sql);
$permissoes = $sqlFuncoes->listaRegistros();
unset($sqlFuncoes);
$permissoesPossiveis = array();
for ($p = 0; $p < count($permissoes); $p++) {
	if ($permissoes[$p]['acaoIndex'] == "s") {
		$permissoesPossiveis[$permissoes[$p]['moduloId']]['moduloId'] = $permissoes[$p]['moduloId'];
		$permissoesPossiveis[$permissoes[$p]['moduloId']]['acaoId'] = $permissoes[$p]['acaoId'];
		$permissoesPossiveis[$permissoes[$p]['moduloId']]['acaoDescricao'] = $permissoes[$p]['acaoDescricao'];
		$permissoesPossiveis[$permissoes[$p]['moduloId']]['acaoPagina'] = $permissoes[$p]['acaoPagina'];
	} elseif ($permissoes[$p]['acaoIndex'] == "n") {
		$permissoesPossiveis[$permissoes[$p]['moduloId']]['moduloAcoes'][$permissoes[$p]['acaoId']]['moduloId'] = $permissoes[$p]['moduloId'];
		$permissoesPossiveis[$permissoes[$p]['moduloId']]['moduloAcoes'][$permissoes[$p]['acaoId']]['acaoId'] = $permissoes[$p]['acaoId'];
		$permissoesPossiveis[$permissoes[$p]['moduloId']]['moduloAcoes'][$permissoes[$p]['acaoId']]['acaoDescricao'] = $permissoes[$p]['acaoDescricao'];
		$permissoesPossiveis[$permissoes[$p]['moduloId']]['moduloAcoes'][$permissoes[$p]['acaoId']]['acaoPagina'] = $permissoes[$p]['acaoPagina'];
	}
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
<title><?php echo $siteTitulo; ?> - Administração | Permissoes do usuário</title>
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
				<p><a href="/cms-base/administracao">Painel</a> &gt; <a href="/cms-base/administracao/usuarios">Usuários</a> &gt; Permissões do usuário</p>
			</nav>
			<h1><img src="/cms-base/imagens/administracao/icones/usuario-permissao.png" alt="Permissoes do usuário" width="16" height="16"> Permissões do usuário "<?php echo $usrDados[0]; ?>"</h1>
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
			<form name="usuario-permissao" id="usuario-permissao" action="/cms-base/administracao/envio/usuario-permissao.php" method="post">
				<input type="hidden" name="usrId" id="usrId" value="<?php echo $usrId; ?>">
<?php
foreach ($permissoesPossiveis as $chave => $permissao) {
?>
				<div class="formLinhas">
					<fieldset>
						<legend><?php echo $permissao['acaoDescricao']; ?></legend>
						<label>
<?php
	if (in_array($permissao['acaoId'], $permissoesAtuais)) {
?>
							<input type="checkbox" name="<?php echo $permissao['acaoPagina']; ?>" id="<?php echo $permissao['acaoPagina']; ?>" value="<?php echo $permissao['acaoId']; ?>" checked>Abrir
<?php
	} else {
?>
							<input type="checkbox" name="<?php echo $permissao['acaoPagina']; ?>" id="<?php echo $permissao['acaoPagina']; ?>" value="<?php echo $permissao['acaoId']; ?>">Abrir
<?php
	}
?>
						</label>
						<br>
<?php
	if (array_key_exists("moduloAcoes", $permissao)) {
		foreach ($permissao['moduloAcoes'] as $chave => $acao) {
?>
						<label>
<?php
			if (in_array($acao['acaoId'], $permissoesAtuais)) {
?>
							<input type="checkbox" name="<?php echo $acao['acaoPagina']; ?>" id="<?php echo $acao['acaoPagina']; ?>" value="<?php echo $acao['acaoId']; ?>" checked><?php echo $acao['acaoDescricao']; ?>
<?php
			} else {
?>
							<input type="checkbox" name="<?php echo $acao['acaoPagina']; ?>" id="<?php echo $acao['acaoPagina']; ?>" value="<?php echo $acao['acaoId']; ?>"><?php echo $acao['acaoDescricao']; ?>
<?php
			}
?>
						</label>
						<br>
<?php
		}
	}
?>
					</fieldset>
				</div>
<?php
}
?>
				<div class="formLinhas">
					<p>
						<input type="submit" name="permissao" value="   Editar permissões >>   ">
					</p>
				</div>
			</form>
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
