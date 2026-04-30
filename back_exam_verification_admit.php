<?php 
include("scripts/settings.php");


$msg='';
page_header_start();
page_header_end();
page_sidebar();

if(isset($_POST['course_name'])){
	
}
else{
	$_POST['course_name']='';
}

if(isset($_GET['dis'])){
	$sql = 'select * from back_exam_student_info where sno="'.$_GET['dis'].'"';
	//echo $sql;
	$row = mysqli_fetch_assoc(mysqli_query($db, $sql));
	
	if($row['admit_card_allow']=='1'){
		$sql = 'update back_exam_student_info set admit_card_allow="0" where sno="'.$row['sno'].'"';
	}
	else{
		$sql = 'update back_exam_student_info set admit_card_allow="1" where sno="'.$row['sno'].'"';
	}
	//echo $sql;
	mysqli_query($db, $sql);
	//$sql = 'update back_exam_student_info set admit_card_allow="'.
}

?>


<style>
form div.row:nth-child(odd) {
  background: #eeeeee;
  border-radius: 5px;
  margin-bottom:5px;
  margin-top:5px;
  padding:5px;
}
form div.row label{
	color:#000000;
}
</style>

<div id="container">
		<div class="card card-body">
				
			<div class="row">
				<div class="col-md-4">
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="">
					<div class="row">
						<div class="col-md-6">
							<label for="">Class</label>
							<select name="course_name" id="course_name" class="form-control" onChange="fn_year_part(this.value, '<?php echo $_POST['year_part']; ?>');">
								<option value=""></option>
								<?php
								$sql = 'select * from class_detail where semester="1" order by abs(display_sort)';
								$result_group = execute_query($db, $sql);
								while($row_group = mysqli_fetch_assoc($result_group)){
									echo '<option value="'.$row_group['sno'].'" ';
									if($_POST['course_name']==$row_group['sno']){
										echo ' selected="selected" ';
									}
									echo '>'.$row_group['class_description'].'</option>';
								}

								?>										
							</select>
						</div>
						<div class="col-md-6">
							<button type="submit" name = "submit" value="save" class="btn btn-primary mt-2 ms-2">Search</button> 
						</div>
					</div>
					</form>
				</div>
				<div class="col-md-8">
				<?php
				if(isset($_POST['course_name'])){
				?>
				<form action="back_exam_verification_print2.php" method="GET" enctype="multipart/form-data" id="" name="" target="_blank">
				<div class="row">
				<div class="col-md-4">
					<label>Verification Print Start</label>
					<input type="text" class="form-control" name="s" id="s">
					<input type="hidden" class="form-control" name="id" id="id" value="<?php echo $_POST['course_name']; ?>">
				</div>
				<div class="col-md-4">
					<label>Count</label>
					<input type="text" class="form-control" name="c" id="c">
				</div>
				<div class="col-md-4">
					<button type="submit" name = "submit" value="save" class="btn btn-warning mt-2 ms-2">Generate</button> 
				</div>
				</div>
				</form>
				<?php } ?>
				</div>
			</div>
			
			<div class="bg-primary text-white p-2"><h3>Admit Card</h3></div>
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="text-white bg-primary" align="center">
					<th>Sno.</th>
					<th>Class</th>
					<th>College Roll No</th>
					<th>Exam Roll No</th>
					<th>Name</th>
					<th>UIN No.</th>
					<th>Exam Form No</th>
					<th>Exam Form Print</th>
					<th>Admit Card</th>
					<th>Verification</th>
					<th>Status</th>
					<th></th>
				</tr>
				<?php
				if($_POST['course_name']!=''){
					$sql = ' SELECT back_exam_student_info.sno as sno, student_info.sno as student_id, class, class_description, student_name, admit_card_allow, student_info.category as category, gender, stu_name, father_name, creation_time, college_roll_no, uin_no, exam_form_no, "" as exam_form, exam_roll_no, class_description, order_status, transaction_id 
					FROM `back_exam_student_info` 
					left join student_info on student_info.sno = student_info_sno 
					left join class_detail on class_detail.sno = back_exam_student_info.course_name 
					where 
					exam_form_no is not null 
					and exam_form_no!="" 
					and order_status="Success" 
					and exam_roll_no is not null 
					and exam_roll_no!="" 
					and course_name="'.$_POST['course_name'].'"
					order by abs(exam_roll_no)';
					//echo $sql.'<br><br>';
					$result_student = execute_query($db, $sql);
					$i=1;
					while($row = mysqli_fetch_assoc($result_student)){
						$sql = 'select class_description from student_info2 left join class_detail on class_detail.sno = class where student_id="'.$row['student_id'].'" and student_info2.type="admission"';
						if($row['college_roll_no']=='2023AG0010449'){
						    //echo $sql;
						}
						$result_info2 = execute_query($db, $sql);
						if(mysqli_num_rows($result_info2)!=0){
							$row_info2 = mysqli_fetch_assoc($result_info2);
							$row['class_description'] = $row_info2['class_description'];
						}
						echo '<tr align="center">
						<td>'.$i++.'</td>
						<td>'.$row['class_description'].'</td>
						<td>'.$row['college_roll_no'].'</td>
						<td>'.$row['exam_roll_no'].'</td>
						<td>'.$row['student_name'].'</td>
						<td>'.$row['uin_no'].'</td>
						<td>'.$row['exam_form_no'].'</td>
						<td><a href="http://knipssexams.in/examination_form_print.php?id='.$row['student_id'].'" target="_blank"><span class="text text-warning">Exam Form</span></td>
						<td><a href="exam_admitcard_print.php?id='.$row['sno'].'" target="_blank"><span class="text text-primary">Admit Card</span></td>
						<td><a href="exam_verification_print.php?id='.$row['sno'].'" target="_blank"><span class="text text-success">Verification</span></td>
						<td><a href="exam_verification_admit.php?dis='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');">'.($row['admit_card_allow']=='0'?'<span class="text text-danger">Disabled</span>':'<span class="text text-danger">Enabled</span>').'</td>
						<td><a href="infr_add_floor.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
							</tr>'	;
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