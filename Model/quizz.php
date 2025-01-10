<?php

function getQuestions(PDO $pdo, int $id){
    $state = $pdo->prepare("SELECT * FROM question WHERE quizz_id = :id");
    $state->bindValue(":id", $id);
    try{
        $state->execute();
        return $state->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        return $e->getMessage();
    }
}