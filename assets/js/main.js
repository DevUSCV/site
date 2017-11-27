const API_URL = "/uscv/api";
const SITE_ROOT = "/uscv/site";
const SITE_NAME = "U.S. Carmaux Voile";
document.title = SITE_NAME;
var SITE;

document.addEventListener("DOMContentLoaded", function (e) {
//    GET SITE INFO
    $.getJSON(API_URL + "/", (data) => {
        SITE = data;
        document.querySelector("a.brand-logo").innerHTML = data.name;
        document.querySelector("a.facebook_link").href = data.facebook_url;
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
        startingTop: '4%', // Starting top style attribute
        endingTop: '10%', // Ending top style attribute
    });


    document.querySelector('#windguru').addEventListener("load", function(e){
        console.log(e.target.contentWindow);
    });
});



function show_contact() {

    $('#modal_contact').modal('open');

}

function show_map() {
    document.querySelector("#modal h4").innerHTML = "Nous Trouver";
    document.querySelector("#modal div.modal-content div").innerHTML = '<iframe src="' + SITE.google_map_url + '"frameborder="0" style="border:0"></iframe>';

    $('#modal').modal('open');

}