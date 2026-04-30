<?php 
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg='';
$tab=1;
$responce = 1;
if(isset($_SESSION['result_course'])){
	$_POST['result_course'] = $_SESSION['result_course'];
	$_POST['exam_roll_no'] = $_SESSION['exam_roll_no'];
}
// print_r($_POST);
if(isset($_POST['result_course'])){
	$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`student_info_sno`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`,`student_info`.`mother_name`,`exam_student_info`.`qr_code`,bar_code, result_srno,`student_info`.`photo_id` FROM `exam_student_info` LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno where `exam_student_info`.`course_name` = "'.$_POST['result_course'].'"'; 
	if ($_POST['exam_roll_no']!=''){
		$sql .= 'AND  `exam_student_info`.`exam_roll_no` = "'.$_POST['exam_roll_no'].'"';
	}else{
		$sql .= 'ORDER BY ABS(exam_roll_no)';
	}
	
	//$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`student_info_sno`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`,`student_info`.`mother_name`,`student_info`.`photo_id` FROM `exam_student_info` LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno where `exam_student_info`.`course_name` = "'.$_POST['result_course'].'" order by  `exam_student_info`.`exam_roll_no` limit 1';
	
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
	  margin: 0px !important;
	  padding: 0px;
	}

	/* Background Page Container */
	.page {
		size: 18in 12in;
	  width: var(--page-width);
	  min-height: var(--page-height); /* Ensures full image shown on screen */
	  background-image: url('image/new_reult_bg2.jpg');
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
	  margin-top: 66mm;
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
		size: 18in 12in;
		margin: 0;
	  }

	  .page {
		  size: 18in 12in;
		background-image: url('image/new_reult_bg2.jpg');
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
	  .header {
		visibility: hidden; /* Hides content but retains space */
	  }
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
	<script>
		function printAndRemoveButton() {
		  // Trigger the print action
		  window.print();

		  // Remove the print button
		  var printButton = document.getElementById('printButton');
		  printButton.parentNode.removeChild(printButton);
		}
    </script>
  </head>

  <body class="w-100 m-auto" id="main">

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
			<??>
			<?php
			$marginRight = ($cr % 2 == 0) ? '9mm' : '19mm'; // Example: left = 78px, right = 30px
			$marginRight1 = ($cr % 2 == 0) ? '105mm' : '115mm'; // Example: left = 78px, right = 30px
			?>
			<div class="sno-box" style="margin-top:39px; font-size:16px; margin-right:<?= $marginRight ?>;"><?php echo $row['result_srno'];?></div>
			<?php 
			$sql = "SELECT enrollment_no, exam_roll_no FROM bed_enrollment WHERE `exam_roll_no` LIKE  {$row['exam_roll_no']}";
			$result2 = mysqli_query($db, $sql);
			$data = mysqli_fetch_assoc($result2);
			?>
			<div class="sno-box" style="margin-top:39px; font-size:16px; margin-right:<?= $marginRight1 ?>;"><?php //echo $data['enrollment_no'];?></div>
			<div class="header">
			  <div class="institute-name"></div>
			  <div class="subtext"></div>
			</div>
			<?php
			$marginLeft = ($cr % 2 == 0) ? '27mm' : '18mm'; // Example: left = 78px, right = 30px
			?>
			<div class="content-box" style="margin-left:<?= $marginLeft ?>;">
				<h4 class="text-center ">STATEMENT OF MARKS<br><span style="font-size:14px;">2023-2024<br><br><span><h4>
				<table class="table table-borderless text-start table-transparent" >
                <tr>
					<th  class="look">Name </th>
					<th width="25%" class="look">: <?php echo strtoupper($row['student_name']); ?></th >
					<th  class="look">Roll NO.</th>
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
					<?php //echo $photo; ?>
					<img style="width:80px; height:80px; " src="<?php echo $photo; ?>" alt="Student Image"></th>
				</tr>
				<tr>
					<th class="look">Father's Name</th>
					<th class="look">: <?php echo strtoupper($row['father_name']); ?></th >
					<th class="look">Class</th>
					<th class="look">: <?php
						$sql_class = 'select * from class_detail where sno = "'.$row['course_name'].'"';
						$row_class = mysqli_fetch_assoc(mysqli_query($db,$sql_class));
						echo $row_class['class_description']; 
						?>
					</th >
				</tr>
				<tr>
					<th class="look">Mother's Name</th>
					<th class="look">: <?php echo strtoupper($row['mother_name']); ?></th >
					<th class="look">UIN NO.</th>
					<th class="look">: <?php echo $row['uin_no']; ?></th >
				</tr>
				<tr>
					<th class="look">College</th>
					<th colspan="3" class="look">: K.N.I.P.S.S. SULTANPUR</th >
				
				</tr>
			</table>	
            <table class="table text-center" width="100%" style="border:1px solid black; ">
				<?php
					if($_POST['result_course']==107 || $_POST['result_course']==249){
						$a1 = 70;
						$a2 = 28;
						$b1 = 30;
						$b2 = 12;
						$c1 = 100;
						$c2 = 40;
						$d = 400;
						$e = 160;
						$f1 = 70;
						$f2 = 35;
						$g1 = 30;
						$g2 = 15;
						$h1 = 100;
						$h2 = 50;
						$i = 400;
						$j = 200;
					}
					if($_POST['result_course']==245 || $_POST['result_course']==246 ){
						$a1 = 80;
						$a2 = 24;
						$b1 = 20;
						$b2 = 06;
						$c1 = 100;
						$c2 = 36;
						$d = 300;
						$e = 108;
						$f1 = 0;
						$f2 = 0;
						$g1 = 0;
						$g2 = 0;
						$h1 = 50;
						$h2 = 25;
						$i = 50;
						$j = 25;
						$k1 = 200;
						$k2 = 100;
					}
					if($_POST['result_course']==247){
						$a1 = 80;
						$a2 = 24;
						$b1 = 20;
						$b2 = 06;
						$c1 = 100;
						$c2 = 36;
						$d = 200;
						$e = 72;
						$f1 = 0;
						$f2 = 0;
						$g1 = 0;
						$g2 = 0;
						$h1 = 50;
						$h2 = 25;
						$i = 50;
						$j = 25;
						$k1 = 50;
						$k2 = 25;
					}
					if($_POST['result_course']==87 || $_POST['result_course']==252){
						$a1 = 80;
						$a2 = 24;
						$b1 = 20;
						$b2 = 6;
						$c1 = 100;
						$c2 = 36;
						$d = 300;
						$e = 108;
						$f1 = 0;
						$f2 = 0;
						$g1 =0 ;
						$g2 =0 ;
						$h1 = 50;
						$h2 = 25;
						$i = 50;
						$j = 25;
						$k1 = 100;
						$k2 = 50;
					}
					if($_POST['result_course']==253){
						$a1 = 80;
						$a2 = 24;
						$b1 = 20;
						$b2 = 6;
						$c1 = 100;
						$c2 = 36;
						$d = 300;
						$e = 108;
						$f1 = 0;
						$f2 = 0;
						$g1 =0 ;
						$g2 =0 ;
						$h1 = 50;
						$h2 = 25;
						$i = 50;
						$j = 25;
						$k1 = 50;
						$k2 = 25;
					}
					$paperCodeArray = array();
						$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY theory_practical DESC"; 
						$result2 = mysqli_query($db, $sql2);
						$row_num = mysqli_num_rows($result2);
						$tot_max=0;
						$tot_obt=0;
						$ufm_exist = 0;
						$theroy_sum = 0;
						$prac_sum = 0;
						$prac_max_sum = 0;
						$theory_max_sum = 0;
						$stu_abs = 0;
						$tot_theory_marks_obt = 0;
						$tot_mid_marks_obt = 0;
						$tot_pra_mid_marks_obt = 0;
						$tot_pra_marks_obt = 0;
						$inc = 0;
						$passing_status_theory = "PASSED";
						$passing_status_practical = "PASSED";
					while ($row2 = mysqli_fetch_assoc($result2)) {
						$inc++;
						$total_abs = 0;
						$practical_marks_70 = 0;
						$practical_marks_30 = 0;
						$theory_marks_70 = 0;
						$theory_marks_30 = 0;
						$theory_total_max = 0;
						$practical_total_max = 0;
						
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
							$sql4 = 'SELECT * FROM `exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" and paper_code = "'.$student_paper.'"';
							
							$result4 =mysqli_query($db,$sql4);
							$row4=mysqli_fetch_assoc($result4);
							
							if (!in_array($paperCode, $paperCodeArray)) {
								$paperCodeArray[] = $paperCode;
									
							if($row4['theory_practical']=="Theory"){
								$theory_marks_max=$row4['pt_marks_max'];
								
								$theory_marks_obt=$row4['pt_marks_obt'];
								$tot_theory_marks_obt+=floatVal($row4['pt_marks_obt']);
								
								$mid_marks_max=$row4['mid_sem_marks_max'];
								$mid_marks_max_ses=$row4['mid_sem_pt_max'];
								//echo $row4['mid_sem_pt_max'].'@@@@@@<br>';
								
								$mid_sem_marks_obt = $row4['mid_sem_marks_obt'] ?? 0;
								$mid_sem_pt_obt = $row4['mid_sem_pt_obt'] ?? 0;

								// Ensure both values are numeric
								$mid_sem_marks_obt = is_numeric($mid_sem_marks_obt) ? $mid_sem_marks_obt : 0;
								$mid_sem_pt_obt = is_numeric($mid_sem_pt_obt) ? $mid_sem_pt_obt : 0;

								$mid_marks_obt = $mid_sem_marks_obt + $mid_sem_pt_obt;

								$tot_mid_marks_obt+=floatVal($mid_marks_obt);
								
								$practical_marks_max='';
								$practical_marks_obt='';
							}
							if($row4['theory_practical']=="Practical"){
								$practical_marks_max='';
								$practical_marks_obt='';
								$theory_marks_max=$row4['pt_marks_max'];
								
								$theory_marks_obt=$row4['pt_marks_obt'];
								$tot_pra_marks_obt+=floatVal($row4['pt_marks_obt']);
								
								$mid_marks_max=$row4['mid_sem_pt_max'];
								$mid_marks_obt=$row4['mid_sem_pt_obt'];
								$tot_pra_mid_marks_obt+=floatVal($mid_marks_obt);
								
							}
				?>
					
					<?php 
					
					// echo $paper_type_show_theory.'####################suraj//';
							if($row4['theory_practical']=="Theory"){
								if(!isset($paper_type_show_theory )){
									
									$paper_type_show_theory = $row4['theory_practical'];
									echo '<tr style="border:1px solid black; "><th width="55%" class="abc text-start">Subject / Paper Selected <br>(THEORY)<span style="margin-left:200px;">Max/Min</span> </th> <th  width="15%" class="abc ">Th.<br>'.$a1.'/'.$a2.'</th> <th  width="15%" class="abc ">Sess.<br>'.$b1.'/'.$b2.'</th><th  width="15%" class="abc " > Total<br>'.$c1.'/'.$c2.'</th></tr>';
									
								}
							}
							
							if($row4['theory_practical']=="Practical"){
								if(!isset($paper_type_show_th_sum)){
									$paper_type_show_th_sum = "th_sum";
									echo '<tr style="border:1px solid black; "> <td class="abc text-start" ><b>THEORY TOTAL <span style="margin-left:100px;"> Max.'.$d.'&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Min.'.$e.'</span></b></td><th>' . ($tot_theory_marks_obt == 0 ? "Abs" : $tot_theory_marks_obt) . '</th>  <th style="border:1px solid black; "> ' . ($tot_mid_marks_obt == 0 ? "Abs" : $tot_mid_marks_obt) . '</th>  <td class="abc text-center" colspan="1" style="border:1px solid black; "><b>' . ($theroy_sum == 0 ? "Abs" : $theroy_sum) . '</b></td></tr>';
								}
								if(!isset($paper_type_show_practical)){
									if($_POST['result_course']==107){
										$paper_type_show_practical = $row4['theory_practical'];
										echo '<tr style="border:1px solid black; "><th width="55%" class="abc text-start">PRACTICAL<span style="margin-left:200px;">Max/Min</span> </th> <th  width="15%" class="abc ">'.$f1.'/'.$f2.'</th> <th  width="15%" class="abc ">'.$g1.'/'.$g2.'</th><th  width="15%" class="abc " >'.$h1.'/'.$h2.'</th></tr>';
									}
									elseif($_POST['result_course']==249){
										$paper_type_show_practical = $row4['theory_practical'];
										echo '<tr style="border:1px solid black; "><th width="55%" class="abc text-start">PRACTICAL<span style="margin-left:200px;">Max/Min</span> </th> <th  width="15%" class="abc ">'.$f1.'/'.$f2.'</th> <th  width="15%" class="abc ">'.$g1.'/'.$g2.'</th><th  width="15%" class="abc " >'.$h1.'/'.$h2.'</th></tr>';
									}
									
								
								else if($_POST['result_course']==245){
								$paper_type_show_practical = $row4['theory_practical'];
									 '<tr style="border:1px solid black; " ><th  class="abc text-start" colspan="1">PRACTICAL ACTIVITIES /VIVA-VOCE Max-'.$h1.'/Min-'.$h2.' </th> <th   class="abc " colspan="3">'.$prac_sum.'</th></tr>';	
								}
								else if($_POST['result_course']==246){
								$paper_type_show_practical = $row4['theory_practical'];
									 '<tr style="border:1px solid black; " ><th  class="abc text-start" colspan="1">PRACTICAL ACTIVITIES /VIVA-VOCE Max-'.$h1.'/Min-'.$h2.' </th> <th   class="abc " colspan="3">'.$prac_sum.'</th></tr>';	
								}
								else if($_POST['result_course']==247){
								$paper_type_show_practical = $row4['theory_practical'];
									 '<tr style="border:1px solid black; " ><th  class="abc text-start" colspan="1">PRACTICAL ACTIVITIES /VIVA-VOCE Max-'.$h1.'/Min-'.$h2.' </th> <th   class="abc " colspan="3">'.$prac_sum.'</th></tr>';	
								}
								else if($_POST['result_course']==87){
								$paper_type_show_practical = $row4['theory_practical'];
									 '<tr style="border:1px solid black; " ><th  class="abc text-start" colspan="3">PRACTICAL<span style="margin-left:200px;">Max/Min</span> </th> <th   class="abc " >'.$h1.'/'.$h2.'</th></tr>';	
								}
								else if($_POST['result_course']==252){
								$paper_type_show_practical = $row4['theory_practical'];
									 '<tr style="border:1px solid black; " ><th  class="abc text-start" colspan="3">PRACTICAL<span style="margin-left:200px;">Max/Min</span> </th> <th   class="abc " >'.$h1.'/'.$h2.'</th></tr>';	
								}
								elseif($_POST['result_course']==253){
								$paper_type_show_practical = $row4['theory_practical'];
									 '<tr style="border:1px solid black; " ><th  class="abc text-start" colspan="3">PRACTICAL<span style="margin-left:200px;">Max/Min</span> </th> <th   class="abc " >'.$h1.'/'.$h2.'</th></tr>';	
								}
								
								}
							}
							if($row4['theory_practical']!="Practical"){
								?>
								<tr style="border:1px solid black; ">
								<td class="text-start ps-2 abc"><?php echo $row4['title_of_paper']; ?></td>
								<td class="abc"><?php echo $theory_marks_obt; ?></td>
								<td class="abc"><?php echo  $mid_marks_obt; ?></td>
								<td class="abc"><?php 
									if($theory_marks_obt == 'Abs' and $mid_marks_obt == 'Abs'){
										echo  $th_total = "Abs";
									}else{
										echo  $th_total = (float)$theory_marks_obt+(float)$mid_marks_obt; 
									}
								?></td>
								<?php  $max_total = (float)$theory_marks_max+(float)$mid_marks_max; ?>
							</tr>
								<?php
							}else{
								if($_POST['result_course']==107){
										?>
										<tr style="border:1px solid black; ">
											<td class="text-start ps-2 abc"><?php echo $row4['title_of_paper']; ?></td>
											<td class="abc"><?php echo $theory_marks_obt; ?></td>
											
										
											
											<td class="abc"><?php echo  $mid_marks_obt; ?></td>
											<td class="abc"><?php 
												if($theory_marks_obt == 'Abs' and $mid_marks_obt == 'Abs'){
													echo  $th_total = "Abs";
												}else{
													echo  $th_total = (float)$theory_marks_obt+(float)$mid_marks_obt; 
												}
											?></td>
											<?php  $max_total = (float)$theory_marks_max+(float)$mid_marks_max; ?>
										</tr>
										
										<?php
									}
									elseif($_POST['result_course']==249){
											if($row4['title_of_paper'] == "Leadership Training Camp (7 to 10 Days )"){
											?>
												<tr style="border:1px solid black; ">
													<td class="text-start ps-2 abc"><?php echo $row4['title_of_paper']; ?></td>
													<td ></td>
													
												
													
													<td></td>
													<td class="abc"><?php 
													$th_total_100 = 0;
													$th_total_100 = $theory_marks_obt;
													
													$th_total = $th_total_100;
														if($theory_marks_obt == 'Abs'){
															echo  $th_total = "Abs";
														}else{
															echo  $th_total_100 = (float)$theory_marks_obt; 
														}
														//echo $th_total_100;
													?></td>
													<?php  $max_total = (float)$theory_marks_max+(float)$mid_marks_max; ?>
												</tr>
											
											<?php	
											}else{
												?>
													
												<tr style="border:1px solid black; ">
													<td class="text-start ps-2 abc"><?php echo $row4['title_of_paper']; ?></td>
													<td class="abc"><?php echo $theory_marks_obt; ?></td>
													
												
													
													<td class="abc"><?php echo  $mid_marks_obt; ?></td>
													<td class="abc"><?php 
														if($theory_marks_obt == 'Abs' and $mid_marks_obt == 'Abs'){
															echo  $th_total = "Abs";
														}else{
															echo  $th_total = (float)$theory_marks_obt+(float)$mid_marks_obt; 
														}
													?></td>
													<?php  $max_total = (float)$theory_marks_max+(float)$mid_marks_max; ?>
												</tr>
												
												<?php
											}
									}
									
								
										else if($_POST['result_course']==245){
											if($theory_marks_obt == 'Abs' and $mid_marks_obt == 'Abs'){
												  $th_total = "Abs";
											}else{
												  $th_total = (float)$theory_marks_obt+(float)$mid_marks_obt; 
											}
											
											 $max_total = (float)$theory_marks_max+(float)$mid_marks_max +(float)$mid_marks_max_ses; 
										}
										else if($_POST['result_course']==246){
											if($theory_marks_obt == 'Abs' and $mid_marks_obt == 'Abs'){
												  $th_total = "Abs";
											}else{
												  $th_total = (float)$theory_marks_obt+(float)$mid_marks_obt; 
											}
											//echo $mid_marks_max.'####<br>';
											 $max_total = (float)$theory_marks_max+(float)$mid_marks_max +(float)$mid_marks_max_ses; 
											 //echo $max_total.'@@@@@@<br>';
										}
										else if($_POST['result_course']==247){
											if($theory_marks_obt == 'Abs' and $mid_marks_obt == 'Abs'){
												  $th_total = "Abs";
											}else{
												  $th_total = (float)$theory_marks_obt+(float)$mid_marks_obt; 
											}
											//echo $mid_marks_max.'####<br>';
											 $max_total = (float)$theory_marks_max+(float)$mid_marks_max +(float)$mid_marks_max_ses; 
											 //echo $max_total.'@@@@@@<br>';
										}
										else if($_POST['result_course']==87){
											if($theory_marks_obt == 'Abs' and $mid_marks_obt == 'Abs'){
												  $th_total = "Abs";
											}else{
												  $th_total = (float)$theory_marks_obt+(float)$mid_marks_obt; 
											}
											 $max_total = (float)$theory_marks_max+(float)$mid_marks_max; 
										}
										else if($_POST['result_course']==252){
											if($theory_marks_obt == 'Abs' and $mid_marks_obt == 'Abs'){
												  $th_total = "Abs";
											}else{
												  $th_total = (float)$theory_marks_obt+(float)$mid_marks_obt; 
											}
											 $max_total = (float)$theory_marks_max+(float)$mid_marks_max; 
										}
										else if($_POST['result_course']==253){
											if($theory_marks_obt == 'Abs' and $mid_marks_obt == 'Abs'){
												  $th_total = "Abs";
											}else{
												  $th_total = (float)$theory_marks_obt+(float)$mid_marks_obt; 
											}
											 $max_total = (float)$theory_marks_max+(float)$mid_marks_max; 
										}
									
							}
						
								if($theory_marks_obt!='Abs'){
									$stu_abs = 1;
								}
								if($mid_marks_obt!='Abs'){
									$stu_abs = 1;
								}
								if($row4['theory_practical']=="Theory"){
									// echo $row4['theory_practical'];
									if($theory_marks_obt=='Abs'){
										$passing_status_theory = "FAILED";
										$theroy_sum += (float)$th_total;
										$theory_max_sum += $max_total;
										
									}
									else{
										if($mid_marks_obt=='Abs'){
											$passing_status_theory = "FAILED";
										}
										$theroy_sum += (float)$th_total;
										$theory_max_sum += $max_total;
										if($theory_marks_obt<$a2){
											$passing_status_theory = "FAILED";
										}
										if($mid_marks_obt<$b2){
											$passing_status_theory = "FAILED";
										}
									}
								}
								// echo $passing_status_theory;
								if($row4['theory_practical']=="Practical"){
									$prac_sum += (float)$th_total;
									$prac_max_sum += $max_total;
									if($theory_marks_obt<$f2){
										$passing_status_practical = "FAILED";
									}
									if($mid_marks_obt<$g2 and $row4['title_of_paper'] != "Leadership Training Camp (7 to 10 Days )"){
										$passing_status_practical = "FAILED";
									}
								}
								$tot_max+=$max_total;
								$tot_obt+=(float)$th_total;
							}	
						}	
						if($inc == $row_num){
							if($row4['theory_practical']=="Practical"){
								if(!isset($paper_type_show_pt_sum)){
									if($_POST['result_course']==107){
											$paper_type_show_pt_sum = "pt_sum";
											echo '<tr style="border:1px solid black; "><td class="abc text-start" ><b>PRACTICAL TOTAL <span style="margin-left:80px;"> Max.'.$i.'&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Min.'.$j.'</span></b></td><th style="border:1px solid black; ">' . ($tot_pra_marks_obt == 0 ? "Abs" : $tot_pra_marks_obt) . '</th><th style="border:1px solid black; ">' . ($tot_pra_mid_marks_obt == 0 ? "Abs" : $tot_pra_mid_marks_obt) . '</th> <td class="abc text-center" ><b>' . ($prac_sum == 0 ? "Abs" : $prac_sum) . '</b></td> </tr>';
										}
										elseif($_POST['result_course']==249){
											$paper_type_show_pt_sum = "pt_sum";
											$tot_pra_marks_obt_70 = $tot_pra_marks_obt - $th_total_100;
											echo '<tr style="border:1px solid black; ">
												<td class="abc text-start" ><b>PRACTICAL TOTAL <span style="margin-left:80px;"> Max.'.$i.'&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Min.'.$j.'</span></b></td>
												<th style="border:1px solid black; ">' . ($tot_pra_marks_obt_70 == 0 ? "Abs" : $tot_pra_marks_obt_70) . '</th>
												<th style="border:1px solid black; ">' . ($tot_pra_mid_marks_obt == 0 ? "Abs" : $tot_pra_mid_marks_obt) . '</th> 
												<td class="abc text-center" ><b>' . ($prac_sum == 0 ? "Abs" : $prac_sum) . '</b></td> </tr>';
										}
										
									
									else if($_POST['result_course']==245){
									$paper_type_show_pt_sum = "pt_sum";
										echo '<tr style="border:1px solid black; " ><th  class="abc text-start" colspan="3"><span style="font-size:12px;">PRACTICAL ACTIVITIES /VIVA-VOCE</span><span style="margin-left:10px;">Max.&nbsp;&nbsp;'.$h1.'&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Min.&nbsp;&nbsp;'.$h2.'</span> </th> <th class="abc">' . ($prac_sum == 0 ? "Abs" : $prac_sum) . '</th></tr>';
									}
									else if($_POST['result_course']==246){
									$paper_type_show_pt_sum = "pt_sum";
										echo '<tr style="border:1px solid black; " ><th  class="abc text-start" colspan="3"><span style="font-size:12px;">PRACTICAL ACTIVITIES /VIVA-VOCE</span><span style="margin-left:10px;">Max.&nbsp;&nbsp;'.$k1.'&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Min.&nbsp;&nbsp;'.$k2.'</span> </th> <th class="abc">' . ($prac_sum == 0 ? "Abs" : $prac_sum) . '</th></tr>';
									}
									else if($_POST['result_course']==247){
									$paper_type_show_pt_sum = "pt_sum";
										echo '<tr style="border:1px solid black; " ><th  class="abc text-start" colspan="3"><span style="font-size:12px;">PRACTICAL ACTIVITIES /VIVA-VOCE</span><span style="margin-left:10px;">Max.&nbsp;&nbsp;'.$k1.'&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Min.&nbsp;&nbsp;'.$k2.'</span> </th> <th class="abc">' . ($prac_sum == 0 ? "Abs" : $prac_sum) . '</th></tr>';
									}
									else if($_POST['result_course']==87){
									$paper_type_show_pt_sum = "pt_sum";
										echo '<tr style="border:1px solid black; " ><th  class="abc text-start" colspan="3"><span style="font-size:12px;">PRACTICAL ACTIVITIES /VIVA-VOCE</span><span style="margin-left:10px;">Max.&nbsp;&nbsp;'.$h1.'&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Min.&nbsp;&nbsp;'.$h2.'</span> </th> <th class="abc">' . ($prac_sum == 0 ? "Abs" : $prac_sum) . '</th></tr>';

									}
									else if($_POST['result_course']==252){
									$paper_type_show_pt_sum = "pt_sum";
										echo '<tr style="border:1px solid black; " ><th  class="abc text-start" colspan="3"><span style="font-size:12px;">PRACTICAL ACTIVITIES /VIVA-VOCE</span><span style="margin-left:10px;">Max.&nbsp;&nbsp;'.$k1.'&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Min.&nbsp;&nbsp;'.$k2.'</span> </th> <th class="abc">' . ($prac_sum == 0 ? "Abs" : $prac_sum) . '</th></tr>';

									}
									else if($_POST['result_course']==253){
									$paper_type_show_pt_sum = "pt_sum";
										echo '<tr style="border:1px solid black; " ><th  class="abc text-start" colspan="3"><span style="font-size:12px;">PRACTICAL ACTIVITIES /VIVA-VOCE</span><span style="margin-left:10px;">Max.&nbsp;&nbsp;'.$k1.'&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Min.&nbsp;&nbsp;'.$k2.'</span> </th> <th class="abc">' . ($prac_sum == 0 ? "Abs" : $prac_sum) . '</th></tr>';

									}
								}
							}
						}
					}	
					
					if($theroy_sum<$e){
						$passing_status_theory = "FAILED";
					}if($prac_sum<$j){
						$passing_status_practical = "FAILED";
					}
					if($stu_abs == 0){
						$passing_status_practical = "ABSENT";
						$passing_status_theory = "ABSENT";
					}
				?>
				
				
				
				<?php if($_POST['result_course']==107){ ?>
				<tr  style="border:1px solid black; " >
                    <th  class=" p-2 text-start"  style="border:1px solid black; "> <br>MAX MARKS <br><br>MARKS OBTAINED <br></th>
                    <th  class="text-center" rowspan="2"  style="border:1px solid black; "><br>Grand Total <br><?php echo $tot_obt==0?"Abs":$tot_obt; ?> / <?php echo $tot_max; ?></th>
                    <th  class="text-center" rowspan="2" colspan="2" style="border:1px solid black; "><br>Result/Division<br>
					<?php 
					if($passing_status_practical=="ABSENT" and $passing_status_theory=="ABSENT"){
						echo "ABSENT";
					}else{
						if($passing_status_practical=="PASSED" and $passing_status_theory=="PASSED"){
							
							echo "PASSED";
						}	else{
							echo "FAILED";
						}
					}
										
					?></th>
                </tr>
				<tr  style="border:1px solid black; " >
                </tr>
			
<!----------------------------------------B.P.Ed 2nd Sem--------------------------------------------->
				<?php } ?>
				<?php if($_POST['result_course']==249){ 
					$sql="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' and exam_id=1";
					$row_t = mysqli_fetch_assoc(mysqli_query($db,$sql));
					$grant_total_obt = $row_t['obt_marks'] + $tot_obt;
					$grant_total_max = $row_t['max_marks'] + $tot_max;
				?>
				<tr  style="border:1px solid black; " >
					
                    <th  class=" p-2 text-start"  >
						<table  class="table text-center" width="100%" style="border:1px solid black; ">
							<tr>
								<th></th>
								<td>1st SEM</td>
								<td>2nd SEM</td>
							</tr>
							<tr>
								<th>MAX MARKS</th>
								<td><?php echo $row_t['max_marks']; ?></td>
								<td><?php echo $tot_max; ?></td>
							</tr>
							<tr>
								<th>MARKS OBTAINED</th>
								<td><?php if($row_t['passing_status'] == "FAILED"){
									echo "-";
								}else{ echo $row_t['obt_marks'];} ?></td>
								<td><?php echo $tot_obt==0?"Abs":$tot_obt; ?></td>
							</tr>
						</table>
					</th>
                    <th  class="text-center" rowspan="2"  style="border:1px solid black; "><br>Grand Total <br><?php echo $grant_total_obt==0?"Abs":$grant_total_obt; ?> / <?php echo $grant_total_max; ?></th>
                    <th  class="text-center" rowspan="2" colspan="2" style="border:1px solid black; "><br>Result/Division<br>
					<?php 

					if($passing_status_practical=="ABSENT" and $passing_status_theory=="ABSENT"){
						echo "ABSENT";
					}if(($passing_status_practical=="PASSED" and $passing_status_theory=="PASSED") and ($row_t['passing_status'] == "FAILED")){
						echo "INC";
					}
					else{
						if($passing_status_practical=="PASSED" and $passing_status_theory=="PASSED"){
							
							echo "PASSED";
						}	else{
							echo "FAILED";
						}
					}
										
					?></th>
                </tr>
				<tr  style="border:1px solid black; " >
                </tr>
				<?php } ?>
				<?php if($_POST['result_course']==87){ ?>
<!----------------------------------------B.P.Ed 2nd Sem end--------------------------------------------->
				<tr  style="border:1px solid black; " >
                    <th  class=" p-2 text-start"  style="border:1px solid black; "> <br>TOTAL (Theory & Practical) &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp  <?php echo "350"//$tot_max; ?><br></th>
                    <th  class="text-center"   style="border:1px solid black; " colspan="3"> <br> <?php echo $tot_obt==0?"Abs":$tot_obt; ?><br><?php echo '( '.strtoupper(int_to_words($tot_obt)).' )';?></th>
                </tr>
				<tr  style="border:1px solid black; " >
                    <th  class=" p-2 text-start"  style="border:1px solid black; ">
						<table width="100%">
							<tr >
								<td width="30%" class="note"><span style="font-size:11px;">MAX MARKS <br>MARKS OBTAINED</span></td>
								<th width="20%"><span style="font-size:17px;">RESULT</span></th>
								<td width="50%" class="note" style="padding-top:20px!important;"><span style="padding-top:50px!important;">Theory<br>Practical & viva-voce</span></td>
							</tr>
						</table>
					</th>
                    <th  class="text-center"   style="border:1px solid black; ">Grand Total <br><?php 
					$total_marks = $theroy_sum + $prac_sum;
					 $theroy_sum==0?"Abs":$theroy_sum; ?> <?php  "300"//$theory_max_sum ?><br><?php  $prac_sum==0?"Abs":$prac_sum; ?> <?php echo $total_marks==0?"Abs":$total_marks;?> / <?php echo "350"//$theory_max_sum ?>
						
					</th>
                    <th  class="text-center"  colspan="2" style="border:1px solid black; ">Result/Division<br><?php echo $theroy_sum==0?"ABSENT":$passing_status_theory;?></th>
                </tr>
				<tr  style="border:1px solid black; " >
                </tr>
				<?php } ?>
<!----------------------------------------M.Ed 2nd Sem --------------------------------------------->
				<?php if($_POST['result_course']==252){ 
				$sql="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' and exam_id=1";
						$row_t = mysqli_fetch_assoc(mysqli_query($db,$sql));
						$grant_total = $row_t['obt_marks'] + $theroy_sum;
						if($row_t['passing_status'] == "FAILED"|| $row_t['passing_status'] == "ATKT" ){
							$passing_status ="INC";
						}else{
							$passing_status;
						}
						if($row_t['passing_status'] == "FAILED" || $row_t['passing_status'] == "ATKT"){
							$grant_total_obt=  $tot_obt;
							$grant_total_max=  400;
						}else{
							$grant_total_obt= $row_t['obt_marks'] + $tot_obt;
							$grant_total_max= $row_t['max_marks'] + 400;
						}
								
								?>
				<tr  style="border:1px solid black; " >
                    <th  class=" p-2 text-start"  style="border:1px solid black; "> <br>TOTAL (Theory & Practical) &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp  400<br></th>
                    <th  class="text-center"   style="border:1px solid black; " colspan="3"> <br> <?php echo $tot_obt==0?"Abs":$tot_obt; ?><br><?php echo '( '.strtoupper(int_to_words($tot_obt)).' )';?></th>
                </tr>
				<tr  style="border:1px solid black; " >
                    <th  class=" p-2 text-start"  style="border:1px solid black; ">
						<table  class="table text-center" width="100%" style="border:1px solid black; ">
							<tr>
								<th></th>
								<td>1st SEM</td>
								<td>2nd SEM</td>
							</tr><tr>
								<th>MAX MARKS</th>
								<td ><?php echo $row_t['max_marks']; ?></td>
								<td >400</td>
							</tr>
							<tr>
								<th>MARKS OBTAINED</th>
								<td><?php if($row_t['passing_status'] == "FAILED"){
									echo "-";
								}else{ echo $row_t['obt_marks'];} ?></td>
								<td><?php echo $tot_obt==0?"Abs":$tot_obt; ?></td>
							</tr>
						
						</table>
					</th>
                    <th  class="text-center"   style="border:1px solid black; ">Grand Total <br><?php echo $grant_total_obt==0?"Abs":$grant_total_obt; ?> / <?php echo $grant_total_max ?></th>
                    <th  class="text-center"  colspan="2" style="border:1px solid black; ">Result/Division<br><?php 

					if($passing_status_practical=="ABSENT" and $passing_status_theory=="ABSENT"){
						echo "ABSENT";
					}if(($passing_status_practical=="PASSED" and $passing_status_theory=="PASSED") and ($row_t['passing_status'] == "FAILED")){
						echo "INC";
					}
					else{
						if($passing_status_practical=="PASSED" and $passing_status_theory=="PASSED"){
							
							echo "PASSED";
						}	else{
							echo "FAILED";
						}
					}
										
					?></th>
                </tr>
				<tr  style="border:1px solid black; " >
                </tr>
				<?php } ?>
<!----------------------------------------M.Ed 2nd Sem end--------------------------------------------->
				<?php if($_POST['result_course']==245 ){ ?>
				<tr  style="border:1px solid black; " >
                    <th  class=" p-2 text-start"  style="border:1px solid black; "> <br>TOTAL (Theory & Practical) &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp  <?php echo $tot_max; ?><br></th>
                    <th  class="text-center"   style="border:1px solid black; " colspan="3"> <br> <?php echo $tot_obt==0?"Abs":$tot_obt; ?><br><?php echo '( '.strtoupper(int_to_words($tot_obt)).' )';?></th>
                </tr>
				<tr  style="border:1px solid black; " >
                    <th  class=" p-2 text-start"  style="border:1px solid black; ">
						<table width="100%">
							<tr >
								<td width="30%" class="note"><span style="font-size:11px;">MAX MARKS <br>MARKS OBTAINED</span></td>
								<th width="20%"><span style="font-size:17px;">RESULT</span></th>
								<td width="50%" class="note" style="padding-top:20px!important;"><span style="padding-top:50px!important;">Theory<br>Practical & viva-voce</span></td>
							</tr>
						</table>
					</th>
                    <th  class="text-center"   style="border:1px solid black; ">Grand Total <br><?php echo $theroy_sum==0?"Abs":$theroy_sum; ?> / <?php echo $theory_max_sum ?><br><?php echo $prac_sum==0?"Abs":$prac_sum; ?> / <?php echo $prac_max_sum ?></th>
                    <th  class="text-center"  colspan="2" style="border:1px solid black; ">Result/Division<br><?php 
						
							echo $theroy_sum==0?"ABSENT":$passing_status_theory;
						
					
					
					?><br><?php echo $prac_sum==0?"ABSENT":$passing_status_practical; ?></th>
                </tr>
				<tr  style="border:1px solid black; " >
                </tr>
				<?php } ?>
<!----------------------------------------B.Ed 2nd Sem --------------------------------------------->
				<?php if($_POST['result_course']==246){ 
						$sql="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' and exam_id=1";
						$row_t = mysqli_fetch_assoc(mysqli_query($db,$sql));
						$tot_theory_max = $theory_max_sum + $mid_marks_max_ses;
						$grant_total = $row_t['obt_marks'] + $theroy_sum ;
						if($row_t['passing_status'] == "FAILED"|| $row_t['passing_status'] == "ATKT" ){
							$passing_status ="INC";
						}else{
							$passing_status;
						}
						if($row_t['passing_status'] == "FAILED" || $row_t['passing_status'] == "ATKT"){
							$grant_total_obt_t= $theroy_sum;
							$grant_total_obt_p=  $prac_sum;
							$grant_total_max_t= 300;
							$grant_total_max_p=  200;
						}else{
							$grant_total_obt_t= $row_t['theory_obt'] + $theroy_sum;
							$grant_total_obt_p= $row_t['practical_obt'] + $prac_sum;
							$grant_total_max_t= $row_t['theory_max'] + 300;
							$grant_total_max_p= $row_t['practical_max'] + 200;
						}
								
								?>
				<tr  style="border:1px solid black; " >
                    <th  class=" p-2 text-start"  style="border:1px solid black; "> <br>TOTAL (Theory & Practical) &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp  500<br></th>
                    <th  class="text-center"   style="border:1px solid black; " colspan="3"> <br> <?php echo $tot_obt==0?"Abs":$tot_obt; ?><br><?php echo '( '.strtoupper(int_to_words($tot_obt)).' )';?></th>
                </tr>
				<tr  style="border:1px solid black; " >
                    <th  class=" p-2 text-start"  style="border:1px solid black; ">
						<table  class="table text-center" width="100%" style="border:1px solid black; ">
							<tr>
								<th class="text-start">MARKS:-</th>
								<td>1st SEM</td>
								<td>2nd SEM</td>
							</tr>
							<tr>
								<th class="text-start">Theory</th>
								<td ><?php echo $row_t['theory_obt'] ?>/<?php echo $row_t['theory_max'] ?></td>
								<td ><?php echo $theroy_sum==0?"Abs":$theroy_sum; ?> / 300</td>
							</tr>
							<tr>
								<th class="text-start">Practical & viva-voce</th>
								<td><?php echo $row_t['practical_obt'] ?>/<?php echo $row_t['practical_max'] ?></td>
								<td><?php echo $prac_sum==0?"Abs":$prac_sum; ?> / 200</td>
							</tr>
						
						</table>
					</th>
                    <th  class="text-center"   style="border:1px solid black; ">
						<table  class="table text-center" width="100%" style="border:1px solid black; ">
							<tr>
								<th>Grand Total</th>
							</tr>
							<tr>
								<td><?php echo $grant_total_obt_t==0?"Abs":$grant_total_obt_t; ?> / <?php echo $grant_total_max_t ?></td>
							</tr>
							<tr>
								<td><?php echo $grant_total_obt_p==0?"Abs":$grant_total_obt_p; ?> / <?php echo $grant_total_max_p ?></td>
							</tr>
						</table>
					
					</th>
                    <th  class="text-center"  colspan="2" style="border:1px solid black; ">
						<table  class="table text-center" width="100%" style="border:1px solid black; ">
							<tr>
								<th>Result / Division</th>
							</tr>
							<tr>
								<td><?php echo $theroy_sum==0?"ABSENT":$passing_status_theory;?></td>
							</tr>
							<tr>
								<td><?php
					
										if($prac_sum == 0){
											echo "ABSENT";
										}elseif($prac_sum<=99){
											echo "FAILED";
										}else{
											echo $prac_sum==0?"ABSENT":$passing_status_practical; 
										}

										
									?>
								</td>
							</tr>
						</table>
					
					</th>
                </tr>
				<tr  style="border:1px solid black; " >
                </tr>
				<?php } ?>
            </table>
			<!----------------------------------------B.Ed 2nd Sem end--------------------------------------------->
			<!----------------------------------------B.Ed 3rd Sem --------------------------------------------->
				<?php
				
if ($_POST['result_course'] == 247) {
	$erp_23 = mysqli_connect("p:localhost", "root", "mysql","knipsser_2023");
      $sql = "SELECT * FROM `exam_student_info` WHERE `student_info_sno` ='" . $row['student_info_sno'] . "' AND `exam_id` IN ('1', '2')";
    $result = mysqli_query($erp_23, $sql);

    // Initialize semester data
    $semesters = [
        1 => ['theory_obt' => 0, 'theory_max' => 0, 'practical_obt' => 0, 'practical_max' => 0],
        2 => ['theory_obt' => 0, 'theory_max' => 0, 'practical_obt' => 0, 'practical_max' => 0],
    ];

    while ($row_t = mysqli_fetch_assoc($result)) {
        $exam_id = $row_t['exam_id'];
        if (isset($semesters[$exam_id])) {
            $semesters[$exam_id]['theory_obt'] = $row_t['theory_obt'];
            $semesters[$exam_id]['theory_max'] = $row_t['theory_max'];
            $semesters[$exam_id]['practical_obt'] = $row_t['practical_obt'];
            $semesters[$exam_id]['practical_max'] = $row_t['practical_max'];
        }
    }
	$semesters[1]['passing_status'] = $row_t['passing_status'];
    // Calculate totals
    $theory_total_obt = $semesters[1]['theory_obt'] + $semesters[2]['theory_obt'] + $theroy_sum;
    $theory_total_max = $semesters[1]['theory_max'] + $semesters[2]['theory_max'] + 200;

    $practical_total_obt = $semesters[1]['practical_obt'] + $semesters[2]['practical_obt'] + $prac_sum;
    $practical_total_max = $semesters[1]['practical_max'] + $semesters[2]['practical_max'] + 50;

    //$passing_status = ($row_t['passing_status'] == "FAILED" || $row_t['passing_status'] == "ATKT") ? "INC" : $row_t['passing_status'];
	$sql3 = "SELECT * FROM `exam_student_info` WHERE `student_info_sno` ='" . $row['student_info_sno'] . "' AND `exam_id`='1'";
    $row_1 = mysqli_fetch_assoc(mysqli_query($erp_23,$sql3));
	$sql4 = "SELECT * FROM `exam_student_info` WHERE `student_info_sno` ='" . $row['student_info_sno'] . "' AND `exam_id`='2'";
    $row_2 = mysqli_fetch_assoc(mysqli_query($erp_23,$sql4));
?>
	
	<table class="table text-center" width="100%" style="border:1px solid black; ">
	    <tr>
                    <th colspan="2" class="text-start" style="text-align:left!important;"></b>RESULT :<b></th>
                </th>
        </tr>
    <tr style="border:1px solid black;">
        <th class="p-2 text-start" style="border:1px solid black;">
            <table class="table text-center" width="100%" style="border:1px solid black;">
                
                <tr>
                    <th class="text-start">SEMESTER:-</th>
                    <td>1st SEM</td>
                    <td>2nd SEM</td>
                    <td>3rd SEM</td>
                </tr>
                <tr>
                    <th class="text-start">Marks ( Theory )</th>
                    <td><?php 
					if($row_1['passing_status']=="FAILED"){
						echo "-" .'/' . $semesters[1]['theory_max'];
						$passing_status_theory="INC";
						$theory_total_obt = $semesters[2]['theory_obt'] + $theroy_sum;
					}else{
						echo $semesters[1]['theory_obt'] . '/' . $semesters[1]['theory_max'];
					}
					 ?></td>
					<td><?php 
					if($row_2['passing_status']=="FAILED" || $row_2['passing_status']=="ABSENT" || $row_2['passing_status']=="INC"){
						$passing_status_theory ="INC";
						$theory_total_obt = $semesters[1]['theory_obt'] + $theroy_sum;
						echo "-" .'/' . $semesters[2]['theory_max'];
					}else{
						echo $semesters[2]['theory_obt'] . '/' . $semesters[2]['theory_max'];
					}
					 ?></td>
                    <td><?php echo $theroy_sum == 0 ? "Abs" : $theroy_sum; ?> / 200</td>
                </tr>
                <tr>
                    <th class="text-start">Marks (Practical & viva-voce)</th>
                    <td><?php echo $semesters[1]['practical_obt'] . '/' . $semesters[1]['practical_max']; ?></td>
                    <td><?php echo $semesters[2]['practical_obt'] . '/' . $semesters[2]['practical_max']; ?></td>
                    <td><?php echo $prac_sum == 0 ? "Abs" : $prac_sum; ?> / 50</td>
                </tr>
            </table>
        </th>
        <th class="text-center" style="border:1px solid black;">
            <table class="table text-center" width="100%" style="border:1px solid black;">
                <tr>
                    <th>Grand Total</th>
                </tr>
                <tr>
                    <td><?php 
					echo $theory_total_obt == 0 ? "Abs" : $theory_total_obt; ?> / <?php echo $theory_total_max; ?></td>
                </tr>
                <tr>
                    <td><?php echo $practical_total_obt == 0 ? "Abs" : $practical_total_obt; ?> / <?php echo $practical_total_max; ?></td>
                </tr>
            </table>
        </th>
        <th class="text-center" colspan="2" style="border:1px solid black;">
            <table class="table text-center" width="100%" style="border:1px solid black;">
                <tr>
                    <th>Result / Division</th>
                </tr>
                <tr>
                    <td><?php 
						
					echo $theroy_sum == 0 ? "ABSENT" : $passing_status_theory; ?></td>
                </tr>
                <tr>
                    <td><?php
                        if ($prac_sum == 0) {
                            echo "ABSENT";
                        } elseif ($prac_sum <= 24) {
                            echo "FAILED";
                        } else {
                            echo $prac_sum == 0 ? "ABSENT" : $passing_status_practical;
                        }
                    ?></td>
                </tr>
            </table>
        </th>
    </tr>
<?php
}
?>

<!----------------------------------------B.Ed 3rd Sem end--------------------------------------------->	

					<table class="text-start">
						<?php if($_POST['result_course']==107){ ?>
							
							<tr>
								<th>NOTE :</th>
							</tr>
							<tr>
								<td class="note">1. The Minimum Passing Standard shall be 40% Aggregate for Theory Papers.</td>
							</tr>
							<tr>
								<td  class="note">2. The Minimum Passing Standard shall be 50% For Practical/Viva-Voce.</td>
							</tr>
						<?php } ?>
						<?php if($_POST['result_course']==249){ ?>
							
							
							<tr>
								<td class="note">1. The Minimum Passing Standard shall be 40% Aggregate for Theory Papers.</td>
							</tr>
							<tr>
								<td  class="note">2. The Minimum Passing Standard shall be 50% For Practical/Viva-Voce.</td>
							</tr>
						<?php } ?>
						<?php if($_POST['result_course']==87){ ?>
							
							<tr>
								<th>NOTE :</th>
							</tr>
							<tr>
								<td class="note">1. The Minimum Passing Standard shall be 36% Aggregate for Theory Papers.</td>
							</tr>
							<tr>
								<td  class="note">2. The Minimum Passing Standard shall be 30% for Theory paper/Assignment (24 Marks out of 80 Marks & 06 Marks out of 20 Marks.)</td>
							</tr>
							<tr>
								<td  class="note">3. The Minimum Passing Standard shall be 50% For Practical/Viva-Voce.</td>
							</tr>
						<?php } ?>
						<?php if($_POST['result_course']==252){ ?>
							
							<tr>
								<th>NOTE :</th>
							</tr>
							<tr>
								<td class="note">1. The Minimum Passing Standard shall be 36% Aggregate for Theory Papers.</td>
							</tr>
							<tr>
								<td  class="note">2. The Minimum Passing Standard shall be 30% for Theory paper/Assignment (24 Marks out of 80 Marks & 06 Marks out of 20 Marks.)</td>
							</tr>
							<tr>
								<td  class="note">3. The Minimum Passing Standard shall be 50% For Practical/Viva-Voce.</td>
							</tr>
						<?php } ?>
						<?php if($_POST['result_course']==245 || $_POST['result_course']==246){ ?>
							
							<tr>
								<th>NOTE :</th>
							</tr>
							<tr>
								<td class="note">1. The Minimum Passing Standard shall be 36% Aggregate for Theory Papers.</td>
							</tr>
							<tr>
								<td  class="note">2. The Minimum Passing Standard shall be 30% for Theory paper/Assignment (24 Marks out of 80 Marks & 06 Marks out of 20 Marks.)</td>
							</tr>
							<tr>
								<td  class="note">3. The Minimum Passing Standard shall be 50% For Practical/Viva-Voce.</td>
							</tr>
						<?php } ?>
					</table>
					</br>					
					<table width="100%">		
						<tr>
							<th width="30%">
								<img src="<?php echo $row['bar_code'];?>" style="height:50px; width:145px;"><br>RESULT DECLARATION DATE : 30/01/2024 
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
		unset($paper_type_show_theory);
		unset($paper_type_show_pt_sum);
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
