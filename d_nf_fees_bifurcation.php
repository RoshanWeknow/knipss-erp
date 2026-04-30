<?php

include("scripts/settings.php");
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
	execute_query($db, $sql);
	
	$sql = "delete from d_fees_invoice_trans where invoice_no=".$_GET['del'];
	execute_query($db, $sql);
	
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
			<div class="bg-primary text-white p-2"><h3>Fee Bifurcation</h3></div>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="pendingfees" enctype="multipart/form-data" method="post" onSubmit="" >
		<span style="float:right;"><img src="images/print.png"  onclick="window.print();"></span>
		<?php echo '<ul><h3>'.$msg.'</h3></ul>'; ?>
		<table width="100%" class="noprint table table-striped table-hover rounded">
			<tr>
				<td>Select Class</td>
				<td>
				<?php echo '
				<div><select class="form-control" name="classsection" id="classsection" >
				<option value=""></option>';
				$sql = 'select * from d_section';
				$res = execute_query($db, $sql);
				if($res){
				while($row = mysqli_fetch_array($res)) {
					$sql1 = execute_query($db,'select * from d_class where sno="'.$row['class_desc'].'"');
					if($sql1 && mysqli_num_rows($sql1)>0){
						$result = mysqli_fetch_array($sql1);
					
						echo '<option value="'.$row['sno'].'" ';
						if (isset($_POST['classsection'])) {
							if ($_POST['classsection'] == $row['sno']) {
								echo 'selected';
							}
						}
						echo '>'.$result['class_desc'].' '.$row['section'].'</option>';
					}
				}}
				?>
				</td>
				<td>Student Name</td>
				<td><input id="supplier" name="supplier" class="form-control"  maxlength="255" tabindex="2" type="text" value="<?php if(isset($_POST['supplier'])){echo $_POST['supplier'];} ?>"></td>
				<td>Receipt No.</td>
				<td><input id="serial_number" name="serial_number" class="form-control"  maxlength="255" tabindex="5" type="text" value="<?php if(isset($_POST['serial_number'])){echo $_POST['serial_number'];} ?>"></td>
			</tr>
			<tr>
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
	
            <a href="fees_bifurcation_export.php"><input type="button" class="btn btn-danger" style="margin-top:20px" name="student_ledger" class="form-control btn btn-danger"  style="float: left;" value="Download In Excel"></a></span>
           <tr class="bg-primary text-white">
			<th>S.No</th>
			<th>Date</th>
			<th>Receipt Number</th>
			<th>Roll.No</th>
			<th>Name</th>
			<th>Father Name</th>
			<th>Class</th>
			<?php
			$sql = 'select * from d_fees_head_master';
			$result_head = execute_query($db, $sql);
			$head = array();
			$tot_head = array();
			while($row_head = mysqli_fetch_assoc($result_head)){
				$head[$row_head['sno']] = $row_head['head_name'];
				$tot_head[$row_head['sno']]=0;
				echo '<th>'.$row_head['head_name'].'</th>';
			}
			?>
			<th>Total Paid Amount</th>
			<th class="noprint">&nbsp;</th>
		</tr>

		<?php
		$_POST['date_to'] = date("Y-m-d", strtotime($_POST['date_to']."+1 day"));
		if(isset($_POST['save'])){
			$_SESSION['sql_receipt_book'] = 'select d_fees_invoice.sno as sno, entry_date, total_amount, total_discount, amount_payable, amount_paid, d_fees_invoice.invoice_no as invoice_no, d_fees_invoice.financial_year as financial_year, sname, fname, roll_no, d_class.class_desc, d_section.section as section, student_id from d_fees_invoice left join d_student_info on d_student_info.sno = student_id left join d_section on d_student_info.class = d_section.sno left join d_class on d_class.sno = d_section.class_desc where entry_date>="'.$_POST['date_from'].'" and entry_date<"'.$_POST['date_to'].'"';
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
			$_SESSION['sql_receipt_book'] .= ' order by abs(d_fees_invoice.invoice_no)';

		}
		elseif(!isset($_SESSION['sql_receipt_book'])){
			$_SESSION['sql_receipt_book'] = 'select d_fees_invoice.sno as sno, entry_date, total_amount, total_discount, amount_payable, amount_paid, d_fees_invoice.invoice_no as invoice_no, d_fees_invoice.financial_year as financial_year, sname, fname, roll_no, d_class.class_desc, d_section.section as section, student_id from d_fees_invoice left join d_student_info on d_student_info.sno = student_id left join d_section on d_student_info.class = d_section.sno left join d_class on d_class.sno = d_section.class_desc where entry_date>="'.$_POST['date_from'].'" and entry_date<"'.$_POST['date_to'].'"';
			$_SESSION['sql_receipt_book'] .= ' order by abs(d_fees_invoice.invoice_no)';
		}
		
		$link = dbconnect();
		$_SESSION['sql5']= $_SESSION['sql_receipt_book'];
		//echo $_SESSION['sql_receipt_book'];
		$result = execute_query($db, $_SESSION['sql_receipt_book']);

		$sql = execute_query($db,'select * from general_settings where `description`="session_start_date"');
		if($sql && mysqli_num_rows($sql)>0){
			$session = mysqli_fetch_array($sql);
			$session = $session['value'];
		}
		$sql = execute_query($db,'select * from general_settings where `description`="current_date"');
		if($sql && mysqli_num_rows($sql)>0){
			$cur = mysqli_fetch_array( $sql);
			$cur_date = $cur['value'];
		}
		$total_fees=0;
		$total_discount=0;
		$total_net_fees=0;
		$total_paid=0;
		$total_pending=0;
		$inv_no_arr = array();

		$i=1;
		while($row = mysqli_fetch_array($result)){
			foreach($head as $k=>$v){
				$head[$k]=0;
			}
			
			$sql = 'select * from d_fees_invoice_trans where invoice_no='.$row['sno'];
			$result_trans = execute_query($db, $sql);
			while($row_trans = mysqli_fetch_assoc($result_trans)){
				$head[$row_trans['head_id']]+=$row_trans['amount_paid'];
				$tot_head[$row_trans['head_id']]+=$row_trans['amount_paid'];
			}
			
			echo '
			<tr><th>'.$i++.'</th>
			<td>'.$row['entry_date'].'</td>
			<td>'.$row['financial_year'].'/'.$row['invoice_no'].'</td>
			<td>'.$row['roll_no'].'</td>
			<td><a href="nf_pendingfees.php?id='.$row['student_id'].'" target="_blank">'.strtoupper($row['sname']).'</a></td>
			<td>'.strtoupper($row['fname']).'</td>
			<td>'.$row['class_desc'].' '.$row['section'].'</td>';
			foreach($head as $k=>$v){
				echo '<td>'.$v.'</td>';
			}
			echo '
			<td>'.$row['amount_paid'].'</td>
			<td><a href="d_nf_fee_receipt.php?id='.$row['sno'].'" target="_blank">View</a></td></tr>';
			$total_paid+=$row['amount_paid'];
		}
		echo '<tr>
		<th colspan="7" class="text-right">Total</th>';
		foreach($tot_head as $k=>$v){
			echo '<th>'.$v.'</th>';
		}
		echo '<th>'.$total_paid.'</th>
		<th></th>
		</tr>';
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
