<?php
include("bba_lib_setting.php");
$msg = '';

// Header and other settings
header_lib();

// Pagination settings
$limit = 1000; // Number of rows per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/Pagination_css/css1.css" rel="stylesheet" type="text/css" media="all">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-secondary">
                    <h4 class="card-title text-center  text-white">Management Library Books</h4>
                </div>
                <div class="card-body">
                    <?php
                    // Query for total book count
                    $sql1 = "SELECT COUNT(*) AS total_books FROM lib_add_new_book WHERE library_location = 'Management Library'";
                    $result1 = execute_query($db, $sql1);

                    if ($result1 && $row1 = mysqli_fetch_assoc($result1)) {
                        $num_data = $row1['total_books'];
                        echo "<h5 style='color:green;' align='right'>Total <u style='color:red; font-weight: bold;'>Management Library</u> Books: {$num_data}</h5><br>";
                    } else {
                        echo "<h5 style='color:red;' align='right'>Error fetching book count.</h5><br>";
                    }

                    // Query for paginated books
                    $sql = "SELECT * FROM lib_add_new_book WHERE library_location = 'Management Library' LIMIT $offset, $limit";
                    $result = execute_query($db, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        ?>
						 <!-- Pagination -->
                        <nav aria-label="Page navigation">
							<ul class="pagination justify-content-center">
								<?php
								$total_pages = ceil($num_data / $limit);

								// Previous Button
								if ($page > 1) {
									$prev_page = $page - 1;
									echo "<li class='page-item'><a class='page-link' href='?page=$prev_page'>Previous</a></li>";
								} else {
									echo "<li class='page-item disabled'><a class='page-link' href='#'>Previous</a></li>";
								}

								// Page Numbers
								for ($p = 1; $p <= $total_pages; $p++) {
									$active = ($page == $p) ? 'active' : '';
									echo "<li class='page-item $active'><a class='page-link' href='?page=$p'>$p</a></li>";
								}

								// Next Button
								if ($page < $total_pages) {
									$next_page = $page + 1;
									echo "<li class='page-item'><a class='page-link' href='?page=$next_page'>Next</a></li>";
								} else {
									echo "<li class='page-item disabled'><a class='page-link' href='#'>Next</a></li>";
								}
								?>
							</ul>
						</nav>

                        <table class="table table-striped table-hover" id="general_stat_table">
                                <tr class="table-primary text-white text-center">
									<th scope="col" width="5%">S.No.</th>
									<th scope="col" width="15%">Library Location</th>
									<th scope="col" width="15%">Accession No</th>
									<th scope="col" width="25%">Title</th>
									<th scope="col" width="15%">Author Name</th>
									<th scope="col" width="15%">Subject</th>
									<th scope="col" width="10%">DDC Code</th>
								</tr>

                            <?php
                            $i = $offset + 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr align="center">
                                    <td>' . $i++ . '</td>
                                    <td>' . $row['library_location'] . '</td>
                                    <td>' . $row['accession_no'] . '</td>
                                    <td>' . $row['title'] . '</td>
                                    <td>' . $row['author_name'] . '</td>
                                    <td>' . $row['subject'] . '</td>
                                    <td>' . $row['ddc_code'] . '</td>
                                </tr>';
                            }
                            ?>
                        </table>

                       
                        <?php
                    } else {
                        echo "<p class='text-center'>No records found for Management Library.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<?php
// page_footer_start();
// page_footer_end();
footer_lib();
?>
</body>
</html>
