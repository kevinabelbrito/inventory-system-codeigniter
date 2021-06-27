<div class="content-layout">
	<div class="content-layout-row">
		<div class="layout-cell" style="width: 100%" >
	        <p style="text-align: right;">
	        	<a href="<?= base_url() ?>orden_salida/" class="button"><span class="glyphicon glyphicon-shopping-cart"></span> Orden de Salida</a>
		        <a href="<?= base_url() ?>admin" class="button"><span class="glyphicon glyphicon-menu-hamburger"></span> Menú</a>
	        </p>
	    </div>
	</div>
</div>
<div class="content-layout">
    <div class="content-layout-row">
	    <div class="layout-cell" style="width: 100%; padding: 10px;" >
	        <div class="row">
	        	<div class="col-md-6 col-sm-12">
	        		<div class="panel panel-primary" id="datos_cliente">
						<div class="panel-heading">Datos del cliente</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-xs-6"><strong>Cedula/RIF</strong></div>
								<div class="col-xs-6"><?= $documento ?></div>
							</div>
							<div class="row">
								<div class="col-xs-6"><strong>Nombre/Razon Social</strong></div>
								<div class="col-xs-6"><?= $nombre ?></div>
							</div>
							<div class="row">
								<div class="col-xs-6"><strong>Monto Total</strong></div>
								<div class="col-xs-6"><?= number_format($total_final, 2, ",", ".") ?></div>
							</div>
							<div class="row">
								<div class="col-xs-6"><strong>Abonado</strong></div>
								<div class="col-xs-6"><?= number_format($abono, 2, ",", ".") ?></div>
							</div>
							<div class="row">
								<div class="col-xs-6"><strong>Deuda</strong></div>
								<div class="col-xs-6"><?= number_format($total_final - $abono, 2, ",", ".") ?></div>
							</div>
							<div class="row">
								<div class="col-xs-6"><strong>Fecha de emisión</strong></div>
								<div class="col-xs-6"><?= date("d/m/Y", strtotime($fecha_actual)) ?></div>
							</div>
							<div class="row">
								<div class="col-xs-6"><strong>Fecha de Vencimiento</strong></div>
								<div class="col-xs-6"><?= date("d/m/Y", strtotime($fecha_vencimiento)) ?></div>
							</div>
							<div class="row">
								<div class="col-xs-6"><strong>Status</strong></div>
								<div class="col-xs-6">
									<?php if ($total_final == $abono) { ?>
										<span class="label label-success">Pagada</span>
									<?php }elseif($fecha_vencimiento < date("Y-m-d")){ ?>
										<span class="label label-danger">Vencida</span>
									<?php } else { ?>
										<span class="label label-warning">Deuda</span>
									<?php } ?>
								</div>
							</div>
							<br><br>
							<div class="row text-center">
					    		<a href="<?= base_url() ?>orden_salida/imprimir_factura/<?= $id ?>" class="button" target="_blank"><span class="glyphicon glyphicon-print"></span> Imprimir Orden de Salida</a>
					    	</div>
						</div>
			    	</div>
	        	</div>
	        	<div class="col-md-6 col-sm-12">
	        		<div class="panel panel-primary">
						<div class="panel-heading">Abonos realizados</div>
						<div class="panel-body">
							<?php $abonos = $this->orden_salida_model->cargar_abonos_factura($id); ?>
							<table class="table">
								<tr>
									<th>Fecha</th>
									<th>Monto</th>
								</tr>
								<?php foreach ($abonos as $abono): ?>
								<tr>
									<td><?= date("d/m/Y", strtotime($abono->fecha)) ?></td>
									<td><?= number_format($abono->monto, 2, ",", ".") ?></td>
								</tr>
								<?php endforeach ?>
							</table>
							<br>
							<div class="row text-center">
								<a class="button" data-toggle="modal" data-target="#ModalAbono">Abonar</a>
							</div>
							<!--Modal Abonar-->
							<?php
							$data = array(
								'id_factura' => $id,
								'fecha_actual' => $fecha_actual,
								);
							$this->load->view('orden_salida/abonar_view', $data);
							?>
						</div>
					</div>
	        	</div>
	        </div>
	        <div class="row">
	        	<div class="col-xs-12">
	        		<div class="panel panel-primary">
						<div class="panel-heading">Productos despachados</div>
						<div class="panel-body">
							<?php $medicamentos = $this->orden_salida_model->cargar_productos_factura($id); ?>
							<div class="table-responsive">
								<table class="table">
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
							</div>
						</div>
					</div>
	        	</div>
	        </div>
	    </div>
    </div>
</div>