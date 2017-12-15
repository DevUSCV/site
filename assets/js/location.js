document.addEventListener("DOMContentLoaded", function (e) {
    document.title = SITE_NAME + " | Tarif des Locations";
    document.querySelector("div.row.content").style.backgroundImage = "url(" + SITE_ROOT + "/assets/image/background.jpg)";

    $.getJSON(API_URL + "/location", function (data) {
        document.querySelector("div.row.location").innerHTML = get_location_tarif_table(data);
        var tl = new TimelineLite();
        tl.staggerFrom($("table tbody tr"), 0.5, {alpha: 0}, 0.1);
    });

});

function get_location_tarif_table(data) {
    var tableHtml = "<table class='centered responsive-table highlight'>"
            + " <thead class='grey darken-3 white-text'>"
            + "     <tr>"
            + "<th>Catégorie</th>"
            + "<th>Demi-heure</th>"
            + "<th>1 Heure</th>"
            + "<th>2 Heures</th>"
            + "<th>Demi Journée</th>"
            + "<th>Journée</th>"
            + "</tr>"
            + " </thead>"
            + " <tbody>";
    for (var price of data) {
        tableHtml += "     <tr class='white' data-description='" + price.description + "' data-image='" + price.image_url + "' onclick='show_desc(this)'>"
                + "         <td>" + price.name + "</td>"
                + "         <td>" + (price.half_hour > 0 ? Math.round(price.half_hour) + "€" : "-") + "</td>"
                + "         <td>" + (price.hour > 0 ? Math.round(price.hour) + "€" : "-") + "</td>"
                + "         <td>" + (price.two_hour > 0 ? Math.round(price.two_hour) + "€" : "-") + "</td>"
                + "         <td>" + (price.half_day > 0 ? Math.round(price.half_day) + "€" : "-") + "</td>"
                + "         <td>" + (price.day > 0 ? Math.round(price.day) + "€" : "-") + "</td>"
                + "     </tr>";
    }
    tableHtml += " </tbody>"
            + "</table>";
    return tableHtml;
}

function show_desc(item) {
    console.log(item);
        document.querySelector("#modal h4").innerHTML = item.childNodes[1].innerText;
        document.querySelector("#modal div.modal-content div").innerHTML = "<img src='" + API_URL + item.dataset.image + "' class='responsive-img'>" 
                + "<p>" + item.dataset.description + "</p>";
        $('#modal').modal('open');
}