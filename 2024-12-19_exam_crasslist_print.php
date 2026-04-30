<?php //print 2112; die;
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg='';
$tabindex = $tab=1;
$responce = 0;

$start_time = microtime(true);


if(isset($_GET['back'])){
	unset($_POST['corsslist_course']);
	unset($_SESSION['corsslist_course']);
	$responce=0;
}
if(isset($_POST['submit']) && $_POST['submit']!=''){
	$_SESSION['corsslist_course'] = $_POST['corsslist_course'];
	$responce = 1;
}
if(isset($_SESSION['corsslist_course'])){
	$_POST['corsslist_course'] = $_SESSION['corsslist_course'];
	$responce=1;
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
								<h2 class="bg-primary text-white p-2">Cross-List</h2>
								<div class="row">
									 <div class=" col-md-4 ">
										<label>Course</label>
										<select name="corsslist_course" id="course" value="" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
												<option disabled <?php echo isset($_GET['id'])? "":' selected = "selected" '?>>---Select Course---</option>
												<?php 
												//$sql  = 'select distinct(course_name),class_detail.class_description from exam_student_info LEFT JOIN class_detail on exam_student_info.course_name = class_detail.sno ORDER BY class_detail.class_description';
												$sql  = 'select distinct(course_name),class_detail.class_description from exam_student_info LEFT JOIN class_detail on exam_student_info.course_name = class_detail.sno WHERE class_detail.crasslist_type = 0 ORDER BY class_detail.class_description';
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
<?php	
	break;
	}
	case 1:{				
if(isset($_POST['corsslist_course'])){
	$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`, `exam_id`, `student_info_sno`, `exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, `class_description` FROM `exam_student_info` 
	LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno 
	LEFT JOIN class_detail on class_detail.sno = course_name
	where exam_roll_no!="" and exam_roll_no is not null and `exam_student_info`.`course_name` = "'.$_POST['corsslist_course'].'" order by exam_roll_no';
	
	
	/*$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`, `exam_id`, `student_info_sno`, `exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, `class_description` FROM `exam_student_info` 
	LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno 
	LEFT JOIN class_detail on class_detail.sno = course_name
	where exam_roll_no!="" and exam_roll_no is not null and exam_id=1 order by course_name, exam_roll_no';*/
	
	
	$result = $summ_result =mysqli_query($db,$sql);
	
							
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
				$per_page = 10;
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
				echo '<div class="pagination"><ul><li><a href="exam_crasslist_print.php?back=1" class="text text-danger">Go Back |</a></li>';
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
										$sql_class = 'select * from class_detail where sno = "'.$_POST['corsslist_course'].'"';
										$row_class = mysqli_fetch_assoc(mysqli_query($db,$sql_class));
										//print_r($row);
									?>
									<div><b><?php echo $row_class['class_description']?>  Main Examination 2023-2024</b></div>
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
						//echo $_GET['page'];
						//echo $tpages;
						//if($_GET['page']!=$tpages){
						$i=1;
						for ($pgid = $start; $pgid < $end; $pgid++) {
							//print_r($row);
							if ($pgid == $total_results) {
								break;
							}
							mysqli_data_seek($result, $pgid);
							$row = mysqli_fetch_array($result);
							$i = $pgid+1;
							$cross_list = cross_list($row);
							echo $cross_list['html'].'<br>';
						}
						 
						/*   REPORT START  */
							if($_GET['page']==$tpages){
								mysqli_data_seek($result, 0);
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
								while($row = mysqli_fetch_assoc($summ_result)){
									
									$total_students++;
									$total_obt = 0;
									$total_max = 0;	
									$total_grade_credit_erned_point = 0;
									$passing_status = 'PASSED';	
									$passing_status_reason = 'CORRECT';
									$avg_credit = 0;
									$cocurricular_count = 0;
									
									$paperCodeArray = array();
									
									if($_POST['corsslist_course']==56){
										$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type = 'Major' THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type = 'Remedial' THEN 3 WHEN type = 'Non-Gradial' THEN 4 END"; 
									}else{
										$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type in ('Major', 'Core') THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type = 'Vocational' THEN 3 WHEN type = 'Cocurricular' THEN 4 END"; 
									}
									
									//echo $row['gender'].'  ';
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
									$stu_abs = 0;
									$stu_ufm = 0;
									while ($row2 = mysqli_fetch_assoc($result2)) {
										
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
												/*$sql4 = 'SELECT * FROM `exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" && paper_code = "'.$student_paper.'"';
												//echo $sql4.'#<br>';
												$result4 =mysqli_query($db,$sql4);
												$row2=mysqli_fetch_assoc($result4);*/
												
												if (!in_array($paperCode, $paperCodeArray)) {
													$paperCodeArray[] = $paperCode;
														
														if($row2['theory_practical']=="Theory"){
															$theory_marks_max=$row2['pt_marks_max'];
															$theory_marks_obt=$row2['pt_marks_obt'];
															$mid_marks_max=$row2['mid_sem_marks_max'];
															$mid_marks_obt=$row2['mid_sem_marks_obt'];
															$practical_marks_max='';
															$practical_marks_obt='';
														}
														if($row2['theory_practical']=="Practical"){
															$practical_marks_max=$row2['pt_marks_max'];
															$practical_marks_obt=$row2['pt_marks_obt'];
															$theory_marks_max='';
															$theory_marks_obt='';
															$mid_marks_max='';
															$mid_marks_obt='';
														}
														if($row2['type']=="Elective"||"Common"){
															if($row2['theory_practical']=="Practical"){
																$practical_marks_max='';
																$practical_marks_obt='';
																$theory_marks_max=$row2['pt_marks_max'];
																$theory_marks_obt=$row2['pt_marks_obt'];
																$mid_marks_max=$row2['mid_sem_marks_max'];
																$mid_marks_obt=$row2['mid_sem_marks_obt'];
															}
														}
														if($row2['theory_practical']=="Viva-voce"){
															$practical_marks_max=$row2['pt_marks_max'];
															$practical_marks_obt=$row2['pt_marks_obt'];
															$theory_marks_max='';
															$theory_marks_obt='';
															$mid_marks_max='';
															$mid_marks_obt='';
														}
														if($row2['theory_practical']=="Theory+ Practical"){
															$practical_marks_max='';
															$practical_marks_obt='';
															$theory_marks_max=$row2['pt_marks_max'];
															$theory_marks_obt=$row2['pt_marks_obt'];
															$mid_marks_max=$row2['mid_sem_marks_max'];;
															$mid_marks_obt=$row2['mid_sem_marks_obt'];;
														}
														if($row2['theory_practical']=="Theory+Practical"){
															$practical_marks_max='';
															$practical_marks_obt='';
															$theory_marks_max='';
															$theory_marks_obt='';
															$mid_marks_max='';
															$mid_marks_obt='';
														}
														if($practical_marks_obt=='Abs'){
															$stu_abs = 1;
														}elseif($theory_marks_obt=='Abs'){
															$stu_abs = 1;
														};
														if($practical_marks_obt=='Ufm'){
															$stu_ufm = 1;
														}elseif($theory_marks_obt=='Ufm'){
															$stu_ufm = 1;
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
														if(is_numeric($row2['credit'])){
															$credit_paper_t = $row2['credit'];
														}else{
															$a = $row2['credit'];
															list($a1, $a2) = explode("+", $a);

															$credit_paper_t = $a1;
															if($row2['theory_practical']=="Practical"){
																$credit_paper_t = $a2;
															}
														}
														//$credit_paper_t = $row2['credit'];
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

														if($row2['type_status']==1){
															$sql_subject = 'select * from add_subject where sno = "'.$row2['subject_id'].'"';
														}else{
															$sql_subject = 'select * from add_subject2 where sno = "'.$row2['subject_id'].'"';
														}
														$row_subject = mysqli_fetch_assoc(mysqli_query($db,$sql_subject));

														if($row2['type']=='Cocurricular'){
															$credit_paper_t = 'NC';
															$earned_credit_t = 'NC';
															$grade_erned_t = 'NA';
															$grade_credit_erned_t = 'NA';
															$cocurricular_count++;
														}
														
														if($row2['type']!='Cocurricular'){
															
															
															$tot_course_credit += (float)$credit_paper_t;
															$tot_obt_credit += (float)$total_obt_t;
															$tot_mid_max += (float)$mid_marks_max;
															$tot_mid_obt += (float)$mid_marks_obt;
															$tot_theory_max += (float)$theory_marks_max;
															$tot_theory_obt += (float)$theory_marks_obt;
															$tot_prac_max += (float)$practical_marks_max;
															$tot_prac_obt += (float)$practical_marks_obt;
														
														
																if($row2['type']=='Non-Gradial'){
																		//echo '<td>'.$practical_marks_max_num_t.'</td>';
																		//echo '<td></td>';
																		//echo '<td>'.$practical_marks_obt_num_t.'</td>';
																}
																else{
																	$total_max_sub = ((float)$theory_marks_max+(float)$mid_marks_max);
																	}
																if($row2['type']=='Vocational'){
																	$total_grade_credit_erned_point += (!isset($row3['practical_paper_code']))?$grade_credit_erned_t:0;
																	
																}
																else{
																	$total_grade_credit_erned_point += $grade_credit_erned_t;
																	if($mid_marks_obt=='Abs' AND $theory_marks_obt=='Abs'){
																		//$stu_abs = 1;
																			//echo '<td>Abs</td>';
																	}else{
																		//echo '<td>'.$total_obt_t.'</td>';
																	}
																}			
															$total_max += $total_max_t;
															$total_obt += $total_obt_t;
													
															$mid_marks_obt_passing_chk = is_numeric($mid_marks_obt) ? $mid_marks_obt: 0;
															$theory_marks_obt_passing_chk = is_numeric($theory_marks_obt) ? $theory_marks_obt: 0;
															$practical_marks_obt_passing_chk = is_numeric($practical_marks_obt) ? $practical_marks_obt: 0;
													
															if($passing_status == 'PASSED'){
																
																if($row2['type']!='Vocational'){
																	if($total_max_sub!=0 && $total_max_sub!=NULL){
																	$percentage_t = percentage_marks($total_obt_t,$total_max_sub);
																		if($percentage_t<33){
																			$passing_status = 'FAILED';
																			$passing_status_reason = 'TOTAL MARKS <33';
																		}
																	}
																	if($total_max_t!=0){
																		if($grade_erned_t<4){
																		$passing_status = 'FAILED';
																		$passing_status_reason = 'Grade <4';
																		}
																	}
																}
															}
															else{
																$passing_status = 'FAILED';
															}
														}else{
															$show_total = 1;
																
															if($theory_marks_obt == 'Abs'){
																$stu_abs = 1;
																//echo 'F';
																$passing_status = 'FAILED';
															}
															elseif (percentage_marks($total_obt_t, ((float)$theory_marks_max+(float)$mid_marks_max))>=33){
																//echo 'Q';
															}
															else{
																//echo 'F';
															};
															if($total_max_t!=0 && $total_max_t!=NULL){
																$percentage_t_c = percentage_marks($total_obt_t,$total_max_t);
																if($percentage_t_c<33){
																	$passing_status_reason = 'Cocurricular MARKS <33';
																}
															}
														}
												}
												
												////CHECK
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
															if($practical_marks_obt_p=='Abs'){
																$stu_abs = 1;
															}elseif($theory_marks_obt_p=='Abs'){
																$stu_abs = 1;
															};
															if($practical_marks_obt_p=='Ufm'){
																$stu_ufm = 1;
															}elseif($theory_marks_obt_p=='Ufm'){
																$stu_ufm = 1;
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
															
																if($row2['type_status']==1){
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
															
															
															if($row5['type']=='Vocational'){
																$earned_credit_p_t = $earned_credit_t+$earned_credit_p;
																$grade_erned_p_t = calculate_grade($tot_sub_pract_theo,$total_max_pract_theo);
																$grade_credit_erned_p_t = ((float)$earned_credit_p_t*(float)$grade_erned_p_t);
																$total_grade_credit_erned_point +=$grade_credit_erned_p_t;
															}else {
																$total_grade_credit_erned_point +=$grade_credit_erned_p;
															}
															$total_max += $total_max_p;
															$total_obt += $total_obt_p;		
															
															if($passing_status == 'PASSED'){
															
																if($total_max_pract_theo!=0 && $total_max_pract_theo!=NULL){
																$percentage_t = percentage_marks($tot_sub_pract_theo,$total_max_pract_theo);
																	if($percentage_t<33){
																		$passing_status = 'FAILED';
																		$passing_status_reason = 'TOTAL MARKS <33';
																	}
																}
																if($total_max_p!=0){
																	if($grade_erned_p<4){
																		$passing_status = 'FAILED';
																		$passing_status_reason = 'Grade <33';
																	}
																}
															}
															else{
																$passing_status = 'FAILED';
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
															
															$total_credit = ($credit_paper_t+$credit_paper_p);
									
														}
													}
												}
											}
										
										
										$total_rows_count = ($count_row-1-($cocurricular_count));
										if($total_rows_count!=0){
											$avg_credit_grade = ($total_grade_credit_erned_point/$tot_course_credit);
										}else{
											$avg_credit_grade = 0;
										}
											
										$avg_credit = number_format($avg_credit_grade, 2);
										
									}		
									    /*
										if($row['gender']=='M'){
											$total_male_students++;
											if($passing_status == 'PASSED'){
												$total_male_passed_students++;
												$div_perc = percentage_marks($total_obt,$total_max);
												if ($div_perc >= 60) {
													$total_male_first_div_students++;
												} elseif ($div_perc > 50 && $div_perc <= 60) {
													$total_male_second_div_students++;
												} elseif ($div_perc > 30 && $div_perc <= 50) {
													$total_male_third_div_students++;
												}
											}elseif($passing_status == 'FAILED'){
												$total_male_failed_students++;
											}
											if($stu_abs == 1){
											$total_male_abs_students++;
											}
										}elseif($row['gender']=='F'){
											$total_female_students++;
											if($passing_status == 'PASSED'){
												$total_female_passed_students++;
												$div_perc = percentage_marks($total_obt,$total_max);
												if ($div_perc >= 60) {
													$total_female_first_div_students++;
												} elseif ($div_perc > 50 && $div_perc <= 60) {
													$total_female_second_div_students++;
												} elseif ($div_perc > 30 && $div_perc <= 50) {
													$total_female_third_div_students++;
												}
											}elseif($passing_status == 'FAILED'){
												$total_female_failed_students++;
											}
											if($stu_abs == 1){
											$total_female_abs_students++;
											}
										}
										*/
										
										if($passing_status=='PASSED'){
											$total_passed_students++;
											/*
											$div_perc = percentage_marks($total_obt,$total_max);
											if ($div_perc >= 60) {
												$total_first_div_pass++;
											} elseif ($div_perc > 50 && $div_perc <= 60) {
												$total_second_div_pass++;
											} elseif ($div_perc > 30 && $div_perc <= 50) {
												$total_third_div_pass++;
											}
											*/
										}
										/*elseif($passing_status=='FAILED'){
											 $total_failed_students++;
										 }
										 */
										if($stu_abs == 1){
											$total_abs_students++;
										}
										if($stu_ufm == 1){
											$total_ufm_students++;
										}
										//echo $row['exam_roll_no'].'/'.$total_obt.'/'.$total_max.'/'.$avg_credit.'/'.$passing_status.'</br>';	
										$avg_credit = number_format($avg_credit_grade, 2);
										$total_grade_credit_erned_point = 0;
										$total_max = 0;
										$total_obt = 0;
										$avg_credit = 0;
										$count_row = 0;
										$total_rows_count = 0;
										$passing_status = 'PASSED';
										$passing_status_reason = 'Correct';
								}	
								
									
										
										?>
										
										<div class="container mt-1">
											<table width="100%" class="table table-bordered mb-5" style="border:1px solid black;">
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
<?php 
	//echo microtime(true)-(float)$start_time.'####';
	break;
}
} ?>

<?php

include'all_queries.php';
?>