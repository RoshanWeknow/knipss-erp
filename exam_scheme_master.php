<?php
//ob_start();
//date_default_timezone_set('Asia/Calcutta');
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
	$sql = 'select * from exam_scheme_master where class_id="'.$_POST['class'].'" and subject_id="'.$_POST['subject'].'"';
	$cond1 = execute_query($sql);
	if(mysqli_num_rows($cond1)!=0){
		$msg .= '<li><h3>Same class and subject.</h3></li>';
	}
	
	$sql = 'insert into exam_scheme_master (class_id, subject_id, paper_id, timing_from, timing_to, date_of_exam) values ("'.$_POST['class'].'", "'.$_POST['subject'].'", "'.$_POST['paper_name'].'", "'.$_POST['paper_time_from'].'", "'.$_POST['paper_time_to'].'", "'.$_POST['paper_date'].'")';
	execute_query($sql);
	if(mysqli_error($db)){
		$msg .= '<li><h3>Successful</h3></li>';
	}
	else{
		$msg .= '<li><h3>Failed</h3></li>';
	}
}

page_header_start();
page_header_end();
page_sidebar();
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
		<h2>Scheme Entry</h2>
		<?php echo $msg; ?>
		<table width="100%">
			<tr>
				<td>Select Class</td>
				<td><select name="class" id="class" onChange="get_subject(this.value)" class="select large" tabindex="<?php echo $tabindex++;?>">
				<?php
				$sql = 'select * from class_detail order by sort_no, year';
				$result = execute_query(connect(), $sql);
				while($row = mysqli_fetch_array($result)){
					echo '<option value="'.$row['sno'].'">'.$row['class_description'].'</option>';
				}
			
				?>
				</select>
				</td>
				<td>Select Subject</td>
				<td><select name="subject" id="subject" class="select large" tabindex="<?php echo $tabindex++;?>"></select></td>
				<td>Paper Name</td>
				<td><input type="text" name="paper_name" id="paper_name" class="fieldtext large" value="<?php if(isset($_POST['paper_name'])){echo $_POST['paper_name'];}?>" tabindex="<?php echo $tabindex++;?>" /></td>
			</tr>
			<tr>
				<td>Date of Paper</td>
				<td><script>DateInput('paper_date', false, 'YYYY-MM-DD', '<?php if(isset($_POST['paper_date'])){echo $_POST['paper_date'];}else{echo date("Y-m-d");}?>', <?php echo $tabindex++; $tabindex += 3; ?>)</script></td>
				<td>Paper Time From</td>
				<td><input type="text" name="paper_time_from" id="paper_time_from" class="fieldtext large" value="<?php if(isset($_POST['paper_time_from'])){echo $_POST['paper_time_from'];}?>" tabindex="<?php echo $tabindex++;?>" /></td>
				<td>Paper Time To</td>
				<td><input type="text" name="paper_time_to" id="paper_time_to" class="fieldtext large" value="<?php if(isset($_POST['paper_time_to'])){echo $_POST['paper_time_to'];}?>" tabindex="<?php echo $tabindex++;?>" /></td>
			</tr>
			<tr>
				<td colspan="6"><input id="new_entry" name="new_entry" class="btTxt submit" type="submit" value="Continue"/></td>
			</tr>
		</table>
	</form>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="admission_newadmission" enctype="multipart/form-data" method="post" onSubmit="" >
		<table width="100%">
			<tr>
				<td>Select Class</td>
				<td><select name="report_class" id="report_class" class="select large" tabindex="<?php echo $tabindex++;?>">
				<?php
				$sql = 'select * from class_detail order by sort_no, year';
				$result = execute_query(connect(), $sql);
				while($row = mysqli_fetch_array($result)){
					echo '<option value="'.$row['sno'].'">'.$row['class_description'].'</option>';
				}
			
				?>
				</select>
				</td>
				<td>Date of Paper</td>
				<td><input type="text" name="report_paper_date" id="report_paper_date" class="fieldtext large" value="<?php if(isset($_POST['report_paper_time'])){echo $_POST['report_paper_time'];}?>" tabindex="<?php echo $tabindex++;?>" /></td>
				<td>Paper Time</td>
				<td><input type="text" name="report_paper_time" id="report_paper_time" class="fieldtext large" value="<?php if(isset($_POST['report_paper_time'])){echo $_POST['report_paper_time'];}?>" tabindex="<?php echo $tabindex++;?>" /></td>
				<td><input id="search" name="search" class="btTxt submit" type="submit" value="Search"/></td>
			</tr>
		</table>
		<table>
			<tr>
				<th>S.No.</th>
				<th>Class</th>
				<th>Subject</th>
				<th>Paper Name</th>
				<th>Date</th>
				<th>Time From</th>
				<th>Time To</th>
				<th>Enrolled Students</th>
			</tr>
			<?php
			$i=1;
			$sql = 'select class_id, subject_id, paper_id, timing_from, timing_to, date_of_exam, subject, class_description from exam_scheme_master left join class_detail on class_detail.sno = exam_scheme_master.class_id left join add_subject on add_subject.sno = exam_scheme_master.subject_id order by class_id, subject_id, date_of_exam';
			//echo $sql;
			$result_scheme = execute_query($sql);
			while($row_scheme = mysqli_fetch_array($result_scheme)){
				$count = get_sub_count($row_scheme['class_id'], $row_scheme['subject_id']);
				echo '<tr>
				<td>'.$i++.'</td>
				<td>'.$row_scheme['class_description'].'</td>
				<td>'.$row_scheme['subject'].'</td>
				<td>'.$row_scheme['paper_id'].'</td>
				<td>'.$row_scheme['date_of_exam'].'</td>
				<td>'.$row_scheme['timing_from'].'</td>
				<td>'.$row_scheme['timing_to'].'</td>
				<td>'.$count['total'].'</td>
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

//ob_end_flush();
?>
<?php
page_footer_start();
page_footer_end();
?>