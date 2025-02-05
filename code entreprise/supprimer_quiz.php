<?php
// Vérifier si l'ID du quiz est fourni
$quizId = $_GET["quiz_id"] ?? null;

if (!$quizId) {
    die("❌ Erreur : Aucun quiz spécifié !");
}

// Charger les quiz existants
$quizData = file_exists("quiz.json") ? json_decode(file_get_contents("quiz.json"), true) : [];
$resultatsData = file_exists("resultats.json") ? json_decode(file_get_contents("resultats.json"), true) : [];

// Vérifier si le quiz existe
if (!isset($quizData[$quizId])) {
    die("❌ Erreur : Quiz introuvable !");
}

// Supprimer le quiz de la liste
unset($quizData[$quizId]);

// Supprimer les réponses associées au quiz
unset($resultatsData[$quizId]);

// Sauvegarder les modifications dans quiz.json
file_put_contents("quiz.json", json_encode($quizData, JSON_PRETTY_PRINT));

// Sauvegarder les modifications dans resultats.json
file_put_contents("resultats.json", json_encode($resultatsData, JSON_PRETTY_PRINT));

// Rediriger vers le hub
header("Location: dashboard_entreprise.php");
exit;
?>
