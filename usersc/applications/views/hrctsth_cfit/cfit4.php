
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
  
  .quiz-image4 {
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
  
  .quiz-option.selected4 .quiz-image4 {
    border-color: #0d6efd;
  }
  
  .timer4-container {
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
  
  .selected4 {
    border: 3px solid #007bff;
  }
</style>

<div class="row">
  <div class="col-lg-10">
    <div class="quiz-container">
      <div class="timer-container">
        Time Left: <span id="timer4"></span>
      </div>

      <div class="cfit4-question" id="question1">
        <h3>Question 1</h3>
        <img src="part4/q1/1.jpg" class="soal">
        <br>

        <h5>Answers:</h5>
        <div class="cfit4-option">
          <img src="part4/q1/option1.jpg" alt="1" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q1/option2.jpg" alt="2" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q1/option3.jpg" alt="3" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q1/option4.jpg" alt="4" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q1/option5.jpg" alt="5" class="quiz-image4" onclick="selectImage4(this)">
        </div>
      </div>

      <div class="cfit4-question" id="question2">
        <h3>Question 2</h3>
        <img src="part4/q2/1.jpg" class="soal">
        <br>

        <h5>Answers:</h5>
        <div class="cfit4-option">
          <img src="part4/q2/option1.jpg" alt="1" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q2/option2.jpg" alt="2" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q2/option3.jpg" alt="3" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q2/option4.jpg" alt="4" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q2/option5.jpg" alt="5" class="quiz-image4" onclick="selectImage4(this)">
        </div>
      </div>

      <div class="cfit4-question" id="question3">
        <h3>Question 3</h3>
        <img src="part4/q3/1.jpg" class="soal">
        <br>

        <h5>Answers:</h5>
        <div class="cfit4-option">
          <img src="part4/q3/option1.jpg" alt="1" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q3/option2.jpg" alt="2" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q3/option3.jpg" alt="3" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q3/option4.jpg" alt="4" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q3/option5.jpg" alt="5" class="quiz-image4" onclick="selectImage4(this)">
        </div>
      </div>

      <div class="cfit4-question" id="question4">
        <h3>Question 4</h3>
        <img src="part4/q4/1.jpg" class="soal">
        <br>

        <h5>Answers:</h5>
        <div class="cfit4-option">
          <img src="part4/q4/option1.jpg" alt="1" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q4/option2.jpg" alt="2" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q4/option3.jpg" alt="3" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q4/option4.jpg" alt="4" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q4/option5.jpg" alt="5" class="quiz-image4" onclick="selectImage4(this)">
        </div>
      </div>


      <div class="cfit4-question" id="question5">
        <h3>Question 5</h3>
        <img src="part4/q5/1.jpg" class="soal">
        <br>

        <h5>Answers:</h5>
        <div class="cfit4-option">
          <img src="part4/q5/option1.jpg" alt="1" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q5/option2.jpg" alt="2" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q5/option3.jpg" alt="3" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q5/option4.jpg" alt="4" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q5/option5.jpg" alt="5" class="quiz-image4" onclick="selectImage4(this)">
        </div>
      </div>

      <div class="cfit4-question" id="question6">
        <h3>Question 6</h3>
        <img src="part4/q6/1.jpg" class="soal">
        <br>

        <h5>Answers:</h5>
        <div class="cfit4-option">
          <img src="part4/q6/option1.jpg" alt="1" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q6/option2.jpg" alt="2" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q6/option3.jpg" alt="3" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q6/option4.jpg" alt="4" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q6/option5.jpg" alt="5" class="quiz-image4" onclick="selectImage4(this)">
        </div>
      </div>

      <div class="cfit4-question" id="question7">
        <h3>Question 7</h3>
        <img src="part4/q7/1.jpg" class="soal">
        <br>

        <h5>Answers:</h5>
        <div class="cfit4-option">
          <img src="part4/q7/option1.jpg" alt="1" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q7/option2.jpg" alt="2" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q7/option3.jpg" alt="3" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q7/option4.jpg" alt="4" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q7/option5.jpg" alt="5" class="quiz-image4" onclick="selectImage4(this)">
        </div>
      </div>

      <div class="cfit4-question" id="question8">
        <h3>Question 8</h3>
        <img src="part4/q8/1.jpg" class="soal">
        <br>

        <h5>Answers:</h5>
        <div class="cfit4-option">
          <img src="part4/q8/option1.jpg" alt="1" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q8/option2.jpg" alt="2" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q8/option3.jpg" alt="3" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q8/option4.jpg" alt="4" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q8/option5.jpg" alt="5" class="quiz-image4" onclick="selectImage4(this)">
        </div>
      </div>

      <div class="cfit4-question" id="question9">
        <h3>Question 9</h3>
        <img src="part4/q9/1.jpg" class="soal">
        <br>

        <h5>Answers:</h5>
        <div class="cfit4-option">
          <img src="part4/q9/option1.jpg" alt="1" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q9/option2.jpg" alt="2" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q9/option3.jpg" alt="3" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q9/option4.jpg" alt="4" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q9/option5.jpg" alt="5" class="quiz-image4" onclick="selectImage4(this)">
        </div>
      </div>

      <div class="cfit4-question" id="question10">
        <h3>Question 10</h3>
        <img src="part4/q10/1.jpg" class="soal">
        <br>

        <h5>Answers:</h5>
        <div class="cfit4-option">
          <img src="part4/q10/option1.jpg" alt="1" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q10/option2.jpg" alt="2" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q10/option3.jpg" alt="3" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q10/option4.jpg" alt="4" class="quiz-image4" onclick="selectImage4(this)">
        </div>
        <div class="cfit4-option">
          <img src="part4/q10/option5.jpg" alt="5" class="quiz-image4" onclick="selectImage4(this)">
        </div>
      </div>

      <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-9">
          <button onclick="previousQuestion4()" class="btn btn-primary" id="prevButton4">Previous</button>
        </div>
        <div class="col-md-2">
          <button onclick="nextQuestion4()" class="btn btn-primary" id="nextButton4">Next</button>
          <button onclick="finishQuiz4()" class="btn btn-success" id="finishButton4" style="display: none;">Finish</button>
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
                for (let i = 1; i <= 10; i++) {
                  var boxClass4 = "grid-box";
                  document.write(`
                    <div class="grid-item" onclick="goToQuestion4(${i - 1})">
                      <div class="${boxClass4}" id="grid4-${i}">${i}</div>
                    </div>
                  `);
                }

                function goToQuestion4(questionIndex) {
                  currentQuestionIndex4 = questionIndex;
                  showCurrentQuestion4();
                  updateGridColors4(); // Update the grid color when navigating to a question
                }
              </script>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

<script>
  var currentQuestionIndex4 = 0;
  var selected4Images = [];
  var answeredQuestions4 = []; 
  var quizQuestions4 = document.getElementsByClassName('cfit4-question');
  var prevButton4 = document.getElementById('prevButton4');
  var nextButton4 = document.getElementById('nextButton4');
  var finishButton4 = document.getElementById('finishButton4');
  var timer4Element = document.getElementById('timer4');
  var countdownInterval4;

  function showCurrentQuestion4() {
    for (var i = 0; i < quizQuestions4.length; i++) {
      if (i === currentQuestionIndex4) {
        quizQuestions4[i].style.display = 'block';
      } else {
        quizQuestions4[i].style.display = 'none';
      }
    }

    // Enable/disable buttons based on current question index
    prevButton4.style.display = currentQuestionIndex4 === 0 ? 'none' : 'block';
    nextButton4.style.display = currentQuestionIndex4 === quizQuestions4.length - 1 ? 'none' : 'block';
    finishButton4.style.display = currentQuestionIndex4 === quizQuestions4.length - 1 ? 'block' : 'none';
  }

  function selectImage4(image4) {
    var maxAllowedSelections = 1;
    var currentQuestionImages = quizQuestions4[currentQuestionIndex4].getElementsByClassName('quiz-image4');
    var selected4ImagesCount = 0;

    // Count the number of selected4 images in the current question
    for (var i = 0; i < currentQuestionImages.length; i++) {
        if (currentQuestionImages[i].classList.contains('selected4')) {
            selected4ImagesCount++;
        }
    }

    // Select the new image
    image4.classList.toggle('selected4');

    if (image4.classList.contains('selected4')) {
        // Clear the selectedImages array and add the new selection
        selected4Images = [];
        selected4Images.push(image4);
    } else {
        // Remove the deselected image from the selectedImages array
        var index = selected4Images.indexOf(image4);
        if (index > -1) {
            selected4Images.splice(index, 1);
        }
    }

    // Mark selected4 images
    for (var i = 0; i < currentQuestionImages.length; i++) {
        var currentImage4 = currentQuestionImages[i];
        if (selected4Images.includes(currentImage4)) {
            currentImage4.classList.add('selected4');
        } else {
            currentImage4.classList.remove('selected4');
        }
    }

    // Mark the question as answered if an image is selected
    if (!answeredQuestions4.includes(currentQuestionIndex4)) {
      answeredQuestions4.push(currentQuestionIndex4);
    }

    updateGridColors4();
  }

  function previousQuestion4() {
    if (currentQuestionIndex4 > 0) {
      currentQuestionIndex4--;
      showCurrentQuestion4();
      updateGridColors4();
    }
  }

  function nextQuestion4() {
    if (currentQuestionIndex4 < quizQuestions4.length - 1) {
      currentQuestionIndex4++;
      showCurrentQuestion4();
      updateGridColors4();
    }
  }
  
  function updateGridColors4() {
    for (let i = 0; i < quizQuestions4.length; i++) {
      var gridItem4 = document.getElementById(`grid4-${i + 1}`);
      if (gridItem4) {  // Check if the element exists
        if (i === currentQuestionIndex4) {
          // Current question: set to primary color
          gridItem4.style.backgroundColor = '#007bff'; // Bootstrap 'primary' color
          gridItem4.style.color = '#fff'; // Bootstrap 'primary' color
        } else if (answeredQuestions4.includes(i)) {
          // Answered question: set to success color
          gridItem4.style.backgroundColor = '#48a745'; // Bootstrap 'success' color
          gridItem4.style.color = '#fff'; // Bootstrap 'primary' color
        } else {
          // Unanswered question: set to plain/default color
          gridItem4.style.backgroundColor = '#f8f9fa'; // Bootstrap 'light' color
          gridItem4.style.color = '#000'; // Bootstrap 'primary' color
        }
      }
    }
  }

  function startCountdown4(duration4) {
    var timer4Element = document.getElementById('timer4');
    var timer4Interval = setInterval(function() {
    var minutes = Math.floor(duration4 / 60);
    var seconds = duration4 % 60;
    

    // Display the remaining time in the timer2 element
    timer4Element.textContent = minutes + 'm ' + seconds + 's';

    // Decrement the duration4
    duration4--;

    // Check if the countdown is finished
    if (duration4 < 0) {
        clearInterval(timer4Interval);
        timer4Element.textContent = 'Time is up!';

        // Additional actions when the countdown ends
        // ...

        // Disable or hide the quiz if needed
        document.getElementById('quiz4').style.display = 'none';
        document.getElementById('button_modal4').style.display = 'none';
        document.getElementById('mulaiCFIT4').style.display = 'block';

        if (!finishSesi4) {
          finishGet4();
        }
      }
    }, 1000);
    return;
  }

  showCurrentQuestion4();
  updateGridColors4();
</script>