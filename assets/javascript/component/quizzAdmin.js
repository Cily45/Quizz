import {showToast} from "./shared/toast.js";
import {createQuizz, updateQuizz} from "../services/quizzAdmin.js";


export const getAccordion = (question, questionId) => {
    const newQuestionElement = document.createElement('li');
    newQuestionElement.classList.add("accordion-item")
    newQuestionElement.classList.add("list-group-item")
    newQuestionElement.setAttribute('id', `accordion-${questionId}`)
    newQuestionElement.setAttribute("draggable", "true")
    newQuestionElement.innerHTML = ` 
                <h2 class="accordion-header" >    
                    <div class="d-flex justify-content-xxl-between m-3">
                        <div id="question-${questionId}">
                            ${question === "" ? "Entrez votre Question" : question}
                        </div>
                        <div >
                           <a href="#" class="m-5"> 
                                <i class="fa-solid fa-xmark delete-question-btn" 
                                data-id="${questionId}" 
                                style="color: #ff0000;"></i>
                           </a>
                           <a href="#" class="m-3 collapsed collapse-btn"  data-bs-toggle="collapse" data-bs-target="#collapse-${questionId}" 
                              aria-expanded="true" aria-controls="collapse">
                                 <i class="fa-solid fa-chevron-down"></i>
                           </a> 
                        </div>
                    </div>
                </h2>
                    <div id="collapse-${questionId}" 
                         class="accordion-collapse collapse" 
                         data-bs-parent="#accordion-${questionId}">
                        <div class="accordion-body">
                            <input type="text" class="form-control questions" id="question-${questionId}"
                                   data-id="${questionId}" placeholder="Entrez votre question" 
                                   aria-label="Entrez votre question" aria-describedby="addon-wrapping-${questionId}"  
                                   value="${question}" required>

                             <ul id="answers-${questionId}" class="col container answers">
                              
                             </ul>
                             <div class="mb-3 ">
                                   <div class="row">
                                        <div class="mt-3 d-flex justify-content-end">
                                             <button data-id ="${questionId}" type="button" 
                                                     class="btn btn-primary add-answer-btn">+</button>
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
    const newAnswerElement = document.createElement('li')

    newAnswerElement.setAttribute("style", "list-style: none")
    newAnswerElement.setAttribute('id', `answer-${questionId}-${answerId}`)
    newAnswerElement.innerHTML = `
            <div class="d-flex flex-row m-3 justify-content-sm-around">
                <input type="text" class="form-control answer-text-${questionId} m-2" 
                       id="answer-text-${questionId}-${answerId}" placeholder="Entrez l'intituler de la réponse" 
                       value="${isNewAnswer ? "" : answer.answer}" required>
                       
                <input type="checkbox" class="form-check-input answer-score-check m-2" data-id="${questionId}-${answerId}"
                       value="" id="flexCheck-${questionId}-${answerId}" ${isNewAnswer ? "" : answer.score > 0 ? 'checked' : ''}>
                       
                <label class="form-check-label" for="flexCheck-${questionId}-${answerId}">bonne reponse</label>
                <input type="number" data-id="${questionId}-${answerId}" 
                       class="answer-score-input answer-score-${questionId} m-2" 
                       style="width: 50px" id="score-${questionId}-${answerId}" 
                       value=${isNewAnswer ? 0 : parseInt(answer.score)} ${isNewAnswer || parseInt(answer.score) === 0 ? 'disabled' : ''}>
               
                <i class="fa-solid fa-xmark delete-answer-btn m-3" data-id="${questionId}-${answerId}" style="color: #ff0000;"></i>    
            </div>`

    return newAnswerElement
}
export const handleChevron = () => {
    const collapseButton = document.querySelectorAll(".collapse-btn")

    for (let i = 0; i < collapseButton.length; i++) {
        collapseButton[i].addEventListener('click', (e) => {
            closeAllCollapse()

            collapseButton[i].innerHTML = collapseButton[i].innerHTML === `<i class="fa-solid fa-chevron-up"></i>`
                ? `<i class="fa-solid fa-chevron-down"></i>` : `<i class="fa-solid fa-chevron-up"></i>`
        })
    }
}
export const handleAccordion = () => {
    const accordionItems = document.querySelectorAll('.accordion')
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
            const answerContainer = document.querySelector(`#answers-${questionId}`)


            if (answerContainer.children.length < 8) {
                let id = 0
                if (answerContainer.children.length > 0) {
                    const idLastAnswer = answerContainer.lastChild.getAttribute('id').split('-')
                    id = parseInt(idLastAnswer[idLastAnswer.length - 1]) + 1
                }

                const newAnswerElement = document.createElement('div')
                newAnswerElement.appendChild(getAnswer("", questionId, id));

                answerContainer.appendChild(newAnswerElement.firstChild);
            }

        }
    })
}
export const handleAddQuestion = () => {
    const addQuestionBtnElements = document.querySelector("#add-question-btn")

    addQuestionBtnElements.addEventListener('click', (e) => {
        e.preventDefault()
        addNewQuestion()
    })
}

export const addNewQuestion = () => {
    const questionContainer = document.querySelector("#accordion")
    closeAllCollapse()

    if (questionContainer.children.length < 30) {
        let id = 0

        if (questionContainer.children.length > 0) {
            const idLastAnswer = questionContainer.lastChild.getAttribute('id').split('-')
            id = parseInt(idLastAnswer[idLastAnswer.length - 1]) + 1
        }
        const newQuestion = getAccordion("", id)
        questionContainer.appendChild(newQuestion)

        const answerContainer = document.querySelector(`#answers-${id}`)
        const newAnswerElement = document.createElement('div')
        newAnswerElement.appendChild(getAnswer("", id, 0))

        answerContainer.appendChild(newAnswerElement.firstChild)

        const question = document.querySelector(`#collapse-${id}`)
        question.classList.add('show')
        question.scrollIntoView({behavior: 'smooth', block: 'start', inline: 'start'})
    }
}
export const handleRemoveQuestion = () => {
    const accordionElement = document.querySelector("#accordion");

    accordionElement.addEventListener('click', (e) => {
        if (e.target.closest('.delete-question-btn')) {
            const id = e.target.getAttribute('data-id')
            document.querySelector(`#accordion-${id}`).remove()
        }
    })
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
    const accordionButtonElements = document.querySelectorAll('.accordion-header')
    for (let i = 0; i < collapseAccordionElements.length; i++) {
        collapseAccordionElements[i].classList.remove("show")
        accordionButtonElements[i].classList.add("collapsed")
    }
    const collapseButton = document.querySelectorAll(".collapse-btn")
    for (let i = 0; i < collapseButton.length; i++) {
        collapseButton[i].innerHTML = `<i class="fa-solid fa-chevron-down"></i>`
    }
}

export const handleValidButton = (id) => {
    const validButton = document.querySelector('#valid-btn')
    const form = document.querySelector('#quizz-form')
    let result, message

    validButton.addEventListener('click', async () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });

        if (!form.checkValidity()) {
            const accordions = document.querySelectorAll('.accordion-collapse');

            for(let i = 0; i < accordions.length; i++) {
                const inputs = accordions[i].querySelectorAll('input');

                for(let j = 0; j < inputs.length; j++) {
                    if (!inputs[j].validity.valid) {
                        accordions[i].classList.add('show');
                    }
                }
            }

            form.reportValidity()

            return false
        }
        if (!isMinimunAnswerCorrect()) {
            alert("Il faut minimum 2 réponses par question")
            return false
        }

        if (!isMinimunQuestionCorrect()) {
            alert("Il faut minimum 1 question")
            return false
        }
        if (!isMinimunGoodAnswerCorrect()) {
            alert("Il faut minimum 1 bonne réponse par question")
            return false
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });

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
                    countGoodAnswer++
                }
            }

            questionsData.push({
                "answers": answersData,
                "question": questions[i].value,
                "isMultipleCorrectAnswer": (countGoodAnswer > 1 ? 0 : 1)
            })
        }

        quizz.push({
            "id": parseInt(id),
            "name": document.querySelector('#quizz-name').value,
            "is_published": document.querySelector('#flexCheckPublished').checked ? 0 : 1,
            "questions": JSON.stringify(questionsData)
        })

        const data = {quizz}

        if (id === '0') {
            result = await createQuizz(data)
            message = 'Le quizz a été créé avec succès'
        } else {
            result = await updateQuizz(data, id)
            message = 'Le quizz a été modifié avec succès'
        }

        if (result.hasOwnProperty('success')) {
            showToast(message, 'bg-success')
        } else {
            showToast(`Une erreur a été rencontrée: ${result.error}`, 'bg-danger')
        }
    })

}

export const handleGoodAnswersCheck = () => {
    const accordionElement = document.querySelector(".accordion")

    accordionElement.addEventListener('click', (e) => {
        if (e.target.closest('.answer-score-check')) {
            const id = e.target.getAttribute('data-id')
            const input = document.querySelector(`#score-${id}`)
            input.disabled = !e.target.checked
            input.value = input.disabled ? 0 : 1
        }
    });
}
export const handleGoodAnswersInput = () => {
    const accordionElement = document.querySelector(".accordion");

    accordionElement.addEventListener('click', (e) => {
        if (e.target.closest('.answer-score-input')) {
            const id = e.target.getAttribute('data-id')
            const checkbox = document.querySelector(`#flexCheck-${id}`)
            checkbox.checked = parseInt(e.target.value) > 0
            e.target.disabled = parseInt(e.target.value) <= 0
        }
    });
}

export const isMinimunAnswerCorrect = () => {
    const answers = document.querySelectorAll('.answers')

    for (let i = 0; i < answers.length; i++) {
        if (answers[i].children.length < 2) {
            return false
        }
    }
    return true
}
export const isMinimunGoodAnswerCorrect = () => {
    const answers = document.querySelectorAll('.answers')
    for (let i = 0; i < answers.length; i++) {
        let quantityGoodAnswer = 0
        for (let j = 0; j < answers[i].children.length; j++) {
            if (answers[i].children[j].children[0].children[1].checked) {
                quantityGoodAnswer++
            }
        }
        if (quantityGoodAnswer < 1) {
            return false
        }
    }
    return true
}

export const isMinimunQuestionCorrect = () => {
    const questions = document.querySelector('#accordion')

    return questions.children.length >= 1
}

export const handleInput = () => {
    const accordionElement = document.querySelector("#accordion");

    accordionElement.addEventListener('click', (e) => {
        if (e.target.closest('.form-control')) {
            e.target.addEventListener('focusin', () => {
                document.querySelectorAll('.accordion-item').forEach(bloc => {
                    bloc.setAttribute('draggable', false)
                })
            })

            e.target.addEventListener('focusout', () => {
                document.querySelectorAll('.accordion-item').forEach(bloc => {
                    bloc.setAttribute('draggable', true)
                    if(e.target.classList.value.includes("questions")) {
                        document.querySelector(`#question-${e.target.getAttribute("data-id")}`).innerHTML = e.target.value
                    }
                })
            })
        }
    })
}