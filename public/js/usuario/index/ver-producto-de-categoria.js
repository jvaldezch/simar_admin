
var editor;

window.verProductoDeCategoria = function (rid) {
    return $.ajax({
        url: '/usuario/get/obtener-producto-de-categoria',
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
                $("#color_ramp").val(res.results.color_ramp);
                editor.froalaEditor('html.set', res.results.description, true);
            }
        }
    });
};

$(document).ready(function () {

    editor = $('#edit').froalaEditor({
        charCounterCount: false,
        saveInterval: 0
    });
    
    verProductoDeCategoria();

});