
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
            ws: "required"
        },
        messages: {
            ws: "La contraseña Web Service es necesaria."
        }
    });

    $("#test").click(function (e) {
        e.preventDefault();
        $.ajax({
            cache: false,
            type: 'post',
            dataType: 'json',
            url: "/administrador/ajax/sello-probar",
            data: {id: $("#id").val()},
            success: function (res) {
                if (res.success === false) {
                    $("#error").html(res.messages);
                    $("#error").show();
                }
            }
        });
    });

    $("#submit").click(function (e) {
        e.preventDefault();
        if ($("#form").valid()) {
            $("#form").ajaxSubmit({
                cache: false,
                type: 'post',
                dataType: 'json',
                url: "/administrador/ajax/sello-actualizar",
                success: function (res) {
                    if (res.success === false) {
                        $("#error").html(res.messages);
                        $("#error").show();
                    }
                }
            });
        }
    });

});