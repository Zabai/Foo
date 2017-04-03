function create_order() {
    var ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            alert(res.message);
        }
    }

    ajax.open("post", "../json/order.php", true);
    ajax.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    var town = $("#town").val();
    var address = $("#address").val();
    ajax.send(JSON.stringify({"op": "create", "town": town, "address": address}));
}

function create_line() {
    var id = get_drinks_id();
    var name = get_drinks_name();
    var pvp = get_drinks_pvp();
    var amount = get_drinks_amount();

    var lines = create_line_json(id, pvp, amount);

    var ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            var lines = res.lines.split("-");

            for (var i = 0; i < id.length; i++) {
                if (amount[i] == 0) continue;

                var totalPrice = pvp[i] * amount[i];
                if ($("#line" + lines[i]).length > 0)
                    $("#line" + lines[i]).html("<td>" + name[i] + "</td><td>" + pvp[i] + "</td><td>"
                        + amount[i] + "</td><td>" + totalPrice.toFixed(2) + "</td><td><button id='delete_line' onclick='delete_line(" + lines[i] + ")'>Eliminar</button>");
                else
                    $("#lineTable").append("<tr id='line" + lines[i] + "'><td>" + name[i] + "</td><td>" + pvp[i] + "</td><td>"
                        + amount[i] + "</td><td>" + totalPrice.toFixed(2) + "</td><td><button id='delete_line' onclick='delete_line(" + lines[i] + ")'>Eliminar</button></td></tr>");
            }
        }
    };

    ajax.open("post", "../json/order.php", true);
    ajax.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    ajax.send(JSON.stringify({"op": "add", "lines": lines}))
}
function get_drinks_id() {
    var id = [];
    $("input[name^='id']").each(function () {
        id.push($(this).val());
    });
    return id;
}
function get_drinks_name() {
    var name = [];
    $("td[name='marca']").each(function () {
        name.push($(this).text());
    });
    return name;
}
function get_drinks_pvp() {
    var pvp = [];
    $("input[name^='PVP']").each(function () {
        pvp.push($(this).val());
    });
    return pvp;
}
function get_drinks_amount() {
    var amount = [];
    $("input[name^='amount']").each(function () {
        amount.push($(this).val());
    });
    return amount;
}
function create_line_json(id, pvp, amount) {
    var lines = [];
    for (var i = 0; i < id.length; i++) {
        lines.push({
            id: id[i],
            pvp: pvp[i],
            amount: amount[i]
        });
    }
    return lines;
}

function delete_line(id) {
    var ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            $("#line" + id).remove();
        }
    };

    ajax.open("post", "../json/order.php", true);
    ajax.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    ajax.send(JSON.stringify({"op": "delete", "id": id}));
}

function finish_order() {
    var ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Cambia interfaz

        }
    }

    ajax.open("post", "../json/order.php", true);
    ajax.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    ajax.send(JSON.stringify({"op": "finish"}));
}