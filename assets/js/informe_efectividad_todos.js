$( document ).ready(function() {

    $("#mes_consulta").datepicker({
        dateFormat: 'mm-yy',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,

        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).val($.datepicker.formatDate('mm-yy', new Date(year, month, 1)));
        }
    });

    $("#mes_consulta").focus(function () {
        $(".ui-datepicker-calendar").hide();
        $("#ui-datepicker-div").position({
            my: "center top",
            at: "center bottom",
            of: $(this)
        });
    });
    
    $("#form_info_efectividad_todos").submit(function( event ) {
        
        $('#empleados_efectividad').DataTable().clear().destroy();

        let arrayPeriodo = $("#mes_consulta").val().split("-");
        let mes = arrayPeriodo[0];
        let anho = arrayPeriodo[1];
        let metaDefinida = $("#meta_empleado").val();
        let metaTotalDefinida = $("#meta_total").val();
        
        $("#empleados_efectividad").DataTable({
            "ajax":{
                "url": "ajax_paginas/ajax_informe_efectividad_todos.php",
                "dataSrc": "",
                "method": "GET",
                "data": { 'mes' : mes, 'anho' : anho, 'metaDefinida' : metaDefinida },
                "destroy": true 
            },
            "columns":[
                {"data": "id"},
                {"data": "nombre"},
                {"data": "consultorio"},
                {"data": "email"},
                {"data": "noSeEncontro"},
                {"data": "oficina"},
                {"data": "telefono"},
                {"data": "meta"},
                {"data": "efectividad"},
            ]
        });

        $.ajax({
            url        :"ajax_paginas/ajax_informe_efectividad_todos_totales.php",
            type       :'GET',
            dataType   :'json',
            data       :{ 'mes' : mes, 'anho' : anho, 'metaTotalDefinida' : metaTotalDefinida },
            cache      :false,
            beforeSend: function () {
                //
            },
            success    :function(result){
                if(result != undefined){
                   $("#efectividad_total").val(result['efectividadTotal']);
                   $("#porcentaje_efectividad_total").val(result['porcentajeEfectividadTotal']);
                }else{
                    //
                }
            }
        });

        event.preventDefault();
    });
});