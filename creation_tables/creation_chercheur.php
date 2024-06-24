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

$query_chercheur = "
    CREATE TABLE CHERCHEUR1 (
        Chno NUMBER PRIMARY KEY,
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
        CONSTRAINT fk_sup1 FOREIGN KEY (Supno) REFERENCES CHERCHEUR1(Chno),
        CONSTRAINT fk_lab1 FOREIGN KEY (Labno) REFERENCES LABORATOIRE1(Labno),
        CONSTRAINT fk_fac1 FOREIGN KEY (Facno) REFERENCES FACULTE1(Facno)
    )
";
executeQuery($conn, $query_chercheur);


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
