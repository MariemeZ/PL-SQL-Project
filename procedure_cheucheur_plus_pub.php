<?php
// Connexion à la base de données Oracle
//$conn = oci_connect('system', 'Azerty1234', 'orcl1');
include 'connexion.php';
// Vérifier la validité de la connexion
if (!$conn) {
    $e = oci_error();
    echo "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

// Corps de la procédure stockée ChercheursAvecPlusDePublications
$sqlProcedure = "
CREATE OR REPLACE PROCEDURE ChercheursAvecPlusDePublications(
    p_date_debut IN DATE,
    p_date_fin IN DATE 
)
AS
     v_noms VARCHAR2(4000) := '';
BEGIN

    FOR row_data IN (
        SELECT
            fac.Facno,
            lab.Labno,
            COUNT(publi.Pubno) AS nb_publications,
            ROW_NUMBER() OVER (PARTITION BY fac.Facno ORDER BY COUNT(publi.Pubno) DESC) AS rnk
        FROM
            FACULTE1 fac
            JOIN LABORATOIRE1 lab ON fac.Facno = lab.Facno
            JOIN CHERCHEUR1 cher ON lab.Labno = cher.Labno
            JOIN PUBLIER1 pub ON cher.Chno = pub.Chno
            JOIN PUBLICATION1 publi ON pub.Pubno = publi.Pubno
        WHERE
            publi.Date_pub BETWEEN p_date_debut AND p_date_fin
        GROUP BY
            fac.Facno, lab.Labno
    )
    LOOP
        IF (row_data.rnk = 1) THEN
            v_noms := '';
            FOR nom IN (SELECT Chnom FROM CHERCHEUR1 WHERE Labno = row_data.Labno AND Facno =row_data.Facno) LOOP
                -- Concaténer les noms dans une chaîne
                v_noms := v_noms || nom.Chnom || ', ';
            END LOOP;
            
            -- Afficher les résultats (remplacez cette partie avec le code d'affichage que vous souhaitez)
            DBMS_OUTPUT.PUT_LINE('Faculté ' || row_data.Facno || ', Laboratoire ' || row_data.Labno || ': ' ||
                                 v_noms || ', ' ||
                                 'Nombre de publications: ' || row_data.nb_publications);
        END IF;
    END LOOP;
END ChercheursAvecPlusDePublications;

";

// Préparation et exécution du script
$stidProcedure = oci_parse($conn, $sqlProcedure);
$executeResult = oci_execute($stidProcedure);

// Vérifier si l'exécution a réussi
if (!$executeResult) {
    $e = oci_error($stidProcedure);
    echo "Erreur OCI (execute) : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

echo "Procédure stockée créée avec succès.";

// Fermer la connexion
oci_free_statement($stidProcedure);
oci_close($conn);
?>
