<?php
// Inclure le fichier de connexion à la base de données
//$conn = oci_connect('system','Azerty1234', 'orcl1');
include 'connexion.php';
// Vérifier la validité de la connexion
if (!$conn) {
    $e = oci_error();
    echo "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

// Récupérer les données pour le menu déroulant "Faculté"
$queryFaculte = "SELECT Facno, Facnom FROM FACULTE1";
$resultFaculte = oci_parse($conn, $queryFaculte);
oci_execute($resultFaculte);
// Fermer la connexion
oci_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Insertion publication</title>
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
	          <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
	          <li class="nav-item"><a href="services.html" class="nav-link">Services</a></li>
	          <li class="nav-item "><a href="pricing.php" class="nav-link">Pricing</a></li>
	          
	          <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>
	          <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
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
          	<p class="breadcrumbs"><span class="mr-2"><a href="page_index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Insertion d'une publication <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Insertion d'une publication</h1>
          </div>
        </div>
      </div>
    </section>
	
	<section class="ChercheurForm" style="text-align: -webkit-center;">
	<div class="col-md-8 block-9 mb-md-5">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="bg-light p-5 contact-form">
            <div class="form-group" >
		        <label for="pubno">Numéro de Publication:</label>
        <input type="text" id="pubno" name="pubno" required><br>
            </div>
        <div class="form-group" >
        <label for="titre">Titre:</label>
        <input type="text" id="titre" name="titre" required><br>
        </div>
        <div class="form-group" >
        <label for="theme">Thème:</label>
        <input type="text" id="theme" name="theme" required><br>
        </div>
        <div class="form-group" >
        <label for="type_pub">Type de Publication:</label>
        <select id="type_pub" name="type_pub" required>
            <option value="AS">AS (Article de journal)</option>
            <option value="PC">PC (Publication de conférence)</option>
            <option value="P">P (Livre)</option>
            <option value="L">L (Chapitre de livre)</option>
            <option value="T">T (Thèse)</option>
            <option value="M">M (Mémoire)</option>
        </select><br>
        </div>
        <div class="form-group" >
        <label for="volume">Volume:</label>
        <input type="number" id="volume" name="volume" required><br>
        </div>
        <div class="form-group" >
        <label for="date_pub">Date de Publication:</label>
        <input type="date" id="date_pub" name="date_pub" required><br>
        </div>
        <div class="form-group" >
        <label for="apparition">Apparition:</label>
        <input type="text" id="apparition" name="apparition" required><br>
        </div>
        <div class="form-group" >
        <label for="editeur">Editeur:</label>
        <input type="text" id="editeur" name="editeur" required><br>
        </div>

			 
              <div class="form-group" >
                <input type="submit" value="Valider" class="btn btn-primary py-3 px-5" id="val" >
              </div>
            </form>
          
          </div>
	</section>
 
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

// Vérifier si les données du formulaire sont définies
if (
    isset($_POST['pubno']) &&
    isset($_POST['titre']) &&
    isset($_POST['theme']) &&
    isset($_POST['type_pub']) &&
    isset($_POST['volume']) &&
    isset($_POST['date_pub']) &&
    isset($_POST['apparition']) &&
    isset($_POST['editeur'])
) {
    // Récupérer les données du formulaire
    $pubno = $_POST['pubno'];
    $titre = $_POST['titre'];
    $theme = $_POST['theme'];
    $type_pub = $_POST['type_pub'];
    $volume = $_POST['volume'];
    $date_pub = $_POST['date_pub'];
    $apparition = $_POST['apparition'];
    $editeur = $_POST['editeur'];

    // Préparer la requête d'insertion
    $queryInsert = "INSERT INTO PUBLICATION1 (PUBNO, TITRE, THEME, TYPE_PUB, VOLUME, DATE_PUB, APPARITION, EDITEUR) 
                    VALUES (:pubno, :titre, :theme, :type_pub, :volume, TO_DATE(:date_pub, 'YYYY-MM-DD'), :apparition, :editeur)";
    
    $stidInsert = oci_parse($conn, $queryInsert);
    
    // Liens entre les variables PHP et les paramètres de la requête
    oci_bind_by_name($stidInsert, ':pubno', $pubno);
    oci_bind_by_name($stidInsert, ':titre', $titre);
    oci_bind_by_name($stidInsert, ':theme', $theme);
    oci_bind_by_name($stidInsert, ':type_pub', $type_pub);
    oci_bind_by_name($stidInsert, ':volume', $volume);
    oci_bind_by_name($stidInsert, ':date_pub', $date_pub);
    oci_bind_by_name($stidInsert, ':apparition', $apparition);
    oci_bind_by_name($stidInsert, ':editeur', $editeur);

    // Exécuter la requête d'insertion
    $executeResult=oci_execute($stidInsert);
    
    if (!$executeResult) {
      //   $errorCode = oci_error($stid)['code'];
      //   echo '<script type="text/javascript">';
      //   echo 'alert("Erreur OCI : Code ' . $errorCode . '");';
      //   if ($errorCode == 20001) {
      //     // Si le code d'erreur est 20001, afficher un message spécifique
      //     echo 'alert(" La capacité d\'encadrement du directeur est dépassée.");';
      // }
      //   echo '</script>';
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Insertion réussie.");';
        echo '</script>';
    }

    // Fermer la connexion
    oci_free_statement($stidInsert);
    oci_close($conn);
} 
?>
