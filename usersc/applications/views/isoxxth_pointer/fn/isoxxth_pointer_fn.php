<script>
    function replaceCanvasImage(imageData) {
        // $('#iboxfilter').addClass("collapsed");
        $('#hasil').empty();
        fabric.Image.fromURL(imageData, function(img) {
            img.set({
                left: 0,
                top: 0,
                selectable: false
            });
            canvas.clear();
            canvas.add(img);
            canvas.setDimensions({ width: img.width, height: img.height });
            canvas.renderAll();
        });

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
        var dataURL = canvas.toDataURL('image/jpeg');
        var imageData = dataURL.replace(/^data:image\/(png|jpeg);base64,/, '');
        var blob = base64ToBlob(imageData, 'image/jpeg');
        var formData = new FormData();
        formData.append('canvasImage', blob);
        formData.append('imageId', imageId); 
        formData.append('warna', warna); 

        $.ajax({
            url: "../../models/isoxxth_pointer/isoxxth_pointer.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (json) {
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