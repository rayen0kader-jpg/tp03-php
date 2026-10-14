# TP3 - Formulaires, GET/POST et validation en PHP

Gestion des étudiants - 2ème année Licence

## Lancer le projet
```bash
cd tp03-php
php -S localhost:8000
```
Puis ouvrir http://localhost:8000

## Structure
- `index.php` : liste des étudiants (tableau HTML, résultat Admis/Ajourné)
- `ajouter.php` : ajout (POST) avec validation et séparation récupération / validation / traitement / affichage
- `rechercher.php` : recherche par nom ou prénom (GET)
- `modifier.php` : modification d'un étudiant (travail à la maison)
- `supprimer.php` : suppression d'un étudiant, POST uniquement (travail à la maison)
- `fonctions.php` : fonctions communes (résultat, validation, stockage, affichage)
- `css/style.css` : styles
- `exercices/` : activités 1 à 8 (`formulaire.php`, `recherche.php`, `inscription.php`)
- `questions.txt` : réponses aux questions

## Stockage
Pas encore de base de données : les étudiants sont stockés dans un tableau PHP conservé dans
`$_SESSION`, ce qui permet d'ajouter, modifier et supprimer entre deux requêtes. Les données
repartent de la liste initiale à la fin de la session (fermeture du navigateur).
