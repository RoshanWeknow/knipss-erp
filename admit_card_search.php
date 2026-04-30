<?php
set_time_limit(0);
//session_cache_limiter('nocache');
//session_start();
include("settings.php");
 page_header();
$response=1;
$msg='';
?>
<?php
if(isset($_POST['submit'])){
	$exam_form_no = (isset($_POST['exam_form_no']) && ($_POST['exam_form_no']) != '') ? $_POST['exam_form_no'] : '';
	$dob = (isset($_POST['dob']) && ($_POST['dob']) != '') ? $_POST['dob'] : '';
	$sql = 'select * from exam_student_info where exam_form_no = "'.$exam_form_no.'" and dob = "'.$dob.'" and exam_roll_no is not null and exam_roll_no!="" and admit_card_allow="1" and admit_download="1"';
	//echo $sql;
	$result = mysqli_query($erp_link, $sql);
	
	
  //if($row['student_info_sno']!=''){
	if(mysqli_num_rows($result)==0){
		echo '<script>alert("Invalid Exam Form number or dob")</script>';
	}
	else{
		$row = mysqli_fetch_array($result);
		header('location: exam_admitcard_print.php?id='.$row['sno']);
	}
}
?>
<html>
	<body id="public">
		<div id="container" width="70%">
			<div class="card">
				<div class="card-body col-md-11  " style="background-color:#E5E4E2;">
					<div class="row ">
						<section class="content-header">
							<h1 style="color: #000!important;">Admit Card 2023-24 <br><span> </span></h1>
										 <br>
						</section>
						<section class="content-header" style="margin-top: -25px">
						</section>
						<form action="" class="wufoo leftLabel page1" name="admission_newadmission" enctype="multipart/form-data" method="POST" onSubmit="" >	
							<div class=" card card-body col-md-11 my-auto mx-auto" style="border-top-color: #d2d6de; background-color:whitesmoke;" >
								<div class="row mt-1">							
									<div class="col-md-6">							
										<label>Exam Form No. </label>
										<input type="text" name="exam_form_no" id="exam_form_no" class="form-control " value="" tabindex="" required />
									</div>
									<div class="col-md-6">							
										<label>Date Of Birth (dd/mm/yyyy) </label>
										<input type="date" name="dob" id="dob" class="form-control " value="" tabindex="" required />
									</div>
								</div>
								<div class="row mt-1">
									<div class="col-md-2">
								<button id="submit" name="submit" class=" btn btn-primary" type="submit" value="submit">Submit</button>
								<!--		<button class=" btn btn-danger" >Closed</button>--->
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>  
	</body>
</html>	
<?php
page_footer();
?>