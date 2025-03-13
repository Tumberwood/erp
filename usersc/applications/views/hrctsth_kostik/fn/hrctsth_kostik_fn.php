<script>
	$('#start_date').datepicker('setDate', tanggal_hariini_dmy);
    
    var finishKostik = false;

    //ALERT KETIKA RELOAD 
    function confirmLeavePage(event) {
      event.preventDefault();
      event.returnValue = 'Are you sure you want to leave this page? Your progress will be lost.';
    }

    window.addEventListener('beforeunload', confirmLeavePage);

    function noKtp() {
        var kode = $('#kode').val();
        console.log(kode);
        start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

        $.ajax({
            url: '../../models/hrctsth_kostik/validate.php',
            dataType: 'json',
            type: 'POST',
            data: {
                kode: kode
            },
            success: function(json) {
                $('#nama').val(json.nama);
                $('#hetxxmh').val(json.hetxxmh);

                if (start_date == 'Invalid date') {
                    toastr.error("Tanggal wajib diisi!", "INFO");
                } else {
                    if (!json.nama) {
                            toastr.error("Kode tes yang Anda masukkan tidak valid!", "INFO");
                            // document.getElementById('button_modal1').style.display = 'none';
                    } else {
                        document.getElementById('kirim').style.display = 'none';
                        document.getElementById('kode').disabled = true;
    
                        if (json.status_kostik == 1) {
                            alert('Tes kostik Sedang Berlangsung.');
                            window.removeEventListener('beforeunload', confirmLeavePage);
                            window.location.reload();
                        } else if (json.status_kostik == 2) {
                            alert('Tes kostik Sudah Berakhir.');
                            window.removeEventListener('beforeunload', confirmLeavePage);
                            window.location.reload();
                        } else {
                            // startQuiz();
                            document.getElementById('goToQuiz').style.display = 'block';
                            document.getElementById('button_modal1').style.display = 'block';
                        } 
                    }
                }
            }
        });
    }


    //SESI 1
    
    function startQuiz() {
        document.getElementById('goToQuiz').style.display = 'none';
        $('#start_date').prop('disabled', true);
        start_at = moment().format('YYYY-MM-DD HH:mm:ss');
        
        start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
        console.log(start_date);

        // Show the quiz container
        document.getElementById('quiz1').style.display = 'block';

        // default 720 detik
        var timerDuration = 720; // Change this value to set the desired countdown time

        // Start the countdown
        startCountdown(timerDuration);
    }
    function finishQuiz() {
        // Generate a random code
        var confirmation = confirm("Apakah Anda Yakin Ingin Mengakhiri Tes Kostik?");

        if (confirmation) {
            var result = []; // Store the result as an array
            var unansweredQuestions = [];

            for (var i = 0; i < tables.length; i++) {
                var questions = tables[i].querySelectorAll('tbody tr');

                for (var j = 0; j < questions.length; j++) {
                    var questionRow = questions[j];
                    var checkboxes = questionRow.getElementsByTagName('input');
                    var checkedAnswer = '';

                    for (var k = 0; k < checkboxes.length; k++) {
                        if (checkboxes[k].checked) {
                            checkedAnswer = checkboxes[k].value;
                            break;
                        }
                    }

                    if (checkedAnswer === '') {
                        var questionNumber = (j + 1);
                        var tableNumber = (i + 1);
                        unansweredQuestions.push('Tolong periksa soal No ' + questionNumber + ' Pada Tabel ' + tableNumber + '.');
                    }
                }
            }

            if (unansweredQuestions.length > 0) {
                var alertMessage = unansweredQuestions.join('\n');
                alert(alertMessage);
            } else {
                finishGet();
                finishKostik = true;
            }
        } else {
            // Code does not match, handle the error or show an appropriate message
            alert('Kode yang Anda masukkan salah. Silakan coba lagi.');
        }
    }


    
    function finishGet() {
        var kode = $('#kode').val(); // Get the value of an element with the ID "id_hcd"
        var result = []; // Store the result as an array
        var unansweredQuestions = [];

        for (var i = 0; i < tables.length; i++) {
            var questions = tables[i].querySelectorAll('tbody tr');

            for (var j = 0; j < questions.length; j++) {
                var questionRow = questions[j];
                var checkboxes = questionRow.getElementsByTagName('input');
                var checkedAnswer = '';

                for (var k = 0; k < checkboxes.length; k++) {
                    if (checkboxes[k].checked) {
                        checkedAnswer = checkboxes[k].value;
                        break;
                        }
                    }
                    result.push({
                    table: 'Tabel ' + (i + 1) + ', Soal No.' + (j + 1),
                    jawaban: checkedAnswer
                });
            }
        }

        console.log(result);
        // Send the selected answers and other data to the server-side PHP script using AJAX
        $.ajax({
            url: '../../models/hrctsth_kostik/insertData.php',
            dataType: 'json',
            type: 'POST',
            data: {
                result: result,
                kode: kode
            },
            success: function(json) {
                // Handle the response from the server-side script
                $.notify({
                    message: json.message
                }, {
                    type: json.type_message
                });
            }
        });
        
        document.getElementById('quiz1').style.display = 'none';
        document.getElementById('button_modal1').style.display = 'none';
        
        window.removeEventListener('beforeunload', confirmLeavePage);
        alert('Anda Telah Menyelesaikan Tes kostik');
        window.location.reload();
        return;
    }
       
</script>

