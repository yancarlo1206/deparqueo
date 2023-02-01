jQuery(document).ready(function($) {
	$("#btnCalcular").click(function(event) {
		event.preventDefault();
		var ticket = $("#inputTicket").val();
		$.post(BASE.url + 'pago/cargarPago', {ticket: ticket}, function(data, textStatus, xhr) {
			$(".formPago input[name='ingreso']").val(data.ingreso);
			$(".formPago input[name='fecha']").val(data.fecha);
			$(".formPago input[name='horaIni']").val(data.horaIni);
			$(".formPago input[name='horaFin']").val(data.horaFin);
			$(".formPago input[name='tiempoTotal']").val(data.tiempoTotal);
			$(".formPago input[name='totalPagar']").val(data.totalPagar);
			$(".formPago input[name='totalPagarNumero']").val(data.totalPagar);
		},"json");
	});
	$(".formPago input[name='recibido']").keyup(function(){
    	if($(".formPago input[name='recibido']").val().length > 6){
    		var devolver = $(".formPago input[name='recibido']").val().substring(2).replace(',','') - $(".formPago input[name='totalPagar']").val().substring(2).replace(',','');
    		$(".formPago input[name='devolver']").val(devolver);
    	}
	});
});