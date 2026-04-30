<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
logvalidate('sadmin');
page_header_store();
$response=1;
$msg='';
?>
<script type="text/javascript" language="javascript">
function open_print(){
	var stu_class = document.getElementById('stu_id').value;

	var category = document.getElementById('category').value;
	if(document.getElementById('stu_id').value==1){
		window.open('nominal_roll_printing.php?class='+stu_class+'&category='+category);
		}
	else{
		window.open('nominal_roll_printing.php?class='+stu_class+'&category='+category);
	}	
}
</script>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="nominal_roll_ug.php"  class="wufoo leftLabel page1" name="admission" enctype="multipart/form-data" method="post">
    <h2>Nominal Roll<span class="orange">(UG)</span></h2>
<?php
	if(isset($_POST['submit']) && $msg!='') {
		echo $msg;
	}
?>
        <label for="name">Select Class<span class="name">*</span></label>
        <div><select name="stu_class" id="stu_id" >
        <?php
		$sql = 'select * from class_detail  where category ="UG" and sno not in (3,29,30)';
		$result = execute_query(connect(), $sql);
		while($row = mysqli_fetch_array($result)){
			echo '<option value="'.$row['sno'].'">'.$row['class_description'].'</option>';
		}
		?>
        </select></div>
        <label for="name">Select Category<span class="name">*</span></label>
        <div><select name="category" id="category">
        	<option value="GEN">GENERAL & OBC</option>
            <option value="SC">SC/ST</option>
        </select></div>
	<div><input type="button" class="btTxt submit" name="save" value="Submit" onclick="return open_print()" /></div> 
</form></div></div>
<?php  
page_footer_store();
?>