<?php
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");

// Load composer autoloader for packages installed by composer
require_once __DIR__ . '/vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;

page_header_start();
page_header_end();
page_sidebar();

$conn = $db;
if (!$conn) {
    echo "Connection failed<br>";
    die();
}

$db_year = substr($_SESSION['db_name'], -4); // Example: 2025

$BASE_DIR = 'exam_student_bar_image/';
$BAR_FOLDER = $BASE_DIR . $db_year . '/';

// Ensure folders exist
if (!file_exists($BASE_DIR)) mkdir($BASE_DIR, 0777, true);
if (!file_exists($BAR_FOLDER)) mkdir($BAR_FOLDER, 0777, true);

// Handle form submission to update barcode paths in DB
if (isset($_POST['submit2'])) {
    if (isset($_POST["student_name"])) {
        foreach ($_POST["student_name"] as $sno => $val) {
            if (isset($_POST['barcode_path'][$sno])) {
                $path = $_POST['barcode_path'][$sno];
                $sno_safe = mysqli_real_escape_string($conn, $sno);
                $path_safe = mysqli_real_escape_string($conn, $path);

                $sql = "UPDATE exam_student_info SET bar_code = '$path_safe' WHERE sno = '$sno_safe'";
                mysqli_query($conn, $sql);

                if (mysqli_errno($conn)) {
                    echo "Barcode update failed: " . mysqli_errno($conn) . " - " . mysqli_error($conn) . "<br>";
                }
            }
        }
        echo "<div class='alert alert-success text-center'>Barcode paths saved in database successfully.</div>";
    }
}
?>

<div class="row">
    <h2 class="bg-secondary text-white text-center p-2">EXAM STUDENT BARCODE GENERATE REPORT</h2>
    <form method="POST">
        <div class="row">
            <div class="col-md-3">
                <label for="class_filter">Class</label>
                <select id="class_filter" name="class_filter" class="form-control" required>
                    <option value="">Select Class</option>
                    <?php
                    $class_query = 'SELECT * FROM class_detail WHERE semester IN ("1", "3", "2", "4") ORDER BY ABS(group_short) ASC';
                    $class_result = mysqli_query($db, $class_query);
                    while ($class_row = mysqli_fetch_assoc($class_result)) {
                        $selected = (isset($_POST['class_filter']) && $_POST['class_filter'] == $class_row['sno']) ? 'selected' : '';
                        echo '<option value="' . $class_row['sno'] . '" ' . $selected . '>' . htmlspecialchars($class_row['class_description']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label>&nbsp;</label><br>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>

        <div class="card-body mt-4">
            <table class="table table-striped table-hover table-bordered" id="general_stat_table">
                <thead>
                    <tr class="bg-primary text-white text-center">
                        <th>S.No.</th>
                        <th>Full Name</th>
                        <th>Father Name</th>
                        <th>Class</th>
                        <th>Date of Birth</th>
                        <th>Mobile No</th>
                        <th>Exam Form No</th>
                        <th>Roll No</th>
                        <th>UIN Number</th>
                        <th>Barcode</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($_POST['class_filter'])) {
                        $class_filter = mysqli_real_escape_string($conn, $_POST['class_filter']);
                        $sql1 = "SELECT * FROM exam_student_info WHERE exam_form_no IS NOT NULL AND course_name='$class_filter' ORDER BY exam_form_no";
                        $result = mysqli_query($db, $sql1);

                        if (mysqli_num_rows($result) > 0) {
                            $generator = new BarcodeGeneratorPNG();

                            while ($row = mysqli_fetch_assoc($result)) {
                                $sno = $row['sno'];
                                $student_info = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM student_info WHERE sno="' . $row['student_info_sno'] . '"'));
                                $class = mysqli_fetch_assoc(mysqli_query($db, 'SELECT * FROM class_detail WHERE sno="' . $row['course_name'] . '"'));

                                // Barcode image path
                                $barcode_path = $BAR_FOLDER . $sno . '.png';

                                // Generate barcode image with white background and roll number text if it doesn't exist
                                if (!file_exists($barcode_path)) {
									// var_dump($row["exam_roll_no"]);
                                    $barcodeData = $row["exam_roll_no"];
                                    $barcodeImageRaw = $generator->getBarcode($barcodeData, $generator::TYPE_CODE_128);

										var_dump($barcodeData);
                                    // Create image from raw barcode PNG data
                                    $barcodeImg = imagecreatefromstring($barcodeImageRaw);

                                    // Get barcode width and height
                                    $barcodeWidth = imagesx($barcodeImg);
                                    $barcodeHeight = imagesy($barcodeImg);

                                    // Create new image with white background and extra height for text
                                    $textHeight = 20;
                                    $finalHeight = $barcodeHeight + $textHeight;
                                    $finalImg = imagecreatetruecolor($barcodeWidth, $finalHeight);

                                    // White background
                                    $white = imagecolorallocate($finalImg, 255, 255, 255);
                                    imagefill($finalImg, 0, 0, $white);

                                    // Copy barcode onto white background
                                    imagecopy($finalImg, $barcodeImg, 0, 0, 0, 0, $barcodeWidth, $barcodeHeight);

                                    // Text color (black)
                                    $black = imagecolorallocate($finalImg, 0, 0, 0);

                                    // Add roll number text centered below the barcode
                                    $fontSize = 3; // built-in font size (1-5)
                                    $text = $barcodeData;
                                    $textBoxWidth = imagefontwidth($fontSize) * strlen($text);
                                    $textX = ($barcodeWidth - $textBoxWidth) / 2;
                                    $textY = $barcodeHeight + 2; // padding below barcode

                                    imagestring($finalImg, $fontSize, $textX, $textY, $text, $black);

                                    // Save final image as PNG
                                    imagepng($finalImg, $barcode_path);

                                    // Free memory
                                    imagedestroy($barcodeImg);
                                    imagedestroy($finalImg);
                                }

                                echo '<tr align="center">
                                    <td>' . $sno . '</td>
                                    <td><input type="text" name="student_name[' . $sno . ']" class="form-control" value="' . htmlspecialchars($row['student_name']) . '"></td>
                                    <td><input type="text" name="father_name[' . $sno . ']" class="form-control" value="' . htmlspecialchars($student_info['father_name']) . '"></td>
                                    <td><input type="text" name="class_description[' . $sno . ']" class="form-control" value="' . htmlspecialchars($class['class_description']) . '"></td>
                                    <td><input type="text" name="dob['.$sno.']" class="form-control" value="' . htmlspecialchars(date("d-m-Y", strtotime($row['dob']))) . '"></td>
                                    <td><input type="text" name="mobile_no[' . $sno . ']" class="form-control" value="' . htmlspecialchars($row['mobile_no']) . '"></td>
                                    <td><input type="text" name="exam_form_no[' . $sno . ']" class="form-control" value="' . htmlspecialchars($row['exam_form_no']) . '"></td>
                                    <td><input type="text" name="exam_roll_no[' . $sno . ']" class="form-control" value="' . htmlspecialchars($row['exam_roll_no']) . '"></td>
                                    <td><input type="text" name="uin_no[' . $sno . ']" class="form-control" value="' . htmlspecialchars($row['uin_no']) . '"></td>
                                    <td>
                                        <img src="' . $barcode_path . '" height="60" alt="Barcode"><br>
                                        <input type="hidden" name="barcode_path[' . $sno . ']" value="' . $barcode_path . '">
                                    </td>
                                </tr>';
                            }
                        } else {
                            echo '<tr><td colspan="10" class="text-center text-danger">No data found for selected class.</td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="10" class="text-center text-danger">Please select a class to view the data.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>

            <?php if (!empty($_POST['class_filter']) && isset($result) && mysqli_num_rows($result) > 0): ?>
                <div class="text-center">
                    <button type="submit" name="submit2" class="btn btn-success">Generate Barcodes</button>
                </div>
            <?php endif; ?>
        </div>
    </form>
</div>

<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>

<?php
page_footer_start();
page_footer_end();
?>
