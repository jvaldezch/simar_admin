$().ready(function () {
    $("#providers").validate({
        errorPlacement: function (error, element) {
            $(element)
                    .closest("form")
                    .find("label[for='" + element.attr("id") + "']")
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

    $("#submit").on('click', function (evt) {
        evt.preventDefault();
        if ($("#providers").valid()) {
            $("#providers").submit();
            return false;            
        }
    });
    
    $("#buscar").on('input', function (evt) {
        var input = $(this);
        var start = input[0].selectionStart;
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
        input[0].selectionStart = input[0].selectionEnd = start;
    });
    
});