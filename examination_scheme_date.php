<?php 
include("scripts/settings.php");
$msg='';
page_header_start();
page_header_end();
page_sidebar();

?>
<?php
 $containerCase = 1;
if(isset($_POST['save'])){
	
    $containerCase = 2;
}

if(isset($_POST['submit'])){
	$brandlist = implode(', ', $_POST['brandslist']);
	 $sql = 'INSERT INTO `exam_exam_invoice`(`examination_name`, `date1`, `date2`, `appared_class`, `created_by`, `creation_time`) VALUES ("'.$_POST['examination_name'].'",
                    "'.$_POST['date_from'].'",
                    "'.$_POST['date_to'].'",
                    "'.$brandlist.'",
                    "'.$_SESSION['username'].'",
                    "'.date("d-m-y H:i:s").'")';
    mysqli_query($db, $sql);
	$exam_id = mysqli_insert_id($db);
	foreach($_POST['brandslist'] as $k=>$v){
		$sql2 = 'SELECT add_subject_details.sno as sno, add_subject_details.type as type, add_subject_details.paper_code as paper_code, title_of_paper, subject_id, subject FROM add_subject_details INNER JOIN add_subject ON add_subject.sno = add_subject_details.subject_id WHERE class_id = "' . $v . '" and type_status=1';
		echo $sql2;
		$res = mysqli_query($db, $sql2);
		$i = 1;

		while ($row_subject = mysqli_fetch_assoc($res)) {
			if($_POST['ex_date1_'.$row_subject['sno']]!=''){
				$sql = 'insert into exam_examination_scheme (`exam_exam_invoice_sno`, `class`, `subject`, `subject_type`, `paper_code`, paper_title, `date`, `time`, `shift`, `created_by`, `creation_time`, `add_subject_details_sno`) VALUES ("'.$exam_id.'",
                    "'.$_POST['ex_class1_'.$row_subject['sno']].'",
                    "'.$_POST['ex_subject1_'.$row_subject['sno']].'",
                    "'.$_POST['ex_type1_'.$row_subject['sno']].'",
                    "'.$_POST['ex_paper_code1_'.$row_subject['sno']].'",
                    "'.$_POST['ex_title1_'.$row_subject['sno']].'",
                    "'.$_POST['ex_date1_'.$row_subject['sno']].'",
                    "'.$_POST['ex_time1_'.$row_subject['sno']].'",
                    "'.$_POST['ex_shift1_'.$row_subject['sno']].'",
                    "'.$_SESSION['username'].'",
                    "'.date("d-m-y H:i:s").'", "'.$row_subject['sno'].'")';
				$result = mysqli_query($db, $sql);
				if(mysqli_errno($db)){
					echo "Insertion failed: ".mysqli_errno($db).mysqli_error($db);
				}
				else{
					echo "Data inserted";
				}
			}
		}
		
		$sql2 = 'SELECT add_subject_details.sno as sno, add_subject_details.type as type, add_subject_details.paper_code as paper_code, title_of_paper, subject_id, subject FROM add_subject_details INNER JOIN add_subject2 ON add_subject2.sno = add_subject_details.subject_id WHERE class_id = "' . $v . '" and type_status=2';
		echo $sql2;
		$res = mysqli_query($db, $sql2);
		$i = 1;

		while ($row_subject = mysqli_fetch_assoc($res)) {
			if($_POST['ex_date2_'.$row_subject['sno']]!=''){
				$sql = 'insert into exam_examination_scheme (`exam_exam_invoice_sno`, `class`, `subject`, `subject_type`, `paper_code`, paper_title, `date`, `time`, `shift`, `created_by`, `creation_time`, `add_subject_details_sno`) VALUES ("'.$exam_id.'",
                    "'.$_POST['ex_class2_'.$row_subject['sno']].'",
                    "'.$_POST['ex_subject2_'.$row_subject['sno']].'",
                    "'.$_POST['ex_type2_'.$row_subject['sno']].'",
                    "'.$_POST['ex_paper_code2_'.$row_subject['sno']].'",
                    "'.$_POST['ex_title2_'.$row_subject['sno']].'",
                    "'.$_POST['ex_date2_'.$row_subject['sno']].'",
                    "'.$_POST['ex_time2_'.$row_subject['sno']].'",
                    "'.$_POST['ex_shift2_'.$row_subject['sno']].'",
                    "'.$_SESSION['username'].'",
                    "'.date("d-m-y H:i:s").'", "'.$row_subject['sno'].'")';
				$result = mysqli_query($db, $sql);
				if(mysqli_errno($db)){
					echo "Insertion failed: ".mysqli_errno($db).mysqli_error($db);
				}
				else{
					echo "Data inserted";
				}
			}
		}
	}	
}
?>
<div id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit"  enctype="multipart/form-data" method="POST" onSubmit="" autocomplete="off">
					<div class="col-md-12 align-right">
						<h4><a href="exam_scheme_report.php">Scheme Report</a></h4>
					</di>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr>	
							<th width="15%">Examination Name</th>	
							<th width="20%"><input type="text" name="examination_name" id="examination_name" value="<?php echo isset($_POST['examination_name'])? $_POST['examination_name']: ''; ?>" class="form-control" >
							</th>
							<th width="15%">From</th>	
							<th width="20%"><input type="date" name="date_from" id="date_from" value="<?php echo isset($_POST['examination_name'])? $_POST['date_from']: ''; ?>" class="form-control">
							</th>
							<th width="15%">To</th>	
							<th width="20%"><input type="date" name="date_to" id="date_to" value="<?php echo isset($_POST['examination_name'])? $_POST['date_to']: ''; ?>" class="form-control">
						</tr>
						<tr>	
							<th width="15%">Select Class</th>
					</table>
                        <?php
                            $class_query = "SELECT * FROM class_detail where semester in ('1','3','2','4') and class_description like '%Sem%' ORDER BY ABS(group_short) ASC";
                            $query_run = mysqli_query($db, $class_query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                foreach($query_run as $class)
                                {
                                    ?>
                                    <input type="checkbox" name="brandslist[]" value="<?php echo $class['sno']; ?>" class="" style="width:50px;padding:5px;" <?php if(isset($_POST['brandslist'])){if(in_array($class['sno'], $_POST['brandslist'])){echo ' checked ';}}?> /> <?php echo $class['class_description']; ?> <br/>
                                    <?php
                                }
                            }
                            else
                            {
                                echo "No Record Found";
                            }
                        ?>
                            <div class="form-group mt-3">
                                <button name="save" type="submit" class="btn btn-primary">Save</button>
                            </div>
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
				
				$sql2 = 'SELECT add_subject_details.sno as sno, add_subject_details.type as type, add_subject_details.paper_code as paper_code, title_of_paper, subject_id, subject FROM add_subject_details INNER JOIN add_subject ON add_subject.sno = add_subject_details.subject_id WHERE class_id = "' . $row['sno'] . '" and type_status=1';
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
                            <td><input type="date" name="ex_date1_' . $row_subject['sno'] . '" value="" class="form-control"></td>
                            <td><input type="time" name="ex_time1_' . $row_subject['sno'] . '" value="" class="form-control"></td>
                            <td>
                                <select name="ex_shift1_' . $row_subject['sno'] . '" class="form-control">
                                    <option selected disabled>--Select--</option>
                                    <option value="1">Morning</option>
                                    <option value="2">Evening</option>
                                </select>
                            </td>
                          </tr>
                          <input type="hidden" name="ex_class1_' . $row_subject['sno'] . '" value="' . $row['class_description'] . '">
                          <input type="hidden" name="ex_subject1_' . $row_subject['sno'] . '" value="' . $row_subject['subject'] . '">
                          <input type="hidden" name="ex_type1_' . $row_subject['sno'] . '" value="' . $row_subject['type'] . '">
                          <input type="hidden" name="ex_paper_code1_' . $row_subject['sno'] . '" value="' . $row_subject['paper_code'] . '">
                          <input type="hidden" name="ex_title1_' . $row_subject['sno'] . '" value="' . $row_subject['title_of_paper'] . '">';
					}
				
		
					$sql2 = 'SELECT add_subject_details.sno as sno, add_subject_details.type as type, add_subject_details.paper_code as paper_code, title_of_paper, subject_id, subject FROM add_subject_details INNER JOIN add_subject2 ON add_subject2.sno = add_subject_details.subject_id WHERE class_id = "' . $row['sno'] . '" and type_status=2';
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
								<td><input type="date" name="ex_date2_' . $row_subject['sno'] . '" value="" class="form-control"></td>
								<td><input type="time" name="ex_time2_' . $row_subject['sno'] . '" value="" class="form-control"></td>
								<td>
									<select name="ex_shift2_' . $row_subject['sno'] . '" class="form-control">
										<option selected disabled>--Select--</option>
										<option value="1">Morning</option>
										<option value="2">Evening</option>
									</select>
								</td>
							  </tr>
							  <input type="hidden" name="ex_class2_' . $row_subject['sno'] . '" value="' . $row['class_description'] . '">
							  <input type="hidden" name="ex_subject2_' . $row_subject['sno'] . '" value="' . $row_subject['subject'] . '">
							  <input type="hidden" name="ex_type2_' . $row_subject['sno'] . '" value="' . $row_subject['type'] . '">
							  <input type="hidden" name="ex_paper_code2_' . $row_subject['sno'] . '" value="' . $row_subject['paper_code'] . '">
							  <input type="hidden" name="ex_title2_' . $row_subject['sno'] . '" value="' . $row_subject['title_of_paper'] . '">';
						}
						echo '</table>';
					}
				?>
				<div style="display:flex;justify-content:flex-end;">
					<button class="btn btn-primary" name="submit" type="submit">submit</button>
				</div>
			</form>
		</div>
    </div>
<?php
	break;
}

page_footer_start();
page_footer_end();
?>	