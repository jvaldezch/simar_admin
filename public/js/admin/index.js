window.tableProducts = function (page, size, type, year) {
    if (page === undefined) {
        page = 1;
    }
    if (size === undefined) {
        size = $("#table-results-selector").val();
    }
    if (year === undefined) {
        year = $("#table-results-year").val();
    }
    if (type === undefined) {
        type = $("#table-results-type").val();
    }
    return $.ajax({url: '/admin/get/productos',
        data: {page: page, size: size, type: type, year: year},
        beforeSend: function (res) {
            $("#table-results").LoadingOverlay("show", {color: "rgba(255, 255, 255, 0.9)"});
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
    return $.ajax({url: '/admin/get/obtener-anios',
        success: function (res) {
            if (res.success === true) {
                for(var index in res.results) { 
                    var obj = res.results[index];
                    $("#table-results-year").append('<option value="' + obj.year + '">' + obj.year + '</option>');
                }
            }
        }
    });
};

$(document).ready(function () {

    tableProducts();
    obtenerAnios();

    $(document.body).on('change', '#table-results-selector, #table-results-year, #table-results-type', function() {
        tableProducts();
    });

});