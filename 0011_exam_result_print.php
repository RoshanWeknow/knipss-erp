<?php 
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg='';
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
		<title>Exam Result</title>
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
								<h2 class="bg-primary text-white p-2">Exam Result</h2>
								<div class="row">
									 <div class=" col-md-4 ">
										<label>Exam Roll Number </label>
										<input type="text" name="exam_roll_no" id="exam_roll_no" class="form-control" required>
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
$grand_total_obt = 0;
$grand_total_max = 0;
$total_credit_earned = 0;
$total_credit_default  = 0;
$passing_status = 'PASSED';
$Cocurricular_count = 0;
$cocurricular_count = 0;
$total_credit_point_earned = 0;
$total_obt = 0;
$total_max = 0;	
$total_grade_credit_erned_point = 0;
$passing_status_reason = 'EVERY THING FINE';
$avg_credit = 0;
$backpaperArray = array();

if(isset($_POST['exam_roll_no'])){
	$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`student_info_sno`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`,`student_info`.`mother_name`,`student_info`.`photo_id` FROM `exam_student_info` LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno where `exam_student_info`.`exam_roll_no` = "'.$_POST['exam_roll_no'].'"';
	//echo $sql;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    
    <!-- Bootstrap CSS -->
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous"
    />
    
    <title>Result</title>

    <!-- css  -->
    <style>
      body {
        font-family: "Roboto", sans-serif;
        font-size: .8rem;
        /* line-height: 0.9; */
      }
      h1{
        font-size: 1.8rem !important;
      }
      h2{
        font-size: 1.5rem !important;
      }
      h3{
        font-size: 1.3rem !important;
      }
      h4{
        font-size: 1rem !important;
      }
      p{
        font-size: .8rem !important;
      }
      td{
        font-size: .8rem !important;
      }
      th{
        font-size: .8rem !important;
      }
		@media print {
				
          
				td{
					border:0px  !important;
					
					
					font-size: 9px!important;
					}
				th{
					border:0px  !important;
					font-size: 9px!important;
				}
				.watermark {
					color: #ececec; 
					opacity: 0.1 !important;
					top: 30% !important;
					left: 10% !important;
					font-size: 3rem; 
				  }
			}
			
		table,th,tr,td{
		
		}
	  
      @page{
        size: A4;
        margin:0px;
      }
	  .watermark {
		  position: absolute;
		  top: 50%;
		  left: 20%;
		  opacity: 0.5;
		  z-index: 99;
		  color: #aeabab ;
		  font-size: 6.1rem;
		  transform: rotate(-45deg);
		  font-weight: normal;
		}
	.look{
			padding-left:10px!important;
			padding:4px;
		}	
    </style>
    <!-- <link rel="stylesheet" href="style.css" media="print"> -->
    <!-- googlefont -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,700&display=swap"
      rel="stylesheet"
    />
  </head>
	<?php
		$result =mysqli_query($db,$sql);
		$i=1;
		while($row=mysqli_fetch_assoc($result)){
			echo '<br><br>';
	?>
  <body class="w-100 m-auto">
  
   <!-- <div class="" style="display:flex ; justify-content: center ;">
      <button class="btn btn-secondary btn-print" style="width: 5%;" onclick="print()">Print</button>
    </div>-->
	<img src="images/kni_logo.png"  id="overlays" style=" z-index:-2;opacity:0.0;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%); width:30%;" alt="overlay image" >
    <div class="container-fluid m-auto cont " style="page-break-after: always;">
        <div class="container-fluid border">
			
            <table width="100%" class="table-bordered" style="margin:0px;">
			<div class="watermark">Internet Copy</div>
                <tr>
                    <th width="12%" rowspan="2"><img style="padding:15px; height:75px; width:75px; " src="images/kni_logo.png" alt="logo" class="img-fluid d-block m-auto" /> </th>
                    <th width="88%"><h4 class="" style="text-align: center; margin:0px; " ><span style="font-size:17px;"><b>Kamla Nehru Institute Of Physical &amp; Social Sciences,Sultanpur, Uttar Pradesh</b></span> <br>An Autonomous Institute And Accredited "A" Grade by NAAC</h4></th>
                </tr>
                
            </table>
            <table class="table table-borderless" width="100%">
				<tr>
					<th class="text-center" colspan="4">PROVISIONAL MARKSHEET<br>2023-2024876546</th>
				</tr>
                <tr>
					<td width="15%" class="look">Name </td>
					<td width="25%" class="look">:	<?php echo strtoupper($row['student_name']);?> <?php //echo $row['id']; ?>	</td >
					<td width="15%" class="look">Roll NO.</td>
					<td width="25%" class="look">: <?php echo $row['exam_roll_no']; ?></td >
					<th width="20%" rowspan="5">
					<?php
						if(fileExists("PHOTO/".$row['photo_id'])){
							$photo = fileExists("PHOTO/".$row['photo_id']);
						}
						else{
							$photo = $row['photo_id'];
						}
					?>
					<?php //echo $photo; ?>
					<img style="width:100px; height:90px; margin-left:0px;" src="<?php echo $photo; ?>" alt="Student Image"></th>
				</tr>
				<tr>
					<td class="look">Father's aa</td>
					<td class="look">: <?php echo strtoupper($row['father_name']); ?></td >
					<td class="look">Class</td>
					<td class="look">: <?php
							$sql_class = 'select * from class_detail where sno = "'.$row['course_name'].'"';
							$row_class = mysqli_fetch_assoc(mysqli_query($db,$sql_class));
							echo $row_class['class_description']; 
						?>
					</td >
				</tr>
				<tr>
					<td class="look">Mother's aa</td>
					<td class="look">: <?php echo strtoupper($row['mother_name']); ?></td >
					<td class="look">UIN NO.</td>
					<td class="look">: <?php echo $row['uin_no']; ?></td >
				</tr>
				<tr>
				</tr>
				<tr>
					<td class="look">College</td>
					<td colspan="3" class="look">: K.N.I.P.S.S. Sultanpur</td >
				
				</tr>
			</table>	

            <table class="table table-bordered text-center" style="border:1px solid black; ">
                <tr>
                    <th  width="16%" >SUBJECT</th>
                    <th  width="10%" >COURSE CODE</th>
                    <th width="25%" >PAPER TITLE</th>
                    <th width="7%" >  MAX MARKS </th>
                    <th width="7%">MARKS OBTAINED</th>
                    <th width="7%" >COURSE CREDIT</th>
                    <th width="7%" >EARNED CREDIT</th>
                    <th width="7%">GRADE POINTS</th>
                    <th width="7%">LETTER GRADE</th>
                    <th width="7%">CREDIT POINTS</th>
                </tr>
                <?php
											$paperCodeArray = array();

											//$sql2 = 'SELECT * FROM `exam_student_paper_info` where `exam_student_info_sno` = "'.$row['id'].'"';
											if($row['course_name']==56){
												$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type = 'Major' THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type = 'Remedial' THEN 3 WHEN type = 'Non-Gradial' THEN 4 END"; 
											}else{
												$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type in ('Major', 'Core') THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type = 'Vocational' THEN 3 WHEN type = 'Cocurricular' THEN 4 END"; 
											}
											//echo $sql2.'<br>';
											$result2 = mysqli_query($db, $sql2);
											$count_row = 1;
											$tot_course_credit = 0;
											$tot_obt_credit = 0;
											$tot_mid_max = 0;
											$tot_mid_obt = 0;
											$tot_theory_max = 0;
											$tot_theory_obt = 0;
											$tot_prac_max = 0;
											$tot_prac_obt = 0;
											while ($row2 = mysqli_fetch_assoc($result2)) {
												if($row2['type']=="Major"){
													if(!isset($paper_type_show_major)){
														$paper_type_show_major = $row2['type'];
														echo '<tr><th colspan="12" >MAJOR SUBJECTS</th></tr>';
													}
												}
												if($row2['type']=="Core"){
													if(!isset($paper_type_show_core)){
														$paper_type_show_core = $row2['type'];
														echo '<tr><th colspan="12" >CORE SUBJECTS</th></tr>';
													}
												}
												if($row2['type']=="Minor"){
													if(!isset($paper_type_show_minor)){
														$paper_type_show_minor = $row2['type'];
														echo '<tr><th colspan="12" >MINOR SUBJECT</th></tr>';
													}
												}
												if($row2['type']=="Remedial"){
													if(!isset($paper_type_show_remedial)){
														$paper_type_show_remedial = $row2['type'];
														echo '<tr><th colspan="12" >RRMEDIAL SUBJECT</th></tr>';
													}
												}
												if($row2['type']=="Cocurricular"){
													if(!isset($paper_type_show_cocurricular)){
														$paper_type_show_cocurricular = $row2['type'];
														echo '<tr><th colspan="12" >COCURRICULAR</th></tr>';
													}
												}
												if($row2['type']=="Vocational"){
													if(!isset($paper_type_show_vocational)){
														$paper_type_show_vocational = $row2['type'];
														echo '<tr><th colspan="12" >VOCATIONAL</th></tr>';
													}
												}
												if($row2['type']=="Non-Gradial"){
													if(!isset($paper_type_show_non_gradial)){
														$paper_type_show_non_gradial = $row2['type'];
														echo '<tr><th colspan="12" >NON-GRADIAL</th></tr>';
													}
												}
												//unset($row3);
												$paperCode = $row2['paper_code'];
												$sql3 = 'SELECT * FROM `exam_paper_code_mapping` where `theory_paper_code` = "'.$paperCode.'"';
												//echo $sql3.'<br>';
												$result3 =mysqli_query($db,$sql3);
												if(isset($student_paper)){
													unset($student_paper);
												}
												if(mysqli_num_rows($result3)>0){
													//echo $sql3.'<br>';
													$row3=mysqli_fetch_assoc($result3);
													$student_paper = $row3['theory_paper_code'];
													//echo $row3['theory_paper_code'].' >> '.$row3['practical_paper_code'].'<br>';
												}
												else{
												    if(isset($row3)){
												        unset($row3);
												    }
												}
												if($row2['type_status']=='2'){
													$sql = 'select * from add_subject2 where sno="'.$row2['subject_id'].'"';
													$other_sub = mysqli_fetch_assoc(execute_query($db, $sql));
													//echo implode("###", $other_sub).'@@@@@<br>';
													if($other_sub['subject_type']=='1'){
														unset($row3);
													}
												}
												
												if(isset($student_paper)){
												$sql4 = 'SELECT * FROM `exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" && paper_code = "'.$student_paper.'"';
												//echo $sql4.'#<br>';
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
														if($row4['theory_practical']=="Viva-voce"){
															$practical_marks_max=$row4['pt_marks_max'];
															$practical_marks_obt=$row4['pt_marks_obt'];
															$theory_marks_max='';
															$theory_marks_obt='';
															$mid_marks_max='';
															$mid_marks_obt='';
														}
													
													
														if($row4['theory_practical']=="Theory+ Practical"){
															$practical_marks_max=$row4['pt_marks_max'];
															$practical_marks_obt=$row4['pt_marks_obt'];
															$theory_marks_max='';
															$theory_marks_obt='';
															$mid_marks_max='';
															$mid_marks_obt='';
														}
														if($row4['theory_practical']=="Theory+Practical"){
															$practical_marks_max=$row4['pt_marks_max'];
															$practical_marks_obt=$row4['pt_marks_obt'];
															$theory_marks_max='';
															$theory_marks_obt='';
															$mid_marks_max='';
															$mid_marks_obt='';
														}
													
														$mid_marks_obt_num_t = is_numeric($mid_marks_obt) ? $mid_marks_obt: 0;
														$theory_marks_obt_num_t = is_numeric($theory_marks_obt) ? $theory_marks_obt: 0;
														$practical_marks_obt_num_t = is_numeric($practical_marks_obt) ? $practical_marks_obt: 0;

														$total_obt_t = ($mid_marks_obt_num_t+$theory_marks_obt_num_t+$practical_marks_obt_num_t);

														$mid_marks_max_num_t = is_numeric($mid_marks_max) ? $mid_marks_max: 0;
														$theory_marks_max_num_t = is_numeric($theory_marks_max) ? $theory_marks_max: 0;
														$practical_marks_max_num_t = is_numeric($practical_marks_max) ? $practical_marks_max: 0;

														$total_max_t = ($mid_marks_max_num_t+$theory_marks_max_num_t+$practical_marks_max_num_t);
													
														if($total_max_t!=0){
															$grade_erned_t = calculate_grade($total_obt_t,$total_max_t);
														}
														else{
															$grade_erned_t = 0;
														}
														if(is_numeric($row4['credit'])){
															$credit_paper_t = $row4['credit'];
														}else{
															$a = $row4['credit'];
															list($a1, $a2) = explode("+", $a);

															$credit_paper_t = $a1;
														}
														//$credit_paper_t = $row4['credit'];
														if($total_max_t!=0){
															$sub_percentage_t = percentage_marks($total_obt_t,$total_max_t);
														}
														else{
															$sub_percentage_t = 0;
														}
														if($sub_percentage_t >= 33){
															$earned_credit_t = $credit_paper_t;
														}else{
															$earned_credit_t = 0;
														}
															
														$result_credit = eval("return $earned_credit_t;");
														$integer_credit = intval($result_credit);

														$grade_erned_t = is_numeric($grade_erned_t) ? $grade_erned_t: 0;

														$grade_credit_erned_t = ($integer_credit*$grade_erned_t);

														if($row4['type_status']==1){
															$sql_subject = 'select * from add_subject where sno = "'.$row4['subject_id'].'"';
														}else{
															$sql_subject = 'select * from add_subject2 where sno = "'.$row4['subject_id'].'"';
														}
														$row_subject = mysqli_fetch_assoc(mysqli_query($db,$sql_subject));

														if($row4['type']=='Cocurricular'){
															$credit_paper_t = 'NC';
															$earned_credit_t = 'NC';
															$grade_erned_t = 'NA';
															$grade_credit_erned_t = 'NA';
															$cocurricular_count++;
														}
														

													?>
													<?php
														if($row4['type']!='Cocurricular'){
														    $tot_course_credit += (float)$credit_paper_t;
    														$tot_obt_credit += (float)$total_obt_t;
    														$tot_mid_max += (float)$mid_marks_max;
    														$tot_mid_obt += (float)$mid_marks_obt;
    														$tot_theory_max += (float)$theory_marks_max;
    														$tot_theory_obt += (float)$theory_marks_obt;
    														$tot_prac_max += (float)$practical_marks_max;
    														$tot_prac_obt += (float)$practical_marks_obt;
													?>
													<tr style="border:1px solid black; border-style:;">

														<?php  $count_row++; ?>
														<?php //echo $row4['type']; ?>
														<td><?php echo $row_subject['subject']; ?></td>
														<td><?php echo $paperCode; ?></td>
														<td><?php echo $row4['title_of_paper']; ?></td>
														<td><?php echo $total_max_sub = ((float)$theory_marks_max+(float)$mid_marks_max); ?></td>
															<?php //echo $credit_paper_t; ?>
															<?php //echo $mid_marks_obt; ?>
															<?php //echo $theory_marks_obt; ?>
														<td><?php echo $total_max_sub = ((float)$theory_marks_obt+(float)$mid_marks_obt);  ?></td>
															<?php //echo $total_obt_t;?>
														<td><?php echo $credit_paper_t; ?></td>
														<td><?php echo $earned_credit_t; ?></td>
														<td><?php echo $grade_erned_t; ?></td>
														<td><?php echo calculate_grade_letter($total_obt_t, ((float)$theory_marks_max+(float)$mid_marks_max)); ?></td>
														<td><?php echo $grade_credit_erned_t; ?></td>
													</tr>
													<?php
															$total_credit_earned += $earned_credit_t;
															$total_grade_credit_erned_point +=$grade_credit_erned_t;
															$total_max += $total_max_t;
															$total_obt += $total_obt_t;
													
															$mid_marks_obt_passing_chk = is_numeric($mid_marks_obt) ? $mid_marks_obt: 0;
															$theory_marks_obt_passing_chk = is_numeric($theory_marks_obt) ? $theory_marks_obt: 0;
															$practical_marks_obt_passing_chk = is_numeric($practical_marks_obt) ? $practical_marks_obt: 0;
													
															//if($passing_status == 'PASSED'){
																if($row4['type']!='Vocational'){
																	if($total_max_sub!=0 && $total_max_sub!=NULL){
																	$percentage_t = percentage_marks($total_obt_t,$total_max_sub);
																		if($percentage_t<33){
																			$passing_status = 'FAILED';
																			$passing_status_reason = 'TOTAL MARKS <33';
																			$backpaperArray[] = $paperCode;
																		}
																	}
																	if($total_max_t!=0){
																		if($grade_erned_t<4){
																		$passing_status = 'FAILED';
																		$passing_status_reason = 'Grade <4';
																		$backpaperArray[] = $paperCode;
																		}
																	}
																}
															// }
															// else{
																// $passing_status = 'FAILED';
															// }
														}else{
													?>
													<!--
											        <tr style="border:1px solid black; border-style:;">
													
        												<th></th>
        												<th></th>
        												<th></th>
        												<th style="text-align:right">Total : </th>
        												<th style="text-align:center;"><?php //echo $tot_course_credit; ?></th>
        												<th style="text-align:center;"><?php //echo ($tot_prac_max+$tot_theory_max+$tot_mid_max); ?></th>
        												<th style="text-align:center;"><?php //echo $tot_mid_obt; ?></th>
        												<th style="text-align:center;"><?php //echo ($tot_obt_credit-$tot_mid_obt); ?></th>
        												<th style="text-align:center;"><?php //echo $tot_obt_credit; ?></th>
        												<th></th>
        												<th></th>
        												<th style="text-align:center;"><?php //echo $total_grade_credit_erned_point; ?></th>
        											</tr>
													-->
											        <tr style="border:1px solid black; border-style:;">
															<?php  $count_row++; ?>
															<?php //echo $row4['type']; ?>
														<td><?php echo $row_subject['subject']; ?></td>
														<td><?php echo $paperCode; ?></td>
														<td><?php echo $row4['title_of_paper']; ?></td>
														<td><?php echo ((float)$theory_marks_max+(float)$mid_marks_max); ?></td>				
														<td><?php echo $total_obt_t = ((float)$theory_marks_obt+(float)$mid_marks_obt); ?></td>
														<td><?php echo $credit_paper_t; ?></td>
														<td><?php echo $earned_credit_t; ?></td>
														<td><?php echo $grade_erned_t; ?></td>
														<td><?php 
														if($theory_marks_obt == 'Abs'){
														    echo 'NQ';
															$passing_status = 'FAILED';
															$backpaperArray[] = $paperCode;
														}
														elseif (percentage_marks($total_obt_t, ((float)$theory_marks_max+(float)$mid_marks_max))>=33){
														    echo 'Q';
														}
														else{
															echo 'F';
														};
															?>
														</td>
														<td><?php echo $grade_credit_erned_t; ?></td>
													</tr>
													
													<?php
															if($total_max_t!=0 && $total_max_t!=NULL){
																$percentage_t_c = percentage_marks($total_obt_t,$total_max_t);
																if($percentage_t_c<33){
																	$passing_status_reason = 'Cocurricular MARKS <33';
																}
															}
														}
												}
												if(isset($row3['practical_paper_code'])){
													$sql5 = 'SELECT * FROM `exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" && paper_code = "'.$row3['practical_paper_code'].'"';
													//echo $sql5.'<br>';
													$result5 =mysqli_query($db,$sql5);
													$row5=mysqli_fetch_assoc($result5);
													if(isset($row5['paper_code'])){
													$paperCode = $row5['paper_code'];
													if (!in_array($paperCode, $paperCodeArray)) {
													$paperCodeArray[] = $paperCode;
														
														if($row5['theory_practical']=="Practical"){
															$practical_marks_max_p=$row5['pt_marks_max'];
															$practical_marks_obt_p=$row5['pt_marks_obt'];
															$theory_marks_max_p='';
															$theory_marks_obt_p='';
															$mid_marks_max_p='';
															$mid_marks_obt_p='';
														}
														if($row5['theory_practical']=="Viva-voce"){
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
														}
													
														$mid_marks_obt_num_p = is_numeric($mid_marks_obt_p) ? $mid_marks_obt_p: 0;
															$theory_marks_obt_num_p = is_numeric($theory_marks_obt_p) ? $theory_marks_obt_p: 0;
															$practical_marks_obt_num_p = is_numeric($practical_marks_obt_p) ? $practical_marks_obt_p: 0;
															$total_obt_p = ($mid_marks_obt_num_p+$theory_marks_obt_num_p+$practical_marks_obt_num_p);
															
															$mid_marks_max_num_p = is_numeric($mid_marks_max_p) ? $mid_marks_max_p: 0;
															$theory_marks_max_num_p = is_numeric($theory_marks_max_p) ? $theory_marks_max_p: 0;
															$practical_marks_max_num_p = is_numeric($practical_marks_max_p) ? $practical_marks_max_p: 0;
															$total_max_p = ($mid_marks_max_num_p+$theory_marks_max_num_p+$practical_marks_max_num_p);
															
															if($total_max_p!=0){
																$grade_erned_p = calculate_grade($total_obt_p,$total_max_p);
															}
															else{
																$grade_erned_p = 0;
															}
															//$grade_erned_p = calculate_grade($total_obt_p,$total_max_p);
															if(is_numeric($row5['credit'])){
																$credit_paper_p = $row5['credit'];
															}else{
																$a = $row5['credit'];
																list($a1, $a2) = explode("+", $a);

																$credit_paper_p = $a2;
															}
														
															if($row4['type_status']==1){
																$sql_subject = 'select * from add_subject where sno = "'.$row5['subject_id'].'"';
															}else{
																$sql_subject = 'select * from add_subject2 where sno = "'.$row5['subject_id'].'"';
															}
															$row_subject = mysqli_fetch_assoc(mysqli_query($db,$sql_subject));
														
														$tot_course_credit += (float)$credit_paper_p;
														$tot_obt_credit += (float)$total_obt_p;
														$tot_mid_max += (float)$mid_marks_max_p;
														$tot_mid_obt += (float)$mid_marks_obt_p;
														$tot_theory_max += (float)$theory_marks_max_p;
														$tot_theory_obt += (float)$theory_marks_obt_p;
														$tot_prac_max += (float)$practical_marks_max_p;
														$tot_prac_obt += (float)$practical_marks_obt_p;
														/*
														$total_obt_t = (isset($total_obt_t))?$total_obt_t:0;
														$practical_marks_obt_p = (isset($practical_marks_obt_p))?$practical_marks_obt_p:0;
														echo $total_obt_t;
														echo $practical_marks_obt_p;
														*/
														$total_obt_t_print = is_numeric($total_obt_t) ? $total_obt_t: 0;
														$practical_marks_obt_p_print = is_numeric($practical_marks_obt_p) ? $practical_marks_obt_p: 0;
														
														$tot_sub_pract_theo = ($total_obt_t_print+$practical_marks_obt_p_print);
														$total_max_pract_theo = ($total_max_sub + $practical_marks_max_p);
													?>
													<tr style="border:1px solid black; border-style:;">
															<?php //echo $row5['type']; ?>
														<td><?php echo $row_subject['subject']; ?></td>
														<td><?php echo $paperCode; ?></td>
														<td><?php echo $row5['title_of_paper']; ?></td>
														<td><?php echo $practical_marks_max_p; ?></td>
														<td><?php echo $practical_marks_obt_p; ?></td>
														<?php
														
															$mid_marks_max = is_numeric($mid_marks_max) ? $mid_marks_max: 0;
															$theory_marks_max = is_numeric($theory_marks_max) ? $theory_marks_max: 0;
															$practical_marks_max = is_numeric($practical_marks_max) ? $practical_marks_max: 0;
														
															$mid_marks_max_p = is_numeric($mid_marks_max_p) ? $mid_marks_max_p: 0;
															$theory_marks_max_p = is_numeric($theory_marks_max_p) ? $theory_marks_max_p: 0;
															$practical_marks_max_p = is_numeric($practical_marks_max_p) ? $practical_marks_max_p: 0;
														
															$mid_marks_obt = is_numeric($mid_marks_obt) ? $mid_marks_obt: 0;
															$theory_marks_obt = is_numeric($theory_marks_obt) ? $theory_marks_obt: 0;
															$practical_marks_obt = is_numeric($practical_marks_obt) ? $practical_marks_obt: 0;
														
															$mid_marks_obt_p = is_numeric($mid_marks_obt_p) ? $mid_marks_obt_p: 0;
															$theory_marks_obt_p = is_numeric($theory_marks_obt_p) ? $theory_marks_obt_p: 0;
															$practical_marks_obt_p = is_numeric($practical_marks_obt_p) ? $practical_marks_obt_p: 0;
														
															$total_mid_max = $mid_marks_max+$mid_marks_max_p;
															$total_mid_obt = $mid_marks_obt+$mid_marks_obt_p;
															$total_theory_max = $theory_marks_max+$theory_marks_max_p;
															$total_theory_obt = $theory_marks_obt+$theory_marks_obt_p;
															$total_practical_max = $practical_marks_max+$practical_marks_max_p;
															$total_practical_obt = $practical_marks_obt+$practical_marks_obt_p;
															
															$total_obt_p_t = $total_mid_obt+$total_theory_obt+$total_practical_obt;
															$total_max_p_t = $total_mid_max+$total_theory_max+$total_practical_max;
															
															$total_credit = ($credit_paper_t+$credit_paper_p);
															
															if($total_max_p != 0){
																$sub_percentage_p = percentage_marks($total_obt_p,$total_max_p);
															}else{
																$sub_percentage_p = 0;
															}
															if($sub_percentage_p >= 33){
																$earned_credit_p = $credit_paper_p;
															}else{
																$earned_credit_p = 0;
															}
															
															$result_credit_p = eval("return $earned_credit_p;");
															$integer_credit_p = intval($result_credit_p);
															$grade_credit_erned_p = ($integer_credit_p*$grade_erned_p);
														?>
															<td><?php echo $credit_paper_p; ?></td>
															<td><?php echo $earned_credit_p; ?></td>
															<td><?php echo $grade_erned_p; ?></td>
															<td><?php echo calculate_grade_letter($practical_marks_obt_p, $practical_marks_max_p).'</td>';?>
															<td><?php echo $grade_credit_erned_p; ?></td>
													</tr>
														<?php
																$total_credit_earned += $earned_credit_p;
																$total_grade_credit_erned_point +=$grade_credit_erned_p;
																$total_max += $total_max_p;
																$total_obt += $total_obt_p;		
														
																if($total_max_pract_theo!=0 && $total_max_pract_theo!=NULL){
																$percentage_t = percentage_marks($tot_sub_pract_theo,$total_max_pract_theo);
																	if($percentage_t<33){
																		$passing_status = 'FAILED';
																		$backpaperArray[] = $paperCode;
																		$passing_status_reason = 'TOTAL MARKS <33';
																	}
																}
																if($total_max_p!=0){
																	if($grade_erned_p<4){
																		$passing_status = 'FAILED';
																		$backpaperArray[] = $paperCode;
																		$passing_status_reason = 'Grade <33';
																	}
																}
														
															$mid_marks_max = is_numeric($mid_marks_max) ? $mid_marks_max: 0;
															$theory_marks_max = is_numeric($theory_marks_max) ? $theory_marks_max: 0;
															$practical_marks_max = is_numeric($practical_marks_max) ? $practical_marks_max: 0;
														
															$mid_marks_max_p = is_numeric($mid_marks_max_p) ? $mid_marks_max_p: 0;
															$theory_marks_max_p = is_numeric($theory_marks_max_p) ? $theory_marks_max_p: 0;
															$practical_marks_max_p = is_numeric($practical_marks_max_p) ? $practical_marks_max_p: 0;
														
															$mid_marks_obt = is_numeric($mid_marks_obt) ? $mid_marks_obt: 0;
															$theory_marks_obt = is_numeric($theory_marks_obt) ? $theory_marks_obt: 0;
															$practical_marks_obt = is_numeric($practical_marks_obt) ? $practical_marks_obt: 0;
														
															$mid_marks_obt_p = is_numeric($mid_marks_obt_p) ? $mid_marks_obt_p: 0;
															$theory_marks_obt_p = is_numeric($theory_marks_obt_p) ? $theory_marks_obt_p: 0;
															$practical_marks_obt_p = is_numeric($practical_marks_obt_p) ? $practical_marks_obt_p: 0;
														
															$total_mid_max = $mid_marks_max+$mid_marks_max_p;
															$total_mid_obt = $mid_marks_obt+$mid_marks_obt_p;
															$total_theory_max = $theory_marks_max+$theory_marks_max_p;
															$total_theory_obt = $theory_marks_obt+$theory_marks_obt_p;
															$total_practical_max = $practical_marks_max+$practical_marks_max_p;
															$total_practical_obt = $practical_marks_obt+$practical_marks_obt_p;
															
															$total_obt_p_t = $total_mid_obt+$total_theory_obt+$total_practical_obt;
															$total_max_p_t = $total_mid_max+$total_theory_max+$total_practical_max;
															
															$total_credit = ($credit_paper_t+$credit_paper_p)
														?>
													<tr >
													<?php	
												}
												}
												}
												
											}
											}
											?>	
            </table>
			<table width="100%">
			<tr>
                    <th colspan="9" class="text-center">RESULT</th>
                </tr>
				<tr>
                    <th colspan="9" >CURRENT SEMESTER RECORD</th>
                </tr>
				<tr>
					<th style="text-align:center;">MAX <BR> MARKS</th>
					<th style="text-align:center;">TOTAL <BR> MARKS</th>
					<th style="text-align:center;">TOTAL <BR> CREDITS</th>
					<th style="text-align:center;">EARNED <BR> CREDITS</th>
					<th style="text-align:center;">TOTAL <BR> CREDIT <BR> POINTS</th>
					<th style="text-align:center;">CREDIT <BR>PERCENTAGE </th>
					<th style="text-align:center;">SGPA<BR> </th>
					<th style="text-align:center;">CGPA</th>
					<th style="text-align:center;">RESULT STATUS</th>
					
				</tr>
				<?php 
				$credit_percentage = ($total_credit_earned*100)/$tot_course_credit;
				$sgpa = $total_grade_credit_erned_point/$total_credit_earned;
				$sgpa = number_format($sgpa, 2);
				?>
				<tr>
					<td><center><?php echo $total_max; ?></center></td>
					<td><center><?php echo $total_obt;?></center></td>
					<td><center><?php echo $tot_course_credit;?></center></td>
					<td><center><?php echo $total_credit_earned;?></center></td>
					<td><center><?php echo $total_grade_credit_erned_point;?></center></td>
					<td><center><?php echo $credit_percentage;?></center></td>
					<td><center><?php echo $sgpa; ?></center></td>
					<td><center><?php echo $sgpa; ?></center></td>
					<td><center><b><?php echo $passing_status; ?></b></center></td>
				</tr>
			</table><br>
			<table width="100%">
			<tr>
                    <th colspan="3" class="text-center">DETAILS OF BACKLOG PAPER</th>
                </tr>
				<tr>
					<th style="text-align:center;" width="25%">SEMESTER DETAILS</th>
					<th style="text-align:center;" width="35%">BACKLOG PAPER</th>
					<th style="text-align:center;" width="40%">FINAL REMARK</th>
					
				</tr>
				<tr>
					<td><center>FIRST SEMESTER</center>
					</td>
					<td><center><?php foreach ($backpaperArray as $element) {
									echo $element . '  ';
								};?>
						</center>
					</td>
					<td><center><?php
									if(empty($backpaperArray)) {
										echo '';
									}
									else{
										echo 'Students must clear their backlog paper(s) in the respective semester cycle';
									}
								?>
						</center>
					</td>
				</tr>
				<tr>
					<td colspan="3">NC = NON CREDITED , NA = NOT APPLICABLE , ATKT = ALLOWED TO KEEP TERM</td>
				</tr>
			</table><br>
			<table width="100%">
			<tr>
					<td colspan="12" style="text-align:center;font-size:1.7rem;font-weight:bold;padding:1rem;">
						GRADING AND PASSING RULESS UNDER CHOICE BASED CREDIT SYSTEM (CBCS)
					</td>
				</tr>
				<tr>
					<td>MARKS RANGE</td>
					<td>91-100</td>
					<td>81-90</td>
					<td>71-80</td>
					<td>61-70</td>
					<td>51-60</td>
					<td>41-50</td>
					<td>33-40</td>
					<td>0-32</td>
					<td>Absent</td>
					<td>-</td>
					<td>-</td>
					
				</tr>
				<tr>
					<td>LETTER GRADE</td>
					<td>O</td>
					<td>A+</td>
					<td>A</td>
					<td>B+</td>
					<td>B</td>
					<td>C</td>
					<td>D</td>
					<td>F</td>
					<td>AB</td>
					<td>Q</td>
					<td>NQ</td>
					
				</tr>
				<tr>
					<td>GRADE POINT</td>
					<td>10</td>
					<td>9</td>
					<td>8</td>
					<td>7</td>
					<td>6</td>
					<td>5</td>
					<td>4</td>
					<td>0</td>
					<td>0</td>
					<td>QUALIFIED</td>
					<td>NOT QUALIFIED</td>
					
				</tr>
			</table>

			<table width="100%">
				<tr>
					<td colspan="2" style="text-align:center;font-size:1.2rem;font-weight:bold;">SGPA has been calculated according to the following formula</td>
				</tr>
				<tr>
					<td rowspan="2">SGPA(Si)=Σ(Ci*Gi)/ΣCi</td>
					<td>Ci=the number of credits of the ith course in a semester.</td>
				</tr>
				<tr>
					<td>Gi=the grade point scored by the student in the ith course</td>
				</tr>
				<tr>
					<td>POINT SECURED </td>
					<td>EARNED CREDIT * GRADE POINT</td>
				</tr>
				<tr>
					<td colspan="2"> RESULT DECLARATION DATE : <?php echo date("d/m/Y"); ?></td>
				</tr>
			</table>
			
        </div>
		</div>
    <div>
  </body>
</html>

<?php
$paper_type_show_major = NULL;
$paper_type_show_minor = NULL;
$paper_type_show_cocurricular = NULL;
$paper_type_show_vocational = NULL;
$passing_status = 'PASSED';			
$grand_total_obt = 0;
$grand_total_max = 0;			
$total_credit_earned = 0;
$total_credit_default  = 0;
$Cocurricular_count = 0;
$total_credit_point_earned = 0;
			
}
}
}
?>	