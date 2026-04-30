<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate('admin');
page_header_start();
$response=1;
$msg='';
if(isset($_POST['submit'])){
	if($_POST['f_no']==''){
		$msg .= '<li class="error">Please enter Form No.</li>';
	}
	if($_POST['s_name']==''){
		$msg .= '<li class="error">Please enter Student name.</li>';
	}
	if($_POST['f_name']==''){
		$msg .= '<li class="error">Please enter Father Name.</li>';
	}
	if($_POST['m_name']==''){
		$msg .= '<li class="error">Please enter Mother Name.</li>';
	}
	if($_POST['dob']==''){
		$msg .= '<li class="error">Please enter Date of Birth.</li>';
	}
	if($_POST['dob']==''){
		$_POST['dob']='1990-01-01';
	}
	if($_POST['s_class']==''){
		$msg .= '<li>Please enter Class.</li>';
	}
	$sql="update student_info set stu_name='".$_POST['s_name']."',
	father_name='".$_POST['f_name']."',
	mother_name='".$_POST['m_name']."',
	form_no='".$_POST['f_no']."',
	class='".$_POST['s_class']."',
	nationalty='".$_POST['nationality']."',
	minority='".$_POST['minority']."',
	income_certificate='".$_POST['inc_certificate']."',
	acc_no='".$_POST['account_no']."',
	bank_name='".$_POST['bank_name']."',
	branch_name='".$_POST['branch_name']."',
	annual_income='".$_POST['annual_income']."',
	perm_address='".$_POST['p_address']."',
	temp_address='".$_POST['c_address']."',
	district='".$_POST['c_district']."' ,
	p_district='".$_POST['p_district']."',state='".$_POST['c_state']."',
	p_state='".$_POST['p_state']."',
	mobile='".$_POST['c_mobile']."',
	p_mobile='".$_POST['p_mobile']."',
	pin='".$_POST['c_pin']."',
	p_pin='".$_POST['p_pin']."',
	post='".$_POST['c_post']."',
	p_post='".$_POST['p_post']."',
	e_mail1='".$_POST['c_email']."',
	e_mail2='".$_POST['p_email']."',
	dob='".$_POST['dob']."',
	remarks='".$_POST['remarks']."' where sno='".$_POST['student_id']."'";
	execute_query(connect(), $sql);
	if(!mysqli_error()){
		$msg .= '<li class="error">Updated.</li>';
	}
	else{
		$msg .= '<li class="error">Error # 1 : '.mysqli_error().' >> '.$sql;
	}
}

if(isset($_GET['id'])){
	$stu_id = mysqli_fetch_array(execute_query(connect(), "select * from student_info where sno=".$_GET['id']));
	$fee_deposition = mysqli_fetch_array(execute_query(connect(), "select * from fee_invoice where type='fees' and student_id=".$stu_id['sno']));
	$timestamp = date('d-m-Y',$fee_deposition['timestamp']);
	$result_cla = mysqli_fetch_array(execute_query(connect(), "select * from class_detail where sno=".$stu_id['class']));
	$sub1 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub1']));
	$sub2 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub2']));
	$sub3 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub3']));
	$response=2;
}

if(isset($_POST['save']) or isset($_GET['stu'])) {
	if($_POST['roll_no']!=''){
		$sql="select * from student_info where roll_no='".$_POST['roll_no']."'";
	}
	else{
		$sql="select * from student_info where form_no='".$_POST['form_no']."'"; 
	}
	$result = execute_query(connect(), $sql);
	$stu = mysqli_fetch_array($result);
	$i=1;
				
	$msg .= '<table width="100%">
	<tr style="background:#000; color:#fff; top:0px;width:800px;">
	<th>Sno</th>
	<th>Student Name</th>
	<th>Father Name</th>
	<th>Mother Name</th>
	<th>Form No.</th>
	<th>Roll No.</th>
	<th>Edit</th>
	</tr>';
	$msg .= '<tr>
	<td>'.$i++.'</td>
	<td>'.$stu['stu_name'].'</td>
	<td>'.$stu['father_name'].'</td>
	<td>'.$stu['mother_name'].'</td>
	<td>'.$stu['form_no'].'</td>
	<td>'.$stu['roll_no'].'</td>
	<td><a href="admin_edit_student_master.php?id='.$stu['sno'].'">Edit</td></tr>';
	$msg .= '</table>';

	$response=1;
}
page_header_end();
page_sidebar();
?>

<script language="javascript" type="text/javascript">
	$( "#doi" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$("#doi").change(function(){
		$( "#doi" ).datepicker("option", "showAnim", "slide");
	});

</script>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">   
				<?php
				switch($response){
					case 1:{
				?>
  				<form action="admin_edit_student_master.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off" >
                    <h2>Edit <span class="orange">Student Master</span></h2>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Enter Form No.<span class="name">*</span></label>
								<input type="text" class="form-control" name="form_no" id="form_no" >
							</div>
							<div class="col-md-4">							
								<label>Enter Roll No.<span class="name">*</span></label>
								<input type="text" class="form-control" name="roll_no" id="roll_no" >
							</div>							
						</div>
						<input type="submit" class="btn btn-primary submit" name="save" value="Submit" />
						<?php echo $msg;?>
					</div>
				</form>
			</div>
		</div>
	</div>
			<?php 
				break;
			}
			case 2:{
		
			?>
		<div class="">
			<form action="admin_edit_student_master.php" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" method="post">
			<h2 align="center">Complete Detail of the <span class="orange">Admission</span></h2>    
			<h2>Total fees:<?php echo $fee_deposition['tot_amount']; ?></h2>
			<input type="button" class="btn btn-primary" name="fees_amount" onClick="return fees_detail();" value="Fees Detail">
			<input type="button" name="fees_amount1" class="btn btn-success" onClick="return printinvoice()" value="Fee Receipt">
			<input type="button" name="fees_amount1"class="btn btn-warning" onClick="return dup_printinvoice()" value="Duplicate Fee Receipt">
			<?php if($stu_id['status']==2){?>
			<input type="button" name="fees_amount" class="btn btn-danger" onClick="return print_certificate();" value="Print Certificate ">
			<?php }
			else {
			?>
		</div>
		
    	
    	<?php } ?></div>
		<div class="card card-body">    
        	<div class="row d-flex my-auto">  
				<h2>STUDENT HAS NOT YET DEPOSITED THE FEES</h2>
				<div style="float:left;"><img src="PHOTO/<?php echo $stu_id['photo_id']; ?>" style="height:150px;"/></div>
				<div class="col-md-12">
					<div class="row">	
						<?php echo $msg; ?>
						<div class="col-md-4">							
							<label>Student ID<span class="alert">*</span></label>
							<input class="form-control" value="<?php echo $stu_id['sno']; ?>">
							
						</div>
						<div class="col-md-4">							
							<label>Form Number<span class="alert">*</span></label>
							<input class="form-control" id="s_name" maxlength="45" size="35" name="f_no" value="<?php echo $stu_id['form_no']; ?>" <?php //if($_SESSION['username']!='sadmin'){}?>>
						</div>
						<div class="col-md-4">							
							<label>University<span class="alert">*</span></label>
							<input class="form-control" id="other_univ" maxlength="45" size="35" name="other_univ" value="<?php echo $stu_id['other_univ']; ?>">
						</div>
					</div>
					<div class="row">							
						<div class="col-md-4">							
							<label>Roll Number<span class="alert">*</span></label>
							<input class="form-control" id="roll_no" maxlength="45" size="35" name="roll_no" value="<?php echo $stu_id['roll_no']; ?>">
						</div>
						<div class="col-md-4">							
							<label>Date of Admission<span class="name">*</span></label>
							<input class="form-control" value="<?php echo $timestamp; ?>">
							
						</div>
						<div class="col-md-4">							
							<label>Candidate's Full Name <span class="alert">*</span></label>
							<input class="form-control" id="s_name" maxlength="45" size="35" name="s_name" value="<?php echo $stu_id['stu_name']; ?>">
						</div>
					</div>
					<div class="row">							
						<div class="col-md-4">							
							<label>Father's Name<span class="alert">*</span></label>
							<input class="form-control" id="f_name" maxlength="35" size="35" name="f_name" value="<?php echo $stu_id['father_name']; ?>">
						</div>
						<div class="col-md-4">							
							<label>Mother's Name <span class="alert">*</span></label>
							<input class="form-control" id="m_name" maxlength="35" size="35" name="m_name" value="<?php echo $stu_id['mother_name'];?>">
						</div>
						<div class="col-md-4">							
							<label>Date of Birth<span class="name">*</span></label>
							<input type="date" class="form-control" id="dob" maxlength="35" size="35" name="dob" value="<?php echo $stu_id['dob']; ?>"/>
						</div>
					</div>
					<div class="row">							
						<div class="col-md-4">							
							<label>Gender <span class="alert">*</span></label>
							<?php 
							  if($stu_id['gender']=='F'){
								  $female = 'selected';
								  $male = '';
							  }
							  else{
								  $male = 'selected';
								  $female = '';
							  }?>
							  <select name="gender" class="form-control">
								<option value="M" <?php echo $male; ?>>Male</option>
								<option value="F" <?php echo $female; ?>>Female</option>
							  </select>
						</div>
						<div class="col-md-4">							
							<label>Nationality <span class="alert">*</span></label>
							<input class="form-control" id="nationality" maxlength="35" size="35" name="nationality" value="<?php echo $stu_id['nationalty']; ?>"/>
						</div>
						<div class="col-md-4">							
							<label>Category <span class="alert">*</span></label>
							<?php 
							  if($stu_id['category']=='GEN'){
								  $gen = 'selected';
								  $obc = '';
								  $sc = '';
							  }
							  elseif($stu_id['category']=='OBC'){
								  $gen = '';
								  $obc = 'selected';
								  $sc = '';
							  }
							  else{
								  $gen = '';
								  $obc = '';
								  $sc = 'selected';
							  }
								  ?>
							  <select name="gender" class="form-control">
								<option value="GEN" <?php echo $gen; ?>>General</option>
								<option value="OBC" <?php echo $obc; ?>>OBC</option>
								<option value="SC" <?php echo $sc; ?>>SC/ST</option>
							  </select>
						</div>
					</div>
					<div class="row">							
						<div class="col-md-4">							
							<label>Minority <span class="alert">*</span></label>
							<select name="minority" value="" class="form-control">
								<option value="NO" <?php if($stu_id['minority']=='NO'){echo ' selected';} ?>>No</option>
								<option value="YES" <?php if($stu_id['minority']=='YES'){echo ' selected';} ?>>Yes</option>
							</select>
						</div>
						<div class="col-md-4">							
							<label>Income Certificate: <span class="alert">*</span></label>
							<input class="form-control" id="inc_certificate" maxlength="35" size="35"  name="inc_certificate" value="<?php echo $stu_id['income_certificate']; ?>"/>
						</div>
						<div class="col-md-4">							
							<label>Annual Income <span class="alert">*</span></label>
							<input class="form-control" id="annual_income" maxlength="35" size="35"  name="annual_income" value="<?php echo $stu_id['annual_income']; ?>"/>
						</div>
					</div>
					<div class="row">							
						<div class="col-md-4">							
							<label>Account No: <span class="alert">*</span></label>
							<input class="form-control" id="account_no" maxlength="35" size="35"  name="account_no" value="<?php echo $stu_id['acc_no']; ?>"/>
						</div>
						<div class="col-md-4">							
							<label>Bank_name <span class="alert">*</span></label>
							<input class="form-control" id="bank_name" maxlength="35" size="35" name="bank_name" value="<?php echo $stu_id['bank_name']; ?>"/>
						</div>
						<div class="col-md-4">							
							<label>Branch_name <span class="alert">*</span></label>
							<input class="form-control" id="branch_name" maxlength="35" size="35" name="branch_name" value="<?php echo $stu_id['branch_name']; ?>"/>
						</div>
					</div>
					<div class="row">							
						<div class="col-md-4">							
							<label>Class <span class="alert">*</span></label>
							<select name="s_class" class="form-control" id="s_class" class="form-control" onChange="get_subject(this.value)" onFocus="fnTXTFocus(this.id)" 
							onBlur="fnTXTLostFocus(this.id)" >
								<option value=""></option>
								<?php 
								$sql = 'select * from class_detail';
								$res = execute_query(connect(), $sql);
								while($row = mysqli_fetch_array($res)) {
									echo '<option value="'.$row['sno'].'" ';
									if($stu_id['class']==$row['sno']){ echo 'selected="selected"'; }
									echo '>'.$row['class_description'].'</option> ';
								}
								?>
							</select>
						</div>
						<div class="col-md-4">							
							<label>Subjects <span class="alert">*</span></label>
							<input class="form-control" value="<?php
								if(($result_cla['category']=='UG')) { 
									
								?>
								<?php echo $sub1['subject']; ?><?php echo $sub2['subject']; ?>
								<?php echo $sub3['subject']; ?>
								<?php 
									
								}
								else{
								?>
								
									<?php echo $pgsub1['subject']; ?>
									<?php echo $pgsub2['subject']; ?>
									
									<?php echo $pgsub3['subject']; ?>
									<?php echo $pgsub4['subject']; ?>
									<?php echo $pgsub5['subject']; ?>
									<?php echo $pgsub6['subject']; ?>
								
								<?php
								}
								?>">
							
						</div>
						<div class="col-md-4">							
							<label>Remarks <span class="alert">*</span></label>
							<input  class="form-control" id="remarks" name="remarks"  value="<?php echo $stu_id['remarks'];?>" >
						</div>
					</div>
					<h3 style="color:#F00; font-size:14px; text-decoration:underline;">Permanent Address:</h3> 
					<div class="row">							
						<div class="col-md-4">							
							<label>Address/Village<span class="alert">*</span></label>
							<textarea class="form-control" id="p_address" rows="2" cols="50" name="p_address"><?php echo $stu_id['perm_address']; ?></textarea>
						</div>
						<div class="col-md-4">							
							<label>Post<span class="alert">*</span></label>
							<input class="form-control" id="p_post" maxlength="35" size="40" name="p_post" value="<?php echo $stu_id['p_post']; ?>" >
						</div>
						<div class="col-md-4">							
							<label>District<span class="alert">*</span></label>
							<input class="form-control" id="p_district" maxlength="35" size="40" name="p_district" value="<?php echo $stu_id['p_district']; ?>" >
						</div>
					</div>
					<div class="row">							
						<div class="col-md-4">							
							<label>State<span class="alert">*</span></label>
							<input class="form-control" id="p_state" maxlength="35" size="40" name="p_state" value="<?php echo $stu_id['p_state']; ?>" >
						</div>
						<div class="col-md-4">							
							<label>Pin<span class="alert">*</span></label>
							<input class="form-control"  id="p_pin" maxlength="6" size="6" name="p_pin" value="<?php echo $stu_id['p_pin']; ?>">
						</div>
						<div class="col-md-4">							
							<label>Mobile<span class="alert">*</span></label>
							<input name="p_mobile"class="form-control" id="p_mobile" size="25" maxlength="10" value="<?php echo $stu_id['p_mobile']; ?>">
						</div>
					</div>
					<div class="row">							
						<div class="col-md-4">							
							<label>Email<span class="alert">*</span></label>
							<input class="form-control" style="text-transform:none;"  id="c_email" maxlength="100" size="30" name="c_email"  value="<?php echo $stu_id['e_mail1']; ?>">
						</div>						
					</div>
					<h3 style="color:#F00; font-size:14px; text-decoration:underline;">Correspondence Address:</h3>
					<a href="javascript:copy_adr()" >Click Here to Copy</a>
					<div class="row">							
						<div class="col-md-4">							
							<label>Address/Village<span class="alert">*</span></label>
							<textarea class="form-control" id="p_address" rows="2" cols="50" name="p_address"><?php echo $stu_id['temp_address']; ?></textarea>
						</div>
						<div class="col-md-4">							
							<label>Post<span class="alert">*</span></label>
							<input class="form-control" id="p_post" maxlength="35" size="40" name="p_post" value="<?php echo $stu_id['post']; ?>" >
						</div>
						<div class="col-md-4">							
							<label>District<span class="alert">*</span></label>
							<input class="form-control" id="p_district" maxlength="35" size="40" name="p_district" value="<?php echo $stu_id['district']; ?>" >
						</div>
					</div>
					<div class="row">							
						<div class="col-md-4">							
							<label>State<span class="alert">*</span></label>
							<input class="form-control" id="p_state" maxlength="35" size="40" name="p_state" value="<?php echo $stu_id['state']; ?>" >
						</div>
						<div class="col-md-4">							
							<label>Pin<span class="alert">*</span></label>
							<input class="form-control"  id="p_pin" maxlength="6" size="6" name="p_pin" value="<?php echo $stu_id['pin']; ?>">
						</div>
						<div class="col-md-4">							
							<label>Mobile<span class="alert">*</span></label>
							<input name="p_mobile"class="form-control" id="p_mobile" size="25" maxlength="10" value="<?php echo $stu_id['mobile']; ?>">
						</div>
					</div>
					<div class="row">							
						<div class="col-md-4">							
							<label>Email<span class="alert">*</span></label>
							<input class="form-control" style="text-transform:none;"  id="c_email" maxlength="100" size="30" name="c_email"  value="<?php echo $stu_id['e_mail2']; ?>">
						</div>						
					</div>
				</div>				
			</div>	
		</div>
				
		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white">							
					<td>S.No</td>
					<td>Name Of Examination</td>
					<td>Board/University Name</td>
					<td>College Name</td>
					<td>Year</td>
					<td>Roll No</td>
					<td>Obtained Marks</th>
					<td>Total Marks</td>
					<td>Percentage</td> 
					<td>Division</td>
					<td>Status</td>                 
				</tr>
					<?php
					   $i=1;
					   $tab=8;
					   $sql = 'SELECT * from qual_detail where student_id="'.$stu_id['sno'].'"';
					   $result_trans = execute_query(connect(), $sql);
					   while($row = mysqli_fetch_array($result_trans)){
					   ?>
						<tr><td><?php echo $i; ?></td>
						<td><select name="part_desc<?php echo $i; ?>" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $i; ?>)" >
						<option value="<?php echo $row['exam_name']; ?>" selected><?php echo $row['exam_name']; ?></option>
						<option value="High School">High School</option>
						<option value="Intermediate">Intermediate</option>
						<option value="B.Ed">B.Ed</option>
						<?php
							$sql = 'select * from class_detail order by sort_no, year';
							$result = execute_query(connect(), $sql);
							while($name = mysqli_fetch_array($result)){
								echo '<option value="'.$name['class_description'].'" ';
								echo '>'.$name['class_description'].'</option>';
							}
							?></option></select>
						</td>
							<td><input name="part_desc<?php echo $i; ?>_board" type="text" value="<?php echo $row['board']; ?>" 
							class="form-control"  maxlength="100"  id="part_desc<?php echo $i; ?>_board"/></td>
							<td><input name="part_desc<?php echo $i; ?>_college" type="text"  value="<?php echo $row['univ_name']; ?>" maxlength="100" 
							class="form-control"  id="part_desc<?php echo $i; ?>_college" /></td>
							 <td><input name="part_desc<?php echo $i; ?>_year" type="text" value="<?php echo $row['year']; ?>"  maxlength="6" 
							 class="form-control" style="width:50px;"  id="part_desc<?php echo $i; ?>_year" /></td>
							<td><input name="part_desc<?php echo $i; ?>_rollno" type="text"  value="<?php echo $row['roll_no']; ?>"   maxlength="12" 
							class="form-control" style="width:50px;"  id="part_desc<?php echo $i; ?>_rollno" /></td>
							<td><input name="part_desc<?php echo $i; ?>_obtmarks" type="text"  value="<?php echo $row['obt_marks']; ?>" maxlength="6" 
							 class="form-control" style="width:50px;"   onBlur="total_amount(<?php echo $i; ?>)" id="part_desc<?php echo $i; ?>_obtmarks" /></td>
							 <td><input name="part_desc<?php echo $i; ?>_totmarks" type="text"  value="<?php echo $row['tot_marks']; ?>"   maxlength="6" 
							 class="form-control" style="width:50px;"  onBlur="total_amount(<?php echo $i; ?>)" id="part_desc<?php echo $i; ?>_totmarks" /></td>
							 <td><input name="part_desc<?php echo $i; ?>_percentage" type="text"  value="<?php echo $row['percentage']; ?>"  maxlength="6"
							  class="form-control" style="width:50px;" id="part_desc<?php echo $i; ?>_percentage" /></td>
							  <td><input name="part_desc<?php echo $i; ?>_division" type="text"  value="<?php echo $row['division']; ?>"  maxlength="6"
							  class="form-control" style="width:50px;" id="part_desc<?php echo $i; ?>_division" /></td>
							  <td><select name="part_desc<?php echo $i; ?>_status" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $i; ?>)" >
								<option value="<?php echo $row['status']; ?>" selected><?php echo $row['status']; ?></option>
								<option value="Passed">Passed</option>
								<option value="Failed">Failed</option>
								</select>
						</td>
							</tr>
					   
						 <?php
							$i++;
						  }
						  ?>
						<tr><th><?php echo $i; ?></th>
						<td><select name="part_desc<?php echo $i; ?>" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $i; ?>)" >
						<option value="<?php echo $row['exam_name']; ?>" selected><?php echo $row['exam_name']; ?></option>
					   
						<option value="High School">High School</option>
						<option value="Intermediate">Intermediate</option>
						<option value="B.Ed">B.Ed</option>
						<?php
							$sql = 'select * from class_detail order by sort_no, year';
							$result = execute_query(connect(), $sql);
							while($name = mysqli_fetch_array($result)){
								echo '<option value="'.$name['class_description'].'" ';
								echo '>'.$name['class_description'].'</option>';
							}
							?></option></select>
						</select>
						</td>
						<td><input name="part_desc<?php echo $i; ?>_board" type="text" value="<?php echo $row['board']; ?>" class="form-control"  
							 maxlength="100"  id="part_desc<?php echo $i; ?>_board"/></td>
						<td><input name="part_desc<?php echo $i; ?>_college" type="text"  value="<?php echo $row['univ_name']; ?>" maxlength="100"
							class="form-control"  id="part_desc<?php echo $i; ?>_college" /></td>
						<td><input name="part_desc<?php echo $i; ?>_year" type="text" value="<?php echo $row['year']; ?>"  maxlength="6" 
							class="form-control" style="width:50px;"  id="part_desc<?php echo $i; ?>_year" /></td>
						<td><input name="part_desc<?php echo $i; ?>_rollno" type="text"  value="<?php echo $row['roll_no']; ?>"   maxlength="12" 
							class="form-control" style="width:50px;"  id="part_desc<?php echo $i; ?>_rollno" /></td>
						<td><input name="part_desc<?php echo $i; ?>_obtmarks" type="text"  value="<?php echo $row['obt_marks']; ?>" maxlength="6"  
							class="form-control" style="width:50px;"   onBlur="total_amount(<?php echo $i; ?>)" id="part_desc<?php echo $i; ?>_obtmarks" /></td>
						<td><input name="part_desc<?php echo $i; ?>_totmarks" type="text"  value="<?php echo $row['tot_marks']; ?>"   maxlength="6"
							class="form-control" style="width:50px;"  onBlur="total_amount(<?php echo $i; ?>)" id="part_desc<?php echo $i; ?>_totmarks" /></td>
						<td><input name="part_desc<?php echo $i; ?>_percentage" type="text"  maxlength="6" class="form-control"  value="
							<?php echo $row['percentage']; ?>" style="width:50px;" id="part_desc<?php echo $i; ?>_percentage" /></td>
						<td><input name="part_desc<?php echo $i; ?>_division" type="text"  value="<?php echo $row['division']; ?>"  maxlength="6"
							  class="form-control" style="width:50px;" id="part_desc<?php echo $i; ?>_division" /></td>
						<td><select name="part_desc<?php echo $i; ?>_status" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $i; ?>)" >
							<option value="Passed">Passed</option>
							<option value="Failed">Failed</option>
							</select>
						</td>
						</tr>
						<tr id="finalValues"></tr>
			</table>
			<input type="hidden" value="" id="current">
							<input type="hidden" value="<?php echo $i; ?>" name="id" id="id">
							<input class="submit btn btn-primary" type="submit" name="submit" value="Submit" title="Continue" />
							  <input type="hidden" name="student_id" value="<?php echo $stu_id['sno']; ?>" />
							 </div>
		</div>
							
							  
						
</form>
<?php
break;
	}
}
?>

<?php  
 page_footer_start();
 page_footer_end();
?>
