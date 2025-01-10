export const qetAccordion= (question, position, isCurrent)=> {
    return ` 
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button ${isCurrent ? "" : "collapsed"}" type="button" data-id=${question.id} data-position=${position} data-bs-toggle="collapse"
                        data-bs-target="#collapse${position}" aria-expanded="true" aria-controls="collapse${position}">${position + ". " + question.question}
                </button>
            </h2>
            <div id="collapse${position}" class="accordion-collapse collapse ${isCurrent ? "show" : ""}" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                         <form class="row g-3 needs-validation ">
                         <div class="col container">
                           <input type="text" class="form-control" id="validationCustom01" value="${question.question}" required>
                         </div>
  
                            <div class="col-12">
                            <button class="btn btn-primary" type="submit">Modifier</button>
                            </div>
                       </form>
                </div>
            </div>
        </div>
`
}
