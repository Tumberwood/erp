<script>
    var finishSesi1 = false;
    var finishSesi2 = false;
    var finishSesi3 = false;
    var finishSesi4 = false;

    //ALERT KETIKA RELOAD 
    function confirmLeavePage(event) {
      event.preventDefault();
      event.returnValue = 'Are you sure you want to leave this page? Your progress will be lost.';
    }

    window.addEventListener('beforeunload', confirmLeavePage);

    function noKtp() {
        var kode = $('#kode').val();
        $.ajax({
            url: '../../models/hrctsth_cfit/validate.php',
            dataType: 'json',
            type: 'POST',
            data: {
                kode: kode
            },
            success: function(json) {
                $('#nama').val(json.nama);
                $('#id_hcd').val(json.id_hcd);
                $('#hetxxmh').val(json.hetxxmh);
                if (!json.nama) {
                    alert('Kode Yang Dimasukkan Salah!!!');
                    document.getElementById('mulaiCFIT1').style.display = 'none';
                    document.getElementById('button_modal1').style.display = 'none';

                    document.getElementById('mulaiCFIT2').style.display = 'none';
                    document.getElementById('button_modal2').style.display = 'none';

                    document.getElementById('mulaiCFIT3').style.display = 'none';
                    document.getElementById('button_modal3').style.display = 'none';

                    document.getElementById('mulaiCFIT4').style.display = 'none';
                    document.getElementById('button_modal4').style.display = 'none';
                } else {
                    document.getElementById('kirim').style.display = 'none';
                    document.getElementById('kode').disabled = true;

                    if (json.status_cfit == 1) {
                        alert('Tes CFIT Sedang Berlangsung.');
                        window.removeEventListener('beforeunload', confirmLeavePage);
                        window.location.reload();
                    } else if (json.status_cfit == 2) {
                        alert('Tes CFIT Sudah Selesai.');
                        window.removeEventListener('beforeunload', confirmLeavePage);
                        window.location.reload();
                    } else {
                        document.getElementById('mulaiCFIT1').style.display = 'block';
                        document.getElementById('button_modal1').style.display = 'block';

                        document.getElementById('mulaiCFIT2').style.display = 'none';
                        document.getElementById('button_modal2').style.display = 'none';

                        document.getElementById('mulaiCFIT3').style.display = 'none';
                        document.getElementById('button_modal3').style.display = 'none';

                        document.getElementById('mulaiCFIT4').style.display = 'none';
                        document.getElementById('button_modal4').style.display = 'none';
                    } 
                }
            }
        });
    }


    //SESI 1
    
    function startQuiz() {

        // Show the quiz container
        document.getElementById('quiz1').style.display = 'block';
        document.getElementById('mulaiCFIT1').style.display = 'none';

        // Set the countdown duration in 3 seconds
        var timerDuration = 180; // Change this value to set the desired countdown time
        // var timerDuration = 3; // Change this value to set the desired countdown time

        // Start the countdown
        startCountdown(timerDuration);

        // var
        
    }

    function finishQuiz() {
        // Generate a random code
        var confirmation = confirm("Apakah Anda Yakin Ingin Mengakhiri Sesi 1 dan lanjut ke Sesi 2?");

        if (confirmation) {
            var maxAllowedSelections = 1;
            var selectedAnswersByQuestion = {};
            var unansweredQuestions = [];

            for (var i = 0; i < quizQuestions.length; i++) {
                var currentQuestionImages = quizQuestions[i].getElementsByClassName('quiz-image');
                var selectedImagesCount = 0;
                var selectedAnswers = [];

                // Count the number of selected images in the current question and collect their answers
                for (var j = 0; j < currentQuestionImages.length; j++) {
                    if (currentQuestionImages[j].classList.contains('selected')) {
                        selectedImagesCount++;
                        selectedAnswers.push(currentQuestionImages[j].alt);
                    }
                }

                if (selectedImagesCount !== maxAllowedSelections) {
                    unansweredQuestions.push(i + 1); // Add the question index to the unansweredQuestions array
                }
            }

            if (unansweredQuestions.length > 0) {
                var errorMessage = 'Mohon lengkapi jawaban pada nomor: ';
                errorMessage += unansweredQuestions.join(', ');
                alert(errorMessage);
                return;
            }
            finishGet();
            var satu = finishGet();
            console.log(satu[0]);
            console.log(satu[1]);
            finishSesi1 = true;
        } else {
            // Code does not match, handle the error or show an appropriate message
            alert('Kode yang Anda masukkan salah. Silakan coba lagi.');
        }
    }

    function finishGet() {
        var id_hcd = $('#id_hcd').val();; // Get the value of an element with the ID "tanggal"
        var maxAllowedSelections = 1; // Define the maximum number of selections allowed per question
        var selectedAnswersByQuestion = {}; // Initialize an object to store selected answers

        for (var i = 0; i < quizQuestions.length; i++) {
            // Loop through each quiz question
            var currentQuestionImages = quizQuestions[i].getElementsByClassName('quiz-image');
            var selectedImagesCount = 0;
            var selectedAnswers = [];

            // Count the number of selected images in the current question and collect their answers
            for (var j = 0; j < currentQuestionImages.length; j++) {
                if (currentQuestionImages[j].classList.contains('selected')) {
                    selectedImagesCount++;
                    selectedAnswers.push(currentQuestionImages[j].alt);
                }
            }

            selectedAnswersByQuestion[i + 1] = selectedAnswers;
            // Store the selected answers in the selectedAnswersByQuestion object
            // The key represents the question number, and the value is an array of selected answers
        }
        //JAWABAN

        //part1_SOAL1
        if (selectedAnswersByQuestion['1'] == '2') {
            part1_soal1 = 1;
        } else {
            part1_soal1 = -9;
        }

        //part1_SOAL2
        if (selectedAnswersByQuestion['2'] == '3') {
            part1_soal2 = 1;
        } else {
            part1_soal2 = -9;
        }

        //part1_SOAL3
        if (selectedAnswersByQuestion['3'] == '2') {
            part1_soal3 = 1;
        } else {
            part1_soal3 = -9;
        }

        //part1_SOAL4
        if (selectedAnswersByQuestion['4'] == '4') {
            part1_soal4 = 1;
        } else {
            part1_soal4 = -9;
        }

        //part1_SOAL5
        if (selectedAnswersByQuestion['5'] == '5') {
            part1_soal5 = 1;
        } else {
            part1_soal5 = -9;
        }

        //part1_SOAL6
        if (selectedAnswersByQuestion['6'] == '2') {
            part1_soal6 = 1;
        } else {
            part1_soal6 = -9;
        }

        //part1_SOAL7
        if (selectedAnswersByQuestion['7'] == '4') {
            part1_soal7 = 1;
        } else {
            part1_soal7 = -9;
        }

        //part1_SOAL8
        if (selectedAnswersByQuestion['8'] == '2') {
            part1_soal8 = 1;
        } else {
            part1_soal8 = -9;
        }

        //part1_SOAL9
        if (selectedAnswersByQuestion['9'] == '6') {
            part1_soal9 = 1;
        } else {
            part1_soal9 = -9;
        }

        //part1_SOAL10
        if (selectedAnswersByQuestion['10'] == '3') {
            part1_soal10 = 1;
        } else {
            part1_soal10 = -9;
        }

        //part1_SOAL11
        if (selectedAnswersByQuestion['11'] == '2') {
            part1_soal11 = 1;
        } else {
            part1_soal11 = -9;
        }

        //part1_SOAL12
        if (selectedAnswersByQuestion['12'] == '2') {
            part1_soal12 = 1;
        } else {
            part1_soal12 = -9;
        }

        //part1_SOAL13
        if (selectedAnswersByQuestion['13'] == '5') {
            part1_soal13 = 1;
        } else {
            part1_soal13 = -9;
        }

        var hasil = [
            id_hcd,
            part1_soal1,
            part1_soal2,
            part1_soal3,
            part1_soal4,
            part1_soal5,
            part1_soal6,
            part1_soal7,
            part1_soal8,
            part1_soal9,
            part1_soal10,
            part1_soal11,
            part1_soal12,
            part1_soal13

        ];
        
        document.getElementById('mulaiCFIT1').style.display = 'none';
        document.getElementById('quiz1').style.display = 'none';
        document.getElementById('button_modal1').style.display = 'none';

        document.getElementById('mulaiCFIT2').style.display = 'block';
        document.getElementById('button_modal2').style.display = 'block';
        return [hasil, selectedAnswersByQuestion];
    }


    //SESI 2
      
    function startQuiz2() {
      // Show the quiz container
        document.getElementById('quiz2').style.display = 'block';
        document.getElementById('mulaiCFIT2').style.display = 'none';
    
      // Set the countdown duration2 in 4 seconds
        var timer2Duration22 = 240; // Change this value to set the desired countdown time
        // var timer2Duration22 = 10; // Change this value to set the desired countdown time
      // Start the countdown
        startCountdown2(timer2Duration22);
    }

    function finishQuiz2() {
        // Generate a random code
        var confirmation2 = confirm("Apakah Anda Yakin Ingin Mengakhiri Sesi 2 dan lanjut ke Sesi 3?");

        if (confirmation2) {
            var maxAllowedSelections2 = 2;
            var selectedAnswers2ByQuestion2 = {};
            var unansweredQuestions2 = [];

            for (var i = 0; i < quizQuestions2.length; i++) {
                var currentQuestionImages2 = quizQuestions2[i].getElementsByClassName('quiz-image2');
                var selectedImagesCount2 = 0;
                var selectedAnswers2 = [];

                // Count the number of selected images in the current question and collect their answers
                for (var j = 0; j < currentQuestionImages2.length; j++) {
                    if (currentQuestionImages2[j].classList.contains('selected2')) {
                        selectedImagesCount2++;
                        selectedAnswers2.push(currentQuestionImages2[j].alt);
                    }
                }

                if (selectedImagesCount2 !== maxAllowedSelections2) {
                    unansweredQuestions2.push(i + 1); // Add the question index to the unansweredQuestions2 array
                }
            }

            if (unansweredQuestions2.length > 0) {
                var errorMessage = 'Mohon lengkapi jawaban pada nomor: ';
                errorMessage += unansweredQuestions2.join(', ');
                alert(errorMessage);
                return;
            }
            finishGet2();
            var dua = finishGet2();
            console.log(dua[0]);
            console.log(dua[1]);
            finishSesi2 = true;
        } else {
            // Code does not match, handle the error or show an appropriate message
            alert('Kode yang Anda masukkan salah. Silakan coba lagi.');
        }
    }

      
    function finishGet2() {
        var id_hcd = $('#id_hcd').val(); // Get the value of an element with the ID "id_hcd"
        var maxAllowedSelections2 = 20; // Define the maximum number of selections allowed per question
        var selectedAnswersByQuestion2 = {}; // Initialize an object to store selected answers

        for (var i = 0; i < quizQuestions2.length; i++) {
            // Loop through each quiz question
            var currentQuestionImages2 = quizQuestions2[i].getElementsByClassName('quiz-image2');
            var selectedImagesCount2 = 0;
            var selectedAnswers2 = [];

            // Count the number of selected images in the current question and collect their answers
            for (var j = 0; j < currentQuestionImages2.length; j++) {
                if (currentQuestionImages2[j].classList.contains('selected2')) {
                    selectedImagesCount2++;
                    selectedAnswers2.push(currentQuestionImages2[j].alt);
                }
            }

            selectedAnswersByQuestion2[i + 1] = selectedAnswers2;
            // Store the selected answers in the selectedAnswersByQuestion2 object
            // The key represents the question number, and the value is an array of selected answers
        }
        //JAWABAN Sesi 2

        //SOAL_2_1
        if (JSON.stringify(selectedAnswersByQuestion2['1']) === JSON.stringify(['2', '5'])) {
            soal_2_1 = 1;
        } else {
            soal_2_1 = -9;
        }

        //SOAL_2_2
        if (JSON.stringify(selectedAnswersByQuestion2['2']) === JSON.stringify(['1', '5'])) {
            soal_2_2 = 1;
        } else {
            soal_2_2 = -9;
        }

        //SOAL_2_3
        if (JSON.stringify(selectedAnswersByQuestion2['3']) === JSON.stringify(['1', '4'])) {
            soal_2_3 = 1;
        } else {
            soal_2_3 = -9;
        }

        //SOAL_2_4
        if (JSON.stringify(selectedAnswersByQuestion2['4']) === JSON.stringify(['3', '5'])) {
            soal_2_4 = 1;
        } else {
            soal_2_4 = -9;
        }

        //SOAL_2_5
        if (JSON.stringify(selectedAnswersByQuestion2['5']) === JSON.stringify(['2', '5'])) {
            soal_2_5 = 1;
        } else {
            soal_2_5 = -9;
        }

        //SOAL_2_6
        if (JSON.stringify(selectedAnswersByQuestion2['6']) === JSON.stringify(['1', '4'])) {
            soal_2_6 = 1;
        } else {
            soal_2_6 = -9;
        }

        //SOAL_2_7
        if (JSON.stringify(selectedAnswersByQuestion2['7']) === JSON.stringify(['2', '5'])) {
            soal_2_7 = 1;
        } else {
            soal_2_7 = -9;
        }

        //SOAL_2_8
        if (JSON.stringify(selectedAnswersByQuestion2['8']) === JSON.stringify(['2', '5'])) {
            soal_2_8 = 1;
        } else {
            soal_2_8 = -9;
        }

        //SOAL_2_9
        if (JSON.stringify(selectedAnswersByQuestion2['9']) === JSON.stringify(['1', '4'])) {
            soal_2_9 = 1;
        } else {
            soal_2_9 = -9;
        }

        //SOAL_2_10
        if (JSON.stringify(selectedAnswersByQuestion2['10']) === JSON.stringify(['2', '4'])) {
            soal_2_10 = 1;
        } else {
            soal_2_10 = -9;
        }

        //SOAL_2_11
        if (JSON.stringify(selectedAnswersByQuestion2['11']) === JSON.stringify(['1', '5'])) {
            soal_2_11 = 1;
        } else {
            soal_2_11 = -9;
        }

        //SOAL_2_12
        if (JSON.stringify(selectedAnswersByQuestion2['12']) === JSON.stringify(['3', '4'])) {
            soal_2_12 = 1;
        } else {
            soal_2_12 = -9;
        }

        //SOAL_2_13
        if (JSON.stringify(selectedAnswersByQuestion2['13']) === JSON.stringify(['2', '3'])) {
            soal_2_13 = 1;
        } else {
            soal_2_13 = -9;
        }

        //SOAL_2_14
        if (JSON.stringify(selectedAnswersByQuestion2['14']) === JSON.stringify(['1', '2'])) {
            soal_2_14 = 1;
        } else {
            soal_2_14 = -9;
        }
        
        var hasil2 = [
            id_hcd,
            soal_2_1,
            soal_2_2,
            soal_2_3,
            soal_2_4,
            soal_2_5,
            soal_2_6,
            soal_2_7,
            soal_2_8,
            soal_2_9,
            soal_2_10,
            soal_2_11,
            soal_2_12,
            soal_2_13,
            soal_2_14
        ];

        document.getElementById('mulaiCFIT2').style.display = 'none';
        document.getElementById('quiz2').style.display = 'none';
        document.getElementById('button_modal2').style.display = 'none';

        document.getElementById('mulaiCFIT3').style.display = 'block';
        document.getElementById('button_modal3').style.display = 'block';
        return [hasil2, selectedAnswersByQuestion2];
    }

    //SESI 3
        
    function startQuiz3() {
        // Show the quiz container
        document.getElementById('quiz3').style.display = 'block';
        document.getElementById('mulaiCFIT3').style.display = 'none';

      // Set the countdown duration3 in 3 seconds
        var timerDuration3 = 180; // Change this value to set the desired countdown time
        // var timerDuration3 = 20; // Change this value to set the desired countdown time
      // Start the countdown
        startCountdown3(timerDuration3);
    }

    function finishQuiz3() {
        // Generate a random code
        var confirmation3 = confirm("Apakah Anda Yakin Ingin Mengakhiri Sesi 3 dan lanjut ke Sesi 4?");

        if (confirmation3) {
            var maxAllowedSelections3 = 1;
            var selectedAnswersByQuestion3 = {};
            var unansweredQuestions3 = [];

            for (var i = 0; i < quizQuestions3.length; i++) {
                var currentQuestionImages3 = quizQuestions3[i].getElementsByClassName('quiz-image3');
                var selectedImagesCount3 = 0;
                var selectedAnswers3 = [];

                // Count the number of selected images in the current question and collect their answers
                for (var j = 0; j < currentQuestionImages3.length; j++) {
                    if (currentQuestionImages3[j].classList.contains('selected3')) {
                        selectedImagesCount3++;
                        selectedAnswers3.push(currentQuestionImages3[j].alt);
                    }
                }

                if (selectedImagesCount3 !== maxAllowedSelections3) {
                    unansweredQuestions3.push(i + 1); // Add the question index to the unansweredQuestions3 array
                }
            }

            if (unansweredQuestions3.length > 0) {
                var errorMessage = 'Mohon lengkapi jawaban pada nomor: ';
                errorMessage += unansweredQuestions3.join(', ');
                alert(errorMessage);
                return;
            }
            finishGet3();
            
            var tiga = finishGet3();
            console.log(tiga[0]);
            console.log(tiga[1]);
            finishSesi3 = true;
        } else {
            // Code does not match, handle the error or show an appropriate message
            alert('Kode yang Anda masukkan salah. Silakan coba lagi.');
        }
    }

    
    function finishGet3() {
        var id_hcd = $('#id_hcd').val(); // Get the value of an element with the ID "id_hcd"
        var maxAllowedSelections3 = 1; // Define the maximum number of selections allowed per question
        var selectedAnswersByQuestion3 = {}; // Initialize an object to store selected answers

        for (var i = 0; i < quizQuestions3.length; i++) {
            // Loop through each quiz question
            var currentQuestionImages3 = quizQuestions3[i].getElementsByClassName('quiz-image3');
            var selectedImagesCount3 = 0;
            var selectedAnswers3 = [];

            // Count the number of selected images in the current question and collect their answers
            for (var j = 0; j < currentQuestionImages3.length; j++) {
                if (currentQuestionImages3[j].classList.contains('selected3')) {
                    selectedImagesCount3++;
                    selectedAnswers3.push(currentQuestionImages3[j].alt);
                }
            }

            selectedAnswersByQuestion3[i + 1] = selectedAnswers3;
            // Store the selected answers in the selectedAnswersByQuestion3 object
            // The key represents the question number, and the value is an array of selected answers
        }
        
        //JAWABAN

        //PART3_SOAL1
        if (selectedAnswersByQuestion3['1'] == '5') {
            part3_soal1 = 1;
        } else {
            part3_soal1 = -9;
        }

        //PART3_SOAL2
        if (selectedAnswersByQuestion3['2'] == '5') {
            part3_soal2 = 1;
        } else {
            part3_soal2 = -9;
        }

        //PART3_SOAL3
        if (selectedAnswersByQuestion3['3'] == '5') {
            part3_soal3 = 1;
        } else {
            part3_soal3 = -9;
        }

        //PART3_SOAL4
        if (selectedAnswersByQuestion3['4'] == '2') {
            part3_soal4 = 1;
        } else {
            part3_soal4 = -9;
        }

        //PART3_SOAL5
        if (selectedAnswersByQuestion3['5'] == '3') {
            part3_soal5 = 1;
        } else {
            part3_soal5 = -9;
        }

        //PART3_SOAL6
        if (selectedAnswersByQuestion3['6'] == '4') {
            part3_soal6 = 1;
        } else {
            part3_soal6 = -9;
        }

        //PART3_SOAL7
        if (selectedAnswersByQuestion3['7'] == '5') {
            part3_soal7 = 1;
        } else {
            part3_soal7 = -9;
        }

        //PART3_SOAL8
        if (selectedAnswersByQuestion3['8'] == '5') {
            part3_soal8 = 1;
        } else {
            part3_soal8 = -9;
        }

        //PART3_SOAL9
        if (selectedAnswersByQuestion3['9'] == '1') {
            part3_soal9 = 1;
        } else {
            part3_soal9 = -9;
        }

        //PART3_SOAL10
        if (selectedAnswersByQuestion3['10'] == '1') {
            part3_soal10 = 1;
        } else {
            part3_soal10 = -9;
        }

        //PART3_SOAL11
        if (selectedAnswersByQuestion3['11'] == '6') {
            part3_soal11 = 1;
        } else {
            part3_soal11 = -9;
        }

        //PART3_SOAL12
        if (selectedAnswersByQuestion3['12'] == '3') {
            part3_soal12 = 1;
        } else {
            part3_soal12 = -9;
        }

        //PART3_SOAL13
        if (selectedAnswersByQuestion3['13'] == '3') {
            part3_soal13 = 1;
        } else {
            part3_soal13 = -9;
        }

        var hasil3 = [
            id_hcd,
            part3_soal1,
            part3_soal2,
            part3_soal3,
            part3_soal4,
            part3_soal5,
            part3_soal6,
            part3_soal7,
            part3_soal8,
            part3_soal9,
            part3_soal10,
            part3_soal11,
            part3_soal12,
            part3_soal13

        ];

        document.getElementById('mulaiCFIT3').style.display = 'none';
        document.getElementById('quiz3').style.display = 'none';
        document.getElementById('button_modal3').style.display = 'none';

        document.getElementById('mulaiCFIT2').style.display = 'none';
        document.getElementById('quiz2').style.display = 'none';
        document.getElementById('button_modal2').style.display = 'none';

        document.getElementById('mulaiCFIT4').style.display = 'block';
        document.getElementById('button_modal4').style.display = 'block';
        return [hasil3, selectedAnswersByQuestion3];
    }

    //SESI 4
        
    function startQuiz4() {
        // Show the quiz container
        document.getElementById('quiz4').style.display = 'block';
        document.getElementById('mulaiCFIT4').style.display = 'none';
        document.getElementById('mulaiCFIT2').style.display = 'none';
        document.getElementById('button_modal2').style.display = 'none';

        // Set the countdown duration4 in 2.5 seconds
        var timerDuration4 = 150; // Change this value to set the desired countdown time
        // Start the countdown
        startCountdown4(timerDuration4);
    }

    function finishQuiz4() {
        // Generate a random code
        var confirmation4 = confirm("Apakah Anda Yakin Ingin Mengakhiri Tes CFIT?");

        if (confirmation4) {
            var maxAllowedSelections4 = 1;
            var selectedAnswersByQuestion4 = {};
            var unansweredQuestions4 = [];

            for (var i = 0; i < quizQuestions4.length; i++) {
                var currentQuestionImages4 = quizQuestions4[i].getElementsByClassName('quiz-image4');
                var selectedImagesCount4 = 0;
                var selectedAnswers4 = [];

                // Count the number of selected images in the current question and collect their answers
                for (var j = 0; j < currentQuestionImages4.length; j++) {
                    if (currentQuestionImages4[j].classList.contains('selected4')) {
                        selectedImagesCount4++;
                        selectedAnswers4.push(currentQuestionImages4[j].alt);
                    }
                }

                if (selectedImagesCount4 !== maxAllowedSelections4) {
                    unansweredQuestions4.push(i + 1); // Add the question index to the unansweredQuestions4 array
                }
            }

            if (unansweredQuestions4.length > 0) {
                var errorMessage = 'Mohon lengkapi jawaban pada nomor: ';
                errorMessage += unansweredQuestions4.join(', ');
                alert(errorMessage);
                return;
            }
            finishGet4();
            finishSesi4 = true;
        } else {
            // Code does not match, handle the error or show an appropriate message
            alert('Kode yang Anda masukkan salah. Silakan coba lagi.');
        }
    }

    
    function finishGet4() {
        var id_hcd = $('#id_hcd').val(); // Get the value of an element with the ID "id_hcd"
        var kode = $('#kode').val(); // Get the value of an element with the ID "id_hcd"
        var maxAllowedSelections4 = 1; // Define the maximum number of selections allowed per question
        var selectedAnswersByQuestion4 = {}; // Initialize an object to store selected answers

        var getCfit1 = finishGet();
        var hasil1 = getCfit1[0]
        var jawaban1 = getCfit1[1]

        var getCfit2 = finishGet2();
        var hasil2 = getCfit2[0]
        var jawaban2 = getCfit2[1]

        var getCfit3 = finishGet3();
        var hasil3 = getCfit3[0]
        var jawaban3 = getCfit3[1]

        for (var i = 0; i < quizQuestions4.length; i++) {
            // Loop through each quiz question
            var currentQuestionImages4 = quizQuestions4[i].getElementsByClassName('quiz-image4');
            var selectedImagesCount4 = 0;
            var selectedAnswers4 = [];

            // Count the number of selected images in the current question and collect their answers
            for (var j = 0; j < currentQuestionImages4.length; j++) {
                if (currentQuestionImages4[j].classList.contains('selected4')) {
                    selectedImagesCount4++;
                    selectedAnswers4.push(currentQuestionImages4[j].alt);
                }
            }

            selectedAnswersByQuestion4[i + 1] = selectedAnswers4;
            // Store the selected answers in the selectedAnswersByQuestion4 object
            // The key represents the question number, and the value is an array of selected answers
        }
        
        //JAWABAN

        //PART4_SOAL1
        if (selectedAnswersByQuestion4['1'] == '2') {
            part4_soal1 = 1;
        } else {
            part4_soal1 = -9;
        }

        //PART4_SOAL2
        if (selectedAnswersByQuestion4['2'] == '1') {
            part4_soal2 = 1;
        } else {
            part4_soal2 = -9;
        }

        //PART4_SOAL3
        if (selectedAnswersByQuestion4['3'] == '4') {
            part4_soal3 = 1;
        } else {
            part4_soal3 = -9;
        }

        //PART4_SOAL4
        if (selectedAnswersByQuestion4['4'] == '4') {
            part4_soal4 = 1;
        } else {
            part4_soal4 = -9;
        }

        //PART4_SOAL5
        if (selectedAnswersByQuestion4['5'] == '1') {
            part4_soal5 = 1;
        } else {
            part4_soal5 = -9;
        }

        //PART4_SOAL6
        if (selectedAnswersByQuestion4['6'] == '2') {
            part4_soal6 = 1;
        } else {
            part4_soal6 = -9;
        }

        //PART4_SOAL7
        if (selectedAnswersByQuestion4['7'] == '3') {
            part4_soal7 = 1;
        } else {
            part4_soal7 = -9;
        }

        //PART4_SOAL8
        if (selectedAnswersByQuestion4['8'] == '4') {
            part4_soal8 = 1;
        } else {
            part4_soal8 = -9;
        }

        //PART4_SOAL9
        if (selectedAnswersByQuestion4['9'] == '1') {
            part4_soal9 = 1;
        } else {
            part4_soal9 = -9;
        }

        //PART4_SOAL10
        if (selectedAnswersByQuestion4['10'] == '4') {
            part4_soal10 = 1;
        } else {
            part4_soal10 = -9;
        }
        var hasil4 = [
            id_hcd,
            part4_soal1,
            part4_soal2,
            part4_soal3,
            part4_soal4,
            part4_soal5,
            part4_soal6,
            part4_soal7,
            part4_soal8,
            part4_soal9,
            part4_soal10

        ];
        console.log(hasil4);
        console.log(selectedAnswersByQuestion4);

        // Send the selected answers and other data to the server-side PHP script using AJAX
        $.ajax({
            url: '../../models/hrctsth_cfit/sesi4.php',
            dataType: 'json',
            type: 'POST',
            data: {
                selectedAnswersByQuestion4: selectedAnswersByQuestion4,
                hasil1: hasil1,
                hasil2: hasil2,
                hasil3: hasil3,
                hasil4: hasil4,
                jawaban1: jawaban1,
                jawaban2: jawaban2,
                jawaban3: jawaban3,
                id_hcd: id_hcd,
                kode: kode
            },
            success: function(json) {

                toastr.info("Tes CFIT Sudah Selesai!", "INFO");
            }
        });

        document.getElementById('mulaiCFIT4').style.display = 'none';
        document.getElementById('quiz4').style.display = 'none';
        document.getElementById('button_modal4').style.display = 'none';

        window.removeEventListener('beforeunload', confirmLeavePage);
        window.location.reload();
        return;
        
    }
       
</script>

