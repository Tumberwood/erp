<style>
  .table-bordered {
    border: 1px solid #000;
    overflow: hidden;
  }

  .table-bordered th,
  .table-bordered td {
    border: 1px solid #000;
    font-size: 12px;
  }

  .bg-abu {
    background-color: #ccc;
    width: 1px;
    text-align: center;
  }

  .yellow-bg {
    background-color: #FFFF00;
    width: 1px;
    text-align: center;
    color: black;
  }

  .green-bg {
    background-color: green;
    width: 1px;
    text-align: center;
  }

  .red-bg {
    background-color: #FF0000;
    color: white;
    text-align: center;
  }

  .kiri {
    text-align: left;
  }

  .timer-container {
    margin-top: 20px;
    font-size: 24px;
    font-weight: bold;
    text-align: center;
  }
  
	.quiz-container {
    max-width: 2000px;
    margin: 0 auto;
    text-align: center;
    overflow: hidden;
  }
</style>
</head>

<div class="quiz-container">
  <div class="timer-container">
    Sisa Waktu: <span id="timer"></span>
  </div>

  <div class="row">
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">1</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal1_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal1_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Gampangan, Mudah setuju</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal1_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal1_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Percaya, Mudah percaya pada orang</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal1_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal1_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Petualang, Mengambil resiko</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal1_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal1_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Toleran, Menghormati</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">2</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal2_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal2_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Lembut suara, Pendiam</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal2_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal2_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Optimistik, Visioner</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal2_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal2_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Pusat Perhatian, Suka gaul</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal2_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal2_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Pendamai, Membawa Harmoni</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">3</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal3_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal3_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Menyemangati orang</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal3_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal3_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Berusaha sempurna</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal3_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal3_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Bagian dari kelompok</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal3_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal3_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Ingin membuat tujuan</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">4</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal4_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal4_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Menjadi frustrasi</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal4_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal4_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Menyimpan perasaan saya</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal4_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal4_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Menceritakan sisi saya</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal4_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal4_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Siap beroposisi</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">5</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal5_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal5_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Hidup, Suka bicara</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal5_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal5_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Gerak cepat, Tekun</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal5_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal5_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Usaha menjaga keseimbangan</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal5_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal5_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Usaha mengikuti aturan</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>

    </div>
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">6</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal6_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal6_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Kelola waktu secara efisien</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal6_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal6_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Sering terburu-buru, Merasa tertekan</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal6_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal6_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Masalah sosial itu penting</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal6_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal6_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Suka selesaikan apa yang saya mulai</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>

    </div>
  </div>

  <div class="row">
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">7</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal7_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal7_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Tolak perubahan mendadak</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal7_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal7_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Cenderung janji berlebihan</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal7_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal7_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Tarik diri di tengah tekanan</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal7_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal7_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Tidak takut bertempur</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">8</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal8_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal8_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Penyemangat yang baik</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal8_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal8_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Pendengar yang baik</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal8_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal8_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Penganalisa yang baik</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal8_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal8_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Delegator yang baik</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4">
      <!-- TABEL 2, NO 9-16 -->
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">9</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal9_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal9_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Hasil adalah penting</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal9_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal9_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Lakukan dengan benar, Akurasi penting </td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal9_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal9_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Dibuat menyenangkan</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal9_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal9_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Mari kerjakan bersama</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">10</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal10_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal10_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Akan berjalan terus tanpa kontrol diri </td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal10_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal10_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Akan membeli sesuai dorongan hati </td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal10_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal10_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Akan menunggu, Tanpa tekanan </td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal10_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal10_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Akan mengusahakan yang kuinginkan</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">11</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal11_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal11_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Ramah, Mudah bergabung</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal11_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal11_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Unik, Bosan rutinitas</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal11_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal11_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Aktif mengubah sesuatu</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal11_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal11_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Ingin hal-hal yang pasti</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">12</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal12_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal12_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Non-konfrontasi, Menyerah</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal12_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal12_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Dipenuhi hal detail</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal12_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal12_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Perubahan pada menit terakhir</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal12_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal12_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Menuntut, Kasar</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">13</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal13_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal13_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Ingin kemajuan</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal13_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal13_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Puas dengan segalanya</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal13_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal13_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Terbuka memperlihatkan perasaan</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal13_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal13_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Rendah hati, Sederhana</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">14</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal14_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal14_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Tenang, Pendiam</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal14_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal14_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Bahagia, Tanpa beban</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal14_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal14_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Menyenangkan, Baik hati</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal14_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal14_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Tak gentar, Berani</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">15</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal15_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal15_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Menggunakan waktu berkualitas dgn teman</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal15_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal15_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Rencanakan masa depan, Bersiap </td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal15_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal15_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Bepergian demi petualangan baru</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal15_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal15_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Menerima ganjaran atas tujuan yg dicapai</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">16</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal16_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal16_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Aturan perlu dipertanyakan</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal16_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal16_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Aturan membuat adil</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal16_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal16_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Aturan membuat bosan</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal16_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal16_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Aturan membuat aman</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">17</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal17_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal17_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Pendidikan, Kebudayaan</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal17_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal17_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Prestasi, Ganjaran </td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal17_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal17_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Keselamatan, keamanan</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal17_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal17_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Sosial, Perkumpulan kelompok</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">18</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal18_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal18_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Memimpin, Pendekatan langsung</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal18_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal18_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Suka bergaul, Antusias </td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal18_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal18_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Dapat diramal, Konsisten</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal18_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal18_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Waspada, Hati-hati</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">19</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal19_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal19_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Tidak mudah dikalahkan</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal19_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal19_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Kerjakan sesuai perintah, Ikut pimpinan </td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal19_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal19_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Mudah terangsang, Riang </td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal19_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal19_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Ingin segalanya teratur, Rapi</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">20</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal20_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal20_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Saya akan pimpin mereka</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal20_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal20_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Saya akan melaksanakan</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal20_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal20_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Saya akan meyakinkan mereka</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal20_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal20_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Saya dapatkan fakta</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">21</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal21_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal21_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Memikirkan orang dahulu</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal21_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal21_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Kompetitif, Suka tantangan</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal21_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal21_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Optimis, Positif</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal21_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal21_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Pemikir logis, Sistematik</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">22</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal22_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal22_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Menyenangkan orang, Mudah setuju</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal22_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal22_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Tertawa lepas, Hidup</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal22_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal22_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Berani, Tak gentar</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal22_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal22_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Tenang, Pendiam</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">23</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal23_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal23_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Ingin otoritas lebih</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal23_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal23_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Ingin kesempatan baru</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal23_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal23_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Menghindari konflik</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal23_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal23_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Ingin petunjuk yang jelas</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
    <div class="col-md-6 col-sm-12 col-lg-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="background-color: #ccc;">No</th>
            <th class="yellow-bg">P</th>
            <th style="background-color: green;">K</th>
            <th class="red-bg">Gambaran Diri</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="4" class="bg-abu align-middle">24</td>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal24_jwb_1" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal24_jwb_1" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Dapat diandalkan, Dapat dipercaya</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal24_jwb_2" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal24_jwb_2" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Kreatif, Unik</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal24_jwb_3" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal24_jwb_3" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Garis dasar, Orientasi hasil</td>
          </tr>
          <tr>
            <td class="yellow-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal24_jwb_4" value="p" onclick="cekInput(this)">
              </div>
            </td>
            <td class="green-bg">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="soal24_jwb_4" value="k" onclick="cekInput(this)">
              </div>
            </td>
            <td class="kiri">Jalankan standar yang tinggi, Akurat</td>
          </tr>
          <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
      </table>
    </div>
  </div>
</div>

  <div class="row">
    <div class="col-6">

    </div>
    <div class="col-6">
      <button class="btn btn-primary" style="margin-bottom: 20px" onclick="finishQuiz()">Selesai</button>
    </div>
  </div>
<script>
  function cekInput(radioButton) {
    const questionRow = radioButton.closest('tr');
    const table = questionRow.closest('table');
    const questions = table.querySelectorAll('tr');
    const selectedAnswer = radioButton.value;
    const selectedQuestionIndex = Array.from(questions).indexOf(questionRow);

    questions.forEach((question, index) => {
      if (index !== selectedQuestionIndex) {
        const radioButtons = question.querySelectorAll('input[type="radio"]');
        const selectedRadioButton = Array.from(radioButtons).find(radio => radio.checked);

        if (selectedRadioButton && selectedRadioButton.value === selectedAnswer) {
          selectedRadioButton.checked = false;
        }
      }
    });
  }

  function startCountdown(duration) {
    var timerElement = document.getElementById('timer');
    var timerInterval = setInterval(function () {
      var minutes = Math.floor(duration / 60);
      var seconds = duration % 60;

      // Display the remaining time in the timer element
      timerElement.textContent = minutes + 'm ' + seconds + 's';

      // Decrement the duration
      duration--;

      // Check if the countdown is finished
      if (duration < 0) {
        clearInterval(timerInterval);
        timerElement.textContent = 'Time is up!';

        if (!finishdisc) {
          finishGet();
        }
      }
    }, 1000);
    return;
  }

</script>