$("#room-button").on("change", ()=> {
    if ($("#room-button").val() == 'Chambre') {
        $("#type-room-button").css('visibility', 'visible');
    } else {
        if ($("#type-room-button").css('visibility') == 'visible') {
            $("#type-room-button").css('visibility', 'hidden');
        }
    }
});