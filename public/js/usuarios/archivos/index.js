$().ready(function () {
    $("#fileForm").validate({
        errorPlacement: function (error, element) {
            $(element)
                    .closest("form")
                    .find("label[for='" + element.attr("id") + "']")
                    .append(error);
        },
        errorElement: "code",
        rules: {
            'patente': {
                required: true                
            },
            'nombre': {
                required: true                
            },
            'filesInput[]': {
                required: true
            }
        },
        messages: {
            'patente': {
                required: " [No se ha seleccionado una patente.]"                
            },
            'nombre': {
                required: " [No se ha seleccionado un cliente.]"                
            },
            'filesInput[]': {
                required: " [No se ha seleccionado un archivo.]"
            }
        }
    });

    $("#submit").on('click', function (evt) {
        evt.preventDefault();
        if ($("#fileForm").valid()) {
            $("#fileForm").ajaxSubmit({
                type: "post",
                dataType: "json",
                timeout: 5000,
                beforeSend: function() {
                    $("#fileErrors").html("");
                },
                success: function (res) {
                    if(res.success === true) {
                        window.location.href = '/usuarios/archivos/index';
                    }
                }
            });
        }
        return false;
    });
    
    $('a.showModal').on('click', function (evt) {
        evt.preventDefault();
        $.post('/usuarios/ajax/cargar-archivo', {idArchivo: $(this).data('id')}, function (html) {
            $('#modal .modal-body').html(html);
            $('#modal').modal('show', {backdrop: 'static'});
        });
        return false;
    });
    
    $("#checkall").change(function () {
        $(".checkArchivos").prop('checked', $(this).prop("checked"));
    });
    
    $("#sendSelected").on("click", function () {
        $(this).prop("disabled", true).addClass("disabled");
        var checkedValues = $('.checkArchivos:checked').map(function () {
            return this.value;
        }).get();
        if(checkedValues.length !== 0) {
            $.each(checkedValues, function (key, value) {
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: "/usuarios/ajax/enviar-archivo",
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
            console.log("Nothing to send.");
        }
    });
    
});