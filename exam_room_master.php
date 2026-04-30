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

if(isset($_POST['new_entry'])){
	
	$sql = 'insert into exam_room_master (room_name, seating_capacity, no_of_rows) values ("'.$_POST['room_name'].'", "'.$_POST['seating_capacity'].'", "'.$_POST['no_of_rows'].'")';
	execute_query($sql);
	if(mysqli_error($db)){
		$msg .= '<li><h3>Successful</h3></li>';
	}
	else{
		$msg .= '<li><h3>Failed</h3></li>';
	}
}

page_header_new();
?>
<?php
switch($response){
	case 1:{
?>	
<style>
.marquee {
    top: 6em;
    position: relative;
    box-sizing: border-box;
    animation: marquee 15s linear infinite;
}

.marquee:hover {
    animation-play-state: paused;
}

/* Make it move! */
@keyframes marquee {
    0%   { top:  20em }
    100% { top: -20em }
}

</style>
<script type="text/javascript" language="javascript">
function register_now(){
    var method = "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", "index.php");

	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "register");
	hiddenField.setAttribute("value", "testing");

	form.appendChild(hiddenField);
    document.body.appendChild(form);
    form.submit();	
}	

function get_subject(class_name){
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var v = xmlhttp.responseText;
			//alert(v);
			var v = v.split('#');
			document.getElementById('subject').innerHTML=v[0];
		}
	}
	xmlhttp.open("GET","get_subject.php?q="+class_name,true);
	xmlhttp.send();
}
$(document).ready(function(){
	get_subject(document.getElementById('class').value);
});
</script>
<div id="content">    	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="admission_newadmission" enctype="multipart/form-data" method="post" onSubmit="" >
		<h2>Room Master</h2>
		<?php echo $msg; ?>
		<table width="100%">
			<tr>
				<td>Room Name</td>
				<td><input type="text" name="room_name" id="room_name" class="text large" tabindex="<?php echo $tabindex++;?>" value="<?php if(isset($_POST['room_name'])){echo $_POST['room_name'];}?>">
				</td>
				<td>Seating Capacity</td>
				<td><input type="text" name="seating_capacity" id="seating_capacity" class="text large" tabindex="<?php echo $tabindex++;?>" value="<?php if(isset($_POST['seating_capacity'])){echo $_POST['seating_capacity'];}?>"></select></td>
				<td>No. of Rows</td>
				<td><input type="text" name="no_of_rows" id="no_of_rows" class="text large" value="<?php if(isset($_POST['no_of_rows'])){echo $_POST['no_of_rows'];}?>" tabindex="<?php echo $tabindex++;?>" /></td>
				<td><input id="new_entry" name="new_entry" class="btTxt submit" type="submit" value="Add Room"/></td>
			</tr>
		</table>
	</form>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="admission_newadmission" enctype="multipart/form-data" method="post" onSubmit="" >
		<table>
			<tr>
				<th>S.No.</th>
				<th>Room Name</th>
				<th>Seating Capacity</th>
				<th>No of Rows</th>
			</tr>
			<?php
			$i=1;
			$sql = 'select * from exam_room_master';
			//echo $sql;
			$result_scheme = execute_query($sql);
			while($row_scheme = mysqli_fetch_array($result_scheme)){
				echo '<tr>
				<td>'.$i++.'</td>
				<td>'.$row_scheme['room_name'].'</td>
				<td>'.$row_scheme['seating_capacity'].'</td>
				<td>'.$row_scheme['no_of_rows'].'</td>
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
