$(document).ready(function() {
    $('#locationAutoBtn').click(function () {
        navigator.geolocation.getCurrentPosition(function (pos) {
            let crd = pos.coords;
            console.log('Votre position actuelle est :');
            console.log(`Latitude : ${crd.latitude}`);
            console.log(`Longitude : ${crd.longitude}`);
            console.log(`La précision est de ${crd.accuracy} mètres.`);

            $('#registerLat').val(`${crd.latitude}`);
            $('#registerLong').val(`${crd.longitude}`);

            $('#locationTicked').html('<i class="fas fa-check-circle"></i>');
            $('#registerSubmit').removeClass('disabled');

        }, function (err) {
            console.warn(`ERREUR (${err.code}): ${err.message}`);
            $('#locationTicked').html('<i class="fas fa-exclamation-circle"></i>');

        }, {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        });



    });

    $('#registerImg').on('change',function(){
        let fileName = document.getElementById("registerImg").files[0].name;
        $('#registerImgName').addClass("selected").html(fileName);
    })
});