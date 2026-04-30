<?php 
include("scripts/settings.php");
include("scripts/image_upload.php");

page_header_start();
$response=1;
$msg='';


page_header_end();
page_sidebar();
?>
<?php 



if(isset($_POST['company_type']) && $_POST['company_type'] != ''){
	$target_dir = "leave_images/".date('Y')."/".date('m')."/";
	if(!is_dir($target_dir)){
		mkdir($target_dir);
	}
	if(isset($_POST['edit']) && $_POST['edit']!= ''){
		if(isset($_FILES['attach_file']) && $_FILES['attach_file']['name'] != ''){
			$sql = 'update mou_management set 
				company_type="' . $_POST['company_type'] . '",
				company_name="' . $_POST['company_name'] . '",
				file_date="' . $_POST['file_date'] . '",
				description="' . $_POST['description'] . '",
				edited_by="' . $_SESSION['username'] . '",
				edition_time="' . date("Y-m-d H:i:s") . '"
				where sno=' . $_POST['edit'];
			$file_details = upload_img($_FILES['attach_file'],$target_dir,$_POST['edit']);
			$msg .= $file_details['msg'];
			$sql = 'update mou_management set attach_file="'. $file_details['file_name'].'" where sno = '.$_POST['edit'];
			if(execute_query($db, $sql)){
				echo "<li> image Updated successfully</li>";
			}
			else{
				echo "<li> image updation failed</li>";
			}
			
		}
		else{
			$sql = 'update mou_management set 
				company_type="' . $_POST['company_type'] . '",
				company_name="' . $_POST['company_name'] . '",
				file_date="' . $_POST['file_date'] . '",
				description="' . $_POST['description'] . '",
				edited_by="' . $_SESSION['username'] . '",
				edition_time="' . date("Y-m-d H:i:s") . '"
				where sno=' . $_POST['edit'];
		}
		execute_query($db, $sql);
		if(mysqli_errno($db)){
			$msg .= '<li>Updation Failed</li>' ;
		}
		else{
			$msg .= '<li>Data Updated</li>' ;
		}
	}
	else{
		$sql = 'insert into mou_management(company_type,company_name,file_date,description,created_by, creation_time) values("'.
		$_POST['company_type'].'", "'.
		$_POST['company_name'].'", "'.
		$_POST['file_date'].'", "'.
		$_POST['description'].'", "'.
		$_SESSION['username'].'", "'.
		date("Y-m-d H:i:s").
		'")';
		
		execute_query($db, $sql);
		if(mysqli_errno($db)){
			$msg .= '<li>Insertion Failed</li>' ;
		}
		else{
			$msg .= '<li>Data Inserted</li>' ;
		}
		$last_data_sno = mysqli_insert_id($db);
		$file_details = upload_img($_FILES['attach_file'],$target_dir,$last_data_sno);
		$msg .= $file_details['msg'];
		$sql = 'update mou_management set attach_file="'. $file_details['file_name'].'" where sno = '.$last_data_sno;
		if(execute_query($db, $sql)){
			echo "<li> image uploaded successfully</li>";
		}
		else{
			echo "<li> image upload failed</li>";
		}

	}
}

if (isset($_GET['edit'])) {
	$sql = 'select * from mou_management where sno=' . $_GET['edit'];
	$data = mysqli_fetch_assoc(execute_query($db,$sql));
}

if(isset($_GET['del']) and $_GET['del']!='') {
		$sql = 'delete from mou_management where sno=' . $_GET['del'];
		$data = execute_query($db, $sql);
		if(mysqli_errno($db)){
			$msg .= '<h6 class="alert alert-danger">Deletion Failed.</h6>';
		}
		else{
			$msg .= '<h6 class="alert alert-danger">Data deleted.</h6>';			
		}
		$_GET['del'] = '';
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
				<form action="" class="wufoo leftLabel page1" name="" enctype="multipart/form-data" method="POST" onSubmit=""  >
					<div class="bg-primary text-white p-2"><h3>MOU Management</h3></div>
						<div class="col-md-12" >
						
							<table width="100%" class="table table-striped  table-hover rounded">
								<tr >
									<th>Company Type</th>
									<th>
										<select name="company_type" id="comapny_type" value="<?php echo isset($_GET['edit'])?$data['comapny_type']:""?>" class="form-control" required>
										  <option value="Software Development Companies">Software Development Companies</option>
										  <option value="Hardware Manufacturing Companies">Hardware Manufacturing Companies</option>
										  <option value="Networking and Telecommunications Companies">Networking and Telecommunications Companies</option>
										  <option value="IT Consulting Firms">IT Consulting Firms</option>
										  <option value="Cloud Computing and Hosting Providers">Cloud Computing and Hosting Providers</option>
										  <option value="Data Analytics and Business Intelligence Companies">Data Analytics and Business Intelligence Companies</option>
										  <option value="Cybersecurity Companies">Cybersecurity Companies</option>
										  <option value="Web Development and Design Agencies">Web Development and Design Agencies</option>
										  <option value="IT Services and Outsourcing Providers">IT Services and Outsourcing Providers</option>
										  <option value="E-commerce and Online Retail Companies">E-commerce and Online Retail Companies</option>
										  <option value="Artificial Intelligence and Machine Learning Companies">Artificial Intelligence and Machine Learning Companies</option>
										  <option value="Mobile App Development Companies">Mobile App Development Companies</option>
										  <option value="System Integration Providers">System Integration Providers</option>
										  <option value="IT Education and Training Companies">IT Education and Training Companies</option>
										  <option value="IT Research and Development Organizations">IT Research and Development Organizations</option>
										</select>

									</th>
									<th>Company Name</th>
									<th><input type="text" name="company_name" id="company_name" value="<?php echo isset($_GET['edit'])?$data['company_name']:""?>" class="form-control"></th>
									<th>Attach File</th>
									<th><input type="file" name="attach_file" id="attach_file" value="<?php echo isset($_GET['edit'])?$data['attach_file']:""?>"  class="form-control"></th>
								</tr>
								<tr>
									<th>Attach file Date</th>
									<th><script type="text/javascript" language="javascript" >
											<?php
												$date = isset($_GET['edit'])? $result['file_date']: date('Y-m-d');
												echo "document.writeln(DateInput('file_date', 'user_form', true, 'YYYY-MM-DD','$date', 1));"
											?>
										</script></th>
									<th>Description</th>
									<th><textarea type="text" id="description" name="description" value="<?php echo isset($_GET['edit'])?$data['description']:""?>" class="form-control"></textarea></th>
								</tr>
								
							</table>
							<button type="submit" class="btn btn-primary " name="save" value="">Submit </button>
							<input type = "hidden" name = "edit" value="<?php echo isset($_GET['edit'])? $_GET['edit']: ""?>">		
								
						</div>
				</form>	
			</div>
		</div>
		<div class="card card-body">
			<table  class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white ">
					<td>S.No.</td>
					<td>Company Type</td>
					<td>Company Name</td>
					<td>File Attach</td>
					<td>File Date</td>
					<td>Description</td>					
					<td>Edit</td>
					<td>Delete</td>
					
				</tr>
				<?php
					$serial_no = 1;
					$sql = 'select * from mou_management';
					$res = execute_query($db, $sql);
					if($res){
						while($row = mysqli_fetch_assoc($res)){

				?>
				<tr>
					<td><?php echo $serial_no++ ?></td>
					<td><?php echo $row['company_type'] ?></td>
					<td><?php echo $row['company_name'] ?></td>
					<td><a href= "<?php echo "leave_images/".date('Y')."/".date('m')."/".$row['attach_file'] ?>" target = "_blank"><?php echo $row['attach_file'] ?></a></td>
					<td><?php echo $row['file_date'] ?></td>					
					<td><?php echo $row['description'] ?></td>	
					
					<td class="text-center ">
						<a href="<?php echo $_SERVER['PHP_SELF'] . '?edit=' . $row['sno']; ?>" alt="Edit" data-toggle="tooltip" title="Edit"><span class="far fa-edit" aria-hidden="true"></span></a></td>
					<td>
						<a href="<?php echo $_SERVER['PHP_SELF'] . '?del=' . $row['sno']; ?>" onclick="return confirm('Are you sure?');" style="color:#f00" alt="Delete"><span class="far fa-trash-alt" aria-hidden="true" data-toggle="tooltip" title="Delete"></span></a>
					</td>

				</tr>
				
				<?php 
					}
						
				}
				
				?>
			</table>	
		</div>
	</div>



<?php 
page_footer_start(); 
page_footer_end(); 

?>




































<?php 
page_footer_start(); 
page_footer_end(); 

?>