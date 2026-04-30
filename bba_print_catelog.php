<?php 
//include("scripts/settings.php");
include("bba_lib_setting.php");
$msg = '';

// page_header_start();
// page_header_end();
// page_sidebar();
header_lib();
?>
<head>
  <!-- Include the jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <!-- Include the DataTables CSS and JavaScript files -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.css">
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.js"></script>
</head>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="bg-success text-center text-white p-2"> Print Catelog</h4>
			</div>
			<div class="card-body">
				<form action="catelog.php" target="_blank" method="POST" enctype="multipart/form-data" id="" name="">
					<?php echo $msg; ?> 
                    <div class="col-md-12">
                        <h4>Enter Accession Number</h4>
                        <div class="row">
						<!--
							<div class=" col-md-4 ">
								<label>Accession Number</label>
								<input type="text" name="acc_no" id="acc_no" class="form-control " value="" tabindex="<?php echo $tabindex++;?>" />
						</div>--->
							
							<div class=" col-md-4 ">
								<label>From</label>
								<input type="text" name="acc_no1" id="acc_no1" class="form-control " value="" tabindex="<?php echo $tabindex++;?>" required>
							</div>
							<div class=" col-md-4 ">
								<label>To</label>
								<input type="text" name="acc_no2" id="acc_no2" class="form-control " value="" tabindex="<?php echo $tabindex++;?>" required>
							</div>
                        </div>
							
						<div>
							<button type="submit" name = "submit" value="submit" class="btn btn-primary mt-2 ms-2">Search</button> 
							<!--
							<a href="catelog.php?from=<?php //echo $_POST['acc_no1'] ?>&to=<?php //echo $_POST['acc_no2'] ?>" class="btn btn-primary mt-2 ms-2">Submit</a>
							-->
						</div>
					</div>
			   </form>
			
			</div>
		</div>	
	</div>
</div>	
<style>
form div.row:nth-child(odd) {
    background: #eeeeee;
    border-radius: 5px;
    margin-bottom: 5px;
    margin-top: 5px;
    padding: 5px;
}

form div.row label {
    color: #000000;
}
</style>
<?php	
	//if(isset($_POST['submit'])){
?>
<!--
<div id="container">
<div class="card card-body">
    <table width="100%" class="table table-striped table-hover rounded" id="myTable" class="display">
        <tr class="text-white bg-primary" align="center" >
            <th>Sno</th>
			<th>Library Location</th>
			<th>Accession No</th>
			<th>Subject</th>
			<th>DDC Code</th>
			<th>Serial No</th>
			<th>Author Name</th>
			<th>Publication Year</th>
			<th>ISBN No</th>
			<th>Date Of Purchase</th>
			<th>Edit </th>
			<th>Delete</th>
        </tr>
<?php
			// if(isset($_POST['acc_no1'])!=''){
				// $min_acc_no = $_POST['acc_no1'];
				// $max_acc_no = $_POST['acc_no2'];

				// $sql = 'SELECT * FROM lib_add_new_book WHERE accession_no BETWEEN '.$min_acc_no.' AND '.$max_acc_no;

				// //$sql = 'SELECT * FROM lib_add_new_book WHERE accession_no >= "'.$_POST['acc_no1'].'" && accession_no <= "'.$_POST['acc_no1'].'"';
				// echo $sql;
					// $result = execute_query($db, $sql);
					// $a=1;
					// if($result){
					// while($row = mysqli_fetch_assoc($result)){
						// echo '<tr style="text-align:center;">
						// <td>'.$a++.'</td>
							// <td>'.$row['library_location'].'</td>
							// <td>'.$row['accession_no'].'</td>
							// <td>'.$row['subject'].'</td>
							// <td>'.$row['ddc_code'].'</td>
							// <td>'.$row['serial_no'].'</td>
							// <td>'.$row['author_name'].'</td>
							// <td>'.$row['publication_year'].'</td>
							// <td>'.$row['isbn_no'].'</td>
							// <td>'.$row['date_of_purchase'].'</td>
							// <td><a href="lib_add_new_book.php?edit='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
							// <td><a href="lib_add_new_book_report.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
						// </tr>'	;
						// }
					// }
			// }
		// }	
		?>
    </table>
</div>
</div>
-->
<?php
// page_footer_start();
// page_footer_end();
footer_lib();
?>