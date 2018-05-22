$(document).ready(function () {

    $("#document").validate({
        errorPlacement: function (error, element) {
            $(element)
                    .closest("form")
                    .find("label[for='" + element.attr("id") + "']")
                    .append(error);
        },
        errorElement: "code",
        rules: {
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
            password: {
                required: " [Debe proporcionar contraseña]",
                minlength: " [La contraseña debe contar con al menos 5 caracteres]"
            },
            repeat: {
                required: " [Debe proporcionar contraseña]",
                minlength: " [La contraseña debe contar con al menos 5 caracteres]",
                equalTo: " [Las contraseñas no son iguales]"
            },
            email: " [Debe propocionar un email válido]"
        }
    });

    $("#submit").on('click', function (evt) {
        evt.preventDefault();
        if ($("#document").valid()) {
            $("#document").ajaxSubmit({
                type: "post",
                timeout: 3000,
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