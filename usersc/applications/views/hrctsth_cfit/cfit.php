
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
  
  .quiz-image {
    max-width: 300px;
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
  
  .quiz-option.selected .quiz-image {
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
    max-width: 250px;
    height: auto;
  }
  
  .selected {
    border: 3px solid #007bff;
  }
</style>

<div class="row">
  <div class="col-lg-10">
    <div class="quiz-container">
      <div class="timer-container">
        Sisa Waktu: <span id="timer"></span>
      </div>
      
      <div class="quiz-question" id="question1">
        <h3>Pertanyaan 1</h3>
        <img src="part1/q1/1.jpg" class="soal">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part1/q1/option1.jpg" alt="1" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q1/option2.jpg" alt="2" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q1/option3.jpg" alt="3" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q1/option4.jpg" alt="4" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q1/option5.jpg" alt="5" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q1/option6.jpg" alt="6" class="quiz-image" onclick="selectImage(this)">
        </div>
      </div>

      <div class="quiz-question" id="question2">
        <h3>Pertanyaan 2</h3>
        <img src="part1/q2/1.jpg" class="soal">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part1/q2/option1.jpg" alt="1" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q2/option2.jpg" alt="2" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q2/option3.jpg" alt="3" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q2/option4.jpg" alt="4" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q2/option5.jpg" alt="5" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q2/option6.jpg" alt="6" class="quiz-image" onclick="selectImage(this)">
        </div>
      </div>

      <div class="quiz-question" id="question3">
        <h3>Pertanyaan 3</h3>
        <img src="part1/q3/1.jpg" class="soal">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part1/q3/option1.jpg" alt="1" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q3/option2.jpg" alt="2" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q3/option3.jpg" alt="3" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q3/option4.jpg" alt="4" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q3/option5.jpg" alt="5" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q3/option6.jpg" alt="6" class="quiz-image" onclick="selectImage(this)">
        </div>
      </div>

      <div class="quiz-question" id="question4">
        <h3>Pertanyaan 4</h3>
        <img src="part1/q4/1.jpg" class="soal">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part1/q4/option1.jpg" alt="1" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q4/option2.jpg" alt="2" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q4/option3.jpg" alt="3" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q4/option4.jpg" alt="4" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q4/option5.jpg" alt="5" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q4/option6.jpg" alt="6" class="quiz-image" onclick="selectImage(this)">
        </div>
      </div>


      <div class="quiz-question" id="question5">
        <h3>Pertanyaan 5</h3>
        <img src="part1/q5/1.jpg" class="soal">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part1/q5/option1.jpg" alt="1" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q5/option2.jpg" alt="2" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q5/option3.jpg" alt="3" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q5/option4.jpg" alt="4" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q5/option5.jpg" alt="5" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q5/option6.jpg" alt="6" class="quiz-image" onclick="selectImage(this)">
        </div>
      </div>

      <div class="quiz-question" id="question6">
        <h3>Pertanyaan 6</h3>
        <img src="part1/q6/1.jpg" class="soal">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part1/q6/option1.jpg" alt="1" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q6/option2.jpg" alt="2" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q6/option3.jpg" alt="3" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q6/option4.jpg" alt="4" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q6/option5.jpg" alt="5" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q6/option6.jpg" alt="6" class="quiz-image" onclick="selectImage(this)">
        </div>
      </div>

      <div class="quiz-question" id="question7">
        <h3>Pertanyaan 7</h3>
        <img src="part1/q7/1.jpg" class="soal">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part1/q7/option1.jpg" alt="1" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q7/option2.jpg" alt="2" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q7/option3.jpg" alt="3" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q7/option4.jpg" alt="4" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q7/option5.jpg" alt="5" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q7/option6.jpg" alt="6" class="quiz-image" onclick="selectImage(this)">
        </div>
      </div>

      <div class="quiz-question" id="question8">
        <h3>Pertanyaan 8</h3>
        <img src="part1/q8/1.jpg" class="soal">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part1/q8/option1.jpg" alt="1" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q8/option2.jpg" alt="2" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q8/option3.jpg" alt="3" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q8/option4.jpg" alt="4" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q8/option5.jpg" alt="5" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q8/option6.jpg" alt="6" class="quiz-image" onclick="selectImage(this)">
        </div>
      </div>

      <div class="quiz-question" id="question9">
        <h3>Pertanyaan 9</h3>
        <img src="part1/q9/1.jpg" class="soal">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part1/q9/option1.jpg" alt="1" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q9/option2.jpg" alt="2" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q9/option3.jpg" alt="3" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q9/option4.jpg" alt="4" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q9/option5.jpg" alt="5" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q9/option6.jpg" alt="6" class="quiz-image" onclick="selectImage(this)">
        </div>
      </div>

      <div class="quiz-question" id="question10">
        <h3>Pertanyaan 10</h3>
        <img src="part1/q10/1.jpg" class="soal">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part1/q10/option1.jpg" alt="1" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q10/option2.jpg" alt="2" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q10/option3.jpg" alt="3" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q10/option4.jpg" alt="4" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q10/option5.jpg" alt="5" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q10/option6.jpg" alt="6" class="quiz-image" onclick="selectImage(this)">
        </div>
      </div>

      <div class="quiz-question" id="question11">
        <h3>Pertanyaan 11</h3>
        <img src="part1/q11/1.jpg" class="soal">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part1/q11/option1.jpg" alt="1" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q11/option2.jpg" alt="2" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q11/option3.jpg" alt="3" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q11/option4.jpg" alt="4" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q11/option5.jpg" alt="5" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q11/option6.jpg" alt="6" class="quiz-image" onclick="selectImage(this)">
        </div>
      </div>

      <div class="quiz-question" id="question12">
        <h3>Pertanyaan 12</h3>
        <img src="part1/q12/1.jpg" class="soal">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part1/q12/option1.jpg" alt="1" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q12/option2.jpg" alt="2" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q12/option3.jpg" alt="3" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q12/option4.jpg" alt="4" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q12/option5.jpg" alt="5" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q12/option6.jpg" alt="6" class="quiz-image" onclick="selectImage(this)">
        </div>
      </div>

      <div class="quiz-question" id="question13">
        <h3>Pertanyaan 13</h3>
        <img src="part1/q13/1.jpg" class="soal">
        <br>

        <h5>Jawaban:</h5>
        <div class="quiz-option">
          <img src="part1/q13/option1.jpg" alt="1" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q13/option2.jpg" alt="2" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q13/option3.jpg" alt="3" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q13/option4.jpg" alt="4" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q13/option5.jpg" alt="5" class="quiz-image" onclick="selectImage(this)">
        </div>
        <div class="quiz-option">
          <img src="part1/q13/option6.jpg" alt="6" class="quiz-image" onclick="selectImage(this)">
        </div>
      </div>
      <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-9">
          <button onclick="previousQuestion()" class="btn btn-primary" id="prevButton">Previous</button>
        </div>
        <div class="col-md-2">
          <button onclick="nextQuestion()" class="btn btn-primary" id="nextButton">Next</button>
          <button onclick="finishQuiz()" class="btn btn-success" id="finishButton" style="display: none;">Finish</button>
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
                      var boxClass1 = "grid-box";
                      document.write(`
                        <div class="grid-item" onclick="goToQuestion1(${i - 1})">
                          <div class="${boxClass1}" id="grid1-${i}">${i}</div>
                        </div>
                      `);
                    }

                    function goToQuestion1(questionIndex) {
                      currentQuestionIndex = questionIndex;
                      showCurrentQuestion();
                      updateGridColors1(); // Update the grid color when navigating to a question
                    }
                  </script>
              </div>
            </div>
        </div>
    </div>
  </div>

</div>

<script>
    var currentQuestionIndex = 0;
    var selectedImages = [];
    var answeredQuestions = []; // Array to track answered questions
    var quizQuestions = document.getElementsByClassName('quiz-question');
    var prevButton = document.getElementById('prevButton');
    var nextButton = document.getElementById('nextButton');
    var finishButton = document.getElementById('finishButton');
    var timerElement = document.getElementById('timer');
    var countdownInterval;

    function showCurrentQuestion() {
        for (var i = 0; i < quizQuestions.length; i++) {
            if (i === currentQuestionIndex) {
                quizQuestions[i].style.display = 'block';
            } else {
                quizQuestions[i].style.display = 'none';
            }
        }

        // Enable/disable buttons based on current question index
        prevButton.style.display = currentQuestionIndex === 0 ? 'none' : 'block';
        nextButton.style.display = currentQuestionIndex === quizQuestions.length - 1 ? 'none' : 'block';
        finishButton.style.display = currentQuestionIndex === quizQuestions.length - 1 ? 'block' : 'none';
    }

    function selectImage(image) {
        var maxAllowedSelections = 1;
        var currentQuestionImages = quizQuestions[currentQuestionIndex].getElementsByClassName('quiz-image');
        var selectedImagesCount = 0;

        // Count the number of selected images in the current question
        for (var i = 0; i < currentQuestionImages.length; i++) {
            if (currentQuestionImages[i].classList.contains('selected')) {
                selectedImagesCount++;
            }
        }

        if (selectedImagesCount >= maxAllowedSelections && !image.classList.contains('selected')) {
            // Deselect the previously selected image
            var previouslySelectedImage = document.querySelector('.quiz-image.selected');
            previouslySelectedImage.classList.remove('selected');
        }

        // Select the new image
        image.classList.toggle('selected');

        // Update the selectedImages array
        selectedImages = [image];

        // Mark selected images
        for (var i = 0; i < currentQuestionImages.length; i++) {
            var currentImage = currentQuestionImages[i];
            if (selectedImages.includes(currentImage)) {
                currentImage.classList.add('selected');
            } else {
                currentImage.classList.remove('selected');
            }
        }

      // Mark the question as answered if an image is selected
      if (!answeredQuestions.includes(currentQuestionIndex)) {
        answeredQuestions.push(currentQuestionIndex);
      }

      updateGridColors1();
    }
    function previousQuestion() {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            showCurrentQuestion();
            updateGridColors1();
        }
    }

    function nextQuestion() {
        if (currentQuestionIndex < quizQuestions.length - 1) {
            currentQuestionIndex++;
            showCurrentQuestion();
            updateGridColors1();
        }
    }

    function updateGridColors1() {
      for (let i = 0; i < quizQuestions.length; i++) {
        var gridItem1 = document.getElementById(`grid1-${i + 1}`);
        if (gridItem1) {  // Check if the element exists
          if (i === currentQuestionIndex) {
            // Current question: set to primary color
            gridItem1.style.backgroundColor = '#007bff'; // Bootstrap 'primary' color
            gridItem1.style.color = '#fff'; // Bootstrap 'primary' color
          } else if (answeredQuestions.includes(i)) {
            // Answered question: set to success color
            gridItem1.style.backgroundColor = '#18a745'; // Bootstrap 'success' color
            gridItem1.style.color = '#fff'; // Bootstrap 'primary' color
          } else {
            // Unanswered question: set to plain/default color
            gridItem1.style.backgroundColor = '#f8f9fa'; // Bootstrap 'light' color
            gridItem1.style.color = '#000'; // Bootstrap 'primary' color
          }
        }
      }
    }
    
    function startCountdown(duration) {
        var timerElement = document.getElementById('timer');
        var timerInterval = setInterval(function() {
            var minutes = Math.floor(duration / 60);
            var seconds = duration % 60;

            if (finishSesi1) {
                clearInterval(timerInterval);
                console.log("Countdown dihentikan karena finishSesi1 = true");
                return;
            }
            
            // Display the remaining time in the timer element
            timerElement.textContent = minutes + 'm ' + seconds + 's';

            // Decrement the duration
            duration--;

            // Check if the countdown is finished
            if (duration < 0) {
                clearInterval(timerInterval);
                timerElement.textContent = 'Time is up!';

                // Additional actions when the countdown ends
                // ...
                // Disable or hide the quiz if needed
                document.getElementById('quiz1').style.display = 'none';
                document.getElementById('button_modal1').style.display = 'none';
                document.getElementById('mulaiCFIT2').style.display = 'block';
                document.getElementById('button_modal2').style.display = 'block';
                if (!finishSesi1) {
                    finishGet();
                }
            }
        }, 1000);
        return;
    }

    showCurrentQuestion();
    updateGridColors1();
</script>