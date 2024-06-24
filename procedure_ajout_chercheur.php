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
CREATE OR REPLACE PROCEDURE AjouterChercheur(
    p_chno IN Chercheur1.Chno%TYPE,
    p_chnom IN Chercheur1.Chnom%TYPE,
    p_grade IN Chercheur1.Grade%TYPE,
    p_statut IN Chercheur1.Statut%TYPE,
    p_daterecrut IN Chercheur1.Daterecrut%TYPE,
    p_salaire IN Chercheur1.Salaire%TYPE,
    p_prime IN Chercheur1.Prime%TYPE,
    p_email IN Chercheur1.Email%TYPE,
    p_supno IN Chercheur1.Supno%TYPE,
    p_labno IN Chercheur1.Labno%TYPE,
    p_facno IN Chercheur1.Facno%TYPE
)
AS
BEGIN
    INSERT INTO Chercheur1 (
        Chno, Chnom, Grade, Statut, Daterecrut, Salaire, Prime, Email, Supno, Labno, Facno
    ) VALUES (
        p_chno, p_chnom, p_grade, p_statut, p_daterecrut, p_salaire, p_prime, p_email, p_supno, p_labno, p_facno
    );
    
    COMMIT; -- Confirmer la transaction
END AjouterChercheur;
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
