<div class="content-layout">
    <div class="content-layout-row">
	    <div class="layout-cell" style="width: 33%" >
	        <p><br></p>
	    </div>
	    <div class="layout-cell" style="width: 34%" >
	        <p style="text-align: center;">
	        	<img width="108" height="108" alt="" class="lightbox" src="<?= base_url() ?>assets/images/recuperar.png">
	        </p>
	        <div class="row">
				<div class="alert alert-danger" id="errors">
					<strong><span class="glyphicon glyphicon-remove-sign"></span> Han ocurrido varios errores de validación</strong>
					<div id="list_errors"></div>
				</div>
				<div class="alert alert-warning" id="warning">
					<strong><span class="glyphicon glyphicon-warning-sign"></span> ¡Ocurrio un Problema!</strong> No fue posible recuperar la contraseña porque los datos suministrados son incorrectos, verifique y vuelva a intentarlo
				</div>
				<div class="alert alert-success" id="success">
					<strong><span class="glyphicon glyphicon-ok-sign"></span> ¡Excelente!</strong> Su contraseña fue recuperada con éxito, hemos enviado un correo electronico con sus credenciales.
				</div>
				<div class="alert alert-info" id="server">
					<strong><span class="glyphicon glyphicon-exclamation-sign"></span> ¡Error de conexión!</strong> No fue posible la comunicación con el servidor
				</div>
			</div>
	        <?= form_open('home/recuperar', array('id' => 'recuperarForm')) ?>
	        <?= form_label('Cedula de Identidad', 'cedula') ?>
	        <?= form_input('cedula', '', array('id' => 'cedula', 'maxlength' => 10)) ?>
	        <br>
	        <?= form_label('Pregunta de Seguridad', 'preg') ?>
	        <?= form_dropdown('preg', $preguntas, '', array('id' => 'preg')) ?>
	        <br>
	        <?= form_label('Respuesta Secreta', 'respuesta') ?>
	        <?= form_input('respuesta', '', array('id' => 'respuesta')) ?>
	        <div class="text-center">
	        	<?= form_submit('recuperar', 'Validar', array('class' => 'button')) ?>
	        </div>
	        <?= form_close() ?>
	    </div>
	    <div class="layout-cell" style="width: 33%" >
	        <p style="text-align: center;">
	        	<a href="<?= base_url() ?>" class="button">Volver al Inicio</a>
	        </p>
	    </div>
    </div>
</div>
<script>
	$(function(){
		recargar();
		$("#recuperarForm").submit(function(){
			var datosForm = $("#recuperarForm").serialize();
			$.post("<?= base_url() ?>home/recuperar", datosForm, procesar).error(procesarError);
			return false;
		});
		function procesar(data)
		{
			if (data == "fallo")
			{
				recargar();
				$("#warning").show(400).delay(4000).hide(400);
				jQuery.fn.reset = function(){
                    $(this).each(function(){ this.reset(); });
                }
                $("#recuperarForm").reset();
                $("#cedula").focus();
			}
			else if(data == "bien")
			{
				recargar();
				$("#success").show(400).delay(4000).hide(400);
				window.location = "<?= base_url() ?>";
			}
			else
			{
				recargar();
				$("#list_errors").html(data);
				$("#errors").show(400).delay(4000).hide(400);
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