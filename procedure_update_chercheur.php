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
CREATE OR REPLACE PROCEDURE ModifierChercheur(
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
    UPDATE CHERCHEUR1
    SET  Chnom = COALESCE(p_chnom, Chnom),
        Grade = COALESCE(p_grade, Grade),
        Statut = COALESCE(p_statut, Statut),
        Daterecrut = COALESCE(p_daterecrut, Daterecrut),
        Prime = COALESCE(p_prime, Prime),
        Email = COALESCE(p_email, Email),
        Salaire = COALESCE(p_salaire, Salaire),
        Supno = COALESCE(p_supno, Supno),
        Labno = COALESCE(p_labno, Labno),
        Facno = COALESCE(p_facno, Facno)
    WHERE Chno = p_chno;

    COMMIT; -- Confirmer la transaction
END ModifierChercheur;
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
