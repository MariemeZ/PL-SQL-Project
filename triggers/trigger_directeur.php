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

CREATE OR REPLACE TRIGGER verif_encadrement
BEFORE INSERT  ON CHERCHEUR1
FOR EACH ROW
DECLARE
    nb_etudiants INT;
    nb_doctorants INT;
BEGIN
    IF :NEW.Grade IN ('E', 'D') THEN
        -- Calcul du nombre d'étudiants en 3ème cycle encadrés par le directeur
        SELECT COUNT(*) INTO nb_etudiants
        FROM CHERCHEUR1
        WHERE Supno = :NEW.Supno AND Grade = 'E';

        -- Calcul du nombre de doctorants encadrés par le directeur
        SELECT COUNT(*) INTO nb_doctorants
        FROM CHERCHEUR1
        WHERE Supno = :NEW.Supno AND Grade = 'D';

        -- Vérification de la capacité d'encadrement
        IF nb_etudiants > 1 OR nb_doctorants > 1 THEN
            RAISE_APPLICATION_ERROR(-20001, 'La capacité d''encadrement du directeur est dépassée.');
        END IF;
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
