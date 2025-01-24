import {showToast} from "./shared/toast.js";
import {createQuizz, updateQuizz} from "../Services/quizz.js";


export const getAccordion = (question, questionId) => {
    const newQuestionElement = document.createElement('li');
    newQuestionElement.classList.add("accordion-item")
    newQuestionElement.classList.add("list-group-item")
    newQuestionElement.setAttribute('id', `accordion-${questionId}`)
    newQuestionElement.setAttribute("draggable", "true")
    newQuestionElement.innerHTML = ` 
                <h2 class="accordion-header">    
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse${questionId}" aria-expanded="true" aria-controls="collapse">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text  bg-primary text-white" id="addon-wrapping-${questionId}">Question:</span>
                                <input type="text" class="form-control questions" data-id="${questionId}" placeholder="Entrez votre question" aria-label="Entrez votre question" aria-describedby="addon-wrapping-${questionId}" id="question-${questionId}" value="${question}" required>
                            
                            </div> 
                            <div class="m-3">
                                <i class="fa-solid fa-xmark delete-question-btn" data-id="${questionId}" style="color: #ff0000;"></i>
                            </div>
                    </button> 
                </h2>
                    <div id="collapse${questionId}" class="accordion-collapse collapse" data-bs-parent="#accordion-${questionId}">
                        <div class="accordion-body">
                             <ul id="answers-${questionId}" class="col container answers">
                              
                             </ul>
                             <div class="mb-3 ">
                                   <div class="row">
                                        <div class="mt-3 d-flex justify-content-end">
                                             <button data-id ="${questionId}" type="button" class="btn btn-primary add-answer-btn">+</button>
                                        </div>
                                   </div>
                             </div>
                        </div>
                    </div>
      `
    return newQuestionElement
}
export const getAnswer = (answer, questionId, answerId) => {
    const isNewAnswer = answer === ""
    const newAnswerElement = document.createElement('li');
    newAnswerElement.setAttribute("style", "list-style: none")
    newAnswerElement.setAttribute('id', `answer-${questionId}-${answerId}`)
    newAnswerElement.innerHTML = `<div class="d-flex flex-row m-3 justify-content-sm-around">
                <input type="text" class="form-control answer-text-${questionId}" id="answer-text-${questionId}-${answerId}"placeholder="Entrez l'intituler de la réponse" value="${isNewAnswer ? "" : answer.answer}" required>
                <input class="form-check-input answer-score-check" data-id="${questionId}-${answerId}" type="checkbox" value="" id="flexCheck-${questionId}-${answerId}" ${isNewAnswer ? "" : answer.score > 0 ? 'checked' : ''}>
                <label class="form-check-label" for="flexCheck-${questionId}-${answerId}">bonne reponse</label>
                <input class="answer-score-${questionId}" id="score-${questionId}-${answerId}" value=${isNewAnswer ? "0" : answer.score} ${isNewAnswer || answer.score === 0 ? 'disabled' : ''}>
                <i class="fa-solid fa-xmark delete-answer-btn m-3" data-id="${questionId}-${answerId}" style="color: #ff0000;"></i>    
            </div>`

    return newAnswerElement
}


export const handleAccordion = () => {
    const accordionItems = document.querySelectorAll('.accordion-item')
    let dragStartClientY
    let draggedItem

    const handleDragStart = (e) => {
        closeAllCollapse()
        const target = e.target.closest('.accordion-item')
        target.style.opacity = 0.5

        draggedItem = target
        dragStartClientY = e.clientY
    }
    const handleDragEnd = (e) => {
        const target = e.target.closest('.accordion-item')

        target.style.opacity = 1
    }
    const handleDrop = (e) => {
        const target = e.target.closest('.accordion-item')
        if (dragStartClientY > e.clientY) {
            target.parentNode.insertBefore(draggedItem, target.previousSibling)
        } else {
            target.parentNode.insertBefore(draggedItem, target.nextSibling)

        }
        draggedItem = null
    }
    const handleDragOver = (e) => {
        e.preventDefault()

    }

    for (let i = 0; i < accordionItems.length; i++) {
        accordionItems[i].addEventListener('dragstart', handleDragStart)
        accordionItems[i].addEventListener('dragover', handleDragOver)
        accordionItems[i].addEventListener('dragend', handleDragEnd)
        accordionItems[i].addEventListener('drop', handleDrop)
    }
}
export const handleAddAnswer = () => {
    const accordionElement = document.querySelector("#accordion");

    accordionElement.addEventListener('click', (e) => {
        if (e.target.closest('.add-answer-btn')) {
            const questionId = e.target.getAttribute('data-id');
            const answerContainer = document.querySelector(`#answers-${questionId}`);

            if (answerContainer.children.length < 8) {
                let id = 0
                if (answerContainer.children.length > 0) {
                    const idLastAnswer = answerContainer.lastChild.getAttribute('id').split('-')
                    id = parseInt(idLastAnswer[idLastAnswer.length - 1]) + 1
                }

                const newAnswerElement = document.createElement('div');
                newAnswerElement.appendChild(getAnswer("", questionId, id));

                answerContainer.appendChild(newAnswerElement.firstChild);
            }
        }
    });

}
export const handleAddQuestion = () => {
    const addQuestionBtnElements = document.querySelector("#add-question-btn");

    addQuestionBtnElements.addEventListener('click', (e) => {
        const questionContainer = document.querySelector("#accordion");

        if (questionContainer.children.length < 30) {
            let id = 0

            if (questionContainer.children.length > 0) {
                const idLastAnswer = questionContainer.lastChild.getAttribute('id').split('-')
                id = parseInt(idLastAnswer[idLastAnswer.length - 1]) + 1
            }
            const newQuestion = getAccordion("", id);
            questionContainer.appendChild(newQuestion);
        }
    });
};
export const handleRemoveQuestion = () => {
    const accordionElement = document.querySelector("#accordion");

    accordionElement.addEventListener('click', (e) => {
        if (e.target.closest('.delete-question-btn')) {
            const id = e.target.getAttribute('data-id')
            document.querySelector(`#accordion-${id}`).remove()
        }
    });
}

export const handleRemoveAnswer = () => {
    const accordionElement = document.querySelector(".accordion");

    accordionElement.addEventListener('click', (e) => {
        if (e.target.closest('.delete-answer-btn')) {
            const id = e.target.getAttribute('data-id')
            document.querySelector(`#answer-${id}`).remove()
        }
    });
};


const closeAllCollapse = () => {
    const collapseAccordionElements = document.querySelectorAll(".accordion-collapse")
    const accordionButtonElements = document.querySelectorAll('.accordion-button')
    for (let i = 0; i < collapseAccordionElements.length; i++) {
        collapseAccordionElements[i].classList.remove("show")
        accordionButtonElements[i].classList.add("collapsed")
    }
}

export const handleValidButton =  (id)  => {
    const form = document.querySelector('#quizz-form')
    const validButton = document.querySelector('#valid-btn')
    let result, message
    validButton.addEventListener('click', async() => {
        isMinimunGoodAnswerCorrect()
        if (!form.checkValidity() ) {
            form.reportValidity()
            return false
        }
        if(!isMinimunAnswerCorrect()) {
            alert("Il faut minimum 2 réponses par question")
            return false
        }
        if(!isMinimunQuestionCorrect()) {
            alert("Il faut minimum 1 question")
            return false
        }
        if(!isMinimunGoodAnswerCorrect()){
            alert("Il faut minimum 1 bonne réponse par question")
            return false
        }
        const quizz = []
        const questionsData = []
        const questions = document.querySelectorAll(".questions")

        for (let i = 0; i < questions.length; i++) {
            const answersData = []
            const questionId = questions[i].getAttribute('data-id')
            const answers = document.querySelectorAll(`.answer-text-${questionId}`)
            const scoresAnswers = document.querySelectorAll(`.answer-score-${questionId}`)
            let countGoodAnswer = 0

            for (let j = 0; j < answers.length; j++) {
                const score = scoresAnswers[j].value
                answersData.push({"answer": answers[j].value, "score": score, "isCorrect": (score === '0' ? 1 : 0)})
                if (score > 0) {
                    countGoodAnswer++;
                }
            }

            questionsData.push({
                "answers": answersData,
                "question": questions[i].value,
                "isMultipleCorrectAnswer": (countGoodAnswer > 1 ? 0 : 1)
            })
        }

        quizz.push({"id": parseInt(id),
                    "name": document.querySelector('#quizz-name').value,
                    "is_published": document.querySelector('#flexCheckPublished').checked ? 0 : 1,
                    "questions": JSON.stringify(questionsData)})

        const data = { quizz }
        if(id === '0'){
            result = await createQuizz(data)
            message = 'Le quizz a été créé avec succès'
        }else{
           result = await updateQuizz(data, id)
            message = 'Le quizz a été modifié avec succès'
        }

        if(result.hasOwnProperty('success')) {
            showToast(message, 'bg-success')
        }else{
            showToast(`Une erreur a été rencontrée: ${result.error}`, 'bg-danger')
        }
    })

}

export const handleGoodAnswers = () => {
    const accordionElement = document.querySelector(".accordion");

    accordionElement.addEventListener('click', (e) => {
        if (e.target.closest('.answer-score-check')) {
            const id = e.target.getAttribute('data-id')
            const input = document.querySelector(`#score-${id}`)
            input.disabled = !e.target.checked
            input.value = input.disabled ? 0 : 1
        }
    });
}

export const isMinimunAnswerCorrect = () => {
    const answers = document.querySelectorAll('.answers')
    for(let i = 0; i < answers.length; i++){
        if(answers[i].children.length < 2){
            return false
        }
    }
    return true
}
export const isMinimunGoodAnswerCorrect = () => {
    const answers = document.querySelectorAll('.answers')
    for(let i = 0; i < answers.length; i++){
        let quantityGoodAnswer = 0
        for(let j = 0; j < answers[i].children.length; j++){
            if(answers[i].children[j].children[0].children[1].checked){
                quantityGoodAnswer++
            }
        }
        if(quantityGoodAnswer < 1){
            return false
        }
    }
    return true
}

export const isMinimunQuestionCorrect = () => {
    const questions = document.querySelector('#accordion')
        return questions.children.length >= 1;

}