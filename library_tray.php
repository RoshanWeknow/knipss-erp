<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_store();
$msg='';
if($_POST['submit']){
	 	$sql='INSERT INTO `library_tray`(`tray_no`, `alm_id`, `max_qty`, `qty`) VALUES("'.$_POST['tray'].'","'.$_POST['almari'].'","'.$_POST['max_qty'].'","0")';
		execute_query(connect(), $sql);
}
?>
<style type="text/css">
fieldset {
  padding: 0em;
  font:80%/2 sans-serif;
  }
  label {
  float:left;
  width:25%;
  margin-right:0.5em;
  padding-top:0.2em;
  text-align:right;
  font-weight:bold;
  }
  </style>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>

<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="library_tray.php" class="wufoo leftLabel page1" name="addnewsubject" enctype="multipart/form-data" method="post" onSubmit="" >
<h2><img style="width:40px;" src="images/add.png" />Add New <span class="orange">Tray</span></h2>

<?php
if(isset($_POST['submit']) &&$msg!='') {
	echo $msg;
	$msg='';
}
?>
	 <li class="notranslate"><label  class="desc" for="book_name">Almari <span class="sub_name">*</span></label>
        <div>
        	<select name="almari" id="almari">
            	<option value="" selected="selected"></option>
                    <?php
                    $sql = 'select * from library_almari';
                    $res = execute_query(connect(), $sql);
                    while($row = mysqli_fetch_array($res)) {
                        echo '<option value="'.$row['sno'].'">'.$row['desc'].'&nbsp;&nbsp;'.$row['category'].'</option> ';
                    }
                    ?>
            </select>
    </div></li>
     <li class="notranslate"><label  class="desc" for="subject">Tray No. <span class="sub_name">*</span></label>
        <div><input type="text" name="tray" id="tray"class="fieldtextmedium" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
    </div></li>
     <li class="notranslate"><label  class="desc" for="book_name">Max. Quantity <span class="sub_name">*</span></label>
        <div><input type="text" name="max_qty" id="max_qty"class="fieldtextmedium" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
    </div></li>
 <div><input type="submit" class="btTxt submit" name="submit" value="Submit" onClick="return confirmSubmit()"/></div>
</form></div></div>
<?php
page_footer_store();
?>