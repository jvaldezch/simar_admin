
window.download = function(filename, text) {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', filename);
  
    element.style.display = 'none';
    document.body.appendChild(element);
  
    element.click();
  
    document.body.removeChild(element);
}
  
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
                localStorage.setItem("archivoBitacora", res.results);
                localStorage.setItem("archivoBitacoraNombre", res.filename);
            }
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

    $(document.body).on('click', '#save', function () {
        var contenido = localStorage.getItem("archivoBitacora");
        var nombre = localStorage.getItem("archivoBitacoraNombre");
        if (contenido) {
            download(nombre, contenido);
        }
    });

});