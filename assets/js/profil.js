document.addEventListener("DOMContentLoaded", function (e) {
    document.title = SITE_NAME + " | Mon Profil";
    document.querySelector("div.row.content").style.backgroundImage = "url(" + SITE_ROOT + "/assets/image/background.jpg)";
});

function init(user_email){
    console.log(user_email);
    $.getJSON(API_URL + "/user/email/" + user_email, function(data){
       console.log(data); 
    });
}