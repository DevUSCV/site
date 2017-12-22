function delete_post(blog_post_id) {
    document.querySelector("#modal h4").innerHTML = "<i class='fa fa-question' aria-hidden='true'></i> Suppression de Billet";
    document.querySelector("#modal div.modal-content div").innerHTML = "<div class='container'>Voulez vous supprimer ce Billet ? <br>Cette action est irreversible</div>"
            + "<div class='modal-footer'><a class='btn red' onclick='confirm_delete_post(" + blog_post_id + ")'>Supprimer</div></div>";
    $('#modal').modal('open');
}

function confirm_delete_post(blog_post_id) {
    $.ajax({
        url: API_URL + '/blog/club/post/' + blog_post_id,
        type: 'DELETE',
        dataType: 'json',
        success: function (result) {
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
            document.querySelector("#modal div.modal-content div").innerHTML = "Billet supprimé avec succes.";
            $("#blog_post_" + blog_post_id).hide(300);
        },
        error: function (jqxhr, status, error) {
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
            document.querySelector("#modal div.modal-content div").innerHTML = error;
        }
    });
}

function delete_post_comment(blog_post_comment_id){
       document.querySelector("#modal h4").innerHTML = "<i class='fa fa-question' aria-hidden='true'></i> Suppression de commentaire";
    document.querySelector("#modal div.modal-content div").innerHTML = "<div class='container'>Voulez vous supprimer ce Commentaire ? <br>Cette action est irreversible</div>"
            + "<div class='modal-footer'><a class='btn red' onclick='confirm_delete_post_comment(" + blog_post_comment_id + ")'>Supprimer</div></div>";
    $('#modal').modal('open');
}

function confirm_delete_post_comment(blog_post_comment_id) {
    $.ajax({
        url: API_URL + '/blog/club/post/12/comment/' + blog_post_comment_id,
        type: 'DELETE',
        dataType: 'json',
        success: function (result) {
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
            document.querySelector("#modal div.modal-content div").innerHTML = "Billet supprimé avec succes.";
            $("#blog_post_comment_" + blog_post_comment_id).hide(300);
        },
        error: function (jqxhr, status, error) {
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
            document.querySelector("#modal div.modal-content div").innerHTML = error;
        }
    }); 
}

function view_reservation(reservation_id){
    alert(reservation_id);
}
