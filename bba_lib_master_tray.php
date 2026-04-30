<?php 

//include("scripts/settings.php");

include("bba_lib_setting.php");



$msg='';



// page_header_start();

// page_header_end();

// page_sidebar();

header_lib();

?>

<?php	

	if(isset($_POST['submit'])){

    if(isset($_POST['edit']) && $_POST['edit'] != ''){

        $sql = 'UPDATE bba_lib_master_tray set  

				almirah_name="'.$_POST['almirah_name'].'" ,  

				tray_name="'.$_POST['tray_name'].'" ,

				max_quantity="'.$_POST['max_quantity'].'" ,  

				edited_by="'.$_SESSION['username'].'",

				edition_time="'.date("d-m-y H:i:s").'"

				 where sno = '.$_POST['edit'];

			 //echo $sql;		 

				mysqli_query($db, $sql);

				if(mysqli_errno($db)){

					echo "Updation failed: ".mysqli_errno($db).mysqli_error($db);

				}

				else{

					echo "Successfully updated";

				}

			}

		else{

				$sql = 'INSERT INTO bba_lib_master_tray(almirah_name, tray_name, max_quantity, created_by, creation_time) 

					values("'.$_POST['almirah_name'].'",

					"'.$_POST['tray_name'].'",

					"'.$_POST['max_quantity'].'",

					"'.$_SESSION['username'].'",

					"'.date("d-m-y H:i:s").'")';

			//echo $sql;



				mysqli_query($db,$sql);

				if(mysqli_errno($db)){

					echo "Insertion failed: ".mysqli_errno($db).mysqli_error($db);

				}

				else{

					echo "Data inserted";

				}

			}

	}

	

	if(isset($_GET['del'])){

		$sql = 'delete from bba_lib_master_tray where sno="'.$_GET['del'].'"';

		mysqli_query($db, $sql);

		if(mysqli_error($db)){

			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';

		}

		else{

			$msg .= '<h3 style="color:red;">Deleted</h3>';

		}

	}

	



	if(isset($_GET['edit'])){

	$sql = 'select * from bba_lib_master_tray where sno = '.$_GET['edit'];

	$qry = mysqli_query($db, $sql);

	$res = mysqli_fetch_assoc($qry);

}

?>

<div id="container">

	<div class="card">

		<div class="card-body ">

			<div class="row d-flex my-auto">

				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"  enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">

					<table width="100%" class="table table-striped table-hover rounded">

						<tr>

							<th>Select Almirah</th>	

							<th><select class="form-control" name="almirah_name" id="almirah_name" class="form-control">

									<?php

										$sql = "SELECT * FROM bba_lib_master_almirah";

										$result = mysqli_query($db, $sql);

										

										while ($row = mysqli_fetch_assoc($result)) {

											echo '<option value="'.$row["almirah_name"].'" '.(isset($_GET['edit']) && $res['almirah_name'] == $row['almirah_name'] ? 'selected':'').'>'.$row["almirah_name"].'</option>';

										}

									?>

								</select>

							</th>

								

							<th>Tray Name</th>

							<th><input type="text" name="tray_name" id="tray_name" value="<?php echo isset($_GET['edit'])? $res['tray_name']: '' ?>" class="form-control" required="required"></th>

							

							<th>Max Quantity</th>

							<th><input type="text" name="max_quantity" id="max_quantity" value="<?php echo isset($_GET['edit'])? $res['max_quantity']: '' ?>" class="form-control" required="required">

							</th>

						</tr>

					</table>

					<button type="submit" class="btn btn-primary " name="submit" value="">Submit </button>

					<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">

				</form>

			</div>

		</div>

	</div>

</div>

<div id="container">	

		<div class="card card-body">    

        	<div class="row d-flex my-auto">  

			<div ><h3>Records</h3></div>

				<div class="col-md-12" >

					<table width="80%" class="table table-striped  table-hover rounded">

						<tr class="bg-primary text-white">

							<th>Sno</th>

							<th>Almirah Name</th>

							<th>Tray Name</th>

							<th>Max Quantity</th>

							<th>Edit </th>

							<th>Delete</th>

						</tr>

							<?php

								$sql = 'select * from bba_lib_master_tray';

								$result = mysqli_query($db, $sql);

								$i=1;

								while($row = mysqli_fetch_assoc($result)){

									echo '<tr>

									<td>'.$i++.'</td>

									<td>'.$row['almirah_name'].'</td>

									<td>'.$row['tray_name'].'</td>

									<td>'.$row['max_quantity'].'</td>

									<td><a href="bba_lib_master_tray.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>

									<td><a href="bba_lib_master_tray.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>

										</tr>'	;

								}

							?>

					</table>

				</div>

			</div>

		</div>

	</div>

<?php

// page_footer_start();

// page_footer_end();

footer_lib();

?>