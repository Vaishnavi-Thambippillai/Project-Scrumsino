<?php
session_start();

// Functie voor het starten van het spel
function startGame()
{
    $_SESSION['board'] = array_fill(0, 3, array_fill(0, 3, ''));
    $_SESSION['current_player'] = 'X';
    $_SESSION['winner'] = null;
}

// Functie om te controleren of de huidige speler heeft gewonnen
function checkWinner()
{
    if (!isset($_SESSION['board'])) {
        return null;
    }

    $board = $_SESSION['board'];

    // Controleert de rijen
    for ($i = 0; $i < 3; $i++) {
        if (
            isset($board[$i][0], $board[$i][1], $board[$i][2]) &&
            $board[$i][0] != '' && $board[$i][0] == $board[$i][1] && $board[$i][0] == $board[$i][2]
        ) {
            return $board[$i][0];
        }
    }

    // Controle kolommen
    for ($j = 0; $j < 3; $j++) {
        if (
            isset($board[0][$j], $board[1][$j], $board[2][$j]) &&
            $board[0][$j] != '' && $board[0][$j] == $board[1][$j] && $board[0][$j] == $board[2][$j]
        ) {
            return $board[0][$j];
        }
    }

    // Controle diagonalen kolommen
    if (
        isset($board[0][0], $board[1][1], $board[2][2]) &&
        $board[0][0] != '' && $board[0][0] == $board[1][1] && $board[0][0] == $board[2][2]
    ) {
        return $board[0][0];
    }
    if (
        isset($board[0][2], $board[1][1], $board[2][0]) &&
        $board[0][2] != '' && $board[0][2] == $board[1][1] && $board[0][2] == $board[2][0]
    ) {
        return $board[0][2];
    }

    // Controleer op een gelijkspel
    $tie = true;
    foreach ($board as $row) {
        foreach ($row as $cell) {
            if ($cell == '') {
                $tie = false;
                break 2;
            }
        }
    }
    if ($tie) {
        return 'T';
    }

    return null;
}

// Functie om de zet van de computer (AI) te maken
function makeAIMove()
{
    $row = rand(0, 2);
    $col = rand(0, 2);

    while ($_SESSION['board'][$row][$col] != '') {
        $row = rand(0, 2);
        $col = rand(0, 2);
    }

    $_SESSION['board'][$row][$col] = $_SESSION['current_player'];
}

// Controleer of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['restart'])) {
        startGame();
    } elseif (isset($_POST['reset'])) {
        startGame();
    } else {
        if ($_SESSION['current_player'] == 'X') {
            // poging van de X speler
            $row = filter_input(INPUT_POST, 'row', FILTER_VALIDATE_INT, [
                'options' => ['min_range' => 0, 'max_range' => 2]
            ]);
            $col = filter_input(INPUT_POST, 'col', FILTER_VALIDATE_INT, [
                'options' => ['min_range' => 0, 'max_range' => 2]
            ]);

            if (
                $row !== false && $col !== false &&
                isset($_SESSION['board'][$row]) && isset($_SESSION['board'][$row][$col]) &&
                $_SESSION['board'][$row][$col] == '' && !$_SESSION['winner']
            ) {
                // Plaats het symbool van de speler op het bord
                $_SESSION['board'][$row][$col] = $_SESSION['current_player'];

                // Controle op een winnaar of gelijkspel
                $_SESSION['winner'] = checkWinner();

                // Wissel naar de andere speler
                $_SESSION['current_player'] = ($_SESSION['current_player'] == 'X') ? 'O' : 'X';
            }
        }

        // poging van de computer (AI)
        if ($_SESSION['current_player'] == 'O' && !$_SESSION['winner']) {
            makeAIMove();

            // Controleer op een winnaar of gelijkspel na de zet van de computer
            $_SESSION['winner'] = checkWinner();

            // Wisselt naar de andere speler
            $_SESSION['current_player'] = ($_SESSION['current_player'] == 'X') ? 'O' : 'X';
        }
    }
} else {
    // Start een nieuw spel als het nog niet is gestart
    if (!isset($_SESSION['board'])) {
        startGame();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boter, Kaas en Eieren</title>
    <link rel="stylesheet" href="boter-kaas-eieren.css">
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
        <h1>Welkom bij Boter, Kaas en Eieren</h1>

        <?php if (isset($_SESSION['winner']) && $_SESSION['winner'] === null) : ?>
            <p>Speler: <?php echo $_SESSION['current_player']; ?></p>
        <?php endif; ?>

        <table>
            <?php for ($i = 0; $i < 3; $i++) : ?>
                <tr>
                    <?php for ($j = 0; $j < 3; $j++) : ?>
                        <td>
                            <?php if (isset($_SESSION['board'][$i][$j]) && $_SESSION['board'][$i][$j] != '') : ?>
                                <?php echo $_SESSION['board'][$i][$j]; ?>
                            <?php else : ?>
                                <form method="post" action="">
                                    <input type="hidden" name="row" value="<?php echo $i; ?>">
                                    <input type="hidden" name="col" value="<?php echo $j; ?>">
                                    <button type="submit"><?php echo $_SESSION['board'][$i][$j]; ?></button>
                                </form>
                            <?php endif; ?>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </table>

        <?php if (isset($_SESSION['winner']) && $_SESSION['winner'] !== null) : ?>
            <?php if ($_SESSION['winner'] == 'T') : ?>
                <p>Het is gelijkspel en je krijgt 0 punten!</p>
            <?php else : ?>
                <p>Gefeliciteerd! Speler <?php echo $_SESSION['winner']; ?> wint! en krijgt 3 punten</p>
            <?php endif; ?>
            <form method="post" action="">
                <input type="hidden" name="restart" value="1">
            </form>
        <?php endif; ?>

        <button type="button" name="goBack" id="goBackButton">Terug naar de homepagina</button>
        <form method="post" action="">
            <input type="hidden" name="reset" value="1">
            <button type="submit">Reset spel</button>
        </form>
    </main>
    <!-- Dit is alle tekst in de aside  -->
    <aside>
        <form action="">
            <ul>
                <p>Welkom bij Boter, kaas en eieren</p>
                <p>Hier is de uitleg</p>
                <li>Speler X ben jij zelf en Speler O is de Computer dus AI</li>
                <li>Je gaat gewoon op een button kiezen en het doel is om 3 op een rij te krijgen</li>

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