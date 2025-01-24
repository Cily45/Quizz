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
                $delete = deleteQuizzAdmin($pdo, $id);
                header('Content-Type: application/json');
                if (is_bool($delete)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['error' => $delete]);
                }
                exit();
            case 'updateIsPublished':
                $change = upgradeIsPublishedQuizzAdmin($pdo, $id);
                header('Content-Type: application/json');
                if (is_bool($change)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['error' => $change]);
                }
                exit();

            default:
                break;
        }}


    $page = isset($_GET['page']) ? cleanString($_GET['page']) : null;
    $sortby = isset($_GET['sortby']) ? cleanString($_GET['sortby']) : null;
    $countPersons = getCountQuizzsAdmin($pdo);
    $quizzs = getAllQuizzsAdmin($pdo,$page,$sortby);

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