<?php
/**
 * @var PDO $pdo
 */
require 'model/login.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
    $username = !empty($_POST['username']) ? $_POST['username'] : null;
    $password = !empty($_POST['password']) ? $_POST['password'] : null;
    if(!empty($username) || !empty($password)){
        $username = cleanString($username);
        $password = cleanString($password);

        $user = getUserAdmin($pdo, $username);


        $isMatchPassword = is_array($user) && password_verify($password, $user['password']);


        if($isMatchPassword) {
            $_SESSION['auth'] = true;
            header("Content-type: application/json");
            echo json_encode(['authentication' => true]);
            exit();
        }else{
            $errors[] = "L'identification à échoué";
            header("Content-type: application/json");
            echo json_encode(['errors' => $errors]);
            exit();
        }
    }
}
require 'view/login.php';