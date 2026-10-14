<?php
// Travail à la maison : modification d'un étudiant
require_once "fonctions.php";

$etudiants = chargerEtudiants();
$erreurs = [];

// Identifiant : GET à l'ouverture, champ caché en POST à l'envoi
$id = filter_var($_POST['id'] ?? $_GET['id'] ?? null, FILTER_VALIDATE_INT);
$etudiant = $id !== false && $id !== null ? trouverParId($etudiants, $id) : null;

if ($etudiant === null) {
    afficherEntete("Modifier un étudiant");
    afficherMenu();
    echo "<div class=\"erreurs\"><p>Étudiant introuvable.</p></div>";
    afficherPied();
    exit;
}

$valeurs = $etudiant;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verification = validerEtudiant($_POST);
    $erreurs = $verification['erreurs'];
    $valeurs = $verification['valeurs'];

    if (count($erreurs) === 0) {
        foreach ($etudiants as $i => $e) {
            if ($e['id'] === $id) {
                $etudiants[$i] = array_merge(["id" => $id], $valeurs);
            }
        }
        sauvegarderEtudiants($etudiants);
        definirMessage("L'étudiant {$valeurs['prenom']} {$valeurs['nom']} a été modifié.");
        header("Location: index.php");
        exit;
    }
}

afficherEntete("Modifier un étudiant");
afficherMenu();
afficherErreurs($erreurs);
afficherFormulaire($valeurs, "modifier.php", "Enregistrer les modifications", $id);
afficherPied();
