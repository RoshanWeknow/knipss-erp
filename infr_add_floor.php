<?php 
include("scripts/settings.php");

$msg='';

page_header_start();
page_header_end();
page_sidebar();
?>

<?php
	if(isset($_POST['campus_name'])){
		if(isset($_POST['edit']) && $_POST['edit'] != ''){
			$sql = 'update infr_add_floor set 
					campus_name="'.$_POST['campus_name'].'",
					faculty_type="'.$_POST['faculty_type'].'",
					floor_name="'.$_POST['floor_name'].'",
					discription="'.$_POST['discription'].'",
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
			$sql = 'insert into infr_add_floor (campus_name,faculty_type,floor_name, discription, created_by, creation_time) values("'.$_POST['campus_name'].'","'.$_POST['faculty_type'].'","'.$_POST['floor_name'].'","'.$_POST['discription'].'","'.$_SESSION['username'].'","'.date('Y-m-d H:m:s').'")';
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
		$sql = 'delete from infr_add_floor where sno="'.$_GET['del'].'"';
		execute_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from infr_add_floor where sno = '.$_GET['edit'];
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
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="user_form" name="user_form">
					<?php echo $msg; ?> 
                    <h3> Floor Information</h3>
                    <div class="col-md-12">
                        <!-- first row -->
                        <div class="row">
                            <div class=" col-md-3 ">
								<label>Campus Name</label>
								<select name="campus_name" id="campus_name" value="<?php echo isset($_GET['edit'])? $res['campus_name']: ''?>" class="form-control" required>
									<option disabled <?php echo isset($_GET['edit'])? "":' selected = "selected" '?>>---Select Your Campus name---</option>
									<?php 
										$sql  = 'select * from infr_add_campus';
										$dept_list = execute_query($db, $sql);
										if($dept_list){
											while($list = mysqli_fetch_assoc($dept_list)){
												echo '<option value = "'.$list['sno'].'" '.(isset($_GET['edit']) && $res['campus_name'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['campus_name'].'</option>';
											}
										}
									?>
								</select>
							</div>
							<div class=" col-md-3 ">
								<label>Faculty Type</label>
								<select name="faculty_type" id="faculty_type" value="<?php echo isset($_GET['edit'])? $res['faculty_type']: ''?>" class="form-control" >
									<option disabled <?php echo isset($_GET['edit'])? "":' selected = "selected" '?>>---Select Your Campus name---</option>
									 <?php 
										// $sql  = 'select * from infr_add_faculty_type';
										// $dept_list = execute_query($db, $sql);
										// if($dept_list){
											// while($list = mysqli_fetch_assoc($dept_list)){
												// echo '<option value = "'.$list['sno'].'" '.(isset($_GET['edit']) && $res['faculty_type'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['faculty_type'].'</option>';
											// }
										// }
									// ?>
								</select>
							</div>
                            <div class="  col-md-3 ">
                                <label>Floor Name</label><br>
                                
								<select name="floor_name" id="floor_name" class="form-control" value="<?php if(isset($_POST['floor_name'])){echo $_POST['floor_name'];}?>"tabindex="<?php echo $tab++; ?>">
										<option selected=""> ----Select-----</option>
										<option value="Ground floor" >Ground floor</option>
										<option value="First Floor" >First Floor</option>
										<option value="Second Floor" >Second Floor</option>
										<option value="Third Floor" >Third Floor</option>
										<option value="Fourth Floor" >Fourth Floor</option>
										<option value="Fifth Floor" >Fifth Floor</option>

									</select>
                            </div>
                            <div class="  col-md-3 ">
                                <label>Discription</label>
                                <textarea id="discription" name="discription" rows="4" cols="50" value="<?php echo isset($_GET['edit'])? $res['discription']: '' ?>" placeholder="Write Discription about the Floor" 
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
				
					<div class="col-md-12" >
						<table width="100%" class="table table-striped  table-hover rounded">
							<tr class="bg-primary text-white" align="center">
								<th>Sno</th>
								<th>campus_name</th>
								<th>Faculty Type</th>
								<th>Floor_Name</th>
								<th>Discription</th>
								<th>Edit </th>
								<th>Delete</th>
							</tr>
								<?php
									$sql = 'select * from infr_add_floor';
									$result = execute_query($db, $sql);
									$i=1;
									while($row = mysqli_fetch_assoc($result)){
										echo '<tr align="center">
										<td>'.$i++.'</td>
										<td>'.mysqli_fetch_assoc(execute_query($db, 'select * from infr_add_campus where sno = '.$row['campus_name']))['campus_name'].'</td>
										<td>'.mysqli_fetch_assoc(execute_query($db, 'select * from infr_add_faculty_type where sno = '.$row['faculty_type']))['faculty_type'].'</td>
										<td>'.$row['floor_name'].'</td>
										<td>'.$row['discription'].'</td>
										<td><a href="infr_add_floor.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
										<td><a href="infr_add_floor.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
											</tr>'	;
									}
								?>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		
		
<script>
$(document).ready(function(){
$("#campus_name").change(function(){
		let selected_value = $("#campus_name").val();
		console.log(selected_value);

		$.ajax({
			url: 'ajax_floor_name.php',
			method: 'GET',
			data : {selected_value: selected_value, id: <?php echo isset($_GET['edit'])? $_GET['edit']: '"test"' ?>},
			success: function(data){
				$("#faculty_type").html(data);
			}
		});
	 })
$("#faculty_type").change(function(){
		let selected_value = $("#faculty_type").val();
		console.log(selected_value);

		
	 })
})

</script>


<?php
page_footer_start();
page_footer_end();
?>