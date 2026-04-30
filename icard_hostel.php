<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate('admin');
page_header_start();
$response=1;
$msg='';
$sql_session = 'SELECT * FROM `general_settings` WHERE `description`="session"';
$result_session = execute_query(connect(), $sql_session);
$row_session = mysqli_fetch_array($result_session);
$current_session = $row_session['value'];
if(isset($_POST['submit'])){
	$sql="insert into icard_hostel (student_id, created_by, creation_time) values ('".$_POST['student_id']."', '".$_SESSION['username']."', '".$_POST['icard_date']."')";
	execute_query(connect(), $sql);
	//echo $sql;
	if(mysqli_error()){
		$msg .= '<h3>Error # 1. '.mysqli_error().' >> '.$sql;
	}
	$response=1;
	if($msg==''){
		$msg .= '<li class="error">Identity Card Generated succesfully.</li>';
		$msg .= '<li class="error"><a href="icard_print_hostler.php?id='.$_POST['student_id'].'" target="_blank">Click Here to print.</a></li>';
		$msg .= '<script>window.open("icard_print_hostler.php?id='.$_POST['student_id'].'");</script>';
	}
}
if(isset($_GET['id'])){
	//echo $_GET['id'];
	$sql = "select student_info.sno as sno, class_description, class_detail.category as class_category, student_info.roll_no as roll_no, student_info.form_no, student_info.e_mail1 as e_mail, student_info.stu_name, student_info.father_name, student_info.dob, student_info.sub1, student_info.sub2, student_info.sub3, student_info.photo_id as photo_id, student_info.p_house_no as house_no, student_info.p_village as village, student_info.p_post as post, student_info.p_district as district, student_info.p_state as state, blood_group, aadhar as aadhar_no, p_mobile as mobile, university_uin as university_uin2 from student_info left join class_detail on class_detail.sno = student_info.class where student_info.sno=".$_GET['id'];
	//echo $sql.'<br>';
	$stu_id = mysqli_fetch_assoc(execute_query(connect(), $sql));
	
	$sql_uin = 'select uin_data.p_house_no as house_no, uin_data.p_village as village, uin_data.p_post as post, uin_data.p_district as district, uin_data.p_state as state, uin_data.aadhar as aadhar_no, blood_group, university_uin2, mobile as mobile from uin_data where student_id="'.$stu_id['sno'].'" order by `sno` desc limit 1';
	//echo $sql_uin;
	$uin_data = execute_query(connect(), $sql_uin);
	if(mysqli_num_rows($uin_data)!=0){
		$uin_data = mysqli_fetch_assoc($uin_data);
	}
	else{
		$uin_data = array();
	}
	//print_r($stu_id);
	//echo $sql_uin.'<br>';
	
	$sql = 'select `student_info2`.`sno` as serial, `student_id` as `sno`, class_description, class_detail.category as class_category, student_info2.roll_no as roll_no, student_info2.form_no, student_info2.e_mail1 as e_mail, student_info2.stu_name, student_info2.father_name, student_info2.dob, student_info2.sub1, student_info2.sub2, student_info2.sub3, student_info2.photo_id as photo_id  from student_info2 left join class_detail on class_detail.sno = student_info2.class where status=2 and student_id='.$stu_id['sno'].' and `student_info2`.type="subject_change"';
	//echo $sql.'<br/>';
	$r_chk = execute_query(connect(), $sql);
	$row_chk = mysqli_num_rows($r_chk);
	if($row_chk!=0){
		//echo 'hello<br/>';
		$stu_id2 = mysqli_fetch_assoc($r_chk);
		$stu_id['class_description'] = $stu_id2['class_description'];
		$stu_id['sub1'] = $stu_id2['sub1'];
		$stu_id['sub2'] = $stu_id2['sub2'];
		$stu_id['sub3'] = $stu_id2['sub3'];
		$stu_id['roll_no'] = $stu_id2['roll_no'];
		//print_r ($stu_id2);
	}
	//print_r ($stu_id);
	echo '<br><br>';
	$stu_id = array_merge($stu_id,$uin_data);
	//print_r ($stu_id);
	
	if(file_exists("PHOTO/".$stu_id['photo_id'])){
		$photo = "PHOTO/".$stu_id['photo_id'];
	}
	else{
		$photo = "PHOTO/".$stu_id['sno'].'.jpg';
	}
	$response=2;
}

if(isset($_POST['save']) or isset($_GET['stu'])) {
	if($_POST['stu_name']!='' && $_POST['father_name']!=''){
		$sql="select student_info.sno as sno, stu_name, father_name, class_description, form_no, roll_no, icard, icard_date, status from student_info left join class_detail on class_detail.sno = student_info.class where stu_name like '".$_POST['stu_name']."%' and father_name like '".$_POST['father_name']."%'";
	}
	else if($_POST['roll_no']!=''){
		$sql="select student_info.sno as sno, stu_name, father_name, class_description, form_no, roll_no, icard, icard_date, status from student_info left join class_detail on class_detail.sno = student_info.class where roll_no='".$_POST['roll_no']."'";
	}
	else{
		$sql="select student_info.sno as sno, stu_name, father_name, class_description, form_no, roll_no, icard, icard_date, status from student_info left join class_detail on class_detail.sno = student_info.class where form_no='".$_POST['stu_id']."'"; 
	}
	if($_SESSION['username']!='sadmin'){
		//$sql .= ' and user_id = "'.$_SESSION['username'].'"';
	}
	//echo $sql;
    $result = execute_query(connect(), $sql);
	$i=1;
				
	$msg .= '		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white">
		<th>Sno</th>
		<th>Student Name</th>
		<th>Father Name</th>
		<th>Class</th>
		<th>Form No.</th>
		<th>Roll No.</th>
		<th>I-Card</th>
		<th></th>
		<th>Edit</th>
	</tr>';
	while($stu = mysqli_fetch_array($result)){
		$stat = $stu['status'];
		$sql = 'select `student_id` as `sno`, `stu_name`, `father_name`, `class_description`, `form_no` from student_info2 join class_detail on class_detail.sno = student_info2.class where status=2 and student_id='.$stu['sno'];
		$r_chk = execute_query(connect(), $sql);
		$row_chk = mysqli_num_rows($r_chk);
		if($row_chk!=0){
			$stu = mysqli_fetch_array($r_chk);
		}
		
		$sql = 'select * from icard_hostel where student_id="'.$stu['sno'].'"';
		$result_icard = execute_query(connect(), $sql);
		if(mysqli_num_rows($result_icard)!=0){
			$row_icard = mysqli_fetch_assoc($result_icard);
		}
		else{
			$row_icard['created_by']='';
			$row_icard['creation_time']='';
		}
		
		if($row_icard['created_by']!=''){
			$icard = '<span style="color:#0f0;">'.$row_icard['creation_time'].'</span>';
			$status = '<span style="color:#0f0;">Generated By '.$row_icard['created_by'].'</span>';
		}
		else{
			$icard = '<span style="color:#f00;">Not Delivered</span>';
			$status='';
		}
		$msg .= '<tr>
		<td>'.$i++.'</td>
		<td>'.$stu['stu_name'].'</td>
		<td>'.$stu['father_name'].'</td>
		<td>'.$stu['class_description'].'</td>
		<td>'.$stu['form_no'].'</td>
		<td>'.$stu['roll_no'].'</td>
		<td>'.$icard.'</td>
		<td>'.$status.'</td>
		<td><a href="icard_hostel.php?id='.$stu['sno'].'">'.$stu['sno'].'</td>
		</tr>';
	    }

		$msg .= '</table></div>';
	
		$response=1;
}

page_footer_end();
page_sidebar();
?>

<script language="javascript" type="text/javascript">
	
	$( "#sale_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$("#sale_date").change(function(){
		$( "#sale_date" ).datepicker("option", "showAnim", "slide");
	});

</script>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
<div id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<?php
				switch($response){
					case 1:{
				?>
				<form action="icard_hostel.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off" >
					<h2>Hostel Identity <span class="orange">Card</span></h2>	
					<div class="col-md-12">
						<table width="100%" class="table table-striped table-hover rounded">
							<tr class="text-start table-primary">
								<th width="20%">Enter Form No.</th>
								<th width="20%"><input type="text" class="form-control" name="stu_id" id="stu_id" ></th>
								<th width="15%" class="text-center">OR*</th>
								<th width="25%">Enter Roll No.</th>
								<th width="20%"><input type="text" class="form-control" name="roll_no" id="roll_no" ></th>
							</tr>
							<tr class="text-start ">
								<th colspan="5" class="text-center">OR*</th>
								
							</tr>
							<tr class="text-start table-primary">
								<th >Enter Student Name</th>
								<th ><input type="text" class="form-control" name="stu_name" id="stu_name" ></th>
								<th  class="text-center">AND*</th>
								<th >Enter Father Name/Husband Name.</th>
								<th ><input type="text" class="form-control" name="father_name" id="father_name" ></th>
							</tr>
						</table>
						<input type="submit" class="submit btn btn-primary" name="save" value="Submit" />
						
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="card">
	<?php echo $msg;?>
	</div>
</div>

		<?php 
			break;
		}
		case 2:{

		?>
			<script language="javascript" type="text/javascript">
				function form_cancel(){
					window.location = 'icard_hostel.php';
				}
			</script>
<div id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form action="icard_hostel.php" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" method="post">
					<h2 >Complete Detail of the <span class="orange">Admission</span></h2> 
					<h1 align="center">KAMLA NEHRU INSTITUTE OF PHYSICAL & SOCIAL SCIENCES</h1>
					<h3 align="center">Sultanpur (U.P.) - 228 118 Tel.: 05362-240854</h3>
					<h3 align="center">Accredited by "NAAC" with 'A' Grade</h3>
					<h3>HOSTEL IDENTITY CARD <?php echo $current_session; ?></h3>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Class :</label>
								<input type="text" class="form-control" name="class_description" value="<?php echo $stu_id['class_description']; ?>">
							</div>
							<div class="col-md-4">							
								<label>Ledger :</label>
								<input type="text" class="form-control" name="roll_no" value="<?php echo $stu_id['roll_no']; ?>">
							</div>
							<div class="col-md-4">							
								<label></label>
								<img src="<?php echo $photo; ?>" style="height:100px;"/>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Student Name : </label>
								<input type="text" class="form-control" name="stu_name" value="<?php echo $stu_id['stu_name']; ?>">
							</div>
							<div class="col-md-4">							
								<label>Father Name :</label>
								<input type="text" class="form-control" name="father_name" value="<?php echo $stu_id['father_name']; ?>">
							</div>
							<div class="col-md-4">							
								<label>Date of Birth :</label>
								<script  type="text/javascript" language="javascript">document.writeln(DateInput('dob', 'dob', true, 'YYYY-MM-DD', '2023-02-27', 2));</script>
								<input type="dob" class="form-control" name="dob" value="<?php echo $stu_id['dob']; ?>">
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Blood Group :</label>
								<input type="text" class="form-control" name="blood_group" value="<?php echo $stu_id['blood_group']; ?>">
							</div>
							<div class="col-md-4">							
								<label>Subjects : </label>
								<input type="text" class="form-control" name="class_category" value="<?php 
									if($stu_id['class_category']=='PG'){
										$pg = mysqli_fetch_array(execute_query(connect(), "select * from pg_subject where student_id=".$stu_id['sno']));
										$pgsub1 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub1']."'"))['subject'];
										$pgsub2 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub2']."'"))['subject'];
										$pgsub3 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub3']."'"))['subject'];
										$pgsub4 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub4']."'"))['subject'];
										$pgsub5 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub5']."'"))['subject'];
										$pgsub6 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub6']."'"))['subject'];
										$pgsub = array();
										if($pgsub1!=''){
											$pgsub[] = $pgsub1;
										}
										if($pgsub2!=''){
											$pgsub[] = $pgsub2;
										}
										if($pgsub3!=''){
											$pgsub[] = $pgsub3;
										}
										if($pgsub4!=''){
											$pgsub[] = $pgsub4;
										}
										if($pgsub5!=''){
											$pgsub[] = $pgsub5;
										}
										if($pgsub6!=''){
											$pgsub[] = $pgsub6;
										}
										$pgsub = implode(", ", $pgsub);
										echo $pgsub;
									}
									else{
										echo get_subject_detail($stu_id['sub1'])['subject']; 
										if($stu_id['sub2']!=''){
											echo ', '.get_subject_detail($stu_id['sub2'])['subject']; 
										}
										if($stu_id['sub3']!=''){
											echo ', '.get_subject_detail($stu_id['sub3'])['subject']; 
										}
									}
									
									?>">
							</div>
							<div class="col-md-4">							
								<label>Aadhar No. :</label>
								<input type="text" class="form-control" name="aadhar_no" value="<?php echo $stu_id['aadhar_no']; ?>">
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>UIN :</label>
								<input type="text" class="form-control" name="university_uin2" value="<?php echo $stu_id['university_uin2']; ?>">
								<img src="images/sign.png" style="height: 50px;"><br/>Proctor's Signature
							</div>
							<div class="col-md-4">							
								<label>E-Mail :</label>
								<input type="text" class="form-control" name="e_mail" value="<?php echo $stu_id['e_mail']; ?>">
							</div>
							<div class="col-md-4">							
								<label>Mobile :</label>
								<input type="text" class="form-control" name="mobile" value="<?php echo $stu_id['mobile']; ?>">
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<label>Date of Identity Card :</label>
								<input type="date" class="form-control" name="icard_date" value="<?php if(isset($_POST['icard_date'])){echo $_POST['icard_date'];}else{echo date("Y-m-d");} ?>">
							</div>
						</div>
						<input class="submit btn btn-success" type="submit" name="submit" value="Confirm and Print" title="Continue" />
						<input class="submit btn btn-danger" type="button" name="cancel" value="Cancel" title="Continue" onClick="window.open('icard_hostel.php', '_self');" />
						<input type="hidden" name="student_id" value="<?php echo $stu_id['sno']; ?>" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>	

            <?php
            break;
                }
            }
            ?>
	   <?php  
         page_footer_start();
         page_footer_end();
       ?>
  </div>