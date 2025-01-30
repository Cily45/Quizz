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

function createQuizzAdmin(PDO $pdo, string $name, int $isPublished, string $questions): array|bool
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query="INSERT INTO quizz (name, is_published, questions) VALUES (:name, :is_published, :questions)";

    $prep = $pdo->prepare($query);

    $prep->bindValue(':name', $name,);
    $prep->bindValue(':is_published', $isPublished,);
    $prep->bindValue(':questions', $questions);

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

function updateQuizzAdmin(PDO $pdo, int $id, string $name, int $isPublished, string $questions){
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query="UPDATE quizz SET name = :name, is_published = :is_published, questions = :questions WHERE id = :id";

    $prep = $pdo->prepare($query);

    $prep->bindValue(':id', $id, PDO::PARAM_INT);
    $prep->bindValue(':name', $name, PDO::PARAM_STR);
    $prep->bindValue(':is_published', $isPublished, PDO::PARAM_INT);
    $prep->bindValue(':questions', $questions, PDO::PARAM_STR);

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