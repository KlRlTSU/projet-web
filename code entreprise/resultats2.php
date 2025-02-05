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
$participants = $resultatsData[$quizId]["participants"] ?? [];

echo "<h2>📊 Résultats du Quiz : " . htmlspecialchars($quiz["nom"]) . "</h2>";

if (empty($participants)) {
    echo "<p>Aucun participant pour ce quiz.</p>";
} else {
    echo "<h3>📌 Participants :</h3>";
    echo "<table border='1'>";
    echo "<tr><th>Nom</th><th>Score</th></tr>";
    foreach ($participants as $participant) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($participant["nom"]) . "</td>";
        echo "<td>" . htmlspecialchars($participant["score"]) . " points</td>";
        echo "</tr>";
    }
    echo "</table>";

    echo "<h3>📌 Statistiques des réponses :</h3>";

    foreach ($quiz["questions"] as $index => $question) {
        echo "<h4>Q" . ($index + 1) . ": " . htmlspecialchars($question["question"]) . "</h4>";

        // Vérifier si la question est un QCM
        if ($question["type"] == "qcm") {
            $totalVotes = count($participants);
            $reponseStats = array_fill(0, count($question["reponses"]), 0);

            // Compter le nombre de votes pour chaque réponse
            foreach ($participants as $participant) {
                if (isset($participant["reponses"][$index])) {
                    $choix = $participant["reponses"][$index];
                    if (isset($reponseStats[$choix])) {
                        $reponseStats[$choix]++;
                    }
                }
            }

            // Afficher les statistiques sous forme de liste
            echo "<ul>";
            foreach ($question["reponses"] as $key => $reponse) {
                $pourcentage = ($totalVotes > 0) ? round(($reponseStats[$key] / $totalVotes) * 100, 2) : 0;
                $isCorrect = ($key == $question["bonne_reponse"]) ? "✔" : "❌";
                echo "<li>$isCorrect " . htmlspecialchars($reponse) . " - <strong>$pourcentage%</strong></li>";
            }
            echo "</ul>";

        } elseif ($question["type"] == "libre") {
            // Pour les réponses libres, afficher les différentes réponses des participants
            echo "<ul>";
            foreach ($participants as $participant) {
                $reponseLibre = $participant["reponses"][$index] ?? "Aucune réponse";
                echo "<li><strong>" . htmlspecialchars($participant["nom"]) . " :</strong> " . htmlspecialchars($reponseLibre) . "</li>";
            }
            echo "</ul>";
        }
    }
}

// Ajouter un bouton pour revenir au dashboard_entreprise.php
echo '<br><br>';
echo '<a href="dashboard_entreprise.php"><button>Retour au Dashboard</button></a>';
?>
