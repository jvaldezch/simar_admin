function facturaAnalizar(id) {
    $.ajax({url: "/usuarios/ajax/factura-analizar", data: {id: id}, type: "post", dataType: "json", cache: false, success: function (res) {
            if (res.success === false) {
                $("#errors").show()
                        .html(res.html);
            } else {
                $("#errors").hide()
                        .html("");
            }
        }});
}

$(document).ready(function () {

    $("#invoice").validate({
        errorPlacement: function (error, element) {
            $(element)
                    .closest("form")
                    .find("label[for=\"" + element.attr("id") + "\"]")
                    .append(error);
        },
        errorElement: "code",
        rules: {
            numFactura: {required: true},
            fechaFactura: {
                required: true,
                dateISO: true
            },
            valorDolares: {
                required: true,
                number: true
            },
            valorMonedaExtranjera: {
                required: true,
                number: true
            },
            factorMonedaExtranjera: {
                required: true,
                number: true
            },
            certificadoOrigen: {required: true},
            tipoOperacion: {required: true},
            subdivision: {required: true},
            divisa: {required: true},
            numExportador: {
                required: function () {
                    return $("#certificadoOrigen").val() === "1";
                }
            }
        },
        messages: {
            numFactura: " [Se requiere numero de factura.]",
            fechaFactura: {
                required: " [Se requiere fecha de factura.]",
                dateISO: " [Se requiere fecha en formato aaaa-mm-dd]"
            },
            valorDolares: {
                required: " [Se requiere valor dólares.]",
                number: " [No es valor numerico.]"
            },
            valorMonedaExtranjera: {
                required: " [Se requiere valor.]",
                number: " [No es valor numerico.]"
            },
            factorMonedaExtranjera: {
                required: " [Se requiere factor.]",
                number: " [No es valor numerico.]"
            },
            certificadoOrigen: " [Debe especificar.]",
            tipoOperacion: " [Debe especificar.]",
            subdivision: " [Debe especificar.]",
            numExportador: " [Debe proporcionar número.]",
            divisa: " [Debe proporcionar divisa.]"
        }
    });

    $("#provider").validate({
        errorPlacement: function (error, element) {
            $(element)
                    .closest("form")
                    .find("label[for=\"" + element.attr("id") + "\"]")
                    .append(error);
        },
        errorElement: "code",
        rules: {
            idIdentificador: {required: true},
            idProveedor: {required: true}
        },
        messages: {
            idIdentificador: " [ Debe especificar el tipo de identificador]",
            idProveedor: " [ Seleccione el emisor de la factura]"
        }
    });

    $("#customer").validate({
        errorPlacement: function (error, element) {
            $(element)
                    .closest("form")
                    .find("label[for=\"" + element.attr("id") + "\"]")
                    .append(error);
        },
        errorElement: "code",
        rules: {
            idIdentificador: {required: true},
            idCliente: {required: true}
        },
        messages: {
            idIdentificador: " [ Debe especificar el tipo de identificador]",
            idCliente: " [ Seleccione el destinatario de la factura]"
        }
    });

    $("#submit").on("click", function (evt) {
        evt.preventDefault();
        if ($("#invoice").valid() && $("#provider").valid()) {
            return false;
        }
        return false;
    });


    $("a.showModal").on("click", function (evt) {
        evt.preventDefault();
        $.post("/usuarios/ajax/cargar-producto", {idProducto: $(this).data("id"), idFactura: $("#id").val()}, function (html) {
            $("#modal .modal-body").html(html);
            $("#modal").modal("show", {backdrop: "static"});
        });
        return false;
    });

    $("#addProduct").on("click", function (evt) {
        evt.preventDefault();
        $.post("/usuarios/ajax/cargar-producto", {idFactura: $("#id").val()}, function (html) {
            $("#modal .modal-body").html(html);
            $("#modal").modal("show", {backdrop: "static"});
        });
    });

    $("#numFactura").on("input", function (evt) {
        var input = $(this);
        var start = input[0].selectionStart;
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
        input[0].selectionStart = input[0].selectionEnd = start;
    });

    $("#fechaFactura").datepicker({
        calendarWeeks: true,
        autoclose: true,
        language: "es",
        format: "yyyy-mm-dd"
    });

    facturaAnalizar($("#id").val());

});