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
        $sql = 'UPDATE lib_reissue set 
				lib_name="'.$_POST['lib_name'].'" ,
				l_card_no="'.$_POST['l_card_no'].'" , 
				accession="'.$_POST['accession'].'" ,  
				title="'.$_POST['title'].'" ,  
				statement_of_rsp="'.$_POST['statement_of_rsp'].'" ,  
				volume_no="'.$_POST['volume_no'].'" ,  
				issue_no="'.$_POST['issue_no'].'" ,  
				s_name="'.$_POST['s_name'].'" ,  
				department="'.$_POST['department'].'" ,  
				issue_date="'.$_POST['issue_date'].'" ,  
				valid_date="'.$_POST['valid_date'].'" ,  
				dor="'.$_POST['dor'].'" ,  
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
				$sql = 'INSERT INTO lib_reissue(lib_name, l_card_no, accession, title, statement_of_rsp, volume_no, issue_no, s_name, department, issue_date, valid_date, dor, created_by, creation_time)
					values("'.$_POST['lib_name'].'",
					"'.$_POST['l_card_no'].'",
					"'.$_POST['accession'].'",
					"'.$_POST['title'].'",
					"'.$_POST['statement_of_rsp'].'",
					"'.$_POST['volume_no'].'",
					"'.$_POST['issue_no'].'",
					"'.$_POST['s_name'].'",
					"'.$_POST['department'].'",
					"'.$_POST['issue_date'].'",
					"'.$_POST['valid_date'].'",
					"'.$_POST['dor'].'",
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
		$sql = 'delete from lib_reissue where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from lib_reissue where sno = '.$_GET['edit'];
	$qry = mysqli_query($db, $sql);
	$res = mysqli_fetch_assoc($qry);
}
?>

<div id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"  enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
				<div class="bg-primary text-white p-2"><h3>Re-Issue</h3></div>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr class="">
							<th>Location</th>
							<th><select class="form-control" name="lib_name" id="lib_name" class="form-control">
									<option value="">----Select----</option>
									<option value="KNIPSS(CENTRAL LIBRARY)"<?php echo (isset($_GET['edit']) && $res['lib_loc']=='KNIPSS(CENTRAL LIBRARY)') ?' selected="selected"':''  ?>>KNIPSS(CENTRAL LIBRARY)</option>
								</select></th>
							<th>Library Card No.</th>
							<th><input type="text" name="l_card_no" id="l_card_no" value="<?php echo isset($_GET['edit'])? $res['l_card_no']: '' ?>" class="form-control" required="required"></th>
							<th style="text-align:center;" width="20%" rowspan="2"> <img  src="#" alt="img" > </th>
							
						</tr>
						<tr>
							<th>Accession No.</th>
							<th><input type="text" name="accession" id="accession" value="<?php echo isset($_GET['edit'])? $res['accession']: '' ?>" class="form-control" required="required"></th>
							
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
							<th>Title</th>
							<th><input type="text" name="title" id="title" value="<?php echo isset($_GET['edit'])? $res['title']: '' ?>" class="form-control" required="required"></th>
							
							<th>Statement of Rsp</th>
							<th><input type="text" name="statement_of_rsp" id="statement_of_rsp" value="<?php echo isset($_GET['edit'])? $res['statement_of_rsp']: '' ?>" class="form-control" required="required"></th>
							<th></th>
						</tr>
						<tr>
							<th>Volume No.</th>
							<th><input type="text" name="volume_no" id="volume_no" value="<?php echo isset($_GET['edit'])? $res['volume_no']: '' ?>" class="form-control" required="required"></th>
							
							<th>Issue No.</th>
							<th><input type="text" name="issue_no" id="issue_no" value="<?php echo isset($_GET['edit'])? $res['issue_no']: '' ?>" class="form-control" required="required"></th>
							<th></th>
						</tr>
						<tr>
							<th>Name</th>
							<th><input type="text" name="s_name" id="s_name" value="<?php echo isset($_GET['edit'])? $res['s_name']: '' ?>" class="form-control" required="required"></th>
							
							<th>Department</th>
							<th><input type="text" name="department" id="department_code" value="<?php echo isset($_GET['edit'])? $res['department_code']: '' ?>" class="form-control" required="required"></th>
							<th></th>
						</tr>
						<tr>
							<th></th>
							
							<th>Date Of Issue</th>
							<th><script  type="text/javascript" language="javascript">
									document.writeln(DateInput('issue_date', 'issue_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['issue_date'])){echo $_POST['issue_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script></th>
							<th></th>
						</tr>
						<tr>
							<th>Valid up to</th>
							<th><input type="text" name="valid_date" id="valid_date" value="<?php echo isset($_GET['edit'])? $res['valid_date']: '' ?>" class="form-control" required="required"></th>
							
							<th>Date of Return</th>
							<th><script  type="text/javascript" language="javascript">
									document.writeln(DateInput('dor', 'dor', true, 'YYYY-MM-DD', '<?php if(isset($_POST['dor'])){echo $_POST['dor'];}else{echo date("Y-m-d"); } ?>', 2));
								</script></th>
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
							<th>Location</th>
							<th>Library Card No.</th>
							<th>Accession No.</th>
							<th>Title</th>
							<th>Statement of Rsp</th>
							<th>Volume No</th>
							<th>Issue No.</th>
							<th>Name</th>
							<th>Department</th>
							<th>Date Of Issue</th>
							<th>Valid up to</th>
							<th>Date of Return</th>
							<th>Edit </th>
							<th>Delete</th>
						</tr>
							<?php
								$sql = 'select * from lib_reissue';
								$result = mysqli_query($db, $sql);
								$i=1;
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['lib_name'].'</td>
									<td>'.$row['l_card_no'].'</td>
									<td>'.$row['accession'].'</td>
									<td>'.$row['title'].'</td>
									<td>'.$row['statement_of_rsp'].'</td>
									<td>'.$row['volume_no'].'</td>
									<td>'.$row['issue_no'].'</td>
									<td>'.$row['s_name'].'</td>
									<td>'.$row['department'].'</td>
									<td>'.$row['issue_date'].'</td>
									<td>'.$row['valid_date'].'</td>
									<td>'.$row['dor'].'</td>
									<td><a href="lib_reissue.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									<td><a href="lib_reissue.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
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
