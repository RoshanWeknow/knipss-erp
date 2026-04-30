<?php
//set_time_limit(0);
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$response=1;
$msg='';
$i=0;

page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript">
function class_report() {
	window.open("fees_computer_second_print.php");
}
</script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
					<h2>Fees <span class="orange">Computer & Self & Breakage (Day Wise)(Second Installment)</span></h2>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-3">							
								<label>Enter Bank User Id<span class="name">*</span></label>
								<input type="text" name="user_id" class="form-control" id="user_id" >
							</div>
							<div class="col-md-3">							
								<label>Select Date<span class="name">*</span></label>
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('dfc_date', 'dfc_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['dfc_date'])){echo $_POST['dfc_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
								
							</div>
							<div class="col-md-3">							
								<label>Fees Type<span class="alert">*</span></label>
								<select class="form-control" name="type" id="type">
                    <option value="all"></option>
                    <option value="computer">Computer Fees</option>
                    <option value="self">Self Fees</option>
                    <option value="breakage">Breakage Fees</option>
              	 </select>
							</div>
							<div class="col-md-3">							
									<label>Type<span class="alert">*</span></label>
									<select class="form-control" name="class_type" id="class_type">
										<option value="all">ALL</option>
										<option value="self">SELF FINANCE</option>
										<option value="aided">AIDED</option>
									 </select>
								</div>
						</div>
						<div class="col-md-12">
							<div class="row">							
								
							</div>
						</div>
						
						
					</div> 
						<input type="submit" class="submit btn btn-primary" name="save" value="Submit" style="margin-top:0px; margin-left:0px;"/>
						<input type="button" name="student_ledger" class="btn btn-danger" onClick="return class_report()" style="float: right;" value="Print">					
				 </form>
			</div>
		</div> 

    
		<div class="card card-body">
			<table class="table table-bordered table-striped table-hover">
	<tr style="background:#CCC; color:#FFF; text-align:center; font-size:13px;">
    	<td>S.No.</td>
        <td>CLASS</td>
        <td>DATE</td>
        <td>STUDENT COUNT</td>
        <td>COMPUTER/SELF FEES/BREAKAGE</td>
    </tr>
<?php 
$tot_stu_count=0;
$grand_fees=0;
$i=1;
//$sql='select * from class_detail order by sort_no, class_description';
$sql = 'select count(*) c, sum(amount_paid) as amount_paid, class_id, class_detail.type as type from fee_invoice3 left join class_detail on fee_invoice3.class_id = class_detail.sno where 1=1';
if(isset($_POST['dfc_date'])){
	$sql .= " and fee_invoice3.approval_date='".$_POST['dfc_date']."'";
}
if($_POST['type']=='computer'){
	$sql .= ' and fee_invoice3.type="computer"';
}
if($_POST['type']=='self'){
	$sql.=' and fee_invoice3.type="self"';
}
if($_POST['class_type']=='self'){
		$sql .= ' and class_detail.type="SELF"';
}
if($_POST['type']=='breakage'){
		$sql .= ' and fee_invoice3.type="breakage"';
}
if($_POST['class_type']=='aided'){
		$sql.=' and class_detail.type!="SELF"';
}
$sql .= ' group by class_id';
//echo $sql;
if(isset($_POST['dfc_date'])){
	$res=mysqli_query($db, $sql);
	while($row=mysqli_fetch_array($res)){
		$sql = 'select * from class_detail where sno="'.$row['class_id'].'"';
		$class = mysqli_fetch_array(execute_query(connect(), $sql));
		if($class['sno']>=60 && $class['sno']<=75){
			//$class['sno']=$class['sno']+1;
		}
		//echo $sql1.'</br>';
		$_SESSION['class_type3']=$_POST['class_type'];
		$_SESSION['comp_date3']=$_POST['dfc_date'];
		$_SESSION['type3']=$_POST['type'];
		$result = execute_query(connect(), $sql);
		$count = $row['c'];
		$tot_stu_count += $count;

		if($count!=0){
			echo '<tr>
			<td>'.$i++.'</td>
			<td>'.get_class_detail($class['sno'])['class_description'].'</td>
			<td>'.date("d-m-Y", strtotime($_POST['dfc_date'])).'</td>
			<td>'.$count.'</td>';
			$grand_fees+=$row['amount_paid'];
			echo '<td>'.$row['amount_paid'].'</td></tr>';
		}
	}
	echo '<tr><td colspan="3">GRAND TOTAL</td><td>'.$tot_stu_count.'</td><td>'.$grand_fees.'</td></tr></table>';
}
?></div></div>
<?php 
page_footer_start(); 
page_footer_end(); 

?>
