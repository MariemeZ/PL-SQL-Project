

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Modification d'une publication publiée</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
	<link rel="stylesheet" href="index.css"/>
	<link rel="stylesheet" href="inscription.css"/>
	
	
	
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    
	  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <!-- <a class="navbar-brand" href="index.php">Car<span>Book</span></a> -->
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item"><a href="page_index.php" class="nav-link">Home</a></li>
			  <li class="nav-item" id="bouton"><a href="Login.php" type="button" class="nav-link">Login &nbsp</a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->
    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="page_index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Modification d'une publication publiée<i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Modification d'une publication publiée</h1>
          </div>
        </div>
      </div>
    </section>
 
    <?php
// Connexion à la base de données Oracle
//$conn = oci_connect('system', 'Azerty1234', 'orcl1');
include 'connexion.php';
// Vérifier la validité de la connexion
if (!$conn) {
    $e = oci_error();
    echo "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

// Récupérer la liste des chercheurs
$queryChercheurs = "SELECT CHNO, CHNOM FROM CHERCHEUR1";
$resultChercheurs = oci_parse($conn, $queryChercheurs);
oci_execute($resultChercheurs);

// Récupérer la liste des publications
$queryPublications = "SELECT PUBNO, TITRE FROM PUBLICATION1";
$resultPublications = oci_parse($conn, $queryPublications);
oci_execute($resultPublications);

// Vérifier si pubno et chno sont passés en paramètres
if (isset($_GET['chno'], $_GET['pubno'])) {
    $chno = $_GET['chno'];
    $pubno = $_GET['pubno'];

    // Récupérer les informations de la publication publiée
    $queryPublieInfo = "SELECT * FROM PUBLIER1 WHERE CHNO = :chno AND PUBNO = :pubno";
    $stidPublieInfo = oci_parse($conn, $queryPublieInfo);
    oci_bind_by_name($stidPublieInfo, ':chno', $chno);
    oci_bind_by_name($stidPublieInfo, ':pubno', $pubno);
    oci_execute($stidPublieInfo);

    // Vérifier si la publication publiée existe
    if ($publieInfo = oci_fetch_assoc($stidPublieInfo)) {
        // Afficher le formulaire de modification
        echo '
        <h2>Modifier Publication Publiée</h2>
        <form action="' . $_SERVER["PHP_SELF"] . '" method="post" class="bg-light p-5 contact-form">
            <input type="hidden" name="chno" value="' . $publieInfo['CHNO'] . '">
            <input type="hidden" name="pubno" value="' . $publieInfo['PUBNO'] . '">
            <div class="form-group">
                <label for="chercheur">Chercheur :</label>
                <select id="chercheur" name="chercheur" required>';
                // Afficher les options de chercheurs
                while ($chercheur = oci_fetch_assoc($resultChercheurs)) {
                    $selected = ($chercheur['CHNO'] == $publieInfo['CHNO']) ? 'selected' : '';
                    echo '<option value="' . $chercheur['CHNO'] . '" ' . $selected . '>' . $chercheur['CHNOM'] . '</option>';
                }
                echo '</select>
            </div>
            <div class="form-group">
                <label for="publication">Publication :</label>
                <select id="publication" name="publication" required>';
                // Afficher les options de publications
                while ($publication = oci_fetch_assoc($resultPublications)) {
                    $selected = ($publication['PUBNO'] == $publieInfo['PUBNO']) ? 'selected' : '';
                    echo '<option value="' . $publication['PUBNO'] . '" ' . $selected . '>' . $publication['TITRE'] . '</option>';
                }
                echo '</select>
            </div>
            <div class="form-group">
                <label for="rang">Rang :</label>
                <input type="text" id="rang" name="rang" value="' . $publieInfo['RANG'] . '" required>
            </div>
            <button type="submit">Enregistrer les modifications</button>
        </form>
        ';
    
        // Fermer la connexion
        oci_free_statement($stidPublieInfo);
    } else {
        echo "La publication publiée avec CHNO $chno et PUBNO $pubno n'existe pas.";
    }
} else {
    echo "Les identifiants uniques de la publication publiée ne sont pas définis.";
}

// Fermer la connexion
oci_free_statement($resultChercheurs);
oci_free_statement($resultPublications);
oci_close($conn);
?>
<footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
        
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved 
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
      </div>
    </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>
<style>
    tbody{
        text-align-last: center;
    }
</style>
<?php
// Connexion à la base de données Oracle
//$conn = oci_connect('system', 'Azerty1234', 'orcl1');
include 'connexion.php';
// Vérifier la validité de la connexion
if (!$conn) {
    $e = oci_error();
    echo json_encode(['success' => false, 'message' => "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES)]);
    die();
}

// Vérifier si les identifiants uniques sont passés en paramètre
if (isset($_POST['chno']) && isset($_POST['pubno'])) {
    // Récupérer les identifiants uniques et les autres données du formulaire
    $chno = $_POST['chercheur'];
    $pubno = $_POST['publication'];
    $rang = $_POST['rang'];

    // Mettre à jour la publication publiée
    $queryUpdate = "UPDATE PUBLIER1 SET Rang = :rang WHERE Chno = :chno AND Pubno = :pubno";
    $stidUpdate = oci_parse($conn, $queryUpdate);
    oci_bind_by_name($stidUpdate, ':rang', $rang);
    oci_bind_by_name($stidUpdate, ':chno', $chno);
    oci_bind_by_name($stidUpdate, ':pubno', $pubno);

    // Exécuter la requête de mise à jour
    if (oci_execute($stidUpdate)) {
        // Succès de la mise à jour
        echo json_encode(['success' => true, 'message' => 'Publication publiée modifiée avec succès.']);
    } else {
        // Échec de la mise à jour
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la modification de la publication publiée.']);
    }

    // Fermer la connexion
    oci_free_statement($stidUpdate);
    oci_close($conn);
} else {
    // Les identifiants uniques ne sont pas définis
    echo json_encode(['success' => false, 'message' => 'Les identifiants uniques de la publication publiée ne sont pas définis.']);
}
?>
