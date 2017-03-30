function create_order() {
    var ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText); //resultado formato JSON {deleted:lógico}
            alert(res.message);
        }
    }

    ajax.open("post", "../json/order.php", true);
    ajax.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    var town = $("#town").val();
    var address = $("#address").val();
    ajax.send(JSON.stringify({"op": "create", "town": town, "address": address}));
}