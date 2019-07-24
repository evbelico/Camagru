function setCookie(name, value, days) {
    let date = new Date();
    date.setTime(date.getTime( + (days*24*60*60*1000)));
    let expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + "=" + ";" + expires + ";path=/";
}

function getCookie(name) {
    let name = name + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let array = decodedCookie.split(';');
    for (let i = 0; i < array.length; i++) {
        let tmp = array[i];
        while (tmp.charAt(0) == ' ') {
            tmp = tmp.substring(1);
        }
        if (tmp.indexOf(name) == 0) {
            return tmp.substring(name.length, tmp.length);
        }
    }
    return "";
}

function checkCookie() {
    let content = getCookie("pictures");
    if (content != "") {
        echo (content);
    }
}