$(document).ready(function () {

    $("#formLogin").validate({
        errorPlacement: function (error, element) {
            $(element).tooltipster('update', $(error).text());
            $(element).tooltipster('show');
        },
        success: function (label, element) {
            $(element).tooltipster('hide');
        },
        rules: {
            username: {
                required: true
            },
            password: {
                required: true
            }
        },
        messages: {
            username: {
                required: "Debe proporcionar usuario"
            },
            password: {
                required: "Debe proporcionar contraseña"
            }
        }
    });

    $('#username, #password').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        position: 'right',
        theme: 'tooltipster-light'
    });

    var msg = getUrlParameter('message');
    if (msg) {
        var tooltipsterObjects = $('#username').tooltipster({
            content: '',
            multiple: true,
            position: 'right',
            theme: 'tooltipster-light',
            autoClose: true
        });
        var tooltip = tooltipsterObjects[0];
        if (msg !== '') {
            tooltip.content(urldecode(msg)).show();
        }
    }

    $('#username').on('focusin', function () {
        if (tooltip) {
            tooltip.disable();
        }
    });

    $(document.body).on('click', '#submit', function (evt) {
        evt.preventDefault();
        if (tooltip) {
            tooltip.disable();
        }
        if ($("#formLogin").valid()) {
            $("#formLogin").ajaxSubmit({
                cache: false,
                url: "/default/auth/login",
                type: "post",
                dataType: "json",
                timeout: 3000,
                success: function (res) {
                    if (res.success === true) {
                        document.location = res.landing;
                    } else {
                        $('#errorMsg').html('<span style="color: red; font-size: 12px">' + res.message + '</span>')
                                .fadeIn(500)
                                .delay(1000)
                                .fadeOut("slow");
                        
                    }
                }
            });
        }
    });
    
    $(document.body).on("keypress", "#username, #password", function(e) {
        if(e.which === 13) {
            $("#submit").trigger("click");
        }
    });

});


