const form = $('form');
const lastname = $('input[name="name"]');
const firstname = $('input[name="firstname"]');
const email = $('input[name="email"]');
const password = $('input[name="password"]');
const phone = $('input[name="phone"]');
const repassword = $('input[name="repassword"]');

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
    if (password.val() !== repassword.val()) {
        repassword.val('');
        password.val('');
        display_error('Password aren\'t the same.');
        return;
    }
    const body = {
        'firstname': lastname.val(),
        'name': firstname.val(),
        'phone': phone.val(),
        'email': email.val(),
        'password': password.val(),
    }
    $.post('../api/v1/signup/', JSON.stringify(body), (data) => {
        if (data.code == 'good') {
            localStorage.setItem('token', data.token);
            window.location = '../'
        } else {
            display_error(...data.reason)
        }
    })
})