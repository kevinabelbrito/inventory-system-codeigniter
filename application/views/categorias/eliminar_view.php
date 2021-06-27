<!--Modal Eliminar-->
<div class="modal fade" id="ModalEliminar<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><?= $descripcion ?></h4>
			</div>
			<div class="modal-body bg-danger">
			¿Estas realmente seguro de querer eliminar esta categoría? todos los productos asociados a esta categoría tambien serán eliminados.
			</div>
			<div class="modal-footer">
				<a href="<?= base_url() ?>categorias/eliminar/<?= $id ?>" class="button">Aceptar</a>
				<button type="button" class="button" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>