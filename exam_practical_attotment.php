<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
$response = 1;
page_header_start();
page_header_end();
page_sidebar();
?>
<?php
	if(isset($_POST['submit'])){
		if($_POST['stu_count'] >= $_POST['attot_stu']){
			if($_POST['edit_sno']!=''){
				$sql = 'update exam_practical_allotment_invoice set
					paper = "'.$_POST['paper'].'",
					max_marks = "'.$_POST['max_marks'].'",
					ext_examiner = "'.$_POST['ext_examiner'].'",
					int_examiner = "'.$_POST['int_examiner'].'",
					exam_date = "'.$_POST['pt_date'].'",
					batch = "'.$_POST['batch'].'",
					alloted_stu_count = "'.$_POST['attot_stu'].'",
					max_allot_date = "'.$_POST['max_allot_date'].'"
					where sno="'.$_POST['edit_sno'].'"';
					mysqli_query($db, $sql);
					$pract_allot_sno = $_POST['edit_sno'];
					
			}
			else{
				
				$ins_sql = 'INSERT INTO `exam_practical_allotment_invoice`(`paper`, `max_marks`, `ext_examiner`, `int_examiner`, `exam_date`, `batch`, `alloted_stu_count`, `max_allot_date`, `created_by`, `creation_time`) VALUES("'.$_POST['paper'].'",
				"'.$_POST['max_marks'].'",
				"'.$_POST['ext_examiner'].'",
				"'.$_POST['int_examiner'].'",
				"'.$_POST['pt_date'].'",
				"'.$_POST['batch'].'",
				"'.$_POST['attot_stu'].'",
				"'.$_POST['max_allot_date'].'",
				"'.$_SESSION['username'].'",
				"'.date("Y-m-d H:i:s").'")';
//echo $ins_sql;					
				$ins_res = mysqli_query($db, $ins_sql);
				$pract_allot_sno = mysqli_insert_id($db);
			}
			
			$limit=$_POST['attot_stu'];
			$sql = "(SELECT exam_student_paper_info.sno as id FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_info_sno=exam_student_info.sno  WHERE paper_code='".$_POST['paper']."' AND practicle_allotment='0' and exam_id in ('1', '3')) union all (SELECT back_exam_student_paper_info.sno as id FROM `back_exam_student_paper_info` LEFT JOIN back_exam_student_info on exam_student_info_sno=back_exam_student_info.sno  WHERE paper_code='".$_POST['paper']."' AND practicle_allotment='0' and exam_id in ('01', '3')) ORDER BY student_name LIMIT $limit";
			
			$sql = "(SELECT exam_student_paper_info.sno as id, student_name, 'regular' as type FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_info_sno=exam_student_info.sno  WHERE paper_code='".$_POST['paper']."' AND practicle_allotment='0' and exam_id in ('1', '3')) union all (SELECT back_exam_student_paper_info.sno as id, student_name, 'back' as type FROM `back_exam_student_paper_info` LEFT JOIN back_exam_student_info on exam_student_info_sno=back_exam_student_info.sno  WHERE paper_code='".$_POST['paper']."' AND practicle_allotment='0' and exam_id in ('01', '3')) ORDER BY student_name LIMIT $limit";
			$res=mysqli_query($db, $sql);
			
			//$sql = 'select count(*) stu_c from ((SELECT sno FROM `back_exam_student_paper_info` where paper_code = "'.$_POST['paper'].'" AND practicle_allotment = "0") union all (select sno from exam_student_paper_info where paper_code = "'.$_POST['paper'].'" AND practicle_allotment = "0")) t2';
						
			//echo "SELECT *,exam_student_paper_info.sno as id FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_info_sno=exam_student_info.sno  WHERE paper_code='".$_POST['paper']."' AND practicle_allotment='0' and exam_id='1' ORDER BY student_name LIMIT $limit";
			
			while($row=mysqli_fetch_assoc($res)){
				$rowsno=$row['id'];
				$internal=$_POST['int_examiner'];
				$external=$_POST['ext_examiner'];
				
				if($row['type']=='regular'){
				    $upsql="UPDATE exam_student_paper_info SET teacher_internal='$internal', verifier_external='$external', practicle_allotment='$pract_allot_sno' WHERE sno='$rowsno'";
				}
				elseif($row['type']=='back'){
				    $upsql="UPDATE back_exam_student_paper_info SET teacher_internal='$internal', verifier_external='$external', practicle_allotment='$pract_allot_sno' WHERE sno='$rowsno'";
				    
				}
				//echo $upsql;
				$upres=mysqli_query($db,$upsql);
				if($upres){
					$msg = "<h5 class='alert alert-success'>Alloted Students Successfully</h5>";
				}else{
					$msg ="<h5 class='alert alert-danger'>Could not alloted</h5>";
				}
			}
		}
		else{
			$msg = "<h5 class='alert alert-danger'>Alloted Students is more then remaining students</h5>";
		}
	}
	
	if(isset($_GET['edit'])){
		$sql = 'select * from exam_practical_allotment_invoice where sno="'.$_GET['edit'].'"';
		$old_data = mysqli_fetch_assoc(execute_query($db, $sql));
		$_POST['paper'] = $old_data['paper'];
		$_POST['save'] = '';
		//print_r($old_data);
	}
?>
		<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="">
					<?php echo $msg; ?> 
                    <div class="col-md-12">
						<h2 class="bg-primary text-white p-2">Practical Exam Student Allotment</h2>
				        <!-- first row -->
                        <div class="row">
							 <div class=" col-md-4 ">
							
								<label>Paper</label>
								<input list="brow"  name="paper" id="paper" value="<?php echo (isset($_POST['save']))? $_POST['paper']:''; ?>" class="form-control">
								<datalist id="brow">
									<option value="Internet Explorer">
									<?php 
									$sql  = 'SELECT count(*) c, title_of_paper, paper_code FROM `add_subject_details` where theory_practical = "Practical" group by paper_code order by paper_code';
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
							<button type="submit" name = "save" value="save" class="btn btn-warning mt-2 ms-2">Search</button> 
							<!--<input type="reset"  value="Reset" class="btn btn-danger mt-2 ms-5" /> -->
						</div>
					</div>
					<?php
					if(isset($_POST['save'])){
						$sql = 'select count(*) stu_c from ((SELECT sno FROM `back_exam_student_paper_info` where paper_code = "'.$_POST['paper'].'" AND practicle_allotment = "0") union all (select sno from exam_student_paper_info where paper_code = "'.$_POST['paper'].'" AND practicle_allotment = "0")) t2';
						//select Count(*) stu_c from exam_student_paper_info where paper_code = "'.$_POST['paper'].'" AND practicle_allotment = "0"';
						//echo $sql;
						 $res = mysqli_fetch_assoc(mysqli_query($db, $sql));
						//echo $res['stu_c'];
						
						$sql_ex_scheme = 'select * from exam_examination_scheme where paper_code = "'.$_POST['paper'].'"';
						$result_ex_scheme = mysqli_fetch_assoc(mysqli_query($db, $sql_ex_scheme));
					
					?>
					 <div class="row">
						 <div class=" col-md-3 ">
							<label>Practical Date<span style="color:red;"></span></label>
					<input type ="date" name="pt_date" id="pt_date"  class="form-control" value="<?php if(isset($old_data['exam_date'])){echo $old_data['exam_date'];}?>" >
						</div>		
						<div class=" col-md-3 ">
							<label>Batch</label>
							<select name="batch" id="batch" class="form-control" required>
								<option selected disabled>--Select Batch--</option>
								<option value="A" <?php if(isset($old_data['batch'])){if($old_data['batch']=='A'){echo " selected='selected' ";}}?>>A</a>
								<option value="B" <?php if(isset($old_data['batch'])){if($old_data['batch']=='B'){echo " selected='selected' ";}}?>>B</a>
								<option value="C" <?php if(isset($old_data['batch'])){if($old_data['batch']=='C'){echo " selected='selected' ";}}?>>C</a>
								<option value="D" <?php if(isset($old_data['batch'])){if($old_data['batch']=='D'){echo " selected='selected' ";}}?>>D</a>
								<option value="E" <?php if(isset($old_data['batch'])){if($old_data['batch']=='E'){echo " selected='selected' ";}}?>>E</a>
								<option value="F" <?php if(isset($old_data['batch'])){if($old_data['batch']=='F'){echo " selected='selected' ";}}?>>F</a>
								<option value="G" <?php if(isset($old_data['batch'])){if($old_data['batch']=='G'){echo " selected='selected' ";}}?>>G</a>
								<option value="H" <?php if(isset($old_data['batch'])){if($old_data['batch']=='H'){echo " selected='selected' ";}}?>>H</a>
							</select>
						</div>		
						<!-- Include jQuery and Select2 -->
						<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
						<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
						<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

						<div class="col-md-3">
							<label>Internal Examiner</label>
							<select name="int_examiner" id="int_examiner" class="form-control select2" required>
								<option selected disabled>---Select Internal Examiner---</option>
								<?php
								$sql_examiner = 'SELECT * FROM exam_examiner_info';
								$res_examiner = mysqli_query($db, $sql_examiner);
								while ($row_examiner = mysqli_fetch_assoc($res_examiner)) {
									echo '<option value="' . $row_examiner['sno'] . '" ';
									if (isset($old_data['int_examiner']) && $row_examiner['sno'] == $old_data['int_examiner']) {
										echo ' selected="selected" ';
									}
									echo '>' . $row_examiner['name'] . '</option>';
								}
								?>
							</select>
						</div>

						<div class="col-md-3">
							<label>External Examiner</label>
							<select name="ext_examiner" id="ext_examiner" class="form-control select2" required>
								<option selected disabled>---Select External Examiner---</option>
								<?php
								$sql_examiner_ex = 'SELECT * FROM exam_examiner_info';
								$res_examiner_ex = mysqli_query($db, $sql_examiner_ex);
								while ($row = mysqli_fetch_assoc($res_examiner_ex)) {
									echo '<option value="' . $row['sno'] . '" ';
									if (isset($old_data['ext_examiner']) && $row['sno'] == $old_data['ext_examiner']) {
										echo ' selected="selected" ';
									}
									echo '>' . $row['name'] . '</option>';
								}
								?>
							</select>
						</div>

						<script>
							$(document).ready(function () {
								$('.select2').select2({
									placeholder: "---Select Examiner---",
									allowClear: true
								});
							});
						</script>

					</div>
					<div class="row">
						<div class=" col-md-3 ">
							<label>Maximum Marks</label>
							<input name="max_marks" id="max_marks" class="form-control" required value="<?php if(isset($old_data['max_marks'])){echo $old_data['max_marks'];}?>">
						</div>
						<div class=" col-md-3 ">
							<label>No. Of Students</label>
							<input name="stu_count" id="stu_count" value="<?php echo $res['stu_c']; ?>" readonly class="form-control" required>
						</div>	
						<div class=" col-md-3 ">
							<label>No. Of Alloted Student<span style="color:red;">*</span></label>
							<input  name="attot_stu" id="attot_stu"  class="form-control" required value="<?php if(isset($old_data['exam_date'])){echo $old_data['alloted_stu_count'];}?>" >
						</div>	
						<div class=" col-md-3 ">
							<label>Date Limit For Allotment Letter <span style="color:red;">*</span></label>
							<?php
							$sql = 'select * from exam_practical_allotment_invoice where paper = "'.$_POST['paper'].'"';
							$res = mysqli_query($db, $sql);
							$row = mysqli_fetch_assoc($res);
							if(mysqli_num_rows ($res) >=1){
								echo '<input type="text" name="max_allot_date" id="max_allot_date" value="'.date("d-m-Y", strtotime($row['max_allot_date'])).'" class="form-control" readonly required>';
							}
							else{
								echo '<input type="date" name="max_allot_date" id="max_allot_date" value="" class="form-control" required>';
							}
							?>
						</div>	
					</div>	
						<button type="submit" name = "submit" value="submit" class="btn btn-primary mt-2 ms-2">Submit</button> 
						<input type="hidden" name="edit_sno" value="<?php if(isset($old_data['exam_date'])){echo $old_data['sno'];}?>">
			   </form>
                    </div>
					
<?php
					}
page_footer_start();
?>
    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<?php		
page_footer_end();
?>