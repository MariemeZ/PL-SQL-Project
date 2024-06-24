<?php

// Inclure le fichier de connexion
$conn = oci_connect('system','Azerty1234', 'orcl1');

// Vérifier la validité de la connexion
if (!$conn) {
    $e = oci_error();
    echo "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

//Définir le script du déclencheur
$triggerScript = "
CREATE OR REPLACE TRIGGER Copie
BEFORE DELETE OR UPDATE ON CHERCHEUR1
FOR EACH ROW
-- DECLARE 
--     MAX_temperature NUMBER;
BEGIN
  
    IF DELETING OR UPDATING THEN
        INSERT INTO HISTORIQUE_CHERCHEUR1 (
        Chno, Chnom, Grade, Statut, Daterecrut, Salaire, Prime,
        Email, Supno, Labno, Facno, DateModification
    ) VALUES (
        :OLD.Chno, :OLD.Chnom, :OLD.Grade, :OLD.Statut, :OLD.Daterecrut,
        :OLD.Salaire, :OLD.Prime, :OLD.Email, :OLD.Supno, :OLD.Labno,
        :OLD.Facno, SYSDATE
    );
        
    END IF;
END;


";
// $triggerScript="DROP TRIGGER copie";
// Préparer la requête
$stid = oci_parse($conn, $triggerScript);


// Vérifier si la préparation a réussi
if (!$stid) {
    $e = oci_error($conn);
    echo "Erreur OCI (parse) : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

// Exécuter la requête
$executeResult = oci_execute($stid);

// Vérifier si l'exécution a réussi
if (!$executeResult) {
    $e = oci_error($stid);
    echo "Erreur OCI (execute) : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}
if ($executeResult) {
    echo "yes";
}

// Fermer la connexion
oci_free_statement($stid);
oci_close($conn);

?>
