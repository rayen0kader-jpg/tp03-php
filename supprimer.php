<?php
// Travail à la maison : suppression d'un étudiant (POST uniquement)
require_once "fonctions.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
$etudiants = chargerEtudiants();
$etudiant = $id !== false && $id !== null ? trouverParId($etudiants, $id) : null;

if ($etudiant === null) {
    definirMessage("Étudiant introuvable, aucune suppression effectuée.");
} else {
    $restants = [];
    foreach ($etudiants as $e) {
        if ($e['id'] !== $id) {
            $restants[] = $e;
        }
    }
    sauvegarderEtudiants($restants);
    definirMessage("L'étudiant {$etudiant['prenom']} {$etudiant['nom']} a été supprimé.");
}

header("Location: index.php");
exit;
