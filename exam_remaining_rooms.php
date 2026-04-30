<?php
ob_start();
date_default_timezone_set('Asia/Calcutta');
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
include("exam_settings.php");
global $db;
$response=1;
$tabindex=1;
$msg='';
if(isset($_POST)){
	foreach($_POST as $k=>$v){
		$_POST[$k] = htmlspecialchars($v);
	}
}

if(isset($_POST['new_entry1'])){
	$sql = 'select * from exam_scheme_master where class_id="'.$_POST['class'].'" and subject_id="'.$_POST['subject'].'"';
	$cond1 = execute_query($sql);
	if(mysqli_num_rows($cond1)!=0){
		$msg .= '<li><h3>Same class and subject.</h3></li>';
	}
}

page_header_new();
?>
<?php
switch($response){
	case 1:{
?>	
<div id="content">    	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="admission_newadmission" enctype="multipart/form-data" method="post" onSubmit="" >
		<h2>Room Wise Seat Allotment</h2>
		<?php echo $msg; ?>
		<table width="100%">
			<tr>
				<td>Select Room</td>
				<td><select name="room_name" id="room_name" class="select large" tabindex="<?php echo $tabindex++;?>">
				<?php
				$sql = 'select * from exam_room_master';
				$result = execute_query(connect(), $sql);
				while($row = mysqli_fetch_array($result)){
					echo '<option value="'.$row['sno'].'">'.$row['room_name'].'</option>';
				}
			
				?>
				</select>
				</td>
				<td><input id="new_entry" name="new_entry" class="btTxt submit" type="submit" value="Continue"/></td>
				<td colspan="6">&nbsp;</td>
			</tr>
		</table>
		<table>
			<tr>
				<th>S.No.</th>
				<th>Room Name</th>
				<th>Paper Name</th>
				<th>Date</th>
				<th>Time From</th>
				<th>Time To</th>
				<th>Seating Capacity</th>
				<th>Alloted Students</th>
				<th>&nbsp;</th>
			</tr>
			<?php
			$i=1;
			$sql = 'select * from exam_seating_plan group by room_id, scheme_id';
			//echo $sql;
			$result_scheme = execute_query($sql);
			while($row_scheme = mysqli_fetch_array($result_scheme)){
				echo '<tr>
				<td>'.$i++.'</td>
				<td>'.$row_scheme['room_name'].'</td>
				<td>'.$row_scheme['seating_capacity'].'</td>
				<td>'.$row_scheme['no_of_rows'].'</td>
				<td>'.$row_scheme['alloted_stundes'].'</td>
				<td>View Map</td>
				</tr>';
			}
			
			?>
		</table>
	</form>
</div>
<script>
$('#paper_time_from').datetimepicker({
	step:15,
	datepicker:false,
	format: 'H:i',
	value: '<?php
	if(isset($_POST['paper_time_from'])){
		echo $_POST['paper_time_from'];
	}
	else{
		echo date("d-m-Y H:i");	
	}
	?>'
});

$('#paper_time_to').datetimepicker({
	step:15,
	datepicker:false,
	format: 'H:i',
	value: '<?php
	if(isset($_POST['paper_time_to'])){
		echo $_POST['paper_time_to'];
	}
	else{
		echo date("d-m-Y H:i");	
	}
	?>'
});

$('#report_paper_time').datetimepicker({
	step:15,
	datepicker:false,
	format: 'H:i',
	value: '<?php
	if(isset($_POST['date_from'])){
		echo $_POST['date_from'];
	}
	else{
		echo date("d-m-Y H:i");	
	}
	?>'
});

$('#report_paper_date').datetimepicker({
	step:15,
	timepicker:false,
	format: 'Y-m-d',
	value: '<?php
	if(isset($_POST['date_from'])){
		echo $_POST['date_from'];
	}
	else{
		echo date("d-m-Y H:i");	
	}
	?>'
});
</script>	
<?php

		break;
	}
	case 3:{
?>
<?php
		break;
	}
}
page_footer_new();
ob_end_flush();
?>
