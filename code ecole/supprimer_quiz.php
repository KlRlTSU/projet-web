<?php
// Vérifier si l'ID du quiz est fourni
$quizId = $_GET["quiz_id"] ?? null;

if (!$quizId) {
    die("❌ Erreur : Aucun quiz spécifié !");
}

// Charger les quiz existants
$quizData = file_exists("quiz.json") ? json_decode(file_get_contents("quiz.json"), true) : [];

// Vérifier si le quiz existe
if (!isset($quizData[$quizId])) {
    die("❌ Erreur : Quiz introuvable !");
}

// Supprimer le quiz de la liste
unset($quizData[$quizId]);

// Sauvegarder les modifications
file_put_contents("quiz.json", json_encode($quizData, JSON_PRETTY_PRINT));

// Rediriger vers le hub
header("Location: hub.php");
exit;
?>
