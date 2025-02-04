<?php
// Charger les données
$quizData = file_exists("quiz.json") ? json_decode(file_get_contents("quiz.json"), true) : [];
$resultatsData = file_exists("resultats.json") ? json_decode(file_get_contents("resultats.json"), true) : [];

$quizId = $_GET["quiz_id"] ?? null;

// Vérifier que le quiz existe
if (!$quizId || !isset($quizData[$quizId])) {
    die("❌ Erreur : Quiz introuvable !");
}

$quiz = $quizData[$quizId];
$participants = $resultatsData[$quizId] ?? [];

echo "<h2>Résultats du Quiz : " . htmlspecialchars($quiz["nom"]) . "</h2>";

if (empty($participants)) {
    echo "<p>Aucun participant pour ce quiz.</p>";
} else {
    echo "<table border='1'>";
    echo "<tr><th>Nom</th><th>Score</th></tr>";
    foreach ($participants as $participant) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($participant["nom"]) . "</td>";
        echo "<td>" . htmlspecialchars($participant["score"]) . " points</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>
