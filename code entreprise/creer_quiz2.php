<?php
// Charger les quiz existants
$quizData = file_exists("quiz.json") ? json_decode(file_get_contents("quiz.json"), true) : [];
$quizId = "quiz_id_1"; // À changer dynamiquement selon le contexte
$questions = isset($quizData[$quizId]["questions"]) ? $quizData[$quizId]["questions"] : [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Créer un Quiz</title>
</head>
<body>
    <div class="container">
    <?php
// Vérifier si quiz.json existe et le charger
$quizData = file_exists("quiz.json") ? json_decode(file_get_contents("quiz.json"), true) : [];

// Vérifier si un ID de quiz est passé en paramètre
$quizId = $_GET["quiz_id"] ?? null;

if (!$quizId || !isset($quizData[$quizId])) {
    die("❌ Erreur : Quiz introuvable ou ID non spécifié !");
}

// Récupérer les données du quiz
$quiz = $quizData[$quizId] ?? null;

// Vérifier que le quiz a bien été trouvé
if (!$quiz) {
    die("❌ Erreur : Impossible de charger ce quiz !");
}

$questions = $quiz["questions"] ?? [];
?>


<h2>Modifier le Quiz : <?= htmlspecialchars($quiz["nom"]) ?></h2>

<h3>Questions existantes :</h3>
<ul>
    <?php foreach ($questions as $index => $question) : ?>
        <li>
            <strong><?= htmlspecialchars($question["question"]) ?></strong>
            (<?= $question["points"] ?> points)
            
            <?php if ($question["type"] === "qcm") : ?>
                <ul>
                    <?php foreach ($question["reponses"] as $key => $reponse) : ?>
                        <li <?= ($key == $question["bonne_reponse"]) ? 'style="font-weight: bold; color: green;"' : '' ?>>
                            <?= htmlspecialchars($reponse) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p style="color: blue;">📝 Question à réponse libre</p>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>




<h3>Ajouter une question :</h3>
<form action="ajouter_question2.php" method="POST">
    <input type="hidden" name="quiz_id" value="<?= htmlspecialchars($quizId) ?>">

    <label>Question :</label>
    <input type="text" name="question" required>

    <label>Type de question :</label>
    <select name="type_question" id="type_question" onchange="toggleReponses()">
        <option value="qcm">QCM</option>
        <option value="libre">Réponse libre</option>
    </select>

    <div id="qcm_section">
        <label>Réponses (séparées par un `;`) :</label>
        <input type="text" name="reponses">

        <label>Indice de la bonne réponse (0,1,2...) :</label>
        <input type="number" name="bonne_reponse">
    </div>

    <label>Points :</label>
    <input type="number" name="points" required>

    <button type="submit">Ajouter</button>
</form>

<script>
    function toggleReponses() {
        var type = document.getElementById("type_question").value;
        document.getElementById("qcm_section").style.display = (type === "qcm") ? "block" : "none";
    }
    toggleReponses(); // Pour masquer la section QCM par défaut si besoin
</script>



<form action="finaliser_quiz2.php" method="POST">
    <input type="hidden" name="quiz_id" value="<?= htmlspecialchars($quizId) ?>">
    <button type="submit">Finaliser le Quiz</button>
</form>

    
    </div>
</body>
</html>
