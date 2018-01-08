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
    location = SITE_ROOT + "/reservation/editor/" + reservation_id;
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
        $("#send_file_button").removeClass("disabled");
    } else {
        $("#send_file_button").addClass("disabled");
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

function upload_avis_de_course(input) {
    if (check_upload_avis_de_course() && isAdmin()) {
        document.querySelector("#modal h4").innerHTML = "Mise a jour de l'avis de course";
        document.querySelector("#modal div.modal-content div").innerHTML = "<div class='container row'>"
                + "<div class='col s8 offset-s2 center'><b>Nouveaux fichier:</b><br><i class='fa fa-file-pdf-o' aria-hidden='true'></i> "
                + input.files[0].name
                + "</div>"
                + "<div class='card-action'><a class='btn blue waves-effect' onclick='confirm_upload_avis_de_course()'> <i class='fa fa-upload' aria-hidden='true'></i> Envoyer</a>"
        $('#modal').modal('open');
    }

}

function confirm_upload_avis_de_course() {
    if (check_upload_avis_de_course() && isAdmin()) {
        var form = document.querySelector("#avis_de_cours_form");
        var data = new FormData(form);
        $.ajax({
            type: "POST",
            url: API_URL + "/file/avisdecourse",
            data: data,
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            dataType: "json",
            success: function (data, textStatus, jqXHR) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
                document.querySelector("#modal div.modal-content div").innerHTML = "Votre fichier est enregistrer.";
                document.querySelector("#event_pdf").data = API_URL + "/uploads/file/avis_de_course.pdf?#zoom=FitH";
                form.reset();
            },
            error: function (jqxhr, status, error) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
                document.querySelector("#modal div.modal-content div").innerHTML = error;
            }
        });
    }
}

function check_upload_avis_de_course() {
    var form = document.querySelector("#avis_de_cours_form");
    return form.avis_de_course.validity.valid;
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
    $.get(SITE_ROOT + "/addsponsor", function (data) {
        document.querySelector("#modal h4").innerHTML = "<i class='fa fa-plus' aria-hidden='true'></i> Ajouter un sponsor";
        document.querySelector("#modal div.modal-content div").innerHTML = data;
        $('#modal').modal('open');
    });
}

function check_add_sponsor_form() {
    var form = document.querySelector("#add_sponsor_form");
    var valid = (
            form.name.validity.valid &&
            form.url.validity.valid
            );
    if (valid) {
        $("#add_sponsor_button").removeClass("disabled");
    } else {
        $("#add_sponsor_button").addClass("disabled");
    }
    return valid;
}

function confirm_add_sponsor() {
    if (check_add_sponsor_form()) {
        var form = document.querySelector("#add_sponsor_form");
        data = {
            name: form.name.value,
            url: form.url.value
        };
        $.post(API_URL + "/sponsor", data, function (data) {
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
            document.querySelector("#modal div.modal-content div").innerHTML = "Sponsor ajouté avec succes.";
            window.setTimeout(function () {
                window.location.reload();
            }, 2000);
        }).fail(function (data) {
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
            document.querySelector("#modal div.modal-content div").innerHTML = error;
        });
    }
}

function delete_sponsor(sponsor_id, sponsor_name) {
    document.querySelector("#modal h4").innerHTML = "<i class='fa fa-question' aria-hidden='true'></i> Suppression de sponsor";
    document.querySelector("#modal div.modal-content div").innerHTML = "<div class='container'>Voulez vous supprimer <b>" + sponsor_name + "</b> des sponsors ? <br>Cette action est irreversible</div>"
            + "<div class='modal-footer'><a class='btn red' onclick='confirm_delete_sponsor(" + sponsor_id + ")'>Supprimer</div></div>";
    $('#modal').modal('open');
}

function confirm_delete_sponsor(sponsor_id){
    $.ajax({
        url: API_URL + '/sponsor/' + sponsor_id,
        type: 'DELETE',
        dataType: 'json',
        success: function (result) {
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
            document.querySelector("#modal div.modal-content div").innerHTML = "Sponsor supprimé avec succes.";
            $("#sponsor_" + sponsor_id).hide(300);
        },
        error: function (jqxhr, status, error) {
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
            document.querySelector("#modal div.modal-content div").innerHTML = error;
        }
    });
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

function add_image() {
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

function edit_location_price(location_price_id) {
    $.get(SITE_ROOT + "/location/editor/" + location_price_id, function (data) {
        document.querySelector("#modal h4").innerHTML = "<i class='fa fa-pencil' aria-hidden='true'></i> Tarif Location";
        document.querySelector("#modal div.modal-content div").innerHTML = data;
        $('#modal').modal('open');
        $.getJSON(API_URL + "/location/" + location_price_id, function (data) {
            var form = document.querySelector("#location_form");
            form.name.value = data.name;
            form.description.value = data.description;
            form.half_hour.value = data.half_hour;
            form.hour.value = data.hour;
            form.two_hour.value = data.two_hour;
            form.half_day.value = data.half_day;
            form.day.value = data.day;
        });
    });
}

function add_location_price() {
    $.get(SITE_ROOT + "/location/editor", function (data) {
        document.querySelector("#modal h4").innerHTML = "<i class='fa fa-pencil' aria-hidden='true'></i> Tarif Location";
        document.querySelector("#modal div.modal-content div").innerHTML = data;
        $('#modal').modal('open');
    });
}

function check_location_form() {
    var form = document.querySelector("#location_form");
    var valid = (
            form.name.validity.valid &&
            form.description.validity.valid &&
            form.image.validity.valid &&
            form.half_hour.validity.valid &&
            form.hour.validity.valid &&
            form.two_hour.validity.valid &&
            form.half_day.validity.valid &&
            form.day.validity.valid
            );
    if (valid) {
        $("#send_location_button").removeClass("disabled")
    } else {
        $("#send_location_button").addClass("disabled")
    }
    return valid;
}

function send_location() {
    if (check_location_form()) {
        var form = document.querySelector("#location_form");
        var data = new FormData(form);
        console.log(data);
        $.ajax({
            type: "POST",
            url: API_URL + "/location" + (form.location_price_id.value ? "/update" : ""),
            data: data,
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            dataType: "json",
            success: function (data, textStatus, jqXHR) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
                document.querySelector("#modal div.modal-content div").innerHTML = "Opération effectuée.";
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

function delete_location_price(location_price_id) {
    document.querySelector("#modal h4").innerHTML = "<i class='fa fa-question' aria-hidden='true'></i> Suppression ce tarif";
    document.querySelector("#modal div.modal-content div").innerHTML = "<div class='container'>Voulez vous supprimer ce tarif ? <br>Cette action est irreversible</div>"
            + "<div class='modal-footer'><a class='btn red' onclick='confirm_delete_location_price(" + location_price_id + ")'>Supprimer</div></div>";
    $('#modal').modal('open');
}

function confirm_delete_location_price(location_price_id) {
    $.ajax({
        url: API_URL + '/location/' + location_price_id,
        type: 'DELETE',
        dataType: 'json',
        success: function (result) {
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
            document.querySelector("#modal div.modal-content div").innerHTML = "Tarif supprimé avec succes.";
            $("#location_price_" + location_price_id).hide(300);
        },
        error: function (jqxhr, status, error) {
            document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
            document.querySelector("#modal div.modal-content div").innerHTML = error;
        }
    });
}

function admin_reservation() {
    $.getJSON(API_URL + "/reservations/7", function (data) {
        var table = document.querySelector("#admin_reservations_table tbody");
        table.innerHTML = "";
        if (Object.keys(data)) {
            for (var day in data) {
                if (data[day] !== null) {
                    for (var reservation of data[day].reservation) {
                        var date = new Date(reservation.date);
                        table.innerHTML += "<tr onclick='view_reservation(" + reservation.reservation_id + ")' style='cursor:pointer;'>"
                                + "<td>" + date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear() + "</td>"
                                + "<td>" + (reservation.time ? reservation.time + "h" : "-") + "</td>"
                                + "<td>" + reservation.full_name + "</td>"
                                + "<td>" + reservation.activity + "</td>"
                                + "<td>" + reservation.support + "</td>"
                                + "<td>" + (reservation.monitor ? reservation.monitor : "-") + "</td>"
                                + "<td>" + reservation.people + "</td>"
                                + (reservation.status == "confirm" ?
                                        "<td class='green white-text'><i class='fa fa-check' aria-hidden='true'></i></td>" : "")
                                + (reservation.status == "valid" ?
                                        "<td class='red white-text'><i class='fa fa-times' aria-hidden='true'></i></td>" : "")
                                + "</tr>";
                    }
                }
            }
        } else {
            table.innerHTML = "<tr><td colspan='8'>Aucune Réservation</td></tr>"
        }

    });
}

function reservation_search_by_name(search) {
    if (search.length > 0) {
        $.getJSON(API_URL + "/reservation/name/" + search, function (data) {
            var table = document.querySelector("#admin_reservations_table tbody");
            table.innerHTML = "<tr><td colspan='8' class='grey lighten-1'>Demandes de reservations en attente de confirmation</td></tr>";
            if (data.valid.length) {
                for (var reservation of data.valid) {
                    var date = new Date(reservation.date);
                    table.innerHTML += "<tr onclick='view_reservation(" + reservation.reservation_id + ")' style='cursor:pointer;'>"
                            + "<td>" + date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear() + "</td>"
                            + "<td>" + (reservation.time ? reservation.time + "h" : "-") + "</td>"
                            + "<td>" + reservation.full_name + "</td>"
                            + "<td>" + reservation.activity + "</td>"
                            + "<td>" + reservation.support + "</td>"
                            + "<td>" + (reservation.monitor ? reservation.monitor : "-") + "</td>"
                            + "<td>" + reservation.people + "</td>"
                            + (reservation.status === "confirm" ?
                                    "<td class='green white-text'><i class='fa fa-check' aria-hidden='true'></i></td>" : "")
                            + (reservation.status === "valid" ?
                                    "<td class='red white-text'><i class='fa fa-times' aria-hidden='true'></i></td>" : "")
                            + "</tr>";
                }
            } else {
                table.innerHTML += "<tr>"
                        + "<td colspan='8'>Aucune demande de réservation en attente.</td>"
                        + "</tr>";
            }
            table.innerHTML += "<tr><td colspan='8' class='grey lighten-1'>Demandes de reservations confirmées</td></tr>";
            if (data.confirm.length) {
                for (var reservation of data.confirm) {
                    var date = new Date(reservation.date);
                    table.innerHTML += "<tr onclick='view_reservation(" + reservation.reservation_id + ")' style='cursor:pointer;'>"
                            + "<td>" + date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear() + "</td>"
                            + "<td>" + (reservation.time ? reservation.time + "h" : "-") + "</td>"
                            + "<td>" + reservation.full_name + "</td>"
                            + "<td>" + reservation.activity + "</td>"
                            + "<td>" + reservation.support + "</td>"
                            + "<td>" + (reservation.monitor ? reservation.monitor : "-") + "</td>"
                            + "<td>" + reservation.people + "</td>"
                            + (reservation.status === "confirm" ?
                                    "<td class='green white-text'><i class='fa fa-check' aria-hidden='true'></i></td>" : "")
                            + (reservation.status === "valid" ?
                                    "<td class='red white-text'><i class='fa fa-times' aria-hidden='true'></i></td>" : "")
                            + "</tr>";
                }
            } else {
                table.innerHTML += "<tr>"
                        + "<td colspan='8'>Aucune demande de réservation confirmée.</td>"
                        + "</tr>";
            }
        });
    } else {
        admin_reservation();
    }
}

function admin_user(search) {
    var table = document.querySelector("#admin_user_table tbody");
    $.getJSON(API_URL + "/user/search/" + search, function (data) {
        if (data.length) {
            table.innerHTML = "";
            for (var user of data) {
                user.age = user.birth_date ? Math.floor(((new Date).getTime() - (new Date(user.birth_date.split('/').reverse().join('/'))).getTime()) / (365.24 * 24 * 3600 * 1000)) + " ans" : "NC";
                table.innerHTML += "<tr onclick='admin_edit_user(this)' style='cursor:pointer;'" + " data-full_name='" + user.firstname + " " + user.lastname + "' data-id='" + user.user_id + "' data-status='" + user.status + "'>"
                        + "<td>" + user.lastname + "</td>"
                        + "<td>" + user.firstname + "</td>"
                        + "<td>" + user.age + "</td>"
                        + "<td>" + (user.phone ? user.phone : "NC") + "</td>"
                        + "<td>" + user.email + "</td>"
                        + "<td>" + user.subscribe_date + "</td>"
                        + "<td class='center'>"
                        + ((user.status === "admin") ?
                                "<div class='chip black  white-text'>Administrateur</div>" :
                                ((user.status === "modo") ?
                                        "<div class='chip blue  white-text'>Modérateur</div>" :
                                        "<div class='chip green  white-text'>Membre</div>"))

                        + "</td>"
                        + "</tr>"
            }
        } else {
            table.innerHTML = "<tr><td colspan='5'>Aucune correspondence</td></tr>"
        }
    });
}

function admin_edit_user(tr_user) {
    data = tr_user.dataset;
    window.location = SITE_ROOT + "/profil/" + data.id;
}

function admin_license(search) {
    var table = document.querySelector("#admin_licences_table tbody");
    $.getJSON(API_URL + "/license/search/" + search, function (data) {
        if (data.length) {
            table.innerHTML = "";
            for (var license of data) {
                table.innerHTML += "<tr>"
                        + "<td>" + license.number + "</td>"
                        + "<td>" + license.lastname + " " + license.firstname + "</td>"
                        + "<td>" + license.aptitude + " " + license.type + "</td>"
                        + "<td>" + license.practice + "</td>"
                        + "<td>" + license.year + "</td>"
                        + "<td>" + license.date + "</td>"
                        + "<td>" + license.address + "<br>" + license.zipcode + " " + license.city + "</td>"
                        + "<td>" + (license.material ? "<i class='fa fa-check' aria-hidden='true'></i>" : "<i class='fa fa-times' aria-hidden='true'></i>")  + "</td>"
                        + "</tr>"
            }
        } else {
            table.innerHTML = "<tr><td colspan='7'>Aucune correspondence</td></tr>"
        }
    });
}

function admin_site() {
    var iframe = document.querySelector("#server_info");
    iframe.src = iframe.dataset.src;
    $.getJSON(API_URL + "/", function (data) {
        var form = document.querySelector("#update_site_info_form");
        form.name.value = data.name;
        form.phone.value = data.phone;
        form.address_contact.value = data.address_contact;
        form.url_facebook.value = data.url_facebook;
        form.url_google_map.value = data.url_google_map;
    });
}

function upload_license_file() {
    var form = document.querySelector("#upload_license_form");
    if (form.license.validity.valid) {
        document.querySelector("#modal h4").innerHTML = "<i class='fa fa-question' aria-hidden='true'></i> Mise a jour des license";
        document.querySelector("#modal div.modal-content div").innerHTML = "<b>" + form.license.files[0].name + "</b><div class='container'>Voulez vous utiliser ce fichier de license ? <br>les licenses actuels seront écrasées</div>"
                + "<div class='modal-footer'><a class='btn green' onclick='confirm_upload_license_file()'><i class='fa fa-upload' aria-hidden='true'></i> Envoyer</div></div>";
        $('#modal').modal('open');
    }
}

function confirm_upload_license_file() {
    var form = document.querySelector("#upload_license_form");
    if (form.license.validity.valid) {
        $.ajax({
            type: "POST",
            url: API_URL + "/license",
            data: new FormData(form),
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            dataType: "json",
            success: function (data, textStatus, jqXHR) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
                document.querySelector("#modal div.modal-content div").innerHTML = "Opération effectuée.";
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

function update_site_info() {
    if (check_update_site_info_form()) {
        var form = document.querySelector("#update_site_info_form");
        document.querySelector("#modal h4").innerHTML = "Modifier le site";
        document.querySelector("#modal div.modal-content div").innerHTML = "<div class='container row'><table class='centered bordered col s6 offset-s3'>"
                + "<thead><tr><th colspan='2'>Confirmer les modifications</th></tr></thead>"
                + "<tr><td><b>Nom</b></td><td>" + form.name.value + "</td></tr>"
                + "<tr><td><b>Téléphone</b></td><td>" + form.phone.value + "</td></tr>"
                + "<tr><td><b>Adresse de contact</b></td><td>" + form.address_contact.value + "</td></tr>"
                + "<tr><td><b>Page Facebook</b></td><td>" + form.url_facebook.value + "</td></tr>"
                + "<tr><td><b>Google Map</b></td><td>" + form.url_google_map.value.substring(0, 50) + "...</td></tr>"
                + "</table></div>"
                + "<div class='modal-footer'><a class='btn green' onclick='confirm_update_site_info()'><i class='fa fa-check' aria-hidden='true'></i> Confirmer</div></div>";
        $('#modal').modal('open');
    }
}
function confirm_update_site_info() {
    var form = document.querySelector("#update_site_info_form");
    if (check_update_site_info_form()) {
        var data = {
            name: form.name.value,
            phone: form.phone.value,
            address_contact: form.address_contact.value,
            url_facebook: form.url_facebook.value,
            url_google_map: form.url_google_map.value
        }
        $.ajax({
            type: "put",
            url: API_URL + "/",
            data: data,
            dataType: "json",
            success: function (data, textStatus, jqXHR) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-checked' aria-hidden='true'></i> Succes";
                document.querySelector("#modal div.modal-content div").innerHTML = "Opération effectuée.";
                window.setTimeout(function () {
                    //window.location.reload();
                }, 2000);
            },
            error: function (jqxhr, status, error) {
                document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
                document.querySelector("#modal div.modal-content div").innerHTML = error;
            }
        });
    }
}

function check_update_site_info_form() {
    var form = document.querySelector("#update_site_info_form");
    var valid = (
            form.name.validity.valid &&
            form.phone.validity.valid &&
            form.address_contact.validity.valid &&
            form.url_facebook.validity.valid &&
            form.url_google_map.validity.valid
            );
    if (valid) {
        $("#update_site_info_button").removeClass("disabled")
    } else {
        $("#update_site_info_button").addClass("disabled")
    }
    return valid;
}