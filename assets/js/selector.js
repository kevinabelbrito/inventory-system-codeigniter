$(document).ready(function () {
	$(".select2").select2();
	// Obtenemos la id del modal al cargarlo
	$(".modal").on('shown.bs.modal', function () {
		idModal = $(this).attr('id');
		/*if (idModal != 'form_msg') {
			console.log(idModal);*/
			$(".select2Modal").select2({
				dropdownParent: $("#" + idModal)
			});
		//}
	})
})
