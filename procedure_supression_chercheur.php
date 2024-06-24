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

// Corps de la procédure stockée ChercheursAvecPlusDePublications
$sqlProcedure = "
CREATE OR REPLACE PROCEDURE SupprimerChercheur(
    p_chno IN CHERCHEUR1.Chno%TYPE
  )
  AS
  BEGIN
  DELETE FROM PUBLIER1 WHERE Chno = p_chno;
  DELETE FROM CHERCHEUR1 WHERE Chno = p_chno;
  COMMIT;
  DBMS_OUTPUT.PUT_LINE('Chercheur supprimé avec succès');
  EXCEPTION
  WHEN NO_DATA_FOUND THEN
  DBMS_OUTPUT.PUT_LINE('Aucun chercheur trouvé avec le numéro' || p_chno);
  WHEN OTHERS THEN
  DBMS_OUTPUT.PUT_LINE('Erreur lors de la suppression du chercheur.');
 
  END SupprimerChercheur;

";

// Préparation et exécution du script
$stidProcedure = oci_parse($conn, $sqlProcedure);
$executeResult = oci_execute($stidProcedure);

// Vérifier si l'exécution a réussi
if (!$executeResult) {
    $e = oci_error($stidProcedure);
    echo "Erreur OCI (execute) : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

echo "Procédure stockée créée avec succès.";

// Fermer la connexion
oci_free_statement($stidProcedure);
oci_close($conn);
?>
