<?php
session_start();
// symbolen van kop of munt
$symbols = ["head", "tail"];

if (!isset($_SESSION['points'])) {
    $_SESSION['points'] = 0;
}

$symbol = null;
$bet = null;
$win = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bet = isset($_POST['bet']) ? $_POST['bet'] : null;
    // hier wordt er een random selectie gemaakt van kop of munt
    $symbol = $symbols[array_rand($symbols)];

    // hier controleert het of de gok correct is en het berekent de winst
    if ($symbol == $bet) {
        $inputPoints = isset($_POST['points']) ? intval($_POST['points']) : 0;
        $win = $inputPoints * 2;
        $_SESSION['points'] += $win;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kop of munt</title>
    <link rel="stylesheet" href="kop-of-munt.css">
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
        <h1>Welkom bij Kop of munt</h1>

        <?php
        if ($symbol !== null) {
            echo "<p>Je hebt: $win punten</p>";
        }
        ?>

        <form method="post" onsubmit="flipCoin()">
            <label>
                <input type="radio" name="bet" value="head" <?php if ($bet === 'head') echo 'checked'; ?>> Kop
            </label>
            <label>
                <input type="radio" name="bet" value="tail" <?php if ($bet === 'tail') echo 'checked'; ?>> Munt
            </label>
            <br>
            <label for="points">Inzet Punten:</label>
            <input type="number" name="points" id="points" min="1" value="<?php echo isset($_POST['points']) ? $_POST['points'] : 1; ?>">

            <br>
            <input type="submit" value="Gooi de munt" class="golden-reset">
        </form>

        <?php
        if ($symbol == "head") {
            echo "<img id='coinImage' class='coin' src='head.png' style='transform: rotateY(0deg);'>";
            echo "Het is kop";
        } else {
            echo "<img id='coinImage' class='coin' src='tail.png' style='transform: rotateY(0deg);'>";
            echo "Het is munt";
        }
        ?>
        <button type="button" name="goBack" id="goBackButton">Terug naar de homepagina</button>

    </main>
    <!-- Dit is alle tekst in de aside  -->
    <aside>
        <form action="">
            <ul>
                <p>Welkom bij Kop of munt</p>
                <p>Hier is de uitleg</p>
                <li>Je begin met een eerst kop of munt kiezen</li>
                <li>Dan denk je over hoeveel punten je gaat inzetten</li>
                <li>Als je geluk hebt dan krijg je dubbele van wat je hebt ingezet</li>
            </ul>
        </form>
    </aside>
    <script>
        document.getElementById("goBackButton").addEventListener("click", goBack);

        function goBack() {
            window.location.href = 'home.html';
        }
    </script>

    <footer>
        &copy; 2024 Casino. Made by: Abdi Hassan, Milan Waagmeester, Ference Eichenberger, Vaishnavi Thambippillai, and Tinoe Boom
    </footer>

</body>

</html>