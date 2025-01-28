<?php

function getAllQuizzsAdmin(PDO $pdo, int $page, string|null $sortby = null): array|string
{
    $query = "SELECT * FROM quizz";

    if ($sortby !== null) {
        $query .= " ORDER BY $sortby";
    }

    $query .= " LIMIT 15";

    if (1 !== $page) {
        $page = ($page - 1) * 15;
        $query .= " OFFSET $page";
    }

    $state = $pdo->prepare($query);

    try {
        $state->execute();
        return $state->fetchAll(PDO::FETCH_OBJ);
    } catch (Exception $e) {
        return $e->getMessage();
    }

}

function getCountQuizzsAdmin(PDO $pdo)
{
    $query = "SELECT COUNT(id) AS `idCount` FROM quizz";
    $state = $pdo->prepare($query);
    try {
        $state->execute();
        return $state->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function deleteQuizzAdmin(PDO $pdo, int $id): true|string
{
    $state = $pdo->prepare("DELETE FROM quizz WHERE id = :id");
    $state->bindParam(':id', $id, PDO::PARAM_INT);

    try {

        $state->execute();
    } catch (PDOException $e) {
        return " erreur : " . $e->getCode() . ' ' . $e->getMessage();
    }

    return true;
}

function updateIsPublishedQuizzAdmin(PDO $pdo, int $id): true|string
{
    $state = $pdo->prepare("UPDATE quizz SET is_published = NOT is_published WHERE id = :id");
    $state->bindParam(':id', $id, PDO::PARAM_INT);

    try {
        $state->execute();
    } catch (PDOException $e) {
        return " erreur : " . $e->getCode() . ' ' . $e->getMessage();
    }

    return true;
}

