function graph(year) {
    $.getJSON("/usuarios/ajax/estadistica?year=" + year, function (json) {
        $("#graph").highcharts({
            renderTo: "graph",
            chart: {
                type: "column"
            },
            title: {
                text: "Operaciones VUCEM " + year
            },
            colors: ["#009955", "#445566", "#B5CA92"],
            xAxis: {
                categories: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                crosshair: true,
                minPadding: 0,
                maxPadding: 0
            },
            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: "OP"
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: json
        });
    });
}

$(document).ready(function () {
    graph(2016);
});