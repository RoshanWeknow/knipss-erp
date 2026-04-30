<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg = '';
$tabindex = 1; // Initialize tabindex
page_header_start();
page_header_end();
page_sidebar();
?>
<html>
<head>
    <title>Nominal List</title>
    <link rel="stylesheet" href="css/light-bootstrap-dashboard.css">
</head>
<body>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo $msg; ?>
                        <div class="col-md-12">
                            <h2 class="bg-primary text-white p-2">Nominal List</h2>
                            <!-- First Row -->
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Course</label>
                                    <select name="course" id="course" class="form-control" tabindex="<?php echo $tabindex++; ?>" required>
                                        <option disabled <?php echo isset($_GET['id']) ? "" : 'selected="selected"'; ?>>---Select Course---</option>
                                        <?php 
                                        $sql = 'SELECT * FROM class_detail WHERE semester IN ("1","3") AND group_name IS NOT NULL ORDER BY ABS(group_short) ASC';
                                        $dept_list = execute_query($db, $sql);
                                        if ($dept_list) {
                                            while ($list = mysqli_fetch_assoc($dept_list)) {
                                                echo '<option value="' . $list['sno'] . '">' . htmlspecialchars($list['class_description']) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <button type="submit" name="submit" value="save" class="btn btn-primary mt-2 ms-2">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course'])){ ?>
        <table class="table table-striped table-hover" id="general_stat_table">
            <thead>
                <tr class="bg-primary text-white">
                    <th scope="col">Sr. No</th>
                    <th scope="col">Student Type</th>
                    <th scope="col">Year Part</th>
                    <th scope="col">Roll No.</th>
                    <th scope="col">Form Number</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Father's Name</th>
                    <th scope="col">Title of Paper</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (isset($_POST['course'])) {
                $course = mysqli_real_escape_string($db, $_POST['course']);
                $query = "SELECT * FROM exam_student_info WHERE course_name = '$course' AND exam_roll_no IS NOT NULL AND exam_roll_no != ''";
            } else {
                $query = "SELECT * FROM exam_student_info WHERE exam_roll_no IS NOT NULL AND exam_roll_no != ''";
            }

            $result = execute_query($db, $query);
            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $query_class = "SELECT class_description FROM class_detail WHERE sno = '" . $row['course_name'] . "'";
                $result_class = execute_query($db, $query_class);
                $row_class = mysqli_fetch_assoc($result_class);
                $class = isset($row_class['class_description']) ? $row_class['class_description'] : '----';
				
				$query_stu = "SELECT father_name FROM student_info WHERE sno = '" . $row['student_info_sno'] . "'";
                $result_stu = execute_query($db, $query_stu);
                $row_stu = mysqli_fetch_assoc($result_stu);

                $query_stu_info = "SELECT title_of_paper, paper_code, theory_practical FROM exam_student_paper_info WHERE exam_student_info_sno = '" . $row['sno'] . "' AND theory_practical != 'Practical'";
                $result_stu_info = execute_query($db, $query_stu_info);
                $all_papers = [];
                $k = 1;
                while ($row_paper = mysqli_fetch_assoc($result_stu_info)) {
                    if (isset($row_paper['title_of_paper'], $row_paper['paper_code'])) {
                        $all_papers[] = "&nbsp;&nbsp;&nbsp;" . $k++ . ". " . $row_paper['title_of_paper'] . " (" . $row_paper['paper_code'] . ")";
                    }
                }
                $paper_titles = implode(' ', $all_papers);
                ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row['student_type']; ?></td>
                    <td><?php echo $class; ?></td>
                    <td><?php echo $row['college_roll_no']; ?></td>
                    <td><?php echo $row['exam_form_no']; ?></td>
                    <td><?php echo $row['student_name']; ?></td>
                    <td><?php echo $row_stu['father_name']; ?></td>
                    <td><?php echo $paper_titles; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</div>

            </div>
        </div>
    </div>
</body>
<script src="js/jquery.min.js"></script>
<script src="js/light-bootstrap-dashboard.js"></script>
<script>
$(document).ready(function () {
    $('#general_stat_table').DataTable({
        paging: false
    });
});
</script>
</html>
<?php
page_footer_start();
page_footer_end();
?>
