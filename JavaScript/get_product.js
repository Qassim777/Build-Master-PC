
function setProdcutNum(al)
{   
    localStorage.setItem("bar", al);
    setCookie();
}
function  getProdcutNum()
{
    var num = localStorage.getItem("bar");
    return num;
}
function setCookie() {
    var d = new Date();
    d.setTime(d.getTime() + (3600));
    var expires = "expires=" + d.toUTCString();
    document.cookie = "pro" + "=" + getProdcutNum()+ ";" + expires + ";path=" + '/';
}
