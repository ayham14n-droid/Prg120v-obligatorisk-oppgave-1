
<?php  /* vis-alle-klasser */
/*
/*  Programmet henter alle klasser fra databasen
/*  Programmet viser alle registrerte klasser
*/
?>

<h3>Vis alle klasser</h3>

<?php
  include("db-tilkobling.php");

  $sqlSetning="SELECT * FROM klasse ORDER BY klassekode;";
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

  $antallRader=mysqli_num_rows($sqlResultat);

  if ($antallRader==0)
    {
      print ("Ingen klasser er registrert <br />");
    }
  else
    {
      print ("<table border='1'>");
      print ("<tr><th>Klassekode</th><th>Klassenavn</th><th>Studiumkode</th></tr>");

      for ($r=1;$r<=$antallRader;$r++)
        {
          $rad=mysqli_fetch_array($sqlResultat);

          $klassekode=htmlspecialchars($rad["klassekode"]);
          $klassenavn=htmlspecialchars($rad["klassenavn"]);
          $studiumkode=htmlspecialchars($rad["studiumkode"]);

          print ("<tr>");
          print ("<td>$klassekode</td>");
          print ("<td>$klassenavn</td>");
          print ("<td>$studiumkode</td>");
          print ("</tr>");
        }

      print ("</table>");
    }

  mysqli_close($db);
?>

<br />
<a href="index.php">Tilbake til hovedmeny</a>
