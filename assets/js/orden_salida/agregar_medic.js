$(function(){
	//Mensajes de Error
	recargar_agregar_medic();
	// Action del formulario
	var accion_form = $("#MedicForm").attr('action');
	//Acciones del Formulario
	$("#MedicForm").submit(function(){
		var datosForm = $("#MedicForm").serialize();
		$.post(accion_form+"/agregar_medic", datosForm, procesar).error(procesarError);
		return false;
	});
	function procesar(data)
	{
		if (data == "recargar")
		{
			recargar_agregar_medic();
			$("#successAgregarMedic").show(400).delay(4000).hide(400);
			$("#productos").load(accion_form+"/listar_productos");
			// Reiniciar el codigo del medicamento
			$("#codigo").focus();
			$("#codigo").val("");
            // Formateando el formulario de agregar medicamentos
            $("#codigo_m").val("");
            $("#id_medic").val("");
            $("#nombre_m").val("");
            $("#nombre_medic").html("");
            $("#precio").val("");
			$("#precio_medic").html("");
			$("#cantidad").val(0);
			$("#cantidad").attr('disabled', true);
			$("#total_medic").html(0);
			$("#datos_medicamento").hide(400);
		}
		else
		{
			recargar_agregar_medic();
			$("#list_errorsAgregarMedic").html(data);
			$("#errorsAgregarMedic").show(400).delay(5000).hide(400);
		}
	}
	function procesarError()
	{
		recargar_agregar_medic();
		$("#serverAgregarMedic").show(400).delay(4000).hide(400);
	}
	function recargar_agregar_medic() {
		$("#errorsAgregarMedic").hide();
		$("#warningAgregarMedic").hide();
		$("#successAgregarMedic").hide();
		$("#serverAgregarMedic").hide();
	}
	// Cuando cambia la cantidad
	$("#cantidad").change(function (e) {
		var cantidad = $("#cantidad").val();
		var precio = $("#precio").val();
		if (cantidad < 0)
		{
			$("#cantidad").val(cantidad);
		}
		var total = cantidad * precio;
		$("#total_medic").html(total);
	});
});