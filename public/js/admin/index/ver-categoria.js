


$(document).ready(function () {

    editor = $('#edit').froalaEditor({
        charCounterCount: false,
        saveInterval: 0,
        saveParam: ['content'],
        saveURL: '/admin/post/guardar-categoria',
        saveMethod: 'POST',
        saveParams: {id: $('#id').val()}
    }).on('froalaEditor.save.before', function (e, editor) {
        // Before save request is made.
    })
    .on('froalaEditor.save.after', function (e, editor, response) {
        $.alert({title: "Confirmación", type: "blue", content: "La información se guardo.", boxWidth: "350px", useBootstrap: false});
    })
    .on('froalaEditor.save.error', function (e, editor, error) {
        // Do something here.
    });

    $(document.body).on('click', '#saveButton', function () {
        $('#edit').froalaEditor('save.save')
    });

    $(document.body).on('click', '#submit', function (ev) {
        ev.preventDefault();
        if ($("#form").valid()) {
            $("#form").ajaxSubmit({ url: "/admin/post/guardar-detalle-categoria", cache: false, type: "post", dataType: "json",
                timeout: 3000,
                success: function (res) {
                    if (res.success === true) {
                        $.alert({title: "Confirmación", type: "blue", content: "La información se guardo.", boxWidth: "350px", useBootstrap: false});
                    }
                }
            });
        }
    });

    $(document.body).on('click', '#search', function () {
        var search = $("#table-results-search").val();
        if (search !== '') {
            searchProduct(search);
        }
    });

});