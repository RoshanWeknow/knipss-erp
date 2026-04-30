<?php

include("scripts/settings.php");



// Get the search term from the request
$term = isset($_GET['term']) ? $_GET['term'] : '';

// Prepare the SQL statement with a LIKE clause for filtering
$sql = "SELECT sno, full_name FROM dp_invoice_personal_info WHERE full_name LIKE ?";
$stmt = $db->prepare($sql);

// Use a wildcard search pattern
$searchTerm = "%" . $term . "%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();

$result = $stmt->get_result();
$suggestions = [];

// Fetch results and prepare them in the format needed for autocomplete
while ($row = $result->fetch_assoc()) {
    $suggestions[] = [
        'id' => $row['sno'],
        'label' => $row['full_name'], // Displayed text
        'value' => $row['full_name']  // Value inserted into the input box
    ];
}

// Return the suggestions as a JSON array
echo json_encode($suggestions);

// Close connections
$stmt->close();
$db->close();




	page_footer_start();
	page_footer_end();
	?>
