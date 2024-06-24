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
$query_publier = "
    CREATE TABLE PUBLIER1 (
        Chno NUMBER,
        Pubno VARCHAR2(10),
        Rang NUMBER,
        PRIMARY KEY (Chno, Pubno),
        CONSTRAINT fk_publier_ch1 FOREIGN KEY (Chno) REFERENCES CHERCHEUR1(Chno),
        CONSTRAINT fk_publier_pub1 FOREIGN KEY (Pubno) REFERENCES PUBLICATION1(Pubno)
    )
";
executeQuery($conn, $query_publier);

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
