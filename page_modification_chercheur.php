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

// Récupérer les données pour le menu déroulant "Laboratoire"
$queryLaboratoire = "SELECT Labno, Labnom FROM LABORATOIRE1";
$resultLaboratoire = oci_parse($conn, $queryLaboratoire);
oci_execute($resultLaboratoire);

// Récupérer les données pour le menu déroulant "Faculté"
$queryFaculte = "SELECT Facno, Facnom FROM FACULTE1";
$resultFaculte = oci_parse($conn, $queryFaculte);
oci_execute($resultFaculte);

// Récupérer le numéro du chercheur à partir de l'URL
$chercheurId = isset($_GET['chno']) ? $_GET['chno'] : '';

// Préparer la requête pour récupérer les données du chercheur
$queryChercheur = "SELECT * FROM CHERCHEUR1 WHERE Chno = :chercheurId";
$stidChercheur = oci_parse($conn, $queryChercheur);
oci_bind_by_name($stidChercheur, ':chercheurId', $chercheurId);
oci_execute($stidChercheur);

// Récupérer les données du chercheur
$chercheurData = oci_fetch_assoc($stidChercheur);

// Fermer la connexion
oci_free_statement($stidChercheur);
oci_close($conn);
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Modification chercheur</title>
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
          	<p class="breadcrumbs"><span class="mr-2"><a href="page_index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Modification du chercheur <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Modification du chercheur</h1>
          </div>
        </div>
      </div>
    </section>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"class="bg-light p-5 contact-form">
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Numero" name="chno" value="<?php echo $chercheurData['CHNO']; ?>" readonly>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Nom" name="chnom" value="<?php echo $chercheurData['CHNOM']; ?>">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Grade" name="grade" value="<?php echo $chercheurData['GRADE']; ?>">
    </div>
    <div class="form-group">
    <label for="salaire">Salaire :</label>
    <input type="text" class="form-control" id="salaire" name="salaire" value="<?php echo isset($chercheurData['SALAIRE']) ? $chercheurData['SALAIRE'] : ''; ?>">
</div>
<div class="form-group">
    <label for="prime">Prime :</label>
    <input type="text" class="form-control" id="prime" name="prime" value="<?php echo isset($chercheurData['PRIME']) ? $chercheurData['PRIME'] : ''; ?>">
</div>

<div class="form-group">
    <label for="email">Email :</label>
    <input type="text" class="form-control" id="email" name="email" value="<?php echo isset($chercheurData['EMAIL']) ? $chercheurData['EMAIL'] : ''; ?>">
</div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Statut" name="statut" value="<?php echo $chercheurData['STATUT']; ?>">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Superieur" name="sup" value="<?php echo $chercheurData['SUPNO']; ?>">
    </div>
    <div class="form-group">
    <label for="daterecru">Date recrutement (jj/mm/aaaa) :</label>
    <?php
    $dateRecrutement = isset($chercheurData['DATERECRUT']) ? DateTime::createFromFormat('d/m/y', $chercheurData['DATERECRUT']) : null;
    $dateRecrutementFormatted = $dateRecrutement ? $dateRecrutement->format('Y-m-d') : '';
    ?>
    <input type="date" class="form-control" id="daterecru" name="daterecru" value="<?php echo $dateRecrutementFormatted; ?>">
</div>

<div class="form-group">
        <label for="lab">Laboratoire :</label>
        <select class="form-control" id="lab" name="lab">
            <?php
            // Boucle à travers les résultats de la requête pour construire les options
            while ($rowLaboratoire = oci_fetch_assoc($resultLaboratoire)) {
                $selected = ($rowLaboratoire['LABNO'] == $rowChercheur['LABNO']) ? 'selected' : '';
                echo "<option value='{$rowLaboratoire['LABNO']}' $selected>{$rowLaboratoire['LABNOM']}</option>";
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
            $selected = ($rowFaculte['FACNO'] == $chercheurData['FACNO']) ? 'selected' : '';
            echo "<option value='{$rowFaculte['FACNO']}' $selected>{$rowFaculte['FACNOM']}</option>";
        }
        ?>
    </select>
</div>


    <!-- Ajoutez ici les autres champs du formulaire avec les valeurs correspondantes -->

    <div class="form-group">
        <input type="submit" value="Valider" class="btn btn-primary py-3 px-5" id="val">
    </div>
</form>
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
// Inclure le fichier de connexion à la base de données
//$conn = oci_connect('system', 'Azerty1234', 'orcl1');
include 'connexion.php';
// Vérifier la validité de la connexion
if (!$conn) {
    $e = oci_error();
    echo "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

// Traitement du formulaire de modification du chercheur
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $chno = $_POST['chno'];
    $chnom = $_POST['chnom'];
    $grade = $_POST['grade'];
    $statut = $_POST['statut'];
    $supno = $_POST['sup'];
    $daterecru = $_POST['daterecru']? date('d-m-Y', strtotime($_POST['daterecru'])) : '';
    $salaire = $_POST['salaire'];
    $prime = $_POST['prime'];
    $email = $_POST['email'];
    $labno = $_POST['lab'];
    $facno = $_POST['facno'];

    // Préparer la requête de mise à jour
    $queryUpdate = "UPDATE CHERCHEUR1 SET
                    Chnom = :chnom,
                    Grade = :grade,
                    Statut = :statut,
                    Supno = :supno,
                    Daterecrut = TO_DATE(:daterecru, 'DD/MM/YYYY'),
                    Salaire = :salaire,
                    Prime = :prime,
                    Email = :email,
                    Labno = :labno,
                    Facno = :facno
                    WHERE Chno = :chno";

    $stidUpdate = oci_parse($conn, $queryUpdate);

    // Vérifier si la préparation a réussi
    if (!$stidUpdate) {
        $e = oci_error($conn);
        echo "Erreur OCI (parse) : " . htmlentities($e['message'], ENT_QUOTES);
        die();
    }

    // Associer les valeurs aux paramètres de la requête
    oci_bind_by_name($stidUpdate, ':chnom', $chnom);
    oci_bind_by_name($stidUpdate, ':grade', $grade);
    oci_bind_by_name($stidUpdate, ':statut', $statut);
    oci_bind_by_name($stidUpdate, ':supno', $supno);
    oci_bind_by_name($stidUpdate, ':daterecru', $daterecru);
    oci_bind_by_name($stidUpdate, ':salaire', $salaire);
    oci_bind_by_name($stidUpdate, ':prime', $prime);
    oci_bind_by_name($stidUpdate, ':email', $email);
    oci_bind_by_name($stidUpdate, ':labno', $labno);
    oci_bind_by_name($stidUpdate, ':facno', $facno);
    oci_bind_by_name($stidUpdate, ':chno', $chno);

    // Exécuter la requête de mise à jour
    $executeResult = oci_execute($stidUpdate);

    // Vérifier si l'exécution a réussi
    // if (!$executeResult) {
    //     $e = oci_error($stidUpdate);
    //     echo "Erreur OCI (execute) : " . htmlentities($e['message'], ENT_QUOTES);
    //     die();
    // }
    if (!$executeResult) {
        $errorCode = oci_error($stidUpdate)['code'];
        echo '<script type="text/javascript">';
        echo 'alert("Erreur OCI : Code ' . $errorCode . '");';
        if ($errorCode == 20002) {
          echo 'alert(" Les mises à jour ne sont autorisées que les jours ouvrables entre 8h et 18h");';
      }
      if ($errorCode == 20010) {
        echo 'alert(" La diminution du salaire est interdite.");';
    }
        echo '</script>';
    }

    // Fermer la connexion
    oci_free_statement($stidUpdate);
    oci_close($conn);

    echo "Mise à jour réussie.";
    echo '<script type="text/javascript">';
echo 'window.location.href = "page_liste_chercheurs.php";';
echo '</script>';
}
?>
