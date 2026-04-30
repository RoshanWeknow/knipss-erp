<?php 
include("scripts/settings.php");
$msg='';
page_header_start();
page_header_end();
page_sidebar();

?>
<?php
 $containerCase = 1;
?>
<style>
@media print {
	#noprint{
		display:none;
	}
}
</style>
<div id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"  enctype="multipart/form-data" method="POST" onSubmit="" autocomplete="off">
					<div class="col-md-12 align-right">
						<h4><a href="examination_scheme_date.php">Scheme Master</a></h4>
						<div style="text-align:right;">
							<button align="" class="btn btn-primary"onclick="window.print()" id="noprint">Print this page</button>
						</div>
						
					</div>
					<table class="table table-striped table-bordered">
						<tr>
							<th>S.No.</th>
							<th>Exam Name</th>
							<th>Classes</th>
							<th>Class ID</th>
							<th>Date From</th>
							<th>Date To</th>
						</tr>
						<?php
						$sql = 'select * from exam_exam_invoice';
						//echo $sql;
						$result_exam = execute_query($db, $sql);
					  	$i=1;
						$date1 = '';
						$date2 = '';
						while($row_exam = mysqli_fetch_assoc($result_exam)){
							$query_class = 'SELECT * FROM class_detail WHERE sno ="'.$row_exam['appared_class'].'"';
							$result_class = mysqli_fetch_assoc(execute_query($db, $query_class));
							if($row_exam['date1']) {
								$date1 = date( 'd-m-Y', strtotime($row_exam['date1']));
							}
							if($row_exam['date2']) {
								$date2 = date( 'd-m-Y', strtotime($row_exam['date2']));
							}
							echo '<tr>
							<td>'.$i++.'</td>
							<td>'.$row_exam['examination_name'].'</td>
							<td>'.$result_class['class_description'].'</td>
							<td>'.$row_exam['appared_class'].'</td>
							<td>'.$date1.'</td>
							<td>'.$date2.'</td>
							</tr>';
						}
						?>
					</table>
			</div>
		</div>
	</div>
</div>
<?php
switch ($containerCase) {
    case 2:
        ?>
<div id="container">
        <div class="card card-body">
			<div class="bg-primary text-white p-2 mb-2"><h3>All Subjects and Papers</h3></div>
				<?php
					$inClause = implode(', ', $_POST['brandslist']);
					
					$sql = "SELECT * FROM class_detail WHERE sno IN ($inClause)";
					
					$result = execute_query($db, $sql);
					
					while ($row = mysqli_fetch_assoc($result)) {
                echo '<table width="100%" class="table table-striped table-hover rounded">
                        <tr>
                            <th colspan="5"><h5>' . $row['class_description'] . '</h5></th>
                        </tr>
                        <tr class="text-white bg-primary" align="center" style="position:sticky;top:0;z-index:2;">
                            <th>Sno.</th>
                            <th>Class Name</th>
                            <th>Subject</th>
                            <th>Subject Type</th>
                            <th>Papers Code</th>
                            <th>Papers Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Shift</th>
                        </tr>';
                $sql2 = 'SELECT * FROM add_subject_details INNER JOIN add_subject ON add_subject.sno = add_subject_details.subject_id WHERE class_id = "' . $row['sno'] . '" AND theory_practical="Theory"';
				
				$sql2 = 'SELECT add_subject_details.sno as sno, add_subject_details.type as type, add_subject_details.paper_code as paper_code, title_of_paper, subject_id, subject FROM add_subject_details INNER JOIN add_subject ON add_subject.sno = add_subject_details.subject_id WHERE class_id = "' . $row['sno'] . '"';
				//echo $sql2;
                $res = mysqli_query($db, $sql2);
                $i = 1;

                while ($row_subject = mysqli_fetch_assoc($res)) {
                    echo '<tr>
                            <td>' . $i++ . '</td>
                            <td>' . $row['class_description'] . '</td>
                            <td>' . $row_subject['subject'] . ' (' . $row_subject['sno'] . ')</td>
                            <td>' . $row_subject['type'] . '</td>
                            <td>' . $row_subject['paper_code'] . '</td>
                            <td>' . $row_subject['title_of_paper'] . '</td>
                            <td><input type="date" name="ex_date_' . $row_subject['sno'] . '" value="" class="form-control"></td>
                            <td><input type="time" name="ex_time_' . $row_subject['sno'] . '" value="" class="form-control"></td>
                            <td>
                                <select name="ex_shift_' . $row_subject['sno'] . '" class="form-control">
                                    <option selected disabled>--Select--</option>
                                    <option value="1">Morning</option>
                                    <option value="2">Evening</option>
                                </select>
                            </td>
                          </tr>
                          <input type="hidden" name="ex_class_' . $row_subject['sno'] . '" value="' . $row['class_description'] . '">
                          <input type="hidden" name="ex_subject_' . $row_subject['sno'] . '" value="' . $row_subject['subject'] . '">
                          <input type="hidden" name="ex_type_' . $row_subject['sno'] . '" value="' . $row_subject['type'] . '">
                          <input type="hidden" name="ex_paper_code_' . $row_subject['sno'] . '" value="' . $row_subject['paper_code'] . '">
                          <input type="hidden" name="ex_title_' . $row_subject['sno'] . '" value="' . $row_subject['title_of_paper'] . '">';
					}
				}
				echo '</table>';
				?>
				<div style="display:flex;justify-content:flex-end;">
					<button class="btn btn-primary" name="submit" type="submit">submit</button>
				</div>
			</form>
		</div>
    </div>
<?php
	break;
default:
}
page_footer_start();
page_footer_end();
?>	