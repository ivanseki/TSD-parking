<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>User login</title>
    <link href="login.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <script>
      function reg()
      {
        document.getElementById("reg").style.display = "block";
        document.getElementById("log").style.display = "none";
      }

      function log()
      {
        document.getElementById("reg").style.display = "none";
        document.getElementById("log").style.display = "block";
      }

      function rel()
      {
        setTimeout(rst, 2000);
      }

      function rst()
      {
          document.getElementById("form_dodaj").reset();
      }
    </script>
    <div class="odabir">
      <button type="button" name="registracija" class="gumb" onclick="reg()">Registriraj se</button>
      <button type="button" name="login" class="gumb" onclick="log()">Prijavi se</button>
    </div>
    <div class="registracija" id="reg" hidden>
      <form class="" action="" method="post" onsubmit="rel()">
        <p>Unesite ime:</p>
        <input class="input" type="text" name="ime" value="" maxlength="25" required><br><br>
        <p>Unesite prezime:</p>
        <input class="input" type="text" name="prezime" value="" maxlength="35" required><br><br>
        <p>Email:</p>
        <input class="input" type="email" name="email" value="" pattern=".+@skole.hr" placeholder="adresa@skole.hr" maxlength="60" required><br><br>
        <p>Lozinka:</p>
        <input class="input" type="password" id="lozinka" name="lozinka" value="" maxlength="16" onkeyup="provjeriloz()" required><br><br><br>
        <p>Ponovite lozinku:</p>
        <input class="input" type="password" id="lozinka2" name="lozinka2" value="" maxlength="16" onkeyup="provjeriloz()" required><br><br><br>
        <span id='poruka'></span><br><br><br>
        <input class="input buton" type="submit" id="submit" name="submit" value="Registriraj se">
      </form>
    </div>
    <div class="registracija" id="log">
      <form class="" action="user_pregled.php" method="post">
        <p>Email:</p>
        <input class="input" type="email" name="email" value="" pattern=".+@skole.hr" placeholder="adresa@skole.hr" required><br><br>
        <p>Lozinka:</p>
        <input class="input" type="password" name="lozinka" value="" maxlength="16" required><br><br>
        <input class="input buton" type="submit" name="submit" value="Prijavi se">
      </form>
    </div>
    <script>
      function provjeriloz()
      {
        var lozinka = document.getElementById('lozinka').value;
        var lozinka2 = document.getElementById('lozinka2').value;
        var poruka = document.getElementById('poruka');
        var submit = document.getElementById('submit');

        if (lozinka == lozinka2)
        {
          poruka.style.color = 'green';
          poruka.innerHTML = 'Lozinke se podudaraju';
          submit.disabled = false;
        } else
          {
            poruka.style.color = 'red';
            poruka.innerHTML = 'Lozinke se ne podudaraju!';
            submit.disabled = true;
          }
      }
    </script>
  </body>
</html>

<?php
  include("connect.php");

  if(isset($_POST['submit']))
  {
    $Ime = $_POST["ime"];
    $Prezime = $_POST["prezime"];
    $Email = $_POST["email"];
    $Lozinka = $_POST["lozinka"];

    $sql = "INSERT INTO KORISNIK";
    $sql .= "(Ime, Prezime, Email, Lozinka)";
    $sql .= "VALUES ('$Ime', '$Prezime', '$Email', '$Lozinka')";

    mysqli_query($db, $sql);

    header("Location: http://localhost/projekt/user_login.php");
    exit();
  }
 ?>
