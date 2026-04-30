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
        $sql = 'UPDATE lib_library_fee_master set 
				library_name="'.$_POST['library_name'].'" , 
				m_catagory="'.$_POST['m_catagory'].'" ,  
				l_security="'.$_POST['l_security'].'" ,  
				l_annual_fee="'.$_POST['l_annual_fee'].'" ,  
				date_e_form="'.$_POST['date_e_form'].'" ,
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
				$sql = 'INSERT INTO lib_library_fee_master(library_name, m_catagory, l_security, l_annual_fee, date_e_form, created_by, created_date) 
					values("'.$_POST['library_name'].'",
					"'.$_POST['m_catagory'].'",
					"'.$_POST['l_security'].'",
					"'.$_POST['l_annual_fee'].'",
					"'.$_POST['date_e_form'].'",
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
		$sql = 'delete from lib_library_fee_master where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from lib_library_fee_master where sno = '.$_GET['edit'];
	$qry = mysqli_query($db, $sql);
	$res = mysqli_fetch_assoc($qry);
}
?>
<div id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"  enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
				<div class="bg-primary text-white p-2"><h3>Library Fee Master</h3></div>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr>
							<th>Library Name</th>	
							<th><select class="form-control" name="library_name" id="library_name" class="form-control">
									<option value="">----Select----</option>
									<option value="KNIPSS(CENTRAL LIBRARY)"<?php echo (isset($_GET['edit']) && $res['institute_name']=='KNIPSS(CENTRAL LIBRARY)') ?' selected="selected"':''  ?>>KNIPSS(CENTRAL LIBRARY)</option>
								</select>
							</th>
								
							<th>Member Catagory</th>	
							<th><select class="form-control" name="m_catagory" id="m_catagory" class="form-control">
									<option value="">----Select----</option>
									<option value="KNIPSS(CENTRAL LIBRARY)"<?php echo (isset($_GET['edit']) && $res['institute_name']=='KNIPSS(CENTRAL LIBRARY)') ?' selected="selected"':''  ?>>KNIPSS(CENTRAL LIBRARY)</option>
								</select>
							</th>
							
							<th>Library Security</th>
							<th><input type="text" name="l_security" id="l_security" value="<?php echo isset($_GET['edit'])? $res['l_security']: '' ?>" class="form-control" required="required">
							</th>
							
						</tr>
						<tr>
							<th>Library Annual Fee</th>
							<th><input type="text" name="l_annual_fee" id="l_annual_fee" value="<?php echo isset($_GET['edit'])? $res['l_annual_fee']: '' ?>" class="form-control" required="required"></th>
							
							<th>Date Effective Form</th>
							<th><script  type="text/javascript" language="javascript">
									document.writeln(DateInput('date_e_form', 'date_e_form', true, 'YYYY-MM-DD', '<?php if(isset($_POST['date_e_form'])){echo $_POST['date_e_form'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
							</th>
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
							<th>Library Name</th>
							<th>Member Catagory</th>
							<th>Library Security</th>
							<th>Library Annual Fee</th>
							<th>Date Effective Form</th>
							<th>Edit </th>
							<th>Delete</th>
						</tr>
							<?php
								$sql = 'select * from lib_library_fee_master';
								$result = mysqli_query($db, $sql);
								$i=1;
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['library_name'].'</td>
									<td>'.$row['m_catagory'].'</td>
									<td>'.$row['l_security'].'</td>
									<td>'.$row['l_annual_fee'].'</td>
									<td>'.$row['date_e_form'].'</td>
									<td><a href="lib_library_fee_master.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									<td><a href="lib_library_fee_master.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
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