
var currentTime = new Date()
var cyear = currentTime.getFullYear()
var cmonth = currentTime.getMonth() + 1

window.calendar = function(year, month) {
    return $.ajax({
        url: '/admin/get/calendario',
        data: { year: year, month: month },
        beforeSend: function (res) {
            $("#calendar").html('');
        },
        success: function (res) {
            if (res.success === true) {
                $("#calendar").html(res.results);
                mesAnterior(year, month);
                mesSiguiente(year, month);
                $(".calendar-products").LoadingOverlay("show", { color: "rgba(255, 255, 255, 0.9)" });
                $.when( obtenerNsst(year, month), obtenerWsst(year, month), obtenerWysst(year, month), obtenerMnsst(year, month), obtenerWhs(year, month), obtenerDhw(year, month), obtenerSba(year, month) ).done(function ( v1, v2, v3, v4, v5, v6, v7 ) {
                    $(".calendar-products").LoadingOverlay("hide", true);
                });
            }
        }
    });
};

window.urlProducto = function(url, product) {
    var url = '<a style="float:left; padding: 0 3px; clear: both" href="' + url + '" target="_blank">' + product + '</a>';
    return url;
}

window.obtenerNsst = function(year, month) {
    return $.ajax({
        url: '/admin/get/obtener-nsst',
        data: { year: year, month: month },
        beforeSend: function (res) {
        },
        success: function (res) {
            if (res.success === true) {
                for (var index in res.results) {
                    var obj = res.results[index];
                    $("#" + obj.product_id).append(urlProducto(obj.url, 'nsst'));
                }
                return true;
            }
            return false;
        }
    });
};

window.obtenerWsst = function(year, month) {
    return $.ajax({
        url: '/admin/get/obtener-wnsst',
        data: { year: year, month: month },
        beforeSend: function (res) {
        },
        success: function (res) {
            if (res.success === true) {
                for (var index in res.results) {
                    var obj = res.results[index];
                    $("#" + obj.product_id).append(urlProducto(obj.url, 'w-nsst'));
                }
                return true;
            }
            return false;
        }
    });
};

window.obtenerWysst = function(year, month) {
    return $.ajax({
        url: '/admin/get/obtener-wynsst',
        data: { year: year, month: month },
        beforeSend: function (res) {
        },
        success: function (res) {
            if (res.success === true) {
                for (var index in res.results) {
                    var obj = res.results[index];
                    $("#" + obj.product_id).append(urlProducto(obj.url, 'wy-nsst'));
                }
                return true;
            }
            return false;
        }
    });
};

window.obtenerMnsst = function(year, month) {
    return $.ajax({
        url: '/admin/get/obtener-mnsst',
        data: { year: year, month: month },
        beforeSend: function (res) {
        },
        success: function (res) {
            if (res.success === true) {
                for (var index in res.results) {
                    var obj = res.results[index];
                    $("#" + obj.product_id).append(urlProducto(obj.url, 'm-nsst'));
                }
                return true;
            }
            return false;
        }
    });
};

window.obtenerWhs = function(year, month) {
    return $.ajax({
        url: '/admin/get/obtener-whs',
        data: { year: year, month: month },
        beforeSend: function (res) {
        },
        success: function (res) {
            if (res.success === true) {
                for (var index in res.results) {
                    var obj = res.results[index];
                    $("#" + obj.product_id).append(urlProducto(obj.url, 'whs'));
                }
                return true;
            }
            return false;
        }
    });
};

window.obtenerDhw = function(year, month) {
    return $.ajax({
        url: '/admin/get/obtener-dhw',
        data: { year: year, month: month },
        beforeSend: function (res) {
        },
        success: function (res) {
            if (res.success === true) {
                for (var index in res.results) {
                    var obj = res.results[index];
                    $("#" + obj.product_id).append(urlProducto(obj.url, 'dhw'));
                }
                return true;
            }
            return false;
        }
    });
};

window.obtenerSba = function(year, month) {
    return $.ajax({
        url: '/admin/get/obtener-sba',
        data: { year: year, month: month },
        beforeSend: function (res) {
        },
        success: function (res) {
            if (res.success === true) {
                for (var index in res.results) {
                    var obj = res.results[index];
                    $("#" + obj.product_id).append(urlProducto(obj.url, 'sba'));
                }
                return true;
            }
            return false;
        }
    });
};

window.mesAnterior = function(year, month) {
    var d = new Date(year + "/" + month + "/01");
    d.setMonth(d.getMonth() - 1);
    document.getElementById('prevMonth').setAttribute('onclick', 'calendar(' + d.getFullYear() + ',' + (d.getMonth() + 1) + ')')
}

window.mesSiguiente = function(year, month) {
    var d = new Date(year + "/" + month + "/01");
    d.setMonth(d.getMonth() + 1);
    document.getElementById('nextMonth').setAttribute('onclick', 'calendar(' + d.getFullYear() + ',' + (d.getMonth() + 1) + ')')
}

$(document).ready(function () {

    calendar(cyear, cmonth);

});