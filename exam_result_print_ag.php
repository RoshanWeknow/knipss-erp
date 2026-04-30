<?php 
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg='';

	$_POST['result_course'] = $_SESSION['result_course'];
	$_POST['exam_roll_no'] = $_SESSION['exam_roll_no'];

if(!isset($_POST['exam_roll_no'])){
	//header("location:exam_result_print_llb.php");
}
$sql_ag_check = 'select * from class_detail where sno = "'.$_POST['result_course'].'"';
$result_ag_check = mysqli_query($db, $sql_ag_check);
$row = mysqli_fetch_assoc($result_ag_check);
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

if(isset($_POST['exam_roll_no'])){
	//$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`student_info_sno`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`,`student_info`.`mother_name`,`student_info`.`photo_id` FROM `exam_student_info` LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno where `exam_student_info`.`exam_roll_no` = "'.$_POST['exam_roll_no'].'" AND `exam_student_info`.`course_name` = "'.$_POST['result_course'].'" AND `exam_student_info`.`dob` = "'.$_POST['stu_dob'].'"';
		
	$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`student_info_sno`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`exam_id`,`exam_student_info`.`result_sno`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`,`student_info`.`mother_name`,`student_info`.`photo_id` FROM `exam_student_info` LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno where `exam_student_info`.`course_name` = "'.$_POST['result_course'].'" AND  `exam_student_info`.`exam_roll_no` = "'.$_POST['exam_roll_no'].'"';
	
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

    <!-- css  -->
    <style>
      body {
        font-family: "Roboto", sans-serif;
        font-size: .8rem;
		margin:5px!important;
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
				font-size: 12px!important;
				padding: 2px!important;
				}
			th{
				
				font-size: 12px!important;
				padding: 2px!important;
			}
			.noprint {
                    display: none;
                }
			.watermark {
				color: #ececec; 
				opacity: 0.2 !important;
				top: 30% !important;
				left: 10% !important;
				font-size: 3rem; 
			  }
			  table td{
			border:1px solid black!important;
			}
			.abc{
				border:1px solid black!important;
			}
			

			.marksheet-container {
				width: 100%;
				height: 100%;
				margin: 15px;
				 /* Ensure each container starts on a new page */
			}
			  #printButton {
				display: none;
			 }
			 #overlays1{
			width:60%!important;
			margin-bottom:!important;
			filter:grayscale(100%);
			margin-top:20px!important;
		}
			 
			.pp{
			padding-top:20px!important;
			}
			
		}
		
		.look{
			padding:3px!important;
			margin:0px!important;
			font-size:11px;
		}
			
		
	  
		@page{
        size: A4;
        margin-top: 65mm;
        margin-bottom: 40mm;
        margin-right: 15mm!important;
        margin-left: 15mm!important;
		}
		.watermark {
		  position: absolute;
		  top: 50%;
		  left: 20%;
		  opacity: 0.6;
		  z-index: -100;
		  color: #aeabab ;
		  font-size: 6.1rem;
		  transform: rotate(-45deg);
		  font-weight: normal;
		  user-select: none;
		}
		

		.merge_column1 {
			position: absolute;
			top: 2%;
			left: 50%;
			-ms-transform: translate(-50%, -50%);
			transform: translate(-50%, -50%);
			background-color: white;
			padding-top: 0.1rem; padding-inline:0.1rem;
			/*padding-left : 20px;
			padding-right : 20px;*/
		}
		.look{
			padding-left:10px!important;
		}
		table td{
			border:1px solid black;
		}
		.abc{
			border:1px solid black;
		}
		#overlays1{
			width:40%;
			margin-top:200px;
			margin-right:50px!important;
			filter:grayscale(100%);
			
		}
	
		#main{
			margin:10px!important;
			padding:5px;
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
	<?php
		$result =mysqli_query($db,$sql);
		if(mysqli_num_rows($result)>0){
		$i=1;
		while($row=mysqli_fetch_assoc($result)){
	?>		
  </head>

  <body class="w-100 m-auto" id="main">
	<div style="text-align:center">
		<button id="printButton" onclick="printAndRemoveButton()" class=" btn btn-danger btn-sm text-center" >Print</button>
	</div>

   <!-- <div class="" style="display:flex ; justify-content: center ;">
      <button class="btn btn-secondary btn-print" style="width: 5%;" onclick="print()">Print</button>
    </div>-->
	<img src="images/kni_logo.png"  id="overlays" style=" z-index:-2;opacity:0.0;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%); width:30%;" alt="overlay image" >
	 <img src="images/logo_bg.png"  id="overlays1" style=" z-index:-100;opacity:0.15;position: absolute;top: 40%;left: 50%;-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%); width:30%; " alt="overlay image" >
    <div  style="">
        <div class="container-fluid">
			
            <table width="100%" style="margin:0px;" class="noprint">
			<div class="watermark">Internet Copy</div>
			<tr>
				<th width="12%" rowspan="2"><img style="padding:15px; height:85px; width:85px; " src="images/kni_logo.png" alt="logo" class="img-fluid d-block m-auto" /> </th>
				<th width="88%">
					<h4 class="" style="text-align: center; margin:0px; " ><span style="font-size:17px;white-space:nowrap;" class="head-name"><b>Kamla Nehru Institute Of Physical & Social Sciences,Sultanpur, Uttar Pradesh</b></span> <br>An Autonomous Institute And Accredited "A" Grade by NAAC<br><span style="font-size:14px;">(Affiliated to Dr. Rammanohar Lohia Avadh University, Ayodhya U.P.)</span></h4>
				</th>
			</tr>
		</table>
            <table class="table table-borderless" width="100%">
				<tr>
					<th class="text-center" colspan="5"><span style="font-size:12px;">PROVISIONAL MARKSHEET<br>2023-2024</span></th>
				</tr>
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
					<img style="width:80px; height:65px; " src="<?php echo $photo; ?>" alt="Student Image"></th>
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
					<th colspan="3" class="look">: K.N.I.P.S.S. Sultanpur</th >
				
				</tr>
			</table>	
            <table class="table text-center" width="100%" style="border:1px solid black; ">
                <tr style="border:1px solid black; ">
                    <th width="50%" class="abc pp">SUBJECT</th>
                    <th width="14%" class="abc pp">CREDIT HOURS</th>
                    <th  width="12%" class="abc">TOTAL OBT MARKS</br>TH.+PR.</th>
                    <th  width="12%" class="abc pp">  GRADE </th>
                    <th  width="12%" class="abc pp">CREDIT GRADE POINTS</th>
                </tr>
				<?php
											$paperCodeArray = array();
											if($_POST['result_course']==56){
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
												$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type in ('Major', 'Core') THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type in ('Vocational', 'Supporting') THEN 3 WHEN type in ('Cocurricular', 'Common', 'Project', 'Research', 'Non-Gradial','Special') THEN 4 END"; 
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
												$show_total = 0;
												$nc_cource_credit = 0;
												$ufm_exist = 0;
												$mid_marks_max = 0;
												$mid_marks_obt  = 0;
												$theory_marks_obt = 0;
												$theory_marks_max  = 0;
												$practical_marks_max   = 0;
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
													$sql="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' and exam_id=1";
													$row_t = mysqli_fetch_assoc(mysqli_query($db,$sql));
													
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
															if($row4['theory_practical']=="Practical" || $row4['theory_practical']=="Practical."){
																$practical_marks_max=$row4['pt_marks_max'];
																$practical_marks_obt=$row4['pt_marks_obt'];
																$theory_marks_max='';
																$theory_marks_obt='';
																$mid_marks_max='';
																$mid_marks_obt='';
															}
															if($row4['type']=="Non-Gradial"||$row4['type']=="Common"||$row4['type']=="Minor"){
																if($row4['theory_practical']=="Practical" || $row4['theory_practical']=="Practical."){
																	$practical_marks_max_p=$row4['pt_marks_max'];
																	$practical_marks_obt=$row4['pt_marks_obt'];
																	$theory_marks_max='';
																	$theory_marks_obt='';
																	$mid_marks_max='';
																	$mid_marks_obt='';
																}
															}
															if($row4['theory_practical']=="Viva-voce" || $row4['theory_practical']=="Project"){
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
															
														?>
														<?php
															if($row2['paper_code']=='KAGRON-560'  || $row2['paper_code']=='KGPB-599'  || $row2['paper_code']=='KSS-599' || $row2['paper_code']=='KHORT-599') {
														?>
															<tr>
																<td class="text-start"><?php echo $row4['title_of_paper']; ?> (<?php echo $row4['paper_code']; ?>)</td>
																<td><?php echo $paper_credit = $row2['credit']; ?></td>
																<td>-</td>
																<td colspan="2"><b>SATISFACTORY</b></td>
															
															</tr>
															
														<?php	
													}elseif($row2['paper_code']=='AGRON-551' || $row2['type'] == "Special Paper" || $row2['paper_code'] == "KENT-515" || $row2['paper_code'] == "KSS-510" || $row2['paper_code'] == "KPGS-503" || $row2['paper_code'] == "KPGS-504" || $row2['paper_code'] == "KPGSS-503" || $row2['paper_code'] == "KPGSS-504"){
														?>
															<tr>
																<td class="text-start"><?php echo $row4['title_of_paper']; ?> (<?php echo $row4['paper_code']; ?>)</td>
																<td><?php echo $paper_credit = $row2['credit']; ?></td>
																<td><?php 
																if(($mid_marks_obt=='Abs' || $mid_marks_obt==NULL) AND ($theory_marks_obt=='Abs' || $theory_marks_obt==NULL) AND ($practical_marks_obt_p=='Abs' || $practical_marks_obt_p==NULL)){
																	echo $obt_total = 'Abs';
																}else{
																	echo $obt_total = (float)$mid_marks_obt+(float)$theory_marks_obt+(float)$practical_marks_obt_p; 
																}		
															?></td>
																<td colspan="2"><b>SATISFACTORY</b></td>
															
															</tr>
															
														<?php
														
													}
													else{
														?>
														
														<tr style="border:1px solid black; border-style:;">
														<?php
															$count_row = '';
														if($row4['type']!='Non-Gradial'){ $count_row++; } ?>
														<?php //echo $paperCode; ?>
														<td class="text-start"><?php echo $row4['title_of_paper']; ?> (<?php echo $row4['paper_code']; ?>)</td>
														<td><?php echo $paper_credit = $row4['credit']; ?></td>
														<?php $max_total = (float)$mid_marks_max+(float)$theory_marks_max+(float)$practical_marks_max_p; ?>
														<?php  $mid_marks_obt; ?>
														<?php  $theory_marks_obt; ?>
														<?php  $practical_marks_obt_p; ?>
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
															
															if($mid_marks_obt=='Inc'){
																 $ufm_exist = 1;
															}if($theory_marks_obt=='Inc'){
																 $ufm_exist = 1;
															}if($practical_marks_obt_p=='Inc'){
																 $ufm_exist = 1;
															}
															
															$theory_percentage = percentage_marks($obt_total,$max_total);
																if($theory_percentage<$required_passing_percentage){
																	 $earned_credit = 0;
																}else{
																	 $earned_credit = $paper_credit;
																}

															if($row4['type']!='Non-Gradial'){
														?>
														<td><?php echo $earned_grade = ((float)$obt_total/10); ?></td>
														<td><?php echo $credit_grade_point = (float)$earned_credit*(float)$earned_grade; ?></td>
														<?php
															}else{
																if(($mid_marks_obt=='Abs' || $mid_marks_obt==NULL) AND ($theory_marks_obt=='Abs' || $theory_marks_obt==NULL) AND ($practical_marks_obt_p=='Abs' || $practical_marks_obt_p==NULL)){
																	$satisfy = 'UNSATISFACTORY';
																	$passing_status='FAILED';
																	$passing_status_reason .= '</br> UNSATISFACTORY';
																}else{
																	$satisfy = 'SATISFACTORY';
																}	
														?>	
														<td colspan="2"><b><?php echo $satisfy; ?></b></td>
												<?php	
															}
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
															$tot_earned_grade+=$earned_grade;
														}else{
															$nc_cource_credit = is_numeric($nc_cource_credit) ? $nc_cource_credit : 0;
															$nc_cource_credit += is_numeric($paper_credit) ? $paper_credit : 0;

														}	
														
														$practical_marks_obt_p==NULL;
													}
												}	
											}
											}
											
											if ((float)$count_row != 0) {
												$grand_tot = $tot_credit_grade / (float)$count_row;
											} else {
												$grand_tot = 0;
												error_log("Division by zero encountered in \$count_row");
											}

	
											$grand_tot = number_format($grand_tot,2);
											
											if($passing_status=='FAILED'){
												//$passing_status='ATKT'; 
											}
											if($tot_course_credit == 0){
												$avg_grd_point = 0;
											}else{
												$avg_grd_point = $tot_credit_grade/$tot_course_credit;
											}
											$avg_grd_point = number_format($avg_grd_point,3);
											if($ufm_exist == 1){
												$passing_status='INC';
												$passing_status_reason .= '</br>UFM occours';
											}
											$avg_grd_point = number_format($avg_grd_point,3);
											$pre_avg_grd_point = $row_t['grade_point'] / $row_t['total_credit'];
											$pre_avg_grd_point = number_format($pre_avg_grd_point, 3);
											$cum_grade_point = $row_t['grade_point'] + $tot_credit_grade;
											$cum_grade_point = number_format($cum_grade_point, 1);
											$cum_credit_avg = $row_t['total_credit'] + $tot_course_credit;
											$cum_total_avg = $cum_grade_point / $cum_credit_avg ;
											$cum_total_avg = number_format($cum_total_avg, 3);
											if(($row_t['passing_status'] == "FAILED" && $passing_status == "PASSED") || ($row_t['passing_status'] == "ATKT" && $passing_status == "PASSED") ){
												$passing_status='INC';
											}else{
												$passing_status;
											}
																	?>
										<tr>
											<th class="text-start">Total </th>
											<th class=""><?php echo $tot_course_credit; ?> </th>
											<th class="text-start"></th>
											<th class="text-start"> </th>
											<th class="text-center"> <?php echo $tot_credit_grade; ?></th>
										</tr>
            </table>
			
			
			<table width="100%" class="table  " style="border:1px solid black; ">
				<tr >
                    <th  class="text-start" width="30%" style="border:1px solid black; ">TOTAL GRADE POINT<br>GRADE POINT AVERAGE<br>PREV. GRADE POINT AVERAGE<br>CUMULATIVE GRADE POINT AVERAGE<br>OVERALL GRADE POINT AVERAGE</th>
                    <th  class="text-start"  width="25%" style="border:1px solid black; "><?php echo $tot_credit_grade; ?><br><?php echo $tot_credit_grade.' / '.$tot_course_credit.' = <span style=" font-weight:bold;">'; echo $avg_grd_point ; ?></span><br>
					<?php
						if($passing_status == 'INC'){
							echo "0.00".' / '.$row_t['total_credit'].' = <span style="font-weight:bold;">'; echo "0" ;
						}else{
							echo $row_t['grade_point'].' / '.$row_t['total_credit'].' = <span style="font-weight:bold;">'; echo $pre_avg_grd_point ; 
						}
													
						
					
					?></span><br>
					<?php
						$avg_grd_point1 = $tot_credit_grade / $cum_credit_avg;
						$avg_grd_point1 = number_format($avg_grd_point1, 3);

						if($passing_status == 'INC'){
							echo $tot_credit_grade.' / '.$cum_credit_avg.' = <span style=" font-weight:bold;">'; echo $avg_grd_point1 ;
						}else{
							echo $cum_grade_point.' / '.$cum_credit_avg.' = <span style=" font-weight:bold;">'; echo $cum_total_avg ; 
						}

					 ?></span><br><span style="margin-left:4.6rem;"><?php
					 if($passing_status == 'INC'){
							 echo $avg_grd_point1 ;
						}else{
							echo $cum_total_avg; 
						}
					 
					 
					 ?></span></th>
                    <th  class="text-center"  width="25%" style="border:1px solid black; ">OVERALL GRADE POINT AVERAGE<br><br>
					<?php

					 if($passing_status == 'INC'){
							 echo $avg_grd_point1 ;
						}else{
							echo $cum_total_avg; 
						} ?></span></th>
                    <th  class="text-center"  width="20%">RESULT<br><br><?php echo $passing_status; ?></th>
                </tr>
				
			</table>
			

			<table width="100%">
				<tr>
					<td><h4 style="text-align:center;font-weight:bold;">INSTRUCTIONS FOR B.Sc(AG) & M.Sc(AG)</h4></td>
				</tr>
				<tr>
					<td>1. To pass a candidate in particular paper must obtain a minimum of 50% marks in U.G. course (aggregate of theory, mid-term, and practical marks) and in P.G. course it will be 60% marks.</br>
					2. Grade obtained=Marks obtained in particular course divided by 10.</br>
					3. Total Grade Point = Numerical value of the grade obtained in particular course/paper multiplied by the number of credits of same course.</br>
					4. GPA = Total Grade Point earned divided by total number of credits offered.</br>
					5. To passing a semester minimum grade point average (GPA) should must be 5.0 in U.G. course, in P.G. course 6.0.</br>
					6. % of marks = GPA x 10.</br>
					7. In case, the result of a candidate is shown incomplete / incorrect, in any paper he/she should represent within one month from the date of declaration of result (No claim shall be accepted thereafter).
					</td>
				</tr>
			</table>
			
        </div>
		</div>
    <div>
  </body>
</html>
<?php
	}			
}else{?>
<script>
  alert("Roll number not found.");
  window.location.href = "exam_result.php";
</script>
<?php
}
}
?>	