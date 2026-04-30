<?php
include("scripts/settings.php");
include("scripts/setting_sms.php");
$msg='';
$tab=1;
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);

$sql = 'select * from general_settings where `description`="school_name"';
$school_name = mysqli_fetch_array(execute_query($db, $sql));
$school_name = $school_name['value'];

$sql = 'select * from general_settings where `description`="address"';
$address = mysqli_fetch_array(execute_query($db, $sql));
$address = $address['value'];

$msg='';
if(isset($_POST['print'])) {
	$response=3;
}
if(isset($_REQUEST['id'])){
	$response=2; 
}
else {
	$response=1;
}
if(isset($_POST['submit'])) {
	if(!isset($_POST['bank'])){
		$_POST['bank']='';
	}
	if(!isset($_POST['c_no'])){
		$_POST['c_no']='';
	}
	
	$date = $_POST['submitdate'];
	$time = strtotime($date);
	$month = date("m",$time);
	$year = date("Y",$time);
	if($month>=1 && $month<=3){
		$year = $year-1;
	}

	$sql = 'select * from d_fees_invoice where type="TAX" and financial_year="'.$year.'" order by abs(invoice_no) desc limit 1';
	$invoice_result = execute_query($db, $sql);
	if(mysqli_num_rows($invoice_result)!=0){
		$invoice_no = mysqli_fetch_array($invoice_result);
		$_POST['invoice_no'] = $invoice_no['invoice_no']+1;
	}
	else{
		$_POST['invoice_no'] = 1;
	}

	
	$sql = 'select * from d_student_info where sno='.$_POST['roll_no'];
	$student = mysqli_fetch_assoc(execute_query($db, $sql));
	
	$sql = 'select * from d_section where sno='.$student['class'];
	$section = mysqli_fetch_assoc(execute_query($db, $sql));
	
	$_GET['vfs'] = $section['sno'];		  
						  
	$sql = 'select * from general_settings where description="session_start_date"';
	$session_start = mysqli_fetch_assoc(execute_query($db, $sql))['value'];

	$sql = 'select * from general_settings where description="current_date"';
	$session_end = mysqli_fetch_assoc(execute_query($db, $sql))['value'];
	
	$sql = 'INSERT INTO `d_fees_invoice` (`student_id`, `class_id`, `entry_date`, `date_from`, `date_to`, `total_amount`, `total_discount`, `amount_payable`, `amount_paid`, `mode_of_payment`, `transaction_no`, `type`, `invoice_no`, `financial_year`, `status`, `created_by`, `creation_time`, `remarks`) VALUES ("'.$_POST['roll_no'].'", "'.$_GET['vfs'].'", "'.$_POST['submitdate'].'", "'.$_POST['date_from'].'", "'.$_POST['date_to'].'", "'.$_POST['fees_amount'].'", "'.$_POST['total_discount'].'", "'.$_POST['total_amount'].'", "'.$_POST['cash_down'].'", "'.$_POST['mod'].'", "'.($_POST['bank'].'-'.$_POST['c_no']).'", "TAX", "'.$_POST['invoice_no'].'", "'.$year.'", "0", "'.$_SESSION['username'].'", "'.date("Y-m-d H:i:s").'", "'.$_POST["remarks"].'")';
	execute_query($db, $sql);
	if(mysqli_error($db)){
		$msg .= '<li class="text-danger">Error # 1 : '.mysqli_error($db).' >> '.$sql.'</li>';
	}
	else{
		$inv_id = mysqli_insert_id($db);

		$sql = 'SELECT d_fees_structure.sno as sno, d_fees_structure.class_id, d_fees_structure.head_id, d_fees_structure.recurring_duration, d_fees_structure.amount, d_fees_structure.status, d_class_desc, head_name FROM `d_fees_structure` left join d_class on d_class.sno = class_id left join d_fees_head_master on d_fees_head_master.sno = head_id where class_id='.$_GET['vfs'];
		//echo $sql;
		$result = execute_query($db, $sql);
		$print = array();
		$head = array();

		while($row = mysqli_fetch_assoc($result)){
			$class_name = $row['class_desc'];
			$class_id = $row['class_id'];
			$print[$row['head_id']][$row['recurring_duration']] = $row['amount'];
		}
		foreach($print as $k=>$v){
			$head[] = $k;
		}

		$recurring = 12;
		$tot = array();
		$cash_down = $_POST['cash_down'];
		while($session_end>$session_start){
			$month = date("m", strtotime($session_start));
			$month_words = strtolower(date("M", strtotime($session_start)));
			foreach($head as $v){
				$discount_value = 0;
				if(!isset($tot[$v])){
					$tot[$v]=0;
					$tot[$v.'_discount']=0;
				}
				$sql = 'SELECT d_fees_structure.sno as sno, d_fees_structure.class_id, d_fees_structure.head_id, d_fees_structure.recurring_duration, d_fees_structure.amount, d_fees_structure.status, class_desc, head_name FROM `d_fees_structure` left join d_class on d_class.sno = class_id left join d_fees_head_master on d_fees_head_master.sno = head_id where class_id='.$_GET['vfs'].' and head_id='.$v;
				$result_head_val = execute_query($db, $sql);
				if(mysqli_num_rows($result_head_val)!=0){
					$row_head_val = mysqli_fetch_assoc($result_head_val);
					$name = date("Ym_", strtotime($session_start)).$v;

					if(is_numeric($row_head_val['recurring_duration'])){
						if($recurring%$row_head_val['recurring_duration']==0){
							$sql = '(select sno, discount_value from d_discount_structure where discount_type="class" and discount_id="'.$_GET['vfs'].'" and head_id='.$v.' and "'.date("Y-m-01", strtotime($session_start)).'" between date_from and date_to ) union all (select sno, discount_value from d_discount_structure where discount_type="head" and discount_id='.$v.' and "'.date("Y-m-01", strtotime($session_start)).'" between date_from and date_to ) union all (select sno, discount_value from d_discount_structure where discount_type="student" and discount_id='.$_POST['roll_no'].' and head_id='.$v.' and "'.date("Y-m-01", strtotime($session_start)).'" between date_from and date_to )';
							$discount_id=array();
							$result_discount = execute_query($db, $sql);
							if(mysqli_num_rows($result_discount)!=0){
								while($row_discount = mysqli_fetch_assoc($result_discount)){
									$discount_value += $row_discount['discount_value'];
									$discount_id[] = $row_discount['sno'];
									$tot[$v.'_discount'] += $discount_value;
								}
							}
							if(isset($_POST['col_'.$name])){
								if($cash_down>=$_POST['col_'.$name]){
									$amount_paid = $_POST['col_'.$name];
									$cash_down-=$_POST['col_'.$name];
								}
								else{
									$amount_paid = $cash_down;
									$cash_down=0;
								}
								$sql = 'INSERT INTO `d_fees_invoice_trans` (`student_id`, `class_id`, `invoice_no`, `entry_date`, `month_year`, `head_id`, `amount`, `discount`, `discount_id`, `amount_payable`, `amount_paid`, `status`, `created_by`, `creation_time`) VALUES ("'.$_POST['roll_no'].'", "'.$_GET['vfs'].'", "'.$inv_id.'", "'.$_POST['submitdate'].'", "'.date("Ym", strtotime($session_start)).'", "'.$v.'", "'.$row_head_val['amount'].'", "'.$discount_value.'", "'.implode("#", $discount_id).'", "'.$_POST['col_'.$name].'", "'.$amount_paid.'", "0", "'.$_SESSION['username'].'", "'.date("Y-m-d H:i:s").'")';
								execute_query($db, $sql);
								if(mysqli_error($db)){
									$msg .= '<li class="text-danger">Error # 2 : '.mysqli_error($db).' >> '.$sql.'<li>';
								}
							}
						}
					}
					else{
						$sql = 'SELECT d_fees_structure.sno as sno, d_fees_structure.class_id, d_fees_structure.head_id, d_fees_structure.recurring_duration, d_fees_structure.amount, d_fees_structure.status, class_desc, head_name FROM `d_fees_structure` left join d_class on d_class.sno = class_id left join fees_head_master on fees_head_master.sno = head_id where class_id='.$_GET['vfs'].' and head_id='.$v.' and recurring_duration="'.$month_words.'"';
						$result_month = execute_query($db, $sql);
						if(mysqli_num_rows($result_month)!=0){
							$sql = '(select sno, discount_value from d_discount_structure where discount_type="class" and discount_id="'.$_GET['vfs'].'" and head_id='.$v.' and "'.date("Y-m-01", strtotime($session_start)).'" between date_from and date_to ) union all (select sno, discount_value from d_discount_structure where discount_type="head" and discount_id='.$v.' and "'.date("Y-m-01", strtotime($session_start)).'" between date_from and date_to ) union all (select sno, discount_value from d_discount_structure where discount_type="student" and discount_id='.$_POST['roll_no'].' and head_id='.$v.' and "'.date("Y-m-01", strtotime($session_start)).'" between date_from and date_to )';
							$discount_id=array();
							$result_discount = execute_query($db, $sql);
							if(mysqli_num_rows($result_discount)!=0){
								while($row_discount = mysqli_fetch_assoc($result_discount)){
									$discount_value += $row_discount['discount_value'];
									$discount_id[] = $row_discount['sno'];
									$tot[$v.'_discount'] += $discount_value;
								}
							}
							if(isset($_POST['col_'.$name])){
								if($cash_down>=$_POST['col_'.$name]){
									$amount_paid = $_POST['col_'.$name];
									$cash_down-=$_POST['col_'.$name];
								}
								else{
									$amount_paid = $cash_down;
									$cash_down=0;
								}
								$sql = 'INSERT INTO `d_fees_invoice_trans` (`student_id`, `class_id`, `invoice_no`, `entry_date`, `month_year`, `head_id`, `amount`, `discount`, `discount_id`, `amount_payable`, `amount_paid`, `status`, `created_by`, `creation_time`) VALUES ("'.$_POST['roll_no'].'", "'.$_GET['vfs'].'", "'.$inv_id.'", "'.$_POST['submitdate'].'", "'.date("Ym", strtotime($session_start)).'", "'.$v.'", "'.$row_head_val['amount'].'", "'.$discount_value.'", "'.implode("#", $discount_id).'", "'.$_POST['col_'.$name].'", "'.$amount_paid.'", "0", "'.$_SESSION['username'].'", "'.date("Y-m-d H:i:s").'")';
								execute_query($db, $sql);
								if(mysqli_error($db)){
									$msg .= '<li class="text-danger">Error # 2 : '.mysqli_error($db).' >> '.$sql.'<li>';
								}
							}
						}
					}
				}
			}
			$recurring--;
			$session_start = date("Y-m-d", strtotime($session_start."+1 month"));
		}
		
		if($_POST['other_fees']!='' && $_POST['other_fees']!='0'){
			$sql = 'INSERT INTO `d_fees_invoice_trans` (`student_id`, `class_id`, `invoice_no`, `entry_date`, `month_year`, `head_id`, `amount`, `discount`, `discount_id`, `amount_payable`, `amount_paid`, `status`, `created_by`, `creation_time`) VALUES ("'.$_POST['roll_no'].'", "'.$_GET['vfs'].'", "'.$inv_id.'", "'.$_POST['submitdate'].'", "'.date("Ym").'", "other", "'.$_POST['other_fees'].'", "0", "", "'.$_POST['other_fees'].'", "'.$_POST['other_fees'].'", "0", "'.$_SESSION['username'].'", "'.date("Y-m-d H:i:s").'")';
			execute_query($db, $sql);
			if(mysqli_error($db)){
				$msg .= '<li class="text-danger">Error # 3.1 : '.mysqli_error($db).' >> '.$sql.'<li>';
			}
		}
		if($_POST['late']!='' && $_POST['late']!='0'){
			$sql = 'INSERT INTO `d_fees_invoice_trans` (`student_id`, `class_id`, `invoice_no`, `entry_date`, `month_year`, `head_id`, `amount`, `discount`, `discount_id`, `amount_payable`, `amount_paid`, `status`, `created_by`, `creation_time`) VALUES ("'.$_POST['roll_no'].'", "'.$_GET['vfs'].'", "'.$inv_id.'", "'.$_POST['submitdate'].'", "'.date("Ym").'", "late", "'.$_POST['late'].'", "0", "", "'.$_POST['late'].'", "'.$_POST['late'].'", "0", "'.$_SESSION['username'].'", "'.date("Y-m-d H:i:s").'")';
			execute_query($db, $sql);
			if(mysqli_error($db)){
				$msg .= '<li class="text-danger">Error # 3.1 : '.mysqli_error($db).' >> '.$sql.'<li>';
			}
		}
		if($_POST['comp_fees']!='' && $_POST['comp_fees']!='0'){
			$sql = 'INSERT INTO `d_fees_invoice_trans` (`student_id`, `class_id`, `invoice_no`, `entry_date`, `month_year`, `head_id`, `amount`, `discount`, `discount_id`, `amount_payable`, `amount_paid`, `status`, `created_by`, `creation_time`) VALUES ("'.$_POST['roll_no'].'", "'.$_GET['vfs'].'", "'.$inv_id.'", "'.$_POST['submitdate'].'", "'.date("Ym").'", "computer", "'.$_POST['comp_fees'].'", "0", "", "'.$_POST['comp_fees'].'", "'.$_POST['comp_fees'].'", "0", "'.$_SESSION['username'].'", "'.date("Y-m-d H:i:s").'")';
			execute_query($db, $sql);
			if(mysqli_error($db)){
				$msg .= '<li class="text-danger">Error # 3.1 : '.mysqli_error($db).' >> '.$sql.'<li>';
			}
		}
	}
}
if(isset($_GET['del'])){
	$sql = "delete from d_fees_invoice where sno=".$_GET['del'];
	execute_query($db, $sql);
	
	$sql = "delete from d_fees_invoice_trans where invoice_no=".$_GET['del'];
	execute_query($db, $sql);
	
	$msg .= '<li class="alert-danger">Invoice deleted.</li>';	
}

if(isset($_POST['save']) or isset($_POST['gen_sms'])){
	$_SESSION['sql_result_filter_nf_pending'] = 'select d_student_info.sno as sno, roll_no, sr_no, sname, fname, d_class.class_desc as class_desc, d_section.section as section, mobile from d_student_info left join section on d_section.sno = d_student_info.class left join class on d_class.sno = d_section.class_desc where `stu_status`!="3" ';
	if($_POST['classsection']!=''){
		$_SESSION['sql_result_filter_nf_pending'] .= ' and class = "'.$_POST['classsection'].'" ';
		//$_SESSION['sql_result_filter_nf_pending'] = 'select * from student_info where sno = 424';
	}
	if($_POST['supplier']!=''){
		$_SESSION['sql_result_filter_nf_pending'] .= ' and sname like "%'.$_POST['supplier'].'%" ';
		//$_SESSION['sql_result_filter_nf_pending'] = 'select * from student_info where sno = 424';
	}
	if($_POST['serial_number']!=''){
		$_SESSION['sql_result_filter_nf_pending'] .= ' and sr_no = "'.$_POST['serial_number'].'" ';
		//$_SESSION['sql_result_filter_nf_pending'] = 'select * from student_info where sno = 424';
	}
	$_SESSION['sql_result_filter_nf_pending'] .= ' order by sname';
	
}
elseif(!isset($_SESSION['sql_result_filter_nf_pending'])){
	$_SESSION['sql_result_filter_nf_pending'] = 'select * from d_student_info where 2=1';
	$_SESSION['sql_result_filter_nf_pending'] .= ' order by sname';
}

if(isset($_POST['gen_sms'])){
	$link = dbconnect();
	$result = execute_query($db, $_SESSION['sql_result_filter_nf_pending']);
	$i=1;
	//print_r($_POST);
	//die();
	if($result){
	while($row_sms = mysqli_fetch_array($result)){
		if(isset($_POST['sms_'.$row_sms['sno']])){
			$data = array($row_sms['sname'], $_POST['sms_'.$row_sms['sno']], $_POST['pending_amt_'.$row_sms['sno']], 5);
			generate_sms("pending_fees", $row_sms['sno'], $row_sms['mobile'], $data);
			$i++;
		}

	}
	}
	$msg .=  '<li class="text-success">'.$i.' SMS Generated.<li>';
}

//echo $_SESSION['sql_result_filter_nf_pending'];
page_header_start();
page_header_end();
page_sidebar();
?>
<script language="javascript" type="text/javascript">

$(function() {
	var options = {
		source: "sale_ajax.php?id=cust_name",
		minLength: 1,
		select: function( event, ui ) {
			log( ui.item ?
				"Selected: " + ui.item.value + " aka " + ui.item.label :
				"Nothing selected, input was " + this.value );
		},
		select: function( event, ui ) {
		    $("[name='supplier']").val(ui.item.label);
			$('#supplier_sno').val(ui.item.id);
			$("#ajax_loader").show();
			$("#final_result").load("sale_ajax_new.php?supplier_sno="+ui.item.id, function(){ $("#ajax_loader").hide(); });
			return false;
		}
	};


	$("input#supplier").on("keydown.autocomplete", function() {
		$(this).autocomplete(options);
	});
});
</script>

<?php
 switch ($response) {
	 case $response==1: {
?>		
<style type="text/css">
@media print {
    html, body {
        height: auto;
        font-size: 17px; /* changing to 10pt has no impact */
    }

}
</style>
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="pendingfees" enctype="multipart/form-data" method="post" onSubmit="" >
	<div class="bg-primary text-white p-2"><h3>Pending Fees</h3></div>
		<span style="float:right;"><img src="images/print.png"  onclick="window.print();"></span>
		<table width="100%" class="table table-striped table-hover rounded">
			<tr>
				<td>Select Class</td>
				<td>
				<?php echo '
				<div><select class="form-control" name="classsection" id="classsection" >
				<option value=""></option>';
				$sql = 'select * from d_section';
				$res = execute_query($db, $sql);
				while($row = mysqli_fetch_array($res)) {
					$sql1 = 'select * from d_class where sno="'.$row['class_desc'].'"';
					$result = mysqli_fetch_array(execute_query($db, $sql1));
					echo '<option value="'.$row['sno'].'" ';
					if (isset($_POST['classsection'])) {
						if ($_POST['classsection'] == $row['sno']) {
							echo 'selected';
						}
					}
					echo '>'.$result['class_desc'].' '.$row['section'].'</option>';
				}
				?>
				</td>
				<td>Select Month</td>
				<td>
					<select name="month" class="form-control">
						<option value="all">All</option>
						<?php
						$sql = 'select * from general_settings where description="session_start_date"';
						$session_start = $temp = mysqli_fetch_assoc(execute_query($db, $sql))['value'];
						$current_year = date("Y", strtotime($session_start));

						 for($i=1;$i<=12;$i++){
							 if($i<=3){
								 $year = $current_year+1;
							 }
							 else{
								 $year = $current_year;
							 }
							 $date = date("Y-m-d", strtotime("$year-".$i."-01"));
							 echo '<option value="'.$date.'" ';
							 if(isset($_POST['month'])){
								 if($_POST['month']==$date){
									 echo ' selected="selected" ';
								 }
							 }
							 echo '>'.date("M", strtotime($date)).'</option>';
						 }
						 
						 ?>
					</select>
				</td>
				<td>Student Name</td>
				<td><input id="supplier" name="supplier"  maxlength="255" class="form-control" tabindex="2" type="text" value="<?php if(isset($_POST['supplier'])){echo $_POST['supplier'];} ?>"></td>
				
			</tr>
			<tr>
				<!--<td>Father Name</td>
				<td><input id="father_name" name="father_name"  maxlength="255" tabindex="3" type="text"></td>-->
				<td>Serial No.</td>
				<td><input id="serial_number" name="serial_number" class="form-control"  maxlength="255" tabindex="5" type="text" value="<?php if(isset($_POST['serial_number'])){echo $_POST['serial_number'];} ?>"></td>
				<!--<td>Roll No.</td>
				<td><input id="roll_number" name="roll_number"  maxlength="255" tabindex="5" type="text"></td>-->
			</tr>
		</table>
		<input type="submit" class="bmit btn btn-primary btn-25" name="save" value="Submit"/>
					<input type="submit" class=" btn btn-success" name="gen_sms" value="Generate SMS"/>
			<input id="supplier_sno" name="supplier_sno" type="hidden">	 
</div>			
</div>			
	<?php
	if(isset($_SESSION['sql_result_filter_nf_pending'])){
	?>
	<div class="card card-body">    
        	<div class="row d-flex my-auto">
			 <a href="pendingfees_export.php"><input type="button" style="margin-top:20px" name="student_ledger" class=" btn btn-danger"  style="float: left;" value="Download In Excel"></a></span>
		<table class="table table-hover table-responsive table-bordered table-striped">
		
           
            
		<tr class="bg-primary text-white">
			<th>S.No</th>
			
			<th>Serial Number</th>
			<th>Name</th>
			<th>Father Name</th>
			<th>Class</th>
			<th>Total Amount</th>
			<th>Discount</th>
			<th>Net Fees</th>
			<th>Paid Amount</th>
			<th>Cash Paid Amount</th>
			<th>Bank Paid Amount</th>
			<th>Pending Amount</th>
			<th>Pending Month</th>
			<th>Pending Month Fees</th>
			<th>SMS</th>
			<th class="noprint">&nbsp;</th>
		</tr>

		<?php
		//echo $_SESSION['sql_result_filter_nf_pending'];
		$_SESSION['sql5']= $_SESSION['sql_result_filter_nf_pending'];
		$_SESSION['sql6']= $_SESSION['sql5'];
		$link = dbconnect();
		$result = execute_query($db, $_SESSION['sql_result_filter_nf_pending']);

		$sql = 'select * from general_settings where `description`="session_start_date"';
		$session = mysqli_fetch_array(execute_query($db, $sql));
		$session = $session['value'];
		if(isset($_POST['serial_number'])){
			if($_POST['serial_number'] != '') {
				//echo 'a<br/>';
				if ($result && mysqli_num_rows($result) == 1) {
					$result_serial = execute_query($db, $_SESSION['sql_result_filter_nf_pending']);
					$row_serial = mysqli_fetch_array($result_serial);
					//echo 'b<br/>';
					$fees_open = get_pending_fees($row_serial['sno'], $session);
					if ($fees_open > 0) {
						//echo 'c<br/>';
						echo '<script>window.open("d_nf_pendingfees.php?id='.$row_serial['sno'].'")</script>';
					}		
				}
			}
		}

		$sql = 'select * from general_settings where `description`="current_date"';
		$cur = mysqli_fetch_array(execute_query($db, $sql));
		$cur_date = $cur['value'];
		$total_fees=0;
		$total_discount=0;
		$total_net_fees=0;
		$total_paid=0;
		$total_paid_cash=0;
		$total_paid_bank=0;
		$total_pending=0;
		$inv_no_arr = array();
		
		$i=1;
		if(!isset($_POST['month'])){
			$_POST['month']='all';
		}
		if($result){
		while($row = mysqli_fetch_array($result)){
			if($_POST['month']!='all'){
				$fees = get_pending_fees_new($row['sno'], $_POST['month']);
			}
			else{
				$fees = get_pending_fees_new($row['sno']);	
			}
			
			if($fees['total_fees']>0){
				$net_fees = $fees['total_fees']-$fees['total_discount'];
				echo '
				<tr><th>'.$i++.'</th><td>'.$row['sr_no'].'</td>
				<td>
					<a href="d_editadmission.php?id='.$row['sno'].'&class='.$row['class_desc'].'&section='.$row['section'].'" style="text-decoration:none">'.strtoupper($row['sname']).'
					</a>
				</td>
				<td>'.strtoupper($row['fname']).'</td>
				<td>'.strtoupper($row['class_desc']).'&nbsp;'. strtoupper($row['section']).'</td>
				<td>'.$fees['total_fees'].'</td>
				<td>'.$fees['total_discount'].'</td>
				<td>'.$net_fees.'</td>
				<td>'.$fees['amount_paid'].'</td>
				<td>'.$fees['cash_amount'].'</td>
				<td>'.$fees['bank_amount'].'</td>
				<td>'.($net_fees-$fees['amount_paid']).'</td>
			    <td>'.$fees['pending_month'].'</td>
				<td>'.$fees['pending_fees'].'</td>
				<td><input type="checkbox" name="sms_'.$row['sno'].'" id="sms_'.$row['sno'].'" '.(strtotime($fees['pending_month'])>=strtotime(date("Y-m-01"))?'':'checked="checked"').' value="'.$fees['pending_month'].'"><input type="hidden" name="pending_amt_'.$row['sno'].'" value="'.$fees['pending_fees'].'"></td>';
				echo'<td class="noprint"><a href="d_nf_pendingfees.php?id='.$row['sno'].'">Details</a></td></tr>';
				$total_fees+=$fees['total_fees'];
				$total_net_fees+=$net_fees;
				$total_discount+=$fees['total_discount'];
				$total_paid+=$fees['amount_paid'];
				$total_paid_cash+=$fees['cash_amount'];
				$total_paid_bank+=$fees['bank_amount'];
				$total_pending+=0;
			}
		}
		}
		echo '<tr>
		<th colspan="5" class="text-right">Total</th>
		<th>'.$total_fees.'</th>
		<th>'.$total_discount.'</th>
		<th>'.$total_net_fees.'</th>
		<th>'.$total_paid.'</th>
		<th>'.$total_paid_cash.'</th>
		<th>'.$total_paid_bank.'</th>
		<th>'.($total_net_fees-$total_paid).'</th>
		<th colspan="4"></th>
		</tr>';
	}

	?>
	</table>
</form>
<?php
break;
	 }
	 case $response==2 : {
?>
<script>
	function changeid(val){
		if(val=='cash'){
			$("#chequeno").css("display", "none");
			$("#bank").css("display", "none");
		}
		else{
			$("#chequeno").css("display", "block");
			$("#bank").css("display", "block");
		}
	}
	
		
	function amount_payable(id){
		var id_arr = id.split("_");
		var date_selected = (parseFloat(id_arr[1])?parseFloat(id_arr[1]):0);
		var date_from = (parseFloat($("#date_from").val())?parseFloat($("#date_from").val()):999999);
		var date_to = (parseFloat($("#date_to").val())?parseFloat($("#date_to").val()):0);
		var disc_id = id.replace("col_", "disc_");
		var disc = $("#"+disc_id).html();
		if(disc){
			var disc_val = parseFloat(disc.replace("Discount: ",""));
		}
		if(!disc_val){
			disc_val=0;
		}
		var total_amount = parseFloat($("#total_amount").val());
		if(!total_amount){
			total_amount=0;
		}
		var total_discount = parseFloat($("#total_discount").val());
		if(!total_discount){
			total_discount=0;
		}
		var val = parseFloat($("#"+id).val());
		if(!val){
			val=0;
		}
		if($("#"+id).prop('checked')){
			total_amount+=val;
			total_discount+=disc_val;
		}
		else{
			total_amount-=val;
			total_discount-=disc_val;
		}
		$("#total_amount").val(total_amount);
		$("#total_discount").val(total_discount);
		$("#fees_amount").val(total_amount+total_discount);
		if(date_selected<date_from){
			$("#date_from").val(date_selected);
		}
		else if(date_selected>date_to){
			$("#date_to").val(date_selected);
		}
		calc_total();
	}
	
	function calc_total(){
		var fees_calculated = (parseFloat($("#total_amount").val())?parseFloat($("#total_amount").val()):0);
		var other_fees = (parseFloat($("#other_fees").val())?parseFloat($("#other_fees").val()):0);
		var late = (parseFloat($("#late").val())?parseFloat($("#late").val()):0);
		var comp_fees = (parseFloat($("#comp_fees").val())?parseFloat($("#comp_fees").val()):0);
		var last_amount = (parseFloat($("#last_amount").val())?parseFloat($("#last_amount").val()):0);
		var cash_down = (parseFloat($("#cash_down").val())?parseFloat($("#cash_down").val()):0);
		
		var total_payable = fees_calculated+other_fees+late+comp_fees;
		$("#last_amount").val(total_payable);
		$("#cash_down").val(total_payable);
		
	}
	
	function verify_amount(){
		var total_payable = (parseFloat($("#last_amount").val())?parseFloat($("#last_amount").val()):0);
		var cash_down = (parseFloat($("#cash_down").val())?parseFloat($("#cash_down").val()):0);
		if(cash_down<=total_payable){
			return true;
		}
		else{
			return false;	
		}		
	}


</script>
<style type="text/css">
@media print {
    html, body {
        height: auto;
        font-size: 16px; /* changing to 10pt has no impact */
    }

}
</style>  
	<form action="nf_pendingfees.php?id=<?php echo $_GET['id']; ?>" class="wufoo leftLabel page1" name="pendingfees" enctype="multipart/form-data" method="post" onSubmit="return verify_amount();" >
		<span style="float:right;" onclick="window.print();" titel="Print Page"><img src="images/print.png"  ></span>
		<?php echo '<ul><h3>'.$msg.'</h3></ul>'; ?>
		<?php
		$sql = 'select * from general_settings where `description`="session_start_date"';
		$session = mysqli_fetch_array(execute_query($db, $sql));
		$session = $session['value'];

		$sql='select * from d_student_info where sno="'.$_GET['id'].'"';
		$new_stud = mysqli_fetch_array(execute_query($db, $sql));
		$sql='select * from d_section where sno="'.$new_stud['class'].'"';
		$sec1 = mysqli_fetch_array(execute_query($db, $sql));
		$sql='select * from d_class where sno="'.$sec1['class_desc'].'"';
		$class1=mysqli_fetch_array(execute_query($db, $sql));

		$sql = 'SELECT sum(amount_due) as due FROM `d_fee_invoice_trans` where amount_due !=0 and student_id="'.$new_stud['sno'].'" ';
		$last_due= execute_query($db, $sql);
		if(mysqli_num_rows($last_due)!=0){
			$last_due = mysqli_fetch_array($last_due);
		}

		$fees = get_pending_fees_new($_GET['id']);
		$sql='select *, sum(amount) as paid,sum(amount_due) as due from d_fee_invoice_trans where student_id="'.$_GET['id'].'"';
		//echo $sql;
		$paid = mysqli_fetch_array(execute_query($db, $sql));
		//echo $fees.'-'.$paid['paid'].'-'.$paid['due'];
		$rem_amt = $fees['total_fees']-($paid['paid']-$paid['due']);
		//$rem_amt = $fees-($paid['paid']);
		//$last_due['due']=$rem_amt;
						  
		$sql = 'select sname, fname, roll_no, d_student_info.sno as serial, d_student_info.sr_no as sr_no, pay_date, d_class.class_desc as class_desc, d_section.section as section from d_student_convey_fee left join d_student_info on d_student_info.sno = d_student_convey_fee.student_id left join d_section on d_section.sno = d_student_info.class left join class on d_class.sno = d_section.class_desc where d_student_convey_fee.status=0 and student_id="'.$_GET['id'].'"';
		//echo $sql;
		$temp_conv_result = execute_query($db, $sql);
		if(mysqli_num_rows($temp_conv_result)!=0){
			$conv = '<a href="d_pendingfees_con.php?id='.$_GET['id'].'" target="_blank">Click Here for Transport</a>';
		}
		  else{
			  $conv = '';
		  }
		?>   
		<table class="table table-responsive table-stripped table-hover">
			<tr>
				<td>Student Id</td>
				<td><input type="text" class="field text medium" name="roll_no" id="roll_no" value="<?php echo $new_stud['sno'];?>" readonly /></td>
				<td>Student Name</td>
				<td><input type="text" name="name" class="field text medium" id="name"  value="<?php echo strtoupper($new_stud['sname']);?>" readonly /></td>
				<td>Father Name</td>
				<td><input type="text" class="field text medium" name="fname" id="fname"  value="<?php echo strtoupper($new_stud['fname']);?>" readonly /></td>
			</tr>
			<tr>
				<td>Mother Name</td>
				<td><input type="text" name="mname" class="field text medium" id="mname"  value="<?php echo strtoupper($new_stud['mname']);?>" readonly /></td>
				<td>Class</td>
				<td><input type="text" name="class" class="field text medium" id="class"  value="<?php echo $class1['class_desc'].'&nbsp;'.$sec1['section'];?>" readonly /><input type="hidden" name="class_id" value="<?php echo $new_stud['class']; ?>" ></td>
				<td>Admission Type</td>
				<td><?php
				  if($new_stud['old_admission']==1){
					  echo '<b>Old Admission</b>';
				  }
				  else{
					  echo '<b>New Admission</b>';
				  }
				  ?></td>
			</tr>
			<tr>
				<td colspan="4"><?php echo $conv; ?></td>
			</tr>
		</table>
		<?php
			$_GET['vfs'] = $sec1['sno'];		  
						  
			$sql = 'select * from general_settings where description="session_start_date"';
			$session_start = mysqli_fetch_assoc(execute_query($db, $sql))['value'];
			
			$sql = 'select * from general_settings where description="current_date"';
			$session_end = mysqli_fetch_assoc(execute_query($db, $sql))['value'];
						  
			if($new_stud['old_admission']==1){
				$student_type = ' and (d_fees_structure.student_type!="new_admission" or d_fees_structure.student_type is null)';
			}
			else{
				$student_type = ' and (d_fees_structure.student_type!="old_admission" or d_fees_structure.student_type is null)';
			}

			$sql = 'SELECT d_fees_structure.sno as sno, d_fees_structure.class_id, d_fees_structure.head_id, d_fees_structure.recurring_duration, d_fees_structure.amount, d_fees_structure.status, d_class.class_desc, head_name, student_type FROM `d_fees_structure` left join d_section on d_section.sno = d_fees_structure.class_id left join d_class on d_class.sno = d_section.class_desc left join d_fees_head_master on d_fees_head_master.sno = head_id where class_id='.$_GET['vfs'].$student_type;

			//echo $sql;						  
			$result = execute_query($db, $sql);
			$print = array();
			$head = array();
		
			while($row = mysqli_fetch_assoc($result)){
				$class_name = $row['class_desc'];
				$class_id = $row['class_id'];
				if($row['student_type']==''){
					$row['student_type']=0;
				}
				$print[$row['head_id']][$row['student_type']][$row['recurring_duration']] = $row['amount'];
			}
		
			echo '<table class="table table-responsive table-stripped">
			<thead>
				<tr>
					<th>Month</th>';
			foreach($print as $k=>$v){
				$head[$k] = $v;
				foreach($v as $key => $val){
					if($key==='new_admission'){
						$student_type= ' <small>(New Admission)</small>';
					}
					elseif($key==='old_admission'){
						$student_type=' <small>(Old Admission)</small>';
					}
					else{
						$student_type = '';
					}
					echo '<th>'.get_head_name($k).' '.$student_type.'</th>';
				}
			}
			echo '<th>Payment</th></thead></tr>';
			/*$session_start_dummy = $session_start;
			while($session_end>$session_start_dummy){
				$session_start_dummy = date("Y-m-d", strtotime($session_start_dummy."+1 month"));
				
			}*/
			$recurring = 12;
			$tot = array();
			$tot_paid = 0;
			while($session_end>$session_start){
				$paid = 0;
				$paid_details = '';
				$month = date("m", strtotime($session_start));
				$month_words = strtolower(date("M", strtotime($session_start)));
				echo '<tr>
				<td class="text-center">'.date("Y-M", strtotime($session_start)).'</td>';
				foreach($head as $k=>$v){
					//print_r($v);
					foreach($v as $key=>$val){
						if($key==='new_admission'){
							$student_type= ' and (student_type="new_admission"  or student_type is null)';
							$k_tot = 'new';
						}
						elseif($key==='old_admission'){
							$student_type= ' and (student_type="old_admission"  or student_type is null)';
							$k_tot = 'old';
						}
						else{
							$student_type = '';
							$k_tot = '';
						}
						$discount_value = 0;
						if(!isset($tot[$k.$k_tot])){
							$tot[$k.$k_tot]=0;
							$tot[$k.$k_tot.'_discount']=0;
						}
						$sql = 'SELECT d_fees_structure.sno as sno, d_fees_structure.class_id, d_fees_structure.head_id, d_fees_structure.recurring_duration, d_fees_structure.amount, d_fees_structure.status, class_desc, head_name, student_type FROM `d_fees_structure` left join d_class on d_class.sno = class_id left join d_fees_head_master on d_fees_head_master.sno = head_id where class_id='.$_GET['vfs'].$student_type.' and head_id='.$k;
						//echo $sql.'<br>';
						$result_head_val = execute_query($db, $sql);
						if(mysqli_num_rows($result_head_val)!=0){
							$row_head_val = mysqli_fetch_assoc($result_head_val);
							$name = date("Ym_", strtotime($session_start)).$k;

							if(is_numeric($row_head_val['recurring_duration'])){
								if($recurring%$row_head_val['recurring_duration']==0){
									$sql = '(select discount_value, student_type from d_discount_structure where discount_type="class" and discount_id="'.$_GET['vfs'].'" and head_id='.$k.' and "'.date("Y-m-01", strtotime($session_start)).'" between date_from and date_to ) union all (select discount_value, student_type from d_discount_structure where discount_type="head" and discount_id='.$k.' and "'.date("Y-m-01", strtotime($session_start)).'" between date_from and date_to ) union all (select discount_value, student_type from d_discount_structure where discount_type="student" and discount_id='.$new_stud['sno'].' and head_id='.$k.' and "'.date("Y-m-01", strtotime($session_start)).'" between date_from and date_to )';
									$result_discount = execute_query($db, $sql);
									if(mysqli_num_rows($result_discount)!=0){
										while($row_discount = mysqli_fetch_assoc($result_discount)){
											$discount_value = 0;
											if($row_discount['student_type']!=''){
												//echo '<br>'.$row_discount['student_type'].'--'.$student['old_admission'].'<br>';
												if($row_discount['student_type']=='old_admission' && $new_stud['old_admission']==1){

												}
												elseif($row_discount['student_type']=='new_admission' && $new_stud['old_admission']==0){

												}
												else{
													$row_discount['discount_value']=0;		
												}
											}
											$discount_symbol = strpos($row_discount['discount_value'], "%");
											if($discount_symbol===false){
												$discount_value += $row_discount['discount_value'];	
											}
											else{
												$temp_disc_val = str_replace("%", "", $row_discount['discount_value']);
												$temp_amt = ($row_head_val['amount']*$temp_disc_val)/100;
												$discount_value += $temp_amt;	
											}
											//echo 'Head: '.$k.' >> '.$session_start.' >> '.$discount_value.'<br>';
											$tot[$k.$k_tot.'_discount'] += $discount_value;
										}
									}
									echo '<td>'.$row_head_val['amount'];
									if($discount_value!=0){
										echo ' <span class="text-danger small" id="disc_'.$name.'">Discount: '.$discount_value.'</span>';
									}
									$sql = 'select group_concat("<li><a href=\'d_nf_fee_receipt.php?id=", d_fees_invoice.sno, "\' target=\'_blank\'>Receipt No.", d_fees_invoice.invoice_no, "</a> | <a href=\'d_nf_pendingfees.php?id='.$_GET['id'].'&del=", d_fees_invoice.sno, "\' onClick=\'return confirm(\"Are you sure?\");\' style=\'color:#f00;\'>(Delete)</a> | ", d_fees_invoice.remarks, " </li>" SEPARATOR \' \') as sno, group_concat(d_fees_invoice.invoice_no) as invoice_no, sum(d_fees_invoice_trans.amount_payable) as amount_payable, sum(d_fees_invoice_trans.amount_paid) as amount_paid from d_fees_invoice_trans left join d_fees_invoice on d_fees_invoice.sno = d_fees_invoice_trans.invoice_no where d_fees_invoice.student_id="'.$new_stud['sno'].'" and month_year="'.date("Ym", strtotime($session_start)).'" and head_id='.$k;

									$result_paid = execute_query($db, $sql);
									$row_paid = mysqli_fetch_assoc($result_paid);
									$paid += $row_paid['amount_paid'];
									$paid_details .= $row_paid['sno'];

									if($row_paid['amount_paid']!='' && $row_paid['amount_payable']!='0'){
										if($row_paid['amount_paid'] < ($row_head_val['amount']-$discount_value)){
											$bal = ($row_head_val['amount']-$discount_value) - $row_paid['amount_paid'];
											echo ' Balance : '.$bal.' <input type="checkbox" name="col_'.$name.'" id="col_'.$name.'" value="'.$bal.'" onchange="amount_payable(this.id)"></td>';	
										}
										else{
											echo ' Full Paid ';	
										}									
									}
									else{
										if($row_paid['amount_payable']!='0'){
											echo ' <input type="checkbox" name="col_'.$name.'" id="col_'.$name.'" value="'.($row_head_val['amount']-$discount_value).'" onchange="amount_payable(this.id)"></td>';		
										}

									}
									$tot[$k.$k_tot] += $row_head_val['amount'];

								}
								else{
									echo '<td>&nbsp;</td>';
								}
							}
							else{
								$sql = 'SELECT d_fees_structure.sno as sno, d_fees_structure.class_id, d_fees_structure.head_id, d_fees_structure.recurring_duration, d_fees_structure.amount, d_fees_structure.status, class_desc, head_name FROM `d_fees_structure` left join d_class on d_class.sno = class_id left join d_fees_head_master on d_fees_head_master.sno = head_id where class_id='.$_GET['vfs'].' and head_id='.$k.' and recurring_duration="'.$month_words.'"';
								$result_month = execute_query($db, $sql);
								if(mysqli_num_rows($result_month)!=0){
									$sql = '(select discount_value from d_discount_structure where discount_type="class" and discount_id="'.$_GET['vfs'].'" and head_id='.$k.' and "'.date("Y-m-01", strtotime($session_start)).'" between date_from and date_to ) union all (select discount_value from d_discount_structure where discount_type="head" and discount_id='.$k.' and "'.date("Y-m-01", strtotime($session_start)).'" between date_from and date_to ) union all (select discount_value from d_discount_structure where discount_type="student" and discount_id='.$new_stud['sno'].' and head_id='.$k.' and "'.date("Y-m-01", strtotime($session_start)).'" between date_from and date_to )';
									$result_discount = execute_query($db, $sql);
									if(mysqli_num_rows($result_discount)!=0){
										while($row_discount = mysqli_fetch_assoc($result_discount)){
											$discount_symbol = strpos($row_discount['discount_value'], "%");
											if($discount_symbol===false){
												$discount_value += $row_discount['discount_value'];	
											}
											else{
												$temp_disc_val = str_replace("%", "", $row_discount['discount_value']);
												$temp_amt = ($row_head_val['amount']*$temp_disc_val)/100;
												$discount_value += $temp_amt;	
											}
											$tot[$k.$k_tot.'_discount'] += $discount_value;
										}
									}
									echo '<td>'.$row_head_val['amount'];
									if($discount_value!=0){
										echo ' <span class="text-danger small" id="disc_'.$name.'">Discount: '.$discount_value.'</span>';
									}
									$sql = 'select group_concat("<li><a href=\'d_nf_fee_receipt.php?id=", d_fees_invoice.sno, "\' target=\'_blank\'>Receipt No.", d_fees_invoice.invoice_no, "</a> | <a href=\'d_nf_pendingfees.php?id='.$_GET['id'].'&del=", d_fees_invoice.sno, "\' onClick=\'return confirm(\"Are you sure?\");\' style=\'color:#f00;\'>(Delete)</a></li>" SEPARATOR \' \') as sno, group_concat(d_fees_invoice.invoice_no) as invoice_no, sum(d_fees_invoice_trans.amount_payable) as amount_payable, sum(d_fees_invoice_trans.amount_paid) as amount_paid from d_fees_invoice_trans left join d_fees_invoice on d_fees_invoice.sno = d_fees_invoice_trans.invoice_no where d_fees_invoice.student_id="'.$new_stud['sno'].'" and month_year="'.date("Ym", strtotime($session_start)).'" and head_id='.$k;

									$result_paid = execute_query($db, $sql);
									$row_paid = mysqli_fetch_assoc($result_paid);
									if($row_paid['amount_paid']!='' && $row_paid['amount_payable']!='0'){
										$paid += $row_paid['amount_paid'];
										$paid_details .= $row_paid['sno'];
										if($row_paid['amount_paid'] < ($row_head_val['amount']-$discount_value)){
											$bal = ($row_head_val['amount']-$discount_value) - $row_paid['amount_paid'];
											echo ' Balance : '.$bal.' <input type="checkbox" name="col_'.$name.'" id="col_'.$name.'" value="'.$bal.'" onchange="amount_payable(this.id)"></td>';	
										}
										else{
											echo ' Full Paid ';	
										}									
									}
									else{
										echo ' <input type="checkbox" name="col_'.$name.'" id="col_'.$name.'" value="'.($row_head_val['amount']-$discount_value).'" onchange="amount_payable(this.id)"></td>';	

									}
									$tot[$k.$k_tot] += $row_head_val['amount'];
								}
								else{
									echo '<td>&nbsp;</td>';
								}
							}
						}
					}
				}
				$recurring--;
				$tot_paid += $paid;
				echo '<td>Rs.'.$paid.'<ul>'.$paid_details.'</ul></td></tr>';
				$session_start = date("Y-m-d", strtotime($session_start."+1 month"));
			}
			echo '<tr>
			<th class="text-center">Total</th>';
			foreach($head as $k=>$v){
				foreach($v as $key=>$val){
					if($key==='new_admission'){
						$k_tot = 'new';
					}
					elseif($key==='old_admission'){
						$k_tot = 'old';
					}
					else{
						$k_tot = '';
					}
					echo '<th>'.$tot[$k.$k_tot];
					if($tot[$k.$k_tot.'_discount']!=0){
						echo ' <span class="text-danger small">Discount: '.$tot[$k.$k_tot.'_discount'].'</span>';
					}
					echo '</th>';	
				}
			}
			echo '<th>'.$tot_paid.'</th></tr></table>';
						  
			?>
			</div>
			</div>
	<table>
		<tr>
			<td>Payment Date</td>
			<td>
				<?php 
					if ($_SESSION['type']!='sadmin') {
						?>
						<input type="date" name="submitdate" id="submitdate" value="<?php echo date("Y-m-d"); ?>" readonly>
						<?php
					}
					else{
				?>
				<script type="text/javascript" language="javascript">
	  				document.writeln(DateInput('submitdate', 'admission', true, 'YYYY-MM-DD', '<?php echo date("Y-m-d"); ?>', <?php echo $tab++; $tab=$tab+3; ?>));
      			</script>
      			<?php
      				} 
      			?>
      		</td>
			<td>Mode of Payment</td>
			<td>
				<select name="mod" id="mod" class="form-control" onChange="changeid(this.value)" >
                <option value="cash" >Cash</option>
                <option value="cheque" >Cheque</option>
                <option value="bank_transfer">Bank Transfer</option>
                </select>
			</td>
		</tr>
		<tr>
			<td>Fees Amount</td>
			<td><input type="text" name="fees_amount"  id="fees_amount" readonly  value="0" class="field text medium" onBlur="calc_total()" /></td>
			<td>Discount</td>
			<td><input type="text" name="total_discount"  id="total_discount" readonly  value="0" class="field text medium" onBlur="calc_total()" /></td>
			<td>Net Fees Amount</td>
			<td><input type="text" name="total_amount"  id="total_amount" readonly  value="0" class="field text medium" onBlur="calc_total()" /></td>
		</tr>
		<tr>	
			<td>Other Fees</td>
			<td><input type="text" name="other_fees"  id="other_fees" onBlur="calc_total()"  value="0" class="field text medium" /></td>
			<td>Late Fees</td>
			<td><input type="text" name="late" id="late"  value=""  onBlur="calc_total()" class="field text medium"  onKeyUp="" /></td>
			<td>Computer Fees/Registration Fees/Board Fees</td>
			<td><input type="text" name="comp_fees" id="comp_fees"  value=""  onBlur="calc_total()" class="field text medium"  onKeyUp="" /></td>
			<!-- <td>Discount</td>
			<td><input type="text" name="discount_value" id="discount_value" class="field text medium" onblur="calc_total();" placeholder="Fill The Discount"><input type="text" name="discount" id="discount" class="field text medium"  value="" onBlur="calc_total()"  onKeyUp="" readonly="" placeholder="Discount Value" /></td>
 -->			
		</tr>
		<tr>
			<td>Last Due Amount</td>
			<td><input type="text" name="last_due_amount" id="last_due_amount" class="field text medium" readonly value="<?php echo $last_due['due'];?>" /></td>
			<td>Total Amount</td>
			<td><input type="text" name="last_amount"  id="last_amount" readonly  value="0" class="field text medium" /></td>
			<td>Amount Paid</td>
			<td><input type="text" style="background-color:#06F; color:#FFF" name="cash_down" id="cash_down" class="field text medium" value="" /></td>
		</tr>
		<tr>
			
			<td>Cheque No.</td>
			<td><div id="chequeno" style="display: none;"><input type="text" name="c_no" id="c_no"  value="" class="field text medium" onBlur="" /></div></td>
			<td>Bank Name</td>
			<td><div id="bank" style="display: none;"><input type="text" name="bank" id="bank"  value="" class="field text medium" onBlur="" /></div></td>
			<td>Remark</td>
			<td><input type="text" name="remarks" id="remarks" class="field text medium" placeholder="Enter Some Remark"></td>
		</tr>
	</table>
     <input type="submit" class="form-control btn btn-primary" name="submit" value="Submit" onClick="return confirm('Are you sure?');"/>
     <input type="hidden" name="date_from" id="date_from">
     <input type="hidden" name="date_to" id="date_to">

</form>
<?php
   break;
	 }
 } 
?>
<?php page_footer_start();?>
