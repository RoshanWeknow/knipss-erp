<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$response=1;

$msg='';

if(isset($_POST['submit'])) {
	if($_POST['fee_type']=='') {
		$msg .='<li>Please Enter Fee Type</li>';		
	}	
	else {
		if($_POST['fee_id']!=''){
			$sql = 'update head_type_misc set 
			fee_type="'.$_POST['fee_type'].'", 
			arrange_order="'.$_POST['arrange_order'].'", 
			amount="'.$_POST['amount'].'", 
			rec_duration="'.$_POST['r_duration'].'" 
			where sno='.$_POST['fee_id'];
		}
		else{
			$sql='insert into head_type_misc (fee_type, rec_duration, arrange_order, amount) values("'.$_POST['fee_type'].'","'.$_POST['r_duration'].'", "'.$_POST['arrange_order'].'", "'.$_POST['amount'].'")';	
		}
		//echo $sql;
		execute_query(connect(), $sql);
		$msg = '<li>New Fee Type Added</li>'; 
		$_POST['fee_type'] = '';
		$_POST['r_duration'] = '';
		$_POST['arrange_order'] = '';
		$_POST['amount'] = '';

	}
}
else{
	$_POST['fee_type'] = '';
	$_POST['r_duration'] = '';
	$_POST['arrange_order'] = '';
	$_POST['amount'] = '';
}
if(isset($_GET['ed'])){
	$sql = 'select * from head_type_misc where sno='.$_GET['ed'];
	$row = mysqli_fetch_array(execute_query(connect(), $sql));
	$_POST['fee_type'] = $row['fee_type'];
	$_POST['r_duration'] = $row['rec_duration'];
	$_POST['arrange_order'] = $row['arrange_order'];
	$_POST['amount'] = $row['amount'];
	$_POST['fee_id'] = $row['sno'];
}

if(isset($_GET['del'])){
	$sql = 'delete from head_type_misc where sno="'.$_GET['del'].'"';
	execute_query(connect(), $sql);
}
page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
	<div id="container">	
		<div id="content" class="card card-body">    
        	<div id="container" class="row d-flex my-auto">   	
				<form action="misc_fees_head.php" class="wufoo leftLabel page1" name="addnewsubject" enctype="multipart/form-data" method="post" onSubmit="" >
				<h2><img style="width:40px;" src="images/add.png" />Add Head<span class="orange"> Misc. (Fees)</span></h2>
				<?php echo $msg;?>
				<div class="col-md-12">
					<div class="row">							
						<div class="col-md-4">							
							<label>Enter Head Name:</label>
							<input type="text" name="fee_type" id="fee_type" class="form-control" value="<?php echo $_POST['fee_type']; ?>" />
						</div>
						<div class="col-md-4">							
							<label>Recurrint Duration:</label>
							<input type="text" name="r_duration" id="r_duration" class="form-control" value="<?php echo $_POST['r_duration']; ?>" />
						</div>
						<div class="col-md-4">							
							<label>Arrange Order:</label>
							<input type="text" name="arrange_order" id="arrange_order" class="form-control" value="<?php echo $_POST['arrange_order']; ?>" />
						</div>
					</div>
					<div class="row">							
						<div class="col-md-4">							
							<label>Amount:</label>
							<input type="text" name="amount" id="amount" class="form-control" value="<?php echo $_POST['amount']; ?>" />
						</div>						
					</div>
					<input type="submit" class="btn btn-primary submit" name="submit" value="Submit"/>
					<input type="hidden" name="fee_id" value="<?php echo $_POST['fee_id']; ?>"/>
				</div>
			</div>
		</div>
				
			
				<?php
					$sql = "select * from head_type_misc";
					$result_head = execute_query(connect(), $sql);
				?>
		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white ">
					<th>S.No</th>
					<th>HeadName</th>
					<th>Recurring Duration</th>
					<th>Arrange Order</th>
					<th>Amount</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
				</tr>
				<?php
				$i=1;
				while($row_head = mysqli_fetch_array($result_head)){
					if($i%2==0){
						$col = '#CCC';
					}
					else{
						$col = '#EEE';
					}
					echo '<tr style="background:'.$col.'">
					<td>'.$i++.'</td>
					<td>'.$row_head['fee_type'].'</td>
					<td>'.$row_head['rec_duration'].'</td>
					<td>'.$row_head['arrange_order'].'</td>
					<td>'.$row_head['amount'].'</td>
					<td><a href="misc_fees_head.php?ed='.$row_head['sno'].'">Edit</a></td>
					<td><a href="misc_fees_head.php?del='.$row_head['sno'].'" onclick="return confirm(\'Are you sure?\'); ">Delete</a></td>
					</tr>';		
				}
				?>
			</table>

			</form>
		</div>
	</div>

<?php
page_footer_start();
page_footer_end();
?>