const API_URL = "/uscv/api";
const SITE_ROOT = "/uscv/site";

document.addEventListener("DOMContentLoaded", function (e) {
    $.getJSON(API_URL + "/", (data) => {
        document.querySelector("a.brand-logo").innerHTML = data.name;
    });
    $('.button-collapse').sideNav({
        menuWidth: 300,
        edge: 'left',
        closeOnClick: true,
        draggable: true
    });

});
