

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

    $("#dateIni").datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true,
        locale: 'es'
    });

    $(document.body).on('click', '#run', function () {
        executeCommand();
    });

});