<?php
session_start();

$array_words = ["felino", "chocolate", "desarrollo", "agua", "monitor"];

function chooseWord($array_words) {
    return $array_words[array_rand($array_words)];
}

function showLetter() {
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

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["word"])) {
    $word = strtoupper($_POST["word"]); 

    $char_in_word = false;

    for ($i = 0; $i < count($_SESSION["hidden_word"]); $i++) {
        if (strtoupper($_SESSION["hidden_word"][$i]) == $word) {
            if ($_SESSION["guessed_letters"][$i]) {
                echo "La letra '$word' ya ha sido adivinada. Intenta con otra.";
            } else {
                $_SESSION["guessed_letters"][$i] = true;
                $char_in_word = true;
                echo "Bien hecho! Has adivinado la letra '$word'.";
            }
        }
    }

    if (!$char_in_word) {
        echo "La letra '$word' no está en la palabra. Intentalo de nuevo.";
        $_SESSION["remaining_attempts"]--;
    }

    if ($_SESSION["remaining_attempts"] <= 0) {
        echo "<p>Oh no!! Has agotado todos los intentos. La palabra era " . implode("", $_SESSION["hidden_word"]) . ".</p>";
        session_destroy();
    } elseif (!in_array(false, $_SESSION["guessed_letters"])) {
        echo "<p>Felicidades!! Has adivinado la palabra.</p>";
        session_destroy();
    }
}

if (isset($_POST["reset"])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

echo "<p>Palabra: " . showLetter() . "</p>";
echo "<p>Letras adivinadas: " . implode(', ', array_keys($_SESSION["guessed_letters"], true)) . "</p>";
echo "<p>Intentos restantes: " . $_SESSION["remaining_attempts"] . "</p>";

require_once('index.php');
?>
