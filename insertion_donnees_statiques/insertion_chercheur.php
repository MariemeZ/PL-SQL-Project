<?php


// Inclure le fichier de connexion
$conn = oci_connect('system', 'Azerty1234', 'orcl1');  // Assuming 'localhost' as the host, you can modify it based on your setup

// Vérifier la validité de la connexion
if (!$conn) {
    $e = oci_error();
    echo "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

$query_insert_chercheur = "
INSERT INTO CHERCHEUR1 (Chno, Chnom, Grade, Statut, Daterecrut, Salaire, Prime, Email, Supno, Labno, Facno)
SELECT 1, 'Chercheur1', 'PR', 'P', TO_DATE('01-01-2022', 'DD-MM-YYYY'), 50000, 1000, 'email1@example.com', NULL, 1, 1 FROM dual
UNION ALL
SELECT 2, 'Chercheur2', 'D', 'C', TO_DATE('01-01-2022', 'DD-MM-YYYY'), 45000, 800, 'email2@example.com', 1, 1, 1 FROM dual
UNION ALL
SELECT 3, 'Chercheur3', 'E', 'P', TO_DATE('01-01-2022', 'DD-MM-YYYY'), 60000, 1200, 'email3@example.com', NULL, 2, 2 FROM dual
";

$stid = oci_parse($conn, $query_insert_chercheur);

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
