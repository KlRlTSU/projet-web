<?php
// Charger les quiz existants
$quizData = file_exists("quiz.json") ? json_decode(file_get_contents("quiz.json"), true) : [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Quiz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Gestion des Quiz</h2>
        <h3>Quiz disponibles :</h3>
        

        <?php
// Charger les quiz depuis quiz.json
$quizData = file_exists("quiz.json") ? json_decode(file_get_contents("quiz.json"), true) : [];

// Vérifier s'il y a des quiz
if (empty($quizData)) {
    echo "<p>Aucun quiz disponible.</p>";
} else {
    echo "<h2>Liste des Quiz</h2>";
    echo "<ul>";
    foreach ($quizData as $quizId => $quiz) {
        echo "<li>";
        echo "<strong>" . htmlspecialchars($quiz["nom"]) . "</strong> ";
        
        // Bouton Modifier
        echo "<a href='creer_quiz.php?quiz_id=$quizId'>✏ Modifier</a> | ";

        // Bouton Voir Résultats (uniquement si le quiz est "terminé")
        if (isset($quiz["etat"]) && $quiz["etat"] === "termine") {
            echo "<a href='resultats.php?quiz_id=$quizId'>📊 Voir Résultats</a> | ";
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



        <h3>Créer un nouveau quiz :</h3>
        <form action="nouveau_quiz.php" method="POST">
            <label>Nom du Quiz :</label>
            <input type="text" name="nom_quiz" required>
            <button type="submit">Créer</button>
        </form>
    </div>
</body>
</html>
