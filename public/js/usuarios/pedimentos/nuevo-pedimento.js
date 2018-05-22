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
            patente: {
                required: true,
                minlength: 4
            },
            aduana: {
                required: true,
                minlength: 3
            },
            pedimento: {
                required: true,
                minlength: 7
            }
        },
        messages: {
            patente: {
                required: " [Debe proporcionar patente]"
            },
            aduana: {
                required: " [Debe proporcionar aduana]"
            },
            pedimento: {
                required: " [Debe proporcionar pedimento]"
            }
        }
    });

    $("#submit").on('click', function (evt) {
        evt.preventDefault();
        if ($("#document").valid()) {
            $("#document").ajaxSubmit({
                type: "post",
                timeout: 3000,
                dataType: "json",
                url: "/usuarios/ajax/nuevo-pedimento",
                success: function (res) {
                    
                }
            });
        }
        return false;
    });
    
});