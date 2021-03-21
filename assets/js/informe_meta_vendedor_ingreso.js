$( document ).ready(function() {
    
    var placeholder = "Seleccione una opción";

    $("#zona").select2({
        placeholder: placeholder,
        width: null
    });

    $("#zona").change(function() {
        let zona = $("#zona").val();

        $.ajax({
            url : 'ajax_paginas/ajax_informe_meta_vendedor_ingreso_clientes.php',
            data : { zona : zona },
            type : 'GET',
            dataType : 'json',
            success : function(resp) {
                $('#cliente').empty();
                resp.forEach(el => {
                    $("#cliente").append(new Option('(' + el['documento'] + ') ' + el['cliente'], el['ide']));
                });

                $("#cliente").select2({
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

    $("#form_info_meta_vendedor_ingreso").submit(function( event ) {

        //verificación mes y año actuales
        var fecha_actual = new Date();
        var mes = ('0' + (fecha_actual.getMonth() + 1)).slice(-2);
        var ano = fecha_actual.getFullYear();
        let arr_mes_ano = $('#mes_ano').val().split("-");

        if(mes == arr_mes_ano[0] && ano == arr_mes_ano[1]){
            let zona = $("#zona").val();
            let cliente = $("#cliente").val();
            let meta = $("#meta").val();

            $.ajax({
                url : 'ajax_paginas/ajax_informe_meta_vendedor_ingreso.php',
                data : { zona : zona, cliente: cliente, meta: meta, mes: arr_mes_ano[0], ano: arr_mes_ano[1] },
                type : 'POST',
                dataType : 'json',
                success : function(resp) {
                    alertify.alert(resp['mensaje'], function(ev) {});
                },
                error : function(xhr, status) {
                    alert('Disculpe, existió un problema');
                }
            });
        }else{
            alertify.alert('El mes y el año deben ser los actuales para continuar.', function(ev) {
                return false;
            });
        }

        event.preventDefault();
    });
});