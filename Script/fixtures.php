<?php
/**
 * @var PDO $pdo
 */
require '../vendor/autoload.php';
require '../Includes/database.php';


$faker = Faker\Factory::create('fr_FR');


//generation quizzs
for ($i = 0; $i < 50; $i++) {
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    $state = $pdo->prepare("INSERT INTO quizz(`name`, `is_published`) VALUES(:name, :isPublished)");

    $state->bindValue(':name', $faker->sentence(rand(2, 5)));
    $state->bindValue(':isPublished', rand(0, 1));

    try {
        $state->execute();
    } catch (PDOException $e) {
        echo "Erreur à la création du quizz {$e->getMessage()}";
    }

    $idQuizz = $pdo->lastInsertId();
    $countMaxScore = 0;

    // Generation questions
    for ($j = 0; $j < rand(5, 20); $j++) {
        $state = $pdo->prepare("INSERT INTO question(`id_quizz`, `question`,`answer`,`quantity_good_answer`) VALUES(:idQuizz,:question,:answer,:quantityGoodAnswer)");
        $state->bindValue(':idQuizz', $idQuizz);
        $question = $faker->sentence(rand(5, 10));
        $state->bindValue(':question', substr_replace($question, '?', strlen($question) - 1));
        $quantityGoodAnswer = 0;
        $answer =[];
        $quantityAnswer = rand(2,8);
        for ($k = 1; $k <= $quantityAnswer; $k++) {
            $answerText = $faker->sentence(rand(1, 4));
            $scoreAnswer = $k === $quantityAnswer && $quantityGoodAnswer === 0 ?  rand(1,3):rand(0,3);
            $countMaxScore += $scoreAnswer;
            $quantityGoodAnswer += $scoreAnswer !== 0? 1 : 0;
            $answer[] = ["answer" => $answerText, "scoreAnswer" => $scoreAnswer];
        }

        $state->bindValue(':answer', json_encode($answer));
        $state->bindValue(':quantityGoodAnswer', $quantityGoodAnswer);


        try {
            $state->execute();
        } catch (PDOException $e) {
            echo "Erreur à la création de la question {$e->getMessage()}";
        }

        $idQuestion = $pdo->lastInsertId();
        $state->closeCursor();

        //Generation reponses
        $answers = [0, 0];
        $quantityAnswer = $quantityGoodAnswer + rand(1, 4);



//        for ($k = 1; $k <= $quantityAnswer; $k++) {
//            $state = $pdo->prepare("INSERT INTO answer(`id_question`,`answer`,`is_good_answer`,`score`) VALUES(:idQuestion,:answer,:isGoodAnswer,:score)");
//            $state->bindValue(':idQuestion', $idQuestion);
//            $state->bindValue(':answer', $faker->sentence(rand(1, 4)));
//
//            $isGoodAnswer = rand(0, 1);
//            if ($isGoodAnswer === 0) {
//                if ($answers[0] < $quantityGoodAnswer) {
//                    $answers[0]++;
//                } else {
//                    $isGoodAnswer = 1;
//                    $answers[1]++;
//                }
//            } else {
//                if ($answers[1] < ($quantityAnswer - $quantityGoodAnswer)) {
//                    $answers[1]++;
//                } else {
//                    $isGoodAnswer = 0;
//                    $answers[0]++;
//                }
//            }
//            $state->bindValue(':isGoodAnswer', $isGoodAnswer);
//            $scoreAnswer = $isGoodAnswer === 0 ?  rand(1,3) : 0;
//            $countMaxScore += $scoreAnswer;
//            $state->bindValue(':score', $scoreAnswer);
//            try {
//                $state->execute();
//            } catch (PDOException $e) {
//                echo "Erreur à la création de la reponse {$e->getMessage()}";
//            }
//            $state->closeCursor();
//        }
    }

    $count = 0;
    $scores = rand(0, 20);

    for($m =0; $m < $scores; $m++) {
        $quizzScore = rand(0, $countMaxScore);
        $count += $quizzScore;
        $state = $pdo->prepare("INSERT INTO scores(`id_quizz`,`score`) VALUES(:idQuizz,:score)");
        $state->bindValue(':idQuizz', $idQuizz);
        $state->bindValue(':score', $quizzScore);

        try {
            $state->execute();
        } catch (Exception $e) {
            echo "Erreur à la création du score {$e->getMessage()}";
        }

        $state->closeCursor();
    }
    $average = (int) ($scores !== 0 ?$count/$scores : 0);


    if($scores > 0){
        try{
            $state = $pdo->prepare("UPDATE `quizz` SET `average_score` = :average WHERE `id` = :idQuizz");
            $state->bindParam(':average', $average);
            $state->bindParam(':idQuizz', $idQuizz);
            $state->execute();
        }catch (Exception $e){
            echo "Erreur à l'ajout de la moyenne du quizz {$e->getMessage()}";
        }
    }

    $state->closeCursor();
}