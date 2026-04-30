<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$msg='';
 if(isset($_POST['submit'])) {
	 
	if($_POST['staff_department']=='') {
		$msg .='<li>Please Enter Staff Department</li>';		
	}
	if($_POST['sno']!='')
		{
			$sql = 'update staff_department set department="'.$_POST['staff_department'].'"  where sno='.$_POST['sno'];
			execute_query(connect(), $sql);
			$msg .= '<li>Update sucessful.</li>';
		}	
	else {
		$sql = 'insert into staff_department(department)
		        value("'.$_POST['staff_department'].'")';
		execute_query(connect(), $sql);
		$msg = '<li>Staff Department Added</li>'; 
	}
 }

if(isset($_GET['id'])){
	$sql = 'select * from staff_department where sno='.$_GET['id'];
	$row=mysqli_fetch_array(execute_query(connect(), $sql));
}
if(isset($_GET['del'])){
	$sql = 'delete from staff_department where sno='.$_GET['del'];
	execute_query(connect(), $sql);
}
page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
	<div class="row">
		<div class="col-md-12">
			
			<form action="add_staff_department.php" class="wufoo leftLabel page1" name="add_staff_department" enctype="multipart/form-data" method="post" onSubmit="" >

				<?php
				if(isset($_POST['submit']) && msg!='') {
					echo $msg;
					$msg='';
				}
				?>
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-4"><h3 style="border-bottom:none;">Add Staff Department</h3></br></div>
								<div class="col-sm-6"></div>
								<div class="col-sm-2">
							</div>
							</div>
						<div class="row">
							<div class="col-md-3">      	
									<label  class="desc"  for="name">Staff Department <span class="name">*</label>
									<div id="supplier_id" class="notranslate"> </div>
									<input type="text" name="staff_department" id="staff_department" class="form-control" value="<?php if(isset($_GET['id'])){echo $row['department'];}?>" onKeyUp="formvalidation(this.value,'varchar',45,'class_desc')"/> </br>
									<div id="supplier_id" class="notranslate"> </div> 
									<input type="hidden" name="sno" value="<?php if(isset($_GET['id'])){echo $_GET['id'];}?>" />
									<input type="submit" " class="btn btn-primary" submit" name="submit" value="Submit" onClick="return confirmSubmit()"/>
								</div>
						</div>
					</div>
				</div>
			</form>
		
			<div class="card">
				<div class="card-body">			
					<table width="100%" class="table table-striped table-hover rounded">
						<tr  class="table-primary ">
							<th>S.No.</th>
							<th>Department</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
						<?php
							$sql = 'select * from staff_department';
							$result=execute_query(connect(), $sql);
							$i=1;
							while($row=mysqli_fetch_array($result)){
								if($i%2==0){
									$col = '#CCC';
								}
								else{
									$col = '#EEE';
								}
								echo '<tr style="background:'.$col.'">
								<td>'.$i++.'</td>
								<td>'.$row['department'].'</td>
								<td><a href="add_staff_department.php?id='.$row['sno'].'">Edit</a></td>
								<td><a href="add_staff_department.php?del='.$row['sno'].'" onclick="return confirm(\'Are you sure?\');">Delete</a></td>
								</tr>';
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
</body>