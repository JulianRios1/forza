$( document ).ready(function() {
    
    var placeholder = "Seleccione una opción";

    $(".select2, .select2-multiple").select2({
        placeholder: placeholder,
        width: null
    });

    $("#fecha_inicial").datepicker();
    $("#fecha_final").datepicker();

    $("#concepto").change(function() {
        if($("#concepto").val() == "1"){//literatura
            $("#divLiteratura").show();
            $("#divObsequio").hide();
            $("#divMuestraMedica").hide();
        }else{
            if($("#concepto").val() == "2"){//obsequio
                $("#divLiteratura").hide();
                $("#divObsequio").show();
                $("#divMuestraMedica").hide();
            }else{
                if($("#concepto").val() == "3"){//muestra m+edica
                    $("#divLiteratura").hide();
                    $("#divObsequio").hide();
                    $("#divMuestraMedica").show();
                }else{
                    $("#divLiteratura").hide();
                    $("#divObsequio").hide();
                    $("#divMuestraMedica").hide();
                }
            }
        }
    });

    $("#form_info_elementos_visitas").submit(function( event ) {
        if($("#concepto").val() == "1"){//literatura
            if($("#literatura").val() == ""){
                $("#literatura").focus();
                return false;
            }
        }else{
            if($("#concepto").val() == "2"){//obsequio
                if($("#obsequio").val() == ""){
                    $("#obsequio").focus();
                    return false;
                }
            }else{
                if($("#concepto").val() == "3"){//muestra médica
                    if($("#muestra_medica").val() == ""){
                        $("#muestra_medica").focus();
                        return false;
                    }
                }
            }
        }

        $('#elementos_visitas').DataTable().clear().destroy();

        let fechaInicial = $("#fecha_inicial").val().split("/");
        let fechaFinal = $("#fecha_final").val().split("/");
        let diaInicial = fechaInicial[1];
        let mesInicial = fechaInicial[0];
        let anhoInicial = fechaInicial[2];
        let diaFinal = fechaFinal[1];
        let mesFinal = fechaFinal[0];
        let anhoFinal = fechaFinal[2];
        let concepto = $("#concepto").val();
        let detalle;
        if(concepto == "1"){//literatura
            detalle = $("#literatura").val();
        }else{
            if(concepto == "2"){//obsequio
                detalle = $("#obsequio").val();
            }else{
                if(concepto == "3"){//muestra médica
                    detalle = $("#muestra_medica").val();
                }
            }
        }
        
        $("#elementos_visitas").DataTable({
            "ajax":{
                "url": "ajax_paginas/ajax_informe_elementos_visitas.php",
                "dataSrc": "",
                "method": "GET",
                "data": { 'diaInicial' : diaInicial, 'mesInicial' : mesInicial, 'anhoInicial' : anhoInicial, 'diaFinal' : diaFinal, 'mesFinal' : mesFinal, 'anhoFinal' : anhoFinal, 'concepto' : concepto, 'detalle' : detalle },
                "destroy": true 
            },
            "columns":[
                {"data": "id"},
                {"data": "empleado"},
                {"data": "tipoContacto"},
                {"data": "fechaHora"},
                {"data": "medico"},
                {"data": "ver"},
            ],
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });

        event.preventDefault();
    });
});