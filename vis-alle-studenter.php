
<?php  /* vis-alle-studenter */
/*
/*  Programmet henter alle studenter fra databasen
/*  Programmet viser alle registrerte studenter
*/
?>

<h3>Vis alle studenter</h3>

<?php
  include("db-tilkobling.php");

  $sqlSetning="SELECT * FROM student ORDER BY brukernavn;";
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

  $antallRader=mysqli_num_rows($sqlResultat);

  if ($antallRader==0)
    {
      print ("Ingen studenter er registrert <br />");
    }
  else
    {
      print ("<table border='1'>");
      print ("<tr><th>Brukernavn</th><th>Fornavn</th><th>Etternavn</th><th>Klassekode</th></tr>");

      for ($r=1;$r<=$antallRader;$r++)
        {
          $rad=mysqli_fetch_array($sqlResultat);

          $brukernavn=htmlspecialchars($rad["brukernavn"]);
          $fornavn=htmlspecialchars($rad["fornavn"]);
          $etternavn=htmlspecialchars($rad["etternavn"]);
          $klassekode=htmlspecialchars($rad["klassekode"]);

          print ("<tr>");
          print ("<td>$brukernavn</td>");
          print ("<td>$fornavn</td>");
          print ("<td>$etternavn</td>");
          print ("<td>$klassekode</td>");
          print ("</tr>");
        }

      print ("</table>");
    }

  mysqli_close($db);
?>

<br />
<a href="index.php">Tilbake til hovedmeny</a>
