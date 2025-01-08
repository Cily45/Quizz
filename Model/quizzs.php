<?php

function getAll(PDO $pdo, int $page){
    $query ="SELECT * FROM quizz LIMIT 15";
    if(1 !== $page){
        $page = ($page -1) *20;
        $query .= " OFFSET $page";
    }

    $state = $pdo->prepare($query);

    try{
        $state->execute();
        return $state->fetchAll(PDO::FETCH_OBJ);
    }catch(Exception $e){
        return $e->getMessage();
    }

}

function getCountQuizzs(PDO $pdo){
    $query ="SELECT COUNT(id) AS `idCount` FROM quizz";
    $state = $pdo->prepare($query);
    try{
        $state->execute();
        return $state-> fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        return $e->getMessage();
    }
}