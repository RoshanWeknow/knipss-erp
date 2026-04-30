<?php 
include("scripts/settings.php");
$msg = '';

page_header_start();
page_header_end();
page_sidebar();
?>

<?php
	if(isset($_POST['building_name'])){
		$target_dir = "room_photos/".date('Y')."/".date('m')."/";
		if(!is_dir($target_dir)){
			mkdir($target_dir);
		}
		if(isset($_POST['edit']) && $_POST['edit'] != ''){
			$sql = 'update add_rooms set 
					building_name="'.$_POST['building_name'].'",
					floor_name="'.$_POST['floor_name'].'", 
					room_type="'.$_POST['room_type'].'", 
					room_no="'.$_POST['room_no'].'" ,
					c_seating_capacity="'.$_POST['c_seating_capacity'].'",
					e_seating_capacity="'.$_POST['e_seating_capacity'].'",
					description="'.$_POST['discription'].'",
					
					edited_by="'.$_SESSION['username'].'",
					edition_time="'.date('Y-m-d H:m:s').'"
					where sno = '.$_POST['edit'];
			//echo $sql;
			execute_query($db, $sql);
			if(mysqli_errno($db)){
				$msg .= '<h3 style="color:red;">Updation failed'.mysqli_errno($db).mysqli_error($db).'</h3>';
			}
			else{
				$msg .= '<h3 style="color:green;">Data updated</h3>';;
			}
			if(isset($_POST['aminities'])){
				foreach($_POST['aminities'] as $key => $value){
					$sql = 'update add_aminities set
					aminities="'.$value.'",
					edited_by="'.$_SESSION['username'].'",
					edition_time="'.date('Y-m-d H:m:s').'"
					where add_rooms_sno = '.$_POST['edit'];
					execute_query($db,$sql);
				}
				if(mysqli_errno($db)){
					$msg .= '<h3 style="color:red;">Aminities updation failed'.mysqli_errno($db).mysqli_error($db).'</h3>';
				}
				else{
					$msg .= '<h3 style="color:green;">Aminities updated</h3>';;
				}
				
			}
			
		}
		else{
			//print_r($_POST);
			
			$sql = 'insert into add_rooms (building_name, floor_name, room_type, room_no, c_seating_capacity,e_seating_capacity, description,  created_by, creation_time ) 
					values("'.$_POST['building_name'].'","'.$_POST['floor_name'].'","'.$_POST['room_type'].'","'.$_POST['room_no'].'","'.$_POST['c_seating_capacity'].'","'.$_POST['e_seating_capacity'].'","'.$_POST['discription'].'","'.$_SESSION['username'].'","'.date('Y-m-d H:m:s').'")';
			//echo $sql;
			execute_query($db,$sql);
			if(mysqli_errno($db)){
				$msg .= '<h3 style="color:red;">Insertion failed'.mysqli_errno($db).mysqli_error($db).'</h3';
			}
			else{
				$msg .= '<h3 style="color:green;">Data Inserted</h3>';
			}
			$id = mysqli_insert_id($db);
			$file_details = upload_img($_FILES['file'],$target_dir,$id);
			$msg .= $file_details['msg'];
			$sql = 'update add_rooms set file="'. $target_dir.$file_details['file_name'].'" where sno = '.$id;
			if(execute_query($db, $sql)){
				echo "<li> image uploaded successfully</li>";
			}
			else{
				echo "<li> image upload failed</li>";
			}
			if(isset($_POST['aminities'])){
				foreach($_POST['aminities'] as $key => $value){
					$sql = 'insert into add_aminities(add_rooms_sno,aminities,created_by,creation_time) values("'.$id.'","'.$value.'","'.$_SESSION['username'].'","'.date('Y-m-d H:m:s').'")';
					execute_query($db,$sql);
				}
				if(mysqli_errno($db)){
					$msg .= '<h3 style="color:red;">Aminities addition failed'.mysqli_errno($db).mysqli_error($db).'</h3>';
				}
				else{
					$msg .= '<h3 style="color:green;">Aminities added</h3>';
				}
				
			}
		}
	}
	
		
	if(isset($_GET['del'])){
		$sql = 'delete from add_rooms where sno="'.$_GET['del'].'"';
		execute_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
		$sql = 'delete from add_aminities where add_rooms_sno="'.$_GET['del'].'"';
		execute_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting Aminities . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Aminities Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
		$sql = 'select * from add_rooms where sno = '.$_GET['edit'];
		$qry = execute_query($db, $sql);
		$res = mysqli_fetch_assoc($qry);
		$sql = 'select * from add_aminities where add_rooms_sno = '.$_GET['edit'];
		$qry = execute_query($db, $sql);
		$aminities = array();
		while($row = mysqli_fetch_assoc($qry)){
			array_push($aminities,$row['aminities']);
		}
		//echo $aminities;
		
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
					<?php echo $msg ?>
                    <h3> Room Information</h3>
                    <div class="col-md-12">
                        <!-- first row -->
                        <div class="row">
                            <div class=" col-md-3 ">
                                <label>Building Name</label>
                                <select name="building_name" id="building_name" value="<?php echo isset($_GET['edit'])? $res['building_name']: ''?>" class="form-control" required>
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
                                <label>Floor Name</label>
                                <select name="floor_name" id="floor_name" value="<?php echo isset($_GET['edit'])? $res['floor_name']: ''?>" class="form-control" required>
										
										
									</select>


                            </div>
							<div class="  col-md-3 ">
                                <label>Room's Type</label><br>
                                 <select name="room_type" id="room_type" value="<?php echo isset($_GET['edit'])? $res['room_type']: ''?>" class="form-control" required>
										<option disabled <?php echo isset($_GET['edit'])? "":' selected = "selected" '?>>---Select Your room_type---</option>
										<?php 
											$sql  = 'select * from add_room_type';
											$dept_list = execute_query($db, $sql);
											if($dept_list){
												while($list = mysqli_fetch_assoc($dept_list)){
													echo '<option value = "'.$list['sno'].'" '.(isset($_GET['edit']) && $res['room_type'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['name'].'</option>';
												}
											}
										?>
									</select>
                            </div>
                            <div class="  col-md-3 ">
                                <label>Room No.</label>
                                <input type="text" name="room_no" id="room_no" value="<?php echo isset($_GET['edit'])? $res['room_no']: '' ?>" class="form-control" required="required">
                            </div>
                            
                            
                        </div>
                        <!-- second row -->

                        <div class="row">
                            <div class="  col-md-3 ">
                                <label>Classroom Seating Capacity</label>
                                <input type="text" name="c_seating_capacity" id="c_seating_capacity" value="<?php echo isset($_GET['edit'])? $res['c_seating_capacity']: '' ?>" class="form-control" required="required">
                            </div>
							<div class="  col-md-3 ">
                                <label>Examination Seating Capacity</label>
                                <input type="text" name="e_seating_capacity" id="e_seating_capacity" value="<?php echo isset($_GET['edit'])? $res['e_seating_capacity']: '' ?>" class="form-control" required="required">
                            </div>
							<div class="  col-md-3 ">
                                <label>Discription</label>
                                <textarea id="discription" name="discription" rows="4" cols="50" placeholder="Write Discription about the Room" class="form-control"><?php echo isset($_GET['edit'])? $res['description']: '' ?></textarea>
                            </div>
                            <div class="col-md-3  ">
                                <label>Amanaties</label><br>
								
                                <select name="aminities[]" multiple id="aminities" class="form-control">
								<?php 
									$sql = execute_query($db,'select * from mst_aminities');
									 if($sql){
										 while($row = mysqli_fetch_assoc($sql)){
											 
											?>
										
									<option value="<?php echo $row['sno']?>" <?php echo (isset($_GET['edit'])&&( in_array($row['sno'],$aminities)))? 'selected="selected"': ''?>><?php echo $row['aminity_name']?></option>
									
									
								<?php
									
										 }
									 }
									
									
								?>
								</select>
																
                            </div>
                             
                        </div>
                         <!-- third row -->
						<div class="row">
							<div class="  col-md-3 ">
                                <label>Upload</label>
                                <input type="file" name="file" id="file" value="<?php echo isset($_GET['edit'])? $res['file']: '' ?>" class="form-control" required="required">
                            </div>
						</div>
                        
                        </br>
						<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
                        <button type="submit" class="btn btn-primary ms-4" name="save" value="">Submit </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<div class="card card-body">
			<div class="bg-primary text-white p-2 mb-2"><h3> Room Information</h3></div>
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="text-white bg-primary">
					<th>Sno.</th>
					<th>Building Name</th>
					<th>Floor Name</th>
					<th>Room Type</th>
					<th>Room No</th>
					<th>Classroom Seating Capacity</th>
					<th>Exam Seating Capacity</th>
					<th>Discription</th>
					<th>File</th>
					<th>Aminities</th>
					<!--<th>Edit</th>-->					
					<th>Delete</th>
				</tr>
				<?php
					$sql = 'select * from add_rooms';
					$result = execute_query($db, $sql);
					$i=1;
					while($row = mysqli_fetch_assoc($result)){
						echo '<tr style="text-align:center;">
						<td>'.$i++.'</td>
						<td>'.mysqli_fetch_assoc(execute_query($db, 'select * from add_building where sno = '.$row['building_name']))['building_name'].'</td>
						<td>'.mysqli_fetch_assoc(execute_query($db, 'select * from add_floor where sno = '.$row['floor_name']))['floor_name'].'</td>
						<td>'.mysqli_fetch_assoc(execute_query($db, 'select * from add_room_type where sno = '.$row['room_type']))['name'].'</td>
						<td>'.$row['room_no'].'</td>
						<td>'.$row['c_seating_capacity'].'</td>
						<td>'.$row['e_seating_capacity'].'</td>
						<td>'.$row['description'].'</td>
						<td><img src="'.$row['file'].'" width="100px" height="100px"></td>
						<td>';
						$id = $row['sno'];
						$sql = 'select * from add_aminities where add_rooms_sno = '.$id;
						$qry = execute_query($db, $sql);
						
						while($row = mysqli_fetch_assoc($qry)){
							echo mysqli_fetch_assoc(execute_query($db, 'select * from mst_aminities where sno = '.$row['aminities']))['aminity_name'].'<br>';
						}

						echo '</td>';
						// <td><a href="add_rooms.php?edit='.$id.'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
						echo '<td><a href="add_rooms.php?del='.$id.'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
							</tr>'	;
					}
								?>
			</table>
		</div>
    </div>

<script>
// $('select[multiple]').multiselect();
$('#aminities').multiselect({
    columns: 1,
    placeholder: 'Select aminities',
    selectAll: true
});




</script>
	
	
<script>
$(document).ready(function(){
$("#building_name").change(function(){
		let selected_value = $("#building_name").val();
		console.log(selected_value);

		$.ajax({
			url: 'ajax_floor_name.php',
			method: 'GET',
			data : {selected_value: selected_value, id: <?php echo isset($_GET['edit'])? $_GET['edit']: '"test"' ?>},
			success: function(data){
				$("#floor_name").html(data);
			}
		});
	 })
})

</script>	
	
	
<?php
page_footer_start();
echo '<!-- JS & CSS library of MultiSelect plugin -->';
echo '<script src="multiselect/jquery.multiselect.js"></script>
<link rel="stylesheet" href="multiselect/jquery.multiselect.css">';
page_footer_end();
?>