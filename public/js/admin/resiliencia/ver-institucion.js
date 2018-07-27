
$(document).ready(function () {

    $("#form").validate({
        rules: {
            nombre: {
                required: true
            },
            pais: {
                required: true
            }
        },
        messages: {
            nombre: {
                required: "En necesario el nombre"
            },
            pais: {
                required: "Es necesario el país"
            }
        }
    });

    $(document.body).on('click', '#submit', function (ev) {
        ev.preventDefault();
        if ($("#form").valid()) {
            $("#form").ajaxSubmit({ url: "/admin/post/guardar-res-institucion", cache: false, type: "post", dataType: "json",
                timeout: 3000,
                success: function (res) {
                    if (res.success === true) {
                        $.alert({title: "Confirmación", type: "blue", content: "La información se guardo.", boxWidth: "350px", useBootstrap: false});
                    }
                }
            });
        }
    });
    
});