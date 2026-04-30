<?php
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);

$msg='';
$subject='';
$id = '';
if(isset($_REQUEST['del'])){
	$sql = "delete from d_section where sno=".$_GET['del'];
	execute_query($db, $sql);
	echo '<script>alert("Record deleted.")</script>';

}
if(isset($_POST['submit'])) {
	if($_POST['max_student']=='')	{
	 $_POST['max_student']=0;
   }
   if($_POST['class_desc']=='') {
	  $msg .='<li>Please Enter Class</li>';
   }
   elseif($_POST['class_section']=='')	{
	 $msg .='<li>Please Enter Section</li>';
   }
   else {
	   	if ($_POST['edit_sno'] != '') {
	   		$id = $_POST['edit_sno'];
	   		$sql_delete = 'DELETE FROM `d_section_info` WHERE `section_id`="'.$_POST['edit_sno'].'"';
	   		execute_query($db, $sql_delete);
	   		$sql = 'update d_section set class_desc="'.$_POST['class_desc'].'" , section ="'.$_POST['class_section'].'", max_student ="'.$_POST['max_student'].'" , class_teacher_id="'.$_POST['class_teacher'].'" , teacher_id="'.$_POST['teacher'].'" where sno="'.$_POST['edit_sno'].'"';
			 execute_query($db, $sql);
			 $msg = '<li>Section updated</li>';
	   	}
	   	else{
			 $sql = 'select * from d_section where class_desc="'.$_POST['class_desc'].'" && section="'.$_POST['class_section'].'"';
			 $res = execute_query($db, $sql);	
			 if(mysqli_num_rows($res)!=1) {		
			   	$sql = 'insert into d_section(class_desc , section , max_student , date , created_by ,creation_time, fees_status , class_teacher_id , teacher_id)value("'.$_POST['class_desc'].'" ,"'.$_POST['class_section'].'" ,"'.$_POST['max_student'].'" ,"'.date("Y-m-d").'" ,"'.$_SESSION['username'].'","'.date('Y-m-d H:m:s').'" ,"0" ,"'.$_POST['class_teacher'].'" ,"'.$_POST['teacher'].'")';
			   	execute_query($db, $sql);	
				//echo $sql;	
			   
			   	$msg .= '<li>New Section Created</li>';
				$id=mysqli_insert_id($db);
			}
			else {
			  $msg = '<li>Class And Section Already Define</li>';
			}
		}
		if ($id != '') {
			$sql_subject = 'SELECT * FROM `d_subject` WHERE `status`="1"';
			$result_subject = execute_query($db, $sql_subject);
			while ($row_subject = mysqli_fetch_array($result_subject)) {
				if (isset($_POST['checkbox_'.$row_subject['sno']])) {
					$sql_insert = 'INSERT INTO `d_section_info`(`section_id`, `subject_id`, `teacher_id`, `created_by`, `creation_time`) VALUES ("'.$id.'" , "'.$row_subject['sno'].'" , "'.$_POST['teacher_'.$row_subject['sno']].'" , "'.$_SESSION['username'].'" , "'.date('Y-m-d h:i:s').'")';
					execute_query($db, $sql_insert);
				}
			}
		}							 
	}	
 } 
if (isset($_GET['id'])) {
	$sql = 'select * from d_section where sno="'.$_GET['id'].'"'; 
	
	$row_edit = mysqli_fetch_array(execute_query($db, $sql));
}
page_header_start();
 page_header_end();
 page_sidebar();
?>  

<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="wufoo leftLabel page1"  name="addsection" enctype="multipart/form-data" method="post" onSubmit="" >
	<div class="bg-primary text-white p-2"><h3>Add Section</h3></div>
		<?php echo $msg; ?>
		<table class="table table-striped table-hover rounded">
			<tr>
				<td>Class Description</td>
				<td>
				<select name="class_desc" id="class_desc" class="form-control" value="" onChange="hide_show('class_desc','1')"/>
					<?php 
					$sql = 'select * from d_class';
					$result = execute_query($db, $sql);
					if($result){
					while($row = mysqli_fetch_array($result)) {
						echo '<option value="'.$row['sno'].'"';
						if (isset($_GET['id'])) {
							if ($row['sno'] == $row_edit['class_desc']) {
								echo 'selected';
							}
						}
						echo '>'.$row['class_desc'].'</option>';
					}
					}
					?>
				</select> 							
				</td>
				<td>Section</td>
				<td><input type="text" name="class_section" id="class_section" class="form-control" value="<?php if(isset($_GET['id'])){echo $row_edit['section'];} ?>" onKeyUp="formvalidation(this.value,'varchar',45,'class_section)" onBlur="hide_show('class_section',2)"/></td>
				<td>Max. Student</td>
				<td><input type="text" name="max_student" id="max_student" class="form-control" onKeyUp="formvalidation(this.value,'int',5,'max_student')" value="<?php if(isset($_GET['id'])){echo $row_edit['max_student'];} ?>" onBlur="hide_show('max_student',3)"/></td>
			</tr>
			<tr>
				<td>Class Teacher</td>
				<td>
					<select name="class_teacher" id="class_teacher" class="form-control">
						<option value=""></option>
				<?php 
					$sql_teacher = 'SELECT * FROM `d_teacher_info`';
					$result_teacher = execute_query($db, $sql_teacher);
					if($result_teacher){
					while ($row_teacher = mysqli_fetch_array($result_teacher)) {
						echo '<option value="'.$row_teacher['sno'].'"';
						if (isset($_GET['id'])) {
							if ($row_teacher['sno'] == $row_edit['class_teacher_id']) {
								echo 'selected';
							}
						}
						echo '>'.$row_teacher['teacher_name'].'</option>';
					}
					}
				?>
					</select>
				</td>
				<td>Teacher</td>
				<td>
					<select name="teacher" id="teacher" class="form-control">
						<option value=""></option>
				<?php 
					$sql_teacher = 'SELECT * FROM `d_teacher_info`';
					$result_teacher = execute_query($db, $sql_teacher);
					while ($row_teacher = mysqli_fetch_array($result_teacher)) {
						echo '<option value="'.$row_teacher['sno'].'"';
						if (isset($_GET['id'])) {
							if ($row_teacher['sno'] == $row_edit['teacher_id']) {
								echo 'selected';
							}
						}
						echo '>'.$row_teacher['teacher_name'].'</option>';
					}
				?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<b>Select Subjects:</b>
				</td>
			</tr>
			<tr>
				<th colspan="2">&nbsp;</th>
				<th colspan="2">Subject Name</th>
				<th colspan="2">Teacher</th>
			</tr>
			<?php
				$sql_subject = 'SELECT * FROM `d_subject` WHERE `status`="1"';
				$result_subject = execute_query($db, $sql_subject);
				if($result_subject){
				while ($row_subject = mysqli_fetch_array($result_subject)) {
					if (isset($_GET['id'])) {
						$sql_section_info_edit = 'SELECT * FROM `d_section_info` WHERE `section_id`="'.$_GET['id'].'" AND `subject_id`="'.$row_subject['sno'].'"';
						$row_section_info_edit = mysqli_fetch_array(execute_query($db, $sql_section_info_edit));
					}
			?>
			<tr>
				<td colspan="2">
					<input type="checkbox" name="checkbox_<?php echo $row_subject['sno']; ?>" <?php if(isset($_GET['id']) && (isset($row_section_info_edit['subject_id']) && $row_section_info_edit['subject_id'] == $row_subject['sno']))echo ' checked'; else echo ' '; ?> class="form-control">
				</td>
				<td colspan="2">
					<?php echo $row_subject['subject_name']; ?>
				</td>
				<td colspan="2">
					<select name="teacher_<?php echo $row_subject['sno']; ?>" id="teacher_<?php echo $row_subject['sno']; ?>" class="form-control">
						<option value=""></option>
					<?php 
						$sql_teacher = 'SELECT * FROM `d_teacher_info`';
						$result_teacher = execute_query($db, $sql_teacher);
						if($result_teacher){
						while ($row_teacher = mysqli_fetch_array($result_teacher)) {
							echo '<option value="'.$row_teacher['sno'].'"';
							if (isset($_GET['id'])) {
								if ( isset($row_section_info_edit['teacher_id']) && $row_section_info_edit['teacher_id'] == $row_teacher['sno']) {
									echo 'selected';
								}
							}
							echo '>'.$row_teacher['teacher_name'].'</option>';
						}
						}
					?>
					</select>
				</td>
			</tr>
			<?php
				}
				}
			?>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td colspan="2">
					<input type="hidden" name="edit_sno" value="<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>">
					
				</td>
				<td colspan="2">&nbsp;</td>
			</tr>
			<!--<tr>
				<td>No. Of Student</td>
				<td><input type="text" name="no_ofstudent" id="no_ofstudent" class="form-control" value="" onKeyUp="formvalidation(this.value,'int',5,'no_ofstudent')" onBlur="hide_show('no_ofstudent',4)"/></td>
				<td>No. Of Subjects</td>
				<td><input type="text" name="no_of_subject" id="no_of_subject" class="form-control" value="" onKeyUp="formvalidation(this.value,'int',5,'no_ofstudent')" onBlur="hide_show('no_ofstudent',4)"/></td>
			</tr>-->
		</table>
		<input type="submit" class="btn btn-primary" name="submit" value="Submit" onClick="return confirmSubmit()"/>
	</form>
</div></div></div>	
		
	<div class="card card-body">	
		<table class="table table-striped table-hover rounded">
		<tr class="bg-primary text-white">
			<th style="width: 4%;">S.No.</th>
			<th>Class Description</th>
			<th>Section</th>
			<th>Max Student</th>
			<th>Class Teacher</th>
			<th>Teacher</th>
			<th>Subjects</th>
			<!--<th>No. Of Student</th>
			<th>No. Of Subject</th>-->
			<th colspan="2">&nbsp;</th>
		</tr>
		<?php
		$i='';
		$sql = 'select d_section.sno , d_class.class_desc , d_section.section , d_section.class_teacher_id , d_section.teacher_id , d_section.max_student from d_section left join d_class on d_section.class_desc=d_class.sno order by abs(d_class.class_desc) , d_class.class_desc , d_section.section , abs(d_section.section) ';
		$result = execute_query($db, $sql);
		if($result){
		while($row = mysqli_fetch_array($result)) {
			$sql_section_info = 'SELECT * FROM `d_section_info` WHERE `section_id`="'.$row['sno'].'"';
			$result_section_info = execute_query($db, $sql_section_info);
			$num = mysqli_num_rows($result_section_info);
			echo '
			<tr><th>'.++$i.'</th>
			<td>'.$row['class_desc'].'</td>
			<td>'.$row['section'].'</td>
			<td>'.$row['max_student'].'</td>
			<td>';
			
			$class_teacher_res = execute_query($db, 'select * from d_teacher_info where sno = '.$row['class_teacher_id']);
			if($class_teacher_res){
				 $class_teacher_id = mysqli_fetch_assoc($class_teacher_res);
				 echo $class_teacher_id['teacher_name'];
			}
			echo '</td>
			<td>';
			$teacher_res = execute_query($db, 'select * from d_teacher_info where sno = '.$row['teacher_id']);
			if($teacher_res){
				 $teacher_id = mysqli_fetch_assoc($teacher_res);
				 echo $teacher_id['teacher_name'];
			}
			echo '</td>';
			?>
			<td><a type="button" class="btn btn-default btn-md" onClick="create_new_modal('<?php echo 'modal_'.$row['sno']; ?>');">&nbsp;<?php echo $num; ?> &nbsp; <span class="glyphicon glyphicon-eye-open"></span></a></td>
			<!-- View RC Modal Start-->

                  <div id="<?php echo 'modal_'.$row['sno']; ?>" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <a type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
                        <h4 class="modal-title">Subject Details</h4>
                      </div>
                      <div class="modal-body"> 
                      	<?php  
							if($result_section_info){
	                        while ($row_subject_info = mysqli_fetch_array($result_section_info)) {
	            				echo '<div class="row"><div class="col-sm-12">';
								$subject_res = execute_query($db, 'select * from d_subject where sno = '.$row_subject_info['subject_id']);
								if($subject_res){
									 $subject_id = mysqli_fetch_assoc($subject_res);
									 echo $subject_id['subject_name'];
								}
								echo '-';
								$teacher_res = execute_query($db, 'select * from d_teacher_info where sno = '.$row_subject_info['teacher_id']);
								if($teacher_res){
									 $teacher_id = mysqli_fetch_assoc($teacher_res);
									 echo $teacher_id['teacher_name'];
								}
								echo '</div></div>';
	            			}}
            			?>
                      </div>
                      <div class="modal-footer">
                        <a type="button" class="btn btn-default" data-dismiss="modal"> Close</a>
                        <!--<a href="my.php?link=PHOTO/<?php echo $row['photo_id'];?>" role="button" traget="_blank" class="btn btn-default"  target="_blank">Print</a>-->
                      </div>
                    </div>
                  </div>
                </div>
              

          <!-- View RC Modal End-->
			<?php
			/**<td>'.$row['no_ofstudent'].'</td>
			<td>'.$row['no_of_subject'].'</td>**/
			echo '<td><a type="button" class="btn btn-default btn-md" href="d_addsection.php?id='.$row['sno'].'"><span class="glyphicon glyphicon-pencil">Edit</span></a></td>
			<td><a type="button" class="btn btn-default btn-md" href="d_addsection.php?del='.$row['sno'].'"><span class="glyphicon glyphicon-remove-circle">Delete</span></a></td></tr>';
		}
		}
		?>
	</table>
</div>
<?php
page_footer_start();
?>
<script type="text/javascript">
    function create_new_modal(modal_name){
      $('#'+modal_name).modal('show');
    }
</script>