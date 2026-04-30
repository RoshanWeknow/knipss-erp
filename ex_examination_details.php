<?php
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);

$msg='';
page_header_start();
 // if(isset($_POST['submit'])) { 
	 // for($i=0; $i<$_POST['tot_count']; $i++){
		 // $exam_details='select * from exam_details where class_id='.$_POST['classdescription'].' and exam_id='.$_POST['exam_id'].' and subject_id="'.$_POST['subject_id'.$i].'"';
		// $marks_details=mysql_fetch_array(mysql_query($exam_details,dbconnect()));
		// if($marks_details[date]!=''){
			// $details='update exam_details set max_marks="'.$_POST['max_marks'.$i].'", min_marks="'.$_POST['min_marks'.$i].'" where sno='.$marks_details['sno'];
			// mysql_query($details,dbconnect());
		// }
		 // else{
			 // $sub_id = $_POST['subject_id'.$i];
			 // $max = $_POST['max_marks'.$i];
		 	 // $min = $_POST['min_marks'.$i];
			 // $insert='insert into exam_details (class_id, exam_id, subject_id, max_marks, min_marks, date, create_by) values("'.$_POST['classdescription'].'" , "'.$_POST['exam_id'].'", "'.$sub_id.'", "'.$max.'", "'.$min.'",  "'.date("d-m-Y").'", "'.$_SESSION['username'].'")';
			// mysql_query($insert,dbconnect());
		 // }
	// }
	
	 // $msg="Details Saved";
 // }
 
 page_header_end();
page_sidebar();
?>
<?php
if(isset($_POST['submit'])) {
  for($i=0; $i<$_POST['tot_count']; $i++){
    $exam_details = 'select * from ex_exam_details where class_id=' . $_POST['classdescription'] . ' and exam_id=' . $_POST['exam_id'] . ' and subject_id="' . $_POST['subject_id' . $i] . '"';
    $marks_details = $db->query($exam_details);
    $marks_details = $marks_details->fetch_assoc();

    if($marks_details['date'] != '') {
      $details = 'update ex_exam_details set max_marks="' . $_POST['max_marks' . $i] . '", min_marks="' . $_POST['min_marks' . $i] . '" where sno=' . $marks_details['sno'];
      $db->query($details);
    } else {
      $sub_id = $_POST['subject_id' . $i];
      $max = $_POST['max_marks' . $i];
      $min = $_POST['min_marks' . $i];
      $insert = 'insert into ex_exam_details (class_id, exam_id, subject_id, max_marks, min_marks, date, create_by) values("' . $_POST['classdescription'] . '" , "' . $_POST['exam_id'] . '", "' . $sub_id . '", "' . $max . '", "' . $min . '",  "' . date('d-m-Y') . '", "' . $_SESSION['username'] . '")';
      $db->query($insert);
    }
  }

  $msg = "Details Saved";
}

?>

<script type="text/javascript" language="javascript">
function get_subject(str) {
	var classid=document.getElementById('classdescription').value;
    if (str == "") {
        document.getElementById("classdescription").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("new_table").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","sale_ajax.php?id=subject&term="+str+'_'+classid,true);
        xmlhttp.send();
    }
}

</script>
<body id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">     	
				<form action="ex_examination_details.php" class="wufoo leftLabel page1" name="addnewexam" enctype="multipart/form-data" method="post" onSubmit="" >
				<h3>Add Exam Details</h3>
				<?php
				if(isset($_POST['submit']) && $msg!='') {
					echo $msg;
					$msg='';
				}
				?>
				<table width="100%" class="table table-striped table-hover rounded">
					<tr class="">
						<th>Class</th>
						<th><select class="select form-control" name="classdescription" id="classdescription">
							<option value=" "></option>
							<?php
								$sql = 'SELECT * FROM ex_section';
								$res = mysqli_query($db, $sql);
								while ($row = mysqli_fetch_array($res)) {
									$sql1 = 'SELECT * FROM ex_class WHERE sno="' . $row['class_desc'] . '"';
									$result = mysqli_fetch_array(mysqli_query($db, $sql1));
									echo '<option value="' . $row['sno'] . '"';
									if ($section['sno'] == $row['sno']) {
										echo ' selected="selected"';
									}
									echo '>' . $result['class_desc'] . ' ' . $row['section'] . '</option>';
								}
								echo '</select>';
							?>
							</th>
						<th>Exam Name</th>
						<th><select name="exam_id" id="exam_id" class="select form-control" onChange="get_subject(this.value)">
								<option value="" selected="selected"></option>
								<?php
									$sql1 = 'SELECT * FROM ex_exam_master';
									$result = mysqli_query($db, $sql1);

									while ($row = mysqli_fetch_array($result)) {
										echo '<option value="' . $row['sno'] . '">' . $row['exam_name'] . '</option>';
									}
								?>
							</select>
						</th>
					</tr>
				</table>
				<input type="submit"  class="btn btn-primary submit" name="submit" value="Submit" />
			</form>
		</div>
	</div>


	<?php
	page_footer_start();
	page_footer_end();
	?>
</body>