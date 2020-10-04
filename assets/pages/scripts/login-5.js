var Login = function() {

    var handleLogin = function() {

        $('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },

            messages: {
                username: {
                    required: "El Usuario es requerido."
                },
                password: {
                    required: "El Password es requerido."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.login-form')).show();
                $('.box-error').hide();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
                
               // var formulario = $('.login-form').serializeArray();
                
                var timeSlide = 1000;
                //alert('usuario=' + $('#username').val() + '&password=' + $('#password').val());
                $.ajax({
                    type: 'POST',
                    url: 'autenticacion.php',
                    data: 'usuario=' + $('#username').val() + '&password=' + $('#password').val(),

                    //si la sesion se inicia correctamente presentamos el mensaje
                    success:function(msj){
                        console.log(msj)
                        if ( msj == 1 ){
                            $('#mensaje').hide();
                            $('#alertBoxes').html('<div class="alert alert-success box-success">');
                            $('.box-success').hide(0).html('Espera un momento…');
                            $('.box-success').slideDown(timeSlide);
                            //setTimeout(function(){
                                window.location.href = "index.php";
                            //},(timeSlide + 500));
                        }
                        
//caso contrario los datos son incorrectos
                        else{
                            console.log(msj)
                            $('#mensaje').hide();
                            $('#alertBoxes').html('<div class="alert alert-danger box-error">');
                            $('.box-error').hide(0).html('Lo sentimos, pero los datos son incorrectos');
                            $('.box-error').show();
                        }

                    },
//si se pierden los datos presentamos error de ejecucion.
                    error:function(){
                        $('#alertBoxes').html('<div class="box-error"></div>');
                        $('.box-error').hide(0).html('Ha ocurrido un error durante la ejecución');
                        $('.box-error').show();
                    }
                });
            }
        });

        $('.login-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });

        $('.forget-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.forget-form').validate().form()) {
                    $('.forget-form').submit();
                }
                return false;
            }
        });

        $('#forget-password').click(function(){
            $('.login-form').hide();
            $('.forget-form').show();
        });

        $('#back-btn').click(function(){
            $('.login-form').show();
            $('.forget-form').hide();
        });
    }

 
  

    return {
        //main function to initiate the module
        init: function() {

            handleLogin();


            $('.forget-form').hide();
        }

    };

}();

jQuery(document).ready(function() {
    Login.init();
});