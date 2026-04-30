<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
page_header_start();
page_header_end();
page_sidebar();
?>
<html>
	<head>
	</head>
	<body>
		<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="">
					<?php echo $msg; ?> 
                    <div class="col-md-12">
                        <!-- first row -->
                        <div class="row">
                            <div class=" col-md-4 ">
								<label>College Roll Number</label>
								<input type="text" name="college_roll_no" id="college_roll_no" class="form-control " value="" placeholder="Enter Roll Number" tabindex="<?php echo $tabindex++;?>" />
							</div>
							<div class=" col-md-4 ">
								<label>Exam Form Number</label>
								<input type="text" name="exam_form_no" id="exam_form_no" class="form-control " value="" placeholder="Enter Form Number" tabindex="<?php echo $tabindex++;?>" />
							</div>
							<div class=" col-md-4 ">
								<label>Session</label>
								<select name="exam_sem" id="exam_sem" class="form-control">
									<option value="">-Select-</option>
									<option value="1">Odd</option>
									<option value="2">Even</option>			
								</select>
							</div>
                        </div>
						<div class="row">
                            
							<div class=" col-md-4 ">
								<label>Student Type</label>
								<select name="stu_type" id="stu_type" class="form-control">
									<option value="">-Select-</option>
									<option value="regular">Regular</option>
									<option value="back">Back</option>									
								</select>
							</div>
                        </div>
						<div>
							<button type="submit" name = "submit" value="save" class="btn btn-primary mt-2 ms-2">Search</button> 
							<!--<input type="reset"  value="Reset" class="btn btn-danger mt-2 ms-5" /> -->
						</div>
					</div>
			   </form>
                    </div>
                    <div class="card-body">
					<table class="table table-striped table-hover" id="general_stat_table">
						<thead>
							<tr class="bg-primary text-white">
								<td scope="col">Sr. No</td>
								<td scope="col">Student Type</td>
								<td scope="col">Exam Form No</td>
								<td scope="col">student_name</td>
								<td scope="col">father's_name</td>
								<td scope="col">Class</td>
								<td scope="col">Gender</td>
								<td scope="col">Category</td>
								<td scope="col">college_roll_no</td>
								<td scope="col">dob</td>
								<td scope="col">mobile_no</td>
								<td scope="col">uin_no</td>
							</tr>
						</thead>
						<?php
							if (isset($_POST['exam_sem'])) {
								if ($_POST['exam_sem'] == 1) {
									$query = '
									SELECT 
										besi.sno, besi.exam_id, besi.student_info_sno, besi.student_name, 
										besi.dob, besi.college_roll_no, besi.exam_form_no, besi.verify_status, 
										besi.student_type, besi.uin_no, besi.course_name, besi.mobile_no, 
										cd.class_description
									FROM back_exam_student_info besi
									LEFT JOIN class_detail cd ON cd.sno = besi.course_name
									WHERE cd.semester IN (1, 3, 5) 
									AND besi.verify_status = "1" 
									AND besi.exam_form_no IS NOT NULL 
									
									UNION ALL 

									SELECT 
										esi.sno, esi.exam_id, esi.student_info_sno, esi.student_name, 
										esi.dob, esi.college_roll_no, esi.exam_form_no, esi.verify_status, 
										esi.student_type, esi.uin_no, esi.course_name, esi.mobile_no, 
										cd.class_description
									FROM exam_student_info esi
									LEFT JOIN class_detail cd ON cd.sno = esi.course_name
									WHERE cd.semester IN (1, 3, 5) 
									AND esi.verify_status = "1" 
									AND esi.exam_form_no IS NOT NULL 

									ORDER BY exam_form_no';
								} else {
									$query = '
									SELECT 
										besi.sno, besi.exam_id, besi.student_info_sno, besi.student_name, 
										besi.dob, besi.college_roll_no, besi.exam_form_no, besi.verify_status, 
										besi.student_type, besi.uin_no, besi.course_name, besi.mobile_no, 
										cd.class_description
									FROM back_exam_student_info besi
									LEFT JOIN class_detail cd ON cd.sno = besi.course_name
									WHERE cd.semester IN (2, 4, 6) 
									AND besi.verify_status = "1" 
									AND besi.exam_form_no IS NOT NULL 

									UNION ALL 

									SELECT 
										esi.sno, esi.exam_id, esi.student_info_sno, esi.student_name, 
										esi.dob, esi.college_roll_no, esi.exam_form_no, esi.verify_status, 
										esi.student_type, esi.uin_no, esi.course_name, esi.mobile_no, 
										cd.class_description
									FROM exam_student_info esi
									LEFT JOIN class_detail cd ON cd.sno = esi.course_name
									WHERE cd.semester IN (2, 4, 6) 
									AND esi.verify_status = "1" 
									AND esi.exam_form_no IS NOT NULL

									ORDER BY exam_form_no';
								}
							} elseif (isset($_POST['exam_form_no'])) {
								$query = 'SELECT * FROM exam_student_info WHERE exam_form_no = "' . $_POST['exam_form_no'] . '"';
							} elseif (isset($_POST['college_roll_no'])) {
								$query = 'SELECT * FROM exam_student_info WHERE college_roll_no = "' . $_POST['college_roll_no'] . '"';
							} elseif (isset($_POST['stu_type']) && $_POST['stu_type'] == "regular") {
								$query = 'SELECT * FROM exam_student_info WHERE verify_status = "1"';
							} elseif (isset($_POST['stu_type']) && $_POST['stu_type'] == "back") {
								$query = 'SELECT * FROM back_exam_student_info WHERE verify_status = "1"';
							} else {
								$query = 'SELECT 
									esi.sno, esi.exam_id, esi.student_info_sno, esi.student_name,
									esi.dob, esi.student_type, esi.college_roll_no, esi.exam_form_no,
									esi.uin_no, esi.course_name, esi.mobile_no, cd.class_description 
								FROM exam_student_info esi
								LEFT JOIN class_detail cd ON cd.sno = esi.course_name
								WHERE esi.exam_form_no IS NOT NULL 
								ORDER BY esi.exam_form_no';
							}

							$result =execute_query($db,$query);
							$i=1;
							while($row=mysqli_fetch_assoc($result)){
								// echo'<pre>';
									// print_r($row);
								// echo'<pre>';
								// echo $row['student_id'];
							// $query2 = 'SELECT * FROM online_payment_exams where student_id ="'.$row['student_info_sno'].'"';
							// $row2 =mysqli_fetch_assoc(execute_query($db2,$query2));
							// echo $query2;
							
							// $query3 = 'SELECT * FROM class_detail where sno ="'.$row['course_name'].'"';
							// $row3 =mysqli_fetch_assoc(execute_query($db,$query3));
						?>
						<tr>
							<td><?php echo $i++;?></td>
							<td><?php echo $row['student_type'];?></td>
							<td><?php echo $row['exam_form_no'];?></td>
							<td><?php echo $row['student_name'] ;?></td>
							<?php
								$query = "SELECT * FROM student_info WHERE sno = '" . $row["student_info_sno"] . "'";
								$result2 =execute_query($db,$query);
								$row2=mysqli_fetch_assoc($result2);
							?>
							<td><?php echo $row2['father_name'] ;?></td>
							<td><?php echo $row['class_description'] ;?></td>
							<td><?php echo $row2['gender'] ;?></td>
							<td><?php echo $row2['category'] ;?></td>
							<td><?php echo $row['college_roll_no'] ;?></td>
							<td><?php echo $row['dob'];?></td>
							<td><?php echo $row['mobile_no'] ;?></td>
							<td><?php echo $row['uin_no'];?></td>
						</tr>
						<?php
								}
								
						  ?>		
									<!---
									<td><a href="uin_verification.php?edit='.$row['sno'].'&&id='.$row['sno'].'" target = "_blank" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									
									<td><a href="uin_verification.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
									--->
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
    /*$('#general_stat_table').DataTable({
		paging: false,
		fixedHeader: true,
		colReorder: true
		});
	});	*/

	
	var t = $('#general_stat_table').DataTable({
		paging: false
    });
 
    
});
	
</script>

    
<?php		
page_footer_end();
?>