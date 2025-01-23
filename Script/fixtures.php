<?php
/**
 * @var PDO $pdo
 */

require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->safeLoad();
require '../Includes/database.php';
$faker = Faker\Factory::create('fr_FR');

for ($i = 0; $i < 100; $i++) {
    $questions = [];
    $quantityQuestion = rand(2, 20);

    for ($j = 0; $j < $quantityQuestion; $j++) {
        $question = $faker->sentence();
        $answers = [];
        $countGoodAnswer = 0;
        $answerQuantity = rand(2,6);

        for ($k = 0; $k < $answerQuantity; $k++) {
            $isCorrectAnswer = ($k === $answerQuantity-1 && $countGoodAnswer === 0) ? 0 : rand(0,1);
            $scoreAnswer = $isCorrectAnswer === 0 ? rand(1,3) : 0;
            $answers[] = ["answer" => $faker->sentence(rand(1, 5)), "score" => $scoreAnswer, "isCorrect" => $scoreAnswer === 0 ? 1 : 0];
            if($isCorrectAnswer === 0 ) {
                $countGoodAnswer++;
            }
        }

        $questions[] = ["question" => $question, "isMultipleCorrectAnswer" => $countGoodAnswer > 1? 0 : 1, "answers" => $answers];

    }

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $state = $pdo->prepare("INSERT INTO quizz(`name`, `is_published`, `questions`) VALUES(:name, :isPublished, :questions)");

    $state->bindValue(':name', $faker->sentence(rand(2, 5)));
    $state->bindValue(':isPublished', rand(0, 1));
    $state->bindValue(':questions', json_encode($questions));

    try {
        $state->execute();
    } catch (PDOException $e) {
        echo "Erreur à la création du quizz {$e->getMessage()}";
    }
    $state->closeCursor();
}