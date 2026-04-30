<?php
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg='';
$tab=1;
$responce = 0;
if(isset($_GET['back'])){
	unset($_POST['corsslist_course_bped']);
	unset($_SESSION['corsslist_course_bped']);
	$responce=0;
}
if(isset($_POST['submit']) && $_POST['submit']!=''){
	$_SESSION['corsslist_course_bped'] = $_POST['corsslist_course_bped'];
		$responce = 1;
}
if(isset($_SESSION['corsslist_course_bped'])){
	$_POST['corsslist_course_bped'] = $_SESSION['corsslist_course_bped'];
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
						<h2 class="bg-secondary text-white p-2">Cross-List (BPED)</h2>
						<div class="row">
							 <div class=" col-md-4 ">
								<label>Course</label>
								<select name="corsslist_course_bped" id="course" value="" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
									<option disabled selected>---Select Course---</option>
									<?php 
									$sql  = 'select distinct(course_name),class_detail.class_description from exam_student_info LEFT JOIN class_detail on exam_student_info.course_name = class_detail.sno WHERE class_detail.crasslist_type = 2 ORDER BY class_detail.class_description';
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
if(isset($_POST['corsslist_course_bped'])){
	$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`student_type`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`,`student_info`.`mother_name`, `student_info`.`gender` FROM `exam_student_info` LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno where exam_roll_no!="" and exam_roll_no is not null and `exam_student_info`.`course_name` = "'.$_POST['corsslist_course_bped'].'" order by exam_roll_no';
	
	$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`verify_status`,`exam_student_info`.`student_type`, `exam_id`, `student_info_sno`, `exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`,`student_info`.`mother_name`, `student_info`.`gender`, class_detail.category as category, `class_description` FROM `exam_student_info` 
	LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno 
	LEFT JOIN class_detail on class_detail.sno = course_name
	where exam_roll_no!="" and exam_roll_no is not null and `exam_student_info`.`verify_status` ="1" and`exam_student_info`.`course_name` = "'.$_POST['corsslist_course_bped'].'" order by exam_roll_no';
	
	$sql = '(SELECT "regular" as exam_type, `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`, `exam_id`,`student_type`, `student_info_sno`, `exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`,`student_info`.`mother_name`, `student_info`.`gender`, class_detail.category as category, `class_description` FROM `exam_student_info` LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno LEFT JOIN class_detail on class_detail.sno = course_name where exam_roll_no!="" and exam_roll_no is not null and `exam_student_info`.`course_name` = "'.$_POST['corsslist_course_bped'].'")



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

        .class_name {
            font-size: 16px;
            font-weight: bolder;
        }

        .noprint {
            display: none;

        }

        td {
            border: 0px !important;
            text-align: center;
            font-size: 7px;
        }

        th {
            border: 0px !important;
            font-size: 7px;
        }

        .headernoprint {
            margin-top: 160px;
        }

        @page {
            size: A3 landscape;
            /* padding-top:100px; */
            margin-top: 5mm;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100vw;
            background-image: url('images/Kamla Nehru Cross List_Set F.jpg');
            /*Change to your actual image path */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            z-index: -1;
            opacity: 1.2;
            /* Adjust opacity for better readability */
        }

        .wrap {
            position: relative;
            z-index: 1;
        }

        header {
            display: none;
            /* Hide header when printing */
        }

        footer {
            margin-bottom: -9px !important;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
        }

        #row_container {
            margin-top: 300px !important;
        }

    }


    td {
        border: 0px !important;
        border-style: ;
        text-align: center;
        font-size: 10px;
    }

    th {
        border: 0px !important;
        font-size: 10px;
    }

    table,
    figure {
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
        padding-top: 0.4rem;
        padding-inline: 0.1rem;

    }

    .report_border {
        border: 1px solid black !important;
        font-size: 13px !important;
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
				echo '<div class="pagination"><ul><li><a href="exam_crasslist_print_bped.php?back=1">Back</a></li>';
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
								<div class="headernoprint ">
                                <h4 class="noprint" style="text-align: center; margin:0px; "><span><b>Kamla Nehru
                                            Institute Of Physical &amp; Social Sciences,Sultanpur, Uttar
                                            Pradesh</b></span> <br><span style="font-size:1.3rem;">An Autonomous
                                        Institute And Accredited "A" Grade by NAAC</span></h4>
                            </div>
								<div class="print-heading text-center" style="font-size:16px; font-weight: bold; margin-bottom: 10px; text-align:center;">
                                <?php
                                    $sql_class = 'select * from class_detail where sno = "'.$_POST['corsslist_course_bped'].'"';
                                    $row_class = mysqli_fetch_assoc(mysqli_query($db,$sql_class));
                                ?>
                                <div>
                                    <b>
                                    <?php echo $row_class['class_description'] ?> Main Examination Session :
                                    <?php
                                        $year = substr($_SESSION['db_name'], -4);
                                        $next_year = $year + 1;
                                        echo $year . '-' . $next_year;
                                    ?>
                                    </b><span class="ps-3">REGULAR</span>
                                </div>
                            
                                
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
				// 			$cross_list = cross_list_bped($row);
				// 			echo $cross_list['html'].'<br>';
							$semester = $row_class['semester'];
							$category = $row_class['category'];

                           
							if ($semester == 1) {
								$max_students_per_page = 3;
							} elseif ($semester == 2) {
								$max_students_per_page = 3;
							} else {
								$max_students_per_page = 2;
								
							}
							$cross_list = cross_list_bped($row);
								 
							echo $cross_list['html'].'<br>';                          
                            $student_counter++;
                            if ($student_counter % $max_students_per_page == 0) {
                                echo '<div style="page-break-after: always;"></div>';
                                    echo '<div ></div>';
                                     echo $print_heading;
                               
                            }
                        
						}
						 mysqli_data_seek($result, 0);	
						?>	
						<!----    REPORT START  ---->
					<?php
					if($_GET['page']==$tpages){
            			$total_students = 0;
            			$total_passed_students = 0;
            			$total_abs_students = 0;
            			$total_ufm_students = 0;
            			$total_appered_students = 0;
            			echo '<div class="text-center" style="font-size:13px;"><b>SUMMARY</b></div>';
            			$sql2 = "
            					SELECT 
            						COUNT(*) AS total_students,
            						SUM(CASE WHEN passing_status = 'ABSENT'  THEN 1 ELSE 0 END) AS total_abs_theory,
            						SUM(CASE WHEN passing_status = 'PASSED' THEN 1 ELSE 0 END) AS total_pass_theory,
            						SUM(CASE WHEN passing_status = 'FAILED' THEN 1 ELSE 0 END) AS total_failed_theory,
            						SUM(CASE WHEN passing_status = 'INC' THEN 1 ELSE 0 END) AS total_inc__theory,
            						SUM(CASE WHEN passing_status = 'UFM' THEN 1 ELSE 0 END) AS total_ufm_theory
            					FROM exam_student_info
            					WHERE course_name = '".$_POST['corsslist_course_bped']."' AND verify_status='1';
            				";
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
            			<div class="d-flex justify-content-between" style="font-size:13px;">
										<!--<div><b>DATE OF RESULT DECLARATION :-->
										    <?php 
												
										$sql25="SELECT *  FROM `result_class` WHERE `class_description` ='".$row_class['class_description']."' and show_result=1";
			                           	$row_date = mysqli_fetch_assoc(mysqli_query($db,$sql25));
												//echo date('d-m-Y', strtotime($row_date['result_declaration_date']));
 
												?>
												<!--</b></div>-->
										<!--<div><b>SIGNATURE OF CONTROLLER OF EXAMS :</b></div>-->
										<!--<div><b>CO-ORDINATOR :</b></div>-->
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
			 <?php

echo '<div style="page-break-after: always;"></div>'; 

$sql_paper = "SELECT paper_code, title_of_paper, theory_practical, pt_marks_max, mid_sem_marks_max, mid_sem_pt_max 
        FROM exam_student_paper_info 
        WHERE class_id = '".$row_class['sno']."' 
        GROUP BY paper_code, title_of_paper, theory_practical, pt_marks_max, mid_sem_marks_max, mid_sem_pt_max";
// echo $sql_paper;
$result_paper = mysqli_query($db, $sql_paper);
// echo "<br>";
// print_r($result_paper);
// echo "</br>";

?>
    <br><br><br><br><br><br><br><br>
    <table width="100%">
        <thead class="">
            <tr>
                <th width="5%">S.No</th>
                <th width="20%">Paper Code</th>
                <th width="60%">Title of Paper</th>
                <th width="5%">EXT</th>
                <th width="5%">INT</th>
                <th width="5%">PRAC</th>
            </tr>
        </thead>
        <tbody>
            <?php 
        $sno = 1;
        $paper_counter = 0;
        while($row_paper = mysqli_fetch_assoc($result_paper)) { 
             $ext = $int = $prac = 0; 
             if($row_paper['theory_practical'] == 'Theory'){
        $ext  = $row_paper['pt_marks_max'];       
        $int  = $row_paper['mid_sem_marks_max'];   
        } else if($row_paper['theory_practical'] == 'Practical'){
        $prac = $row_paper['pt_marks_max'];       
        $int  = $row_paper['mid_sem_pt_max'];      
        }
            $total = (float)$ext + (float)$int;
        ?>
            <tr class="text-start">
                <td class="text-start"><?php echo $sno++; ?></td>
                <td class="text-start"><?php echo $row_paper['paper_code']; ?></td>
                <td class="text-start"><?php echo $row_paper['title_of_paper']; ?></td>
                <td class="text-start"><?php echo $ext; ?></td>
                <td class="text-start"><?php echo $int; ?></td>
                <td class="text-start"><?php 
                if($row_paper['paper_code']=="KPHCW 102"){
                    echo "30";
                }else{
                   echo $prac; 
                }
                 ?></td>
            </tr>
            <?php 
            $paper_counter++;
            if($paper_counter % 23 == 0 && $paper_counter < mysqli_num_rows($result_paper)) {
                echo '</tbody></table>';
                echo '<div style="page-break-after: always;"></div>';
                echo '<div style="height:170px;"></div>';
                echo ' <table width="100%">
                <thead class="">
                    <tr>
                        <th width="5%">S.No</th>
                        <th width="20%">Paper Code</th>
                        <th width="60%">Title of Paper</th>
                        <th width="5%">EXT</th>
                        <th width="5%">INT</th>
                        <th width="5%">PRAC</th>
                    </tr>
                </thead>
                        <tbody>';
                
            }
            } ?>
        </tbody>
    </table>
			<footer>
        <table class="table" width="100%">
            <tr>
                <th style="font-size:12px;" colspan="2">
                    <span style="font-weight:bolder; font-size:12px;" id="row-span">NOTE:</span><br>
                    1. The Minimum Passing Standard shall be 40% Aggregate for Theory Papers.<br>
                    2. The Minimum Passing Standard shall be 50% For Practical/Viva-Voce.
                </th>
            </tr>
             <tr>
                <th style="font-size:11px;" width="30%" rowspan="2">
                    DATE OF RESULT DECLARATION: <?php
                    	$sql25="SELECT *  FROM `result_class` WHERE `class_description` ='".$row_class['class_description']."'";
                       	$row_date = mysqli_fetch_assoc(mysqli_query($db,$sql25));
								if (!empty($row_date['result_declaration_date'])) {
                            echo strtoupper(date('d-m-Y', strtotime($row_date['result_declaration_date'])));
                        } else {
                            echo 'N/A';
                        }
                ?>
                </th>
                <th style="font-size:11px; text-align:left; margin-right:10px;" width="35%">
                    CHECKED BY 1........................................
                </th>
                <th style="font-size:11px;" width="35%">
                    SIGNATURE OF EXAM. CONTROLLER.........................................
                </th>
            </tr>
            <tr>
                                <th style="font-size:11px;  padding-left:75px;" width="50%">
                    2........................................
                </th>
                <th style="font-size:11px; text-align:right; margin-right:30px;">
                    PRINCIPAL......................................................................................
                </th>
            </tr>
        </table>
		</div>
	</body>
</html>
<?php
}
}


function cross_list_bped($row){
	global $db;
	$backpaperArray = array();
	$incpaperArray = array();
	$result_array = array();
	$show_total = 0;
	$total_obt = 0;
	$total_max = 0;	
	$total_grade_credit_erned_point = 0;
	$passing_status = 'PASSED';	
	$passing_status_reason = 'EVERY THING FINE';
	$avg_credit = 0;
	$cocurricular_count = 0;
	$count_row = 0;
	$show_total=0;
	$html = '<table style=" width:100%; border:1px solid black;border-style: ;">
	<tr style="border:1px solid black;border-style: ;">
		<td style="verticle-align:top;"  width="20%" valign="top">
			<table width="100%"  valign="middle" >
				<tr>
					<td style="height: 33px;"></td>
					<td ><b></b></td>

				</tr>
				<tr>
    <td><b>DOB</b></td>
    <td><b>'.date('d-m-Y', strtotime($row['dob'])).'</b></td>
</tr>
				<tr>
					<td><b>ROLL NO.</b></td>
					<td ><b>'.$row['exam_roll_no'].'</b></td>
				</tr>
				<tr >
					<td><b>UIN No.</b></td>
					<td ><b>'.$row['uin_no'].'</b></td>
				</tr>
				<tr >
					<td><b>STUDENT\'S NAME</b></td>
					<td><b>'.strtoupper($row['student_name']).'</b></td>
				</tr>
				<tr >
					<td ><b>FATHER\'S NAME</b></td>
					<td><b>'.strtoupper($row['father_name']).'</b></td>
				</tr>
				<tr >
						<td ><b>MOTHER\'S NAME</b></td>
						<td><b>'.strtoupper($row['mother_name']).'</b></td>
					</tr>
					<tr >
						<td ><b>ENROLLMENT No.</b></td>
						<td><b></b></td>
					</tr>
			</table>
		</td>
		<td width="40%" valign="top">
			<table width="100%">
				<tr>
					<td rowspan="2"><b>PAPER CODE</b></td>
					<td rowspan="2"><b>PAPER NAME</b></td>
					<td colspan="2"><b>THEORY</b></td>
					<td colspan="2"><b>PRACTICAL </td>
					<td rowspan="2"><b>TOTAL</br>100<br></b></td>
				</tr>
				<tr>
					<td ><b>70</br>28</b></td>
					<td ><b>30</br>12</b></td>
					<td ><b>70</br>35</b></td>
					<td ><b>30</br>15</b></td>
				</tr>';
		$paperCodeArray = array();
		if($row['exam_type']=='regular'){
		    $sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type in ('Major', 'Core') THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type in ('Vocational', 'Supporting') THEN 3 WHEN type in ('Cocurricular', 'Common') THEN 4 END, sno"; 
		}else{
		    $sql2 = "SELECT * FROM back_exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type in ('Major', 'Core') THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type in ('Vocational', 'Supporting') THEN 3 WHEN type in ('Cocurricular', 'Common') THEN 4 END, sno"; 
		}
		//echo $_POST['corsslist_course_bped'];
		if($_POST['corsslist_course_bped']=="251"){
		    $sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY paper_code ASC"; 
		}
		
//echo $sql2;
		$result2 = mysqli_query($db, $sql2);
		$tot_max=0;
		$tot_obt=0;
		$ufm_exist = 0;
		$tot_theory_30 = 0;
		$tot_theory_70 = 0;
		$tot_theory_obt = 0;
		$tot_practical_30 = 0;
		$tot_practical_70 = 0;
		$tot_practical_100 = 0;
		$tot_practical_obt = 0;
		$stu_abs = 0;
		while ($row2 = mysqli_fetch_assoc($result2)) {
			
				$total_abs = 0;
				$practical_marks_70 = 0;
				$practical_marks_100 = 0;
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
								$practical_marks_max='';
								$practical_marks_obt='';
							}
							if($row4['theory_practical']=="Practical"){
								$practical_marks_max='';
								$practical_marks_obt='';
								$theory_marks_max=$row4['pt_marks_max'];
								$theory_marks_obt=$row4['pt_marks_obt'];
								$mid_marks_max=$row4['mid_sem_pt_max'];
								$mid_marks_obt=$row4['mid_sem_pt_obt'];
							}
							
						$count_row++;
						
						
					if($row2['paper_code']=='KBPED-208P'){
						
						$practical_marks_100 = $theory_marks_obt;
						$obt_total = (float)$practical_marks_100;
						$html .= '
						<tr style="border:1px solid black; border-style:;">
							<td>'.$paperCode.'</td>
							<td style="text-align:left; padding-left:15px;">'.strtoupper($row4['title_of_paper']).'</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>';
							$html .= '<td>'.$practical_marks_100.'</td>';
							if((float)$practical_marks_100<50){
								$passing_status = "FAILED";
								$passing_status_reason .= "</br>Practical marks 100 less then 50";
							}if($practical_marks_100!="Abs"){
								$stu_abs = 1;
								$total_abs = 1;
							}
						$html .= '</tr>';
						
					}
					else{
						$html .= '<tr style="border:1px solid black; border-style:;">
							<td>'.$paperCode.'</td>
							<td style="text-align:left; padding-left:15px;">'.strtoupper($row4['title_of_paper']).'</td>';
						if($row4['theory_practical']=="Theory"){
							$theory_marks_70 = $theory_marks_obt;
							$html .= '<td>'.$theory_marks_70.'</td>';
							if((float)$theory_marks_70<28){
								$passing_status = "FAILED";
								$passing_status_reason .= "</br>theory marks 70 less then 28";
							}if($theory_marks_70!="Abs"){
								$stu_abs = 1;
								$total_abs = 1;
							}
						}else{
							$html .= '<td>-</td>';
						}
								
						if($row4['theory_practical']=="Theory"){
							$theory_marks_30 = $mid_marks_obt;
							$html .= '<td>'.$theory_marks_30.'</td>';
							if((float)$theory_marks_30<12){
								$passing_status = "FAILED";
								$passing_status_reason .= "</br>theory marks 30 less then 12";
							}if($theory_marks_30!="Abs"){
								$stu_abs = 1;
								$total_abs = 1;
							}
						}else{
							$html .= '<td>-</td>';
						}
						
						if($row4['theory_practical']=="Theory"){
							$theory_total = (float)$theory_marks_obt+(float)$mid_marks_obt;
							if((float)$theory_total<40){
								$passing_status = "FAILED";
								$passing_status_reason .= "</br>Theory marks total less then 40";
							}
							$theory_total_max = (float)$theory_marks_max+(float)$mid_marks_max;
						}else{
							$theory_total = '-';
						}
								
						if($row4['theory_practical']=="Practical"){
							$practical_marks_70 = $theory_marks_obt;
							$html .= '<td>'.$practical_marks_70.'</td>';
							if((float)$practical_marks_70<35){
								$passing_status = "FAILED";
								$passing_status_reason .= "</br>Practical marks 70 less then 35";
							}if($practical_marks_70!="Abs"){
								$stu_abs = 1;
								$total_abs = 1;
							}
						}else{
							$html .=  '<td>-</td>';
						}
						
						if($row4['theory_practical']=="Practical"){
							$practical_marks_30 = $mid_marks_obt;
							$html .= '<td>'.$practical_marks_30.'</td>';
							if((float)$practical_marks_30<15){
								$passing_status = "FAILED";
								$passing_status_reason .= "</br>Practical marks 30 less then 15";
							}if($practical_marks_30!="Abs"){
								$stu_abs = 1;
								$total_abs = 1;
							}
						}else{
							$html .= '<td>-</td>';
						}
								
						if($row4['theory_practical']=="Practical"){
							$practical_total = (float)$theory_marks_obt+(float)$mid_marks_obt;
							if((float)$practical_total<50){
								$passing_status = "FAILED";
								$passing_status_reason .= "</br>Practical marks total less then 50";
							}
							$practical_total_max = (float)$theory_marks_max+(float)$mid_marks_max;
						}else{
							$practical_total = '-';
						}
						if($total_abs == 0){
							$html .= '<td>Abs</td>';
							$obt_total = 0;
						}else{
							$obt_total = (float)$theory_total+(float)$practical_total;
							$html .= '<td>'.$obt_total.'</td>';
						}	
						
					}
						$tot_theory_70+=(float)$theory_marks_70;
						$tot_theory_30+=(float)$theory_marks_30;
						$tot_theory_obt +=(float)$theory_total;
				// 		$tot_practical_30+=(float)$practical_marks_30;
				// 		$tot_practical_70+=(float)$practical_marks_70;
				// 		$tot_practical_100+=(float)$practical_marks_100;
					
				// 		$tot_practical_obt +=(float)$practical_total ;
				$tot_practical_30 += (float)$practical_marks_30;
                $tot_practical_70 += (float)$practical_marks_70;
                $tot_practical_100 += (float)$practical_marks_100;
                $tot_practical_obt = $tot_practical_30 + $tot_practical_70 + $tot_practical_100;
                
                //echo "Total Practical Obtained: $tot_practical_obt";

						$tot_obt+=(float)$obt_total;
						$tot_max+=(float)$theory_total_max+(float)$practical_total_max;
				}						
			}
		}
		if($show_total==0){
		$html .= '</tr>
		<tr style="border:1px solid black; border-style:;">
			<th></th>
			<th style="text-align:right">Total : --</th>
			<th style="text-align:center;">'.$tot_theory_70.'</th>
			<th style="text-align:center;">'.$tot_theory_30.'</th>
			<th style="text-align:center;">'.$tot_practical_70.'</th>
			<th style="text-align:center;">'.$tot_practical_30.'</th>
			<th style="text-align:center;">'.$tot_obt.'</th>
		</tr>';
		}
		$html .= '</table>
		</td>
		<td width="40%" valign="top">';
	
		if($row['exam_id']=='1'){
			$html .= '<table width="100%">
				<tr style="border:1px solid black">
					<td ><b>THEORY</br>400</br>160</b></td>
					<td ><b>PRACTICAL</br>400</br>200</b></td>
					<td ><b>G. TOTAL</br>800</br>360</b></td>
					<td ><b>RESULT</b></td>
				</tr>
				<tr>';
			if($tot_theory_obt<160){
				$passing_status = "FAILED";
				$passing_status_reason .= "Total theory is less then 160";
			}if($tot_practical_obt<200){
				$passing_status = "FAILED";
				$passing_status_reason .= "Total practical less then 200";
			}if($tot_obt<360){
				$passing_status = "FAILED";
				$passing_status_reason .= "Total is less then 360";
			}
			if($stu_abs == 0){
				$passing_status = "ABSENT";
			}
			$html .= '
			<td ><b>'.$tot_theory_obt.'</b></td>
			<td ><b>'.$tot_practical_obt.'</b></td>
			<td ><b>'.$tot_obt.'/'.$tot_max.'</b></td>
			<td ><b>'.$passing_status.'</b></td>';
			//$backpaper[] = $i;
			//$b_paper = implode(",", $backpaper);
			$b_paper = NULL;

			$sql_update = 'UPDATE exam_student_info SET 
			max_marks = "'.$tot_max.'",
			obt_marks = "'.$tot_obt.'",
			passing_status = "'.$passing_status.'",
			sgpa = "",
			grade_point = "",
			`back_papers`="'.$b_paper.'" 
			WHERE sno = '.$row['id'];
			$result_update = mysqli_query($db, $sql_update);
			$html .= '</tr>
				</table>';
		}
		elseif($row['exam_id']=='3'){
			$html .= '<table width="100%">
				<tr style="border:1px solid black">
					<td class="border border-dark"><b>THEORY</br>400</br>160</b></td>
					<td class="border border-dark"><b>PRACTICAL</br>400</br>200</b></td>
					<td class="border border-dark"><b>SUM TOTAL</br>800</br>360</b></td>
					<td class="border border-dark"> 
						<table width="100%">
							<tr>
								<th colspan="3" class="text-center">PREVIOUS SEMESTER DETAILS</th>
							</tr>
							<tr>
								<td width="30%"><b>TOTAL</b><td>
								<td width="30%"><b>YEAR</b><td>
								<td width="40%"><b>ROLL-NO</b><td>
							</tr>
						</table>
					</td>
					<td class="border border-dark"><b>GRAND</br>TOTAL</b></td>
					<td class="border border-dark"><b>RESULT</b></td>
				</tr>
				<tr>';
				$prev_year = (int)substr($_SESSION['db_name'], -4) - 1;
    				$db_name = 'knipsser_' . $prev_year;
    				$erp_23 = mysqli_connect("p:localhost", "knipsserp", "hdsvIe673CYG3Xg@", $db_name);
                 $prev_year2 = (int)substr($_SESSION['db_name'], -4) - 2;
    				$db_name2 = 'knipsser_' . $prev_year2;
    				$erp_2 = mysqli_connect("p:localhost", "knipsserp", "hdsvIe673CYG3Xg@", $db_name2);
				$sql1="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' and exam_id=1";
				$row_t1 = mysqli_fetch_assoc(mysqli_query($erp_23,$sql1));
				$sql2="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' and exam_id=2";
				$row_t2 = mysqli_fetch_assoc(mysqli_query($erp_23,$sql2));
			if($tot_theory_obt<160){
				$passing_status = "FAILED";
				$passing_status_reason .= "Total theory is less then 160";
			}if($tot_practical_obt<200){
				$passing_status = "FAILED";
				$passing_status_reason .= "Total practical less then 200";
			}if($tot_obt<360){
				$passing_status = "FAILED";
				$passing_status_reason .= "Total is less then 360";
			}
			if($stu_abs == 0){
				$passing_status = "ABSENT";
			}
			if($row_t1['passing_status'] == "FAILED" || $row_t2['passing_status'] == "FAILED" || $row_t1['passing_status'] == "ABSENT" || $row_t2['passing_status'] == "ABSENT" || $row_t1['passing_status'] == "INC" || $row_t2['passing_status'] == "INC"){

				$passing_status ="INC";
			}else{
				$passing_status;
			}
			if($row_t1['passing_status'] == "FAILED" || $row_t2['passing_status'] == "FAILED" || $row_t1['passing_status'] == "ABSENT" || $row_t2['passing_status'] == "ABSENT" || $row_t1['passing_status'] == "INC" || $row_t2['passing_status'] == "INC"){
				$grant_total = $tot_obt;
			} else {
				$grant_total = $row_t1['obt_marks'] + $row_t2['obt_marks'] + $tot_obt;
			}
			$pre_total_obt= $row_t1['obt_marks'] + $row_t2['obt_marks'];
			
			
			$html .= '
			<td ><b>'.$tot_theory_obt.'</b></td>
			<td ><b>'.$tot_practical_obt.'</b></td>
			<td ><b>'.$tot_obt.'</b></td>
			<td > 
				<table width="100%" class="text-center">
					
					<tr>';
						if($row_t1['passing_status'] == "FAILED" || $row_t2['passing_status'] == "FAILED" || $row_t1['passing_status'] == "ABSENT" || $row_t2['passing_status'] == "ABSENT" || $row_t1['passing_status'] == "INC" || $row_t2['passing_status'] == "INC"){
							$html .= '<td class="text-center" width="30%"><b><span style="position:relative; left:15px;">-&nbsp;&nbsp;&nbsp;&nbsp;</span></b></td>';
						}else{
							$html .= '<td class="text-center" width="30%"><b>'.$pre_total_obt.'</b></td>';
						}
		
						$html .= '<td class="text-center" width="30%"><b>2023</b></td>
						<td class="text-center" width="40%"><b>'.$row_t1['exam_roll_no'].'</b></td>
					</tr>
				</table>
			</td>';
			if($row_t1['passing_status'] == "FAILED" || $row_t2['passing_status'] == "FAILED" || $row_t1['passing_status'] == "ABSENT" || $row_t2['passing_status'] == "ABSENT" || $row_t1['passing_status'] == "INC" || $row_t2['passing_status'] == "INC"){
				$html .= '<td ><b>'.$tot_obt.'</b></td>';
			}else{
				$html .= '<td ><b>'.$grant_total.'</b></td>';
			}
			$html .= '<td ><b>'.$passing_status.'</b></td></tr>';
			//$backpaper[] = $i;
			//$b_paper = implode(",", $backpaper);
			
			$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, `max_marks`, `obt_marks`, earned_credit, total_credit, sgpa, cgpa, grade_point, passing_status, class_description FROM `exam_student_info` 
			LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno 
			LEFT JOIN class_detail on class_detail.sno = course_name
			where exam_roll_no!="" and exam_roll_no is not null and student_info_sno="'.$row['student_info_sno'].'" and exam_id=1 order by exam_roll_no';
			//echo $sql.'<br>';
			$result_sem_even = mysqli_query($db,$sql);
			if(mysqli_num_rows($result_sem_even)!=0){
					$row_sem_even = mysqli_fetch_assoc($result_sem_even);
			}
			else{
				$row_sem_even['sgpa']='';
			}
			
			//$html .= '<tr><td colspan="4">I SEM RESULT</td></tr>';
			
			$b_paper = NULL;

			$sql_update = 'UPDATE exam_student_info SET 
			max_marks = "'.$tot_max.'",
			obt_marks = "'.$tot_obt.'",
			passing_status = "'.$passing_status.'",
			sgpa = "",
			grade_point = "",
			`back_papers`="'.$b_paper.'" 
			WHERE sno = '.$row['id'];
			$result_update = mysqli_query($db, $sql_update);
			$html .= '</tr>
				</table>';
		}elseif($row['exam_id']=='2'){
			
				$sql="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' and exam_id=1";
			$row_t = mysqli_fetch_assoc(mysqli_query($db,$sql));
			if($tot_theory_obt<160){
				$passing_status = "FAILED";
				$passing_status_reason .= "Total theory is less then 160";
			}if($tot_practical_obt<200){
				$passing_status = "FAILED";
				$passing_status_reason .= "Total practical less then 200";
			}if($tot_obt<360){
				$passing_status = "FAILED";
				$passing_status_reason .= "Total is less then 360";
			}
			if($stu_abs == 0){
				$passing_status = "ABSENT";
			}
			if(($row_t['passing_status'] == "FAILED" && $passing_status == "PASSED") || ($row_t['passing_status'] == "ATKT" && $passing_status == "PASSED") ) {

				$passing_status ="INC";
			}else{
				$passing_status;
			}
			if ($row_t['passing_status'] == "FAILED" || $row_t['passing_status'] == "ATKT") {
				$grant_total = $tot_obt;
			} else {
				$grant_total = $row_t['obt_marks'] + $tot_obt;
			}
			$grant_max = $row_t['max_marks'] + 800;
			//echo $grant_max;
			$html .= '<table width="100%">
				<tr style="border:1px solid black">
					<td class="border border-dark"><b>THEORY</br>400</br>160</b></td>
					<td class="border border-dark"><b>PRACTICAL</br>400</br>200</b></td>
					<td class="border border-dark"><b>SUM TOTAL</br>800</br>360</b></td>
					<td class="border border-dark"> 
						<table width="100%">
							<tr>
								<th colspan="3" class="text-center">PREVIOUS SEMESTER DETAILS</th>
							</tr>
							<tr>
								<td width="30%"><b>TOTAL<br>'.$row_t['max_marks'].'</b><td>
								<td width="30%"><b>YEAR</b><td>
								<td width="40%"><b>ROLL-NO</b><td>
							</tr>
						</table>
					</td>
					<td class="border border-dark"><b>GRAND</br>TOTAL<br>'.$grant_max.'</b></td>
					<td class="border border-dark"><b>RESULT</b></td>
				</tr>
				<tr>';
			
			//echo $practical_marks_100;
			$html .= '
			<td ><b>'.$tot_theory_obt.'</b></td>
			<td ><b>'.$tot_practical_obt.'</b></td>
			<td ><b>'.$tot_obt.'</b></td>
			<td > 
				<table width="100%" class="text-center">
					
					<tr>';
						if($row_t['passing_status'] == "FAILED" || $row_t['passing_status'] == "ATKT"){
							$html .= '<td class="text-center" width="30%"><b><span style="position:relative; left:15px;">-&nbsp;&nbsp;&nbsp;&nbsp;</span></b></td>';
						}else{
							$html .= '<td class="text-center" width="30%"><b>'.$row_t['obt_marks'].'</b></td>';
						}
		
						$html .= '<td class="text-center" width="30%"><b>'.substr($_SESSION['db_name'], -4).'</b></td>
						<td class="text-center" width="40%"><b>'.$row_t['exam_roll_no'].'</b></td>
					</tr>
				</table>
			</td>
			<td ><b>'.$grant_total.'</b></td>
			<td ><b>'.$passing_status.'</b></td></tr>';
			//$backpaper[] = $i;
			//$b_paper = implode(",", $backpaper);
			
			$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, `max_marks`, `obt_marks`, earned_credit, total_credit, sgpa, cgpa, grade_point, passing_status, class_description FROM `exam_student_info` 
			LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno 
			LEFT JOIN class_detail on class_detail.sno = course_name
			where exam_roll_no!="" and exam_roll_no is not null and student_info_sno="'.$row['student_info_sno'].'" and exam_id=1 order by exam_roll_no';
			//echo $sql.'<br>';
			$result_sem_even = mysqli_query($db,$sql);
			if(mysqli_num_rows($result_sem_even)!=0){
					$row_sem_even = mysqli_fetch_assoc($result_sem_even);
			}
			else{
				$row_sem_even['sgpa']='';
			}
			
			//$html .= '<tr><td colspan="4">I SEM RESULT</td></tr>';
			
			$b_paper = NULL;

			$sql_update = 'UPDATE exam_student_info SET 
			max_marks = "800",
			obt_marks = "'.$tot_obt.'",
			passing_status = "'.$passing_status.'",
			sgpa = "",
			grade_point = "",
			`back_papers`="'.$b_paper.'" 
			WHERE sno = '.$row['id'];
			//$result_update = mysqli_query($db, $sql_update);
			$html .= '</tr>
				</table>';
		}elseif($row['exam_id']=='4'){
			$html .= '<table width="100%">
				<tr style="border:1px solid black">
					<td class="border border-dark"><b>THEORY</br>400</br>160</b></td>
					<td class="border border-dark"><b>PRACTICAL</br>400</br>200</b></td>
					<td class="border border-dark"><b>SUM TOTAL</br>800</br>360</b></td>
					<td class="border border-dark"> 
						<table width="100%">
							<tr>
								<th colspan="3" class="text-center">PREVIOUS SEMESTER DETAILS</th>
							</tr>
							<tr>
								<td width="30%"><b>TOTAL<br>2400</b><td>
								<td width="30%"><b>YEAR</b><td>
								<td width="40%"><b>ROLL-NO</b><td>
							</tr>
						</table>
					</td>
					<td class="border border-dark"><b>GRAND</br>TOTAL<br>3200</b></td>
					<td class="border border-dark"><b>RESULT</b></td>
				</tr>
				<tr>';
				$erp_23 = mysqli_connect("p:localhost", "knipsserp", "hdsvIe673CYG3Xg@","knipsser_2023");
				$sql1="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' and exam_id=1";
				$row_t1 = mysqli_fetch_assoc(mysqli_query($erp_23,$sql1));
				
				$sql2="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' and exam_id=2";
				$row_t2 = mysqli_fetch_assoc(mysqli_query($erp_23,$sql2));
				$sql3="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' and exam_id=3";
				$row_t3 = mysqli_fetch_assoc(mysqli_query($db,$sql3));
					
				//echo $row_t3['obt_marks'];
				// echo $row_t1['passing_status'];
				// echo "<br>";
				// echo $row_t2['passing_status'];
				$exam_roll_no = $row['exam_roll_no'];
				//  If failed in exam 1, get data from back_exam_student_info
				if (isset($row_t1['passing_status']) && $row_t1['passing_status'] === 'FAILED') {
					$sql_back1 = "SELECT 
									obt_marks, theory_obt, practical_obt,
									max_marks, theory_max, practical_max, passing_status 
								  FROM back_exam_student_info 
								  WHERE exam_roll_no = '$exam_roll_no' AND exam_id = '01' LIMIT 1";
					$row_back1 = mysqli_fetch_assoc(mysqli_query($db, $sql_back1));
                        //echo $row_back1['obt_marks'];
					
				}

				//  If failed in exam 2, get data from back_exam_student_info
				if (isset($row_t2['passing_status']) && $row_t2['passing_status'] === 'FAILED') {
					$sql_back2 = "SELECT 
									obt_marks, theory_obt, practical_obt,
									max_marks, theory_max, practical_max, passing_status 
								  FROM back_exam_student_info 
								  WHERE exam_roll_no = '$exam_roll_no' AND exam_id = '02' LIMIT 1";
					$row_back2 = mysqli_fetch_assoc(mysqli_query($db, $sql_back2));
					

				}	
				
				
			if($tot_theory_obt<160){
				$passing_status = "FAILED";
				$passing_status_reason .= "Total theory is less then 160";
			}if($tot_practical_obt<200){
				$passing_status = "FAILED";
				$passing_status_reason .= "Total practical less then 200";
			}if($tot_obt<360){
				$passing_status = "FAILED";
				$passing_status_reason .= "Total is less then 360";
			}
			if($stu_abs == 0){
				$passing_status = "ABSENT";
			}
			if($row_t3['passing_status'] == "FAILED" || $row_t3['passing_status'] == "ABSENT" ){

				$passing_status ="INC";
			}else{
				$passing_status;
			}
// 			if($row_t1['passing_status'] == "FAILED" || $row_t2['passing_status'] == "FAILED" || $row_t1['passing_status'] == "ABSENT" || $row_t2['passing_status'] == "ABSENT" || $row_t1['passing_status'] == "INC" || $row_t2['passing_status'] == "INC"){
// 				$grant_total = $tot_obt;
// 			} else {
// 				$grant_total = $row_t1['obt_marks'] + $row_t2['obt_marks'] + $row_t2['obt_marks'] + $tot_obt;
// 			}
            if($row_t1['passing_status']=="FAILED"){
				$pre_total_obt= $row_back1['obt_marks'] + $row_t2['obt_marks'] + $row_t3['obt_marks'];
				//echo"1A";
			}elseif($row_t2['passing_status']=="FAILED"){
				$pre_total_obt= $row_t1['obt_marks'] + $row_back2['obt_marks'] + $row_t3['obt_marks'];
				//echo"2";
			}elseif($row_t2['passing_status']=="FAILED" && $row_t1['passing_status']=="FAILED"){
				$pre_total_obt= $row_back1['obt_marks'] + $row_back2['obt_marks'] + $row_t3['obt_marks'];
				//echo"3";
			}else{
				$pre_total_obt= $row_t1['obt_marks'] + $row_t2['obt_marks'] + $row_t3['obt_marks'];
				//echo"4";
			}
			$grant_total = $pre_total_obt + $tot_obt;
			
			
			
			$html .= '
			<td ><b>'.$tot_theory_obt.'</b></td>
			<td ><b>'.$tot_practical_obt.'</b></td>
			<td ><b>'.$tot_obt.'</b></td>
			<td > 
				<table width="100%" class="text-center">
					
					<tr>';
						if($row_t3['passing_status'] == "FAILED" || $row_t3['passing_status'] == "ABSENT"){
							$html .= '<td class="text-center" width="30%"><b><span style="position:relative; left:15px;">-&nbsp;&nbsp;&nbsp;&nbsp;</span></b></td>';
						}else{
							$html .= '<td class="text-center" width="30%"><b>'.$pre_total_obt.'</b></td>';
						}
		
						$html .= '<td class="text-center" width="30%"><b>'.substr($_SESSION['db_name'], -4).'</b></td>
						<td class="text-center" width="40%"><b>'.$row_t1['exam_roll_no'].'</b></td>
					</tr>
				</table>
			</td>';
			if($row_t3['passing_status'] == "FAILED" || $row_t3['passing_status'] == "ABSENT"){
				$html .= '<td ><b>'.$tot_obt.'</b></td>';
			}else{
				$html .= '<td ><b>'.$grant_total.'</b></td>';
			}
			$grant_total_per = round($grant_total * 100 / 3200, 2);

			if ($grant_total_per >= 60) {
				$passing_status_th = "FIRST";
			} elseif ($grant_total_per >= 48 && $grant_total_per < 60) {
				$passing_status_th = "SECOND";
			} elseif ($grant_total_per >= 36 && $grant_total_per < 48) {
				$passing_status_th = "THIRD";
			} else {
				$passing_status_th = "FAIL";
			}
			if($passing_status =="ABSENT" || $passing_status =="INC" || $passing_status =="FAILED" ){
			    $html .= '<td ><b>'.$passing_status.'</b></td></tr>';
			}else{
			   $html .= '<td ><b>'.$passing_status_th.'</b></td></tr>'; 
			}
			
			//$html .= '<td ><b>'.$passing_status.'</b></td></tr>';
			
			
			//$backpaper[] = $i;
			//$b_paper = implode(",", $backpaper);
			
			$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, `max_marks`, `obt_marks`, earned_credit, total_credit, sgpa, cgpa, grade_point, passing_status, class_description FROM `exam_student_info` 
			LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno 
			LEFT JOIN class_detail on class_detail.sno = course_name
			where exam_roll_no!="" and exam_roll_no is not null and student_info_sno="'.$row['student_info_sno'].'" and exam_id=1 order by exam_roll_no';
			//echo $sql.'<br>';
			$result_sem_even = mysqli_query($db,$sql);
			if(mysqli_num_rows($result_sem_even)!=0){
					$row_sem_even = mysqli_fetch_assoc($result_sem_even);
			}
			else{
				$row_sem_even['sgpa']='';
			}
			
			//$html .= '<tr><td colspan="4">I SEM RESULT</td></tr>';
			
			$b_paper = NULL;

			$sql_update = 'UPDATE exam_student_info SET 
			max_marks = "'.$tot_max.'",
			obt_marks = "'.$tot_obt.'",
			passing_status = "'.$passing_status.'",
			sgpa = "",
			grade_point = "",
			`back_papers`="'.$b_paper.'" 
			WHERE sno = '.$row['id'];
			$result_update = mysqli_query($db, $sql_update);
			$html .= '</tr>
				</table>';
		}
		$html .= '</td>
	</tr>
</table>';
	$total_obt = 0;
	$total_max = 0;	
	$total_grade_credit_erned_point = 0;
	$passing_status = 'PASSED';	
	$passing_status_reason = 'EVERY THING FINE';
	$avg_credit = 0;
	$cocurricular_count = 0;
	$count_row = 0;	
	$final_result = array("html"=>$html, "data"=>$result_array);
	//print_r($backpaperArray);
	return $final_result;

	
}
?>