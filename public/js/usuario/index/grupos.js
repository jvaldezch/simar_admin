window.tableProducts = function (size) {
    if (size === undefined) {
        size = $("#table-results-selector").val();
    }
    return $.ajax({
        url: '/usuario/get/grupos',
        data: { size: size },
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

window.searchProduct = function (search) {
    return $.ajax({
        url: '/usuario/get/buscar-categoria',
        data: { search: search },
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

window.obtenerAnios = function () {
    return $.ajax({
        url: '/usuario/get/obtener-anios',
        success: function (res) {
            if (res.success === true) {
                for (var index in res.results) {
                    var obj = res.results[index];
                    $("#table-results-year").append('<option value="' + obj.year + '">' + obj.year + '</option>');
                }
            }
        }
    });
};

$(document).ready(function () {

    tableProducts();

    $(document.body).on('click', '#update', function () {
        tableProducts();
    });

    $(document.body).on('click', '#search', function () {
        var search = $("#table-results-search").val();
        if (search !== '') {
            searchProduct(search);
        }
    });

});