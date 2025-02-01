<?php
function getQuizz(PDO $pdo, int $id): array|string
{

    $state = $pdo->prepare("SELECT * FROM quizz WHERE id = :id");
    $state->bindParam(':id', $id, PDO::PARAM_INT);

    try {
        $state->execute();
        return $state->fetchAll(PDO::FETCH_OBJ);
    } catch (Exception $e) {
        return  $e->getMessage();
    }
}
function addTime(PDO $pdo, int $quizzId, int $time): array|bool
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query="INSERT INTO times (quizz_id, time) VALUES (:quizzId, :time)";

    $state = $pdo->prepare($query);

    $state->bindValue(":quizzId", $quizzId, PDO::PARAM_INT);
    $state->bindValue(":time", $time, PDO::PARAM_INT);

    try
    {
        $state->execute();
    }
    catch (PDOException $e)
    {
        return $e->getMessage();
    }

    $state->closeCursor();

    return true;
}

function updateQuizzTime(PDO $pdo, int $id, int $averageTime, int $bestTime): array|bool
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query="UPDATE quizz SET average_time = :averageTime, best_time = :bestTime WHERE id = :id";

    $state = $pdo->prepare($query);

    $state->bindValue(":id", $id, PDO::PARAM_INT);
    $state->bindValue(":averageTime", $averageTime, PDO::PARAM_INT);
    $state->bindValue(":bestTime", $bestTime, PDO::PARAM_INT);

    try
    {
        $state->execute();
    }
    catch (PDOException $e)
    {
        return $e->getMessage();
    }

    $state->closeCursor();

    return true;
}

function getTimes(PDO $pdo, int $id): array|string
{

    $state = $pdo->prepare("SELECT * FROM times WHERE quizz_id = :id");
    $state->bindParam(':id', $id, PDO::PARAM_INT);

    try {
        $state->execute();
        return $state->fetchAll(PDO::FETCH_OBJ);
    } catch (Exception $e) {
        return  $e->getMessage();
    }
}