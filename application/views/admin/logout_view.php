<div class="modal fade" id="ModalLogout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Cerrar Sesión</h4>
			</div>
			<div class="modal-body bg-danger">
			¿Estas realmente seguro de querer cerrar la sesión? cualquier cambio no guardado se borrará.
			</div>
			<div class="modal-footer">
				<a href="<?= base_url() ?>admin/logout" class="button">Aceptar</a>
				<button type="button" class="button" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>