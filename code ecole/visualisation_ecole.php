<?php
$quizId = "quiz_id_1";
$resultats = file_exists("resultats.json") ? json_decode(file_get_contents("resultats.json"), true) : [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Résultats du Quiz</title>
</head>
<body>
    <h2>Résultats du Quiz</h2>
    <ul>
        <?php foreach ($resultats[$quizId] as $r) : ?>
            <li><?= htmlspecialchars($r["nom"]) ?> : <?= $r["note"] ?> points</li>
        <?php endforeach; ?>
    </ul>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        color: #333;
    }
    form {
        max-width: 600px;
        margin: auto;
        padding: 20px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }
    input, select, textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }
    .activites-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    justify-content: flex-start;
    }

    .activite-item {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    }
    </style>
</body>
</html>
