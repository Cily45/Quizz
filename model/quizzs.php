<?php
function getAll(PDO $pdo, int $page)
{
    $query = "SELECT * FROM quizz WHERE is_published =0";

    $query .= " LIMIT 16";

    if (1 !== $page) {
        $page = ($page - 1) * 16;
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

function getCountQuizzs(PDO $pdo)
{
    $query = "SELECT COUNT(id) AS `idCount` FROM quizz WHERE is_published = 0";
    $state = $pdo->prepare($query);

    try {
        $state->execute();
        return $state->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return $e->getMessage();
    }

}