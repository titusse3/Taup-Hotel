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
const id_r = urlParams.get('id');

const capitalize = str => str.split(' ').map(s => s.charAt(0).toUpperCase() 
    + s.slice(1)).join(' ');

$.post('../api/v1/hotel/get/', JSON.stringify({id: id_r}), d => {
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