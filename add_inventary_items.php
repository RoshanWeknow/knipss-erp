<?php
include("scripts/settings.php");
$msg = '';
$tab = 1;
// if (isset($_POST['type'])) {
	// if ($_POST['type'] == '') {
		// $msg .= '<h6 class="alert alert-danger">Blank Entry!</h6>';
	// }
	// if ($msg == '') {
		// if ($_POST['edit_sno'] != '') {
			// $sql = 'update mst_food_type set 
			// name="' . $_POST['name'] . '",
			// edited_by="' . $_SESSION['username'] . '",
			// edition_time="' . date("Y-m-d H:i:s") . '"
			// where sno=' . $_POST['edit_sno'];
		// } else {
			// $sql = 'insert into mst_food_type (name, created_by, creation_time) values ("' . $_POST['name'] . '", "' . $_SESSION['username'] . '", "' . date("Y-m-d H:i:s") . '")';
		// }

		// execute_query($sql);
		// if (mysqli_error($db)) {
			// $msg .= '<h6 class="alert alert-danger">Error 1 # : ' . mysqli_error($db) . ' >> ' . $sql . '</h6>';
			// $msg .= '<h6 class="alert alert-danger">Error 1.</h6>';
		// }
		// if ($msg == '') {
			// $msg .= '<h6 class="alert alert-success">Success.</h6>';
			// $_POST['type'] = '';
			// $_POST['edit_sno'] = '';
		// }
	// }
// } else {
	// $_POST['type'] = '';
	// $_POST['edit_sno'] = '';
// }
// if (isset($_GET['id'])) {
	// $sql = 'select * from mst_food_type where sno=' . $_GET['id'];
	// $data = mysqli_fetch_assoc(execute_query($sql));
	// $_POST['type'] = $data['type_name'];
	// $_POST['edit_sno'] = $data['sno'];
// }
// if (isset($_GET['del'])) {
		// $sql = 'delete from mst_food_type where sno=' . $_GET['del'];
		// $data = execute_query($sql);
		// $msg .= '<h6 class="alert alert-danger">Data deleted.</h6>';
	
// }
?>
<?php
	if(isset($_POST['submit'])){
		if(isset($_POST['edit']) && $_POST['edit'] != ''){
			$sql = 'update inventory_item set 
					item_name="'.$_POST['item_name'].'" 
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
			$sql = 'insert into inventory_item (item_name) 
					values
				   ("'.$_POST['item_name'].'")';
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
		$sql = 'delete from inventory_item where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from inventory_item where sno = '.$_GET['edit'];
	$qry = mysqli_query($db, $sql);
	$res = mysqli_fetch_assoc($qry);
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
</style>


<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Add Item</h4>
				<?php echo $msg; ?>
			</div>
			<div class="card-body">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="" name="">
					<div class="row">
						<div class="col-md-4 pr-1">
							<div class="form-group">
								<label for = "type">ITEM NAME</label>
								<input type="text" name="item_name" id="item_name" class="form-control" placeholder="Enter Name" value="<?php echo isset($_GET['edit'])? $res['item_name']: '' ?>" required>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-fill pull-right" name="submit">Submit</button>
					<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
				</form>
			</div>
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
							<th>Item Name</th>
							<th>Edit </th>
							<th>Delete</th>
						</tr>
							<?php
								$sql = 'select * from inventory_item';
								$result = mysqli_query($db, $sql);
								$i=1;
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['item_name'].'</td>
									<td><a href="add_inventary_items.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									<td><a href="add_inventary_items.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
										</tr>'	;
								}
							?>
					</table>
				</div>
			</div>
		</div>
	</div>

<!--<div class="row">
	<div class="col-md-12">
		<div class="card strpied-tabled-with-hover">

			<div class="card-body table-full-width table-responsive">
				<table class="table table-hover table-striped">
					<thead>
						<?php
						// $i = 1;
						// $sql = 'select * from mst_food_type where 1=1';
						// $result_data = execute_query($sql);
						?>
						<tr>
							<th colspan="6">
								<?php
								// include('pagination/paginate.php'); //include of paginat page
								// $total_results = mysqli_num_rows($result_data);
								// $total_pages = ceil($total_results / $per_page); //total pages we going to have
								// $tpages = $total_pages;
								// if (isset($_GET['page'])) {
									// $show_page = $_GET['page'];             //it will telles the current page
									// if ($show_page > 0 && $show_page <= $total_pages) {
										// $start = ($show_page - 1) * $per_page;
										// $end = $start + $per_page;
									// } else {
										// // error - show first set of results
										// $start = 0;
										// $end = $per_page;
									// }
								// } else {
									// // if page isn't set, show first set of results
									// $_GET['page'] = 1;
									// $show_page = 1;
									// $start = 0;
									// $end = $per_page;
								// }
								// // display pagination
								// $page = intval($_GET['page']);

								// if ($page <= 0)
									// $page = 1;


								// $reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages . (isset($_GET['details']) ? '&details=1' : '');
								// echo '<div class="pagination"><ul>';
								// if ($total_pages > 1) {
									// echo paginate($reload, $show_page, $total_pages);
								// }
								// echo "</ul></div>";
								?>
							</th>
						</tr>
					</thead>
				</table>

				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th>S.No.</th>
							<th>TYPE</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						// $i = 1;
						// $sql = 'select * from mst_food_type';
						// $result = execute_query($sql);
						// for ($pgid = $start; $pgid < $end; $pgid++) {
							// //print_r($row);
							// if ($pgid == $total_results) {
								// break;
							// }
							// mysqli_data_seek($result_data, $pgid);
							// $row = mysqli_fetch_array($result_data);
							// $i = $pgid + 1;
						?>
							<tr>
								<td class="text-center"><?php //echo $i++; ?></td>
								<td class="text-center"><?php //echo $row['type_name']; ?></td>
								<td class="text-center"><a href="<?php //echo $_SERVER['PHP_SELF'] . '?id=' . $row['sno']; ?>" alt="Edit" data-toggle="tooltip" title="Edit"><span class="far fa-edit" aria-hidden="true"></span></td>
								<td class="text-center"><a href="<?php //echo $_SERVER['PHP_SELF'] . '?del=' . $row['sno']; ?>" onclick="return confirm('Are you sure?');" style="color:#f00" alt="Delete"><span class="far fa-trash-alt" aria-hidden="true" data-toggle="tooltip" title="Delete"></span></a></td>
							</tr>


						<?php
						// }

						?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>-->


<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>

<?php
page_footer_start();
page_footer_end();
?>