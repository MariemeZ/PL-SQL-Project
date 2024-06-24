<?php


// Inclure le fichier de connexion
$conn = oci_connect('system', 'Azerty1234', 'orcl1');  // Assuming 'localhost' as the host, you can modify it based on your setup

// Vérifier la validité de la connexion
if (!$conn) {
    $e = oci_error();
    echo "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

$query_insert_labo = "
INSERT INTO LABORATOIRE1 (Labno, Labnom, Facno)
SELECT 1, 'Lab1', 1 FROM dual
UNION ALL
SELECT 2, 'Lab2', 1 FROM dual
UNION ALL
SELECT 3, 'Lab3', 2 FROM dual
UNION ALL
SELECT 4, 'Lab4', 2 FROM dual
";

$stid = oci_parse($conn, $query_insert_labo);

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
