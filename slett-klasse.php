
<?php  /* slett-klasse */
/*
/*  Programmet lager et skjema for å velge en klasse som skal slettes
/*  Programmet sletter den valgte klassen hvis den ikke har studenter
*/
?>

<script src="funksjoner.js"></script>

<h3>Slett klasse</h3>

<form method="post" action="" id="slettKlasseSkjema" name="slettKlasseSkjema" onSubmit="return bekreft()">
  Klasse
  <select name="klassekode" id="klassekode">
    <option value="">velg klasse</option>
    <?php include("dynamiske-funksjoner.php"); listeboksKlassekode(); ?>
  </select> <br />

  <input type="submit" value="Slett klasse" name="slettKlasseKnapp" id="slettKlasseKnapp" />
</form>

<?php
  if (isset($_POST ["slettKlasseKnapp"]))
    {
      $klassekode=$_POST ["klassekode"];

      if (!$klassekode)
        {
          print ("Klasse ikke valgt <br />");
        }
      else
        {
          include("db-tilkobling.php");

          $sqlSetning="SELECT * FROM student WHERE klassekode=?;";
          $sqlSpørring=mysqli_prepare($db,$sqlSetning);
          mysqli_stmt_bind_param($sqlSpørring,"s",$klassekode);
          mysqli_stmt_execute($sqlSpørring);
          mysqli_stmt_store_result($sqlSpørring);

          $antallRader=mysqli_stmt_num_rows($sqlSpørring);
          mysqli_stmt_close($sqlSpørring);

          if ($antallRader>0)
            {
              print ("Klassen kan ikke slettes fordi den har studenter <br />");
            }
          else
            {
              $sqlSetning="DELETE FROM klasse WHERE klassekode=?;";
              $sqlSpørring=mysqli_prepare($db,$sqlSetning);
              mysqli_stmt_bind_param($sqlSpørring,"s",$klassekode);

              if (mysqli_stmt_execute($sqlSpørring))
                {
                  if (mysqli_stmt_affected_rows($sqlSpørring)>0)
                    {
                      print ("F&oslash;lgende klasse er n&aring; slettet: " . htmlspecialchars($klassekode) . " <br />");
                    }
                  else
                    {
                      print ("Klassen finnes ikke i databasen <br />");
                    }
                }
              else
                {
                  print ("Ikke mulig &aring; slette klasse <br />");
                }

              mysqli_stmt_close($sqlSpørring);
            }

          mysqli_close($db);
        }
    }
?>

<br />
<a href="index.php">Tilbake til hovedmeny</a>
