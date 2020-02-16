function confirmarProcedimiento(url, mensaje=null) {
    if(!mensaje){
      mensaje = "¿Esta seguro que desea seguir con el procedimiento?";
    }
    toastr["info"](""+mensaje+"<br><div><button type='button' id='siBtn' class='btn btn-success'>Si, Seguro</button><button type='button' id='noBtn' class='btn btn-danger' style='margin: 0 8px 0 8px'>Cancelar</button></div>", "Dialogo de Confirmación")
    $("#siBtn").click(function(event) {
      location.href = url;
    });
}
jQuery(document).ready(function($) {

    if($('.datepicker').length){
        $('.datepicker').datepicker({
        	format: 'dd/mm/yyyy',
        	language:'es'
        }).on('changeDate', function() {
            $(this).datepicker('hide');
        });
    }

    $('#dataTableEsp').dataTable( {
        "language": {
	    "order": [[ 0, "desc" ]],
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        }
    });

    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-bottom-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }

});