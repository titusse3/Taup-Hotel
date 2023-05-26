const form = $('form');
const email = $('input[name="email"]');
const password = $('input[name="password"]');

function display_error() {
    $('form div ul').remove();
    const countainer = $('<div>');
    const list = $('<ul>');
    countainer.append(list);
    for (let i = 0; i < arguments.length; ++i) {
        list.append($('<li>').text(arguments[i]))
    }
    form.append(countainer);
}

form.on('submit', event => {
    event.preventDefault();
    const body = {
        'email': email.val(),
        'password': password.val()
    }
    $.post('../api/v1/signin/', JSON.stringify(body), (data) => {
        if (data.code == 'good') {
            localStorage.setItem('token', data.token);
            window.location = '../'
        } else {
            display_error(...data.reason)
        }
    })
})