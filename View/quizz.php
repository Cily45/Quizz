<?php
?>
<h1 class="text-center">Quizz</h1>
<div class="progress m-2" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0"
     aria-valuemax="100">
    <div class="progress-bar" style="width: 0%"></div>
</div>
<div class="container border">
    <h2 class=" text-center m-3" id="title-question">Question 1</h2>

    <div class="m-2 ms-5">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Default checkbox
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
            <label class="form-check-label" for="flexCheckChecked">
                Checked checkbox
            </label>
        </div>
    </div>

    <div class="d-flex flex-row justify-content-between m-2">
        <button type="button" class="btn btn-primary">Precédent</button>
        <button type="button" class="btn btn-primary">Suivant</button>
    </div>
</div>
<script src="./Assets/JavaScript/Services/quizz.js" type="module"></script>
<script type="module">


    import {getQuizz} from "./Assets/Javascript/Services/quizz.js";

    document.addEventListener('DOMContentLoaded', async () => {
        const data = await getQuizz(<?php echo $_GET['id'] ?? 0 ?>);
        console.log(data)
    })

</script>