<?php
// Charger les données existantes
$quizData = file_exists("quiz.json") ? json_decode(file_get_contents("quiz.json"), true) : [];

$quizId = $_POST["quiz_id"] ?? null;
$question = trim($_POST["question"] ?? "");
$type_question = $_POST["type_question"] ?? "qcm"; // Par défaut, QCM
$points = intval($_POST["points"] ?? 1);

if (!$quizId || !$question) {
    die("❌ Erreur : Données invalides !");
}

// Création de la question
$nouvelleQuestion = [
    "question" => $question,
    "type" => $type_question, // "qcm" ou "libre"
    "points" => $points
];

if ($type_question === "qcm") {
    $reponses = explode(";", $_POST["reponses"] ?? "");
    $bonne_reponse = intval($_POST["bonne_reponse"] ?? -1);

    if (empty($reponses) || $bonne_reponse < 0 || $bonne_reponse >= count($reponses)) {
        die("❌ Erreur : Réponses invalides pour QCM !");
    }

    $nouvelleQuestion["reponses"] = array_map("trim", $reponses);
    $nouvelleQuestion["bonne_reponse"] = $bonne_reponse;
} else {
    // Réponse libre : pas de réponses prédéfinies
    $nouvelleQuestion["reponses"] = []; // Vide pour une réponse libre
}

// Ajouter la question au quiz
$quizData[$quizId]["questions"][] = $nouvelleQuestion;

// Sauvegarder
file_put_contents("quiz.json", json_encode($quizData, JSON_PRETTY_PRINT));

echo "✅ Question ajoutée avec succès !";

echo "<br><br>";
echo "<a href='creer_quiz2.php?quiz_id=" . htmlspecialchars($quizId) . "'>
        <button>Revenir à la modification du quiz</button>
      </a>";

?>
