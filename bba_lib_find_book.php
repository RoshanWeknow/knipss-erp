<?php 
//include("scripts/settings.php");
include("bba_lib_setting.php");

$msg='';

// page_header_start();
// page_header_end();
// page_sidebar();
header_lib();
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
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"  enctype="multipart/form-data" method="POST" onSubmit="" autocomplete="off">
					<table width="100%" class="table table-striped table-hover rounded">
						<tr>
							<th>Subject Name</th>	
							<th>
								<div class="frmSearch">
									<input type="text" class="form-control" name="sub_name" id="sub_name" placeholder="Subject" />
									<div id="s_suggesstion-box"></div>
									<script>
									function select_sub_name(val) {
										console.log(val);
										$("#sub_name").val(val);
										$("#s_suggesstion-box").hide();
									}
									</script>
								</div>
							</th>
							<th>Publication Name</th>
							<th>
								<div class="frmSearch">
									<input type="text" class="form-control" name="p_name" id="p_name" placeholder="Publication Name" />
									<div id="p_suggesstion-box"></div>
									<script>
									function select_p_name(val) {
										console.log(val);
										$("#p_name").val(val);
										$("#p_suggesstion-box").hide();
										// let p_name = $(p_name).val()
										// publication_details(p_name);
									}
									// accession no book name
									// function accession_details(val){
										// console.log(val);
										// $.ajax({
											// url: 'testing_autocomplete.php', // PHP script to handle the AJAX request
											// type: 'GET', // or 'POST' depending on your setup
											// data: { p_name: val }, // Send the selected roll number as a parameter
											// success: function(response) {
												// let return_data = JSON.parse(response);
												// Handle the response data and update the UI as needed
												// You can update the details in the third column of the table here
												//$('#subject').val(return_data[1]);
												//$('#author_name').val(return_data[0]);
											// }
										// });
									// }
									</script>
								</div>
							</th>
						</tr>
						<tr>
							<th>OR</th>
						</tr>
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
										// let accession_no = $("#accession_no").val()
										// accession_details(accession_no);
									}
									// accession no book name
									// function accession_details(val){
										// console.log(val);
										// $.ajax({
											// url: 'testing_autocomplete.php', // PHP script to handle the AJAX request
											// type: 'POST', // or 'POST' depending on your setup
											// data: { accession_no: val }, // Send the selected roll number as a parameter
											// success: function(response) {
												// let return_data = JSON.parse(response);
												// Handle the response data and update the UI as needed
												// You can update the details in the third column of the table here
												// $('#subject').val(return_data[1]);
												// $('#author_name').val(return_data[0]);
											// }
										// });
									// }
									</script>
								</div>
							</th>
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
			<div ><h3>Records</h3></div>
				<div class="col-md-12" >
					<table width="80%" class="table table-striped  table-hover rounded">
						<tr class="bg-primary text-white">
							<th>Sno</th>
							<th>Accession No</th>
							<th>Subject</th>
							<th>Publication</th>
							<th>Author</th>
							<th>Shelf Location</th>
							<th>Lib_location</th>
							<!----
							<th>Edit </th>
							<th>Delete</th>
							---->
						</tr>
							<?php
								$acc_no = (isset($_POST['accession_no']) && ($_POST['accession_no']) != '') ? $_POST['accession_no'] : '';
								$s_subject = (isset($_POST['sub_name']) && ($_POST['sub_name']) != '') ? $_POST['sub_name'] : '';
								$s_pub = (isset($_POST['p_name']) && ($_POST['p_name']) != '') ? $_POST['p_name'] : '';
								
								$sql = 'select * from lib_add_new_book where accession_no = "'.$acc_no.'"';
								$sql1 = 'select * from lib_add_new_book where subject = "'.$s_subject.'" && publisher_name = "'.$s_pub.'" ';
								$query = (isset($_POST['accession_no']) && ($_POST['accession_no']) != '') ? $sql : $sql1;
								$result = mysqli_query($db, $query);
								$i=1;
								//echo $query;
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['accession_no'].'</td>
									<td>'.$row['subject'].'</td>
									<td>'.$row['publisher_name'].'</td>
									<td>'.$row['author_name'].'</td>
									<td>'.$row['shelf_location'].'</td>
									<td>'.$row['library_location'].'</td>
									<!----
									<td><a href="lib_master_almirah.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									<td><a href="lib_master_almirah.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
									---->
										</tr>'	;
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
		
		
		//For Subject
		$("#sub_name").keyup(function() {
			$.ajax({
				type: "POST",
				url: "testing_autocomplete.php",
				data: 'subject_keyword=' + $(this).val(),
				beforeSend: function() {
					$("#sub_name").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
				},
				success: function(data) {
					$("#s_suggesstion-box").show();
					$("#s_suggesstion-box").html(data);
					$("#sub_name").css("background", "#FFF");
				}
			});
		});
		
		
		//For publication
		$("#p_name").keyup(function() {
			let pub_keyword = $(this).val();
			let sub_keyword = $('#sub_name').val();
			$.ajax({
				type: "POST",
				url: "testing_autocomplete.php",
				data: {"publication_keyword":pub_keyword,"subject_keyword":sub_keyword},
				beforeSend: function() {
					$("#p_name").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
				},
				success: function(data) {
					$("#p_suggesstion-box").show();
					$("#p_suggesstion-box").html(data);
					$("#p_name").css("background", "#FFF");
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