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
        $sql = 'UPDATE lib_book_catalog set 
				lib_loc="'.$_POST['lib_loc'].'" ,
				l_card_no="'.$_POST['l_card_no'].'" , 
				accession_no="'.$_POST['accession_no'].'" , 
				title="'.$_POST['title'].'" ,  
				department="'.$_POST['department'].'" ,  
				s_name="'.$_POST['s_name'].'" ,  
				reason="'.$_POST['reason'].'" ,  
				due_date="'.$_POST['due_date'].'" ,  
				issue_date="'.$_POST['issue_date'].'" ,  
				fine="'.$_POST['fine'].'" ,  
				return_date="'.$_POST['return_date'].'" ,  
				paid_ammount="'.$_POST['paid_ammount'].'" ,  
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
				$sql = 'INSERT INTO lib_book_catalog(lib_loc, l_card_no, accession_no, title, department, s_name, reason, due_date, issue_date, fine, return_date, paid_ammount, created_by, creation_time) 
					values("'.$_POST['lib_loc'].'",
					"'.$_POST['l_card_no'].'",
					"'.$_POST['accession_no'].'",
					"'.$_POST['title'].'",
					"'.$_POST['department'].'",
					"'.$_POST['s_name'].'",
					"'.$_POST['reason'].'",
					"'.$_POST['due_date'].'",
					"'.$_POST['issue_date'].'",
					"'.$_POST['fine'].'",
					"'.$_POST['return_date'].'",
					"'.$_POST['paid_ammount'].'",
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
		$sql = 'delete from lib_book_catalog where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from lib_book_catalog where sno = '.$_GET['edit'];
	$qry = mysqli_query($db, $sql);
	$res = mysqli_fetch_assoc($qry);
}
?>

<div id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"  enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
				<div class="bg-primary text-white p-2"><h3>Return</h3></div>
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
							<th>Title</th>
							<th><input type="text" name="title" id="title" value="<?php echo isset($_GET['edit'])? $res['title']: '' ?>" class="form-control" required="required"></th>
							
							<th>Department</th>
							<th><input type="text" name="department" id="department" value="<?php echo isset($_GET['edit'])? $res['department']: '' ?>" class="form-control" required="required"></th>
							<th></th>
						</tr>
						<tr>
							<th>Name</th>
							<th><input type="text" name="s_name" id="s_name" value="<?php echo isset($_GET['edit'])? $res['s_name']: '' ?>" class="form-control" required="required"></th>
							
							<th>Reason</th>
							<th><input type="text" name="reason" id="reason" value="<?php echo isset($_GET['edit'])? $res['reason']: '' ?>" class="form-control" required="required"></th>
							<th></th>
						</tr>
						<tr>
							<th></th>
							<th><input type="text" name="" id="" value="<?php echo isset($_GET['edit'])? $res['']: '' ?>" class="form-control" required="required"></th>
							
							<th>Due Date</th>
							<th><script  type="text/javascript" language="javascript">
									document.writeln(DateInput('due_date', 'due_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['due_date'])){echo $_POST['due_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script></th>
						</tr>
						<tr>
							
							
							<th>Date Of Issue</th>
							<th><script  type="text/javascript" language="javascript">
									document.writeln(DateInput('issue_date', 'issue_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['issue_date'])){echo $_POST['issue_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script></th>
								<th>Fine Amount</th>
							<th><input type="text" name="fine" id="fine" value="<?php echo isset($_GET['edit'])? $res['fine']: '' ?>" class="form-control" required="required"></th>
							<th></th>
						</tr>
						<tr>
							
							
							<th>Date of Return</th>
							<th><script  type="text/javascript" language="javascript">
									document.writeln(DateInput('return_date', 'return_date', true, 'YYYY-MM-DD', '<?php if(isset(return_date)){echo $_POST['return_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script></th>
								<th>Paid Amount</th>
							<th><input type="text" name="paid_ammount" id="paid_ammount" value="<?php echo isset($_GET['edit'])? $res['paid_ammount']: '' ?>" class="form-control" required="required"></th>
							<th></th>
						</tr>
					</table>
					<button type="submit" class="btn btn-primary " name="save" value="">Submit</button>
					<button type="submit" class="btn btn-success " name="save" value="reset">Reset</button>
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
							<th>Title</th>
							<th>Department</th>
							<th>Name</th>
							<th>Reason</th>
							<th>Due Date</th>
							<th>Date Of Issue</th>
							<th>Fine Amount</th>
							<th>Date of Return</th>
							<th>Paid Amount</th>
							<th>Edit </th>
							<th>Delete</th>
						</tr>
							<?php
								$sql = 'select * from lib_book_catalog';
								$result = mysqli_query($db, $sql);
								$i=1;
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['lib_loc'].'</td>
									<td>'.$row['l_card_no'].'</td>
									<td>'.$row['accession_no'].'</td>
									<td>'.$row['title'].'</td>
									<td>'.$row['department'].'</td>
									<td>'.$row['s_name'].'</td>
									<td>'.$row['reason'].'</td>
									<td>'.$row['due_date'].'</td>
									<td>'.$row['issue_date'].'</td>
									<td>'.$row['fine'].'</td>
									<td>'.$row['return_date'].'</td>
									<td>'.$row['paid_ammount'].'</td>
									<td><a href="lib_book_catalog.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									<td><a href="lib_book_catalog.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
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
