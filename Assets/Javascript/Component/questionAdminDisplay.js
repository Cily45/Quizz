export const qetAccordion= (question, position, isCurrent)=> {
    return ` 
  
            <div  class="accordion-item" draggable="true">
                <h2 class="accordion-header">    
                    <button class="accordion-button ${isCurrent ? "" : "collapsed"}" type="button" data-position=${position} data-bs-toggle="collapse"
                            data-bs-target="#collapse${position}" aria-expanded="true" aria-controls="collapse${position}">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text  bg-primary text-white" id="addon-wrapping">Question:</span>
                                <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping" id="validationCustom01" value="${question}" required>
                            </div>
                    </button> 
                </h2>
                    <div id="collapse${position}" class="accordion-collapse collapse ${isCurrent ? "show" : ""}" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                             <div class="col container" id="answers${position}">
                               
                             </div>
                        </div>
                    </div>
            </div>
      
`
}

export const getAnswer= (answer)=> {
    return `<div class="d-flex flex-row m-3">
                <input type="text" class="form-control" value="${answer.answer}" required>
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" ${answer.score > 0?'checked':''}>
                <label class="form-check-label" for="flexCheckDefault">bonne reponse</label>
                <input value=${answer.score} ${answer.score === 0?'disabled':''}>
            </div>`
}