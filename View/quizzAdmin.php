<?php
?>

<form id="quizz-form">
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">Nom du quizz</span>
        <input type="text" class="form-control" id="quizz-name" placeholder="Entrez l'intituler du quizz"
               aria-label="Nom du quizz" aria-describedby="addon-wrapping" required>
    </div>
    <div class="mb-3 ">
        <div class="row">
            <div class="mt-3 d-flex justify-content-end">
                <a href="#" type="button" class="btn btn-primary" id="add-question-btn"><i class="fa fa-plus me-2"></i>Ajouter une question</a>
            </div>
        </div>
    </div>
    <ul class="accordion list-group" id="accordion">
    </ul>
    <div class="form-check m-3 d-flex justify-content-end">
        <input class="form-check-input" type="checkbox" value="" id="flexCheckPublished" checked>
        <label class="form-check-label ms-2" for="flexCheckChecked">
            Publier
        </label>
    </div>
</form>

<div class="mb-3 ">
    <div class="row">
        <div class="mt-3 d-flex justify-content-end">
            <button class="btn btn-primary" type="button" id="valid-btn"></button>
        </div>
    </div>
</div>


<script src="./Assets/JavaScript/Services/quizzAdmin.js" type="module"></script>
<script type="module">
    import {getQuizzAdmin} from "./Assets/Javascript/Services/quizzAdmin.js";
    import {getAccordion, getAnswer, handleAccordion, handleAddAnswer, handleRemoveQuestion,handleValidButton, handleRemoveAnswer, handleAddQuestion, handleGoodAnswers} from "./Assets/Javascript/Component/questionAdmin.js";

    document.addEventListener('DOMContentLoaded', async () => {
        const accordionElement = document.querySelector(".accordion")
        const quizzName = document.querySelector("#quizz-name")
        const URL = new URLSearchParams(window.location.search)
        const validButton = document.querySelector("#valid-btn")
        const id = URL.get('id')
        let data
        let countQuestion = 0

        if(id !== '0'){
            data = await getQuizzAdmin(id)
            quizzName.setAttribute('value', data.quizz[0].name)
            const questions = JSON.parse(data.quizz[0].questions)
            for (let i = 0; i < questions.length; i++) {
                const answers = questions[i].answers
                accordionElement.appendChild(getAccordion(questions[i].question, countQuestion))
                const currentQuestion = document.querySelector(`#answers-${countQuestion}`)
                for (let j = 0; j < answers.length; j++) {
                    currentQuestion.appendChild(getAnswer(answers[j], i, j))
                }
                countQuestion++
            }
        }

        handleAccordion()
        handleAddAnswer()
        handleRemoveQuestion()
        handleRemoveAnswer()
        handleAddQuestion(countQuestion)
        handleValidButton(id)
        handleGoodAnswers()

        validButton.innerHTML = id === '0' ? "Créer" : "Modifier"
    })
</script>