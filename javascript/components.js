function show_create_order() {
    if (!$("#show_create_order").length) return;
    var form = "<div class='panel'> " +
        "<p>Población</p>" +
        "<input id='town' type='text'>" +
        "<p>Dirección</p>" +
        "<input id='address' type='text'><br><br>" +
        "<button id='create_order' onclick='create_order()'>Crear pedido</button> " +
        "</div>" +
        "<div class='clearfix'></div>";
    $("#show_create_order").after(form);
    $("#show_create_order").remove();
}