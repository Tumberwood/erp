<script>
    var backgroundBlob;
    
    function replaceCanvasImage(imageData) {
        // Remove all objects from the canvas
        canvas.clear();

        // Set the image as the background of the canvas
        fabric.Image.fromURL(imageData, function(img) {
            // Set canvas dimensions to match the image size
            canvas.setDimensions({ width: img.width, height: img.height });

            // Set the image as the background with configuration
            canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
                // Make the image the background without resizing it
                scaleX: canvas.width / img.width,
                scaleY: canvas.height / img.height,
                top: 0,
                left: 0,
                originX: 'left',
                originY: 'top' // Ensure the background image starts from the top-left corner
            });
        });

        // Render canvas
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
        // console.log(c_circle);
        $('#inputfileUpload').prop('disabled', true);
    }

    function removeCircle(circle) {
        canvas.remove(circle);
        c_circle--;
        // console.log(c_circle);
        if (c_circle == 0) {
            $('#inputfileUpload').prop('disabled', false);
        } else {
            $('#inputfileUpload').prop('disabled', true);
        }
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

    function hitungWarna(imageData, callback) {
        //Inputan File disable ketika sudah di analisa
        $('#inputfileUpload').prop('disabled', true);

        //filter kode disable ketika analisa
        $('#go').prop('disabled', true);
        $('#frmisoittd_upload :input').prop('disabled', true);

        var circles = canvas.getObjects('circle');
        var countByColor = {};
        var circleOldAnalisis = new Set(); // Menggunakan Set untuk menyimpan nilai analisis yang unik

        // Iterate over each circle to count and display
        circles.forEach(function(circle) {
            var color = circle.fill;

            var analisis = color + '-' + circle.left + '-' + circle.top;
            // console.log(analisis);

            // Jika analisis belum ada dalam Set, tambahkan ke Set dan array circleOldAnalisis
            if (!circleOldAnalisis.has(analisis)) {
                circleOldAnalisis.add(analisis);

                if (!countByColor[color]) {
                    countByColor[color] = 1;
                } else {
                    countByColor[color]++;
                }
            }
        });

        // console.log([...circleOldAnalisis]); // Ubah Set kembali menjadi array saat mencetak
        // console.log(countByColor);

        $('#hitung').empty();
        $('#hasil').empty(); // Clear any previous images

        // Set the canvas with filtered circles
        canvas.clear().renderAll();
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

            // Loop through each color
            var simpanFoto = {};
            for (var color in countByColor) {
                if (countByColor.hasOwnProperty(color)) {
                    canvas.forEachObject(function(object) {
                        canvas.remove(object);
                    });

                    //Enable Save ketika sudah ada warna
                    $('#saveBtn').prop('disabled', false);

                    // Filter circles by color
                    var filteredCircles = circles.filter(function(circle) {
                        return circle.fill === color;
                    });

                    // Remove circles with different colors
                    var circlesToRemove = circles.filter(function(circle) {
                        return circle.fill !== color;
                    });
                    canvas.remove.apply(canvas, circlesToRemove);

                    // Add circles with the current color
                    filteredCircles.forEach(function(circle) {
                        canvas.add(circle);
                    });
                    
                    // Create the fabric.Text object
                    var totalText = new fabric.Text(`Total Circles: ${countByColor[color]}`, {
                        left: 10,
                        top: 10,
                        fill: color
                    });

                    // Measure text width and height
                    var textWidth = totalText.width;
                    var textHeight = totalText.height;

                    // Create a black background rectangle
                    var backgroundRect = new fabric.Rect({
                        left: 5,
                        top: 5,
                        width: textWidth + 5, // Adjust width based on text width and padding
                        height: textHeight + 5, // Adjust height based on text height and padding
                        fill: 'black',
                        opacity: 0.8, // Adjust opacity if needed
                        rx: 5, // Rounded corners
                        ry: 5 // Rounded corners
                    });

                    // Add the background rectangle behind the text
                    canvas.add(backgroundRect);

                    // Add the text on top of the background rectangle
                    canvas.add(totalText);

                    // Bring the text to the front
                    totalText.bringToFront();


                    // Convert canvas to image
                    var canvasDataUrl = canvas.toDataURL({
                        format: 'png',
                        quality: 1
                    });

                    // Create image element and append it to #hasil
                    var img = document.createElement('img');
                    img.src = canvasDataUrl;
                    $('#hasil').append(img); // Append the image to #hasil
                    
                    var circleImageData = canvasDataUrl.replace(/^data:image\/(png|jpeg);base64,/, '');
                    var circleBlob = base64ToBlob(circleImageData, 'image/jpeg');
                    var imageId = Date.now();

                    simpanFoto[imageId] = circleBlob;

                    // console.log(imageId);

                    // var formData = new FormData();
                    // formData.append('canvasImage', circleBlob);
                    // formData.append('imageId', imageId); 

                    // $.ajax({
                    //     url: "../../models/isoxxth_pointer/isoxxth_pointer_v2.php",
                    //     type: 'POST',
                    //     data: formData,
                    //     processData: false,
                    //     contentType: false,
                    //     success: function (json) {
                    //         var imageId = json.data.imageId;
                    //         console.log(imageId);
                    //     },
                    //     error: function (xhr, status, error) {
                    //         console.error(xhr, status, error);
                    //     }
                    // });

                    $('#hitung').append(`<h3 id="addFisik" data-count="${countByColor[color]}" data-image="${imageId}" class="btn btn-primary btn_hasil" style="background-color: ${color}; border-color: ${color}">Warna ${color}: ${countByColor[color]}</h3>`);
                    $('.btn_hasil').prop('disabled', true); 
                }
            }
            callback(simpanFoto);

            // Restore all circles
            canvas.renderAll();
            circles.forEach(function(circle) {
                canvas.add(circle);
            });
        });

        // $('#analyzeBtn').hide();
        //show, berapa button yang tidak di hide
    }


    // Fungsi resizeImage
    function resizeImage(file, maxWidth, maxHeight, quality) {
        return new Promise((resolve, reject) => { //return Promise ini digunakan jika ada funtion tambahakn then() atau catch()
            var reader = new FileReader(); //ini untuk membaca data URL dari gambar/objek 
            reader.onload = function(event) { //load reader tadi dengan function event
                var image = new Image(); //buat image baru
                image.src = event.target.result; //src nya ini dari target result yang dari URL reader tadi yang udah berubah nama jadi event
                image.onload = function() { //image nya di load
                    var width = image.width; //buat variable width dari width asli gambar yang di load
                    var height = image.height; //buat variable height dari height asli gambar yang di load

                    //disini untuk penyesuaian gambar atau resize gambarnya
                    if (width > height) {
                        if (width > maxWidth) {
                            height *= maxWidth / width;
                            width = maxWidth;
                        }
                    } else {
                        if (height > maxHeight) {
                            width *= maxHeight / height;
                            height = maxHeight;
                        }
                    }

                    //buat canvas baru dengan ukuran yang baru aja di resize diatas
                    var canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;

                    //gambar ulang disini gambarnya sesuai ukuran canvas tadi
                    var ctx = canvas.getContext('2d');
                    ctx.drawImage(image, 0, 0, width, height);

                    //gambarnya diubah jadi blob
                    canvas.toBlob(function(blob) {
                        resolve(blob);
                    }, 'image/jpeg', quality);
                };
            };
            reader.readAsDataURL(file);
        });
    }


</script>