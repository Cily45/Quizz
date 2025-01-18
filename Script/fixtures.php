<?php
/**
 * @var PDO $pdo
 */

require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->safeLoad();
require '../Includes/database.php';
$faker = Faker\Factory::create('fr_FR');


//generation quizzs
for ($i = 0; $i < 100; $i++) {
    $questions = [];
    $quantityQuestion = rand(5, 20);

    $apiUrl = "https://quizapi.io/api/v1/questions?apiKey={$_ENV['API_KEY_QUIZZ']}&imit={$quantityQuestion}";

    $options = [
        'http' => [
            'header' => "Content-Type: application/json"
        ]
    ];

    $context = stream_context_create($options);

    $response = file_get_contents($apiUrl, false, $context);

    if ($response === false) {
        echo 'Erreur lors de la récupération des données';
        exit;
    }

    $data = json_decode($response, true);


    // Generation questions
    for ($j = 0; $j < $quantityQuestion; $j++) {
        $question = $data[$j]["question"];
        $isMultipleCorrectAnswer = $data[$j]["multiple_correct_answers"];
        $answers = [];
        $goodAnswers = $data[$j]["correct_answers"];
        $letter = 'a';

        for ($k = 0; $k < sizeof($data[$j]["answers"]); $k++) {
            $answerText = $data[$j]["answers"]["answer_{$letter}"];
            if ($answerText !== null) {
                $scoreAnswer = $goodAnswers["answer_{$letter}_correct"] === "true" ? rand(1, 3) : 0;
                $answers[] = ["answer" => $answerText, "score" => $scoreAnswer];
            }

            $letter++;
        }

        $questions[] = ["question" => $question, "quantityGoodAnswer" => $isMultipleCorrectAnswer, "answers" => $answers];

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