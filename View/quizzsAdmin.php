<?php
?>
<h1 class="text-center">Liste des quizz</h1>
<div class="d-flex justify-content-center">
    <div class="spinner-grow text-warning d-none" id="spinner" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<table class="table" id="list-quizzs">
    <thead>
    <tr>
        <th scope="col"><a href="#">#</a></th>
        <th scope="col"><a href="#">Quizz</a></th>
        <th scope="col"><a href="#">Moyenne</a></th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>


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
    import {getRow} from "./Assets/Javascript/Component/quizz.js";
    document.addEventListener('DOMContentLoaded', async () =>{
        const tbody = document.querySelector("#list-quizzs tbody")
        const nextBtnElement = document.querySelector('#next-page')
        const prevBtnElement = document.querySelector('#prev-page')

        let page = 1
        const limit = 15
        let data = await getQuizzs(page)
        let maxPage = Math.ceil(data.quizzCount.idCount / limit)
        const auth = data.auth

        const displayQuizzs = async () => {
            const countPage = document.querySelector("#page-count")
            const spinner = document.querySelector("#spinner")
            spinner.classList.remove('d-none')
            data = await getQuizzs(page, limit)
            tbody.innerHTML = ""
            for(let i = 0; i < data.quizzs.length; i++){
                tbody.innerHTML += getRow(data.quizzs[i], auth)
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