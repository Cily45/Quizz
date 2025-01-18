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
                <a href="#" type="button" class="btn btn-primary" id="add-question"><i class="fa fa-plus me-2"></i>Ajouter une question</a>
            </div>
        </div>
    </div>
    <div class="accordion" id="accordion">

    </div>
</form>
<button class="btn btn-primary" type="submit"><?php echo isset($_GET['id']) ? "Modifier" : "Créer" ?></button>


<script src="./Assets/JavaScript/Services/quizzAdmin.js" type="module"></script>
<script type="module">
    import {getQuizzAdmin} from "./Assets/Javascript/Services/quizzAdmin.js";
    import {qetAccordion, getAnswer} from "./Assets/Javascript/Component/questionAdminDisplay.js";
    import {handleAccordion} from "./Assets/Javascript/Component/questionAdminHandle.js";

    document.addEventListener('DOMContentLoaded', async () => {
        const acordionElement = document.querySelector(".accordion")
        const quizzName = document.querySelector("#quizz-name")
        const addQuestion = document.querySelector("#add-question")

        let currentQuestion = 0;
        let data = await getQuizzAdmin(<?php echo $_GET['id'] ?? 0 ?>)
        quizzName.setAttribute('value', data.quizz[0].name)

        const questions = JSON.parse(data.quizz[0].questions)

        acordionElement.innerHTML = ""

        for (let i = 0; i < questions.length; i++) {
            const questionPosition = i + 1;
            const isCurrentQuestion = questionPosition == currentQuestion;
            const answers = questions[i].answers

            acordionElement.innerHTML += qetAccordion(questions[i].question, questionPosition, isCurrentQuestion)
            const answersElement = document.querySelector(`#answers${i + 1}`)

            answersElement.innerHTML = ""
            for (let j = 0; j < answers.length; j++) {
                answersElement.innerHTML += getAnswer(answers[j])
                if (j === answers.length - 1 && answers.length < 8) {
                    answersElement.innerHTML += '<button type="button" class="btn btn-primary">+</button>'
                }
            }
           handleAccordion()
        }


        const acordionItemElement = document.querySelectorAll(".accordion-button")
        for (let i = 0; i < acordionItemElement.length; i++) {
            acordionItemElement[i].addEventListener('click', (event) => {
                const position = event.target.getAttribute('data-position')
                currentQuestion = position === currentQuestion ? 0 : position
            })
        }
    })
</script>