changeIcon();

$('.switch-darker input').change(function() {
    const isDarker = getCookie("darker-mode", true) ?? $('body').hasClass('darker');
    setCookie("darker-mode", !isDarker);

    changeIcon();
});

function changeIcon() {
    const isDarker = getCookie("darker-mode", true) ?? $('body').hasClass('darker');

    if(isDarker) {
        $('body').addClass('darker');
        $('html link[rel="icon"]').attr('href', favicon.darker);
        $('html link[rel="apple-touch-icon"]').attr('href', favicon.darker);
        $('.switch-darker input').removeAttr('checked', 'checked');
    } else {
        $('body').removeClass('darker');
        $('html link[rel="icon"]').attr('href', favicon.lighter);
        $('html link[rel="apple-touch-icon"]').attr('href', favicon.lighter);
        $('.switch-darker input').attr('checked', 'checked');
    }
}