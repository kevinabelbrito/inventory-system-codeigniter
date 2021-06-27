<div class="content-layout">
    <div class="content-layout-row">
		<div class="layout-cell" style="width: 100%" >
		    <p style="text-align: right;">
		    	<a href="<?= base_url() ?>orden_salida" class="button"><span class="glyphicon glyphicon-shopping-cart"></span> Orden de Salida</a>
		        <a href="<?= base_url() ?>admin" class="button"><span class="glyphicon glyphicon-menu-hamburger"></span> Menú</a>
		    </p>
		</div>
	</div>
</div>
<div class="content-layout">
    <div class="content-layout-row">
	    <div class="layout-cell" style="width: 100%; padding:10px;" >
	        <div class="row">
	        	<div class="col-md-6 col-sm-12">
	        		<div class="panel panel-primary">
						<div class="panel-heading">Información del Cliente</div>
						<div class="panel-body">
							<div class="row">
								<div class="alert alert-danger" id="errorsValidar">
									<strong><span class="glyphicon glyphicon-remove-sign"></span> Han ocurrido varios errores de validación</strong>
									<div id="list_errorsValidar"></div>
								</div>
								<div class="alert alert-warning" id="warningValidar">
									<strong><span class="glyphicon glyphicon-warning-sign"></span> ¡Ocurrio un Problema!</strong> No fue posible validar el cliente
								</div>
								<div class="alert alert-success" id="successValidar">
									<strong><span class="glyphicon glyphicon-ok-sign"></span> ¡Excelente!</strong> El cliente ha sido validado con éxito
								</div>
								<div class="alert alert-info" id="serverValidar">
									<strong><span class="glyphicon glyphicon-exclamation-sign"></span> ¡Error de conexión!</strong> No fue posible la comunicación con el servidor
								</div>
							</div>
							<?= form_open('orden_salida', array('id' => 'validarForm', 'method' => 'get')) ?>
							<div class="form-group">
								<?= form_label('Cliente', 'documento_validar') ?>
								<?php //form_input('documento', '', array('id' => 'documento_validar', 'maxlength' => 10)) ?>
								<?= form_dropdown(
									'documento',
									$clientes,
									'',
									array(
										'id' => 'documento_validar',
										'class' => 'select2'
									)
								) ?>
							</div>
							<div class="form-group">
								<?= form_submit('validad', 'Validar', array('class' => 'button')) ?>
								<a href="#" class="button" data-toggle="modal" data-target="#ModalAgregar"><span class="glyphicon glyphicon-plus-sign"></span> Agregar Cliente</a>
							</div>
							<?= form_close() ?>
							<br>
							<table class="table" id="datos_cliente">
								<tr>
									<td><strong>Nombre/Razón Social</strong></td>
									<td><div id="nombre"></div></td>
								</tr>
								<tr>
									<td><strong>Teléfono</strong></td>
									<td><div id="tlf"></div></td>
								</tr>
								<tr>
									<td><strong>Correo Electrónico</strong></td>
									<td><div id="email"></div></td>
								</tr>
								<tr>
									<td><strong>Dirección</strong></td>
									<td style="max-width:180px;"><div id="direccion"></div></td>
								</tr>
							</table>
						</div>
				    </div>
	        	</div>
	        	<div class="col-md-6 col-sm-12">
	        		<div class="panel panel-primary">
						<div class="panel-heading">Información del Producto</div>
						<div class="panel-body">
							<!--Errores para formulario de validar medicamento-->
				    		<div class="row">
				    			<div class="alert alert-danger" id="errorsValidarMedic">
									<strong><span class="glyphicon glyphicon-remove-sign"></span> Han ocurrido varios errores de validación</strong>
									<div id="list_errorsValidarMedic"></div>
								</div>
								<div class="alert alert-warning" id="warningValidarMedic">
									<strong><span class="glyphicon glyphicon-warning-sign"></span> ¡Ocurrio un Problema!</strong> No fue posible validar el medicamento
								</div>
								<div class="alert alert-success" id="successValidarMedic">
									<strong><span class="glyphicon glyphicon-ok-sign"></span> ¡Excelente!</strong> El medicamento fue cargado con éxito
								</div>
								<div class="alert alert-info" id="serverValidarMedic">
									<strong><span class="glyphicon glyphicon-exclamation-sign"></span> ¡Error de conexión!</strong> No fue posible la comunicación con el servidor
								</div>
				    		</div>
				    		<!--Errores para formulario de agregar medicamento-->
				    		<div class="row">
				    			<div class="alert alert-danger" id="errorsAgregarMedic">
									<strong><span class="glyphicon glyphicon-remove-sign"></span> Han ocurrido varios errores de validación</strong>
									<div id="list_errorsAgregarMedic"></div>
								</div>
								<div class="alert alert-warning" id="warningAgregarMedic">
									<strong><span class="glyphicon glyphicon-warning-sign"></span> ¡Ocurrio un Problema!</strong> No fue posible agregar el medicamento
								</div>
								<div class="alert alert-success" id="successAgregarMedic">
									<strong><span class="glyphicon glyphicon-ok-sign"></span> ¡Excelente!</strong> El medicamento fue agregado a la lista con éxito
								</div>
								<div class="alert alert-info" id="serverAgregarMedic">
									<strong><span class="glyphicon glyphicon-exclamation-sign"></span> ¡Error de conexión!</strong> No fue posible la comunicación con el servidor
								</div>
				    		</div>
				    		<!--Formulario para Validar medicamento-->
				    		<?= form_open('orden_salida', array('id' => 'MedicSearchForm')) ?>
				    		<div class="form-group">
				    			<?= form_label('Código o Nombre del producto', 'codigo') ?>
				    			<?php //form_input('codigo', '', array('id' => 'codigo')) ?>
				    			<?= form_dropdown(
									'codigo',
									$productos,
									'',
									array(
										'id' => 'codigo',
										'class' => 'select2'
									)
								) ?>
				    		</div>
				    		<div class="form-group">
				    			<?= form_submit('cargar', 'Buscar', array('class' => 'button')) ?>
				    		</div>
				    		<?= form_close() ?>
				    		<br>
				    		<div id="datos_medicamento">
				    		<!--Formulario de agregar medicamentos-->
				    		<?= form_open('orden_salida/', array('id' => 'MedicForm')) ?>
				    		<table class="table">
				    			<tr>
				    				<td><?= form_label('Nombre') ?></td>
				    				<td>
				    					<div id="nombre_medic"></div>
				    					<input type="hidden" name="nombre" id="nombre_m">
				    				</td>
				    			</tr>
				    			<tr>
				    				<td><?= form_label('Precio') ?></td>
				    				<td>
				    					<div id="precio_medic"></div>
			    						<input type="hidden" name="precio" id="precio">
				    				</td>
				    			</tr>
				    			<tr>
				    				<td><?= form_label('Cantidad', 'cantidad') ?></td>
				    				<td>
				    					<input type="number" name="cantidad" id="cantidad" value="0" disabled="true" min="0">
				    				</td>
				    			</tr>
				    			<tr>
				    				<td><?= form_label('Precio Total') ?></td>
				    				<td><div id="total_medic">0</div></td>
				    			</tr>
				    		</table>
				    		<div class="text-center">
				    			<input type="hidden" name="codigo" id="codigo_m">
				    			<input type="hidden" name="id_medicamento" id="id_medic">
				    			<?= form_submit('agregar', 'Agregar', array('class' => 'button')) ?>
				    		</div>
				    		<?= form_close() ?>
				    		</div>
						</div>
					</div>
	        	</div>
	        </div>
	        <div class="row">
	        	<div class="col-xs-12" id="facturacion_info">
	        		<div class="panel panel-primary" id="medicamentos">
						<div class="panel-heading">Productos a facturar</div>
						<div class="panel-body" id="productos"></div>
				    </div>
	        	</div>
	        </div>
	        <div class="row">
	        	<div class="col-xs-12">
	        		<div class="panel panel-primary">
						<div class="panel-heading">Información de la Orden de Salida</div>
						<div class="panel-body">
				    		<div class="row">
								<div class="alert alert-danger" id="errorsFacturar">
									<strong><span class="glyphicon glyphicon-remove-sign"></span> Han ocurrido varios errores de validación</strong>
									<div id="list_errorsFacturar"></div>
								</div>
								<div class="alert alert-warning" id="warningFacturar">
									<strong><span class="glyphicon glyphicon-warning-sign"></span> ¡Ocurrio un Problema!</strong> No se puede crear una factura sin productos a vender
								</div>
								<div class="alert alert-success" id="successFacturar">
									<strong><span class="glyphicon glyphicon-ok-sign"></span> ¡Excelente!</strong> La Factura fue creada con exito
								</div>
								<div class="alert alert-info" id="serverFacturar">
									<strong><span class="glyphicon glyphicon-exclamation-sign"></span> ¡Error de conexión!</strong> No fue posible la comunicación con el servidor
								</div>
							</div>
							<div class="row">
								<?= form_open('orden_salida', array('id' => 'facturaForm')) ?>
								<div class="col-md-4 col-sm-12">
									<?= form_label('Monto a Abonar', 'abono') ?>
									<?= form_input('abono', 0, array('id' => 'abono')) ?>
									<input type="hidden" name="total" id="monto_total">
								</div>
								<div class="col-md-4 col-sm-12">
									<?= form_label('Fecha de la Factura', 'fecha_actual') ?>
									<input type="date" name="fecha_actual" id="fecha_actual" value="<?= date("Y-m-d") ?>">
								</div>
								<div class="col-md-4 col-sm-12">
									<?= form_label('Fecha de Vencimiento', 'fecha_vencimiento') ?>
									<input type="date" name="fecha_vencimiento" id="fecha_vencimiento">
									<input type="hidden" name="id_cliente" id="id_cliente">
								</div>
								<div class="row text-center">
									<?= form_submit('agregar', 'Crear Orden de Salida', array('class' => 'button')) ?>
								</div>
								<?= form_close() ?>
							</div>
						</div>
					</div>
	        	</div>
	        </div>
	    </div>
    </div>
</div>
<!--Modal Agregar Cliente-->
<?php $this->load->view('clientes/agregar_view') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/select2/dist/css/select2.min.css') ?>">
<script src="<?= base_url('assets/plugins/select2/dist/js/select2.min.js') ?>"></script>
<script src="<?= base_url('assets/js/selector.js') ?>"></script>
<script src="<?= base_url() ?>assets/js/orden_salida/validacion_cliente.js"></script>
<script src="<?= base_url() ?>assets/js/orden_salida/validacion_medic.js"></script>
<script src="<?= base_url() ?>assets/js/orden_salida/agregar_medic.js"></script>
<script src="<?= base_url() ?>assets/js/orden_salida/validar_factura.js"></script>
<script>
	$(function () {
		//Cargamos la lista de productos a despachar
		$("#productos").load("<?= base_url() ?>orden_salida/listar_productos");
	})
</script>