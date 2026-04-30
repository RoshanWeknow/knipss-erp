<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_store();
$msg='';
if($_POST['submit']){
	 	$sql='INSERT INTO `library_almari`(`desc`, `category`) VALUES("'.$_POST['description'].'","'.$_POST['category'].'")';
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
	<form action="library_add_almari.php" class="wufoo leftLabel page1" name="addnewsubject" enctype="multipart/form-data" method="post" onSubmit="" >
<h2><img style="width:40px;" src="images/add.png" />Add New <span class="orange">Almari</span></h2>

<?php
if(isset($_POST['submit']) &&$msg!='') {
	echo $msg;
	$msg='';
}
?>
	 <li class="notranslate"><label  class="desc" for="book_name">Description <span class="sub_name">*</span></label>
        <div><input type="text" name="description" id="description"class="fieldtextmedium" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
    </div></li>
    <li class="notranslate"><label  class="desc" for="subject">Category <span class="sub_name">*</span></label>
        <div>
        	<?php
                $sql = 'select * from library_category';
                $res = execute_query(connect(), $sql);
                while($row = mysqli_fetch_array($res)) {
                    echo '<option value="'.$row['sno'].'">'.$row['desc'].'</option> ';
                }
              ?>
    </div></li>
 <div><input type="submit" class="btTxt submit" name="submit" value="Submit" onClick="return confirmSubmit()"/></div>
</form></div></div>
<?php
page_footer_store();
?>