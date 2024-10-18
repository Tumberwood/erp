  <style>
    th:first-child,
    td:first-child {
      width: 200px; /* Default display size */
    }

    @media only screen and (max-width: 320px) {
        th:first-child,
        td:first-child {
          width: 20px;
        }
      }

      /* Media query for other phones with similar screen sizes */
      @media only screen and (max-width: 480px) {
        th:first-child,
        td:first-child {
          width: 20px;
        }
      }

      /* Media query for tablet devices */
      @media only screen and (min-width: 768px) and (max-width: 1023px) {
        th:first-child,
        td:first-child {
          width: 30px;
        }
      }

    .timer-container {
        margin-top: 20px;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="timer-container">
      Time Left: <span id="timer"></span>
    </div>
    <div class="table-wrapper">
      <table class="table" id="table1">
        <thead>
          <tr>
            <th>No</th>
            <th>Question Table 1</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>
              <input type="checkbox" name="question1" value="1" onclick="checkAnswer(this)"> a. Saya seorang pekerja giat
              <br>
              <input type="checkbox" name="question1" value="2" onclick="checkAnswer(this)"> b. Saya bukan seorang murung
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>
              <input type="checkbox" name="question2" value="1" onclick="checkAnswer(this)"> a. Saya suka bekerja lebih baik daripada orang lain
              <br>
              <input type="checkbox" name="question2" value="2" onclick="checkAnswer(this)"> b. Saya melakukan pekerjaan hingga tuntas
            </td>
          </tr>
          <tr>
            <td>3</td>
            <td>
              <input type="checkbox" name="question3" value="1" onclick="checkAnswer(this)"> a. Saya suka memberi orang petunjuk bagaimana melakukan sesuatu
              <br>
              <input type="checkbox" name="question3" value="2" onclick="checkAnswer(this)"> b. Saya senang memberitahukan orang apa yang harus dikerjakan
            </td>
          </tr>
          <tr>
            <td>4</td>
            <td>
              <input type="checkbox" name="question4" value="1" onclick="checkAnswer(this)"> a. Saya melakukan hal-hal yang lucu
              <br>
              <input type="checkbox" name="question4" value="2" onclick="checkAnswer(this)"> b. Saya suka mengatakan kepada orang lain apa yang harus dikerjakan
            </td>
          </tr>
          <tr>
            <td>5</td>
            <td>
              <input type="checkbox" name="question5" value="1" onclick="checkAnswer(this)"> a. Saya suka bergabung didalam kelompok
              <br>
              <input type="checkbox" name="question5" value="2" onclick="checkAnswer(this)"> b. Saya ingin diperhatikan didalam kelompok
            </td>
          </tr>
          <tr>
            <td>6</td>
            <td>
              <input type="checkbox" name="question6" value="1" onclick="checkAnswer(this)"> a. Saya suka menjalin persahabatan
              <br>
              <input type="checkbox" name="question6" value="2" onclick="checkAnswer(this)"> b. Saya suka menggabungkan diri dalam suatu kelompok
            </td>
          </tr>
          <tr>
            <td>7</td>
            <td>
              <input type="checkbox" name="question7" value="1" onclick="checkAnswer(this)"> a. Jika saya rasa perlu, saya bisa cepat menyesuaikan diri
              <br>
              <input type="checkbox" name="question7" value="2" onclick="checkAnswer(this)"> b. Saya berusaha menjalin persahabatan
            </td>
          </tr>
          <tr>
            <td>8</td>
            <td>
              <input type="checkbox" name="question8" value="1" onclick="checkAnswer(this)"> a. Saya suka membalas jika benar-benar disakiti
              <br>
              <input type="checkbox" name="question8" value="2" onclick="checkAnswer(this)"> b. Saya suka mengerjakan sesuatu hal yang baru dan berbeda
            </td>
          </tr>
          <tr>
            <td>9</td>
            <td>
              <input type="checkbox" name="question9" value="1" onclick="checkAnswer(this)"> a. Saya ingin atasan menyukai saya
              <br>
              <input type="checkbox" name="question9" value="2" onclick="checkAnswer(this)"> b. Saya suka memberitahu orang lain jika mereka berbuat salah
            </td>
          </tr>
          <tr>
            <td>10</td>
            <td>
              <input type="checkbox" name="question10" value="1" onclick="checkAnswer(this)"> a. Saya senang mengikuti petunjuk-petunjuk yang diberikan kepada saya
              <br>
              <input type="checkbox" name="question10" value="2" onclick="checkAnswer(this)"> b. Saya ingin menyenangkan atasan saya
            </td>
          </tr>
          <!-- Add more rows for additional questions -->
        </tbody>
      </table>
      <table class="table" id="table2" style="display: none;">
        <thead>
          <tr>
            <th>No</th>
            <th>Question Table 2</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td>1</td>
              <td>
                <input type="checkbox" name="question1" value="1" onclick="checkAnswer(this)"> a. Saya berusaha keras sekali
                <br>
                <input type="checkbox" name="question1" value="2" onclick="checkAnswer(this)"> b. Saya adalah seorang yang rapi saya menempatkan segala sesuatu ditempatnya
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>
                <input type="checkbox" name="question2" value="1" onclick="checkAnswer(this)"> a. Saya mampu mempengaruhi orang lain untuk melakukan apa yang saya kehendaki
                <br>
                <input type="checkbox" name="question2" value="2" onclick="checkAnswer(this)"> b. Saya tidak mudah marah
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>
                <input type="checkbox" name="question3" value="1" onclick="checkAnswer(this)"> a. Saya suka memberitahukan apa yang harus dikerjakan oleh kelompok
                <br>
                <input type="checkbox" name="question3" value="2" onclick="checkAnswer(this)"> b. Saya selalu melakukan pekerjaan sampai tuntas
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td>
                <input type="checkbox" name="question4" value="1" onclick="checkAnswer(this)"> a. Saya ingin menjadi orang yang menarik dan mengasyikkan
                <br>
                <input type="checkbox" name="question4" value="2" onclick="checkAnswer(this)"> b. Saya ingin menjadi orang yang sangat berhasil
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>
                <input type="checkbox" name="question5" value="1" onclick="checkAnswer(this)"> a. Saya suka menyesuaikan diri dalam kelompok
                <br>
                <input type="checkbox" name="question5" value="2" onclick="checkAnswer(this)"> b. Saya suka membantu orang mengambil keputusan
              </td>
            </tr>
            <tr>
              <td>6</td>
              <td>
                <input type="checkbox" name="question6" value="1" onclick="checkAnswer(this)"> a. Saya cemas bila seseorang tidak menyukai saya
                <br>
                <input type="checkbox" name="question6" value="2" onclick="checkAnswer(this)"> b. Saya suka orang memperhatikan saya
              </td>
            </tr>
            <tr>
              <td>7</td>
              <td>
                <input type="checkbox" name="question7" value="1" onclick="checkAnswer(this)"> a. Saya suka mencoba hal-hal yang baru
                <br>
                <input type="checkbox" name="question7" value="2" onclick="checkAnswer(this)"> b. Saya lebih suka bekerja sama daripada bekerja sendiri
              </td>
            </tr>
            <tr>
              <td>8</td>
              <td>
                <input type="checkbox" name="question8" value="1" onclick="checkAnswer(this)"> a. Kadang-kadang saya menyalahkan orang lain bila ada sesuatu yang tidak beres
                <br>
                <input type="checkbox" name="question8" value="2" onclick="checkAnswer(this)"> b. Saya merasa terganggu bila ada yang tidak menyukai saya
              </td>
            </tr>
            <tr>
              <td>9</td>
              <td>
                <input type="checkbox" name="question9" value="1" onclick="checkAnswer(this)"> a. Saya ingin menyenangkan atasan-atasan saya
                <br>
                <input type="checkbox" name="question9" value="2" onclick="checkAnswer(this)"> b. Saya suka mencoba suatu pekerjaan yang baru dan berbeda
              </td>
            </tr>
            <tr>
              <td>10</td>
              <td>
                <input type="checkbox" name="question10" value="1" onclick="checkAnswer(this)"> a. Saya suka penjelasan-penjelasan terperinci dalam menyelesaikan pekerjaan
                <br>
                <input type="checkbox" name="question10" value="2" onclick="checkAnswer(this)"> b. Akan saya katakan kepada orang-orang yang bersangkutan bila mereka menjengkelkan saya
              </td>
            </tr>
          <!-- Add more rows for additional questions -->
        </tbody>
      </table>
      <table class="table" id="table3" style="display: none;">
        <thead>
          <tr>
            <th>No</th>
            <th>Question Table 3</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td>1</td>
              <td>
                <input type="checkbox" name="question1" value="1" onclick="checkAnswer(this)"> a. Saya selalu berusaha keras
                <br>
                <input type="checkbox" name="question1" value="2" onclick="checkAnswer(this)"> b. Saya suka melaksanakan setiap langkah dengan hati-hati
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>
                <input type="checkbox" name="question2" value="1" onclick="checkAnswer(this)"> a. Saya akan menjadi seorang pemimpin yang baik
                <br>
                <input type="checkbox" name="question2" value="2" onclick="checkAnswer(this)"> b. Saya dapat mengorganisir suatu pekerjaan dengan baik
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>
                <input type="checkbox" name="question3" value="1" onclick="checkAnswer(this)"> a. Saya mudah tersinggung
                <br>
                <input type="checkbox" name="question3" value="2" onclick="checkAnswer(this)"> b. Saya lamban dalam membuat keputusan-keputusan
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td>
                <input type="checkbox" name="question4" value="1" onclick="checkAnswer(this)"> a. Saya suka mengerjakan beberapa pekerjaan sekaligus
                <br>
                <input type="checkbox" name="question4" value="2" onclick="checkAnswer(this)"> b. Bila saya dalam kelompok, saya lebih sering sebagai pendengar
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>
                <input type="checkbox" name="question5" value="1" onclick="checkAnswer(this)"> a. Saya sangat senang bila mendapat undangan
                <br>
                <input type="checkbox" name="question5" value="2" onclick="checkAnswer(this)"> b. saya ingin lebih baik dari yang lain dalam mengerjakan sesuatu
              </td>
            </tr>
            <tr>
              <td>6</td>
              <td>
                <input type="checkbox" name="question6" value="1" onclick="checkAnswer(this)"> a. Saya suka menjalin persahabatan
                <br>
                <input type="checkbox" name="question6" value="2" onclick="checkAnswer(this)"> b. Saya suka memberi nasehat kepada orang lain
              </td>
            </tr>
            <tr>
              <td>7</td>
              <td>
                <input type="checkbox" name="question7" value="1" onclick="checkAnswer(this)"> a. Saya suka mengerjakan sesuatu hal yang baru dan berbeda
                <br>
                <input type="checkbox" name="question7" value="2" onclick="checkAnswer(this)"> b. Saya suka memberitahu bagaimana saya berhasil dalam melakukan sesuatu
              </td>
            </tr>
            <tr>
              <td>8</td>
              <td>
                <input type="checkbox" name="question8" value="1" onclick="checkAnswer(this)"> a. Jika memang saya benar, saya akan mempertahankannya
                <br>
                <input type="checkbox" name="question8" value="2" onclick="checkAnswer(this)"> b. Saya ingin di terima dan diakui dalam kelompok
              </td>
            </tr>
            <tr>
              <td>9</td>
              <td>
                <input type="checkbox" name="question9" value="1" onclick="checkAnswer(this)"> a. Saya tidak ingin menjadi lain dari yang lain
                <br>
                <input type="checkbox" name="question9" value="2" onclick="checkAnswer(this)"> b. Saya berusaha dekat dengan orang-orang
              </td>
            </tr>
            <tr>
                <!-- NO 30 -->
              <td>10</td>
              <td>
                <input type="checkbox" name="question10" value="1" onclick="checkAnswer(this)"> a. Saya senang memberitahu orang bagaimana melakukan suatu pekerjaan
                <br>
                <input type="checkbox" name="question10" value="2" onclick="checkAnswer(this)"> b. Saya berusaha dekat dengan orang-orang
              </td>
            </tr>
          <!-- Add more rows for additional questions -->
        </tbody>
      </table>
      <table class="table" id="table4" style="display: none;">
        <thead>
          <tr>
            <th>No</th>
            <th>Question Table 4</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td>1</td>
              <td>
                <input type="checkbox" name="question1" value="1" onclick="checkAnswer(this)"> a. Saya bekerja keras
                <br>
                <input type="checkbox" name="question1" value="2" onclick="checkAnswer(this)"> b. Saya banyak berfikir dan membuat rencana
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>
                <input type="checkbox" name="question2" value="1" onclick="checkAnswer(this)"> a. Saya memimpin suatu kelompok
                <br>
                <input type="checkbox" name="question2" value="2" onclick="checkAnswer(this)"> b. Saya tertarik dengan hal-hal yang lebih detail
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>
                <input type="checkbox" name="question3" value="1" onclick="checkAnswer(this)"> a. Saya membuat keputusan dengan mudah dan cepat
                <br>
                <input type="checkbox" name="question3" value="2" onclick="checkAnswer(this)"> b. Saya merawat barang-barang saya dengan rapi dan teratur
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td>
                <input type="checkbox" name="question4" value="1" onclick="checkAnswer(this)"> a. Saya mengerjakan sesuatu dengan cepat
                <br>
                <input type="checkbox" name="question4" value="2" onclick="checkAnswer(this)"> b. Saya jarang marah atau sedih
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>
                <input type="checkbox" name="question5" value="1" onclick="checkAnswer(this)"> a. Saya ingin menjadi bagian dari suatu kelompok
                <br>
                <input type="checkbox" name="question5" value="2" onclick="checkAnswer(this)"> b. Saya hanya ingin mengerjakan satu pekerjaan dalam satu saat
              </td>
            </tr>
            <tr>
              <td>6</td>
              <td>
                <input type="checkbox" name="question6" value="1" onclick="checkAnswer(this)"> a. Saya berusaha menjalin persahabatan
                <br>
                <input type="checkbox" name="question6" value="2" onclick="checkAnswer(this)"> b. Saya berusaha keras untuk menjadi yang paling baik
              </td>
            </tr>
            <tr>
              <td>7</td>
              <td>
                <input type="checkbox" name="question7" value="1" onclick="checkAnswer(this)"> a. Saya suka baju-baju dan mobil-mobil model mutakhir
                <br>
                <input type="checkbox" name="question7" value="2" onclick="checkAnswer(this)"> b. Saya senang bertanggung jawab atas orang lain
              </td>
            </tr>
            <tr>
              <td>8</td>
              <td>
                <input type="checkbox" name="question8" value="1" onclick="checkAnswer(this)"> a. Saya senang berdebat
                <br>
                <input type="checkbox" name="question8" value="2" onclick="checkAnswer(this)"> b. Saya senang mendapat perhatian
              </td>
            </tr>
            <tr>
              <td>9</td>
              <td>
                <input type="checkbox" name="question9" value="1" onclick="checkAnswer(this)"> a. Saya suka menyenangkan atasan saya
                <br>
                <input type="checkbox" name="question9" value="2" onclick="checkAnswer(this)"> b. Saya tertarik untuk menjadi bagian dari suatu kelompok
              </td>
            </tr>
            <tr>
              <td>10</td>
              <td>
                <input type="checkbox" name="question10" value="1" onclick="checkAnswer(this)"> a. Saya suka mematuhi peraturan dengan sungguh-sungguh
                <br>
                <input type="checkbox" name="question10" value="2" onclick="checkAnswer(this)"> b. Saya ingin agar orang-orang benar-benar mengenal saya
              </td>
            </tr>
          <!-- Add more rows for additional questions -->
        </tbody>
      </table>
      <table class="table" id="table5" style="display: none;">
        <thead>
          <tr>
            <th>No</th>
            <th>Question Table 5</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td>1</td>
              <td>
                <input type="checkbox" name="question1" value="1" onclick="checkAnswer(this)"> a. Saya berusaha keras sekali
                <br>
                <input type="checkbox" name="question1" value="2" onclick="checkAnswer(this)"> b. Saya sangat ramah
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>
                <input type="checkbox" name="question2" value="1" onclick="checkAnswer(this)"> a. Orang-orang menganggap saya adalah pemimpin yang baik
                <br>
                <input type="checkbox" name="question2" value="2" onclick="checkAnswer(this)"> b. Saya berfikir panjang dan hati-hati
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>
                <input type="checkbox" name="question3" value="1" onclick="checkAnswer(this)"> a. Bila ada kesempatan, saya akan memanfaatkannya
                <br>
                <input type="checkbox" name="question3" value="2" onclick="checkAnswer(this)"> b. Saya senang mengurusi hal-hal yang kecil
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td>
                <input type="checkbox" name="question4" value="1" onclick="checkAnswer(this)"> a. Orang-orang menganggap saya bekerja dengan cepat
                <br>
                <input type="checkbox" name="question4" value="2" onclick="checkAnswer(this)"> b. Orang-orang berpendapat bahwa saya rapi dan teratur
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>
                <input type="checkbox" name="question5" value="1" onclick="checkAnswer(this)"> a. Saya suka berolahraga
                <br>
                <input type="checkbox" name="question5" value="2" onclick="checkAnswer(this)"> b. Saya memiliki kepribadian yang menyenangkan
              </td>
            </tr>
            <tr>
              <td>6</td>
              <td>
                <input type="checkbox" name="question6" value="1" onclick="checkAnswer(this)"> a. Saya senang jika orangdekat dan bersahabat dengan saya
                <br>
                <input type="checkbox" name="question6" value="2" onclick="checkAnswer(this)"> b. Saya selalu berusaha menyelesaikan pekerjaan yang telah saya mulai
              </td>
            </tr>
            <tr>
              <td>7</td>
              <td>
                <input type="checkbox" name="question7" value="1" onclick="checkAnswer(this)"> a. Saya suka bereksperimen dan mencoba hal-hal yang baru
                <br>
                <input type="checkbox" name="question7" value="2" onclick="checkAnswer(this)"> b. Saya senang menyelesaikan dengan baik pekerjaan yang sulit
              </td>
            </tr>
            <tr>
              <td>8</td>
              <td>
                <input type="checkbox" name="question8" value="1" onclick="checkAnswer(this)"> a. Saya senang diperlakukan secara adil
                <br>
                <input type="checkbox" name="question8" value="2" onclick="checkAnswer(this)"> b. Saya suka memberitahu orang bagaimana mengerjakan sesuatu
              </td>
            </tr>
            <tr>
              <td>9</td>
              <td>
                <input type="checkbox" name="question9" value="1" onclick="checkAnswer(this)"> a. Saya suka melakukan apa yang diharapkan dari saya
                <br>
                <input type="checkbox" name="question9" value="2" onclick="checkAnswer(this)"> b. Saya suka bila orang perduli terhadap saya
              </td>
            </tr>
            <tr>
              <td>10</td>
              <td>
                <input type="checkbox" name="question10" value="1" onclick="checkAnswer(this)"> a. Saya suka penjelasan-penjelasan yang terperinci dalam bekerja
                <br>
                <input type="checkbox" name="question10" value="2" onclick="checkAnswer(this)"> b. Saya senang berada diantara orang-orang
              </td>
            </tr>
          <!-- Add more rows for additional questions -->
        </tbody>
      </table>
      <table class="table" id="table6" style="display: none;">
        <thead>
          <tr>
            <th>No</th>
            <th>Question Table 6</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td>1</td>
              <td>
                <input type="checkbox" name="question1" value="1" onclick="checkAnswer(this)"> a. Saya selalu berusaha menyelesaikan tugas-tugas secara sempurna
                <br>
                <input type="checkbox" name="question1" value="2" onclick="checkAnswer(this)"> b. Saya adalah orang yang tak mengenal lelah
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>
                <input type="checkbox" name="question2" value="1" onclick="checkAnswer(this)"> a. Saya adalah tipe pemimpin
                <br>
                <input type="checkbox" name="question2" value="2" onclick="checkAnswer(this)"> b. Saya mudah bergaul
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>
                <input type="checkbox" name="question3" value="1" onclick="checkAnswer(this)"> a. Saya suka mengambil kesempatan-kesempatan yang ada
                <br>
                <input type="checkbox" name="question3" value="2" onclick="checkAnswer(this)"> b. Saya banyak berfikir
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td>
                <input type="checkbox" name="question4" value="1" onclick="checkAnswer(this)"> a. Saya bekerja dengan tempo yang tinggi dan mantap
                <br>
                <input type="checkbox" name="question4" value="2" onclick="checkAnswer(this)"> b. Saya senang menangani detail suatu pekerjaan
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>
                <input type="checkbox" name="question5" value="1" onclick="checkAnswer(this)"> a. Saya memiliki banyak tenaga untuk berolah raga dan bermain
                <br>
                <input type="checkbox" name="question5" value="2" onclick="checkAnswer(this)"> b. Saya merawat barang-barang saya dengan rapi dan teratur
              </td>
            </tr>
            <tr>
              <td>6</td>
              <td>
                <input type="checkbox" name="question6" value="1" onclick="checkAnswer(this)"> a. Saya dapat bergaul baik dengan semua orang
                <br>
                <input type="checkbox" name="question6" value="2" onclick="checkAnswer(this)"> b. Saya orang yang berwatak tenang
              </td>
            </tr>
            <tr>
              <td>7</td>
              <td>
                <input type="checkbox" name="question7" value="1" onclick="checkAnswer(this)"> a. Saya suka bertemu dengan orang-orang baru dan melakukan sesuatu yang baru
                <br>
                <input type="checkbox" name="question7" value="2" onclick="checkAnswer(this)"> b. Saya selalu ingin menyelesaikan pekerjaan yang saya mulai
              </td>
            </tr>
            <tr>
              <td>8</td>
              <td>
                <input type="checkbox" name="question8" value="1" onclick="checkAnswer(this)"> a. Saya biasanya mempertahankan pendapat yang saya yakini
                <br>
                <input type="checkbox" name="question8" value="2" onclick="checkAnswer(this)"> b. Saya biasanya suka bekerja keras
              </td>
            </tr>
            <tr>
              <td>9</td>
              <td>
                <input type="checkbox" name="question9" value="1" onclick="checkAnswer(this)"> a. Saya menyambut baik saran-saran dari orang yang saya kagumi
                <br>
                <input type="checkbox" name="question9" value="2" onclick="checkAnswer(this)"> b. Saya senang bertanggung jawab atas orang lain
              </td>
            </tr>
            <tr>
              <td>10</td>
              <td>
                <input type="checkbox" name="question10" value="1" onclick="checkAnswer(this)"> a. Saya membiarkan orang lain mempengaruhi saya
                <br>
                <input type="checkbox" name="question10" value="2" onclick="checkAnswer(this)"> b. Saya senang mendapatkan banyak perhatian
              </td>
            </tr>
          <!-- Add more rows for additional questions -->
        </tbody>
      </table>
      <table class="table" id="table7" style="display: none;">
        <thead>
          <tr>
            <th>No</th>
            <th>Question Table 7</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td>1</td>
              <td>
                <input type="checkbox" name="question1" value="1" onclick="checkAnswer(this)"> a. Saya biasanya bekerja keras
                <br>
                <input type="checkbox" name="question1" value="2" onclick="checkAnswer(this)"> b. Saya biasanya bekerja cepat
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>
                <input type="checkbox" name="question2" value="1" onclick="checkAnswer(this)"> a. Bila saya berbicara orang-orang mendengarkan
                <br>
                <input type="checkbox" name="question2" value="2" onclick="checkAnswer(this)"> b. Saya sangat mahir menggunakan peralatan
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>
                <input type="checkbox" name="question3" value="1" onclick="checkAnswer(this)"> a. Saya lamban dalam membuat persahabatan
                <br>
                <input type="checkbox" name="question3" value="2" onclick="checkAnswer(this)"> b. Saya lamban dalam memutuskan sesuatu
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td>
                <input type="checkbox" name="question4" value="1" onclick="checkAnswer(this)"> a. Saya biasanya makan dengan cepat
                <br>
                <input type="checkbox" name="question4" value="2" onclick="checkAnswer(this)"> b. Saya senang membaca
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>
                <input type="checkbox" name="question5" value="1" onclick="checkAnswer(this)"> a. Saya menyukai pekerjaan dimana saya banyak bergerak
                <br>
                <input type="checkbox" name="question5" value="2" onclick="checkAnswer(this)"> b. Saya senang pada pekerjaan yang membutuhkan ketelitian
              </td>
            </tr>
            <tr>
              <td>6</td>
              <td>
                <input type="checkbox" name="question6" value="1" onclick="checkAnswer(this)"> a. Saya mudah membuat sebanyak mungkin teman
                <br>
                <input type="checkbox" name="question6" value="2" onclick="checkAnswer(this)"> b. Saya mudah menemukan kembali barang-barang yang saya simpan
              </td>
            </tr>
            <tr>
              <td>7</td>
              <td>
                <input type="checkbox" name="question7" value="1" onclick="checkAnswer(this)"> a. Saya merencanakan sesuatu jauh-jauh sebelumnya
                <br>
                <input type="checkbox" name="question7" value="2" onclick="checkAnswer(this)"> b. Saya selalu menyenangkan
              </td>
            </tr>
            <tr>
              <td>8</td>
              <td>
                <input type="checkbox" name="question8" value="1" onclick="checkAnswer(this)"> a. Saya menjunjung tinggi nama baik saya
                <br>
                <input type="checkbox" name="question8" value="2" onclick="checkAnswer(this)"> b. Saya memusatkan perhatian pada satu persoalan sampai persoalan tersebut terpecahkan
              </td>
            </tr>
            <tr>
              <td>9</td>
              <td>
                <input type="checkbox" name="question9" value="1" onclick="checkAnswer(this)"> a. Saya suka menyenangkan orang-orang yang saya hormati dan kagumi
                <br>
                <input type="checkbox" name="question9" value="2" onclick="checkAnswer(this)"> b. Saya ingin sukses dan berhasil
              </td>
            </tr>
            <tr>
              <td>10</td>
              <td>
                <input type="checkbox" name="question10" value="1" onclick="checkAnswer(this)"> a. Saya senang orang lain yang membuat keputusan untuk kelompok
                <br>
                <input type="checkbox" name="question10" value="2" onclick="checkAnswer(this)"> b. Saya suka membuat keputusan untuk kelompok
              </td>
            </tr>
          <!-- Add more rows for additional questions -->
        </tbody>
      </table>
      <table class="table" id="table8" style="display: none;">
        <thead>
          <tr>
            <th>No</th>
            <th>Question Table 8</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td>1</td>
              <td>
                <input type="checkbox" name="question1" value="1" onclick="checkAnswer(this)"> a. Saya selalu berusaha keras
                <br>
                <input type="checkbox" name="question1" value="2" onclick="checkAnswer(this)"> b. Saya memutuskan sesuatu dengan mudah dan cepat
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>
                <input type="checkbox" name="question2" value="1" onclick="checkAnswer(this)"> a. Kelompok biasanya menjalankan apa yang saya inginkan
                <br>
                <input type="checkbox" name="question2" value="2" onclick="checkAnswer(this)"> b. Saya biasanya berkerja cepat-cepat
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>
                <input type="checkbox" name="question3" value="1" onclick="checkAnswer(this)"> a. Saya sering merasa lelah
                <br>
                <input type="checkbox" name="question3" value="2" onclick="checkAnswer(this)"> b. Saya lamban dalam memutuskan sesuatu
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td>
                <input type="checkbox" name="question4" value="1" onclick="checkAnswer(this)"> a. Saya bekerja dengan cepat
                <br>
                <input type="checkbox" name="question4" value="2" onclick="checkAnswer(this)"> b. Saya mudah berteman
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>
                <input type="checkbox" name="question5" value="1" onclick="checkAnswer(this)"> a. Saya biasanya bersemangat dan bergairah
                <br>
                <input type="checkbox" name="question5" value="2" onclick="checkAnswer(this)"> b. Saya memerlukan banyak waktu untuk berfikir
              </td>
            </tr>
            <tr>
              <td>6</td>
              <td>
                <input type="checkbox" name="question6" value="1" onclick="checkAnswer(this)"> a. Saya sangat ramah kepada orang
                <br>
                <input type="checkbox" name="question6" value="2" onclick="checkAnswer(this)"> b. Saya senang pada pekerjaan yang membutuhkan ketepatan
              </td>
            </tr>
            <tr>
              <td>7</td>
              <td>
                <input type="checkbox" name="question7" value="1" onclick="checkAnswer(this)"> a. Saya banyak sekali berfikir dan membuat rencana
                <br>
                <input type="checkbox" name="question7" value="2" onclick="checkAnswer(this)"> b. Saya meletakkan segalanya pada tempatnya
              </td>
            </tr>
            <tr>
              <td>8</td>
              <td>
                <input type="checkbox" name="question8" value="1" onclick="checkAnswer(this)"> a. Saya senang pada pekerjaan yang membutuhkan ketelitian dan detail
                <br>
                <input type="checkbox" name="question8" value="2" onclick="checkAnswer(this)"> b. Saya tidak mudah marah
              </td>
            </tr>
            <tr>
              <td>9</td>
              <td>
                <input type="checkbox" name="question9" value="1" onclick="checkAnswer(this)"> a. Saya suka menurut pada orang-orang yang saya kagumi
                <br>
                <input type="checkbox" name="question9" value="2" onclick="checkAnswer(this)"> b. Saya selalu menyelesaikan pekerjaan yang telah saya mulai
              </td>
            </tr>
            <tr>
              <td>10</td>
              <td>
                <input type="checkbox" name="question10" value="1" onclick="checkAnswer(this)"> a. Saya suka mengikuti petunjuk-petunjuk yang jelas
                <br>
                <input type="checkbox" name="question10" value="2" onclick="checkAnswer(this)"> b. Saya senang bekerja keras
              </td>
            </tr>
          <!-- Add more rows for additional questions -->
        </tbody>
      </table>
      <table class="table" id="table9" style="display: none;">
        <thead>
          <tr>
            <th>No</th>
            <th>Question Table 9</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td>1</td>
              <td>
                <input type="checkbox" name="question1" value="1" onclick="checkAnswer(this)"> a. Saya berusaha mendapatkan apa yang saya inginkan
                <br>
                <input type="checkbox" name="question1" value="2" onclick="checkAnswer(this)"> b. Saya seorang pemimpin yang baik
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>
                <input type="checkbox" name="question2" value="1" onclick="checkAnswer(this)"> a. Saya dapat membuat orang lain bekerja keras
                <br>
                <input type="checkbox" name="question2" value="2" onclick="checkAnswer(this)"> b. Saya adalah type orang yang tidak kenal susah
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>
                <input type="checkbox" name="question3" value="1" onclick="checkAnswer(this)"> a. Saya mengambil keputusan dengan cepat
                <br>
                <input type="checkbox" name="question3" value="2" onclick="checkAnswer(this)"> b. Saya berbicara dengan cepat
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td>
                <input type="checkbox" name="question4" value="1" onclick="checkAnswer(this)"> a. Rasanya saya bekerja dengan tergesa-gesa
                <br>
                <input type="checkbox" name="question4" value="2" onclick="checkAnswer(this)"> b. Saya berlatih / berolah raga dengan teratur
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>
                <input type="checkbox" name="question5" value="1" onclick="checkAnswer(this)"> a. Saya tidak suka bertemu kebanyakan orang
                <br>
                <input type="checkbox" name="question5" value="2" onclick="checkAnswer(this)"> b. Saya cepat merasa lelah
              </td>
            </tr>
            <tr>
              <td>6</td>
              <td>
                <input type="checkbox" name="question6" value="1" onclick="checkAnswer(this)"> a. Saya mempunyai banyak sekali teman
                <br>
                <input type="checkbox" name="question6" value="2" onclick="checkAnswer(this)"> b. Saya banyak menghabiskan waktu untuk berfikir
              </td>
            </tr>
            <tr>
              <td>7</td>
              <td>
                <input type="checkbox" name="question7" value="1" onclick="checkAnswer(this)"> a. Saya suka menerapkan teori-teori dalam bekerja
                <br>
                <input type="checkbox" name="question7" value="2" onclick="checkAnswer(this)"> b. Saya suka mengerjakan sesuatu sampai pada hal-hal yang detail dan jelas
              </td>
            </tr>
            <tr>
              <td>8</td>
              <td>
                <input type="checkbox" name="question8" value="1" onclick="checkAnswer(this)"> a. Saya suka mengerjakan sesuatu sampai pada hal-hal yang detail dan jelas
                <br>
                <input type="checkbox" name="question8" value="2" onclick="checkAnswer(this)"> b. Saya suka mengatur dan mengorganisir pekerjaan saya
              </td>
            </tr>
            <tr>
              <td>9</td>
              <td>
                <input type="checkbox" name="question9" value="1" onclick="checkAnswer(this)"> a. Saya meletakkan segalanya pada tempatnya
                <br>
                <input type="checkbox" name="question9" value="2" onclick="checkAnswer(this)"> b. Saya selalu menyenangkan
              </td>
            </tr>
            <tr>
              <td>10</td>
              <td>
                <input type="checkbox" name="question10" value="1" onclick="checkAnswer(this)"> a. Saya senang diberi petunjuk apa yang harus dikerjakan
                <br>
                <input type="checkbox" name="question10" value="2" onclick="checkAnswer(this)"> b. Saya harus menyelesaikan apa yang saya mulai
              </td>
            </tr>
          <!-- Add more rows for additional questions -->
        </tbody>
      </table>
      <!-- Add more tables for additional sets of questions -->
    </div>
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-3">
          <button class="btn btn-primary" id="prevButton" onclick="showPrevTable()">Previous</button>
          <br>
        </div>
        <div class="col-md-6">
            <div id="tableIndexes">
                <button class="btn btn-secondary tableIndex" onclick="showTable(0)">1</button>
                <button class="btn btn-secondary tableIndex" onclick="showTable(1)">2</button>
                <button class="btn btn-secondary tableIndex" onclick="showTable(2)">3</button>
                <button class="btn btn-secondary tableIndex" onclick="showTable(3)">4</button>
                <button class="btn btn-secondary tableIndex" onclick="showTable(4)">5</button>
                <button class="btn btn-secondary tableIndex" onclick="showTable(5)">6</button>
                <button class="btn btn-secondary tableIndex" onclick="showTable(6)">7</button>
                <button class="btn btn-secondary tableIndex" onclick="showTable(7)">8</button>
                <button class="btn btn-secondary tableIndex" onclick="showTable(8)">9</button>
            </div>
        </div>
        <div class="col-md-2">
          <button class="btn btn-primary" id="nextButton" onclick="showNextTable()">Next</button>
          <button class="btn btn-primary" id="finishButton" onclick="finishQuiz()" style="display: none;">Finish</button>
          <br>
        </div>
    </div>



  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    var currentTableIndex = 0;
    var tables = document.querySelectorAll('.table-wrapper table');
    var prevButton = document.getElementById('prevButton');
    var nextButton = document.getElementById('nextButton');
    var finishButton = document.getElementById('finishButton');
    var tableIndexes = document.getElementById('tableIndexes').getElementsByClassName('tableIndex');

    function showTable(index) {
      currentTableIndex = index;
      for (var i = 0; i < tables.length; i++) {
        if (i === index) {
          tables[i].style.display = 'table';
        } else {
          tables[i].style.display = 'none';
        }

        // Show/hide Finish button berdasarkan current table index
        prevButton.style.display = currentTableIndex === 0 ? 'none' : 'block';
        nextButton.style.display = currentTableIndex === tables.length - 1 ? 'none' : 'block';
        finishButton.style.display = currentTableIndex === tables.length - 1 ? 'block' : 'none';

        for (var j = 0; j < tableIndexes.length; j++) {
          if (j === index) {
            tableIndexes[j].classList.add('btn-primary');
            tableIndexes[j].classList.remove('btn-secondary');
          } else {
            tableIndexes[j].classList.add('btn-secondary');
            tableIndexes[j].classList.remove('btn-primary');
          }
        }
      }
    }

    function showNextTable() {
      currentTableIndex++;
      if (currentTableIndex >= tables.length) {
        currentTableIndex = tables.length - 1;
      }
      showTable(currentTableIndex);
    }

    function showPrevTable() {
      currentTableIndex--;
      if (currentTableIndex < 0) {
        currentTableIndex = 0;
      }
      showTable(currentTableIndex);
    }

    function checkAnswer(checkbox) {
      var questionRow = checkbox.parentNode.parentNode;
      var checkboxes = questionRow.getElementsByTagName('input');

      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] !== checkbox) {
          checkboxes[i].checked = false;
        }
      }
    }

    function startCountdown(duration) {
        var timerElement = document.getElementById('timer');
        var timerInterval = setInterval(function() {
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

            if (!finishKostik) {
            finishGet();
            }
        }
        }, 1000);
        return;
    }
    // var timerDuration = 180; // Change this value to set the desired countdown time

    // Start the countdown

    showTable(currentTableIndex);
  </script>
