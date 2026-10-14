<?php
// Activités 10 et 11 : ajout d'un étudiant, avec séparation claire des étapes
require_once "fonctions.php";

$erreurs = [];
$valeurs = [];
$etudiantAjoute = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Récupération des données
    $donnees = $_POST;

    // 2. Validation
    $verification = validerEtudiant($donnees);
    $erreurs = $verification['erreurs'];
    $valeurs = $verification['valeurs'];

    // 3. Traitement (uniquement si aucune erreur)
    if (count($erreurs) === 0) {
        $etudiants = chargerEtudiants();
        $etudiant = [
            "id" => prochainId($etudiants),
            "nom" => $valeurs['nom'],
            "prenom" => $valeurs['prenom'],
            "age" => $valeurs['age'],
            "formation" => $valeurs['formation'],
            "moyenne" => $valeurs['moyenne'],
        ];
        $etudiants[] = $etudiant;
        sauvegarderEtudiants($etudiants);
        $etudiantAjoute = $etudiant;
    }
}

// 4. Affichage HTML
afficherEntete("Ajouter un étudiant");
afficherMenu();

if ($etudiantAjoute !== null) {
    afficherFiche($etudiantAjoute);
    echo "<p><a href=\"ajouter.php\">Ajouter un autre étudiant</a> | <a href=\"index.php\">Voir la liste</a></p>";
} else {
    afficherErreurs($erreurs);
    afficherFormulaire($valeurs, "ajouter.php", "Enregistrer");
}
afficherPied();
