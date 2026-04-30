<?php 
	include("scripts/settings.php");
	include("scripts/settings_dbase_uin.php");
	$msg = '';
	$tab = 1;
	$response = 1;
	page_header_start();
	page_header_end();
	page_sidebar();
?>
	<div class="card card-body">
		<form method="GET" action="">
			<div>
				<label>Filter by Class:</label>
				<input type="text" name="class" value="<?php echo isset($_GET['class']) ? $_GET['class'] : ''; ?>">
				<label>Exam Form Status:</label>
				<select name="exam_form_status">
					<option value="">All</option>
					<option value="filled" <?php if (isset($_GET['exam_form_status']) && $_GET['exam_form_status'] == 'filled') echo 'selected'; ?>>Filled</option>
					<option value="not_filled" <?php if (isset($_GET['exam_form_status']) && $_GET['exam_form_status'] == 'not_filled') echo 'selected'; ?>>Not Filled</option>
				</select>
				<button type="submit">Filter</button>
			</div>
		</form>

		<table class="table table-striped table-hover rounded">
			<tr class="bg-primary text-white">
				<td>S.No.</td>
				<td>Full Name</td>
				<td>Father Name</td>
				<td>Class</td>
				<td>College Roll No</td>
				<td>UIN Number</td>
				<td>Exam Roll Number</td>
				<td>Status</td>
			</tr>
			<?php
				$serial_no = 1;
				$temp_id = 1;

				$class_filter = isset($_GET['class']) ? $_GET['class'] : '';
				$exam_form_status = isset($_GET['exam_form_status']) ? $_GET['exam_form_status'] : '';

				$sql = 'SELECT student_info.stu_name, student_info.sno, student_info.father_name, 
							   student_info.roll_no, student_info.class, student_info.university_uin, 
							   exam_student_info.student_info_sno, exam_student_info.exam_form_no 
						FROM student_info 
						JOIN exam_student_info ON student_info.sno = exam_student_info.student_info_sno 
						WHERE university_uin IS NOT NULL 
						AND (university_uin LIKE "KNI%" OR university_uin LIKE "kni%")';

				if ($class_filter) {
					$sql .= ' AND student_info.class = "' . mysqli_real_escape_string($db, $class_filter) . '"';
				}

				if ($exam_form_status === 'filled') {
					$sql .= ' AND exam_student_info.exam_form_no IS NOT NULL';
				} elseif ($exam_form_status === 'not_filled') {
					$sql .= ' AND exam_student_info.exam_form_no IS NULL';
				}

				$sql .= ' ORDER BY university_uin ASC';

				$res = execute_query($db, $sql);
				if ($res && mysqli_num_rows($res) > 0) while ($row = mysqli_fetch_assoc($res)) {
			?>

			<tr>
				<td><?php echo $serial_no++ ?></td>
				<td><?php echo $row['stu_name'] ?></td>
				<td><?php echo $row['father_name'] ?></td>
				<td><?php echo $row['class'] ?></td>
				<td><?php echo $row['roll_no'] ?></td>
				<td><?php echo $row['university_uin'] ?></td>
				<td><?php 
					if (empty($row['exam_form_no'])) {
						echo "<p style='color:red;'>Not Filled</p>";
					} else {
						echo $row['exam_form_no'];
					}
				?></td>
			</tr>
			<?php 
				}
			?>
		</table>	
	</div>
<?php
	page_footer_start();
	page_footer_end();
?>
