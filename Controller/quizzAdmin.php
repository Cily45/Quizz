<?php
/**
 * @var PDO $pdo
 */
require 'Model/quizzAdmin.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
    if(isset($_get['action'])){
        $action = cleanString($_GET['action']);
        switch ($action) {
        }
    }
    $id = isset($_GET['id']) ? cleanString($_GET['id']) : null;
    $quizz = getQuizzAdmin($pdo,$id);

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
require 'View/quizzAdmin.php';