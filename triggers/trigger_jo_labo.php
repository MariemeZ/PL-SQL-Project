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
// $triggerScript = "
// CREATE OR REPLACE TRIGGER VerifJoursOuvrablesLAB
// BEFORE INSERT OR UPDATE ON LABORATOIRE1
// FOR EACH ROW
// DECLARE
//     jour_semaine VARCHAR2(20);
//     heure_actuelle NUMBER;
// BEGIN
//     -- Récupérer le jour de la semaine en français (lundi, mardi, etc.)
//     SELECT TO_CHAR(SYSDATE, 'Day', 'NLS_DATE_LANGUAGE=FRENCH') INTO jour_semaine FROM DUAL;

//     -- Récupérer l'heure actuelle
//     SELECT TO_NUMBER(TO_CHAR(SYSDATE, 'HH24')) INTO heure_actuelle FROM DUAL;

//     -- Vérifier si le jour de la semaine est un jour ouvrable (lundi à vendredi) et l'heure de travail (de 8h à 18h)
//     IF jour_semaine IN ('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi','Samedi') AND heure_actuelle BETWEEN 8 AND 18 THEN
//         -- Mise à jour autorisée pendant les jours ouvrables et les heures de travail
//         NULL;
//     ELSE
//         -- Lever une exception si la mise à jour est tentée en dehors des heures de travail ou un week-end
//         RAISE_APPLICATION_ERROR(-20001, 'Les mises à jour ne sont autorisées que les jours ouvrables entre 8h et 18h.');
//     END IF;
// END;
// ";
$triggerScript="DROP TRIGGER VerifJoursOuvrablesLAB";
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
