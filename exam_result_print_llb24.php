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
				font-size: 15px!important;
				padding: 7px!important;
				}
			th{
				
				font-size: 15px!important;
				padding: 7px!important;
			}
			.watermark {
				color: #ececec; 
				opacity: 0.5 !important;
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
			position:relative;
			z-index:-100;
			}
			.pp{
			padding-top:20px!important;
			}
			 
			  
			
		}
		
		.look{
			padding:5px!important;
			margin:0px!important;
			font-size:13px;
		}
			
		
	  
		@page{
        size: A4;
        margin:10px;
        margin-right:25px!important;
		}
		.watermark {
		  position: absolute;
		  top: 50%;
		  left: 20%;
		  opacity: 0.8;
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
  </head>

  <body class="w-100 m-auto" id="main">
	<div style="text-align:center">
		<button id="printButton" onclick="printAndRemoveButton()" class=" btn btn-danger btn-sm text-center" >Print</button>
	</div>

   <!-- <div class="" style="display:flex ; justify-content: center ;">
      <button class="btn btn-secondary btn-print" style="width: 5%;" onclick="print()">Print</button>
    </div>-->
	<img src="images/kni_logo.png"  id="overlays" style=" z-index:-2;opacity:0.0;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%); width:30%;" alt="overlay image" >
	 <img src="images/logo_bg.png"  id="overlays1" style=" z-index:-2;opacity:0.15;position: absolute;top: 40%;left: 50%;-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%); width:30%; " alt="overlay image" >
    <div  style="">
        <div class="container-fluid">
			
            <table width="100%" style="margin:0px;">
			<div class="watermark">Internet Copy</div>
			<tr>
				<th width="12%" rowspan="2"><img style="padding:15px; height:65px; width:65px; " src="images/kni_logo.png" alt="logo" class="img-fluid d-block m-auto" /> </th>
				<th width="88%">
					<h4 class="" style="text-align: center; margin:0px; " ><span style="font-size:17px;white-space:nowrap;" class="head-name"><b>Kamla Nehru Institute Of Physical & Social Sciences,Sultanpur, Uttar Pradesh</b></span> <br>An Autonomous Institute And Accredited "A" Grade by NAAC<br><span style="font-size:14px;">(Affiliated to Dr. Rammanohar Lohia Avadh University, Ayodhya U.P.)</span></h4>
				</th>
			</tr>
		</table>
		<?php
			$result =mysqli_query($db,$sql);
			if(mysqli_num_rows($result)>0){
				$row=mysqli_fetch_assoc($result);
		?>
            <table class="table table-borderless" width="100%">
				<tr>
					<th class="text-center" colspan="5"><span style="font-size:12px;">PROVISIONAL MARKSHEET<br>2024-2025</span></th>
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
					<th colspan="3" class="look">: K.N.I.P.S.S. SULTANPUR</th >
				
				</tr>
			</table>	
            <table class="table text-center" width="100%" style="border:1px solid black; ">
                <tr style="border:1px solid black; ">
                    <th width="50%" class="abc text-start" style="padding-top:20px;">SUBJECT</th>
                    <th width="14%" class="abc "style="padding-top:20px;">Max</th>
                    <th  width="16%" class="abc ">Min</th>
                    <th  width="20%" class="abc " style="padding-top:20px;"> Total</th>
                </tr>
				
						<?php 
							if($row['exam_id']==2){
					
						?>
						<?php
					$total_obt = 0;
					$total_max = 0;
					$total_abs = 0;
					$passing_status = 'PASSED';
					$passing_status_reason = 'EVERYTHING FINE';
					$min_marks = 36;
					$required_total = 315;

					$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."'"; 
					$result2 = mysqli_query($db, $sql2);

					// Array to store grouped data
					$groupedData = [];
					while ($row2 = mysqli_fetch_assoc($result2)) {
						$title = $row2['title_of_paper'];
						if (!isset($groupedData[$title])) {
							$groupedData[$title] = [
								'title_of_paper' => $title,
								'pt_marks_max' => $row2['pt_marks_max'],
								'pt_marks_obt' => $row2['pt_marks_obt']
							];
						} else {
							$groupedData[$title]['pt_marks_max'] += $row2['pt_marks_max'];
							$groupedData[$title]['pt_marks_obt'] += $row2['pt_marks_obt'];
						}

						// Calculate totals
						$total_max += $row2['pt_marks_max'];
						$total_obt += intval($row2['pt_marks_obt']);

						if ($row2['pt_marks_obt'] < $min_marks) {
							$passing_status = "FAILED";
							$passing_status_reason .= " | Marks less than $min_marks in one or more subjects.";
						}
					}

					if ($total_obt < $required_total) {
						$passing_status = "FAILED";
						$passing_status_reason .= " | Total marks less than $required_total.";
					}

					if ($total_obt == 0) {
						$passing_status = "ABSENT";
						$passing_status_reason = "All subjects marked absent.";
					}
					?>

					<!-- Display Results -->
					<?php foreach ($groupedData as $row2): ?>
					<tr style="border:1px solid black;">
						<td class="abc text-start"><?php echo $row2['title_of_paper']; ?></td>
						<td class="abc"><?php echo $row2['pt_marks_max']; ?></td>
						<td class="abc"><?php echo $min_marks; ?></td>
						<td class="abc"><?php echo $row2['pt_marks_obt']; ?></td>
					</tr>
					<?php endforeach; ?>

					<tr style="height:50px;">
						<td colspan="4">&nbsp;</td>
					</tr>
					<tr style="border:1px solid black; font-weight:bold;">
						<td class="abc text-start">Total: <?php echo $total_obt == 0 ? "ABSENT" : strtoupper(int_to_words($total_obt)); ?></td>
						<td class="abc"><?php echo $total_max; ?></td>
						<td class="abc"><?php echo $required_total; ?></td>
						<td class="abc"><?php echo $total_obt == 0 ? "Abs" : $total_obt; ?></td>
					</tr>

				<tr  style="border:1px solid black; " >
                    <th  class=" p-2 text-start"  style="border:1px solid black; ">
						<?php
								$sql="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' and exam_id=1";
								$row_t = mysqli_fetch_assoc(mysqli_query($db,$sql));
								$grant_total = $row_t['obt_marks'] + $total_obt;
								if($row_t['passing_status'] == "FAILED"|| $row_t['passing_status'] == "ATKT" ){
									$passing_status ="INC";
								}else{
									$passing_status;
								}
								if($row_t['passing_status'] == "FAILED" || $row_t['passing_status'] == "ATKT"){
									$grant_total_obt=  $total_obt;
									$grant_total_max=  $total_max;
								}else{
									$grant_total_obt= $row_t['obt_marks'] + $total_obt;
									$grant_total_max= $row_t['max_marks'] + $total_max;
								}
								
								?>
						
						<table width ="100%">
							<tr>
								<th></th>
								<th>I<sup>st</sup> SEM</th>
								<th>II<sup>nd</sup> SEM</th>
							</tr>
							<tr>
								<th>MAX MARKS</th>
								<th><?php echo $row_t['max_marks']; ?></th>
								<th><?php echo $total_max; ?></th>
							</tr>
							<tr>
								<th>MARKS OBTAINED</th>
								<th ><?php 
										if($row_t['passing_status'] == "FAILED" || $row_t['passing_status'] == "ATKT"){
											echo '-';
										}else{
											echo $row_t['obt_marks'];
										}
									?></th>
								<th><?php if($total_obt == 0){
										echo "Abs";
									} else{
										echo $total_obt;
									}
								?></th>
							</tr>
						</table>
							
					</th>
					<th  class="text-center" rowspan="2"  style="border:1px solid black; "><br>Grand Total <br>
						<?php if($total_obt == 0){
									echo "AB";
								} else{
									echo $grant_total_obt . "/" . $grant_total_max;

								}
						?></th>
					<th  class="text-center" rowspan="2" colspan="2" style="border:1px solid black; "><br>Result/Division<br><?php 
							if($grant_total_obt==0 || $total_obt == 0){
								echo "ABSENT";
							}
							else{
								echo $passing_status;
							}
						?></th>
					<?php 
							}elseif($row['exam_id']==3){
					
					
					$total_obt = 0;
					$total_max = 0;
					$total_abs = 0;
					$passing_status = 'PASSED';
					$passing_status_reason = 'EVERYTHING FINE';
					$min_marks = 36;
					$required_total = 315;

					$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."'"; 
					$result2 = mysqli_query($db, $sql2);

					// Array to store grouped data
					$groupedData = [];
					while ($row2 = mysqli_fetch_assoc($result2)) {
						$title = $row2['title_of_paper'];
						if (!isset($groupedData[$title])) {
							$groupedData[$title] = [
								'title_of_paper' => $title,
								'pt_marks_max' => $row2['pt_marks_max'],
								'pt_marks_obt' => $row2['pt_marks_obt']
							];
						} else {
							$groupedData[$title]['pt_marks_max'] += $row2['pt_marks_max'];
							$groupedData[$title]['pt_marks_obt'] += $row2['pt_marks_obt'];
						}

						// Calculate totals
						$total_max += $row2['pt_marks_max'];
						$total_obt += intval($row2['pt_marks_obt']);

						if ($row2['pt_marks_obt'] < $min_marks) {
							$passing_status = "FAILED";
							$passing_status_reason .= " | Marks less than $min_marks in one or more subjects.";
						}
					}

					if ($total_obt < $required_total) {
						$passing_status = "FAILED";
						$passing_status_reason .= " | Total marks less than $required_total.";
					}

					if ($total_obt == 0) {
						$passing_status = "ABSENT";
						$passing_status_reason = "All subjects marked absent.";
					}
					?>

					<!-- Display Results -->
					<?php foreach ($groupedData as $row2): ?>
					<tr style="border:1px solid black;">
						<td class="abc text-start"><?php echo $row2['title_of_paper']; ?></td>
						<td class="abc"><?php echo $row2['pt_marks_max']; ?></td>
						<td class="abc"><?php echo $min_marks; ?></td>
						<td class="abc"><?php echo $row2['pt_marks_obt']; ?></td>
					</tr>
					<?php endforeach; ?>

					<tr style="height:50px;">
						<td colspan="4">&nbsp;</td>
					</tr>
					<tr style="border:1px solid black; font-weight:bold;">
						<td class="abc text-start">Total: <?php echo $total_obt == 0 ? "ABSENT" : strtoupper(int_to_words($total_obt)); ?></td>
						<td class="abc"><?php echo $total_max; ?></td>
						<td class="abc"><?php echo $required_total; ?></td>
						<td class="abc"><?php echo $total_obt == 0 ? "Abs" : $total_obt; ?></td>
					</tr>

				<tr  style="border:1px solid black; " >
						
                    <th  class=" p-2 text-start"  style="border:1px solid black; ">
						<?php
							$erp_23 = mysqli_connect("p:localhost", "root", "mysql", "knipsser_2023");

							// Fetch semester data
							$sql1 = "SELECT * FROM `exam_student_info` WHERE `student_info_sno` = '" . $row['student_info_sno'] . "' AND exam_id = '1'";
							$row_t = mysqli_fetch_assoc(mysqli_query($erp_23, $sql1));

							$sql2 = "SELECT * FROM `exam_student_info` WHERE `student_info_sno` = '" . $row['student_info_sno'] . "' AND exam_id = '2'";
							$row_t2 = mysqli_fetch_assoc(mysqli_query($erp_23, $sql2));

							// Calculate grand totals and passing status
							$grant_total_obt = $total_obt;
							$grant_total_max = $total_max;
							$passing_status = 'PASSED';

							
							if ($row_t2['passing_status'] === "FAILED" || $row_t2['passing_status'] === "ATKT" || $row_t2['passing_status'] === "INC") {
								$passing_status = 'INC';
								$first_year_obt = '-';
							} else {
								if ($row_t2) {
									$grant_total_obt += $row_t2['obt_marks'];
									$grant_total_max += $row_t2['max_marks'];
								}
							}

							if ($total_obt > 0) {
								$grant_total_obt += intval($row_t['obt_marks']);
								$grant_total_max += intval($row_t['max_marks']);
							}

							// Handle absence
							if ($total_obt == 0) {
								$passing_status = "ABSENT";
								$grant_total_obt = 0;
							}
							if ($total_obt < 314) {
								$passing_status = "FAILED";
							}
							$first_year_max = (float)$row_t['max_marks'] + (float)$row_t2['max_marks'];
							$first_year_obt = (float)$row_t['obt_marks'] + (float)$row_t2['obt_marks'];

							?>

							<!-- Display Results Table -->
							<table width="100%" >
								<tr>
									<th></th>
									<th>II<sup>nd</sup> SEM</th>
									<th>III<sup>rd</sup> SEM</th>
								</tr>
								<tr>
									<th>MAX MARKS</th>
									<th><?php echo $first_year_max ?? '-'; ?></th>
									<th><?php echo $total_max; ?></th>
								</tr>
								<tr>
									<th>MARKS OBTAINED</th>
									<th><?php echo $first_year_obt ?? '-'; ?></th>
									<th><?php echo $total_obt == 0 ? 'Abs' : $total_obt; ?></th>
								</tr>
							</table>

							<!-- Grand Total and Result -->
							<th class="text-center" rowspan="2" style="border: 1px solid black;">
								<br>Grand Total<br>
								<?php echo $total_obt == 0 ? "AB" : "$grant_total_obt / $grant_total_max"; ?>
							</th>
							<th class="text-center" rowspan="2" colspan="2" style="border: 1px solid black;">
								<br>Result/Division<br>
								<?php echo $grant_total_obt == 0 || $total_obt == 0 ? "ABSENT" : $passing_status; ?>
							</th>

					<?php 
					} else{
						?>
						<?php
					$total_obt = 0;
					$total_max = 0;
					$total_abs = 0;
					$passing_status = 'PASSED';
					$passing_status_reason = 'EVERYTHING FINE';
					$min_marks = 36;
					$required_total = 270;

					$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."'"; 
					$result2 = mysqli_query($db, $sql2);

					// Array to store grouped data
					$groupedData = [];
					while ($row2 = mysqli_fetch_assoc($result2)) {
						$title = $row2['title_of_paper'];
						if (!isset($groupedData[$title])) {
							$groupedData[$title] = [
								'title_of_paper' => $title,
								'pt_marks_max' => $row2['pt_marks_max'],
								'pt_marks_obt' => $row2['pt_marks_obt']
							];
						} else {
							$groupedData[$title]['pt_marks_max'] += $row2['pt_marks_max'];
							$groupedData[$title]['pt_marks_obt'] += $row2['pt_marks_obt'];
						}

						// Calculate totals
						$total_max += $row2['pt_marks_max'];
						$total_obt += intval($row2['pt_marks_obt']);

						if ($row2['pt_marks_obt'] < $min_marks) {
							$passing_status = "FAILED";
							$passing_status_reason .= " | Marks less than $min_marks in one or more subjects.";
						}
					}

					if ($total_obt < $required_total) {
						$passing_status = "FAILED";
						$passing_status_reason .= " | Total marks less than $required_total.";
					}

					if ($total_obt == 0) {
						$passing_status = "ABSENT";
						$passing_status_reason = "All subjects marked absent.";
					}
					?>

					<!-- Display Results -->
					<?php foreach ($groupedData as $row2): ?>
					<tr style="border:1px solid black;">
						<td class="abc text-start"><?php echo $row2['title_of_paper']; ?></td>
						<td class="abc"><?php echo $row2['pt_marks_max']; ?></td>
						<td class="abc"><?php echo $min_marks; ?></td>
						<td class="abc"><?php echo $row2['pt_marks_obt']; ?></td>
					</tr>
					<?php endforeach; ?>

					<tr style="height:50px;">
						<td colspan="4">&nbsp;</td>
					</tr>
					<tr style="border:1px solid black; font-weight:bold;">
						<td class="abc text-start">Total: <?php echo $total_obt == 0 ? "ABSENT" : strtoupper(int_to_words($total_obt)); ?></td>
						<td class="abc"><?php echo $total_max; ?></td>
						<td class="abc"><?php echo $required_total; ?></td>
						<td class="abc"><?php echo $total_obt == 0 ? "Abs" : $total_obt; ?></td>
					</tr>

				<tr  style="border:1px solid black; " >
					<th  class=" p-2 text-start"  style="border:1px solid black; "> <br>MAX MARKS <br><br>MARKS OBTAINED <br></th>
					<th  class="text-center" rowspan="2"  style="border:1px solid black; "><br>Grand Total <br><?php echo $total_obt; ?>/<?php echo $total_max; ?></th>
					<th  class="text-center" rowspan="2" colspan="2" style="border:1px solid black; "><br>Result/Division<br><?php echo $passing_status; ?></th>
					<?php }?>
                    
                    
                </tr>
				<tr  style="border:1px solid black; " >
                </tr>
            </table>
			<!--<table width="100%" class="table  " style="border:1px solid black; ">
				<tr  style="border:1px solid black; " >
                    <th  class=" p-2" width="50%" style="border:1px solid black; "> <br>MAX MARKS <br><br>MARKS OBTAINED <br></th>
                    <th  class="text-center" rowspan="2" width="14%" style="border:1px solid black; ">Grand Total <br><?php echo $total_obt; ?>/<?php echo $total_max; ?></th>
                    <th  class="text-center" rowspan="2" width="36%" style="border:1px solid black; ">Result/Division<br><?php echo $passing_status; ?></th>
                </tr>
				<tr  style="border:1px solid black; " >
                </tr>
			</table>-->
			<table>
				<tr>
					<th>RESULT DECLARATION DATE : 16-01-2025</th>
				</tr>
			<table>
        </div>
		</div>
    <div>
  </body>
</html>
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