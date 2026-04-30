<?php
include("scripts/settings.php");
// include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
// page_header_start();
// page_header_end();
// page_sidebar();
function modified_int_to_words($x)
{
 global $nwords;
 if(!is_numeric($x))
 {
	 $w = '#';
 }else if(fmod($x, 1) != 0)
 {
	 $w = '#';
 }else{
	 if($x < 0)
	 {
		 $w = 'minus ';
		 $x = -$x;
	 }else{
		 $w = '';
	 }
	 if($x < 21)
	 {
		 $w .= $nwords[$x];
	 }else if($x < 100)
	 {
		 $w .= $nwords[10 * floor($x/10)];

		 $r = fmod($x, 10);
		 if($r > 0)
		 {
			 $w .= ' '. $nwords[$r];
		 }
	 } else if($x < 1000)
	 {
		 $w .= $nwords[floor($x/100)] .' hundred';
		 $r = fmod($x, 100);
		 if($r > 0)
		 {
			 $w .= ' and '. int_to_words($r);
		 }
	 } else if($x < 100000)
	 {
		 $w .= int_to_words(floor($x/1000)) .' thousand';
		 $r = fmod($x, 1000);
		 if($r > 0)
		 {
			 $w .= ' ';
			 if($r < 100)
			 {
				 $w .= 'and ';
			 }
			 $w .= int_to_words($r);
		 }
	 } else {
		 $w .= int_to_words(floor($x/100000)) .' lakh';
		 $r = fmod($x, 100000);
		 if($r > 0)
		 {
			 $w .= ' ';
			 if($r < 100)
			 {
				 $word .= 'and ';
			 }
			 $w .= int_to_words($r);
		 }
	 }
 }
 return $w;
}
?>
<?php
	$sql_allot_data = 'Select * from theory_marks_allotment where sno = "'.$_GET['id'].'"';
	$row_allot_data = mysqli_fetch_assoc(mysqli_query($db, $sql_allot_data));
	//echo $sql_allot_data;
	$sql_course = 'SELECT class_description,subject,paper_code,title_of_paper FROM `add_subject_details` LEFT JOIN class_detail on class_id=class_detail.sno LEFT JOIN add_subject on subject_id=add_subject.sno WHERE paper_code = "'.$row_allot_data['paper'].'"';
	$row_course = mysqli_fetch_assoc(mysqli_query($db, $sql_course));
	

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
		
		<title>Exam Theory Marks Report of Paper Code:<?php echo $row_course['paper_code'];?></title>

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
			#watermarks{
				width: 100%;
				height:100vh;
				background-image:url("images/college_log.png");
				background-repeat:no-repeat;
				background-position:center center;
				position:fixed;
				z-index:-2;
				opacity:0.13;
				background-size: 30%;
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
			   
				td{
				  padding: 4px 2px !important;
				}
				
				.print_no{
				 	 display:none !important;
				}
			
				.btn-print{
				 	 display:none;
				}
				#watermarks{
					
					background-size: 50%;
				}
				tbody>tr>td>table th{
					font-weight:bolder!important;
					font-size:0.75rem!important;
				}
				tbody>tr>td>table td{
					font-size:0.7rem!important;
				}

				@page {
					size: A4;
					margin-top: 20px; /* Adjust this margin based on your header height */
				}
					
			}

			@page{
				size: A4;
			
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
		<div id="watermarks">
			<!-- <img src="images/college_log.png"  id="overlays" style=" z-index:-2;opacity:0.15;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%); width:30%;" alt="overlay image" > -->
		</div>


		<div class="container-fluid m-auto cont ">
			<div class="container-fluid border">
				<table class="table table-bordered border-dark">
					<thead>
						<tr>
							<td colspan="8">
								<table width="100%" class="" style="margin:0px;" >
									<thead>
										<tr>
											<th width="12%" rowspan="2"><img style="padding:15px; height:65px; width:65px; " src="images/college_log.png" alt="logo" class="img-fluid d-block m-auto" /> </th>
											<th width="88%">
												<h4 class="" colspan="4" style="text-align: center; margin:0px; " ><span style="font-size:17px;white-space:nowrap;" class="head-name"><b>Kamla Nehru Institute Of Physical & Social Sciences,Sultanpur, Uttar Pradesh</b></span> <br>An Autonomous Institute And Accredited "A" Grade by NAAC</h4>
											</th>
										</tr>
									</thead>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="8">
								<table  width="100%" class="table table-bordered border-dark" >
						
									<tr align="center">
										<th scope="col" colspan="5" >AWARD SHEET EXAMINATION, <?php echo date("Y"); ?></th>
										
									</tr>
									
									<tr>
										<th scope="col"  >CENTER:</th>
										<td scope="col"   colspan="3">(001)&nbsp;&nbsp;K.N.I.P.S.S SULTANPUR</td>
										
									</tr>
									<tr>
										<th scope="col"  >COURSE:</th>
										<td scope="col"   colspan="3"><?php echo $row_course['class_description']; ?></td>
									</tr>
									<tr>
										<th scope="col"  width="15%">YEAR PART </br> PAPER: </th>
										<td scope="col"  width="55%"><?php echo $row_course['class_description'].' '.$row_course['subject'].'</br>'.$row_course['title_of_paper'].' - ('.$row_course['paper_code']; ?>)</td>
										<th scope="col" width="15%" style="font-weight:bolder;">MAX MARKS:  </th>
										<td scope="col" width="15%" style="font-weight:bolder;"><?php echo $row_allot_data['max_marks']; ?></td>
									</tr>
									<tr>
										<th scope="col"   >DATE :</th>
										<td scope="col" colspan="3"  ><?php echo date("d-m-Y"); ?></td>
									</tr>

								</table>
							</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="8">
								<table  width="100%" class="table table-bordered border-dark " align="center" id="bodys">
						
									
									<thead>		
										<tr align="center">
											<th scope="col" width="5%" >S.No.</th>
											<th scope="col" width="10%" >STUDENT TYPE</th>
											<th scope="col"  width="15%" >UIN NO.</th>
											<th scope="col"  width="15%" >ROLL NO.</th>
											<th scope="col" width="15%" >STUDENT NAME</th>
											<th scope="col"  width="15%" >FATHER NAME</th>
											<th scope="col"  width="10%" >MARKS (IN NUM.)</th>
											<th scope="col"  width="15%" >MARKS (IN WORDS)</th>
										</tr>
									</thead>
										<?php
											$sql_examiner = 'Select * from theory_marks_allotment where sno = "'.$_GET['id'].'"';
											$row_examiner = mysqli_fetch_assoc(mysqli_query($db, $sql_examiner));
										
											//$query = 'SELECT *,exam_student_paper_info.sno as stu_paper_id FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_info_sno=exam_student_info.sno  WHERE practicle_allotment ="'.$_GET['id'].'" AND paper_code ="'.$_GET['ppr'].'" ORDER BY exam_roll_no';
											$query = "SELECT 
												exam_student_paper_info.sno AS id, 
												exam_student_info.exam_roll_no, 
												exam_student_info.student_info_sno, 
												exam_student_info.student_type, 
												exam_student_info.student_name, 
												exam_student_paper_info.practicle_allotment, 
												exam_student_paper_info.paper_code,
												exam_student_paper_info.pt_marks_obt,
												exam_student_paper_info.title_of_paper,
												'R' AS student_paper_type
											FROM 
												exam_student_paper_info
											LEFT JOIN 
												exam_student_info 
											ON 
												exam_student_info_sno = exam_student_info.sno  
											WHERE 
												practicle_allotment ='".$_GET['id']."' AND paper_code ='".$_GET['ppr']."' AND exam_roll_no IS NOT NULL

											UNION 

											SELECT 
												back_exam_student_paper_info.sno AS id, 
												back_exam_student_info.exam_roll_no, 
												back_exam_student_info.student_info_sno, 
												back_exam_student_info.student_type, 
												back_exam_student_info.student_name, 
												back_exam_student_paper_info.practicle_allotment, 
												back_exam_student_paper_info.paper_code,
												back_exam_student_paper_info.pt_marks_obt,
												back_exam_student_paper_info.title_of_paper,
												'S' AS student_paper_type
											FROM 
												back_exam_student_paper_info 
											LEFT JOIN 
												back_exam_student_info 
											ON 
												exam_student_info_sno = back_exam_student_info.sno  
											WHERE 
												practicle_allotment ='".$_GET['id']."' AND paper_code ='".$_GET['ppr']."'
											ORDER BY 
												exam_roll_no ";
											//echo $query;
											$result =execute_query($db,$query);
											$i=1;
											while($row=mysqli_fetch_assoc($result)){
											$sql_stu_info = 'Select * from student_info where sno = "'.$row['student_info_sno'].'"';
											$row_stu_info = mysqli_fetch_assoc(mysqli_query($db, $sql_stu_info));
										?>
										<tr>
											<td><?php echo $i++.".";?></td>
											<td><?php echo $row['student_type'];?></td>
											<td><?php echo $row_stu_info['university_uin'];?></td>
											<td><?php echo $row['exam_roll_no'] ;?></td>
											<td><?php echo $row['student_name'];?></td>
											<td><?php echo $row_stu_info['father_name'] ;?></td>
											<td><?php echo $row['pt_marks_obt'] ;?></td>
											<td><?php echo strtoupper(modified_int_to_words($row['pt_marks_obt'])) ;?></td>
										</tr>
										<?php
											}	
											?>
									
								</table>	
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="8">
								<table  width="100%" class="border " id="footers" >
									<tfoot>
										<tr style="height:20px">
											<th scope="col" width="50%" style="padding-left:1rem!important;font-size:0.8rem!important;"><?php echo $row_examiner['examiner'] ;?></th>
											<th scope="col"  width="50%" style="text-align:right;padding-right:5rem!important; font-size:0.8rem!important;" ><?php echo $row_examiner['v_auth'] ;?></th>
										</tr>
										<tr style="height:20px">
											<th scope="col" width="50%" ></th>
											<th scope="col"  width="50%" ></th>
										</tr>
										<tr >
											<td scope="col" width="50%" >SIGNATURE OF EXAMINER</td>
											<td scope="col"  width="50%" style="text-align:right;padding-right:1rem!important;">SIGNATURE OF VERIFIER AUTHORITY</td>
										</tr>
										<tr >
											<th scope="col" colspan="2" >PRINTED ON: <?php echo date("d-m-Y H:i:s"); ?></th>
										</tr>
										<tr >
											<th scope="col" colspan="2" >NOTE: PLEASE SEND SIGNED COPY OF AWARD SHEET TO INSTITUTE AS SOON AS POSSIBLE. ADDRESS: CONTROLLER OF EXAMINATION KAMLA NEHRU INSTITUTE OF PHYSICAL & SOCIAL SCIENCES,SULTANPUR - 228118</th>
										</tr>
									</tfoot>
								</table>
							</td>
						</tr>
					</tfoot>
				</table>
				
			
				
				
				
					
				
			</div>
		</div>
	</body>
</html>
