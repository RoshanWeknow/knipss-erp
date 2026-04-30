<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
page_header_start();
page_header_end();
page_sidebar();

if(isset($_GET['course_filter'])){
    $course_filter = $_GET['course_filter'];
    $classes = array(76, 60, 87);
    $ql = 'SELECT * FROM class_detail WHERE sno="' . mysqli_real_escape_string($db, $course_filter) . '"';
    $class_detail_result = execute_query($db, $ql);
    $class_detail = mysqli_fetch_assoc($class_detail_result);
    
    if(!in_array($course_filter, $classes)){
        $sql = 'SELECT phd_entrance_admission_student_info.sno AS sno, phd_entrance_admission_student_info.uin AS uin, phd_entrance_admission_student_info.course_applying_for AS course_applying_for, phd_entrance_admission_student_info.candidate_name AS candidate_name, phd_entrance_admission_student_info.father_name AS father_name, phd_entrance_admission_student_info.gender AS gender, phd_entrance_admission_student_info.category AS category, phd_entrance_admission_student_info.mobile AS mobile, phd_entrance_admission_student_info.email AS email, phd_entrance_admission_student_info.signature AS signature, phd_entrance_admission_student_info.photo AS photo, phd_entrance_student_info.roll_no AS roll_no FROM phd_entrance_admission_student_info LEFT JOIN phd_entrance_student_info ON phd_entrance_student_info.sno = phd_entrance_admission_student_info.student_id WHERE phd_entrance_admission_student_info.course_applying_for = "' . mysqli_real_escape_string($db, $course_filter) . '" AND uin IS NOT NULL ORDER BY phd_entrance_student_info.roll_no';
    } else {
        $sql = 'SELECT entrance_admission_student_info.sno AS sno, entrance_admission_student_info.uin AS uin, entrance_admission_student_info.course_applying_for AS course_applying_for, entrance_admission_student_info.candidate_name AS candidate_name, entrance_admission_student_info.father_name AS father_name, entrance_admission_student_info.gender AS gender, entrance_admission_student_info.category AS category, entrance_admission_student_info.mobile AS mobile, entrance_admission_student_info.email AS email, entrance_admission_student_info.signature AS signature, entrance_admission_student_info.photo AS photo, entrance_student_info.roll_no AS roll_no FROM entrance_admission_student_info LEFT JOIN entrance_student_info ON entrance_student_info.sno = entrance_admission_student_info.student_id WHERE entrance_admission_student_info.course_applying_for = "' . mysqli_real_escape_string($db, $course_filter) . '" AND uin IS NOT NULL ORDER BY entrance_student_info.roll_no LIMIT 50';
    }
    $res = mysqli_query($db2, $sql);
}

if(isset($_POST['save'])){
    $i = 1;
    while(isset($_POST['class_description_' . $i])){
        if($_POST['class_description_' . $i] != ''){
            if(isset($_POST['edit']) && $_POST['edit'] != ''){
                $sql2 = 'UPDATE entrance_student_info SET 
                        class_description="' . mysqli_real_escape_string($db, $_POST['class_description_' . $i]) . '",
                        roll_no="' . mysqli_real_escape_string($db, $_POST['roll_no_' . $i]) . '",
                        form_number="' . mysqli_real_escape_string($db, $_POST['form_number_' . $i]) . '",
                        candidate_name="' . mysqli_real_escape_string($db, $_POST['candidate_name_' . $i]) . '",
                        father_name="' . mysqli_real_escape_string($db, $_POST['father_name_' . $i]) . '",
                        max_marks="' . mysqli_real_escape_string($db, $_POST['max_marks_' . $i]) . '",
                        obt_marks="' . mysqli_real_escape_string($db, $_POST['obt_marks_' . $i]) . '",
                        edited_by="' . mysqli_real_escape_string($db, $_SESSION['username']) . '",
                        edition_time="' . date('Y-m-d H:i:s') . '"
                        WHERE sno = ' . intval($_POST['edit']);
                execute_query($db, $sql2);
                if(mysqli_errno($db)){
                    echo "Updation failed: " . mysqli_errno($db) . " " . mysqli_error($db);
                } else {
                    echo "Successfully updated";
                }
            } else {
                $sql2 = 'INSERT INTO entrance_student_info (class_description, roll_no, form_number, candidate_name, father_name, max_marks, obt_marks) VALUES (
                        "' . mysqli_real_escape_string($db, $_POST['class_description_' . $i]) . '",
                        "' . mysqli_real_escape_string($db, $_POST['roll_no_' . $i]) . '",
                        "' . mysqli_real_escape_string($db, $_POST['form_number_' . $i]) . '",
                        "' . mysqli_real_escape_string($db, $_POST['candidate_name_' . $i]) . '",
                        "' . mysqli_real_escape_string($db, $_POST['father_name_' . $i]) . '",
                        "' . mysqli_real_escape_string($db, $_POST['max_marks_' . $i]) . '",
                        "' . mysqli_real_escape_string($db, $_POST['obt_marks_' . $i]) . '"
                )';
                execute_query($db, $sql2);
                if(mysqli_errno($db)){
                    echo "Insertion failed: " . mysqli_errno($db) . " " . mysqli_error($db);
                } else {
                    echo "Data inserted";
                }
            }
        }
        $i++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <title>Entrance Marks Feeding</title>
    <style>
        .no-border {
            border: none;
            text-align: center;
        }
    </style>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,700&display=swap" rel="stylesheet" />
</head>
<body class="w-100 m-auto">
    <div id="container">
        <h2 scope="col" colspan="5" class="bg-primary text-white text-center p-3 no-print"><u>ENTRANCE EXAMINATION MARKS FEEDING SHEETS 2024</u></h2>
        <div class="card card-body">
            <div class="row d-flex my-auto">
                <h4 class="text-end me-5">Max. Marks : <input type="text" id="max_marks1" /></h4>
                <div class="col-md-12">
                    <!-- first row -->
                    <table width="100%" class="table text-center">
                        <tr class="bg-primary text-white text-center p-1">
                            <th>Sno</th>
                            <th>Course Name</th>
                            <th>Roll No.</th>
                            <th>Form No.</th>
                            <th>Name</th>
                            <th>Father's Name</th>
                            <th>Max. Marks</th>
                            <th>Obt. Marks</th>
                        </tr>
                        <form action="entrance_marks_feed_print.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
                        <?php
                        $i = 1;
                        while($row = mysqli_fetch_assoc($res)){
                        ?>
                            <tr>
								<th><?php echo $i; ?></th>
								<th><input type="text" name="class_description_<?php echo $i; ?>" id="class_description_<?php echo $i; ?>" value="<?php echo htmlspecialchars($class_detail['class_description']); ?>" class="form-control no-border" tabindex="<?php echo $i * 6 + 1; ?>" readonly></th>
								<th><input type="text" name="roll_no_<?php echo $i; ?>" id="roll_no_<?php echo $i; ?>" value="<?php echo htmlspecialchars($row['roll_no']); ?>" class="form-control no-border" tabindex="<?php echo $i * 6 + 2; ?>" readonly></th>
								<th><input id="form_number_<?php echo $i; ?>" name="form_number_<?php echo $i; ?>" value="<?php echo htmlspecialchars($row['uin']); ?>" class="form-control no-border" tabindex="<?php echo $i * 6 + 3; ?>" readonly></th>
								<th><input id="candidate_name_<?php echo $i; ?>" name="candidate_name_<?php echo $i; ?>" value="<?php echo htmlspecialchars($row['candidate_name']); ?>" class="form-control no-border" tabindex="<?php echo $i * 6 + 4; ?>" readonly></th>
								<th><input id="father_name_<?php echo $i; ?>" name="father_name_<?php echo $i; ?>" value="<?php echo htmlspecialchars($row['father_name']); ?>" class="form-control no-border" tabindex="<?php echo $i * 6 + 5; ?>" readonly></th>
								<th><input class="max_marks_input form-control no-border" id="max_marks_<?php echo $i; ?>" name="max_marks_<?php echo $i; ?>" value="" class="form-control" tabindex="6" readonly></th>
								<th><input id="obt_marks_<?php echo $i; ?>" name="obt_marks_<?php echo $i; ?>" value="" class="form-control" tabindex="7"></th>
							</tr>

							<script>
								document.addEventListener('DOMContentLoaded', function() {
									var maxMarksInputs = document.querySelectorAll('.max_marks_input');
									var originalMaxMarksInput = document.getElementById('max_marks1');

									if (originalMaxMarksInput) {
										originalMaxMarksInput.addEventListener('input', function() {
											var maxMarksValue = this.value;
											maxMarksInputs.forEach(function(input) {
												input.value = maxMarksValue;
											});
										});
									}
								});
							</script>
							 <?php
                            $i++;
                        }
                        ?>

                        </table>
                        <br />
                        <button type="submit" class="btn btn-primary ms-4" name="save" value="">Submit</button>
                        <input type="hidden" name="edit" value="<?php echo isset($_GET['edit']) ? intval($_GET['edit']) : ''; ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <?php 
    page_footer_start();
    page_footer_end();
    ?>
</body>
</html>
