<?php
include("settings.php");
include("scripts/settings.php");
$info2=0;
	$sql = 'select * from exam_student_info where sno="'.$_GET['id'].'"';
	// echo $sql;
	$result_exam_student_info = mysqli_query($db, $sql);
	$student_exam_info = mysqli_fetch_assoc($result_exam_student_info);
	// echo $student_exam_info['sno'];
	
	
	
	 $sql2 = 'select * from exam_student_paper_info  where exam_student_info_sno = "'.$student_exam_info['sno'].'"';
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
	$db = $db;

		if(($class['sort_no']=='BA_SEM' || $class['sort_no']=='BSC_SEM' || $class['sort_no']=='BCOM_SEM') && ($class['year']=='1' || $class['year']=='2')){
			if($class['sort_no']=='BCOM_SEM'){
				$sql = 'select * from add_subject_details where class_id="'.$class['sno'].'" and type_status="1"';
				//echo $sql;
				$paper1 = mysqli_query($db, $sql);
				while($row_paper1 = mysqli_fetch_assoc($paper1)){
					if($row_paper1['type_status']=='1'){
						$sub_name = mysqli_fetch_assoc(mysqli_query($db, "select * from add_subject where sno=".$row_paper1['subject_id']));	
					}
					$papers[$i]['subject_name'] = $sub_name['subject'];
					$papers[$i++][] = $row_paper1;
				}
			}
			else{
				$sub1 = mysqli_fetch_assoc(mysqli_query($db, "select * from add_subject where sno=".$student_info['sub1']));
				$sub2 = mysqli_fetch_assoc(mysqli_query($db, "select * from add_subject where sno=".$student_info['sub2']));
				$sub3 = mysqli_fetch_assoc(mysqli_query($db, "select * from add_subject where sno=".$student_info['sub3']));
				

				$sql = 'select * from add_subject_details where class_id="'.$class['sno'].'" and subject_id="'.$sub1['sno'].'" and type_status="1"';
				//echo $sql;
				$paper1 = mysqli_query($db, $sql);
				while($row_paper1 = mysqli_fetch_assoc($paper1)){
					$papers[$i]['subject_name'] = $sub1['subject'];
					$papers[$i++][] = $row_paper1;
				}
				$papers[$i]['subject_name'] = $sub1['subject'];

				$sql = 'select * from add_subject_details where class_id="'.$class['sno'].'" and subject_id="'.$sub2['sno'].'" and type_status="1"';
				$paper2 = mysqli_query($db, $sql);
				while($row_paper2 = mysqli_fetch_assoc($paper2)){
					$papers[$i]['subject_name'] = $sub2['subject'];
					$papers[$i++][] = $row_paper2;
				}
				

				$sql = 'select * from add_subject_details where class_id="'.$class['sno'].'" and subject_id="'.$sub3['sno'].'" and type_status="1"';
				$paper3 = mysqli_query($db, $sql);
				while($row_paper3 = mysqli_fetch_assoc($paper3)){
					$papers[$i]['subject_name'] = $sub3['subject'];
					$papers[$i++][] = $row_paper3;
				}
			}	
			$sql = 'select add_subject2.subject, add_subject2.sno as subject_id from student_info_subject left join add_subject2 on add_subject2.sno = student_info_subject.subject_id where student_id="'.$student_info['sno'].'"';
				
			//echo $sql;
			$result_vocational_subs = mysqli_query($db, $sql);
			$vocational_subs = array();
			$ac=0;
			while($row_vocational_subs = mysqli_fetch_assoc($result_vocational_subs)){
				/*if($ac==1){
					$row_vocational_subs['subject_id']=31;
				}*/
				$sql = 'select * from add_subject_details where class_id="'.$student_info['class'].'" and type_status="2" and subject_id="'.$row_vocational_subs['subject_id'].'"';
				//echo $sql.'<br>';
				$result_subs = mysqli_query($db, $sql);
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
        //print_r($papers);
		if($student_info['class']==196 || $class['sno']=='209' || $class['sno']=='213' || $class['sno']=='225' || $class['sno']=='217' || $class['sno']=='221'){
			$papers = array();
			$sql = 'select * from exam_student_paper_info where exam_student_info_sno="'.$student_exam_info['sno'].'"';
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
				  padding: 3px !important;
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
			  padding:50px;
			}
		</style>
		<!-- <link rel="stylesheet" href="style.css" media="print"> -->
		<!-- googlefont -->
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,700&display=swap" rel="stylesheet" />
	</head>
	<body class="w-100 m-auto">
		<div class="" style="display:flex ; justify-content: center ;">
		  <button class="btn btn-secondary btn-print" style="width: 5%;" onclick="print()">Print</button>
		</div>
		<img src="images/college_log.png"  id="overlays" style=" z-index:-2;opacity:0.15;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%); width:30%;" alt="overlay image" >


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
			
				<table width="100%" style="margin:0px;">
					<tr>
						<th width="12%" rowspan="2"><img style="padding:15px; height:65px; width:65px; " src="images/college_log.png" alt="logo" class="img-fluid d-block m-auto" /> </th>
						<th width="88%">
							<h4 class="" style="text-align: center; margin:0px; " ><span style="font-size:17px;white-space:nowrap;" class="head-name"><b>Kamla Nehru Institute Of Physical & Social Sciences,Sultanpur, Uttar Pradesh</b></span> <br>An Autonomous Institute And Accredited "A" Grade by NAAC</h4>
						</th>
					</tr>
				</table>
				<!-- <hr> -->
				<?php $student_course = $student_exam_info['course_name']; ?>
				<div class="table-responsive ">
					<table  width="100%" class="table table-bordered border">
						<tr align="center">
							<th scope="col" colspan="5" >PROVISIONAL ADMIT CARD EXAMINATION 2023-24</th>
							
						</tr>
						
						<tr>
							<th scope="col"  >EXAM ROLL NO :</th>
							<td scope="col"   colspan="3"><?php echo $student_exam_info['exam_roll_no']; ?></td>
							<th scope="col"  width="20%" rowspan="8" ><?php echo $student_exam_info['exam_form_no']; ?><br><img src="<?php echo $stu_student_info['photo_id']; ?>"  style="height:110px; width:110px; margin-right:10px;"><br><img src="<?php echo $stu_student_info['signature_id']; ?>"  style="height:35px; width:110px; margin-right:10px;"></th>
						</tr>
						<tr>
							<th scope="col"  >ROLL NO (IN WORDS):</th>
							<td scope="col"   colspan="3">
							<?php
							foreach($words as $k=>$v){
							    echo strtoupper($ones[$v]).' ';
							    
							}
							?>
							</td>
						</tr>
						<tr>
							<th scope="col"  >COURSE:</th>
							<td scope="col"   colspan="3"><?php echo $class['class_description']; ?></td>
						</tr>
						<tr>
							<th scope="col"  >YEAR / SEMESTER </th>
							<td scope="col"   colspan="3">IInd SEMESTER</td>
						</tr>
						<tr>
							
							<th scope="col"  >UIN NUMBER:</th>
							<td scope="col"   ><?php echo $student_exam_info['uin_no']; ?></td>
							<th scope="col"  width="20%">STUDENT TYPE: </th>
							<td scope="col"  width="20%">REGULAR</td>
						</tr>
						
						<tr>
							<th scope="col"  width="20%">STUDENT NAME : </th>
							<td scope="col"  width="20%"><?php echo $student_info['stu_name']; ?></td>
							<th scope="col"  >FATHER'S/HUSBAND NAME :</th>
							<td scope="col"   > <?php echo $stu_student_info['father_name']; ?></td>
						</tr>
						<tr>
							<th scope="col" colspan="2" >COLLEGE STUDYING</th>
							<th scope="col"  colspan="2" >CENTER OF EXAMINATION</th>
						</tr>
						<tr>
							<th scope="col" colspan="2" >K.N.I.P.S.S.,SULTANPUR <br>COLLEGE CODE: 039</th>
							<th scope="col" colspan="2" >K.N.I.P.S.S.,SULTANPUR <br>COLLEGE CODE: 001</th>
						</tr>
						
						
					</table>
					<table  width="100%" class="table table-bordered border  " align="center">
						<tr align="center">
							<th scope="col" colspan="6" ><span style="font-size:12px; margin-top:10px;">Paper Details</span></th>
						</tr>
						<tr align="center">
							<th scope="col" width="5%" >Sno</th>
							<th scope="col" width="15%" >Date</th>
							<th scope="col"  width="15%" >Shift / Time</th>
							<?php if($student_course!=60){ ?>
							<th scope="col"  width="10%" >Paper Code</th>
							<?php } ?>
							<th scope="col" width="25%" >Subject</th>
							<th scope="col"  width="30%" >Paper Name</th>
						</tr>
						
						
						<?php
						$i=1;
						//print_r($papers);
						$scheme_array = array();
						foreach($papers as $key=>$val){
							foreach($val as $k=>$v){
								if($k!=='subject_name'){
									$sql = 'select * from exam_examination_scheme where add_subject_details_sno="'.$v['sno'].'" order by `date`';
									//echo $sql.'<br>';
									$scheme_result = mysqli_query($db, $sql);
									if(mysqli_num_rows($scheme_result)!=0){
									    $scheme = mysqli_fetch_assoc($scheme_result);
    									$scheme_array[$i]['date'] = $scheme['date'];
    									$scheme_array[$i]['time'] = $scheme['time'];
    									$scheme_array[$i]['shift'] = $scheme['shift'];
    									$scheme_array[$i]['paper_code'] = $scheme['paper_code'];
    									$scheme_array[$i]['subject'] = $scheme['subject'];
    									$scheme_array[$i]['paper_title'] = $scheme['paper_title'];
										$i++;
    									
    								}
								}
							}
						}

function date_compare($a, $b)
{
    $t1 = strtotime($a['date']);
    $t2 = strtotime($b['date']);
    return $t1 - $t2;
}
//$$scheme_array = usort($scheme_array, 'date_compare');
usort($scheme_array, 'date_compare');
						$i=1;
						foreach($scheme_array as $k=>$scheme){
							echo '<tr>
							<th>'.$i++.'</th>
							<th>'.date("d-m-Y", strtotime($scheme['date'])).'</th>
							<th>'.($scheme['shift']=='1'?'Morning':'Afternoon').' '.$scheme['time'].'</th>';
							if($student_course!=60){
							    	echo '<th>'.$scheme['paper_code'].'</th>';
							}
							echo'<th>'.$scheme['subject'].'</th>
							<th>'.$scheme['paper_title'].'</th>
							</tr>';
						}
						?>
						
					</table>
					<br>
					<table>
						<tr align="center">
							<th><span style="font-size:15px;">DISCLAIMER</span></th>
						</tr>
						<tr>
							<th>अभ्यर्थी द्वारा परीक्षा फॉर्म में पूरित विवरण के संस्थान से सत्यापणोपरांत यह प्रवेश पत्र संस्थान द्वारा निर्गत किया गया है जो औपबन्धिक है। उपरोक्त परीक्षा समय सारणी अपरिहार्य कारणों से संशोधित हो सकती है। अतः अभ्यर्थियों को उनके हित में सुझाव दिया जाता है कि संस्थान वेबसाइट का अवलोकन करते रहे तथा परीक्षा केंद्र के सम्पर्क में रहे ताकि अंतिम समय में कोई असुविधा न हो।</th>
						</tr>
						<tr align="right">
							<th><img src="images/principal_sign.jpg"  style="height:35px; width:90px; margin-right:10px;"><br>CONTROLLER OF EXAMINATION</th>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
