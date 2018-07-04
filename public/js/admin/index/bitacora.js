
window.tableProducts = function (size) {
    if (size === undefined) {
        size = $("#table-results-selector").val();
    }
    return $.ajax({
        url: '/admin/get/bitacora',
        data: { size: size },
        beforeSend: function (res) {
            $("#table-results").LoadingOverlay("show", { color: "rgba(255, 255, 255, 0.9)" });
        },
        success: function (res) {
            $("#table-results").LoadingOverlay("hide", true);
            if (res.success === true) {
                $("table#results tbody").html(res.results);
            }
        }
    });
};

window.archivoBitacora = function(filename) {
    return $.ajax({
        url: '/admin/get/archivo-bitacora',
        data: { filename: filename },
        beforeSend: function (res) {
            $("#content").html('');
            $("#content").LoadingOverlay("show", { color: "rgba(255, 255, 255, 0.9)" });
        },
        success: function (res) {
            $("#content").LoadingOverlay("hide", true);
            if (res.success === true) {
                $("#content").html(res.results);
            }
        }
    });
};

window.executeCommand = function() {
    return $.ajax({
        url: '/admin/get/execute-command',
        beforeSend: function (res) {
            $("#commands").LoadingOverlay("show", { color: "rgba(255, 255, 255, 0.9)" });
            $("#commands").html('');
        },
        success: function (res) {
            $("#commands").LoadingOverlay("hide", true);
            $("#commands").html(res);
        }
    });
};

$(document).ready(function () {

    tableProducts();

    $(document.body).on('click', '#update', function () {
        tableProducts();
    });

    $(document.body).on('change', '#table-results-selector', function () {
        tableProducts();
    });

    $(document.body).on('click', '#run', function () {
        executeCommand();
    });

});