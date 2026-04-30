<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
$response=1;
page_header_start();
if(isset($_GET['id'])){
	$response=2;
}
if(isset($_POST['add_subject'])){
	$sql = 'insert into library_subject (`subject_name`) values ("'.$_POST['add_subject'].'")';
	execute_query(connect(), $sql);
}
if(isset($_GET['del'])){
	$sql = 'delete from library_almirah where sno='.$_GET['del'];
	execute_query(connect(), $sql);
	$sql = 'update library_book_info set itemrack="'.$_GET['alt'].'" where itemrack='.$_GET['del'];
	execute_query(connect(), $sql);
	//execute_query(connect(), $sql);
}
if(isset($_POST['almirah_id'])){
	$sql = 'update library_almirah set almirah_name ="'.$_POST['almirah_name_edit'].'", subject_code="'.$_POST['subject_code_edit'].'" where sno='.$_POST['almirah_id'];
	//echo $sql;
	execute_query(connect(), $sql);
}
page_footer_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript">
function alternate_value(id){
	var alternate = prompt("Please enter alternate subject code.","");
	if(!alternate){
		alert("Can not delete without alternate subject code.");
		return false;
	}
	else{
		//alert("library_almirah.php?del="+id+"&alt="+alternate);
		window.open("library_almirah.php?del="+id+"&alt="+alternate, '_self');
		return true;
	}
}
</script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto"> 
				<?php
				switch($response){
					case $response==1:{
				?>
				<form name="validation" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
					<h2 >Add/Edit <span class="orange">Almirah</span></h2>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Almirah Name</label>
								<input type="text" name="almirah_name" class="form-control" >
							</div>
							<div class="col-md-4">							
								<label>Subject</label>
								<select name="subject_code" class="form-control">
								<?php
								$sql = 'select * from library_subject';
								$r = execute_query(connect(), $sql);
								while($row = mysqli_fetch_array($r)){
									echo '<option value="'.$row['sno'].'">'.$row['subject_name'].'</td>';
								}
								?>
								</select>
							</div>
							
						</div>
						<input class="btn btn-primary submit" value="Add Almirah" name="submit"  type="submit">
					</div>
				</form>		
			</div>
		</div>
		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white">
					<td>S.No.</td>
					<td>Almirah Name</td>
					<td>Subject Name</td>
					<td></td>
					<td></td>
				</tr>
				<?php
					$i=1;
					$sql = 'select * from library_almirah';
					$res = execute_query(connect(), $sql);
					while($row = mysqli_fetch_array($res)){
						if($i%2){
							$col = '#EEE';
						}
						else{
							$col = '#CCC';
						}
						$sub = mysqli_fetch_array(execute_query(connect(), "select * from library_subject where sno='".$row['subject_code']."'"));
						echo '<tr ><th>'.$i++.'</th>
						<td>'.$row['almirah_name'].'</th>
						<td>'.$sub['subject_name'].'</th>
						<td><a href="library_almirah.php?id='.$row['sno'].'">Edit</th>
						<td><a href="#" onclick="return alternate_value('.$row['sno'].')">Delete</th>
						</tr>';
						
					}
				?>
			</table>
						  
			<input type="hidden" name="alternate" id="alternate">
			<?php
				break;
				}
				case $response==2:{
				$almirah = mysqli_fetch_array(execute_query(connect(), "select * from library_almirah where sno='".$_GET['id']."'"));
				$sub = mysqli_fetch_array(execute_query(connect(), "select * from library_subject where sno='".$almirah['subject_code']."'"));
			?>
		</div>
		<form name="validation" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="">
			<input type="hidden" name="almirah_id" value="<?php echo $_GET['id'] ?>">
			<h2>Edit <span class="orange">Almirah</span></h2>
			<div class="card card-body">
				<div class="col-md-12">
					<div class="row">							
						<div class="col-md-4">							
							<label>Almirah Name</label>
							<input type="text" name="almirah_name" class="form-control" value="<?php echo $almirah['almirah_name']; ?>" >
						</div>
						<div class="col-md-4">							
							<label>Subject</label>
							<select name="subject_code" class="form-control">
								<?php
									$sql = 'select * from library_subject';
									$r = execute_query(connect(), $sql);
									while($row = mysqli_fetch_array($r)){
										echo '<option value="'.$row['sno'].'" ';
										if($sub['sno']==$row['sno']){
											echo 'selected="selected"';
										}
										echo '>'.$row['subject_name'].'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<input class="btn btn-primary submit" value="Add Almirah" name="submit"  type="submit">
				</div>
			</div>
		</form>		
	</div>
	<?php
					}
				}
	   ?>
	<?php
	?>
	<?php
	page_footer_start();
	page_footer_end();
	?>
</body>