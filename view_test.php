<?php

// Inclure le fichier de connexion
//$conn = oci_connect('system','Azerty1234', 'orcl1');
include 'connexion.php';
// Vérifier la validité de la connexion
if (!$conn) {
    $e = oci_error();
    echo "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

// Sélectionner toutes les colonnes de la table FACULTE
$query_select_faculte = "SELECT * FROM test";

// Exécuter la requête
$result = oci_parse($conn, $query_select_faculte);
oci_execute($result);

// Afficher les résultats
echo "<h2>Contenu de la table FACULTE :</h2>";
echo "<table border='1'>";
echo "<tr><th>Facno</th><th>Facnom</th><th>Adresse</th><th>Libelle</th></tr>";

while ($row = oci_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['FACNO'] . "</td>";
    echo "<td>" . $row['FACNOM'] . "</td>";
    echo "<td>" . $row['ADRESSE'] . "</td>";
    echo "<td>" . $row['LIBELLE'] . "</td>";
    echo "</tr>";
}

echo "</table>";

// Fermer la connexion
oci_free_statement($result);
oci_close($conn);

?>
