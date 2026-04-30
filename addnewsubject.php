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
if(isset($_POST['sub_id'])){
	$sql = 'update add_subject set subject="'.$_POST['subject'].'" where sno='.$_POST['sub_id'];
	execute_query(connect(), $sql);
	if(mysqli_error()){
		$msg .= '<li>Error # 1 : '.mysqli_error().' >> '.$sql.'</li>';
	}
	else{
		$msg .= '<li>Successful</li>';
	}
}
$msg='';
 if(isset($_POST['submit'])) {
	 if($_POST['sub_desc']!=='') {
		 $sql='insert into add_subject(subject) values("'.$_POST['sub_desc'].'")';
		 execute_query(connect(), $sql);
		 $msg .= '<li>New Subject Added</li>'; 
	 }
	 else{
		 $msg .= '<li>Please enter full information</li>';
	 }
  }
  page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
	<div id="wrapper">	
		<div id="content " class="card card-body">    
        	<div id="container" class="row d-flex my-auto">  	
				<form action="addnewsubject.php" class="wufoo leftLabel page1" name="addnewsubject" enctype="multipart/form-data" method="post" onSubmit="" >
					<?php
					switch($response){
						case 1:{
					?>
					<h2><img style="width:40px;" src="images/add.png" />Add New <span class="orange">Subject</span></h2>
					<?php echo $msg;?>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label  class="desc" for="sub_name">Enter Subject name <span class="sub_name">*</span></label>
								<input type="text" name="sub_desc" id="sub_desc"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							
						</div>
						<input type="submit" class="btn btn-primary submit" name="submit" value="Submit"/>
					</div>

					<?php
						$sql = "select * from add_subject";
						$result_sub = execute_query(connect(), $sql);
					?>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr class="bg-primary text-white ">
							<th>S.No</th>
							<th>Subject Name</th>
							<th>&nbsp;</th>
						</tr>
						<?php
						$i=1;
						while($row_sub = mysqli_fetch_array($result_sub)){
							if($i%2==0){
								$col = '#CCC';
							}
							else{
								$col = '#EEE';
							}
							echo '<tr style="background:'.$col.'">
							<td>'.$i++.'</td><td>'.$row_sub['subject'].'</td>
							<td><a href="addnewsubject.php?ed='.$row_sub['sno'].'">Edit</a></td></tr>';		
						}
						?>
					</table>
					<?php
							break;
						}
						case 2:{
							$sql = 'select * from add_subject where sno='.$_GET['ed'];
							$row = mysqli_fetch_array(execute_query(connect(), $sql));
					?>
					<h2><img style="width:40px;" src="images/add.png" />Edit Subject</h2>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label  class="desc" for="subject">Enter Subject<span class="orange">*</span></label>
								<input type="text" name="subject" id="subject"class="form-control" value="<?php echo $row['subject']; ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							
						</div>
						<input type="hidden" name="sub_id" id="sub_id" value="<?php echo $row['sno']; ?>"/>
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