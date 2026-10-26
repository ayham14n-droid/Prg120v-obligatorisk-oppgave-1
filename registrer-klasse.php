
<?php  /* registrer-klasse */
/*
/*  Programmet lager et skjema for registrering av klasse
/*  Programmet registrerer en ny klasse i databasen
*/
?>

<h3>Registrer klasse</h3>

<form method="post" action="" id="registrerKlasseSkjema" name="registrerKlasseSkjema">
  Klassekode <input type="text" id="klassekode" name="klassekode" /> <br />
  Klassenavn <input type="text" id="klassenavn" name="klassenavn" /> <br />
  Studiumkode <input type="text" id="studiumkode" name="studiumkode" /> <br />
  <input type="submit" value="Registrer klasse" id="registrerKlasseKnapp" name="registrerKlasseKnapp" />
</form>

<?php
  if (isset($_POST ["registrerKlasseKnapp"]))
    {
      $klassekode=trim($_POST ["klassekode"]);
      $klassenavn=trim($_POST ["klassenavn"]);
      $studiumkode=trim($_POST ["studiumkode"]);

      if (!$klassekode || !$klassenavn || !$studiumkode)
        {
          print ("Alle felt m&aring; fylles ut <br />");
        }
      else
        {
          include("db-tilkobling.php");

          $sqlSetning="SELECT * FROM klasse WHERE klassekode=?;";
          $sqlSpørring=mysqli_prepare($db,$sqlSetning);
          mysqli_stmt_bind_param($sqlSpørring,"s",$klassekode);
          mysqli_stmt_execute($sqlSpørring);
          mysqli_stmt_store_result($sqlSpørring);

          $antallRader=mysqli_stmt_num_rows($sqlSpørring);
          mysqli_stmt_close($sqlSpørring);

          if ($antallRader>0)
            {
              print ("Klassen finnes fra f&oslash;r <br />");
            }
          else
            {
              $sqlSetning="INSERT INTO klasse (klassekode,klassenavn,studiumkode)
                           VALUES (?,?,?);";

              $sqlSpørring=mysqli_prepare($db,$sqlSetning);
              mysqli_stmt_bind_param($sqlSpørring,"sss",$klassekode,$klassenavn,$studiumkode);

              if (mysqli_stmt_execute($sqlSpørring))
                {
                  print ("F&oslash;lgende klasse er registrert: $klassekode $klassenavn $studiumkode <br />");
                }
              else
                {
                  print ("Ikke mulig &aring; registrere klasse <br />");
                }

              mysqli_stmt_close($sqlSpørring);
            }

          mysqli_close($db);
        }
    }
?>

<br />
<a href="index.php">Tilbake til hovedmeny</a>
