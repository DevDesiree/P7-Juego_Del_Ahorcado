<?php

require_once('game.php');
$messages = processGuess();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego del Ahorcado</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container_game">
        <h1>Hangman Game</h1>
        <div class="info_game">
            <?php
            echo "<p class='choosen_word'>Palabra: " . showLetter() . "</p>";
            echo "<p class='remaining_attemps_text'>Intentos restantes: " . $_SESSION["remaining_attempts"] . "</p>";
            ?>
        </div>
        <div class="message_alerts">
            <?php
            echo $messages;
            ?>
        </div>

        <div class="container_picture_hangman">
            <?php echo displayHangman($_SESSION["remaining_attempts"]); ?>
        </div>

        <form action="game.php" class="form_game" method="POST">

            <div class="buttons_game">
                <button type="submit" name="word" value="A">A</button>
                <button type="submit" name="word" value="B">B</button>
                <button type="submit" name="word" value="C">C</button>
                <button type="submit" name="word" value="D">D</button>
                <button type="submit" name="word" value="E">E</button>
                <button type="submit" name="word" value="F">F</button>
                <button type="submit" name="word" value="G">G</button>
                <button type="submit" name="word" value="H">H</button>
                <button type="submit" name="word" value="I">I</button>
                <button type="submit" name="word" value="J">J</button>
                <button type="submit" name="word" value="K">K</button>
                <button type="submit" name="word" value="L">L</button>
                <button type="submit" name="word" value="M">M</button>
                <button type="submit" name="word" value="N">N</button>
                <button type="submit" name="word" value="O">O</button>
                <button type="submit" name="word" value="P">P</button>
                <button type="submit" name="word" value="Q">Q</button>
                <button type="submit" name="word" value="R">R</button>
                <button type="submit" name="word" value="S">S</button>
                <button type="submit" name="word" value="T">T</button>
                <button type="submit" name="word" value="U">U</button>
                <button type="submit" name="word" value="V">V</button>
                <button type="submit" name="word" value="W">W</button>
                <button type="submit" name="word" value="X">X</button>
                <button type="submit" name="word" value="Y">Y</button>
                <button type="submit" name="word" value="Z">Z</button>
            </div>

            <button type="submit" class="reset_btn" name="reset" value="reset">Reiniciar Juego</button>

        </form>
    </div>


</body>

</html>