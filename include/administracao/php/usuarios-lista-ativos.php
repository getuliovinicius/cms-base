<div class="tableBox">
			<table>
				<tr>
					<th>Id</th>
					<th>Nome</th>
					<th>E-mail</th>
				</tr>
<?php
foreach ($usrDados as $chave => $valor) {
?>
				<tr>
					<td><?php echo $valor['usrId']; ?></td>
					<td><?php echo $valor['usrNome']; ?></td>
					<td><?php echo $valor['usrEmail']; ?></td>
				</tr>
<?php
}
?>
			</table>
			</div>