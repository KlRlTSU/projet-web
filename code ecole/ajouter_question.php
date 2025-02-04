<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quizId = $_POST["quiz_id"];
    $question = trim($_POST["question"]);
    $reponses = explode(";", trim($_POST["reponses"]));
    $bonneReponse = (int) $_POST["bonne_reponse"];
    $points = (int) $_POST["points"];

    if (!empty($question) && count($reponses) > 1) {
        $quizData = file_exists("quiz.json") ? json_decode(file_get_contents("quiz.json"), true) : [];

        if (isset($quizData[$quizId])) {
            // Ajouter la question
            $quizData[$quizId]["questions"][] = [
                "question" => $question,
                "reponses" => $reponses,
                "bonne_reponse" => $bonneReponse,
                "points" => $points
            ];

            // Sauvegarde dans quiz.json
            file_put_contents("quiz.json", json_encode($quizData, JSON_PRETTY_PRINT));
        }
    }
}

// Retour à la page de modification
header("Location: creer_quiz.php?quiz_id=" . urlencode($quizId));
exit;
?>
