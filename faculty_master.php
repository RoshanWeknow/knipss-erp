<?php
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg='';
$tab=1;
$responce = 0;

page_header_start();
page_header_end();
page_sidebar();	
?>
<?php
	if(isset($_POST['submit'])){
		if(isset($_POST['edit']) && $_POST != ''){
			$sql = 'UPDATE  exam_faculty_master_info SET 
			name = "'.$_POST['name'].'",
			f_name = "'.$_POST['f_name'].'",
			designation = "'.$_POST['designation'].'",
			subject_name = "'.$_POST['subject_name'].'",
			mobile_no = "'.$_POST['mobile_no'].'",
			aadhar = "'.$_POST['aadhar'].'",
			email = "'.$_POST['email'].'",
			pan = "'.$_POST['pan'].'",
			account_no = "'.$_POST['account_no'].'",
			account_no2 = "'.$_POST['account_no2'].'",
			ifsc_code = "'.$_POST['ifsc_code'].'",
			branch = "'.$_POST['branch'].'",
			bank_name = "'.$_POST['bank_name'].'"
			';
			$result = mysqli_query($db,$sql);
			if(!isset($result)){
				echo 'Failed To Update ';
			}
			
		}else{
			$sql = 'INSERT INTO  exam_faculty_master_info (name, f_name, designation, subject_name, mobile_no, aadhar, email, pan, account_no, account_no2, ifsc_code, branch, bank_name) VALUES ("'.$_POST['name'].'","'.$_POST['f_name'].'","'.$_POST['designation'].'","'.$_POST['subject_name'].'","'.$_POST['mobile_no'].'","'.$_POST['aadhar'].'","'.$_POST['email'].'","'.$_POST['pan'].'","'.$_POST['account_no'].'","'.$_POST['account_no2'].'","'.$_POST['ifsc_code'].'","'.$_POST['branch'].'","'.$_POST['bank_name'].'")';
			$result = mysqli_query($db,$sql);
			if(!isset($result)){
				echo 'Failed To insert ';
			}
		}
		
	}
	
	// Deletion 
		if(isset($_GET['del'])){
			$sql = 'DELETE FROM  exam_faculty_master_info where sno="'.$_GET['del'].'"';
			$delete=mysqli_query($db, $sql);
			if(!isset($delete)){
				echo "DELETION NOT SUCCESSFULL !!!";
			}
		}
		
		// Edition
		if(isset($_GET['edit'])){
			$sql = 'SELECT * FROM  exam_faculty_master_info';
			$qry = mysqli_query($db, $sql);
			$res = mysqli_fetch_assoc($qry);
		}
	
?>
<!----cdn lind---->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!------cdn link end-------->


<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
						
							<?php echo $msg; ?> 
							<div class="col-md-12">
								<h2 class="bg-primary text-white p-2" style="text-align:center;">Faculty Master Record</h2>
								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-10 mt-4" style="border:2px solid grey; box-shadow:1px 1px  1px grey;">
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="" target="_blank">
											<div class="d-flex">
												<div style="border-right:1px solid grey;width:50%; padding-left:10px;padding-right:10px;">
													<h3 style="text-align:center;background-color:#0d6efd;color:white;height:4rem;line-height:4rem;">Personal Details</h3>
													<div class="mb-3 pt-3">
														<label for="name" class="form-label">NAME OF FACULTY/OTHER*</label>
														<input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Name" required="required">
													</div>
													<div class="mb-3">
														<label for="f_name" class="form-label">FATHER NAME*</label>
														<input type="text" class="form-control" name="f_name" id="f_name" placeholder="Enter Your Father Name" required="required">
													</div>
													<div class="mb-3 me-3">
														<label for="designation" class="form-label">DESIGNATION*</label>
														<select name="designation" id="designation" class="form-control" tabindex="<?php echo $tabindex++;?>" >
															<option value="" disabled selected>---Select---</option>
															<option value="Assistant Professor" >Assistant Professor</option>
															<option value="Associate Professor<" >Associate Professor</option>
															<option value="Professor" > Professor</option>
															<option value="Other" >Other</option>
														</select>
													</div>
													<div class="mb-3">
														<label for="mnumber" class="form-label">MOBILE NO</label>
														<input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile No" required="required">
													</div>
													<div class="mb-3 me-3">
														<label for="subject_name" class="form-label">DEPARTMENT/SUBJECT OF FACULTY*</label>
														<select name="subject_name" id="subject_name" tabindex="<?php echo $tab++; ?>" class="form-control">
															<?php
															$query = "SELECT * FROM add_subject";
															$run = mysqli_query($db, $query);
															while ($data = mysqli_fetch_array($run)) {
																echo '<option value="' . $data['sno'] . '" ';
																if (isset($_POST['subject_name']) && $data['sno'] == $_POST['subject_name']) {
																	echo ' selected="Selected"';
																}
																echo '>' . trim($data['subject']) . '</option>';
															}
															?>
														</select>

													</div>
													<div class="mb-3">
														<label for="aadhar" class="form-label">ADHAR NUMBER*</label>
														<input type="text" class="form-control" name="aadhar" id="aadhar" placeholder="Enter Adhar Number" required="required">
													</div>
													<div class="mb-3">
														<label for="email" class="form-label">Email ID*</label>
														<input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Id" required="required">
													</div>
												</div>
												<div style="width:50%;padding-left:10px;padding-right:10px;">
													<h3 style="text-align:center;background-color:#0d6efd;color:white;height:4rem;line-height:4rem;">Bank Details</h3>
													<div class="mb-3 pt-3">
														<label for="account_no" class="form-label">ACCOUNT NUMBER*</label>
														<input type="text" class="form-control" name="account_no" id="account_no" placeholder="Account No." required="required">
													</div>
													<div class="mb-3">
														<label for="account_no2" class="form-label">RE-ENTER ACCOUNT NUMBER*</label>
														<input type="text" class="form-control" name="account_no2" id="account_no2" placeholder="Re Enter Account No." required="required">
													</div>
													<div class="mb-3">
														<label for="ifsc_code" class="form-label">IFSC CODE*</label>
														<input type="text" class="form-control" name="ifsc_code" id="ifsc_code" placeholder="IFSC CODE" required="required">
													</div>
													<div class="mb-3">
														<label for="bank_name" class="form-label">BANK NAME</label>
														<input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="Bank Name" required="required">
													</div>
													<div class="mb-3">
									 					<label for="branch" class="form-label">BRANCH NAME*</label>
														<input type="text" class="form-control" name="branch" id="branch" placeholder="Branch Name" required="required">
													</div>
													<div class="mb-3">
														<label for="pan" class="form-label">PAN NUMBER*</label>
														<input type="text" class="form-control" name="pan" id="pan" placeholder="Enter PAN No.(Use Capital Letter)" required="required">
													</div>
													<div class="d-flex" style="justify-content:space-around;">
														<div class="pt-2">
															<button type="submit" name = "submit" value="submit" class="btn btn-primary mt-2 ms-2" style="padding-left:30px;padding-right:30px;">Submit</button>
														</div>
														<div  class="pt-2">
															<button type="cancel" name = "cancel" value="" class="btn btn-primary mt-2 ms-2"  style="padding-left:30px;padding-right:30px;">Cancel</button>
														</div>	
													</div>
												</div>
											</div>
										</form>					
									</div>
									<div class="col-md-1"></div>					
								</div>
								<div class="row pt-5">
									<div class="col-md-12">
										<h3 style="text-align:center;background-color:#0d6efd;color:white;height:4rem;line-height:4rem;">DETAILS OF MASTER FACULTY RECORD</h3>
										
										<table class="table table-striped px-auto">
											<tr>
												<td>S.NO.</td>
												<td>NAME</td>
												<td>DESIGNATION</td>
												<td>SUBJECT NAME</td>
												<td>MOBILE NO.</td>
												<td>ADHAR NO.</td>
												<td>PAN NO</td>
												<td>ACCOUNT NO</td>
												
												<td>IFSC CODE</td>
												<td>BRANCH NAME</td>
												<td>BANK NAME</td>
												<td>EDIT</td>
												<td>DELETE</td>
											</tr>

											<?php
												$sql = 'select * from exam_faculty_master_info';
												$result = mysqli_query($db, $sql);
												$i=1;
												while($row = mysqli_fetch_assoc($result)){
													echo '<tr>
													<td>'.$i++.'</td>
													<td>'.$row['name'].'</td>
													<td>'.$row['designation'].'</td>
													<td>'.$row['subject_name'].'</td>
													<td>'.$row['mobile_no'].'</td>
													<td>'.$row['aadhar'].'</td>
													<td>'.$row['pan'].'</td>
													<td>'.$row['account_no'].'</td>
													<td>'.$row['ifsc_code'].'</td>
													<td>'.$row['branch'].'</td>
													<td>'.$row['bank_name'].'</td>
													<td><a href="faculty_master.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
													<td><a href="faculty_master.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
														</tr>'	;
												}
											?>
										</table>
									</div>
								</div>
							</div>
                    </div>
				</div>
			</div>
		</div>
