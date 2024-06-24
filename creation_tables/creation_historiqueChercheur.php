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

$query_HISTORIQUE_CHERCHEUR = "
CREATE TABLE HISTORIQUE_CHERCHEUR1 (
    Code  NUMBER GENERATED ALWAYS AS IDENTITY,
    Chno NUMBER,
    Chnom VARCHAR2(50),
    Grade VARCHAR2(2) CHECK (Grade IN ('E', 'D', 'A', 'MA', 'MC', 'PR')),
    Statut VARCHAR2(1) CHECK (Statut IN ('P', 'C')),
    Daterecrut DATE,
    Salaire NUMBER,
    Prime NUMBER,
    Email VARCHAR2(100),
    Supno NUMBER,
    Labno NUMBER,
    Facno NUMBER,
    DateModification DATE,
    PRIMARY KEY (Code)
)
";
executeQuery($conn, $query_HISTORIQUE_CHERCHEUR);



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
