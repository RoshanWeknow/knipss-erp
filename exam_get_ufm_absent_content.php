<?php
set_time_limit(0);
include("scripts/settings.php");
$conn = $db;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if(isset($_POST['selectedDate']) && $_POST['selectedDate']!=""){
	$selectedDate = $_POST['selectedDate'];

    // $selectSubjectSql="SELECT * FROM exam_examination_scheme LEFT JOIN class_detail on exam_examination_scheme.class=class_detail.class_description WHERE date = '$selectedDate' ORDER BY shift";
    
    $selectSubjectSql="SELECT exam_examination_scheme.class,exam_examination_scheme.subject,exam_examination_scheme.paper_code,exam_examination_scheme.paper_title,exam_examination_scheme.subject_type,exam_examination_scheme.shift,exam_examination_scheme.time,class_detail.sno AS classsno FROM exam_examination_scheme LEFT JOIN class_detail on exam_examination_scheme.class=class_detail.class_description WHERE date = '$selectedDate' ORDER BY shift";
    

	$selectSubjectRes=mysqli_query($db,$selectSubjectSql);
	
	$sub = array();
    $i=1;
	while($selectSubjectRow=mysqli_fetch_assoc($selectSubjectRes)){
        $paperCode = $selectSubjectRow['paper_code'];
        $classId=$selectSubjectRow['classsno'];
        $sub[$i] = $selectSubjectRow;
        $studentCountSql = "SELECT COUNT(paper_code) as count FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_paper_info.exam_student_info_sno=exam_student_info.sno WHERE paper_code = '$paperCode' and class_id='$classId'";
        // $studentCountSql = "SELECT COUNT(paper_code) as count FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_paper_info.exam_student_info_sno=exam_student_info.sno WHERE paper_code = '$paperCode' and class_id='110'";
        $studentCountRes = mysqli_query($db, $studentCountSql);

        // Fetch the additional data
        $studentCountRow = mysqli_fetch_assoc($studentCountRes);
        $sub[$i]['count'] = $studentCountRow['count'];
        $i++;
	}

	
	echo json_encode($sub);
}

// if(isset($_POST['selectedDateForReport']) && $_POST['selectedDateForReport']!=""){
    
// }


?>
