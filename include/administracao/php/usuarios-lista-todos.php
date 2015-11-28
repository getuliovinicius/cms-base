<div class="tableBox">
			<table>
				<tr>
					<th>ID</th>
					<th>Nome</th>
					<th>Login</th>
					<th>E-mail</th>
					<th>Ativo</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
				</tr>
<?php
foreach ($usrDados as $chave => $valor) {
?>
				<tr>
					<td><?php echo $valor['usrId']; ?></td>
					<td><?php echo $valor['usrNome']; ?></td>
					<td><?php echo $valor['usrLogin']; ?></td>
					<td><?php echo $valor['usrEmail']; ?></td>
					<td><?php echo $valor['usrAtivo']; ?></td>
					<td><a href="/cms-base/administracao/usuario-editar/<?php echo $valor['usrId']; ?>" title="Editar dados"><img src="/cms-base/imagens/administracao/icones/usuario-editar.png" alt="Editar dados"></a></td>
					<td>
<?php
if ($valor['usrRoot'] != 's') {
?>
					<a href="/cms-base/administracao/usuario-permissao/<?php echo $valor['usrId']; ?>" title="Editar permissões"><img src="/cms-base/imagens/administracao/icones/usuario-permissao.png" alt="Editar permissões"></a>
<?php
}
?>
					</td>
				</tr>
<?php
}
?>
			</table>
			</div>