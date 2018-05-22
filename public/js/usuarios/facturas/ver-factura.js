
$(document).ready(function () {

    $("#create").on("click", function () {
        $.ajax({
            cache: false,
            url: "/usuarios/ajax/crear-adenda",
            type: "post",
            dataType: "json",
            data: {id: $(this).data("id")},
            success: function (res) {
                if (res.success === true) {
                    window.location.href = "/usuarios/facturas/index";
                }
            }
        });
    });

});