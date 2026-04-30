<?php 
//include("scripts/settings.php");
include("lib_setting.php");
$msg = '';

// page_header_start();
// page_header_end();
// page_sidebar();
header_lib();
?>
<head>
    <!-- Required meta tags -->
    <!-- <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <script src="Bar_Code_generate\JsBarcode.all.min.js">
    </script>
	<link href="css/Pagination_css/css1.css" rel="stylesheet" type="text/css" media="all" /> --><!-- For cubic --->
	<!---<link href="css/Pagination_css/css.css" rel="stylesheet" type="text/css" media="all" /> <!-- For Cerculer--->
    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">-->
</head>
<body>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title text-center"></h4></br>
			</div>
			<div class="card-body">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="">
					<?php echo $msg; ?> 
                    <div class="col-md-12">
                        <!-- first row -->
                        <div class="row">
                            
							<div class="col-md-4">
								<label>Course</label>
								<select name="Category" id="Category" class="form-control" tabindex="<?php echo $tabindex++; ?>" >
									<option value="">---Select Course---</option>
									<option value="3">LLB 3 Year</option>
									<option value="5">LLB 5 Year</option>
								</select>
							</div>
                        </div>
						<div>
							<button type="submit" name = "submit" value="submit" class="btn btn-primary mt-2 ms-2">Search</button> 
						</div>
					</div>
			   </form>
			
			</div>
		</div>	
	</div>
</div>			
	<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
                    </div>
                    <div class="card-body">
					<?php
					$limit = 50;
							(isset($_GET['page']) ? $page = $_GET['page'] : $page = 1);
							$offset = ($page - 1) * $limit;
							//$sql = "SELECT * FROM lib_add_new_book ORDER BY accession_no ASC LIMIT {$offset}, {$limit}";
							if(isset($_POST['Category'])){
								$sql = "select * from lib_add_new_book where book_category = '".$_POST['Category']."' LIMIT {$offset}, {$limit}";
							}
							else{
								$sql = "SELECT * FROM lib_add_new_book LIMIT {$offset}, {$limit}";
							}
							//echo $sql.'<br/>';
							$result = execute_query($db, $sql);
							$arrayBarcodes=array();
						if(mysqli_num_rows($result) > 0 ) {
					?>	
					
					<table class="table table-striped table-hover" id="general_stat_table">
						
					<?php
					// FOR PUT PAGES UPPER SIDE OF THE TABLE
						//$sql1 = 'select * from lib_add_new_book ORDER BY accession_no ASC';
						if(isset($_POST['Category'])){
								$sql1 = 'select * from lib_add_new_book where book_category = "'.$_POST['Category'].'" ORDER BY ABS(accession_no)';
							}
							else{
								$sql1 = 'select * from lib_add_new_book ORDER BY ABS(accession_no) ';
							}
							//echo $sql1;
						$result1 = execute_query($db, $sql1) or die("Query Faild. ");
						$num_data = mysqli_num_rows($result1);
								$book_cat = "";
						if(isset($_POST['Category'])){
							$book_cat = $_POST['Category'];
							echo '<a href="lib_old_book_info.php" align="right">Show Full Report</a>';
						}	
							echo "<h5 style='color:green;' align='right'>Total <u style='color:red; font-weight: bold;'>".$book_cat."</u> Books : ".$num_data."</h5><br>";
							
						if (mysqli_num_rows($result1) > 0) {
							$total_records = mysqli_num_rows($result1);
							$total_page = ceil($total_records / $limit);
							
							echo '<ul class="pagination admin-pagination">';
							
							if($page > 1){
								echo '<li><a class="page-link" href="lib_old_book_info.php?page='.($page-1).'">Prev</a></li>';
							}
							if($page >= 6){
								echo '<li><a class="page-link" href="lib_old_book_info.php?page=1">1</a></li>';
							}
							
							for($i = ($page-2 >= 1)?$page-2:$page-1; $i<=$page-1 ; $i++){
									if($i>=1){
										echo '<li class=""><a class="page-link" href="lib_old_book_info.php?page='.$i.'">'.$i.' 	</a></li>';
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
									echo '<li class="'.$active.'"><a class="page-link" href="lib_old_book_info.php?page='.$i.'">'.$i.'</a></li>';
								}
							}
												
							//echo '<li><a  style="color:black;" class="page-link disabled" >.....</a></li>';
							echo '<li><a style="color:black;" class="page-link" href="lib_old_book_info.php?page='.($total_page).'">'.$total_page.'</a></li>';
							if($total_page > $page) {
								echo '<li><a class="page-link" href="lib_old_book_info.php?page='.($page+1).'">Next</a></li>';
							}	
							echo '</ul>';
						}
				?>
						<thead class="thead-primary">
							<tr align="center">
								<td>S.No.</td>
								<td>Library Location</td>
								<td>Shelf Location</td>
								<td>Accession No</td>
								<td>Title</td>
								<td>Author Name</td>
								<td>Subject</td>
								<td>DDC Code</td>
							</tr>
						</thead>
						<tbody>
						<?php
							if(isset($_GET['page'])){
								$i=(($_GET['page']-1)*$limit)+1;
							}else{
								$i=1;
							}
							$arrayBarcodes=array();
							while($row = mysqli_fetch_assoc($result)){
								$arrayBarcodes[]=(string)$row['accession_no'];
								$asc_number = preg_replace('/[^0-9]/', '', $row['accession_no']);
								$asc_alpha = preg_replace('/[^a-zA-Z]/', '', $row['accession_no']);
								echo '<tr align="center">
									<td>'.$i++.'</td>
									<td>'.$row['library_location'].'</td>
									<td>'.$row['shelf_location'].'</td>
									<td>'.$row['accession_no'].'</td>
									<td>'.$row['title'].'</td>
									<td>'.$row['author_name'].'</td>
									<td>'.$row['subject'].'</td>
									<td>'.$row['ddc_code'].'</td>
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
<!--Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script type="text/javascript">
  //convert json to JS array data.
  function arrayjsonbarcode(j) {
    json = JSON.parse(j);
    arr = [];
    for (var x in json) {
      arr.push(json[x]);
    }
    return arr;
  }

  //convert PHP array to json data.
  jsonvalue = '<?php echo json_encode($arrayBarcodes) ?>';
  values = arrayjsonbarcode(jsonvalue);

  //generate barcodes using values data.
  for (var i = 0; i < values.length; i++) {
    JsBarcode("#barcode" + values[i], values[i].toString(), {
      format: "code128",
      lineColor: "#000",
      width: 2,
      height: 30,
      displayValue: true
      }
    );
  }
</script>
<?php
// page_footer_start();
// page_footer_end();
footer_lib();
?>
</body>