$(function(){
	//Action del formulario
	var accion_form = $("#validarForm").attr('action');
	//Mensajes de Error
	recargar_validar();
	//Panel para informacion del cliente
	$("#datos_cliente").hide();
	//Acciones del Formulario
	$("#validarForm").submit(function(){
		var datosForm = $("#validarForm").serialize();
		$.post(accion_form+"/validar", datosForm, procesar).error(procesarError);
		return false;
	});
	function procesar(data)
	{
		if (data == "bien")
		{
			recargar_validar();
			$("#successValidar").show(400).delay(4000).hide(400);
			var datosForm = $("#validarForm").serialize();
			$.getJSON(accion_form+"/cargar_cliente", datosForm, function(data){
				$("#nombre").html(data.nombre);
				$("#tlf").html(data.tlf);
				$("#email").html(data.email);
				$("#direccion").html(data.direccion);
				$("#id_cliente").val(data.id);
				$("#datos_cliente").show(400);
			});
		}
		else
		{
			recargar_validar();
			$("#list_errorsValidar").html(data);
			$("#errorsValidar").show(400).delay(5000).hide(400);
			jQuery.fn.reset = function(){
                $(this).each(function(){ this.reset(); });
            }
            $("#validarForm").reset();
            $("#documento_validar").focus();
            // Formateando el panel de clientes
            $("#nombre").html("");
			$("#tlf").html("");
			$("#email").html("");
			$("#direccion").html("");
			$("#id_cliente").val("");
            $("#datos_cliente").hide(400);
		}
	}
	function procesarError()
	{
		recargar_validar();
		$("#serverValidar").show(400).delay(4000).hide(400);
	}
	function recargar_validar() {
		$("#errorsValidar").hide();
		$("#warningValidar").hide();
		$("#successValidar").hide();
		$("#serverValidar").hide();
	}
});