<?php
// Charger les quiz existants
$quizData = file_exists("quiz.json") ? json_decode(file_get_contents("quiz.json"), true) : [];
// Charger les résultats des quiz
$resultatsData = file_exists("resultats.json") ? json_decode(file_get_contents("resultats.json"), true) : [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Entreprise</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>📊 Dashboard Entreprise</h2>

        <h3>📌 Vos Quiz :</h3>

        <?php
        if (empty($quizData)) {
            echo "<p>Aucun quiz disponible.</p>";
        } else {
            echo "<ul>";
            foreach ($quizData as $quizId => $quiz) {
                echo "<li>";
                echo "<strong>" . htmlspecialchars($quiz["nom"]) . "</strong> ";
                
                // Affichage du statut du quiz
                echo "<br>📌 Statut : <strong>" . htmlspecialchars($quiz["etat"]) . "</strong> ";

                // Nombre de réponses
                $nombreReponses = isset($resultatsData[$quizId]) ? count($resultatsData[$quizId]["participants"]) : 0;
                echo "<br>📊 Nombre de réponses : <strong>$nombreReponses</strong>";

                echo "<br>";

                // Bouton Modifier
                echo "<a href='creer_quiz2.php?quiz_id=$quizId'>✏ Modifier</a> | ";

                // Bouton Voir Résultats (uniquement si le quiz est "terminé")
                if (isset($quiz["etat"]) && $quiz["etat"] === "termine") {
                    echo "<a href='resultats2.php?quiz_id=$quizId'>📊 Voir Résultats</a> | ";
                } else {
                    echo "<span style='color:gray;'>📊 Résultats indisponibles</span> | ";
                }

                // Bouton Supprimer (avec confirmation en JS)
                echo "<a href='supprimer_quiz.php?quiz_id=$quizId' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce quiz ?\")' style='color:red;'>🗑 Supprimer</a>";

                echo "</li>";
            }
            echo "</ul>";
        }
        ?>

        <h3>➕ Créer un nouveau quiz :</h3>
        <form action="nouveau_quiz.php" method="POST">
            <label>Nom du Quiz :</label>
            <input type="text" name="nom_quiz" required>
            <button type="submit">Créer</button>
        </form>
    </div>
</body>
</html>