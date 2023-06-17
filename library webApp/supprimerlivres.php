<!DOCTYPE html>
<html lang="en">
  <head>
  <link rel="stylesheet" type="text/css" href="supprimerlivre.css">
    <title>Document</title>
  </head>
  <body>
    <header>
      <h1>la suppression des livres</h1>
      <nav>
        <ul>
        <li><a href="dashboardAdmin.html">la page d'accueil</a></li>
				<li><a href="livre2.html">page precedente</a></li>
				<li><a href="affichage.php">liste des livres</a></li>
        <li><a href="afficherusagers.php">liste des utilisateurs</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <?php
      // Vérifier si le formulaire a été soumis
      if(isset($_POST['delet'])) {
          define("MYHOST","localhost");
          define("MYUSER","root");
          define("MYPASS","");
          $base="bibliotheque";
          // Récupérer le code du livre à supprimer
          $codelivre = $_POST['codelivre'];

          // Connexion à la base de données
          $conn = @mysqli_connect(MYHOST,MYUSER,MYPASS,$base);

          // Vérifier si la connexion a réussi
          if(!$conn) {
              die("La connexion a échoué : " . mysqli_connect_error());
          }

          // Vérifier si le livre existe
          $sql = "SELECT * FROM livre WHERE NumLivre='$codelivre'";
          $result = mysqli_query($conn, $sql);

          if(mysqli_num_rows($result) == 0) {
              echo "<p class='error-message'> Le livre que vous souhaitez supprimer n'existe pas dans la base de données.</p>";
          } else {
              // Supprimer le livre de la table "livre" de la base de données
              $sql = "DELETE FROM livre WHERE NumLivre='$codelivre'";

              if(mysqli_query($conn, $sql)) {
                  echo "<p class='success-message'>Le livre a été supprimé avec succès.</p>";
              } else {
                  echo "<p class='error-message'> Erreur lors de la suppression du livre : </p>" . mysqli_error($conn);
              }
          }

          // Fermer la connexion à la base de données
          mysqli_close($conn);
      }
      ?>
      <form action="supprimerlivres.php" method="post">
        <fieldset>
          <legend><b>supprimer le livre</b></legend>
          <table>
          
            <tr>
              <td>le code du livre :</td>
              <td><input type="text" name="codelivre" size="40" /></td>
            </tr>  
            <tr>
              <td><input type="submit" name="delet" value="delet"/></td>
              <td><input type="reset" /></td>
            </tr>
          </table>
        </fieldset>
      </form>
    </main>
    
  </body>
</html>