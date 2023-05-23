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
