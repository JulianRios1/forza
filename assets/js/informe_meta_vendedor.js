$( document ).ready(function() {
    
    var placeholder = "Seleccione una opción";

    if($("#rol").val() == 4){//si es super admin
        $("#vendedor").select2({
            placeholder: placeholder,
            width: null
        });
    }else{//si es vendedor
        $("#zona").select2({
            placeholder: placeholder,
            width: null
        });
    }

    $("#vendedor").change(function() {
        let vendedor = $("#vendedor").val();
        $("#id_vendedor").val(vendedor);

        $.ajax({
            url : 'ajax_paginas/ajax_informe_meta_vendedor_zonas.php',
            data : { vendedor : vendedor },
            type : 'GET',
            dataType : 'json',
            success : function(resp) {
                $('#zona').empty();
                resp.forEach(el => {
                    $("#zona").append(new Option(el['des'], el['id']));
                });

                $("#zona").select2({
                    placeholder: placeholder,
                    width: null
                });
            },
            error : function(xhr, status) {
                alert('Disculpe, existió un problema');
            }
        });
    });

    $("#mes_ano").datepicker({
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

    $("#mes_ano").focus(function () {
        $(".ui-datepicker-calendar").hide();
        $("#ui-datepicker-div").position({
            my: "center top",
            at: "center bottom",
            of: $(this)
        });
    });

    $("#form_info_meta_vendedor").submit(function( event ) {
        $('#clientes_table').DataTable().clear().destroy();

        let vendedor = $("#id_vendedor").val();
        let zona = $("#zona").val();
        let arr_mes_ano = $('#mes_ano').val().split("-");
        
        $("#clientes_table").DataTable({
            "ajax":{
                "url": "ajax_paginas/ajax_informe_meta_vendedor.php",
                "dataSrc": "",
                "method": "GET",
                "data": { 'vendedor' : vendedor , 'zona' : zona, 'mes' : arr_mes_ano[0], 'ano' : arr_mes_ano[1] },
                "destroy": true 
            },
            "columns":[
                {"data": "id"},
                {"data": "cliente"},
                {"data": "mejor_venta"},
                {"data": "promedio_actual"},
                {"data": "pronostico_vendedor"},
                {"data": "venta_actual"},
                {"data": "porcentaje_cumplimiento"},
            ],
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });

        $.ajax({
            url        :"ajax_paginas/ajax_informe_meta_vendedor_totales.php",
            type       :'GET',
            dataType   :'json',
            data       :{ 'vendedor' : vendedor , 'zona' : zona, 'mes' : arr_mes_ano[0], 'ano' : arr_mes_ano[1] },
            cache      :false,
            beforeSend: function () {
                //
            },
            success    :function(result){
                if(result != undefined){
                    $("#total_esperado_ventas").val(result['totalEsperadoVentas']);
                    $("#porcentaje_total_ejecutado").val(result['porcentajeTotalEjecutado']+"%");

                    if(result['porcentajeTotalEjecutado'] <= 70){
                        $("#porcentaje_total_ejecutado").css("color", "red");
                    }else{
                        if(result['porcentajeTotalEjecutado'] > 70 && result['porcentajeTotalEjecutado'] <= 90){
                            $("#porcentaje_total_ejecutado").css("orange", "red");
                        }else{
                            if(result['porcentajeTotalEjecutado'] > 90){
                                $("#porcentaje_total_ejecutado").css("green", "red");
                            }
                        }
                    }
                }else{
                    //
                }
            }
        });

        event.preventDefault();
    });
});