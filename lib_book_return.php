<?php 
//include("scripts/settings.php");
include("lib_setting.php");
$msg = '';
$rdate = date('Y-m-d', strtotime("+15 days"));
// page_header_start();
// page_header_end();
// page_sidebar();
header_lib();
?>
<?php	
	if(isset($_POST['submit2'])){
		
		$fine_value = $_POST['finecost'];
		
		if(isset($_POST['fine'])){
			$fine_value = 0;
		}
		$sql = 'UPDATE `lib_issue_book` SET `status`=0,
		`actual_return_date`= "'.date('d-m-y H:m:s').'",
		`fine`= "'.$fine_value.'" 
		where sno="'.$_POST['id'].'"';
		//echo $sql;
		execute_query($db, $sql);
		
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in Returning . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Book Returned</h3>';
		}
	}
	
	if (isset($_GET['reissue'])) {
		$sql1 = 'SELECT * FROM `lib_issue_book` WHERE sno = "'.$_GET['reissue'].'"';
		$result = execute_query($db, $sql1);
		$row = mysqli_fetch_assoc($result);
		$issueCount = $row['issue_count'] + 1;
		
		$sql = 'UPDATE `lib_issue_book` SET `issue_count`= "'.$issueCount.'",
		`book_reissue_date`= "'.date('d-m-y H:m:s').'", 
		`booksreturndate`= "'.$rdate.'" 
		where sno="'.$_GET['reissue'].'"';
		$res1 = execute_query($db, $sql);
		
		if (mysqli_error($db)) {
			$msg .= '<h4 style="color:red;">Error in updating.'.mysqli_error($db).' >> ' .$sql.'</h4>';
		} else {
			$msg .= '<p style="color:green;">Book Re-Issued for <b>'.$row['stu_name'].'</b></p>';
		}
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
    width: 370px;
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

#search-box, #accession_no {
    padding: 10px;
    border: #a8d4b1 1px solid;
    border-radius: 4px;
}

</style>
    <style>
        /* Modal Background */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 20%; /* Could be more or less, depending on screen size */
        }

        /* Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
<div id="container">
	<div class="card">
		<div class="card-body ">
		
			<div class="row d-flex my-auto">
				<?php echo $msg; ?>
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"  enctype="multipart/form-data" method="POST" onSubmit="" autocomplete="off">
					<table width="100%" class="table table-striped table-hover rounded">
						<tr>
							<th>Accession No.</th>
							<th>
								 <div class="frmSearch">
									<input type="text" class="form-control" name="accession_no" id="accession_no" placeholder="Accessio No" />
									<div id="a_suggesstion-box"></div>
									<script>
										function select_accession_no(val) {
											console.log(val);
											$("#accession_no").val(val);
											$("#a_suggesstion-box").hide();
										}
									
									</script>
								</div>
							</th>
							<th>Card No.</th>
							<th>
								 <div class="frmSearch">
									<input type="text" class="form-control" name="lib_card_no" id="lib_card_no" placeholder="Library Card No" />
									<div id="l_suggesstion-box"></div>
									<script>
									function select_lib_card_no(val) {
										console.log(val);
										$("#lib_card_no").val(val);
										$("#l_suggesstion-box").hide();
									}
									</script>
								</div>
							</th>
						</tr>
						<tr>
							<th>OR</th>
						</tr>
						<tr>
							<th>From Date</th>
								<th>
									<input type="date" class="form-control" name="first_date" id="first_date" />
								</th>
								<th>To Date</th>
								<td>
									<input type="date" class="form-control" name="last_date" id="last_date" />
								</td>
						</tr>
					</table>
					<button type="submit" class="btn btn-success " name="submit" value="">Search</button>
				</form>
			</div>
		</div>
	</div>
</div>
<div id="container">	
	<div class="card card-body">    
		<div class="row d-flex my-auto">  	
			<div class="d-flex  justify-content-between">
				<div class="h3 " style="margin-top:0px;">Issued Books Report</div>
				<div><a href="lib_book_return_record.php" style="margin-right:2rem;" class="btn btn-info" >Full Report</h3></a></div>
			</div>
			<div class="col-md-12" >
				<table width="100%" class="table table-striped  table-hover rounded">
					<tr class="bg-primary text-white" align="center">
						<th>Sno</th>
						<th>Accession No</th>
						<th>Card No</th>
						<th>Student Name</th>
						<!--<th>Batch</th>
						<th>Mobile No.</th>-->
						<th>Subject</th>
						<th>Book Issue Date</th>
						<th>Book Return Date </th>
						<th>Re-Issue</th>  
						<th>Return</th>
						<th>Fine</th>
						<th>Fine Remove</th>
						<th>Recive Fine</th>
					</tr>
						<?php
							// if(isset($_POST['accession_no']) && ($_POST['accession_no'] != '')){
								// echo $query = 'SELECT * FROM lib_issue_book WHERE accession_no = "'.$_POST['accession_no'].'" AND status = 1';
							// }
							// elseif(isset($_POST['lib_card_no']) && ($_POST['lib_card_no'] != '')){
								// $query = 'SELECT * FROM lib_issue_book WHERE lib_card_no = "'.$_POST['lib_card_no'].'" AND status = 1';
							// }
							// elseif(isset($_POST['first_date']) && isset($_POST['last_date'])){
								// $startDate = $_POST['first_date'];
								// $endDate = $_POST['last_date'];
								// $query = 'SELECT * FROM lib_issue_book WHERE booksissuedate BETWEEN "'.$startDate.'" AND "'.$endDate.'" AND status = 1';
							// }
							// else{
								// echo $query = 'SELECT * FROM lib_issue_book WHERE status = 1';
							// }
							
							$query = 'SELECT * FROM lib_issue_book WHERE status = 1';
								if (isset($_POST['first_date']) && isset($_POST['last_date'])) {
									if($_POST['first_date']!="" &&$_POST['last_date']!=""){
										$startDate = $_POST['first_date'];
										$endDate = $_POST['last_date'];
										$query .= ' AND booksissuedate BETWEEN "'.$startDate.'" AND "'.$endDate.'"';
									}
								}
								if(isset($_POST['accession_no']) && ($_POST['accession_no'] != '')){
									 $query .= ' and accession_no = "'.$_POST['accession_no'].'"';
								}
								elseif(isset($_POST['lib_card_no']) && ($_POST['lib_card_no'] != '')){
									$query .= ' and lib_card_no = "'.$_POST['lib_card_no'].'" ';
								}
								// echo $query ;
							$result = execute_query($db, $query);
							$i = 1;
							while($row = mysqli_fetch_assoc($result)){
								$date1 = $row['booksreturndate'];
								$date2 = date('y-m-d'); 

								$start_date = strtotime($date1);
								$end_date = strtotime($date2);
								$daysDifference = ($end_date - $start_date) / 60 / 60 / 24;

								if ($daysDifference >= 0) {
									$fine = $daysDifference;
								} else {
									$fine = 0;
								}                        
								echo '<tr align="center">
									<td>'.$i++.'</td>
									<td>'.$row['accession_no'].'</td>
									<td>'.$row['lib_card_no'].'</td>
									<td>'.$row['stu_name'].'</td>
									<td>'.$row['subject'].'</td>
									<td>'.$row['booksissuedate'].'</td>
									<td>'.$row['booksreturndate'].'</td>
									<td><a href="lib_book_return.php?reissue='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');"><h3 class="btn btn-sm btn-success">ReIssue</h3></a></td>';?>
									
									<?php
									if(isset($_POST['fine_submit'])){
										$sql='UPDATE `lib_issue_book` SET 
										`fine_amount`="'.$_POST['fine_amount'].'",
										`fine_comment`="'.$_POST['fine_comment'].'" 
										WHERE sno="'.$_POST['fine_row_sno'].'"';
										$res = execute_query($db, $sql);
										if(mysqli_error($db)){
											$msg.='Not Update';
										}else{
											
											$msg.='Update successfully';
										}

									}
									?>
									<?php echo'
									<form action="lib_book_return.php" method="POST">
										<td>
											<button class="btn btn-sm btn-danger" type="submit" name="submit2" value="return">Return</button>
										</td>
										<td>'.$fine.' Rs.
											<input type="hidden" value="'.$fine.'" name="finecost">
											<input type="hidden" value="'.$row['sno'].'" name="id">
										</td>
										<td>
											<input type="checkbox" id="fine'.$row['sno'].'" name="fine'.$row['sno'].'" value="'.$row['sno'].'" onclick="togglePopup(\''.$row['sno'].'\')">
										</td>
										<td>'.$row['fine_amount'].'</td>
										<div id="myModal'.$row['sno'].'" class="modal">
											<div class="modal-content">
												<span class="close" onclick="closePopup(\''.$row['sno'].'\')">&times;</span>
												<input type="number" name="fine_amount" placeholder="Enter Amount" class="form-control mb-2">
												<input type="hidden" name="fine_row_sno" value="'.$row['sno'].'" placeholder="Enter Amount" class="form-control mb-2">
												<textarea id="comment'.$row['sno'].'" name="fine_comment" rows="4" cols="30" placeholder="Enter your comment here..." class="form-control mb-2"></textarea>
												<br>
												<button type="submit" name="fine_submit" onclick="submitComment(\''.$row['sno'].'\')" class="btn btn-success">OK</button>
											</div>
										</div>
									</form>
								</tr>';
							}
						?>

				</table>
<script>
function togglePopup(rowId) {
    const checkbox = document.getElementById('fine' + rowId);
    const modal = document.getElementById('myModal' + rowId);

    if (checkbox.checked) {
        modal.style.display = 'block'; // Show the modal when checkbox is checked
    } else {
        modal.style.display = 'none'; // Hide the modal when checkbox is unchecked
    }
}

function submitComment(rowId) {
    const comment = document.getElementById('comment' + rowId).value;
    alert("Comment submitted: " + comment);
    document.getElementById('myModal' + rowId).style.display = 'none'; // Hide the modal after submission
    document.getElementById('fine' + rowId).checked = false; // Uncheck the checkbox after submission (optional)
}

function closePopup(rowId) {
    document.getElementById('myModal' + rowId).style.display = 'none'; // Hide the modal
    document.getElementById('fine' + rowId).checked = false; // Uncheck the checkbox
}
</script>


			</div>
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
		// For Accession
		$("#accession_no").keyup(function() {
			$.ajax({
				type: "POST",
				url: "testing_autocomplete.php",
				data: 'accession_keyword1=' + $(this).val(),
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
		
		// For Library Card number
		$("#lib_card_no").keyup(function() {
			$.ajax({
				type: "POST",
				url: "testing_autocomplete.php",
				data: 'lib_keyword=' + $(this).val(),
				beforeSend: function() {
					$("#lib_card_no").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
				},
				success: function(data) {
					$("#l_suggesstion-box").show();
					$("#l_suggesstion-box").html(data);
					$("#lib_card_no").css("background", "#FFF");
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