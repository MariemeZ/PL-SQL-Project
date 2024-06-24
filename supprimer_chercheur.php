<?php
// Inclure le fichier de connexion à la base de données
//$conn = oci_connect('system', 'Azerty1234', 'orcl1');
include 'connexion.php';
// Vérifier la validité de la connexion
if (!$conn) {
    $response = ['success' => false, 'message' => 'Erreur de connexion à la base de données.'];
    echo json_encode($response);
    die();
}

// Récupérer le numéro du chercheur à supprimer
$chno = isset($_POST['chno']) ? $_POST['chno'] : '';

// Préparer la requête de suppression
$queryDelete = "DELETE FROM CHERCHEUR1 WHERE CHNO = :chno";
$stid = oci_parse($conn, $queryDelete);
oci_bind_by_name($stid, ':chno', $chno);

// Exécuter la requête
$executeResult = oci_execute($stid);

// Vérifier si la suppression a réussi
if ($executeResult) {
    $response = ['success' => true, 'message' => 'Chercheur supprimé avec succès.'];
} else {
    $e = oci_error($stid);
    $response = ['success' => false, 'message' => 'Erreur OCI : ' . htmlentities($e['message'], ENT_QUOTES)];
}

// Fermer la connexion
oci_free_statement($stid);
oci_close($conn);

// Retourner la réponse en format JSON
echo json_encode($response);
?>
