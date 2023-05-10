$(window).on('scroll', () => {
    if ($(window).scrollTop() != 0) {
        $('header').addClass('h-on');
    } else {
        $('header').removeClass('h-on');
    }
});