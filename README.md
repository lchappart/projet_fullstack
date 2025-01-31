# Projet Géolocalisation Web Fullstack

## Développeur
Léo Chappart


## Installation
Les différentes étapes pour installer le projet sont les suivantes :
- Exécutez la commande suivante dans votre terminal dans le dossier où vous souhaitez cloner le repo:
```bash  
git clone https://github.com/lchappart/projet_fullstack.git 
```
- Ensuite, exécutez la commande :
````bash
composer install
````
- Importez la base de donnée grâce au fichier `fullstack_bdd.sql` que vous trouverez dans le dossier `Includes`.
- Créez un fichier `.env` à la racine puis collez le contenu de `.env.dist` :
````
DB_HOST=  //Le nom de votre host
DB_NAME=  //Le nom de votre base de données
DB_USER=  //Le nom du user  
DB_PASS=  //Le mot de passe
````
- Exécuter la commande suivante pour remplir votre base de données :
````bash
php scripts/fixtures.php
````
En cas d'erreur à cause de l'api, vous pourrez avoir besoin de relancer la commande.

Voilà, vous avez installé le projet ! Vous pouvez vous connecter avec le compte admin et le mot de passe admin

## Débuggage
En cas d'erreurs au niveau de l'ajout d'images, vérifiez que le nom du dossier ou se trouve la racine s'appelle bien `projet_fullstack` et que il n'y a pas un dossier dans un dossier
