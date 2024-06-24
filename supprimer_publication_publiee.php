<?php
// Connexion à la base de données Oracle
//$conn = oci_connect('system', 'Azerty1234', 'orcl1');
include 'connexion.php';
// Vérifier la validité de la connexion
if (!$conn) {
    $e = oci_error();
    echo json_encode(['success' => false, 'message' => "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES)]);
    die();
}

// Vérifier si chno et pubno sont passés en paramètre
if (isset($_POST['chno']) && isset($_POST['pubno'])) {
    $chno = $_POST['chno'];
    $pubno = $_POST['pubno'];

    // Supprimer la publication publiée
    $queryDelete = "DELETE FROM PUBLIER1 WHERE Chno = :chno AND Pubno = :pubno";
    $stidDelete = oci_parse($conn, $queryDelete);
    oci_bind_by_name($stidDelete, ':chno', $chno);
    oci_bind_by_name($stidDelete, ':pubno', $pubno);

    if (oci_execute($stidDelete)) {
        // Succès de la suppression
        echo json_encode(['success' => true, 'message' => 'Publication supprimée avec succès.']);
    } else {
        // Échec de la suppression
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression de la publication.']);
    }

    // Fermer la connexion
    oci_free_statement($stidDelete);
    oci_close($conn);
} else {
    // chno ou pubno n'est pas défini
    echo json_encode(['success' => false, 'message' => 'Les identifiants uniques du chercheur et de la publication ne sont pas définis.']);
}
?>
