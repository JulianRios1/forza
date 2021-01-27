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
        alert( "Handler for .submit() called." );
        event.preventDefault();
    });
});