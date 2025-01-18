<?php
?>
<div class="container">
<h1 class="text-center" id="title-quizz">Quizz</h1>

    <div class="progress" id="progress-bar" role="progressbar" aria-label="Info example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
        <div class="progress-bar" id="progress-bar-text" style="width: 0%">0%</div>
    </div>

</div>
<div class="container border">
    <h2 class=" text-center m-3" id="title-question">Question 1</h2>
        <div id="answers" class="m-2 ms-5">

        </div>
    <div id="btn" class="d-flex flex-row justify-content-between m-3">
        <button type="button" class="btn btn-primary" id="previous-btn" disabled>Precédent</button>
        <button type="button" class="btn btn-primary" id="next-btn" disabled>Suivant</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="./Assets/JavaScript/Services/quizz.js" type="module"></script>
<script type="module">


    import {getQuizz} from "./Assets/Javascript/Services/quizz.js";
    import {displayQuestion, displayResultQuizz} from "./Assets/Javascript/Component/question.js";


    document.addEventListener('DOMContentLoaded', async () => {

        const data = await getQuizz(<?php echo $_GET['id'] ?? 0 ?>);
        const titleQuizz = document.querySelector('#title-quizz')
        const progressBarElement = document.querySelector("#progress-bar")
        const progressBarText = document.querySelector("#progress-bar-text")
        const nextBtn = document.querySelector("#next-btn")
        const previousBtn = document.querySelector("#previous-btn")
        const countQuestions = data.questions.length
        const PROGRESS_BAR_WIDTH =  Math.trunc(100 / countQuestions)
        let progressCount = 0
        let currentQuestion = 0
        const userAnswer = []
        let countIsChecked = 0
        let curentScore = 0


        titleQuizz.innerHTML = data.quizz[0].name
        displayQuestion(currentQuestion, data)

        const checkInput = document.querySelectorAll('.form-check-input')
        for(let i = 0; i < checkInput.length; i++){
            checkInput[i].addEventListener('click', () =>{
                if(checkInput[i].checked){
                    countIsChecked++
                }else{
                    countIsChecked--
                }
                nextBtn.disabled = countIsChecked === 0
                nextBtn.disabled = i === checkInput.length - 1
            })
        }

        nextBtn.addEventListener('click', () =>{
            currentQuestion++;
            progressCount = currentQuestion === countQuestions ? 100 : progressCount + PROGRESS_BAR_WIDTH
            updateProgressBar()
            if(currentQuestion === countQuestions){
                displayResultQuizz(curentScore, [4,6])
            }else{
                displayQuestion(currentQuestion, data)
            }

        })

        previousBtn.addEventListener('click', () =>{
            currentQuestion--;
            progressCount -= PROGRESS_BAR_WIDTH
            updateProgressBar()
            displayQuestion(currentQuestion, data)
        })



        const updateProgressBar = () => {
            progressBarText.style.width = `${progressCount}%`
            progressBarText.innerHTML = `${progressCount}%`
            progressBarElement.setAttribute('aria-valuenow', progressCount)
        }
    })
</script>