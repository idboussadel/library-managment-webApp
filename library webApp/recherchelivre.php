<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="recherchelivre.css">
</head>
<body>
    <header>
        <h1>chercher un livre</h1>
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
        <form action="#" method="post">

            <fieldset>
                <legend>Afficher Les Donnees Des livres</legend>
                <table>
                    <tr>
                        <td><label> le code du livre</label></td>
                        <td><input type="text" name="codelivre" id="codelivre"></td>
                    </tr>
                    <tr>
                        <td><input type="reset" value="Effacer"></td>
                        <td><input type="submit" value="chercher"></td>
                    </tr>
                </table>
             </fieldset>
         </form>
    </main>  
    <?php 
    if(isset($_POST['codelivre']))
    {
        if(!empty($_POST['codelivre']))
        {
            define("MyHost","localhost");
            define("MyUser" , "root");
            define("MyPass" , "");
            define("NomDb" , "bibliotheque");
            $idcom = @mysqli_connect(MyHost , MyUser , MyPass , NomDb);
            if(!$idcom)
            {
                echo "<h3> Connexion Impossible à la base de données! </h3>" ;
            }
            else
            {
                $codelivre = $_POST['codelivre'] ;
                $requete = "SELECT * FROM livre WHERE NumLivre = '$codelivre'";
                $result = mysqli_query($idcom ,$requete);
                if(!$result)
                {
                    echo "<h2> Erreur d'affichage </h2>";
                }
                else
                {
                    $Enregistrement = mysqli_fetch_array($result , MYSQLI_ASSOC);
                    if($Enregistrement)
                    {
                        echo "<div class='response'><b>Les Données de ce livre sont : </b><br><br>";
                        echo "<table>";
                        foreach($Enregistrement as $cle => $valeur)
                        {
                            echo "<tr><td><b>$cle :</b></td> <td>$valeur</td></tr>";
                        }
                        echo "</table></div>";
                    }
                    else
                    {
                        echo "<h2>Ce livre n'existe Pas !! </h2>";
                    }
                }
            }
            mysqli_close($idcom);
        }
        else
        {
            echo "<h2>Svp Entrer le code de livre !</h2>";
        }
    }
    ?>
</body>
</html>