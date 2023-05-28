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
}

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

if (!urlParams.has('id')) {
    window.location = '../';
}
const id_h = urlParams.get('id');
let next = null;
const container = $('#container');
const form = $('form');
const trie = $('select[name="trie"]');
const note = $('select[name="note"]');
const type_room = $('select[name="type_room"]');

const capitalize = str => str.split(' ').map(s => s.charAt(0).toUpperCase() 
    + s.slice(1)).join(' ');

$.post('../api/v1/hotel/get/', JSON.stringify({id: id_h}), d => {
    if (d.code !== 'good') {
        window.location = '../';
    }
    const data = d.data;

    $('#title-hotel').text(capitalize(data.NAME));
    $('.localisation .sub-info').text(data.COUNTRY.toUpperCase() + ', ' 
        + capitalize(data.CITY) + ', ' + data.ADDRESS);
    $('.notation .sub-info').text(parseFloat(data.AVG_NOTE).toFixed(1));
    const imgs = [data.IMG1, data.IMG2, data.IMG3, data.IMG4];
    $('.grid-img').children().each((ind, val) => $(val).attr('src', imgs[ind]));
    $('#img1').attr('src', data.IMG0);
    $('.desc .info-desc').text(data.DESCR);
    $('.owner .info-desc').text(capitalize(data.MANAGER_NAME));
})

fetch();

function addElement() {
    for (let i = 0; i < arguments.length; ++i) {
        const a = $('<a>', {
            class: 'annonce-block',
            href: '../room?' + 
                (new URLSearchParams({id: arguments[i]['ID']})).toString()
        });
        const img_block = $('<div>', {class: 'img-block'});
        const img_annonce = $('<img>', {
            class: 'img-annonce',
            src: arguments[i]['IMG0']
        });
        const type_block = $('<div>', {class: 'type-block'});
        const type = $('<img>', {
            src: '../src/img/Lit.svg'
        });
        const title = $('<h4>', {
            text: 'Room'
        });
        const heart_block = $('<div>', {class: 'heart-block'});
        const heart = $('<img>', {src: '../src/img/heart.svg'});
        const note = $('<h4>', {
            text: parseFloat(arguments[i]['NOTE']).toFixed(2)
        });
        const bottom_block = $('<div>', {class: 'bottom-block'});
        const info = $('<div>');
        const name = $('<h3>', {text: arguments[i]['NAME']});
        const address = $('<h4>', {
            text: arguments[i]['COUNTRY'] + ', ' + arguments[i]['CITY'] 
                + ', ' + arguments[i]['ADDRESS']
        });
        const price_block = $('<h4>');
        const price = $('<span>', {
            text: parseFloat(arguments[i]['PRICE']).toFixed(2)
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
    let body = {
        hotel:  id_h,
        order: trie.val(),
        min_note: note.val(),
        type_room: type_room.val(),
        next: next
    };
    body = JSON.stringify(body, (_, value) => {if (value) return value})
    $.post('../api/v1/hotel/room/', body, (data) => {
        if (data.code == 'good') {
            if (data.data) {
                addElement(...data.data);
            } else if (!next) container.append($('<p>', {
                text: data.success[0],
                class: 'erreur'
            }));
        } else if (!next) container.append($('<p>', {
            text: data.reason[0],
            class: 'erreur'
        }));
        next = data.next || null;
    })
}

form.on('submit', event => {
    event.preventDefault();
    container.children().remove();
    next = null;
    fetch();
})

$(window).on('scroll', event => {
    if (next && $(this).scrollTop() > container.innerHeight() 
        + container.offset().top - $('footer').innerHeight() 
        - (container.children().first().innerHeight() || 0)) {
        fetch();
    }
})