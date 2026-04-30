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
if(isset($_POST['submit1'])){
	$date=$_POST['dfcdate'];
	$sql = 'select * from fees_transfer where month="'.date("Y-m", strtotime($date)).'" and type="aided" and head_id not in ("transfer", "deduction", "maintenance")';
	$res = execute_query(connect(), $sql);
	if(mysqli_num_rows($res)==0){
		$sql = 'insert into fees_transfer (head_id, amount, timestamp, type, month) values ';
		$comma=0;
		foreach($_POST as $k => $v){
			if(strpos($k,'fees')!==false){
				if($comma==0){
					$sql .= '("'.$k.'", "'.$v.'", "'.time().'", "aided", "'.date("Y-m", strtotime($date)).'")';
					$comma=1;
				}
				else{
					$sql .= ', ("'.$k.'", "'.$v.'", "'.time().'", "aided", "'.date("Y-m", strtotime($date)).'")';
				}
			}
		}
		//echo $sql;
		execute_query(connect(), $sql);
	}
	else{
		$msg .= '<h2>Collection Already Generated.</h2>';
	}
	
}
page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript">
function report_print_second() {
	window.open("fees_class_consolidate_print.php");
}
</script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
					<h2>Fees <span class="orange">Consolidate (Class Wise)</span></h2>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Enter Bank User Id<span class="name">*</span></label>
								<input type="text" name="user_id" class="form-control" id="user_id" >
							</div>
							<div class="col-md-4">							
								<label>Select Date<span class="name">*</span></label>
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('dfc_date', 'dfc_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['dfc_date'])){echo $_POST['dfc_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
								
							</div>
							<div class="col-md-4">							
								<label>Type<span class="alert">*</span></label>
								<select class="form-control" name="type" id="type">
									<option value="all">ALL</option>
									<option value="self">SELF FINANCE</option>
									<option value="aided">AIDED</option>
									<option value="ballb">BA.LLB.</option>
								 </select>
							</div>
						</div>
						
						
					</div> 
						<input type="submit" class="submit btn btn-primary" name="save" value="Submit" style="margin-top:0px; margin-left:0px;"/>
						<input type="button" name="student_ledger1" class="btn btn-danger" onClick="return report_print_second()" style="float: right;" value="Print">					
				 </form>
			</div>
		</div> 

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
<?php
$sql= "select * from head_type";
$result_head = execute_query(connect(), $sql);
$count = mysqli_num_rows($result_head);
?>
		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="table-primary ">
				<td rowspan="3">S.No.</td>
				<td rowspan="3">CLASS</td>
				<td rowspan="3">STUDENT COUNT</td>
				<td colspan="<?php echo $count-2; ?>">FEES HEADS</td>
				<td colspan="4">&nbsp;</td>
				<td rowspan="3">TOTAL2</td>
				<td rowspan="3">TOTAL</td>
				<td rowspan="3">TOTAL DEPOSITED</td>
			</tr>
			<tr class="table-primary ">
				<td colspan="4">MAINTENANCE</td>
				<td colspan="16">&nbsp;</td>
				<td colspan="12">UNIVERSITY FEES ACCOUNT</td>
			 <!--   <td colspan="5"></td>
				<td colspan="12">PRACTICAL FEES ACCOUNT</td>-->
			</tr>
			<tr style="background:#CCC; color:#FFF; text-align:center; ">
		<?php
		while($row_head = mysqli_fetch_array($result_head)){
			if($row_head['sno']==4){
				echo '<td >Total1</td>';
			}
			if($row_head['sno']==23){
				echo '<td >Lab Fee Half Yearly</td>';
			}
			echo '<td>'.strtoupper($row_head['fee_type']).'</td>';
			$fees_division[$row_head['sno']]=0;
		}
		?>
		<!--	<td>TOTAL FEES</td>
			<td>ZOOLOGY PRACTICAL FEES</td>
			<td>BOTANY PRACTICAL FEES</td>
			<td>CHEMISTRY PRACTICAL FEES</td>
			<td>PHYSICS PRACTICAL FEES</td>
			<td>MILITARY SCIENCE PRACTICAL FEES</td>
			<td>GEOGRAPHY PRACTICAL FEES</td>
			<td>HOME SCIENCE PRACTICAL FEES</td>
			<td>PHYSICAL EDUCATION PRACTICAL FEES</td>
			<tr>TOTAL PRACTICAL FEES (36 to 50)</tr>-->
			</tr>
			 <?php
			 $grand_tot[]=0;
			for($td=1; $td<=36; $td++){
				$tot[]=0;
				$grand_tot[]=0;
				if($td==8){
					echo '<td>8<br>(5+6+7)</td>';
				}
				//elseif($td==17){
					//echo '<td>17<br>(15+16)</td>';
				//}
				//elseif($td==30) {
					//echo '<td>30<br>(26+27+28+29)</td>';
				//}
				else{
					echo '<td>'.$td.'</td>';
				}
			}
			$grand_tot[50]=0;
			$grand_tot[52]=0;
			?>
			</tr>
		<?php
		$tot_stu_count=0;
		if(isset($_POST['dfc_date'])){
			$start = strtotime($_POST['dfc_date']);
			$start = date("01-m-Y",$start);
			$start = strtotime($start);
			$end = strtotime(date("Y-m-d",$start) . " +1 month");
			//$start = strtotime("2013-07-16");
			//$end = strtotime("2013-07-17");
		}
		$_SESSION['start1']=$start;
		$_SESSION['end1']=$end;
		$_SESSION['fees_date1']=$_POST['dfc_date'];
		$i=1;

		$sql='select * from class_detail order by sort_no, class_description';
		$res=execute_query(connect(), $sql);
			while($class=mysqli_fetch_array($res)){
			unset($tot);
			$tot[0]=0;
			for($td=1; $td<=35; $td++){
				$tot[]=0;
			}
			$tot[50]=0;
			$tot[52]=0;
			$sql = "select *, student_info.sno as student_serial, student_info.category as category from fee_invoice join student_info on student_info.sno = student_id join class_detail on student_info.class = class_detail.sno where fee_invoice.amount_paid is not null and fee_invoice.type='fees' and class_detail.sno=".$class['sno'];
			$sql .= " and timestamp>=".$start." and timestamp<".$end;
			if(isset($_POST['type'])){
				if($_POST['type']=='self'){
					$sql .= ' and class_detail.type="SELF" and class_detail.sno not in(66,67,68,69,70,71,72,73,74,75)';
				}
				if($_POST['type']=='aided'){
					$sql.=' and class_detail.type!="SELF"';
				}
				if($_POST['type']=='ballb'){
					$sql.=' and class_detail.sno>=66 and class_detail.sno<=75';
				}
				$_SESSION['class_type']=$_POST['type'];
			}
			else{
				$_POST['type']='';
			}
			
			if(isset($_POST['user_id'])){
				$result = execute_query(connect(), $sql);
				$count = mysqli_num_rows($result);
				$tot_stu_count += $count;
				if($count!=0){
				echo '<tr>
				<td>'.$i++.'</td>
				<td>'.$class['class_description'].'</td>
				<td>'.$count.'</td>';
				while($row = mysqli_fetch_array($result)){
					$final_res = fees_bifucation($row);
					$tot[50] += $final_res[1][50];
					$tot[22] += $final_res[1][22];
					$tot[52] += $final_res[1][52];
					$tot[30] += $final_res[1][30];
					$tot[31] += $final_res[1][31];
					$sql = 'select * from head_type';
					$re = execute_query(connect(), $sql);
					while($a = mysqli_fetch_array($re)){
						$tot[$a['sno']] += $final_res[1][$a['sno']];
						$grand_tot[$a['sno']] += $final_res[1][$a['sno']];
					}
				}
			
			$grand_tot[50] += $tot[50];
			$grand_tot[22] += $tot[22];
			$grand_tot[52] += $tot[52];
			$grand_tot[30] += $tot[30];
			$grand_tot[31] += $tot[31];
			//echo '<tr><th colspan="2">GRAND TOTAL :</th>';
			$sql = 'select * from head_type';
			$re = execute_query(connect(), $sql);
			while($a = mysqli_fetch_array($re)){
				echo '<td>'.$tot[$a['sno']].'</td>';
				if($a['sno']==3){
					echo '<td>'.$tot[50].'</td>';
				}
				if($a['sno']==21){
					echo '<td>'.$tot[22].'</td>';
				}
			}
			echo '<td>'.$tot[52].'</td>';
			echo '<td>'.$tot[30].'</td>';
			echo '<td>'.$tot[31].'</td>';
			if($tot[30]!=$tot[31]){
				echo '<td>ERROR</td>';
			}
				}
		}
		}
		echo '<tr><td colspan="2">GRAND TOTAL :</td>
		<td>'.$tot_stu_count.'</td>';
			$sql = 'select * from head_type';
			$re = execute_query(connect(), $sql);
			while($a = mysqli_fetch_array($re)){
				echo '<td>'.$grand_tot[$a['sno']].'<input type="hidden" name="fees_total_'.$a['sno'].'" value="'.$grand_tot[$a['sno']].'"></td>';
				if($a['sno']==3){
					echo '<td>'.$grand_tot[50].'</td>';
				}
				if($a['sno']==21){
					echo '<td>'.$grand_tot[22].'<input type="hidden" name="fees_total_22" value="'.$grand_tot[22].'"></td>';
				}
			}
			echo '<td>'.$grand_tot[52].'</td>';
			echo '<td>'.$grand_tot[30].'</td>';
			echo '<td>'.$grand_tot[31].'</td>';
			echo '
			</table></div>
			<input type="hidden" name="dfcdate" value="'.$_POST['dfc_date'].'">
			<input type="hidden" name="type" value="'.$_POST['type'].'">';
			echo '<input type="Submit" class="btn btn-success" name="submit1" value="Generate Fees Collection" class="submit">
			</form>';
			
			
		?></div>
<?php 
page_footer_start(); 
page_footer_end(); 

?>