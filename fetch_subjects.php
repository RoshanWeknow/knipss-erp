<?php
include("settings.php");


if(isset($_POST['table'])) {
    $table = $_POST['table']; // Get table name from AJAX request

    // Validate table name to prevent SQL injection
    $allowedTables = ['add_subject', 'add_subject2'];
    if (!in_array($table, $allowedTables)) {
        echo '<option value="">Invalid Table</option>';
        exit;
    }

    $sql = "SELECT sno, subject FROM $table"; // Fetch subjects
    $result = mysqli_query($db, $sql);

    if(mysqli_num_rows($result) > 0) {
        echo '<option disabled selected>---Select Subject---</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['sno'] . '">' . $row['subject'] . '</option>';
        }
    } else {
        echo '<option value="">No Subjects Found</option>';
    }
} else {
    echo '<option value="">Invalid Request</option>';
}
?>


