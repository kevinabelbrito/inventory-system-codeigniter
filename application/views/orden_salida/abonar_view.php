<div class="modal fade" id="ModalAbono" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?= form_open('orden_salida/abonar', array('id' => 'abonoForm')) ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Abonar</h4>
			</div>
			<div class="modal-body bg-warning">
				<div class="row">
					<div class="alert alert-danger" id="errors">
						<strong><span class="glyphicon glyphicon-remove-sign"></span> Han ocurrido varios errores de validación</strong>
						<div id="list_errors"></div>
					</div>
					<div class="alert alert-warning" id="warning">
						<strong><span class="glyphicon glyphicon-warning-sign"></span> ¡Ocurrio un Problema!</strong> No fue posible realizar el abono
					</div>
					<div class="alert alert-success" id="success">
						<strong><span class="glyphicon glyphicon-ok-sign"></span> ¡Excelente!</strong> El monto fue abonado con exito
					</div>
					<div class="alert alert-info" id="server">
						<strong><span class="glyphicon glyphicon-exclamation-sign"></span> ¡Error de conexión!</strong> No fue posible la comunicación con el servidor
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Monto a Abonar', 'monto') ?>
					</div>
					<div class="col-xs-6">
						<?= form_input('monto', '', array('id' => 'monto')) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Fecha', 'fecha') ?>
					</div>
					<div class="col-xs-6">
						<input type="date" name="fecha" id="fecha">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<?= form_hidden('id_factura', $id_factura) ?>
				<?= form_hidden('fecha_actual', $fecha_actual) ?>
				<?= form_submit('agregar', 'Abonar', array('class' => 'button')) ?>
				<button type="button" class="button" data-dismiss="modal">Cerrar</button>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>
<script>
	$(function(){
		//Eventos del modal
		$('#ModalAbono').on('hidden.bs.modal', function (e) {
	  		window.location = "<?= base_url() ?>orden_salida/detalles/<?= $id_factura ?>"
		});
		//Mensajes de Error
		recargar();
		//Acciones del Formulario
		$("#abonoForm").submit(function(){
			var datosForm = $("#abonoForm").serialize();
			$.post("<?= base_url() ?>orden_salida/abonar", datosForm, procesar).error(procesarError);
			return false;
		});
		function procesar(data)
		{
			if (data == "bien")
			{
				recargar();
				$("#success").show(400).delay(4000).hide(400);
				jQuery.fn.reset = function(){
                    $(this).each(function(){ this.reset(); });
                }
                $("#abonoForm").reset();
                $("#monto").focus();
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