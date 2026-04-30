<?php 
//include("scripts/settings.php");
include("lib_setting.php");

$msg='';

// page_header_start();
// page_header_end();
// page_sidebar();
header_lib();
?>
<?php	
	if(isset($_POST['submit'])){
    if(isset($_POST['edit']) && $_POST['edit'] != ''){
        $sql = 'UPDATE lib_add_library set 
				library_name="'.$_POST['library_name'].'" , 
				edited_by="'.$_SESSION['username'].'",
				edition_time="'.date("d-m-y H:i:s").'"
				 where sno = '.$_POST['edit'];
			 //echo $sql;		 
				mysqli_query($db, $sql);
				if(mysqli_errno($db)){
					echo "Updation failed: ".mysqli_errno($db).mysqli_error($db);
				}
				else{
					echo "Successfully updated";
				}
			}
		else{
				$sql = 'INSERT INTO lib_add_library(library_name, created_by, creation_time) 
					values("'.$_POST['library_name'].'",
					"'.$_SESSION['username'].'",
					"'.date("d-m-y H:i:s").'")';
			//echo $sql;

				mysqli_query($db,$sql);
				if(mysqli_errno($db)){
					echo "Insertion failed: ".mysqli_errno($db).mysqli_error($db);
				}
				else{
					echo "Data inserted";
				}
			}
	}
	
	if(isset($_GET['del'])){
		$sql = 'delete from lib_add_library where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from lib_add_library where sno = '.$_GET['edit'];
	$qry = mysqli_query($db, $sql);
	$res = mysqli_fetch_assoc($qry);
}
?>
<div id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"  enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
					<table width="100%" class="table table-striped table-hover rounded">
						<tr>	
							<th width="15%">Library Name</th>	
							<th width="20%"><input type="text" name="library_name" id="library_name" value="<?php echo isset($_GET['edit'])? $res['library_name']: '' ?>" class="form-control" required="required">
							</th>
							<th width="65%"></th>
						</tr>
					</table>
					<button type="submit" class="btn btn-primary " name="submit" value="">Submit </button>
					<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
				</form>
			</div>
		</div>
	</div>
</div>
<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">  
			<div ><h3>Records</h3></div>
				<div class="col-md-12" >
					<table width="80%" class="table table-striped  table-hover rounded">
						<tr class="bg-primary text-white">
							<th>Sno</th>
							<th>Library Name</th>
							<th>Edit </th>
							<th>Delete</th>
						</tr>
							<?php
								$sql = 'select * from lib_add_library';
								$result = mysqli_query($db, $sql);
								$i=1;
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['library_name'].'</td>
									<td><a href="lib_add_library.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									<td><a href="lib_add_library.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
										</tr>'	;
								}
							?>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php
// page_footer_start();
// page_footer_end();
footer_lib()
?>