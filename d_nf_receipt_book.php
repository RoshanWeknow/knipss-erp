<?php

include("scripts/settings.php");
$msg='';
$tab=1;
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);

$sql = 'select * from general_settings where `description`="school_name"';
$school_name = mysqli_fetch_array(execute_query($db ,$sql));
$school_name = $school_name['value'];

$sql = 'select * from general_settings where `description`="address"';
$address = mysqli_fetch_array(execute_query($db ,$sql));
$address = $address['value'];

$msg='';
if(!isset($_POST['date_from'])){
	$_POST['date_from'] = date("Y-m-01");
	$_POST['date_to'] = date("Y-m-d");
	
}
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

}
if(isset($_GET['del'])){
	$sql = "delete from d_fees_invoice where sno=".$_GET['del'];
	execute_query($db ,$sql);
	
	$sql = "delete from d_fees_invoice_trans where invoice_no=".$_GET['del'];
	execute_query($db ,$sql);
	
	$msg .= '<li class="alert-danger">Invoice deleted.</li>';	
}

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
			<div class="bg-primary text-white p-2"><h3>Receipt Book</h3></div>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="pendingfees" enctype="multipart/form-data" method="post" onSubmit="" >
		<span style="float:right;"><img src="images/print.png"  onclick="window.print();"></span>
		<?php echo '<ul><h3>'.$msg.'</h3></ul>'; ?>
		<table width="100%" class=" noprint table table-striped table-hover rounded">
			<tr>
				<td>Select Class</td>
				<td>
				<?php echo '
				<div><select class="form-control" name="classsection" id="classsection" >
				<option value="">All</option>';
				$sql = 'select * from d_section';
				$res = execute_query($db ,$sql);
				if($res){
				while($row = mysqli_fetch_array($res)) {
					$sql1 = 'select * from d_class where sno="'.$row['class_desc'].'"';
					$result = mysqli_fetch_array(execute_query($db ,$sql1));
					echo '<option value="'.$row['sno'].'" ';
					if (isset($_POST['classsection'])) {
						if ($_POST['classsection'] == $row['sno']) {
							echo 'selected';
						}
					}
					if(isset($result['class_desc'])){
					echo '>'.$result['class_desc'].' '.$row['section'].'</option>';
					}
				}}
				?>
				</td>
				<td>Student Name</td>
				<td><input id="supplier" name="supplier"class="form-control"   maxlength="255" tabindex="2" type="text" value="<?php if(isset($_POST['supplier'])){echo $_POST['supplier'];} ?>"></td>
				<td>Receipt No.</td>
				<td><input id="serial_number" name="serial_number"class="form-control"   maxlength="255" tabindex="5" type="text" value="<?php if(isset($_POST['serial_number'])){echo $_POST['serial_number'];} ?>"></td>
				
				
			</tr>
			<tr>
				<td>Mode of Payment</td>
				<td>
					<select name="mode_of_payment"class="form-control"  id="mode_of_payment" tabindex="<?php echo $tab++; ?>">
						<option value="" >All</option>
						<option value="cash" <?php if(isset($_POST['mode_of_payment'])){if($_POST['mode_of_payment']=='cash'){echo " selected='selected' ";}}?> >Cash</option>
						<option value="cheque" <?php if(isset($_POST['mode_of_payment'])){if($_POST['mode_of_payment']=='cheque'){echo " selected='selected' ";}}?>>Cheque</option>
						<option value="bank_transfer" <?php if(isset($_POST['mode_of_payment'])){if($_POST['mode_of_payment']=='bank_transfer'){echo " selected='selected' ";}}?>>Bank Transfer</option>
					</select>
				</td>
				<td>Date From</td>
				<td>
					<script type="text/javascript" language="javascript">
						document.writeln(DateInput('date_from', 'admission', true, 'YYYY-MM-DD', '<?php echo $_POST['date_from'];?>', <?php echo $tab++; $tab=$tab+3; ?>));
					</script>
				</td>
				<td>Date To</td>
				<td>
					<script type="text/javascript" language="javascript">
						document.writeln(DateInput('date_to', 'admission', true, 'YYYY-MM-DD', '<?php echo $_POST['date_to']; ?>', <?php echo $tab++; $tab=$tab+3; ?>));
					</script>
				</td>
			</tr>
		</table>
		<input type="submit" class="submit btn btn-primary" name="save" value="Search"/>
			<input id="supplier_sno" name="supplier_sno" type="hidden">	  
	</form>
</div>
</div>	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">
	<table class="table table-hover table-responsive table-bordered table-striped">
		
            <a href="receipt_book_export.php"><input type="button" style="margin-top:20px" class="btn btn-danger" name="student_ledger" class="form-control btn btn-danger"  style="float: left;" value="Download In Excel"></a></span>
           
		<tr class="bg-primary text-white">
			<th>S.No</th>
			<th>Date</th>
			<th class="noprint">SR.No</th>
			<th>Receipt Number</th>
			<th>Name</th>
			<th>Month</th>
			<th>Class</th>
			<th>Total Amount</th>
			<th>Discount</th>
			<th>Net Fees</th>
			<th>Other Fees</th>
			<th>Late Fees</th>
			<th>Paid Amount</th>
			<th>Paid Cash</th>
			<th>Paid Bank</th>
			<th>Pending Fees</th>
			<th>Remarks</th>
			
			<th class="noprint">&nbsp;</th>
		</tr>

		<?php
		$tot = 0;
		$tot_cash = 0;
		$tot_cheque = 0;
		$tot_bank_transfer = 0;
		$_POST['date_to'] = date("Y-m-d", strtotime($_POST['date_to']."+1 day"));
		if(isset($_POST['save'])){
			$_SESSION['sql_receipt_book'] = 'select d_fees_invoice.sno as sno, sr_no, entry_date, total_amount, total_discount, amount_payable, amount_paid, d_fees_invoice.invoice_no as invoice_no, d_fees_invoice.financial_year as financial_year, sname, fname, roll_no, d_class.class_desc, d_fees_invoice.remarks as remarks, d_section.section as section, student_id, mode_of_payment, (SELECT group_concat(month_year) FROM `d_fees_invoice_trans` where `d_fees_invoice_trans`.`invoice_no`=`d_fees_invoice`.`sno`) as month_year, (SELECT sum(amount_paid) as other_fees from d_fees_invoice_trans where `d_fees_invoice_trans`.`invoice_no`=`d_fees_invoice`.`sno` and head_id NOT REGEXP "^-?[0-9]+$" and head_id!="late") as other_fees, (SELECT sum(amount_paid) as late_fees from d_fees_invoice_trans where `d_fees_invoice_trans`.`invoice_no`=`d_fees_invoice`.`sno` and head_id="late") as late_fees from fees_invoice left join d_student_info on d_student_info.sno = student_id left join d_section on d_student_info.class = d_section.sno left join d_class on d_class.sno = d_section.class_desc where entry_date>="'.$_POST['date_from'].'" and entry_date<"'.$_POST['date_to'].'"';
			if($_POST['classsection']!=''){
				$_SESSION['sql_receipt_book'] .= ' and class = "'.$_POST['classsection'].'" ';
				//$_SESSION['sql_receipt_book'] = 'select * from student_info where sno = 424';
			}
			if($_POST['supplier']!=''){
				$_SESSION['sql_receipt_book'] .= ' and sname like "%'.$_POST['supplier'].'%" ';
				//$_SESSION['sql_receipt_book'] = 'select * from student_info where sno = 424';
			}
			if($_POST['serial_number']!=''){
				$_SESSION['sql_receipt_book'] .= ' and sr_no = "'.$_POST['serial_number'].'" ';
				//$_SESSION['sql_receipt_book'] = 'select * from student_info where sno = 424';
			}
			if($_POST['mode_of_payment']!=''){
				$_SESSION['sql_receipt_book'] .= ' and mode_of_payment = "'.$_POST['mode_of_payment'].'" ';
			}
			$_SESSION['sql_receipt_book'] .= ' order by abs(d_fees_invoice.invoice_no)';

		}
		elseif(!isset($_SESSION['sql_receipt_book'])){
			$_SESSION['sql_receipt_book'] = 'select d_fees_invoice.sno as sno, sr_no, entry_date, total_amount, total_discount, amount_payable, amount_paid, d_fees_invoice.invoice_no as invoice_no, d_fees_invoice.financial_year as financial_year, sname, fname, roll_no, d_class.class_desc, d_section.section as section, student_id, mode_of_payment, (SELECT group_concat(month_year) FROM `d_fees_invoice_trans` where `d_fees_invoice_trans`.`invoice_no`=`d_fees_invoice`.`sno`) as month_year, (SELECT sum(amount_paid) as other_fees from d_fees_invoice_trans where `d_fees_invoice_trans`.`invoice_no`=`d_fees_invoice`.`sno` and head_id NOT REGEXP "^-?[0-9]+$" and head_id!="late") as other_fees from d_fees_invoice left join d_student_info on d_student_info.sno = student_id left join d_section on d_student_info.class = d_section.sno left join d_class on d_class.sno = d_section.class_desc where entry_date>="'.$_POST['date_from'].'" and entry_date<"'.$_POST['date_to'].'"';
			$_SESSION['sql_receipt_book'] .= ' order by abs(d_fees_invoice.invoice_no)';
		}
		//echo $_SESSION['sql_receipt_book'];
		$_SESSION['sql5']= $_SESSION['sql_receipt_book'];
		$link = dbconnect();
		//echo $_SESSION['sql_receipt_book'];
		$result = execute_query($db ,$_SESSION['sql_receipt_book']);

		$sql = 'select * from general_settings where `description`="session_start_date"';
		$session = mysqli_fetch_array(execute_query($db ,$sql));
		$session = $session['value'];
		
		$sql = 'select * from general_settings where `description`="current_date"';
		$cur = mysqli_fetch_array(execute_query($db ,$sql));
		$cur_date = $cur['value'];
		$total_fees=0;
		$total_discount=0;
		$total_net_fees=0;
		$total_other_fees=0;
		$total_late_fees=0;
		$total_paid=0;
		$pending=0;
		$total_pending=0;
		$tot_last='';
		$tot_discount = 0;
		$tot_amount = 0;
		$inv_no_arr = array();

		$i=1;
		if($result){
		while($row = mysqli_fetch_array($result)){
			$month = array();
			foreach(explode(",", $row['month_year']) as $k=>$v){
				$v.='01';
				//echo $v.'<br>';
				
				$month[] = date("M", strtotime($v));
			}
			$pending = (($row['amount_payable']+$row['other_fees']+$row['late_fees'])-$row['amount_paid']);
			$tot_discount += $row['total_discount'];

			$tot_amount +=  $row['total_amount'];
			$tot_last =  $row['amount_paid'];	  
			$tot_last = $tot_last;
			$tot+= $tot_last;
			
			if ($row['mode_of_payment'] == 'cash') {
				$tot_cash +=  $tot_last;
			  }
			else if ($row['mode_of_payment'] == 'cheque') {
				$tot_cheque +=  $tot_last;
			  }
		    else if ($row['mode_of_payment'] == 'bank_transfer') {
				$tot_bank_transfer +=  $tot_last;
			  }
			if($row['other_fees']==''){$row['other_fees']='0';}
			if($row['late_fees']==''){$row['late_fees']='0';}
			echo '
			<tr><th>'.$i++.'</th>
			<td>'.$row['entry_date'].'</td>
			<td class="noprint">'.$row['sr_no'].'</td><td>'.$row['financial_year'].'/'.$row['invoice_no'].'</td>
			<td><a href="nf_pendingfees.php?id='.$row['student_id'].'" target="_blank">'.strtoupper($row['sname']).'</a></td>
			<td>'.implode(", ", $month).'</td>
			<td>'.$row['class_desc'].' '.$row['section'].'</td>
			<td>'.$row['total_amount'].'</td>
			<td>'.$row['total_discount'].'</td>
			<td>'.$row['amount_payable'].'</td>
			<td>'.$row['other_fees'].'</td>
			<td>'.$row['late_fees'].'</td>
			<td>'.$row['amount_paid'].'</td>';
			if($row['mode_of_payment']=='cash'){
			echo'
				<td>'.$tot_last.'</td>
				<td>0</td>';
			}
			if($row['mode_of_payment']=='bank_transfer'){
				echo'
				<td>0</td>
				<td>'.$tot_last.'</td>';
			}
			if($row['mode_of_payment'] == 'cheque') {
				echo'
				<td>0</td>
				<td>0</td>';
			  }
			
			echo '
			
			<td>'.$pending.'</td>
			<td>'.$row['remarks'].'</td>
			
			<td><a href="d_nf_fee_receipt.php?id='.$row['sno'].'" target="_blank">View</a></td></tr>';
			$total_fees+=$row['total_amount'];
			$total_discount+=$row['total_discount'];
			$total_net_fees+=$row['amount_payable'];
			$total_other_fees+=$row['other_fees'];
			$total_late_fees+=$row['late_fees'];
			$total_paid+=$row['amount_paid'];
			$total_pending += $pending;
		}}
		echo '<tr>
		<th class="noprint"></th>
		<th colspan="6" class="text-right">Total</th>
		<th>'.$total_fees.'</th>
		<th>'.$total_discount.'</th>
		<th>'.$total_net_fees.'</th>
		<th>'.$total_other_fees.'</th>
		<th>'.$total_late_fees.'</th>
		<th>'.$total_paid.'</th>
		<th>'.$tot_cash.'</th>
		<th>'.$tot_bank_transfer.'</th>
		<th>'.$total_pending.'</th>
		<th colspan="3"></th>
		</tr>';
	?>
	</table>
	<table class="table table-hover table-responsive table-bordered table-striped">
	<?php 
		 echo '<tr><th style="font-size:20px;">Mode Of Payment</th><th style="font-size:20px;">Total Amount: </th><td style="font-size:20px;">'.$tot.'</td><th style="font-size:20px;">Cash: </th><td style="font-size:20px;">'.$tot_cash.'</td><th style="font-size:20px;">Cheque: </th><td style="font-size:20px;">'.$tot_cheque.'</td><th style="font-size:20px;">Bank Transfer: </th><td style="font-size:20px;">'.$tot_bank_transfer.'</td></tr>';
	?>
</table>
</form>
</div>
</div>
</div>
<?php
break;
	 }
	 case $response==2 : {
?>

<?php
   break;
	 }
 } 
?>
<?php page_footer_start();?>
<?php page_footer_end();?>
