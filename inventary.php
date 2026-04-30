<?php 
include("scripts/settings.php");





page_header_start();
page_header_end();
page_sidebar();
?>
<?php
	if(isset($_POST['submit'])){
		if(isset($_POST['edit']) && $_POST['edit'] != ''){
			$sql = 'update inventory set 
					item="'.$_POST['item'].'",
					in_stock="'.$_POST['in_stock'].'",
					in_used="'.$_POST['in_used'].'" 
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
			$sql = 'insert into inventory (item, in_stock, in_used) 
					values
				   ("'.$_POST['item'].'",
					"'.$_POST['in_stock'].'",
					"'.$_POST['in_used'].'")';
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
		$sql = 'delete from inventory where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from inventory where sno = '.$_GET['edit'];
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
                <form action="inventary.php" class="wufoo leftLabel page1" name=""
                    enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
                    <h3 >Inventory</h3>
                    <div class="col-md-12">
                        <!-- first row -->
                        <div class="row">
                            <div class=" col-md-3 ms-4">
                                <label>Inventory Items</label>
								<select id="item" name="item" value="<?php echo isset($_GET['edit'])? $res['item']: '' ?>" required="required" class="form-control">
									<?php
										$sql = "select * from inventory_item"; 
										$result = mysqli_query($db,$sql); 
										while ($row = mysqli_fetch_assoc($result)) { 
										?>
										<option value="<?php echo $row["item_name"]; ?>"> 
										<?php echo $row["item_name"]; ?>
										</option>
										<?php } ?>
								</select>
                            </div>
                            <div class="  col-md-2 ms-4">
                                <label>IN Stock</label>
                                <input type="text" name="in_stock" id="in_stock" value="<?php echo isset($_GET['edit'])? $res['in_stock']: '' ?>" class="form-control" required="">
                            </div>
                            <div class="  col-md-2 ms-4">
                                <label>IN Used</label>
                                <input type="text" name="in_used" id="in_used" value="<?php echo isset($_GET['edit'])? $res['in_used']: '' ?>" class="form-control" required="">
                            </div>
                            <div class="  col-md-2 ms-4">
                            </div>
                        </div>
                        <!-- second row -->

                        </br><button type="submit" class="btn btn-primary ms-3" name="submit" value="">Submit </button>
						<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">  
			<div  ><h3>Records</h3></div>
				<div class="col-md-12" >
					<table width="100%" class="table table-striped  table-hover rounded">
						<tr class="bg-primary text-white">
							<th>Sno</th>
							<th>Item</th>
							<th>IN Stock</th>
							<th>IN Used</th>
							<th>Edit </th>
							<th>Delete</th>
						</tr>
							<?php
								$sql = 'select * from inventory';
								$result = mysqli_query($db, $sql);
								$i=1;
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['item'].'</td>
									
									<td>'.$row['in_stock'].'</td>
									<td>'.$row['in_used'].'</td>
									<td><a href="inventary.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									<td><a href="inventary.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
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
