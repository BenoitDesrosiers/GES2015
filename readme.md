GES2015 (Gestion d'Événement Sportif)
=====================================

Un système de gestion d'évènement sportif développé dans le cadre du cours de programmation web 420-CN2-DM du Cégep de Drummondville. 

Le projet a démarré lors des jeux du Québec qui se sont tenus à Drummondville en 2015. Le développement se poursuit à chaque automne par les étudiants qui suivent ce cours. De nouvelles fonctionnalités y sont ajoutées, et les bugs sont corrigés par les étudiants. 

Développé à l'aide du framework Laravel. 


Installation
------------

Prérequis:

Composer

MySQL


Il suffit de cloner ce dépot et d'entrer la commande "composer update". 

Vous devez créer une BD nommée GestionEvenementsSportifs. 

Vous devez changer l'information dans le fichier .env afin de fournir votre compte et mot de passe pour accéder à MySQL. 

Une fois la BD créer, vous devez faire les migrations et le seed. 

php artisan migrate

php artisan db:seed

License 
-------

Vous êtes libre de copier ce code et d'en faire ce que vous voulez. Il n'y a aucune garantie que les fonctionnalités sont "bug-free"... n'oubliez pas que c'est un projet d'étudiants... 

Aucune aide ne sera acceptée pour le faire avancer. Ce projet est à titre éducatif uniquement. Si vous apportez des modifications, merci de me les communiquer, mais il est possible qu'elles soient refusées. 

