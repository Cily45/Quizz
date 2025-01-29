<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
require 'Includes/database.php';
require 'Includes/helper.php';
require("_partials/errors.php");

$errors[] = [];

if (isset($_GET['logout']) && $_GET['logout']) {
    session_destroy();
    header("Location: index.php");
    exit();
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest") {
    if (isset($_SESSION['auth'])) {
        if (isset($_GET['component'])) {
            $componentName = !empty($_GET['component']) ?
                htmlspecialchars($_GET['component'], ENT_QUOTES, 'UTF-8')
                : 'quizzsAdmin';
            if (file_exists("Controller/$componentName.php") && str_contains($_GET['component'], "Admin")) {
                require "Controller/$componentName.php";
            }else{
                require "Controller/quizzsAdmin.php";
            }
        }else{
            require "Controller/quizzsAdmin.php";
        }
    } elseif (isset($_GET['component'])) {
        $componentName = !empty($_GET['component']) ?
            htmlspecialchars($_GET['component'], ENT_QUOTES, 'UTF-8')
            : 'quizzs';

        $actionName = !empty($_GET['action']) ?
            htmlspecialchars($_GET['action'], ENT_QUOTES, 'UTF-8')
            : null;

        if (file_exists("Controller/$componentName.php") && !str_contains($_GET['component'], "Admin")) {
            require "Controller/$componentName.php";
        }else{
            require "Controller/quizzs.php";
        }
    } else {
        require "Controller/quizzs.php";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quizz</title>

    <link href="includes/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="includes/fontawesome/fontawesome-free-6.7.1-web/css/all.min.css" />


    <style>
        a {
            text-decoration: none !important;
        }
    </style>
</head>
<body>
<div class="container">
    <?php
    require "_Partials/navbar.php";

    if (isset($_SESSION['auth'])) {
        if (isset($_GET['component'])) {
            $componentName = !empty($_GET['component']) ?
                htmlspecialchars($_GET['component'], ENT_QUOTES, 'UTF-8')
                : 'quizzsAdmin';
            if (file_exists("Controller/$componentName.php") && str_contains($_GET['component'], "Admin")) {
                require "Controller/$componentName.php";
            }else{
                require "Controller/quizzsAdmin.php";
            }
        }else{
            require "Controller/quizzsAdmin.php";
        }
    } elseif (isset($_GET['component'])) {
        $componentName = !empty($_GET['component']) ?
            htmlspecialchars($_GET['component'], ENT_QUOTES, 'UTF-8')
            : 'quizzs';

        $actionName = !empty($_GET['action']) ?
            htmlspecialchars($_GET['action'], ENT_QUOTES, 'UTF-8')
            : null;

        if (file_exists("Controller/$componentName.php") && !str_contains($_GET['component'], "Admin")) {
            require "Controller/$componentName.php";
        }else{
            require "Controller/quizzs.php";
        }
    } else {
        require "Controller/quizzs.php";
    }
    ?>

</div>
<?php require "_partials/_toast.html"; ?>
<script src="Includes/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="Includes/chart.js"></script>

</body>
</html>