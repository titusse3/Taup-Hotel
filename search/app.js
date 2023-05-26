if (localStorage.getItem('token')) {
    $('.sig-iu').children().remove();
    const img = $('<img>',  {src : '../src/img/account.svg'});
    const a = $('<a>', {
        href: './account',
        class: 'button-connect',
        text: 'Account'
    })
    $('.sig-iu').append(a);
    a.append(img);
}

$("#room-button").on("change", ()=> {
    if ($("#room-button").val() == 'ROOM') {
        $("#type-room-button").css('visibility', 'visible');
    } else {
        if ($("#type-room-button").css('visibility') == 'visible') {
            $("#type-room-button").css('visibility', 'hidden');
        }
    }
});

function daysBetween(startDate, endDate) {
    return (endDate - startDate) / (24 * 60 * 60 * 1000);;
}

let next = null;
const container = $('.contain-annonce');

const form = $('form');
const dest = $('input[name="dest"]');
const name_ = $('input[name="name"]');
const arrived = $('input[name="arrived"]');
const departure = $('input[name="departure"]');
const bed = $('input[name="bed"]');
const trie = $('select[name="trie"]');
const note = $('select[name="note"]');
const type = $('select[name="type"]');
const type_room = $('select[name="type_room"]');

const currentDate = new Date();
let year = currentDate.getFullYear();
let month = String(currentDate.getMonth() + 1).padStart(2, '0');
let day = String(currentDate.getDate()).padStart(2, '0');
let formattedDate = year + '-' + month + '-' + day;

departure.val(formattedDate)

currentDate.setDate(currentDate.getDate() + 7);
year = currentDate.getFullYear();
month = String(currentDate.getMonth() + 1).padStart(2, '0');
day = String(currentDate.getDate()).padStart(2, '0');
formattedDate = year + '-' + month + '-' + day;

arrived.val(formattedDate);
bed.val(1);

fetch();

function addElement() {
    const nbDays = daysBetween(new Date(departure.val()).getTime(), 
        new Date(arrived.val()).getTime());
    for (let i = 0; i < arguments.length; ++i) {
        const a = $('<a>', {
            class: 'annonce-block',
            href: '../room/?id=' + arguments[i]['ID']
        });
        const img_block = $('<div>', {class: 'img-block'});
        const img_annonce = $('<img>', {
            class: 'img-annonce',
            src: arguments[i]['IMG0']
        });
        const type_block = $('<div>', {class: 'type-block'});
        const type = $('<img>', {
            src: arguments[i]['TYPE'] == 'HOTEL' ? '../src/img/hotel2.svg' 
                : '../src/img/Lit.svg'
        });
        const title = $('<h4>', {
            text: arguments[i]['TYPE'] == 'HOTEL' ? 'Hotel' : 'Room'
        });
        const heart_block = $('<div>', {class: 'heart-block'});
        const heart = $('<img>', {src: '../src/img/heart.svg'});
        const note = $('<h4>', {text: '4.69'});
        const bottom_block = $('<div>', {class: 'bottom-block'});
        const info = $('<div>');
        const name = $('<h3>', {text: arguments[i]['NAME']});
        const address = $('<h4>', {
            text: arguments[i]['COUNTRY'] + ', ' + arguments[i]['CITY'] 
                + ', ' + arguments[i]['ADDRESS']
        });
        const price_block = $('<h4>');
        const price = $('<span>', {
            text: (arguments[i]['PRICE'] * nbDays).toFixed(2)
        });
        container.append(a);
        a.append(img_block);
        img_block.append(img_annonce);
        img_block.append(type_block);
        type_block.append(type);
        type_block.append(title);
        img_block.append(heart_block);
        heart_block.append(heart);
        heart_block.append(note);
        a.append(bottom_block);
        bottom_block.append(info);
        info.append(name);
        info.append(address);
        bottom_block.append(price_block);
        price_block.append(price);
        price_block.append(' Total');
    }
}

function fetch() {
    const body = {};
    body['dfrom'] = new Date(departure.val()).getTime();
    body['dto'] = new Date(arrived.val()).getTime();
    body['place'] = bed.val();
    console.log(dest.val())
    if (dest.val()) {
        body['city'] = dest.val();
        body['address'] = dest.val();
        body['country'] = dest.val();
    }
    if (name_.val()) body['name'] = name_.val();
    if (trie.val()) body['order'] = trie.val();
    console.log(trie.val())
    if (note.val()) body['min_note'] = note.val();
    if (type.val()) body['type'] = type.val();
    if (type_room.val()) body['type_room'] = type_room.val();
    if (next) body['next'] = next;

    $.post('../api/v1/search/', JSON.stringify(body), (data) => {
        if (data.code == 'good') {
            if (data.data) {
                if (data.next) {
                    next = data.next;
                } else {
                    next = null;
                }
                addElement(...data.data);
            } else {
                if (!next) {
                    container.append($('<p>', {text: data.success[0]}));
                }
                next = null;
            }
        } else {
            if (!next) {
                container.append($('<p>', {text: data.success[0]}));
            }
            next = null;
        }
    })
}

form.on('submit', event => {
    event.preventDefault();
    container.children().remove();
    fetch();
})

$(window).on('scroll', event => {
    if (next && $(this).scrollTop() > container.innerHeight() + container.offset().top - $('footer').innerHeight() - (container.children().first().innerHeight() || 0)) {
        fetch();
    }
})