<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Prikaz prijava</title>
    <link href="login.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <script>
      function dod()
      {
        document.getElementById("dodaj_voz").style.display = "block";
        document.getElementById("tbl_zapisi").style.display = "none";
        document.getElementById("tbl_vozila").style.display = "none";
        document.getElementById("btn_zapisi").style.display = "inline";
        document.getElementById("btn_dodaj").style.display = "none";
      }

      function zap()
      {
        document.getElementById("tbl_zapisi").style.display = "table";
        document.getElementById("tbl_vozila").style.display = "table";
        document.getElementById("dodaj_voz").style.display = "none";
        document.getElementById("btn_dodaj").style.display = "inline";
        document.getElementById("btn_zapisi").style.display = "none";
        document.getElementById("stat").innerHTML = "";
        document.getElementById("form_dodaj").reset();
      }

      function sbmt()
      {
        document.getElementById("dodaj_voz").style.display = "none";
        document.getElementById("btn_dodaj").style.display = "none";
        document.getElementById("btn_zapisi").style.display = "inline";
        document.getElementById("stat").innerHTML = "Vozilo dodano!";
        setTimeout(zap, 2000);
        setTimeout(rel, 2000);
      }

      function rel()
      {
        location.reload();
      }
    </script>
    <div class="odabir odabir2">
      <button type="button" name="button" class="gumb" onclick="window.location.href = 'index.html';">
        Povratak na početnu
      </button>
      <button type="button" name="button" class="gumb" onclick="window.location.href = 'user_login.php';">
        Povratak na prijavu
      </button>
      <button type="button" name="button" class="gumb" id="btn_dodaj" onclick="dod()">
        Dodaj novo vozilo
      </button>
      <button type="button" name="button" class="gumb" id="btn_zapisi" onclick="zap()" hidden>
        Prikaži zapise o vozilu
      </button>
    </div>
    <h2 id="stat"></h2>
    <table class="tablica" id="tbl_vozila">
      <tr>
        <th>Popis vozila</th>
      </tr>
      <?php
        include("connect.php");

        $Email = $_POST['email'];
        $Lozinka = $_POST['lozinka'];

        $sql = "SELECT * FROM KORISNIK WHERE Email = '$Email'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);
        if($row['Lozinka'] == $Lozinka)
        {
            $IDk = $row['ID_korisnik'];
            $sql = "SELECT * FROM VOZILO WHERE Korisnik_ID = $IDk";
            $result = mysqli_query($db, $sql);

            while($row = mysqli_fetch_assoc($result))
            {
              echo '<tr><td>'.$row['Naziv'].'</td></tr>';
            }
        } else
          {
            $message = "Netočni podatci";
            echo "<script type='text/javascript'>alert('$message');window.location = 'user_login.php';</script>";
          }
      ?>
    </table>
    <table class="tablica" id="tbl_zapisi">
      <tr>
        <th>Email</th>
        <th>Naziv vozila</th>
        <th>ID kartice</th>
        <th>Vrijeme</th>
        <th>Stanje</th>
        <th>Stanica</th>
      </tr>
      <?php
        $sql = "SELECT * FROM ZAPISI WHERE Email = '$Email'";
        $result = mysqli_query($db, $sql);

        while($row = mysqli_fetch_assoc($result))
        {
          echo '<tr><td>'.$row['Email'].'</td><td>'.$row['Naziv'].'</td><td>'.$row['Kartica'].'</td><td>'.$row['Vrijeme'].'</td><td>'.$row['Stanje'].'</td><td>'.$row['Stanica'].'</td></tr>';
        }
      ?>
    </table>
    <div class="registracija" id="dodaj_voz" hidden>
      <form class="" id="form_dodaj" action="user_dodaj.php" target="_blank" method="post" onsubmit="sbmt()">
        <p>Naziv vozila</p>
        <input class="input" type="text" name="naziv" value="" maxlength="20" required><br><br>
        <div class="r">
          <p>Vrsta vozila</p>
          <label class="rad">
            <input class="radio" type="radio" name="vrsta" value="0" required>Bicikl<br>
          </label>
          <label class="rad">
            <input class="radio" type="radio" name="vrsta" value="1">Električni bicikl<br>
          </label>
          <label class="rad">
            <input class="radio" type="radio" name="vrsta" value="2">Romobil<br>
          </label>
          <label class="rad">
            <input class="radio" type="radio" name="vrsta" value="3">Električni romobil<br>
          </label>
        </div><br>
        <p>Unesite ID kartice:</p>
        <input class="input" type="text" name="kartica" value="" maxlength="12" required><br><br><br>
        <input type="number" name="IDk" value="<?php echo htmlspecialchars($IDk); ?>" hidden>
        <input class="input buton" type="submit" id="submit" name="submitt" value="Dodaj vozilo">
      </form>
    </div>
  </body>
</html>
