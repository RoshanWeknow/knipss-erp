<?php 
//include("scripts/settings.php");
include("ag_lib_setting.php");
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
		$sql = 'UPDATE `ag_ag_lib_issue_book` SET `status`=0,
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
		$sql1 = 'SELECT * FROM `ag_lib_issue_book` WHERE sno = "'.$_GET['reissue'].'"';
		$result = execute_query($db, $sql1);
		$row = mysqli_fetch_assoc($result);
		$issueCount = $row['issue_count'] + 1;
		
		$sql = 'UPDATE `ag_lib_issue_book` SET `issue_count`= "'.$issueCount.'",
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

<div id="container">	
	<div class="card card-body">    
		<div class="row d-flex my-auto">  	
			<div class="d-flex  justify-content-between">
				<div class="h3 " style="margin-top:0px;">Issued Books Report</div>
				<div><a href="ag_lib_book_return.php" style="margin-right:2rem;" class="btn btn-danger" >Back</h3></a></div>
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
						<th>Issue Count</th>
						<th>Book Issue Date</th>
						<th>Book Return Date </th>
						<th>Book Submitted </th>
						<th>Fine</th>
						<th>Recive Fine</th>
						<th>Reason</th>
					</tr>
						<?php
							if(isset($_POST['accession_no']) && ($_POST['accession_no'] != '')){
								$query = 'select * from ag_lib_issue_book where accession_no = "'.$_POST['accession_no'].'" AND status =1';
							}
							elseif(isset($_POST['lib_card_no']) && ($_POST['lib_card_no'] != '')){
								$query = 'select * from ag_lib_issue_book where lib_card_no = "'.$_POST['lib_card_no'].'" AND status =1';
							}
							elseif(isset($_POST['first_date']) && isset($_POST['last_date'])){
								$startDate = $_POST['first_date'];
								$endDate = $_POST['last_date'];
								$query = 'SELECT * FROM ag_lib_issue_book WHERE booksissuedate BETWEEN "'.$startDate.'" AND "'.$endDate.'" AND status = 1';
							}
							else{
								$query = 'select * from ag_lib_issue_book ';
							}
							//echo $query;
							
							$result = execute_query($db, $query);
							$i=1;
							while($row = mysqli_fetch_assoc($result)){
						
							$date1 = $row['booksreturndate'];
							$date2 = date('y-m-d'); 
							
							$start_date = strtotime($date1);
							$end_date = strtotime($date2);
							$daysDifference = ($end_date - $start_date)/60/60/24;
							
							$date1=date_create("2013-03-15");
							$date2=date_create("2013-12-12");
							
							/*
							// date_diff() function is not working
							$diff=date_diff($date1,$date2);
							echo $diff->format("%R%a days");
							*/
							if ($daysDifference >= 0) {
								$fine = $daysDifference;
							} else {
								$fine = 0;
							}						
								echo '<tr align="center">
								<td>'.$i++.'</td>
								<td>'.$row['accession_no'].'</td>
								<td>'.$row['lib_card_no'].'</td>
								<td>'.$row['stu_name'].'</td>'.
								// <td>'.$row['batch'].'</td>
								// <td>'.$row['mobile'].'</td>
								'<td>'.$row['subject'].'</td>
								<td>'.$row['issue_count'].'</td>
								<td>'.$row['booksissuedate'].'</td>
								<td>'.$row['booksreturndate'].'</td>
								<td>'.$row['actual_return_date'].'</td>
								<td>'.$row['fine'].'</td>
								<td>'.$row['fine_amount'].'</td>
								<td>'.$row['fine_comment'].'</td>
								
							</tr>';
							}
						?>
				</table>
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