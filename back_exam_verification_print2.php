<?php
$start = time();
function date_compare($a, $b)
{
    $t1 = strtotime($a['date']);
    $t2 = strtotime($b['date']);
    return $t1 - $t2;
}
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
		
		<title>Candidate Confirmation Form !</title>

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
			font-size: .6rem !important;
			}
			td{

			font-size: .6rem !important;
			}
			th{
			font-size: .6rem !important;
			}
			.paper{
			  text-align:left!important;
			}
			@media print {
				*{
				  margin: 0px !important;
				  margin-block: 2px !important;
				  padding: 2px !important;
				  box-sizing: border-box !important;
				}
				.head-name{
					font-size:15.5px !important;
				}
			   body{
				padding:0rem!important;
			   }
			   #overlays{
				   width:50%!important;
				   top: 40%!important;
				   -ms-transform: translate(-50%, -50%);
			   transform: translate(-50%, -50%);}
				td{
				  padding: 4px 2px !important;
				  /* margin: 10px !important; */
				}
				tr{
				}
				.print_no{
				  display:none !important;
				}
			
				.btn-print{
				  display:none;
				}
			
			}

			@page{
			size: A4;
			margin-inline:0;
			padding: 0;
			}
			.colgap{
			  padding:30px;
			}
		</style>
		<!-- <link rel="stylesheet" href="style.css" media="print"> -->
		<!-- googlefont -->
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,700&display=swap" rel="stylesheet" />
	</head>
	<body class="w-100 m-auto">
	
<?php		
include("scripts/settings.php");


		
		
$sql = 'select * from back_exam_student_info where course_name="'.$_GET['id'].'"  and exam_roll_no is not null and exam_roll_no!="" order by abs(exam_roll_no) limit '.$_GET['s'].', '.$_GET['c'];
//echo $sql;
$result_exam_student_info = mysqli_query($db, $sql);
while($student_exam_info = mysqli_fetch_assoc($result_exam_student_info)){
	$papers = array();
	
	$info2=0;
	// echo $student_exam_info['sno'];
	
	
	
	 $sql2 = 'select * from back_exam_student_paper_info  where exam_student_info_sno = "'.$student_exam_info['sno'].'"';
	// //echo $sql2;
	 $result_paper_info = mysqli_query($db, $sql2);
	 $stu_paper = mysqli_fetch_assoc($result_paper_info);
	// //echo $stu_paper['sno'];
	//echo $stu_paper['class_id'];
	
	
	
	$sql3 = 'select * from student_info where sno ="'.$student_exam_info['student_info_sno'].'"';
	 //echo $sql3;
	$result_student_info = mysqli_query($db, $sql3);
	$student_info = $stu_student_info = mysqli_fetch_assoc($result_student_info);
	$sql2 = 'select * from student_info2 where type="admission" and student_id ='.$student_info['sno'];
	//echo $sql2;
		$result2 = mysqli_query($db, $sql2);
		if(mysqli_num_rows($result2)!=0){
			$student_info2 = mysqli_fetch_array($result2);
			$student_info['class'] = $student_info2['class'];
			$student_info['sub1'] = $student_info2['sub1'];
			$student_info['sub2'] = $student_info2['sub2'];
			$student_info['sub3'] = $student_info2['sub3'];
			$student_info['student_id'] = $student_info2['student_id'];
			$info2 = 1;
		}
	// echo $stu_student_info['sno'];
//echo '<h1>'.$info2;
$student_info['class'] = $student_exam_info['course_name'];
	$sql4 = 'select * from class_detail where sno ="'.$student_info['class'].'"';
	 //echo $sql4;
	$result_class = mysqli_query($db, $sql4);
	$class = mysqli_fetch_assoc($result_class);
	//echo $class;
	//print_r($result_class);
	
	$ones = array( 
	    0 => "zero",
        1 => "one", 
        2 => "two", 
        3 => "three", 
        4 => "four", 
        5 => "five", 
        6 => "six", 
        7 => "seven", 
        8 => "eight", 
        9 => "nine"
    );
    $words = str_split($student_exam_info['exam_roll_no'], 1);
    //print_r($words);
$i=1;

$erp_link = $db;

		if(($class['sort_no']=='BA_SEM' || $class['sort_no']=='BSC_SEM' || $class['sort_no']=='BCOM_SEM') && ($class['year']=='1' || $class['year']=='3')){
			if($class['sort_no']=='BCOM_SEM'){
				$sql = 'select * from add_subject_details where class_id="'.$class['sno'].'" and type_status="1"';
				//echo $sql;
				$paper1 = mysqli_query($erp_link, $sql);
				while($row_paper1 = mysqli_fetch_assoc($paper1)){
					if($row_paper1['type_status']=='1'){
						$sub_name = mysqli_fetch_assoc(mysqli_query($erp_link, "select * from add_subject where sno=".$row_paper1['subject_id']));	
					}
					$papers[$i]['subject_name'] = $sub_name['subject'];
					$papers[$i++][] = $row_paper1;
				}
			}
			else{
				$sub1 = mysqli_fetch_assoc(mysqli_query($erp_link, "select * from add_subject where sno=".$student_info['sub1']));
				$sub2 = mysqli_fetch_assoc(mysqli_query($erp_link, "select * from add_subject where sno=".$student_info['sub2']));
				$sub3 = mysqli_fetch_assoc(mysqli_query($erp_link, "select * from add_subject where sno=".$student_info['sub3']));
				

				$sql = 'select * from add_subject_details where class_id="'.$class['sno'].'" and subject_id="'.$sub1['sno'].'" and type_status="1"';
				//echo $sql;
				$paper1 = mysqli_query($erp_link, $sql);
				while($row_paper1 = mysqli_fetch_assoc($paper1)){
					$papers[$i]['subject_name'] = $sub1['subject'];
					$papers[$i++][] = $row_paper1;
				}
				$papers[$i]['subject_name'] = $sub1['subject'];

				$sql = 'select * from add_subject_details where class_id="'.$class['sno'].'" and subject_id="'.$sub2['sno'].'" and type_status="1"';
				$paper2 = mysqli_query($erp_link, $sql);
				while($row_paper2 = mysqli_fetch_assoc($paper2)){
					$papers[$i]['subject_name'] = $sub2['subject'];
					$papers[$i++][] = $row_paper2;
				}
				

				$sql = 'select * from add_subject_details where class_id="'.$class['sno'].'" and subject_id="'.$sub3['sno'].'" and type_status="1"';
				$paper3 = mysqli_query($erp_link, $sql);
				while($row_paper3 = mysqli_fetch_assoc($paper3)){
					$papers[$i]['subject_name'] = $sub3['subject'];
					$papers[$i++][] = $row_paper3;
				}
			}	
			$sql = 'select add_subject2.subject, add_subject2.sno as subject_id from student_info_subject left join add_subject2 on add_subject2.sno = student_info_subject.subject_id where student_id="'.$student_info['sno'].'"';
				
			//echo $sql;
			$result_vocational_subs = mysqli_query($erp_link, $sql);
			$vocational_subs = array();
			$ac=0;
			while($row_vocational_subs = mysqli_fetch_assoc($result_vocational_subs)){
				/*if($ac==1){
					$row_vocational_subs['subject_id']=31;
				}*/
				$sql = 'select * from add_subject_details where class_id="'.$student_info['class'].'" and type_status="2" and subject_id="'.$row_vocational_subs['subject_id'].'"';
				//echo $sql.'<br>';
				$result_subs = mysqli_query($erp_link, $sql);
				//echo mysqli_num_rows($result_subs)
				if(mysqli_num_rows($result_subs)!=0){
					while($row_subs = mysqli_fetch_assoc($result_subs)){
						$papers[$i]['subject_name'] = $row_vocational_subs['subject'];
						//echo $row_vocational_subs['subject'].'<br>';
						$papers[$i++][] = $row_subs;
					}
				}
				//$vocational_subs[$row_vocational_subs['subject_type']] = $row_vocational_subs['subject'];
				$ac++;
			}
			
			//print_r($papers);
		}
		else{
			$sql = 'select * from add_subject_details where class_id="'.$class['sno'].'"';
			$paper1 = mysqli_query($erp_link, $sql);
			while($row_paper1 = mysqli_fetch_assoc($paper1)){
				if($row_paper1['type_status']=='1'){
					$sub_name = mysqli_fetch_assoc(mysqli_query($erp_link, "select * from add_subject where sno=".$row_paper1['subject_id']));	
				}
				elseif($row_paper1['type_status']=='2'){
					$sub_name = mysqli_fetch_assoc(mysqli_query($erp_link, "select * from add_subject2 where sno=".$row_paper1['subject_id']));
				}
			
				$papers[$i]['subject_name'] = $sub_name['subject'];
				$papers[$i++][] = $row_paper1;
			}


		}
		if($student_info['class']==196 || $class['sno']=='209' || $class['sno']=='213' || $class['sno']=='225' || $class['sno']=='217' || $class['sno']=='221' || $class['sno']=='246'){
			$papers = array();
			$sql = 'select * from back_exam_student_paper_info where exam_student_info_sno="'.$student_exam_info['sno'].'"';
			$paper_env = mysqli_query($db, $sql);
			while($row_paper_env = mysqli_fetch_assoc($paper_env)){
				$sql = 'select * from add_subject_details where paper_code="'.$row_paper_env['paper_code'].'" and class_id="'.$row_paper_env['class_id'].'"';
				//echo $sql.'<br>';
				$paper1 = mysqli_query($db, $sql);
				while($row_paper1 = mysqli_fetch_assoc($paper1)){
					if($row_paper1['type_status']=='1'){
						$sub_name = mysqli_fetch_assoc(mysqli_query($db, "select * from add_subject where sno=".$row_paper1['subject_id']));	
					}
					elseif($row_paper1['type_status']=='2'){
						$sub_name = mysqli_fetch_assoc(mysqli_query($db, "select * from add_subject2 where sno=".$row_paper1['subject_id']));
					}

					$papers[$i]['subject_name'] = $sub_name['subject'];
					$papers[$i++][] = $row_paper1;
				}
			}
			
		}
		
		
		
		
		
			//echo $stu_student_info['photo_id'];
			//echo "PHOTO/".ceil($_GET['id']/1000).'/'.$stu_student_info['sno'].'.jpeg';
	if(fileExists("PHOTO/".$stu_student_info['photo_id'])){
	    //echo '11111111111';
	    $photo = fileExists("PHOTO/".$stu_student_info['photo_id']);
	    $sign = fileExists("PHOTO/".$stu_student_info['signature_id']);
		//$photo = "PHOTO/".$stu_student_info['photo_id'];
		//$sign = "PHOTO/".$stu_student_info['signature_id'];
	}
	elseif(fileExists("PHOTO/".ceil($stu_student_info['sno']/1000).'/'.$stu_student_info['sno'].'.jpg')){
	    //echo '2222222222222';
		$photo = fileExists("PHOTO/".ceil($stu_student_info['sno']/1000).'/'.$stu_student_info['sno'].'.jpg');
		$sign = fileExists("PHOTO/".ceil($stu_student_info['sno']/1000).'/'.$stu_student_info['sno'].'_sign.jpg');
	}
	elseif(fileExists("PHOTO/".ceil($stu_student_info['sno']/1000).'/'.$stu_student_info['sno'].'.jpeg')){
	    //echo '33333333333333';
		$photo = fileExists("PHOTO/".ceil($stu_student_info['sno']/1000).'/'.$stu_student_info['sno'].'.jpeg');
		$sign = fileExists("PHOTO/".ceil($stu_student_info['sno']/1000).'/'.$stu_student_info['sno'].'_sign.jpeg');
	}
	elseif(fileExists($stu_student_info['photo_id'])){
	    //echo '4444444444444444';
		$photo = fileExists($stu_student_info['photo_id']);
	    $sign = fileExists($stu_student_info['signature_id']);
	}
	else{
	    if($class['semester']== "1"){
			$sql = 'select * from admission_student_info where uin ="'.$student_info['university_uin'].'"';
			$result_img = mysqli_fetch_assoc(mysqli_query($uin_link, $sql));
		}else{
			$sql = 'select * from admission_student_info where uin ="'.$student_info['university_uin'].'"';
			$result_img = mysqli_fetch_assoc(mysqli_query($db2, $sql));
		}	
	    //echo '555555555555555';
		$photo = "PHOTO/".$stu_student_info['sno'].'.jpg';
		$photo = "https://knipssexams.in/".$result_img['photo'];
		$sign = "PHOTO/".$stu_student_info['sno'].'_sign.jpg';
		$sign = "https://knipssexams.in/".$result_img['signature'];
		
	}

?>

    <div  style="page-break-after: always; background: url(images/watermark_verification.png) no-repeat center;">
    <div class="container-fluid m-auto cont ">
        <div class="container-fluid border">
            <!-- <div class="row  d-flex align-items-center">
				  <div class="col-2 ">
					<img src="images/logo.gif" alt="logo" class="img-fluid w-75 m-1" />
				  </div>
				  <div class="col-11">
					<h3 class="" style="text-align: center;"><b>Kamla Nehru Institute Of Physical & Social Sciences,Sultanpur, Uttar Pradesh<b></h3>
					<h4 style="text-align: center;"><b>An Autonomous Institute</b></h4>
				  </div>
				</div>-->

            <table class="border-dark" width="100%" style="margin:0px;">
                <tr>
                    <th width="12%" rowspan="2"><img style="padding:15px; height:65px; width:65px; "
                            src="images/college_log.png" alt="logo" class="img-fluid d-block m-auto" /> </th>
                    <th width="88%">
                        <h4 class="" style="text-align: center; margin:0px; "><span
                                style="font-size:17px;white-space:nowrap;" class="head-name"><b>Kamla Nehru Institute Of
                                    Physical & Social Sciences,Sultanpur, Uttar Pradesh</b></span> <br>An Autonomous
                            Institute And Accredited "A" Grade by NAAC</h4>
                    </th>
                </tr>
            </table>
            <!-- <hr> -->
            <?php $student_course = $student_exam_info['course_name']; ?>
            <div class="table-responsive ">
                <table width="100%" class="table table-bordered border border-dark">
                    <tr align="center">
                        <th scope="col" colspan="5">VERIFICATION - 2024-25</th>

                    </tr>

                    <tr>
                        <th scope="col">EXAM ROLL NO :</th>
                        <td scope="col" colspan="3"><?php echo $student_exam_info['exam_roll_no']; ?></td>
                        <th scope="col" width="20%" rowspan="8">
                            <?php echo $student_exam_info['exam_form_no']; ?><br>
                            <?php if($class['semester']=="1" || $class['semester']=="3"){?>
                            <img src="<?php echo $photo; ?>" style="height:110px; width:110px; margin-right:10px;"><br>
                            <img src="<?php echo $sign; ?>"   style="height:35px; width:110px; margin-right:10px;">
                             <?php }else{ ?>
                             <img src="<?php echo $photo; ?>" style="height:110px; width:110px; margin-right:10px;"><?php echo $stu_student_info['photo_id']; ?><br>
                            <img src="<?php echo  $stu_student_info['signature_id']; ?>"   style="height:35px; width:110px; margin-right:10px;">
                             <?php } ?>
                                <br><img src="images/principal_sign.jpg"
                                style="height:25px; width:90px; margin-right:10px;"><br><span
                                style="font-size:7px;">CONTROLLER OF EXAMINATION<span></th>
                    </tr>
                    <tr>
                        <th scope="col">ROLL NO (IN WORDS):</th>
                        <td scope="col" colspan="3">
                            <?php
							foreach($words as $k=>$v){
							    echo strtoupper($ones[$v]).' ';
							    
							}
							?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">COURSE:</th>
                        <td scope="col" colspan="3"><?php echo $class['group_name']; ?></td>
                    </tr>
                    <tr>
                        <th scope="col">YEAR / SEMESTER </th>
                        <?php
							$semester = $class['semester'];
							if ($semester == 1) {
								$suffix = "st";
							} elseif ($semester == 2) {
								$suffix = "nd";
							} elseif ($semester == 3) {
								$suffix = "rd";
							} else {
								$suffix = "th";
							}
							?>

							<td scope="col" colspan="3">
								<?php echo $semester . " " . $suffix; ?> SEMESTER
							</td>
                    </tr>
                    <tr>

                        <th scope="col">UIN NUMBER:</th>
                        <td scope="col"><?php echo $student_exam_info['uin_no']; ?></td>
                        <th scope="col" width="20%">STUDENT TYPE: </th>
                        <td scope="col" width="20%">REGULAR</td>
                    </tr>

                    <tr>
                        <th scope="col" width="20%">STUDENT NAME : </th>
                        <td scope="col" width="20%"><?php echo $student_exam_info['student_name']; ?></td>
                        <th scope="col">FATHER'S/HUSBAND NAME :</th>
                        <td scope="col"> <?php echo $stu_student_info['father_name']; ?></td>
                    </tr>
                    <tr>
                        <th scope="col" colspan="2">COLLEGE STUDYING</th>
                        <th scope="col" colspan="2">CENTER OF EXAMINATION</th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="2">K.N.I.P.S.S.,SULTANPUR <br>COLLEGE CODE: 039</th>
                        <th scope="col" colspan="2">K.N.I.P.S.S.,SULTANPUR <br>COLLEGE CODE: 001</th>
                    </tr>


                </table>
                <table width="100%" class="table table-bordered border border-dark " align="center">
                    <tr align="center">
                        <th scope="col" colspan="6"><span style="font-size:12px; margin-top:10px;">Paper Details</span>
                        </th>
                    </tr>
                    <tr align="center">
                        <th scope="col" width="5%">Sno</th>
                        <th scope="col" width="15%">Date</th>
                        <th scope="col" width="15%">Shift / Time</th>
                        <?php if($student_course!=60){ ?>
							<th scope="col"  width="10%" >Paper Code</th>
							<?php } ?>
                        <th scope="col" width="25%">Subject</th>
                        <th scope="col" width="30%">Paper Name</th>
                    </tr>
                    <?php
						$j = 1;

							// SQL query with JOIN and DISTINCT
							$sql = 'SELECT DISTINCT 
										esp.paper_code, 
										ees.date, 
										ees.shift, 
										ees.time, 
										ees.subject, 
										ees.paper_title
									FROM 
										back_exam_student_paper_info AS esp
									INNER JOIN 
										exam_examination_scheme AS ees 
									ON 
										esp.paper_code = ees.paper_code AND esp.title_of_paper = ees.paper_title
									INNER JOIN 
										exam_student_info AS esi
									ON 
										esp.exam_student_info_sno = esi.sno
									WHERE 
										esp.theory_practical != "Practical" 
										AND esp.exam_student_info_sno = "' . $student_exam_info['sno'] . '"
										AND ees.class = "' . $class['class_description'] . '"
									ORDER BY 
										ees.date';
										//echo $sql;

							$result = mysqli_query($erp_link, $sql);

							while ($row = mysqli_fetch_assoc($result)) {
								// Adjust time based on conditions
								$time = ($row['paper_code'] == "KZ010101T" || $row['paper_code'] == "KZ030301T") && $stu_student_info['gender'] == "M"
									? "11:30"
									: $row['time'];

								// Output row
								echo '<tr>
										<th>' . $j++ . '</th>
										<th>' . date("d-m-Y", strtotime($row['date'])) . '</th>
										<th>' . ($row['shift'] == '1' ? 'Morning' : 'Afternoon') . ' ' . $time . '</th>';

								if ($student_course != 60) {
									echo '<th>' . $row['paper_code'] . '</th>';
								}

								echo '<th>' . $row['subject'] . '</th>
									  <th>' . $row['paper_title'] . '</th>
									</tr>';
							}
						?>

                </table>
                <style>
                
                </style>
                <table width="100%" class="table table-bordered border-dark">
                    <tr align="center">
                        <th colspan="8">RECORD OF ATTENDANCE IN THE EXAMINATION HALL</th>
                    </tr>
                    <tr align="center">
                        <th scope="col" width="5%">Sno</th>
                        <th scope="col" width="10%">Date</th>
                        <th scope="col" width="25%">Subject</th>
                        <th scope="col" width="10%">Paper</th>
                        <th scope="col" width="10%">Answer Booklet No.</th>
                        <th scope="col" width="10%">Room No.</th>
                        <th scope="col" width="15%">Signature of Condidate</th>
                        <th scope="col" width="15%">Signature of Invigilator</th>
                    </tr>
                    <tr>
                        <th class="pading" scope="col" class="colgap ">1</th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                    </tr>
                    <tr>
                        <th class="pading" scope="col" class="colgap ">2</th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                    </tr>
                    <tr>
                        <th class="pading" scope="col" class="colgap ">3</th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                    </tr>
                    <tr>
                        <th class="pading" scope="col" class="colgap ">4</th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                    </tr>
                    <tr>
                        <th class="pading" scope="col" class="colgap ">5</th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                    </tr>
                    <tr>
                        <th class="pading" scope="col" class="colgap ">6</th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                    </tr>
                    <tr>
                        <th class="pading" scope="col" class="colgap ">7</th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                    </tr>
                    <tr>
                        <th class="pading" scope="col" class="colgap ">8</th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                    </tr>
                    <tr>
                        <th class="pading" scope="col" class="colgap ">9</th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                    </tr>
                    <tr>
                        <th class="pading" scope="col" class="colgap ">10</th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                    </tr>
                    <tr>
                        <th class="pading" scope="col" class="colgap ">11</th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                    </tr>
                    <tr>
                        <th class="pading" scope="col" class="colgap ">12</th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                    </tr>
                    <tr>
                        <th class="pading" scope="col" class="colgap ">13</th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                    </tr>
                    <tr>
                        <th class="pading" scope="col" class="colgap ">14</th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                    </tr>
                    <tr>
                        <th class="pading" scope="col" class="colgap ">15</th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                        <th class="pading" scope="col"></th>
                    </tr>
                </table>
            </div>

        </div>
    </div>
    <br><br>
    <h6 style="text-align:right;margin-top:10px;margin-right:1rem;margin-bottom:0;">Signature of Centre Superintendent
        With Seal</h6>
		</div>
<?php } ?>
	</body>
</html>
<?php
	//echo "Time Taken : ".time()-$start;
?>