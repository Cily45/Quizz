export const qetAccordion= (question,answers,questionId)=> {
    return ` 
            <div  class="accordion-item" draggable="true">
                <h2 class="accordion-header">    
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse${questionId}" aria-expanded="true" aria-controls="collapse">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text  bg-primary text-white" id="addon-wrapping">Question:</span>
                                <input type="text" class="form-control" placeholder="Entrez votre question" aria-label="Entrez votre question" aria-describedby="addon-wrapping" id="validationCustom01" value="${question}" required>
                            </div> 
                            <div class="m-3">
                                <a href="#"> <i class="fa-solid fa-xmark delete-question-btn" data-id="${questionId} style="color: #ff0000;"></i></a> 
                            </div>
                    </button> 
                </h2>
                    <div id="collapse${questionId}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                             <div id="answers${questionId}" class="col container">
                               ${answers}
                             </div>
                             <div class="mb-3 ">
                                   <div class="row">
                                        <div class="mt-3 d-flex justify-content-end">
                                             <button data-id ="${questionId}" type="button" class="btn btn-primary add-answer-btn">+</button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
            </div>
      `
}
export const getAnswer= (answer)=> {
    const isNewAnswer = answer === ""
    return `<div class="d-flex flex-row m-3">
                <input type="text" class="form-control" placeholder="Entrez l'intituler de la réponse" value="${isNewAnswer ? "" : answer.answer }" required>
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" ${isNewAnswer ? "" : answer.score > 0?'checked':''}>
                <label class="form-check-label" for="flexCheckDefault">bonne reponse</label>
                <input value=${isNewAnswer ? "" : answer.score} ${isNewAnswer ? "" : answer.score === 0?'disabled':''}>
                <a href="#"> <i class="fa-solid fa-xmark delete-answer-btn m-3" style="color: #ff0000;"></i></a>       
            </div>`
}


export const handleAccordion = () =>{
    const accordionItems = document.querySelectorAll('.accordion-item')
    let dragStartClientY
    let draggedItem

    const handleDragStart = (e) => {
        const target = e.target

        target.style.opacity = 0.5

        draggedItem = target
        dragStartClientY = e.clientY
    }
    const handleDragEnd = (e) => {
        const target = e.target
        target.style.opacity = 1
    }
    const handleDrop = (e) => {
        const target = e.target.closest('.accordion-item')
        if(dragStartClientY >e.clientY){
            target.parentNode.insertBefore(draggedItem, target.previousSibling)
        }else{
            target.parentNode.insertBefore(draggedItem, target.nextSibling)

        }
        draggedItem = null
    }
    const handleDragOver = (e) => {
        e.preventDefault()

    }

    for (let i = 0; i < accordionItems.length; i++){
        accordionItems[i].addEventListener('dragstart', handleDragStart)
        accordionItems[i].addEventListener('dragover', handleDragOver)
        accordionItems[i].addEventListener('dragend', handleDragEnd)
        accordionItems[i].addEventListener('drop', handleDrop)
    }
}
export const handleAddAnswer = () =>{
    const addAnswerBtnElements = document.querySelectorAll(".add-answer-btn")
    console.log("ii")
    for(let i = 0; i < addAnswerBtnElements.length; i++){
        addAnswerBtnElements[i].addEventListener('click', (e) =>{
            const id = e.target.getAttribute('data-id')
            const answer = document.querySelectorAll(`#answers${id}`)
            answer.innerHTML += getAnswer("")
        })
    }
}

export const handleRemoveQuestion = () => {
    const deleteButonElement = document.querySelectorAll(".delete-question-btn")

    for(let i = 0; i < deleteButonElement.length; i++){
        deleteButonElement[i].addEventListener('click' , (e) =>{
            alert("ok")
        })
    }
}