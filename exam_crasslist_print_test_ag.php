<?php
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg='';
$tab=1;
$responce = 1;
$_POST['corsslist_course_ag'] = $_GET['id'];
switch ($responce) {
case 1:				
if(isset($_POST['corsslist_course_ag'])){
	$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name` FROM `exam_student_info` LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno where exam_roll_no!="" and exam_roll_no is not null and `exam_student_info`.`course_name` = "'.$_POST['corsslist_course_ag'].'" order by exam_roll_no limit '.$_GET['start'].', '.$_GET['limit'];
	$result =mysqli_query($db,$sql);
							
//echo $sql;
$show_total = 0;
$hide_practical_paper = 0;	
}	
?>
<html>
	<head>
		<title>Exam Crosslist</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
		
		
		<style>
			@media print {
				.fixedallpage{
					position:fixed;
					top:0;
					left:0;
					right:0;
					margin-bottom:100px;
				}
				
				.noprint{
					display: none;
				}
          
				td{
					border:0px  !important;
					border-style: ;
					text-align:center;
					font-size: 10px;
					}
				th{
					border:0px  !important;
					font-size: 10px;
				}
				
				@page {
					size: A3 landscape;
					/* padding-top:100px; */
					margin-top:5mm;
				}
				.last_div{
					width : 100% !important;
				}
            }

			td{
				border:0px  !important;
				border-style: ;
				text-align:center;
				font-size: 10px;
			}

			th{
				border:0px  !important;
				font-size: 10px;
			}

			table, figure {
				page-break-inside: avoid;
			}
			
			.merge_column {
				position: absolute;
				top: 2%;
				left: 50%;
				-ms-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
				background-color: white;
				heigth: 200px;
				height: 29px;
				padding-top: 0.4rem; padding-inline:0.1rem;
				
			}
			
		</style>
		<link href="css/pagination.css" rel="stylesheet" type="text/css" media="all" />
	</head>
	<body>
		<div class="wrap">
			<table width="100%">
				<thead>
					<tr>
						<td>
							<div style="width:100%" class="border ">
								<div><h4 class="" style="text-align: center; margin:0px; " ><span ><b>Kamla Nehru Institute Of Physical &amp; Social Sciences,Sultanpur, Uttar Pradesh</b></span> <br><span style="font-size:1.3rem;">An Autonomous Institute And Accredited "A" Grade by NAAC</span></h4></div>
								<div class="d-flex">
									<?php
										$sql_class = 'select * from class_detail where sno = "'.$_POST['corsslist_course_ag'].'"';
										$row_class = mysqli_fetch_assoc(mysqli_query($db,$sql_class));
										//print_r($row);
									?>
									<div><b><?php echo $row_class['class_description']?> 1st Semester Main Examination 2023</b></div>
									<div style="margin-left:20px;">Regular</div>
									<div style="margin-left:100px;"></div>
								</div>
							</div>
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
						<div class="topmargin" style="">
						<?php
							$i=1;
							while($row = mysqli_fetch_array($result)){
								//$i = $pgid+1;
								$total_obt = 0;
								$total_max = 0;	
								$total_grade_credit_erned_point = 0;
								$passing_status = 'PASSED';	
								$passing_status_reason = 'EVERY THING FINE';
								$avg_credit = 0;
								$cocurricular_count = 0;
								$count_row = 0;
						?>
						<table style=" width:100%; border:1px solid black;border-style: ;">
							<tr style="border:1px solid black;border-style: ;">
								<td style="verticle-align:top;"  width="20%" valign="top">
									<table width="100%"  valign="middle" >
										<tr>
											<td style="height: 33px;"></td>
											
										</tr>
										<tr>
											<td><b>ROLL NO.</b></td>
											<td ><b><?php echo $row['exam_roll_no']; ?></b></td>
										</tr>
										<tr >
											<td><b>UIN No.</b></td>
											<td ><b><?php echo $row['uin_no']; ?></b></td>
										</tr>
										<tr >
											<td><b>STUDENT'S NAME</b></td>
											<td><b><?php echo $row['student_name']; ?></b><?php //echo $row['id']; ?></td>
										</tr>
										<tr >
											<td ><b>FATHER'S NAME</b></td>
											<td><b><?php echo $row['father_name']; ?></b></td>
										</tr>
									</table>
								</td>
								<td width="60%" valign="top">
									<table width="100%">
										<tr>
											<td ><b>PAPER CODE</b></td>
											<td ><b>PAPER NAME</b></td>
											<td ><b>COURSE<br>HOURS</b> </td>
											<!--<td ><b>MAX<br>MRK</b></td>-->
											<td ><b>MID <br>20/40</b></td>
											<td ><b>TH <br>50/60</b></td>
											<td ><b>PRAC <br>30/100</b></td>
											<td ><b>SUB-TOT</br>100</b></td>
											<!--<td ><b>EARNED<br>CREDIT <b></td>-->
											<td ><b>GRADE </br></b></td>
											<td ><b>CREDIT <br> GRADE <br>POINT</b></td>
											<!--<td ><b>LETTER<br>GRADE</b></td>-->
										</tr>
										<?php
											$paperCodeArray = array();
											if($_POST['corsslist_course_ag']==56){
												//$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type = 'Major' THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type = 'Remedial' THEN 3 WHEN type = 'Non-Gradial' THEN 4 END"; 
												$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY 
														CASE 
															WHEN type = 'Major' THEN 1 
															WHEN type in ('Minor', 'Elective') THEN 2 
															WHEN type = 'Remedial' THEN 3 
															WHEN type = 'Non-Gradial' THEN 4 
														END, 
														CASE 
															WHEN type = 'Remedial' THEN 
																CASE 
																	WHEN paper_code = 'KAG-110A' THEN 1 
																	WHEN paper_code = 'KAG-109' THEN 2 
																	WHEN paper_code = 'KAG-11A' THEN 3 
																	ELSE 4 
																END 
															ELSE NULL 
														END";												
											}else{
												$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type in ('Major', 'Core') THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type in ('Vocational', 'Supporting') THEN 3 WHEN type in ('Cocurricular', 'Common') THEN 4 END"; 
											}
												$result2 = mysqli_query($db, $sql2);
												$tot_course_credit=0;
												$tot_max=0;
												$tot_mid_obt=0;
												$tot_the_obt=0;
												$tot_pra_obt=0;
												$tot_obt=0;
												$tot_credit_grade=0;
												$tot_earned_grade=0; 
											while ($row2 = mysqli_fetch_assoc($result2)) {
												
												$paperCode = $row2['paper_code'];
												$sql3 = 'SELECT * FROM `exam_paper_code_mapping` where `theory_paper_code` = "'.$paperCode.'"';
												
												$result3 =mysqli_query($db,$sql3);
												if(isset($student_paper)){
													unset($student_paper);
												}
												if(mysqli_num_rows($result3)>0){
													$row3=mysqli_fetch_assoc($result3);
													$student_paper = $row3['theory_paper_code'];
													$student_practical_paper = $row3['practical_paper_code'];
												}
												else{
												    if(isset($row3)){
												        unset($row3);
												    }
												}
												if($row2['type_status']=='2'){
													$sql_1 = 'select * from add_subject2 where sno="'.$row2['subject_id'].'"';
													$other_sub = mysqli_fetch_assoc(execute_query($db, $sql_1));
													if($other_sub['subject_type']=='1'){
														unset($row3);
													}
												}
												
												if(isset($student_paper)){
													$sql4 = 'SELECT * FROM `exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" && paper_code = "'.$student_paper.'"';
													
													$result4 =mysqli_query($db,$sql4);
													$row4=mysqli_fetch_assoc($result4);
													
													if (!in_array($paperCode, $paperCodeArray)) {
														$paperCodeArray[] = $paperCode;
															
															if($row4['theory_practical']=="Theory"){
																$theory_marks_max=$row4['pt_marks_max'];
																$theory_marks_obt=$row4['pt_marks_obt'];
																$mid_marks_max=$row4['mid_sem_marks_max'];
																$mid_marks_obt=$row4['mid_sem_marks_obt'];
																$practical_marks_max='';
																$practical_marks_obt='';
															}
															if($row4['theory_practical']=="Practical"){
																$practical_marks_max=$row4['pt_marks_max'];
																$practical_marks_obt=$row4['pt_marks_obt'];
																$theory_marks_max='';
																$theory_marks_obt='';
																$mid_marks_max='';
																$mid_marks_obt='';
															}
															if($row4['type']=="Non-Gradial"||$row4['type']=="Common"||$row4['type']=="Minor"){
																if($row4['theory_practical']=="Practical"){
																	$practical_marks_max_p=$row4['pt_marks_max'];
																	$practical_marks_obt=$row4['pt_marks_obt'];
																	$theory_marks_max='';
																	$theory_marks_obt='';
																	$mid_marks_max='';
																	$mid_marks_obt='';
																}
															}
															if($row4['theory_practical']=="Viva-voce"){
																$practical_marks_max=$row4['pt_marks_max'];
																$practical_marks_obt=$row4['pt_marks_obt'];
																$theory_marks_max='';
																$theory_marks_obt='';
																$mid_marks_max='';
																$mid_marks_obt='';
															}
														
														
															if($row4['theory_practical']=="Theory+ Practical"){
																$practical_marks_max='';
																$practical_marks_obt='';
																$theory_marks_max=$row4['pt_marks_max'];
																$theory_marks_obt=$row4['pt_marks_obt'];
																$mid_marks_max=$row4['mid_sem_marks_max'];
																$mid_marks_obt=$row4['mid_sem_marks_obt'];
															}
															if($row4['theory_practical']=="Theory+Practical"){
																$practical_marks_max='';
																$practical_marks_obt='';
																$theory_marks_max=$row4['pt_marks_max'];
																$theory_marks_obt=$row4['pt_marks_obt'];
																$mid_marks_max=$row4['mid_sem_marks_max'];
																$mid_marks_obt=$row4['mid_sem_marks_obt'];
															}
															
															if(isset($student_practical_paper)){
																if (!in_array($student_practical_paper, $paperCodeArray)) {
																	$paperCodeArray[] = $student_practical_paper;
																	
																	$sql5 = 'SELECT * FROM `exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" && paper_code = "'.$student_practical_paper.'"';
																	$result5 =mysqli_query($db,$sql5);
																	$row5=mysqli_fetch_assoc($result5);	
																	if($row5['theory_practical']=="Practical"){
																		$practical_marks_max_p=$row5['pt_marks_max'];
																		$practical_marks_obt_p=$row5['pt_marks_obt'];
																		$theory_marks_max_p='';
																		$theory_marks_obt_p='';
																		$mid_marks_max_p='';
																		$mid_marks_obt_p='';
																	}
																	if($row5['theory_practical']=="Theory+ Practical"){
																		$practical_marks_max_p=$row5['pt_marks_max'];
																		$practical_marks_obt_p=$row5['pt_marks_obt'];
																		$theory_marks_max_p='';
																		$theory_marks_obt_p='';
																		$mid_marks_max_p='';
																		$mid_marks_obt_p='';
																	}if($row5['theory_practical']=="Theory+Practical"){
																		$practical_marks_max_p=$row5['pt_marks_max'];
																		$practical_marks_obt_p=$row5['pt_marks_obt'];
																		$theory_marks_max_p='';
																		$theory_marks_obt_p='';
																		$mid_marks_max_p='';
																		$mid_marks_obt_p='';
																	}if($row5['theory_practical']=="Theory"){
																		$practical_marks_max_p=$row5['pt_marks_max'];
																		$practical_marks_obt_p=$row5['pt_marks_obt'];
																		$theory_marks_max_p='';
																		$theory_marks_obt_p='';
																		$mid_marks_max_p='';
																		$mid_marks_obt_p='';
																	}
																	 
																}		
															}else{
																$practical_marks_max_p=NULL;
																$practical_marks_obt_p=NULL;
																if(isset($practical_marks_obt)){
																	$practical_marks_max_p=$practical_marks_max;
																	$practical_marks_obt_p=$practical_marks_obt;
																}
																$theory_marks_max_p=NULL;
																$theory_marks_obt_p=NULL;
																$mid_marks_max_p=NULL;
																$mid_marks_obt_p=NULL;
																$practical_marks_obt=NULL;
																$practical_marks_max=NULL;
															}
															$theory_percentage = percentage_marks($theory_marks_obt,$theory_marks_max);
															$practical_percentage = percentage_marks($practical_marks_obt_p,$practical_marks_max_p);
															if($row_class['category']=='UG'){
																$required_passing_percentage = 50;
																$required_gpa = 5;
															}elseif($row_class['category']=='PG'){
																$required_passing_percentage = 60;
																$required_gpa = 6;
															}
														if($row4['type']!='Non-Gradial'){	
														?>
														
														<tr style="border:1px solid black; border-style:;">
															<?php  $count_row++; ?>
															<td><?php echo $paperCode; ?></td>
															<td><?php echo $row4['title_of_paper']; ?></td>
															<td><?php echo $paper_credit = credit_sum($row4['credit'],$row4['theory_practical']);echo '('.$row4['credit'].')'; ?></td>
															<?php $max_total = (float)$mid_marks_max+(float)$theory_marks_max+(float)$practical_marks_max_p; ?>
															<td><?php echo $mid_marks_obt; ?></td>
															<td><?php echo $theory_marks_obt; ?></td>
															<td><?php echo $practical_marks_obt_p; ?></td>
															<td><?php 
																	if(($mid_marks_obt=='Abs' || $mid_marks_obt==NULL) AND ($theory_marks_obt=='Abs' || $theory_marks_obt==NULL) AND ($practical_marks_obt_p=='Abs' || $practical_marks_obt_p==NULL)){
																		echo $obt_total = 'Abs';
																	}else{
																		echo $obt_total = (float)$mid_marks_obt+(float)$theory_marks_obt+(float)$practical_marks_obt_p; 
																	}		
															?>
															</td>
															<?php 
																//echo $earned_credit =  (credit_subject($row4['credit'],'Theory',$theory_percentage)+credit_subject($row4['credit'],'Practical',$practical_percentage));// echo '('.credit_subject($row4['credit'],'Theory',$theory_percentage).'+'.credit_subject($row4['credit'],'Practical',$practical_percentage).')';
															
																$theory_percentage = percentage_marks($obt_total,$max_total);
																if($theory_percentage<$required_passing_percentage){
																	 $earned_credit = 0;
																}else{
																	 $earned_credit = $paper_credit;
																}
															?>
															<td><?php echo $earned_grade = ((float)$obt_total/10); ?></td>
															<td><?php echo $credit_grade_point = (float)$earned_credit*(float)$earned_grade; ?></td>
															<!--<td><?php //echo calculate_grade_letter($obt_total,$max_total); ?></td>-->
														<?php	
															if($passing_status=='PASSED'){
																$obt_total_pass_chk = (float)$obt_total;
																if($max_total>0){
																	$theory_percentage = percentage_marks($obt_total_pass_chk,$max_total);
																	if($theory_percentage<$required_passing_percentage){
																		$passing_status='FAILED';
																		$passing_status_reason = '</br>Marks percentage is less then '.$required_passing_percentage;
																	}
																}
															}
																	
																$tot_course_credit+=(float)$paper_credit;
																$tot_max+=(float)$max_total;
																$tot_mid_obt+=(float)$mid_marks_obt;
																$tot_the_obt+=(float)$theory_marks_obt;
																$tot_pra_obt+=(float)$practical_marks_obt_p;
																$tot_obt+=(float)$obt_total;
																$tot_earned_grade+=(float)$earned_grade;
																$tot_credit_grade+=(float)$credit_grade_point;

														}else{
															if($show_total==0){
															?>	
														</tr>
															<tr style="border:1px solid black; border-style:;">
																<th></th>
																<th style="text-align:right">Total : --</th>
																<th style="text-align:center;"><?php echo $tot_course_credit; ?></th>
																<?php //echo $tot_max; ?>
																<th style="text-align:center;"><?php echo $tot_mid_obt; ?></th>
																<th style="text-align:center;"><?php echo $tot_the_obt; ?></th>
																<th style="text-align:center;"><?php echo $tot_pra_obt; ?></th>
																<th style="text-align:center;"><?php echo $tot_obt; ?></th>
																<th style="text-align:center;"><?php echo $tot_earned_grade; ?></th>
																<th style="text-align:center;"><?php echo $tot_credit_grade; ?></th>
															</tr>
															<?php	
																$show_total=1;
															}
														?>	
														<tr style="border:1px solid black; border-style:;">
															<?php  $count_row++; ?>
															<td><?php echo $paperCode; ?></td>
															<td><?php echo $row4['title_of_paper']; ?></td>
															<td><?php echo $paper_credit = credit_sum($row4['credit'],$row4['theory_practical']);echo '('.$row4['credit'].')'; ?></td>
															<?php  $max_total = (float)$mid_marks_max+(float)$theory_marks_max+(float)$practical_marks_max_p; ?>
															<td><?php echo $mid_marks_obt; ?></td>
															<td><?php echo $theory_marks_obt; ?></td>
															<td><?php echo $practical_marks_obt_p; ?></td>
															<td><?php 
																if(($mid_marks_obt=='Abs' || $mid_marks_obt==NULL) AND ($theory_marks_obt=='Abs' || $theory_marks_obt==NULL) AND ($practical_marks_obt_p=='Abs' || $practical_marks_obt_p==NULL)){
																	echo $obt_total = 'Abs';
																}else{
																	echo $obt_total = (float)$mid_marks_obt+(float)$theory_marks_obt+(float)$practical_marks_obt_p; 
																}		
																?>
															</td>
															<td colspan="2"><b>SATISFACTORY</b></td>
															<td></td>
														</tr>	
												<?php	}	
													}
												}						
											}
											
												if($show_total==0){
												?>	
												<tr style="border:1px solid black; border-style:;">
													<th></th>
													<th style="text-align:right">Total : --</th>
													<th style="text-align:center;"><?php echo $tot_course_credit; ?></th>
													<?php //echo $tot_max; ?>
													<th style="text-align:center;"><?php echo $tot_mid_obt; ?></th>
													<th style="text-align:center;"><?php echo $tot_the_obt; ?></th>
													<th style="text-align:center;"><?php echo $tot_pra_obt; ?></th>
													<th style="text-align:center;"><?php echo $tot_obt; ?></th>
													<th style="text-align:center;"><?php echo $tot_earned_grade; ?></th>
													<th style="text-align:center;"><?php echo $tot_credit_grade; ?></th>
												</tr>
												<?php	
												}
											?>
											
									</table>
								</td>
								<td width="20%" valign="top">
									<table width="100%">
										<tr>
											<td ><b> TOTAL<br>GRADE</br>POINT</b></td>
											<td ><b> GRADE<br>POINT<br>AVG.</b></td>
											<td ><b>G. TOTAL</br></br><?php echo $tot_max; ?></b></td>
											<td ><b>RESULT</b></td>
										</tr><hr>
										<tr>
											<?php
											/*
											if($tot_course_credit!=0){
												$sgpa = ($tot_credit_grade/$tot_course_credit);
											}else{
												$sgpa = 0;
											}
												$sgpa = number_format($sgpa, 2);
											*/	
											if($tot_course_credit!=0){
												$grade_point_avg = (float)$tot_credit_grade/(float)$tot_course_credit;
											}else{
												$grade_point_avg = 0;
											}
											$grade_point_avg = number_format($grade_point_avg, 2);
											$percentage_of_marks = (float)$grade_point_avg*10;
											if($grade_point_avg<$required_gpa){
												$passing_status=='FAILED';
												$passing_status_reason .= '</br>GPA is less then '.$required_gpa;
											}
											?>
											<td ><b><?php echo $tot_credit_grade; ?></b></td>
											<td ><b><?php echo $grade_point_avg; ?></b></td>
											<td ><b><?php echo $tot_obt; ?></br><?php //echo $percentage_of_marks; ?></b></td>
											<td ><b><?php echo $passing_status; ?><?php //echo $passing_status_reason ?></b></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						</br>
						<?php
							$total_obt = 0;
							$total_max = 0;	
							$total_grade_credit_erned_point = 0;
							$passing_status = 'PASSED';	
							$passing_status_reason = 'EVERY THING FINE';
							$avg_credit = 0;
							$cocurricular_count = 0;
							$count_row = 0;
							$show_total=0
						?>		
					<?php
						}
						 mysqli_data_seek($result, 0);
					//}	
					?>	
						<!----    REPORT START  ---->
					<?php
						if((isset($_GET['page_report'])) AND $_GET['page_report']==1){
								//REPORT DATA NEEDS
								$total_students = 0;
								$total_passed_students = 0;
								$total_failed_students = 0;
								$total_abs_students = 0;
								$total_ufm_students = 0;
								$total_first_div_pass = 0;
								$total_second_div_pass = 0;
								$total_third_div_pass = 0;
								$total_appered_students = 0;
								echo '<div class="text-center" style="font-size:13px;"><b>SUMMARY</b></div>';
							while($row = mysqli_fetch_assoc($result)){
									
									$total_students++;
									$tot_course_credit=0;
									$tot_max=0;
									$tot_mid_obt=0;
									$tot_the_obt=0;
									$tot_pra_obt=0;
									$tot_obt=0;
									$tot_credit_grade=0;
									$stu_ufm = 0;
									$stu_abs = 0;
							
										$paperCodeArray = array();
											if($_POST['corsslist_course_ag']==56){
												//$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type = 'Major' THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type = 'Remedial' THEN 3 WHEN type = 'Non-Gradial' THEN 4 END"; 
												$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY 
														CASE 
															WHEN type = 'Major' THEN 1 
															WHEN type in ('Minor', 'Elective') THEN 2 
															WHEN type = 'Remedial' THEN 3 
															WHEN type = 'Non-Gradial' THEN 4 
														END, 
														CASE 
															WHEN type = 'Remedial' THEN 
																CASE 
																	WHEN paper_code = 'KAG-110A' THEN 1 
																	WHEN paper_code = 'KAG-109' THEN 2 
																	WHEN paper_code = 'KAG-11A' THEN 3 
																	ELSE 4 
																END 
															ELSE NULL 
														END";

											}else{
												$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type in ('Major', 'Core') THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type in ('Vocational', 'Supporting') THEN 3 WHEN type in ('Cocurricular', 'Common') THEN 4 END"; 
											}
												$result2 = mysqli_query($db, $sql2);
												$tot_course_credit=0;
												$tot_max=0;
												$tot_mid_obt=0;
												$tot_the_obt=0;
												$tot_pra_obt=0;
												$tot_obt=0;
												$tot_credit_grade=0;
												$tot_earned_grade=0; 
											while ($row2 = mysqli_fetch_assoc($result2)) {
												
												$paperCode = $row2['paper_code'];
												$sql3 = 'SELECT * FROM `exam_paper_code_mapping` where `theory_paper_code` = "'.$paperCode.'"';
												
												$result3 =mysqli_query($db,$sql3);
												if(isset($student_paper)){
													unset($student_paper);
												}
												if(mysqli_num_rows($result3)>0){
													$row3=mysqli_fetch_assoc($result3);
													$student_paper = $row3['theory_paper_code'];
													$student_practical_paper = $row3['practical_paper_code'];
												}
												else{
												    if(isset($row3)){
												        unset($row3);
												    }
												}
												if($row2['type_status']=='2'){
													$sql_1 = 'select * from add_subject2 where sno="'.$row2['subject_id'].'"';
													$other_sub = mysqli_fetch_assoc(execute_query($db, $sql_1));
													if($other_sub['subject_type']=='1'){
														unset($row3);
													}
												}
												
												if(isset($student_paper)){
													$sql4 = 'SELECT * FROM `exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" && paper_code = "'.$student_paper.'"';
													
													$result4 =mysqli_query($db,$sql4);
													$row4=mysqli_fetch_assoc($result4);
													
													if (!in_array($paperCode, $paperCodeArray)) {
														$paperCodeArray[] = $paperCode;
															
															if($row4['theory_practical']=="Theory"){
																$theory_marks_max=$row4['pt_marks_max'];
																$theory_marks_obt=$row4['pt_marks_obt'];
																$mid_marks_max=$row4['mid_sem_marks_max'];
																$mid_marks_obt=$row4['mid_sem_marks_obt'];
																$practical_marks_max='';
																$practical_marks_obt='';
															}
															if($row4['theory_practical']=="Practical"){
																$practical_marks_max=$row4['pt_marks_max'];
																$practical_marks_obt=$row4['pt_marks_obt'];
																$theory_marks_max='';
																$theory_marks_obt='';
																$mid_marks_max='';
																$mid_marks_obt='';
															}
															if($row4['type']=="Non-Gradial"||$row4['type']=="Common"||$row4['type']=="Minor"){
																if($row4['theory_practical']=="Practical"){
																	$practical_marks_max_p=$row4['pt_marks_max'];
																	$practical_marks_obt=$row4['pt_marks_obt'];
																	$theory_marks_max='';
																	$theory_marks_obt='';
																	$mid_marks_max='';
																	$mid_marks_obt='';
																}
															}
															if($row4['theory_practical']=="Viva-voce"){
																$practical_marks_max=$row4['pt_marks_max'];
																$practical_marks_obt=$row4['pt_marks_obt'];
																$theory_marks_max='';
																$theory_marks_obt='';
																$mid_marks_max='';
																$mid_marks_obt='';
															}
														
														
															if($row4['theory_practical']=="Theory+ Practical"){
																$practical_marks_max='';
																$practical_marks_obt='';
																$theory_marks_max=$row4['pt_marks_max'];
																$theory_marks_obt=$row4['pt_marks_obt'];
																$mid_marks_max=$row4['mid_sem_marks_max'];
																$mid_marks_obt=$row4['mid_sem_marks_obt'];
															}
															if($row4['theory_practical']=="Theory+Practical"){
																$practical_marks_max='';
																$practical_marks_obt='';
																$theory_marks_max=$row4['pt_marks_max'];
																$theory_marks_obt=$row4['pt_marks_obt'];
																$mid_marks_max=$row4['mid_sem_marks_max'];
																$mid_marks_obt=$row4['mid_sem_marks_obt'];
															}
															if(isset($student_practical_paper)){
																if (!in_array($student_practical_paper, $paperCodeArray)) {
																	$paperCodeArray[] = $student_practical_paper;
																	
																	$sql5 = 'SELECT * FROM `exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" && paper_code = "'.$student_practical_paper.'"';
																	$result5 =mysqli_query($db,$sql5);
																	$row5=mysqli_fetch_assoc($result5);
																		
																	if($row5['theory_practical']=="Practical"){
																		$practical_marks_max_p=$row5['pt_marks_max'];
																		$practical_marks_obt_p=$row5['pt_marks_obt'];
																		$theory_marks_max_p='';
																		$theory_marks_obt_p='';
																		$mid_marks_max_p='';
																		$mid_marks_obt_p='';
																	}
																	if($row5['theory_practical']=="Theory+ Practical"){
																		$practical_marks_max_p=$row5['pt_marks_max'];
																		$practical_marks_obt_p=$row5['pt_marks_obt'];
																		$theory_marks_max_p='';
																		$theory_marks_obt_p='';
																		$mid_marks_max_p='';
																		$mid_marks_obt_p='';
																	}if($row5['theory_practical']=="Theory+Practical"){
																		$practical_marks_max_p=$row5['pt_marks_max'];
																		$practical_marks_obt_p=$row5['pt_marks_obt'];
																		$theory_marks_max_p='';
																		$theory_marks_obt_p='';
																		$mid_marks_max_p='';
																		$mid_marks_obt_p='';
																	}if($row5['theory_practical']=="Theory"){
																		$practical_marks_max_p=$row5['pt_marks_max'];
																		$practical_marks_obt_p=$row5['pt_marks_obt'];
																		$theory_marks_max_p='';
																		$theory_marks_obt_p='';
																		$mid_marks_max_p='';
																		$mid_marks_obt_p='';
																	}
																}		
															}else{
																$practical_marks_max_p=NULL;
																$practical_marks_obt_p=NULL;
																if(isset($practical_marks_obt)){
																	$practical_marks_max_p=$practical_marks_max;
																	$practical_marks_obt_p=$practical_marks_obt;
																}
																$theory_marks_max_p=NULL;
																$theory_marks_obt_p=NULL;
																$mid_marks_max_p=NULL;
																$mid_marks_obt_p=NULL;
																$practical_marks_obt=NULL;
																$practical_marks_max=NULL;
															}
															$theory_percentage = percentage_marks($theory_marks_obt,$theory_marks_max);
															$practical_percentage = percentage_marks($practical_marks_obt_p,$practical_marks_max_p);
															if($row_class['category']=='UG'){
																$required_passing_percentage = 50;
																$required_gpa = 5;
															}elseif($row_class['category']=='PG'){
																$required_passing_percentage = 60;
																$required_gpa = 6;
															}
													if($practical_marks_obt_p=='Abs'){
														$stu_abs = 1;
													}elseif($practical_marks_obt_p=='Ufm'){
														$stu_ufm = 1;
													}elseif($theory_marks_obt=='Abs'){
														$stu_abs = 1;
													}elseif($theory_marks_obt=='Ufm'){
														$stu_ufm = 1;
													}
													
												
												$count_row++; 
												// $paperCode;
												// $row4['title_of_paper'];
												$paper_credit = credit_sum($row4['credit'],$row4['theory_practical']);
												$max_total = (float)$mid_marks_max+(float)$theory_marks_max+(float)$practical_marks_max_p;
												// $mid_marks_obt;
												// $theory_marks_obt;
												// $practical_marks_obt_p; 
													if(($mid_marks_obt=='Abs' || $mid_marks_obt==NULL) AND ($theory_marks_obt=='Abs' || $theory_marks_obt==NULL) AND ($practical_marks_obt_p=='Abs' || $practical_marks_obt_p==NULL)){
														 $obt_total = 'Abs';
														 $stu_abs = 1;
													}else{
														 $obt_total = (float)$mid_marks_obt+(float)$theory_marks_obt+(float)$practical_marks_obt_p; 
													}	
													$earned_credit =  (credit_subject($row4['credit'],'Theory',$theory_percentage)+credit_subject($row4['credit'],'Practical',$practical_percentage)); 

												
												        $earned_grade = ((float)$obt_total/10);
														$credit_grade_point = (float)$earned_credit*(float)$earned_grade;
													
														if($passing_status=='PASSED'){
															$obt_total_pass_chk = (float)$obt_total;
															if($max_total>0){
																$theory_percentage = percentage_marks($obt_total_pass_chk,$max_total);
																if($theory_percentage<$required_passing_percentage){
																	$passing_status='FAILED';
																	$passing_status_reason = '</br>Marks percentage is less then '.$required_passing_percentage;
																}
															}
														}
												
														if($row4['type']!='Non-Gradial'){
															$tot_course_credit+=(float)$paper_credit;
															$tot_max+=(float)$max_total;
															$tot_mid_obt+=(float)$mid_marks_obt;
															$tot_the_obt+=(float)$theory_marks_obt;
															$tot_pra_obt+=(float)$practical_marks_obt_p;
															$tot_obt+=(float)$obt_total;
															$tot_credit_grade+=(float)$credit_grade_point;
														}
										
											
												$tot_course_credit+=(float)$paper_credit;
												$tot_max+=(float)$max_total;
												$tot_mid_obt+=(float)$mid_marks_obt;
												$tot_the_obt+=(float)$theory_marks_obt;
												$tot_pra_obt+=(float)$practical_marks_obt_p;
												$tot_obt+=(float)$obt_total;
												$tot_credit_grade+=(float)$credit_grade_point;

											}
										}						
									}
									
									if($tot_course_credit!=0){
										$grade_point_avg = (float)$tot_credit_grade/(float)$tot_course_credit;
									}else{
										$grade_point_avg = 0;
									}
									$grade_point_avg = number_format($grade_point_avg, 2);
									$percentage_of_marks = (float)$grade_point_avg*10;
									if($grade_point_avg<$required_gpa){
										$passing_status=='FAILED';
										$passing_status_reason .= '</br>GPA is less then '.$required_gpa;
									}
									if($passing_status!='FAILED'){
										$total_passed_students++;
									}	
									if($stu_abs == 1){
										$total_abs_students++;
									}
									if($stu_ufm == 1){
										$total_ufm_students++;
									}
									$total_obt = 0;
									$total_max = 0;	
									$total_grade_credit_erned_point = 0;
									$passing_status = 'PASSED';	
									$passing_status_reason = 'EVERY THING FINE';
									$avg_credit = 0;
									$cocurricular_count = 0;
									$count_row = 0;			
							}			
										?>	
										<div class="container-fluid mt-5 last_div">
											<table width="100%" class="table table-bordered" style="border:1px solid black;">
												<tr class="text-center">
													<th width="16%" > </th>
													<th width="13%" class="report_border">REGISTERD</th>
													<th width="12%" class="report_border">ABSENT</th>
													<th width="12%" class="report_border">APPERED</th>
													<th width="9%" class="report_border">PASS</th>
													<th width="9%" class="report_border">FAIL</th>
													<th width="9%" class="report_border">UFM</th>
													<th width="9%" class="report_border">INC</th>
												</tr>
												<tr>
													<th  class="report_border"><?php echo $row_class['class_description']?></th>
													<td class="report_border"><?php echo $total_students ; ?></td>
													<td  class="report_border"><?php  echo $total_abs_students; ?></td>
													<td class="report_border"><?php  echo $total_appered_stu = ($total_students-$total_abs_students); ?></td>
													<td class="report_border"><?php  echo $total_passed_students; ?> </td>
													<td class="report_border"><?php  echo $total_failed_stu = ($total_appered_stu - $total_passed_students); ?> </td>
													<td class="report_border"><?php echo $total_ufm_students; ?></td>
													<td class="report_border"><?php echo '0'; ?></td>
												</tr>
											</table>
											<div class="" style="display:flex;justify-content:space-between;font-size:13px;">
												<div><b>DATE OF RESULT DECLRATION :  <?php echo date("d-m-Y"); ?></b></div>
												<div><b>SIGNATURE OF CONTROLLER OF EXAMS :</b></div>
												<div><b>CO-ORDINATOR :</b></div>
											</div>
										</div>
						<?php			
						}	
						?>						
						<!----    REPORT END ---->
					</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>
</html>
<?php } ?>	