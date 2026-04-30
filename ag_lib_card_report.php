<?php 
//include("scripts/settings.php");
include("ag_lib_setting.php");
$msg = '';

// page_header_start();
// page_header_end();
// page_sidebar();
header_lib();
?>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/Pagination_css/css1.css" rel="stylesheet" type="text/css" media="all" /> <!-- For cubic --->
	<!---<link href="css/Pagination_css/css.css" rel="stylesheet" type="text/css" media="all" /> <!-- For Cerculer--->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  </head>
  <body>
	<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4>
                    </div>
                    <div class="card-body">
					<?php
					$limit = 50;
							(isset($_GET['page']) ? $page = $_GET['page'] : $page = 1);
							$offset = ($page - 1) * $limit;
							$sql = "SELECT * FROM ag_lib_id_card ORDER BY sno ASC LIMIT {$offset}, {$limit}";
							$result = execute_query($db, $sql);
						if(mysqli_num_rows($result) > 0 ) {
					?>
					<h2 class="bg-success text-white p-2 text-center ">AGRICULTURE LIBRARY CARD LIST</h2>
					<table class="table table-striped table-hover" id="general_stat_table">
						<thead>
					<?php
					// FOR PUT PAGES UPPER SIDE OF THE TABLE
						$sql1 = 'select * from ag_lib_id_card';
						$result1 = execute_query($db, $sql1) or die("Query Faild. ");
						if (mysqli_num_rows($result1) > 0) {
							$total_records = mysqli_num_rows($result1);
							$total_page = ceil($total_records / $limit);
							
							echo '<ul class="pagination admin-pagination">';
							
							if($page > 1){
								echo '<li><a class="page-link" href="lib_card_report.php?page='.($page-1).'">Prev</a></li>';
							}
							if($page >= 6){
								echo '<li><a class="page-link" href="lib_card_report.php?page=1">1</a></li>';
							}
							
							for($i = ($page-2 >= 1)?$page-2:$page-1; $i<=$page-1 ; $i++){
									if($i>=1){
										echo '<li class=""><a class="page-link" href="lib_card_report.php?page='.$i.'">'.$i.' 	</a></li>';
									}
									else{'';}
								}
								
							for($i = $page; $i<= (($page+2)<= $total_page?$page+2:$page+1); $i++){
								if($i == $page){
									$active = "page-item active";
								}
								else{
									$active = "";
								}
								if($i<=$total_page-1){
									echo '<li class="'.$active.'"><a class="page-link" href="lib_card_report.php?page='.$i.'">'.$i.'</a></li>';
								}
							}
												
							//echo '<li><a  style="color:black;" class="page-link disabled" >.....</a></li>';
							echo '<li><a style="color:black;" class="page-link" href="lib_card_report.php?page='.($total_page).'">'.$total_page.'</a></li>';
							if($total_page > $page) {
								echo '<li><a class="page-link" href="lib_card_report.php?page='.($page+1).'">Next</a></li>';
							}	
							echo '</ul>';
						}
				?>
							<tr class="bg-primary text-white" style="color:white!important;" align="center">
								<td>S.No.</td>
								<td>Library Card No</td>
								<td>Student Name</td>
								<td>Father Name</td>
								<td>Date Of Birth</td>
								<td>Course Type</td>
								<td>Course</td>
								<td>Valid Up To</td>
								<td>Print</td>
							</tr>
						</thead>
						<tbody>
						<?php
									$i=1;
									while($row = mysqli_fetch_assoc($result)){
										$sql_course = 'SELECT * FROM class_detail where sno = "'.$row['course'].'"';
										$course = mysqli_fetch_assoc(mysqli_query($db, $sql_course));
										echo '<tr align="center">
											<td>'.$i++.'</td>
											<td>'.$row['lib_no'].'</td>
											<td>'.$row['name'].'</td>
											<td>'.$row['father_name'].'</td>
											<td>'.$row['dob'].'</td>
											<td>'.$row['course_catagory'].'</td>
											<td>'.$row['course'].'</td>
											
												<td>'.$row['valid_upto'].'</td>
												<td><a href="ag_lib_card_result.php?id='.$row['sno'].'" target="_blank"><i class="fa fa-print" style="font-size:20px; color:red;"></i></a></td>
											</tr>';

									}
						}
								?>
						</tbody>
					</table>
					</div>
                </div>
            </div>
		</div>
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
</body>