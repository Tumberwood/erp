<script>
	$('#start_date').datepicker('setDate', tanggal_hariini_dmy);

  var finishdisc = false;

  //ALERT KETIKA RELOAD
  function confirmLeavePage(event) {
    event.preventDefault();
    event.returnValue = 'Are you sure you want to leave this page? Your progress will be lost.';
  }

  window.addEventListener('beforeunload', confirmLeavePage);

  function noKtp() {
    var kode = $('#kode').val();
    start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

    $.ajax({
      url: '../../models/hrctsth_disc/validate.php',
      dataType: 'json',
      type: 'POST',
      data: {
        kode: kode
      },
      success: function (json) {
        $('#nama').val(json.nama);
        $('#hetxxmh').val(json.hetxxmh);

        if (start_date == 'Invalid date') {
          toastr.error("Tanggal wajib diisi!", "INFO");
        } else {
          if (!json.nama) {
            toastr.error("Kode tes yang Anda masukkan tidak valid!", "INFO");
          } else {
              document.getElementById('kirim').style.display = 'none';
              document.getElementById('kode').disabled = true;
  
              if (json.status_disc == 1) {
                alert('Tes disc Sedang Berlangsung.');
                window.removeEventListener('beforeunload', confirmLeavePage);
                window.location.reload();
              } else if (json.status_disc == 2) {
                alert('Tes disc Sudah Berakhir.');
                window.removeEventListener('beforeunload', confirmLeavePage);
                window.location.reload();
              } else {
                // document.getElementById('mulaidisc1').style.display = 'block';
                // document.getElementById('button_modal1').style.display = 'block';
                startQuiz();
              } 
          }
        }
      }
    });
  }

  //SESI 1

  function startQuiz() {
    $('#start_date').prop('disabled', true);
    start_at = moment().format('YYYY-MM-DD HH:mm:ss');
      
    start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
    console.log(start_date);

    document.getElementById('quiz1').style.display = 'block';
    var timerDuration = 600;
    startCountdown(timerDuration);
    
    // Show the quiz container
    // document.getElementById('mulaidisc1').style.display = 'none';

    // Set the countdown duration in 3 seconds
    // var timerDuration = 20;

    // Start the countdown

    // var id_hcd = $('#id_hcd').val();
    // var tanggal = $('#tanggal').val();
    // $.ajax({
    //   url: '../../models/hrctsth_disc/status.php',
    //   dataType: 'json',
    //   type: 'POST',
    //   data: {
    //     id_hcd: id_hcd,
    //     tanggal: tanggal
    //   },
    //   success: function (json) {
    //   }
    // });
  }

  function finishQuiz() {
    // Generate a random code
    var confirmation = confirm("Apakah Anda Yakin Ingin Mengakhiri Tes DISC?");

    if (confirmation) {
      const tables = document.querySelectorAll('table');
      const tableErrors = [];

      tables.forEach((table, tableIndex) => {
        if (tableIndex > 0) {
          const questions = table.querySelectorAll('tr');
          let pCount = 0;
          let kCount = 0;

          questions.forEach((question, questionIndex) => {
            const radioButtons = question.querySelectorAll('input[type="radio"]');
            const selectedRadioButton = Array.from(radioButtons).find(radioButton => radioButton.checked);

            if (selectedRadioButton) {
              const selectedAnswer = selectedRadioButton.value;

              if (selectedAnswer === 'p') {
                pCount++;
              } else if (selectedAnswer === 'k') {
                kCount++;
              }
            }
          });

          if (pCount !== 1 || kCount !== 1) {
            tableErrors.push(`Soal ${tableIndex}`);
          }
        }

      });

      if (tableErrors.length > 0) {
        const errorTablesMessage = `Periksa Kembali Pertanyaan berikut ini:\n\n${tableErrors.join(', ')}`;
        alert(errorTablesMessage);
      } else {
        finishGet();
        finishDisc = true;
      }
    } else {
      // Code does not match, handle the error or show an appropriate message
      alert('Kode yang Anda masukkan salah. Silakan coba lagi.');
    }
  }

  function finishGet() {
    var kode = $('#kode').val();
    const tables = document.querySelectorAll('table');
    const tableErrors = [];

    tables.forEach((table, tableIndex) => {
      const questions = table.querySelectorAll('tr');
      let pCount = 0;
      let kCount = 0;

      questions.forEach((question, questionIndex) => {
        const radioButtons = question.querySelectorAll('input[type="radio"]');
        const selectedRadioButton = Array.from(radioButtons).find(radioButton => radioButton.checked);

        if (selectedRadioButton) {
          const selectedAnswer = selectedRadioButton.value;

          if (selectedAnswer === 'p') {
            pCount++;
          } else if (selectedAnswer === 'k') {
            kCount++;
          }
        }
      });
    });

    const result = [];

    tables.forEach((table, tableIndex) => {
      if (tableIndex > 0) {
        const questions = table.querySelectorAll('tr');

        questions.forEach((question, questionIndex) => {
          const radioButtons = question.querySelectorAll('input[type="radio"]');
          const selectedRadioButton = Array.from(radioButtons).find(radioButton => radioButton.checked);

          const selectedAnswer = selectedRadioButton ? selectedRadioButton.value : '';
          const gambaran = selectedRadioButton ? `${questionIndex}` : '';

          result.push({
            table: `Soal ${tableIndex + 1}`,
            gambaran: gambaran,
            answer: selectedAnswer
          });
        });
      }
    });

    // Sort the quiz results by table in a natural order (1, 2, 3, ..., 10, 11, 12)
    result.sort((a, b) => {
      const tableA = parseInt(a.table.split(' ')[1]);
      const tableB = parseInt(b.table.split(' ')[1]);
      return tableA - tableB;
    });

    // Move 'P' answers to the top within each table, preserving the original question order
    result.sort((a, b) => {
      if (a.table === b.table) {
        if (a.answer === 'p' && b.answer !== 'p') {
          return -1;
        } else if (a.answer !== 'p' && b.answer === 'p') {
          return 1;
        }
      }
      return 0;
    });

    const groupedResult = {};
    result.forEach(item => {
      const key = item.table;
      if (!groupedResult[key]) {
        groupedResult[key] = [];
      }
      groupedResult[key].push(item);
    });

    const limitedResult = [];
    Object.keys(groupedResult).forEach(key => {
      const items = groupedResult[key];
      const answeredItems = items.filter(item => item.answer !== '');
      const blankItems = items.filter(item => item.answer === '');

      if (answeredItems.length > 0) {
        answeredItems.slice(0, 2).forEach(item => {
          limitedResult.push(item);
        });
      } else if (blankItems.length > 0) {
        blankItems.slice(0, 2).forEach(item => {
          item.answer = '';
          limitedResult.push(item);
        });
      }
    });

    console.log(limitedResult);
    $.ajax({
      url: '../../models/hrctsth_disc/insertData.php',
      dataType: 'json',
      type: 'POST',
      data: {
        limitedResult: limitedResult,
        kode: kode
      },
      success: function (json) {
        toastr.info("Tes DISC Sudah Selesai, untuk kode DISC tersebut hanya dapat digunakan sekali. Jika ingin tes lagi, silahkan hubungi admin!", "INFO");
        is_finish = 1;
      }
    });
    // document.getElementById('mulaidisc1').style.display = 'none';
    document.getElementById('quiz1').style.display = 'none';
    // document.getElementById('button_modal1').style.display = 'none';

    window.removeEventListener('beforeunload', confirmLeavePage);
    alert('Anda Telah Menyelesaikan Tes DISC');
    window.location.reload();
    return;
  }



</script>
