
<?php  /* registrer-student */
/*
/*  Programmet lager et skjema for registrering av student
/*  Programmet registrerer en ny student i databasen
*/
?>

<h3>Registrer student</h3>

<form method="post" action="" id="registrerStudentSkjema" name="registrerStudentSkjema">
  Brukernavn <input type="text" id="brukernavn" name="brukernavn" maxlength="7" /> <br />
  Fornavn <input type="text" id="fornavn" name="fornavn" maxlength="50" /> <br />
  Etternavn <input type="text" id="etternavn" name="etternavn" maxlength="50" /> <br />

  Klasse
  <select name="klassekode" id="klassekode">
    <option value="">velg klasse</option>
    <?php include("dynamiske-funksjoner.php"); listeboksKlassekode(); ?>
  </select> <br />

  <input type="submit" value="Registrer student" id="registrerStudentKnapp" name="registrerStudentKnapp" />
</form>

<?php
  if (isset($_POST ["registrerStudentKnapp"]))
    {
      $brukernavn=trim($_POST ["brukernavn"]);
      $fornavn=trim($_POST ["fornavn"]);
      $etternavn=trim($_POST ["etternavn"]);
      $klassekode=$_POST ["klassekode"];

      if (!$brukernavn || !$fornavn || !$etternavn || !$klassekode)
        {
          print ("Alle felt m&aring; fylles ut <br />");
        }
      else
        {
          include("db-tilkobling.php");

          $sqlSetning="SELECT * FROM student WHERE brukernavn=?;";
          $sqlSpørring=mysqli_prepare($db,$sqlSetning);
          mysqli_stmt_bind_param($sqlSpørring,"s",$brukernavn);
          mysqli_stmt_execute($sqlSpørring);
          mysqli_stmt_store_result($sqlSpørring);

          $antallRader=mysqli_stmt_num_rows($sqlSpørring);
          mysqli_stmt_close($sqlSpørring);

          if ($antallRader>0)
            {
              print ("Studenten finnes fra f&oslash;r <br />");
            }
          else
            {
              $sqlSetning="INSERT INTO student (brukernavn,fornavn,etternavn,klassekode)
                           VALUES (?,?,?,?);";

              $sqlSpørring=mysqli_prepare($db,$sqlSetning);
              mysqli_stmt_bind_param($sqlSpørring,"ssss",$brukernavn,$fornavn,$etternavn,$klassekode);

              if (mysqli_stmt_execute($sqlSpørring))
                {
                  print ("F&oslash;lgende student er registrert: $brukernavn $fornavn $etternavn $klassekode <br />");
                }
              else
                {
                  print ("Ikke mulig &aring; registrere student <br />");
                }

              mysqli_stmt_close($sqlSpørring);
            }

          mysqli_close($db);
        }
    }
?>

<br />
<a href="index.php">Tilbake til hovedmeny</a>
