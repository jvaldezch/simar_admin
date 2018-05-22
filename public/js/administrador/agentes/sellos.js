$().ready(function () {
    $("#fiel").validate({
        errorPlacement: function (error, element) {
            $(element)
                    .closest("form")
                    .find("label[for='" + element.attr("id") + "']")
                    .append(error);
        },
        errorElement: "code",
        rules: {
            password: {required: true},
            cerFile: {required: true},
            webservice: {required: true},
            keyFile: {required: true}
        },
        messages: {
            password: " [Proporcionar password.]",
            cerFile: " [No se ha seleccionado archivo .cer]",
            webservice: " [No se ha seleccionado archivo .cer]",
            keyFile: " [No se ha seleccionado archivo .key]"
        }
    });

    $("#submit").on('click', function (evt) {
        evt.preventDefault();
        if ($("#fiel").valid()) {
            $("#fiel").ajaxSubmit({
                type: "post",
                dataType: "json",
                timeout: 3000,
                success: function (res) {
                    if (res.success === true) {

                    }
                }
            });
        }
        return false;
    });
});


