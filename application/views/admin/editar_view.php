<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?= form_open('admin/editar', array('id' => 'userForm')) ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Editar mis datos de usuario</h4>
			</div>
			<div class="modal-body bg-info">
				<div class="row">
					<div class="alert alert-danger" id="errors">
						<strong><span class="glyphicon glyphicon-remove-sign"></span> Han ocurrido varios errores de validación</strong>
						<div id="list_errors"></div>
					</div>
					<div class="alert alert-warning" id="warning">
						<strong><span class="glyphicon glyphicon-warning-sign"></span> ¡Ocurrio un Problema!</strong> No fue posible guardar los cambios
					</div>
					<div class="alert alert-success" id="success">
						<strong><span class="glyphicon glyphicon-ok-sign"></span> ¡Excelente!</strong> Los cambios han sido guardados con éxito
					</div>
					<div class="alert alert-info" id="server">
						<strong><span class="glyphicon glyphicon-exclamation-sign"></span> ¡Error de conexión!</strong> No fue posible la comunicación con el servidor
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Nombre Completo', 'nombre') ?>
					</div>
					<div class="col-xs-6">
						<?= form_input('nombre', $this->session->userdata('nombre'), array('id' => 'nombre', 'maxlength' => 100)) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Cedula de Identidad', 'cedula') ?>
					</div>
					<div class="col-xs-6">
						<?= form_input('cedula', $this->session->userdata('cedula'), array('id' => 'cedula', 'maxlength' => 10)) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Correo Electrónico', 'email') ?>
					</div>
					<div class="col-xs-6">
						<?= form_input('email', $this->session->userdata('email'), array('id' => 'email', 'maxlength' => 100)) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Usuario', 'username') ?>
					</div>
					<div class="col-xs-6">
						<?= form_input('username', $this->session->userdata('username'), array('id' => 'username', 'maxlength' => 50)) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Pregunta de Seguridad', 'preg') ?>
					</div>
					<div class="col-xs-6">
						<?= form_dropdown('preg', $preguntas, $this->session->userdata('preg'), array('id' => 'preg')) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Respuesta secreta', 'respuesta') ?>
					</div>
					<div class="col-xs-6">
						<?= form_input('respuesta', $this->session->userdata('resp'), array('id' => 'respuesta')) ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<?= form_submit('editar', 'Guardar Cambios', array('class' => 'button')) ?>
				<button type="button" class="button" data-dismiss="modal">Cerrar</button>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>
<script>
	$(function(){
		//Eventos del modal
		$('#ModalEditar').on('hidden.bs.modal', function (e) {
		  window.location="<?= base_url() ?>admin";
		});
		//Mensajes de Error
		$("#errors").hide();
		$("#warning").hide();
		$("#success").hide();
		$("#server").hide();
		//Acciones del Formulario
		$("#userForm").submit(function(){
			var datosForm = $("#userForm").serialize();
			$.post("<?= base_url() ?>admin/editar", datosForm, procesar).error(procesarError);
			return false;
		});
		function procesar(data)
		{
			if (data == "guardo")
			{
				$("#success").show(400).delay(4000).hide(400);
			}
			else
			{
				$("#list_errors").html(data);
				$("#errors").show(400).delay(5000).hide(400);
				jQuery.fn.reset = function(){
                    $(this).each(function(){ this.reset(); });
                }
                $("#userForm").reset();
			}
		}
		function procesarError()
		{
			$("#server").show(400).delay(4000).hide(400);
		}
	});
</script>