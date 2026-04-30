<?php
ob_start();
date_default_timezone_set('Asia/Calcutta');
session_cache_limiter('nocache');
session_start();
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
		<h2>Room Map</h2>
		<?php echo $msg; ?>
		<table>
		<?php
		if(isset($_GET['rid'])){
			$sql = 'select * from exam_room_master where sno='.$_GET['rid'];
			$room = mysqli_fetch_array(execute_query($sql));
			$no_of_seat = ceil($room['seating_capacity']/$room['no_of_rows']);
			$last_row_seats = $room['seating_capacity'] - $no_of_seat*($room['no_of_rows']-1);
			$sql = 'SELECT * FROM `exam_seating_plan` where room_id='.$_GET['rid'].' group by room_id, scheme_id';
			$result_seating_plan = execute_query($sql);
			$scheme_id = array();
			while($row_seating = mysqli_fetch_array($result_seating_plan)){
				$scheme_id[] = $row_seating['scheme_id'];
			}
			$total_papers = sizeof($scheme_id);
			$scheme_id = implode(",", $scheme_id);
			$sql = 'select roll_no, paper_id, subject from exam_seating_plan left join exam_scheme_master on exam_scheme_master.sno = scheme_id join add_subject on add_subject.sno = subject_id where room_id='.$_GET['rid'].' and scheme_id in ('.$scheme_id.') order by abs(seat_no)';
			//echo $sql;
			$result_seats = execute_query($sql);
			$seats = array();
			while($row_seats = mysqli_fetch_array($result_seats)){
				$seats[] = $row_seats;
			}
			$sno=1;
			$col=1;
			for($a=1;$a<=$no_of_seat;$a++){
				echo '<tr>';
				for($i=1;$i<=$room['no_of_rows'];$i++){
					if($i!=1){
						$seat_no = ($i-1)*$no_of_seat+$a;
					}
					else{
						$seat_no = $sno;
						$sno++;
					}
					if($col==$total_papers){
						$col=1;
					}
					else{
						$col++;
					}
					$seat_id = $seat_no-1;
					echo '<td class="color'.$col.'"><strong>Seat No :</strong> '.$seat_no.'<br><strong>Roll No :</strong> '.$seats[$seat_id]['roll_no'].'<br /><strong>Subject :</strong>'.$seats[$seat_id]['subject'].'<br><strong>Paper :</strong>'.$seats[$seat_id]['paper_id'].'</td>';
					if((($i-1)*$no_of_seat+$a)==$room['seating_capacity']){
						$room['no_of_rows']--;
					}
				}
				echo '</tr>';
			}
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
