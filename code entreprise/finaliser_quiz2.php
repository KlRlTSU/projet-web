<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quizId = $_POST["quiz_id"];

    $quizData = file_exists("quiz.json") ? json_decode(file_get_contents("quiz.json"), true) : [];

    if (isset($quizData[$quizId])) {
        $quizData[$quizId]["etat"] = "termine";
        file_put_contents("quiz.json", json_encode($quizData, JSON_PRETTY_PRINT));
    }
}

header("Location: dashboard_entreprise.php");
exit;
?>
