var sortMin = undefined;
var sortMax = undefined;
var sortDate = undefined;

window.tableProducts = function (page, size, type, year, search) {
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
    return $.ajax({
        url: '/admin/get/productos-satmo',
        data: { page: page, size: size, type: type, year: year, search: search, sortMin: sortMin, sortMax: sortMax, sortDate: sortDate },
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
        url: '/admin/get/obtener-anios',
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
    obtenerAnios();

    $(document.body).on('change', '#table-results-selector, #table-results-year, #table-results-type', function () {
        tableProducts();
    });

    $(document.body).on('click', '#update', function () {
        tableProducts();
    });

    $(document.body).on('click', '#search', function () {
        var search = $("#table-results-search").val();
        if (search !== '') {
            tableProducts(undefined, undefined, undefined, undefined, search);
        }
    });

    $("#table-results-dateini, #table-results-dateend").datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        autoclose: true,
        locale: 'es'
    });

    $.contextMenu({
        selector: '#download-report',
        trigger: 'left',
        callback: function (key, options) {
            var m = "clicked: " + key;
            window.console && console.log(m);
        },
        items: {
            "csv": { name: "Formato CSV", icon: "edit" },
            "excel": { name: "Formato Excel", icon: "cut" },
            "sep1": "---------",
            "quit": {
                name: "Salir", icon: function () {
                    return 'context-menu-icon context-menu-icon-quit';
                }
            }
        }
    });

    $(document.body).on('click', '.sort-min', function (e) {
        sortMax = false;
        sortDate = false;
        if (sortMin == false) {
            sortMin = 1;
        } else {
            if (sortMin == 1) 
                sortMin = 0;
            else
                sortMin = 1;
        }
        tableProducts();
    });

    $(document.body).on('click', '.sort-max', function (e) {
        sortMin = false;
        sortDate = false;
        if (sortMax == false) {
            sortMax = 1;
        } else {
            if (sortMax == 1) 
                sortMax = 0;
            else
                sortMax = 1;
        }
        tableProducts();
    });

    $(document.body).on('click', '.sort-date', function (e) {
        sortMax = false;
        sortMin = false;
        if (sortDate == false) {
            sortDate = 1;
        } else {
            if (sortDate == 1) 
            sortDate = 0;
            else
            sortDate = 1;
        }
        tableProducts();
    });

    $(document.body).on('keyup', '#table-results-search', function (e) {
        if(e.keyCode == 13) {
            $('#search').trigger("click");
        }
    });

});