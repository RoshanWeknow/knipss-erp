<?php
include("scripts/settings.php");

page_header_start();
page_header_end();
page_sidebar();

$course_filter = isset($_GET['course_filter']) ? $_GET['course_filter'] : '';

$sql = 'SELECT entrance_admission_student_info.sno as sno, entrance_admission_student_info.uin as uin,entrance_admission_student_info.course_applying_for as course_applying_for,entrance_admission_student_info.candidate_name as candidate_name, entrance_admission_student_info.father_name as father_name, entrance_admission_student_info.gender as gender, entrance_admission_student_info.category as category, entrance_admission_student_info.mobile as mobile, entrance_admission_student_info.email as email, entrance_student_info.roll_no as roll_no 
FROM entrance_admission_student_info 
LEFT JOIN entrance_student_info on entrance_student_info.sno = entrance_admission_student_info.student_id';

if ($course_filter) {
    $sql .= ' WHERE entrance_admission_student_info.course_applying_for = "' . $course_filter . '"';
}

$sql .= ' ORDER BY entrance_student_info.roll_no';

$res = mysqli_query($db2, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <title>Candidate Confirmation Form !</title>
    <!-- css  -->
    <!-- <link rel="stylesheet" href="style.css" media="print"> -->
    <!-- googlefont -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,700&display=swap" rel="stylesheet" />
</head>
<body class="w-100 m-auto">
    

    <div class="table-responsive ">
        <h2 scope="col" colspan="5" class="bg-primary text-white text-center p-3"><u>Ph.D ENTRANCE EXAMINATION REPORT 2024</u></h2>
		<div class="container mt-3">
        <div class="row mb-3">
            <div class="col-md-4">
                <select id="filterDropdown" class="form-select">
                    <option value="">All Classes</option>
                    <?php
                        $sql_class_options = 'SELECT * FROM class_detail WHERE sno IN (76, 60, 87)';

                        $res_class_options = mysqli_query($db, $sql_class_options);
                        while ($row_class_options = mysqli_fetch_assoc($res_class_options)) {
                            echo '<option value="' . $row_class_options['sno'] . '">' . $row_class_options['class_description'] . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <button id="searchButton" class="btn btn-primary">Search</button>
            </div>
        </div>
    </div>
        <table width="100%" class="table table-bordered border">
            <tr class="bg-primary text-white">
                <th scope="col">Sr. No</th>
                <th scope="col">Roll No.</th>
                <th scope="col">Registration No.</th>
                <th scope="col">Course Name</th>
                <th scope="col">Course Code</th>
                <th scope="col">Student Name</th>
                <th scope="col">Father Name</th>
                <th scope="col">Gender</th>
                <th scope="col">Category</th>
                <th scope="col">Mobile No.</th>
                <th scope="col">Email</th>
            </tr>
            <?php
                $serial_no = 1;
                if($res){
                    while($row = mysqli_fetch_assoc($res)){
                        $sql_class = 'SELECT * FROM class_detail WHERE sno = "' . $row['course_applying_for'] . '"';
                        $row_class = mysqli_fetch_assoc(mysqli_query($db, $sql_class));
            ?>
            <tr>
                <th><?php echo $serial_no++ ?></th>
                <th scope="col"><?php echo $row['roll_no']; ?></th>
                <th scope="col"><?php echo $row['uin']; ?></th>
                <th scope="col"><?php echo $row_class['class_description']; ?></th>
                <th scope="col"><?php echo $row_class['course_code']; ?></th>
                <th scope="col"><?php echo $row['candidate_name']; ?></th>
                <th scope="col"><?php echo $row['father_name']; ?></th>
                <th scope="col"><?php echo $row['gender']; ?></th>
                <th scope="col"><?php echo $row['category']; ?></th>
                <th scope="col"><?php echo $row['mobile']; ?></th>
                <th scope="col"><?php echo $row['email']; ?></th>
            </tr>
            <?php 
                    }        
                }
            ?>
        </table>
    </div>

    <script>
    document.getElementById('searchButton').addEventListener('click', function() {
        var selectedValue = document.getElementById('filterDropdown').value;
        window.location.href = "?course_filter=" + selectedValue;
    });
    </script>
</body>
</html>
