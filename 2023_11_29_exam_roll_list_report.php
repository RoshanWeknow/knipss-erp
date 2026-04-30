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
						<h2 class="bg-primary text-white p-2">Roll List</h2>
                        <!-- first row -->
                        <div class="row">
							 <div class=" col-md-4 ">
							
								<label>Course</label>
                                <select name="course" id="course" value="" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
										<option disabled <?php echo isset($_GET['id'])? "":' selected = "selected" '?>>---Select Course---</option>
										<?php 
										$sql  = 'select * from class_detail where `year`="1"';
										$dept_list = execute_query($db,$sql);
										if($dept_list){
											while($list = mysqli_fetch_assoc($dept_list)){
												echo '<option  value = "'.$list['sno'].'">'.$list['class_description'].'</option>';
											}
										}
										?>
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
                   <?php
				if(isset($_POST['course'])){
					?>
                    <div class="card-body">
					<table class="table table-striped table-hover" id="general_stat_table">
						<thead>
							<tr class="bg-primary text-white">
								<td scope="col">Sr. No</td>
								<td scope="col">Student Type</td>
								<td scope="col">Year Part</td>
								<td scope="col">Roll No.</td>
								<td scope="col">Form Number</td>
								<td scope="col">Student Name</td>
								<td scope="col">Father Name</td>
								<td scope="col">Sub 1</td>
								<td scope="col">Sub 2</td>
								<td scope="col">Sub 3</td>
								<td scope="col">Minor</td>
								<td scope="col">Co-Curricular</td>
								<td scope="col">Vocational</td>
							</tr>
						</thead>
						<?php
						if(isset($_POST['course'])){
							$query = 'SELECT * FROM exam_student_info WHERE course_name ="'.$_POST['course'].'" and exam_roll_no is not null and exam_roll_no!="" order by exam_roll_no';
						}
						else{
							$query = 'SELECT * FROM exam_student_info';
						}
						//echo $query;
						$result =execute_query($db,$query);
						$i=1;
						while($row=mysqli_fetch_assoc($result)){
								
							$query_class = 'SELECT * FROM class_detail WHERE sno ="'.$row['course_name'].'"';
							$result_class = execute_query($db, $query_class);
							$row_class = mysqli_fetch_assoc($result_class);
							if (isset($row_class['class_description']) && ($row_class['class_description'] != '' || $row_class['class_description'] !== NULL)) {
								$class = $row_class['class_description'];
							} else {
								$class = '----';
							}
							
							$query_stu_info = 'SELECT * FROM student_info WHERE sno ="'.$row['student_info_sno'].'"';
							$result_stu_info = execute_query($db, $query_stu_info);
							$row_stu_info = mysqli_fetch_assoc($result_stu_info);	
							
							$sql = 'select * from student_info2 where student_id="'.$row_stu_info['sno'].'" and type="subject_change"';
							$result2 = execute_query($db, $sql);
							if(mysqli_num_rows($result2)!=0){
								$row2 = mysqli_fetch_assoc($result2);
								$row_stu_info['sub1'] = $row2['sub1'];
								$row_stu_info['sub2'] = $row2['sub2'];
								$row_stu_info['sub3'] = $row2['sub3'];
								
							}
							
							$sql = 'select subject, subject_type from student_info_subject left join add_subject2 on add_subject2.sno = student_info_subject.subject_id where student_id="'.$row_stu_info['sno'].'"';
							//echo $sql;
							//die();
							$result_subjects = execute_query(connect(), $sql);
							$minor='';
							$cocurricular='';
							$vocational='';
							while($row_subjects = mysqli_fetch_assoc($result_subjects)){
								if($row_subjects['subject_type']=='1'){
									$minor = $row_subjects['subject'];
								}
								elseif($row_subjects['subject_type']=='2'){
									$cocurricular = $row_subjects['subject'];
								}
								elseif($row_subjects['subject_type']=='3'){
									$vocational = $row_subjects['subject'];
								}
							}
							
							$query_sub1 = 'SELECT * FROM add_subject WHERE sno ="'.$row_stu_info['sub1'].'"';
							$result_sub1 = execute_query($db, $query_sub1);
							$row_sub1 = mysqli_fetch_assoc($result_sub1);
							
							$query_sub2 = 'SELECT * FROM add_subject WHERE sno ="'.$row_stu_info['sub2'].'"';
							$result_sub2 = execute_query($db, $query_sub2);
							$row_sub2 = mysqli_fetch_assoc($result_sub2);
							if (isset($row_sub2['subject']) && ($row_sub2['subject'] != '' || $row_sub2['subject'] !== NULL)) {
								$sub2 = $row_sub2['subject'];
							} else {
								$sub2 = '----';
							}
							
							$query_sub3 = 'SELECT * FROM add_subject WHERE sno ="'.$row_stu_info['sub3'].'"';
							$result_sub3 = execute_query($db, $query_sub3);
							$row_sub3 = mysqli_fetch_assoc($result_sub3);
							if (isset($row_sub3['subject']) && ($row_sub3['subject'] != '' || $row_sub3['subject'] !== NULL)) {
								$sub3 = $row_sub3['subject'];
							} else {
								$sub3 = '----';
							}
							
						?>
						<tr>
							<td><?php echo $i++;?></td>
							<td><?php echo 'Regular';?></td>
							<td><?php echo $class;?></td>
							<td><?php echo $row['exam_roll_no'] ;?></td>
							<td><?php echo $row['exam_form_no'];?></td>
							<td><?php echo $row['student_name'] ;?></td>
							<td><?php echo $row_stu_info['father_name'];?></td>
							<td><?php echo $row_sub1['subject'];?></td>
							<td><?php echo $sub2;?></td>
							<td><?php echo $sub3;?></td>
							<td><?php echo $minor;?></td>
							<td><?php echo $cocurricular;?></td>
							<td><?php echo $vocational;?></td>
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
               <?php } ?>
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