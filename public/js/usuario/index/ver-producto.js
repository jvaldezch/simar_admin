
window.verProducto = function (rid) {
    return $.ajax({
        url: '/usuario/get/obtener-producto',
        data: { rid: rid },
        beforeSend: function (res) {
            $("#results").LoadingOverlay("show", {color: "rgba(255, 255, 255, 0.9)"});
        },
        success: function (res) {
            $("#results").LoadingOverlay("hide", true);
            if (res.success === true) {
                var results = res.results;
                $("#filename").val(res.results.filename);
                $("#year").val(res.results.year);
                $("#day").val(res.results.day);
                $("#composition").val(res.results.composition);
                $("#product").val(res.results.product);
                $("#sensor").val(res.results.sensor);
                $("#min").val(res.results.min);
                $("#max").val(res.results.max);
                $("#mean").val(res.results.mean);
                $("#projection").val(res.results.projection);
                $("#bit_depth").val(res.results.bit_depth);
                $("#pix_res").val(res.results.pix_res);
                $("#std_dev").val(res.results.std_dev);
                $("#no_data").val(res.results.no_data);
                $("#x_min").val(res.results.x_min);
                $("#y_min").val(res.results.y_min);
                $("#x_max").val(res.results.x_max);
                $("#y_max").val(res.results.y_max);

                $("#downloadlink").attr('href', res.results.download)
                    .show();
                $("#viewOnMap").attr('href', '/usuario/index/ver-mapa?rid=' + rid)
                    .show();
                $("#viewFolder").attr('href', res.results.folder)
                    .show();
                if (res.results.kmz) {
                    $("#downloadKmz").attr('href', res.results.kmz)
                        .show();
                }
                if (res.results.png) {
                    $("#downloadPng").attr('href', res.results.png)
                        .show();
                }
                obtenerMetadata(res.results.composition);
            }
        }
    });
};

window.obtenerMetadata = function (composition) {
    var comp;
    if (composition == 'day') {
        comp = 'nsst';
    } else {
        comp = composition;
    }
    return $.ajax({
        url: '/usuario/get/obtener-metadata',
        data: { composition: comp },
        success: function (res) {
            if (res.success === true) {
                $(".metadata").html(res.html)
                .show();
            }
        }
    });
}


$(document).ready(function () {

    verProducto(getAllUrlParams().rid);

});