document.addEventListener("DOMContentLoaded", function (e) {
    document.querySelector("div.row.content").style.backgroundImage = "url(" + SITE_ROOT + "/assets/image/background.jpg)";
    var table = document.querySelector("#file_table tbody");

    $.getJSON(API_URL + "/article/download", function (data) {
        document.querySelector(".card span").innerHTML += data.title;
        document.querySelector(".card p").innerHTML += data.content;
    });
    $.getJSON(API_URL + "/file", function (data) {
        for (var file of data) {
            table.innerHTML += "<tr id=file_" + file.file_id + ">"
                    + "<td>" + file.name + "</td>"
                    + "<td colspan='2'><small>" + file.description + "</small></td>"
                    + "<td><a target='_BLANK' href='" + API_URL + file.url + "' class='btn green wave-effects'><i class='fa fa-download' aria-hidden='true'></i></a>"
                    + (isAdmin() ? "<a class='btn red' onclick='delete_file(" + file.file_id + ")'><i class='fa fa-trash' aria-hidden='true'></i></a>" : "")
                    + "</td>"
                    + "</tr>";
        }
    }).fail(function () {
        table.innerHTML += "<tr><td colspan='4'><b>Il n'y as aucun fichier a tétécharger.</b></td></tr>";
    });
});