<?php
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg='';
$tab=1;
if(isset($_POST['verify']) && $_POST['verify']!=''){
	$sql_up = 'update exam_cross_list_verify set
				varify_status = "1",
				created_by = "'.$_SESSION['username'].'",
				creation_time = "'.date("d-m-Y H:i:s").'"
				WHERE class_details_sno = "'.$_POST['class'].'"';
	//echo $sql_up;
	$res = mysqli_query($db, $sql_up);
	if(isset($res)){
		$msg = '<h4 class="alert alert-success">Cross-List Verified</h4>';
	}else{
		$msg = '<h4 class="alert alert-danger">Cross-List Not Verifed</h4>';
	}	
}
?>
<?php
$responce = 0;
if(isset($_POST['submit']) && $_POST['submit']!=''){
	$responce = 1;
}
switch ($responce) {
case 0:	
page_header_start();
page_header_end();
page_sidebar();	
?>
<html>
	<head>
		<title>Exam Crosslist</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
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
								<h2 class="bg-primary text-white p-2">Cross-List</h2>
								<div class="row">
									 <div class=" col-md-4 ">
										<label>Course</label>
										<select name="course" id="course" value="" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
												<option disabled <?php echo isset($_GET['id'])? "":' selected = "selected" '?>>---Select Course---</option>
												<?php 
												$sql  = 'select distinct(course_name),class_detail.class_description from exam_student_info LEFT JOIN class_detail on exam_student_info.course_name = class_detail.sno ORDER BY class_detail.class_description';
												echo $sql;
												$dept_list = execute_query($db,$sql);
												if($dept_list){
													while($list = mysqli_fetch_assoc($dept_list)){
														echo '<option  value = "'.$list['course_name'].'">'.$list['class_description'].'</option>';
													}
												}
												?>
										</select>
									</div>

								</div>
								<div>
									<button type="submit" name = "submit" value="save" class="btn btn-primary mt-2 ms-2">Search</button> 
								</div>
							</div>
					   </form>
                    </div>
				</div>
			</div>
		</div>
	</body>
</html>	
<?php
break;
case 1:			
$total_marks_obt = 0;
$total_marks_max = 0;
$total_grade = 0;		
$total_credit_grade = 0;
$total_grade_erned = 0;	
$passing_status = 'PASSED';		

if(isset($_POST['course'])){
$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name` FROM `exam_student_info` LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno where `exam_student_info`.`course_name` = "'.$_POST['course'].'" ORDER BY ABS(`exam_student_info`.`exam_roll_no`)';
//echo $sql;	
}
/*if(isset($_POST['course'])){
$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name` FROM `exam_student_info` LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno where `exam_student_info`.`course_name` = "'.$_POST['course'].'" limit 10';
//echo $sql;	
}	*/
?>
<html>
	<head>
		<title>Exam Crosslist</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
		<style>
			*{
				box-sizing:border-box;
				margin:0px;
				padding:0px;
			}
			@media print{
				.wrap{
					font-size:10px;
				}
			}
			@media print{
				table{
					font-size:10px;
				}
			}
		</style>
		<?php
		$sql_chk_verify = 'select varify_status from exam_cross_list_verify WHERE class_details_sno = "'.$_POST['course'].'"';
		$row = mysqli_fetch_assoc(mysqli_query($db, $sql_chk_verify));
		if($row['varify_status'] == 2){
		?>	
		<style>
			@media print {
            body * {
                display: none !important;
            }
			}
		</style>
		<?php
		}
		?>	
	</head>
	<body>
		<div class="wrap">
			<div style="width:100%" class="border">
				<div><h4 class="" style="text-align: center; margin:0px; " ><span ><b>Kamla Nehru Institute Of Physical &amp; Social Sciences,Sultanpur, Uttar Pradesh</b></span> <br><span style="font-size:1.3rem;">An Autonomous Institute And Accredited "A" Grade by NAAC</span></h4></div>
				<div class="d-flex">
					<?php
						$sql_class = 'select * from class_detail where sno = "'.$_POST['course'].'"';
						$row_class = mysqli_fetch_assoc(mysqli_query($db,$sql_class));
						//print_r($row);
					?>
					<div><?php echo $row_class['class_description']?> 1st Semester Main Examination 2023</div>
					<div style="margin-left:20px;">Regular</div>
					<div style="margin-left:100px;"></div>
				</div>
			</div>
			<?php
				$result =mysqli_query($db,$sql);
				$i=1;
				while($row=mysqli_fetch_assoc($result)){
					if(isset($row['exam_roll_no'])){
			?>	
			<div >
			<table style=" width:100%; border:1px solid black;border-style: dashed;">
				<tr style="border:1px solid black;border-style: dashed;">
					<td width="25%" style="vertical-align: top;">
						<table style="width:100%;">
							<tr>
								<td style="vertical-align: top;">Roll No.</td>
								<td style="vertical-align: top;">CANDIDATE's NAME</td>
							</tr>
							<tr>
								<td>UIN No. <br></td>
								<td>FATHER'S NAME <br></td>
							</tr>
							
							<tr>
								<td><?php echo $row['exam_roll_no']; ?>   </td>
								<td><?php echo $row['student_name']; ?>  </td>
							</tr>
							<tr>
								<td><?php echo $row['uin_no']; ?></td>
								<td><?php echo $row['father_name']; ?></td>
							</tr>
						</table>
					</td>
					<td width="55%" style="vertical-align: top;">	
						<table style="width:100%;">
							<tr>
								<!--<td style="vertical-align: top;">Sno</td>-->
								<td style="vertical-align: top;">PAPER NAME</td>
								<td style="vertical-align: top;">CREDIT <br> HOURS</td>
								<td style="vertical-align: top;">&nbsp;MID.<br>&nbsp;<?php //echo $mid_marks_max;?></td>
								<td style="vertical-align: top;">THE.<br><?php //echo $theory_marks_max; ?></td>
								<td style="vertical-align: top;">PRAC.<br><?php //echo $pract_marks_max; ?></td>
								<td style="vertical-align: top;">SUB-TOT<br><?php //echo $total_max_marks; ?></td>
								<td style="vertical-align: top;">GRADE</td>
								<td style="vertical-align: top;">CREDIT <br> GRADE <br>POINT</td>
							</tr>
							<?php
								$sql2 = 'SELECT DISTINCT(title_of_paper),exam_student_info_sno FROM `exam_student_paper_info` where `exam_student_info_sno` = "'.$row['id'].'"';
								//echo $sql2;
								$result2 =mysqli_query($db,$sql2);
								$i=1;
								while($row2=mysqli_fetch_assoc($result2)){	
									
									if($i!=1){
										echo '<td></td><td></td>';
									}
									
									$sql3 = 'SELECT * FROM `exam_paper_code_mapping` where `paper` = "'.$row2['title_of_paper'].'"';
									$result3 =mysqli_query($db,$sql3);
									while($row3=mysqli_fetch_assoc($result3)){
										if(mysqli_num_rows($result3)>0){
											//$row3=mysqli_fetch_assoc($result3);
											$paper_name = $row3['paper'];
											$theory_paper = $row3['theory_paper_code'];
											$practical_paper = $row3['practical_paper_code'];
										}
										else{
											//echo $sql3;
											echo $row2['title_of_paper'].'DOES NOT FOUND';
											
										}

										if($theory_paper!=NULL){
											//echo $theory_paper;
											$sql4 = 'SELECT * FROM `exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" && paper_code = "'.$theory_paper.'"';
											$result4 =mysqli_query($db,$sql4);
											if(mysqli_num_rows($result4)>0){
												$row4=mysqli_fetch_assoc($result4);
												$theory_marks_default = $theory_marks_obt = $row4['pt_marks_obt'];
												$theory_marks_max = $row4['pt_marks_max'];
												$mid_sem_marks_default = $mid_sem_marks_obt = $row4['mid_sem_marks_obt'];
												$mid_sem_marks_max = $row4['mid_sem_marks_max'];
												break;
											}
											else{
												continue;
												echo $theory_paper.'-Paper Not Found';
											}
										}else{
											$theory_marks_obt = 0;
											$theory_marks_max = 0;
											$mid_sem_marks_obt = 0;
											$mid_sem_marks_max = 0;
										}
									
									if($practical_paper!=NULL){
										//echo ' - '.$practical_paper;
										$sql5 = 'SELECT * FROM `exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" && paper_code = "'.$practical_paper.'"';
										$result5 =mysqli_query($db,$sql5);
										$row5=mysqli_fetch_assoc($result5);
										$practical_marks_default = $practical_marks_obt = $row5['pt_marks_obt'];
										$practical_marks_max = $row5['pt_marks_max'];
									}else{
										$practical_marks_obt = 0;
										$practical_marks_max = 0;
									}
								}
									$mid_marks = (isset($mid_sem_marks_obt))?$mid_sem_marks_obt:0;
									$theory_maks = (isset($theory_marks_obt))?$theory_marks_obt:0;
									$practical_marks = (isset($practical_marks_obt))?$practical_marks_obt:0;
									
									$mid_marks_max = (isset($mid_sem_marks_max))?$mid_sem_marks_max:0;
									$theory_maks_max = (isset($theory_marks_max))?$theory_marks_max:0;
									$practical_marks_max = (isset($practical_marks_max))?$practical_marks_max:0;
									
									$sql6 = 'SELECT * FROM `add_subject_details` where `title_of_paper` = "'.$paper_name.'"';
									$result6 =mysqli_query($db,$sql6);
									$row6=mysqli_fetch_assoc($result6);
									$credit_paper = $row6['credit'];
									$result_credit = eval("return $credit_paper;");
									$integerResult = intval($result_credit);
									//echo '<br>';
									$mid_marks_max = is_numeric($mid_marks_max) ? $mid_marks_max: 0;
									$theory_maks_max = is_numeric($theory_maks_max) ? $theory_maks_max: 0;
									$practical_marks_max = is_numeric($practical_marks_max) ? $practical_marks_max: 0;
									//echo '<br>';
									$mid_marks = is_numeric($mid_marks) ? $mid_marks: 0;
									$theory_maks = is_numeric($theory_maks) ? $theory_maks: 0;
									$practical_marks = is_numeric($practical_marks) ? $practical_marks: 0;
									
									
									$total_max = ($mid_marks_max+$theory_maks_max+$practical_marks_max);
									$total_obt = ($mid_marks+$theory_maks+$practical_marks);
									$grade_erned = calculate_grade($total_obt,$total_max);
									$grade_credit_erned = ($integerResult*$grade_erned);
							?>
							<tr>
								<!--<td><?php //echo $i; ?></td>-->
								<td><?php echo $paper_name; ?></td>
								<td><?php echo $credit_paper.'&nbsp;('.$integerResult.')' ?></td>
								<td><?php echo $mid_marks; //echo ' ('.$mid_marks_max.')'; ?></td>
								<td><?php echo $theory_maks; //echo ' ('.$theory_maks_max.')'; ?></td>
								<td><?php echo $practical_marks;  //echo ' ('.$practical_marks_max.')'; ?></td>
								<td><?php echo $total_obt; //echo ' ('.$total_max.')'; ?></td>
								<td><?php echo $grade_erned; ?></td>
								<td><?php echo $grade_credit_erned; ?></td>
							</tr>
							<?php
									if($passing_status == 'PASSED'){
										if($mid_marks_max!=0){
											$percentage_m = percentage_marks($mid_marks,$mid_marks_max);
											if($percentage_m<33){
												$passing_status = 'FAILD';
												$passing_status_reason = 'MID SEM MARKS <33';
											}
										}
										if($theory_maks_max!=0){
										$percentage_t = percentage_marks($theory_maks,$theory_maks_max);
											if($percentage_t<33){
												$passing_status = 'FAILD';
												$passing_status_reason = 'Theory MARKS <33';
											}
										}
										if($practical_marks_max!=0){
										$percentage_p = percentage_marks($practical_marks,$practical_marks_max);
											if($percentage_p<33){
												$passing_status = 'FAILD';
												$passing_status_reason = 'Practical MARKS <33';
											}
										}
										/*if($total_max!=0){
											if($grade_erned<4){
												$passing_status = 'FAILD';
											}
										}*/
										if($grade_erned<4){
											$passing_status = 'FAILD';
											$passing_status_reason = 'Grade <33';
										}
									}
									else{
										$passing_status = 'FAILD';
									}
									
									$total_credit_grade += $grade_credit_erned;
									$total_grade_erned += $grade_erned;
									$total_marks_obt += $total_obt;
									$total_marks_max += $total_max;
									$avg_grade = 0;
									$total_grade += $grade_erned;
									$avg_grade = ($total_grade/$i);
									$i++;
								}
							?>		
						</table>
					</td>
					<td width="20%" style="vertical-align: top;">
						<table style="width:100%;">
							<tr >
								<td style="vertical-align: top;">TOTAL <br> GRADE <br> POINT</td>
								<td style="vertical-align: top;">GRADE <br> POINT <br> AVE.</td>
								<td style="vertical-align: top;">G_TOT <br><?php echo $total_marks_max; ?></td>
								<td style="vertical-align: top;">RESULT</td>
							</tr>
							<tr>
								<td><?php echo $total_credit_grade; ?></td>
								<td><?php echo $avg_grade = round($avg_grade, 3); ?></td>
								<td><?php echo $total_marks_obt; ?></td>
								<td><?php echo $passing_status; ?><br><?php //echo ($passing_status=="FAILD")?$passing_status_reason:''; ?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table >
				
					<?php
						$total_marks_obt = 0;
						$total_marks_max = 0;
						$total_credit_grade = 0;
						$total_grade = 0;
						$passing_status = 'PASSED';
				}
					else{
						continue;
					}
				}
					?>
					<tr width="100%">
					    <td colspan="2">DATE OF RESULT DECLARED : <?php echo date("d/m/Y"); ?></td>
						<td></td>
						<td></td>
						<td style="text-align:center;">SIGNATURE OF <SPAN STYLE="padding-left:5PX;">CONTROL OF EXAM</SPAN></td>
						<td colspan="7" style="text-align:center;">CO-ORDINATOR<span style="padding-left:10px;">:</span></td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
		<div>
			  <form id="verificationForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				  <?php
		$sql_chk_verify = 'select varify_status from exam_cross_list_verify WHERE class_details_sno = "'.$_POST['course'].'"';
		$row = mysqli_fetch_assoc(mysqli_query($db, $sql_chk_verify));
		if($row['varify_status'] == 0){
		?>	
				<center>
				 <!-- <input class="btn btn-danger" type="submit" name="verify" id ="submit" value="Verify" onclick="showConfirmation()">-->
					<input type="hidden" name="class" value="<?php echo $_POST['course'];?>">
				</center>
		<?php
		}
		else{
			echo '<center><button class="btn btn-primary" onclick="printPage()">Print</button></center>';
		}
		?>	
				
			  </form>

			  <script>
				function showConfirmation() {
				  var confirmation = confirm("Are you sure you want to verify and submit?");
				  if (confirmation) {
					document.getElementById("verificationForm").submit();
				  } 
				}
			  </script>
			<script>
				function printPage() {
					window.print();
				}
			</script>
		</div>
	</body>
</html>
<?php
}
?>		