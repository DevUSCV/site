document.addEventListener("DOMContentLoaded", function (e) {
    document.querySelector("div.row.content").style.backgroundImage = "url(" + SITE_ROOT + "/assets/image/background.jpg)";
    tinymce.init({
        language: 'fr_FR',
        selector: 'textarea',
        branding: false,
        menubar: false,
        force_br_newlines: true,
        force_p_newlines: false,
        forced_root_block: '',
        fontsize_formats: '6px 7px 8px 9px 10px 11px 12px 13px 14px 18px 24px 36px',
        plugins: "link image media table wordcount textcolor preview autolink",
        toolbar: [
            'undo redo | styleselect fontsizeselect | bold italic underline | link image media | table | alignleft aligncenter alignright | forecolor backcolor | preview'
        ],
        style_formats: [
            {
                title: 'Image Gauche',
                selector: 'img',
                styles: {
                    'float': 'left',
                    'margin': ' 5px 10px'
                }
            },
            {
                title: 'Image Droite',
                selector: 'img',
                styles: {
                    'float': 'right',
                    'margin': ' 5px 10px'
                }
            }
        ],
        style_formats_merge: true,
        style_formats_autohide: true
    });
});

function init(article_name) {
    var form = document.querySelector("#article_editor");
    $.getJSON(API_URL + "/article/" + article_name, (data) => {
        form.title.value = data.title;
        form.article_id.value = data.article_id;
        tinymce.get('content').on('init', function (e) {
            e.target.setContent(data.content);
        });
    }).fail(function () {
        window.setTimeout(window.history.back(), 2000);
    });
}

function save() {
    var form = document.querySelector("#article_editor");
    var article_id = parseInt(form.article_id.value);
    var title = form.title.value;
    var content = tinymce.get('content').getContent();

    var error = false;
    if (article_id === 0) {
        error = "Identifiant d'article inconnu.";
    } else if (title.length === 0) {
        error = "Veuillez saisir un titre.";
    } else if (content.length === 0) {
        error = "Veuillez saisir un contenue."
    }

    if (!error) {
        document.querySelector("#modal h4").innerHTML = "<i class='fa fa-check' aria-hidden='true'></i> Article Valide";
        document.querySelector("#modal div.modal-content div").innerHTML = "<h3>" + title + "</h3><p>" + content + "</p>"
                + "<div class='modal-footer'><a id='confirm_button' class='btn green'><i class='fa fa-paper-plane' aria-hidden='true'></i> Envoyer</a></div>";
        $('#modal').modal('open');
        document.querySelector("#confirm_button").addEventListener("click", function (e) {
            console.log("AJAX");
            $.ajax({
                url: API_URL + /article/ + article_id,
                type: "PUT",
                dataType: 'json',
                data: {
                    title: title,
                    content: content
                },
                success: function (data) {
                    document.querySelector("#modal h4").innerHTML = "<i class='fa fa-check' aria-hidden='true'></i> Succes";
                    document.querySelector("#modal div.modal-content div").innerHTML = "Moddifications Enregistrées.";
                    window.setTimeout(function(){
                        window.history.back();
                    }, 2000);
                },
                error: function (jqxhr, status, error) {
                    document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Echec";
                    document.querySelector("#modal div.modal-content div").innerHTML = error;
                }
            });
        });
    } else {
        document.querySelector("#modal h4").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Une erreur est survenue:";
        document.querySelector("#modal div.modal-content div").innerHTML = "<p>" + error + "</p>";
        $('#modal').modal('open');
    }
}