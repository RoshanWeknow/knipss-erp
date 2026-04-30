<?php
$start = microtime(true);
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg='';
$tab=1;
$responce = 0;
if(isset($_GET['back'])){
	unset($_POST['corsslist_course_ag']);
	unset($_SESSION['corsslist_course_ag']);
	$responce=0;
}
if(isset($_POST['submit']) && $_POST['submit']!=''){
	$_SESSION['corsslist_course_ag'] = $_POST['corsslist_course_ag'];
		$responce = 1;
}
if(isset($_SESSION['corsslist_course_ag'])){
	$_POST['corsslist_course_ag'] = $_SESSION['corsslist_course_ag'];
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
						<h2 class="bg-primary text-white p-2">Cross-List (AG)</h2>
						<div class="row">
							 <div class=" col-md-4 ">
								<label>Course</label>
								<select name="corsslist_course_ag" id="course" value="" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
									<option disabled selected>---Select Course---</option>
									<?php 
									$sql  = 'select distinct(course_name),class_detail.class_description from exam_student_info LEFT JOIN class_detail on exam_student_info.course_name = class_detail.sno WHERE class_detail.crasslist_type = 1 ORDER BY class_detail.class_description';
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
if(isset($_POST['corsslist_course_ag'])){
	$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`student_type`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender` FROM `exam_student_info` LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno where exam_roll_no!="" and exam_roll_no is not null and `exam_student_info`.`course_name` = "'.$_POST['corsslist_course_ag'].'" order by exam_roll_no';
	
	$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`student_type`, `exam_id`, `student_info_sno`, `exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, class_detail.category as category, `class_description` FROM `exam_student_info` 
	LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno 
	LEFT JOIN class_detail on class_detail.sno = course_name
	where exam_roll_no!="" and exam_roll_no is not null and `exam_student_info`.`course_name` = "'.$_POST['corsslist_course_ag'].'" order by exam_roll_no';
	
	$sql = '(SELECT "regular" as exam_type, `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`, `exam_id`,`student_type`, `student_info_sno`, `exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, class_detail.category as category, `class_description` FROM `exam_student_info` LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno LEFT JOIN class_detail on class_detail.sno = course_name where exam_roll_no!="" and exam_roll_no is not null and `exam_student_info`.`course_name` = "'.$_POST['corsslist_course_ag'].'")

union all 

(SELECT "back" as exam_type, `back_exam_student_info`.`sno` as id,`back_exam_student_info`.`student_name`,`back_exam_student_info`.`exam_roll_no`, `exam_id`,`student_type`, `student_info_sno`, `back_exam_student_info`.`dob`,`back_exam_student_info`.`uin_no`,`back_exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`,  class_detail.category as category,`class_description` FROM `back_exam_student_info` LEFT JOIN `student_info` ON `back_exam_student_info`.student_info_sno = `student_info`.sno LEFT JOIN class_detail on class_detail.sno = course_name where exam_roll_no!="" and exam_roll_no is not null and `back_exam_student_info`.`course_name` = "'.$_POST['corsslist_course_ag'].'")

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
                .fixedallpage {
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                }
            
                .noprint {
                    display: none;
                }
                
            
                td {
                    border: 0px !important;
                    text-align: center;
                    font-size: 10px;
                }
            
                th {
                    border: 0px !important;
                    font-size: 10px;
                }
            
                @page {
                    size: A3 landscape;
                    margin-top: 40mm;
                }
            
                body {
                    counter-reset: page;
                }
            
                header {
                    display: none; /* Hide header when printing */
                }
            
                footer {
                    position: fixed;
                    bottom: 0;
                    width: 100%;
                    text-align: center;
                    font-size: 15px;
                }
            
                footer::after {
                    content: "Page " counter(page);
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
				echo '<div class="pagination"><ul><li><a href="exam_crasslist_print_ag.php?back=1">Back</a></li>';
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
								<div class="noprint"><h4 class="" style="text-align: center; margin:0px; " ><span ><b>Kamla Nehru Institute Of Physical &amp; Social Sciences,Sultanpur, Uttar Pradesh</b></span> <br><span style="font-size:1.3rem;">An Autonomous Institute And Accredited "A" Grade by NAAC</span></h4></div>
								<div class="d-flex">
									<?php
										$sql_class = 'select * from class_detail where sno = "'.$_POST['corsslist_course_ag'].'"';
										$row_class = mysqli_fetch_assoc(mysqli_query($db,$sql_class));
										//print_r($row_class);
									?>
									<div><b><?php echo $row_class['class_description']?><?php //echo $row_class['sno']?>  Main Examination <?php
										$db_year = substr($_SESSION['db_name'], -4);
										$next_year = $db_year + 1;
										echo $db_year . "-" . $next_year;
										?></b></div>
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
						for ($pgid = $start; $pgid < $end; $pgid++) {
								
							if ($pgid == $total_results) {
								break;
							}
							mysqli_data_seek($result, $pgid);
							$row = mysqli_fetch_array($result);
							$i = $pgid+1;
							$cross_list = cross_list_ag($row);
							echo $cross_list['html'];

						}
						 mysqli_data_seek($result, 0);
					//}	
						
						/*   REPORT START  */
							if($_GET['page']==$tpages){
			$total_students = 0;
			$total_passed_students = 0;
			$total_abs_students = 0;
			$total_ufm_students = 0;
			$total_appered_students = 0;
			echo '<div class="text-center" style="font-size:13px;"><b>SUMMARY</b></div>';
			// while($row = mysqli_fetch_assoc($result)){
				// $total_students++;
				// $paperCodeArray = array();
				// $sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."'"; 
				// $result2 = mysqli_query($db, $sql2);
				// $i = 1;
				// $total_obt = 0;
				// $total_max = 0;	
				// $passing_status = "PASSED";	
				// $stu_abs = 0;
				// while($row2 = mysqli_fetch_assoc($result2)){
					// if($row2['pt_marks_obt']<36){
						// $passing_status = "FAILED";
					// }
					// if($row2['pt_marks_obt']!="Abs"){
						// $stu_abs = 1;
					// }
					// $total_obt+=(float)$row2['pt_marks_obt'];
				// }
				// if($total_obt<315){
					// $passing_status = "FAILED";
				// }
				// if($passing_status == "PASSED"){
					// $total_passed_students++;
				// }
				// if($stu_abs == 0){
					// $total_abs_students++;
				// }
			// }
			$sql2 = "
					SELECT 
						COUNT(*) AS total_students,
						SUM(CASE WHEN passing_status = 'ABSENT'  THEN 1 ELSE 0 END) AS total_abs_theory,
						SUM(CASE WHEN passing_status = 'PASSED' THEN 1 ELSE 0 END) AS total_pass_theory,
						SUM(CASE WHEN passing_status = 'FAILED' THEN 1 ELSE 0 END) AS total_failed_theory,
						SUM(CASE WHEN passing_status = 'INC' THEN 1 ELSE 0 END) AS total_inc__theory,
						SUM(CASE WHEN passing_status = 'UFM' THEN 1 ELSE 0 END) AS total_ufm_theory
					FROM exam_student_info
					WHERE course_name = '".$_POST['corsslist_course_ag']."' AND verify_status='1';
				";
//echo $_POST['corsslist_course'];
				$result = mysqli_query($db, $sql2);
				$result_row = mysqli_fetch_assoc($result); // Fetch as associative array
				$apperred_stu = $result_row['total_students'] - ($result_row['total_abs_theory']);
		?>
		
			<table width="100%" class="table table-bordered" style="border:1px solid black;">
				<tr class="text-center">
					<th width="16%" > </th>
					<th width="13%" class="report_border">REGISTERED</th>
					<th width="12%" class="report_border">ABSENT</th>
					<th width="12%" class="report_border">APPEARED</th>
					<th width="9%" class="report_border">PASS</th>
					<th width="9%" class="report_border">FAIL</th>
					<th width="9%" class="report_border">UFM</th>
					<th width="9%" class="report_border">INC</th>
				</tr>
				<tr>
					<th  class="report_border"><?php echo $row_class['class_description']?></th>
					<td class="report_border"><?php  echo $result_row['total_students']; ?> </td>
					<td class="report_border"><?php  echo $result_row['total_abs_theory']; ?></td>
					<td  class="report_border"><?php  echo $apperred_stu; ?></td>
					<td class="report_border"><?php  echo $result_row['total_pass_theory']; ?></td>
					<td class="report_border"><?php  echo $result_row['total_failed_theory']; ?></td>
					
					<td class="report_border"><?php  echo $result_row['total_ufm_theory']; ?></td>
					<td class="report_border"><?php  echo $result_row['total_inc__theory']; ?></td>
				</tr>
			</table>
		<?php
		}
		?>
											<div class="" style="display:flex;justify-content:space-between;font-size:13px;">
												<div><b>DATE OF RESULT DECLRATION :  <?php echo date("d-m-Y"); ?></b></div>
												<div><b>SIGNATURE OF CONTROLLER OF EXAMS :</b></div>
												<div><b>CO-ORDINATOR :</b></div>
											</div>
										</div>
													
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
$end = microtime(true);
//echo ($end-$start)/1000;
?>