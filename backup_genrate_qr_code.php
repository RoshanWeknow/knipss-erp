<?php 
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
include "lib_card_phpqrcode/qrlib.php";
page_header_start();
page_header_end();
page_sidebar();

$conn = $db;
if(!$conn){
	echo "connection failed<br>";
	die();
}

$db_year = substr($_SESSION['db_name'], -4); // e.g., "2025"

if(isset($_POST['submit2'])){
	$BASE_DIR = 'exam_student_qr_image/';
	$QR_FOLDER = $BASE_DIR . $db_year . '/'; // e.g., "exam_student_qr_image/2025/"

	// Create base folder if not exists
	if (!file_exists($BASE_DIR)) {
		mkdir($BASE_DIR);
	}

	// Create year-specific folder if not exists
	if (!file_exists($QR_FOLDER)) {
		mkdir($QR_FOLDER);
	}

	if (isset($_POST["student_name"])) {
		foreach ($_POST["student_name"] as $sno => $val) {
			$filename_only = $sno . '.png'; // 123.png
			$full_path = $QR_FOLDER . $filename_only; // exam_student_qr_image/2025/123.png

			$codeString  = "Full Name  - " . $_POST["student_name"][$sno] . "\n";
			$codeString .= "Father's name - " . $_POST["father_name"][$sno] . "\n";
			$codeString .= "Class - " . $_POST["class_description"][$sno] . "\n";
			$codeString .= "Date of Birth - " . $_POST["dob"][$sno] . "\n";
			$codeString .= "Mobile No - " . $_POST["mobile_no"][$sno] . "\n";
			$codeString .= "Exam Form No - " . $_POST["exam_form_no"][$sno] . "\n";
			$codeString .= "Roll No  - " . $_POST["exam_roll_no"][$sno] . "\n";
			$codeString .= "UIN Number - " . $_POST["uin_no"][$sno] . "\n";
			$codeString .= "Marks  - " . $_POST["obt_marks"][$sno] . "\n";
			$codeString .= "passing_status  - " . $_POST["passing_status"][$sno] . "\n";

			QRcode::png($codeString, $full_path);

			// Escape for SQL safety
			$sno_safe = mysqli_real_escape_string($conn, $sno);
			$path_safe = mysqli_real_escape_string($conn, $full_path);

			$sql = "UPDATE exam_student_info SET qr_code = '$path_safe' WHERE sno = '$sno_safe'";
			mysqli_query($conn, $sql);

			if(mysqli_errno($conn)){
				echo "QR update failed: " . mysqli_errno($conn) . " - " . mysqli_error($conn) . "<br>";
			}
		}
		echo "<div class='alert alert-success text-center'>QR Codes generated and saved in <b>$db_year</b> folder successfully.</div>";
	}
}
?>


<div class="row">
    <h2 class="bg-secondary text-white text-center p-2">EXAM STUDENT QR GENRATE REPORT</h2>
    <form method="POST">
        <div class="row">
            <div class="col-md-3">
                <label for="class_filter">Class</label>
                <select id="class_filter" name="class_filter" class="form-control" required>
                    <option value="">Select Class</option>
                    <?php
                    $class_query = 'SELECT * FROM class_detail WHERE semester IN ("1", "3","2","4") ORDER BY ABS(group_short) ASC';
                    $class_result = mysqli_query($db, $class_query);
                    while ($class_row = mysqli_fetch_assoc($class_result)) {
                        $selected = (isset($_POST['class_filter']) && $_POST['class_filter'] == $class_row['sno']) ? 'selected' : '';
                        echo '<option value="'.$class_row['sno'].'" '.$selected.'>'.$class_row['class_description'].'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label>&nbsp;</label><br>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>

        <div class="card-body mt-4">
            <table class="table table-striped table-hover table-bordered" id="general_stat_table">
                <tr class="bg-primary text-white text-center">
                    <td>S.No.</td>
                    <td>Full Name</td>
                    <td>Father Name</td>
                    <td>Class</td>
                    <td>Date of Birth</td>
                    <td>Mobile No</td>
                    <td>Exam Form No</td>
                    <td>Roll No</td>
                    <td>UIN Number</td>
                    <td>Marks</td>
                    <td>Passing Status</td>
                </tr>
                <?php
                if (!empty($_POST['class_filter'])) {
                    $sql1 = 'SELECT * FROM exam_student_info WHERE exam_form_no IS NOT NULL';
                    $sql1 .= ' AND course_name="' . $_POST['class_filter'] . '"';
                    $sql1 .= ' ORDER BY exam_form_no';

                    $result = mysqli_query($db, $sql1);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $sno = $row['sno'];
                            $student_info = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM student_info WHERE sno="' . $row['student_info_sno'] . '"'));
                            $class = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM class_detail WHERE sno="' . $row['course_name'] . '"'));

                            echo '<tr align="center">
                                <td>' . $sno . '</td>
                                <td><input type="text" name="student_name['.$sno.']" class="form-control" value="'.htmlspecialchars($row['student_name']).'"></td>
                                <td><input type="text" name="father_name['.$sno.']" class="form-control" value="'.htmlspecialchars($student_info['father_name']).'"></td>
                                <td><input type="text" name="class_description['.$sno.']" class="form-control" value="'.htmlspecialchars($class['class_description']).'"></td>
                                <td><input type="text" name="dob['.$sno.']" class="form-control" value="'.htmlspecialchars(date("d-m-Y", strtotime($row['dob']))).'"></td>
                                <td><input type="text" name="mobile_no['.$sno.']" class="form-control" value="'.htmlspecialchars($row['mobile_no']).'"></td>
                                <td><input type="text" name="exam_form_no['.$sno.']" class="form-control" value="'.htmlspecialchars($row['exam_form_no']).'"></td>
                                <td><input type="text" name="exam_roll_no['.$sno.']" class="form-control" value="'.htmlspecialchars($row['exam_roll_no']).'"></td>
                                <td><input type="text" name="uin_no['.$sno.']" class="form-control" value="'.htmlspecialchars($row['uin_no']).'"></td>
                                <td><input type="text" name="obt_marks['.$sno.']" class="form-control" value="'.htmlspecialchars($row['obt_marks']).'/'.htmlspecialchars($row['max_marks']).'" readonly></td>
								<td><input type="text" name="passing_status['.$sno.']" class="form-control" value="'.htmlspecialchars($row['passing_status']).'" readonly></td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="10" class="text-center text-danger">No data found for selected class.</td></tr>';
                    }
                } else {
                    echo '<tr><td colspan="10" class="text-center text-danger">Please select a class to view the data.</td></tr>';
                }
                ?>
            </table>
            <?php if (!empty($_POST['class_filter']) && mysqli_num_rows($result) > 0): ?>
                <div class="text-center">
                    <button type="submit" name="submit2" class="btn btn-success">Generate QR Codes</button>
                </div>
            <?php endif; ?>
        </div>
    </form>
</div>

<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>

<?php 
page_footer_start(); 
page_footer_end(); 
?>
