if (localStorage.getItem('token')) {
    $('.sig-iu').remove();
}

$("#room-button").on("change", ()=> {
    if ($("#room-button").val() == 'Chambre') {
        $("#type-room-button").css('visibility', 'visible');
    } else {
        if ($("#type-room-button").css('visibility') == 'visible') {
            $("#type-room-button").css('visibility', 'hidden');
        }
    }
});

let next = null;

function fetch() {
    $.post('../api/v1/search/', JSON.stringify(body), (data) => {
        if (data.code == 'good') {
            console.log(data);
        } else {
            $('.contain-annonce').append($('<p>').text(data.reason[0]))
        }
    })
}

const form = $('form');
const dest = $('input[name="dest"]');
const name_ = $('input[name="name"]');
const arrived = $('input[name="arrived"]');
const departure = $('input[name="departure"]');
const bed = $('input[name="bed"]');

form.on('submit', event => {
    event.preventDefault();
    console.log(arrived.val());
    const body = {};
    body['dfrom'] = new Date(departure.val()).getTime();
    body['dto'] = new Date(arrived.val()).getTime();
    body['place'] = bed.val();
    if (dest.val()) {
        body['city'] = dest.val();
        body['address'] = dest.val();
        body['country'] = dest.val();
    }
    if (name_.val()) {
        body['nale'] = name_.val();
    }

    console.log(body)
})