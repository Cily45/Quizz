export const getQuestion = (questions) => {
    let result = ""

        for(let i = 0; i < questions.length; i++){
            result += `
                <div id="question-${i}-content" class="d-none">
                    <form id="form-question-${i}">
                        <div class="mb-3">
                            <h2>${i+1}) ${questions[i].question}</h2>
                               
                        </div> ${questions[i].isMultipleCorrectAnswer === 0? getAnswerCheck(questions[i].answers, i) : getAnswerRadio(questions[i].answers, i)}
                    </form>
                </div>`
        }

        return result
}

export const getAnswerRadio = (answers, question) => {
    let result = ""

    for(let i = 0; i < answers.length; i++){
        result +=` <div class="form-check ms-5">
                        <input class="form-check-input" type="radio" name="question-${question}" id="question-${question}-${i}"
                                    value="client" required>
                        <label class="form-check-label" for="question-${question}-${i}">
                                    ${answers[i].answer}
                        </label>
                  </div>`
    }
    return result
}

export const getAnswerCheck = (answers, question) => {
    let result = ""
        for(let i = 0; i < answers.length; i++){
        result +=` <div class="form-check ms-5">
                        <input class="form-check-input" type="checkbox" name="question-${question}" id="question-${question}-${i}"
                                    value="" required>
                        <label class="form-check-label" for="question-${question}-${i}">
                                    ${answers[i].answer}
                        </label>
                  </div>`
    }
    return result
}

export const changeQuestion = (currentQuestion, nextQuestion) => {
    document.querySelector(`#question-${nextQuestion}-content`).classList.remove('d-none')
    document.querySelector(`#question-${currentQuestion}-content`).classList.add('d-none')
}

export const displayResultQuizz = (score, answersCount, id) => {
    const result = document.querySelector("#result")
    document.querySelector('#btn').innerHTML = ""
    result.innerHTML = `<h1>Votre scores est de ${score}</h1>
                        <div style="width: 50%; margin: auto; text-align: center;">
                              <canvas id="my-chart" width="400" height="400"></canvas>
                        </div>
                        <div class="mt-3 d-flex justify-content-end">
                            <a href="http://127.0.0.1/quizz/index.php?component=quizz&id=${id}" type="button" class="btn btn-primary" id="add-question">Recommencer</a>
                        </div>
`

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

    for(let i= 0; i < checkboxes.length; i++){
        if(checkboxes[i].checked && answers[i].isCorrect === 1){
            return 0
        }
        if(!checkboxes[i].checked && answers[i].isCorrect === 0){
            return 0
        }
        if(answers[i].isCorrect === 0){
            countScore += answers[i].score
        }
    }

    return countScore
}

export const getResult = (countScore) =>{
    let result = [0,0]

    for(let i = 0 ; i < countScore.length; i++){
        if(countScore[i] === 0){
            result[1]++
        }else{
            result[0]++
        }
    }

    return result
}

export const isChecked = (currentQuestion) => {
    const checkboxes = document.querySelectorAll(`input[name="question-${currentQuestion}"]`);

    for(let i = 0; i < checkboxes.length; i++){
        if(checkboxes[i].checked){
            return true
        }
    }

    return false
}
