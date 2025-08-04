 <?php
/*
ANSAL  MUHAMMED
21 APRIL 2023
WEBD2201
*/
// This Defines variables for page content
$file = "template.php";
$date = "21-04-2023";
$title = "Rog's WEB2023 Template";
$description = "For Web2023, this is the Bonus Lab page";
$banner = "Bonus Lab ";

// Include header file
include("./header.php");

?>

<?php
// Include the functions.php file
require_once 'functions.php';

// Initialize session for storing score and question number
session_start();

// Check if the page was accessed using a GET request
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Reset session data
    $_SESSION['score'] = 0;
    $_SESSION['questionNumber'] = 1;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if "Retake Quiz" button is pressed
    if (isset($_POST['retakeQuiz'])) {
        // Redirect to template.php
        header('Location: template.php');
        exit;
    }

    // Get user's answer from form
    $answer = $_POST['answer'];
    // Get correct answer from session
    $correctAnswer = $_SESSION['correctAnswer'];

    // Check if user's answer is correct
    if ($answer == $correctAnswer) {
        // Increment score
        $_SESSION['score']++;
        $message = "Correct!";
    } else {
        $message = "Incorrect. The correct answer is $correctAnswer";
    }

    // Increment question number
    $_SESSION['questionNumber']++;

    // Check if all questions are answered
    if ($_SESSION['questionNumber'] > 5) {
        // Set a flag to indicate quiz completion
        $quizCompleted = true;
    } else {
        // Generate new question
        $num1 = randdigit();
        $num2 = randdigit();
        $operator = randop();
        $correctAnswer = evaluate($num1, $num2, $operator);
        $_SESSION['correctAnswer'] = $correctAnswer;
    }
} else {
    // Generate first question
    $num1 = randdigit();
    $num2 = randdigit();
    $operator = randop();
    $correctAnswer = evaluate($num1, $num2, $operator);
    $_SESSION['correctAnswer'] = $correctAnswer;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Math Quiz</title>
</head>
<body>
    <h1>Math Quiz</h1>
    <?php if(isset($message)) echo "<p>$message</p>"; ?>
    <?php if(isset($quizCompleted) && $quizCompleted) { ?>
        <h2>Quiz Completed!</h2>
        <p>Your Score: <?php echo $_SESSION['score']; ?>/5</p>
        <form method="post" action="">
            <input type="submit" name="retakeQuiz" value="Retake Quiz">
        </form>
    <?php } else { ?>
        <p>Question <?php echo $_SESSION['questionNumber']; ?>: What is <?php echo $num1 . " " . $operator . " " . $num2 . "?"; ?></p>
        <form method="post" action="">
            <input type="number" name="answer" required>
            <input type="submit" value="Submit">
        </form>
    <?php } ?>
</body>
</html>

<?php

include ("./footer.php");

?>