<h1>Projet : site web pour le master IA de l'URCA</h1>

## Membres du projet :

- LEMONT Gaétan, `lemo0037`
- PLUCHART Evan, `pluc0003`
- ROBION Alban, `robi0082`
- LAIDIE Lucie, `laid0003`


## Introduction du projet



> L'université de Reims Champagne-Ardenne a besoin d'un site pour leur master informatique parcours IA. Nous sommes ici chargés de la création de ce site. Ce projet est composé en 3 étapes :
>  - La réalisation du [cahier des charges](https://docs.google.com/document/d/1SNjHnTAs2dZm_Wvjl6REXTSZmRf3SR8BpaIwg26iOUk/edit?usp=sharing "Lien vers le drive du cahier des charges")
>  - La réalisation du [rapport d'analyse](https://docs.google.com/document/d/1bvXWJZBKu2fY5icIPTMaX61Fq6h1UfLQC4F78m-e2SE/edit?usp=sharing "Lien vers le drive du rapport d'analyse") à l'aide de la méthode SCRUM
>  - La partie développement, permettant de mettre en place les diagrammes créés auparavant.


## Outils utilisés



- <abbr title="Hypertext Preprocessor">**PHP**</abbr>
  - Le projet sera fait sur [**Symfony**](https://symfony.com/download)
  - [**Composer**](https://getcomposer.org/) sera utilisé pour la gestion des bibliothèques
  - [**Codeception**](https://codeception.com/) pour les tests unitaires
  - [**PHP-CS-FIXER**](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer#user-content-editor-integration) servira à vérifier le respect des normes de PHP
- <abbr title="Hyper Text Markup Language">**HTML**</abbr>
- <abbr title="Cascading Style Sheets">**CSS**</abbr>
  - [**Bootstrap**](https://getbootstrap.com/)
- <abbr title="Syntactically Awesome Style Sheet">**SCSS**</abbr>
- **Javascript**

## Installation et configuration


Ce projet utlise le framework *Symfony* :

- Pour récupérer les paquets du projets utilisez : 
```bash 
composer install
```
- Pour lancer le projet utilisez :
```bash
composer start
```

## Tester le projet

Utilisation : composer [script_name]

    start: Démarre le serveur symfony sans restriction de durée
    Naviguez alors à partir de cette adresse : http://localhost:8000/,
    fix:cs: Fixe les problèmes de syntaxes du projet.,
    test:codecept: Regénère une base de donnée de test en y insérant des données puis execute les tests de codeception.,
    test: Démarre les tests de codeception et de composer à la suite.,
    db: Génère une base de donnée de test.


## Base de donnée:


Le fichier de configuration de la base de donnée est .env.local La ligne de configuration a la bd se présente sous cette forme :
```bash 
DATABASE_URL="mysql://[phpmyadmin_name]:[mdp]@mysql:3306/[nom_bdd_dans_phpMyAdmin]?serverVersion=mariadb-[maria-db_version (x.x.x)]"
```

## Style de codage

Le code suit la recommandation [PSR-12](https://www.php-fig.org/psr/psr-12/) :
- il peut être reformaté automatiquement avec `composer fix:cs`

## Utilisateurs (`email:password`)

- `admin@example.com:admin`
- `teacher@example.com:test`
- `student@example.com:test`
- `student2@example.com:test`
- `company@example.com:test`