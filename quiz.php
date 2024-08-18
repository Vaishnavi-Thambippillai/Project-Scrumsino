<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML & CSS Quiz</title>
    <link rel="stylesheet" href="quiz.css">
</head>

<body>

    <header>
        <h1>SCRUMSINO</h1>
        <img src="logo1.png" alt="Logo" />
    </header>

<!-- Dit is de navbar waar alle games mee zijn gelinkt -->
    <nav>
        <a class="selector" href="kop-of-munt.php">Kop of munt</a>
        <a class="selector" href="steen-papier-schaar.php">Steen, papier schaar</a>
        <a class="selector" href="galgje.php">Galgje</a>
        <a class="selector" href="boter-kaas-eieren.php">Boter, kaas en eieren</a>
        <a class="selector" href="quiz.php">Quiz</a>
    </nav>

    <main>
<!-- Dit is alle tekst in de aside  -->
        <aside>
            <form action="">
                <p>Welkom bij de quiz</p>
                <p>Hier is de uitleg</p>
                <ul>
                    <li>Je hebt 10 vragen met mulitple choice</li>
                    <li>Na dat je de 10 vragen hebt beantwoord krijg je meteen je resultaat te zien</li>
                    
                </ul>
            </form>
        </aside>

    </main>

    <?php
// dit zijn alle vragen van de game
    $questions = array(
        "Waar staat HTML voor?",
        "Welk element heb je nodig om een ​​ongeordende lijst te maken?",
        "Welk element heb je nodig om een ​​CSS-bestand in je HTML-bestand te koppelen",
        "Waar staat CSS voor?",
        "Welk element heb je nodig om een ​​geordende lijst te maken?",
        "Wat is het element voor een flexbox?",
        "Welke CSS-eigenschap wordt gebruikt om de tekstkleur in te stellen?",
        "Wat is de standaardweergavemodus voor de CSS-weergave-eigenschap?",
        "Welke CSS-eigenschap wordt gebruikt om de lettergrootte van tekst in te stellen?",
        "Wat is het doel van de CSS-eigenschap position: relative?",
    );

// Dit zijn je multiple choice antwoorden
    $choices = array(
        array("a" => "HyperText Markup Language", "b" => "High-Level Text Markup Language", "c" => "Home Tool Markup Language", "d" => "Hyperlink and Text Markup Language"),
        array("a" => "Ol", "b" => "Ul", "c" => "Id", "d" => "Class"),
        array("a" => "Type", "b" => "a", "c" => "Href", "d" => "Link"),
        array("a" => "Cruising style shoot", "b" => "Cascading Style Sheets", "c" => "Connect super shoot", "d" => "Cascading style sapjes"),
        array("a" => "Ul", "b" => "Css", "c" => "Ol", "d" => "Href"),
        array("a" => "Display-Flex", "b" => "Flex-Wrap", "c" => "Margin", "d" => "Font-size"),
        array("a" => "Font-Color", "b" => "Color", "c" => "Color++", "d" => "Color-weight"),
        array("a" => "Flex", "b" => "Weight", "c" => "Wrap", "d" => "Justify-Content"),
        array("a" => "Font-font", "b" => "Font", "c" => "Font-size", "d" => "Font-weight"),
        array("a" => "Left", "b" => "Right", "c" => "Bottom", "d" => "Top"),
    );
// dit zijn de goede antwoorden van de multiple choice
    $correct_answers = array("a", "b", "d", "b", "c", "a", "b", "a", "c", "a");
    $total_questions = count($questions);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $current_question = isset($_POST["current_question"]) ? $_POST["current_question"] : 1;
        $user_answer = isset($_POST["answer"]) ? $_POST["answer"] : null;
        $score = isset($_POST["score"]) ? $_POST["score"] : 0;

        if (!empty($user_answer) && $user_answer == $correct_answers[$current_question - 1]) {
            $score++;
        }

        if ($current_question < $total_questions) {
            $current_question++;
        } 
        // dit is de resultaat van hoeveel vragen je goed hebt
        else {
            echo "<h2>Resultaat:</h2>";
            echo "<p>Je hebt " . $score . " van de " . $total_questions . " vragen correct beantwoord.</p>";
        }
    } else {
        $current_question = 1;
        $score = 0;
    }
    ?>


    <?php
    for ($i = 0; $i < $total_questions; $i++) {
        $question_class = ($i + 1 == $current_question) ? "" : "hidden";
    ?>
        <form method="post" action="" class="question <?php echo $question_class; ?>">
            <p><strong>Vraag <?php echo ($i + 1); ?>:</strong> <?php echo $questions[$i]; ?></p>
            <?php
            foreach ($choices[$i] as $key => $value) {
                echo "<label><input type='radio' name='answer' value='" . $key . "'>" . $value . "</label><br>";
            }
            ?>
            <input type="hidden" name="current_question" value="<?php echo $current_question; ?>">
            <input type="hidden" name="score" value="<?php echo $score; ?>">
            <br>
            <input type="submit" value="Volgende vraag">
        </form>
    <?php } ?>

    <div class="button-container">
        <button onclick="resetGame()" class="golden-reset"> Reset</button>
        <button type="button" onclick="goBack()" id="goBackButton">Terug naar de homepagina</button>
    </div>

    <script>
        function goBack() {
            window.location.href = 'home.html';
        }
    </script>

    <footer>
        &copy; 2024 Casino. Gemaakt door: Abdi Hassan, Milan Waagmeester, Ference Eichenberger, Vaishnavi Thambippillai, and Tinoe Boom
    </footer>
</body>
</html>