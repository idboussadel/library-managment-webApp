<!DOCTYPE html>
<html lang="en">
  <head>
   <link rel="stylesheet" href="modifierlivres.css">
    <title>Modifier un livre</title>
  </head>
  <body>
  <header>
		<h1 >modifier les livres</h1>
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
    <form action="modifierlivres.php" method="post">
      <fieldset>
        
        <table>
          <tr>
            <td>Code du livre :</td>
            <td><input type="text" name="codelivre" size="40" /></td>
          </tr>
          <tr>
            <td>Titre :</td>
            <td><input type="text" name="titre" size="40" /></td>
          </tr>
          <tr>
            <td>Auteurs :</td>
            <td><input type="text" name="auteurs" size="40" /></td>
          </tr>
          <tr>
            <td>Maison d'édition :</td>
            <td><input type="text" name="maisonedition" size="40" /></td>
          </tr>
          <tr>
            <td>Nombre de pages :</td>
            <td><input type="text" name="nbpages" size="40" /></td>
          </tr>
          <tr>
            <td>Nombre d'exemplaires :</td>
            <td><input type="text" name="nbexemplaires" size="40" /></td>
          </tr>
          <tr>
            <td colspan="2"><input type="submit" name="modifier" value="Modifier" /></td>
          </tr>
        </table>
      </fieldset>
    </form>
    <?php

// Vérifier si le formulaire a été soumis
if(isset($_POST['modifier'])) {

    define("MYHOST","localhost");
    define("MYUSER","root");
    define("MYPASS","");
    $base="bibliotheque";

    // Récupérer les données du formulaire
    $codelivre = $_POST['codelivre'];
    $titre = $_POST['titre'];
    $auteurs = $_POST['auteurs'];
    $maisonedition = $_POST['maisonedition'];
    $nbpages = $_POST['nbpages'];
    $nbexemplaires = $_POST['nbexemplaires'];

    // Connexion à la base de données
    $conn = mysqli_connect(MYHOST,MYUSER,MYPASS,$base);

    // Vérifier si la connexion a réussi
    if(!$conn) {
        die("La connexion a échoué : " . mysqli_connect_error());
    }

    // Vérifier si le livre existe dans la base de données
    $sql = "SELECT * FROM livre WHERE NumLivre='$codelivre'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1) {

        // Modifier les données du livre dans la table "livre" de la base de données
        $sql = "UPDATE livre SET Titre='$titre', Auteurs='$auteurs', MaisonEdition='$maisonedition', NbPages='$nbpages', NbExemplaires='$nbexemplaires' WHERE NumLivre='$codelivre'";

        if(mysqli_query($conn, $sql)) {
            echo "<p class='message'>Le livre a été modifié avec succès.</p>";
        } else {
            echo "<p class='message'>Erreur lors de la modification du livre : </p>" . mysqli_error($conn);
        }

    } else {
        echo "<p class='message'>Le livre n'existe pas dans la base de données.</p>";
    }

    // Fermer la connexion à la base de données
    mysqli_close($conn);
}
?>
  </main>
    
</body>
</html>
    
