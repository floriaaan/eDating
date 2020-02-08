var mymap = L.map('mapid').setView([49.42266, 1.066265], 12);

function displayMap() {
    L.tileLayer('http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
        {
            maxZoom: 18,
            attribution: 'Map data &2opy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox.streets'
        })
        .addTo(mymap);
}


function displayUser(pos_x, pos_y, prenom, nom, age, campus, dateInscription, id) {
    /*var greenIcon = new L.Icon({
        iconUrl: '../doc/fmm.svg',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });



    L.marker([pos_x, pos_y],{icon: greenIcon})
        .bindPopup('<b>'+ prenom + ' ' + nom + '</b>')
        .addTo(mymap);*/

    L.circle([pos_x + (Math.random() / 666), pos_y + (Math.random() / 666)], {})
        .setRadius(100)
        .bindPopup('<h3>' + prenom + ' ' + nom + '</h3><br>' + age + ' ans<br>' +
            'Inscrit au campus de <b>' + campus + '</b> <br>' +
            'Membre depuis le <b>' + dateInscription + '</b><br>' +

            '<a href="/Mate/Profile/' + id + '" class="btn btn-outline-fmm mt-2 mx-auto">Voir son profil</a>')
        .addTo(mymap);


}