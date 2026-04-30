<?php
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$response=1;
$msg='';
$fee_print['sno']=0;

if(isset($_POST['submit1'])){
	$_GET['dbn'] = $_POST['dbn'];
	$stu_id = mysqli_fetch_array(execute_query(connect(), "select * from `".$_POST['dbn']."`.`student_info` where sno=".$_POST['student_id']));
	$result_cla = mysqli_fetch_array(execute_query(connect(), "select * from `".$_POST['dbn']."`.`class_detail` where sno=".$stu_id['class']));
	
	$time = strtotime($_POST['doa']);
	$month = date("m",$time);
	$current_year = date("Y",$time);

	$fy = $current_year;
	if($month>=1 && $month<=3){
		$fy = $fy-1;
	}
	
	
	if(!isset($_POST['edit_sno'])){
		$sql = 'select * from `'.$_POST['dbn'].'`.`head_type_misc`';
		$result_head = execute_query(connect(), $sql);
		while($row_head = mysqli_fetch_assoc($result_head)){
			if($_POST['amount_def_'.$row_head['sno']]!=''){
				$sql = 'insert into `'.$_POST['dbn'].'`.`fees_detail_misc` (student_id, head_id, fee_amount) values ("'.$_POST['student_id'].'", "'.$row_head['sno'].'", "'.$_POST['amount_def_'.$row_head['sno']].'")';	
				execute_query(connect(), $sql);
			}
		}
	}

	$sql = 'select * from `'.$_POST['dbn'].'`.`fees_detail_misc` left join head_type_misc on head_type_misc.sno = fees_detail_misc.head_id where student_id="'.$_POST['student_id'].'"';
	$result_misc = execute_query(connect(), $sql);
	while($row_misc = mysqli_fetch_assoc($result_misc)){
		if($_POST['amount_'.$row_misc['head_id']]!=''){
			if(isset($_POST['edit_sno'])){
				$sql = 'update `'.$_POST['dbn'].'`.`fee_invoice_misc` set 
				approval_date = "'.$_POST['doa'].'", 
				amount_paid = "'.$_POST['amount_'.$row_misc['head_id']].'", 
				fee_session = "'.$fy.'"
				where sno = "'.$_POST['edit_sno'].'"';
			}
			else{
				$sql = 'insert into `'.$_POST['dbn'].'`.`fee_invoice_misc` (head_id, class_id, student_id, fees_amount, discount, tot_amount, approval_date, status, e_pin, amount_paid, fee_session) values ("'.$row_misc['head_id'].'", "'.$stu_id['class'].'", "'.$stu_id['sno'].'", 0, 0, 0, "'.$_POST['doa'].'", 0, "", "'.$_POST['amount_'.$row_misc['head_id']].'", "'.$fy.'")';

			}
			//echo $sql;
			execute_query(connect(), $sql);
		}
	}
	$_GET['id'] = $_POST['student_id'];
}

if(isset($_GET['id']) or isset($_POST['Submit3'])){
	if(!isset($_GET['dbn'])){
		$_GET['dbn'] = $_SESSION['db_name'];
	}
	if(isset($_POST['Submit3'])){
		$_GET['id'] = $_POST['student_id'];
	}
	$stu_id = mysqli_fetch_array(execute_query(connect(), "select * from `".$_GET['dbn']."`.`student_info` where sno=".$_GET['id']));
	$result_cla = mysqli_fetch_array(execute_query(connect(), "select * from `".$_GET['dbn']."`.`class_detail` where sno=".$stu_id['class']));
	$session = mysqli_fetch_array(execute_query(connect(), "select * from `".$_GET['dbn']."`.`general_settings` where description='session'"));
	$response=2;
}

if(isset($_POST['save']) or isset($_GET['stu'])) {
	if($_POST['stu_name']!='' && $_POST['father_name']!=''){
		$sql="select * from student_info where stu_name like '".$_POST['stu_name']."%' and father_name like '".$_POST['father_name']."%' and status=2";
	}
	else if($_POST['roll_no']!=''){
		$sql="select * from student_info where roll_no='".$_POST['roll_no']."' and status=2";
	}
	else{
		$sql="select * from student_info where form_no='".$_POST['stu_id']."' and status=2"; 
	}
	//echo $sql;
	$result = execute_query(connect(), $sql);
	$i=1;
	$msg .= '		<div class="card card-body"><table width="100%" class="table table-striped table-hover rounded"><tr class="bg-primary text-white"><th >Sno</th><th >Student Name</th><th>Father Name</th> <th ">Mother Name</th><th >Form No.</th><th>Roll No.</th><th >Edit</th></tr>';
	while($stu = mysqli_fetch_array($result)){
		if($i%2!=0){
			$col = "#EEE";
		}
		else {
			$col = "#ccc";
		}
		$msg .= '<tr style="background:'.$col.';"><td>'.$i++.'</td><td>'.$stu['stu_name'].'</td><td>'.$stu['father_name'].'</td><td>'.$stu['mother_name'].'</td><td>'.$stu['form_no'].'</td><td>'.$stu['roll_no'].'</td>';
		$sql = 'select * from fees_detail_misc where student_id="'.$stu['sno'].'"';
		$res_stu = execute_query(connect(), $sql);
		if(mysqli_num_rows($res_stu)!=0){
			$msg .= '<td style="color:#0F0"><a href="deposit_misc_fees.php?id='.$stu['sno'].'">Misc Fees Alloted</a></td>';
		}
		else{
			$msg .= '<td style="color:#F00">Not Alloted</td>';
		}
		$msg .= '</tr>';
		
	}
	$msg .= '</table> </div>';
	$response=1;
}

if(isset($_GET['fid'])){
	$sql = 'SELECT fee_invoice_misc.sno as sno, approval_date, head_type_misc.sno as head_id, head_type_misc.fee_type as fee_type, amount_paid FROM `'.$_GET['dbn'].'`.`fee_invoice_misc` left join `'.$_GET['dbn'].'`.`head_type_misc` on head_type_misc.sno = head_id where fee_invoice_misc.sno='.$_GET['fid'];
	//echo $sql;
	$old_data = mysqli_fetch_assoc(execute_query(connect(), $sql));
	$_POST['doa'] = $old_data['approval_date'];
			
}

if(isset($_GET['del'])){
	$sql = 'delete from `'.$_GET['dbn'].'`.fee_invoice_misc where sno='.$_GET['del'];
	execute_query(connect(), $sql);
}

page_header_end();
page_sidebar();
?>


<?php
switch($response){
	case 1:{
?>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="deposit_misc_fees.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
					<h2>Misc Fees <span class="orange">Deposit</span></h2>
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
	
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="deposit_misc_fees.php" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" method="post" onSubmit="return validate_readmission()">
					<?php	echo $msg;	?>
					<h2 align="center">Deposit Misc. <span class="orange">Fees</span></h2>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Session</label>
								<input type="text" name="value" class="form-control" value="<?php echo $session['value']; ?>" >
							</div>
							<div class="col-md-4">							
								<label>Candidate's Full Name </label>
								<input type="text" name="stu_name" class="form-control" value="<?php echo $stu_id['stu_name']; ?>" >
							</div>
							<div class="col-md-4">							
								<label> class </label>
								<input type="text" name="class_description" class="form-control" value="<?php echo $result_cla['class_description']; ?>" >
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Father's Name</label>
								<input type="text" name="father_name" class="form-control" value="<?php echo $stu_id['father_name']; ?>" >
							</div>
							<div class="col-md-4">							
								<label>Mother's Name</label>
								<input type="text" name="mother_name" class="form-control" value="<?php echo $stu_id['mother_name']; ?>" >
							</div>
							<div class="col-md-4">							
								<label>Deposit Date</label>
								<input type="date" name="doa" class="form-control" value="<?php if(isset($_POST['doa'])){echo $_POST['doa'];}else{echo date("Y-m-d");} ?>" >
							</div>
						</div>
					</div>

					<div class="card card-body">
						<table width="100%" class="table table-striped table-hover rounded">
							<tr class="table-primary ">
									<th>S.No.</th>
									<th>Head Name</th>
									<th>Amount</th>
									<th>Amount Deposited Till Date</th>
									<th>Pending</th>
									<th>Amount To Be Deposited</th>
							</tr>
							<?php
							if(isset($old_data)){
								echo '<tr>
								<th align="center" colspan="6" style="color:#f90; font-size:16px;">Edit Mode</th></tr>';
							}
							$i=1;
							$sql = 'select * from `'.$_GET['dbn'].'`.`head_type_misc`';
							$result_head = execute_query(connect(), $sql);
							while($row_head = mysqli_fetch_assoc($result_head)){
								echo '<tr>
								<td>'.$i++.'</td>
								<td>'.$row_head['fee_type'].'</td>';
								
								$sql = 'select * from `'.$_GET['dbn'].'`.`fees_detail_misc` left join head_type_misc on head_type_misc.sno = fees_detail_misc.head_id where student_id="'.$stu_id['sno'].'" and head_id="'.$row_head['sno'].'"';
								$result_misc = execute_query(connect(), $sql);
								if(mysqli_num_rows($result_misc)==0){
									if(!isset($old_data)){
										echo '<td><input type="text" name="amount_def_'.$row_head['sno'].'" placeholder="'.$row_head['amount'].'"></td>';
									}
									else{
										echo '<td></td>';
									}
									$row_misc['fee_amount'] = 0;
								}
								else{
									$row_misc = mysqli_fetch_assoc($result_misc);
									echo '<td>'.$row_misc['fee_amount'].'</td>';
								}

								$sql = 'select head_id, sum(amount_paid) as amount_paid from `'.$_GET['dbn'].'`.`fee_invoice_misc` where student_id="'.$stu_id['sno'].'" and head_id='.$row_head['sno'];
								//echo $sql;
								$result_deposit = execute_query(connect(), $sql);
								if(mysqli_num_rows($result_deposit)!=0){
									$row_deposit = mysqli_fetch_assoc($result_deposit);
								}
								else{
									$row_deposit['amount_paid'] = 0;
								}

								echo '<td>'.$row_deposit['amount_paid'].'</td>
								<td>'.($row_misc['fee_amount']-$row_deposit['amount_paid']).'</td>
								<td>';
								if(isset($old_data)){
									if($old_data['head_id']==$row_head['sno']){
										echo '<input type="text" name="amount_'.$row_head['sno'].'" value="'.$old_data['amount_paid'].'">';
									}
								}
								else{
									echo '<input type="text" name="amount_'.$row_head['sno'].'" value="">';
								}
								
								echo '</td>
								</tr>';
							}
							if(isset($old_data)){
								echo '<input type="hidden" name="edit_sno" value="'.$_GET['fid'].'">';
							}
							?>
						</table>
					</div>
					<div class="card card-body">
					<h3>Fees Deposit Details</h3>
						<table width="100%" class="table table-striped table-hover rounded">
							<tr class="table-primary ">

						<th>S.No.</th>
						<th>Deposit Date</th>
						<th>Head Type</th>
						<th>Amount</th>
						<th></th>
						<th></th>
					</tr>
				   <?php
						$i=1;
						$sql = 'SELECT fee_invoice_misc.sno as sno, approval_date, head_type_misc.fee_type as fee_type, amount_paid FROM `'.$_GET['dbn'].'`.`fee_invoice_misc` left join `'.$_GET['dbn'].'`.`head_type_misc` on head_type_misc.sno = head_id where student_id="'.$stu_id['sno'].'" order by approval_date';
						$result_deposit = execute_query(connect(), $sql);
						while($row_deposit = mysqli_fetch_assoc($result_deposit)){
							echo '<tr>
							<td>'.$i++.'</td>
							<td>'.$row_deposit['approval_date'].'</td>
							<td>'.$row_deposit['fee_type'].'</td>
							<td>'.$row_deposit['amount_paid'].'</td>
							<td><a href="deposit_misc_fees.php?dbn='.$_GET['dbn'].'&id='.$_GET['id'].'&fid='.$row_deposit['sno'].'">Edit</a></td>
							<td><a href="deposit_misc_fees.php?dbn='.$_GET['dbn'].'&id='.$_GET['id'].'&del='.$row_deposit['sno'].'" onClick="return confirm(\'Are you sure?\');" style="color:#F00">Delete</a></td>
							</tr>';
						}
					
					?>
					
								</table>
								<input type="hidden" value="" id="current">
								<input type="hidden" value="<?php echo $stu_id['sno']; ?>" name="id" id="id">
							
					<div>
						<input class="submit" type="submit" class="btn btn-primary" name="submit1" value="Submit" title="Continue" />
						<input type="hidden" name="student_id" value="<?php echo $stu_id['sno']; ?>" />
						<input type="hidden" name="dbn" value="<?php echo $_GET['dbn']; ?>" />
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
</body>