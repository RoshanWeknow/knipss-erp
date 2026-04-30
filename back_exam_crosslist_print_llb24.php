<?php
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg='';
$tab=1;
$responce = 0;
if(isset($_GET['back'])){
	unset($_POST['corsslist_course_llb']);
	unset($_SESSION['corsslist_course_llb']);
	$responce=0;
}
if(isset($_POST['submit']) && $_POST['submit']!=''){
	$_SESSION['corsslist_course_llb'] = $_POST['corsslist_course_llb'];
		$responce = 1;
}
if(isset($_SESSION['corsslist_course_llb'])){
	$_POST['corsslist_course_llb'] = $_SESSION['corsslist_course_llb'];
		$responce = 1;
}

function insertPaper($paperCode, $paperTitle, &$papersArray) {
    $index = (count($papersArray) + 1);
    $newPaper = array("paper_code" => $paperCode, "title_of_paper" => $paperTitle);
    $papersArray[$index] = $newPaper;
}
function fetchPapersfororder($papersArray) {
    foreach ($papersArray as $index => $paper) {
        echo $paper['paper_code'];
    }
}
function fetchPapers($papersArray) {
    $counter = 0;
    foreach ($papersArray as $index => $paper) {
        echo  $index.".&nbsp;&nbsp;".$paper['title_of_paper'] . "&nbsp;&nbsp; (" . $paper['paper_code'].")&nbsp;&nbsp;";
        $counter++;
        if ($counter % 6 == 0) {
            echo "<br>";
        } else {
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
    }
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
						<h2 class="bg-primary text-white p-2">Cross-List (LLB)</h2>
						<div class="row">
							 <div class=" col-md-4 ">
								<label>Course</label>
								<select name="corsslist_course_llb" id="course" value="" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
									<option disabled selected>---Select Course---</option>
									<?php 
									$sql  = 'select distinct(course_name),class_detail.class_description from back_exam_student_info LEFT JOIN class_detail on back_exam_student_info.course_name = class_detail.sno WHERE class_detail.crasslist_type = 3 ORDER BY class_detail.class_description';
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
if(isset($_POST['corsslist_course_llb'])){
	$sql = 'SELECT `back_exam_student_info`.`sno` as id, back_exam_student_info.student_info_sno ,`back_exam_student_info`.`student_name`,`back_exam_student_info`.`exam_roll_no`,`back_exam_student_info`.`dob`,`back_exam_student_info`.`exam_id`,`back_exam_student_info`.`uin_no`,`back_exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender` FROM `back_exam_student_info` LEFT JOIN `student_info` ON `back_exam_student_info`.student_info_sno = `student_info`.sno where exam_roll_no!="" and exam_roll_no is not null and `back_exam_student_info`.`course_name` = "'.$_POST['corsslist_course_llb'].'" order by exam_roll_no';
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
					font-size: 13px;
					}
				th{
					border:0px  !important;
					font-size: 13px;
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
				font-size: 13px;
			}
			th{
				border:0px  !important;
				font-size: 13px;
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
				echo '<div class="pagination"><ul><li><a href="exam_crasslist_print_llb.php?back=1">Back</a></li>';
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
										$sql_class = 'select * from class_detail where sno = "'.$_POST['corsslist_course_llb'].'"';
										$row_class = mysqli_fetch_assoc(mysqli_query($db,$sql_class));
										//print_r($row_class);
						
									?>
									<div><b><?php echo $row_class['class_description']?><?php //echo $row_class['sno']?>   Main Examination 2024</b></div>
									<div style="margin-left:20px;">Ex-Student</div>
									<div style="margin-left:100px;"></div>
								</div>
							</div>
						</td>
					</tr>
				</thead>
			</table>
			
			<table width="100%">
				<tr style="border:1px solid black;border-style: ;">
					<td width="9%" class="border border-dark"><b>ROLL NO</b></td>
					<td width="15%" class="text-start ps-5"><b>NAME OF THE CANDIDATE & </br> FATHER NAME</b></td>
					<td width="6%" class="border border-dark"><b>PAPER I<br>100</br>36</b></td>
					<td width="6%" class="border border-dark"><b>PAPER II<br>100</br>36</b></td>
					<td width="6%" class="border border-dark"><b>PAPER III<br>100</br>36</b></td>
					<td width="6%" class="border border-dark"><b>PAPER IV<br>100</br>36</b></td>
					<td width="6%" class="border border-dark"><b>PAPER V<br>100</br>36</b></td>
					<td width="6%" class="border border-dark"><b>PAPER VI<br>100</br>36</b></td>
					<td width="6%" class="border border-dark"><b>PAPER VII<br>100</br>36</b></td>
					<td width="6%" class="border border-dark"><b>TOTAL</br>700<br>315</b></td>
					
					<?php 
					$row = mysqli_fetch_array($result);
					if($row['exam_id']==2){
					
					 ?>
						<td width="16%" class="border border-dark">
						<table width="100%" class="bolder">
							<tr>
								<td colspan="3"><b>DETAIL OF LLB I SEMESTER</b><td>
							</tr>
							<tr>
								<td ><b>TOTAL</b><td>
								<td ><b>YEAR</b><td>
								<td ><b>ROLL-NO</b><td>
							</tr>
						</table>
					</td>
					<td width="6%" class="border border-dark"><b>GRANT</br>TOTAL<br></b></td>
					<?php }?>
					
					<td width="6%" class="border border-dark"><b>RESULT</b></td>
				</tr>
			</table>	
			<div class="topmargin" style="">
				<?php
				$papers = array();
				$i=1;
				for ($pgid = $start; $pgid < $end; $pgid++) {
					if ($pgid == $total_results) {
						break;
					}
					mysqli_data_seek($result, $pgid);
					$row = mysqli_fetch_array($result);
					$i = $pgid+1;
					$total_obt = 0;
					$total_max = 0;	
					$passing_status = 'PASSED';	
					$passing_status_reason = 'EVERY THING FINE';
					$avg_credit = 0;
					$cocurricular_count = 0;
					$count_row = 0;
					$show_total=0;
					$total_abs = 0;
				?>	
				<table width="100%">
					<tr style="border:1px solid black;border-style: ;">
						<td width="9%"><?php echo $row['exam_roll_no']; ?><?php //echo $row['dob']; ?></td>
						<td width="15%" class="text-start ps-5" ><?php echo $row['student_name']; ?><?php //echo $row['id']; ?></br><?php echo $row['father_name']; ?></td>
						<?php
							if(empty($papers)){
								$sql_paper_save = 'select * from back_exam_student_paper_info where exam_student_info_sno = "'.$row['id'].'"';
								$result_paper_save = mysqli_query($db, $sql_paper_save);
								while($row_paper_save = mysqli_fetch_assoc($result_paper_save)){
									insertPaper($row_paper_save['paper_code'], $row_paper_save['title_of_paper'], $papers);
								}
							}
							$paperCodeArray = array();
							$sql2 = "SELECT * FROM back_exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."'"; 
						
							$result2 = mysqli_query($db, $sql2);
							$i = 1;
							while($row2 = mysqli_fetch_assoc($result2)){
							 $i++;
						?>
								<td width="6%"><?php echo $row2['pt_marks_obt']; ?></td>
						<?php
								if($row2['pt_marks_obt']!='Abs'){
									$total_abs = 1;
								}
								if($row2['pt_marks_obt']<36){
									$passing_status = "FAILED";
									$passing_status_reason = "Marks less then 36 in paper - ".$i;
								}
								$total_obt+=(float)$row2['pt_marks_obt'];
								$total_max+=(float)$row2['pt_marks_max'];
							}
								if($total_obt<315){
									$passing_status = "FAILED";
									$passing_status_reason = "Total OBT less then 315";
								}
							if($total_abs == 0){
								$passing_status = "ABSENT";
							}	
						?>
						<td width="6%"><?php 
							if($total_obt == 0){
								echo "Abs";
							}else{
								echo $total_obt;
							}
						
						?></td>
						<?php 
							$grant_total = $total_obt;
							if($row['exam_id']==2){
					
						?>
						<td width="16%" style="position:relative; left:28px;">
							<table width="100%" align="center">
								<tr>
								<?php
								$sql="SELECT *  FROM `back_exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' and exam_id=1";
								$row_t = mysqli_fetch_assoc(mysqli_query($db,$sql));
								$grant_total = $row_t['obt_marks'] + $total_obt;
								if($row_t['passing_status'] == "FAILED"|| $row_t['passing_status'] == "ATKT" ) {

									$passing_status ="INC";
								}else{
									$passing_status;
								}
								?>
									<td ><?php 
										if($row_t['passing_status'] == "FAILED" || $row_t['passing_status'] == "ATKT"){
											echo '<span style="position:relative; left:15px;">-&nbsp;&nbsp;&nbsp;&nbsp;</span>';
										}else{
											echo $row_t['obt_marks'];
										}
									?><td>
									<td style="position:relative; left:28px;">2023<td>
									<td style="position:relative; left:8px;"><?php echo $row_t['exam_roll_no'];  ?><?php //echo $row_t['passing_status'];  ?><td>
								</tr>
							</table>
						</td>
						<?php
							if ($row_t['passing_status'] == "FAILED" || $row_t['passing_status'] == "ATKT") {
								$grant_total = $total_obt;
							} else {
								$grant_total = $row_t['obt_marks'] + $total_obt;
							}
							?>
						<td width="6%">
						<?php
							if($grant_total==0 || $total_obt == 0){
								echo "AB";
							}else{

							echo $grant_total;
							}
							?></td>

						<?php }?>
						
						<td width="6%"><?php
							if($grant_total==0 || $total_obt == 0){
								echo "ABSENT";
							}
							else{
								echo $passing_status;
							}
						?></td>
						<?php
							//$backpaper[] = $i;
							//$b_paper = implode(",", $backpaper);
							$b_paper = NULL;
							$sql_update = 'UPDATE `back_exam_student_info` SET `max_marks`="'.$total_max.'",`obt_marks`="'.$total_obt.'",`passing_status`="'.$passing_status.'",`back_papers`="'.$b_paper.'" WHERE sno = '.$row['id'];
							$result_update = mysqli_query($db, $sql_update);
						?>
					</tr>
				</table>	
				<?php
				}
				mysqli_data_seek($result, 0);
				?>	
				
			</div>
		</div>	
		<div class=" mt-3" style="display:flex;justify-content:space-between;font-size:13px;">	
			<?php
				fetchPapers($papers);
			?>
		</div></br>
		<?php
			if($_GET['page']==$tpages){
				$total_students = 0;
				$total_passed_students = 0;
				$total_abs_students = 0;
				$total_ufm_students = 0;
				$total_appered_students = 0;
				echo '<div class="text-center" style="font-size:13px;"><b>SUMMARY</b></div>';
				while($row = mysqli_fetch_assoc($result)){
					$total_students++;
					$paperCodeArray = array();
					$sql2 = "SELECT * FROM back_exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."'"; 
					$result2 = mysqli_query($db, $sql2);
					$i = 1;
					$total_obt = 0;
					$total_max = 0;	
					$passing_status = "PASSED";	
					$stu_abs = 0;
					while($row2 = mysqli_fetch_assoc($result2)){
						if($row2['pt_marks_obt']<36){
							$passing_status = "FAILED";
						}
						if($row2['pt_marks_obt']!="Abs"){
							$stu_abs = 1;
						}
						$total_obt+=(float)$row2['pt_marks_obt'];
					}
					if($total_obt<315){
						$passing_status = "FAILED";
					}
					if($passing_status == "PASSED"){
						$total_passed_students++;
					}
					if($stu_abs == 0){
						$total_abs_students++;
					}
				}
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
						<td class="report_border"><?php echo $total_students ; ?></td>
						<td  class="report_border"><?php  echo $total_abs_students; ?></td>
						<td class="report_border"><?php  echo $total_appered_students = ($total_students-$total_abs_students); ?></td>
						<td class="report_border"><?php  echo $total_passed_students; ?> </td>
						<td class="report_border"><?php  echo ($total_appered_students-$total_passed_students); ?> </td>
						<td class="report_border"><?php echo $total_ufm_students; ?></td>
						<td class="report_border"><?php echo $total_ufm_students; ?></td>
					</tr>
				</table>
		<?php
			}
		?>
		<div style="display:flex;justify-content:space-between;font-size:13px;">	
			<div><b>DATE OF RESULT DECLRATION :  <?php echo date("d-m-Y"); ?></b></div>
			<div><b>SIGNATURE OF CONTROLLER OF EXAMS :</b></div>
			<div><b>CO-ORDINATOR :</b></div>
		</div>
	</body>
</html>
<?php
}
}
?>