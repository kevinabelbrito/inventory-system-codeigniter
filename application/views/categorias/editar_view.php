<!--Modal para agregar registros-->
<div class="modal fade" id="ModalEditar<?= $id  ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<?= form_open('categorias/editar/'.$id, array('id' => 'categoriasFormEditar'.$id)) ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><?= $descripcion ?></h4>
			</div>
			<div class="modal-body bg-info">
				<div class="row">
					<div class="alert alert-danger" id="errorsEditar<?= $id  ?>">
						<strong><span class="glyphicon glyphicon-remove-sign"></span> Han ocurrido varios errores de validación</strong>
						<div id="list_errorsEditar<?= $id  ?>"></div>
					</div>
					<div class="alert alert-warning" id="warningEditar<?= $id  ?>">
						<strong><span class="glyphicon glyphicon-warning-sign"></span> ¡Ocurrio un Problema!</strong> No fue posible guardar los cambios
					</div>
					<div class="alert alert-success" id="successEditar<?= $id  ?>">
						<strong><span class="glyphicon glyphicon-ok-sign"></span> ¡Excelente!</strong> Los cambios han sido guardados con éxito
					</div>
					<div class="alert alert-info" id="serverEditar<?= $id  ?>">
						<strong><span class="glyphicon glyphicon-exclamation-sign"></span> ¡Error de conexión!</strong> No fue posible la comunicación con el servidor
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<?= form_label('Descripción', 'descripcion') ?>
					</div>
					<div class="col-xs-6">
						<?= form_input('descripcion', $descripcion, array('id' => 'descripcion', 'maxlength' => 50)) ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<?= form_hidden('id', $id) ?>
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
		$('#ModalEditar<?= $id  ?>').on('hidden.bs.modal', function (e) {
		  window.location="<?= base_url() ?>categorias";
		});
		//Mensajes de Error
		recargar_editar();
		//Acciones del Formulario
		$("#categoriasFormEditar<?= $id ?>").submit(function(){
			var datosForm = $("#categoriasFormEditar<?= $id ?>").serialize();
			$.post("<?= base_url() ?>categorias/editar/<?= $id ?>", datosForm, procesar).error(procesarError);
			return false;
		});
		function procesar(data)
		{
			if (data == "guardo")
			{
				recargar_editar();
				$("#successEditar<?= $id  ?>").show(400).delay(4000).hide(400);
			}
			else
			{
				recargar_editar();
				$("#list_errorsEditar<?= $id  ?>").html(data);
				$("#errorsEditar<?= $id  ?>").show(400).delay(5000).hide(400);
				jQuery.fn.reset = function(){
                    $(this).each(function(){ this.reset(); });
                }
                $("#categoriasFormEditar<?= $id ?>").reset();
			}
		}
		function procesarError()
		{
			recargar_editar();
			$("#serverEditar<?= $id  ?>").show(400).delay(4000).hide(400);
		}
		function recargar_editar() {
			$("#errorsEditar<?= $id  ?>").hide();
			$("#warningEditar<?= $id  ?>").hide();
			$("#successEditar<?= $id  ?>").hide();
			$("#serverEditar<?= $id  ?>").hide();
		}
	});
</script>