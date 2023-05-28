if (localStorage.getItem('token')) {
    $('.sig-iu').children().remove();
    const img = $('<img>',  {src : '../src/img/account.svg'});
    const a = $('<a>', {
        href: '../account',
        class: 'button-connect',
        text: 'Account'
    });
    $('.sig-iu').append(a);
    a.append(img);
} else {
    $('#room-reservation').remove();
}

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

if (!urlParams.has('id')) {
    window.location = '../';
}
const id_r = urlParams.get('id');
const arrived = $('input[name="arrived"]');
const departure = $('input[name="departure"]');
const bed = $('input[name="bed"]');

function daysBetween(startDate, endDate) {
    return (endDate - startDate) / (24 * 60 * 60 * 1000);
}

const capitalize = str => str.split(' ').map(s => s.charAt(0).toUpperCase() 
    + s.slice(1)).join(' ');

$.post('../api/v1/room/get/', JSON.stringify({id: id_r}), d => {
    if (d.code !== 'good') {
        window.location = '../';
    }
    const data = d.data;

    $('#title-hotel').text(capitalize(data.NAME));
    $('.localisation .sub-info').text(data.COUNTRY.toUpperCase() + ', ' 
        + capitalize(data.CITY) + ', ' + data.ADDRESS);
    $('.notation .sub-info').text(parseFloat(data.NOTE).toFixed(1));
    const imgs = [data.IMG1, data.IMG2, data.IMG3, data.IMG4];
    $('.grid-img').children().each((ind, val) => $(val).attr('src', imgs[ind]));
    $('#img1').attr('src', data.IMG0);
    $('.desc .info-desc').text(data.DESCR);
    $('.owner .info-desc').eq(0).text(data.HOTEL_NAME);
    $('.room-one-night h4').text('$' + data.PRICE);
    let nbDays = 1;
    if (urlParams.has('place') && urlParams.has('arrived') 
        && urlParams.has('departure')) {
        const body = {
            room: id_r,
            dto: urlParams.get('arrived') / 1000,
            dfrom: urlParams.get('departure') / 1000
        }

        bed.val(urlParams.get('place'));

        let date = new Date(parseInt(urlParams.get('departure')));
        let year = date.getFullYear();
        let month = String(date.getMonth() + 1).padStart(2, '0');
        let day = String(date.getDate()).padStart(2, '0');
        departure.val(year + '-' + month + '-' + day);

        date = new Date(parseInt(urlParams.get('arrived')));
        year = date.getFullYear();
        month = String(date.getMonth() + 1).padStart(2, '0');
        day = String(date.getDate()).padStart(2, '0');
        arrived.val(year + '-' + month + '-' + day);

        nbDays = daysBetween(urlParams.get('departure'), 
            urlParams.get('arrived'));

        $.post('../api/v1/room/place/', JSON.stringify(body), d => {
            if (d.code !== 'good') {
                window.location = '../';
            }
            $('.owner .info-desc').eq(1).text(d.place);
        })
    } else {
        $('.owner .info-desc').eq(1).text(data.PLACE);
    }
    $('.room-price h4').text('$' + (data.PRICE * nbDays).toFixed(2));
});

$('form').on('submit', event => {
    event.preventDefault();
    const body = {
        room: id_r,
        place: bed.val(),
        dfrom: new Date(departure.val()).getTime() / 1000,
        dto: new Date(arrived.val()).getTime() / 1000,
        token: localStorage.getItem('token'),
    }
    $.post('../api/v1/room/reserve/', JSON.stringify(body), d => {
        if (d.code !== 'good') {
            $('main').append($('<h6>', {
                text: d.reason[0],
                class: 'erreur'
            }));
            return;
        }
        $('main').append($('<h6>', {
            text: 'You have reserved this room.',
            class: 'good'
        }));
        setTimeout(() => window.location = '../', 2000);
    })
})