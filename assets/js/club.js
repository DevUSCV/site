document.addEventListener("DOMContentLoaded", function (e) {
    document.querySelector("div.row.content").style.backgroundImage = "url(" + SITE_ROOT + "/assets/image/background.jpg)";
});

function actualite() {
    $.getJSON(API_URL + "/blog/club", (data) => {
        let content = document.querySelector("#actualite_content");
        content.innerHTML = "<div class='col s12 l4 center'><h1>Actualités</h1></div>";
        if (data.post) {
            for (let post of data.post) {
                let card = '<div class="col s12 l4">'
                        + '<div class="card">'
                        + '<div class="card-content ">'
                        + '<span class="card-title">' + post.title + '</span>'
                        + '<p>' + post.content + '</p>'
                        + '</div>'
                        + '<div class="card-action">'
                        + '<a class="btn waves-effects blue" href="' + SITE_ROOT + '/post/' + post.blog_post_id + '">Lire</a>'
                        + '<a class="right">' + post.comment_count + ' commentaire(s)</a>'
                        + '</div>'

                content.innerHTML += card;
            }
        }
    });
}
;