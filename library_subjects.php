<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
$response=1;
page_header_start();
if(isset($_POST['add_subject'])){
	$sql = 'insert into library_subject (`subject_name`) values ("'.$_POST['add_subject'].'")';
	execute_query(connect(), $sql);
}
if(isset($_GET['del'])){
	$sql = 'delete from library_subject where sno='.$_GET['del'];
	execute_query(connect(), $sql);
	$sql = 'update library_book_info set category="'.$_GET['alt'].'" where category='.$_GET['del'];
	execute_query(connect(), $sql);
	$sql = 'update library_almirah set subject_code="'.$_GET['alt'].'" where subject_code='.$_GET['del'];
	execute_query(connect(), $sql);
	//echo $sql;
	//execute_query(connect(), $sql);
}
if(isset($_GET['sub'])){
	$response=3;
}
if(isset($_GET['alm'])){
	$response=4;
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
		//alert("library_subjects.php?del="+id+"&alt="+alternate);
		window.open("library_subjects.php?del="+id+"&alt="+alternate, '_self');
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
					<h2>Add/Edit <span class="orange">Subjects</span></h2>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Add New Subject</label>
								<input type="text" class="form-control" name="add_subject"  >
							</div>
							
						</div>
						<input class="btn btn-primary submit" value="Add Subject" name="submit"  type="submit">
					</div>
				</form>
			</div>
		</div>
		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white">
					<td>S.NO.</td>
                    <td>Subject Name</td>
                    <td>Subject Code</td>
                    <td>Book Count</td>
                    <td>Almirah Count</td>
                    <td>Edit</td>
                    <td>Delete</td>
                </tr>
                <?php
					$i=1;
					$sql = 'select * from library_subject';
					$res = execute_query(connect(), $sql);
					while($row = mysqli_fetch_array($res)){
						if($i%2==0){
							$col='#CCC';
						}
						else{
							$col='#EEE';
						}
						$sql = 'select count(*) c from library_book_info where category='.$row['sno'];
						$subject = mysqli_fetch_array(execute_query(connect(), $sql));
						$subject = $subject['c'];
						$sql = 'select count(*) c from library_almirah where subject_code='.$row['sno'];
						$almirah = mysqli_fetch_array(execute_query(connect(), $sql));
						$almirah = $almirah['c'];
						echo '<tr ><th>'.$i++.'</th>
						<td><a href="library_subjects.php?sub='.$row['sno'].'">'.$row['subject_name'].'</a></td>
						<td>'.$row['sno'].'</td>
						<td>'.$subject.'</td>
						<td>'.$almirah.'</td>
						<td><a href="library_subjects.php?id='.$row['sno'].'">Edit</th>
						<td><a href="#" onclick="return alternate_value('.$row['sno'].')">Delete</th>
						</tr>';
						
					}
				?>
			</table>
		</div>
			<input type="hidden" name="alternate" id="alternate">
			<?php
			  		break;
				}
				case $response==2:{
			?>
			<form name="validation" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="">
				<input type="text" name="type" value="<?php echo $_POST['typeid'] ?>">
				<div class="card card-body">
					<table width="100%" class="table table-striped table-hover rounded">
							<tr class="table-primary ">
								<td>S No.</td>
								<th style="font-size:16px;"><u>Description</u></th>
						   </tr>
						   
						<?php
						if(isset($_POST['submit'])){
						$sql='select * from nav';
						$result=execute_query(connect(), $sql);
							while($row=mysqli_fetch_array($result)){
							echo'
								<tr>
									<td><input type="checkbox" name="submit'.$row['sno'].'" value="'.$row['sno'].'"';
									$sql = 'select * from validation where `desc`="'.$_POST['typeid'].'" and file="'.$row['display'].'"';
									$check = execute_query(connect(), $sql);
									if(mysqli_num_rows($check)==1){
										echo 'checked="checked"';
									}
									
									echo '></td>
									<td>'.$row['display'].'</td>
								</tr>
							';	
							}
						}
						?>
							<tr>
								<td><input type="submit" class="btn btn-primary submit" name="submit1" value="submit"></td>
							</tr>
					</table>
				</div>
			</form>
			<?php
					break;
				}
				case $response==3:{
					$subject = mysqli_fetch_array(execute_query(connect(), "select * from library_subject where sno=".$_GET['sub']));
			?>
            
			<h1 align="center">Almirah under subject <span class="orange"><?php echo $subject['subject_name']; ?></span>
			</h1>
			<hr/>
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white text-center">
					<td>S.No.</td>
					<td>Almirah Name</td>
					<td>Almirah Code</td>
					<td>Book Count</td>
					<td>Tray Count</td>
				</tr>
			</table>
            <?php
					$sql = 'select * from library_almirah where subject_code='.$_GET['sub'];
					$result = execute_query(connect(), $sql);
					$i=1;
					while($row = mysqli_fetch_array($result)){
						if($i%2==0){
							$col='#CCC';
						}
						else{
							$col='#EEE';
						}
						$sql = 'select count(*) c from library_book_info where itemrack='.$row['sno'];
						$book = mysqli_fetch_array(execute_query(connect(), $sql));
						$book = $book['c'];
						$sql = 'select count(*) c from library_almirah_tray where almirah_code='.$row['sno'];
						$tray = mysqli_fetch_array(execute_query(connect(), $sql));
						$tray = $tray['c'];
						echo '<tr style="background:'.$col.'"><th>'.$i++.'</th>
						<td><a href="library_subjects.php?alm='.$row['sno'].'">'.$row['almirah_name'].'</a></td>
						<td>'.$row['sno'].'</td>
						<td>'.$book.'</td>
						<td>'.$tray.'</td>';

					}
					break;
				}
				case $response==4:{
					$almirah = mysqli_fetch_array(execute_query(connect(), "select * from library_almirah where sno=".$_GET['alm']));
			?>
		<div class="card card-body">
			<h2>Trays under Almirah <span class="orange"><?php echo $almirah['almirah_name']; ?></span></h2>
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="table-primary ">                	<td>S.No.</td>
                    <td>Tray Name</td>
                    <td>Tray Code</td>
                    <td>Book Count</td>
                </tr>
            
					<?php
							$sql = 'select * from library_almirah_tray where almirah_code='.$_GET['alm'];
							$result = execute_query(connect(), $sql);
							$i=1;
							while($row = mysqli_fetch_array($result)){
								$book=0;
								if($i%2==0){
									$col='#CCC';
								}
								else{
									$col='#EEE';
								}
								$sql = 'select count(*) c from library_book_info where itemrack='.$_GET['alm'].' and tray="'.$row['sno'].'"';
								$book = mysqli_fetch_array(execute_query(connect(), $sql));
								$book = $book['c'];
								echo '<tr ><th>'.$i++.'</th>
								<td><a href="library_subjects.php?alm='.$row['sno'].'">'.$row['tray_name'].'</a></td>
								<td>'.$row['sno'].'</td>
								<td>'.$book.'</td> </tr>';

							}
							break;
						}
					}
					?>
			</table>
		</div>
	</div>	
	<?php
	?>
	<?php
	page_footer_start();
	page_footer_end();
	?>
</body>