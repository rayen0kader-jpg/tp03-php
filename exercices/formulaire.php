<?php
// Activités 1 à 3 : formulaire GET + isset()
//
// Activité 1 : <form> sans attribut method -> GET par défaut, les champs sont envoyés dans l'URL.
// Activité 2 : <form method="GET"> et lecture avec $_GET.
// Activité 3 : isset() pour fonctionner à la première ouverture ET après envoi.

$envoye = isset($_GET['nom']) || isset($_GET['prenom']) || isset($_GET['age']) || isset($_GET['formation']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Activités 1 à 3 - Formulaire GET</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h1>Formulaire (méthode GET)</h1>

<form method="GET">
    <label>Nom :</label>
    <input type="text" name="nom">
    <label>Prénom :</label>
    <input type="text" name="prenom">
    <label>Âge :</label>
    <input type="number" name="age">
    <label>Formation :</label>
    <input type="text" name="formation">
    <br>
    <button type="submit">Envoyer</button>
</form>

<h2>Données reçues</h2>
<?php
if ($envoye) {
    if (isset($_GET['nom']))       { echo "Nom : " . htmlspecialchars($_GET['nom']) . "<br>"; }
    if (isset($_GET['prenom']))    { echo "Prénom : " . htmlspecialchars($_GET['prenom']) . "<br>"; }
    if (isset($_GET['age']))       { echo "Âge : " . htmlspecialchars($_GET['age']) . "<br>"; }
    if (isset($_GET['formation'])) { echo "Formation : " . htmlspecialchars($_GET['formation']) . "<br>"; }
} else {
    echo "<p>Veuillez remplir le formulaire.</p>";
}
?>
<p><a href="../index.php">Retour</a></p>
</body>
</html>
