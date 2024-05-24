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

                    $('#hitung').append(`<button id="addFisik" data-count="${countByColor[color]}" data-image="${imageId}" class="btn btn-primary btn_hasil" style="background-color: ${color}; border-color: ${color}">Warna ${color}: ${countByColor[color]}</button>`);
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
        
        // BEGIN isoittd_upload_fisik
        edtisoittd_upload_fisik = new $.fn.dataTable.Editor( {
            ajax: {
                url: "../../models/isoittd_upload/isoittd_upload_fisik_pointer_v2.php",
                type: 'POST',
                data: function (d){
                }
            },
            formOptions: {
                main: {
                    focus: 12,
                    onBackground: 'none'
                }
            },
            fields: [ 
                {
                    label: "isoittd_upload_fisik.start_at",
                    name: "isoittd_upload_fisik.start_at",
                    type: "hidden"
                },	
                {
                    label: "isoittd_upload_fisik.finish_at",
                    name: "isoittd_upload_fisik.finish_at",
                    type: "hidden"
                },	
                {
                    label: "nama_tabel",
                    name: "nama_tabel",
                    def: "isoittd_upload_fisik",
                    type: "hidden"
                },	
                {
                    label: "isoittd_upload_fisik.transaction_state",
                    name: "isoittd_upload_fisik.transaction_state",
                    type: "hidden",
                    def: 0
                },	
                {
                    label: "Kode",
                    name: "isoxxth_upload_fisik.id_isoxxth_upload",
                    type: "hidden",
					def: id_isoxxth_upload_filter
				},
                {
                    label: "Item",
                    name: "isoittd_upload_fisik.id_isoittd_upload",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/isoittd_upload/isoittd_upload_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_isoittd_upload_old: id_isoittd_upload_old,
									id_isoxxth_upload_old: id_isoxxth_upload_filter,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1,
						},
					}
				},
                {
                    label: "Fisik <sup class='text-danger'>*<sup>",
                    name: "isoittd_upload_fisik.fisik",
                    type: "readonly"
                }, 	
                // {
                //     label: "Images",
                //     name: "files[].id",
                //     type: "uploadMany",
                //     display: function ( fileId, counter ) {
                //         if (fileId == 0){
                //             return 'Belum ada lampiran';
                //         }else{
                //             return '<a href="'+edtisoittd_upload_fisik.file( 'files', fileId ).web_path+'" target="_blank">'+ edtisoittd_upload_fisik.file( 'files', fileId ).filename + '</a>'; 
                //         }
                //     },
                // },	
                {
                    label: "Gambar",
                    name: "foto",
                    type: "hidden"
                },
                {
                    label: "Keterangan",
                    name: "isoittd_upload_fisik.keterangan",
                    type: "textarea"
                }
            ]
        } );

        edtisoittd_upload_fisik.on("open", function (e, mode, action) {
            $(".modal-dialog").addClass("modal-lg");
        });

        edtisoittd_upload_fisik.dependent( 'isoxxth_upload_fisik.id_isoxxth_upload', function ( val, data, callback ) {
            if (val > 0) {
                // console.log(val);
                id_isoxxth_upload_old = val;
            }
            return {}
        }, {event: 'keyup change'});

        edtisoittd_upload_fisik.on( 'preSubmit', function (e, data, action) {
            if(action != 'remove'){
                fisik           = edtisoittd_upload_fisik.field('isoittd_upload_fisik.fisik').val();

                validasiRequired(
                    edtisoittd_upload_fisik,
                    'isoittd_upload_fisik',
                    {
                        'fisik': fisik,
                    }
                );

                validasiNumber(
                    edtisoittd_upload_fisik,
                    'isoittd_upload_fisik',
                    {
                        'fisik': fisik
                    },
                    0,
                    '>='
                );
            }
            
            if ( edtisoittd_upload_fisik.inError() ) {
                return false;
            }
        });

        edtisoittd_upload_fisik.on('initSubmit', function(e, action) {
            finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
            edtisoittd_upload_fisik.field('isoittd_upload_fisik.finish_at').val(finish_at);
        });
            
        edtisoittd_upload_fisik.on( 'postSubmit', function (e, json, data, action, xhr) {
        } );

        edtisoittd_upload_fisik.on( 'close', function () {
            edtisoittd_upload_fisik.enable();
        } );

        $('#hitung').on('click', '#addFisik', function (e) {
            e.preventDefault();
            var count = $(this).data('count');
            var image = $(this).data('image');
            // console.log(count);
            // console.log(image);
                
            edtisoittd_upload_fisik.on( 'preOpen', function( e, mode, action ) {
                
                start_at = moment().format('YYYY-MM-DD HH:mm:ss');
                edtisoittd_upload_fisik.field('isoittd_upload_fisik.start_at').val(start_at);
                edtisoittd_upload_fisik.field('isoittd_upload_fisik.fisik').val(count);
                edtisoittd_upload_fisik.field('foto').val(image);
                // console.log(image);
                // console.log(file);
                // edtisoittd_upload_fisik.field('files[].id').val([file]);
                
                // console.log(countByColor[color]);
                // edtisoittd_upload_fisik.field('files[]').input().files = [file];
                // console.log(count);
            });
            
            var clickedButton = $(this); // Store a reference to the clicked button
            edtisoittd_upload_fisik.title('Input Fisik').buttons(
                {
                    label: 'Submit',
                    className: 'btn btn-primary',
                    action: function () {
                        this.submit();
                        clickedButton.hide(); // Hide the clicked button after submission
                        
                        var visibleButtons = $('#hitung #addFisik:visible').length;
                        // console.log("Jumlah tombol yang tidak tersembunyi: " + visibleButtons);

                        if (visibleButtons == 0) {
                            $('#go').prop('disabled', false);
                            $('#frmisoittd_upload :input').prop('disabled', false);
                            $('#inputfileUpload').prop('disabled', false);
                        }
                    }
                }
            ).create();
        });
        
        //show, berapa button yang tidak di hide
    }

</script>