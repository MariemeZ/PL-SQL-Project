<?php

$nomUtilisateur = 'system';
$motDePasse = 'Azerty1234';
$nomServeurOracle = 'orcl1';

// Tentative de connexion à la base de données Oracle
//$conn = oci_connect($nomUtilisateur, $motDePasse, $nomServeurOracle);
$conn = oci_connect('system', 'Azerty1234', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=DESKTOP-T2V147B)(PORT=1522))(CONNECT_DATA=(SERVER=DEDICATED)(SERVICE_NAME=orcl1)))', 'AL32UTF8');

// if ($conn) {
//     echo "Connexion réussie à Oracle Database!";
    
//     // N'oubliez pas de fermer la connexion après utilisation
//     oci_close($conn);
// } else {
//     // Affichez un message d'erreur en cas d'échec de la connexion
//     $e = oci_error();
//     echo "Erreur de connexion à Oracle Database: " . htmlentities($e['message'], ENT_QUOTES);
// }



?>
