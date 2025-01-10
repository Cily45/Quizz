<?php

function getAllQuizzsAdmin(PDO $pdo, int $page, string | null $sortby = null): array|string
{
    $query ="SELECT * FROM quizz";
    if($sortby !== null){
        $query .= " ORDER BY $sortby";
    }
    $query .=  " LIMIT 15";
    if(1 !== $page){
        $page = ($page -1) *15;
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

function getCountQuizzsAdmin(PDO $pdo){
    $query ="SELECT COUNT(id) AS `idCount` FROM quizz";
    $state = $pdo->prepare($query);
    try{
        $state->execute();
        return $state-> fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        return $e->getMessage();
    }
}

function delete(PDO $pdo, int $id)
{
    $state= $pdo->prepare("DELETE FROM quizz WHERE id = :id");
    $state->bindParam(':id', $id, PDO::PARAM_INT);
    try {

        $state->execute();
        return true;
    }
    catch (PDOException $e) {
        return $e ->getMessage();
    }
}

function isPublished(PDO $pdo, int $id, int $isPublished){
    $state= $pdo->prepare("UPDATE quizz SET is_published = :isPublished WHERE id = :id");
    $state->bindParam(':isPublished', $isPublished, PDO::PARAM_INT);
    $state->bindParam(':id', $id, PDO::PARAM_INT);
    try{
        $state->execute();
    }catch(PDOException $e){
        return $e ->getMessage();
    }
}

