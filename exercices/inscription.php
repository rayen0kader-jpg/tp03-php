<?php
// Activités 4 (POST), 5, 6, 7 et 8 : inscription avec validation
require_once "../fonctions.php"; // pour la fonction resultat()

$erreurs = [];
$enregistre = false;

// Les variables sont initialisées pour conserver les valeurs dans le formulaire (Activité 7)
$nom = $prenom = $age = $formation = $moyenne = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom       = trim($_POST['nom'] ?? '');
    $prenom    = trim($_POST['prenom'] ?? '');
    $age       = trim($_POST['age'] ?? '');
    $formation = trim($_POST['formation'] ?? '');
    $moyenne   = trim($_POST['moyenne'] ?? '');

    // Activité 5 : champs obligatoires
    // (on compare à '' plutôt que empty() car "0" est une valeur valide pour l'âge/la moyenne)
    if ($nom === '')       { $erreurs[] = "Le nom est obligatoire."; }
    if ($prenom === '')    { $erreurs[] = "Le prénom est obligatoire."; }
    if ($age === '')       { $erreurs[] = "L'âge est obligatoire."; }
    if ($formation === '') { $erreurs[] = "La formation est obligatoire."; }
    if ($moyenne === '')   { $erreurs[] = "La moyenne est obligatoire."; }

    // Activité 6 : règles sur l'âge et la moyenne
    if ($age !== '') {
        if (!is_numeric($age)) {
            $erreurs[] = "L'âge doit être un nombre.";
        } elseif ($age < 16 || $age > 40) {
            $erreurs[] = "L'âge doit être compris entre 16 et 40 ans.";
        }
    }
    if ($moyenne !== '') {
        if (!is_numeric($moyenne)) {
            $erreurs[] = "La moyenne doit être un nombre.";
        } elseif ($moyenne < 0 || $moyenne > 20) {
            $erreurs[] = "La moyenne doit être comprise entre 0 et 20.";
        }
    }

    if (count($erreurs) === 0) {
        $enregistre = true;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Activités 5 à 8 - Inscription</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h1>Inscription (POST)</h1>

<?php if ($enregistre): ?>
    <!-- Activité 8 : fiche de l'étudiant -->
    <div class="fiche">
        <h2>Étudiant enregistré</h2>
        <p>Nom : <?= htmlspecialchars($nom) ?></p>
        <p>Prénom : <?= htmlspecialchars($prenom) ?></p>
        <p>Âge : <?= (int) $age ?> ans</p>
        <p>Formation : <?= htmlspecialchars($formation) ?></p>
        <p>Moyenne : <?= (float) $moyenne ?> / 20</p>
        <p>Résultat : <?= resultat((float) $moyenne) ?></p>
    </div>
    <p><a href="inscription.php">Nouvelle inscription</a></p>
<?php else: ?>
    <?php if (count($erreurs) > 0): ?>
        <div class="erreurs">
            <?php foreach ($erreurs as $erreur): ?>
                <p><?= htmlspecialchars($erreur) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label>Nom :</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($nom ?? '') ?>">
        <label>Prénom :</label>
        <input type="text" name="prenom" value="<?= htmlspecialchars($prenom ?? '') ?>">
        <label>Âge :</label>
        <input type="number" name="age" value="<?= htmlspecialchars($age ?? '') ?>">
        <label>Formation :</label>
        <input type="text" name="formation" value="<?= htmlspecialchars($formation ?? '') ?>">
        <label>Moyenne :</label>
        <input type="number" step="0.01" name="moyenne" value="<?= htmlspecialchars($moyenne ?? '') ?>">
        <br>
        <button type="submit">Envoyer</button>
    </form>
<?php endif; ?>

<p><a href="../index.php">Retour</a></p>
</body>
</html>
