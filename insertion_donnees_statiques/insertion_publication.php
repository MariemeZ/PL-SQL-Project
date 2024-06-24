<?php


// Inclure le fichier de connexion
$conn = oci_connect('system', 'Azerty1234', 'orcl1');  // Assuming 'localhost' as the host, you can modify it based on your setup

// Vérifier la validité de la connexion
if (!$conn) {
    $e = oci_error();
    echo "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

$query_insert_publication = "
INSERT INTO PUBLICATION1 (Pubno, Titre, Theme, Type_pub, Volume, Date_pub, Apparition, Editeur)
SELECT 'Pub1', 'Titre1', 'Theme1', 'AS', 10, TO_DATE('01-01-2022', 'DD-MM-YYYY'), 'Apparition1', 'Editeur1' FROM dual
UNION ALL
SELECT 'Pub2', 'Titre2', 'Theme2', 'PC', 15, TO_DATE('01-02-2022', 'DD-MM-YYYY'), 'Apparition2', 'Editeur2' FROM dual
UNION ALL
SELECT 'Pub3', 'Titre3', 'Theme3', 'P', 8, TO_DATE('01-03-2022', 'DD-MM-YYYY'), 'Apparition3', 'Editeur3' FROM dual

";

$stid = oci_parse($conn, $query_insert_publication);

if (!$stid) {
    $e = oci_error($conn);
    echo "Erreur OCI (parse) : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}



$executeResult = oci_execute($stid);

if (!$executeResult) {
    $e = oci_error($stid);
    echo "Erreur OCI (execute) : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

oci_free_statement($stid);

// Fermeture de la connexion
oci_close($conn);

// Fonction pour exécuter une requête
function executeQuery($connection, $query) {
    $stid = oci_parse($connection, $query);

    if (!$stid) {
        $e = oci_error($connection);
        echo "Erreur OCI (parse) : " . htmlentities($e['message'], ENT_QUOTES);
        die();
    }

    $executeResult = oci_execute($stid);

    if (!$executeResult) {
        $e = oci_error($stid);
        echo "Erreur OCI (execute) : " . htmlentities($e['message'], ENT_QUOTES);
        die();
    }

    oci_free_statement($stid);
}
?>
