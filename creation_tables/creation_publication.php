<?php

// Inclure le fichier de connexion
$conn = oci_connect('system','Azerty1234', 'orcl1');

// Vérifier la validité de la connexion
if (!$conn) {
    $e = oci_error();
    echo "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

// Suppression des tables existantes s'il y en a
$query_publication = "
    CREATE TABLE PUBLICATION1 (
        Pubno VARCHAR2(10) PRIMARY KEY,
        Titre VARCHAR2(100),
        Theme VARCHAR2(50),
        Type_pub VARCHAR2(2) CHECK (Type_pub IN ('AS', 'PC', 'P', 'L', 'T', 'M')),
        Volume NUMBER,
        Date_pub DATE,
        Apparition VARCHAR2(100),
        Editeur VARCHAR2(50)
    )
";
executeQuery($conn, $query_publication);


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
