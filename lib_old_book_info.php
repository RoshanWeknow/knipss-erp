<?php
include("lib_setting.php");
$msg = '';

// Header and other settings
header_lib();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <!-- <meta charset="utf-8"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <!-- Bootstrap CSS -->
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Custom CSS -->
    <link href="css/Pagination_css/css1.css" rel="stylesheet" type="text/css" media="all" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center"></h4></br>
                </div>
                <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                        <?php echo $msg; ?> 
                        <div class="col-md-12">
                            <!-- first row -->
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Course</label>
                                    <select name="Category" id="Category" class="form-control">
                                        <option value="">All Book </option>
                                        <option value="3" <?php if (isset($_POST['Category']) && $_POST['Category'] == "3") echo 'selected'; ?>>LLB 3 Year</option>
                                        <option value="5" <?php if (isset($_POST['Category']) && $_POST['Category'] == "5") echo 'selected'; ?>>LLB 5 Year</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <button type="submit" name="submit" value="submit" class="btn btn-primary mt-2 ms-2">Search</button> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>    
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center"></h4></br>
                </div>
                <div class="card-body">
                    <?php
                    $limit = 1000;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    // Get the selected category from POST or GET
                    $book_cat = isset($_POST['Category']) ? $_POST['Category'] : (isset($_GET['Category']) ? $_GET['Category'] : "");

                    // Adjust SQL queries based on the selected category
                    if ($book_cat == "3") {
						$sql = "SELECT * FROM lib_add_new_book WHERE library_location = 'Law Library' AND accession_no_int = '3' LIMIT {$offset}, {$limit}";
						$sql1 = "SELECT * FROM lib_add_new_book WHERE library_location = 'Law Library' AND accession_no_int = '3'";
					} elseif ($book_cat == "5") {
						$sql = "SELECT * FROM lib_add_new_book WHERE library_location = 'Law Library' AND accession_no_int = '5' LIMIT {$offset}, {$limit}";
						$sql1 = "SELECT * FROM lib_add_new_book WHERE library_location = 'Law Library' AND accession_no_int = '5'";
					} else {
						$sql = "SELECT * FROM lib_add_new_book WHERE library_location = 'Law Library' LIMIT {$offset}, {$limit}";
						$sql1 = "SELECT * FROM lib_add_new_book WHERE library_location = 'Law Library'";
					}


                    $result1 = execute_query($db, $sql1) or die("Query Failed.");
                    $num_data = mysqli_num_rows($result1);

                    if ($book_cat) {
                        echo '<a href="lib_old_book_info.php" align="right">Show Full Report</a>';
                    }
                    echo "<h5 style='color:green;' align='right'>Total <u style='color:red; font-weight: bold;'>LLB " . $book_cat . " Year</u> Books : " . $num_data . "</h5><br>";

                    if (mysqli_num_rows($result1) > 0) {
                        $total_records = mysqli_num_rows($result1);
                        $total_page = ceil($total_records / $limit);

                        echo '<ul class="pagination admin-pagination">';

                        if ($page > 1) {
                            echo '<li><a class="page-link" href="lib_old_book_info.php?page=' . ($page - 1) . '&Category=' . $book_cat . '">Prev</a></li>';
                        }
                        if ($page >= 6) {
                            echo '<li><a class="page-link" href="lib_old_book_info.php?page=1&Category=' . $book_cat . '">1</a></li>';
                        }

                        for ($i = ($page - 2 >= 1) ? $page - 2 : $page - 1; $i <= $page - 1; $i++) {
                            if ($i >= 1) {
                                echo '<li><a class="page-link" href="lib_old_book_info.php?page=' . $i . '&Category=' . $book_cat . '">' . $i . '</a></li>';
                            }
                        }

                        for ($i = $page; $i <= (($page + 2) <= $total_page ? $page + 2 : $page + 1); $i++) {
                            $active = ($i == $page) ? "page-item active" : "";
                            if ($i <= $total_page - 1) {
                                echo '<li class="' . $active . '"><a class="page-link" href="lib_old_book_info.php?page=' . $i . '&Category=' . $book_cat . '">' . $i . '</a></li>';
                            }
                        }

                        echo '<li><a style="color:black;" class="page-link" href="lib_old_book_info.php?page=' . ($total_page) . '&Category=' . $book_cat . '">' . $total_page . '</a></li>';
                        if ($total_page > $page) {
                            echo '<li><a class="page-link" href="lib_old_book_info.php?page=' . ($page + 1) . '&Category=' . $book_cat . '">Next</a></li>';
                        }
                        echo '</ul>';
                    }

                    $result = execute_query($db, $sql);
                    $arrayBarcodes = array();

                    if (mysqli_num_rows($result) > 0) {
                    ?> 					
                        <table class="table table-striped table-hover" id="general_stat_table">
                            <thead class="thead-primary">
                                <tr align="center" >
                                    <th>S.No.</th>
                                    <th>Library Location</th>
                                    <th>Shelf Location</th>
                                    <th>Accession No</th>
                                    <th>Title</th>
                                    <th>Author Name</th>
                                    <th>Subject</th>
                                    <th>DDC Code</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = (isset($_GET['page'])) ? (($_GET['page'] - 1) * $limit) + 1 : 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr align="center">
                                        <td>' . $i++ . '</td>
                                        <td>' . $row['library_location'] . '</td>
                                        <td>' . $row['shelf_location'] . '</td>
                                        <td>' . $row['accession_no'] . '</td>
                                        <td>' . $row['title'] . '</td>
                                        <td>' . $row['author_name'] . '</td>
                                        <td>' . $row['subject'] . '</td>
                                        <td>' . $row['ddc_code'] . '</td>
                                    </tr>';
                                }
                            ?>
                            </tbody>
                        </table>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script type="text/javascript">
  // Convert JSON to JS array data.
  function arrayjsonbarcode(j) {
    json = JSON.parse(j);
    arr = [];
    for (var x in json) {
      arr.push(json[x]);
    }
    return arr;
  }

  // Convert PHP array to JSON data.
  jsonvalue = '<?php echo json_encode($arrayBarcodes) ?>';
  values = arrayjsonbarcode(jsonvalue);

  function getVal() {
    return values;
  }
</script>

</body>
</html>
