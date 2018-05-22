/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$().ready(function () {
    
    $("#address").validate({
        errorPlacement: function (error, element) {
            $(element)
                    .closest("form")
                    .find("label[for='" + element.attr("id") + "']")
                    .append(error);
        },
        errorElement: "code",
        rules: {
            calle: {required: true},
            numExterior: {required: true},
            estado: {required: true},
            cp: {required: true},
            pais: {required: true}
        },
        messages: {
            calle: " [Debe proporcionar la calle.]",
            numExterior: " [Debe proporcionar el número exterior.]",
            estado: " [Debe proporcionar estado.]",
            cp: " [Debe proporcionar código postal.]",
            pais: " [Debe proporcionar el país.]"
        }
    });
    
    $("#calle").on('input', function (evt) {
        var input = $(this);
        var start = input[0].selectionStart;
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
        input[0].selectionStart = input[0].selectionEnd = start;
    });
    
});


