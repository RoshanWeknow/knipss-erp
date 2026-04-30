<?php 
include("scripts/settings.php");

$msg='';

page_header_start();
page_header_end();
page_sidebar();
?>

<div id="container">    
    <div class="card card-body">    
        <div class="row d-flex my-auto">  
            <div class="col-md-12">
                <!-- Filter by Class -->
                <form method="GET" id="filterForm">
                    <div class="form-group col-md-4" >
                        <label for="classFilter">Filter by Class:</label>
                        <select id="classFilter" name="class" class="form-control" onchange="document.getElementById('filterForm').submit();">
                            <option value="">ALL Class</option>
                            <?php
                                // Fetch distinct class values from the database for the dropdown
                                $classQuery = 'SELECT DISTINCT class FROM exam_examination_scheme';
                                $classResult = execute_query($db, $classQuery);
                                while ($classRow = mysqli_fetch_assoc($classResult)) {
                                    $selected = (isset($_GET['class']) && $_GET['class'] == $classRow['class']) ? 'selected' : '';
                                    echo '<option value="'.$classRow['class'].'" '.$selected.'>'.$classRow['class'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </form>

                <!-- Table -->
                <table width="100%" class="table table-striped table-hover rounded">
                    <tr class="bg-primary text-white" align="center">
                        <th>Sno</th>
                        <th>class</th>
                        <th>subject</th>
                        <th>subject_type</th>
                        <th>paper_code</th>
                        <th>paper_title</th>
                        <th>date</th>
                        <th>time</th>
                        <th>shift</th>
                    </tr>
                    <?php
                        // Fetch the filtered results based on the selected class
                        $filter = '';
                        if (isset($_GET['class']) && !empty($_GET['class'])) {
                            $filter = "WHERE class = '".mysqli_real_escape_string($db, $_GET['class'])."'";
                        }
                        
                        $sql = 'SELECT * FROM exam_examination_scheme '.$filter;
                        $result = execute_query($db, $sql);
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr align="center">
                                <td>'.$i++.'</td>
                                <td>'.$row['class'].'</td>
                                <td>'.$row['subject'].'</td>
                                <td>'.$row['subject_type'].'</td>
                                <td>'.$row['paper_code'].'</td>
                                <td>'.$row['paper_title'].'</td>
                                <td>'.$row['date'].'</td>
                                <td>'.$row['time'].'</td>
                                <td>'.$row['shift'].'</td>
                            </tr>';
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
page_footer_start();
page_footer_end();
?>
	