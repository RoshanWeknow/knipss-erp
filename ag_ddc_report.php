<?php
//include("scripts/settings.php");
include("ag_lib_setting.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
// page_header_start();
// page_header_end();
// page_sidebar();
header_lib();
?>
<html>
	<head>
	</head>
	<body>
		<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="">
					<?php echo $msg; ?> 
                    <div class="col-md-12">
                        <!-- first row -->
                        <div class="row">
                            <div class=" col-md-4 ">
								<label>Subject Heading</label>
								<input type="text" name="college_roll_no" id="college_roll_no" class="form-control " value="" placeholder="Enter Subject" tabindex="<?php echo $tabindex++;?>" />
							</div>
							<div class=" col-md-4 ">
								<label>Book No</label>
								<input type="text" name="exam_form_no" id="exam_form_no" class="form-control " value="" placeholder="Enter Book Number" tabindex="<?php echo $tabindex++;?>" />
							</div>
                        </div>
						
						<div>
							<button type="submit" name = "submit" value="save" class="btn btn-primary mt-2 ms-2">Search</button> 
							<!--<input type="reset"  value="Reset" class="btn btn-danger mt-2 ms-5" /> -->
						</div>
						<p style="text-align:right;margin-bottom:0;"><a href="https://classify.oclc.org/classify2/" target="_blank">Search DDC Code...</a></p>
					</div>
			   </form>
                    </div>
                    <div class="card-body">
					<table class="table table-striped table-hover" id="general_stat_table">
						<thead>
							<tr class="bg-primary text-white">
								<td scope="col">Sno</td>
								<td scope="col">Book Classification ID</td>
								<td scope="col">MFN</td>
								<td scope="col">Class Formet</td>
								<td scope="col">Class No</td>
								<td scope="col">Book No</td>
								<td scope="col">Marc Tag</td>
								<td scope="col">Subject Heading</td>
							</tr>
						</thead>
						<?php
							if(isset($_POST['college_roll_no'])){
								$query = 'SELECT * FROM lib_ddc_code_report WHERE subject_heading = "'.$_POST['college_roll_no'] . '"';
							}
							elseif(isset($_POST['exam_form_no'])){
								$query = 'SELECT * FROM lib_ddc_code_report WHERE book_no = "'.$_POST['exam_form_no'].'"';
							}
							else{
								$query = 'SELECT * FROM lib_ddc_code_report limit 10';
							}
							$result =execute_query($db,$query);
							$i=1;
							while($row=mysqli_fetch_assoc($result)){
						?>
						<tr>
							<td><?php echo $i++;?></td>
							<td><?php echo $row['book_classification_id'];?></td>
							<td><?php echo $row['mfn'] ;?></td>
							<td><?php echo $row['class_formate'] ;?></td>
							<td><?php echo $row['class_no'];?></td>
							<td><?php echo $row['book_no'] ;?></td>
							<td><?php echo $row['marc_tag'];?></td>
							<td><?php echo $row['subject_heading'];?></td>
						</tr>
						<?php
								}
								
						  ?>		
									<!---
									<td><a href="uin_verification.php?edit='.$row['sno'].'&&id='.$row['sno'].'" target = "_blank" onClick="return confirm(\'Are you sure? \');" <h3 style="color: #3066ec;"> Edit</h3></a></td>
									
									<td><a href="uin_verification.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure? \');" <h3 style="color:red;"></h3>Delete</a></td>
									--->
					</table>
					</div>
                </div>
            </div>
		</div>
	</body>
</html>	
    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<script>

$('select[multiple]').multiselect({
	search: true,
	selectAll: true
});
	
$(document).ready( function () {
    /*$('#general_stat_table').DataTable({
		paging: false,
		fixedHeader: true,
		colReorder: true
		});
	});	*/

	
	var t = $('#general_stat_table').DataTable({
		paging: false
    });
 
    
});
	
</script>

    
<?php		
// page_footer_start();
// page_footer_end();
footer_lib();
?>