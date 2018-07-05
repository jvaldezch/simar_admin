
/*window.tableProducts = function (page, size) {
    if (page === undefined) {
        page = 1;
    }
    if (size === undefined) {
        size = $("#table-results-selector").val();
    }
    return $.ajax({
        url: '/admin/get/productos-de-categoria',
        data: { page: page, size: size, id: $("#id").val() },
        beforeSend: function (res) {
            $("#table-results").LoadingOverlay("show", { color: "rgba(255, 255, 255, 0.9)" });
        },
        success: function (res) {
            $("#table-results").LoadingOverlay("hide", true);
            if (res.success === true) {
                $("table#results tbody").html(res.results);
                $("#table-results-paginator").html(res.paginator);
                $("#table-results-info").html("Página " + res.info.current + " de " + res.info.pageCount);
            }
        }
    });
};*/

$(document).ready(function () {

    editor = $('#edit').froalaEditor({
        charCounterCount: false,
        saveInterval: 0,
        saveParam: ['content'],
        saveURL: '/admin/post/guardar-grupo',
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

    $(document.body).on('click', '#submit', function () {
        if ($("#form").valid()) {
            $("#form").ajaxSubmit({ url: "/admin/post/guardar-detalle-grupo", cache: false, type: "post", dataType: "json",
                timeout: 3000,
                success: function (res) {
                    if (res.success === true) {
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