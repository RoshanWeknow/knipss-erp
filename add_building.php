<?php 
include("scripts/settings.php");


$msg='';
page_header_start();
page_header_end();
page_sidebar();
?>


<?php
	if(isset($_POST['building_type'])){
		if(isset($_POST['edit']) && $_POST['edit'] != ''){
			$sql = 'update add_building set 
					building_type="'.$_POST['building_type'].'",
					building_name="'.$_POST['building_name'].'", 
					building_condition="'.$_POST['building_condition'].'", 
					year_of_establishment="'.$_POST['year_of_establishment'].'" ,
					dimentions="'.$_POST['dimentions'].'",
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
			$sql = 'insert into add_building (building_type, building_name, building_condition, year_of_establishment, dimentions, discription, remark, created_by, creation_time ) 
					values("'.$_POST['building_type'].'","'.$_POST['building_name'].'","'.$_POST['building_condition'].'","'.$_POST['year_of_establishment'].'","'.$_POST['dimentions'].'","'.$_POST['discription'].'","'.$_POST['remark'].'","'.$_SESSION['username'].'","'.date('Y-m-d H:m:s').'")';
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
		$sql = 'delete from add_building where sno="'.$_GET['del'].'"';
		execute_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
		$sql = 'select * from add_building where sno = '.$_GET['edit'];
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
                <form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"
                    enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
                    <div class="bg-primary text-white p-2"><h3> Add Building</h3></div>
                    <div class="col-md-12">
                        <!-- first row -->
						<table width="100%" class="table table-striped table-hover rounded">
							<tr >
								<th>Faculty Type:</th>
								<th>
									<select name="building_type" id="building_type" value="<?php echo $res['building_type']?>" class="form-control" required>
										<option disabled <?php echo isset($_GET['edit'])? "":' selected = "selected" '?>>---Select Your building_type---</option>
										<?php 
											$sql  = 'select * from add_building_type';
											$dept_list = execute_query($db, $sql);
											if($dept_list){
												while($list = mysqli_fetch_assoc($dept_list)){
													echo '<option value = "'.$list['sno'].'" '.(isset($_GET['edit']) && $res['building_type'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['name'].'</option>';
												}
											}
										?>
									</select>
								</th>
								
								<th>Building Name</th>
								<th><input type="text" name="building_name" id="building_name" value="<?php echo isset($_GET['edit'])? $res['building_name']: '' ?>" class="form-control" required="required"></th>
								<th>Year of Establishment</th>
								<th><input type="text" name="year_of_establishment" id="year_of_establishment"  class="form-control" required="required" value="<?php echo isset($_GET['edit'])? $res['year_of_establishment']: '' ?>"></th>
								
							</tr>
							<tr>
								
								
								<th>Dimentions(Area in Sq.feet)</th>
								<th><input type="text" name="dimentions" id="dimentions" class="form-control" required="required" value="<?php echo isset($_GET['edit'])? $res['dimentions']: '' ?>"></th>
								
								<th>Discription</th>
								<th><textarea id="discription" name="discription" rows="4" cols="50" placeholder="Write Discription about the Building" class="form-control" value="<?php echo isset($_GET['edit'])? $res['discription']: '' ?>" ></textarea></th>
							</tr>
							<!--<tr>
								<th>Remark</th>
								<th><textarea id="remark" name="remark" rows="4" cols="50" placeholder="Write Remark about the Building"class="form-control" value="<?php echo isset($_GET['edit'])? $res['remark']: '' ?>"></textarea></th>
								<th>Building Condition:</th>
								<th>
								<select name="building_condition" id="building_condition" value="<?php echo $res['building_condition']?>" class="form-control" required>
										<option disabled <?php echo isset($_GET['edit'])? "":' selected = "selected" '?>>---Select Your building_condition---</option>
										<?php 
											$sql  = 'select * from add_building_condition';
											$dept_list = execute_query($db, $sql);
											if($dept_list){
												while($list = mysqli_fetch_assoc($dept_list)){
													echo '<option value = "'.$list['sno'].'" '.(isset($_GET['edit']) && $res['building_condition'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['name'].'</option>';
												}
											}
										?>
								</th>
							</tr>-->
						</table>
                       
                        <button type="submit" class="btn btn-primary " name="save" value="">Submit </button>
						<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
                    </div>
                </form>
            </div>
        </div>
		<div class="card card-body">
			<div class="bg-primary text-white p-2 mb-2"><h3> Infrastructure Report</h3></div>
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="text-white bg-primary">
					<th>Sno.</th>
					<th>Faculty Type</th>
					<th>Building Name</th>
					<th>Year of Establishment</th>
					<th>Dimentions</th>
					<th>Discription</th>
					<th>Edit</th>					
					<th>Delete</th>
				</tr>
				<?php
					$sql = 'select * from add_building';
					$result = execute_query($db, $sql);
					$i=1;
					while($row = mysqli_fetch_assoc($result)){
						echo '<tr>
						<td>'.$i++.'</td>
						<td>'.mysqli_fetch_assoc(execute_query($db,'select * from add_building_type where sno = '.$row['building_type']))['name'].'</td>
						<td>'.$row['building_name'].'</td>
						<td>'.$row['year_of_establishment'].'</td>
						<td>'.$row['dimentions'].'</td>
						<td>'.$row['discription'].'</td>
						<td><a href="add_building.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
						<td><a href="add_building.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
							</tr>'	;
					}
								?>
			</table>
		</div>
    </div>
<?php
page_footer_start();
page_footer_end();


?>	
	





























