<?php
session_start();

$array_words = ["felino", "chocolate", "desarrollo", "agua", "monitor"];

function chooseWord($array_words)
{
    $chosenWord = $array_words[array_rand($array_words)];
    return strtoupper($chosenWord);
}

function showLetter()
{
    $word_show = "";
    $guessed_letters = $_SESSION["guessed_letters"];
    $hidden_word = $_SESSION["hidden_word"];

    foreach ($hidden_word as $i => $letter) {
        if ($guessed_letters[$i]) {
            $word_show .= $letter . " ";
        } else {
            $word_show .= "_ ";
        }
    }
    return trim($word_show);
}

if (!isset($_SESSION["hidden_word"])) {
    $_SESSION["hidden_word"] = str_split(chooseWord($array_words));
    $_SESSION["guessed_letters"] = array_fill(0, count($_SESSION["hidden_word"]), false);
    $_SESSION["remaining_attempts"] = 6;
}

function processGuess()
{
    $messages = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["word"])) {
        $word = strtoupper($_POST["word"]);

        $char_in_word = false;
        $letter_already_guessed = false;

        for ($i = 0; $i < count($_SESSION["hidden_word"]); $i++) {
            if (strtoupper($_SESSION["hidden_word"][$i]) == $word) {
                if ($_SESSION["guessed_letters"][$i]) {
                    $letter_already_guessed = true;
                } else {
                    $_SESSION["guessed_letters"][$i] = true;
                    $char_in_word = true;
                }
            }
        }

        if ($char_in_word && !$letter_already_guessed) {
            $messages .= "<p class='sucess_char_message'>Bien hecho! Has adivinado la letra '$word'. </p>";
        } elseif ($letter_already_guessed) {
            $messages .= "<p class='same_char_message'>La letra '$word' ya ha sido adivinada. Intenta con otra.</p>";
        } else {
            $messages .= "<p class='fail_char_message'>La letra '$word' no está en la palabra. Inténtalo de nuevo.</p>";
            $_SESSION["remaining_attempts"]--;
        }

        if ($_SESSION["remaining_attempts"] <= 0) {
            $messages .= "<p class='lose_message'>Has agotado todos los intentos!! La palabra era " . implode("", $_SESSION["hidden_word"]) . ".</p>";
            session_destroy();
        } elseif (!in_array(false, $_SESSION["guessed_letters"])) {
            $messages .= "<p class='win_message'>Felicidades!! Has adivinado la palabra 😄.</p>";
            session_destroy();
        }
    }
    return $messages;
}

function displayHangman($remaining_attempts)
{
    $hangman_display = "";

    switch ($remaining_attempts) {
        case 6:
            $hangman_display .= "<img src='img\hangman0.png'><br>";
            break;
        case 5:
            $hangman_display .= "<img src='img\hangman1.png''><br>";
            break;
        case 4:
            $hangman_display .= "<img src='img\hangman2.png''><br>";
            break;
        case 3:
            $hangman_display .= "<img src='img\hangman3.png''><br>";
            break;
        case 2:
            $hangman_display .= "<img src='img\hangman4.png''><br>";
            break;
        case 1:
            $hangman_display .= "<img src='img\hangman5.png''><br>";
            break;
        case 0:
            $hangman_display .= "<img src='img\hangman6.png''><br>";
            break;
        default:
            $hangman_display .= "<img src='img\hangman0.png''><br>";
            break;
    }


    return $hangman_display;
}

if (isset($_POST["reset"])) {
    session_destroy();
    header("Location: index.php");
}


require_once('index.php');
