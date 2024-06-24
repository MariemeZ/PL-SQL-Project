<?php
// Connexion à la base de données Oracle
include "connexion.php";

// Vérifier la validité de la connexion
if (!$conn) {
    $e = oci_error();
    echo "Erreur de connexion à la base de données : " . htmlentities($e['message'], ENT_QUOTES);
    die();
}

$stidEnableOutput = oci_parse($conn, "BEGIN DBMS_OUTPUT.ENABLE(NULL); END;");
oci_execute($stidEnableOutput);
oci_free_statement($stidEnableOutput);

// Vérifier si les clés 'chno' existent dans $_POST
$chno = isset($_POST['chno']) ? $_POST['chno'] : '';

// Output the value of 'chno' before the procedure execution
echo "Value of chno before procedure execution: " . $chno;

// Exécuter la procédure stockée
$sqlCallProcedure = "BEGIN SupprimerChercheur(:chno); END;";
$stidProcedure = oci_parse($conn, $sqlCallProcedure);
oci_bind_by_name($stidProcedure, ':chno', $chno);

// Exécuter la procédure
oci_execute($stidProcedure);

// Récupérer les messages de sortie avec DBMS_OUTPUT.GET_LINE
$stidGetLine = oci_parse($conn, "BEGIN DBMS_OUTPUT.GET_LINE(:output_line, :status); END;");
oci_bind_by_name($stidGetLine, ':output_line', $outputLine, 255);
oci_bind_by_name($stidGetLine, ':status', $status, 1);

// Stocker les messages dans un tableau
$outputMessages = array();

while ($status == 0) {
    $outputMessages[] = $outputLine;
    oci_execute($stidGetLine);
}

// Close the output buffering
ob_end_clean();

// Produire une réponse JSON
$response = array();

if (!empty($outputMessages)) {
    $response['success'] = true;
    $response['messages'] = $outputMessages;
} else {
    $response['success'] = false;
    $response['error'] = "Aucun message récupéré.";
}

// Set the content type header and output the JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Fermer les statements
oci_free_statement($stidProcedure);
oci_free_statement($stidGetLine);
oci_close($conn);
?>
