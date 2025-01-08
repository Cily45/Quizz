<?php
?>
<h1 class="text-center">Liste des personnes</h1>
<div class="d-flex justify-content-center">
    <div class="spinner-grow text-warning d-none" id="spinner" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<table class="table" id="list-quizzs">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">Quizz</th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<div id="footer-table" class="row">
    <button id="prev-page" type="button" class="col-1 btn ">|<</button>
    <p class="col-10 text-center" id="page-count">Hello</p>
    <button id="next-page" type="button" class="col-1 btn">>|</button>
</div>

<script src="./Assets/JavaScript/Services/quizz.js" type="module"></script>
<script type="module">

    import {getQuizz} from "./Assets/Javascript/Services/quizz.js";
    import {GetRow} from "./Assets/Javascript/Component/quizz.js";

    document.addEventListener('DOMContentLoaded', async () =>{
        const tbody = document.querySelector("#list-quizzs")

        const nextBtnElement = document.querySelector('#next-page')
        const prevBtnElement = document.querySelector('#prev-page')
        let page = 1
        const limit = 15
        let data = await getQuizz(page)
        let maxPage = Math.ceil(data.quizzCount.idCount / limit)

        const displayQuizzs = async () => {
            const countPage = document.querySelector("#page-count")
            const spinner = document.querySelector("#spinner")
            spinner.classList.remove('d-none')
            data = await getQuizz(page, limit)
            tbody.innerHTML = ""
            for(let i = 0; i < data.quizzs.length; i++){
                tbody.innerHtml += GetRow(data.quizzs[i])
            }
            countPage.innerHTML = ""
            for(let i = 1; i <= maxPage; i++){
                countPage.innerHTML += `<button type="button" data-page='${i}' class="button-change-page btn m-1 btn-primary">${i}</button>`
            }
            const btnPage = document.querySelectorAll('.button-change-page')
            for(let i = 0; i < btnPage.length; i++){
                btnPage[i].addEventListener('click', (event) => {
                    page = event.target.getAttribute('data-page')
                    displayQuizzs()
                })
            }
            spinner.classList.add('d-none')
        }

        await displayQuizzs()
        nextBtnElement.addEventListener('click',async () => {
            if (page < maxPage){
                console.log(`Page next = ${page}`)
                page ++
                await  displayPersons()
            }
        })

        prevBtnElement.addEventListener('click',async () => {
            if (page  > 1){
                console.log(`Page prev = ${page}`)
                page --
                await displayPersons()
            }
        })
    })
</script>