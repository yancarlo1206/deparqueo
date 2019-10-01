$.fn.delayPasteKeyUp = function(fn, ms) {
	var timer = 0;
 	$(this).on("propertychange input", function() {
  		clearTimeout(timer);
  		timer = setTimeout(fn, ms);
 	});
};

jQuery(document).ready(function($) {
	$("#inputTicket").focus();
	$("#inputTicket").delayPasteKeyUp(function(){
		if($("#inputTicket").val().length > 4){
			$("#btnCalcular").click();	 		
		}
 	}, 100);
	$("#btnCalcular").click(function(event) {
		event.preventDefault();
		var ticket = $("#inputTicket").val();
		if(ticket == ''){
			$(".mensajeError").html("Se Debe Registrar un Ticket");
			$(".alert").css('display', 'block');
			setTimeout(function(){ 
				$(".alert").css('display', 'none');    
			}, 3000);
			return;
		}
		$.post(BASE.url + 'pago/cargarPago', {ticket: ticket}, function(data, textStatus, xhr) {
			if(data.data == "ok"){
				$(".formPago input[name='ingreso']").val(data.ingreso);
				$(".formPago input[name='fecha']").val(data.fecha);
				$(".formPago input[name='horaIni']").val(data.horaIni);
				$(".formPago input[name='horaFin']").val(data.horaFin);
				$(".formPago input[name='tiempoTotal']").val(data.tiempoTotal);
				$(".formPago input[name='totalPagar']").val(data.totalPagar);
				$(".formPago input[name='totalPagarNumero']").val(data.totalPagar);
				$(".formPago input[name='recibido']").prop("disabled", false);
				$(".formPago input[name='recibido']").focus();
			}else{
				$(".mensajeError").html(data.mensaje);
				$(".alert").css('display', 'block');
				setTimeout(function(){ 
					$(".alert").css('display', 'none');    
				}, 3000); 
			}
		},"json");
	});
	$(".formPago input[name='recibido']").keyup(function(){
    	if($(".formPago input[name='recibido']").val().length > 6){
    		$(".formPago input[name='recibidoNumero']").val($(".formPago input[name='recibido']").val().substring(2).replace(',',''));
    		var devolver = $(".formPago input[name='recibido']").val().substring(2).replace(',','') - $(".formPago input[name='totalPagar']").val().substring(2).replace(',','');
    		$(".formPago input[name='devolverNumero']").val(devolver);
    		$(".formPago input[name='devolver']").val(devolver);
    	}
	});
	$("#btnCalcularTarjeta").click(function(event) {
		event.preventDefault();
		var tarjeta = $("#inputTarjeta").val();
		if(tarjeta == ''){
			$(".mensajeError").html("Se Debe Registrar una Tarjeta");
			$(".alert").css('display', 'block');
			setTimeout(function(){ 
				$(".alert").css('display', 'none');    
			}, 3000);
			return;
		}
		$.post(BASE.url + 'pago/cargarPagoMensual', {tarjeta: tarjeta}, function(data, textStatus, xhr) {
			if(data.data == "ok"){
				$(".formPagoMensual input[name='tarjeta']").val(data.tarjeta);
				$(".formPagoMensual input[name='cliente']").val(data.cliente);
				$(".formPagoMensual input[name='totalPagar']").val(data.totalPagar);
				$(".formPagoMensual input[name='totalPagarNumero']").val(data.totalPagar);
			}else{
				$(".mensajeError").html(data.mensaje);
				$(".alert").css('display', 'block');
				setTimeout(function(){ 
					$(".alert").css('display', 'none');    
				}, 3000); 
			}
		},"json");
	});
	$(".formPagoMensual input[name='recibido']").keyup(function(){
    	if($(".formPagoMensual input[name='recibido']").val().length > 6){
    		$(".formPagoMensual input[name='recibidoNumero']").val($(".formPagoMensual input[name='recibido']").val().substring(2).replace(',',''));
    		var devolver = $(".formPagoMensual input[name='recibido']").val().substring(2).replace(',','') - $(".formPagoMensual input[name='totalPagar']").val().substring(2).replace(',','');
    		$(".formPagoMensual input[name='devolverNumero']").val(devolver);
    		$(".formPagoMensual input[name='devolver']").val(devolver);
    	}
	});
});