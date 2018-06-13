var tooltip;

$(document).ready(function () {

    $("#formLogin").validate({
        errorPlacement: function (error, element) {
            if ($(error).text() !== '') {
                $(element).tooltipster('content', $(error).text());
                $(element).tooltipster('open');
            }
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
                required: "En necesario usuario"
            },
            password: {
                required: "Es necesario contraseña"
            }
        }
    });

    var tooltipsterObjects = $('#username, #password').tooltipster({
        trigger: 'custom',
        theme: 'tooltipster-punk',
        position: 'right',
    });

    tooltip = tooltipsterObjects[0];

    $(document.body).on('click', '#submit', function (evt) {
        evt.preventDefault();
        if ($("#formLogin").valid()) {
            $("#formLogin").ajaxSubmit({ url: "/default/auth/login", cache: false, type: "post", dataType: "json",
                timeout: 3000,
                success: function (res) {
                    if (res.success === true) {
                        document.location = res.landing;
                    } else {
                        if (res.username) {
                            $("#username").tooltipster('content', res.username);
                            $("#username").tooltipster('open');
                        }
                        if (res.password) {
                            $("#password").tooltipster('content', res.password);
                            $("#password").tooltipster('open');
                        }
                        
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


