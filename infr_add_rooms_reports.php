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
					floor_name="'.$_POST['floor_name'].'", 
					room_type="'.$_POST['room_type'].'", 
					room_no="'.$_POST['room_no'].'" ,
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
			
			$sql = 'insert into infr_add_rooms (campus_name,faculty_type, floor_name, room_type, room_no,class_seating,exam_seating,room_dimension, description,  created_by, creation_time )values("'.$_POST['campus_name'].'","'.$_POST['faculty_type'].'","'.$_POST['floor_name'].'","'.$_POST['room_type'].'","'.$_POST['room_no'].'","'.$_POST['class_seating'].'","'.$_POST['exam_seating'].'","'.$_POST['room_dimension'].'","'.$_POST['description'].'","'.$_SESSION['username'].'","'.date('Y-m-d H:m:s').'")';
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
<head>
  <!-- Include the jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <!-- Include the DataTables CSS and JavaScript files -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.css">
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.js"></script>
</head>

<style>
form div.row:nth-child(odd) {
    background: #eeeeee;
    border-radius: 5px;
    margin-bottom: 5px;
    margin-top: 5px;
    padding: 5px;
}

form div.row label {
    color: #000000;
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
                        <div class="  col-md-4 ">
                            <label>Room No.</label>
							<input type="text" name="room_no" id="room_no" value="" class="form-control" placeholder="Search by Room No" onkeyup="searchFun()" >
                        </div>
                        <!--
							<div class="  col-md-4 ">
								<label>Floor Name</label>
								<input type="text" name="floor_name" id="floor_name" value="" class="form-control" required="required">
							</div>
							<div class="  col-md-4 ">
								<label>Room's Type</label>
								<input type="text" name="room_type" id="room_type" value="" class="form-control" required="required">
							</div>
							---->
                    </div>
                    <button type="submit" class="btn btn-primary ms-4" name="submit" value="">Submit </button>
                    <button type="submit" class="btn btn-success ms-4" name="reset" value="reset">Reset </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="card card-body">
    <div class="bg-primary text-white p-2 mb-2">
        <h3> Room Information</h3>
    </div>
    <table width="100%" class="table table-striped table-hover rounded" id="myTable" class="display">
        <tr class="text-white bg-primary" align="center" >
            <th>Sno.</th>
            <th>Campus Name</th>
            
			<th>Faculty Type</th>
			<th>Department Name</th>
			<th>Floor Name</th>
            <th>Room Type</th>
            <th>Room No</th>
            <th>Class Seating Capacity</th>
            <th>Exam Seating Capacity</th>
            <th>Room Dimension</th>
            <th>Description</th>
            <th>File</th>
            <th>Aminities</th>
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
<?php
page_footer_start();
page_footer_end();
?>