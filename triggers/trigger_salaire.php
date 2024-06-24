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
CREATE OR REPLACE TRIGGER VerifDiminutionSalaire
BEFORE UPDATE ON Chercheur1
FOR EACH ROW
DECLARE
BEGIN
    IF :NEW.salaire < :OLD.salaire THEN
        RAISE_APPLICATION_ERROR(-20010, 'La diminution du salaire est interdite.');
    END IF;
END;




";
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
