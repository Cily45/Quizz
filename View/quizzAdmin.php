<?php
?>
<h1>QuizzAdmin</h1>

<div class="accordion" id="accordion">

</div>


<script src="./Assets/JavaScript/Services/quizz.js" type="module"></script>
<script type="module">
    import {getQuizzAdmin} from "./Assets/Javascript/Services/quizz.js";
    import {qetAccordion} from "./Assets/Javascript/Component/question.js";

    document.addEventListener('DOMContentLoaded', async () =>{
        const acordionElement = document.querySelector(".accordion")
        let currentQuestion = 0;
        let data = await getQuizzAdmin(<?php echo $_GET['id'] ?? 0 ?>)
        console.log(data)
        const displayQuestion = async () =>{
            acordionElement.innerHTML = ""
            for(let i = 0; i < data.questions.length; i++){
                const questionPosition = i+1;
                const isCurrentQuestion = questionPosition == currentQuestion;
                acordionElement.innerHTML += qetAccordion(data.questions[i], questionPosition, isCurrentQuestion)
            }

            const acordionItemElement = document.querySelectorAll(".accordion-button")
            for(let i = 0; i < acordionItemElement.length; i++){
                acordionItemElement[i].addEventListener( 'click', (event)=> {
                    const position = event.target.getAttribute('data-position')
                    currentQuestion = position === currentQuestion ? 0 : position
                    displayQuestion()
                })
            }
        }

        await displayQuestion()

    })
</script>