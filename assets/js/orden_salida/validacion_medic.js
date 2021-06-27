$(function(){
	//Action del formulario
	var accion_form = $("#MedicSearchForm").attr('action');
	//Mensajes de Error
	recargar_validar_producto();
	//Panel para infor del medicamento
	$("#datos_medicamento").hide();
	//Acciones del Formulario
	$("#MedicSearchForm").submit(function(){
		var datosForm = $("#MedicSearchForm").serialize();
		$.post(accion_form+"/validar_medic", datosForm, procesar).error(procesarError);
		return false;
	});
	function procesar(data)
	{
		if (data == "bien")
		{
			recargar_validar_producto();
			$("#successValidarMedic").show(400).delay(4000).hide(400);
			var datosForm = $("#MedicSearchForm").serialize();
			$.getJSON(accion_form+"/cargar_medic", datosForm, function(data){
				$("#codigo_m").val(data.codigo);
				$("#id_medic").val(data.id_medicamento);
				$("#nombre_m").val(data.nombre_medic);
				$("#nombre_medic").html(data.nombre_medic);
				$("#precio").val(data.precio);
				$("#precio_medic").html(data.precio);
				$("#cantidad").attr('disabled', false);
				$("#datos_medicamento").show(400);
			});
		}
		else
		{
			recargar_validar_producto();
			$("#list_errorsValidarMedic").html(data);
			$("#errorsValidarMedic").show(400).delay(5000).hide(400);
			jQuery.fn.reset = function(){
                $(this).each(function(){ this.reset(); });
            }
            $("#MedicSearchForm").reset();
            $("#codigo").focus();
            // Formateando el formulario de agregar medicamentos
            $("#nombre_m").val("");
            $("#nombre_medic").html("");
            $("#tipo_m").val("");
            $("#tipo_medic").html("");
            $("#precio").val("");
			$("#precio_medic").html("");
			$("#cantidad").val(0);
			$("#cantidad").attr('disabled', true);
			$("#datos_medicamento").hide(400);
		}
	}
	function procesarError()
	{
		recargar_validar_producto();
		$("#serverValidarMedic").show(400).delay(4000).hide(400);
	}
	function recargar_validar_producto() {
		$("#errorsValidarMedic").hide();
		$("#warningValidarMedic").hide();
		$("#successValidarMedic").hide();
		$("#serverValidarMedic").hide();
	}
});