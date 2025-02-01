<?php
/**
 * @var PDO $pdo
 */

require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->safeLoad();
require '../includes/database.php';
$faker = Faker\Factory::create('fr_FR');
$quizzIdIsChrono = [];

for ($i = 0; $i < 50; $i++) {
    $questions = [];
    $quantityQuestion = rand(2, 20);
    $maxScore = 0;
    $isChrono = rand(0, 1);

    for ($j = 0; $j < $quantityQuestion; $j++) {
        $question = $faker->sentence();
        $answers = [];
        $countGoodAnswer = 0;
        $answerQuantity = rand(2, 6);

        for ($k = 0; $k < $answerQuantity; $k++) {
            $isCorrectAnswer = ($k === $answerQuantity - 1 && $countGoodAnswer === 0) ? 0 : rand(0, 1);
            $scoreAnswer = $isCorrectAnswer === 0 ? rand(1, 3) : 0;
            $maxScore += $scoreAnswer;
            $answers[] = ["answer" => $faker->sentence(rand(1, 5)), "score" => $scoreAnswer, "isCorrect" => $scoreAnswer === 0 ? 1 : 0];
            if ($isCorrectAnswer === 0) {
                $countGoodAnswer++;
            }
        }

        $questions[] = ["question" => $question, "isMultipleCorrectAnswer" => $countGoodAnswer > 1 ? 0 : 1, "answers" => $answers];

    }

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $state = $pdo->prepare("INSERT INTO quizz(`name`, `is_published`, `questions`, `max_score`, `is_chrono`) VALUES(:name, :isPublished, :questions, :maxScore, :isChrono)");

    $state->bindValue(':name', $faker->sentence(rand(2, 5)));
    $state->bindValue(':isPublished', rand(0, 1));
    $state->bindValue(':questions', json_encode($questions));
    $state->bindValue(':maxScore', $maxScore);
    $state->bindValue(':isChrono', $isChrono);

    try {
        $state->execute();
    } catch (PDOException $e) {
        echo "Erreur à la création du quizz {$e->getMessage()}";
    }
    $id = $pdo->lastInsertId();
    $state->closeCursor();
    if ($isChrono === 0) {
        $quizzIdIsChrono[] = $id;
    }

}

$times = [];
for ($i = 0; $i < count($quizzIdIsChrono); $i++) {
    $quizzId = $quizzIdIsChrono[$i];
    $averageTimes = 0;

    $numberTimes = rand(0, 30);
    $min = null;

    if ($numberTimes > 0) {
        for ($j = 0; $j < $numberTimes; $j++) {
            $time = rand(20, 4000);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "INSERT INTO times (quizz_id, time) VALUES (:quizzId, :time)";

            $state = $pdo->prepare($query);

            $state->bindValue(":quizzId", $quizzId, PDO::PARAM_INT);
            $state->bindValue(":time", $time, PDO::PARAM_INT);

            try {
                $state->execute();
            } catch (PDOException $e) {
                echo "Erreur à la création des times {$e->getMessage()}";
            }

            $state->closeCursor();

            $averageTimes += $time;

            if ($min === null) {
                $min = $time;
            }
            if ($time < $min) {
                $min = $time;
            }
        }

        $averageTimes = floor($averageTimes / $numberTimes);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "UPDATE quizz SET average_time = :averageTime, best_time = :bestTime WHERE id = :id";

        $state = $pdo->prepare($query);

        $state->bindValue(":id", $quizzId, PDO::PARAM_INT);
        $state->bindValue(":averageTime", $averageTimes, PDO::PARAM_INT);
        $state->bindValue(":bestTime", $min, PDO::PARAM_INT);

        try {
            $state->execute();
        } catch (PDOException $e) {
            echo "Erreur à la mise à jours des times {$e->getMessage()}";
        }

        $state->closeCursor();
    }
}
