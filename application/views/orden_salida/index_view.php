<div class="content-layout">
    <div class="content-layout-row">
	    <div class="layout-cell" style="width: 40%" >
	        <?= form_open('orden_salida/', array('id' => 'busquedaForm', 'method' => 'get')) ?>
			<?= form_label('Busqueda', 'campo') ?>
			<input type="date" name="campo" id="campo" placeholder="YY/mm/dd" value="<?= $campo ?>">
			<?= form_submit('buscar', 'Buscar', array('class' => 'button')) ?>
			<?= form_close() ?>
	    </div>
	    <div class="layout-cell" style="width: 60%" >
	        <p style="text-align: right;">
	        	<a href="<?= base_url() ?>orden_salida/nueva" class="button"><span class="glyphicon glyphicon-plus-sign"></span> Nueva Orden de Salida</a>
		        <a href="<?= base_url() ?>admin" class="button"><span class="glyphicon glyphicon-menu-hamburger"></span> Menú</a>
	        </p>
	    </div>
    </div>
</div>
<div class="content-layout">
    <div class="content-layout-row">
	    <div class="layout-cell" style="width: 100%" >
	        <?php if($num_facturas > 0){ ?>
			<br>
			<div class="table-responsive">
			<table style="margin: auto;">
				<tr>
					<th style="min-width: 200px;">Documento de Identidad</th>
					<th style="min-width: 200px;">Nombre/Razón Social</th>
					<th style="min-width: 100px;">Monto total</th>
					<th>Abonado</th>
					<th>Deuda</th>
					<th>Fecha</th>
					<th>Vencimiento</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
				<?php foreach ($facturas as $fac): ?>
				<tr>
					<td><?= $fac->documento ?></td>
					<td><?= $fac->nombre ?></td>
					<td><?= number_format($fac->total_final, 2, ",", ".") ?></td>
					<td><?= number_format($fac->abono, 2, ",", ".") ?></td>
					<td><?= number_format($fac->total_final - $fac->abono, 2, ",", ".") ?></td>
					<td><?= date("d/m/Y", strtotime($fac->fecha_actual)) ?></td>
					<td><?= date("d/m/Y", strtotime($fac->fecha_vencimiento)) ?></td>
					<td>
						<?php if ($fac->total_final == $fac->abono) { ?>
							<span class="label label-success">Pagada</span>
						<?php }elseif($fac->fecha_vencimiento < date("Y-m-d")){ ?>
							<span class="label label-danger">Vencida</span>
						<?php } else { ?>
							<span class="label label-warning">Deuda</span>
						<?php } ?>
					</td>
					<td style="min-width: 150px; text-align: center;">
						<a href="<?= base_url() ?>orden_salida/detalles/<?= $fac->id ?>" class="button" title="Detalles"><span class="glyphicon glyphicon-list-alt"></a>
						<?php if($this->session->userdata('tipo') == "Administrador"): ?>
						<a href="#" class="button" title="Eliminar" data-toggle="modal" data-target="#ModalEliminar<?= $fac->id ?>"><span class="glyphicon glyphicon-remove"></a>
						<?php endif ?>
					</td>
				</tr>				
				<!--Modal Eliminar-->
				<?php
				$data = array('id' => $fac->id);
				$this->load->view('orden_salida/eliminar_view', $data);
				?>
				<?php endforeach ?>
			</table>
			</div>
			<?= $pagination ?>
			<?php } else { ?>
			<div class="alert alert-info">
				<h2 class="text-center">No se encontraron facturas</h2>
			</div>
			<?php } ?>
	    </div>
    </div>
</div>