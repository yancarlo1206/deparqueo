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
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        }
    });

});