<?php
// Activité 12 : recherche avec la méthode GET
require_once "fonctions.php";

$etudiants = chargerEtudiants();
$nom = trim($_GET['nom'] ?? '');
$recherche = isset($_GET['nom']);
$resultats = $recherche && $nom !== '' ? rechercherParNom($etudiants, $nom) : [];

afficherEntete("Rechercher un étudiant");
afficherMenu();
?>
<form method="GET" action="rechercher.php">
    <label for="nom">Nom ou prénom :</label>
    <input type="text" id="nom" name="nom" value="<?= echapper($nom) ?>">
    <button type="submit">Rechercher</button>
</form>
<?php
if ($recherche && $nom === '') {
    echo "<div class=\"erreurs\"><p>Veuillez saisir un nom ou un prénom.</p></div>";
} elseif ($recherche) {
    echo "<h2>Résultats pour « " . echapper($nom) . " » (" . count($resultats) . ")</h2>";
    if (count($resultats) > 0) {
        afficherTableau($resultats);
    } else {
        echo "<p>Aucun étudiant trouvé.</p>";
    }
}
afficherPied();
