<?php 
include("scripts/settings.php");
$msg = '';

page_header_start();
page_header_end();
page_sidebar();
?>

<?php
	if(isset($_POST['campus_name'])){
		//echo "hello";
		$target_dir = "room_photos/";
		if(!is_dir($target_dir)){
			mkdir($target_dir);
		}
		if(isset($_POST['edit']) && $_POST['edit'] != ''){
			$sql = 'update infr_add_rooms set 
					campus_name="'.$_POST['campus_name'].'",
					faculty_type="'.$_POST['faculty_type'].'",
					department_name="'.$_POST['department_name'].'",
					floor_name="'.$_POST['floor_name'].'", 
					room_type="'.$_POST['room_type'].'", 
					room_no="'.$_POST['room_no'].'" ,
					room_name="'.$_POST['room_name'].'" ,
					class_seating="'.$_POST['class_seating'].'",
					exam_seating="'.$_POST['exam_seating'].'",
					room_dimension="'.$_POST['room_dimension'].'",
					description="'.$_POST['description'].'",
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
					$sql = 'update infr_add_aminities set
					aminities="'.$value.'",
					edited_by="'.$_SESSION['username'].'",
					edition_time="'.date('Y-m-d H:m:s').'"
					where infr_add_rooms_sno = '.$_POST['edit'];
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
			
			$sql = 'insert into infr_add_rooms (campus_name,faculty_type,department_name, floor_name, room_type, room_no,room_name,class_seating,exam_seating,room_dimension, description,  created_by, creation_time )values("'.$_POST['campus_name'].'","'.$_POST['faculty_type'].'","'.$_POST['department_name'].'","'.$_POST['floor_name'].'","'.$_POST['room_type'].'","'.$_POST['room_no'].'","'.$_POST['room_name'].'","'.$_POST['class_seating'].'","'.$_POST['exam_seating'].'","'.$_POST['room_dimension'].'","'.$_POST['description'].'","'.$_SESSION['username'].'","'.date('Y-m-d H:m:s').'")';
			//echo $sql;
			execute_query($db,$sql);
			if(mysqli_errno($db)){
				$msg .= '<h3 style="color:red;">Insertion failed'.mysqli_errno($db).mysqli_error($db).'</h3';
			}
			else{
				$msg .= '<h3 style="color:green;">Data Inserted</h3>';
			}
			$id = mysqli_insert_id($db);
			if(isset($_POST['aminities_name_0'])){
				$sql = 'insert into infr_add_aminities(infr_add_rooms_sno,aminities_name,quantity,created_by,creation_time) values("'.$id.'","'.$_POST['aminities_name_0'].'","'.$_POST['quantity_0'].'","'.$_SESSION['username'].'","'.date('Y-m-d H:m:s').'")';
					execute_query($db,$sql);
			}
			if(isset($_POST['add_rows_id_exp']) && $_POST['add_rows_id_exp']!= '' ){
				for($i=1; $i<=$_POST['add_rows_id_exp']; $i++){
					$sql = 'insert into infr_add_aminities(infr_add_rooms_sno,aminities_name,quantity,created_by,creation_time) values("'.$id.'","'.$_POST['aminities_name_'.$i].'","'.$_POST['quantity_'.$i].'","'.$_SESSION['username'].'","'.date('Y-m-d H:m:s').'")';
					execute_query($db,$sql);
				}
				if(mysqli_errno($db)){
					$msg .= '<h3 style="color:red;">Aminities addition failed'.mysqli_errno($db).mysqli_error($db).'</h3>';
				}
				else{
					$msg .= '<h3 style="color:green;">Aminities added</h3>';
				}
				
			}
			
			for($i=1; $i<=5; $i++){
				if(isset($_POST['room'.$i]) && isset($_FILES['img_room'.$i]) && $_FILES['img_room'.$i]['name'] != ''){
					$file_details = upload_img($_FILES['img_room'.$i],$target_dir,'img_room'.$i.'_'.$id);
					$sql = execute_query($db, 'update infr_add_rooms set room'.$i.'="' .$_POST['room'.$i].'", img_room'.$i.'="'.$target_dir.$file_details['file_name'].'" where sno = '.$id);
					if(mysqli_errno($db)){
						$msg .= '<h4 style="color:red;">Room Photos upload failed'.mysqli_errno($db).mysqli_error($db).'</h4>';
					}
					else{
						$msg .= '<h4 style="color:green;">Room Photos uploaded</h4>';
					}
					
				}
			}
			// $file_details = upload_img($_FILES['file'],$target_dir,$id);
			// $msg .= $file_details['msg'];
			// $sql = 'update infr_add_room set file="'. $target_dir.$file_details['file_name'].'" where sno = '.$id;
			// if(execute_query($db, $sql)){
				// echo "<li> image uploaded successfully</li>";
			// }
			// else{
				// echo "<li> image upload failed</li>";
			// }
			
		}
	}
	
		
	if(isset($_GET['del'])){
		$sql = 'delete from infr_add_rooms where sno="'.$_GET['del'].'"';
		execute_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
		$sql = 'delete from infr_add_aminities where infr_add_rooms_sno="'.$_GET['del'].'"';
		execute_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting Aminities . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Aminities Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
		$sql = 'select * from infr_add_rooms where sno = '.$_GET['edit'];
		$qry = execute_query($db, $sql);
		$res = mysqli_fetch_assoc($qry);
		$sql = 'select * from infr_add_aminities where infr_add_rooms_sno = '.$_GET['edit'];
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
                <form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" autocomplete = "off">
					<?php echo $msg ?>
                    <h3> Room Information</h3>
                    <div class="col-md-12">
                        <!-- first row -->
                        <div class="row">
                            <div class=" col-md-3 ">
                                <label>Campus Name</label>
                                <select name="campus_name" id="campus_name" value="<?php echo isset($_GET['edit'])? $res['campus_name']: ''?>" class="form-control" >
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
										<option disabled <?php echo isset($_GET['edit'])? "":' selected = "selected" '?>>---Select Faculty Type---</option>
										<?php 
											// $sql  = 'select * from infr_add_faculty_type';
											// $dept_list = execute_query($db, $sql);
											// if($dept_list){
												// while($list = mysqli_fetch_assoc($dept_list)){
													// echo '<option value = "'.$list['sno'].'" '.(isset($_GET['edit']) && $res['faculty_type'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['faculty_type'].'</option>';
												// }
											// }
										?>
									</select>

                            </div>
							<div class=" col-md-3 ">
                                <label>Department Name</label>
                                <select name="department_name" id="department_name" value="<?php echo isset($_GET['edit'])? $res['department_name']: ''?>" class="form-control" >
										<option disabled <?php echo isset($_GET['edit'])? "":' selected = "selected" '?>>---Select Department---</option>
										<?php 
											$sql  = 'select * from dp_department ';
											$dept_list = execute_query($db, $sql);
											if($dept_list){
												while($list = mysqli_fetch_assoc($dept_list)){
													echo '<option value = "'.$list['sno'].'" '.(isset($_GET['edit']) && $res['department_name'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['department_name'].'</option>';
												}
											}
										?>
									</select>

                            </div>
                            <div class="  col-md-3 ">
                                <label>Floor Name</label>
                                <select name="floor_name" id="floor_name" value="<?php echo isset($_GET['edit'])? $res['floor_name']: ''?>" class="form-control" >
										<option disabled <?php echo isset($_GET['edit'])? "":' selected = "selected" '?>>---Select Floor Name---</option>
										<?php 
											// $sql  = 'select * from infr_add_floor';
											// $dept_list = execute_query($db, $sql);
											// if($dept_list){
												// while($list = mysqli_fetch_assoc($dept_list)){
													// echo '<option value = "'.$list['sno'].'" '.(isset($_GET['edit']) && $res['floor_name'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['floor_name'].'</option>';
												// }
											// }
										?>
									</select>


                            </div>
							
                           
                            
                            
                        </div>
                        <!-- second row -->

                        <div class="row">
							<div class="  col-md-3 ">
                                <label>Type (Room ,hall etc..)</label><br>
                                 <select name="room_type" id="room_type" value="<?php echo isset($_GET['edit'])? $res['room_type']: ''?>" class="form-control" >
										<option disabled <?php echo isset($_GET['edit'])? "":' selected = "selected" '?>>---Select Your type---</option>
										<?php 
											$sql  = 'select * from infr_add_room_type';
											$dept_list = execute_query($db, $sql);
											if($dept_list){
												while($list = mysqli_fetch_assoc($dept_list)){
													echo '<option value = "'.$list['sno'].'" '.(isset($_GET['edit']) && $res['room_type'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['room_type'].'</option>';
												}
											}
										?>
									</select>
                            </div>
							 <div class="  col-md-3 ">
                                <label>Room No.</label>
                                <input type="text" name="room_no" id="room_no" value="<?php echo isset($_GET['edit'])? $res['room_no']: '' ?>" class="form-control" >
                            </div>
							<div class="  col-md-3 ">
                                <label>Room Name</label>
                                <input type="text" name="room_name" id="room_name" value="<?php echo isset($_GET['edit'])? $res['room_name']: '' ?>" class="form-control" >
                            </div>
                            <div class="  col-md-3 ">
                                <label>Classroom Seating Capacity</label>
                                <input type="text" name="class_seating" id="class_seating" value="<?php echo isset($_GET['edit'])? $res['class_seating']: '' ?>" class="form-control" >
                            </div>
							
							
                            
                             
                        </div>
						<div class="row">
							<div class="  col-md-3 ">
                                <label>Examination Seating Capacity</label>
                                <input type="text" name="exam_seating" id="exam_seating" value="<?php echo isset($_GET['edit'])? $res['exam_seating']: '' ?>" class="form-control" >
                            </div>
							<div class="col-md-6  ">
                               <div id="experience" >	
							
							<div id="add_rows_length_exp" class="row">
								<div class="col-md-5">									
									<label >Aminities Name</label>
									<select name="aminities_name_0" class="form-control"  id="aminities_name_0" value="<?php echo isset($_GET['edit'])? $res['amenities_name']: ''?>" >
										<option disabled <?php echo isset($_GET['edit'])? "":' selected = "selected" '?>>---Select ---</option>
										<?php 
											$sql  = 'select * from mst_aminities';
											$dept_list = execute_query($db, $sql);
											if($dept_list){
												while($list = mysqli_fetch_assoc($dept_list)){
													echo '<option value = "'.$list['sno'].'" '.(isset($_GET['edit']) && $res['amenities_name'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['aminity_name'].'</option>';
												}
											}
										?>
									</select>									
								</div>
								
								<div class="col-md-5">									
									<label >Quantity</label>
									<input type="text" name="quantity_0" id="quantity_0" class="form-control" placeholder=" " value="" tabindex="<?php echo $tab++; ?>">									
								</div>
								
								
								<div class="col-md-2 d-flex justify-content- align-items-center">
									<button type="button" id="add_button_exp" class="btn btn-info pull-right" onClick="add_rows_exp()">Add</button>
								</div>
							</div>
							
							<div id="test_exp"></div>
							<input type="hidden" name="add_rows_id_exp" id="add_rows_id_exp" value=" " />
							</div>
						</div>
							<div class="  col-md-3 ">
                                <label>Room Dimension(sq.feet)</label>
                                <input id="room_dimension" name="room_dimension"   class="form-control" value="<?php echo isset($_GET['edit'])? $res['room_dimension']: '' ?>" />
                            </div>		
							
						</div>
						<div class="row">
							<div class="col-md-3 ">
                                <label>Description</label>
                                <textarea id="description" name="description" rows="4" cols="50" placeholder="Write Discription about the Room" class="form-control"><?php echo isset($_GET['edit'])? $res['description']: '' ?></textarea>
                            </div>
							<div class="col-md-3 ">
								
							</div>
						</div>
						
                         <!-- third row -->
						 <h4>Upload Room Photo</h4>
						<div class="row">
							<div class="  col-md-3 ">
                                <input type="text" name="room1" id="room1" placeholder="About 1st Image" value="<?php echo isset($_GET['edit'])? $res['room1']: '' ?>" class="form-control" >
							</div>
							<div class="  col-md-3 ">
								<input type="file" name="img_room1" id="img_room1" value="<?php echo isset($_GET['edit'])? $res['img_room1']: '' ?>" class="form-control" >
                                
                            </div>
						</div>
						<div class="row">
							<div class="  col-md-3 ">
                                <input type="text" name="room2" id="room2" placeholder="About 2nd Image" value="<?php echo isset($_GET['edit'])? $res['room2']: '' ?>" class="form-control" >
							</div>
							<div class="  col-md-3 ">
								<input type="file" name="img_room2" id="img_room2" value="<?php echo isset($_GET['edit'])? $res['img_room2']: '' ?>" class="form-control" >
                                
                            </div>
						</div>
						<div class="row">
							<div class="  col-md-3 ">
                                <input type="text" name="room3" id="room3" placeholder="About 3rd Image" value="<?php echo isset($_GET['edit'])? $res['room3']: '' ?>" class="form-control" >
							</div>
							<div class="  col-md-3 ">
								<input type="file" name="img_room3" id="img_room3" value="<?php echo isset($_GET['edit'])? $res['img_room3']: '' ?>" class="form-control" >
                                
                            </div>
						</div>
						<div class="row">
							<div class="  col-md-3 ">
                                <input type="text" name="room4" id="room4" placeholder="About 4th Image" value="<?php echo isset($_GET['edit'])? $res['room4']: '' ?>" class="form-control" >
							</div>
							<div class="  col-md-3 ">
								<input type="file" name="img_room4" id="img_room4" value="<?php echo isset($_GET['edit'])? $res['img_room4']: '' ?>" class="form-control" >
                                
                            </div>
						</div>
						<div class="row">
							<div class="  col-md-3 ">
                                <input type="text" name="room5" id="room5" placeholder="About 5th Image" value="<?php echo isset($_GET['edit'])? $res['room5']: '' ?>" class="form-control" >
							</div>
							<div class="  col-md-3 ">
								<input type="file" name="img_room5" id="img_room1" value="<?php echo isset($_GET['edit'])? $res['img_room1']: '' ?>" class="form-control" >
                                
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
	<div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
                    </div>
			<div class="bg-primary text-white p-2 mb-2"><h3> Room Information</h3></div>
			<table width="100%" class="table table-striped table-hover rounded"  id="general_stat_table">
				<tr class="text-white bg-primary" align="center">
					<th>Sno.</th>
					<th>Campus Name</th>
					<th>Faculty Type</th>
					<th>Department Name</th>
					<th>Floor Name</th>
					<th>Room Type</th>
					<th>Room No</th>
					<th>Room Name</th>
					<th>Class Seating Capacity</th>
					<th>Exam Seating Capacity</th>
					<th>Room Dimension</th>
					<th>Description</th>
					<th>File</th>
					<th>Aminities</th>
					<th>Edit</th>					
					<th>Delete</th>
				</tr>
				<?php
					$sql = 'select * from infr_add_rooms';
					$result = execute_query($db, $sql);
					$a=1;
					if($result){
					while($row = mysqli_fetch_assoc($result)){
						$sql_campus = 'select * from infr_add_campus where sno = "'.$row['campus_name'].'"';
						$result_campus = execute_query($db, $sql_campus);
						if(mysqli_num_rows($result_campus)!=0){
							$row_campus = mysqli_fetch_assoc($result_campus);
							$campus = $row_campus['campus_name'];
						}
						else{
							$campus = '';
						}
						
						$sql_faculty = 'select * from infr_add_faculty_type where sno = "'.$row['faculty_type'].'"';
						$result_faculty = execute_query($db, $sql_faculty);
						if(mysqli_num_rows($result_faculty)!=0){
							$row_faculty = mysqli_fetch_assoc($result_faculty);
							$faculty = $row_faculty['faculty_type'];
						}
						else{
							$faculty = '';
						}
						
						$sql_department = 'select * from dp_department where sno = "'.$row['department_name'].'"';
						$result_department = execute_query($db, $sql_department);
						if(mysqli_num_rows($result_department)!=0){
							$row_department = mysqli_fetch_assoc($result_department);
							$department = $row_department['department_name'];
						}
						else{
							$department = '';
						}
						
						
						
						$sql_floor = 'select * from infr_add_floor where sno = "'.$row['floor_name'].'"';
						$result_floor = execute_query($db, $sql_floor);
						if(mysqli_num_rows($result_floor)!=0){
							$row_floor = mysqli_fetch_assoc($result_floor);
							$floor = $row_floor['floor_name'];
						}
						else{
							$floor = '';
						}
						
						$sql_room = 'select * from infr_add_room_type where sno = "'.$row['room_type'].'"';
						$result_room = execute_query($db, $sql_room);
						if(mysqli_num_rows($result_room)!=0){
							$row_room = mysqli_fetch_assoc($result_room);
							$room = $row_room['room_type'];
						}
						else{
							$room = '';
						}
						
						echo '<tr style="text-align:center;">
						<td>'.$a++.'</td>
						<td>'.$campus.'</td>
						<td>'.$faculty.'</td>
						<td>'.$department.'</td>
						<td>'.$floor.'</td>
						<td>'.$room.'</td>
						<td>'.$row['room_no'].'</td>
						<td>'.$row['room_name'].'</td>
						<td>'.$row['class_seating'].'</td>
						<td>'.$row['exam_seating'].'</td>
						<td>'.$row['room_dimension'].'</td>
						<td>'.$row['description'].'</td>
						<td>';
						for($i=1; $i<=5; $i++){
							if(isset($row['img_room'.$i])){
									echo '<img src="user_data/'.$row['img_room'.$i].'" width="60px" height="50px" style="margin:5px;" onclick="openFullscreen(this)">';
							}
						}
						
						
						echo '</td>
						<td>';
						$id = $row['sno'];
						$sql = 'select * from infr_add_aminities where infr_add_rooms_sno = '.$id;
						$qry = execute_query($db, $sql);
						if($qry){
						while($row = mysqli_fetch_assoc($qry)){
							echo mysqli_fetch_assoc(execute_query($db, 'select * from mst_aminities where sno = '.$row['aminities_name']))['aminity_name'].'-'.$row['quantity'].'<br>';
						}}

						echo '</td>';
						echo '<td><a href="infr_add_rooms.php?edit='.$id.'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>';
						echo '<td><a href="infr_add_rooms.php?del='.$id.'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
							</tr>'	;
					}}
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

		$.ajax({
			url: 'ajax_floor_name.php',
			method: 'GET',
			data : {faculty_type: selected_value, id: <?php echo isset($_GET['edit'])? $_GET['edit']: '"test"' ?>},
			success: function(data){
				$("#floor_name").html(data);
			}
		});
	 })
})

</script>	
<script>
function openFullscreen(element) {
    if (element.requestFullscreen) {
        element.requestFullscreen();
    } else if (element.mozRequestFullScreen) { // Firefox
        element.mozRequestFullScreen();
    } else if (element.webkitRequestFullscreen) { // Chrome, Safari and Opera
        element.webkitRequestFullscreen();
    } else if (element.msRequestFullscreen) { // IE/Edge
        element.msRequestFullscreen();
    }
}
</script>

<script>
	function add_rows_exp(){
		var id = parseFloat($("#add_rows_id_exp").val());
		if(!id){
			id=0;
		}
		/*for(var i=1; i<=id; i++){
			if($("#month_"+i).val()=='' || $("#amount_"+i).val()==''){
				alert("पंक्ति संख्या "+i+" खाली है");
				$("#month_"+i).focus();
				return;
			}
		}*/
		id = id+1;

		

		var txt = id+'<div id="add_rows_length_exp" class="row"><div class="col-md-5"><label > Amenities Name</label><select class="form-control" name="aminities_name_'+id+'" id="aminities_name_'+id+'" onChange="show_description(this.value, '+id+')"><option value="">--- Select ---</option>';
		<?php 
			$sql  = 'select * from mst_aminities';
			$dept_list = execute_query($db, $sql);
			if($dept_list){
				while($list = mysqli_fetch_assoc($dept_list)){
					echo 'txt += "<option value=\''.$list['sno'].'\'>'.$list['aminity_name'].'</option>";'."\n";
				}
			}
		?>
		txt += '</select></div><div class="col-md-5"><label >Quantity</label><input type="text" name="quantity_'+id+'" id="quantity_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-2 d-flex justify-content- align-items-center"><button type="button" id="add_button_exp" class="btn btn-info pull-right" onClick="add_rows_exp()">Add</button></div></div>';
		$("#test_exp").append(txt);
		$("#add_rows_id_exp").val(id);
	}
</script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<script>

$('select[multiple]').multiselect({
	search: true,
	selectAll: true
});
	
$(document).ready( function () {
    /*$('#general_stat_table').DataTable({
		paging: false,
		fixedHeader: true,
		colReorder: true
		});
	});	*/

	
	var t = $('#general_stat_table').DataTable({
		paging: false
    });
 
    
});
	
</script>

	
<?php
page_footer_start();
echo '<!-- JS & CSS library of MultiSelect plugin -->';
echo '<script src="multiselect/jquery.multiselect.js"></script>
<link rel="stylesheet" href="multiselect/jquery.multiselect.css">';
page_footer_end();
?>