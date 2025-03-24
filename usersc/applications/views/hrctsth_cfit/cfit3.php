
<style>
	.quiz-container {
    max-width: 2000px;
    margin: 0 auto;
    text-align: center;
    overflow: hidden;
  }
  
  .quiz-question{
    margin-bottom: 20px;
  }
  
  .quiz-question img{
    max-width: 700px;
    height: auto;
  }
  
  .cfit3-question{
    margin-bottom: 20px;
  }
  
  .cfit3-question img{
    max-width: 350px;
    height: auto;
  }
  
  .cfit4-question{
    margin-bottom: 20px;
  }
  
  .cfit4-question img{
    max-width: 250px;
    height: auto;
  }
  
  .quiz-image3 {
    max-width: 250px;
    height: auto;
    /* margin-bottom: 20px; */
    border: 2px solid transparent;
  }
  
  .quiz-option {
    display: inline-block;
    /* margin: 10px;
    cursor: pointer; */
  }
  
  .quiz-option img {
    max-width: 150px;
    height: auto;
  }
  
  .cfit4-option {
    display: inline-block;
    /* margin: 10px;
    cursor: pointer; */
  }
  
  .cfit4-option img {
    max-width: 200px;
    height: auto;
  }
  
  .quiz-option input[type="radio"] {
    display: none;
  }
  
  .quiz-option.selected3 .quiz-image3 {
    border-color: #0d6efd;
  }

  .quiz-image-container {
    position: relative;
    display: inline-block;
  }

  .quiz-image-container img {
    max-width: 200px;
    height: auto;
  }
  
  .selected3 {
    border: 3px solid #007bff;
  }
</style>

<div class="row">
  <div class="col-lg-10">
    <div class="quiz-container">
      <!-- <div class="timer-container">
        Sisa Waktu: <span id="timer3"></span>
      </div> -->

      <div class="cfit3-question" id="question1">
        <h3>Pertanyaan 1</h3>
        <img src="part3/q1/1.jpg" class="soal3">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part3/q1/option1.jpg" alt="1" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q1/option2.jpg" alt="2" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q1/option3.jpg" alt="3" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q1/option4.jpg" alt="4" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q1/option5.jpg" alt="5" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q1/option6.jpg" alt="6" class="quiz-image3" onclick="selectImage3(this)">
        </div>
      </div>

      <div class="cfit3-question" id="question2">
        <h3>Pertanyaan 2</h3>
        <img src="part3/q2/1.jpg" class="soal3">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part3/q2/option1.jpg" alt="1" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q2/option2.jpg" alt="2" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q2/option3.jpg" alt="3" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q2/option4.jpg" alt="4" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q2/option5.jpg" alt="5" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q2/option6.jpg" alt="6" class="quiz-image3" onclick="selectImage3(this)">
        </div>
      </div>

      <div class="cfit3-question" id="question3">
        <h3>Pertanyaan 3</h3>
        <img src="part3/q3/1.jpg" class="soal3">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part3/q3/option1.jpg" alt="1" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q3/option2.jpg" alt="2" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q3/option3.jpg" alt="3" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q3/option4.jpg" alt="4" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q3/option5.jpg" alt="5" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q3/option6.jpg" alt="6" class="quiz-image3" onclick="selectImage3(this)">
        </div>
      </div>

      <div class="cfit3-question" id="question4">
        <h3>Pertanyaan 4</h3>
        <img src="part3/q4/1.jpg" class="soal3">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part3/q4/option1.jpg" alt="1" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q4/option2.jpg" alt="2" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q4/option3.jpg" alt="3" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q4/option4.jpg" alt="4" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q4/option5.jpg" alt="5" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q4/option6.jpg" alt="6" class="quiz-image3" onclick="selectImage3(this)">
        </div>
      </div>


      <div class="cfit3-question" id="question5">
        <h3>Pertanyaan 5</h3>
        <img src="part3/q5/1.jpg" class="soal3">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part3/q5/option1.jpg" alt="1" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q5/option2.jpg" alt="2" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q5/option3.jpg" alt="3" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q5/option4.jpg" alt="4" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q5/option5.jpg" alt="5" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q5/option6.jpg" alt="6" class="quiz-image3" onclick="selectImage3(this)">
        </div>
      </div>

      <div class="cfit3-question" id="question6">
        <h3>Pertanyaan 6</h3>
        <img src="part3/q6/1.jpg" class="soal3">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part3/q6/option1.jpg" alt="1" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q6/option2.jpg" alt="2" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q6/option3.jpg" alt="3" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q6/option4.jpg" alt="4" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q6/option5.jpg" alt="5" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q6/option6.jpg" alt="6" class="quiz-image3" onclick="selectImage3(this)">
        </div>
      </div>

      <div class="cfit3-question" id="question7">
        <h3>Pertanyaan 7</h3>
        <img src="part3/q7/1.jpg" class="soal3">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part3/q7/option1.jpg" alt="1" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q7/option2.jpg" alt="2" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q7/option3.jpg" alt="3" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q7/option4.jpg" alt="4" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q7/option5.jpg" alt="5" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q7/option6.jpg" alt="6" class="quiz-image3" onclick="selectImage3(this)">
        </div>
      </div>

      <div class="cfit3-question" id="question8">
        <h3>Pertanyaan 8</h3>
        <img src="part3/q8/1.jpg" class="soal3">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part3/q8/option1.jpg" alt="1" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q8/option2.jpg" alt="2" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q8/option3.jpg" alt="3" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q8/option4.jpg" alt="4" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q8/option5.jpg" alt="5" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q8/option6.jpg" alt="6" class="quiz-image3" onclick="selectImage3(this)">
        </div>
      </div>

      <div class="cfit3-question" id="question9">
        <h3>Pertanyaan 9</h3>
        <img src="part3/q9/1.jpg" class="soal3">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part3/q9/option1.jpg" alt="1" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q9/option2.jpg" alt="2" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q9/option3.jpg" alt="3" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q9/option4.jpg" alt="4" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q9/option5.jpg" alt="5" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q9/option6.jpg" alt="6" class="quiz-image3" onclick="selectImage3(this)">
        </div>
      </div>

      <div class="cfit3-question" id="question10">
        <h3>Pertanyaan 10</h3>
        <img src="part3/q10/1.jpg" class="soal3">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part3/q10/option1.jpg" alt="1" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q10/option2.jpg" alt="2" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q10/option3.jpg" alt="3" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q10/option4.jpg" alt="4" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q10/option5.jpg" alt="5" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q10/option6.jpg" alt="6" class="quiz-image3" onclick="selectImage3(this)">
        </div>
      </div>

      <div class="cfit3-question" id="question11">
        <h3>Pertanyaan 11</h3>
        <img src="part3/q11/1.jpg" class="soal3">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part3/q11/option1.jpg" alt="1" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q11/option2.jpg" alt="2" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q11/option3.jpg" alt="3" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q11/option4.jpg" alt="4" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q11/option5.jpg" alt="5" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q11/option6.jpg" alt="6" class="quiz-image3" onclick="selectImage3(this)">
        </div>
      </div>

      <div class="cfit3-question" id="question12">
        <h3>Pertanyaan 12</h3>
        <img src="part3/q12/1.jpg" class="soal3">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part3/q12/option1.jpg" alt="1" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q12/option2.jpg" alt="2" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q12/option3.jpg" alt="3" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q12/option4.jpg" alt="4" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q12/option5.jpg" alt="5" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q12/option6.jpg" alt="6" class="quiz-image3" onclick="selectImage3(this)">
        </div>
      </div>

      <div class="cfit3-question" id="question13">
        <h3>Pertanyaan 13</h3>
        <img src="part3/q13/1.jpg" class="soal3">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part3/q13/option1.jpg" alt="1" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q13/option2.jpg" alt="2" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q13/option3.jpg" alt="3" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q13/option4.jpg" alt="4" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q13/option5.jpg" alt="5" class="quiz-image3" onclick="selectImage3(this)">
        </div>
        <div class="quiz-option">
          <img src="part3/q13/option6.jpg" alt="6" class="quiz-image3" onclick="selectImage3(this)">
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <button onclick="previousQuestion3()" class="btn btn-primary" id="prevButton3">Previous</button>
        </div>
        <div class="col-6 d-flex justify-content-end">
          <button onclick="nextQuestion3()" class="btn btn-primary" id="nextButton3">Next</button>
          <button onclick="finishQuiz3()" class="btn btn-success" id="finishButton3" style="display: none;">Finish</button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-2">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Question Box</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content" style="padding: 15px">
          <div class="scroll_content" style="overflow-y: auto;">
            <div class="grid-container">
              <script>
                for (let i = 1; i <= 13; i++) {
                  var boxClass3 = "grid-box";
                  document.write(`
                    <div class="grid-item" onclick="goToQuestion3(${i - 1})">
                      <div class="${boxClass3}" id="grid3-${i}">${i}</div>
                    </div>
                  `);
                }

                function goToQuestion3(questionIndex) {
                  currentQuestionIndex3 = questionIndex;
                  showCurrentQuestion3();
                  updateGridColors3(); // Update the grid color when navigating to a question
                }
              </script>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

<script>
  var currentQuestionIndex3 = 0;
  var selected3Images = [];
  var answeredQuestions3 = []; 
  var quizQuestions3 = document.getElementsByClassName('cfit3-question');
  var prevButton3 = document.getElementById('prevButton3');
  var nextButton3 = document.getElementById('nextButton3');
  var finishButton3 = document.getElementById('finishButton3');
  var timer3Element = document.getElementById('timer3');
  var countdownInterval2;

  function showCurrentQuestion3() {
    for (var i = 0; i < quizQuestions3.length; i++) {
      if (i === currentQuestionIndex3) {
        quizQuestions3[i].style.display = 'block';
      } else {
        quizQuestions3[i].style.display = 'none';
      }
    }

    // Enable/disable buttons based on current question index
    prevButton3.style.display = currentQuestionIndex3 === 0 ? 'none' : 'block';
    nextButton3.style.display = currentQuestionIndex3 === quizQuestions3.length - 1 ? 'none' : 'block';
    finishButton3.style.display = currentQuestionIndex3 === quizQuestions3.length - 1 ? 'block' : 'none';
  }

  function selectImage3(image3) {
    var maxAllowedSelections = 1;
    var currentQuestionImages = quizQuestions3[currentQuestionIndex3].getElementsByClassName('quiz-image3');
    var selected3ImagesCount = 0;

    // Count the number of selected3 images in the current question
    for (var i = 0; i < currentQuestionImages.length; i++) {
        if (currentQuestionImages[i].classList.contains('selected3')) {
            selected3ImagesCount++;
        }
    }

    // Select the new image
    image3.classList.toggle('selected3');

    if (image3.classList.contains('selected3')) {
        // Clear the selectedImages array and add the new selection
        selected3Images = [];
        selected3Images.push(image3);
    } else {
        // Remove the deselected image from the selectedImages array
        var index = selected3Images.indexOf(image3);
        if (index > -1) {
            selected3Images.splice(index, 1);
        }
    }

    // Mark selected3 images
    for (var i = 0; i < currentQuestionImages.length; i++) {
        var currentImage3 = currentQuestionImages[i];
        if (selected3Images.includes(currentImage3)) {
            currentImage3.classList.add('selected3');
        } else {
            currentImage3.classList.remove('selected3');
        }
    }
    
    // Mark the question as answered if an image is selected
    if (!answeredQuestions3.includes(currentQuestionIndex3)) {
      answeredQuestions3.push(currentQuestionIndex3);
    }

    updateGridColors3();
}

  function previousQuestion3() {
    if (currentQuestionIndex3 > 0) {
      currentQuestionIndex3--;
      showCurrentQuestion3();
      updateGridColors3();
    }
  }

  function nextQuestion3() {
    if (currentQuestionIndex3 < quizQuestions3.length - 1) {
      currentQuestionIndex3++;
      showCurrentQuestion3();
      updateGridColors3();
    }
  }
    
  function updateGridColors3() {
    for (let i = 0; i < quizQuestions3.length; i++) {
      var gridItem3 = document.getElementById(`grid3-${i + 1}`);
      if (gridItem3) {  // Check if the element exists
        if (i === currentQuestionIndex3) {
          // Current question: set to primary color
          gridItem3.style.backgroundColor = '#007bff'; // Bootstrap 'primary' color
          gridItem3.style.color = '#fff'; // Bootstrap 'primary' color
        } else if (answeredQuestions3.includes(i)) {
          // Answered question: set to success color
          gridItem3.style.backgroundColor = '#38a745'; // Bootstrap 'success' color
          gridItem3.style.color = '#fff'; // Bootstrap 'primary' color
        } else {
          // Unanswered question: set to plain/default color
          gridItem3.style.backgroundColor = '#f8f9fa'; // Bootstrap 'light' color
          gridItem3.style.color = '#000'; // Bootstrap 'primary' color
        }
      }
    }
  }

  function startCountdown3(duration3) {
      var btnFilter = document.getElementById("btnFilterFloating");
      if (btnFilter) {
      var timerDiv = document.createElement("div");
      timerDiv.className = "timer-container";
      timerDiv.innerHTML = 'Sisa Waktu: <span id="timer3"></span>';
      btnFilter.parentNode.insertBefore(timerDiv, btnFilter);
    }

    var timer3Element = document.getElementById('timer3');
    var timer3Interval = setInterval(function() {
    var minutes = Math.floor(duration3 / 60);
    var seconds = duration3 % 60;
      
    if (finishSesi3) {
        clearInterval(timer3Interval);
        document.querySelectorAll(".timer-container").forEach(el => el.remove());
        console.log("Countdown dihentikan karena finishSesi3 = true");
        return;
    }

    // Display the remaining time in the timer2 element
    timer3Element.textContent = minutes + 'm ' + seconds + 's';

    // Decrement the duration3
    duration3--;

    // Check if the countdown is finished
    if (duration3 < 0) {
        clearInterval(timer3Interval);
          document.querySelectorAll(".timer-container").forEach(el => el.remove());
        timer3Element.textContent = 'Time is up!';

        // Additional actions when the countdown ends
        // ...

        // Disable or hide the quiz if needed
        document.getElementById('quiz3').style.display = 'none';
        document.getElementById('button_modal3').style.display = 'none';
        document.getElementById('mulaiCFIT4').style.display = 'block';

        if (!finishSesi3) {
          finishGet3();
        }
      }
    }, 1000);
    return;
  }

  showCurrentQuestion3();
  updateGridColors3();
</script>
