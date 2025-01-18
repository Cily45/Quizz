

 const getAnswerRadio=(answers) =>{
    const answersElement = document.querySelector('#answers')
     answersElement.innerHTML =""
    for(let i = 0; i < answers.length; i++){
        answersElement.innerHTML += `<div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="answer-${i}">
                <label class="form-check-label" for="flexRadioDefault1">${answers[i].answer}</label>
            </div>`
    }
}

 const getAnswerCheck=(answers) =>{
    const answersElement = document.querySelector('#answers')
     answersElement.innerHTML =""
    for(let i = 0; i < answers.length; i++){
        answersElement.innerHTML += `<div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="answer-${i}">
                <label class="form-check-label" for="flexCheckDefault">${answers[i].answer}</label>
            </div>`
    }
}

export const displayQuestion = (currentQuestion, data) => {
    const titleQuestion = document.querySelector('#title-question')

    titleQuestion.innerHTML = data.questions[currentQuestion].question

    const answers = JSON.parse(data.questions[currentQuestion].answer)

    if (data.questions[currentQuestion].quantity_good_answer > 1) {
        getAnswerCheck(answers)
    } else {
        getAnswerRadio(answers)
    }

    if(currentQuestion !== 0){
        document.querySelector('#previous-btn').disabled = false
    }
}

export const displayResultQuizz = (score, answersCount) => {
    const answersElement = document.querySelector('#answers')
    const titleQuestion = document.querySelector('#title-question')

    titleQuestion.innerHTML = `Votre scores est de ${score}`

    document.querySelector('#btn').innerHTML = ""
    answersElement.innerHTML =`<div style="width: 50%; margin: auto; text-align: center;">
                                    <canvas id="my-chart" width="400" height="400"></canvas>
                               </div>
                               <div class="mt-3 d-flex justify-content-end">
                <a href="#" type="button" class="btn btn-primary" id="add-question">Recommencer</a>
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
