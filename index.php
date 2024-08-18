<?php
$ageError = "";
$age = 0;

// Het verwerken van POST in het formulier
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $age = $_POST["age"];
  // hier wordt gecontroleerd of je 16 jaar of ouder bent om de website te betreden
  if ($age >= 16) {
    header("Location: home.html");
    exit();
  } else {
    $AgeError = ("Sorry, Je moet ouder zijn dan 16 jaar om de website te betreden");
  }
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Spelersverificatie</title>
  <link rel="stylesheet" href="index.css">
</head>

<body background="casino.png">

  <header>
    <h1>SCRUMSINO</h1>
    <img src="logo1.png" alt="Logo" />
  </header>
  <!-- als je op de knoppen klikt van de navbar krijg je melding je moet eerst verifiëren. -->
  <nav>
    <a id="kopofmuntLink" class="selector" <?php echo ($age >= 16) ? 'href="kop-of-munt.php"' : 'href="#" onclick="alert(\'Sorry, Je moet eerst verifiëren.\'); return false;"'; ?>>
      Kop of munt
    </a>
    <a id="rockPaperScissorsLink" class="selector" <?php echo ($age >= 16) ? 'href="steen-papier-schaar.php"' : 'href="#" onclick="alert(\'Sorry, Je moet eerst verifiëren.\'); return false;"'; ?>>
      Steen, Papier, Schaar
    </a>
    <a id="galgjeLink" class="selector" <?php echo ($age >= 16) ? 'href="galgje.php"' : 'href="#" onclick="alert(\'Sorry, Je moet eerst verifiëren.\'); return false;"'; ?>>
      Galgje
    </a>
    <a id="boterkaaseierenLink" class="selector" <?php echo ($age >= 16) ? 'href="boter-kaas-eieren.php"' : 'href="#" onclick="alert(\'Sorry, Je moet eerst verifiëren.\'); return false;"'; ?>>
      Boter, kaas en eieren
    </a>
    <a id="quizLink" class="selector" <?php echo ($age >= 16) ? 'href="quiz.php"' : 'href="#" onclick="alert(\'Sorry, Je moet eerst verifiëren.\'); return false;"'; ?>>
      Quiz
    </a>
  </nav>
  <main>

    <aside>
      <h3>Welkom bij de Spelers Verificatie voor Scrumsino
        <p>Als je jonger bent dan 16 jaar, helaas dan is deze website niet bestemd voor jou.</p>
        <p>Als je ouder bent dan 16 jaar dan ben je op de goede site.</p>
      </h3>
    </aside>
  </main>

  <h2>Spelers Verificatie Casino</h2>
  <!-- de formulier van de verificatie systeem -->
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
    <label for="name">Naam:</label>
    <input type="text" id="name" name="name" required />

    <label for="age">Leeftijd:</label>
    <input type="number" id="age" name="age" required />

    <button type="submit">
      Leeftijd controle
    </button>
  </form>

  <script>
    function validateForm() {
      var age = document.getElementById("age").value;
      // hier krijg je melding als je jonger bent dan 16 jaar
      if (age < 16) {
        alert("Sorry, Je moet ouder zijn dan 16 jaar om de website te betreden");
        return false;
      }

      return true;
    }
  </script>

  <footer> &copy; 2024 Casino. Gemaakt door: Abdi Hassan, Milan Waagmeester, Ference Eichenberger, Vaishnavi Thambippillai, and Tinoe Boom</footer>

</body>

</html>