<?php
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg='';
$tab=1;
$responce = 0;
if(isset($_GET['back'])){
	unset($_POST['corsslist_course_bed']);
	unset($_SESSION['corsslist_course_bed']);
	$responce=0;
}
if(isset($_POST['submit']) && $_POST['submit']!=''){
	$_SESSION['corsslist_course_bed'] = $_POST['corsslist_course_bed'];
		$responce = 1;
}
if(isset($_SESSION['corsslist_course_bed'])){
	$_POST['corsslist_course_bed'] = $_SESSION['corsslist_course_bed'];
		$responce = 1;
}
switch ($responce) {
case 0:	{
page_header_start();
page_header_end();
page_sidebar();	
?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title text-center"></h4></br>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="" target="_blank">
					<?php echo $msg; ?> 
					<div class="col-md-12">
						<h2 class="bg-primary text-white p-2">Cross-List (B.Ed)</h2>
						<div class="row">
							 <div class=" col-md-4 ">
								<label>Course</label>
								<select name="corsslist_course_bed" id="course" value="" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
									<option disabled selected>---Select Course---</option>
									<?php 
									$sql  = 'select distinct(course_name),class_detail.class_description from exam_student_info LEFT JOIN class_detail on exam_student_info.course_name = class_detail.sno WHERE class_detail.crasslist_type = 4 ORDER BY class_detail.class_description';
									//echo $sql;
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
<?php
}
break;
case 1:{
if(isset($_POST['corsslist_course_bed'])){
	$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`student_type`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender` FROM `exam_student_info` LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno where exam_roll_no!="" and exam_roll_no is not null and `exam_student_info`.`course_name` = "'.$_POST['corsslist_course_bed'].'" order by exam_roll_no';
	
	$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`student_type`, `exam_id`, `student_info_sno`, `exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, `class_description` FROM `exam_student_info` 
	LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno 
	LEFT JOIN class_detail on class_detail.sno = course_name
	where exam_roll_no!="" and exam_roll_no is not null and `exam_student_info`.`course_name` = "'.$_POST['corsslist_course_bed'].'" order by exam_roll_no';
	
	$sql = '(SELECT "regular" as exam_type, `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`, `exam_id`,`student_type`, `student_info_sno`, `exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, `class_description` FROM `exam_student_info` LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno LEFT JOIN class_detail on class_detail.sno = course_name where exam_roll_no!="" and exam_roll_no is not null and `exam_student_info`.`course_name` = "'.$_POST['corsslist_course_bed'].'")

union all 

(SELECT "back" as exam_type, `back_exam_student_info`.`sno` as id,`back_exam_student_info`.`student_name`,`back_exam_student_info`.`exam_roll_no`, `exam_id`,`student_type`, `student_info_sno`, `back_exam_student_info`.`dob`,`back_exam_student_info`.`uin_no`,`back_exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, `class_description` FROM `back_exam_student_info` LEFT JOIN `student_info` ON `back_exam_student_info`.student_info_sno = `student_info`.sno LEFT JOIN class_detail on class_detail.sno = course_name where exam_roll_no!="" and exam_roll_no is not null and `back_exam_student_info`.`course_name` = "'.$_POST['corsslist_course_bed'].'")

order by exam_type, exam_roll_no 
';
	$result = $summ_result =mysqli_query($db,$sql);
		
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
			
			.report_border{
				border:1px solid black!important;
				font-size:13px!important;
			}
			
		</style>
		<link href="css/pagination.css" rel="stylesheet" type="text/css" media="all" />
	</head>
	<body>
		<div class="row noprint">
			<div class="col-md-12">
				<?php
				include ('pagination/paginate.php'); //include of paginat page
				$total_results = mysqli_num_rows($result);
				$per_page = 1000;
				$total_pages = (ceil($total_results / $per_page));//total pages we going to have
				$tpages=$total_pages;
				if (isset($_GET['page'])) {
					$show_page = $_GET['page'];             //it will telles the current page
					if ($show_page > 0 && $show_page <= $total_pages) {
						$start = ($show_page - 1) * $per_page;
						$end = $start + $per_page;
					} else {
						// error - show first set of results
						$start = 0;              
						$end = $per_page;
					}
				} else {
					// if page isn't set, show first set of results
					$_GET['page'] = 1;
					$show_page = 1;
					$start = 0;
					$end = $per_page;
				}
				// display pagination
				$page = intval($_GET['page']);
				if ($page <= 0)
					$page = 1;
				$reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages . (isset($_GET['details'])?'&details=1':'');
				echo '<div class="pagination"><ul><li><a href="exam_crasslist_print_bed.php?back=1">Back</a></li>';
				if ($total_pages > 1) {
					echo paginate($reload, $show_page, $total_pages);
				}
				echo "</ul></div>";
			?>
			</div>
		</div>
		<div class="wrap">
			<table width="100%">
				<thead>
					<tr>
						<td>
							<div style="width:100%" class="border ">
								<div><h4 class="" style="text-align: center; margin:0px; " ><span ><b>Kamla Nehru Institute Of Physical &amp; Social Sciences,Sultanpur, Uttar Pradesh</b></span> <br><span style="font-size:1.3rem;">An Autonomous Institute And Accredited "A" Grade by NAAC</span></h4></div>
								<div class="d-flex">
									<?php
										$sql_class = 'select * from class_detail where sno = "'.$_POST['corsslist_course_bed'].'"';
										$row_class = mysqli_fetch_assoc(mysqli_query($db,$sql_class));
										//print_r($row_class);
									?>
									<div><b><?php echo $row_class['class_description']?><?php //echo $row_class['sno']?>  Main Examination  <?php echo substr($_SESSION['db_name'], -4);?></b></div>
									<div style="margin-left:20px;font-weight:bolder;">Regular/Backpaper/Ex-Student</div>
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
								for ($pgid = $start; $pgid < $end; $pgid++) {
									if ($pgid == $total_results) {
										break;
									}
									mysqli_data_seek($result, $pgid);
									$row = mysqli_fetch_array($result);
									$i = $pgid+1;
									$cross_list = cross_list_bed($row);
									echo $cross_list['html'].'<br>';
								
									
								}
								 mysqli_data_seek($result, 0);	
							?>	
						<!----    REPORT START  ---->
							<?php

							if ($_GET['page'] == $tpages) {
								// Initialize variables for summary data
								$total_students = 0;
								$total_failed_students = 0;
								$total_abs_students = 0;
								$total_ufm_students = 0;
								$total_appeared_students = 0;
								$total_pass_students = 0;
								$total_inc_students = 0;

								// Fetch data from `exam_student_info` table for the current course
								$course_name = $_POST['corsslist_course_bed'];

								$sql2 = "
									SELECT 
										COUNT(*) AS total_students,
										SUM(CASE WHEN theory_status = 'ABSENT'  THEN 1 ELSE 0 END) AS total_abs_theory,
										SUM(CASE WHEN practical_status = 'ABSENT'  THEN 1 ELSE 0 END) AS total_abs_practical,
										SUM(CASE WHEN theory_status IN ('PASSED', 'FIRST', 'SECOND', 'THIRD') THEN 1 ELSE 0 END) AS total_pass_theory,
										SUM(CASE WHEN practical_status = 'PASSED' THEN 1 ELSE 0 END) AS total_pass_practical,
										SUM(CASE WHEN theory_status = 'FAILED' THEN 1 ELSE 0 END) AS total_failed_theory,
										SUM(CASE WHEN practical_status = 'FAILED' THEN 1 ELSE 0 END) AS total_failed_practical,
										SUM(CASE WHEN theory_status = 'INC' THEN 1 ELSE 0 END) AS total_inc_theory,
										SUM(CASE WHEN practical_status = 'INC' THEN 1 ELSE 0 END) AS total_inc_practical,
										SUM(CASE WHEN theory_status = 'UFM' THEN 1 ELSE 0 END) AS total_ufm_theory,
										SUM(CASE WHEN practical_status = 'UFM' THEN 1 ELSE 0 END) AS total_ufm_practical
									FROM exam_student_info
									WHERE course_name = '$course_name';
								";

								$result = mysqli_query($db, $sql2);
								$result_row = mysqli_fetch_assoc($result); // Fetch as associative array
								$apperred_stu = $result_row['total_students'] - ($result_row['total_abs_theory']);

								echo '';
							?>
								<div class="container mt-5">
									<div class="text-center" style="font-size:15px; margin-bottom:15px;"><b>SUMMARY</b></div>
									<table width="100%" class="table table-bordered" style="border:1px solid black;">
										<tr class="text-center">
											<th width="16%" rowspan="2" style="font-size:15px; padding-top:30px;" ><?php echo $row_class['class_description']; ?></th>
											<th width="13%" style="font-size:15px; padding-top:30px;" class="report_border" rowspan="2">REGISTERED</th>
											<th width="12%" style="font-size:15px; padding-top:30px;" rowspan="2" class="report_border">APPEARED</th>
											<th width="12%" colspan="2" class="report_border">ABSENT</th>
											<th width="9%" colspan="2" class="report_border">PASSED</th>
											<th width="9%" colspan="2" class="report_border">FAILED</th>
											<th width="9%" colspan="2" class="report_border">UFM</th>
											<th width="9%" colspan="2" class="report_border">INC</th>
										</tr>
										<tr class="text-center">
											
											<th width="12%" class="report_border">Th. ABSENT</th>
											<th width="12%" class="report_border">Pra. ABSENT</th>
											<th width="9%" class="report_border">Th. PASS</th>
											<th width="9%" class="report_border"> Pra. PASS</th>
											<th width="9%" class="report_border">Th. FAIL</th>
											<th width="9%" class="report_border">Pra. FAIL</th>
											<th width="9%" class="report_border"> Th. UFM</th>
											<th width="9%" class="report_border">Pra. UFM</th>
											<th width="9%" class="report_border"> Th.y INC</th>
											<th width="9%" class="report_border">Pra. INC</th>
										</tr>
										<tr>
											<td class="report_border">TOTAL</td>
											<td class="report_border"><?php echo $result_row['total_students']; ?></td>
											<td class="report_border"><?php echo $apperred_stu; ?></td>
											<td class="report_border"><?php echo $result_row['total_abs_theory']; ?></td>
											<td class="report_border"><?php echo $result_row['total_abs_practical']; ?></td>
											<td class="report_border"><?php echo $result_row['total_pass_theory']; ?></td>
											<td class="report_border"><?php echo $result_row['total_pass_practical']; ?></td>
											<td class="report_border"><?php echo $result_row['total_failed_theory']; ?></td>
											<td class="report_border"><?php echo $result_row['total_failed_practical']; ?></td>
											<td class="report_border"><?php echo $result_row['total_ufm_theory']; ?></td>
											<td class="report_border"><?php echo $result_row['total_ufm_practical']; ?></td>
											<td class="report_border"><?php echo $result_row['total_inc_theory']; ?></td>
											<td class="report_border"><?php echo $result_row['total_inc_practical']; ?></td>
										</tr>
									</table>
									<div class="d-flex justify-content-between" style="font-size:13px;">
										<div><b>DATE OF RESULT DECLARATION : <?php 
												
										$sql25="SELECT *  FROM `result_class` WHERE `class_description` ='".$row_class['class_description']."' and show_result=1";
			                           	$row_date = mysqli_fetch_assoc(mysqli_query($db,$sql25));
												echo !empty($row_date['result_declaration_date']) ? date('d-m-Y', strtotime($row_date['result_declaration_date'])) : '';

 
												?></b></div>
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
<?php
}
}
//***************** CROSS LIST FUNCTION *************************//
function cross_list_bed($row){
	
	global $db;
	$backpaperArray = array();
	$incpaperArray = array();
	$show_total = 0;
	$hide_practical_paper = 0;
	$result_array = array();
	$total_obt = 0;
	$total_max = 0;	
	$total_grade_credit_erned_point = 0;
	$passing_status = 'PASSED';	
	$passing_status_t = 'PASSED';	
	$passing_status_p = 'PASSED';	
	$passing_status_reason = 'EVERY THING FINE';
	$avg_credit = 0;
	$cocurricular_count = 0;
	$count_row = 0;
	$show_total=0;
//**************** STUDENT INFORMATION START **********************//
	$html = '
	<table style=" width:100%; border:1px solid black;border-style: ;">
		<tr style="border:1px solid black;border-style: ;">
			<td style="verticle-align:top;"  width="20%" valign="top">
				<table width="100%"  valign="middle" >
					<tr>
						<td style="height: 35;"></td>

					</tr> 
					<tr>
						<td><b>STUDENT TYPE</b></td>
						<td ><b>'.$row['student_type'].'</b></td>
					</tr>
					<tr>
						<td><b>ROLL NO.</b></td>
						<td ><b>'.$row['exam_roll_no'].'@@#'.$row['dob'].'</b></td>
					</tr>
					<tr >
						<td><b>UIN No.</b></td>
						<td ><b>'.$row['uin_no'].'</b></td>
					</tr>
					<tr >
						<td><b>STUDENT\'S NAME</b></td>
						<td><b>'.$row['student_name'].'</b></td>
					</tr>
					<tr >
						<td ><b>FATHER\'S NAME</b></td>
						<td><b>'.$row['father_name'].'</b></td>
					</tr>
				</table>
			</td>';
//**************** STUDENT INFORMATION END **********************//
//**************** PAPER INFORMATION START **********************//
			$html .= '<td width="40%" valign="top">
				<table width="100%">
					<tr>
						<td rowspan="2"><b>PAPER CODE</b></td>
						<td rowspan="2" class="text-start ps-5"><b>PAPER NAME</b></td>
						<td colspan="2"><b>&nbsp;THEORY</b></td>
						<td ><b>TOTAL </br>THEORY </td>
						<td ><b>PRACTICAL</br>VIVA-VOCE</td>
					</tr>
					<tr>
						<td ><b>80</br>24</b></td>
						<td ><b>20</br>06</b></td>
						<td ><b>100</br>36</b></td>';
						if($row['course_name'] == 246){
							$html .= '<td ><b>200</br>100</b></td>';
						}elseif($row['course_name'] == 252){
							$html .= '<td ><b>100</br>50</b></td>';
						}elseif($row['course_name'] == 248){
							$html .= '<td ><b>200</br>100</b></td>';
						}elseif($row['course_name'] == 254){
							$html .= '<td ><b>100</br>50</b></td>';
						}else{
							$html .= '<td >##<b>50</br>25</b></td>';
						}
					$html .= '</tr>';
					$paperCodeArray = array();
					if($row['exam_type']=='regular'){
					    $sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY theory_practical DESC"; 
					}
					else{
					    $sql2 = "SELECT * FROM back_exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY theory_practical DESC";
					}
					$result2 = mysqli_query($db, $sql2);
					$tot_max=0;
					$tot_obt=0;
					$ufm_exist = 0;
					$tot_theory_20 = 0;
					$tot_theory_80 = 0;
					$tot_theory_obt = 0;
					$tot_practical_30 = 0;
					$tot_practical_50 = 0;
					$tot_practical_obt = 0;
					$stu_abs = 0;
					while ($row2 = mysqli_fetch_assoc($result2)) {
						$total_abs = 0;
						$practical_marks_50 = 0;
						$practical_marks_30 = 0;
						$theory_marks_80 = 0;
						$theory_marks_20 = 0;
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
						    if($row['exam_type']=='regular'){
							    $sql4 = 'SELECT * FROM `exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" && paper_code = "'.$student_paper.'"';
						    }
						    else{
						        $sql4 = 'SELECT * FROM `back_exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" && paper_code = "'.$student_paper.'"';
						    }

							$result4 =mysqli_query($db,$sql4);
							$row4=mysqli_fetch_assoc($result4);

							if (!in_array($paperCode, $paperCodeArray)) {
								$paperCodeArray[] = $paperCode;

								if($row4['theory_practical']=="Theory"){
									$theory_marks_max=$row4['pt_marks_max'];
									$theory_marks_obt=$row4['pt_marks_obt'];
									$mid_marks_max=$row4['mid_sem_marks_max'];
									$mid_marks_obt=$row4['mid_sem_marks_obt'];
									$mid_sem_pt_max=$row4['mid_sem_pt_max'];
									$mid_sem_pt_obt=$row4['mid_sem_pt_obt'];
									$practical_marks_max='';
									$practical_marks_obt='';
								}
								if($row4['theory_practical']=="Practical"){
									$practical_marks_max='';
									$practical_marks_obt='';
									$theory_marks_max=$row4['pt_marks_max'];
									$theory_marks_obt=$row4['pt_marks_obt'];
									$mid_marks_max=$row4['mid_sem_marks_max'];
									$mid_marks_obt=$row4['mid_sem_marks_obt'];
									$mid_sem_pt_max=$row4['mid_sem_pt_max'];
									$mid_sem_pt_obt=$row4['mid_sem_pt_obt'];
								}
								$count_row++;
								$html .= '<tr style="border:1px solid black; border-style:;">
									<td>'.$paperCode.'</td>
									<td class="text-start ps-5">'.$row4['title_of_paper'].'</td>';
									if($row4['theory_practical']=="Theory"){
										$theory_marks_80 = $theory_marks_obt;
										$html .=  '<td>'.$theory_marks_80.'</td>';
											if((float)$theory_marks_80<24){
												$passing_status = "FAILED";
												$passing_status_t = "FAILED";
												$passing_status_reason .= "</br>theory marks 80 less then 24";
											}if($theory_marks_80!="Abs"){
												$stu_abs = 1;
												$total_abs = 1;
											}
									}else{
										$html .=  '<td>-</td>';
									}
									
									if($row4['theory_practical']=="Theory"){
										$mid_marks_obt = is_numeric($mid_marks_obt) ? $mid_marks_obt : 0;
										$mid_sem_pt_obt = is_numeric($mid_sem_pt_obt) ? $mid_sem_pt_obt : 0;
										$theory_marks_20 = $mid_marks_obt + $mid_sem_pt_obt;

										$html .=  '<td>'.$theory_marks_20.'</td>';
										if((float)$theory_marks_20<6){
											$passing_status = "FAILED";
											$passing_status_t = "FAILED";
											$passing_status_reason .= "</br>theory marks 20 less then 12";
										}if($theory_marks_20!="Abs"){
											$stu_abs = 1;
											$total_abs = 1;
										}
									}else{
										$html .=  '<td>-</td>';
									}
									if($row4['theory_practical']=="Theory"){
										if($total_abs == 0){
											$theory_total = "Abs";
											$html .=  '<td>'.$theory_total.'</td>';
										}else{
											$theory_total = (float)$theory_marks_obt+(float)$mid_marks_obt+(float)$mid_sem_pt_obt;
											$html .= '<td>'.$theory_total.'</td>';
										}
										if((float)$theory_total<36){
											$passing_status = "FAILED";
											$passing_status_t = "FAILED";
											$passing_status_reason .= "</br>Theory marks total less then 36";
										}
										$theory_total_max = (float)$theory_marks_max+(float)$mid_marks_max+(float)$mid_sem_pt_max;
									}else{
										$theory_total = '-';
										$html .=  '<td>-</td>';
									}
										
									if($row4['theory_practical']=="Practical"){
										$practical_marks_50 = $theory_marks_obt;
										$html .= '<td>'.$practical_marks_50.'</td>';
										/*if((float)$practical_marks_50<25){
											$passing_status = "FAILED";
											$passing_status_reason .= "</br>Practical marks 70 less then 25";
										}*/
										if($practical_marks_50!="Abs"){
											$stu_abs = 1;
											$total_abs = 1;
										}
										$practical_total_max = 	$theory_marks_max;
									}else{
										$html .=  '<td>-</td>';
									}
									$max_total = (float)$theory_total_max+(float)$practical_total_max;
									if($total_abs == 0){
										//echo 'Abs';
										$obt_total = 0;
									}else{
										 $obt_total = (float)$theory_total+(float)$practical_marks_50;
									}	
									$tot_theory_80+=(float)$theory_marks_80;
									$tot_theory_20+=(float)$theory_marks_20;
									$tot_theory_obt +=(float)$theory_total;
									$tot_practical_obt+=(float)$practical_marks_50;
									$tot_obt+=(float)$obt_total;
									$tot_max+=(float)$max_total;
							}
						}						
					}
											
					if($show_total==0){
					$html .= '</tr>
					<tr style="border:1px solid black; border-style:;">
						<th></th>
						<th style="text-align:right">Total : --</th>
						<th style="text-align:center;">'.$tot_theory_80.'</th>
						<th style="text-align:center;">'.$tot_theory_20.'</th>
						<th style="text-align:center;">'.$tot_theory_obt.'</th>
						<th style="text-align:center;">'.$tot_practical_obt.'</th>
					</tr>';
					}

				$html .= '</table>
			</td>

			<style>
				.bord1{
				  border: 1px solid black!important;
				  border-collapse: collapse!important;
				}
			</style>

			<td width="40%" valign="top">';
//**************** PAPER INFORMATION END **********************//
//**************** START CALCULATION SEMESTER WISE **********************//
// *********************** B.ED Ist Semester  Start **************************//
			if($row['exam_id']=='1' && $row['course_name'] == 245){
				$html .= '<table width="100%">
					<tr style="border:1px solid black">
						<td colspan="4" class="bord1"><b>TOTAL MARKS</b></td>
						<td class="bord1"><b>G. TOTAL</b></td>
					</tr>
					<tr style="border:1px solid black">
						<td ><b>THEORY</br>300</br>108</b></td>
						<td ><b>THEORY</br>RESULT</b></td>
						<td ><b>PRAC/V.V</br>50</br>25</b></td>
						<td ><b>PRAC/V.V</br>RESULT</b></td>
						<td class="bord1"><b>350</br>Max.</b></td>
					</tr>
					<tr>';
					if($tot_theory_obt<108){
						$passing_status = "FAILED";
						$passing_status_t = "FAILED";
						$passing_status_reason .= "Total theory is less then 108";
					}if($tot_practical_obt<25){
						$passing_status = "FAILED";
						$passing_status_p = "FAILED";
						$passing_status_reason .= "Total practical less then 25";
					}if($tot_obt<133){
						$passing_status = "FAILED";
						$passing_status_reason .= "Total is less then 133";
					}
					if($stu_abs == 0){
						$passing_status = "ABSENT";
						$passing_status_t = "ABSENT";
						$passing_status_p = "ABSENT";
					}
					if($tot_theory_obt == 0){
						$passing_status = "ABSENT";
						$passing_status_t = "ABSENT";
					}
					if($tot_practical_obt == 0){
						$passing_status = "ABSENT";
						$passing_status_p = "ABSENT";
					}
					
					$html .= '
						<td ><b>'.$tot_theory_obt.'</b></td>
						<td ><b>'.$passing_status_t.'</b></td>
						<td ><b>'.$tot_practical_obt.'</b></td>
						<td ><b>'.$passing_status_p.'</b></td>
						<td ><b>'.$tot_obt.'</b></td>';
					$b_paper = NULL;
					$sql_update = 'UPDATE exam_student_info SET 
						max_marks = "'.$tot_max.'",
						obt_marks = "'.$tot_obt.'",
						theory_obt = "'.$tot_theory_obt.'",
						theory_max = "300",
						practical_obt = "'.$tot_practical_obt.'",
						practical_max = "50",
						passing_status = "'.$passing_status.'",
						theory_status = "'.$passing_status_t.'",
						practical_status = "'.$passing_status_p.'",
						sgpa = "",
						grade_point = ""					
						WHERE sno = '.$row['id'];
						//$result_update = mysqli_query($db, $sql_update);
						//$result_update = mysqli_query($db, $sql_update);
					$html .= '
					</tr>
				</table>';
			}
				
//******************************* B.Ed Ist Semester END ******************//				
//******************************* M.Ed Ist Semester Start ******************//				
			elseif($row['exam_id']=='1' && $row['course_name'] == 87){
				$html .= '<table width="100%">
					<tr style="border:1px solid black">
						<td colspan="2" class="bord1"><b>TOTAL MARKS</b></td>
						<td class="bord1"><b>GRAND TOTAL</b></td>
						<td class="bord1" rowspan="2"><b>RESULT / DIVISION</b></td>
					</tr>
					<tr style="border:1px solid black">
						<td ><b>THEORY</br>300</br>108</b></td>
						<td ><b>PRAC/V.V</br>50</br>25</b></td>
						<td class="bord1"><b>350</br>133</b></td>
					</tr>
					<tr>';
					if($tot_theory_obt<108){
						$passing_status = "FAILED";
						$passing_status_t = "FAILED";
						$passing_status_reason .= "Total theory is less then 108";
					}if($tot_practical_obt<25){
						$passing_status = "FAILED";
						$passing_status_p = "FAILED";
						$passing_status_reason .= "Total practical less then 25";
					}if($tot_obt<133){
						$passing_status = "FAILED";
						$passing_status_reason .= "Total is less then 133";
					}
					if($stu_abs == 0){
						$passing_status = "ABSENT";
						$passing_status_t = "ABSENT";
						$passing_status_p = "ABSENT";
					}
					if($tot_theory_obt == 0){
						$passing_status = "ABSENT";
						$passing_status_t = "ABSENT";
					}
					if($tot_practical_obt == 0){
						$passing_status = "ABSENT";
						$passing_status_p = "ABSENT";
					}
					
					$html .= '
						<td ><b>'.$tot_theory_obt.'</b></td>
						<td ><b>'.$tot_practical_obt.'</b></td>
						<td ><b>'.$tot_obt.'</b></td>
						<td ><b>'.$passing_status_t.'</b></td>
						';
					$b_paper = NULL;
					$sql_update = 'UPDATE exam_student_info SET 
						max_marks = "'.$tot_max.'",
						obt_marks = "'.$tot_obt.'",
						theory_obt = "'.$tot_theory_obt.'",
						theory_max = "300",
						practical_obt = "'.$tot_practical_obt.'",
						practical_max = "50",
						passing_status = "'.$passing_status.'",
						theory_status = "'.$passing_status_t.'",
						practical_status = "'.$passing_status_p.'",
						sgpa = "",
						grade_point = ""					
						WHERE sno = '.$row['id'];
					//$result_update = mysqli_query($db, $sql_update);
						//$result_update = mysqli_query($db, $sql_update);
					$html .= '
					</tr>
				</table>';
			}
//******************************* M.Ed Ist Semester END ******************//				
//******************************* B.Ed 2nd Semester Start ******************//
			elseif($row['course_name'] == 246){
				$sql="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' and exam_id=1";
				$row_t = mysqli_fetch_assoc(mysqli_query($db,$sql));
				$grant_total = $row_t['obt_marks'] + $tot_obt;
				$grant_total_t = (float)$row_t['theory_obt'] + (float)$tot_theory_obt;
				$grant_total_p = $row_t['practical_obt'] + $tot_practical_obt;
				$grant_max = $row_t['max_marks'] + $tot_max;
				$grant_max_t = $row_t['max_marks'] + $tot_max;
				$grant_max_p = $row_t['max_marks'] + $tot_max;
				$grant_pre_max = $row_t['theory_max'] + $row_t['practical_max'] ;
				//<td class="bord1"><b>SUM TOTAL</b></td>
				$html .= '<table width="100%">
					<tr style="border:1px solid black">
						<td colspan="2" class="bord1"><b>TOTAL MARKS</b></td>
						
						<td colspan="4" class="bord1"><b>PREVIOUS DETAILS</b></td>
						<td class="bord1"><b>GRAND THEORY</b></td>
						<td class="bord1" rowspan="2"><b>RESULT / DIVISION</b></td>
						<td class="bord1"><b>GRAND PRACTICAL</b></td>
						<td class="bord1"  rowspan="2"><b>RESULT / DIVISION</b></td>
					</tr>
					<tr style="border:1px solid black">
						<td ><b>THEORY</br>300</br>108</b></td>';
							$html .= '<td class="bord1"><b>PRAC/V.V</br>200</br>100</b></td>';
						
						$html .= '<td ><b>Theory <br>'.$row_t['theory_max'].' <br>108</b></td>
						<td ><b>Practical<br>'.$row_t['practical_max'].'<br>25</b></td>
						
						<td ><b>YEAR</b></td>
						<td ><b>ROLL-NO</b></td>
						<td class="bord1"><b>600</br>216</b></td>
						<td class="bord1"><b>250</br>125</b></td>
					</tr>
					<tr>';
					if($tot_theory_obt<108){
						$passing_status = "FAILED";
						$passing_status_t = "FAILED";
						$passing_status_reason .= "Total theory is less then 108";
					}if($tot_practical_obt<100){
						$passing_status = "FAILED";
						$passing_status_p = "FAILED";
						$passing_status_reason .= "Total practical less then 25";
					}if($tot_obt<133){
						$passing_status = "FAILED";
						$passing_status_reason .= "Total is less then 133";
					}
					if($stu_abs == 0){
						$passing_status = "ABSENT";
						$passing_status_t = "ABSENT";
						$passing_status_p = "ABSENT";
					}
					if($tot_theory_obt == 0){
						$passing_status = "ABSENT";
						$passing_status_t = "ABSENT";
					}
					if($tot_practical_obt == 0){
						$passing_status = "ABSENT";
						$passing_status_p = "ABSENT";
					}
					if($row_t['theory_status'] == "FAILED" && $passing_status_t == "PASSED"){
						$passing_status_t = "INC";
					}
					if($row_t['practical_status'] == "FAILED" && $passing_status_p == "PASSED"){
						$passing_status_t = "INC";
					}
					
					
					
					$html .= '
						<td ><b>'.($tot_theory_obt==0?"Abs":$tot_theory_obt).'</b></td>
						
						<td ><b>'.($tot_practical_obt==0?"Abs":$tot_practical_obt).'</b></td>
						
						
						<td ><b>'.$row_t['theory_obt'].'</b> </td>
						<td ><b>'.$row_t['practical_obt'].'</b></td>
						
						<td ><b>2023</b></td>
						<td ><b>'.$row_t['exam_roll_no'].'</b></td>
						<td ><b>'.$grant_total_t.'</b></td>
						<td ><b>'.$passing_status_t.'</b></td>
						<td ><b>'.$grant_total_p.'</b></td>
						<td ><b>'.$passing_status_p.'</b></td>';	
						$b_paper = NULL;
						$sql_update = 'UPDATE exam_student_info SET 
						max_marks = "'.$tot_max.'",
						obt_marks = "'.$tot_obt.'",
						theory_obt = "'.$tot_theory_obt.'",
						theory_max = "300",
						practical_obt = "'.$tot_practical_obt.'",
						practical_max = "200",
						passing_status = "'.$passing_status.'",
						theory_status = "'.$passing_status_t.'",
						practical_status = "'.$passing_status_p.'",
						sgpa = "",
						grade_point = ""					
						WHERE sno = '.$row['id'];
						//$result_update = mysqli_query($db, $sql_update);
							//$result_update = mysqli_query($db, $sql_update);
						$html .= '
					</tr>
				</table>';
			}
//******************************* B.Ed 2nd Semester END ******************//				
//******************************* M.Ed 2nd Semester Start ******************//			
			elseif($row['course_name'] == 252){
				$sql="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' and exam_id=1";
						$row_t = mysqli_fetch_assoc(mysqli_query($db,$sql));
						$grant_total = $row_t['obt_marks'] + $tot_obt;
						$grant_max = $row_t['max_marks'] + $tot_max;
						$grant_pre_max = $row_t['theory_max'] + $row_t['practical_max'] ;
						//<td class="bord1"><b>THEORY</br>RESULT</b></td>
				$html .= '<table width="100%">
					<tr style="border:1px solid black">
						<td colspan="2" class="bord1"><b>TOTAL MARKS</b></td>
						<td class="bord1"><b>SUM TOTAL</b></td>
						<td colspan="3" class="bord1"><b>PREVIOUS DETAILS</b></td>
						<td class="bord1"><b>GRAND TOTAL</b></td>
						<td class="bord1" rowspan="2"><b>RESULT</b></td>
					</tr>
					<tr style="border:1px solid black">
						<td ><b>THEORY</br>300</br>108</b></td>';
						
						if($row['course_name'] == 252){
							$html .= '<td class="bord1"><b>PRAC/V.V</br>100</br>50</b></td>';
						}else{
							$html .= '<td ><b>50</br>25</b></td>';
						}
						
						//$html .= '<td ><b>PRAC/V.V</br>RESULT</b></td>';
						if($row['course_name'] == 252){
							$html .= '<td class="bord1"><b>400</br>158</b></td>';
						}else{
							$html .= '<td ><b>350</br>108</b></td>';
						}
						//<td ><b>Theory <br>'.$row_t['theory_max'].' </b></td>
						//<td ><b>Practical<br>'.$row_t['practical_max'].'</b></td>
						$html .= '
						<td ><b>TOTAL <br>'.$grant_pre_max.'<br></b></td>
						<td ><b>YEAR</b></td>
						<td ><b>ROLL-NO</b></td>
						<td class="bord1"><b>'.$grant_max.'</b></td>
					</tr>
					<tr>';
					if($tot_theory_obt<108){
						$passing_status = "FAILED";
						$passing_status_t = "FAILED";
						$passing_status_reason .= "Total theory is less then 108";
					}if($tot_practical_obt<25){
						$passing_status = "FAILED";
						$passing_status_p = "FAILED";
						$passing_status_reason .= "Total practical less then 25";
					}if($tot_obt<133){
						$passing_status = "FAILED";
						$passing_status_reason .= "Total is less then 133";
					}
					if($stu_abs == 0){
						$passing_status = "ABSENT";
						$passing_status_t = "ABSENT";
						$passing_status_p = "ABSENT";
					}
					if($row_t['passing_status'] == "FAILED" && $passing_status == "PASSED"){
						$passing_status == "INC";
					}else{
						$passing_status;
					}
					//<td ><b>'.($tot_theory_obt==0?"ABSENT":$passing_status_t).'</b></td>
					//<td ><b>'.($tot_practical_obt==0?"ABSENT":$passing_status_p).'</b></td>
					//<td ><b>'.$row_t['theory_obt'].'</b></td>
						//<td ><b>'.$row_t['practical_obt'].'</b></td>
					$html .= '
						<td ><b>'.($tot_theory_obt==0?"Abs":$tot_theory_obt).'</b></td>
						
						<td ><b>'.($tot_practical_obt==0?"Abs":$tot_practical_obt).'</b></td>
						
						<td ><b>'.($tot_obt==0?"Abs":$tot_obt).'</b></td>
						
						<td ><b>'.$row_t['obt_marks'].'</b></td>
						<td ><b>2023</b></td>
						<td ><b>'.$row_t['exam_roll_no'].'</b></td>
						<td ><b>'.$grant_total.'</b></td>
						<td ><b>'.($tot_obt==0?"ABSENT":$passing_status).'</b></td>
						
						';
						$b_paper = NULL;
						//echo $tot_theory_obt;
						
						$sql_update = 'UPDATE exam_student_info SET 
						max_marks = "'.$tot_max.'",
						obt_marks = "'.$tot_obt.'",
						theory_obt = "'.$tot_theory_obt.'",
						theory_max = "300",
						practical_obt = "'.$tot_practical_obt.'",
						practical_max = "100",
						passing_status = "'.$passing_status.'",
						theory_status = "'.$passing_status_t.'",
						practical_status = "'.$passing_status_p.'",
						sgpa = "",
						grade_point = ""					
						WHERE sno = '.$row['id'];
						//$result_update = mysqli_query($db, $sql_update);
						//$result_update = mysqli_query($db, $sql_update);
						$html .= '
					</tr>
				</table>';
			}
//******************************* M.Ed 2nd Semester END ******************//				
//******************************* B.Ed 3rd Semester Start ******************//	
			elseif($row['exam_id']=='3' && $row['course_name'] == 247){
				$erp_23 = mysqli_connect("p:localhost", "root", "mysql","knipsser_2023");
				$sql="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."'";
				$row_t = mysqli_fetch_assoc(mysqli_query($db,$sql));
				$sql = "SELECT 
							SUM(obt_marks) as obt_marks, 
							SUM(theory_obt) as theory_obt, 
							SUM(practical_obt) as practical_obt,
							SUM(max_marks) as max_marks,
							SUM(theory_max) as theory_max,
							SUM(practical_max) as practical_max
						FROM `exam_student_info` 
						WHERE `exam_roll_no` = '".$row['exam_roll_no']."' 
						AND exam_id IN ('1','2')";
				$row_23 = mysqli_fetch_assoc(mysqli_query($erp_23,$sql));
				$sql1 = "SELECT 
							passing_status,exam_roll_no,theory_status,practical_status
						FROM `exam_student_info` 
						WHERE `exam_roll_no` = '".$row['exam_roll_no']."' 
						AND exam_id IN ('1')";
				$first_row_23 = mysqli_fetch_assoc(mysqli_query($erp_23,$sql1));
				
				$sql2 = "SELECT 
							passing_status,exam_roll_no,practical_status,theory_status
						FROM `exam_student_info` 
						WHERE `exam_roll_no` = '".$row['exam_roll_no']."' 
						AND exam_id IN ('2')";
				$second_row_23 = mysqli_fetch_assoc(mysqli_query($erp_23,$sql2));
				//echo $row_23['theory_obt'];
				$grant_total = $row_23['obt_marks'] + $tot_obt;
				$grant_total_t = (float)$row_23['theory_obt'] + (float)$tot_theory_obt;
				$grant_total_p = $row_23['practical_obt'] + $tot_practical_obt;
				$grant_max = $row_23['max_marks'] + $tot_max;
				$grant_max_t = $row_23['max_marks'] + $tot_max;
				$grant_max_p = $row_23['max_marks'] + $tot_max;
				$grant_pre_max = $row_23['theory_max'] + $row_23['practical_max'] ;
				//<td class="bord1"><b>SUM TOTAL</b></td>
				$html .= '<table width="100%">
					<tr style="border:1px solid black">
						<td colspan="2" class="bord1"><b>TOTAL MARKS</b></td>
						
						<td colspan="4" class="bord1"><b>PREVIOUS DETAILS</b></td>
						<td class="bord1"><b>GRAND THEORY</b></td>
						<td class="bord1" rowspan="2"><b>RESULT / DIVISION</b></td>
						<td class="bord1"><b>GRAND PRACTICAL</b></td>
						<td class="bord1"  rowspan="2"><b>RESULT / DIVISION</b></td>
					</tr>
					<tr style="border:1px solid black">';
						if($row['course_name'] == 247){
							$html .= '<td ><b>THEORY</br>200</br>72</b></td>';
						}elseif($row['course_name'] == 253){
							$html .= '<td ><b>THEORY</br>300</br>108</b></td>';
						}else{
							$html .= '<td ><b>THEORY</br>200</br>72</b></td>';
						}
						//<td class="bord1"><b>THEORY</br>RESULT</b></td>
						if($row['course_name'] == 247){
							$html .= '<td class="bord1"><b>PRAC/V.V</br>50</br>25</b></td>';
						}elseif($row['course_name'] == 253){
							$html .= '<td class="bord1"><b>PRAC/V.V</br>50</br>25</b></td>';
						}elseif($row['course_name'] == 254){
							$html .= '<td class="bord1"><b>PRAC/V.V</br>100</br>50</b></td>';
						}else{
							$html .= '<td ><b>50</br>25</b></td>';
						}
						
						//$html .= '<td ><b>PRAC/V.V</br>RESULT</b></td>';
						// if($row['course_name'] == 246){
							// $html .= '<td class="bord1"><b>500</br>208</b></td>';
						// }elseif($row['course_name'] == 252){
							// $html .= '<td class="bord1"><b>400</br>158</b></td>';
						// }else{
							// $html .= '<td ><b>350</br>108</b></td>';
						// }
						//<td ><b>TOTAL <br>'.$grant_pre_max.'</b></td>
						$html .= '<td ><b>Theory <br>'.$row_23['theory_max'].' <br>216</b></td>
						<td ><b>Practical<br>'.$row_23['practical_max'].'<br>125</b></td>
						
						<td ><b>YEAR</b></td>
						<td ><b>ROLL-NO</b></td>';
						if($row['course_name'] == 247){
							$html .= '<td class="bord1"><b>800</br>288</b></td>';
						}elseif($row['course_name'] == 253){
							$html .= '<td class="bord1"><b>900</br>324</b></td>';
						}else{
							$html .= '<td ><b>50</br>25</b></td>';
						}
						if($row['course_name'] == 247){
							$html .= '<td class="bord1"><b>300</br>150</b></td>';
						}elseif($row['course_name'] == 253){
							$html .= '<td class="bord1"><b>200</br>100</b></td>';
						}else{
							$html .= '<td ><b>50</br>25</b></td>';
						}
					$html .= '</tr>
					<tr>';
					if($tot_theory_obt<72){
						$passing_status = "FAILED";
						$passing_status_t = "FAILED";
						$passing_status_reason .= "Total theory is less then 72";
					}if($tot_practical_obt<25){
						$passing_status = "FAILED";
						$passing_status_p = "FAILED";
						$passing_status_reason .= "Total practical less then 25";
					}if($tot_obt<133){
						$passing_status = "FAILED";
						$passing_status_reason .= "Total is less then 133";
					}
					if($stu_abs == 0){
						$passing_status = "ABSENT";
						$passing_status_t = "ABSENT";
						$passing_status_p = "ABSENT";
					}
					if ($first_row_23['theory_status'] == "FAILED" && $passing_status_t == "PASSED") {
						$passing_status_t = "INC";
					} elseif ($second_row_23['theory_status'] == "FAILED" && $passing_status_t == "PASSED") {
						$passing_status_t = "INC";
					}
					if ($first_row_23['practical_status'] == "FAILED" && $passing_status_p == "PASSED") {
						$passing_status_p = "INC";
					} elseif ($second_row_23['practical_status'] == "FAILED" && $passing_status_p == "PASSED") {
						$passing_status_p = "INC";
					}

					$html .= '
						<td ><b>'.($tot_theory_obt==0?"Abs":$tot_theory_obt).'</b></td>
						
						<td ><b>'.($tot_practical_obt==0?"Abs":$tot_practical_obt).'</b></td>
						
						
						<td ><b>'.$row_23['theory_obt'].'</b></td>
						<td ><b>'.$row_23['practical_obt'].'</b></td>
						
						<td ><b>2024</b></td>
						<td ><b>'.$row_t['exam_roll_no'].'</b></td>
						<td ><b>'.$grant_total_t.'</b></td>
						<td ><b>'.($tot_obt==0?"ABSENT":$passing_status_t).'</b></td>
						<td ><b>'.$grant_total_p.'</b></td>
						<td ><b>'.($tot_obt==0?"ABSENT":$passing_status_p).'</b></td>
						
						';
					$b_paper = NULL;
					$sql_update = 'UPDATE exam_student_info SET 
					max_marks = "'.$tot_max.'",
					obt_marks = "'.$tot_obt.'",
					theory_obt = "'.$tot_theory_obt.'",
					theory_max = "300",
					practical_obt = "'.$tot_practical_obt.'",
					practical_max = "50",
					passing_status = "'.$passing_status.'",
					theory_status = "'.$passing_status_t.'",
					practical_status = "'.$passing_status_p.'",
					sgpa = "",
					grade_point = ""					
					WHERE sno = '.$row['id'];
					//$result_update = mysqli_query($db, $sql_update);
					//$result_update = mysqli_query($db, $sql_update);
					$html .= '
					</tr>
				</table>';
			}
//******************************* B.Ed 3rd Semester END ******************//				
//******************************* M.Ed 3rd Semester Start ******************//	
			elseif($row['course_name'] == 253){
				$erp_23 = mysqli_connect("p:localhost", "root", "mysql","knipsser_2023");
				$sql="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."'";
				$row_t = mysqli_fetch_assoc(mysqli_query($db,$sql));
				$sql = "SELECT 
							SUM(obt_marks) as obt_marks, 
							SUM(theory_obt) as theory_obt, 
							SUM(practical_obt) as practical_obt,
							SUM(max_marks) as max_marks,
							SUM(theory_max) as theory_max,
							SUM(practical_max) as practical_max
						FROM `exam_student_info` 
						WHERE `exam_roll_no` = '".$row['exam_roll_no']."' 
						AND exam_id IN ('1','2')";


				$row_23 = mysqli_fetch_assoc(mysqli_query($erp_23,$sql));
				//echo $row_23['theory_obt'];
				$grant_total = $row_23['obt_marks'] + $tot_obt;
				$grant_total_t = (float)$row_23['theory_obt'] + (float)$tot_theory_obt;
				$grant_total_p = $row_23['practical_obt'] + $tot_practical_obt;
				$grant_max = $row_23['max_marks'] + $tot_max;
				$grant_max_t = $row_23['max_marks'] + $tot_max;
				$grant_max_p = $row_23['max_marks'] + $tot_max;
				$grant_pre_max = $row_23['theory_max'] + $row_23['practical_max'] ;
				//<td class="bord1"><b>SUM TOTAL</b></td>
				$html .= '<table width="100%">
					<tr style="border:1px solid black">
						<td colspan="2" class="bord1"><b>TOTAL MARKS</b></td>
						<td class="bord1"><b>SUM TOTAL</b></td>
						<td colspan="3" class="bord1"><b>PREVIOUS DETAILS</b></td>
						<td class="bord1"><b>GRAND TOTAL</b></td>
						<td class="bord1"  rowspan="2"><b>RESULT / DIVISION</b></td>
					</tr>
					<tr style="border:1px solid black">';
						$html .= '<td ><b>THEORY</br>300</br>108</b></td>';
						//<td class="bord1"><b>THEORY</br>RESULT</b></td>
						$html .= '<td class="bord1"><b>PRAC/V.V</br>50</br>25</b></td>';
						
						$html .= '<td class="bord1"><b>350</br>133</b></td>';
						//$html .= '<td ><b>PRAC/V.V</br>RESULT</b></td>';
						// if($row['course_name'] == 246){
							// $html .= '<td class="bord1"><b>500</br>208</b></td>';
						// }elseif($row['course_name'] == 252){
							// $html .= '<td class="bord1"><b>400</br>158</b></td>';
						// }else{
							// $html .= '<td ><b>350</br>108</b></td>';
						// }
						//<td ><b>TOTAL <br>'.$grant_pre_max.'</b></td>
						$html .= '<td ><b>Theory <br>'.$row_23['max_marks'].' </b></td>
						
						<td ><b>YEAR</b></td>
						<td ><b>ROLL-NO</b></td>';
						$html .= '<td class="bord1"><b>1100</b></td>';
					$html .= '</tr>
					<tr>';
					if($tot_theory_obt<108){
						$passing_status = "FAILED";
						$passing_status_t = "FAILED";
						$passing_status_reason .= "Total theory is less then 108";
					}if($tot_practical_obt<25){
						$passing_status = "FAILED";
						$passing_status_p = "FAILED";
						$passing_status_reason .= "Total practical less then 25";
					}if($tot_obt<133){
						$passing_status = "FAILED";
						$passing_status_reason .= "Total is less then 133";
					}
					if($stu_abs == 0){
						$passing_status = "ABSENT";
						$passing_status_t = "ABSENT";
						$passing_status_p = "ABSENT";
					}
					if($row_t['passing_status'] == "FAILED" && $passing_status_t == "PASSED"){
						$passing_status_t == "INC";
					}else{
						$passing_status_t;
					}
					if($row_t['passing_status'] == "FAILED" && $passing_status_p == "PASSED"){
						$passing_status_p == "INC";
					}else{
						$passing_status_p;
					}
					//<td ><b>'.($tot_theory_obt==0?"ABSENT":$passing_status_t).'</b></td>
					//<td ><b>'.($tot_practical_obt==0?"ABSENT":$passing_status_p).'</b></td>
					//<td ><b>'.($tot_obt==0?"Abs":$tot_obt).'</b></td>
					//<td ><b>'.$row_t['obt_marks'].'</b></td>
					$grand_total=$tot_theory_obt + $tot_practical_obt;
					$grand_total_all= $grand_total + $row_23['obt_marks'];
					$html .= '
						<td ><b>'.($tot_theory_obt==0?"Abs":$tot_theory_obt).'</b></td>
						
						<td ><b>'.($tot_practical_obt==0?"Abs":$tot_practical_obt).'</b></td>
						
						
						<td ><b>'.$grand_total.'</b></td>
						<td ><b>'.$row_23['obt_marks'].'</b></td>
						<td ><b>2024</b></td>
						<td ><b>'.$row_t['exam_roll_no'].'</b></td>
						<td ><b>'.$grand_total_all.'</b></td>
						<td ><b>'.($tot_obt==0?"ABSENT":$passing_status_p).'</b></td>
						
						';
					$b_paper = NULL;
					$sql_update = 'UPDATE exam_student_info SET 
					max_marks = "'.$tot_max.'",
					obt_marks = "'.$grand_total.'",
					theory_obt = "'.$tot_theory_obt.'",
					theory_max = "300",
					practical_obt = "'.$tot_practical_obt.'",
					practical_max = "50",
					passing_status = "'.$passing_status.'",
					theory_status = "'.$passing_status_t.'",
					practical_status = "'.$passing_status_p.'",
					sgpa = "",
					grade_point = ""					
					WHERE sno = '.$row['id'];
					//$result_update = mysqli_query($db, $sql_update);
						//$result_update = mysqli_query($db, $sql_update);
					$html .= '
					</tr>
				</table>';
			
			}
//******************************* M.Ed 3rd Semester END ******************//
//******************************* B.Ed 4th Semester Start ******************//	
			elseif($row['exam_id']=='4' && $row['course_name'] == 248){
				$erp_23 = mysqli_connect("p:localhost", "root", "mysql","knipsser_2023");
				$sql="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."'";
				$row_t = mysqli_fetch_assoc(mysqli_query($db,$sql));
				$exam_roll_no = $row['exam_roll_no'];

				// 1. Get total marks from exam_student_info
				$sql_sum = "SELECT 
								SUM(obt_marks) AS obt_marks, 
								SUM(theory_obt) AS theory_obt, 
								SUM(practical_obt) AS practical_obt,
								SUM(max_marks) AS max_marks,
								SUM(theory_max) AS theory_max,
								SUM(practical_max) AS practical_max
							FROM `exam_student_info` 
							WHERE `exam_roll_no` = '$exam_roll_no' 
							AND exam_id IN ('1','2')";

				$row_23 = mysqli_fetch_assoc(mysqli_query($erp_23, $sql_sum));

				// 2. Get passing_status for exam_id = 1
				$sql_status1 = "SELECT obt_marks, theory_obt, practical_obt,
            max_marks, theory_max, practical_max,
            passing_status  FROM `exam_student_info` 
								WHERE `exam_roll_no` = '$exam_roll_no' AND exam_id = '1'";
				$row_status1 = mysqli_fetch_assoc(mysqli_query($erp_23, $sql_status1));

				// 3. Get passing_status for exam_id = 2
				$sql_status2 = "SELECT obt_marks, theory_obt, practical_obt,
            max_marks, theory_max, practical_max,
            passing_status  FROM `exam_student_info` 
								WHERE `exam_roll_no` = '$exam_roll_no' AND exam_id = '2'";
				$row_status2 = mysqli_fetch_assoc(mysqli_query($erp_23, $sql_status2));

				// 4. Default set from main table
				$semesters[1]['passing_status'] = $row_status1['passing_status'] ?? '';
				$semesters[2]['passing_status'] = $row_status2['passing_status'] ?? '';

				// 5. If failed in exam 1, get data from back_exam_student_info
				if (isset($row_status1['passing_status']) && $row_status1['passing_status'] === 'FAILED') {
					$sql_back1 = "SELECT 
									obt_marks, theory_obt, practical_obt,
									max_marks, theory_max, practical_max, passing_status 
								  FROM back_exam_student_info 
								  WHERE exam_roll_no = '$exam_roll_no' AND exam_id = '01' LIMIT 1";
					$row_back1 = mysqli_fetch_assoc(mysqli_query($db, $sql_back1));

					if ($row_back1) {
						$semesters[1]['passing_status'] = $row_back1['passing_status'];
						// Optionally replace $row_23 values with back values for exam_id 1 if needed
					}
				}

				// 6. If failed in exam 2, get data from back_exam_student_info
				if (isset($row_status2['passing_status']) && $row_status2['passing_status'] === 'FAILED') {
					$sql_back2 = "SELECT 
									obt_marks, theory_obt, practical_obt,
									max_marks, theory_max, practical_max, passing_status 
								  FROM back_exam_student_info 
								  WHERE exam_roll_no = '$exam_roll_no' AND exam_id = '02' LIMIT 1";
					$row_back2 = mysqli_fetch_assoc(mysqli_query($db, $sql_back2));
					// echo $row_back2['obt_marks'];
					// echo $row_back2['theory_obt'];
					// echo $row_back2['practical_obt'];

					if ($row_back2) {
						$semesters[2]['passing_status'] = $row_back2['passing_status'];
						// Optionally replace $row_23 values with back values for exam_id 2 if needed
					}
				}

				// Debug
				//echo $semesters[1]['passing_status'] . "@@@@@" . $semesters[2]['passing_status'];

				
				
				
				$sql="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' AND exam_id IN ('3')";
				$row_odd = mysqli_fetch_assoc(mysqli_query($db,$sql));
				//echo $row_23['theory_obt'];
				$grant_total = $row_23['obt_marks'] + $tot_obt;
				$grant_total_t = (float)$row_23['theory_obt'] + (float)$tot_theory_obt + (float)$row_odd['theory_obt'];
				$grant_total_p = $row_23['practical_obt'] + $tot_practical_obt + (float)$row_odd['practical_obt'];
				$grant_max = $row_23['max_marks'] + $tot_max;
				$grant_max_t = $row_23['max_marks'] + $tot_max;
				$grant_max_p = $row_23['max_marks'] + $tot_max;
				$grant_pre_max = $row_23['theory_max'] + $row_23['practical_max'] ;
				
				
				//<td class="bord1"><b>SUM TOTAL</b></td>
				$html .= '<table width="100%">
					<tr style="border:1px solid black">
						<td colspan="2" class="bord1"><b>TOTAL MARKS</b></td>
						
						<td colspan="4" class="bord1"><b>PREVIOUS DETAILS</b></td>
						<td class="bord1"><b>GRAND THEORY</b></td>
						<td class="bord1" rowspan="2"><b>RESULT / DIVISION</b></td>
						<td class="bord1"><b>GRAND PRACTICAL</b></td>
						<td class="bord1"  rowspan="2"><b>RESULT / DIVISION</b></td>
					</tr>
					<tr style="border:1px solid black">';
						if($row['course_name'] == 248){
							$html .= '<td ><b>THEORY</br>200</br>72</b></td>';
						}elseif($row['course_name'] == 253){
							$html .= '<td ><b>THEORY</br>300</br>108</b></td>';
						}else{
							$html .= '<td ><b>THEORY</br>200</br>72</b></td>';
						}
						//<td class="bord1"><b>THEORY</br>RESULT</b></td>
						if($row['course_name'] == 248){
							$html .= '<td class="bord1"><b>PRAC/V.V</br>200</br>100</b></td>';
						}elseif($row['course_name'] == 253){
							$html .= '<td class="bord1"><b>PRAC/V.V</br>50</br>25</b></td>';
						}elseif($row['course_name'] == 254){
							$html .= '<td class="bord1"><b>PRAC/V.V</br>100</br>50</b></td>';
						}else{
							$html .= '<td ><b>50</br>25</b></td>';
						}
						
						//$html .= '<td ><b>PRAC/V.V</br>RESULT</b></td>';
						// if($row['course_name'] == 246){
							// $html .= '<td class="bord1"><b>500</br>208</b></td>';
						// }elseif($row['course_name'] == 252){
							// $html .= '<td class="bord1"><b>400</br>158</b></td>';
						// }else{
							// $html .= '<td ><b>350</br>108</b></td>';
						// }
						//<td ><b>TOTAL <br>'.$grant_pre_max.'</b></td>
						$html .= '<td ><b>Theory <br>800<br>288</b></td>
						<td ><b>Practical<br>300<br>150</b></td>
						
						<td ><b>YEAR</b></td>
						<td ><b>ROLL-NO</b></td>';
						if($row['course_name'] == 248){
							$html .= '<td class="bord1"><b>1000</br>360</b></td>';
						}elseif($row['course_name'] == 253){
							$html .= '<td class="bord1"><b>900</br>324</b></td>';
						}elseif($row['course_name'] == 254){
							$html .= '<td class="bord1"><b>900</br>324</b></td>';
						}else{
							$html .= '<td ><b>50</br>25</b></td>';
						}
						if($row['course_name'] == 248){
							$html .= '<td class="bord1"><b>500</br>250</b></td>';
						}elseif($row['course_name'] == 253){
							$html .= '<td class="bord1"><b>200</br>100</b></td>';
						}elseif($row['course_name'] == 254){
							$html .= '<td class="bord1"><b>100</br>50</b></td>';
						}else{
							$html .= '<td ><b>50</br>25</b></td>';
						}
					$html .= '</tr>
					<tr>';
					if($tot_theory_obt<72){
						$passing_status = "FAILED";
						$passing_status_t = "FAILED";
						$passing_status_reason .= "Total theory is less then 72";
					}if($tot_practical_obt<25){
						$passing_status = "FAILED";
						$passing_status_p = "FAILED";
						$passing_status_reason .= "Total practical less then 25";
					}if($tot_obt<133){
						$passing_status = "FAILED";
						$passing_status_reason .= "Total is less then 133";
					}
					if($stu_abs == 0){
						$passing_status = "ABSENT";
						$passing_status_t = "ABSENT";
						$passing_status_p = "ABSENT";
					}
					if($row_t['passing_status'] == "FAILED" && $passing_status_t == "PASSED"){
						$passing_status_t == "INC";
					}else{
						$passing_status_t;
					}
					if($row_t['passing_status'] == "FAILED" && $passing_status_p == "PASSED"){
						$passing_status_p == "INC";
					}else{
						$passing_status_p;
					}
					
					if($row_status1['passing_status']=="FAILED"){
						$pre_marks_t=$row_status2['theory_obt']+$row_back1['theory_obt']+$row_odd['theory_obt'];
						$pre_marks_p=$row_status2['practical_obt']+$row_back1['practical_obt']+$row_odd['practical_obt'];
					}elseif($row_status2['passing_status']=="FAILED"){
						$pre_marks_t=$row_status1['theory_obt']+$row_back2['theory_obt']+$row_odd['theory_obt'];
						$pre_marks_p=$row_status1['practical_obt']+$row_back2['practical_obt']+$row_odd['practical_obt'];	
					}else{
						$pre_marks_t=$row_23['theory_obt']+$row_odd['theory_obt'];
						$pre_marks_p=$row_23['practical_obt']+$row_odd['practical_obt'];	
					}
					$grant_total_th = $pre_marks_t + $tot_theory_obt;
					$grant_total_pra = $pre_marks_p + $tot_practical_obt;
					$passing_percent_t = $grant_total_th * 100 / 1000;
					if ($passing_percent_t >= 60) {
						$passing_status_th = "FIRST";
					} elseif ($passing_percent_t >= 48 && $passing_percent_t < 60) {
						$passing_status_th = "SECOND";
					} elseif ($passing_percent_t >= 36 && $passing_percent_t < 48) {
						$passing_status_th = "THIRD";
					} else {
						$passing_status_th = "FAIL";
					}

					echo $passing_percent_t;
					$passing_percent_pr = $grant_total_pra * 100 / 500;
					if ($passing_percent_pr >= 75) {
						$passing_status_pr = "FIRST";
					} elseif ($passing_percent_pr >= 60 && $passing_percent_pr < 75) {
						$passing_status_pr = "SECOND";
					} elseif ($passing_percent_pr >= 50 && $passing_percent_pr < 60) {
						$passing_status_pr = "THIRD";
					} else {
						$passing_status_pr = "FAIL";
					}



					
					$html .= '
						<td ><b>'.($tot_theory_obt==0?"Abs":$tot_theory_obt).'</b></td>
						
						<td ><b>'.($tot_practical_obt==0?"Abs":$tot_practical_obt).'</b></td>
						
						
						<td ><b>'.$pre_marks_t.'</b></td>
						<td ><b>'.$pre_marks_p.'</b></td>
						
						<td ><b>2024</b></td>
						<td ><b>'.$row_t['exam_roll_no'].'</b></td>
						<td ><b>'.$grant_total_th.'</b></td>
						<td ><b>'.($tot_obt==0?"ABSENT":$passing_status_th).'</b></td>
						<td ><b>'.$grant_total_pra.'</b></td>
						<td ><b>'.($tot_obt==0?"ABSENT":$passing_status_pr).'</b></td>
						
						';
					$total_max = "1500";
					$total_obt = $grant_total_th + $grant_total_pra;
					$b_paper = NULL;
					$sql_update = 'UPDATE exam_student_info SET 
					max_marks = "'.$total_max.'",
					obt_marks = "'.$total_obt.'",
					theory_obt = "'.$grant_total_th.'",
					theory_max = "1000",
					practical_obt = "'.$grant_total_pra.'",
					practical_max = "500",
					passing_status = "'.$passing_status_th.'",
					theory_status = "'.$passing_status_th.'",
					practical_status = "'.$passing_status_pr.'",
					sgpa = "",
					grade_point = ""					
					WHERE sno = '.$row['id'];
					$result_update = mysqli_query($db, $sql_update);
					//$result_update = mysqli_query($db, $sql_update);
					$html .= '
					</tr>
				</table>';
			}
//******************************* B.Ed 4th Semester END ******************//
//******************************* M.Ed 4th Semester Start ******************//	
			elseif($row['exam_id']=='4' && $row['course_name'] == 254){
				$erp_23 = mysqli_connect("p:localhost", "root", "mysql","knipsser_2023");
				$sql="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."'";
				$row_t = mysqli_fetch_assoc(mysqli_query($db,$sql));
				$sql = "SELECT 
							SUM(obt_marks) as obt_marks, 
							SUM(theory_obt) as theory_obt, 
							SUM(practical_obt) as practical_obt,
							SUM(max_marks) as max_marks,
							SUM(theory_max) as theory_max,
							SUM(practical_max) as practical_max
						FROM `exam_student_info` 
						WHERE `exam_roll_no` = '".$row['exam_roll_no']."' 
						AND exam_id IN ('1','2')";


				$row_23 = mysqli_fetch_assoc(mysqli_query($erp_23,$sql));
				$sql3 = "SELECT 
									obt_marks, theory_obt, practical_obt,
									max_marks, theory_max, practical_max, passing_status 
								  FROM exam_student_info 
								  WHERE exam_roll_no = '".$row['exam_roll_no']."' AND exam_id = '3' LIMIT 1";
					$row_pre = mysqli_fetch_assoc(mysqli_query($db, $sql3));
					$pre_total = $row_23['obt_marks'] + $row_pre['obt_marks'];
					$pre_max = $row_23['max_marks'] + $row_pre['max_marks'];
				//echo $row_23['theory_obt'];
				$grant_total = $row_23['obt_marks'] + $tot_obt;
				$grant_total_t = (float)$row_23['theory_obt'] + (float)$tot_theory_obt;
				$grant_total_p = $row_23['practical_obt'] + $tot_practical_obt;
				$grant_max = $row_23['max_marks'] + $tot_max;
				$grant_max_t = $row_23['max_marks'] + $tot_max;
				$grant_max_p = $row_23['max_marks'] + $tot_max;
				$grant_pre_max = $row_23['theory_max'] + $row_23['practical_max'] ;
				//<td class="bord1"><b>SUM TOTAL</b></td>
				$html .= '<table width="100%">
					<tr style="border:1px solid black">
						<td colspan="2" class="bord1"><b>TOTAL MARKS</b></td>
						<td class="bord1"><b>SUM TOTAL</b></td>
						<td colspan="3" class="bord1"><b>PREVIOUS DETAILS</b></td>
						<td class="bord1"><b>GRAND TOTAL</b></td>
						<td class="bord1"  rowspan="2"><b>RESULT / DIVISION</b></td>
					</tr>
					<tr style="border:1px solid black">';
						$html .= '<td ><b>THEORY</br>300</br>108</b></td>';
						//<td class="bord1"><b>THEORY</br>RESULT</b></td>
						$html .= '<td class="bord1"><b>PRAC/V.V</br>100</br>50</b></td>';
						
						$html .= '<td class="bord1"><b>400</br>158</b></td>';
						//$html .= '<td ><b>PRAC/V.V</br>RESULT</b></td>';
						// if($row['course_name'] == 246){
							// $html .= '<td class="bord1"><b>500</br>208</b></td>';
						// }elseif($row['course_name'] == 252){
							// $html .= '<td class="bord1"><b>400</br>158</b></td>';
						// }else{
							// $html .= '<td ><b>350</br>108</b></td>';
						// }
						//<td ><b>TOTAL <br>'.$grant_pre_max.'</b></td>
						
						$html .= '<td ><b>Theory <br>'.$pre_max.' </b></td>
						
						<td ><b>YEAR</b></td>
						<td ><b>ROLL-NO</b></td>';
						$html .= '<td class="bord1"><b>1500</b></td>';
					$html .= '</tr>
					<tr>';
					if($tot_theory_obt<108){
						$passing_status = "FAILED";
						$passing_status_t = "FAILED";
						$passing_status_reason .= "Total theory is less then 108";
					}if($tot_practical_obt<25){
						$passing_status = "FAILED";
						$passing_status_p = "FAILED";
						$passing_status_reason .= "Total practical less then 25";
					}if($tot_obt<133){
						$passing_status = "FAILED";
						$passing_status_reason .= "Total is less then 133";
					}
					if($stu_abs == 0){
						$passing_status = "ABSENT";
						$passing_status_t = "ABSENT";
						$passing_status_p = "ABSENT";
					}
					if($row_t['passing_status'] == "FAILED" && $passing_status_t == "PASSED"){
						$passing_status_t == "INC";
					}else{
						$passing_status_t;
					}
					if($row_t['passing_status'] == "FAILED" && $passing_status_p == "PASSED"){
						$passing_status_p == "INC";
					}else{
						$passing_status_p;
					}
					$grand_total=$tot_theory_obt + $tot_practical_obt;
					$grand_total_all= $grand_total + $pre_total;
					
					//echo $row_pre['obt_marks'];
					$html .= '
						<td ><b>'.($tot_theory_obt==0?"Abs":$tot_theory_obt).'</b></td>
						
						<td ><b>'.($tot_practical_obt==0?"Abs":$tot_practical_obt).'</b></td>
						
						
						<td ><b>'.$grand_total.'</b></td>
						<td ><b>'.$pre_total.'</b></td>
						<td ><b>2024</b></td>
						<td ><b>'.$row_t['exam_roll_no'].'</b></td>
						<td ><b>'.$grand_total_all.'</b></td>
						<td ><b>'.($tot_obt==0?"ABSENT":$passing_status_p).'</b></td>
						
						';
					$b_paper = NULL;
					$sql_update = 'UPDATE exam_student_info SET 
					max_marks = "'.$tot_max.'",
					obt_marks = "'.$grand_total.'",
					theory_obt = "'.$tot_theory_obt.'",
					theory_max = "300",
					practical_obt = "'.$tot_practical_obt.'",
					practical_max = "50",
					passing_status = "'.$passing_status.'",
					theory_status = "'.$passing_status_t.'",
					practical_status = "'.$passing_status_p.'",
					sgpa = "",
					grade_point = ""					
					WHERE sno = '.$row['id'];
					//$result_update = mysqli_query($db, $sql_update);
						//$result_update = mysqli_query($db, $sql_update);
					$html .= '
					</tr>
				</table>';
			
			}
//******************************* M.Ed 4th Semester END ******************//
			else{
					$html .= 'Contact Admin';
				}
				
		
			$html .= '</td>
		</tr>
	</table>';
	$total_obt = 0;
	$total_max = 0;	
	$total_grade_credit_erned_point = 0;
	$passing_status = 'PASSED';	
	$passing_status_t = 'PASSED';	
	$passing_status_p = 'PASSED';
	$passing_status_reason = 'EVERY THING FINE';
	$avg_credit = 0;
	$cocurricular_count = 0;
	$count_row = 0;	
	$final_result = array("html"=>$html, "data"=>$result_array);
	//print_r($backpaperArray);
	return $final_result;

}
?>