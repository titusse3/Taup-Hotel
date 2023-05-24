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