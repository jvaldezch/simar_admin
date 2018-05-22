
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
            patente: {required: true},
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
            patente: " [Se requiere patente.]",
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

    $("#submit").on("click", function (evt) {
        evt.preventDefault();
        if ($("#invoice").valid()) {
            $.ajax({
                type: "post",
                dataType: "json",
                url: "/usuarios/ajax/agregar-factura",
                data: {factura: $("#invoice").serialize(), cliente: $("#customer").serialize()},
                success: function (res) {
                    if (res.success === true) {
                        window.location.href = "/usuarios/facturas/editar-factura?id=" + res.id;
                    }
                }
            });
        }
        return false;
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

});