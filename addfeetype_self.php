<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$response=1;
if(isset($_GET['ed'])){
	$response=2;
}
$msg='';
if(isset($_POST['fee_id'])){
	$sql = 'update head_type_self set fee_type="'.$_POST['fee_type'].'", rec_duration="'.$_POST['r_duration'].'" where sno='.$_POST['fee_id'];
	execute_query(connect(), $sql);
	if(mysqli_error()){
		$msg .= '<li>Error # 1 : '.mysqli_error().' >> '.$sql.'</li>';
	}
	else{
		$msg .= '<li>Successful</li>';
	}
}
if(isset($_POST['submit'])) {
	 if($_POST['fee_type']=='') {
		$msg .='<li>Please Enter Fee Type</li>';		
	}	
	else {
	 $sql='insert into head_type_self(fee_type,rec_duration) values("'.$_POST['fee_type'].'","'.$_POST['r_duration'].'")';
	 execute_query(connect(), $sql);
		$msg = '<li>New Fee Type Added</li>'; 
 }
}

page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
<div id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form action="addfeetype_self.php" class="wufoo leftLabel page1" name="addnewsubject" enctype="multipart/form-data" method="post" onSubmit="" >
					<?php
						switch($response){
							case 1:{
						?>
					<h2><img style="width:40px;" src="images/add.png" />Add Head Self <span class="orange">(Fees)</span></h2>
					<?php echo $msg;?>	
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Enter Head <span class="orange">*</span></label>
								<input type="text" name="fee_type" id="fee_type"class="form-control" value=""  onkeyup="formvalidation(this.value,'varchar',100,'fee_type')"/>
							</div>
							<div class="col-md-4">							
								<label>Recurring Duration <span class="orange">*</span></label>
								<input type="text" name="r_duration" id="r_duration"class="form-control" value="" onKeyUp="formvalidation(this.value,'varchar',100,'r_duration')"/>
							</div>
							<div class="col-md-4">							
								<label></label>
								
							</div>
						</div>
						
						<input type="submit" class="btn btn-primary submit" name="submit" value="Submit"/>
						<?php
							$sql = "select * from head_type_self";
							$result_head = execute_query(connect(), $sql);
						?>

					</div>
				
			</div>
		</div>
	</div>
	<div class="card card-body">
		<table width="100%" class="table table-striped table-hover rounded">
			<tr class="bg-primary text-white ">
				<th>S.No</th>
				<th>HeadName</th>
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
				<td>'.$i++.'</td><td>'.$row_head['fee_type'].'</td>
				<td><a href="addfeetype_self.php?ed='.$row_head['sno'].'">Edit</a></td></tr>';		
			}
			?>
		</table>
		<?php
			break;
		}
		case 2:{
			$sql = 'select * from head_type_self where sno='.$_GET['ed'];
			$row = mysqli_fetch_array(execute_query(connect(), $sql));
		?>
	</div>
	<h2><img style="width:40px;" src="images/add.png" />Add Head Self <span class="orange">(Fees)</span></h2>
					<?php echo $msg;?>	
					<div class="col-md-12">
						<div class="row mb-3">							
							<div class="col-md-4">							
								<label>Enter Head <span class="orange">*</span></label>
								<input type="text" name="fee_type" id="fee_type"class="form-control" value="<?php echo $row['fee_type']; ?>"   onkeyup="formvalidation(this.value,'varchar',100,'fee_type')"/>
							</div>
							<div class="col-md-4">							
								<label>Recurring Duration <span class="orange">*</span></label>
								<input type="text" name="r_duration" id="r_duration"class="form-control" value="<?php echo $row['rec_duration']; ?>" onKeyUp="formvalidation(this.value,'varchar',100,'r_duration')"/>
							</div>
							
						
						
							
						</div>
						<input type="hidden" name="fee_id" id="fee_id" value="<?php echo $row['sno']; ?>"/>
							<input type="submit" class="btn btn-primary submit mb-3" name="submit_edit" value="Submit"/>
							<?php						
									break;	
								}
							}
							?>
					</div>
	</form>
</div>




<?php
page_footer_start();
page_footer_end();

?>