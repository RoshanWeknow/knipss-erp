<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
page_header_start();
page_header_end();
page_sidebar();

// Fetch distinct exam_ids for the dropdown
$exam_query = "SELECT DISTINCT exam_id FROM exam_student_info";
$exam_result = execute_query($db, $exam_query);

$selected_exam_id = isset($_POST['exam_id']) ? $_POST['exam_id'] : '';

?>
<html>
<head>
</head>
<body>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h2 class="bg-primary text-white text-center p-2">EXAM STUDENT SUMMARY REPORT <button class="btn btn-warning"><a href="exam_student_report_back.php" target="_blank">BACK STUDENT REPORT</button></a></h2>
                <div class="card-body">

                <!-- Exam ID Filter Form -->
                <form method="POST" action="">
                    <label for="exam_id">Select Semester:</label>
                    <select name="exam_id" id="exam_id " >
                        <option value="">All</option>
                        <?php
                        while ($exam_row = mysqli_fetch_assoc($exam_result)) {
                            $selected = ($exam_row['exam_id'] == $selected_exam_id) ? 'selected' : '';
                            echo "<option value='{$exam_row['exam_id']}' $selected>{$exam_row['exam_id']}</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" value="Filter" class="btn btn-success">
                </form>

                <table class="table table-striped table-hover border border-danger" id="general_stat_table">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th scope="col" rowspan="2" >Sr. No</th>
                            <th scope="col" rowspan="2" class="bg-warning text-dark">Class</th>
                            <th scope="col" colspan="3" >Registered</th>
                            <th scope="col" colspan="3" class="bg-warning text-dark">Appeared</th>
                            <th scope="col" colspan="3">Passed</th>
                            <th scope="col" colspan="3" class="bg-warning text-dark">Failed</th>
                            <th scope="col" colspan="3">ATKT</th>
                            <th scope="col" colspan="3" class="bg-warning text-dark">ABSENT</th>
                            <th scope="col" colspan="3">INC</th>
                            <th scope="col" rowspan="2" class="bg-warning text-dark">UFM</th>
                            <th scope="col" colspan="3">Passing %</th>
							<th scope="col" rowspan="2" >Date of Result<br> Declaration</th>
                        </tr>
                        <tr class="bg-warning text-dark">
							<td scope="col" class="bg-primary text-white">M</td>
                            <td scope="col" class="bg-primary text-white">F</td>
                            <td scope="col" class="bg-primary text-white">Total</td>
                            <td scope="col">M</td>
                            <td scope="col">F</td>
                            <td scope="col">Total</td>
                            <td scope="col" class="bg-primary text-white">M</td>
                            <td scope="col" class="bg-primary text-white">F</td>
                            <td scope="col" class="bg-primary text-white">Total</td>
                            <td scope="col">M</td>
                            <td scope="col">F</td>
                            <td scope="col">Total</td>
                            <td scope="col" class="bg-primary text-white">M</td>
                            <td scope="col" class="bg-primary text-white">F</td>
                            <td scope="col" class="bg-primary text-white">Total</td>
                            <td scope="col">M</td>
                            <td scope="col">F</td>
                            <td scope="col">Total</td>
                            <td scope="col" class="bg-primary text-white">M</td>
                            <td scope="col" class="bg-primary text-white">F</td>
                            <td scope="col" class="bg-primary text-white">Total</td>
                            <td scope="col" class="bg-primary text-white">M</td>
                            <td scope="col" class="bg-primary text-white">F</td>
                            <td scope="col" class="bg-primary text-white">Total</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = "
                        SELECT 
                            cd.class_description AS class,
                            cd.group_short AS group_short,
                            cd.semester AS semester,
                            esi.exam_id,
                            esi.verify_status,
                            COUNT(*) AS total_students,
                            SUM(CASE WHEN si.gender = 'M' THEN 1 ELSE 0 END) AS male_count,
                            SUM(CASE WHEN si.gender = 'F' THEN 1 ELSE 0 END) AS female_count,
                            SUM(CASE WHEN si.gender = 'M' AND esi.passing_status = 'PASSED' THEN 1 ELSE 0 END) AS male_pass_count,
                            SUM(CASE WHEN si.gender = 'F' AND esi.passing_status = 'PASSED' THEN 1 ELSE 0 END) AS female_pass_count,
                            SUM(CASE WHEN si.gender = 'M' AND esi.passing_status = 'FAILED' THEN 1 ELSE 0 END) AS male_fail_count,
                            SUM(CASE WHEN si.gender = 'F' AND esi.passing_status = 'FAILED' THEN 1 ELSE 0 END) AS female_fail_count,
                            SUM(CASE WHEN si.gender = 'M' AND esi.passing_status = 'ATKT' THEN 1 ELSE 0 END) AS male_atkt_count,
                            SUM(CASE WHEN si.gender = 'F' AND esi.passing_status = 'ATKT' THEN 1 ELSE 0 END) AS female_atkt_count,
                            SUM(CASE WHEN si.gender = 'M' AND esi.passing_status = 'ABSENT' THEN 1 ELSE 0 END) AS male_abs_count,
                            SUM(CASE WHEN si.gender = 'F' AND esi.passing_status = 'ABSENT' THEN 1 ELSE 0 END) AS female_abs_count,
                            SUM(CASE WHEN si.gender = 'M' AND esi.passing_status = 'INC' THEN 1 ELSE 0 END) AS male_inc_count,
                            SUM(CASE WHEN si.gender = 'F' AND esi.passing_status = 'INC' THEN 1 ELSE 0 END) AS female_inc_count
                        FROM 
                            exam_student_info esi
                        LEFT JOIN 
                            class_detail cd ON cd.sno = esi.course_name
                        LEFT JOIN 
                            student_info si ON si.sno = esi.student_info_sno
                        WHERE 
                           esi.verify_status='1' and esi.exam_form_no IS NOT NULL 
                    ";
                    
                    // Add exam_id filter if selected
                    if ($selected_exam_id) {
                        $query .= " AND esi.exam_id = '$selected_exam_id'";
                    }

                    $query .= "
                        GROUP BY 
							cd.class_description, esi.exam_id, cd.group_short, cd.semester
						ORDER BY 
							 ABS(cd.group_short) ASC, ABS(cd.semester) ASC

											";
                    
                    $result = execute_query($db, $query);
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        
                        $male_count = $row['male_count'];
                        $female_count = $row['female_count'];
                        $total_students = $row['total_students'];
						
						$male_appeared_count = $row['male_count'] - $row['male_abs_count'];
						$female_appeared_count = $row['female_count'] - $row['female_abs_count'];
                        $total_appeared_students = $row['total_students'] - ($row['female_abs_count'] + $row['male_abs_count']);
                        
                        $male_pass_count = $row['male_pass_count'];
                        $female_pass_count = $row['female_pass_count'];
                        $total_pass_count = $row['female_pass_count'] + $row['male_pass_count'];
                        
                        $male_fail_count = $row['male_fail_count'];
                        $female_fail_count = $row['female_fail_count'];
                        $total_fail_count = $row['female_fail_count'] + $row['male_fail_count'];
                        
                        $male_atkt_count = $row['male_atkt_count'];
                        $female_atkt_count = $row['female_atkt_count'];
                        $total_atkt_count = $row['female_atkt_count'] + $row['male_atkt_count'];
                        
                        $male_abs_count = $row['male_abs_count'];
                        $female_abs_count = $row['female_abs_count'];
                        $total_abs_count = $row['female_abs_count'] + $row['male_abs_count'];
                        
                        $male_inc_count = $row['male_inc_count'];
                        $female_inc_count = $row['female_inc_count'];
                        $total_inc_count = $row['female_inc_count'] + $row['male_inc_count'];
                        
                        $male_passing_per = ($male_appeared_count != 0) ? round(($row['male_pass_count'] * 100) / $male_appeared_count, 2) : 0;
                        $female_passing_per = ($female_appeared_count != 0) ? round(($row['female_pass_count'] * 100) / $female_appeared_count, 2) : 0;
                        $total_passing_per = ($total_appeared_students != 0) ? round(($total_pass_count * 100) / $total_appeared_students, 2) : 0;
						
						$sql="SELECT *  FROM `result_class` WHERE `class_description` ='".$row['class']."' and show_result=1 ORDER BY ABS(dropdown_show) ASC";
			           	$row_t = mysqli_fetch_assoc(mysqli_query($db,$sql));

                    ?>
                    <tr>
                        <td><?php echo $i++;?></td>
                        <td><?php echo $row['class'];?></td>
                        <td><?php echo $male_count;?></td>
                        <td><?php echo $female_count;?></td>
                        <td><?php echo $total_students;?></td>
						
						<td><?php echo $male_appeared_count;?></td>
                        <td><?php echo $female_appeared_count;?></td>
                        <td><?php echo $total_appeared_students;?></td>
						
                        <td><?php echo $male_pass_count;?></td>
                        <td><?php echo $female_pass_count;?></td>
                        <td><?php echo $total_pass_count;?></td>
                        
                        <td><?php echo $male_fail_count;?></td>
                        <td><?php echo $female_fail_count;?></td>
                        <td><?php echo $total_fail_count;?></td>
                       
                        <td><?php echo $male_atkt_count;?></td>
                        <td><?php echo $female_atkt_count;?></td>
                        <td><?php echo $total_atkt_count;?></td>
                        
                        <td><?php echo $male_abs_count;?></td>
                        <td><?php echo $female_abs_count;?></td>
                        <td><?php echo $total_abs_count;?></td>
                       
                        <td><?php echo $male_inc_count;?></td>
                        <td><?php echo $female_inc_count;?></td>
                        <td><?php echo $total_inc_count;?></td>
                        
                        <td>0</td>
                        <td><?php echo $male_passing_per;?></td>
                        <td><?php echo $female_passing_per;?></td>
                        <td><?php echo $total_passing_per;?></td>
                        <td>
							<?php echo !empty($row_t['result_declaration_date']) ? date('d-m-Y', strtotime($row_t['result_declaration_date'])) : '';


								if($row['class'] == "LL.B I Sem."){
									echo "16-02-2024";
								}elseif($row['class'] == "B.Ed. I Sem" || $row['class'] == "M.Ed. I Sem" || $row['class'] == "B.P.Ed-I Sem"){
									echo "21-02-2024";
								}elseif($row['class'] == "B.Sc I Sem (Agriculture)" || $row['class'] == "M.Sc I Sem (Agronomy)" || $row['class'] == "M.Sc I Sem (Entomology)" || $row['class'] == "M.Sc I Sem (Genetics & Plant Breeding)" || $row['class'] == "M.Sc I Sem (Horticulture)" || $row['class'] == "M.Sc I Sem (Soil Science & Agri. Chemistry)"){
									echo "13-02-2024";
								}elseif($row['exam_id']==1 && $row['class'] != ''){
									echo "30-01-2024";
								}elseif($row['class'] == "LL.B II Sem."){
									echo "09-07-2024";
								}elseif($row['class'] == "B.Ed. II Sem" || $row['class'] == "M.Ed. II Sem" || $row['class'] == "B.P.Ed-II Sem"){
									echo "18-07-2024";
								}elseif($row['class'] == "B.Sc II Sem (Agriculture)" || $row['class'] == "M.Sc II Sem (Agronomy)" || $row['class'] == "M.Sc II Sem (Entomology)" || $row['class'] == "M.Sc II Sem (Genetics & Plant Breeding)" || $row['class'] == "M.Sc II Sem (Horticulture)" || $row['class'] == "M.Sc II Sem (Soil Science & Agri. Chemistry)"){
									echo "19-07-2024";
								}elseif($row['exam_id']==2 && $row['class'] != ''){
									echo "01-07-2024";
								}
							?>
						</td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
page_footer_start();
?>
    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
    <script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<script>
$('select[multiple]').multiselect({
    search: true,
    selectAll: true
});

$(document).ready( function () {
    var t = $('#general_stat_table').DataTable({
        paging: false
    });
});
</script>
<?php		
page_footer_end();
?>
