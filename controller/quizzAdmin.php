<?php
/**
 * @var PDO $pdo
 */
require 'model/quizzAdmin.php';

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {

    if (
        isset($_GET['action'])
    ) {
        $action = cleanString($_GET['action']);
        $data = !empty($_POST['data']) ? json_decode($_POST['data'], true) : null;

        $name = !empty($data['quizz'][0]['name']) ? cleanString($data['quizz'][0]['name']) : null;
        $isPublished = !empty($data['quizz'][0]['is_published']) ? cleanString($data['quizz'][0]['is_published']) : 0;
        $isChrono = !empty($data['quizz'][0]['is_chrono']) ? cleanString($data['quizz'][0]['is_chrono']) : 0;
        $questions = !empty($data['quizz'][0]['questions']) ? cleanJson($data['quizz'][0]['questions']) : null;
        $score = !empty($data['quizz'][0]['score']) ? cleanString($data['quizz'][0]['score']) : null;

        switch ($action) {
            case 'create':
                $create = createQuizzAdmin($pdo, $name, $isPublished, $questions, $score, $isChrono);
                header('Content-Type: application/json');

                if (is_bool($create)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['error' => $create]);
                }

                exit();
                break;

            case 'update':
                $id = !empty($data['quizz'][0]['id']) ? cleanString($data['quizz'][0]['id']) : null;
                $change = updateQuizzAdmin($pdo, $id, $name, $isPublished, $questions, $score, $isChrono);
                header('Content-Type: application/json');

                if (is_bool($change)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['error' => $change]);
                }

                exit();
                break;

            default:
                break;
        }

    }

    $id = isset($_GET['id']) ? cleanString($_GET['id']) : null;
    $quizz = getQuizzAdmin($pdo, $id);

    if (!is_array($quizz)) {
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

require 'view/quizzAdmin.php';