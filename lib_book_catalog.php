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
				accession_no="'.$_POST['accession_no'].'" ,
				lib_loc="'.$_POST['lib_loc'].'" , 
				class_type="'.$_POST['class_type'].'" , 
				accession_no_s="'.$_POST['accession_no_s'].'" ,  
				edited_by="'.$_SESSION['username'].'",
				edition_time="'.date("d-m-y H:i:s").'"
				 where sno = '.$_POST['edit'];
			 echo $sql;		 
				mysqli_query($db, $sql);
				if(mysqli_errno($db)){
					echo "Updation failed: ".mysqli_errno($db).mysqli_error($db);
				}
				else{
					echo "Successfully updated";
				}
			}
		else{
				$sql = 'INSERT INTO lib_book_catalog(accession_no, lib_loc, class_type, accession_no_s, created_by, creation_time) 
					values("'.$_POST['accession_no'].'",
					"'.$_POST['lib_loc'].'",
					"'.$_POST['class_type'].'",
					"'.$_POST['accession_no_s'].'",
					"'.$_SESSION['username'].'",
					"'.date("d-m-y H:i:s").'")';
			echo $sql;

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
				<div class="bg-primary text-white p-2"><h3>Catalog Printing (book)</h3></div>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr class="">
							<th width="20%">Accession No.</th>
							<th width="20%"> <div class="input-group">
								<input type="text" name="accession_no" id="accession_no" value="<?php echo isset($_GET['edit'])? $res['accession_no']: '' ?>" class="form-control" required="required">
								<div class="input-group-append">
								  <button class="btn btn-primary" type="button">
									<i class="fa fa-search"></i>
								  </button>
								</div>
							  </div></th>
							  <th><select class="form-control" name="lib_loc" id="lib_loc" class="form-control">
									<option value="">----Select----</option>
									<option value="KNIPSS(CENTRAL LIBRARY)"<?php echo (isset($_GET['edit']) && $res['lib_loc']=='KNIPSS(CENTRAL LIBRARY)') ?' selected="selected"':''  ?>>KNIPSS(CENTRAL LIBRARY)</option>
								</select></th>
								<th></th>
							
							
						</tr>
						<tr>
						<th width="20%">Title</th>
							<th width="20%"></th>
						<th width="20%">Option</th>
							<th width="20%"><select class="form-control" name="class_type" id="class_type" class="form-control">
									<option value="">----Select----</option>
									<option value="KNIPSS(CENTRAL LIBRARY)"<?php echo (isset($_GET['edit']) && $res['class_type']=='KNIPSS(CENTRAL LIBRARY)') ?' selected="selected"':''  ?>>KNIPSS(CENTRAL LIBRARY)</option>
								</select></th>
							<th></th>
						</tr>
						<tr>
							<th width="20%">Accession No.(s)</th>
							<th width="20%"><textarea type="text" name="accession_no_s" id="accession_no_s" value="" class="form-control" required="required"><?php echo isset($_GET['edit'])? $res['accession_no_s']: '' ?></textarea></th>
						</tr>
							
					</table>
					
					<button type="submit" class="btn btn-primary " name="submit" value="">Print Catalog</button>
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
							<th>Option</th>
							<th>Accession No.(s)</th>
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
									<td>'.$row['accession_no'].'</td>
									<td>'.$row['lib_loc'].'</td>
									<td>'.$row['class_type'].'</td>
									<td>'.$row['accession_no_s'].'</td>
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
