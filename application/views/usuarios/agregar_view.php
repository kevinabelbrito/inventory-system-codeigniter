<!--Modal para agregar registros-->
<div class="modal fade" id="ModalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?= form_open('usuarios/agregar', array('id' => 'userForm')) ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Agregar un nuevo usuario</h4>
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
						<strong><span class="glyphicon glyphicon-ok-sign"></span> ¡Excelente!</strong> El Usuario ha sido agregado con éxito
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
						<?= form_input('nombre', '', array('id' => 'nombre', 'maxlength' => 100)) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Cedula de Identidad', 'cedula') ?>
					</div>
					<div class="col-xs-6">
						<?= form_input('cedula', '', array('id' => 'cedula', 'maxlength' => 10)) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Correo Electrónico', 'email') ?>
					</div>
					<div class="col-xs-6">
						<?= form_input('email', '', array('id' => 'email', 'maxlength' => 100)) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Usuario', 'username') ?>
					</div>
					<div class="col-xs-6">
						<?= form_input('username', '', array('id' => 'username', 'maxlength' => 50)) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Tipo', 'tipo') ?>
					</div>
					<div class="col-xs-6">
						<?= form_dropdown('tipo', $tipos, '', array('id' => 'tipo')) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Contraseña', 'password') ?>
					</div>
					<div class="col-xs-6">
						<?= form_password('password', '', array('id' => 'password', 'maxlength' => 30)) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Confirmar', 'conf') ?>
					</div>
					<div class="col-xs-6">
						<?= form_password('conf', '', array('id' => 'conf', 'maxlength' => 30)) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Pregunta de Seguridad', 'preg') ?>
					</div>
					<div class="col-xs-6">
						<?= form_dropdown('preg', $preguntas, '', array('id' => 'preg')) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Respuesta secreta', 'respuesta') ?>
					</div>
					<div class="col-xs-6">
						<?= form_input('respuesta', '', array('id' => 'respuesta')) ?>
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
		//Eventos del modal
		$('#ModalAgregar').on('hidden.bs.modal', function (e) {
		  window.location="<?= base_url() ?>usuarios";
		});
		//Mensajes de Error
		recargar();
		//Acciones del Formulario
		$("#userForm").submit(function(){
			var datosForm = $("#userForm").serialize();
			$.post("<?= base_url() ?>usuarios/agregar", datosForm, procesar).error(procesarError);
			return false;
		});
		function procesar(data)
		{
			if (data == "guardo")
			{
				recargar();
				$("#success").show(400).delay(4000).hide(400);
				jQuery.fn.reset = function(){
                    $(this).each(function(){ this.reset(); });
                }
                $("#userForm").reset();
                $("#nombre").focus();
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