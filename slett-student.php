
<?php  /* slett-student */
/*
/*  Programmet lager et skjema for å velge en student som skal slettes
/*  Programmet sletter den valgte studenten
*/
?>

<script src="funksjoner.js"></script>

<h3>Slett student</h3>

<form method="post" action="" id="slettStudentSkjema" name="slettStudentSkjema" onSubmit="return bekreft()">
  Student
  <select name="brukernavn" id="brukernavn">
    <option value="">velg student</option>
    <?php include("dynamiske-funksjoner.php"); listeboksBrukernavn(); ?>
  </select> <br />

  <input type="submit" value="Slett student" name="slettStudentKnapp" id="slettStudentKnapp" />
</form>

<?php
  if (isset($_POST ["slettStudentKnapp"]))
    {
      $brukernavn=$_POST ["brukernavn"];

      if (!$brukernavn)
        {
          print ("Student ikke valgt <br />");
        }
      else
        {
          include("db-tilkobling.php");

          $sqlSetning="DELETE FROM student WHERE brukernavn=?;";
          $sqlSpørring=mysqli_prepare($db,$sqlSetning);
          mysqli_stmt_bind_param($sqlSpørring,"s",$brukernavn);

          if (mysqli_stmt_execute($sqlSpørring))
            {
              if (mysqli_stmt_affected_rows($sqlSpørring)>0)
                {
                  print ("F&oslash;lgende student er n&aring; slettet: " . htmlspecialchars($brukernavn) . " <br />");
                }
              else
                {
                  print ("Studenten finnes ikke i databasen <br />");
                }
            }
          else
            {
              print ("Ikke mulig &aring; slette student <br />");
            }

          mysqli_stmt_close($sqlSpørring);
          mysqli_close($db);
        }
    }
?>

<br />
<a href="index.php">Tilbake til hovedmeny</a>
