<!DOCTYPE html>
<html lang="en">
<head>
    <title>/ajout des livres</title>
    <link rel="stylesheet" href="ajout_livre.css">
</head>
<body>
    <header>
		<h1>la gestion des livres</h1>
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
    <form action="ajoutlivre.php" method="post">
        <fieldset>
            <legend>Saisir les Coordonnées du nouveau livre</legend>
            <table>
                <tr>
                    <td>le code du livre :</td>
                    <td><input type="text" id="codelivre" name="codelivre"></td>
                </tr>
                <tr>
                    <td>Titre :</td>
                    <td><input type="text" id="titre" name="titre"></td>
                </tr>
                <tr>
                    <td>auteur :</td>
                    <td><input type="text" id="auteur" name="auteur"></td>
                </tr>
                <tr>
                    <td>maison edition :</td>
                    <td><input type="text" id="maisonedition" name="maisonedition"></td>
                </tr>
                <tr>
                    <td>le nombres des pages :</td>
                    <td><input type="text" id="nbpages" name="nbpages"></td>
                </tr>
                <tr>
                    <td>le nombres des Exemplaires :</td>
                    <td><input type="text" id="NbExemplaires" name="NbExemplaires"></td>
                </tr>
                <tr>
                    <td><input type="reset" value="Effacer"></td>
                    <td><input type="submit" value="Enregistrer"></td>
                </tr>
            </table>
        </fieldset>
    </form>
    <?php
 if(isset($_POST['codelivre']) && isset($_POST['titre']) && isset($_POST['auteur']) && isset($_POST['maisonedition']) && isset($_POST['nbpages']) && isset($_POST['NbExemplaires']))
{
    if(!empty($_POST['codelivre']) && !empty($_POST['titre']) && !empty($_POST['auteur']) && !empty( $_POST['maisonedition']) && !empty($_POST['nbpages'] ) && !empty($_POST['NbExemplaires']) )
    {
        define("MyHost","localhost");
        define("MyUser" , "root");
        define("MyPass" , "");
        define("base" , "bibliotheque");
        
        // Connexion à la base de données
        $idcom = @mysqli_connect(MyHost , MyUser , MyPass , base);
        if(!$idcom)
        {
            echo "<h3 class='response'> Connexion Impossible à la base de données! </h3>" ;
        }
        else
        {
            // Récupération des données saisies dans le formulaire
            $codelivre = $_POST['codelivre'] ;
            $titre = $_POST['titre'] ;
            $auteur = $_POST['auteur'] ;
            $maisonedition = $_POST['maisonedition'] ;
            $nbpages = $_POST['nbpages'];
            $NbExemplaires = $_POST['NbExemplaires'] ;

            // Requête SQL d'insertion dans la table livre
            $requete = "INSERT INTO livre VALUES('$codelivre','$titre','$auteur','$maisonedition','$nbpages','$NbExemplaires')";
    
            // Exécution de la requête
            $result = @mysqli_query($idcom ,$requete );
    
            // Vérification si l'insertion a bien été effectuée
            if(!$result)
{
    echo "<h2 class='response'> Erreur d'insertion </h2>";
}
else
{
    echo "<p class='response'>Le livre a été ajouté !</p>" ;
}
        }

    }
    else
    {
        echo "<p class='response'> Formulaire à compléter !</p>" ;
    }
   
   }

   ?>
    </main>
   </body>
</html>