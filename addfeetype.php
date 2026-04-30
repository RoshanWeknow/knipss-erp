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
	$sql = 'update head_type set fee_type="'.$_POST['fee_type'].'", rec_duration="'.$_POST['r_duration'].'" where sno='.$_POST['fee_id'];
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
	 $sql='insert into head_type(fee_type,rec_duration) values("'.$_POST['fee_type'].'","'.$_POST['r_duration'].'")';
	 execute_query(connect(), $sql);
		$msg = '<li>New Fee Type Added</li>'; 
 }
}
page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
	<div id="wrapper">	
		<div id="content" class="card card-body">    
        	<div id="container" class="row d-flex my-auto" >    	
				<form action="addfeetype.php" class="wufoo leftLabel page1" name="addnewsubject" enctype="multipart/form-data" method="post" onSubmit="" >
					<?php
					switch($response){
						case 1:{
					?>
					<h2><img style="width:40px;" src="images/add.png" />Add Head<span class="orange">(Fees)</span></h2>
					<?php echo $msg;?>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label  class="desc" for="fee_type">Enter Head <span class="orange">*</span></label>
								<input type="text" name="fee_type" id="fee_type"class="form-control" value=""  onkeyup="formvalidation(this.value,'varchar',100,'fee_type')"/>
							</div>
							<div class="col-md-4">							
								<label  class="desc" for="r_duration">Recurring Duration <span class="orange">*</span></label>
								<input type="text" name="r_duration" id="r_duration"class="form-control" value="" onKeyUp="formvalidation(this.value,'varchar',100,'r_duration')"/>
							</div>
							
						</div>
						<input type="submit" class="btn btn-primary submit" name="submit" value="Submit"/>
					</div>

					<?php
						$sql = "select * from head_type";
						$result_head = execute_query(connect(), $sql);
					?>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr class="bg-primary text-white">
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
							<td><a href="addfeetype.php?ed='.$row_head['sno'].'">Edit</a></td></tr>';		
						}
						?>
					</table>
					<?php
							break;
						}
						case 2:{
							$sql = 'select * from head_type where sno='.$_GET['ed'];
							$row = mysqli_fetch_array(execute_query(connect(), $sql));
					?>
					<h2><img style="width:40px;" src="images/add.png" />Edit Head<span class="orange">(Fees)</span></h2>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label  class="desc" for="fee_type">Enter Head <span class="orange">*</span></label>
								<input type="text" name="fee_type" id="fee_type"class="form-control notranslate" value="<?php echo $row['fee_type']; ?>"  onkeyup="formvalidation(this.value,'varchar',100,'fee_type')"/>
							</div>
							<div class="col-md-4">							
								<label  class="desc" for="r_duration">Recurring Duration <span class="orange">*</span></label>
								<input type="text" name="r_duration" id="r_duration"class="form-control notranslate" value="<?php echo $row['rec_duration']; ?>" onKeyUp="formvalidation(this.value,'varchar',100,'r_duration')"/>
							</div>
							
						</div>
						<input type="hidden" name="fee_id" id="fee_id" value="<?php echo $row['sno']; ?>"/>
						<input type="submit" class="btn btn-success submit" name="submit_edit" value="Submit"/>
					</div>
					

					<?php	
							break;	
						}
					}
					?>
				</form>
			</div>
		</div>
	</div>
	<?php
	page_footer_start();
	page_footer_end();
	?>
</body>