<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate('admin');
page_header_start();
$response=1;
$msg='';
if(isset($_POST['submit'])){
	//print_r($_POST);
	$link = connect();
	if($_GET['inv_type']==1){
		$sql = 'select * from fee_invoice where sno="'.$_GET['id'].'"';
		$inv = mysqli_fetch_array(execute_query(connect(), $sql));
		if($inv['semester']!=2){
			$sql = 'select * from fee_invoice where student_id="'.$inv['student_id'].'" and type="fees"';
			$inv = mysqli_fetch_array(execute_query(connect(), $sql));
		}
		//$_GET['id'] = $inv['sno'];
		$tbl = 'fee_invoice';
	}
	elseif($_GET['inv_type']==2){
		$sql = 'select * from fee_invoice2 where sno="'.$_GET['id'].'"';
		$tbl = 'fee_invoice2';
	}
	elseif($_GET['inv_type']==3){
		$sql = 'select * from fee_invoice3 where sno="'.$_GET['id'].'"';	
		$tbl = 'fee_invoice3';
	}
	elseif($_GET['inv_type']==4){
		$sql = 'select * from fee_invoice4 where sno="'.$_GET['id'].'"';	
		$tbl = 'fee_invoice4';
		
	}
	$inv = mysqli_fetch_array(execute_query(connect(), $sql));
	
	if($_GET['inv_type']==2){
		$sql = 'update student_info2 set counselling_date="'.$_POST['doi'].'", date_of_admission="'.$_POST['doi'].'" where sno='.$inv['student_id'];
		execute_query(connect(), $sql);		
		
	}
	elseif($_GET['inv_type']==4){
		$sql = 'update student_info3 set counselling_date="'.$_POST['doi'].'", date_of_admission="'.$_POST['doi'].'" where sno='.$inv['student_id'];
		execute_query(connect(), $sql);		
	}
	else{
		if($inv['semester']!='2'){
			$sql = 'update student_info set counselling_date="'.$_POST['doi'].'", date_of_admission="'.$_POST['doi'].'" where sno='.$inv['student_id'];
			execute_query(connect(), $sql);
		}
				
	}
	//echo mysqli_error($db);
	
	$sql="update $tbl set 
	tot_amount='".$_POST['amount']."', 
	amount_paid='".$_POST['amount_paid']."', 
	discount='".$_POST['discount']."',
	approval_date='".$_POST['doi']."',
	timestamp='".strtotime($_POST['doi'])."'
	where sno=".$_GET['id'];
	execute_query($link, $sql);
	//echo $sql.'<br>';
	
	if(mysqli_error($link)){
		$msg .= '<h3>Error # 1.1. '.mysqli_error($link).' >> '.$sql;
	}
	$response=1;
	if($msg==''){
		$msg .= '<li class="error">Data saved succesfully.</li>';
	}
	if($_GET['inv_type']==1){
		
		if($_POST['computer']!='' && $_POST['computer']!=0){
			$sql = 'select * from fee_invoice where student_id="'.$inv['student_id'].'" and type="computer"';
			$result_computer = execute_query(connect(), $sql);
			if(mysqli_num_rows($result_computer)!=0){
				$row_computer = mysqli_fetch_array($result_computer);
				$sql = "update fee_invoice set tot_amount='".$_POST['computer']."', 
				amount_paid='".$_POST['computer']."', 
				approval_date='".$_POST['doi']."',
				timestamp='".strtotime($_POST['doi'])."'
				where sno=".$row_computer['sno'];
			}
			else{
				$sql = 'insert into fee_invoice (class_id, student_id, tot_amount, approval_date, status, e_pin, tc, marksheet, addmission_form, character_certificate, amount_paid, mode_of_payment, chq_no, user_id, timestamp, type) values ("'.$inv['class_id'].'", "'.$inv['student_id'].'", "'.$_POST['computer'].'", "'.$inv['approval_date'].'", "'.$inv['status'].'", "'.$inv['e_pin'].'", "'.$inv['tc'].'", "'.$inv['marksheet'].'", "'.$inv['addmission_form'].'", "'.$inv['character_certificate'].'", "'.$_POST['computer'].'", "'.$inv['mode_of_payment'].'", "'.$inv['chq_no'].'", "'.$inv['user_id'].'", "'.$inv['timestamp'].'", "computer")';
			}
			//echo $sql;
			execute_query(connect(), $sql);
		}
		if($_POST['self']!='' && $_POST['self']!=0){
			$sql = 'select * from fee_invoice where student_id="'.$inv['student_id'].'" and type="self"';
			$result_self = execute_query(connect(), $sql);
			if(mysqli_num_rows($result_self)!=0){
				$row_self = mysqli_fetch_array($result_self);
				$sql = "update fee_invoice set tot_amount='".$_POST['self']."', 
				amount_paid='".$_POST['self']."', 
				approval_date='".$_POST['doi']."',
				timestamp='".strtotime($_POST['doi'])."'
				where sno=".$row_self['sno'];
			}
			else{
				$sql = 'insert into fee_invoice (class_id, student_id, tot_amount, approval_date, status, e_pin, tc, marksheet, addmission_form, character_certificate, amount_paid, mode_of_payment, chq_no, user_id, timestamp, type) values ("'.$inv['class_id'].'", "'.$inv['student_id'].'", "'.$_POST['self'].'", "'.$inv['approval_date'].'", "'.$inv['status'].'", "'.$inv['e_pin'].'", "'.$inv['tc'].'", "'.$inv['marksheet'].'", "'.$inv['addmission_form'].'", "'.$inv['character_certificate'].'", "'.$_POST['self'].'", "'.$inv['mode_of_payment'].'", "'.$inv['chq_no'].'", "'.$inv['user_id'].'", "'.$inv['timestamp'].'", "self")';
			}
			execute_query(connect(), $sql);
		}
	}
}

if(isset($_GET['del'])){
	if($_GET['inv_type']==1){
		$sql = 'delete from fee_invoice where sno="'.$_GET['del'].'"';
		$sql_fees = 'select * from fee_invoice where sno="'.$_GET['del'].'"';
		$fee_row = mysqli_fetch_array(execute_query(connect(), $sql_fees));
		
		$sql_student = 'select `student_info`.`sno`, `class_detail`.`year`, `class_detail`.`sort_no` from student_info left join `class_detail` on `class_detail`.`sno` = `student_info`.`class` where `student_info`.`sno`="'.$fee_row['student_id'].'"';
		//echo $sql_student;
		$student_row = mysqli_fetch_array(execute_query(connect(), $sql_student));
		
		$sql_fees = 'select * from fee_invoice where student_id="'.$fee_row['student_id'].'"';
		$result_fees = execute_query(connect(), $sql_fees);
		if(mysqli_num_rows($result_fees)==1){
			$sql = 'delete from fee_invoice where sno="'.$_GET['del'].'"';
			if($student_row['year']!=1){
				$class_sql = 'select * from class_detail where sort_no="'.$student_row['sort_no'].'" and year="'.($student_row['year']-1).'"';
				$class_row = mysqli_fetch_array(execute_query(connect(), $class_sql));

				$student_update = 'update student_info set class="'.$class_row['sno'].'", status=0, date_of_admission="", counselling_date="" where sno="'.$student_row['sno'].'"';
				//echo $student_update;
				execute_query(connect(), $student_update);
				if(mysqli_error()){
					$msg .= '<li class="error">Unable to roll back student.</li>';
				}
				else{
					$msg .= '<li class="error">Student Roll Back Successful.</li>';
				}
			}
			else{
				$sql = 'delete from student_info where sno="'.$student_row['sno'].'"';
				execute_query(connect(), $sql);
				if(mysqli_error()){
					$msg .= '<li class="error">Unable to delete student.</li>';
				}
				else{
					$msg .= '<li class="error">Student Deleted</li>';
				}
			}
		}
		else{
			$sql = 'delete from fee_invoice where sno="'.$_GET['del'].'"';
		}
	}
	elseif($_GET['inv_type']==2){
		$sql = 'delete from fee_invoice2 where sno="'.$_GET['del'].'"';
	}
	elseif($_GET['inv_type']==3){
		$sql = 'delete from fee_invoice3 where sno="'.$_GET['del'].'"';	
	}
	//echo $sql;
	execute_query(connect(), $sql);
	$msg .= '<li class="error">Invoice Deleted.</li>';
}
if(isset($_GET['id'])){
	//echo $_GET['id'];
	if($_GET['inv_type']==1){
		$sql = 'select * from fee_invoice where sno="'.$_GET['id'].'"';
		$fee_invoice = mysqli_fetch_array(execute_query(connect(), $sql));
		if($fee_invoice['semester']=='2'){
			
		}
		else{
			$sql = 'select * from fee_invoice where student_id="'.$fee_invoice['student_id'].'" and type="fees"';	
		}
		
		
	}
	elseif($_GET['inv_type']==2){
		$sql = 'select * from fee_invoice2 where sno="'.$_GET['id'].'"';
	}
	elseif($_GET['inv_type']==3){
		$sql = 'select * from fee_invoice3 where sno="'.$_GET['id'].'"';	
	}
	elseif($_GET['inv_type']==4){
		$sql = 'select * from fee_invoice4 where sno="'.$_GET['id'].'"';	
	}
	
	$fee_invoice = mysqli_fetch_array(execute_query(connect(), $sql));
	if($_GET['inv_type']==2){
		$stu_id = mysqli_fetch_array(execute_query(connect(), "select * from student_info2 where sno=".$fee_invoice['student_id']));
	}
	elseif($_GET['inv_type']==4){
		$stu_id = mysqli_fetch_array(execute_query(connect(), "select * from student_info3 where sno=".$fee_invoice['student_id']));
	}
	else{
		$stu_id = mysqli_fetch_array(execute_query(connect(), "select * from student_info where sno=".$fee_invoice['student_id']));
	}
	//print_r($stu_id);
	//echo $sql;
	
	$sql = 'select `sno` as serial, `student_id` as `sno`, `stu_name`, `father_name`, `mother_name`, `class`, `reservation`, `waightage`, `minority`, `dob`, `acc_no`, `bank_name`, `branch_name`, `temp_address`, `perm_address`, `pin`, `mobile`, `p_mobile`, `p_pin`, `date_of_admission`, `gender`, `photo_id`, `signature_id`, `subject_id`, `district`, `state`, `nationality`, `category`, `form_no`, `p_district`, `p_state`, `post`,`p_post`, `sub1`, `sub2`, `sub3`, `e_mail1`, `e_mail2`, `status`, `roll_no`, `marks`, `counselling_date`, `cat_rank`, `income_certificate`, `annual_income`, `other_univ`, `user_id`, `icard`, `univ_roll`,`remarks`  from student_info2 where status=2 and student_id='.$stu_id['sno'];
	//echo $sql;
	$r_chk = execute_query(connect(), $sql);
	$row_chk = mysqli_num_rows($r_chk);
	if($row_chk!=0){
		$stu_id = mysqli_fetch_array($r_chk);
		//print_r ($stu_id);
	}
	
	if($fee_invoice['type']=='computer'){
		$inv_type = 'Computer Fees';
	}
	elseif($fee_invoice['type']=='fees'){
		$inv_type = 'Fees';
	}
	elseif($fee_invoice['type']=='self'){
		$inv_type = 'Self Finance';
	}
	elseif($fee_invoice['type']=='tour'){
		$inv_type = 'Tour Fees';
	}
	elseif($fee_invoice['type']=='breakage'){
		$inv_type = 'Breakage Fees';
	}
	$response=2;
}

if(isset($_POST['save']) or isset($_GET['stu'])) {
	if($_POST['invoice_type']==4){
		$table = 'student_info3';
	}
	else{
		$table = 'student_info';
	}
	if($_POST['roll_no']!=''){
		$sql="select * from $table where roll_no='".$_POST['roll_no']."'";
	}
	elseif($_POST['form_no']!=''){
		$sql="select * from $table where form_no='".$_POST['form_no']."'"; 
	}
	elseif($_POST['s_class']!=''){
		$sql="select * from $table where class='".$_POST['s_class']."'"; 
	}
	//echo $sql;
	$result = execute_query(connect(), $sql);
	$msg .= '<table width="100%" class="table table-striped table-hover rounded">
	<tr class="bg-primary text-white">
	<th>Sno</th>
	<th>S.Sno.</th>
	<th>Class</th>
	<th>Student Name</th>
	<th>Father Name</th>
	<th>Form No.</th>
	<th>Roll No.</th>
	<th>Invoice Type</th>
	<th>Invoice Amount</th>
	<th>Amount Paid</th>
	<th>Invoice Date</th>
	<th>Edit</th>
	<th>Delete</th>
	</tr>';
	$i=1;
	while($stu = mysqli_fetch_array($result)){
		if($_POST['invoice_type']!=4){
			$sql="select * from student_info2 where student_id='".$stu['sno']."'"; 
			$stu2 = execute_query(connect(), $sql);
			if(mysqli_num_rows($stu2)!=0){
				$stu2 = mysqli_fetch_array($stu2);
			}
		}
		if($_POST['invoice_type']==1){
			$sql = 'select * from fee_invoice where student_id="'.$stu['sno'].'" and (semester="1" or semester is null) ';
			//echo $sql;
		}
		elseif($_POST['invoice_type']==2){
			$sql = 'select * from fee_invoice2 where student_id="'.$stu2['sno'].'"';
		}
		elseif($_POST['invoice_type']==3){
			$sql = 'select * from fee_invoice3 where student_id="'.$stu['sno'].'"';	
		}
		elseif($_POST['invoice_type']==4){
			$sql = 'select * from fee_invoice4 where student_id="'.$stu['sno'].'"';	
		}
		//echo $sql;
		$inv_result = execute_query(connect(), $sql);
		//echo mysqli_num_rows($inv_result);
		$a=1;
		$e_pin = array();
		while($inv_row = mysqli_fetch_array($inv_result)){
			$e_pin[] = $inv_row['e_pin'];
			if($i%2!=0){
				$col = "#EEE";
			}
			else {
				$col = "#ccc";
			}
			if($inv_row['type']=='computer'){
				$col = '#00FF00';
				$inv_type = 'Computer Fees';
			}
			elseif($inv_row['type']=='fees'){
				$inv_type = 'Fees';
			}
			elseif($inv_row['type']=='self'){
				$col = '#FFEE66';
				$inv_type = 'Self Finance';
			}
			elseif($inv_row['type']=='tour'){
				$col = '#F0F0F0';
				$inv_type = 'Tour Fees';
			}
			elseif($inv_row['type']=='due'){
				$col = '#F0F0F0';
				$inv_type = 'Pending Fees';
			}
			elseif($inv_row['type']=='breakage'){
				$col = '#FFF000';
				$inv_type = 'Breakage Fees';
			}
			$msg .= '<tr style="background:'.$col.';">
			<td>'.$i++.'</td>
			<td>'.$a++.'</td>
			<td>'.get_class_detail($stu['class'])['class_description'].'</td>
			<td>'.$stu['stu_name'].'</td>
			<td>'.$stu['father_name'].'</td>
			<td>'.$stu['form_no'].'</td>
			<td>'.$stu['roll_no'].'</td>
			<td>'.$inv_type.'</td>
			<td>'.$inv_row['tot_amount'].'</td>
			<td>'.$inv_row['amount_paid'].'</td>
			<td>'.$inv_row['approval_date'].'</td>
			<td><a href="edit_fee_invoice.php?id='.$inv_row['sno'].'&inv_type='.$_POST['invoice_type'].'">'.$inv_row['sno'].'</td>
			<td><a href="edit_fee_invoice.php?del='.$inv_row['sno'].'&inv_type='.$_POST['invoice_type'].'" onclick="return confirm(\'Are you sure ?\');">Delete</a></td></tr>';
		}
		if($_POST['invoice_type']!=1){
			$_POST['invoice_type']=1;
			$sql = 'select * from fee_invoice where student_id="'.$stu['sno'].'" and e_pin in ("'.implode('", "', $e_pin).'")';
			//echo $sql;
			$result_invoice = execute_query(connect(), $sql);
			if(mysqli_num_rows($result_invoice)!=0){
				while($inv_row = mysqli_fetch_assoc($result_invoice)){
					if($i%2!=0){
						$col = "#EEE";
					}
					else {
						$col = "#ccc";
					}
					if($inv_row['type']=='computer'){
						$col = '#00FF00';
						$inv_type = 'Computer Fees';
					}
					elseif($inv_row['type']=='fees'){
						$inv_type = 'Fees';
					}
					elseif($inv_row['type']=='self'){
						$col = '#FFEE66';
						$inv_type = 'Self Finance';
					}
					elseif($inv_row['type']=='tour'){
						$col = '#F0F0F0';
						$inv_type = 'Tour Fees';
					}
					elseif($inv_row['type']=='due'){
						$col = '#F0F0F0';
						$inv_type = 'Pending Fees';
					}
					elseif($inv_row['type']=='breakage'){
						$col = '#FFF000';
						$inv_type = 'Breakage Fees';
					}
					$msg .= '<tr style="background:'.$col.';">
					<td>'.$i++.'</td>
					<td>'.$a++.'</td>
					<td>'.get_class_detail($stu['class'])['class_description'].'</td>
					<td>'.$stu['stu_name'].'</td>
					<td>'.$stu['father_name'].'</td>
					<td>'.$stu['form_no'].'</td>
					<td>'.$stu['roll_no'].'</td>
					<td>'.$inv_type.'</td>
					<td>'.$inv_row['tot_amount'].'</td>
					<td>'.$inv_row['amount_paid'].'</td>
					<td>'.$inv_row['approval_date'].'</td>
					<td><a href="edit_fee_invoice.php?id='.$inv_row['sno'].'&inv_type='.$_POST['invoice_type'].'">'.$inv_row['sno'].'</td>
					<td><a href="edit_fee_invoice.php?del='.$inv_row['sno'].'&inv_type='.$_POST['invoice_type'].'" onclick="return confirm(\'Are you sure ?\');">Delete</a></td></tr>';
				}

			}
		}

	}

	$msg .= '</table>';

	$response=1;
}

page_header_end();
page_sidebar();

?>
<style>
.ui-autocomplete-loading { background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat; }
input{ text-transform:uppercase}
</style>
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
				<form action="edit_fee_invoice.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off" >
					<h2>Edit <span class="orange">Fee Invoice</span></h2>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Select Fee Invoice Type<span class="name">*</span></label>
								<select name="invoice_type" id="invoice_type" class="form-control">
									<option value="1">New Admission</option>
									<option value="2">Edit Class</option>
									<option value="3">2nd Semester</option>
									<option value="4">Ex Student</option>
								</select>
							</div>
							<div class="col-md-4">							
								<label>Enter Form No.<span class="name">*</span></label>
								<input type="text" class="form-control" name="form_no" id="form_no" >
							</div>
							<div class="col-md-4">							
								<label>Enter Roll No.<span class="name">*</span></label>
								<input type="text" name="roll_no" id="roll_no" class="form-control" >
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Select class <span class="alert">*</span></</label>
								<select name="s_class" class="form-control" id="s_class" >
									<option value="">ALL</option>
									<?php
									$sql = 'select * from class_detail order by sort_no, class_description';
									$res = execute_query(connect(), $sql);
									while($row = mysqli_fetch_array($res)) {
										echo '<option value="'.$row['sno'].'" ';
										if(isset($_POST['s_class'])){
											if($_POST['s_class']==$row['sno']){
												echo " selected";
											}
										}
										echo '>'.$row['class_description'].'</option> ';
										
									}
									?>
								 </select>
							</div>
							
						</div>
						<input type="submit" class="btn btn-success submit" name="save" value="Submit" />
							<?php echo $msg;?>
					</div>
					
				</form>
			</div>
		</div>
				<?php 
                    break;
                }
                case 2:{
            
                ?>
		<div class="card">
			<div class="card-body ">
				<div class="row d-flex my-auto">
					<form action="edit_fee_invoice.php?id=<?php echo $_GET['id']; ?>&inv_type=<?php echo $_GET['inv_type']; ?>" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" method="post">
					<h2 align="center" class="bg-primary text-white">Edit <span class="orange">Fee Invoice</span></h2>    
					<div style="float:left;"><img src="PHOTO/<?php echo $stu_id['photo_id']; ?>" style="height:150px;"/></div>	
						<div class="col-md-12">
						<?php echo $msg; ?>
							<div class="row">							
								<div class="col-md-4">							
									<label  class="desc" for="form_no">Student ID:<span class="alert">*</span></label>
									<?php echo $stu_id['sno']; ?>
								</div>
								<div class="col-md-4">							
									<label  class="desc" for="form_no">Form Number:<span class="alert">*</span></label>
									<?php echo $stu_id['form_no']; ?>
								</div>
								<div class="col-md-4">							
									<label  class="desc" for="s_name">Candidate's Full Name: <span class="alert">*</span></label>
									<?php echo $stu_id['stu_name']; ?>
								</div>
							</div>
							<div class="row">							
								<div class="col-md-4">							
									<label  class="desc" for="f_name">Father's Name:<span class="alert">*</span></label>
									<?php echo $stu_id['father_name']; ?>
								</div>
								<div class="col-md-4">							
									<label  class="desc" for="f_name">Invoice Type:<span class="alert">*</span></label>
									<?php echo $inv_type; ?>
								</div>
								<div class="col-md-4">							
									<label  class="desc" for="f_name">User ID:<span class="alert">*</span></label>
									<?php echo $fee_invoice['user_id']; ?>
								</div>
							</div>
							<div class="row">							
								<div class="col-md-4">							
									<label  class="desc" for="doi">Date of Invoice<span class="name">*</span></label>
									<input class="form-control" id="doi" maxlength="35" size="35" name="doi" value="<?php echo $fee_invoice['approval_date']; ?>"/>
								</div>
								<div class="col-md-4">							
									<label class="desc" for="dob">Invoice Amount<span class="name">*</span></label>
									<input class="form-control" id="amount" maxlength="35" size="35" name="amount" value="<?php echo $fee_invoice['tot_amount']; ?>"/>
								</div>
								<div class="col-md-4">							
									<label class="desc" for="dob">Amount Paid<span class="name">*</span></label>
									<input class="form-control" id="amount_paid" maxlength="35" size="35" name="amount_paid" value="<?php echo $fee_invoice['amount_paid']; ?>"/>
								</div>
							</div>
							<div class="row">							
								<div class="col-md-4">							
									<label class="desc" for="dob">Discount<span class="name">*</span></label>
									<input class="form-control" id="discount" maxlength="35" size="35" name="discount" value="<?php echo $fee_invoice['discount']; ?>"/>
								</div>								
							
								<?php
									if($_GET['inv_type']==1){
										$sql = 'select * from fee_invoice where student_id="'.$fee_invoice['student_id'].'" and type="computer"';
										$result_computer = execute_query(connect(), $sql);
										if(mysqli_num_rows($result_computer)!=0){
											$row_computer = mysqli_fetch_array($result_computer);
											$computer = $row_computer['tot_amount'];
										}
										else{
											$computer = '';
										}
										
										$sql = 'select * from fee_invoice where student_id="'.$fee_invoice['student_id'].'" and type="self"';
										$result_self = execute_query(connect(), $sql);
										if(mysqli_num_rows($result_self)!=0){
											$row_self = mysqli_fetch_array($result_self);
											$self = $row_self['tot_amount'];
										}
										else{
											$self = '';
										}
								?>
														
								<div class="col-md-4">							
									<label class="desc" for="dob">Computer Fees<span class="name">*</span></label>
									<input class="form-control" id="amount" maxlength="35" size="computer" name="computer" value="<?php echo $computer; ?>"/>
								</div>
								<div class="col-md-4">							
									<label class="desc" for="dob">Self Fees<span class="name">*</span></label>
									<input class="form-control" id="amount" maxlength="35" size="self" name="self" value="<?php echo $self; ?>"/>
								</div>
								
							</div>
							<?php } ?>
							<div id="finalValues"></div>
							<input type="hidden" value="" id="current">
							<input type="hidden" value="<?php echo $i; ?>" name="id" id="id">
							<input class="submit btn btn-primary" type="submit" name="submit" value="Submit" title="Continue" />
							  <input type="hidden" name="student_id" value="<?php echo $stu_id['sno']; ?>" />
						</div>
					</form>
					<?php
					break;
						}
					}
					?>
				</div>
			</div>
		</div>
     
	</div>

	<?php
	page_footer_start();
	page_footer_end();
	?>
 </body>