<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "bibliotheque";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if(isset($_POST['submit_consulter_historique'])) {
    $sql = "SELECT id, id_utilisateur, NumLivre, date_emprunt,date_retour FROM emprunt";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $table_html = "<table style='border-collapse: collapse;'>";
        $table_html .= "<tr><th style='padding: 8px; border: 2px solid #ddd;'>ID</th><th style='padding: 8px; border: 2px solid #ddd;'>ID utilisateur</th><th style='padding: 8px; border: 2px solid #ddd;'>NumLivre</th><th style='padding: 8px; border: 2px solid #ddd;'>Date d'emprunt</th><th style='padding: 8px; border: 2px solid #ddd;'>Date de retour prévue</th><th style='padding: 8px; border: 2px solid #ddd;'>Date de retour effective</th></tr>";
        while($row = mysqli_fetch_assoc($result)) {
            $date_emprunt = date_create($row["date_emprunt"]);
            date_add($date_emprunt, date_interval_create_from_date_string('30 days'));
            $date_retour_prevue = date_format($date_emprunt, 'Y-m-d');
            $table_html .= "<tr><td style='padding: 8px; border: 2px solid #ddd;'>" . $row["id"]. "</td><td style='padding: 8px; border: 2px solid #ddd;'>" . $row["id_utilisateur"]. "</td><td style='padding: 8px; border: 2px solid #ddd;'>" . $row["NumLivre"]. "</td><td style='padding: 8px; border: 2px solid #ddd;'>" . $row["date_emprunt"]. "</td><td style='padding: 8px; border: 2px solid #ddd;'>" . $date_retour_prevue . "</td><td style='padding: 8px; border: 2px solid #ddd;'>" . $row["date_retour"] .
            "</td></tr>";
        }
        $table_html .= "</table>";
        echo $table_html;
    } else {
        echo "0 results";
    }
    mysqli_close($conn);
}


if(isset($_POST['submit_emprunt'])) {
    $id_utilisateur = $_POST['id_utilisateur'];
    $NumLivre = $_POST['NumLivre'];
    $date_emprunt = $_POST['date_emprunt'];

    // Check the number of borrowings for the user
    $sql_check_emprunts = "SELECT COUNT(*) as count_emprunts FROM emprunt WHERE id_utilisateur = '$id_utilisateur'";
    $result_check_emprunts = mysqli_query($conn, $sql_check_emprunts);
    $row_check_emprunts = mysqli_fetch_assoc($result_check_emprunts);
    $count_emprunts = $row_check_emprunts['count_emprunts'];

    // Check the number of available exemplaires
    $sql_check_exemplaires = "SELECT NbExemplaires FROM livre WHERE NumLivre = '$NumLivre'";
    $result_check_exemplaires = mysqli_query($conn, $sql_check_exemplaires);
    
    if ($result_check_exemplaires) {
        $row_check_exemplaires = mysqli_fetch_assoc($result_check_exemplaires);
        $NbExemplaires = $row_check_exemplaires['NbExemplaires'];
    } else {
        echo "Erreur: " . mysqli_error($conn);
        exit();
    }

    if ($NbExemplaires == 0) {
        echo "Erreur : Aucun exemplaire disponible de ce livre.";
        exit();
    }

    if ($count_emprunts >= 5) {
        echo "Erreur: L'utilisateur a déjà atteint la limite d'emprunts (5).";
        exit();
    }

    $sql = "INSERT INTO emprunt (id_utilisateur, NumLivre, date_emprunt) VALUES ('$id_utilisateur', '$NumLivre', '$date_emprunt')";
    if(mysqli_query($conn, $sql)){
        echo "Emprunt ajouté avec succès.";
        
        // Decrement the NbExemplaires
        $sql_decrement_exemplaires = "UPDATE livre SET NbExemplaires = NbExemplaires - 1 WHERE NumLivre = '$NumLivre'";
        mysqli_query($conn, $sql_decrement_exemplaires);
    } else{
        echo "Erreur: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}



if(isset($_POST['submit_consulter_en_cours'])) {
    $sql = "SELECT id, id_utilisateur, NumLivre, date_emprunt FROM emprunt WHERE date_retour IS NULL";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $table_html = "<table style='border-collapse: collapse;'>";
        $table_html .= "<tr><th style='padding: 8px; border: 2px solid #ddd;'>ID</th><th style='padding: 8px; border: 2px solid #ddd;'>ID utilisateur</th><th style='padding: 8px; border: 2px solid #ddd;'>NumLivre</th><th style='padding: 8px; border: 2px solid #ddd;'>Date d'emprunt</th></tr>";
        while($row = mysqli_fetch_assoc($result)) {
            $table_html .= "<tr><td style='padding: 8px; border: 2px solid #ddd;'>" . $row["id"]. "</td><td style='padding: 8px; border: 2px solid #ddd;'>" . $row["id_utilisateur"]. "</td><td style='padding: 8px; border: 2px solid #ddd;'>" . $row["NumLivre"]. "</td><td style='padding: 8px; border: 2px solid #ddd;'>" . $row["date_emprunt"]. "</td></tr>";
        }
        $table_html .= "</table>";
        echo $table_html;
    } else {
        echo "Aucun emprunt en cours.";
    }
    mysqli_close($conn);
}

if(isset($_POST['submit_rendre'])) {
    $id = $_POST['id_emprunt'];
    $date_retour = $_POST['date_retour'];
    
    $sql_get_livre = "SELECT NumLivre FROM emprunt WHERE id = '$id'";
    $result_get_livre = mysqli_query($conn, $sql_get_livre);
    $row_get_livre = mysqli_fetch_assoc($result_get_livre);
    $NumLivre = $row_get_livre['NumLivre'];
    
    $sql = "UPDATE emprunt SET date_retour = '$date_retour' WHERE id = '$id'";
    if(mysqli_query($conn, $sql)){
        echo "Livre rendu avec succès.";
        
        $sql_increment_exemplaires = "UPDATE livre SET NbExemplaires = NbExemplaires + 1 WHERE NumLivre = '$NumLivre'";
        mysqli_query($conn, $sql_increment_exemplaires);
    } else{
        echo "Erreur: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}


?>