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

}

function delete_line(id) {
    var ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            $("#linea" + id).remove();
        }
    };

    ajax.open("post", "../json/order.php", true);
    ajax.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    ajax.send(JSON.stringify({"op": "delete", "id": id}));
}

function finish_order() {

}