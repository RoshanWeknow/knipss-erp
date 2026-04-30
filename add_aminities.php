<?php
include("scripts/settings.php");
$msg = '';
$tab = 1;
if (isset($_POST['aminity_name'])) {
	if ($_POST['aminity_name'] == '') {
		$msg .= '<h6 class="alert alert-danger">Blank Entry!</h6>';
	}
	if ($msg == '') {
		if ($_POST['edit'] != '') {
			$sql = 'update mst_aminities set 
			aminity_name="' . $_POST['aminity_name'] . '",
			edited_by="' . $_SESSION['username'] . '",
			edition_time="' . date("Y-m-d H:i:s") . '"
			where sno=' . $_POST['edit'];
		} else {
			$sql = 'insert into mst_aminities (aminity_name, created_by, creation_time) values ("' . $_POST['aminity_name'] . '", "' . $_SESSION['username'] . '", "' . date("Y-m-d H:i:s") . '")';
		}

		execute_query($db, $sql);
		if (mysqli_error($db)) {
			$msg .= '<h6 class="alert alert-danger">Error 1 # : ' . mysqli_error($db) . ' >> ' . $sql . '</h6>';
			$msg .= '<h6 class="alert alert-danger">Error 1.</h6>';
		}
		if ($msg == '') {
			$msg .= '<h6 class="alert alert-success">Success.</h6>';
			$_POST['aminity_name'] = '';
			$_POST['edit'] = '';
		}
	}
} else {
	$_POST['aminity_name'] = '';
	$_POST['edit'] = '';
}
if (isset($_GET['id'])) {
	$sql = 'select * from mst_aminities where sno=' . $_GET['id'];
	$data = mysqli_fetch_assoc(execute_query($db, $sql));
	$_POST['aminity_name'] = $data['aminity_name'];
	$_POST['edit'] = $data['sno'];
}
if (isset($_GET['del'])) {
		$sql = 'delete from mst_aminities where sno=' . $_GET['del'];
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
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="user_form" name="user_form">
					<div class="row">
						<div class="col-md-4 pr-1">
							<div class="form-group">
								<label for = "type">AMINITY NAME</label>
								<input type="text" name="aminity_name" id="aminity_name" tabindex="<?php echo $tab++; ?>" class="form-control" placeholder="Enter Name" value="<?php echo $_POST['aminity_name'] ?>">
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
					<thead>
						<?php
						$i = 1;
						$sql = 'select * from mst_aminities where 1=1';
						$result_data = execute_query($db, $sql);
						?>
						<tr>
							<th colspan="6">
								<?php
								include('pagination/paginate.php'); //include of paginat page
								$total_results = mysqli_num_rows($result_data);
								$total_pages = ceil($total_results / $per_page); //total pages we going to have
								$tpages = $total_pages;
								if (isset($_GET['page'])) {
									$show_page = $_GET['page'];             //it will telles the current page
									if ($show_page > 0 && $show_page <= $total_pages) {
										$start = ($show_page - 1) * $per_page;
										$end = $start + $per_page;
									} else {
										// error - show first set of results
										$start = 0;
										$end = $per_page;
									}
								} else {
									// if page isn't set, show first set of results
									$_GET['page'] = 1;
									$show_page = 1;
									$start = 0;
									$end = $per_page;
								}
								// display pagination
								$page = intval($_GET['page']);

								if ($page <= 0)
									$page = 1;


								$reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages . (isset($_GET['details']) ? '&details=1' : '');
								echo '<div class="pagination text-white"><ul>';
								if ($total_pages > 1) {
									echo paginate($reload, $show_page, $total_pages);
								}
								echo "</ul></div>";
								?>
							</th>
						</tr>
					</thead>
				</table>

				<table class="table table-hover table-striped">
					<thead>
						<tr class="bg-primary text-white">
							<th>S.No.</th>
							<th>Aminity Name</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$sql = 'select * from mst_aminities';
						$result = execute_query($db, $sql);
						for ($pgid = $start; $pgid < $end; $pgid++) {
							//print_r($row);
							if ($pgid == $total_results) {
								break;
							}
							mysqli_data_seek($result_data, $pgid);
							$row = mysqli_fetch_array($result_data);
							$i = $pgid + 1;
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td class="text-center"><?php echo $row['aminity_name']; ?></td>
								<td class="text-center"><a href="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $row['sno']; ?>" alt="Edit" data-toggle="tooltip" title="Edit"><span class="far fa-edit" aria-hidden="true"></span></td>
								<td class="text-center"><a href="<?php echo $_SERVER['PHP_SELF'] . '?del=' . $row['sno']; ?>" onclick="return confirm('Are you sure?');" style="color:#f00" alt="Delete"><span class="far fa-trash-alt" aria-hidden="true" data-toggle="tooltip" title="Delete"></span></a></td>
							</tr>


						<?php
						}

						?>

					</tbody>
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