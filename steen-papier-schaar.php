<?php
# we beginnen met een functie die de sessie start
session_start();

if (!isset($_SESSION['round'])) {
    $_SESSION['round'] = 1;
}

if (!isset($_SESSION['scoreA'])) {
    $_SESSION['scoreA'] = 0;
}

if (!isset($_SESSION['scoreB'])) {
    $_SESSION['scoreB'] = 0;
}
# deze functie kijkt wat de computer/AI kiest
function generateAIChoice()
{
    $choices = ["rock", "paper", "scissor"];
    return $choices[array_rand($choices)];
}

// Deze functie verwerkt het hele spel
function processGame($userChoice, $aiChoice)
{
    $resultString = "Mijn Keuze: $userChoice, AI's keuze: $aiChoice. ";

    if (!isset($_SESSION['Points'])) {
        $_SESSION['Points'] = 0;
    }

    if ($userChoice === $aiChoice) {
        $_SESSION['Points'] += 0;
        $_SESSION['scoreA'] += 0; 
        $_SESSION['scoreB'] += 0; 
        echo "<script>updateScores('Gelijkspel', 0, {$_SESSION['Points']});</script>";
        return $resultString . "Gelijkspel";
    } elseif (
        ($userChoice === "rock" && $aiChoice === "scissor") ||
        ($userChoice === "paper" && $aiChoice === "rock") ||
        ($userChoice === "scissor" && $aiChoice === "paper")
    ) {
        $_SESSION['Points'] += 3;
        $_SESSION['scoreA'] += 3; 
        echo "<script>updateScores('Gewonnen', 3, {$_SESSION['Points']});</script>";
        return $resultString . "Je hebt gewonnen!" . " punten " . $_SESSION['Points'];
    } else {
        $_SESSION['Points'] -= 1;
        $_SESSION['scoreB'] += 1; 
        echo "<script>updateScores('Verloren', -1, {$_SESSION['Points']});</script>";
        // return $resultString . "Je hebt verloren!." . " punten " . $_SESSION['Points'];
    }
}
// deze functie geeft het eind resultaat aan
function displayFinalResult()
{
    $winMessage = ($_SESSION['scoreA'] > $_SESSION['scoreB']) ? "Je hebt gewonnen!" : "Je hebt verloren.";
    echo "<h2 id='result'>$winMessage</h2>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steen, papier schaar</title>
    <link rel="stylesheet" href="steen-papier-schaar.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url(trial.png);
            background-size: cover;
            color: white;
        }
    </style>
</head>

<body class="custom-body">
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
            <p>Welkom bij Steen, papier schaar</p>
            <form action="">
                <p>Hier is de uitleg</p>
                <ul>
                    <li>De punten zie je wanneer je klikt op 1 van de foto's</li>
                    <li>Je hebt 3 kansen</li>
                    <li>Als je 1x wint krijg je 3 punten</li>
                    <li>Als je verlies, verlies je 1 punt</li>
                    <li>na 3 pogingen wordt je terug verwezen naar de homepagina en als je opnieuw wilt spelen dan klik weer op het spel </li>
                </ul>
            </form>
        </aside>


    </main>

    <h5>Welcome bij Steen, papier schaar</h5>

    <?php
    if ($_SESSION['round'] <= 3) {
        if (isset($_POST['userChoice'])) {
            $_SESSION['userChoice'] = $_POST['userChoice'];
            $_SESSION['aiChoice'] = generateAIChoice();
            $result = processGame($_SESSION['userChoice'], $_SESSION['aiChoice']);
            echo "<div id='result'>$result</div>";

            $_SESSION['round']++;

            if ($_SESSION['round'] > 3) {
                displayFinalResult();
                session_destroy();
            }
        }
    }
    ?>
    <!-- Hier worden de rondes aangemaakt -->
    <?php if ($_SESSION['round'] <= 3) : ?>
        <div id="round">Ronde: <?php echo $_SESSION['round']; ?>/3</div>
        <div id="game-container">
            <div class="choice-container">
                <!-- Hiet worden je eigen keuzes gestuurd -->
                <h2>Mijn keuze</h2>
                <form method="post">
                    <button type="submit" name="userChoice" value="rock">
                        <img src="rock.png" alt="Rock">
                    </button>
                    <button type="submit" name="userChoice" value="paper">
                        <img src="paper.png" alt="Paper">
                    </button>
                    <button type="submit" name="userChoice" value="scissor">
                        <img src="scissor.png" alt="Scissor">
                    </button>
                </form>
            </div>
            <!--Dit zijn de keuzes van de computer/AI -->
            <div class="choice-container">
                <h2>AI's Keuze</h2>
                <?php
                if (isset($_SESSION['aiChoice'])) {
                    echo "<img src='{$_SESSION['aiChoice']}.png' alt='{$_SESSION['aiChoice']}'>";
                }
                ?>
            </div>
        </div>

    <?php endif; ?>
    <!-- button om terug te gaan -->
    <button type="button" name="goBack" id="goBackButton">Terug naar de homepagina</button>

    <footer>
        &copy; 2024 Casino. Gemaakt door: Abdi Hassan, Milan Waagmeester, Ference Eichenberger, Vaishnavi Thambippillai, and Tinoe Boom
    </footer>

    <script>
        document.getElementById("goBackButton").addEventListener("click", goBack);

        function goBack() {
            window.location.href = 'home.html';
        }
    </script>
</body>

</html>