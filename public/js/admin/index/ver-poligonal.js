window.tableProducts = function (id) {
    return $.ajax({
        url: '/admin/get/datos-poligonal',
        data: { id:id },
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
};

$(document).ready(function () {

    tableProducts(getAllUrlParams().id);

    $(document.body).on('click', '#update', function () {
        tableProducts(getAllUrlParams().id);
    });

});