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
    // SET FOOTER
    $.getJSON(API_URL + "/article/footer", (data) => {
        document.querySelector("p#footer_article").innerHTML = data.content;
    });
    $.getJSON(API_URL + "/sponsor", (data) => {
        for(var sponsor of data){
            document.querySelector("#sponsor").innerHTML += "<li>"
                    + (isAdmin() ? "<a class='red-text' onclick='delete_sponsor(" + sponsor.sponsor_id + ")'><i class='fa fa-trash' aria-hidden='true'></i></a> " : "")
                    + "<a target='_BLANK' class='grey-text text-lighten-3' href='" + sponsor.url + "'>" + sponsor.name + "</a>"
                    + "</li>";
        }        
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
    
    var loading = false;
    $( document ).ajaxStart(function(){
        loading = true;
        window.setTimeout(function(){
            if(loading){$("#loader").fadeIn(300);}
        }, 500);
    });
    $( document ).ajaxComplete(function(){
       loading = false; 
       $("#loader").fadeOut(300);
    });
    $( document ).ajaxError(function(){
       loading = false; 
       $("#loader").fadeOut(300);
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
        window.location.reload();
    });
}

function contact_form_check() {
    var form = document.querySelector("#contact_form")
    var valid = (
            form.contact_full_name.validity.valid &&
            form.contact_reply.validity.valid &&
            form.contact_object.validity.valid &&
            form.contact_content.validity.valid
            )
    if (valid) {
        $("#contact_form_submit").removeClass("disabled");
    } else {
        $("#contact_form_submit").addClass("disabled");
    }
    console.log(valid);
    return valid;
}

function sendmail(grecaptcha) {
    var form = document.querySelector("#contact_form")
    $.post(API_URL + "/contact",
            {
                grecaptcha: grecaptcha,
                full_name: form.contact_full_name.value,
                reply: form.contact_reply.value,
                object: form.contact_object.value,
                content: form.contact_content.value
            },
            function (data) {
                form.reset();
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-envelope' aria-hidden='true'></i> Votre message a été envoyé avec succès.";
                document.querySelector("#modal div.modal-content div").innerHTML = 'Il sera traité dans les meilleurs délais.';
                $('#modal').modal('open');
            })
            .fail(function (jqXHR, textStatus) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Une erreur est survenue.";
                document.querySelector("#modal div.modal-content div").innerHTML = jqXHR.statusText;
                $('#modal').modal('open');
            });
    window.grecaptcha.reset();
}