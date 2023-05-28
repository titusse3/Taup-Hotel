if (localStorage.getItem('token')) {
    $('.sig-iu').children().remove();
    const img = $('<img>',  {src : 'src/img/account.svg'});
    const a = $('<a>', {
        href: './account',
        class: 'button-connect',
        text: 'Account'
    })
    $('.sig-iu').append(a);
    a.append(img);

    let click = 0;

    $('#ahah').on('click', e => {
        if (click == 3) {
            click = 0;
            
            $.post('./api/v1/mallet/', 
                JSON.stringify({token: localStorage.getItem('token')}), d => {
                console.log(d);
                if (d.code !== 'good') {
                    window.location = './src/img/taup.png';
                    return;
                }
                window.location = './account/';
            })
        } else {
            ++click
        }
    })
}

$(window).on('scroll', () => {
    if ($(window).scrollTop() != 0) {
        $('header').addClass('h-on');
    } else {
        $('header').removeClass('h-on');
    }
});

const childs = $('.carouselle > div').children();
const links = [
    "url('./src/img/template1.jpg')",
    "url('./src/img/temp2.jpg')",
    "url('./src/img/temp3.jpg')",
]
let k = 0;

function carou () {
    childs.eq(k).addClass('active');
    $('.carouselle').css('background-image', links[k]);
    return setInterval(() => {
        childs.eq(k).removeClass('active');
        k = (k + 1) % childs.length;
        childs.eq(k).addClass('active');
        $('.carouselle').css('background-image', links[k]);
    }, 3000);
}

let id = carou();

childs.on('click', (event) => {
    let i = jQuery.inArray(event.target, childs);
    clearInterval(id);
    childs.removeClass('active');
    k = i;
    id = carou();
});