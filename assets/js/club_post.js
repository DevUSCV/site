function init(blog_post_id) {
    $.getJSON(API_URL + "/blog/club/post/" + blog_post_id, (data) => {
        document.title = "U.S. Carmaux Voile | " + data.title;
        document.querySelector(".post_title").innerHTML = data.title;
        document.querySelector(".post_author").innerHTML = (data.last_editor_name ?
                ("Modifié par " + data.last_editor_name + " le " + data.last_edit_date) :
                ("Ecrit par " + data.author_name + " le " + data.create_date));
        document.querySelector(".post_content").innerHTML = data.content;
        let comment_div = document.querySelector("div.post_comment");
        if (data.comment.length > 0) {
            for (var comment of data.comment) {
                var item = document.createElement("div");
                item.id = "blog_post_comment_" + comment.blog_post_comment_id;
                item.innerHTML = ((STATUS === "admin" || STATUS === "modo") ? "<a class='red-text' onclick='delete_post_comment(" + comment.blog_post_comment_id + ")'><i class='fa fa-trash-o' aria-hidden='true'></i></a> " : "")
                        + "<b>" + comment.author_name + "</b><small class='right'>" + comment.create_date + "</small><br><p class='col s12'>" + comment.content 
                        + "</p>";
                comment_div.appendChild(item);
            }
        }
        if (!data.commentable) {
            $("#form_comment").remove();
        }

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