# Quizz

Contexte du Projet
Type : Projet scolaire

Réalisé par : Étudiante chez Coda

Consigne :

Création de quizz (CRUD : Créer, Lire, Mettre à jour, Supprimer)

Création de questions pour les quizz (CRUD)

Chaque quizz comporte un nom et peut être publié/dépublié

Les quizz publiés sont accessibles côté front office

Les questions sont liées aux quizz et peuvent être de type simple ou multiple

Affichage des réponses sous forme de boutons radio ou cases à cocher selon le type de question

Authentification nécessaire pour accéder à la partie backoffice

Les utilisateurs front office peuvent choisir et répondre aux quizz publiés

Affichage d'une barre de progression et d'un graphique de type doughnut à la fin du quizz

Fonctionnalité de drag and drop pour ordonner les questions en backoffice

Fonctionnalités
Fonctionnalités obligatoires
CRUD complet pour les quizz et les questions

Authentification pour la partie backoffice

Affichage de quizz publiés côté front office

Navigation fluide sans rechargement de page

Barre de progression et graphique récapitulatif à la fin du quizz

Fonctionnalité de drag and drop pour ordonner les questions

Fonctionnalités optionnelles (Nice To Have)
Accès au corrigé à la fin du quizz

Chronomètre activable par quizz avec enregistrement du temps

Affichage du meilleur temps et du temps moyen pour chaque quizz

Règles de comptabilisation des bonnes réponses
Règle stricte : Si toutes les bonnes réponses ne sont pas cochées, alors la question est considérée comme fausse et aucun point n'est attribué.

Installation
Prérequis
PHP

Composer

Étapes d'installation
Récupérer la base de données et l'installer.

Dans le projet, exécuter les commandes suivantes :

bash
composer require fakerphp/faker
composer require vlucas/phpdotenv
Remplir le fichier .env avec les informations nécessaires.

Accès à la partie admin
Identifiant : admin

Mot de passe : coucou

Technologies utilisées
PHP

JavaScript

Composer

Auteur
Réalisé par une étudiante chez Coda.