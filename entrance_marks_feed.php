<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");

page_header_start();
page_header_end();
page_sidebar();

$course_filter = isset($_GET['course_filter']) ? $_GET['course_filter'] : '';

if(isset($_GET['course_filter'])){
	$classes = array(76, 60, 87);
	if(!in_array($_GET['course_filter'], $classes)){
		$sql = 'SELECT phd_entrance_admission_student_info.sno as sno, phd_entrance_admission_student_info.uin as uin, phd_entrance_admission_student_info.course_applying_for as course_applying_for, phd_entrance_admission_student_info.candidate_name as candidate_name, phd_entrance_admission_student_info.father_name as father_name, phd_entrance_admission_student_info.gender as gender, phd_entrance_admission_student_info.category as category, phd_entrance_admission_student_info.mobile as mobile, phd_entrance_admission_student_info.email as email, phd_entrance_admission_student_info.signature as signature, phd_entrance_admission_student_info.photo as photo, phd_entrance_student_info.roll_no as roll_no FROM phd_entrance_admission_student_info LEFT JOIN phd_entrance_student_info ON phd_entrance_student_info.sno = phd_entrance_admission_student_info.student_id WHERE phd_entrance_admission_student_info.course_applying_for = "' . $course_filter . '" ORDER BY phd_entrance_student_info.roll_no';
	}
	else{
		$sql = 'SELECT entrance_admission_student_info.sno as sno, entrance_admission_student_info.uin as uin, entrance_admission_student_info.course_applying_for as course_applying_for, entrance_admission_student_info.candidate_name as candidate_name, entrance_admission_student_info.father_name as father_name, entrance_admission_student_info.gender as gender, entrance_admission_student_info.category as category, entrance_admission_student_info.mobile as mobile, entrance_admission_student_info.email as email, entrance_admission_student_info.signature as signature, entrance_admission_student_info.photo as photo, entrance_student_info.roll_no as roll_no FROM entrance_admission_student_info LEFT JOIN entrance_student_info ON entrance_student_info.sno = entrance_admission_student_info.student_id WHERE entrance_admission_student_info.course_applying_for = "' . $course_filter . '" ORDER BY entrance_student_info.roll_no';
	}
	//echo $sql;
	$res = mysqli_query($db2, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <title>Candidate Confirmation Form !</title>
    <style>
        body {
            font-family: "Roboto", sans-serif;
            font-size: .8rem;
        }

        h1 {
            font-size: 1.8rem !important;
        }

        h2 {
            font-size: 1.5rem !important;
        }

        h3 {
            font-size: 1.3rem !important;
        }

        h4 {
            font-size: 1rem !important;
        }

        p {
            font-size: .6rem !important;
        }

        td {
            font-size: 13px !important;
            font-weight: bolder;
        }

        th {
            font-size: 12px !important;
        }

        table {
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .bold {
            font-weight: bold;
        }

        .photo-sign {
            text-align: center;
        }

        .photo-sign img {
            width: 100px;
            height: 100px;
        }

        .no-top-border {
            border-top: none !important;
        }

        .placeholder {
            color: #a9a9a9;
            font-style: italic;
        }

        @media print {
            .head-name {
                font-size: 15.5px !important;
            }

            #overlays {
                width: 50% !important;
                top: 40% !important;
                -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
            }

            th, td {
                font-size: 13px;
                padding: 0px;
            }

            .print_no {
                display: none !important;
            }

            .btn-print {
                display: none;
            }
        }

        @page {
            size: A4;
            margin-inline: 0;
            padding: 0;
        }
    </style>
    <link rel="stylesheet" href="style.css" media="print">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,700&display=swap" rel="stylesheet" />
</head>

<body class="w-100 m-auto">
    <h2 scope="col" colspan="5" class="bg-primary text-white text-center p-3 no-print"><u>ENTRANCE EXAMINATION VERIFICATION 2024</u></h2>
    <div class="container mt-3">
        <div class="row mb-3 no-print">
            <div class="col-md-4">
                <select id="filterDropdown" class="form-select">
                    <option value="">All Classes</option>
                    <?php
                    $sql_class_options = 'SELECT * FROM class_detail WHERE sno IN (230, 244, 129, 257, 256, 255, 123, 228, 128, 258, 260, 259, 127, 76, 60, 87)';
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

    <div class="container-fluid m-auto cont">
        <div class="container-fluid border">
            <div id="candidateTable" class="table-responsive">
                <div class="d-flex justify-content-center">
                    <button class="btn btn-secondary btn-print" onclick="window.print()">Print</button>
                </div>
                <img src="images/college_log.png" id="overlays" style="z-index:-2;opacity:0.15;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%);width:30%;" alt="overlay image">
				<table width="100%" style="margin:0px;">
					<tr>
						<th width="12%" rowspan="2"><img style="padding:15px; height:65px; width:65px; " src="images/college_log.png" alt="logo" class="img-fluid d-block m-auto" /> </th>
						<th width="88%">
							<h4 class="" style="text-align: center; margin:0px; " ><span style="font-size:17px;white-space:nowrap;" class="head-name"><b>Kamla Nehru Institute Of Physical & Social Sciences,Sultanpur, Uttar Pradesh</b></span> <br>An Autonomous Institute And Accredited "A" Grade by NAAC</h4>
						</th>
					</tr>
					<tr>
						
						<th width="88%">
							<h6 class="" style="text-align: center; margin:0px; " ><span style="font-size:17px;white-space:nowrap;" class="head-name"><b><u>(Entrance Exam Attendance Sheets 2024)</u></h6>
						</th>
					</tr>
				</table>
				<h4 class="text-end me-5">Course Name :</h4>
				<h4 class="text-end me-5">Page No. :</h4>
                <?php
                $serial_no = 1;
                if($res && mysqli_num_rows($res) > 0){
                    while($row = mysqli_fetch_assoc($res)){
                        $sql_class = 'SELECT * FROM class_detail WHERE sno = "' . $row['course_applying_for'] . '"';
                        $row_class = mysqli_fetch_assoc(mysqli_query($db, $sql_class));
                ?>
                        <table width="100%" class="table table-border border-dark" >
                            <tr>
                                <td width="40%">Candidate's Particulars</td>
                                <td width="12%" rowspan="2" class="photo-sign bold"><img src="<?php echo $row['photo']; ?>" style="height:70px; width:90px;"></td>
                                <td width="15%" class="bold">Test Booklet No.</td>
                                <td width="17%" class="bold"></td>
                                <td width="15%" class="bold photo-sign">Signature</td>
                            </tr>
                            <tr>
                                <td class="bold">Roll No.:<?php echo $row['roll_no']; ?>&nbsp; Form No.: <?php echo $row['uin']; ?><br>Name:<?php echo $row['candidate_name']; ?><br></td>
                                <td class="bold">Test Booklet Series</td>
                                <td></td>
                                <td class="photo-sign bold placeholder">Candidate</td>
                            </tr>
                            <tr>
                                <td class="bold no-top-border" style="border: none;">Father’s Name:<?php echo $row['father_name']; ?></td>
                                <td class="photo-sign bold"><img src="<?php echo $row['signature']; ?>" style="height:30px; width:90px;"></td>
                                <td class="bold">OMR Sheet No.</td>
                                <td class="bold"></td>
                                <td class="photo-sign bold placeholder">Invigilator</td>
                            </tr>
                        </table>
                <?php
                    }
                } else {
                    echo "<p>No records found.</p>";
                }
                ?>
				<h5>* Please Mark the Absentee in RED Ink</h5>
				<h5 class="text-end me-2 mt-2">Signature & Seal of Centre</h5>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchButton').addEventListener('click', function() {
            var selectedValue = document.getElementById('filterDropdown').value;
            var candidateTable = document.getElementById('candidateTable');
            if (selectedValue) {
                window.open("entrance_marks_feed_print.php?course_filter=" + selectedValue);
            }
        });

        // Initially hide the table if no filter is applied
        document.addEventListener("DOMContentLoaded", function() {
            var courseFilter = "<?php echo $course_filter; ?>";
            var candidateTable = document.getElementById('candidateTable');
            if (!courseFilter) {
                candidateTable.style.display = 'none';
            } else {
                candidateTable.style.display = 'block';
            }
        });
    </script>
    <?php 
	page_footer_start();
	page_footer_end();

	?>
</body>

</html>
