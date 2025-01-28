<?php

function getUserAdmin(PDO $pdo, string $username)
{
    $res = $pdo->prepare('SELECT * FROM admin_user WHERE username = :username');
    $res->bindValue(':username', $username);

    try {
        $res->execute();
    } catch (Exception $e) {
        return "erreur avec le serveur d'autenthification : $e->getMessage()";
    }

    return $res->fetch(PDO::FETCH_ASSOC);
}
