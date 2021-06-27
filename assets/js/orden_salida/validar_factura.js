$(function(){
	//Action del formulario
	var accion_form = $("#facturaForm").attr('action');
	//Mensajes de Error
	recargar_orden_salida();
	//Acciones del Formulario
	$("#facturaForm").submit(function(){
		var datosForm = $("#facturaForm").serialize();
		$.post(accion_form+"/nueva/", datosForm, procesar).error(procesarError);
		return false;
	});
	function procesar(data)
	{
		if (data == "bien")
		{
			recargar_orden_salida();
			$("#successFacturar").show(400).delay(4000).hide(400);
			$.post(accion_form+"/cargar_ultima_factura", "", function(data){
				var id_factura = data;
				window.location = accion_form+"/detalles/"+id_factura;
			})
		}
		else if(data == "productos")
		{
			recargar_orden_salida();
			$("#warningFacturar").show(400).delay(4000).hide(400);
		}
		else
		{
			recargar_orden_salida();
			$("#list_errorsFacturar").html(data);
			$("#errorsFacturar").show(400).delay(5000).hide(400);
		}
	}
	function procesarError()
	{
		recargar_orden_salida();
		$("#serverFacturar").show(400).delay(4000).hide(400);
	}
	function recargar_orden_salida() {
		$("#errorsFacturar").hide();
		$("#warningFacturar").hide();
		$("#successFacturar").hide();
		$("#serverFacturar").hide();
	}
})