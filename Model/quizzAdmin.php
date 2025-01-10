<?php
function getQuizzAdmin(PDO $pdo, int $id): array|string
{

    $state = $pdo->prepare("SELECT * FROM quizz WHERE id = :id");
    $state->bindParam(':id', $id, PDO::PARAM_INT);

    try{
        $state->execute();
        return $state->fetchAll(PDO::FETCH_OBJ);
    }catch(Exception $e){
        return $e->getMessage();
    }
}

function getAllQuestionsAdmin(PDO $pdo, int $id): array|string
{

    $state = $pdo->prepare("SELECT * FROM question WHERE id_quizz = :id");
    $state->bindParam(':id', $id, PDO::PARAM_INT);

    try{
        $state->execute();
        return $state->fetchAll(PDO::FETCH_OBJ);
    }catch(Exception $e){
        return $e->getMessage();
    }
}