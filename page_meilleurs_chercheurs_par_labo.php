
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Chercheurs du meilleur labo</title>
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
          	<p class="breadcrumbs"><span class="mr-2"><a href="page_index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Chercheurs avec Plus de Publications<i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Chercheurs avec Plus de Publications</h1>
          </div>
        </div>
      </div>
    </section>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="date_debut">Date de début :</label>
    <input type="date" id="date_debut" name="date_debut" required>

    <label for="date_fin">Date de fin :</label>
    <input type="date" id="date_fin" name="date_fin" required>

    <!-- Autres champs du formulaire -->

    <button type="submit">Exécuter la Procédure</button>
</form>

<h2>Résultat de la Procédure :</h2>
<div id="resultat_procedure">
    <!-- La sortie de la procédure sera affichée ici -->
    <?php
// Connexion à la base de données Oracle
include "connexion.php";
// Vérifier la validité de la connexion
if (!$conn) {
    $e = oci_error();
    echo "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}
$stidEnableOutput = oci_parse($conn, "BEGIN DBMS_OUTPUT.ENABLE(NULL); END;");
oci_execute($stidEnableOutput);
oci_free_statement($stidEnableOutput);
// Vérifier si les clés 'date_debut' et 'date_fin' existent dans $_POST
if (isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
    // Assigner les valeurs aux paramètres
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    // Exécuter la procédure stockée
    $sqlCallProcedure = "BEGIN ChercheursAvecPlusDePublications(TO_DATE(:date_debut, 'YYYY-MM-DD'), TO_DATE(:date_fin, 'YYYY-MM-DD')); END;";

    $stidProcedure = oci_parse($conn, $sqlCallProcedure);
    oci_bind_by_name($stidProcedure, ':date_debut', $date_debut);
    oci_bind_by_name($stidProcedure, ':date_fin', $date_fin);

    // Exécuter la procédure
    oci_execute($stidProcedure);

    // Récupérer les messages de sortie avec DBMS_OUTPUT.GET_LINE
    $stidGetLine = oci_parse($conn, "BEGIN DBMS_OUTPUT.GET_LINE(:output_line, :status); END;");
    oci_bind_by_name($stidGetLine, ':output_line', $outputLine, 255);
    oci_bind_by_name($stidGetLine, ':status', $status, 1);

    // Stocker les messages dans un tableau
    $outputMessages = array();

    while ($status == 0) {
        $outputMessages[] = $outputLine;
        oci_execute($stidGetLine);
    }

    // Afficher les messages récupérés
    if (!empty($outputMessages)) {
        echo "Messages récupérés :<br>";
        foreach ($outputMessages as $message) {
            echo $message . "<br>";
        }
    } else {
        echo "Aucun message récupéré.<br>";
    }
    
    // Fermer les statements
    oci_free_statement($stidProcedure);
    oci_free_statement($stidGetLine);
    oci_close($conn);
}
?>


</div>

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

