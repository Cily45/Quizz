<?php
?>
<h1 class="text-center">Liste des quizz</h1>
<div class="d-flex justify-content-center">
    <div class="spinner-grow text-warning d-none" id="spinner" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<div class="row" id="cards">

</div>


<nav aria-label="...">
    <ul class="pagination">
        <li id="prev-page" class="page-item">
            <a  class="page-link">Previous</a>
        </li>
       <li id="page-count" class="page-item d-flex flex-row"> </li>
        <li id="next-page" class="page-item">
            <a class="page-link" href="#">Next</a>
        </li>
    </ul>
</nav>
<script src="./Assets/JavaScript/Services/quizz.js" type="module"></script>
<script type="module">

    import {getQuizzs} from "./Assets/Javascript/Services/quizz.js";
    import {getCard} from "./Assets/Javascript/Component/quizz.js";
    document.addEventListener('DOMContentLoaded', async () =>{
        const cards = document.querySelector("#cards")
        const nextBtnElement = document.querySelector('#next-page')
        const prevBtnElement = document.querySelector('#prev-page')

        let page = 1
        const limit = 15
        let data = await getQuizzs(page)
        let maxPage = Math.ceil(data.quizzCount.idCount / limit)

        const displayQuizzs = async () => {
            const countPage = document.querySelector("#page-count")
            const spinner = document.querySelector("#spinner")
            spinner.classList.remove('d-none')
            data = await getQuizzs(page)
            cards.innerHTML = ""
            for(let i = 0; i < data.quizzs.length; i++){
                cards.innerHTML += getCard(data.quizzs[i])
            }

            countPage.innerHTML = ""
            for(let i = 1; i <= maxPage; i++){
                countPage.innerHTML += `<a data-page='${i}' class="page-item page-link change-page" href="#">${i}</a>`
            }
            const btnPage = document.querySelectorAll('.change-page')
            for(let i = 0; i < btnPage.length; i++){
                btnPage[i].addEventListener('click', (event) => {
                    page = event.target.getAttribute('data-page')
                    displayQuizzs()
                })
            }

             const goBtn = document.querySelectorAll(".go-btn")
             for(let i = 0; i < goBtn.length; i++){
                 goBtn[i].addEventListener('click', (event) => {
                    document.location.href = `index.php?component=quizz&id=${event.target.getAttribute('data-id')}`
                })
             }

            if(page <= 1){
                prevBtnElement.classList.add("disabled")
            }else{
                prevBtnElement.classList.remove("disabled")
            }

            if(page >= maxPage){
                nextBtnElement.classList.add("disabled")
            }else{
                nextBtnElement.classList.remove("disabled")
            }


            spinner.classList.add('d-none')
        }

        prevBtnElement.addEventListener('click',async () => {
            if (page  > 1){
                page --
                await displayQuizzs()
            }
        })

        await displayQuizzs()
        nextBtnElement.addEventListener('click',async () => {
            if (page < maxPage){
                page ++
                await  displayQuizzs()
            }
        })
    })
</script>