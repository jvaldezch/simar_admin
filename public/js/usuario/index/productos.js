
window.tableProducts = function (page, size) {
    if (page === undefined) {
        page = 1;
    }
    if (size === undefined) {
        size = $("#table-results-selector").val();
    }
    return $.ajax({
        url: '/usuario/get/productos',
        data: { page: page, size: size },
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

    tableProducts();

    $(document.body).on('click', '#update', function () {
        tableProducts();
    });
    
});