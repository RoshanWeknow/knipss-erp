<?php 
include("scripts/settings.php");

$response=1;
$msg='';
page_header_start();
page_header_end();
page_sidebar();
?>
<div id="container">
	<div class="card card-body">
		<!-- Filter Form -->
		<form method="POST" action="">
			<div class="row">
				<div class="col-md-6">
					<label for="semester">Select Semester:</label>
					<select name="semester" id="semester" class="form-control">
						<option value="">All Semesters</option>
						<option value="1">Semester 1</option>
						<option value="2">Semester 2</option>
						<!-- Add more semesters as needed -->
					</select>
				</div>
				<div class="col-md-6">
					<label for="class">Select Class:</label>
					<select name="class" id="class" class="form-control">
						<option value="">All Classes</option>
						<?php
// Fetching classes dynamically from class_detail table
$sql_classes = 'SELECT sno, class_description, semester FROM class_detail WHERE semester IN (1, 2)';
$result_classes = mysqli_query($db, $sql_classes);
if ($result_classes) {
    while($class = mysqli_fetch_assoc($result_classes)) {
        echo '<option value="' . $class['sno'] . '">' . $class['class_description'] . '</option>';
    }
} else {
    echo '<option disabled>No classes available</option>';
}
?>

					</select>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-12 text-center">
					<input type="submit" name="filter" value="Filter" class="btn btn-primary">
				</div>
			</div>
		</form>

		<!-- Data Table -->
		<table class="table table-striped table-hover table-sm rounded">
			<tr class="bg-primary text-white">
				<td>Sno</td>
				<td>Semester</td>
				<td>Exam Year</td>
				<td>Course</td>
				<td>Crasslist View</td>
				<td>Download</td>
			</tr>
			<?php
				// Default query without filter
				$query = 'SELECT * FROM exam_crasslist_pdf_store';

				// Modify query if filters are applied
				if(isset($_POST['filter'])) {
					$semester = $_POST['semester'];
					$class = $_POST['class'];
					$query .= ' WHERE 1=1'; // To easily append conditions
					
					if(!empty($semester)) {
						$query .= ' AND exam_semester = "' . $semester . '"';
					}
					if(!empty($class)) {
						$query .= ' AND class_details_sno = "' . $class . '"';
					}
				}

				$result = execute_query($db, $query);
				$i = 1;
				while($row = mysqli_fetch_assoc($result)) {
					$sql_class = 'SELECT * FROM class_detail WHERE sno="' . $row['class_details_sno'] . '"';
					$result_class = mysqli_query($db, $sql_class);
					$row_class = mysqli_fetch_assoc($result_class);
			?>
			<tr>
				<td><?php echo $i++; ?></td>
				<td><?php echo $row['exam_semester']; ?></td>
				<td><?php echo $row['exam_year']; ?></td>
				<td><?php echo $row_class['class_description']; ?></td>
				<td>
					<form action="crass_pdf_open.php" method="POST" target="_blank">
						<input type="hidden" name="pdf_path" value="<?php echo $row['pdf_path'] ?>">
						<input type="submit" value="View" class="btn btn-success btn-sm" style="width:120px;margin:auto;">
					</form>
				</td>
				<td>
					<a href="<?php echo $row['pdf_path']; ?>" download class="btn btn-primary btn-sm" style="width:120px;margin:auto;">Download</a>
				</td>
			</tr>
			<?php
				}
			?>
		</table>	
	</div>
</div>


<?php 
page_footer_start(); 
page_footer_end(); 

?>
