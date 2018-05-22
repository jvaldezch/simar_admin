function deleteInvoice(id) {
    var r = confirm("¿Esta seguro que desea borrar la factura?");
    if (r === true) {
        $.ajax({
            cache: false,
            url: "/usuarios/ajax/borrar-factura",
            type: "post",
            dataType: "json",
            data: {id: id},
            success: function (res) {
                if (res.success === true) {
                    window.location.href = "/usuarios/facturas/index";
                }
            }
        });
    }
}

$(document).ready(function () {

    $("#invoices").validate({
        errorPlacement: function (error, element) {
            $(element)
                    .closest("form")
                    .find("label[for=\"" + element.attr("id") + "\"]")
                    .append(error);
        },
        errorElement: "code",
        rules: {
            buscar: {required: true}
        },
        messages: {
            buscar: " [Nada que buscar.]"
        }
    });

    $("#submit").on("click", function (evt) {
        evt.preventDefault();
        if ($("#invoices").valid()) {
            $("#invoices").submit();
            return false;
        }
    });

    $("#checkall").change(function () {
        $(".checkInvoices").prop("checked", $(this).prop("checked"));
    });

    $("#sendSelected").on("click", function () {
        $(this).prop("disabled", true).addClass("disabled");
        var checkedValues = $(".checkInvoices:checked").map(function () {
            return this.value;
        }).get();
        if (checkedValues.length !== 0) {
            $.each(checkedValues, function (key, value) {
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: "/usuarios/ajax/enviar-factura",
                    data: {id: value},
                    success: function (res) {
                        if (res.success === true) {
                        }
                    }
                });
            });
            $(this).removeProp("disabled").removeClass("disabled");
        } else {
            $(this).removeProp("disabled").removeClass("disabled");
            alert("¡No ha seleccionado nada!");
        }
    });

    $("#buscar").on("input", function (evt) {
        var input = $(this);
        var start = input[0].selectionStart;
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
        input[0].selectionStart = input[0].selectionEnd = start;
    });

});