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

function delete_post_comment(blog_post_comment_id) {
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

function view_reservation(reservation_id) {
    alert(reservation_id);
}

function add_file() {
    $.get(SITE_ROOT + "/addfile", function (data) {
        document.querySelector("#modal h4").innerHTML = "<i class='fa fa-plus' aria-hidden='true'></i> Ajouter un fichier";
        document.querySelector("#modal div.modal-content div").innerHTML = data;
        $('#modal').modal('open');
    });
}

function check_send_file_form() {
    var form = document.querySelector("#add_file_form_form");
    var valid = (
            form.name.validity.valid &&
            form.description.validity.valid &&
            form.file.validity.valid
            );
    if (valid) {
        $("#send_file_button").removeClass("disabled")
    } else {
        $("#send_file_button").addClass("disabled")
    }
    return valid;
}

function send_file() {
    if (check_send_file_form()) {
        var form = document.querySelector("#add_file_form_form");
        var data = new FormData(form);
        console.log(data);
        $.ajax({
            type: "POST",
            url: API_URL + "/file",
            data: data,
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            dataType: "json",
            success: function (data, textStatus, jqXHR) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
                document.querySelector("#modal div.modal-content div").innerHTML = "Votre fichier est enregistrer.";
                window.setTimeout(function () {
                    window.location.reload();
                }, 2000);
            },
            error: function (jqxhr, status, error) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
                document.querySelector("#modal div.modal-content div").innerHTML = error;
            }
        });
    }
}

function delete_file(file_id) {
    document.querySelector("#modal h4").innerHTML = "<i class='fa fa-question' aria-hidden='true'></i> Suppression de fichier";
    document.querySelector("#modal div.modal-content div").innerHTML = "<div class='container'>Voulez vous supprimer ce fichier ? <br>Cette action est irreversible</div>"
            + "<div class='modal-footer'><a class='btn red' onclick='confirm_delete_file(" + file_id + ")'>Supprimer</div></div>";
    $('#modal').modal('open');
}

function confirm_delete_file(file_id) {
    $.ajax({
        url: API_URL + '/file/' + file_id,
        type: 'DELETE',
        dataType: 'json',
        success: function (result) {
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
            document.querySelector("#modal div.modal-content div").innerHTML = "Fichier supprimé avec succes.";
            $("#file_" + file_id).hide(300);
        },
        error: function (jqxhr, status, error) {
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
            document.querySelector("#modal div.modal-content div").innerHTML = error;
        }
    });
}

function add_sponsor() {
    alert("TODO");
}

function delete_sponsor(sponsor_id) {
    alert("TOTO spondor_id = " + sponsor_id);
}

function delete_image(image_id) {
    document.querySelector("#modal h4").innerHTML = "<i class='fa fa-question' aria-hidden='true'></i> Suppression d'image";
    document.querySelector("#modal div.modal-content div").innerHTML = "<div class='container'>Voulez vous supprimer cette image ? <br>Cette action est irreversible</div>"
            + "<div class='modal-footer'><a class='btn red' onclick='confirm_delete_image(" + image_id + ")'>Supprimer</div></div>";
    $('#modal').modal('open');
}

function confirm_delete_image(photo_id) {
    $.ajax({
        url: API_URL + '/photo/' + photo_id,
        type: 'DELETE',
        dataType: 'json',
        success: function (result) {
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
            document.querySelector("#modal div.modal-content div").innerHTML = "Image supprimé avec succes.";
            $("#image_" + photo_id).hide(300);
        },
        error: function (jqxhr, status, error) {
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
            document.querySelector("#modal div.modal-content div").innerHTML = error;
        }
    });
}

function add_image(){
    $.get(SITE_ROOT + "/addimage", function (data) {
        document.querySelector("#modal h4").innerHTML = "<i class='fa fa-plus' aria-hidden='true'></i> Ajouter un fichier";
        document.querySelector("#modal div.modal-content div").innerHTML = data;
        $('#modal').modal('open');
    });
}

function check_send_image_form() {
    var form = document.querySelector("#add_image_form");
    var valid = (
            form.title.validity.valid &&
            form.description.validity.valid &&
            form.photo.validity.valid
            );
    if (valid) {
        $("#send_image_button").removeClass("disabled")
    } else {
        $("#send_image_button").addClass("disabled")
    }
    return valid;
}

function send_image() {
    if (check_send_image_form()) {
        var form = document.querySelector("#add_image_form");
        var data = new FormData(form);
        console.log(data);
        $.ajax({
            type: "POST",
            url: API_URL + "/photo",
            data: data,
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            dataType: "json",
            success: function (data, textStatus, jqXHR) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
                document.querySelector("#modal div.modal-content div").innerHTML = "Votre image est enregistrer.";
                window.setTimeout(function () {
                    window.location.reload();
                }, 2000);
            },
            error: function (jqxhr, status, error) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
                document.querySelector("#modal div.modal-content div").innerHTML = error;
            }
        });
    }
}