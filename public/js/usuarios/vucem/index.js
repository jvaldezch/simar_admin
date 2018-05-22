
$(document).ready(function () {

    $(".send").on("click", function () {
        $.ajax({
            type: "post",
            dataType: "json",
            url: "/usuarios/ajax/enviar-vucem",
            data: {id: $(this).data("id")},
            success: function (res) {
                if (res.success === true) {
                    window.location.href = "/usuarios/vucem/index";
                }
            }
        });
    });

    $(".response").on("click", function () {
        $.ajax({
            type: "post",
            dataType: "json",
            url: "/usuarios/ajax/respuesta-vucem",
            data: {id: $(this).data("id")},
            success: function (res) {
                if (res.success === true) {
                    window.location.href = "/usuarios/vucem/index";
                }
            }
        });
    });

});