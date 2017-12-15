document.addEventListener("DOMContentLoaded", function (e) {
    document.title = SITE_NAME + " | Les Activitées";
    document.querySelector("div.row.content").style.backgroundImage = "url(" + SITE_ROOT + "/assets/image/background.jpg)";
    $.getJSON(API_URL + "/article/cours_particuliers", (data) => {
        document.querySelector("#cours_part span.card-title").innerHTML = data.title;
        document.querySelector("#cours_part p").innerHTML = data.content;
    });
    $.getJSON(API_URL + "/article/stages", (data) => {
        document.querySelector("#stages span.card-title").innerHTML = data.title;
        document.querySelector("#stages p").innerHTML = data.content;
    });
    $.getJSON(API_URL + "/article/groupes", (data) => {
        document.querySelector("#groupe span.card-title").innerHTML = data.title;
        document.querySelector("#groupe p").innerHTML = data.content;
    });
    var tl = new TimelineLite();
    tl.staggerFrom($(".card"), 0.3, {alpha: 0, scale:0.1}, 0.1);

});

function tarif_cours() {
    $.getJSON(API_URL + "/price/cours_particulier_1", function (data) {//    1 PERSONNE
        document.querySelector("#modal h4").innerHTML = "Tarifs des Cours Particuliers";
        document.querySelector("#modal div.modal-content div").innerHTML = "<h6>Des cours particuliers sont proposé sur " + data[0].support + "</h6>";
        let tableHTML = get_tarif_table(data, "1 Personne");
        $.getJSON(API_URL + "/price/cours_particulier_2", function (data) {//    2 PERSONNE
            tableHTML += get_tarif_table(data, "2 Personnes");
            $.getJSON(API_URL + "/price/cours_particulier_3", function (data) {//    3 PERSONNE
                tableHTML += get_tarif_table(data, "3 Personnes")
                        + "<a href='" + SITE_ROOT + "/reservation' class='btn green'>Reservation</a>";
                document.querySelector("#modal div.modal-content div").innerHTML += tableHTML;
                $('#modal').modal('open');
            });
        });
    });
}


function tarif_stage() {
    $.getJSON(API_URL + "/price/stage_optimist", function (data) {//    OPTIMIST
        document.querySelector("#modal h4").innerHTML = "Tarifs des Stages";
        let tableHTML = get_tarif_table(data, data[0].support);
        $.getJSON(API_URL + "/price/stage_laser", function (data) {//    LASER
            tableHTML += get_tarif_table(data, data[0].support);
            $.getJSON(API_URL + "/price/stage_planche_a_voile", function (data) {//    PLANCHE A VOILE
                tableHTML += get_tarif_table(data, data[0].support);
                $.getJSON(API_URL + "/price/stage_catamaran", function (data) {//    CATAMARAN
                    tableHTML += get_tarif_table(data, data[0].support)
                            + "<a href='" + SITE_ROOT + "/reservation' class='btn green'>Reservation</a>";
                    document.querySelector("#modal div.modal-content div").innerHTML = tableHTML;
                    $('#modal').modal('open');
                });
            });
        });
    });
}


function tarif_groupe() {
    $.getJSON(API_URL + "/price/groupe_1", function (data) {//    ACTIVITE DE GROUPE
        document.querySelector("#modal h4").innerHTML = "Tarifs des Cours Particuliers";
        document.querySelector("#modal div.modal-content div").innerHTML = "<h6>Activitées de groupes sur " + data[0].support + "</h6>";
        let tableHTML = get_tarif_table(data, "Séances de 2h (Tarifs par stagiaire)") + "<span class='right'>Maximum 10 embarcations</span>";
        $.getJSON(API_URL + "/price/groupe_2", function (data) {//    FORFAITS CARAVELLE
            tableHTML += get_tarif_table(data, "Caravelle (6 enfants max.)")
                    + "<a href='" + SITE_ROOT + "/reservation' class='btn green'>Reservation</a>";
            document.querySelector("#modal div.modal-content div").innerHTML += tableHTML;
            $('#modal').modal('open');
        });
    });
}

function condition_cours() {
    $.getJSON(API_URL + "/article/cours_particuliers_conditions", (data) => {
        document.querySelector("#modal h4").innerHTML = data.title;
        document.querySelector("#modal div.modal-content div").innerHTML = "<p>" + data.content + "</p>";
        $('#modal').modal('open');
    });
}

function condition_stages() {
    $.getJSON(API_URL + "/article/stages_conditions", (data) => {
        document.querySelector("#modal h4").innerHTML = data.title;
        document.querySelector("#modal div.modal-content div").innerHTML = "<p>" + data.content + "</p>";
        $('#modal').modal('open');
    });
}

function condition_groupes() {
    $.getJSON(API_URL + "/article/groupes_conditions", (data) => {
        document.querySelector("#modal h4").innerHTML = data.title;
        document.querySelector("#modal div.modal-content div").innerHTML = "<p>" + data.content + "</p>";
        $('#modal').modal('open');
    });
}

function get_tarif_table(data, title) {
    let tableHtml = "<table class='centered responsive-table highlight bordered striped'>"
            + " <thead class='grey lighten-2'>"
            + "     <tr><th colspan='2'>" + title + "</th></tr>"
            + " </thead>"
            + " <tbody>";
    for (let price of data) {
        tableHtml += "     <tr>"
                + "         <td>"
                + "             " + price.duration
                + "         </td>"
                + "         <td>"
                + "             " + Math.round(price.price) + " €"
                + "         </td>"
                + "     </tr>";
    }
    tableHtml += " </tbody>"
            + "</table>";
    return tableHtml;
}
