<nav id="menuModulos">
				<ul>
<?php
foreach ($sessaoMenu as $chave => $modulo) {
?>				
					<li id="<?php echo $modulo['moduloPagina']; ?>">
							<a href="/administracao/<?php echo $modulo['moduloPagina']; ?>"><img src="/imagens/administracao/icones/<?php echo $modulo['moduloPagina'] . ".png";?>" alt="<?php echo $modulo['moduloDescricao']; ?>" width="16" height="16"> <?php echo $modulo['moduloDescricao']; ?></a>
<?php							
	if (array_key_exists("moduloAcoes",$modulo)) {
?>
						<nav id="menuAcao">
							<ul id="<?php echo $modulo['moduloPagina'] . "Acao"; ?>">
<?php
		foreach ($modulo['moduloAcoes'] as $chave => $acao) {
?>
							<li>
								<a href="/administracao/<?php echo $acao['acaoPagina']; ?>"><?php echo $acao['acaoDescricao']; ?></a>
							</li>
<?php
		}
?>
							</ul>
						</nav>
<?php
	}
?>
					</li>
<?php
}
?>
				</ul>
			</nav>