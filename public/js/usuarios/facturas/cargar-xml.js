$(document).ready(function () {

    $("#form").validate({
        errorPlacement: function (error, element) {
            $(element)
                    .closest("form")
                    .find("label[for=\"" + element.attr("id") + "\"]")
                    .append(error);
        },
        errorElement: "code",
        rules: {
            file: {required: true},
            idCliente: {required: true}
        },
        messages: {
            file: " [No se ha seleccionado un archivo XML.]",
            idCliente: " [No se ha seleccionado cliente.]"
        }
    });

    $("#submit").on("click", function (evt) {
        evt.preventDefault();
        if ($("#form").valid()) {
            $("#form").ajaxSubmit({
                type: "post",
                dataType: "json",
                timeout: 5000,
                beforeSend: function () {
                    $("#formErrors").html("");
                },
                success: function (res) {
                    if (res.success === true) {
                        window.location.href = "/usuarios/facturas/index";
                    } else {
                        $("#formErrors").html("<p class=\"bg-danger\" style=\"padding: 10px 15px\"><strong>Error:</strong> " + res.message + "</p>");
                    }
                }
            });
        }
        return false;
    });

});