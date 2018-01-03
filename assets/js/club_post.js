function init(blog_post_id) {
    $.getJSON(API_URL + "/blog/club/post/" + blog_post_id, (data) => {
        document.title = "U.S. Carmaux Voile | " + data.title;
        document.querySelector(".post_title").innerHTML = data.title;
        document.querySelector(".post_author").innerHTML = (data.last_editor_name ?
                ("Modifié par " + data.last_editor_name + " le " + data.last_edit_date) + "<br>" : "")
                + "Ecrit par " + data.author_name + " le " + data.create_date;
        document.querySelector(".post_content").innerHTML = data.content;

        let comment_div = document.querySelector("div.post_comment");
        if (data.comment.length > 0) {
            for (var comment of data.comment) {
                var item = document.createElement("div");
                item.id = "blog_post_comment_" + comment.blog_post_comment_id;
                item.innerHTML = (isModo() ? "<a class='red-text' onclick='delete_post_comment(" + comment.blog_post_comment_id + ")'><i class='fa fa-trash' aria-hidden='true'></i></a> " : "")
                        + "<b>" + comment.author_name + "</b><small class='right'>" + comment.create_date + "</small><br><p class='col s12'>" + comment.content
                        + "</p>";
                comment_div.appendChild(item);
            }
        }
        if (!data.commentable) {
            $("#form_comment").remove();
        }

        $('meta[property="og:url"]').attr('content', document.location);
        $('meta[property="og:title"]').attr('content', data.title);
        $('meta[property="og:description"]').attr('content', data.content);
        $('meta[property="og:image"]').attr('content', document.location + "/assets/Image/logo.jpg");
        document.querySelector(".fb-share-button").dataset.href = document.location;

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.11';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

    });
}

function check_validity(value) {
    if (value.length >= 5 && value.length <= 255) {
        $("#form_comment a").removeClass("disabled")
    } else {
        $("#form_comment a").addClass("disabled")
    }
}

function comment(blog_post_id) {
    var comment = document.querySelector("#form_comment").comment.value;
    $.post(API_URL + "/blog/club/post/" + blog_post_id + "/comment",
            {content: comment},
            function () {
                location.reload();
            }
    );
}