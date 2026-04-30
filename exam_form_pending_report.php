<?php 
include("scripts/settings.php");
page_header_start();
$response=1;
$msg='';
page_header_end();
page_sidebar();

if(!isset($_POST['from_date'])){
    $_POST['from_date'] = date("Y-m-d");
    $_POST['to_date'] = date("Y-m-d");
    $_POST['exam_name'] = '';
}
else{
    if($_POST['exam_name'] != ''){
        $_POST['exam_name'] = ' and exam_id="'.$_POST['exam_name'].'"';
    }
}
?>
<style>
    .table td { font-size: 11px; }
</style>

<div class="row">
    <h2 class="bg-secondary text-white text-center p-2">FORM VERIFICATION REPORT</h2>
    <form method="POST">
        <div class="row">
            <div class="col-md-3">
                <label for="class_filter">Class</label>
                <select id="class_filter" name="class_filter" class="form-control">
                    <option value="">All Classes</option>
                    <?php
                    $class_query = 'SELECT * FROM class_detail WHERE semester IN ("1","3","2","4") ORDER BY ABS(group_short) ASC';
                    $class_result = mysqli_query($db, $class_query);
                    while ($class_row = mysqli_fetch_assoc($class_result)) {
                        echo '<option value="'.$class_row['sno'].'">'.$class_row['class_description'].'</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-3">
                <label for="verify_status">Verify Status</label>
                <select id="verify_status" name="verify_status" class="form-control">
                    <option value="">All</option>
                    <option value="1">Verified</option>
                    <option value="0">Not Verified</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="session_status">Exam Session</label>
                <select id="session_status" name="session_status" class="form-control">
                    <option value="">All</option>
                    <option value="odd">Odd</option>
                    <option value="even">Even</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>&nbsp;</label><br>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <div class="card-body">
        <table class="table table-striped table-hover table-bordered" id="general_stat_table">
            <tr class="bg-primary text-white" align="center">
                <td>S.No.</td>
                <td>Full Name</td>
                <td>Father Name</td>
                <td>Class</td>
                <td>Semester</td>
                <td>Date of Birth</td>
                <td>Mobile No</td>
                <td>Exam Form No</td>
                <td>Roll No</td>
                <td>Verify Status</td>
                <td>Verified By</td>
                <td>Verified Time</td>
            </tr>
            <?php
            // Check if any filters are applied
            $filtersApplied = !empty($_POST['exam_name']) || !empty($_POST['class_filter']) || isset($_POST['verify_status']) || !empty($_POST['session_status']);

            if ($filtersApplied) {
                // Main Query with Joins to include semester from class_detail
                $sql1 = 'SELECT e.*, s.father_name, c.class_description, c.semester 
                         FROM exam_student_info e
                         JOIN student_info s ON e.student_info_sno = s.sno
                         JOIN class_detail c ON e.course_name = c.sno
                         WHERE e.exam_form_no IS NOT NULL';

                if (!empty($_POST['exam_name'])) {
                    $sql1 .= ' AND e.exam_id="'.$_POST['exam_name'].'"';
                }
                if (!empty($_POST['class_filter'])) {
                    $sql1 .= ' AND e.course_name="'.$_POST['class_filter'].'"';
                }
                if (isset($_POST['verify_status']) && $_POST['verify_status'] !== '') {
                    $sql1 .= ' AND e.verify_status="'.$_POST['verify_status'].'"';
                }
                if (!empty($_POST['session_status'])) {
                    if ($_POST['session_status'] == 'odd') {
                        $sql1 .= ' AND c.semester IN ("1", "3", "5")';
                    } elseif ($_POST['session_status'] == 'even') {
                        $sql1 .= ' AND c.semester IN ("2", "4", "6")';
                    }
                }

                $sql1 .= ' ORDER BY e.exam_form_no';

                $result = mysqli_query($db, $sql1);
                $i=1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr align="center">
                        <td>'.$i++.'</td>
                        <td>'.$row['student_name'].'</td>
                        <td>'.$row['father_name'].'</td>
                        <td>'.$row['class_description'].'</td>
                        <td>'.$row['semester'].'</td>
                        <td>'.date("d-m-Y", strtotime($row['dob'])).'</td>
                        <td>'.$row['mobile_no'].'</td>
                        <td>'.$row['exam_form_no'].'</td>
                        <td>'.$row['college_roll_no'].'</td>
                        <td>';
                        if ($row['verify_status'] == 1) {
                            echo '<button class="btn btn-success btn-sm">Verified</button>';
                        } else {
                            echo '<button class="btn btn-danger btn-sm">Pending</button>';
                        }
                        echo '</td>
                        <td>'.$row['verify_by'].'</td>
                        <td>'.$row['verify_time'].'</td>
                    </tr>';
                }
            }
            ?>
        </table>
    </div>
</div>

<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<script>
$(document).ready(function () {
    $('#general_stat_table').DataTable({
        paging: false
    });
});

function toggleVerifyStatus(studentId, newStatus) {
    let action = newStatus === 1 ? 'verify' : 'unverify';
    let confirmMessage = `Are you sure you want to ${action} this student?`;

    if (confirm(confirmMessage)) {
        $.ajax({
            url: 'exam_update_verify_status.php',
            type: 'POST',
            data: {
                student_info_sno: studentId,
                verify_status: newStatus
            },
            success: function(response) {
                location.reload();
            },
            error: function() {
                alert('Error updating the status. Please try again.');
            }
        });
    }
}
</script>

<?php 
page_footer_start(); 
page_footer_end(); 
?>
