<!--Modal para agregar registros-->
<div class="modal fade" id="ModalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?= form_open('clientes/agregar', array('id' => 'clientesForm')) ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Agregar un nuevo cliente</h4>
			</div>
			<div class="modal-body bg-info">
				<div class="row">
					<div class="alert alert-danger" id="errors">
						<strong><span class="glyphicon glyphicon-remove-sign"></span> Han ocurrido varios errores de validación</strong>
						<div id="list_errors"></div>
					</div>
					<div class="alert alert-warning" id="warning">
						<strong><span class="glyphicon glyphicon-warning-sign"></span> ¡Ocurrio un Problema!</strong> No fue posible guardar el registro
					</div>
					<div class="alert alert-success" id="success">
						<strong><span class="glyphicon glyphicon-ok-sign"></span> ¡Excelente!</strong> El cliente ha sido agregado con éxito
					</div>
					<div class="alert alert-info" id="server">
						<strong><span class="glyphicon glyphicon-exclamation-sign"></span> ¡Error de conexión!</strong> No fue posible la comunicación con el servidor
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Cedula/RIF', 'documento') ?>
					</div>
					<div class="col-xs-6">
						<?= form_input('documento', '', array('id' => 'documento', 'maxlength' => 10)) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Nombre/Razón Social', 'nombre') ?>
					</div>
					<div class="col-xs-6">
						<?= form_input('nombre', '', array('id' => 'nombre', 'maxlength' => 100)) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Teléfono', 'tlf') ?>
					</div>
					<div class="col-xs-6">
						<?= form_input('tlf', '', array('id' => 'tlf', 'maxlength' => 11)) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Correo Electrónico', 'email') ?>
					</div>
					<div class="col-xs-6">
						<?= form_input('email', '', array('id' => 'email')) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Dirección', 'direccion') ?>
					</div>
					<div class="col-xs-6">
						<?= form_input('direccion', '', array('id' => 'direccion')) ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<?= form_submit('agregar', 'Agregar', array('class' => 'button')) ?>
				<button type="button" class="button" data-dismiss="modal">Cerrar</button>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>
<script>
	$(function(){
		//Mensajes de Error
		recargar();
		//Acciones del Formulario
		$("#clientesForm").submit(function(){
			var datosForm = $("#clientesForm").serialize();
			$.post("<?= base_url() ?>clientes/agregar", datosForm, procesar).error(procesarError);
			return false;
		});
		function procesar(data)
		{
			if (data == "guardo")
			{
				recargar();
				//Solo para orden de salida
				documento = $("#documento").val();
				$("#documento_validar").val(documento);
				$("#success").show(400).delay(4000).hide(400);
				jQuery.fn.reset = function(){
                    $(this).each(function(){ this.reset(); });
                }
                $("#clientesForm").reset();
                $("#documento").focus();
			}
			else
			{
				recargar();
				$("#list_errors").html(data);
				$("#errors").show(400).delay(5000).hide(400);
			}
		}
		function procesarError()
		{
			recargar();
			$("#server").show(400).delay(4000).hide(400);
		}
		function recargar() {
			$("#errors").hide();
			$("#warning").hide();
			$("#success").hide();
			$("#server").hide();
		}
	});
</script>