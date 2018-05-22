/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$().ready(function () {
    
    $("#customs").validate({
        errorPlacement: function (error, element) {
            $(element)
                    .closest("form")
                    .find("label[for='" + element.attr("id") + "']")
                    .append(error);
        },
        errorElement: "code",
        rules: {
            idAduana: {required: true}
        },
        messages: {
            idAduana: " [Debe seleccionar la aduana.]"
        }
    });
    
});


