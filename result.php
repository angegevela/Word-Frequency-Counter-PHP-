<?php 
session_start();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Word Frequency Results</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Word Frequency Results</h1>
    
    <?php
    if (isset($_SESSION['wordFrequency'])) {
        echo "<table border='1'><tr><th>Word</th><th>Frequency</th></tr>";
        foreach ($_SESSION['wordFrequency'] as $word => $count) {
            echo "<tr><td>" . htmlspecialchars($word) . "</td><td>" . $count . "</td></tr>";
        }
        echo "</table>";

        // Clear session data after displaying
        unset($_SESSION['wordFrequency']);
    } else {
        echo "<p>No results available.</p>";
    }
    ?>

    <br><a href="index.php">Go Back</a>