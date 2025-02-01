# Quizz

## Description

The project is a quiz application integrating various functionalities. It was developed as part of a school assignment.

### Backoffice
Access to the backoffice is secured by an authentication system, ensuring that only authorized individuals can manage quizzes and questions. You can create, read, update, and delete quizzes thanks to a complete CRUD system. Additionally, a drag-and-drop feature is available to order questions, facilitating their organization. Each quiz has a unique name and can be published or unpublished as needed. Published quizzes are then accessible to users on the front office, allowing for wide distribution.

Questions in the quizzes can be of simple or multiple types, with answers displayed as radio buttons or checkboxes, depending on the nature of the question. Moreover, quizzes can have a timer with time recording, allowing visualization of the best time as well as the average time for each quiz.

### Frontoffice
Front office users have the ability to choose and answer published quizzes, thus enhancing interactivity. At the end of each quiz, a progress bar and a doughnut chart are displayed, providing a visual overview of the user's performance. Optionally, users can access the corrected answers at the end of the quiz.

Finally, the scoring rules follow a strict approach: if not all correct answers are selected, the question is considered incorrect and no points are awarded.

![alt text](https://github.com/cily/quizz/bdd.jpg?raw=true)

### Prerequisites
* composer
  
### Installation
* Retrieve the database and install it.

* In the project directory, execute the following commands:

```
composer require fakerphp/faker
composer require vlucas/phpdotenv
```

* Create a .env file, copy the content from en.dist into it, and fill it out.

* Go to the script directory and run this command:

```
php fixtures.php
```

### Author
Cecile Fischer, also known as Cily
As a student at Coda-Orléans

# Quizz

## Description

Le projet est une application de quizz intégrant diverses fonctionnalités. Il a été réalise dans le cadre scolaire.

### Backoffice 
L'accès à la partie backoffice est sécurisé par un système d'authentification, garantissant que seules les personnes autorisées peuvent gérer les quizz et les questions. Vous pouvez créer, lire, mettre à jour et supprimer des quizz grâce à un système CRUD complet. De plus, une fonctionnalité de glisser-déposer (drag and drop) est disponible pour ordonner les questions, facilitant ainsi leur organisation. Chaque quizz possède un nom unique et peut être publié ou dépublié selon les besoins. Les quizz publiés sont alors accessibles aux utilisateurs côté front office, permettant une large diffusion.

Les questions des quizz peuvent être de type simple ou multiple, avec des réponses affichées sous forme de boutons radio ou de cases à cocher, selon la nature de la question. De plus, les quizz peuvent avoir un chronomètre avec enregistrement du temps, permettant ainsi de visualiser le meilleur temps ainsi que le temps moyen pour chaque quizz.

### Frontoffice 
Les utilisateurs du front office ont la possibilité de choisir et de répondre aux quizz publiés, favorisant ainsi une interactivité accrue. À la fin de chaque quizz, une barre de progression et un graphique de type doughnut sont affichés, offrant un aperçu visuel des performances de l'utilisateur. En termes de fonctionnalités optionnelles, les utilisateurs peuvent accéder au corrigé à la fin du quizz.

Enfin, les règles de comptabilisation des bonnes réponses suivent une approche stricte : si toutes les bonnes réponses ne sont pas cochées, alors la question est considérée comme fausse et aucun point n'est attribué.

### Prérequis
* composer

### Instalation

* Récupérer la base de données et l'installer.

Dans le projet, exécuter les commandes suivantes :

```
composer require fakerphp/faker
composer require vlucas/phpdotenv
```
* Créer un fichier .env y copier coller le contenu de en.dist et le remplir.

* Aller dans le dossier script et lance cette commande :

```
php fixtures.php
```

## Auteur

Cecile Fischer alias Cily
En tant qu'etudiante chez Coda-Orléans

[@CecileFischer](https://www.linkedin.com/in/fischercecile/)

