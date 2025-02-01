import {formatTime} from "./shared/timer.js";
import {addTime} from "../services/quizz.js";
import {showToast} from "./shared/toast.js";

export const getQuestion = (questions) => {
    let result = ""

    for (let i = 0; i < questions.length; i++) {
        result += `
                <div id="question-${i}-content" class="question d-none p-3">
                    <form id="form-question-${i}">
                        <div class="mb-3">
                            <h2>${i + 1}) ${questions[i].question}</h2>
                        </div> 
                        <div class="user-answer">
                            ${parseInt(questions[i].isMultipleCorrectAnswer) === 0 ?
            getAnswerCheck(questions[i].answers, i) : getAnswerRadio(questions[i].answers, i)}
                        </div>
                    </form>
                </div>`
    }

    return result
}

export const getAnswerRadio = (answers, question) => {
    let result = ""

    for (let i = 0; i < answers.length; i++) {
        result += ` 
            <div class="form-check ms-5">
                <input class="form-check-input" type="radio" name="question-${question}" id="question-${question}-${i}"
                                    value="client" required>
                <label class="form-check-label" for="question-${question}-${i}">${answers[i].answer}</label>
            </div>`
    }

    return result
}

export const getAnswerCheck = (answers, question) => {
    let result = ""

    for (let i = 0; i < answers.length; i++) {
        result += `
            <div class="form-check ms-5">
               <input class="form-check-input" type="checkbox" name="question-${question}" id="question-${question}-${i}"
                      value="" required>
               <label class="form-check-label" for="question-${question}-${i}">${answers[i].answer}</label>
            </div>`
    }

    return result
}

export const changeQuestion = (currentQuestion, nextQuestion) => {
    document.querySelector(`#question-${nextQuestion}-content`).classList.remove('d-none')
    document.querySelector(`#question-${currentQuestion}-content`).classList.add('d-none')
}

export const displayResultQuizz = async (score, answersCount, id, questions, scoreTotal, time) => {
    const result = document.querySelector("#result")
    time = Math.floor((Date.now() - time) * 0.001)
    document.querySelector('#btn').innerHTML = ""
    result.innerHTML = `
            <h1 class="text-center">Votre scores est de ${score} sur ${scoreTotal}</h1>
            <p class="text-center">Vous avez réalisé ce quizz en : ${formatTime(time)}</p>
            <div style="width: 30%; margin: auto; text-align: center;">
                <canvas id="my-chart" width="400" height="400"></canvas>
            </div>
            
            <div class="mt-3 d-flex justify-content-around">
                <a href="#" type="button" class="btn btn-primary" id="correction-btn">Correction</a>
                <a href="index.php?component=quizz&id=${id}" type="button" class="btn btn-primary">Recommencer</a>
            </div>`

    const chart = document.querySelector("#my-chart")
    new Chart(chart, {
        type: 'doughnut',
        data: {
            labels: ["Bonne réponses", "Mauvaise réponses"],
            datasets: [{
                data: answersCount,
                hoverOffset: 4
            }]
        },
    });

    let res = await addTime(id, time)

    if (res.hasOwnProperty('bestTime')) {
        showToast("Vous venez de faire le meilleur temps!!!", 'bg-success')
    } else if (res.hasOwnProperty('success')) {
        showToast("Votre temps à bien été pris en compte", 'bg-success')
    } else {
        showToast(`Une erreur a été rencontrée: ${result.error}`, 'bg-danger')
    }
    handleCorrection(questions)
}


export const updateProgressBar = (progressCount) => {
    const progressBarElement = document.querySelector("#progress-bar")
    const progressBarText = document.querySelector("#progress-bar-text")

    progressBarText.style.width = `${progressCount}%`
    progressBarText.innerHTML = `${progressCount}%`
    progressBarElement.setAttribute('aria-valuenow', progressCount)
}

export const countScore = (answers, currentQuestion) => {
    const checkboxes = document.querySelectorAll(`input[name="question-${currentQuestion}"]`);
    let countScore = 0;

    for (let i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked && parseInt(answers[i].isCorrect) === 1) {
            return 0
        }
        if (!checkboxes[i].checked && parseInt(answers[i].isCorrect) === 0) {
            return 0
        }
        if (parseInt(answers[i].isCorrect) === 0) {
            countScore += parseInt(answers[i].score)
        }
    }

    return countScore
}

export const getResult = (countScore) => {
    let result = [0, 0]

    for (let i = 0; i < countScore.length; i++) {
        if (countScore[i] === 0) {
            result[1]++
        } else {
            result[0]++
        }
    }

    return result
}

export const isChecked = (currentQuestion) => {
    const checkboxes = document.querySelectorAll(`input[name="question-${currentQuestion}"]`);

    for (let i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            return true
        }
    }

    return false
}

export const sumScore = (scoreCount) => {
    let result = 0;

    for (let i = 0; i < scoreCount.length; i++) {
        result += parseInt(scoreCount[i])
    }

    return result
}

const handleCorrection = (questions) => {
    const correctionButton = document.querySelector('#correction-btn')

    answersCorrection(questions)

    correctionButton.addEventListener('click', (e) => {
        const questionElements = document.querySelectorAll(".question")
        e.preventDefault()

        for (let i = 0; i < questionElements.length; i++) {
            questionElements[i].classList.remove("d-none")
        }

        questionElements[0].scrollIntoView({behavior: 'smooth', block: 'start', inline: 'start'});

    })
}

const answerDnone = () => {
    const answersUser = document.querySelectorAll('.user-answer')

    for (let i = 0; i < answersUser.length; i++) {
        answersUser[i].classList.add('d-none')
    }
}

const answersCorrection = (questions) => {
    const questionElements = document.querySelectorAll(".question")
    answerDnone()

    for (let i = 0; i < questionElements.length; i++) {
        const checkElements = document.querySelectorAll(`input[name="question-${i}"]`);
        const answers = questions[i].answers
        const newAnswers = document.createElement('ul')
        newAnswers.classList.add('list-group')

        for (let j = 0; j < checkElements.length; j++) {

            newAnswers.innerHTML += `
                   <li class="list-group-item ms-5"  
                       style="color:${checkElements[j].checked && parseInt(answers[j].isCorrect) === 1 ?
                "red" : parseInt(answers[j].isCorrect) === 0 && checkElements[j].checked ?
                    "DarkGreen" :
                    !checkElements[j].checked && parseInt(answers[j].isCorrect) === 0 ?
                        "DarkOrange" : ""}"> 
                                <i class="fa-regular fa-square${checkElements[j].checked ? "-check" : ""}"></i>
                        ${answers[j].answer} 
                   </li>
                `


        }
        questionElements[i].appendChild(newAnswers)
    }
}