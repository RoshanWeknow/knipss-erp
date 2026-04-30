<?php 
include("scripts/settings.php");
$msg = '';
$data_exist = 0;
$allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
if(isset($_POST['submit']) && $_POST['submit'] != ''){
		$check_data_sql = 'Select * from exam_crasslist_pdf_store where class_details_sno = "'.$_POST['course'].'"';
		$check_data_res = mysqli_query($db, $check_data_sql);
		if(mysqli_num_rows($check_data_res)>0){
			 $msg .= '<h6 class="alert  alert-danger">PDF already uploded for this course. Please go for edit.</h6>' ;
			 $data_exist = 1;
		}	
	// if(isset($_GET['edit_id'])){
		// $data_exist = 0;
	// }	
	if($data_exist == 0){
    $errors = [];
    $fileName=$_FILES["u_file"]["name"];
    $fileTmpName=$_FILES["u_file"]["tmp_name"];
    $fileSize=$_FILES["u_file"]['size'];
    $newFileName=$fileName;
    
    // if ($_FILES["u_file"]["size"] > 5 * 1024 * 1024) {
        // $errors[] = "File is too large. Maximum file size allowed is 5MB.";
    // }

    // Allowed file extensions
    
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Check if the file extension is allowed
    if (!in_array($fileExtension, $allowedExtensions)) {
        $errors[] = "Only JPG, JPEG, PNG, and PDF files are allowed.";
    }
    
    if (empty($errors)) {

        // $check="SELECT * FROM exam_copy_view WHERE file_upload_status='1' and sno='{$_POST['sno']}'";
        // $rescheck=mysqli_query($db,$check);
        // if(mysqli_num_rows($rescheck)>0){
        //     $rowcheck=mysqli_fetch_assoc($rescheck);
        //     if (file_exists($rowcheck['file_path'])) {
        //         if (unlink($rowcheck['file_path'])) {
        //             $msg .= '<h6 class="alert  alert-danger">file deleted done.</h6>';
        //         }else{
        //             $msg .= '<h6 class="alert  alert-primary">Could not find the file.</h6> ';
        //         }
        //     }
        // }

        // Set the upload directory
        $uploadDir = "crasslist_pdf";

        // Create the upload directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadPath="crasslist_pdf/".$_POST['course']."_crasslist.".$fileExtension;
        if(mysqli_errno($db)){
            $msg .= '<h6 class="alert  alert-danger">Insertion Failed.</h6>' ;
        }
        else{
            //$msg .= '<h6 class="alert  alert-success">Data Inserted.</h6>' ;
            if(move_uploaded_file($fileTmpName,$uploadPath)){
				if(isset($_GET['edit_id'])){
					$sql2 = 'UPDATE `exam_crasslist_pdf_store` SET `exam_semester`="'.$_POST['sem_name'].'",`exam_year`="'.$_POST['exam_year'].'",`class_details_sno`="'.$_POST['course'].'",`pdf_path`="'.$uploadPath.'",`edited_by`="'.$_SESSION['username'].'",`edition_time`="'.date('d-m-Y:H:i:s').'" WHERE sno = "'.$_GET['edit_id'].'"';
					execute_query($db, $sql2);
					$msg .='<p class="alert alert-success">File Updated  Successfully </p>';
				}
               $sql2 = 'INSERT INTO `exam_crasslist_pdf_store`(`exam_semester`, `exam_year`, `class_details_sno`, `pdf_path`, `created_by`, `creation_time`) VALUES ("'.$_POST['sem_name'].'","'.$_POST['exam_year'].'","'.$_POST['course'].'","'.$uploadPath.'","'.$_SESSION['username'].'","'.date('d-m-Y:H:i:s').'")';
                execute_query($db, $sql2);
                $msg .='<p class="alert alert-success">File Upload  Successfully </p>';   
                }      
        }
    }else{
        $msg .= '<h6 class="alert  alert-danger">Due to Some Error Insertion Failed.</h6>' ;
    }
}
}
page_header_start();
page_header_end();
page_sidebar();
?>
	<div class="bg-white p-4">
		<?php echo $msg; ?>
		<div class="header  bg-primary text-white p-1 " style="border-radius:10px;">
			<h3>Upload Answer Sheet</h3>
		</div>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" class="mx-3" method="POST" enctype="multipart/form-data">
			<div class="row" style="background-color:#fff;">
				<div class="col-md-3">
					<div class="form-group">
						<label for="">Exam Semester</label>
						<select name="sem_name"class="form-control" required>
							<option selected disabled >---Select Semester--</option>
							 <?php
								$sem=1;
								for ($sem; $sem <= 8; $sem++) {
									echo "<option value='$sem'>$sem Semester</option>";
								}
							?>
						</select>
					</div>
				</div>
				<?php
					$currentYear = date('Y');
					$startYear = $currentYear - 10; // Adjust this as needed
					$endYear = $currentYear + 4; // Adjust this as needed
				?>
				<div class="col-md-3">
					<div class="form-group">
						<label for="">Year</label>
						<select name="exam_year"class="form-control" required>
							<option selected disabled >---Select Year--</option>
							 <?php
								for ($year = $endYear; $year >= $startYear; $year--) {
									$nextYear = $year + 1;
									echo "<option value='$year-$nextYear'>$year-$nextYear</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<label>Course</label>
					<select name="course" id="course" value="" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
						<option disabled selected>---Select Course---</option>
						<?php 
						$sql  = 'select distinct(course_name),class_detail.class_description from exam_student_info LEFT JOIN class_detail on exam_student_info.course_name = class_detail.sno ORDER BY class_detail.class_description';
						echo $sql;
						$dept_list = execute_query($db,$sql);
						if($dept_list){
							while($list = mysqli_fetch_assoc($dept_list)){
								echo '<option  value = "'.$list['course_name'].'">'.$list['class_description'].'</option>';
							}
						}
						?>
					</select>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="">Upload Crasslist</label>
						<input type="file" name="u_file" class="form-control" id="" required>
					</div>
				</div>
			</div>
			</br>
				<button type="submit" class="btn btn-primary" id="" name="submit" Value="Submit" >Submit</button>	
		</form>
	</div>
	<div class="card-body">
		<table class="table table-striped table-hover" id="general_stat_table">
			<thead>
				<tr class="bg-primary text-white">
					<td scope="col">Sno</td>
					<td scope="col">Semester</td>
					<td scope="col">Exam Year</td>
					<td scope="col">Class</td>
					<td scope="col">Crasslist PDF</td>
					<td scope="col">Upload Date</td>
				</tr>
			</thead>
			<?php
				$query = 'SELECT * FROM exam_crasslist_pdf_store';
				$result =execute_query($db,$query);
				$i=1;
				while($row=mysqli_fetch_assoc($result)){
						$sql_class = 'select * from class_detail WHERE sno="'.$row['class_details_sno'].'"';
						$result_class = mysqli_query($db,$sql_class); 
						$row_class = mysqli_fetch_assoc($result_class)
			?>
			<tr>
				<td><?php echo $i++;?></td>
				<td><?php echo $row['exam_semester'];?></td>
				<td><?php echo $row['exam_year'] ;?></td>
				<td><?php echo $row_class['class_description'] ;?></td>
				<td>
					<form action="crass_pdf_open.php" method="POST" target="_blank">
						<input type="hidden" name="pdf_path" value="<?php echo $row['pdf_path']?>">
						<input type="submit" value="View" class="btn btn-success btn-sm " style="width:120px;margin:auto;">
					</form>
				</td>
				<td><?php echo $row['creation_time'] ;?></td>
				<!--<td><a href="edit_add_answer_sheet.php?edit_id=<?php //echo $row['sno'] ;?>">Edit</a></td>-->
			</tr>
			<?php
					}
			?>		
		</table>
	</div>
<?Php
page_footer_start(); 
page_footer_end(); 

?>