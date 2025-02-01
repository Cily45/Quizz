<?php
/**
 * @var PDO $pdo
 */
require 'model/quizz.php';

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {

    if (
        isset($_GET['action']) &&
        isset($_GET['id']) &&
        is_numeric($_GET['id'])
    ) {
        $id = cleanString($_GET['id']);
        $action = cleanString($_GET['action']);
        $time = cleanString($_POST['time']);

        if ($action == "result") {
            $result = addTime($pdo, $id, $time);
            header('Content-Type: application/json');

            if (is_bool($result)) {
                $times = getTimes($pdo, $id);
                $average = 0;
                $min = $times[0]->time;

                for ($i = 0; $i < count($times); $i++) {
                    $average += $times[$i]->time;

                    if ($average < $min) {
                        $max = $average;
                    }

                }
                $average = floor($average / count($times));
                $uptateQuizzTime = updateQuizzTime($pdo, $id, $average, $min);

                if (is_bool($uptateQuizzTime)) {
                    echo json_encode(['success' => true, 'bestTime' => $min === $time]);
                } else {
                    echo json_encode(['error' => $result]);
                }

            } else {
                echo json_encode(['error' => $result]);
            }

            exit();
        }

    }

    $id = isset($_GET['id']) ? cleanString($_GET['id']) : null;

    $quizz = getQuizz($pdo, $id);

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

require 'view/quizz.php';