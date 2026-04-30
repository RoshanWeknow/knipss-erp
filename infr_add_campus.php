<?php 
include("scripts/settings.php");


$msg='';
page_header_start();
page_header_end();
page_sidebar();
?>


<?php
	if(isset($_POST['campus_name'])){
		if(isset($_POST['edit']) && $_POST['edit'] != ''){
			$sql = 'update infr_add_campus set 
					campus_name="'.$_POST['campus_name'].'", 
					total_dimentions="'.$_POST['total_dimentions'].'", 
					const_dimentions="'.$_POST['const_dimentions'].'" ,
					discription="'.$_POST['discription'].'",
					edited_by="'.$_SESSION['username'].'",
					edition_time="'.date('Y-m-d H:m:s').'"
					where sno = '.$_POST['edit'];
			//echo $sql;
			execute_query($db, $sql);
			if(mysqli_errno($db)){
				echo "Updation failed".mysqli_errno($db).mysqli_error($db);
			}
			else{
				echo "Successfully updated";
			}
		}
		else{
			$sql = 'insert into infr_add_campus (campus_name, total_dimentions, const_dimentions, discription, created_by, creation_time ) 
					values("'.$_POST['campus_name'].'","'.$_POST['total_dimentions'].'","'.$_POST['const_dimentions'].'","'.$_POST['discription'].'","'.$_SESSION['username'].'","'.date('Y-m-d H:m:s').'")';
			//echo $sql;
			execute_query($db,$sql);
			if(mysqli_errno($db)){
				echo "Insertion failed".mysqli_errno($db).mysqli_error($db);
			}
			else{
				echo "Data inserted";
			}
		}
	}
	
		
	if(isset($_GET['del'])){
		$sql = 'delete from infr_add_campus where sno="'.$_GET['del'].'"';
		execute_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
		$sql = 'select * from infr_add_campus where sno = '.$_GET['edit'];
		$qry = execute_query($db, $sql);
		$res = mysqli_fetch_assoc($qry);
		
	}
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
</style>

<div id="container">
        <div class="card card-body">
            <div class="row d-flex my-auto">
                <form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"
                    enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
                    <div class="bg-primary text-white p-2"><h3> Add Campus</h3></div>
                    <div class="col-md-12">
                        <!-- first row -->
						<table width="100%" class="table table-striped table-hover rounded">
							<tr >
								
								
								<th width="15%">Campus Name</th>
								<th width="15%"><input type="text" name="campus_name" id="campus_name" value="<?php echo isset($_GET['edit'])? $res['campus_name']: '' ?>" class="form-control" required="required"></th>
								<th>Total Dimentions(Area in Sq.feet)</th>
								<th><input type="text" name="total_dimentions" id="total_dimentions" class="form-control" required="required" value="<?php echo isset($_GET['edit'])? $res['total_dimentions']: '' ?>"></th>
								<th> Construction Dimentions(Area in Sq.feet)</th>
								<th><input type="text" name="const_dimentions" id="const_dimentions" class="form-control" required="required" value="<?php echo isset($_GET['edit'])? $res['const_dimentions']: '' ?>"></th>
								
								
							</tr>
							<tr>
								<th>Discription</th>
								<th><textarea id="discription" name="discription" rows="4" cols="50" placeholder="Write Discription about the Building" class="form-control"  ><?php echo isset($_GET['edit'])? $res['discription']: '' ?></textarea></th>
							</tr>
							
							
						</table>
                       
                        <button type="submit" class="btn btn-primary " name="save" value="">Submit </button>
						<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
                    </div>
                </form>
            </div>
        </div>
		<div class="card card-body">
			<div class="bg-primary text-white p-2 mb-2"><h3> Infrastructure Report</h3></div>
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="text-white bg-primary" align="center">
					<th>Sno.</th>
					<th>Campus Name</th>
					<th>Total Dimentions  (sq.feet)</th>
					<th>Construction Dimentions (sq.feet)</th>
					<th>Discription</th>
					<th>Edit</th>					
					<th>Delete</th>
				</tr>
				<?php
					$sql = 'select * from infr_add_campus';
					$result = execute_query($db, $sql);
					$i=1;
					while($row = mysqli_fetch_assoc($result)){
						echo '<tr align="center">
						<td>'.$i++.'</td>
						<td>'.$row['campus_name'].'</td>
						<td>'.$row['total_dimentions'].'</td>
						<td>'.$row['const_dimentions'].'</td>
						<td>'.$row['discription'].'</td>
						<td><a href="infr_add_campus.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
						<td><a href="infr_add_campus.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
							</tr>'	;
					}
								?>
			</table>
		</div>
    </div>
<?php
page_footer_start();
page_footer_end();


?>	
	





























