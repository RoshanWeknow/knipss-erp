<?php
include("scripts/settings.php");
$msg = '';
$tab = 1;
if (isset($_POST['room_type'])) {
	if ($_POST['room_type'] == '') {
		$msg .= '<h6 class="alert alert-danger">Blank Entry!</h6>';
	}
	if ($msg == '') {
		if ($_POST['edit'] != '') {
			$sql = 'update infr_add_room_type set 
			room_type="' . $_POST['room_type'] . '",
			edited_by="' . $_SESSION['username'] . '",
			edition_time="' . date("Y-m-d H:i:s") . '"
			where sno=' . $_POST['edit'];
		} else {
			$sql = 'insert into infr_add_room_type (room_type, created_by, creation_time) values ("' . $_POST['room_type'] . '", "' . $_SESSION['username'] . '", "' . date("Y-m-d H:i:s") . '")';
		}

		execute_query($db, $sql);
		if (mysqli_error($db)) {
			$msg .= '<h6 class="alert alert-danger">Error 1 # : ' . mysqli_error($db) . ' >> ' . $sql . '</h6>';
			$msg .= '<h6 class="alert alert-danger">Error 1.</h6>';
		}
		if ($msg == '') {
			$msg .= '<h6 class="alert alert-success">Success.</h6>';
			$_POST['room_type'] = '';
			$_POST['edit'] = '';
		}
	}
} else {
	$_POST['room_type'] = '';
	$_POST['edit'] = '';
}
if (isset($_GET['id'])) {
	$sql = 'select * from infr_add_room_type where sno=' . $_GET['id'];
	$data = mysqli_fetch_assoc(execute_query($db, $sql));
	$_POST['room_type'] = $data['room_type'];
	$_POST['edit'] = $data['sno'];
}
if (isset($_GET['del'])) {
		$sql = 'delete from infr_add_room_type where sno=' . $_GET['del'];
		$data = execute_query($db, $sql);
		$msg .= '<h6 class="alert alert-danger">Data deleted.</h6>';
	
}
?>

<?php
page_header_start();
page_header_end();
page_sidebar();

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
.table-striped thead {
    background-color: #0d6efd!important;
    color: #ffffff;
}
</style>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				
				<?php echo $msg; ?>
			</div>
			<div class="card-body">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="user_form" room_type="user_form">
					<div class="row">
						<div class="col-md-4 pr-1">
							<div class="form-group">
								<label for = "type">Room Type</label>
								<input type="text" name="room_type" id="room_type" tabindex="<?php echo $tab++; ?>" class="form-control" placeholder="Enter room_type" value="<?php echo $_POST['room_type'] ?>">
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-fill pull-right" value="">Create/Update </button>
					<input type="hidden" name="edit" id="edit" value="<?php  echo $_POST['edit'] ?>">
					<div class="clearfix"></div>
				</form>
			</div>
		</div>
	</div>
</div>




<div class="row">
	<div class="col-md-12">
		<div class="card strpied-tabled-with-hover">

			<div class="card-body table-full-width table-responsive">
				
				<table class="table table-hover table-striped">
					
						<tr class="bg-primary text-white">
							<th>S.No.</th>
							<th>ROOM TYPE</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					<?php
									$sql = 'select * from infr_add_room_type';
									$result = execute_query($db, $sql);
									$i=1;
									while($row = mysqli_fetch_assoc($result)){
										echo '<tr>
										<td>'.$i++.'</td>
										<td>'.$row['room_type'].'</td>
										<td><a href="infr_add_room_type.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
										<td><a href="infr_add_room_type.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
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
?>


<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>

<?php
page_footer_end();
?>