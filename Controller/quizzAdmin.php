<?php
/**
 * @var PDO $pdo
 */
require 'Model/quizzAdmin.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
    if (
        isset($_GET['action'])
    ) {
        $id = cleanString($_GET['id']);
        $action = cleanString($_GET['action']);

        $questions = !empty($_POST['questions']) ? cleanString($_POST['questions']) : null;

        //$_POST['quizz']['id']
        //$_POST['quizz']['name']
        //$_POST['quizz']['is_published']
        //$_POST['quizz']['questions']
        switch ($action) {
            case 'create':
                $create= createQuizz($pdo, $questions);
                header('Content-Type: application/json');
                if (is_bool($create)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['error' => $create]);
                }
                exit();
            case 'update':
                $change = upgradeIsPublishedQuizzAdmin($pdo, $id, $questions);
                header('Content-Type: application/json');
                if (is_bool($change)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['error' => $change]);
                }
                exit();

            default:
                break;
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