<?php 
session_start(); // Start session to store data

function cleanText($text) {
    $text = strtolower($text);
    $text = preg_replace("/[\p{P}]/u", "", $text);
    return $text;
}

function getWordFrequency($text) {
    $stopWords = ["the", "and", "in", "of", "to", "a", "is", "it", "that", "on", "for", "with", "as", "was", "at", "by", "an", "be", "this", "which", "or", "from", "but", "not", "are", "were", "has", "had", "have", "they", "you", "we", "can", "will", "their"];
    
    $text = cleanText($text);
    $words = explode(" ", $text);
    
    $wordCount = [];
    foreach ($words as $word) {
        $word = trim($word);
        if ($word !== "" && !in_array($word, $stopWords)) {
            $wordCount[$word] = ($wordCount[$word] ?? 0) + 1;
        }
    }
    
    return $wordCount;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = $_POST['text'] ?? '';
    $sortOrder = $_POST['sort'] ?? 'desc';
    $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 10;

    if (!empty($text)) {
        $wordFrequency = getWordFrequency($text);
        
        // Sort results
        if ($sortOrder === "asc") {
            asort($wordFrequency);
        } else {
            arsort($wordFrequency);
        }
        
        // Limit results
        $wordFrequency = array_slice($wordFrequency, 0, $limit, true);

        // Store results in session
        $_SESSION['wordFrequency'] = $wordFrequency;

        // Redirect to result.php
        header("Location: result.php");//This is file location whereas user can see some of the result and interface.
        exit();
    } else {//This else statement is where if the user tries to not inputting a information but clicking the button.
        $_SESSION['error'] = "Please enter some text to analyze.";//Error Message
        header("Location: index.php");
        exit();
    }
}
?>
