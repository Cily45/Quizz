<?php
?>
<div class="container">
    <h1 class="text-center m-3" id="title-quizz">Quizz</h1>
    <div class="progress m-4" id="progress-bar" role="progressbar" aria-label="Info example" aria-valuenow="0"
         aria-valuemin="0" aria-valuemax="100">
        <div class="progress-bar" id="progress-bar-text" style="width: 0%">0%</div>
    </div>
</div>
<div class="container border">
    <div id="result">
    </div>
    <div id="displayQuestions">
    </div>
    <div id="btn" class="d-flex flex-row justify-content-between m-3">
        <button type="button" class="btn btn-primary" id="previous-btn" disabled>Precédent</button>
        <button type="button" class="btn btn-primary" id="next-btn">Suivant</button>
    </div>
</div>
<script src="./assets/javascript/services/quizz.js" type="module"></script>
<script type="module">

    import {getQuizz} from "./assets/javascript/services/quizz.js";
    import {
        displayResultQuizz,
        getQuestion,
        changeQuestion,
        updateProgressBar,
        countScore,
        getResult,
        isChecked,
        sumScore
    } from "./assets/javascript/component/quizz.js";

    document.addEventListener('DOMContentLoaded', async () => {
        const URL = new URLSearchParams(window.location.search)
        const id = URL.get('id')
        const data = await getQuizz(id);
        const titleQuizz = document.querySelector('#title-quizz')
        const nextBtn = document.querySelector("#next-btn")
        const previousBtn = document.querySelector("#previous-btn")
        const questions = JSON.parse(data.quizz[0].questions)
        const countQuestions = questions.length
        const PROGRESS_BAR_WIDTH = Math.round(100 / countQuestions)
        const dateStart = Date.now()
        let progressCount = 0
        let currentQuestion = 0
        let scoreCount = []

        titleQuizz.innerHTML = data.quizz[0].name

        document.querySelector("#displayQuestions").innerHTML = getQuestion(questions)
        document.querySelector("#question-0-content").classList.remove('d-none')

        nextBtn.addEventListener('click', () => {
            const formQuestion = document.querySelector(`#form-question-${currentQuestion}`)

            if (!isChecked(currentQuestion)) {
                formQuestion.reportValidity()
                return false
            }

            currentQuestion++;
            progressCount = currentQuestion === countQuestions ? 100 : progressCount + PROGRESS_BAR_WIDTH
            updateProgressBar(progressCount)
            scoreCount[currentQuestion - 1] = countScore((questions[currentQuestion - 1].answers), currentQuestion - 1)


            if (currentQuestion === countQuestions) {
                document.querySelector(`#question-${currentQuestion - 1}-content`).classList.add('d-none')
                displayResultQuizz(sumScore(scoreCount), getResult(scoreCount), id, questions, data.quizz[0].max_score, dateStart)
            } else {
                changeQuestion(currentQuestion - 1, currentQuestion)
            }

            previousBtn.disabled = currentQuestion === 0
        })

        previousBtn.addEventListener('click', () => {
            currentQuestion--;
            progressCount -= PROGRESS_BAR_WIDTH
            updateProgressBar(progressCount)
            changeQuestion(currentQuestion + 1, currentQuestion)
            previousBtn.disabled = currentQuestion === 0
        })
    })
</script>