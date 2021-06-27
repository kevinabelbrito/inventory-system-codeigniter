<style>
	table
	{
		margin: auto;
	}
	th, td
	{
		padding: 10px;
	}
</style>
<page backtop="20px" backbottom="20px" backleft="50px" backright="50px">
	<img src="<?= APPPATH ?>third_party/logotipo.png" width="100">
	<p style="text-align:right;">RIF: J-12345678-9</p>
	<p style="text-align:center"><h3>Orden de Salida</h3></p>
	<p style="text-align:right;">Fecha: <?= date("d/m/Y", strtotime($fecha_actual)) ?></p>
	<p><strong>Nº de orden:</strong> <?= $id ?></p>
	<p><strong>Documento:</strong> <?= $documento ?></p>
	<p><strong>Nombre/Razón Social:</strong> <?= $nombre ?></p>
	<p><strong>Fecha de Vencimiento:</strong> <?= date("d/m/Y", strtotime($fecha_vencimiento)) ?></p>
	<p>
		<strong>Status:</strong> 
		<?php if ($total_final == $abono) { ?>
			<span class="label label-success">Pagada</span>
		<?php }elseif($fecha_vencimiento < date("Y-m-d")){ ?>
			<span class="label label-danger">Vencida</span>
		<?php } else { ?>
			<span class="label label-warning">Deuda</span>
		<?php } ?>

	</p>
	<p style="text-align:center;"><strong>Especificaciones</strong></p>
	<?php $medicamentos = $this->orden_salida_model->cargar_productos_factura($id); ?>
	<table border="1">
		<tr>
			<th>Codigo</th>
			<th>Nombre</th>
			<th>Precio</th>
			<th>Cantidad</th>
			<th>Sub-total</th>
		</tr>
		<?php foreach ($medicamentos as $medic): ?>
		<tr>
			<td><?= $medic->codigo ?></td>
			<td><?= $medic->nombre ?></td>
			<td><?= number_format($medic->precio, 2, ",", ".") ?></td>
			<td><?= $medic->cantidad ?></td>
			<td><?= number_format($medic->sub_total, 2, ",", ".") ?></td>
		</tr>
		<?php endforeach ?>
	</table>
	<p style="text-align:right;">
		<h4>Total a Pagar: <?= number_format($total_final, 2, ",", ".") ?></h4>
		<strong>Abonado: <?= number_format($abono, 2, ",", ".") ?></strong>
		<br>
		<strong>Deuda: <?= number_format($total_final - $abono, 2, ",", ".") ?></strong>
	</p>
</page>