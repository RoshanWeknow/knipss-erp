<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
$response = 1;
page_header_start();
page_header_end();
page_sidebar();

if(isset($_GET['id'])){
	if($_GET['id']==1){
		$response=2;
	}
	else{
		$response=1;
	}
}

if(isset($_POST['other_subject'])){
	$response=2;
}
switch($response){
	case 1:{
	
?>
		<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="">
					<?php echo $msg; ?> 
                    <div class="col-md-12">
						<h2 class="bg-primary text-white p-2">Seating Plan</h2>
				        <!-- first row -->
                        <div class="row">
							 <div class=" col-md-4 ">
							
								<label>Paper</label>
								<input list="brow"  name="paper" id="paper" class="form-control">
								<datalist id="brow">
									<option value="Internet Explorer">
									<?php 
									$sql  = 'SELECT count(*) c, title_of_paper, paper_code FROM `add_subject_details` group by paper_code order by paper_code';
									$dept_list = execute_query($db,$sql);
									if($dept_list){
										while($list = mysqli_fetch_assoc($dept_list)){
											echo '<option  value = "'.$list['paper_code'].'">'.$list['paper_code'].' - '.$list['title_of_paper'].'</option>';
										}
									}
									?>
								</datalist>  
                                <!--<select name="paper" id="paper" value="" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
									<option disabled <?php echo isset($_GET['id'])? "":' selected = "selected" '?>>---Select Course---</option>
									<?php 
									$sql  = 'SELECT count(*) c, title_of_paper, paper_code FROM `add_subject_details` group by paper_code order by paper_code';
									$dept_list = execute_query($db,$sql);
									if($dept_list){
										while($list = mysqli_fetch_assoc($dept_list)){
											echo '<option  value = "'.$list['paper_code'].'">'.$list['paper_code'].' - '.$list['title_of_paper'].'</option>';
										}
									}
									?>
								</select>-->
							</div>
						<div>
							<button type="submit" name = "submit" value="save" class="btn btn-primary mt-2 ms-2">Search</button> 
							<a href="exam_seating_plan_generate_excel.php"><button type="button" name = "submit" value="save" class="btn btn-warning mt-2 ms-2">Export To Excel</button> </a>
							<!--<input type="reset"  value="Reset" class="btn btn-danger mt-2 ms-5" /> -->
						</div>
					</div>
			   </form>
                    </div>
                   <?php
				//print_r($_POST);
				if(isset($_POST['paper'])){
					$_SESSION['seating_plan'] = $_POST;
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
								<td scope="col">Subject</td>
								<td scope="col">Paper</td>
								
							</tr>
						</thead>
						<?php
					
						$sql = 'select * from add_subject_details where paper_code="'.$_POST['paper'].'"  group by subject_id, type_status order by class_id';
						//echo $sql;
						$result_paper = execute_query($db, $sql);
						$i=1;
								
						while($row = mysqli_fetch_assoc($result_paper)){
							if($row['type_status']=='1'){
								$_POST['course'] = $row['class_id'];
								$_POST['paper'] = $row['sno'];
								$_POST['subject'] = $row['subject_id'];
								$sql = 'select * from add_subject_details where sno="'.$_POST['paper'].'"';
								//echo $sql;
								$paper_result = execute_query($db, $sql);
								if(mysqli_num_rows($paper_result)!=0){
									$row_paper = mysqli_fetch_array($paper_result);
									$paper = $row_paper['title_of_paper'].' ('.$row_paper['paper_code'].')';
								}
								else{
									$paper = '';
								}
								if(isset($_POST['course'])){
									
									$query = 'SELECT * FROM exam_student_info WHERE course_name ="'.$_POST['course'].'" and exam_roll_no is not null and exam_roll_no!=""';
									$query = 'SELECT student_info.sno as sno, student_name, student_info_sno, stu_name, exam_form_no, exam_roll_no, uin_no, course_name FROM `exam_student_info` left join student_info on student_info.sno = student_info_sno  WHERE course_name="'.$_POST['course'].'" and (sub1="'.$_POST['subject'].'" or sub2="'.$_POST['subject'].'" or sub3="'.$_POST['subject'].'") and exam_roll_no is not null and exam_roll_no!="" order by exam_roll_no';
									
									if($_POST['course']=='112'){
										$query = 'SELECT student_info.sno as sno, student_name, student_info_sno, stu_name, exam_form_no, exam_roll_no, uin_no, course_name FROM `exam_student_info` left join student_info on student_info.sno = student_info_sno  WHERE course_name="'.$_POST['course'].'" and sub1 in (37, 66, 67, 68) and exam_roll_no is not null and exam_roll_no!="" order by exam_roll_no';
									}

									
								}
								else{
									$query = 'SELECT * FROM exam_student_info';
								}
								//echo $query;
								$result =execute_query($db,$query);
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
									if($_POST['course']=='112'){
										$row_stu_info['sub1']='37';
									}
									$print=0;
									if($_POST['subject']==$row_stu_info['sub1']){
										$query_sub1 = 'SELECT * FROM add_subject WHERE sno ="'.$row_stu_info['sub1'].'"';
										$result_sub1 = execute_query($db, $query_sub1);
										$row_sub1 = mysqli_fetch_assoc($result_sub1);
										$print=1;
										$subject = '1.'.$row_sub1['subject'];
									}
									elseif($_POST['subject']==$row_stu_info['sub2']){
										$query_sub1 = 'SELECT * FROM add_subject WHERE sno ="'.$row_stu_info['sub2'].'"';
										$result_sub1 = execute_query($db, $query_sub1);
										$row_sub1 = mysqli_fetch_assoc($result_sub1);
										$print=1;
										$subject = '2.'.$row_sub1['subject'];
										$print=1;
									}
									elseif($_POST['subject']==$row_stu_info['sub3']){
										$query_sub1 = 'SELECT * FROM add_subject WHERE sno ="'.$row_stu_info['sub3'].'"';
										$result_sub1 = execute_query($db, $query_sub1);
										$row_sub1 = mysqli_fetch_assoc($result_sub1);
										$print=1;
										$subject = '3.'.$row_sub1['subject'];
										$print=1;
									}
									if($print==1){

									?>
										<tr>
											<td><?php echo $i++;?></td>
											<td><?php echo 'Regular1';?></td>
											<td><?php echo $class;?></td>
											<td><?php echo $row['exam_roll_no'] ;?></td>
											<td><?php echo $row['exam_form_no'];?></td>
											<td><?php echo $row['student_name'] ;?></td>
											<td><?php echo $row_stu_info['father_name'];?></td>
											<td><?php echo $subject; ?></td>
											<td><?php echo $paper; ?></td>

										</tr>
									<?php
									}
								}
							}
							else{
								$_POST['course'] = $row['class_id'];
								$_POST['paper'] = $row['sno'];
								$_POST['other_subject'] = $row['subject_id'];
								
								$sql = 'select * from add_subject2 where sno="'.$_POST['other_subject'].'"';
								$subject = mysqli_fetch_assoc(execute_query($db, $sql));
								$subject_detail = '';
								if($subject['subject_type']=='1'){
									$subject_detail = 'Minor';
								}
								elseif($subject['subject_type']=='2'){
									$subject_detail = 'Co-Curricular';
								}
								elseif($subject['subject_type']=='3'){
									$subject_detail = 'Vocational';
								}
								$subject = $subject['subject'];
								

								$sql = 'select * from add_subject_details where sno="'.$_POST['paper'].'"';
								$paper_result = execute_query($db, $sql);
								if(mysqli_num_rows($paper_result)!=0){
									$row_paper = mysqli_fetch_array($paper_result);
									$paper = $row_paper['title_of_paper'].' ('.$row_paper['paper_code'].')';
								}
								else{
									$paper = '';
								}
								if(isset($_POST['course'])){
									$query = 'SELECT student_info.sno as sno, student_name, student_info_sno, stu_name, exam_form_no, exam_roll_no, uin_no, course_name FROM `exam_student_info` left join student_info on student_info.sno = student_info_sno  WHERE course_name ="'.$_POST['course'].'" and exam_roll_no is not null and exam_roll_no!="" order by exam_roll_no';

									$query = 'SELECT student_info.sno as sno, student_name, student_info_sno, stu_name, exam_form_no, exam_roll_no, uin_no, course_name FROM `student_info_subject` left join student_info on student_info.sno = student_id left join exam_student_info on exam_student_info.student_info_sno = student_info.sno where student_info_subject.subject_id="'.$_POST['other_subject'].'" and  exam_roll_no is not null and exam_roll_no!="" order by exam_roll_no';
								}
								else{
									$query = 'SELECT * FROM exam_student_info';
								}
								//echo $query.'<br>';
								$result =execute_query($db,$query);
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
									$print=1;
									if($print==1){


									?>
									<tr>
										<td><?php echo $i++;?></td>
										<td><?php echo 'Regular2';?></td>
										<td><?php echo $class;?></td>
										<td><?php echo $row['exam_roll_no'] ;?></td>
										<td><?php echo $row['exam_form_no'];?></td>
										<td><?php echo $row['student_name'] ;?></td>
										<td><?php echo $row_stu_info['father_name'];?></td>
										<td><?php echo $subject_detail; ?></td>
										<td><?php echo $subject; ?></td>

									</tr>
									<?php
									}
								}
								 ?>		
							<?php
								
							}

						}
						?>		
					</table>
					</div>
               <?php } ?>
					

                </div>
            </div>
		</div>
<?php
		break;
	}

}
page_footer_start();
?>
    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>

    
<?php		
page_footer_end();
?>