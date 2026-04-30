<?php 
include("scripts/settings.php");

$msg='';

page_header_start();
page_header_end();
page_sidebar();
?>
<?php	
	if(isset($_POST['submit'])){
    if(isset($_POST['edit']) && $_POST['edit'] != ''){
        $sql = 'UPDATE lib_inventory_category set 
				inventory_type="'.$_POST['inventory_type'].'" , 
				inventory_catagory="'.$_POST['inventory_catagory'].'" , 
				inventory_code="'.$_POST['inventory_code'].'" , 
				edited_by="'.$_SESSION['username'].'",
				edited_date="'.date("d-m-y H:i:s").'"
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
				$sql = 'INSERT INTO lib_inventory_category(inventory_type, inventory_catagory, inventory_code, created_by, created_date) 
					values("'.$_POST['inventory_type'].'",
					"'.$_POST['inventory_catagory'].'",
					"'.$_POST['inventory_code'].'",
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
		$sql = 'delete from lib_inventory_category where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from lib_inventory_category where sno = '.$_GET['edit'];
	$qry = mysqli_query($db, $sql);
	$res = mysqli_fetch_assoc($qry);
}
?>
<div id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"  enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
				<div class="bg-primary text-white p-2"><h3>Inventory Catagory</h3></div>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr>
							<th>Inventory Type</th>	
							<th><select class="form-control" name="inventory_type" id="inventory_type" class="form-control">
									<option value="">----Select----</option>		
									<option value="1">1</option>		
									<option value="2">2</option>		
								</select></th>
							<th>Inventory Catagory</th>
							<th><input type="text" name="inventory_catagory" id="inventory_catagory" value="<?php echo isset($_GET['edit'])? $res['inventory_catagory']: '' ?>" class="form-control" required="required"></th>
							
							<th>Inventory Code</th>
							<th><input type="text" name="inventory_code" id="inventory_code" value="<?php echo isset($_GET['edit'])? $res['inventory_code']: '' ?>" class="form-control" required="required"></th>
						</tr>
					</table>
					<button type="submit" class="btn btn-primary " name="submit" value="">Submit </button>
					<button type="submit" class="btn btn-success " name="save" value="reset">Reset </button>
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
							<th>Inventory Type</th>
							<th>Inventory Catagory</th>
							<th>Inventory Code</th>
							<th>Edit </th>
							<th>Delete</th>
						</tr>
							<?php
								$sql = 'select * from lib_inventory_category';
								$result = mysqli_query($db, $sql);
								$i=1;
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['inventory_type'].'</td>
									<td>'.$row['inventory_catagory'].'</td>
									<td>'.$row['inventory_code'].'</td>
									<td><a href="lib_inventory_category.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									<td><a href="lib_inventory_category.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
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