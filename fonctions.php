<?php
// fonctions.php : fonctions communes de l'application "Gestion des étudiants"

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // les étudiants sont conservés dans $_SESSION (pas encore de base de données)
}

// ---------- Utilitaires ----------

function resultat($moyenne)
{
    return $moyenne >= 10 ? "Admis" : "Ajourné";
}

function echapper($valeur)
{
    return htmlspecialchars((string) ($valeur ?? ''), ENT_QUOTES, 'UTF-8');
}

function definirMessage($message)
{
    $_SESSION['message'] = $message;
}

function lireMessage()
{
    $message = $_SESSION['message'] ?? null;
    unset($_SESSION['message']);
    return $message;
}

// ---------- Stockage (tableau PHP conservé en session) ----------

function etudiantsParDefaut()
{
    return [
        ["id" => 1, "nom" => "Khediri",   "prenom" => "Ahmed",   "age" => 20, "formation" => "Informatique", "moyenne" => 14.5],
        ["id" => 2, "nom" => "Ali",       "prenom" => "Sami",    "age" => 21, "formation" => "Informatique", "moyenne" => 11.5],
        ["id" => 3, "nom" => "Ben Salah", "prenom" => "Nour",    "age" => 19, "formation" => "Gestion",      "moyenne" => 16],
        ["id" => 4, "nom" => "Trabelsi",  "prenom" => "Amine",   "age" => 22, "formation" => "Informatique", "moyenne" => 8.75],
        ["id" => 5, "nom" => "Jlassi",    "prenom" => "Salma",   "age" => 21, "formation" => "Réseaux",      "moyenne" => 17.5],
    ];
}

function chargerEtudiants()
{
    if (!isset($_SESSION['etudiants'])) {
        $_SESSION['etudiants'] = etudiantsParDefaut();
    }
    return $_SESSION['etudiants'];
}

function sauvegarderEtudiants($etudiants)
{
    $_SESSION['etudiants'] = array_values($etudiants);
}

function prochainId($etudiants)
{
    $max = 0;
    foreach ($etudiants as $e) {
        if ($e['id'] > $max) {
            $max = $e['id'];
        }
    }
    return $max + 1;
}

function trouverParId($etudiants, $id)
{
    foreach ($etudiants as $e) {
        if ($e['id'] === $id) {
            return $e;
        }
    }
    return null;
}

function rechercherParNom($etudiants, $terme)
{
    $terme = mb_strtolower(trim($terme));
    $trouves = [];
    foreach ($etudiants as $e) {
        if (str_contains(mb_strtolower($e['nom']), $terme) || str_contains(mb_strtolower($e['prenom']), $terme)) {
            $trouves[] = $e;
        }
    }
    return $trouves;
}

// ---------- Validation ----------

// Reçoit les données brutes ($_POST) et renvoie les erreurs + les valeurs nettoyées
function validerEtudiant($donnees)
{
    $erreurs = [];

    $nom       = trim($donnees['nom'] ?? '');
    $prenom    = trim($donnees['prenom'] ?? '');
    $formation = trim($donnees['formation'] ?? '');
    $age       = trim($donnees['age'] ?? '');
    $moyenne   = str_replace(',', '.', trim($donnees['moyenne'] ?? ''));

    if ($nom === '') {
        $erreurs[] = "Le nom est obligatoire.";
    } elseif (mb_strlen($nom) > 50) {
        $erreurs[] = "Le nom ne doit pas dépasser 50 caractères.";
    }

    if ($prenom === '') {
        $erreurs[] = "Le prénom est obligatoire.";
    } elseif (mb_strlen($prenom) > 50) {
        $erreurs[] = "Le prénom ne doit pas dépasser 50 caractères.";
    }

    if ($formation === '') {
        $erreurs[] = "La formation est obligatoire.";
    }

    if ($age === '') {
        $erreurs[] = "L'âge est obligatoire.";
    } elseif (filter_var($age, FILTER_VALIDATE_INT) === false) {
        $erreurs[] = "L'âge doit être un nombre entier.";
    } else {
        $age = (int) $age;
        if ($age < 16 || $age > 40) {
            $erreurs[] = "L'âge doit être compris entre 16 et 40 ans.";
        }
    }

    if ($moyenne === '') {
        $erreurs[] = "La moyenne est obligatoire.";
    } elseif (!is_numeric($moyenne)) {
        $erreurs[] = "La moyenne doit être un nombre.";
    } else {
        $moyenne = (float) $moyenne;
        if ($moyenne < 0 || $moyenne > 20) {
            $erreurs[] = "La moyenne doit être comprise entre 0 et 20.";
        }
    }

    return [
        "erreurs" => $erreurs,
        "valeurs" => [
            "nom" => $nom,
            "prenom" => $prenom,
            "age" => $age,
            "formation" => $formation,
            "moyenne" => $moyenne,
        ],
    ];
}

// ---------- Affichage HTML ----------

function afficherEntete($titre, $racine = '')
{
    echo "<!DOCTYPE html>\n<html lang=\"fr\">\n<head>\n<meta charset=\"UTF-8\">\n";
    echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n";
    echo "<title>" . echapper($titre) . "</title>\n";
    echo "<link rel=\"stylesheet\" href=\"{$racine}css/style.css\">\n</head>\n<body>\n";
    echo "<h1>" . echapper($titre) . "</h1>\n";
}

function afficherMenu($racine = '')
{
    echo "<nav>";
    echo "<a href=\"{$racine}index.php\">Liste des étudiants</a>";
    echo "<a href=\"{$racine}ajouter.php\">Ajouter un étudiant</a>";
    echo "<a href=\"{$racine}rechercher.php\">Rechercher un étudiant</a>";
    echo "</nav>\n";
}

function afficherPied()
{
    echo "</body>\n</html>\n";
}

function afficherErreurs($erreurs)
{
    if (count($erreurs) > 0) {
        echo "<div class=\"erreurs\">";
        foreach ($erreurs as $erreur) {
            echo "<p>" . echapper($erreur) . "</p>";
        }
        echo "</div>";
    }
}

function afficherFormulaire($valeurs, $action, $texteBouton, $id = null)
{
    ?>
    <form method="POST" action="<?= echapper($action) ?>">
        <?php if ($id !== null): ?>
            <input type="hidden" name="id" value="<?= (int) $id ?>">
        <?php endif; ?>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?= echapper($valeurs['nom'] ?? '') ?>">

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?= echapper($valeurs['prenom'] ?? '') ?>">

        <label for="age">Âge :</label>
        <input type="number" id="age" name="age" value="<?= echapper($valeurs['age'] ?? '') ?>">

        <label for="formation">Formation :</label>
        <input type="text" id="formation" name="formation" value="<?= echapper($valeurs['formation'] ?? '') ?>">

        <label for="moyenne">Moyenne :</label>
        <input type="number" id="moyenne" name="moyenne" step="0.01" value="<?= echapper($valeurs['moyenne'] ?? '') ?>">

        <br>
        <button type="submit"><?= echapper($texteBouton) ?></button>
    </form>
    <?php
}

function afficherFiche($etudiant, $titre = "Étudiant enregistré")
{
    $res = resultat($etudiant['moyenne']);
    $classe = $res === "Admis" ? "admis" : "ajourne";
    echo "<div class=\"fiche\">";
    echo "<h2>" . echapper($titre) . "</h2>";
    echo "<p>Nom : " . echapper($etudiant['nom']) . "</p>";
    echo "<p>Prénom : " . echapper($etudiant['prenom']) . "</p>";
    echo "<p>Âge : " . (int) $etudiant['age'] . " ans</p>";
    echo "<p>Formation : " . echapper($etudiant['formation']) . "</p>";
    echo "<p>Moyenne : " . echapper($etudiant['moyenne']) . " / 20</p>";
    echo "<p>Résultat : <span class=\"$classe\">$res</span></p>";
    echo "</div>";
}

function afficherTableau($etudiants, $avecActions = false)
{
    if (count($etudiants) === 0) {
        echo "<p>Aucun étudiant.</p>";
        return;
    }
    echo "<table>";
    echo "<tr><th>Nom</th><th>Prénom</th><th>Âge</th><th>Formation</th><th>Moyenne</th><th>Résultat</th>";
    if ($avecActions) {
        echo "<th>Actions</th>";
    }
    echo "</tr>";
    foreach ($etudiants as $e) {
        $res = resultat($e['moyenne']);
        $classe = $res === "Admis" ? "admis" : "ajourne";
        echo "<tr>";
        echo "<td>" . echapper($e['nom']) . "</td>";
        echo "<td>" . echapper($e['prenom']) . "</td>";
        echo "<td>" . (int) $e['age'] . "</td>";
        echo "<td>" . echapper($e['formation']) . "</td>";
        echo "<td>" . echapper($e['moyenne']) . "</td>";
        echo "<td class=\"$classe\">$res</td>";
        if ($avecActions) {
            echo "<td>";
            echo "<a href=\"modifier.php?id=" . (int) $e['id'] . "\">Modifier</a> ";
            echo "<form class=\"inline\" method=\"POST\" action=\"supprimer.php\" onsubmit=\"return confirm('Supprimer cet étudiant ?');\">";
            echo "<input type=\"hidden\" name=\"id\" value=\"" . (int) $e['id'] . "\">";
            echo "<button type=\"submit\">Supprimer</button>";
            echo "</form>";
            echo "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
