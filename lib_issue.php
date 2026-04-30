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
        $sql = 'UPDATE lib_add_course set 
				institute_name="'.$_POST['institute_name'].'" ,
				library_name="'.$_POST['library_name'].'" , 
				department_name="'.$_POST['department_name'].'" ,  
				category="'.$_POST['category'].'" ,  
				c_name="'.$_POST['c_name'].'" ,  
				c_code="'.$_POST['c_code'].'" ,  
				duration="'.$_POST['duration'].'" ,  
				c_type="'.$_POST['c_type'].'" ,  
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
				$sql = 'INSERT INTO lib_issue(lib_name, l_card_no, accession, title, statement_of_rsp, name, department, valid_up_to, doi, class_type, dor, created_by, creation_time
					values("'.$_POST['lib_name'].'",
					"'.$_POST['l_card_no'].'",
					"'.$_POST['accession'].'",
					"'.$_POST['title'].'",
					"'.$_POST['statement_of_rsp'].'",
					"'.$_POST['name'].'",
					"'.$_POST['department'].'",
					"'.$_POST['valid_up_to'].'",
					"'.$_POST['doi'].'",
					"'.$_POST['class_type'].'",
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
		$sql = 'delete from lib_add_course where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from lib_add_course where sno = '.$_GET['edit'];
	$qry = mysqli_query($db, $sql);
	$res = mysqli_fetch_assoc($qry);
}
?>
<div id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"  enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
				<div class="bg-primary text-white p-2"><h3>Circulation Issue</h3></div>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr class="">
							<th>Library Name</th>
							<th><select class="form-control" name="lib_name" id="lib_name" class="form-control">
									<option value="">----Select----</option>
									<option value="KNIPSS(CENTRAL LIBRARY)">KNIPSS(CENTRAL LIBRARY)</option>
								</select></th>
							<th>Library Card No.</th>
							<th><input type="text" name="l_card_no" id="l_card_no" value="<?php echo isset($_GET['edit'])? $res['l_card_no']: '' ?>" class="form-control" required="required"></th>
							<th style="text-align:center;" width="20%" rowspan="2"> <img  src="#" alt="img" > </th>
							
						</tr>
						<tr>
							<th>Accession</th>
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
							<th>Name</th>
							<th><input type="text" name="name" id="name" value="<?php echo isset($_GET['edit'])? $res['name']: '' ?>" class="form-control" required="required"></th>
							
							<th>Department</th>
							<th><input type="text" name="department" id="department" value="<?php echo isset($_GET['edit'])? $res['department']: '' ?>" class="form-control" required="required"></th>
							<th></th>
						</tr>
						<tr>
							<th>Valid up to</th>
							<th><input type="text" name="valid_up_to" id="valid_up_to" value="<?php echo isset($_GET['edit'])? $res['valid_up_to']: '' ?>" class="form-control" required="required"></th>
							
							<th>Date Of Issue</th>
							<th><script  type="text/javascript" language="javascript">
									document.writeln(DateInput('doi', 'doi', true, 'YYYY-MM-DD', '<?php if(isset($_POST['doi'])){echo $_POST['doi'];}else{echo date("Y-m-d"); } ?>', 2));
								</script></th>
							<th></th>
						</tr>
						<tr>
							<th></th>
							<th><select class="form-control" name="class_type" id="class_type" class="form-control">
									<option value="">----Select----</option>
								</select></th>
							
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
							<th>Institute Name</th>
							<th>Library Name</th>
							<th>Department Name</th>
							<th>Category</th>
							<th>Course Name</th>
							<th>Course Code</th>
							<th>Duration in year</th>
							<th>Course Type</th>
							<th>Edit </th>
							<th>Delete</th>
						</tr>
							<?php
								$sql = 'select * from lib_add_course';
								$result = mysqli_query($db, $sql);
								$i=1;
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['institute_name'].'</td>
									<td>'.$row['library_name'].'</td>
									<td>'.$row['department_name'].'</td>
									<td>'.$row['category'].'</td>
									<td>'.$row['c_name'].'</td>
									<td>'.$row['c_code'].'</td>
									<td>'.$row['duration'].'</td>
									<td>'.$row['c_type'].'</td>
									<td><a href="lib_add_course.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									<td><a href="lib_add_course.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
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
