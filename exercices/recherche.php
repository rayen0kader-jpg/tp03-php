<?php
// Activité 4 : recherche -> méthode GET
$nom = trim($_GET['nom'] ?? '');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Activité 4 - Recherche (GET)</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h1>Recherche (GET)</h1>
<form method="GET">
    <label>Nom :</label>
    <input type="text" name="nom" value="<?= htmlspecialchars($nom) ?>">
    <button type="submit">Rechercher</button>
</form>
<?php
if (isset($_GET['nom'])) {
    echo $nom === '' ? "<p>Veuillez saisir un nom.</p>" : "<p>Recherche de : <strong>" . htmlspecialchars($nom) . "</strong></p>";
    echo "<p>L'URL contient les données : ?nom=" . htmlspecialchars(urlencode($nom)) . " (elle peut être partagée ou mise en favori).</p>";
}
?>
<p><a href="../index.php">Retour</a></p>
</body>
</html>
