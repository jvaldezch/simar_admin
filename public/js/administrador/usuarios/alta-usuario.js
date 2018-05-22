$(document).ready(function () {

    $("#form").validate({
        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        rules: {
            username: {
                required: true,
                minlength: 5
            },
            nombre: {
                required: true,
                minlength: 5
            },
            password: {
                required: true,
                minlength: 5
            },
            repeat: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            username: {
                required: "Debe proporcionar usuario.",
                minlength: "El usuario debe contar con al menos 5 caracteres."
            },
            nombre: {
                required: "Debe proporcionar nombre.",
                minlength: "El nombre debe contar con al menos 5 caracteres."
            },
            password: {
                required: "Debe proporcionar contraseña.",
                minlength: "La contraseña debe contar con al menos 5 caracteres."
            },
            repeat: {
                required: "Debe proporcionar contraseña.",
                minlength: "La contraseña debe contar con al menos 5 caracteres.",
                equalTo: "Las contraseñas no son iguales."
            },
            email: "Debe propocionar un email válido"
        }
    });

    $("#submit").on('click', function (evt) {
        evt.preventDefault();
        if ($("#form").valid()) {
            $("#form").ajaxSubmit({
                cache: false,
                timeout: 3000,
                type: "post",
                dataType: "json",
                url: "/administrador/ajax/editar-usuario",
                success: function (res) {
                    if (res.success === false) {
                        $.each(res.error, function (index, value) {
                            $("label[for='password']").append('<code class="error"> [' + value + ']</code>');
                        });
                    }
                }
            });
        }
        return false;
    });

});