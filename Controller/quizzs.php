<?php
/**
 * @var PDO $pdo
 */
require 'Model/quizzs.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
    $page = isset($_GET['page']) ? cleanString($_GET['page']) : null;
    $countPersons = getCountQuizzs($pdo);
    $quizzs = getAll($pdo,$page);
    if(!is_array($quizzs)){
        $errors[] = $quizzs;
    }

    header('Content-Type: application/json');
    echo json_encode(
        [
            'quizzCount' => $countPersons,
            'quizzs' => $quizzs
        ]
    );
    exit();
}
require 'View/quizzs.php';