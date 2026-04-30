<?php
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg = '';
$tab = 1;
$responce = 0;

page_header_start();
page_header_end();
page_sidebar();

// Deletion
if (isset($_GET['del'])) {
    $sno = $_GET['del'];
    mysqli_query($db, "DELETE FROM exam_daily_examination_attendence WHERE sno='$sno'");
    mysqli_query($db, "DELETE FROM exam_daily_attendence2 WHERE exam_daily_attendence2_sno='$sno'");
}

// Filters
$where = "1";
if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
    $from = $_GET['from_date'];
    $to = $_GET['to_date'];
    $where .= " AND exam_date BETWEEN '$from' AND '$to'";
}
if (!empty($_GET['exam_shift'])) {
    $shift = $_GET['exam_shift'];
    $where .= " AND exam_shift = '$shift'";
}

// Get distinct shifts for dropdown
$shift_result = mysqli_query($db, "SELECT DISTINCT exam_shift FROM exam_daily_examination_attendence ORDER BY exam_shift ASC");

$sql = "SELECT * FROM exam_daily_examination_attendence WHERE $where ORDER BY exam_date DESC";
$result = mysqli_query($db, $sql);
?>

<!-- CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="row pt-5">
    <div class="col-md-12">
        <h3 class="bg-secondary text-white p-2 text-center">DETAILS OF DAILY EXAMINATION ATTENDANCE REPORT</h3>

        <!-- Filter Form -->
        <form method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label>From Date</label>
                    <input type="date" name="from_date" class="form-control" value="<?php echo $_GET['from_date'] ?? ''; ?>">
                </div>
                <div class="col-md-3">
                    <label>To Date</label>
                    <input type="date" name="to_date" class="form-control" value="<?php echo $_GET['to_date'] ?? ''; ?>">
                </div>
                <div class="col-md-3">
                    <label>Exam Shift</label>
                    <select name="exam_shift" class="form-control">
                        <option value="">-- All Shifts --</option>
                        <?php while ($shift_row = mysqli_fetch_assoc($shift_result)) { ?>
                            <option value="<?php echo $shift_row['exam_shift']; ?>" <?php if (isset($_GET['exam_shift']) && $_GET['exam_shift'] == $shift_row['exam_shift']) echo 'selected'; ?>>
                                <?php echo $shift_row['exam_shift']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-warning w-70">Filter</button>
                </div>
            </div>
        </form>

        <!-- Table -->
        <table class="table table-striped px-auto">
            <tr class="bg-secondary text-white p-2 text-center">
                <td>S.NO.</td>
                <td>Exam Date</td>
                <td>Exam Shift</td>
                <td>Shift Wise Student Count</td>
                <td>Total Student Reg</td>
                <td>Number Of Rooms</td>
                <td>CENTER SUPERINTENDENT</td>
                <td>ASSISTANT SUPERINTENDENT</td>
                <td>ROOM INVIGILATOR</td>
                <td>RELIEVER</td>
                <td>ALLOTED DUTY</td>
                <td>Total DUTY</td>
                <td>VIEW</td>
                <td>EDIT</td>
                <td>DELETE</td>
            </tr>
            <?php
            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $allotted_duty = $row['alloted_cs'] + $row['alloted_as'] + $row['alloted_ri'] + $row['alloted_relive'];
                $tot_duty = $row['max_allow_cs'] + $row['max_allow_as'] + $row['max_allow_ri'] + $row['max_allow_relive'];
            ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row['exam_date']; ?></td>
                    <td><?php echo $row['exam_shift']; ?></td>
                    <td><?php echo $row['shift_wise_stud_count']; ?></td>
                    <td><?php echo $row['total_reg_stud']; ?></td>
                    <td><?php echo $row['room_count']; ?></td>
                    <td><?php echo $row['alloted_cs']; ?></td>
                    <td><?php echo $row['alloted_as']; ?></td>
                    <td><?php echo $row['alloted_ri']; ?></td>
                    <td><?php echo $row['alloted_relive']; ?></td>
                    <td><?php echo $allotted_duty; ?></td>
                    <td><?php echo $tot_duty; ?></td>
                    <td><a href="exam_daily_attendence_print.php?edit=<?php echo $row['sno']; ?>" class="btn btn-success" target="_blank">View</a></td>
                    <td><a href="exam_daily_examination_attendence.php?edit=<?php echo $row['sno']; ?>" class="btn btn-primary" target="_blank">Edit</a></td>
                    <td><a href="exam_daily_attendence_report.php?del=<?php echo $row['sno']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

<?php
page_footer_start();
page_footer_end();
?>
