<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_store();
$msg='';
 if(isset($_POST['submit'])) {
	 if($_POST['subfees']=='') {
		$msg .='<li>Please Enter Subject</li>';		
	}	
	else {
		$sql="select * from class_detail where sno=".$_REQUEST['id']."";
		$classid=mysqli_fetch_array(execute_query(connect(), $sql));
		$classid=$classid['sno'];
		$sql="select * from head_type where sno=".$_REQUEST['id']."";
		$classid=mysqli_fetch_array(execute_query(connect(), $sql));
		$headid=$headid['sno'];
		
	
	 $sql='insert into fees_detail(class_id,fee_type_id,fee_amount,recurring_duration) values("'.$_POST[$classid].'","'.$_POST[$headid].'","'.$_POST['subfees'].'","'.$_POST['rec_duration'].'")';
	 execute_query(connect(), $sql);
		$msg = '<li>New fees Added</li>'; 
 }
 }
 

?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>

<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="addheadfee.php" class="addnewsubject" name="addnewsubject" enctype="multipart/form-data" method="post" onSubmit="" >
<h2><img style="width:40px;" src="images/add.png" />Add  Head<span class="orange"> Fees</span></h2>

<?php
if(isset($_POST['submit']) && $msg!='') {
	echo $msg;
	$msg='';
}
?>
<div id="labeldetail" spry:hover="labeldetail">
 
                 <li class="notranslate"><label  class="desc" for="s_class">Select Class<span class="s_class">*</span></label>
                <select name="s_class" class="s_class" id="s_class" onchange="hide_show('s_class','1')">
                <option value="" selected="selected"></option>
                <?php
                $sql = 'select * from class_detail';
                $res = execute_query(connect(), $sql);
                while($row = mysqli_fetch_array($res)) {
                    echo '<option value="'.$row['sno'].'">'.$row['class_description'].'</option> ';
                }
                ?>
                </select>
                </div>
                
                
                  <li class="notranslate"><label  class="desc" for="s_head">Select Head Type<span class="s_head">*</span></label>
                <select name="s_head" class="s_head" id="s_head" onchange="hide_show('s_class','1')">
                <option value="" selected="selected"></option>
                <?php
                $sql = 'select * from head_type';
                $res = execute_query(connect(), $sql);
                while($row = mysqli_fetch_array($res)) {
                    echo '<option value="'.$row['sno'].'">'.$row['fee_type'].'</option> ';
                }
                ?>
                </select>
                </detail>
                 <div id="label_detail">
              <li class="notranslate"><label  class="desc" for="subfees">Recurring Duration <span class="subfees">*</span></label>
            <div><input type="text" name="rec_duration" id="rec_duration"class="fieldtextmedium" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
            </div>
            <div id="label_detail">
              <li class="notranslate"><label  class="desc" for="subfees">Enter Fee Amount <span class="subfees">*</span></label>
            <div><input type="text" name="subfees" id="subfees"class="fieldtextmedium" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
            </div>
</div>
</div>

 <div><input type="submit" class="btTxt submit" name="submit" value="Submit" onClick="return confirmSubmit()"/></div>
</div>
</form></div></div>


<?php
page_footer_store();
?>