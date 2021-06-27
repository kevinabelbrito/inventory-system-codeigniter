<style>
.content .postcontent-0 .layout-item-0 { padding-right: 10px;padding-left: 10px;  }
.ie7 .post .layout-cell {border:none !important; padding:0 !important; }
.ie6 .post .layout-cell {border:none !important; padding:0 !important; }
</style>
<div class="content-layout">
    <div class="content-layout-row">
        <div class="layout-cell layout-item-0" style="width: 33%" >
            <p><br></p>
        </div>
        <div class="layout-cell layout-item-0" style="width: 34%" >
			<p style="text-align: center;">
			<img width="119" height="119" alt="" class="lightbox" src="<?= base_url() ?>assets/images/login.png">
			</p>
			<div class="row">
				<div class="alert alert-danger" id="errors">
					<strong><span class="glyphicon glyphicon-remove-sign"></span> Han ocurrido varios errores de validación</strong>
					<div id="list_errors"></div>
				</div>
				<div class="alert alert-warning" id="warning">
					<strong><span class="glyphicon glyphicon-warning-sign"></span> ¡Ocurrio un Problema!</strong> No fue posible iniciar la sesión porque el usuario y/o la contraseña son incorrectos
				</div>
				<div class="alert alert-success" id="success">
					<strong><span class="glyphicon glyphicon-ok-sign"></span> ¡Excelente!</strong> La inicion ha sido iniciada
				</div>
				<div class="alert alert-info" id="server">
					<strong><span class="glyphicon glyphicon-exclamation-sign"></span> ¡Error de conexión!</strong> No fue posible la comunicación con el servidor
				</div>
			</div>
			<?= form_open('home/login', array('id' => 'loginForm'))?>
			<?= form_label('Usuario', 'username') ?>
			<?= form_input('username', '', array('id' => 'username')) ?>
			<br>
			<?= form_label('Contraseña', 'password') ?>
			<?= form_password('password', '', array('id' => 'password')) ?>
			<br>
			<div class="text-center">
				<?= form_submit('login', 'Ingresar', array('class' => 'button')) ?>
			</div>
			<?= form_close() ?>
        </div>
        <div class="layout-cell layout-item-0" style="width: 33%" >
            <p style="text-align: center;">
				<a href="<?= base_url() ?>home/recuperar" class="button">Recuperar clave</a>
			</p>
        </div>
    </div>
</div>
<script>
	$(function(){
		recargar();
		$("#loginForm").submit(function(){
			var datosForm = $("#loginForm").serialize();
			$.post("<?= base_url() ?>home/login", datosForm, procesar).error(function (error) {
				recargar();
				$("#server").show(400).delay(4000).hide(400);
				console.log(error.responseText);	
			});
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
                $("#loginForm").reset();
                $("#username").focus();
			}
			else if(data == "entrada")
			{
				recargar();
				$("#success").show(400).delay(4000).hide(400);
				window.location = "<?= base_url() ?>admin";
			}
			else
			{
				recargar();
				$("#list_errors").html(data);
				$("#errors").show(400).delay(4000).hide(400);
			}
		}
		/*function procesarError(error)
		{
			recargar();
			$("#server").show(400).delay(4000).hide(400);
			console.log(error.responseText);
		}*/
		function recargar() {
			$("#errors").hide();
			$("#warning").hide();
			$("#success").hide();
			$("#server").hide();
		}
	});
</script>