<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
$response = 1;
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
    
    $sql = 'SELECT DISTINCT title_of_paper, paper_code FROM add_subject_details 
            WHERE theory_practical = "Practical" AND class_id = ? ORDER BY paper_code';
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $class_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo '<option value="'.$row['paper_code'].'">'.$row['paper_code'].' - '.$row['title_of_paper'].'</option>';
    }
}
?>