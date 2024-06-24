

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Modification d'une publication</title>
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
          	<p class="breadcrumbs"><span class="mr-2"><a href="page_index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Modification d'une publication <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Modification d'une publication</h1>
          </div>
        </div>
      </div>
    </section>
 
    <?php
    // Récupérer les données de la publication à modifier
    // Assurez-vous d'avoir ces données avant d'afficher le formulaire
   
    if (isset($_GET['pubno'])) {
      $pubno = $_GET['pubno'];
  
    // Connexion à la base de données Oracle
    //$conn = oci_connect('system', 'Azerty1234', 'orcl1');
    include 'connexion.php';
    // Vérifier la validité de la connexion
    if (!$conn) {
        $e = oci_error();
        echo "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES);
        die();
    }

    // Récupérer les informations de la publication
    $queryPublication = "SELECT * FROM PUBLICATION1 WHERE Pubno = :pubno";
    $stidPublication = oci_parse($conn, $queryPublication);
    oci_bind_by_name($stidPublication, ':pubno', $pubno);
    oci_execute($stidPublication);

    // Vérifier si la publication existe
    if ($publication = oci_fetch_assoc($stidPublication)) {
      
      $datePub = isset($publication['DATE_PUB']) ? DateTime::createFromFormat('d/m/y', $publication['DATE_PUB']) : null;
      $datePub = $datePub ? $datePub->format('Y-m-d') : '';
      
        // Afficher le formulaire de modification avec les données pré-remplies
        echo '
        <form action="' . $_SERVER["PHP_SELF"] .'" method="post" class="bg-light p-5 contact-form">
            <input type="hidden" name="pubno" value="' . $publication['PUBNO'] . '">
            <div class="form-group">
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" value="' . $publication['TITRE'] . '" required><br>
            </div>
            <div class="form-group">
            <label for="theme">Thème :</label>
            <input type="text" id="theme" name="theme" value="' . $publication['THEME'] . '" required><br>
            </div>
            <div class="form-group">
            <label for="type_pub">Type de publication :</label>
            <input type="text" id="type_pub" name="type_pub" value="' . $publication['TYPE_PUB'] . '" required><br>
            </div>
            <div class="form-group">
            <label for="volume">Volume :</label>
            <input type="number" id="volume" name="volume" value="' . $publication['VOLUME'] . '" required><br>
            </div>
            <div class="form-group">
            <label for="date_pub">Date de publication :</label>
           
            <input type="date" id="date_pub" name="date_pub" value="' .   $datePub. '" required><br>
            </div>
            <div class="form-group">
            <label for="apparition">Apparition :</label>
            <input type="text" id="apparition" name="apparition" value="' . $publication['APPARITION'] . '" required><br>
            </div>
            <div class="form-group">
            <label for="editeur">Editeur :</label>
            <input type="text" id="editeur" name="editeur" value="' . $publication['EDITEUR'] . '" required><br>
            </div>
            <button type="submit">Enregistrer les modifications</button>
        </form>';
    } else {
        echo "La publication avec le numéro $pubno n'existe pas.";
    }

    // Fermer la connexion
    oci_free_statement($stidPublication);
    oci_close($conn);
  }
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

// Vérifier si le formulaire a été soumis
if (!empty($_POST)) {
    // Récupérer les données du formulaire
    $pubno = $_POST['pubno'];
    $titre = $_POST['titre'];
    $theme = $_POST['theme'];
    $type_pub = $_POST['type_pub'];
    $volume = $_POST['volume'];
    $date_pub = $_POST['date_pub'];
    $apparition = $_POST['apparition'];
    $editeur = $_POST['editeur'];

    // Mettre à jour la publication dans la base de données
    $queryUpdate = "UPDATE PUBLICATION1 SET
                    Titre = :titre,
                    Theme = :theme,
                    Type_pub = :type_pub,
                    Volume = :volume,
                    Date_pub = TO_DATE(:date_pub, 'YYYY-MM-DD'),
                    Apparition = :apparition,
                    Editeur = :editeur
                    WHERE Pubno = :pubno";

    $stidUpdate = oci_parse($conn, $queryUpdate);
    oci_bind_by_name($stidUpdate, ':titre', $titre);
    oci_bind_by_name($stidUpdate, ':theme', $theme);
    oci_bind_by_name($stidUpdate, ':type_pub', $type_pub);
    oci_bind_by_name($stidUpdate, ':volume', $volume);
    oci_bind_by_name($stidUpdate, ':date_pub', $date_pub);
    oci_bind_by_name($stidUpdate, ':apparition', $apparition);
    oci_bind_by_name($stidUpdate, ':editeur', $editeur);
    oci_bind_by_name($stidUpdate, ':pubno', $pubno);

    if (oci_execute($stidUpdate)) {
        // Succès de la mise à jour
        echo '<script type="text/javascript">';
echo 'window.location.href = "page_liste_publications.php";';
echo '</script>';
    } else {
        // Échec de la mise à jour
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour de la publication.']);
    }

    // Fermer la connexion
    oci_free_statement($stidUpdate);
    oci_close($conn);
} 
?>
