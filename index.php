<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
require 'includes/database.php';
require 'includes/helper.php';
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
            if (file_exists("controller/$componentName.php") && str_contains($_GET['component'], "Admin")) {
                require "controller/$componentName.php";
            }else{
                require "controller/quizzsAdmin.php";
            }
        }else{
            require "controller/quizzsAdmin.php";
        }
    } elseif (isset($_GET['component'])) {
        $componentName = !empty($_GET['component']) ?
            htmlspecialchars($_GET['component'], ENT_QUOTES, 'UTF-8')
            : 'quizzs';

        $actionName = !empty($_GET['action']) ?
            htmlspecialchars($_GET['action'], ENT_QUOTES, 'UTF-8')
            : null;

        if (file_exists("controller/$componentName.php") && !str_contains($_GET['component'], "Admin")) {
            require "controller/$componentName.php";
        }else{
            require "controller/quizzs.php";
        }
    } else {
        require "controller/quizzs.php";
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
    require "_partials/navbar.php";

    if (isset($_SESSION['auth'])) {
        if (isset($_GET['component'])) {
            $componentName = !empty($_GET['component']) ?
                htmlspecialchars($_GET['component'], ENT_QUOTES, 'UTF-8')
                : 'quizzsAdmin';
            if (file_exists("controller/$componentName.php") && str_contains($_GET['component'], "Admin")) {
                require "controller/$componentName.php";
            }else{
                require "controller/quizzsAdmin.php";
            }
        }else{
            require "controller/quizzsAdmin.php";
        }
    } elseif (isset($_GET['component'])) {
        $componentName = !empty($_GET['component']) ?
            htmlspecialchars($_GET['component'], ENT_QUOTES, 'UTF-8')
            : 'quizzs';

        $actionName = !empty($_GET['action']) ?
            htmlspecialchars($_GET['action'], ENT_QUOTES, 'UTF-8')
            : null;

        if (file_exists("controller/$componentName.php") && !str_contains($_GET['component'], "Admin")) {
            require "controller/$componentName.php";
        }else{
            require "controller/quizzs.php";
        }
    } else {
        require "controller/quizzs.php";
    }
    ?>

</div>
<?php require "_partials/_toast.html"; ?>
<script src="includes/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="includes/chart.js"></script>

</body>
</html>