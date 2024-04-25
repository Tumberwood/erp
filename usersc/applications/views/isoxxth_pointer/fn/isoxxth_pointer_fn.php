<script>
    var backgroundBlob;

    function replaceCanvasImage(imageData) {
        // Hapus semua objek yang ada di canvas
        canvas.clear();

        // Atur gambar sebagai latar belakang canvas
        fabric.Image.fromURL(imageData, function(img) {
            // Mengatur ukuran canvas sesuai ukuran gambar
            canvas.setDimensions({ width: img.width, height: img.height });

            // Atur gambar sebagai latar belakang dengan konfigurasi
            canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
                // Menjadikan gambar sebagai latar belakang tanpa mengubah ukurannya
                scaleX: canvas.width / img.width,
                scaleY: canvas.height / img.height,
                top: 0,
                left: 0
            });

            var backgroundDataURL = canvas.toDataURL('image/jpeg');
            var backgroundImageData = backgroundDataURL.replace(/^data:image\/(png|jpeg);base64,/, '');
            backgroundBlob = base64ToBlob(backgroundImageData, 'image/jpeg');
        });

        // Render ulang canvas
        canvas.renderAll();

        
    }

    function addCircle(left, top) {
        var circle = new fabric.Circle({
            radius: circleSize * 10,
            fill: warna,
            left: left,
            top: top,
            originX: 'center',
            originY: 'center',
            selectable: true
        });
        canvas.add(circle);
        canvas.bringToFront(circle);
        canvas.renderAll(); // Render circle immediately after adding
    }

    function base64ToBlob(base64Data, contentType) {
        var sliceSize = 512;
        var byteCharacters = atob(base64Data);
        var byteArrays = [];
        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);
            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }
            var byteArray = new Uint8Array(byteNumbers);
            byteArrays.push(byteArray);
        }
        var blob = new Blob(byteArrays, { type: contentType });
        return blob;
    }

    function hitungWarna(imageId) {

        // var backgroundDataURL = canvas.toDataURL('image/jpeg');
        // var backgroundImageData = backgroundDataURL.replace(/^data:image\/(png|jpeg);base64,/, '');
        // var backgroundBlob = base64ToBlob(backgroundImageData, 'image/jpeg');

        canvas.setBackgroundImage(null);

        var circleDataURL = canvas.toDataURL({
            format: 'jpeg',
            quality: 1,
            multiplier: 1,
            left: 0,
            top: 0,
            width: canvas.width,
            height: canvas.height
        });
        
        var circleImageData = circleDataURL.replace(/^data:image\/(png|jpeg);base64,/, '');
        var circleBlob = base64ToBlob(circleImageData, 'image/jpeg');

        var formData = new FormData();
        formData.append('canvasImage', circleBlob);
        formData.append('imageId', imageId); 
        formData.append('warna', warna); 
        formData.append('backgroundImage', backgroundBlob);

        $.ajax({
            url: "../../models/isoxxth_pointer/isoxxth_pointer.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (json) {
                console.log(json);
                if(json.data.status_code == 200){

                    var urlhasil = json.data.output_file;
                    $('#hasil').html('<img src="' + urlhasil + '" class="img-fluid">');
                    location.href = "#hasil"; 
                    toastr.remove();
				    toastr["success"]("Proses hitung berhasil","INFO")
                }
                
            },
            error: function (xhr, status, error) {
                console.error(xhr, status, error);
            }
        });

    }

</script>