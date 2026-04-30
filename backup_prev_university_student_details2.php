<?php 
include("scripts/settings.php");

$msg = '';
page_header_start();
page_header_end();
page_sidebar();
?>

<div id="container">
    <div class="card card-body">
        <div class="bg-primary text-white p-2 mb-2"><h3>Student Report</h3></div>

        <!-- Filter Dropdown for Previous University -->
        <form method="GET" action="">
            <label for="university_filter">Filter by Previous University:</label>
            <select id="university_filter" name="university_filter" class="">
                <option value="">All PG COURSE</option>
                <option value="Dr. Ram Manohar Lohia Avadh University" <?php echo (isset($_GET['university_filter']) && $_GET['university_filter'] == 'Dr. Ram Manohar Lohia Avadh University') ? 'selected' : ''; ?>>Dr. Ram Manohar Lohia Avadh University</option>
                <option value="Other" <?php echo (isset($_GET['university_filter']) && $_GET['university_filter'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                <option value="UG Course" <?php echo (isset($_GET['university_filter']) && $_GET['university_filter'] == 'UG Course') ? 'selected' : ''; ?>>UG Course</option>
            </select>

            <!-- Filter Dropdown for Class -->
            <label for="class_filter">Filter by Class:</label>
            <select id="class_filter" name="class_filter" class="">
                <option value="">All Classes</option>
                <?php
                    // Fetch all distinct class names from class_detail table
                    $class_query = "SELECT * FROM class_detail WHERE group_name IS NOT NULL";
                    $class_result = execute_query($db, $class_query);
                    while ($class_row = mysqli_fetch_assoc($class_result)) {
                        echo '<option value="' . $class_row['class_description'] . '" ' . (isset($_GET['class_filter']) && $_GET['class_filter'] == $class_row['class_description'] ? 'selected' : '') . '>' . $class_row['class_description'] . '</option>';
                    }
                ?>
            </select>

            <button type="submit" class="btn btn-success">Filter</button>
        </form>

        
            <?php
                // Get the selected filters
                $university_filter = isset($_GET['university_filter']) ? $_GET['university_filter'] : '';
                $class_filter = isset($_GET['class_filter']) ? $_GET['class_filter'] : '';

                // Build the SQL query with the filters
                $sql = 'SELECT * FROM exam_student_info WHERE 1=1';

                if ($university_filter != '') {
                    if ($university_filter == 'Other') {
                        $sql .= ' AND prev_univ != "Dr. Ram Manohar Lohia Avadh University" AND prev_univ != ""';
                    } elseif ($university_filter == 'Dr. Ram Manohar Lohia Avadh University') {
                        $sql .= ' AND prev_univ = "Dr. Ram Manohar Lohia Avadh University"';
                    } elseif ($university_filter == 'UG Course') {
                        $sql .= ' AND prev_univ = ""';
                    }
                } else {
                    // For "All PG COURSE", exclude blank prev_univ
                    $sql .= ' AND prev_univ != ""';
                }
				if ($class_filter != '') {
					$sql .= ' AND course_name IN (SELECT sno FROM class_detail WHERE class_description = "' . $class_filter . '")';
				}

				// Add ORDER BY clause to sort by course_name
				$sql .= ' ORDER BY course_name';

                $result = execute_query($db, $sql);
                $i = 1;
				?>
					<table width="100%" class="table table-striped table-hover rounded">
            <tr class="text-white bg-primary" align="center">
                <th>Sno.</th>
                <th>Student Name</th>
                <th>Class Name</th>
                <th>Father Name</th>
                <th>Gender</th>
                <th>Ledger No.</th>
                <th>UIN</th>
                <th>Category</th>
                <th>Exam Roll No.</th>
					<th>exam_name</th>
					<th>board</th>
					<th>univ_name</th>
					<th>Roll Number</th>
					<th>year</th>
					<th>Obt./Max.</th>
					
				
            </tr>
					<?php
                while($row = mysqli_fetch_assoc($result)) {
                    // Fetch the class description for each student
                    $sql_class = 'SELECT * FROM class_detail WHERE sno = "' . $row['course_name'] . '"';
                    $result_class = execute_query($db, $sql_class);
                    if (mysqli_num_rows($result_class) != 0) {
                        $row_class = mysqli_fetch_assoc($result_class);
                        $class = $row_class['class_description'];
                    } else {
                        $class = '';
                    }

                    $sql_stu_info = 'SELECT * FROM student_info WHERE sno = "' . $row['student_info_sno'] . '"';
                    $result_stu_info = execute_query($db, $sql_stu_info);
                    if (mysqli_num_rows($result_stu_info) != 0) {
                        $row_result_stu_info = mysqli_fetch_assoc($result_stu_info);
                        $father_name = $row_result_stu_info['father_name'];
                        $gender = $row_result_stu_info['gender'];
                    } else {
                        $father_name = '';
                        $gender = '';
                    }
					
					$sql_stu_qual = 'SELECT * FROM qual_detail WHERE student_id = "' . $row['student_info_sno'] . '"';
					$result_stu_qual = execute_query($db, $sql_stu_qual);

					if (mysqli_num_rows($result_stu_qual) != 0) {
                        // Main student row
                        echo '<tr align="center">
                            <td rowspan="' . (mysqli_num_rows($result_stu_qual) + 1) . '">' . $i++ . '</td>
                            <td rowspan="' . (mysqli_num_rows($result_stu_qual) + 1) . '">' . $row['student_name'] . '</td>
                            <td rowspan="' . (mysqli_num_rows($result_stu_qual) + 1) . '">' . $class . '</td>
                            <td rowspan="' . (mysqli_num_rows($result_stu_qual) + 1) . '">' . $father_name . '</td>
                            <td rowspan="' . (mysqli_num_rows($result_stu_qual) + 1) . '">' . $gender . '</td>
                            <td rowspan="' . (mysqli_num_rows($result_stu_qual) + 1) . '">' . $row['college_roll_no'] . '</td>
                            <td rowspan="' . (mysqli_num_rows($result_stu_qual) + 1) . '">' . $row['uin_no'] . '</td>
                            <td rowspan="' . (mysqli_num_rows($result_stu_qual) + 1) . '">' . $row['category'] . '</td>
                            <td rowspan="' . (mysqli_num_rows($result_stu_qual) + 1) . '">' . $row['exam_roll_no'] . '</td>';

                        
                        

                        echo '</tr>';

                        // Display qualification data in new rows
                        while ($row_result_stu_qual = mysqli_fetch_assoc($result_stu_qual)) {
                            echo '<tr align="center">
                                    <td>' . $row_result_stu_qual['exam_name'] . '</td>
                                    <td>' . $row_result_stu_qual['board'] . '</td>
									<td>' . $row_result_stu_qual['univ_name'] . '</td>
                                    <td>' . $row_result_stu_qual['roll_no'] . '</td>
									<td>' . $row_result_stu_qual['year'] . '</td>
                                    <td>' . $row_result_stu_qual['obt_marks'] . '/' . $row_result_stu_qual['tot_marks'] . '</td>
                                  </tr>';
                        }
                    }
                }
            ?>
        </table>
    </div>
</div>

<?php
page_footer_start();
page_footer_end();
?>
