<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate('admin');
page_header_start();
$response=1;
$msg='';
if(isset($_POST['submit'])){
		$sql='select * from fee_invoice3 where student_id='.$_POST['student_id'].' and type in ("fees", "due")';
		$old_data=mysqli_fetch_assoc(execute_query(connect(), $sql));
		
	
		$sql='select * from fee_invoice3 where student_id='.$_POST['student_id'].' and type in ("breakage")';
		$row=execute_query(connect(), $sql);
		$count=mysqli_num_rows($row);
		$result=mysqli_fetch_array($row);
		if($count!=0){
			$sql='update fee_invoice3 set tot_amount="'.$_POST['breakage'].'" , amount_paid="'.$_POST['breakage'].'" where student_id='.$result['student_id'].' and type="breakage"';
			execute_query(connect(), $sql);
		}
		else{
			if($_POST['breakage']!=0){
				$sql='select * from fee_invoice3 where student_id='.$_POST['student_id'].' and type="fees"';
				$row=mysqli_fetch_array(execute_query(connect(), $sql));
				$sql = 'insert into fee_invoice3(class_id, student_id, tot_amount, amount_paid, approval_date, e_pin, tc, marksheet, addmission_form, character_certificate, status, timestamp, user_id, type) values ("'.$_POST['class_id'].'", "'.$_POST['student_id'].'", "'.$_POST['breakage'].'", "'.$_POST['breakage'].'", "'.date("Y-m-d").'",
				"'.$old_data['e_pin'].'", "1", "1", "1", "1", "1", "'.strtotime(date("Y-m-d")).'", "'.$old_data['user_id'].'", "breakage")';
				//echo $sql.'<br>';
				execute_query(connect(), $sql);
			}
		}
		$sql='select * from fee_invoice3 where student_id='.$_POST['student_id'].' and type="tour"';
		$row=execute_query(connect(), $sql);
		$count=mysqli_num_rows($row);
		$result=mysqli_fetch_array($row);
		if($count!=0){
			$sql='update fee_invoice3 set tot_amount="'.$_POST['breakage'].'" , amount_paid="'.$_POST['breakage'].'" where student_id='.$result['student_id'].' and type="tour"';
			execute_query(connect(), $sql);
		}
		else{
			if($_POST['tour']!=0){
				$sql='select * from fee_invoice3 where student_id='.$_POST['student_id'].' and type="fees"';
				$row=mysqli_fetch_array(execute_query(connect(), $sql));
				$sql = 'insert into fee_invoice3(class_id,student_id,tot_amount,amount_paid,approval_date,e_pin,tc,marksheet,addmission_form,
				character_certificate,status,timestamp,user_id,type)
				values("'.$_POST['class_id'].'","'.$_POST['student_id'].'","'.$_POST['tour'].'", "'.$_POST['tour'].'","'.$row['approval_date'].'",
				"'.$row['e_pin'].'","1","1","1","1","1","'.strtotime($row['approval_date']).'","'.$row['user_id'].'","tour")';
				execute_query(connect(), $sql);
			}
		}
		$sql='select * from fee_invoice3 where student_id='.$_POST['student_id'].' and type="computer"';
		$row=execute_query(connect(), $sql);
		$count=mysqli_num_rows($row);
		$result=mysqli_fetch_array($row);
		if($count!=0){
			$sql='update fee_invoice3 set tot_amount="'.$_POST['computer'].'" , amount_paid="'.$_POST['computer'].'" where student_id='.$result['student_id'].' and type="computer"';
			execute_query(connect(), $sql);
			$msg="<h2>FEE UPDATED</h2>";
		}
		else{
			if($_POST['computer']!=0){
				$sql='select * from fee_invoice3 where student_id='.$_POST['student_id'].' and type="fees"';
				$row=mysqli_fetch_array(execute_query(connect(), $sql));
				$sql = 'insert into fee_invoice3(class_id,student_id,tot_amount,amount_paid,approval_date,e_pin,tc,marksheet,addmission_form,
				character_certificate,status,timestamp,user_id,type)
				values("'.$_POST['class_id'].'","'.$_POST['student_id'].'","'.$_POST['computer'].'", "'.$_POST['computer'].'","'.$row['approval_date'].'",
				"'.$row['e_pin'].'","1","1","1","1","1","'.strtotime($row['approval_date']).'","'.$row['user_id'].'","computer")';
				execute_query(connect(), $sql);
			}
		  $msg="<h2>FEE SUBMITTED</h2>";
		}

}
if(isset($_POST['fee'])){
	$sql='delete from fee_invoice3 where student_id='.$_POST['student_id'].' and type="fees"';
	execute_query(connect(), $sql);
	$sql='delete from fee_invoice3 where student_id='.$_POST['student_id'].' and type="computer"';
	execute_query(connect(), $sql);
	
	$sql = 'delete from student_info2 where student_id="'.$_POST['student_id'].'" and type="admission"';
	execute_query(connect(), $sql);
	
	$msg="<h2>FEE DELETED";
}
if(isset($_POST['breakage_fee'])){
	$sql='delete from fee_invoice3 where student_id='.$_POST['student_id'].' and type="breakage"';
	execute_query(connect(), $sql);
	$msg="<h2>BREAKAGE FEE DELETED";
}
if(isset($_GET['id'])){
	//echo $_GET['id'];
	$stu_id = mysqli_fetch_array(execute_query(connect(), "select * from student_info where sno=".$_GET['id']));
	//print_r($stu_id);
	//echo $sql;
	
	$sql = 'select `sno` as serial, `student_id` as `sno`, `stu_name`, `father_name`, `mother_name`, `class`, `reservation`, `waightage`, `minority`, `dob`, `acc_no`, `bank_name`, `branch_name`, `temp_address`, `perm_address`, `pin`, `mobile`, `p_mobile`, `p_pin`, `date_of_admission`, `gender`, `photo_id`, `signature_id`, `subject_id`, `district`, `state`, `category`, `form_no`, `p_district`, `p_state`, `sub1`, `sub2`, `sub3`, `e_mail1`, `e_mail2`, `status`, `roll_no`, `marks`, `counselling_date`, `cat_rank`, `income_certificate`, `annual_income`, `other_univ`, `user_id`, `icard`, `univ_roll`,`remarks`  from student_info2 where status=2 and student_id='.$stu_id['sno'];
	//echo $sql;
	$r_chk = execute_query(connect(), $sql);
	$row_chk = mysqli_num_rows($r_chk);
	if($row_chk!=0){
		$stu_id = mysqli_fetch_array($r_chk);
		//print_r ($stu_id);
	}
	$fee_deposition = mysqli_fetch_array(execute_query(connect(), "select * from fee_invoice3 where type in ('fees', 'due') and student_id=".$stu_id['sno']));
	//echo  "select * from fee_invoice3 where type in ('fees', 'due') and student_id=".$stu_id['sno'];
	$fee_deposit = mysqli_fetch_array(execute_query(connect(), "select * from fee_invoice where type in ('fees', 'due') and student_id=".$stu_id['sno']));
	$timestamp = date('d-m-Y',$fee_deposit['timestamp']);
	$result_cla = mysqli_fetch_array(execute_query(connect(), "select * from class_detail where sno=".$stu_id['class']));
	$sub1 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub1']));
	$sub2 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub2']));
	$sub3 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub3']));
	$fees_amount = calc_fees($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
	$pg = mysqli_fetch_array(execute_query(connect(), "select * from pg_subject where student_id=".$stu_id['sno']));
	
	if($result_cla['type']=='PG'){
		$pgsub1 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub1']));
		$pgsub2 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub2']));
		$pgsub3 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub3']));
		$pgsub4 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub4']));
		$pgsub5 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub5']));
		$pgsub6 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub6']));
	}
	$fees_amount = calc_fees($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
	if($stu_id['category']=='GEN' || $stu_id['category']=='OBC'){
		$second_install=calc_second_fees_gen($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
	}
	else{
		if($stu_id['annual_income']>1){
			$second_install=calc_second_fees_gen($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
		}
		else{
			$second_install=calc_second_fees_sc($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
		}
	}
	
	if($fee_deposit['tot_amount']!=$fee_deposit['amount_paid']){
		$amount_paid = $row_invoice3['amount_paid'];
		$sql_invoice_due3 = 'SELECT SUM(`amount_paid`) AS amount FROM `fee_invoice3` WHERE `type`="due" AND `student_id`="'.$sno.'" AND `sno`>"'.$row_invoice3['sno'].'"';
		$result_invoice_due3 = execute_query(connect(),$sql_invoice_due3);
		$row_invoice_due3 = mysqli_fetch_array($result_invoice_due3);
		$amount_paid += $row_invoice_due3['amount'];
	}
	
	$sql='select * from fee_invoice where student_id="'.$stu_id['sno'].'" and type="computer"';
	$comp_result=mysqli_fetch_array(execute_query(connect(), $sql));
	if($comp_result['tot_amount']!=''){
		$computer=$comp_result['tot_amount'];
	}
	else{
		$computer=0;
		}
	$sql='select * from fee_invoice2 where student_id="'.$stu_id['sno'].'" and type="computer"';
	$computer_result=mysqli_fetch_array(execute_query(connect(), $sql));
	if($computer_result['tot_amount']!=''){
		$computer=$computer_result['tot_amount'];
	}
	else{
		$compuer=0;
	}
	$sql='select * from fee_invoice3 where student_id="'.$stu_id['sno'].'" and type="breakage"';
	$breakage=mysqli_fetch_array(execute_query(connect(), $sql));
	$breakage=$breakage['tot_amount'];
	
	$sql='select * from fee_invoice3 where student_id="'.$stu_id['sno'].'" and type="tour"';
	$tour=mysqli_fetch_array(execute_query(connect(), $sql));
	$tour=$tour['tot_amount'];
	
	$response=2;
}
if(isset($_POST['save']) or isset($_GET['stu'])) {
	if($_POST['stu_name']!='' && $_POST['father_name']!=''){
		$sql="select * from student_info where stu_name like '".$_POST['stu_name']."%' and father_name like '".$_POST['father_name']."%'";
	}
	else if($_POST['roll_no']!=''){
		$sql="select * from student_info where roll_no='".$_POST['roll_no']."'";
	}
	else{
		$sql="select * from student_info where form_no='".$_POST['stu_id']."'"; 
	}
	
    $result =execute_query(connect(), $sql);
	$i=1;
	$msg .= '			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white "><th >Sno</th><th >Student Name</th><th>Father Name</th>				             <th ">Mother Name</th><th >Form No.</th><th>Roll No.</th><th >Edit</th></tr>';
	while($stu = mysqli_fetch_array($result)){
		if($i%2!=0){
			$col = "#EEE";
		}
		else {
			$col = "#ccc";
		}
			$sql = 'select `student_id` as `sno`, `stu_name`, `father_name`, `mother_name`, `class`, `reservation`, `waightage`, `minority`, `dob`, `acc_no`, `bank_name`, `branch_name`, `temp_address`, `perm_address`, `pin`, `mobile`, `p_mobile`, `p_pin`, `date_of_admission`, `gender`, `photo_id`, `signature_id`, `subject_id`, `district`, `state`, `category`, `form_no`, `p_district`, `p_state`,`post`, `p_post`,`sub1`, `sub2`, `sub3`, `e_mail1`, `e_mail2`, `status`, `roll_no`, `marks`, `counselling_date`, `cat_rank`, `income_certificate`, `annual_income`, `other_univ`, `user_id`, `icard`, `univ_roll` , `remarks` from student_info2 where status=2 and student_id='.$stu['sno'];
			//echo $sql;
			$r_chk = execute_query(connect(), $sql);
			$row_chk = mysqli_num_rows($r_chk);
			if($row_chk!=0){
				$sno=$stu['sno'];
				$stu = mysqli_fetch_array($r_chk);
				//print_r ($stu).'<br>';
			}
			else{
				$sno=$stu['sno'];
			}
			$msg .= '<tr >
			<td>'.$i++.'</td><td>'.$stu['stu_name'].'</td><td>'.$stu['father_name'].'</td><td>'.$stu['mother_name'].'</td>
			<td>'.$stu['form_no'].'</td><td>'.$stu['roll_no'].'</td><td><a href="edit_second_fee.php?id='.$stu['sno'].'">'.$stu['sno'].'</td></tr>';
	}
			$msg .= '</table></div>';
			$response=1;
		
}

page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript">
function changeid(id){
	var check=id;
	var id2 = id.replace('1', '');
	//alert(id2);
	if(document.getElementById(check).checked== true){			
		document.getElementById(id2).style.display = 'block';
	}
	else {
		document.getElementById(id2).style.display = 'none';
	}
}
function get_sum(){
	var breakage=document.getElementById('breakage').value;
	var total=document.getElementById('total').value;
	breakage=parseInt(breakage);
	total=parseInt(total);
	var grand=breakage+total;
	grand=parseInt(grand);
	document.getElementById('total').value=grand;
	}
</script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<div class="row d-flex my-auto">    	
				 <?php
				switch($response){
					case 1:{
				?>
  				<form action="edit_second_fee.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
                    <h2>Second <span class="orange">Instalment</span></h2>
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
					</div> 
						<input type="submit" class="submit btn btn-primary" name="save" value="Submit" style="margin-top:0px; margin-left:0px;"/>
										
				 </form>
			</div>
		</div> 
		<div class="card ">
			<?php echo $msg;?>	
		</div>
	</div>

<?php 
	break;
}
case 2:{

?>
<script language="javascript" type="text/javascript">
function fees_detail(){
	window.open('fees.php?a=<?php echo $stu_id['class']."&b=".$stu_id['sub1']."&c=".$stu_id['sub2']."&d=".$stu_id['sub3']."&e=".$stu_id['gender']; ?>');
}
function printinvoice() {
	window.open('print_second_install.php?inv=<?php echo $fee_deposition['sno']; ?>');
}
function dup_printinvoice() {
	window.open('printing_duplicate.php?inv=<?php echo $fee_deposition['sno']; ?>');
}
 function print_certificate(){
	 window.open('print_certificate.php?sno=<?php echo $stu_id['sno']; ?>');
 }
 function form_cancel(){
	 window.location = 'edit_second_fee.php';
 }
 </script>
	<div class="card card-body"> 
		<div class="d-flex my-auto row">
			<form action="edit_second_fee.php?id=<?php echo $_GET['id']; ?>" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" method="post">
				<div class="bg-primary text-white">
					<h2 align="center">Second <span class="orange">Instalment</span></h2> 					
						<input type="button" name="fees_amount1" class="btn btn-danger" onClick="return printinvoice()" style="float: right;"
							value="Fee Receipt">
						<?php if($stu_id['status']==2){?>
						<?php }
						else {
						?>
						<?php } ?>
					
				</div>
				<?php echo '<h3>'.$msg.'</h3>'; ?>
				<table width="100%" class="table table-striped table-hover rounded">
					<tr>
						<th>Form Number</th>
						<td><?php echo $stu_id['form_no']; ?></td>
						<th>Roll Number</th>
						<td><?php echo $stu_id['roll_no']; ?></td>
						<th>Candidate's Full Name</th>
						<td><?php echo $stu_id['stu_name']; ?></td>
					</tr>
					<tr>
						<th>Date Of Admission</th>
						<td><?php echo $timestamp; ?></td>
						<th>Father's Name</th>
						<td><?php echo $stu_id['father_name']; ?></td>
						<th>Mother's Name</th>
						<td><?php echo $stu_id['mother_name'];?></td>
					</tr>
					<tr>
						<th>Date of Birth</th>
						<td><?php echo $stu_id['dob']; ?></td>
						<th>Gender</th>
						<td><?php 
						  if($stu_id['gender']=='F'){
							  echo 'Female';
						  }
						  else{
							  echo 'Male';
						  }?></td>
						<th>Category</th>
						<td><?php echo $stu_id['category']; ?></td>
					</tr>
					<tr>
						<th>Minority</th>
						<td><?php if($stu_id['minority']=='NO'){echo ' NO';} else{ echo 'YES';} ?></td>
						<th>Annual Income</th>
						<td><?php if($stu_id['annual_income']>1){echo 'Above 2 Lakhs';}  else{echo 'Below 2 Lakhs';}?></td>
						<th colspan="2"><?php
						if($fee_deposit['tot_amount']!=$fee_deposit['amount_paid']){
							echo '<label  class="desc" for="opt_cat">Total Fees<span class="alert">*</span></label>
							   '.$fee_deposit['tot_amount'].'
							  ';
						}	
					?></th>
						
					</tr>
					<tr>
						<th>First Instalment</th>
						<td><?php echo $fee_deposit['amount_paid']; ?></td>
						<th>Second Instalment</th>
						<td><?php echo $second_install; ?><input type="hidden" name="fees_amount" value="<?php echo $second_install;?>" /></td>
						<th>Computer Fees</th>
						<td><?php echo $computer; ?>
							<input type="hidden" name="computer" value="<?php echo $computer;?>" /></td>
					</tr>
					<tr>
						<th>Breakage Fees</th>
						<td><input class="fieldtextmedium" type="checkbox" id="breakage1" name="breakage1"onFocus="fnTXTFocus(this.id)" onChange="changeid(this.id)" />
							<input type="text" name="breakage" onBlur="get_sum()" style="display:none" id="breakage"value="<?php echo $breakage;?>" /></td>
						<th>Tour Fees</th>
						<td><input class="fieldtextmedium" type="checkbox" id="tour1" name="tour1" onFocus="fnTXTFocus(this.id)" onChange="changeid(this.id)" />
							<input type="text" name="tour" onBlur="get_sum()" style="display:none" id="tour" value="<?php echo $tour;?>" /></td>
						<th>Total Fees</th>
						<td><input type="text" name="total" id="total" value="<?php echo ($second_install+$computer); ?>" readonly /></td>
					</tr>
					<tr>
						<th>Class</th>
						<td><?php echo $result_cla['class_description']; ?>
							<input type="hidden" id="class_id" name="class_id" value="<?php echo $result_cla['sno']; ?>" /></td>
						<th>Subjects</th>
						<td>1. <?php echo $sub1['subject']; ?></td>
						<td>2. <?php echo $sub2['subject']; ?></td>
						<td>3. <?php echo $sub3['subject']; ?></td>
					</tr>
				</table>		
				<div>
					<input type="hidden" value="" id="current">
					<input type="hidden" value="<?php echo $i; ?>" name="id" id="id">
					<input class="submit btn btn-primary " type="submit" name="submit" value="Submit" title="Continue" />
					<input type="hidden" name="student_id" value="<?php echo $stu_id['sno']; ?>" />
					<input class="submit btn btn-danger" type="submit " name="fee" value="Delete Fee" onClick="return confirm('Are you sure?')" title="Continue" />
					<input class="submit btn btn-success" type="submit"  name="breakage_fee" value="Delete Breakage Fee"	onClick="return confirm('Are you sure?')" title="Continue" />
				</div>
			</form>
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
</body>	   