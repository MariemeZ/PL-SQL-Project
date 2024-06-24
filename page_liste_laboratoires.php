
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Liste labos</title>
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
          	<p class="breadcrumbs"><span class="mr-2"><a href="page_index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Liste des laboratoires <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Liste des laboratoires</h1>
          </div>
        </div>
      </div>
    </section>

    <div></div>
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

// Récupérer les données de la table "laboratoire" avec le nom de la faculté
$queryLabos = "
    SELECT labo.LABNO, labo.LABNOM, fac.FACNOM
    FROM LABORATOIRE1 labo
    JOIN FACULTE1 fac ON labo.FACNO = fac.FACNO
";
$resultLabos = oci_parse($conn, $queryLabos);
oci_execute($resultLabos);

// Afficher le tableau des laboratoires
echo '<table border="1" style="margin: 26px auto;">
        <tr>
            <th>Numero</th>
            <th>Nom</th>
            <th>Faculté</th>
            <th>Action</th>
        </tr>';

while ($row = oci_fetch_assoc($resultLabos)) {
    echo '<tr>';
    echo '<td>' . $row['LABNO'] . '</td>';
    echo '<td>' . $row['LABNOM'] . '</td>';
    echo '<td>' . $row['FACNOM'] . '</td>';
    echo '<td>
    <button><a href="page_modification_laboratoire.php?labno=' . $row['LABNO'] . '">Modifier</a></button>
    <button onclick="supprimerLaboratoire(' . $row['LABNO'] . ')">Supprimer</button>
  </td>';
    echo '</tr>';
}

echo '</table>';

// Fermer la connexion
oci_free_statement($resultLabos);
oci_close($conn);
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
<script>
function supprimerLaboratoire(labno) {
    // Demander une confirmation avant de supprimer
    if (confirm("Êtes-vous sûr de vouloir supprimer ce laboratoire?")) {
        // Utiliser fetch pour envoyer une requête AJAX au script PHP
        fetch('supprimer_laboratoire.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'labno=' + labno,
        })
        .then(response => response.json())
        .then(data => {
            // Vérifier la réponse du serveur
            if (data.success) {
                alert("Laboratoire supprimé avec succès!");
                // Actualiser la page ou effectuer d'autres actions nécessaires
                location.reload();
            } else {
                alert("Erreur lors de la suppression du laboratoire.");
            }
        })
        .catch(error => {
            console.error('Erreur lors de la communication avec le serveur:', error);
        });
    }
}
</script>