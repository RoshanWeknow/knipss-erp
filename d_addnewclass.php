<?php 
include("scripts/settings.php");


if(isset($_POST['class_desc']) && $_POST['class_desc'] != ''){
	//print_r($_POST);
	if(isset($_POST['edit']) && $_POST['edit']!= ''){
		$sql = 'update d_class set 
			class_desc="' . $_POST['class_desc'] . '",
			edited_by="' . $_SESSION['username'] . '",
			edition_time="' . date("Y-m-d H:i:s") . '"
			where sno=' . $_POST['edit'];
		execute_query($db, $sql);
		if(mysqli_errno($db)){
			$msg .= '<li>Updation Failed</li>' ;
		}
		else{
			$msg .= '<li>Data Updated</li>' ;
		}
	}
	else{
		$sql = 'insert into d_class(class_desc,created_by,creation_time) values(
		"'.$_POST['class_desc'].'","'.
		$_SESSION['username'].'", "'.
		date('Y-m-d H:m:s').'")';
		
		execute_query($db, $sql);
		if(mysqli_errno($db)){
			$msg .= '<p class="text text-danger">Error # 1.6 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		else{
			$msg.= '<li class="text-success"> Data Inserted </li>';
		}
	}
}

if(isset($_GET['edit'])) {
	$sql = 'select * from d_class where sno=' . $_GET['edit'];
	$data = mysqli_fetch_assoc(execute_query($db,$sql));
}

if(isset($_GET['del']) and $_GET['del']!='') {
		$sql = 'delete from d_class where sno=' . $_GET['del'];
		$data = execute_query($db, $sql);
		if(mysqli_errno($db)){
			$msg .= '<h6 class="alert alert-danger">Deletion Failed.</h6>';
		}
		else{
			$msg .= '<h6 class="alert alert-danger">Data deleted.</h6>';			
		}
		$_GET['del'] = '';
}




page_header_start();
page_header_end();
page_sidebar();
?>


<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">  
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off" >
					<div class="bg-primary text-white p-2"><h3>Add Class</h3></div>
						<div class="col-md-12" >
							<!-- first row -->
							<div class="row">							
								<div class=" col-md-3 ">							
									<label>Class Description</label>
									<input type="text" name="class_desc" id="class_desc" value="<?php  echo isset($_GET['edit'])?  $data['class_desc']: ""?>" class="form-control" required="required">
								</div>
							<div>	
							</br>
							<button type="submit" class="btn btn-primary " name="save" value="">Submit </button>
							<input type = "hidden" name = "edit" value="<?php echo isset($_GET['edit'])? $_GET['edit']: ""?>">	
						</div>
				</form>	
			</div>
		</div>
	</div>
		<div class="card card-body">
			<table  class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white">
					<td>S.No.</td>
					<td>Class Description</td>
					<td></td>
					<td></td>
					
				</tr>
				<?php
					$serial_no = 1;
					//echo $_SESSION['usersno'];
					$sql = 'select * from d_class';
					
					$res = execute_query($db, $sql);
					if($res){
						while($row = mysqli_fetch_assoc($res)){

				?>
				<tr>
					<td><?php echo $serial_no++ ?></td>
					<td><?php echo $row['class_desc'] ?></td>
					<td class="text-center ">
						<a href="<?php echo $_SERVER['PHP_SELF'] . '?edit=' . $row['sno']; ?>" alt="Edit" data-toggle="tooltip" title="Edit"><span class="far fa-edit" aria-hidden="true"></span></a></td>
						<td><a href="<?php echo $_SERVER['PHP_SELF'] . '?del=' . $row['sno']; ?>" onclick="return confirm('Are you sure?');" style="color:#f00" alt="Delete"><span class="far fa-trash-alt" aria-hidden="true" data-toggle="tooltip" title="Delete"></span></a>
					</td>

				</tr>
				
				<?php 
					}
						
				}
				
				?>
			</table>	
		</div>

<?php
page_footer_start();
?>


<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>

<?php
page_footer_end();
?>