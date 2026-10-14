<?php
// Page d'accueil : liste des étudiants (Activité 13)
require_once "fonctions.php";

$etudiants = chargerEtudiants();
$message = lireMessage();

afficherEntete("Gestion des étudiants");
afficherMenu();

if ($message !== null) {
    echo "<div class=\"succes\">" . echapper($message) . "</div>";
}
?>
<h2>Liste des étudiants (<?= count($etudiants) ?>)</h2>
<?php afficherTableau($etudiants, true); ?>
<p><a class="bouton" href="ajouter.php">+ Ajouter un étudiant</a></p>
<?php afficherPied(); ?>
