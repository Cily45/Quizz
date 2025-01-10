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
        <th scope="col"><a href="#" class="sortby-item" data-sortby="id ASC">#</a></th>
        <th scope="col"><a href="#"  class="sortby-item" data-sortby="name ASC">Quizz</a></th>
        <th scope="col"><a href="#" class="sortby-item" data-sortby="average_score ASC">Moyenne</a></th>
        <th scope="col"><a href="#" class="sortby-item" data-sortby="is_published ASC">Publié</a></th>
        <th scope="col"></th>
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

    import {getQuizzsAdmin} from "./Assets/Javascript/Services/quizz.js";
    import {getRow} from "./Assets/Javascript/Component/quizz.js";
    import {deletteQuizz} from "./Assets/Javascript/Services/quizz.js";
    import {updateIsPublishedQuizz} from "./Assets/Javascript/Services/quizz.js";
    document.addEventListener('DOMContentLoaded', async () =>{
        const tbody = document.querySelector("#list-quizzs tbody")
        const nextBtnElement = document.querySelector('#next-page')
        const prevBtnElement = document.querySelector('#prev-page')

        let page = 1
        const limit = 15
        let data = await getQuizzsAdmin(page)
        let sortby = "id ASC"
        let maxPage = Math.ceil(data.quizzCount.idCount / limit)
        const auth = data.auth

        const displayQuizzs = async () => {
            const countPage = document.querySelector("#page-count")
            const spinner = document.querySelector("#spinner")
            spinner.classList.remove('d-none')
            data = await getQuizzsAdmin(page,sortby)

            tbody.innerHTML = ""
            for(let i = 0; i < data.quizzs.length; i++){
                tbody.innerHTML += getRow(data.quizzs[i], auth)
            }

            const isPublished = document.querySelectorAll(".is-published")
            for (let i = 0; i < isPublished.length; i++){
                isPublished[i].addEventListener('click', (event) => {
                    const id = event.target.getAttribute('data-id')
                    updateIsPublishedQuizz(id,  event.target.getAttribute('class').includes('danger') ? 0 : 1)
                         displayQuizzs()

                })
            }

            const btnDelete = document.querySelectorAll('.delete-btn')
            for (let i = 0; i < btnDelete.length; i++){
                btnDelete[i].addEventListener('click', (event) => {
                    const id = event.target.getAttribute('data-id')
                    if (confirm(`Êtes-vous sûr de vouloir supprimer le quizz n°${id}?`)) {
                        deletteQuizz(id)
                        displayQuizzs()
                    }
                })
            }

            const btnUpdate = document.querySelectorAll('.update-btn')
            for(let i = 0;  i < btnUpdate.length; i++){
                btnUpdate[i].addEventListener('click', (event) => {
                    document.location.href = `index.php?component=quizzAdmin&id=${event.target.getAttribute('data-id')}`
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

        const sortItem = document.querySelectorAll('.sortby-item')
        for(let i = 0; i < sortItem.length; i++){
            sortItem[i].addEventListener('click', (event) => {
                sortby = event.target.getAttribute('data-sortby')
                event.target.setAttribute('data-sortby',(sortby.includes("ASC") ? sortby.substring(0,sortby.length-3)+"DESC" : sortby.substring(0,sortby.length-4)+"ASC"))
                displayQuizzs()
            })
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