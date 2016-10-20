function setCookie(title, name, timer) {

    var new_time = new Date();
    new_time.setTime(new_time.getTime() + (timer*24*60*60*1000));
    var expires = "expires="+new_time.toUTCString();
    var whole = title + "=" + name + "; " + expires;

    document.cookie = title + "=" + name + "; " + expires;
    document.getElementById("c_info").style.display = "none";

}

function getCookie(title) {

    var name = title + "=";
    var whole_cookies = document.cookie.split(';');
    for(var x=0; x < whole_cookies.length; x++) {
        var one_cookie = whole_cookies[x];
        while (one_cookie.charAt(0)==' ') one_cookie = one_cookie.substring(1);
        if (one_cookie.indexOf(title) == 0) {
 			 return one_cookie.length;}
        	
    }
    return "";
}

function checkCookie(name) {

    var is_cookie = getCookie(name);
    if (is_cookie != "") {
        return '1';
    } else {
				return '0';
    }
}