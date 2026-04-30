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
<?php
	if(isset($_POST['name'])){
		if(isset($_POST['edit']) && $_POST['edit'] != ''){
			$sql = 'update departmets set 
					title="'.$_POST['title'].'" ,
					name="'.$_POST['name'].'" ,
					description="'.$_POST['description'].'" , 
					remarks="'.$_POST['remarks'].'"
					 where sno = '.$_POST['edit'];
			//echo $sql;
			mysqli_query($db, $sql);
			if(mysqli_errno($db)){
				echo "Updation failed".mysqli_errno($db).mysqli_error($db);
			}
			else{
				echo "Successfully updated";
			}
		}
		else{
			$sql = 'insert into departmets (title, name, description, remarks, created_by, created_date, edited_by, edited_date) 
					values("'.$_POST['title'].'","'.$_POST['name'].'","'.$_POST['description'].'","'.$_POST['remarks'].'","'.$_POST['created_by'].'","'.$_POST['created_date'].'","'.$_POST['edited_by'].'","'.$_POST['edited_date'].'")';
			//echo $sql;
			mysqli_query($db,$sql);
			if(mysqli_errno($db)){
				echo "Insertion failed".mysqli_errno($db).mysqli_error($db);
			}
			else{
				echo "Data inserted";
			}
		}
	}
	
		
	if(isset($_GET['del'])){
		$sql = 'delete from departmets where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from departmets where sno = '.$_GET['edit'];
	$qry = mysqli_query($db, $sql);
	$res = mysqli_fetch_assoc($qry);
}
?>
<style>
form div.row:nth-child(odd) {
  background: #eeeeee;
  border-radius: 5px;
  margin-bottom:5px;
  margin-top:5px;
  padding:5px;
}
form div.row label{
	color:#000000;
}
</style>



<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">  
				<form action="" class="wufoo leftLabel page1" name="" enctype="multipart/form-data" method="POST" onSubmit="" >
					<div class="bg-primary text-white p-2"><h3>Add Department</h3></div>
						<div class="col-md-12" >
						
							<table width="100%" class="table table-striped  table-hover rounded">
								<tr >
									<th>Title</th>
									<th><input type="text" name="title" id="title" value="<?php echo isset($_GET['edit'])? $res['title']: '' ?>" class="form-control"></th>
									<th>Name</th>
									<th><input type="text" name="name" id="name" value="<?php echo isset($_GET['edit'])? $res['name']: '' ?>" class="form-control"></th>
									<th>Description</th>
									<th><textarea type="text" id="description" name="description" value="" class="form-control"><?php echo isset($_GET['edit'])? $res['description']: '' ?></textarea></th>
								</tr>
								<tr>
									<th>Remarks</th>
									<th><textarea type="text" id="remarks" name="remarks" value="" class="form-control"><?php echo isset($_GET['edit'])? $res['remarks']: '' ?> </textarea></th>
								</tr>
							</table>
							<button type="submit" class="btn btn-primary " name="save" value="">Submit </button>
							<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
						</div>
				</form>	
			</div>
		</div>
	</div>
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">  
			<div ><h3>Records</h3></div>
				<div class="col-md-12" >
					<table width="100%" class="table table-striped  table-hover rounded">
						<tr class="bg-primary text-white" >
							<th>Sno</th>
							<th>Title</th>
							<th>Name</th>
							<th>Description</th>
							<th>Remarks</th>
							<th>Edit </th>
							<th>Delete</th>
						</tr>
							<?php
								$sql = 'select * from departmets';
								$result = mysqli_query($db, $sql);
								$i=1;
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['title'].'</td>
									<td>'.$row['name'].'</td>
									<td>'.$row['description'].'</td>
									<td>'.$row['remarks'].'</td>
									<td><a href="departmets.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									<td><a href="departmets.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
										</tr>'	;
								}
							?>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php 
page_footer_start(); 
page_footer_end(); 
?>