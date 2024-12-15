<!-- UNTUK SEND -->
<?php
// Set content type as JSON
header("Content-Type: application/json");

// Check if POST data is received
if (isset($_POST['name']) && isset($_POST['city'])) {
    // Retrieve values from POST data
    $name = $_POST['name'];
    $city = $_POST['city'];

    // Prepare an associative array to send back
    $response = [
        "name" => $name,
        "city" => $city
    ];

    // Send JSON response
    echo json_encode($response);
} else {
    // If any data is missing, send an error message
    $response = [
        "error" => "Missing 'name' or 'city' data"
    ];
    echo json_encode($response);
}
?>

