<?php
?>

<form>
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">Nom du quizz</span>
        <input type="text" class="form-control" id="quizz-name" placeholder="Entrez l'intituler du quizz"
               aria-label="Nom du quizz" aria-describedby="addon-wrapping">
    </div>
    <div class="mb-3 ">
        <div class="row">
            <div class="mt-3 d-flex justify-content-end">
                <a href="#" type="button" class="btn btn-primary" id="add-question-btn"><i class="fa fa-plus me-2"></i>Ajouter une question</a>
            </div>
        </div>
    </div>
    <div class="accordion" id="accordion">
    </div>
</form>

<div class="mb-3 ">
    <div class="row">
        <div class="mt-3 d-flex justify-content-end">
            <button class="btn btn-primary" type="submit" id="valid-btn"></button>
        </div>
    </div>
</div>


<script src="./Assets/JavaScript/Services/quizzAdmin.js" type="module"></script>
<script type="module">
    import {getQuizzAdmin} from "./Assets/Javascript/Services/quizzAdmin.js";
    import {qetAccordion, getAnswer, handleAccordion, handleAddAnswer} from "./Assets/Javascript/Component/questionAdmin.js";

    document.addEventListener('DOMContentLoaded', async () => {
        const accordionElement = document.querySelector(".accordion")
        const quizzName = document.querySelector("#quizz-name")
        const addQuestion = document.querySelector("#add-question-btn")
        const URL = new URLSearchParams(window.location.search)
        const validButton = document.querySelector("#valid-btn")
        const id = URL.get('id')
        const QUESTION_LIMIT = 30
        let data
        let countQuestion = 0

        if(id !== '0'){
            data = await getQuizzAdmin(id)
            quizzName.setAttribute('value', data.quizz[0].name)
            const questions = JSON.parse(data.quizz[0].questions)
            for (let i = 0; i < questions.length; i++) {
                const answers = questions[i].answers
                let answersHtml = ""
                for (let j = 0; j < answers.length; j++) {
                    answersHtml += getAnswer(answers[j])
                }
                accordionElement.innerHTML += qetAccordion(questions[i].question,answersHtml, countQuestion)
                countQuestion++
            }
        }

        addQuestion.addEventListener('click', () => {
            if(countQuestion < QUESTION_LIMIT) {
                accordionElement.innerHTML += qetAccordion("", "", countQuestion)
                countQuestion++
                handleAccordion()
                handleAddAnswer()
            }
        })

        validButton.innerHTML = id === '0' ? "Créer" : "Modifier"
    })
</script>