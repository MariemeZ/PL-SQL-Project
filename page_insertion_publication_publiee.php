<?php
// Inclure le fichier de connexion à la base de données
//$conn = oci_connect('system', 'Azerty1234', 'orcl1');
include 'connexion.php';
// Vérifier la validité de la connexion
if (!$conn) {
    $e = oci_error();
    echo "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

// Fonction pour récupérer la liste des chercheurs
function getChercheurs($conn) {
    $query = "SELECT Chno, Chnom FROM CHERCHEUR1";
    $stid = oci_parse($conn, $query);
    oci_execute($stid);

    $chercheurs = [];
    while ($row = oci_fetch_assoc($stid)) {
        $chercheurs[] = $row;
    }

    oci_free_statement($stid);
    return $chercheurs;
}

// Fonction pour récupérer la liste des publications
function getPublications($conn) {
    $query = "SELECT Pubno, Titre FROM PUBLICATION1";
    $stid = oci_parse($conn, $query);
    oci_execute($stid);

    $publications = [];
    while ($row = oci_fetch_assoc($stid)) {
        $publications[] = $row;
    }

    oci_free_statement($stid);
    return $publications;
}

// Récupérer la liste des chercheurs
$chercheurs = getChercheurs($conn);

// Récupérer la liste des publications
$publications = getPublications($conn);

// Fermer la connexion
oci_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Insertion Publication Publiée</title>
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
	          <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
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
          	<p class="breadcrumbs"><span class="mr-2"><a href="page_index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Insertion Publication Publiée<i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Insertion Publication Publiée</h1>
          </div>
        </div>
      </div>
    </section>
	
	<section class="ChercheurForm" style="text-align: -webkit-center;">
	<div class="col-md-8 block-9 mb-md-5">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="bg-light p-5 contact-form">
  <div class="form-group" >
        <label for="chercheur">Chercheur :</label>
        <select name="chercheur" id="chercheur" required>
            <?php foreach ($chercheurs as $chercheur) : ?>
                <option value="<?= $chercheur['CHNO'] ?>"><?= $chercheur['CHNOM'] ?></option>
            <?php endforeach; ?>
        </select>
        </div>
        <br>
        <div class="form-group" >
        <label for="publication">Publication :</label>
        <select name="publication" id="publication" required>
            <?php foreach ($publications as $publication) : ?>
                <option value="<?= $publication['PUBNO'] ?>"><?= $publication['TITRE'] ?></option>
            <?php endforeach; ?>
        </select>
        </div>
        <br>
        <div class="form-group" >
        <label for="rang">Rang :</label>
        <input type="number" name="rang" id="rang" required>
        </div>
        <br>

        <input type="submit" value="Insérer Publication Publiée">
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
if (isset($_POST['chercheur'], $_POST['publication'], $_POST['rang'])) {
  $chno = $_POST['chercheur'];
  $pubno = $_POST['publication'];
  $rang = $_POST['rang'];

  // Insertion dans la table publier
  $queryInsert = "INSERT INTO PUBLIER1 (CHNO, PUBNO, RANG) VALUES (:chno, :pubno, :rang)";
  $stidInsert = oci_parse($conn, $queryInsert);
  oci_bind_by_name($stidInsert, ':chno', $chno);
  oci_bind_by_name($stidInsert, ':pubno', $pubno);
  oci_bind_by_name($stidInsert, ':rang', $rang);
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
