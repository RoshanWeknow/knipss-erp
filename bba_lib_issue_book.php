<?php 
//include("scripts/settings.php");
include("bba_lib_setting.php");
$msg = '';
$rdate = date('Y-m-d', strtotime("+15 days"));
// page_header_start();
// page_header_end();
// page_sidebar();
header_lib();
?>
<?php
	if(isset($_POST['submit2'])){
		if(isset($_POST['edit']) && $_POST['edit'] != ''){
			$sql = 'update bba_lib_issue_book set 
					lib_no="'.$_POST['lib_no'].'",
					lib_card_no="'.$_POST['roll_no'].'",
					stu_name="'.$_POST['stu_name'].'",
					mobile="'.$_POST['p_mobile'].'",
					batch="'.$_POST['batch'].'",
					email="'.$_POST['e_mail1'].'",
					accession_no="'.$_POST['accession_no'].'",
					subject="'.$_POST['subject_heading'].'",
					author_name="'.$_POST['author_name'].'",
					booksissuedate="'.$_POST['booksissuedate'].'",
					booksreturndate="'.$_POST['booksreturndate'].'",
					edited_by="'.$_SESSION['username'].'",
					edition_time="'.date('d-m-y H:m:s').'"
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
			$query = 'select * from bba_lib_issue_book where accession_no = "'.$_POST['accession_no'].'" AND status =1';
			$res = execute_query($db,$query);
			if(mysqli_num_rows($res)==0){
				$sql = 'insert into bba_lib_issue_book (lib_no,lib_card_no, stu_name, mobile, batch, email, accession_no, subject, author_name, booksissuedate, booksreturndate, created_by, creation_time)
				VALUES ("'.$_POST['lib_no'].'","'.$_POST['roll_no'].'","'.$_POST['stu_name'].'","'.$_POST['p_mobile'].'","'.$_POST['batch'].'","'.$_POST['e_mail1'].'","'.$_POST['accession_no'].'", "'.$_POST['subject_heading'].'", "'.$_POST['author_name'].'", "'.$_POST['booksissuedate'].'", "'.$_POST['booksreturndate'].'", "'.$_SESSION['username'].'","'.date('d-m-y H:m:s').'")';
				//echo $sql;
				execute_query($db,$sql);
				if(mysqli_errno($db)){
					echo "Insertion failed".mysqli_errno($db).mysqli_error($db);
				}
				else{
					echo'<h4 style = "color:green;">Book Issued</h4>';
				}
			}
			else{
				echo'<h4 style = "color:red;">This Book Is Already Issued To Someone</h4>';
			}
		}
		
	}
	
		
	if(isset($_GET['del'])){
		$sql = 'delete from bba_lib_issue_book where sno="'.$_GET['del'].'"';
		execute_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from bba_lib_issue_book where sno = '.$_GET['edit'];
	$qry = execute_query($db, $sql);
	$res = mysqli_fetch_assoc($qry);
}
?>
<style>
.frmSearch {
    background-color: #c6f7d0;
    margin: 2px 0px;
    border-radius: 4px;
}

#roll-list {
    float: left;
    list-style: none;
    margin-top: -3px;
    padding: 0;
    width: 190px;
    position: absolute;
	z-index: 10;
}

#roll-list li {
    padding: 10px;
    background: #f0f0f0;
    border-bottom: #bbb9b9 1px solid;
}

#roll-list li:hover {
    background: #ece3d2;
    cursor: pointer;
}

#search-box1, #accession_no {
    padding: 10px;
    border: #a8d4b1 1px solid;
    border-radius: 4px;
}

</style>
	<!--dashboard area-->
		<div class="card row" style="--bs-gutter-x: -0.5rem !important;">
			<div class="col-md-12">
				<div class="issue-wrapper">
					<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"  enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off">
					<div class="bg-primary text-white p-2"><h3>Issue Book</h3></div>
						<table  width="100%" class="table">
							<tr>
								<td class="" width="20%">
									<div class="frmSearch">
										<input type="text" class="form-control" name="roll_no" id="search-box1" placeholder="Library Card Number" />
										<div id="suggesstion-box"></div>
										<script>
										function select_roll_no(val) {
											console.log(val);
											$("#search-box1").val(val);
											$("#suggesstion-box").hide();
										}
										</script>
									</div>
								</td>
								<td width="10%">
									<button type="submit" class="btn btn-info" value="" placeholder="Search" name="submit1">Search</button>
								</td>
								<td width="70%"></td>
							</tr>
						</table>
						 <?php 
						if (isset($_POST["submit1"])) {
						   $sql  = 'select * from bba_lib_id_card where lib_no = "'.$_POST['roll_no'].'"';
						   //echo $sql;
							$dept_list = execute_query($db, $sql);
							
							if($dept_list && mysqli_num_rows($dept_list)>0){
								while($row5 = mysqli_fetch_assoc($dept_list)){
								$stu_name      = $row5['name']; 
								$dob       = $row5['dob'];
								$batch   = $row5['course_session'];
								$e_mail1     = $row5['email'];
								$p_mobile     = $row5['mobile'];
								$roll_no     = $row5['lib_card_no'];
								$lib_no     = $row5['lib_no'];
							   
						   
						?>
						<table width="100%" class="table table-striped table-hover rounded">
							<tr>
								<th>Library Card No.</th>
								<td>
								   <input type="text" class="form-control" name="lib_no" value="<?php echo $lib_no; ?>" readonly> 
								</td>
								<th>Roll No.</th>
								<td>
								   <input type="text" class="form-control" name="roll_no" value="<?php echo $_POST['roll_no']; ?>" readonly> 
								</td>
								<th>Student Name</th>
								<td>
								   <input type="stu_name" class="form-control" name="stu_name" value="<?php echo $stu_name; ?>"> 
								</td>
							</tr>
							<tr>
								<th>Phone No.</th>
								<td>
								   <input type="text" class="form-control" name="p_mobile"  value="<?php echo $p_mobile; ?>"> 
								</td>
								<th>Batch</th>
								<td>
								   <input type="text" class="form-control" name="batch"  value="<?php echo $batch; ?>"> 
								</td>
								<th>Email</th>
								<td>
								   <input type="text" class="form-control" name="e_mail1"  value="<?php echo $e_mail1; ?>"> 
								</td>
							</tr>
							<tr>
								<th>Accession No</th>
								<td>
								   <div class="frmSearch">
										<input type="text" class="form-control" name="accession_no" id="accession_no" placeholder="Accessio No" />
										<div id="a_suggesstion-box"></div>
										<script>
										function select_accession_no(val) {
											console.log(val);
											$("#accession_no").val(val);
											$("#a_suggesstion-box").hide();
											let accession_no = $("#accession_no").val()
											accession_details(accession_no);
										}
										// accession no book name
										function accession_details(val){
											console.log(val);
											$.ajax({
												url: 'testing_autocomplete.php', // PHP script to handle the AJAX request
												type: 'POST', // or 'POST' depending on your setup
												data: { accession_no: val }, // Send the selected roll number as a parameter
												success: function(response) {
													let return_data = JSON.parse(response);
													// Handle the response data and update the UI as needed
													// You can update the details in the third column of the table here
													$('#subject_heading').val(return_data[1]);
													$('#author_name').val(return_data[0]);
												}
											});
										}
										</script>
									</div>
								</td>
								<th>Subject Heading</th>
								<td>
									<input type="text" class="form-control" id="subject_heading" name="subject_heading"  value="">
								</td>
								
								<th>Author Name</th>
								<td>
								   <input type="text" class="form-control" name="author_name" id="author_name"  value=""> 
								</td>
							</tr>
							<tr>
								<th>Book Issue Date</th>
								<td>
								   <input type="text" class="form-control" name="booksissuedate"  value="<?php echo  date('Y-m-d'); ?>"> 
								</td>
								<th>Book Return Date</th>
								<td>
								   <input type="text" class="form-control" name="booksreturndate"  value="<?php echo $rdate; ?>"> 
								</td>
							</tr>
							<tr>
								<td>
								   <input type="submit" name="submit2" class="btn btn-info" value="Issue Book"> 
								</td>
							</tr>
						</table>
				  <?php
									}			
							}
						}
				?>
					</form>
				</div>
			</div>
		</div>
<!-- Add your existing HTML and PHP code for the select dropdown and submit button here -->
<!-- Make sure you include the necessary JavaScript libraries like jQuery for AJAX -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<script src='https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/js/jquery.circliful.min.js'></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script>
    $(document).ready(function() {
		//-----------------------------------------
		
		$("#search-box1").keyup(function() {
			$.ajax({
				type: "POST",
				url: "testing_autocomplete.php",
				data: 'keyword1=' + $(this).val(),
				beforeSend: function() {
					$("#search-box1").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
				},
				success: function(data) {
					$("#suggesstion-box").show();
					$("#suggesstion-box").html(data);
					$("#search-box1").css("background", "#FFF");
				}
			});
		});
		$("#accession_no").keyup(function() {
			$.ajax({
				type: "POST",
				url: "testing_autocomplete.php",
				data: 'accession_keyword=' + $(this).val(),
				beforeSend: function() {
					$("#accession_no").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
				},
				success: function(data) {
					$("#a_suggesstion-box").show();
					$("#a_suggesstion-box").html(data);
					$("#accession_no").css("background", "#FFF");
				}
			});
		});
		
		//-----------------------------------------
        // Attach a change event listener to the select element
        $('#roll_no').change(function() {
            var selectedRollNo = $(this).val(); // Get the selected roll number
            
            // Make an AJAX request to fetch data based on the selected roll number
            $.ajax({
                url: 'get_student_details.php', // PHP script to handle the AJAX request
                type: 'GET', // or 'POST' depending on your setup
                data: { roll_no: selectedRollNo }, // Send the selected roll number as a parameter
                success: function(response) {
                    // Handle the response data and update the UI as needed
                    // You can update the details in the third column of the table here
                    $('#student_details').html(response);
                }
            });
        });
    });
</script>
<?php
// page_footer_start();
// page_footer_end();
footer_lib();
?>