if (!localStorage.getItem('token')) {
    window.location = '../../signin';
}

function convertToBase64(fileInputElement) {
    return new Promise(r => {
        const file = fileInputElement.files[0];
        if (file) {
            const  reader = new FileReader();
            reader.onload = function(event) {
                r(event.target.result);
            };
            reader.readAsDataURL(file);
        } else {
            r(null);
        }
    })
}

function filePreview(input, n) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#preview' + n).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
$("#img1-input").change(function () {
    filePreview(this, 1);
});
$("#img2-input").change(function () {
    filePreview(this, 2);
});
$("#img3-input").change(function () {
    filePreview(this, 3);
});
$("#img4-input").change(function () {
    filePreview(this, 4);
});
$("#img5-input").change(function () {
    filePreview(this, 5);
});

$("#croix1").on('click', e => {
    e.preventDefault();
    $("#img2-input").val(null);
    $('#preview2').attr('src', '../../src/img/blank.png');
})
$("#croix2").on('click', e => {
    e.preventDefault();
    $("#img3-input").val('');
    $('#preview3').attr('src', '../../src/img/blank.png');
})
$("#croix3").on('click', e => {
    e.preventDefault();
    $("#img4-input").val('');
    $('#preview4').attr('src', '../../src/img/blank.png');
})
$("#croix4").on('click',e => {
    e.preventDefault();
    $("#img5-input").val('');
    $('#preview5').attr('src', '../../src/img/blank.png');
})

const form = $('form');
const name_ = $('input[name="name"]');
const localisation = $('input[name="localisaion"]');
const img0 = $('input[name="img0"]');
const img1 = $('input[name="img1"]');
const img2 = $('input[name="img2"]');
const img3 = $('input[name="img3"]');
const img4 = $('input[name="img4"]');
const descr = $('textarea');

form.on('submit', async event => {
    event.preventDefault();
    const vals = localisation.val().split(', ');
    const country = vals[0];
    const city = vals[1];
    const address = vals.slice(2).join(', ');
    let body = {
        token: localStorage.getItem('token'),
        name: name_.val(),
        country: country,
        city: city,
        address: address,
        img0: (await convertToBase64(img0[0])).split(',')[1],
        img1: (await convertToBase64(img1[0]))?.split(',')[1],
        img2: (await convertToBase64(img2[0]))?.split(',')[1],
        img3: (await convertToBase64(img3[0]))?.split(',')[1],
        img4: (await convertToBase64(img4[0]))?.split(',')[1],
        descr: descr.val()
    }
    body = JSON.stringify(body, (_, value) => {if (value) return value})
    $.post('../../api/v1/hotel/create/', body, d => {
        if (d.code !== 'good') {
            form.append($('<h6>', {text: d.reason[0]}))
        }
        form.append($('<h6>', {text: 'Room create.'}));
        setTimeout(() => {
            window.location = '../../';
        }, 2000)
    })
})