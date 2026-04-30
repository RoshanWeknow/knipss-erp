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
	window.open('nominal_roll_printing_pg_sc.php?class='+stu_class+'&category='+category);
}
</script>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="nominal_roll_pg.php"  class="wufoo leftLabel page1" name="admission" enctype="multipart/form-data" method="post">
    <h2>Nominal Roll <span class="orange">(PG)</span></h2>
<?php
	if(isset($_POST['submit']) && $msg!='') {
		echo $msg;
	}
?>
         <li class="notranslate"><label  class="desc" for="name">Select Class<span class="name">*</span></label>
        <div><select name="stu_class" id="stu_id" >
        <?php
		$sql = 'select * from class_detail where sno not in (1,4,5,31,32,34,35,36,37,38,65,66)';
		$result = execute_query(connect(), $sql);
		while($row = mysqli_fetch_array($result)){
			echo '<option value="'.$row['sno'].'">'.$row['class_description'].'</option>';
		}
		?>
        </select></div>
     
         <li class="notranslate"><label  class="desc" for="name">Select Category<span class="name">*</span></label>
        <div><select name="category" id="category">
        	<option value="GEN">GENERAL & OBC</option>
            <option value="SC">SC/ST</option>
        </select></div>
  <div><input type="button" class="btTxt submit" name="save" value="Submit" onclick="return open_print()"/></div> 
</form></div></div>
  
<?php  
page_footer_store();
?>