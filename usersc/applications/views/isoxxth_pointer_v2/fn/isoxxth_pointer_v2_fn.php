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
        c_circle++;

    }

    function removeCircle(circle) {
        canvas.remove(circle);
        c_circle--;
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

    function hitungWarna() {
        var circles = canvas.getObjects('circle');
        var countByColor = {};

        // console.log("circles = "+circles);
        circles.forEach(function(circle) {
            var color = circle.fill;
            console.log(circle);
            if (!countByColor[color]) {
                countByColor[color] = 1;
            } else {
                countByColor[color]++;
            }
        });
        
        $('#hitung').empty();
        // Tampilkan jumlah lingkaran per warna di dalam elemen #hitung
        for (var color in countByColor) {
            if (countByColor.hasOwnProperty(color)) {
                $('#hitung').append(`<h3 style="color: ${color}">Warna ${color}: ${countByColor[color]}</h3>`);
                
                // Ubah kanvas menjadi gambar
                var canvasDataUrl = canvas.toDataURL({
                    format: 'png',
                    quality: 1
                });

                // Buat elemen gambar baru dan tambahkan ke dalam elemen #hasil
                var img = document.createElement('img');
                img.src = canvasDataUrl;
                $('#hasil').html(img);
            }
        }
    }

// function hitungWarna() {
//     var circles = canvas.getObjects('circle');
//     var circlesByColor = {};

//     // Group circles by fill color
//     circles.forEach(function(circle) {
//         var color = circle.fill;
//         if (!circlesByColor[color]) {
//             circlesByColor[color] = [];
//         }
//         circlesByColor[color].push(circle);
//     });

//     $('#hasil').empty(); // Clear the #hasil element
//     // Debugging the code
//     // console.log("Number of circles:", circles.length);
//     // console.log("Circles grouped by color:", circlesByColor);

//     // Iterate over circles grouped by color
//     for (var color in circlesByColor) {
//         if (circlesByColor.hasOwnProperty(color)) {
//             var circlesGroup = circlesByColor[color];

//             // Create a canvas for each group of circles with the same fill color
//             var canvasCopy = new fabric.Canvas();

//             // Iterate over circles in the group
//             circlesGroup.forEach(function(circle) {
//                 var circleCopy = new fabric.Circle({
//                     radius: circle.radius,
//                     fill: circle.fill,
//                     left: circle.left,
//                     top: circle.top
//                 });

//                 // Add circle to canvasCopy
//                 canvasCopy.add(circleCopy);
//                 canvasCopy.renderAll(); // Render circle immediately after adding
//             });

//             // Log canvasCopy for debugging
//             console.log("Canvas Copy:", canvasCopy);

//             // Convert canvasCopy to an image
//             var canvasDataUrl = canvasCopy.toDataURL({
//                 format: 'png',
//                 quality: 1
//             });

//             // Log canvasDataUrl for debugging
//             console.log("Canvas Data URL:", canvasDataUrl);

//             // Create a new image element and append it to the #hasil element
//             var img = document.createElement('img');
//             img.src = canvasDataUrl;

//             // Log img for debugging
//             console.log("Image Element:", img);

//             $('#hasil').append(img); // Append image inside the loop
//         }
//     }



// }


</script>