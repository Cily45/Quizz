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

function createQuizzAdmin(PDO $pdo, string $name, int $isPublished, string $questions, int $maxScore, int $isChono): array|bool
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query="INSERT INTO quizz (name, is_published, questions, max_score, is_chrono) VALUES (:name, :is_published, :questions, :maxScore, :isChrono)";

    $prep = $pdo->prepare($query);

    $prep->bindValue(':name', $name,);
    $prep->bindValue(':is_published', $isPublished,);
    $prep->bindValue(':questions', $questions);
    $prep->bindValue(':maxScore', $maxScore);
    $prep->bindValue(':isChrono', $isChono);

    try
    {
        $prep->execute();
    }
    catch (PDOException $e)
    {
        return " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
    }

    $prep->closeCursor();

    return true;
}

function updateQuizzAdmin(PDO $pdo, int $id, string $name, int $isPublished, string $questions, int $maxScore, int $isChrono): bool|array
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query="UPDATE quizz SET name = :name, is_published = :is_published, questions = :questions, max_score = :maxScore, is_chrono = :isChrono WHERE id = :id";

    $prep = $pdo->prepare($query);

    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    $prep->bindValue(':name', $name, PDO::PARAM_STR);
    $prep->bindValue(':is_published', $isPublished, PDO::PARAM_INT);
    $prep->bindValue(':questions', $questions, PDO::PARAM_STR);
    $prep->bindValue(':maxScore', $maxScore, PDO::PARAM_INT);
    $prep->bindValue(':isChrono', $isChrono, PDO::PARAM_INT);

    try
    {
        $prep->execute();
    }
    catch (PDOException $e)
    {
        return " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
    }

    $prep->closeCursor();

    return true;
}