<div class="modal fade" id="ModalClave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?= form_open('admin/cambio_clave', array('id' => 'claveForm')) ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Cambio de Contraseña</h4>
			</div>
			<div class="modal-body bg-warning">
				<div class="row">
					<div class="alert alert-danger" id="errorsClave">
						<strong><span class="glyphicon glyphicon-remove-sign"></span> Han ocurrido varios errores de validación</strong>
						<div id="list_errorsClave"></div>
					</div>
					<div class="alert alert-warning" id="warningClave">
						<strong><span class="glyphicon glyphicon-warning-sign"></span> ¡Ocurrio un Problema!</strong> No fue posible cambiar la contraseña
					</div>
					<div class="alert alert-success" id="successClave">
						<strong><span class="glyphicon glyphicon-ok-sign"></span> ¡Excelente!</strong> La contraseña fue cambiada con exito
					</div>
					<div class="alert alert-info" id="serverClave">
						<strong><span class="glyphicon glyphicon-exclamation-sign"></span> ¡Error de conexión!</strong> No fue posible la comunicación con el servidor
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Contraseña actual', 'actual') ?>
					</div>
					<div class="col-xs-6">
						<?= form_password('actual', '', array('id' => 'actual', 'maxlength' => 30)) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Nueva Contraseña', 'nueva') ?>
					</div>
					<div class="col-xs-6">
						<?= form_password('nueva', '', array('id' => 'nueva', 'maxlength' => 30)) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Confirmar Contraseña', 'conf') ?>
					</div>
					<div class="col-xs-6">
						<?= form_password('conf', '', array('id' => 'conf', 'maxlength' => 30)) ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<?= form_submit('cambiar', 'Cambiar Contraseña', array('class' => 'button')) ?>
				<button type="button" class="button" data-dismiss="modal">Cerrar</button>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>
<script>
	$(function(){
		//Eventos del modal
		$('#ModalClave').on('hidden.bs.modal', function (e) {
	  		jQuery.fn.reset = function(){
                $(this).each(function(){ this.reset(); });
            }
            $("#claveForm").reset();
		});
		//Mensajes de Error
		$("#errorsClave").hide();
		$("#warningClave").hide();
		$("#successClave").hide();
		$("#serverClave").hide();
		//Acciones del Formulario
		$("#claveForm").submit(function(){
			var datosForm = $("#claveForm").serialize();
			$.post("<?= base_url() ?>admin/cambio_clave", datosForm, procesar).error(procesarError);
			return false;
		});
		function procesar(data)
		{
			if (data == "bien")
			{
				$("#successClave").show(400).delay(4000).hide(400);
				jQuery.fn.reset = function(){
                    $(this).each(function(){ this.reset(); });
                }
                $("#claveForm").reset();
                $("#actual").focus();
			}
			else
			{
				$("#list_errorsClave").html(data);
				$("#errorsClave").show(400).delay(5000).hide(400);
			}
		}
		function procesarError()
		{
			$("#serverClave").show(400).delay(4000).hide(400);
		}
	});
</script>