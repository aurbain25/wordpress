function setCookie(name, value, expiry) {
    let d = new Date();
    d.setTime(d.getTime() + (expiry*86400000));
    document.cookie = name + "=" + value + ";" + "expires=" + d.toUTCString() + ";path=/";
}

function getCookie(key, isBoolean = false) {
    const keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    let result = keyValue ? keyValue[2] : null;

    if(result != null && isBoolean) {
        result = result === 'true';
    }

    return result;
}