document.addEventListener("DOMContentLoaded", function (e) {
    document.querySelector("div.row.content").style.backgroundImage = "url(" + SITE_ROOT + "/assets/image/background.jpg)";
});

function actualite() {
    document.title = SITE_NAME + " | Le Club";
    $.getJSON(API_URL + "/blog/club", (data) => {
        var content = document.querySelector("#actualite_content");
        content.innerHTML = "<h1 class=''>Actualités"
                + (isModo() ? " <a class='btn-floating blue' href='blog/editor/new'><i class='fa fa-plus' aria-hidden='true'></i></a>" : "")
                + "</h1>";
        if (data.post) {
            for (var post of data.post) {
                var card = '<div class="col s12" id="blog_post_' + post.blog_post_id + '">'
                        + '<div class="card blog_post_excerpt">'
                        + '<div class="card-content ">'
                        + '<span class="card-title grey darken-3 white-text">' + post.title + '</span>'
                        + '<p>' + post.content + '</p>'
                        + '</div>'
                        + '<div class="card-action">'
                        + '<a class="btn waves-effects blue" href="' + SITE_ROOT + '/club/post/' + post.blog_post_id + '"><i class="fa fa-eye" aria-hidden="true"></i> Lire</a>'

                        + (isAdmin() ?
                                " <div class='right'><a class='btn-floating blue' href='blog/editor/" + post.blog_post_id + "'><i class='fa fa-pencil' aria-hidden='true'></i></a> "
                                + " <a class='btn-floating red' onclick='delete_post(" + post.blog_post_id + ")'><i class='fa fa-trash' aria-hidden='true'></i></a></div>"
                                : " ")
                        + '<a class="right">' + post.comment_count + ' commentaire(s)</a>'
                        + '</div>'

                content.innerHTML += card;
            }
            var tl = new TimelineLite();
            tl.staggerFrom($(".blog_post_excerpt"), 0.3, {alpha: 0, scale: 0.1}, 0.1);
        }
    });
}
;

function evenement() {
    document.title = SITE_NAME + " | Les Evenements";
    var tl = new TimelineLite();
    tl.staggerFrom($(".card"), 0.3, {alpha: 0, scale: 0.1}, 0);
    $.getJSON(API_URL + "/article/evenements", (data) => {
        document.querySelector("#event_planning p").innerHTML = data.content;
        document.querySelector("#event_pdf").data = SITE_ROOT + "/assets/file/avis-de-course.pdf?#zoom=FitH";
    });
}
;

function pratique() {
    var tl = new TimelineLite();
    tl.staggerFrom($(".card"), 0.3, {alpha: 0, scale: 0.1}, 0);
    document.title = SITE_NAME + " | Les Pratiques";
    $.getJSON(API_URL + "/article/pratique_deriveur", (data) => {
        document.querySelector("#pratique_deriveur span.card-title").innerHTML = data.title;
        document.querySelector("#pratique_deriveur p").innerHTML = data.content;
    });
    $.getJSON(API_URL + "/article/pratique_vrc", (data) => {
        document.querySelector("#pratique_vrc span.card-title").innerHTML = data.title;
        document.querySelector("#pratique_vrc p").innerHTML = data.content;
    });
    $.getJSON(API_URL + "/article/pratique_croisiere", (data) => {
        document.querySelector("#pratique_croisiere span.card-title").innerHTML = data.title;
        document.querySelector("#pratique_croisiere p").innerHTML = data.content;
    });
}
;

function entrainement() {
    document.title = SITE_NAME + " | Les Entrainements";
    var tl2 = new TimelineLite();
    tl2.staggerFrom($(".card"), 0.3, {alpha: 0, scale: 0.1}, 0);
    $.getJSON(API_URL + "/article/entrainements", (data) => {
        document.querySelector("#entrainements span.card-title").innerHTML = data.title;
        document.querySelector("#entrainements p").innerHTML = data.content;
    });
}
;

function equipe() {
    document.title = SITE_NAME + " | L'Equipe";
    var tl = new TimelineLite();
    tl.staggerFrom($(".card"), 0.3, {alpha: 0, scale: 0.1}, 0);
    $.getJSON(API_URL + "/article/moniteur1", (data) => {
        document.querySelector("#team_1 span.card-title").innerHTML = data.title;
        document.querySelector("#team_1 p").innerHTML = data.content;
    });
    $.getJSON(API_URL + "/article/moniteur2", (data) => {
        document.querySelector("#team_2 span.card-title").innerHTML = data.title;
        document.querySelector("#team_2 p").innerHTML = data.content;
    });
    $.getJSON(API_URL + "/article/moniteur3", (data) => {
        document.querySelector("#team_other span.card-title").innerHTML = data.title;
        document.querySelector("#team_other p").innerHTML = data.content;
    });
}
;

function apropos() {
    document.title = SITE_NAME + " | A Propos";
    var tl = new TimelineLite();
    tl.staggerFrom($(".card"), 0.3, {alpha: 0, scale: 0.1}, 0);
    $.getJSON(API_URL + "/article/apropos", (data) => {
        document.querySelector("#apropos span.card-title").innerHTML = data.title;
        document.querySelector("#apropos p").innerHTML = data.content;
    });
}
;