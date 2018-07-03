
var editor;

window.verProductoDeCategoria = function (rid) {
    return $.ajax({
        url: '/admin/get/obtener-producto-de-categoria',
        data: { id: $('#id').val() },
        beforeSend: function (res) {
            $("#edit").LoadingOverlay("show", {color: "rgba(255, 255, 255, 0.9)"});
        },
        success: function (res) {
            $("#edit").LoadingOverlay("hide", true);
            if (res.success === true) {
                $("#spanish_title").val(res.results.spanish_title);
                $("#composition").val(res.results.composition);
                $("#title").val(res.results.title);
                $("#subtitle").val(res.results.subtitle);
                $("#thumb_image").val(res.results.thumb_image);
                $("#color_ramp_unit").val(res.results.color_ramp_unit);
                editor.froalaEditor('html.set', res.results.description, true);
            }
        }
    });
};

$(document).ready(function () {

    editor = $('#edit').froalaEditor({
        charCounterCount: false,
        saveInterval: 0,
        saveParam: ['content'],
        saveURL: '/admin/post/guardar-producto-de-categoria',
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
    
    verProductoDeCategoria();

    $(document.body).on('click', '#saveButton', function () {
        $('#edit').froalaEditor('save.save')
    });

    $(document.body).on('click', '#submit', function (ev) {
        ev.preventDefault();
        $("#form").ajaxSubmit({url: "/admin/post/guardar-parametros-producto-de-categoria", dataType: "json", timeout: 3000, type: "POST",
            success: function (res) {
                if (res.success === true) {
                }
            }
        });
    });

});