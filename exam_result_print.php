<?php 
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg='';



if(!isset($_POST['exam_roll_no'])){
	header("location:exam_result.php");
}

$sql_ag_check = 'select * from class_detail where sno = "'.$_POST['result_course'].'"';
$result_ag_check = mysqli_query($db, $sql_ag_check);
$row = mysqli_fetch_assoc($result_ag_check);

if($row['crasslist_type']==1){
	$_SESSION['result_course'] = $_POST['result_course'];
	$_SESSION['exam_roll_no'] = $_POST['exam_roll_no'];
	header("location:exam_result_print_ag.php");
}
if($row['crasslist_type']==3){
	$_SESSION['result_course'] = $_POST['result_course'];
	$_SESSION['exam_roll_no'] = $_POST['exam_roll_no'];
	header("location:exam_result_print_llb24.php");
}
if($row['crasslist_type']==4||$row['crasslist_type']==2){
	$_SESSION['result_course'] = $_POST['result_course'];
	$_SESSION['exam_roll_no'] = $_POST['exam_roll_no'];
	header("location:exam_result_print_bped.php");
}
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
$incpaperArray = array();

if(isset($_POST['result_course'])){
	//$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`student_info_sno`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`,`student_info`.`mother_name`,`student_info`.`photo_id` FROM `exam_student_info` LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno where `exam_student_info`.`exam_roll_no` = "'.$_POST['exam_roll_no'].'" AND `exam_student_info`.`course_name` = "'.$_POST['result_course'].'" AND `exam_student_info`.`dob` = "'.$_POST['stu_dob'].'"';
		
	$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`student_info_sno`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`result_sno`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`,`student_info`.`mother_name`, `exam_student_info`.`qr_code`,bar_code ,`student_info`.`photo_id` FROM `exam_student_info` 
	LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno where `exam_student_info`.`course_name` = "'.$_POST['result_course'].'" ';
	if ($_POST['exam_roll_no']!=''){
		$sql .= 'AND  `exam_student_info`.`exam_roll_no` = "'.$_POST['exam_roll_no'].'"';
	}else{
		// $sql .= 'LIMIT 13';
	}
	// echo $sql;
	//$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`student_info_sno`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`,`student_info`.`mother_name`,`student_info`.`photo_id` FROM `exam_student_info` LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno where `exam_student_info`.`course_name` = "'.$_POST['result_course'].'" order by  `exam_student_info`.`exam_roll_no` limit 1';
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>A3 Certificate Print</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
   :root {
	  --page-width: 430mm;
	  --page-height: 294.1mm;
	}

	/* Reset and font styles */
	html, body {
	  margin: 0;
	  padding: 0;
	  height: 100%;
	  font-family: "Roboto", sans-serif;
	  width:auto;
	}

	/* Typography */
	h1 { font-size: 1.8rem !important; }
	h2 { font-size: 1.5rem !important; }
	h3 { font-size: 1.3rem !important; }
	h4 { font-size: 1rem !important; }
	p  { font-size: 10px !important; }
	td, th { font-size: 10px !important; }

	.look {
	  padding: 0px !important;
	  margin: 0px !important;
	  font-size: 8px;
	  padding-left: 3px !important;
	}

	#main {
	  margin: 10px !important;
	  padding: 0px;
	}

	/* Background Page Container */
	.page {
	  width: var(--page-width);
	  min-height: var(--page-height); /* Ensures full image shown on screen */
	  background-image: url('image/new_marksheet_background.jpg');
	  background-size: cover;
	  background-position: center;
	  background-repeat: no-repeat;
	  page-break-inside: avoid;

	  display: flex !important;
	  flex-direction: row;
	  justify-content: space-between;
	  margin: auto;
	  padding: 0;
	}

	/* Certificate Box */
	.certificate {
	  width: 50%;
	  height: 100%;
	  
	  position: relative;
	}

	.header {
	  text-align: center;
	  margin-bottom: 10mm;
	}
	.institute-name {
	  font-weight: bold;
	  font-size: 18pt;
	  color: #4b0082;
	}
	.subtext {
	  font-size: 10pt;
	  color: #555;
	}
	.logo {
	  width: 40mm;
	  height: 40mm;
	  position: absolute;
	  top: 10mm;
	  left: 10mm;
	}
	.sno-box {
	  position: absolute;
	  top: 10mm;
	  right: 10mm;
	  font-size: 10pt;
	}
	.content-box {
	  width: 170mm;
	  height: 193mm;
	  margin: 0 auto;
	  margin-top: 65mm;
	}

	/* Transparent Table */
	table {
	  background-color: transparent !important;
	  border-collapse: collapse;
	}
	table td, table th {
	  background-color: transparent !important;
	  
	}

	/* Custom Classes */
	.abc {
	  border: 1px solid black;
	}
	.merge_column1 {
	  position: absolute;
	  top: 2%;
	  left: 50%;
	  transform: translate(-50%, -50%);
	  padding-top: 1px;
	  padding-inline: 0.1rem;
	}

	/* Print-Specific Styles */
	@media print {
	  body {
		background: none;
	  }

	  @page {
		size: 430mm 294.1mm;
		margin: 0;
	  }

	  .page {
		background-image: url('image/new_marksheet_background.jpg');
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
		height: var(--page-height);
		page-break-inside: avoid;
	  }

	  h1 { font-size: 1.8rem !important; }
		h2 { font-size: 1.5rem !important; }
		h3 { font-size: 1.3rem !important; }
		h4 { font-size: 1rem !important; }
		p  { font-size: 9px !important; }
		td, th { font-size: 10px !important; }
		.look {
	  
	  padding-left: 3px !important;
	}

	  .abc {
		border: 1px solid black !important;
	  }

	  #printButton,
	  .no-print {
		display: none !important;
	  }

	  .logo,
	  .sno-box,
	  .header {
		visibility: hidden; /* Hides content but retains space */
	  }
	}
	
  </style>
</head>

	<body>
	

	  <?php
		//echo $sql;
		$result =mysqli_query($db,$sql);
		if(mysqli_num_rows($result)>0){
			$student_exists = 1;
		}
		else{
			$student_exists = 0;
		}
		if($student_exists==1){
		$i=1;
		$cr=0;
		
		while($row=mysqli_fetch_assoc($result)){
			if ($cr % 2 == 0) {
				echo '<div class="page">';
			}
		?>
			
		<!-- Left Certificate -->
		<div class="certificate">
			
			<div class="sno-box " style="margin-top:28px; font-size:16px;margin-right:48px;">123456</div>
			<div class="header">
			  <div class="institute-name"></div>
			  <div class="subtext"></div>
			</div>
			<div class="content-box">
				<h4 class="text-center ">STATEMENT OF MARKS<br><span style="font-size:14px;">2023-2024<br><br><span><h4>
				<table class="table table-borderless text-start table-transparent" >
					<tr>
						<th width="15%" class="look">Name </th>
						<th width="25%" class="look">:	<?php echo strtoupper($row['student_name']);?></th >
						<th width="15%" class="look">Roll NO.</th>
						<th width="25%" class="look">: <?php echo $row['exam_roll_no']; ?></th >
						<th width="20%" rowspan="5">
						<?php
							if(fileExists("PHOTO/".$row['photo_id'])){
								$photo = fileExists("PHOTO/".$row['photo_id']);
							}
							else{
								$photo = $row['photo_id'];
							}
						?>
						<img style="width:70px; height:60px; " src="<?php echo $photo; ?>" alt="Student Image"></th>
					</tr>
					<tr>
						<th class="look">Father's Name</th>
						<th class="look">: <?php echo strtoupper($row['father_name']); ?></th >
						<th class="look">Class</th>
						<th class="look">: <?php 
						$sql_class = 'select * from class_detail where sno = "'.$row['course_name'].'"'; $row_class = 	mysqli_fetch_assoc(mysqli_query($db,$sql_class));
							echo $row_class['class_description'];   ?>
						</th >
					</tr>
					<tr>
						<th class="look">Mother's Name</th>
						<th class="look">: <?php echo strtoupper($row['mother_name']); ?></th >
						<th class="look">UIN NO.</th>
						<th class="look">: <?php echo $row['uin_no']; ?></th >
					</tr>
					
				</table>	
				<table class="table text-start" style="border:1px solid black; ">
					<tr style="border:1px solid black; ">
					<?php if($row_class['category']!='PG'){ ?>
						<th  width="18%" class="abc">SUBJECT</th>
					<?php } ?>	
						<th  width="15%"  class="abc">PAPER CODE</th>
						<th width="25%"  class="abc">PAPER TITLE</th>
						<th width="6%"  class="abc"> MAX MARKS </th>
						<th width="6%" class="abc">MARKS OBTAINED</th>
						<th width="6%"  class="abc">COURSE CREDIT</th>
						<th width="6%"  class="abc">EARNED CREDIT</th>
						<th width="6%"  class="abc">GRADE POINTS</th>
						<th width="6%"  class="abc">CREDIT POINTS</th>
						<th width="6%"  class="abc">LETTER GRADE</th>
						
					</tr>
					<?php
					$paperCodeArray = array();
					if($_POST['result_course']==56){
						$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type = 'Major' THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type = 'Remedial' THEN 3 WHEN type = 'Non-Gradial' THEN 4 END"; 
					}else{
						$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type in ('Major', 'Core') THEN 1 WHEN type in ('Elective') THEN 2 WHEN type in ('Minor') THEN 3 WHEN type in ('Vocational', 'Supporting') THEN 4 WHEN type in ('Cocurricular', 'Common') THEN 5 END"; 
					}
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
					$grace_flag=0;
					while ($row2 = mysqli_fetch_assoc($result2)) {
						if($row2['type']=="Major"){
							if(!isset($paper_type_show_major)){
								$paper_type_show_major = $row2['type'];
								echo '<tr><th colspan="12" style="text-align:left;">MAJOR SUBJECTS</th></tr>';
							}
						}
						if($row2['type']=="Minor"){
							if(!isset($paper_type_show_minor)){
								$paper_type_show_minor = $row2['type'];
								echo '<tr><th colspan="12" style="text-align:left;">MINOR SUBJECT</th></tr>';
							}
						}
						if($row2['type']=="Cocurricular"){
							if(!isset($paper_type_show_cocurricular)){
								$paper_type_show_cocurricular = $row2['type'];
								echo '<tr><th colspan="12" style="text-align:left;">COCURRICULAR (Qualifying): Non-credited paper. Marks are not added in total.</th></tr>';
							}
						}
						if($row2['type']=="Vocational"){
							if(!isset($paper_type_show_vocational)){
								$paper_type_show_vocational = $row2['type'];
								echo '<tr><th colspan="12" style="text-align:left;">VOCATIONAL</th></tr>';
							}
						}
						$paperCode = $row2['paper_code'];
						$sql3 = 'SELECT * FROM `exam_paper_code_mapping` where `theory_paper_code` = "'.$paperCode.'"';
						
						$result3 =mysqli_query($db,$sql3);
						if(isset($student_paper)){
							unset($student_paper);
						}
						if(mysqli_num_rows($result3)>0){
							$row3=mysqli_fetch_assoc($result3);
							$student_paper = $row3['theory_paper_code'];
						}
						else{
							if(isset($row3)){
								unset($row3);
							}
						}
						if($row2['type_status']=='2'){
							$sql = 'select * from add_subject2 where sno="'.$row2['subject_id'].'"';
							$other_sub = mysqli_fetch_assoc(mysqli_query($db, $sql));
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
							if($row4['type']=="Elective"||"Common"){
								if($row4['theory_practical']=="Practical"){
									$practical_marks_max='';
									$practical_marks_obt='';
									$theory_marks_max=$row4['pt_marks_max'];
									$theory_marks_obt=$row4['pt_marks_obt'];
									$mid_marks_max=$row4['mid_sem_marks_max'];
									$mid_marks_obt=$row4['mid_sem_marks_obt'];
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
								$mid_marks_max=$row4['mid_sem_marks_max'];;
								$mid_marks_obt=$row4['mid_sem_marks_obt'];;
							}
							if($row4['theory_practical']=="Theory+Practical"){
								$practical_marks_max='';
								$practical_marks_obt='';
								$theory_marks_max='';
								$theory_marks_obt='';
								$mid_marks_max='';
								$mid_marks_obt='';
							}
							if($theory_marks_obt!='Abs' && $practical_marks_obt!='Abs'){
								if($theory_marks_obt=='' && $practical_marks_obt=='' ){
									$incpaperArray[] = $paperCode;
								}
								elseif($theory_marks_obt>$theory_marks_max || $practical_marks_obt>$practical_marks_max){
									$incpaperArray[] = $paperCode;
								}
								elseif($row4['type']!='Vocational'){
									$pt_marks_max = (float)$row4['pt_marks_max'];
									$mid_sem_marks_max = (float)$row4['mid_sem_marks_max'];
									if (($pt_marks_max + $mid_sem_marks_max) < 100 || ($pt_marks_max + $mid_sem_marks_max) > 100) {
									 
										$incpaperArray[] = $paperCode;
									}
								}
								elseif($row2['type']=='Vocational'){
									if($row2['pt_marks_max']!=40 && $row2['pt_marks_max']!=60){
										$incpaperArray[] = $paperCode.' ** '.$row2['pt_marks_max'].' ** '.$row2['type'];
									}
								}
							}
							if($theory_marks_obt=='Abs' || $practical_marks_obt=='Abs'){
								$grace_flag_print='';
								$total_obt_sub = 'Abs';
							}else{
								$total_obt_sub = ((float)$theory_marks_obt+(float)$mid_marks_obt);
								$grace_flag_print='';
								if ($grace_flag == 0 && $row4['type'] != 'Vocational') {
									if ($total_obt_sub == 31) {
										$total_obt_sub += 2;
										$theory_marks_obt += 2;
										$grace_flag_print = $grace_flag = 2;
									} elseif ($total_obt_sub == 32) {
										$total_obt_sub += 1;
										$theory_marks_obt += 1;
										$grace_flag_print = $grace_flag = 1;
									} 
								}
							}
							$total_obt_t = $total_obt_sub;
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
								list($a1, $a2) = explode("+", $a) + [null, null];
								$credit_paper_t = $a1;
							}
							if($total_max_t!=0){
								$sub_percentage_t = percentage_marks($total_obt_t,$total_max_t);
							}
							else{
								$sub_percentage_t = 0;
							}
							if($sub_percentage_t >= 33){
								$earned_credit_t = $credit_paper_t;
							}else{
								if($row2['type']=='Vocational' && $theory_marks_obt!='Abs'){
										$earned_credit_t = $credit_paper_t;
								}
								else{
									$earned_credit_t = 0;
								}
							}	
							$result_credit = $earned_credit_t;
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
								$grade_erned_t = 'NC';
								$grade_credit_erned_t = 'NC';
								$cocurricular_count++;
							}

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
						<?php  
						$count_row++; 
						if($row4['type']=='Vocational'){
							if($row4['paper_code']=='KI010202P'){			 
								if($row_class['category']!='PG'){ 
						?>
							<td class="abc"><?php echo $row_subject['subject']; ?></td>
						<?php } ?>	
							<td class="abc"><?php echo $vocational_theory_ppr = $paperCode; ?></td>
							<td class="abc"><?php  echo $row4['title_of_paper']; ?></td>
							<td class="abc"><?php  echo $total_max_sub = ((float)$theory_marks_max+(float)$mid_marks_max); ?></td>
							<td><?php  echo $total_obt_sub = (($theory_marks_obt=='Abs')?'Abs':((float)$theory_marks_obt+(float)$mid_marks_obt));  ?></td>
							<td class="abc"><?php  echo $credit_paper_t; ?></td>
							<td class="abc"><?php  echo $earned_credit_t; ?></td></td>
							<td class="abc"><?php  echo $grade_erned_t; ?></td>
							<td class="abc"><?php  echo (($total_obt_sub=='Abs')?'AB':calculate_grade_letter($total_obt_t, ((float)$theory_marks_max+(float)$mid_marks_max))); ?></td>
							<td class="abc"><?php  echo $grade_credit_erned_t; ?></td>
						<?php 
							$total_grade_credit_erned_point +=$grade_credit_erned_t;
							}   
							$row_subject['subject'];  
							$vocational_theory_ppr = $paperCode; 
							$row4['title_of_paper']; 
							$total_max_sub = ((float)$theory_marks_max+(float)$mid_marks_max); 
							$total_obt_sub = ($theory_marks_obt=='Abs'?'Abs':((float)$theory_marks_obt+(float)$mid_marks_obt));  
							$credit_paper_t; 
							$earned_credit_t; 
							$grade_erned_t; 
							calculate_grade_letter($total_obt_t, ((float)$theory_marks_max+(float)$mid_marks_max)); 
							$grade_credit_erned_t;  
						}else{
							if($row_class['category']!='PG'){ 
						?>
							<td class="abc"><?php echo $row_subject['subject']; ?></td>
							<?php } ?>	
							<td class="abc"><?php echo $paperCode; ?></td>
							<td class="abc"><?php echo $row4['title_of_paper']; ?></td>
						<?php
							if($row4['theory_practical']=="Viva-voce"){
								echo '<td class="text-center abc" >'.$practical_marks_max.'</td>
								<td class="text-center">'.$practical_marks_obt.'</td>';
							}else{
								$total_max_sub = ((float)$theory_marks_max+(float)$mid_marks_max);
								echo '<td class="text-center abc">'.$total_max_sub.'</td>';
							
								if ($grace_flag_print == 1 || $grace_flag_print == 2) {
									echo '<td class="text-center abc">'.$total_obt_sub . ' <sup>#</sup></td>';
								} else {
									if($total_obt_sub=='Abs' && $mid_marks_obt!='Abs' && $mid_marks_obt!='0' && $mid_marks_obt!=''){
										echo '<td class="text-center abc">'.$mid_marks_obt.'</td>';
									}
									else{
										echo '<td class="text-center abc">'.$total_obt_sub.'</td>';
									}
								}
							}
								?>
							<td class="text-center abc"><?php echo $credit_paper_t; ?></td>
							<td class="text-center abc"><?php echo $earned_credit_t; ?></td>
							<td class="text-center abc"><?php echo $grade_erned_t; ?></td>
							<td class="text-center abc"><?php echo $grade_credit_erned_t; ?></td>
							<td class="text-center abc"><?php 
							if(($mid_marks_obt=='Abs' || $mid_marks_obt=='') AND $total_obt_sub=='Abs'){
								echo "AB";
							} else {
								if($total_obt_sub=='Abs' && $mid_marks_obt!='Abs' && $mid_marks_obt!='0' && $mid_marks_obt!=''){
									echo calculate_grade_letter($mid_marks_obt, ((float)$theory_marks_max + (float)$mid_marks_max+ (float)$practical_marks_max));
								}
								else{
									echo calculate_grade_letter($total_obt_t, ((float)$theory_marks_max + (float)$mid_marks_max+ (float)$practical_marks_max));
								}
							}
						?>
							</td>	
						<?php
							$total_grade_credit_erned_point +=$grade_credit_erned_t;
						} ?>
					</tr>
						<?php
							$total_credit_earned += is_numeric($earned_credit_t) ? $earned_credit_t : 0;

							$total_max += $total_max_t;
							$total_obt = (float) $total_obt;
							$total_obt_t = (float) $total_obt_t;
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
											$passing_status_reason .= 'TOTAL MARKS <33';
											$backpaperArray[] = $paperCode;
										}
									}
									if($total_max_t!=0){
										if($grade_erned_t<4){
										$passing_status = 'FAILED';
										$passing_status_reason .= 'Grade <4';
										//$backpaperArray[] = $paperCode;
										}
									}
								}elseif($row4['type']=='Vocational'){
									if($total_obt_sub=='Abs'){
										$passing_status = 'FAILED';
										$passing_status_reason .= 'VOCATIONAL THEORY ABS';
										$backpaperArray[] = $paperCode;
									}
									
								}
							}else{
						?>
						<tr style="border:1px solid black; border-style:;">
										<?php  $count_row++; ?>
										<?php //echo $row4['type']; ?>
									<?php if($row_class['category']!='PG'){ ?>
										<td class="abc"><?php echo $row_subject['subject']; ?></td>
									<?php } ?>	
									<td class="abc"><?php echo $paperCode; ?></td>
									<td class="abc"><?php echo $row4['title_of_paper']; ?></td>
									<td class="text-center abc"><?php echo ((float)$theory_marks_max+(float)$mid_marks_max) ?></td>				
									<td class="text-center abc"><?php $total_obt_t = ((float)$theory_marks_obt+(float)$mid_marks_obt); 
										if ($grace_flag_print == 1 || $grace_flag_print == 2) {
												echo $theory_marks_obt . ' <sup>#</sup>';
											} else {
												echo $theory_marks_obt ;
											}
									 ?></td>
									<td class="text-center abc"><?php echo $credit_paper_t; ?></td>
									<td class="text-center abc"><?php echo $earned_credit_t; ?></td>
									<td class="text-center abc"><?php echo $grade_erned_t; ?></td>
									<td class="text-center abc"><?php echo $grade_credit_erned_t; ?></td>
									<td class="text-center abc"><?php 
									
									if($theory_marks_obt == 'Abs' ){
										echo 'NQ';
										$passing_status = 'FAILED';
										$backpaperArray[] = $paperCode;
										$passing_status_reason = 'Cocurricular not QUALIFIED';
									}
									elseif (percentage_marks($total_obt_t, ((float)$theory_marks_max+(float)$mid_marks_max))>=33){
										echo 'Q';
									}
									else{
										echo 'NQ';
									};
										?>
									</td>
									
						</tr>
								
								<?php
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
									$practical_marks_obt_p_show = $practical_marks_obt_p;
									
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
									
									$total_obt_t_print = is_numeric($total_obt_t) ? $total_obt_t: 0;
									$practical_marks_obt_p_print = is_numeric($practical_marks_obt_p) ? $practical_marks_obt_p: 0;
									
									$tot_sub_pract_theo = ($total_obt_t_print+$practical_marks_obt_p_print);
									$total_max_pract_theo = ($total_max_sub + $practical_marks_max_p);
								?>
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
										$grade_credit_erned_p = ((float)$integer_credit_p*(float)$grade_erned_p);
									?>
									<tr style="border:1px solid black; border-style:;">
										<?php if($row4['type']=='Vocational')
											{ 
										?>
											<?php if($row_class['category']!='PG'){ ?>
												<td class="abc"><?php echo $row_subject['subject']; ?></td>
											<?php } ?>	
											<td class="abc"><?php echo $vocational_theory_ppr; ?>,<?php echo $paperCode; ?></td>
											<td style="position:relative;" class="abc"><div class="merge_column"><?php echo $row5['title_of_paper']; ?></div></td>
											<td style="position:relative;" class="text-center abc">
											<div class="merge_column"><?php echo $practical_marks_max_p_t = $practical_marks_max_p+$total_max_sub; ?></td>
											<td style="position:relative;" class="text-center abc"><div class="merge_column">
											<?php 
											$practical_marks_obt_p_t = ($total_obt_sub=='Abs'?0:$practical_marks_obt_p+$total_obt_sub); 
											if($practical_marks_obt_p=='Abs' || $total_obt_sub=='Abs'){
												echo 'Abs';
											}
											else{
												
												echo ($practical_marks_obt_p_show=='Abs'?'Abs':$practical_marks_obt_p_t);
											}
											?>
											</td>
											<td style="position:relative; " class="text-center abc"><div class="merge_column"><?php echo $credit_paper_p_t = $credit_paper_p+$credit_paper_t; ?></div></td>
											<td style="position:relative;" class="abc"><div class="merge_column"><?php 
											if($practical_marks_obt_p_show == 'Abs'){
												echo $earned_credit_p_t = 0;
											}
											else{
												echo $earned_credit_p_t = $earned_credit_t+$earned_credit_p;
											}
											 ?></div></td>
											<td style="position:relative; border:none;" class="text-center abc"><div class="merge_column"><?php echo $grade_erned_p_t = calculate_grade($practical_marks_obt_p_t, $practical_marks_max_p_t);?></div></td>
											<td style="position:relative;" class="text-center abc"><div class="merge_column"><?php echo $grade_credit_erned_p_t = ((float)$earned_credit_p_t*(float)$grade_erned_p_t); ?></div></td>
											<td style="position:relative;" class="text-center abc"><div class="merge_column"><?php echo (($practical_marks_obt_p_show=='Abs')?'AB':calculate_grade_letter($practical_marks_obt_p_t, $practical_marks_max_p_t)).'</td>';?></div></td>
											
										<?php 
											if($practical_marks_obt_p=='Abs'){
												$passing_status = 'FAILED';
												$backpaperArray[] = $paperCode;
												$passing_status_reason .= 'VOCATIONAL PRACTICAL Abs';
											}
											$total_grade_credit_erned_point +=$grade_credit_erned_p_t;
											$vovational_percentage = percentage_marks($practical_marks_obt_p_t, $practical_marks_max_p_t);
											if($vovational_percentage<40){
												$passing_status = 'FAILED';
												//$backpaperArray[] = $paperCode;
												$passing_status_reason .= 'TOTAL VOCATIONAL <40';
											}
										}else{ 
										?>
											<?php if($row_class['category']!='PG'){ ?>
												<td><?php echo $row_subject['subject']; ?></td>
											<?php } ?>	
											<td class="abc"><?php echo $paperCode; ?></td>
											<td class="abc"><?php echo $row5['title_of_paper']; ?></td>
											<td class="text-center abc"><?php echo $practical_marks_max_p; ?></td>
											<td class="text-center abc"><?php echo $practical_marks_obt_p_show; ?></td>
											<td class="text-center abc"><?php echo $credit_paper_p; ?></td>
											<td class="text-center abc"><?php echo $earned_credit_p; ?></td>
											<td class="text-center abc"><?php echo $grade_erned_p; ?></td>
											<td class="text-center abc"><?php echo $grade_credit_erned_p; ?></td>
											<td class="text-center abc"><?php
													if($practical_marks_obt_p_show=="Abs"){
													 echo 'AB';	
													}else{
														echo calculate_grade_letter($practical_marks_obt_p, $practical_marks_max_p);
													}?>
											</td>		
											
										<?php 
											$total_grade_credit_erned_point +=$grade_credit_erned_p;
										}?>
									</tr>
									<?php
										$total_credit_earned += $earned_credit_p;
										$total_max += $total_max_p;
										$total_obt += $total_obt_p;		
								
										if($total_max_pract_theo!=0 && $total_max_pract_theo!=NULL){
										$percentage_t = percentage_marks($tot_sub_pract_theo,$total_max_pract_theo);
											if($percentage_t<33){
												$passing_status = 'FAILED';
												//$backpaperArray[] = $paperCode;
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
					<table width="100%" class="table  text-center" style="border:1px solid black; ">
						<tr>
							<th colspan="9" class="p-2" > SEMESTER RESULT</th>
						</tr>
						<tr>
							<th style="text-align:center;" class="abc">SEMESTER</th>
							<th style="text-align:center;" class="abc">MAX <BR> MARKS</th>
							<th style="text-align:center;" class="abc">TOTAL <BR> MARKS</th>
							<th style="text-align:center;" class="abc">TOTAL <BR> CREDITS</th>
							<th style="text-align:center;" class="abc">EARNED <BR> CREDITS</th>
							<th style="text-align:center;" class="abc">TOTAL <BR> CREDIT <BR> POINTS</th>
							<!--<th style="text-align:center;" class="abc">CREDIT <BR>PERCENTAGE </th>-->
							<th style="text-align:center;" class="abc">SGPA<BR> </th>
							<th style="text-align:center;" class="abc">CGPA</th>
							<th style="text-align:center;" class="abc">RESULT</th>
							
						</tr>
						<?php 
						if($tot_course_credit !=0){
							$credit_percentage = ($total_credit_earned*100)/$tot_course_credit;
							$sgpa = $total_grade_credit_erned_point/$tot_course_credit;
						}
						else{
							$sgpa = 0;
							$credit_percentage = 0;
						}
						$credit_percentage = number_format($credit_percentage, 2);
						$sgpa = number_format($sgpa, 2);
						if ($passing_status == 'FAILED' AND $sgpa >= '4') {	
							$passing_status='ATKT';
						}
						?>
						<?php
							$tot_tot_obt = 0;
							$tot_tot_max = 0;
							$tot_tot_obt_credit = 0;
							$tot_tot_max_credit = 0;
							$tot_tot_credit_point = 0;
							$tot_earned_credit = 0;

							$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, `max_marks`, `obt_marks`, earned_credit, total_credit, sgpa, cgpa, grade_point, passing_status, class_description FROM `exam_student_info` 
							LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno 
							LEFT JOIN class_detail on class_detail.sno = course_name
							where exam_roll_no!="" and exam_roll_no is not null and student_info_sno="'.$row['student_info_sno'].'" and exam_id=1 order by exam_roll_no';

							//echo $sql.'<br>';
							$result_sem_even = mysqli_query($db, $sql);
							$sub_html = ''; // Initialize the variable
							if (mysqli_num_rows($result_sem_even) != 0) {
								$row_sem_even = mysqli_fetch_assoc($result_sem_even);
								$sub_html .= '<tr style="border:1px solid black; border-style:;">
										<td class="abc">' . $row_sem_even['class_description'] . '</td>
										<td class="abc">' . $row_sem_even['max_marks'] . ' </td>
										<td class="abc">' . $row_sem_even['obt_marks'] . ' </td>
										<td class="abc">' . $row_sem_even['total_credit'] . '</td>
										<td class="abc">' . $row_sem_even['earned_credit'] . '</td>
										<td class="abc">' . $row_sem_even['grade_point'] . '</td>
										
										
										<td class="abc">' . $row_sem_even['sgpa'] . '</td>
										<td class="abc">' . $row_sem_even['cgpa'] . '</td>
										<td class="abc"><b>' . $row_sem_even['passing_status'] . '</b></td>
									</tr>';
									$tot_tot_obt+=(float)$row_sem_even['obt_marks'];
									$tot_tot_max+=(float)$row_sem_even['max_marks'];
									$tot_tot_obt_credit+=(float)$row_sem_even['earned_credit'];
									$tot_tot_max_credit+=(float)$row_sem_even['total_credit'];
									$tot_tot_credit_point+=(float)$row_sem_even['grade_point'];
									$tot_tot_cgpa = (($row_sem_even['total_credit'] * $row_sem_even['sgpa']) + ($tot_course_credit * $sgpa)) / ($row_sem_even['total_credit'] + $tot_course_credit);

									
								// Handle the case where no rows are returned
								
							}
							else{
								$sub_html .= '<tr><td colspan="10">No data found</td></tr>';
							}
							echo $sub_html;
						?>
					</table>
					
					 <p style="text-align:left; font-size:13px;"><b>Equivalent Percentage of Marks=CGPA*10 <br>NC = NON CREDITED , NA = NOT APPLICABLE , ATKT = ALLOWED TO KEEP TERM <br> # = PASSED WITH GRACE <br> </b></p>
					<table width="100%">		
						<tr>
							<th width="30%">
								<img src="<?php echo $row['bar_code'];?>" style="height:50px;"><br>RESULT DECLARATION DATE : 30/01/2024 
							</th>
							<th  width="40%" class="text-center">
								<img src="<?php echo $row['qr_code'];?>" style="height:70px;">
							</th>
							<th  width="30%">    </th>
						</tr>
						<tr>
							<th style="margin-top:5px;font-size:10px!important;" valign="bottom"><!--<img src="image/Principal.png" style="height:30px;">--><br> </th>
							<th class="text-center"> Checked By : <br><br>1. <br><br><br>2. </th>
							<th style="font-size:10px!important; text-align:right;" valign="bottom"><img src="image/RadheShyam.png" style="height:30px; padding-right:30px;padding-bottom:5px;"><br> Controller of Examination </th>
						</tr>
					</table>
					</div>
				</div>
			
<?php
    $cr++;
    if ($cr % 2 == 0) {
        echo '</div>
		</div></div>';
    }
}

if ($cr % 2 != 0) {
    echo '</div>';
}
?>	

<?php			
}else{
?>
<script>
  alert("Roll number not found.");
  window.location.href = "exam_result.php";
</script>
<?php
}
}
?>
	</body>	
</html>
