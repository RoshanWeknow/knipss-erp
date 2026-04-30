<?php
include("scripts/settings.php");

if (isset($_POST['student_info_sno']) && isset($_POST['verify_status'])) {
    $student_info_sno = $_POST['student_info_sno'];
    $verify_status = $_POST['verify_status'];

    $sql = "UPDATE back_exam_student_info SET 
        verify_status = '$verify_status',
        verify_by = '{$_SESSION['username']}',
        verify_time = '" . date('Y-m-d H:i:s') . "'
        WHERE student_info_sno = '$student_info_sno'";

    if (mysqli_query($db, $sql)) {
        echo 'Status updated successfully';
    } else {
        echo 'Error updating status: ' . mysqli_error($db);
    }
}

?>
