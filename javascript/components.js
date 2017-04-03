function check_rol() {
    var isClient = $("#rol").val();

    if (isClient == 2) show_location();
    else hide_location();
}

function show_location() {
    $("#location").show();
}

function hide_location() {
    $("#location").hide();
}

function check_form() {
    var nickname = $("#nickname").val();
    var username = $("#username").val();
    var rol = $("#rol").val();

    if (nickname.length < 4) $("#alert1").show();
    else $("#alert1").hide();

    if (username.length < 4) $("#alert2").show();
    else $("#alert2").hide();

    if (rol === "0") $("#alert3").show();
    else $("#alert3").hide();

    if (nickname.length > 4 && username.length > 4 && rol !== "0") document.getElementById("login").submit();
}

function show_create_order() {
    if (!$("#show_create_order").length) return;
    var form = "<div class='panel'> " +
        "<p>Población</p>" +
        "<input id='town' type='text'>" +
        "<p>Dirección</p>" +
        "<input id='address' type='text'><br><br>" +
        "<button id='create_order' onclick='create_order()'>Crear pedido</button> " +
        "</div>";
    $("#show_create_order").after(form);
    $("#show_create_order").remove();
}

function show_cart() {
    $("#cart").show();
}

function hide_cart() {
    $("#cart").hide();
}
