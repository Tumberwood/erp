  
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
  
  .quiz-image2 {
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
  
  .quiz-option.selected2 .quiz-image2 {
    border-color: #0d6efd;
  }
  
  .timer-container {
    margin-top: 20px;
    font-size: 24px;
    font-weight: bold;
  }

  .quiz-image-container {
    position: relative;
    display: inline-block;
  }

  .quiz-image-container img {
    max-width: 200px;
    height: auto;
  }
  
  .selected2 {
    border: 3px solid #007bff;
  }
</style>
  
<div class="row">
  <div class="col-lg-10">
    <div class="quiz-container">
      <div class="timer-container">
        Time Left: <span id="timer2"></span>
      </div>

      <div class="quiz-question2" id="question1">
        <h4>Question 1:</h4>
        <div class="quiz-image-container">
          <img src="part2/q1/option1.jpg" alt="1" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q1/option2.jpg" alt="2" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q1/option3.jpg" alt="3" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q1/option4.jpg" alt="4" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q1/option5.jpg" alt="5" class="quiz-image2" onclick="selectImage2(this)">
        </div>
      </div>

      <div class="quiz-question2" id="question2">
        <h4>Question 2:</h4>
        <div class="quiz-image-container">
          <img src="part2/q2/option1.jpg" alt="1" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q2/option2.jpg" alt="2" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q2/option3.jpg" alt="3" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q2/option4.jpg" alt="4" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q2/option5.jpg" alt="5" class="quiz-image2" onclick="selectImage2(this)">
        </div>
      </div>

      <div class="quiz-question2" id="question3">
        <h4>Question 3:</h4>
        <div class="quiz-image-container">
          <img src="part2/q3/option1.jpg" alt="1" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q3/option2.jpg" alt="2" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q3/option3.jpg" alt="3" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q3/option4.jpg" alt="4" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q3/option5.jpg" alt="5" class="quiz-image2" onclick="selectImage2(this)">
        </div>
      </div>

      <div class="quiz-question2" id="question4">
        <h4>Question 4:</h4>
        <div class="quiz-image-container">
          <img src="part2/q4/option1.jpg" alt="1" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q4/option2.jpg" alt="2" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q4/option3.jpg" alt="3" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q4/option4.jpg" alt="4" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q4/option5.jpg" alt="5" class="quiz-image2" onclick="selectImage2(this)">
        </div>
      </div>


      <div class="quiz-question2" id="question5">
        <h4>Question 5:</h4>
        <div class="quiz-image-container">
          <img src="part2/q5/option1.jpg" alt="1" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q5/option2.jpg" alt="2" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q5/option3.jpg" alt="3" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q5/option4.jpg" alt="4" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q5/option5.jpg" alt="5" class="quiz-image2" onclick="selectImage2(this)">
        </div>
      </div>

      <div class="quiz-question2" id="question6">
        <h4>Question 6:</h4>
        <div class="quiz-image-container">
          <img src="part2/q6/option1.jpg" alt="1" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q6/option2.jpg" alt="2" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q6/option3.jpg" alt="3" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q6/option4.jpg" alt="4" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q6/option5.jpg" alt="5" class="quiz-image2" onclick="selectImage2(this)">
        </div>
      </div>

      <div class="quiz-question2" id="question7">
        <h4>Question 7:</h4>
        <div class="quiz-image-container">
          <img src="part2/q7/option1.jpg" alt="1" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q7/option2.jpg" alt="2" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q7/option3.jpg" alt="3" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q7/option4.jpg" alt="4" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q7/option5.jpg" alt="5" class="quiz-image2" onclick="selectImage2(this)">
        </div>
      </div>

      <div class="quiz-question2" id="question8">
        <h4>Question 8:</h4>
        <div class="quiz-image-container">
          <img src="part2/q8/option1.jpg" alt="1" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q8/option2.jpg" alt="2" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q8/option3.jpg" alt="3" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q8/option4.jpg" alt="4" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q8/option5.jpg" alt="5" class="quiz-image2" onclick="selectImage2(this)">
        </div>
      </div>

      <div class="quiz-question2" id="question9">
        <h4>Question 9:</h4>
        <div class="quiz-image-container">
          <img src="part2/q9/option1.jpg" alt="1" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q9/option2.jpg" alt="2" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q9/option3.jpg" alt="3" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q9/option4.jpg" alt="4" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q9/option5.jpg" alt="5" class="quiz-image2" onclick="selectImage2(this)">
        </div>
      </div>

      <div class="quiz-question2" id="question10">
        <h4>Question 10:</h4>
        <div class="quiz-image-container">
          <img src="part2/q10/option1.jpg" alt="1" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q10/option2.jpg" alt="2" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q10/option3.jpg" alt="3" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q10/option4.jpg" alt="4" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q10/option5.jpg" alt="5" class="quiz-image2" onclick="selectImage2(this)">
        </div>
      </div>

      <div class="quiz-question2" id="question11">
        <h4>Question 11:</h4>
        <div class="quiz-image-container">
          <img src="part2/q11/option1.jpg" alt="1" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q11/option2.jpg" alt="2" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q11/option3.jpg" alt="3" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q11/option4.jpg" alt="4" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q11/option5.jpg" alt="5" class="quiz-image2" onclick="selectImage2(this)">
        </div>
      </div>

      <div class="quiz-question2" id="question12">
        <h4>Question 12:</h4>
        <div class="quiz-image-container">
          <img src="part2/q12/option1.jpg" alt="1" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q12/option2.jpg" alt="2" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q12/option3.jpg" alt="3" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q12/option4.jpg" alt="4" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q12/option5.jpg" alt="5" class="quiz-image2" onclick="selectImage2(this)">
        </div>
      </div>

      <div class="quiz-question2" id="question13">
        <h4>Question 13:</h4>
        <div class="quiz-image-container">
          <img src="part2/q13/option1.jpg" alt="1" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q13/option2.jpg" alt="2" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q13/option3.jpg" alt="3" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q13/option4.jpg" alt="4" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q13/option5.jpg" alt="5" class="quiz-image2" onclick="selectImage2(this)">
        </div>
      </div>

      <div class="quiz-question2" id="question14">
        <h4>Question 14:</h4>
        <div class="quiz-image-container">
          <img src="part2/q14/option1.jpg" alt="1" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q14/option2.jpg" alt="2" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q14/option3.jpg" alt="3" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q14/option4.jpg" alt="4" class="quiz-image2" onclick="selectImage2(this)">
        </div>
        <div class="quiz-image-container">
          <img src="part2/q14/option5.jpg" alt="5" class="quiz-image2" onclick="selectImage2(this)">
        </div>
      </div>

      <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-9">
          <button onclick="previousQuestion2()" class="btn btn-primary" id="prevButton2">Previous</button>
        </div>
        <div class="col-md-2">
          <button onclick="nextQuestion2()" class="btn btn-primary" id="nextButton2">Next</button>
          <button onclick="finishQuiz2()" class="btn btn-success" id="finishButton2" style="display: none;">Finish</button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-2">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Question</h5>
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
                for (let i = 1; i <= 14; i++) {
                  var boxClass2 = "grid-box";
                  document.write(`
                    <div class="grid-item" onclick="goToQuestion(${i - 1})">
                      <div class="${boxClass2}" id="grid2-${i}">${i}</div>
                    </div>
                  `);
                }

                function goToQuestion(questionIndex) {
                  currentQuestionIndex2 = questionIndex;
                  showCurrentQuestion2();
                  updateGridColors(); // Update the grid color when navigating to a question
                }
              </script>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

<script>
  var currentQuestionIndex2 = 0;
  var selectedImages2 = [];
  var answeredQuestions2 = []; 
  var quizQuestions2 = document.getElementsByClassName('quiz-question2');
  var prevButton2 = document.getElementById('prevButton2');
  var nextButton2 = document.getElementById('nextButton2');
  var finishButton2 = document.getElementById('finishButton2');
  var timer2Element2 = document.getElementById('timer2');
  var countdownInterval2;

  function showCurrentQuestion2() {
    for (var i = 0; i < quizQuestions2.length; i++) {
      quizQuestions2[i].style.display = i === currentQuestionIndex2 ? 'block' : 'none';
    }

    prevButton2.style.display = currentQuestionIndex2 === 0 ? 'none' : 'block';
    nextButton2.style.display = currentQuestionIndex2 === quizQuestions2.length - 1 ? 'none' : 'block';
    finishButton2.style.display = currentQuestionIndex2 === quizQuestions2.length - 1 ? 'block' : 'none';
  }

  function selectImage2(image2) {
    var maxAllowedSelections2 = 2;
    var currentQuestionImages2 = quizQuestions2[currentQuestionIndex2].getElementsByClassName('quiz-image2');
    var selectedImagesCount2 = 0;

    for (var i = 0; i < currentQuestionImages2.length; i++) {
      if (currentQuestionImages2[i].classList.contains('selected2')) {
        selectedImagesCount2++;
      }
    }

    if (selectedImagesCount2 >= maxAllowedSelections2 && !image2.classList.contains('selected2')) {
      alert('Anda hanya dapat memilih ' + maxAllowedSelections2 + ' gambar di setiap pertanyaan.');
      return;
    }

    image2.classList.toggle('selected2');
    if (image2.classList.contains('selected2')) {
      selectedImages2.push(image2);
    } else {
      selectedImages2.splice(selectedImages2.indexOf(image2), 1);
    }

    // Mark the question as answered if an image is selected
    if (!answeredQuestions2.includes(currentQuestionIndex2)) {
      answeredQuestions2.push(currentQuestionIndex2);
    }

    updateGridColors(); // Update grid colors when an answer is selected
  }

  function previousQuestion2() {
    if (currentQuestionIndex2 > 0) {
      currentQuestionIndex2--;
      showCurrentQuestion2();
      updateGridColors();
    }
  }

  function nextQuestion2() {
    if (currentQuestionIndex2 < quizQuestions2.length - 1) {
      currentQuestionIndex2++;
      showCurrentQuestion2();
      updateGridColors();
    }
  }

  function updateGridColors() {
    for (let i = 0; i < quizQuestions2.length; i++) {
      var gridItem2 = document.getElementById(`grid2-${i + 1}`);
      if (gridItem2) {  // Check if the element exists
        if (i === currentQuestionIndex2) {
          // Current question: set to primary color
          gridItem2.style.backgroundColor = '#007bff'; // Bootstrap 'primary' color
          gridItem2.style.color = '#fff'; // Bootstrap 'primary' color
        } else if (answeredQuestions2.includes(i)) {
          // Answered question: set to success color
          gridItem2.style.backgroundColor = '#28a745'; // Bootstrap 'success' color
          gridItem2.style.color = '#fff'; // Bootstrap 'primary' color
        } else {
          // Unanswered question: set to plain/default color
          gridItem2.style.backgroundColor = '#f8f9fa'; // Bootstrap 'light' color
          gridItem2.style.color = '#000'; // Bootstrap 'primary' color
        }
      }
    }
  }

  function startCountdown2(duration2) {
    var timer2Element2 = document.getElementById('timer2');
    var timer2Interval = setInterval(function() {
      var minutes = Math.floor(duration2 / 60);
      var seconds = duration2 % 60;

      timer2Element2.textContent = minutes + 'm ' + seconds + 's';
      duration2--;

      if (duration2 < 0) {
        clearInterval(timer2Interval);
        timer2Element2.textContent = 'Time is up!';
        document.getElementById('quiz2').style.display = 'none';
        document.getElementById('button_modal2').style.display = 'none';
        document.getElementById('mulaiCFIT3').style.display = 'block';

        if (!finishSesi2) {
          finishGet2();
        }
      }
    }, 1000);
  }

  showCurrentQuestion2();
  updateGridColors(); // Initialize grid colors when the quiz starts
</script>