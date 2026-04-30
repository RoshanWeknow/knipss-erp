<?php 
include("scripts/settings.php");

$msg='';

page_header_start();
page_header_end();
page_sidebar();
?>
<?php	
	if(isset($_POST['submit'])){
    if(isset($_POST['edit']) && $_POST['edit'] != ''){
        $sql = 'UPDATE lib_fine_wave set 
				lib_loc="'.$_POST['lib_loc'].'" ,
				lib_card_no="'.$_POST['lib_card_no'].'" , 
				from_date="'.$_POST['from_date'].'" ,  
				upto_date="'.$_POST['upto_date'].'" , 
				edited_by="'.$_SESSION['username'].'",
				edited_date="'.date("d-m-y H:i:s").'"
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
				$sql = 'INSERT INTO lib_fine_wave(lib_loc, lib_card_no, from_date, upto_date, created_by, created_date) 
					values("'.$_POST['lib_loc'].'",
					"'.$_POST['lib_card_no'].'",
					"'.$_POST['from_date'].'",
					"'.$_POST['upto_date'].'",
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
		$sql = 'delete from lib_fine_wave where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from lib_fine_wave where sno = '.$_GET['edit'];
	$qry = mysqli_query($db, $sql);
	$res = mysqli_fetch_assoc($qry);
}
?>

<div id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"  enctype="multipart/form-data" method="POST" onSubmit="" autocomplete="off">
				<div class="bg-primary text-white p-2"><h3>Fine Waive</h3></div>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr class="">
							<th>Library Location</th>
							<th><select class="form-control" name="lib_loc" id="lib_loc" class="form-control">
									<option value="">----Select----</option>
									<option value="KNIPSS(CENTRAL LIBRARY)"<?php echo (isset($_GET['edit']) && $res['lib_loc']=='KNIPSS(CENTRAL LIBRARY)') ?' selected="selected"':''  ?>>KNIPSS(CENTRAL LIBRARY)</option>
								</select></th>
							<th>Library Card No.</th>
							<th><input type="text" name="lib_card_no" id="lib_card_no" value="<?php echo isset($_GET['edit'])? $res['lib_card_no']: '' ?>" class="form-control" required="required"></th>
							
							
						</tr>
						<tr>
							<th>From</th>
							<th><script  type="text/javascript" language="javascript">
									document.writeln(DateInput('from_date', 'from_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['from_date'])){echo $_POST['from_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script></th>
								<th>Upto</th>
							<th><script  type="text/javascript" language="javascript">
									document.writeln(DateInput('upto_date', 'upto_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['upto_date'])){echo $_POST['upto_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script></th>
							
						</tr>
					</table>
					
					<button type="submit" class="btn btn-primary " name="submit" value="">Search </button>
					<button type="submit" class="btn btn-success " name="save" value="reset">Reset </button>
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
							<th>Library Location</th>
							<th>Library Card No.</th>
							<th>From</th>
							<th>Upto</th>
							<th>Edit </th>
							<th>Delete</th>
						</tr>
							<?php
								$sql = 'select * from lib_fine_wave';
								$result = mysqli_query($db, $sql);
								$i=1;
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['lib_loc'].'</td>
									<td>'.$row['lib_card_no'].'</td>
									<td>'.$row['from_date'].'</td>
									<td>'.$row['upto_date'].'</td>
									<td><a href="lib_fine_wave.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									<td><a href="lib_fine_wave.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
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
page_footer_end();
?>
