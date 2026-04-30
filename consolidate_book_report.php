<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
logvalidate('sadmin');
page_header_store();
$msg='';
$response =1;
if(isset($_GET['book_id'])!=''){
	$response =2;
	}
if(isset($_POST['reissue'])){
	$sql1='select * from library_book_transaction where sno="'.$_POST['tran_id'].'"';
	$row=mysqli_fetch_array(execute_query(connect(), $sql1));
	$inv_no=$row['no_invoice']+1;
	$inv=$inv_no;
	$sql1='SELECT * FROM `library_edor` where sno=1';
	$row=mysqli_fetch_array(execute_query(connect(), $sql1));
	$edor=$_POST['issue_date'];
	$ed=strtotime(date("Y-m-d", strtotime($edor)) . " +".$row['days']."days");
	$e_dor=date('Y-m-d',$ed);
	$sql='UPDATE `library_book_transaction` set `e_dor`="'.$e_dor.'", `no_invoice`="'.$inv.'", date_of_reissue="'.$_POST['sale_date'].'" where sno="'.$_POST['tran_id'].'"';
	execute_query(connect(), $sql);
	//echo $sql;
}
if(isset($_POST['return'])){
	$sql='UPDATE `library_book_transaction`set `dor`="'.$_POST['sale_date'].'" where sno="'.$_POST['tran_id'].'"';
	execute_query(connect(), $sql);
	//echo $sql;
	}
if(isset($_POST['submit'])){
	$sql='select * from library_book_transaction join library_book_info on library_book_transaction.book_id = library_book_info.sno where 1=1 and dor=0';
	if($_POST['stu_id']!=''){
		$sql .=' and stu_id="'.$_POST['stu_id'].'"';
		}
	if($_POST['serial']!=''){
		$sql .=' and serial_no="'.$_POST['serial'].'"';
		}
	if($_POST['category']!=''){
		$sql .=' and category like "%'.$_POST['category'].'%"';
		}
	if($_POST['language']!=''){
		$sql .=' and language like"%'.$_POST['language'].'%"';
		}
	}
else {
	$sql='select * from library_book_transaction where 1=1 and dor=0';
	}
//echo $sql;
$result=execute_query(connect(), $sql);
?>
<script language="javascript" type="text/javascript">

$(function() {

	var options = {

		source: "sale_ajax.php?id=roll",

		minLength: 1,

		select: function( event, ui ) {

			log( ui.item ?

				"Selected: " + ui.item.value + " aka " + ui.item.label :

				"Nothing selected, input was " + this.value );

		},

		select: function( event, ui ) {

		    $("[name='roll_no']").val(ui.item.label);

			$('#stu_id').val(ui.item.id);

			$('#stu_name').val(ui.item.address);

			$('#f_name').val(ui.item.mobile);

			$("#ajax_loader").show();

			$("#final_result").load("purchase_ajax_new.php?supplier_sno="+ui.item.id, function(){ $("#ajax_loader").hide(); });

			return false;

		}

	};





$("input#roll_no").live("keydown.autocomplete", function() {

	$(this).autocomplete(options);

});
});
</script>
<style>

.ui-autocomplete-loading { background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat; }

</style>
<?php
switch($response){
	case $response == 1 : {
?>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="addnewsubject" enctype="multipart/form-data" method="post" onSubmit="" >
<h2><img style="width:40px;" src="images/add.png" />Transaction <span class="orange">Report</span></h2>
<h3><a href="transaction.php">Book Transaction</a></h3>
<ul>
<?php
if(isset($_POST['submit']) &&$msg!='') {
	echo $msg;
	$msg='';
}
?>
	 <li class="notranslate"><label  class="desc" for="sub_name">Roll No <span class="sub_name">*</span></label>
        <div><input type="text" name="roll_no" id="roll_no"class="fieldtextmedium" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
        <input type="hidden" name="stu_id" id="stu_id" value="" onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
     	</div>
    </li>
    <li class="notranslate"><label  class="desc" for="sub_name">Serial No <span class="sub_name">*</span></label>
        <div><input type="text" name="serial" id="serial"  class="fieldtextmedium" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
     	</div>
    </li>
    <li class="notranslate"><label  class="desc" for="sub_name">Subject<span class="sub_name">*</span></label>
        <div><input type="text" name="category" id="category"  class="fieldtextmedium" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
     	</div>
    </li>
   	<li class="notranslate"><label  class="desc" for="sub_name">Language<span class="sub_name">*</span></label>
        <div><input type="text" name="language" id="language"  class="fieldtextmedium" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
     	</div>
    </li>
    <li id="fo1li10" class="date notranslate">
            <label class="desc" id="title10" for="Field10">
            Date Of Issue
            </label>
            <span>
           	 <script type="text/javascript" language="javascript">
	  				DateInput('sale_date', false, 'YYYY-MM-DD', '<?php echo date("Y-m-d"); ?>')
      			</script>
            </span>
        </li>
  
	
<div><input type="submit" class="btTxt submit" name="submit" value="Submit"></div>
<table class="report" style="margin-bottom:70px;"> 
     <tr style="background:#000; font-weight:bold; font-size:14px; color:#FFF;">
    	<th style="color:#FFF;">Sno</th>
        <th style="color:#FFF;">Serial No</th>
        <th style="color:#FFF;">Book Name</th>
        <th style="color:#FFF;">Language</th>
        <th style="color:#FFF;">Subject</th>
        <th style="color:#FFF;">Student Name</th>
        <th style="color:#FFF;">Father's Name</th>
        <th style="color:#FFF;">Roll No.</th>
        <th style="color:#FFF;">Date of Issue</th>
        <th style="color:#FFF;">Expected Date</th>
        <th style="color:#FFF;"></th>
    </tr>
<?php 
$i=1;
while($row=mysqli_fetch_array($result)){
	$book=mysqli_fetch_array(execute_query(connect(), 'select * from library_book_info where sno="'.$row['book_id'].'"'));
	$stu=mysqli_fetch_array(execute_query(connect(), 'select * from student_info where sno="'.$row['stu_id'].'"'));
	if($i%2==0){
					$col = '#CCC';
				}
				else{
					$col = '#EEE';
				}
	echo'
		<tr style="background:'.$col.'">
			<td>'.$i.'</td>
			<td>'.$book['serial_no'].'</td>';
			if(strtoupper(trim($stu['language']))=='HINDI' or strtoupper(trim($stu['language']))=='' ){
				$lang = 'font-family:\'kruti Dev 010\'; font: \'kruti Dev 010\';';
			}
			else{
				$lang = '';
			}
			echo'
			<td style="'.$lang.'">'.$book['book_name'].'</td>
			<td>'.$book['language'].'</td>
			<td>'.$book['category'].'</td>
			<td>'.$stu['stu_name'].'</td>
			<td>'.$stu['father_name'].'</td>
			<td>'.$stu['roll_no'].'</td>
			<td>'.$row['issue_date'].'</td>
			<td>'.$row['e_dor'].'</td>
			<td><a href="transaction_report.php?book_id='.$row['sno'].'">Return/Reissue</a></td>
		</tr>
	';
$i++;
	}
?>
</table>
</ul>
</form></div></div>
<?php
break;
	}
case $response == 2 : {
if($_GET['book_id']!=''){
	$sql='select * from library_book_transaction where sno="'.$_GET['book_id'].'"';
	$row=mysqli_fetch_array(execute_query(connect(), $sql));
	$book=mysqli_fetch_array(execute_query(connect(), 'select * from library_book_info where sno="'.$row['book_id'].'"'));
	$stu=mysqli_fetch_array(execute_query(connect(), 'select * from student_info where sno="'.$row['stu_id'].'"'));
	$book_category=mysqli_fetch_array(execute_query(connect(), 'select * from library_category where sno="'.$book['category'].'"'));
	}				
?>
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="addnewsubject" enctype="multipart/form-data" method="post" onSubmit="" >
<h2><img style="width:40px;" src="images/add.png" />Book <span class="orange">Return/Reissue</span></h2>

<?php
if(isset($_POST['submit']) &&$msg!='') {
	echo $msg;
	$msg='';
}
?>
	<li id="fo1li10" class="date notranslate">
            <label class="desc" id="title10" for="Field10">
            Date
            </label>
            <span>
           	<input id="sale_date" name="sale_date" class="field text" size="12" maxlength="18" tabindex="1" type="text">
            </span>
        </li>
	 <li class="notranslate"><label  class="desc" for="book_name">Book Name <span class="sub_name">*</span></label>
        <div><input type="text" name="book_name" readonly="readonly" id="book_name"class="fieldtextmedium" value="<?php echo $book['book_name'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
        <input type="hidden" name="book_id" id="book_id" value="" onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
        <input type="hidden" name="issue_date" id="issue_date" value="<?php echo $row['e_dor'] ?>">
        <input type="hidden" name="tran_id" id="tran_id" value="<?php echo $row['sno'] ?>">
    </div></li>
    <li class="notranslate"><label  class="desc" for="subject">Subject <span class="sub_name">*</span></label>
        <div><input type="text" name="subject" id="subject" readonly="readonly" class="fieldtextmedium" value="<?php echo $book['subject'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
    </div></li>
    <li class="notranslate"><label  class="desc" for="language">Language Of Book <span class="sub_name">*</span></label>
        <div><input type="text" name="language" id="language" readonly="readonly" class="fieldtextmedium" value="<?php echo $book['language'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
    </div></li>
    <li class="notranslate"><label  class="desc" for="sub_name">Category <span class="sub_name">*</span></label>
        <div><input type="text" name="category" id="category" readonly="readonly" class="fieldtextmedium" value="<?php echo $book_category['desc'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
    	</div>
    </li>
    <li class="notranslate"><label  class="desc" for="s_name">Roll No <span class="sub_name">*</span></label>
        <div><input type="text" name="roll_no" id="roll_no" readonly="readonly" class="fieldtextmedium" value="<?php echo $stu['roll_no'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
        <input type="hidden" name="stu_id" id="stu_id" value="" onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
    </div></li>
    <li class="notranslate"><label  class="desc" for="stu_name">Student Name <span class="sub_name">*</span></label>
        <div><input type="text" name="stu_name" id="stu_name" readonly="readonly" class="fieldtextmedium" value="<?php echo $stu['stu_name'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
    </div></li>
    <li class="notranslate"><label  class="desc" for="edition">Father's Name <span class="sub_name">*</span></label>
        <div><input type="text" name="f_name" id="f_name" readonly="readonly" class="fieldtextmedium" value="<?php echo $stu['father_name'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
    </div></li>
 <div><table><tr><td><input type="submit" class="btTxt submit" name="return" value="Return" onClick="return confirmSubmit()"/></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>
<input type="submit" class="btTxt submit" name="reissue" value="Reissue" onClick="return confirmSubmit()"/></td></tr></table></div>
</form></div></div>
<?php
break; 
	}
		}
page_footer_store();
?>