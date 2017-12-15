const API_URL = "/api";
const SITE_ROOT = "";
const SITE_NAME = "U.S. Carmaux Voile";
document.title = SITE_NAME;
var SITE;
document.addEventListener("DOMContentLoaded", function (e) {
//    GET SITE INFO
    $.getJSON(API_URL + "/", (data) => {
        SITE = data;
        document.querySelector("a.brand-logo").innerHTML = data.name;
        document.querySelector("a#site_phone").innerHTML = data.phone;
        document.querySelector("a#site_phone").href = "tel:" + data.phone;
        document.querySelector("a#site_phone2").innerHTML = data.phone;
        document.querySelector("a#site_phone2").href = "tel:" + data.phone;
        document.querySelector("a.facebook_link").href = data.url_facebook;
        document.querySelector("span.site_address").innerHTML = data.address_contact;
    });
//    SET SIDE NAV
    $('.button-collapse').sideNav({
        menuWidth: 300,
        edge: 'left',
        closeOnClick: true,
        draggable: true
    });
//    SET MADAL
    $('.modal').modal({
        dismissible: true, // Modal can be dismissed by clicking outside of the modal
        opacity: .5, // Opacity of modal background
        inDuration: 300, // Transition in duration
        outDuration: 200, // Transition out duration
        //startingTop: '4%', // Starting top style attribute
        //endingTop: '10%', // Ending top style attribute
    });
});
function show_contact() {

    $('#modal_contact').modal('open');
}

function show_map() {
    document.querySelector("#modal h4").innerHTML = "Nous Trouver";
    document.querySelector("#modal div.modal-content div").innerHTML = '<iframe src="' + SITE.url_google_map + '"frameborder="0" style="border:0"></iframe>';
    $('#modal').modal('open');
}

function connection() {
    $.get(SITE_ROOT + "/connection", function (data) {
        document.querySelector("#modal h4").innerHTML = "Identifiez vous";
        document.querySelector("#modal div.modal-content div").innerHTML = data;
        $('#modal').modal('open');
        $.getScript(SITE_ROOT + "/assets/js/form/connection.js");
    });
}

function deconnection() {

    $.get(API_URL + "/logout", function (data) {
        window.location = window.location;
    })



}
