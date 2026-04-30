<?php 
include("scripts/settings.php");

$msg='';

page_header_start();
page_header_end();
page_sidebar();
?>

<?php
	if(isset($_POST['building_name'])){
		if(isset($_POST['edit']) && $_POST['edit'] != ''){
			$sql = 'update add_floor set 
					building_name="'.$_POST['building_name'].'",
					floor_name="'.$_POST['floor_name'].'",
					discription="'.$_POST['discription'].'",
					remark="'.$_POST['remark'].'",
					edited_by="'.$_SESSION['username'].'",
					edition_time="'.date('Y-m-d H:m:s').'"
					where sno = '.$_POST['edit'];
			//echo $sql;
			execute_query($db, $sql);
			if(mysqli_errno($db)){
				echo "Updation failed".mysqli_errno($db).mysqli_error($db);
			}
			else{
				echo "Successfully updated";
			}
		}
		else{
			$sql = 'insert into add_floor (building_name, floor_name, discription, remark, created_by, creation_time) 
					values("'.$_POST['building_name'].'","'.$_POST['floor_name'].'","'.$_POST['discription'].'","'.$_POST['remark'].'","'.$_SESSION['username'].'","'.date('Y-m-d H:m:s').'")';
			//echo $sql;
			execute_query($db,$sql);
			if(mysqli_errno($db)){
				echo "Insertion failed".mysqli_errno($db).mysqli_error($db);
			}
			else{
				echo "Data inserted";
			}
		}
	}
	
		
	if(isset($_GET['del'])){
		$sql = 'delete from add_floor where sno="'.$_GET['del'].'"';
		execute_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from add_floor where sno = '.$_GET['edit'];
	$qry = execute_query($db, $sql);
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
                <form action="add_floor.php" class="wufoo leftLabel page1" name="feesdeposit"
                    enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
                    <h3> Floor Information</h3>
                    <div class="col-md-12">
                        <!-- first row -->
                        <div class="row">
                            <div class=" col-md-3 ">
                                <label>Building Name</label>
                                <select name="building_name" id="building_name" value="<?php echo $res['building_name']?>" class="form-control" required>
										<option disabled <?php echo isset($_GET['edit'])? "":' selected = "selected" '?>>---Select Your building_name---</option>
										<?php 
											$sql  = 'select * from add_building';
											$dept_list = execute_query($db, $sql);
											if($dept_list){
												while($list = mysqli_fetch_assoc($dept_list)){
													echo '<option value = "'.$list['sno'].'" '.(isset($_GET['edit']) && $res['building_name'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['building_name'].'</option>';
												}
											}
										?>
									</select>

                            </div>
                            <div class="  col-md-3 ">
                                <label>Floor Name</label><br>
                                <input type="text" name="floor_name" id="floor_name" value="<?php echo isset($_GET['edit'])? $res['floor_name']: '' ?>"
                                    class="form-control" required="required">
                            </div>
                            <div class="  col-md-3 ">
                                <label>Discription</label>
                                <textarea id="discription" name="discription" rows="4" cols="50" value="<?php echo isset($_GET['edit'])? $res['discription']: '' ?>" placeholder="Write Discription about the Floor" 
                                    class="form-control"></textarea>
                            </div>
							<div class="  col-md-3 ">
                                <label>Remark</label>
                                <textarea id="remark" name="remark" rows="4" cols="50" value="<?php echo isset($_GET['edit'])? $res['remark']: '' ?>" placeholder="Write Remark about the Floor"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                       
                        </br>
                        <button type="submit" class="btn btn-primary ms-4" name="save" value="">Submit </button>
						<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
	<div id="container">	
			<div class="card card-body">    
				<div class="row d-flex my-auto">  
				<div class="bg-primary text-white" align="center"><h3>Records</h3></div>
					<div class="col-md-12" >
						<table width="100%" class="table table-striped  table-hover rounded">
							<tr >
								<th>Sno</th>
								<th>Building_Name</th>
								<th>Floor_Name</th>
								<th>Discription</th>
								<th>Remark</th>
								<th>Edit </th>
								<th>Delete</th>
							</tr>
								<?php
									$sql = 'select * from add_floor';
									$result = execute_query($db, $sql);
									$i=1;
									while($row = mysqli_fetch_assoc($result)){
										echo '<tr>
										<td>'.$i++.'</td>
										<td>'.mysqli_fetch_assoc(execute_query($db,'select * from add_building where sno = '.$row['building_name']))['building_name'].'</td>
										<td>'.$row['floor_name'].'</td>
										<td>'.$row['discription'].'</td>
										<td>'.$row['remark'].'</td>
										<td><a href="add_floor.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
										<td><a href="add_floor.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
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