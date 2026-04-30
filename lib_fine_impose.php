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
        $sql = 'UPDATE lib_fine_impose set 
				lib_loc="'.$_POST['lib_loc'].'" ,
				l_card_no="'.$_POST['l_card_no'].'" , 
				accession_no="'.$_POST['accession_no'].'" , 
				s_name="'.$_POST['s_name'].'" ,  
				department="'.$_POST['department'].'" ,  
				designation="'.$_POST['designation'].'" ,  
				reason="'.$_POST['reason'].'" ,  
				item_type="'.$_POST['item_type'].'" ,  
				unit_cost="'.$_POST['unit_cost'].'" ,  
				fine_amount="'.$_POST['fine_amount'].'" ,  
				paid_amount="'.$_POST['paid_amount'].'" , 
				edited_by="'.$_SESSION['username'].'",
				edition_time="'.date("d-m-y H:i:s").'"
				 where sno = '.$_POST['edit'];
			// echo $sql;		 
				mysqli_query($db, $sql);
				if(mysqli_errno($db)){
					echo "Updation failed: ".mysqli_errno($db).mysqli_error($db);
				}
				else{
					echo "Successfully updated";
				}
			}
		else{
				$sql = 'INSERT INTO lib_fine_impose(lib_loc, l_card_no, accession_no, s_name, department, designation, reason, item_type, unit_cost, fine_amount, paid_amount, created_by, creation_time) 
					values("'.$_POST['lib_loc'].'",
					"'.$_POST['l_card_no'].'",
					"'.$_POST['accession_no'].'",
					"'.$_POST['s_name'].'",
					"'.$_POST['department'].'",
					"'.$_POST['designation'].'",
					"'.$_POST['reason'].'",
					"'.$_POST['item_type'].'",
					"'.$_POST['unit_cost'].'",
					"'.$_POST['fine_amount'].'",
					"'.$_POST['paid_amount'].'",
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
		$sql = 'delete from lib_fine_impose where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from lib_fine_impose where sno = '.$_GET['edit'];
	$qry = mysqli_query($db, $sql);
	$res = mysqli_fetch_assoc($qry);
}
?>

<div id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"  enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
				<div class="bg-primary text-white p-2"><h3>Fine Impose</h3></div>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr class="">
							<th>Library Location</th>
							<th><select class="form-control" name="lib_loc" id="lib_loc" class="form-control">
									<option value="">----Select----</option>
									<option value="KNIPSS(CENTRAL LIBRARY)"<?php echo (isset($_GET['edit']) && $res['lib_loc']=='KNIPSS(CENTRAL LIBRARY)') ?' selected="selected"':''  ?>>KNIPSS(CENTRAL LIBRARY)</option>
								</select></th>
							<th>Library Card No.</th>
							<th><input type="text" name="l_card_no" id="l_card_no" value="<?php echo isset($_GET['edit'])? $res['l_card_no']: '' ?>" class="form-control" required="required"></th>
							<th style="text-align:center;" width="20%" rowspan="2"> <img  src="#" alt="img" > </th>
							
						</tr>
						<tr>
							<th>Accession No.</th>
							<th><input type="text" name="accession_no" id="accession_no" value="<?php echo isset($_GET['edit'])? $res['accession_no']: '' ?>" class="form-control" required="required"></th>
							
							<th></th>
							<th></th>
						</tr>
					</table>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr class="bg-info text-white">
							<th width="20%">Member Particular</th>
							<th width="20%"></th>
							<th width="20%">Inventory Particular</th>
							<th width="20%"></th>
							<th width="20%"></th>
						<tr>
						<tr>
							<th>Name</th>
							<th><input type="text" name="s_name" id="s_name" value="<?php echo isset($_GET['edit'])? $res['s_name']: '' ?>" class="form-control" required="required"></th>
							
							<th>Department</th>
							<th><input type="text" name="department" id="department" value="<?php echo isset($_GET['edit'])? $res['department']: '' ?>" class="form-control" required="required"></th>
							<th></th>
						</tr>
						<tr>
							<th>Designation</th>
							<th><input type="text" name="designation" id="designation" value="<?php echo isset($_GET['edit'])? $res['designation']: '' ?>" class="form-control" required="required"></th>
							
							<th>Reason</th>
							<th><input type="text" name="reason" id="reason" value="<?php echo isset($_GET['edit'])? $res['reason']: '' ?>" class="form-control" required="required"></th>
							<th></th>
						</tr>
						<tr>
							<th>Item Type</th>
							<th><input type="text" name="item_type" id="item_type" value="<?php echo isset($_GET['edit'])? $res['item_type']: '' ?>" class="form-control" required="required"></th>
							
							<th>Unit Cost</th>
							<th><input type="text" name="unit_cost" id="unit_cost" value="<?php echo isset($_GET['edit'])? $res['unit_cost']: '' ?>" class="form-control" required="required"></th>
							<th></th>
						</tr>
						<tr>
								<th>Fine Amount</th>
							<th><input type="text" name="fine_amount" id="fine_amount" value="<?php echo isset($_GET['edit'])? $res['fine_amount']: '' ?>" class="form-control" required="required"></th>
							
								<th>Paid Amount</th>
							<th><input type="text" name="paid_amount" id="paid_amount" value="<?php echo isset($_GET['edit'])? $res['paid_amount']: '' ?>" class="form-control" required="required"></th>
							<th></th>
						</tr>
						
					</table>
					<button type="submit" class="btn btn-primary " name="submit" value="">Submit </button>
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
							<th>Accession No.</th>
							<th>Name</th>
							<th>Department</th>
							<th>Designation</th>
							<th>Reason</th>
							<th>Item Type</th>
							<th>Unit Cost</th>
							<th>Fine Amount</th>
							<th>Paid Amount</th>
							<th>Edit </th>
							<th>Delete</th>
						</tr>
							<?php
								$sql = 'select * from lib_fine_impose';
								$result = mysqli_query($db, $sql);
								$i=1;
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['lib_loc'].'</td>
									<td>'.$row['l_card_no'].'</td>
									<td>'.$row['accession_no'].'</td>
									<td>'.$row['s_name'].'</td>
									<td>'.$row['department'].'</td>
									<td>'.$row['designation'].'</td>
									<td>'.$row['reason'].'</td>
									<td>'.$row['item_type'].'</td>
									<td>'.$row['unit_cost'].'</td>
									<td>'.$row['fine_amount'].'</td>
									<td>'.$row['paid_amount'].'</td>
									<td><a href="lib_fine_impose.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									<td><a href="lib_fine_impose.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
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
