<script>
    function getLocation(){
        // Mendapatkan lokasi menggunakan navigator.geolocation
        if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
        } else {
        // console.log("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        // Menampilkan lat dan long
        // console.log("Latitude: " + latitude);
        // console.log("Longitude: " + longitude);
        edthtsprtd.field('htsprtd.lat').val(latitude);
        edthtsprtd.field('htsprtd.lng').val(longitude);
        
        // Menggunakan Nominatim untuk mendapatkan alamat
        var url = `https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`;
        
        fetch(url)
        .then(response => response.json())
        .then(data => {
            // Menampilkan alamat
            // console.log("Alamat: " + data.display_name);
            edthtsprtd.field('htsprtd.lokasi').val(data.display_name);
        })
            .catch(error => {
            // console.log("Error:", error);
        });
    }

</script>