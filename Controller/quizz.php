<?php
/**
 * @var PDO $pdo
 */
require 'Model/quizz.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
    $id = isset($_GET['id']) ? cleanString($_GET['id']) : null;
    $question = getQuestion($pdo,$id);
    if(!is_array($question)){
        $errors[] = $question;
    }
    header('Content-Type: application/json');
    echo json_encode(
        [
            'question' => $question
        ]
    );
    exit();
}

require 'View/quizz.php';
