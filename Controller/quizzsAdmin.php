<?php
/**
 * @var PDO $pdo
 */
require 'Model/quizzsAdmin.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
    if (
        isset($_GET['action']) &&
        isset($_GET['id']) &&
        is_numeric($_GET['id'])
    ) {
        $id = cleanString($_GET['id']);
        $action = cleanString($_GET['action']);
        switch ($action) {
            case 'delete':
                $delete = delete($pdo, $id);
                if (!empty($delete)) {
                    $delete = "Impossible de supprimer l'utilisateur car celui-ci est encore lié !";
                    $errors[] = $delete;
                }
                break;

            case 'updateIsPublished':
                $isPublished = $_GET['isPublished'] ?? null;
                $change = isPublished($pdo, $id, $isPublished);
                if (!empty($change)) {
                    $change = "Impossible de supprimer l'utilisateur car celui-ci est encore lié !";
                    $errors[] = $change;
                }
                break;

            default:
                break;
        }}


    $page = isset($_GET['page']) ? cleanString($_GET['page']) : null;
    $sortby = isset($_GET['sortby']) ? cleanString($_GET['sortby']) : null;
    $countPersons = getCountQuizzsAdmin($pdo);
    $quizzs = getAllQuizzsAdmin($pdo,$page,$sortby);

    if(!is_array($quizzs)){
        $errors[] = $quizzs;
    }

    header('Content-Type: application/json');
    echo json_encode(
        [
            'quizzCount' => $countPersons,
            'quizzs' => $quizzs,
            'auth' => $_SESSION['auth'] ?? null,
            'sortby' => $sortby
        ]
    );
    exit();
}
require 'View/quizzsAdmin.php';