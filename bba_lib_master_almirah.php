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

        $sql = 'UPDATE bba_lib_master_almirah set 

				subject="'.$_POST['subject'].'" , 

				almirah_name="'.$_POST['almirah_name'].'" ,  

				quantity="'.$_POST['quantity'].'" ,  

				tray_name="'.$_POST['tray_name'].'" ,

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

				$sql = 'INSERT INTO bba_lib_master_almirah(subject, almirah_name, quantity, tray_name, created_by, creation_time) 

					values("'.$_POST['subject'].'",

					"'.$_POST['almirah_name'].'",

					"'.$_POST['quantity'].'",

					"'.$_POST['tray_name'].'",

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

		$sql = 'delete from bba_lib_master_almirah where sno="'.$_GET['del'].'"';

		mysqli_query($db, $sql);

		if(mysqli_error($db)){

			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';

		}

		else{

			$msg .= '<h3 style="color:red;">Deleted</h3>';

		}

	}

	



	if(isset($_GET['edit'])){

	$sql = 'select * from bba_lib_master_almirah where sno = '.$_GET['edit'];

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

							<th>Select Subject</th>	

							<th><select class="form-control" name="subject" id="subject" class="form-control">

									<?php

										$sql = "SELECT * FROM add_subject";

										$result = mysqli_query($db, $sql);

										

										while ($row = mysqli_fetch_assoc($result)) {

											$selected="";

											if(isset($_GET['edit'])){

												if($res['subject']==$row['subject']){

													$selected="selected";

												}

											}

											echo '<option '.$selected.' value="'.$row["subject"].'">'.$row["subject"].'</option>';

										}

									?>

								</select>

							</th>

								

							<th>Almirah Name</th>	

							<th><input type="text" name="almirah_name" id="almirah_name" value="<?php echo isset($_GET['edit'])? $res['almirah_name']: '' ?>" class="form-control" required="required">

							</th>

							

							<th>Quantity</th>

							<th><input type="text" name="quantity" id="quantity" value="<?php echo isset($_GET['edit'])? $res['quantity']: '' ?>" class="form-control" required="required">

							</th>

							

						</tr>

						<tr>

							<th>Numbers Of Tray</th>

							<th><input type="text" name="tray_name" id="tray_name" value="<?php echo isset($_GET['edit'])? $res['tray_name']: '' ?>" class="form-control" required="required"></th>

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

							<th>Subject</th>

							<th>Almirah Name</th>

							<th>Quantity</th>

							<th>Tray Name</th>

							<th>Edit </th>

							<th>Delete</th>

						</tr>

							<?php

								$sql = 'select * from bba_lib_master_almirah';

								$result = mysqli_query($db, $sql);

								$i=1;

								while($row = mysqli_fetch_assoc($result)){

									echo '<tr>

									<td>'.$i++.'</td>

									<td>'.$row['subject'].'</td>

									<td>'.$row['almirah_name'].'</td>

									<td>'.$row['quantity'].'</td>

									<td>'.$row['tray_name'].'</td>

									<td><a href="bba_lib_master_almirah.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>

									<td><a href="bba_lib_master_almirah.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>

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