<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomQuiz = trim($_POST["nom_quiz"]);
    
    if (!empty($nomQuiz)) {
        $quizData = file_exists("quiz.json") ? json_decode(file_get_contents("quiz.json"), true) : [];
        
        // Générer un ID unique
        $quizId = "quiz_" . time();
        
        // Ajouter le quiz
        $quizData[$quizId] = [
            "nom" => $nomQuiz,
            "etat" => "en cours",
            "questions" => []
        ];
        
        file_put_contents("quiz.json", json_encode($quizData, JSON_PRETTY_PRINT));
    }
}

header("Location: dashboard_entreprise.php");
?>
