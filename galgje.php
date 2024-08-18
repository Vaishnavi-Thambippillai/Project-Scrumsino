<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galgje</title>
    <link rel="stylesheet" href="galgje.css">


    <header>
        <h1>SCRUMSINO</h1>
        <img src="logo1.png" alt="Logo" />
    </header>

    <!-- navbar van het galgje waar je andere spelletjes kan klikken-->
    <nav>
        <a class="selector" href="kop-of-munt.php">Kop of munt</a>
        <a class="selector" href="steen-papier-schaar.php">Steen, papier schaar</a>
        <a class="selector" href="galgje.php">Galgje</a>
        <a class="selector" href="boter-kaas-eieren.php">Boter, kaas en eieren</a>
        <a class="selector" href="quiz.php">Quiz</a>
    </nav>
    </div>

    <!-- het display waar de button verdwijnt-->
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <h1>Welkom tot Galgje</h1>
    <main>
        <?php
        session_start();


        $word = array('software', 'ict', 'php', 'html', 'javascript', 'nexed');

        // Voorkomen van 'undefined' problemen
        if (!isset($_SESSION['score'])) {
            $_SESSION['score'] = 0;
        }

        if (!isset($_SESSION['strike'])) {
            $_SESSION['strike'] = 0;
        }

        if (!isset($_SESSION['letterguess'])) {
            $_SESSION['letterguess'] = '';
        }

        if (!isset($_SESSION['alphabet'])) {
            $_SESSION['alphabet'] = range('a', 'z');
        }

        if (!isset($_SESSION['word'])) {
            $word = array('software', 'ict', 'php', 'html', 'javascript', 'nexed');
        }

        $alphabet = $_SESSION['alphabet'];

        //het verandert de word die je raad naar punten
        function wordToDots($wordInFunction)
        {
            global $word;

            $lettersInFunction = str_split($wordInFunction);

            $unguessed = 0;
            foreach ($lettersInFunction as $letterInLoop) {
                if (in_array($letterInLoop, str_split($_SESSION['letterguess']))) {
                    echo $letterInLoop;
                } else {
                    echo '&bull;';
                    $unguessed = $unguessed + 1;
                }
            }
           // Pop-up voor 'helaas' en optie om opnieuw te spelen
            if ($_SESSION['strike'] >= 10) {
                echo '<div class="popup">
        <h1>Helaas</h1> 
        <p>Je hebt niet het woord geraden</p>
        <a href="?restart=1">Wil je een ander woord?</a> 
        </div>';
                $_SESSION['word'] = $word[rand(0, count($word) - 1)];
                $_SESSION['score'] = 0;
                $_SESSION['strike'] = 0;
                $_SESSION['letterguess'] = '';
                $_SESSION['alphabet'] = range('a', 'z');
            }

            // Pop-up voor succesvol raden en optie om opnieuw te spelen
            if (isset($unguessed) && ($unguessed === 0)) {
                echo '<div class="popup">';
                echo '<p>Goed gedaan, Je hebt het woord geraden</p><a href="?restart=1">Wil je een ander woord?</a>';
                $_SESSION['score'] = $_SESSION['score'] + 5;
                $_SESSION['word'] = $word[rand(0, count($word) - 1)];
                $_SESSION['letterguess'] = '';
                $_SESSION['strike'] = 0;
                $_SESSION['alphabet'] = range('a', 'z');
                echo '</div>';
            }
        }

         // Controleert of de letter goed of fout is en geeft punten of een 'strike'
        if (isset($_POST['letter'])) {
            $letterInPost = $_POST['letter'];
            $letterInWord = str_split($_SESSION['word']);
            $_SESSION['letterguess'] = $_SESSION['letterguess'] . $letterInPost;

            if (in_array($letterInPost, $letterInWord)) {
                $_SESSION['score'] = $_SESSION['score'] + 1;
            } else {
                $_SESSION['strike'] = $_SESSION['strike'] + 1;
            }


            $index = array_search($letterInPost, $_SESSION['alphabet']);
            if ($index !== false) {
                unset($_SESSION['alphabet'][$index]);
            }
        }


        ?>

        <!-- score content-->
        <aside class="scoren">
            <em>Welkom bij Galgje</em> <br>
            <em>Hieronder zie je de uitleg en scores:</em>
            <ul>
                <li>Je krijgt 1 punt voor elke correcte knopdruk.</li>
                <li>Je krijgt een aantal fouten totdat je er 10 raakt en al je punten verdwijnen.</li>
                <li>Als je alles correct hebt geraden, krijg je er nog eens 5 extra punten bij.</li>
                <li>Maar in beide gevallen kun je het nog een keer proberen.</li>
            </ul>
            <em>Klik op het woord 'Nog een keer' om opnieuw te spelen.</em>


            <?php
            //het laat de score zien van de aantal punt of strikes je hebt
            echo '<h3><strong>score</strong><br />';
            echo '<em> dit is jouw score: ' . $_SESSION['score'] . '  </em> </br> ';
            echo '<em> je hebt ' . $_SESSION['strike'] . ' fouten van de 10' . '</em></p>'
            ?>
        </aside>
        <script>
            function goBack() {
                window.location.href = 'home.html';
            }

            //de knop om terug tegaan naar homepage
        </script>
        <button type="button" onclick="goBack()" id="goBackButton">Terug naar de homepagina</button>


    </main>

    <!-- keybaord content-->
    <div class="content" id="keyboard">
        <img id="fotos" src="strike_/strike_<?php echo $_SESSION['strike']; ?>.png" alt="">
        <div class="content_menu">
            <p><?php wordToDots($_SESSION['word']); ?></p>
        </div>
        <?php

        //zorgt ervoor dat de keybaord responsief is 
        echo '<form action="#" method="post">';
        foreach ($alphabet as $letter) {
            echo '<input type="submit" name="letter" value="' . $letter . '" ';
            if (in_array($letter, str_split($_SESSION['letterguess']))) {
                echo 'class="hidden"';
            }
            echo '/>';
        }
        echo '</form>';
        ?>
    </div>

    <!--footer content-->
    <footer>
        &copy; 2024 Casino. Made by: Abdi Hassan, Milan Waagmeester, Ference Eichenberger, Vaishnavi Thambippillai, and Tinoe Boom
    </footer>
</body>

</html>