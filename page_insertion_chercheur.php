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

// Récupérer les données pour le menu déroulant "Laboratoire"
$queryLaboratoire = "SELECT Labno, Labnom FROM LABORATOIRE1";
$resultLaboratoire = oci_parse($conn, $queryLaboratoire);
oci_execute($resultLaboratoire);

// Fermer la connexion
oci_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Insertion chercheur</title>
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
          	<p class="breadcrumbs"><span class="mr-2"><a href="page_index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Insertion d'un chercheur <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Insertion d'un chercheur</h1>
          </div>
        </div>
      </div>
    </section>
	
	<section class="ChercheurForm" style="text-align: -webkit-center;">
	<div class="col-md-8 block-9 mb-md-5">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="bg-light p-5 contact-form">
			<div class="form-group">
                <input type="text" class="form-control" placeholder="Numero" name="chno">
              </div>
			  <div class="form-group">
                <input type="text" class="form-control" placeholder="Nom" name="chnom">
              </div>
			  <div class="form-group">
                <input type="text" class="form-control" placeholder="Grade" name="grade">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Statut" name="statut">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Superieur" name="sup">
              </div>
              <div class="form-group">
              <label for="lab">Date recrutement :</label>
              <input type="date" class="form-control" id="daterecru" name="daterecru">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Salaire" name="Salaire">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Prime" name="prime">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Email" name="email">
              </div>
              <div class="form-group">
                <label for="lab">Laboratoire :</label>
                <select class="form-control" id="lab" name="lab">
                    <?php
                    // Boucle à travers les résultats de la requête pour construire les options
                    while ($rowLaboratoire = oci_fetch_assoc($resultLaboratoire)) {
                        echo "<option value='{$rowLaboratoire['LABNO']}'>{$rowLaboratoire['LABNOM']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="faculte">Faculté :</label>
                <select class="form-control" id="faculte" name="facno">
                    <?php
                    // Boucle à travers les résultats de la requête pour construire les options
                    while ($rowFaculte = oci_fetch_assoc($resultFaculte)) {
                        echo "<option value='{$rowFaculte['FACNO']}'>{$rowFaculte['FACNOM']}</option>";
                    }
                    ?>
                </select>
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
// Inclure le fichier de connexion à la base de données
//$conn = oci_connect('system', 'Azerty1234', 'orcl1');
include 'connexion.php';
// Vérifier la validité de la connexion
if (!$conn) {
    $e = oci_error();
    echo "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $chno = isset($_POST['chno']) ? $_POST['chno'] : '';
    $chnom = isset($_POST['chnom']) ? $_POST['chnom'] : '';
    $grade = isset($_POST['grade']) ? $_POST['grade'] : '';
    $statut = isset($_POST['statut']) ? $_POST['statut'] : '';
    $daterecru = isset($_POST['daterecru']) ? date('d-m-Y', strtotime($_POST['daterecru'])) : '';
    $salaire = isset($_POST['Salaire']) ? $_POST['Salaire'] : '';
    $prime = isset($_POST['prime']) ? $_POST['prime'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $labno = isset($_POST['lab']) ? $_POST['lab'] : '';
    $facno = isset($_POST['facno']) ? $_POST['facno'] : '';
    $supno = isset($_POST['sup']) ? $_POST['sup'] : '';

    // Préparer la requête d'insertion
    $queryInsert = "INSERT INTO CHERCHEUR1 (Chno, Chnom, Grade, Statut, Daterecrut, Salaire, Prime, Email, Labno, Facno,Supno)
                   VALUES (:chno, :chnom, :grade, :statut, TO_DATE(:daterecru, 'DD-MM-YYYY'), :salaire, :prime, :email, :labno, :facno,:supno)";
    $stid = oci_parse($conn, $queryInsert);
   
    // Vérifier si la préparation a réussi
    if (!$stid) {
        $e = oci_error($conn);
        echo "Erreur OCI (parse) : " . htmlentities($e['message'], ENT_QUOTES);
        die();
    }

    // Associer les valeurs aux paramètres de la requête
    oci_bind_by_name($stid, ':chno', $chno);
    oci_bind_by_name($stid, ':chnom', $chnom);
    oci_bind_by_name($stid, ':grade', $grade);
    oci_bind_by_name($stid, ':statut', $statut);
    oci_bind_by_name($stid, ':daterecru', $daterecru);
    oci_bind_by_name($stid, ':salaire', $salaire);
    oci_bind_by_name($stid, ':prime', $prime);
    oci_bind_by_name($stid, ':email', $email);
    oci_bind_by_name($stid, ':labno', $labno);
    oci_bind_by_name($stid, ':facno', $facno);
    oci_bind_by_name($stid, ':supno', $supno);

    // Exécuter la requête
    $executeResult = oci_execute($stid);

    // Vérifier si l'exécution a réussi
    // if (!$executeResult) {
    //     $e = oci_error($stid);
    //     echo  htmlentities($e['message'], ENT_QUOTES);
    //     die();
    // }
    if (!$executeResult) {
      $errorCode = oci_error($stid)['code'];
      echo '<script type="text/javascript">';
      echo 'alert("Erreur OCI : Code ' . $errorCode . '");';
      if ($errorCode == 20001) {
        // Si le code d'erreur est 20001, afficher un message spécifique
        echo 'alert(" La capacité d\'encadrement du directeur est dépassée.");';
    }
      echo '</script>';
  } else {
      echo '<script type="text/javascript">';
      echo 'alert("Insertion réussie.");';
      echo '</script>';
  }

  //   if (!$executeResult) {
  //     echo '<script type="text/javascript">alert("Erreur OCI (execute) : ' . htmlentities(oci_error($stid)['message'], ENT_QUOTES) . '");</script>';
  //     die();
  // }

    // Fermer la connexion
    oci_free_statement($stid);
    oci_close($conn);

    
}
?>
	