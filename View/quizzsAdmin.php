<?php
?>
<h1 class="text-center">Liste des quizz</h1>
<div class="d-flex justify-content-center">
    <div class="spinner-grow text-warning d-none" id="spinner" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div class="mb-3 ">
    <div class="row">
        <div class="mb-3 d-flex justify-content-end">
            <a href="index.php?component=quizzAdmin&action=create&id=0" type="button" class="btn btn-primary" id="create-quizz-btn"><i class="fa fa-plus me-2"></i>Créer un quizz</a>
        </div>
    </div>
</div>

<table class="table" id="list-quizzs">
    <thead>
    <tr>
        <th scope="col"><a href="#" class="sort-by-item" data-sort-by="id ASC">#</a></th>
        <th scope="col"><a href="#"  class="sort-by-item" data-sort-by="name ASC">Quizz</a></th>
        <th scope="col"><a href="#" class="sort-by-item" data-sort-by="is_published ASC">Publié</a></th>
        <th scope="col"></th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>


<nav aria-label="...">
    <ul class="pagination justify-content-center" id="pagination">

    </ul>
</nav>
<script src="./Assets/JavaScript/Services/quizzAdmin.js" type="module"></script>
<script src="./Assets/JavaScript/Component/quizzAdmin.js" type="module"></script>
<script type="module">
    import {displayQuizzs, handleSortBy, handlePublishedClick} from "./Assets/Javascript/Component/quizzAdmin.js";

    document.addEventListener('DOMContentLoaded', async () =>{

        let page = 1
        let sortBy = "id ASC"

        await displayQuizzs(page,sortBy)
        handleSortBy(page,sortBy)
    })
</script>