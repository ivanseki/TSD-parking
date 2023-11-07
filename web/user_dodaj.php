<?php
  include("connect.php");

  if(isset($_POST['submitt']))
  {
    $Naziv = $_POST["naziv"];
    $Vrsta = $_POST["vrsta"];
    $Kartica = $_POST["kartica"];
    $IDk = $_POST["IDk"];

    $sql = "INSERT INTO VOZILO";
    $sql .= "(Naziv, Vrsta, Kartica, Korisnik_ID)";
    $sql .= "VALUES ('$Naziv', '$Vrsta', '$Kartica', $IDk)";

    mysqli_query($db, $sql);

    echo "<script>window.close();</script>";
  }
?>
