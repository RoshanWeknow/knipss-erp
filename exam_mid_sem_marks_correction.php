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
		$up_sql = 'UPDATE exam_student_paper_info set 
			mid_teacher="'.$_POST['mid_teacher'].'" , 
			mid_verifier="'.$_POST['mid_verifier'].'" , 
			mid_sem_allotment="'.$_POST['mid_sem_allotment'].'" , 
			mid_sem_marks_max="'.$_POST['mid_sem_marks_max'].'" , 
			mid_sem_marks_obt="'.$_POST['mid_sem_marks_obt'].'" , 
			edited_by="'.$_SESSION['username'].'",
			edition_time="'.date("d-m-y H:i:s").'"
			 where sno = '.$_POST['id'];
		 
		//echo $up_sql;					
		$up_res = mysqli_query($db, $up_sql);
		
		if($up_res){
			$msg = "<h5 class='alert alert-success'>Successfully Submitted</h5>";
		}else{
			$msg ="<h5 class='alert alert-danger'>Error ! Could not submitted</h5>";
		}		
	}
?>
		<div class="row">
            <div class="col-md-12"> 
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" onsubmit="return showAlert()">
					<?php echo $msg; ?> 
                    <div class="col-md-12">
						<h2 class="bg-primary text-white p-2">Mid Sem Marks Correction</h2>
				        <!-- first row -->
                        <div class="row">
							 <div class=" col-md-4 ">
							
								<label>Paper Code<span style="color:red;font-size:1rem;">*</span></label>
								<input list="brow"  name="paper" id="paper" value="<?php echo (isset($_POST['save']))? $_POST['paper']:''; ?>" class="form-control" required>
								<datalist id="brow">
									<option value="Internet Explorer">
									<?php 
									$sql  = 'SELECT count(*) c, title_of_paper, paper_code FROM `add_subject_details` where theory_practical = "Theory" group by paper_code order by paper_code';
									$dept_list = execute_query($db,$sql);
									if($dept_list){
										while($list = mysqli_fetch_assoc($dept_list)){
											echo '<option  value = "'.$list['paper_code'].'">'.$list['paper_code'].' - '.$list['title_of_paper'].'</option>';
										}
									}
									?>
								</datalist> 
							</div>
							<div class=" col-md-3 ">
								<label>Exam Roll Number<span style="color:red;font-size:1rem;">*</span></label>
							<input type ="text" name="ex_roll" id="ex_roll" value="<?php echo isset($_POST['ex_roll']) ? $_POST['ex_roll'] : ''; ?>"  class="form-control" required>
						</div>		
						<div>
							<button type="submit" name = "save" value="save" class="btn btn-warning mt-2 ms-2">Search</button> 
							<!--<input type="reset"  value="Reset" class="btn btn-danger mt-2 ms-5" /> -->
						</div>
					</div>
					<?php
					if(isset($_POST['save'])){
						$sql = 'SELECT *,exam_student_paper_info.sno as stu_paper_id FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_info_sno=exam_student_info.sno  WHERE exam_roll_no ="'.$_POST['ex_roll'].'" AND paper_code ="'.$_POST['paper'].'"';
						//echo $sql;
						 $res1 = mysqli_query($db, $sql);
						 $res = mysqli_fetch_assoc($res1);
						if(mysqli_num_rows($res1) == 1){
					?>
					 <div class="row">
						 <div class=" col-md-4 ">
							<label>Name<span style="color:red;">*</span></label>
							<input type ="text" name="student_name" id="stu_name" value="<?php echo $res['student_name']; ?>" class="form-control" required readonly>
						</div>	
						<div class=" col-md-4 ">
							<label>Paper Code<span style="color:red;">*</span></label>
							<input type ="text" name="paper_code" id="stu_name" value="<?php echo $res['paper_code']; ?>" class="form-control" required readonly>
						</div>	
						<div class=" col-md-4 ">
							<label>Title Of Paper<span style="color:red;">*</span></label>
							<input type ="text" name="title_of_paper" id="title_of_paper" value="<?php echo $res['title_of_paper']; ?>" class="form-control" required readonly>
						</div>	
					</div>	
					<div class="row">	
						<div class=" col-md-4 ">
							<label>Theacher Name<span style="color:red;">*</span></label>
							<input type ="text" name="mid_teacher" id="mid_teacher" value="<?php echo isset($res['mid_teacher']) ? $res['mid_teacher'] : ''; ?>" class="form-control" required>
						</div>		
						<div class=" col-md-4 ">
							<label>Verifier Authority<span style="color:red;">*</span></label>
							<input type ="text" name="mid_verifier" id="mid_verifier" value="<?php echo isset($res['mid_verifier']) ? $res['mid_verifier'] : ''; ?>" class="form-control" required>
						</div>			
						<div class=" col-md-4 ">
							<label>Allotment ID<span style="color:red;">*</span></label>
							<input type ="text" name="mid_sem_allotment" id="mid_sem_allotment" value="<?php echo isset($res['mid_sem_allotment']) ? $res['mid_sem_allotment'] : ''; ?>" class="form-control" required>
						</div>	
					</div>	
					<div class="row">	
						<div class=" col-md-4 ">
							<label>Maximum Marks<span style="color:red;">*</span></label>
							<input type ="text" name="mid_sem_marks_max" id="mid_sem_marks_max" value="<?php echo isset($res['mid_sem_marks_max']) ? $res['mid_sem_marks_max'] : ''; ?>" class="form-control" required>
						</div>		
						<div class=" col-md-4 ">
							<label>Obtained Marks<span style="color:red;">*</span></label>
							<input type ="text" name="mid_sem_marks_obt" id="mid_sem_marks_obt" value="<?php echo isset($res['mid_sem_marks_obt']) ? $res['mid_sem_marks_obt'] : ''; ?>" class="form-control" required>
						</div>
					</div>	
						<button type="submit" name = "submit" value="submit" class="btn btn-primary mt-2 ms-2">Submit</button> 
						<input type="hidden" name="id" value="<?php echo $res['stu_paper_id'];?>">
						<script>
							function showAlert() {
								// Display an alert
								alert("Are you sure you want to submit?");

								// Return false to prevent the form from being submitted
								return true;
							}
						</script>
			   </form>
                    </div>
					
<?php
						}
						else{
							echo "<h5 class='alert alert-danger'>Student Not Found</h5>";
						}
					}
page_footer_start();
?>
    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<?php		
page_footer_end();
?>