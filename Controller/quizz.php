<?php
/**
 * @var PDO $pdo
 */
require 'Model/quizz.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
    $id = isset($_GET['id']) ? cleanString($_GET['id']) : null;

    $quizz = getQuizz($pdo,$id);

    if(!is_array($quizz)){
        $errors[] = $quizz;
    }

    header('Content-Type: application/json');
    echo json_encode(
        [
            'quizz' => $quizz,
        ]
    );
    exit();
}

require 'View/quizz.php';