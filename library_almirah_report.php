<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_store();
$msg='';
$response =1;
if(!isset($_REQUEST['id'])){
	$_REQUEST['id']=1;
}
if(isset($_GET['id'])!=''){
	$response =2;
}
if(isset($_POST['submit1'])!=''){
	$sql = 'update library_book_info set status = "'.$_POST['status'].'" where sno ="'.$_POST['book_id'].'"';
	execute_query(connect(), $sql);
	$response =1;
	//echo $sql;
}

function pagelist($id,$post,$sort){
	$page = ($_REQUEST['id']*30)-30;
	$page = $page+1;
	if($post!='') {
	     $sql = 'select * from library_book_info where '.$post.' like "'.$sort.'%"';
	}	
	else {
		 $sql ='select * from library_book_info';
	}
	//echo $sql;
	$res = execute_query(connect(), $sql);
	$rows = mysqli_num_rows($res);
	$rowcount = $rows;
	//echo "id".$rowcount;
	$pagecount = ceil($rowcount/30);
	$k = $_REQUEST['id'];
	if($id > 1){
		echo '<a href="library_book_report.php?id=1&type='.$post.'&sort='.$sort.'">&lt;&lt;</a> | <a href="library_book_report.php?id='.($id-1).'&type='.$post.'&sort='.$sort.'">&lt;';
	}
	if($id<=5){
		$x = 1;
	}
	else{
		$x = $id-4;
	}
	for($i=$x;$i<=$x+10;$i++){
		if($i>$pagecount){
			break;

		}

		if($k==$i) { $bc = "background-color:#900"; $c = "color:#fff"; }		

		else { $bc=""; $c="";}

		

		echo '<a href="library_book_report.php?id='.$i.'&type='.$post.'&sort='.$sort.'" style="'.$c.'">'.$i.'</a> | ';		

	}

	if($id < $pagecount){

		echo '<a href="library_book_report.php?id='.($id+1).'&type='.$post.'&sort='.$sort.'">&gt;</a> | <a href="library_book_report.php?id='.$pagecount.'&type='.$post.'&sort='.$sort.'">&gt;&gt;</a>';

	}

}


function customer($page,$info) {
	$page = ($page*30)-30;
	$i=$page+1;
	$link = connect();  echo ' 
	<div id="comment-wrapper">
    <div id="comments"> ';
if(isset($_POST['submit'])){
	$response=1;
	if($_POST['serial']!=''){
		$_SESSION['sql_result_filter'] = "select *  from library_book_info where serial_no='".$_POST['serial']."' limit ".$page.",30";
	}
	elseif($_POST['category']!==''){
		$_SESSION['sql_result_filter'] = "select *  from library_book_info where category like '".$_POST['category']."%' limit ".$page.",30";
	}
	elseif($_POST['language']!==''){
		$_SESSION['sql_result_filter'] = "select *  from library_book_info where language  like '".$_POST['language']."%' limit ".$page.",30";
	}
	elseif($_POST['status']!==''){
		$_SESSION['sql_result_filter'] = "select *  from library_book_info where status='".$_POST['status']." 'limit ".$page.",30";
	}
	elseif($_POST['book_name']!==''){
		$_SESSION['sql_result_filter'] = "select *  from library_book_info where book_name  like '".$_POST['book_name']."%' limit ".$page.",30";
	}
	
}
else{
	$_SESSION['sql_result_filter'] = "select *  from library_book_info order by abs(serial_no) limit ".$page.",30";
}
$result = execute_query(connect(), $_SESSION['sql_result_filter'],$link);
$i=1;
$tot=0;
//echo $_SESSION['sql_result_filter'];
while($row= mysqli_fetch_array($result)) {
	if($i%2==0){
		$col = '#CCC';
	}
	else{
		$col = '#EEE';
	}
	echo'
		<tr style="background:'.$col.'">
			<td>'.$i.'</td>
			<td>'.$row['serial_no'].'</td>';
			if(strtoupper(trim($row['language']))=='HINDI' or strtoupper(trim($row['language']))=='' ){
				$lang = 'font-family:\'kruti Dev 010\'; font: \'kruti Dev 010\'; font-size:18px;';
			}
			else{
				$lang = 'font-size:15px;';
			}
    	/*<th style="color:#FFF;">Sno</th>
        <th style="color:#FFF;">Serial No</th>
        <th style="color:#FFF;">Book Name</th>
        <th style="color:#FFF;">Language</th>
        <th style="color:#FFF;">Subject</th>
        <th style="color:#FFF;">Almirah</th>
        <th style="color:#FFF;">Tray</th>
        <th style="color:#FFF;">Purchase Date</th>
        <th style="color:#FFF;">Author Name</th>
        <th style="color:#FFF;">Salesman Name</th>
        <th style="color:#FFF;">Publisher Name</th>
        <th style="color:#F00;">Status</th>*/
			
			echo'<td style="'.$lang.'">'.$row['book_name'].'</td>
			<td>'.$row['language'].'</td>
			<td>'.$row['category'].'</td>
			<td>'.$row['itemrack'].'</td>
			<td>'.$row['tray'].'</td>
			<td>'.date("Y-m-d", strtotime($row['create_by'])).'</td>
			<td style="'.$lang.'">'.$row['auth_id'].'</td>
			<td style="'.$lang.'">'.$row['salesman_id'].'</td>
			<td style="'.$lang.'">'.$row['pub_name'].'</td>';
			if($row['status']==0){
				echo '<td  style="color:#060;">Available</td>';
			}
			elseif($row['status']==1){
				echo '<td  style="color:#F00;">Issued</td>';
			}
			elseif($row['status']==2){
				echo '<td  style="color:#00F;">Maintenance</td>';
			}
			elseif($row['status']==3){
				echo '<td  style="color:#F00;">Removed</td>';
			}
			
			echo'
			<td><a href="library_book_report.php?id='.$row['sno'].'"> Update Status</a></td>
			</tr>';
	$i++;
	}
	mysqli_free_result($result);
	mysqli_close($link); echo '
	</div> </div>';
	
}

?>
<script>

$(function () {

  

  var msie6 = $.browser == 'msie' && $.browser.version < 7;

  

  if (!msie6) {

    var top = $('#comment').offset().top - parseFloat($('#comment').css('margin-top').replace(/auto/, 0));

    $(window).scroll(function (event) {

      // what the y position of the scroll is

      var y = $(this).scrollTop();

      

      // whether that's below the form

      if (y >= top) {

        // if so, ad the fixed class

        $('#comment').addClass('fixed');

      } else {

        // otherwise remove it

        $('#comment').removeClass('fixed');

      }

    });

  }  

});

</script>
<script language="javascript" type="text/javascript">
function checkname(component) {

	var compo = document.getElementById(component).value; 

    if(compo=="") {

		document.getElementById("ima").style.display="block"

		document.getElementById("ima1").style.display="none"

	}

	else {

		document.getElementById("ima").style.display="none"

		document.getElementById("ima1").style.display="block"

	}

}

function checkpwd(component) {		

    var compo = document.getElementById(component).value;

	if(compo=="") {

		document.getElementById("pwd").style.display="block"

		document.getElementById("pwd1").style.display="none"

	}

	else {

		document.getElementById("pwd").style.display="none"

		document.getElementById("pwd1").style.display="block"

	}

}

$(function() {

	var options = {

		source: "sale_ajax.php?id=book",

		minLength: 1,

		select: function( event, ui ) {

			log( ui.item ?

				"Selected: " + ui.item.value + " aka " + ui.item.label :

				"Nothing selected, input was " + this.value );

		},

		select: function( event, ui ) {

		    $("[name='book_name']").val(ui.item.label);

			$('#book_id').val(ui.item.id);

			$('#subject').val(ui.item.address);

			$('#language').val(ui.item.mobile);

			$('#category').val(ui.item.balance);

			$('#last_balance').val(ui.item.balance);

			$('#tin').val(ui.item.tin);

			$("#ajax_loader").show();

			$("#final_result").load("purchase_ajax_new.php?supplier_sno="+ui.item.id, function(){ $("#ajax_loader").hide(); });

			return false;

		}

	};

$("input#book_name").live("keydown.autocomplete", function() {

	$(this).autocomplete(options);
	});
	
});
function change_font(){
	if(document.getElementById('english').checked){
		$(".ui-widget").css('font-family','"Arial Black", Gadget, sans-serif');
		$("#book_name").css('font-family','"Arial Black", Gadget, sans-serif');		
	}
	else{
		$(".ui-widget").css('font-family','"Kruti Dev 010"');
		$("#book_name").css('font-family','"Kruti Dev 010"');
	}
	//alert('done');
}

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
<h2><img style="width:40px;" src="images/add.png" />Subject Wise <span class="orange">Book Report</span></h2>

<?php
if(isset($_POST['submit']) &&$msg!='') {
	echo $msg;
	$msg='';
}
?>
    <li class="notranslate"><label  class="desc" for="sub_name">Serial No <span class="sub_name">*</span></label>
        <div><input type="text" name="serial" id="serial"  class="fieldtextmedium" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
     	</div>
    </li>
     <li class="notranslate"><label  class="desc" for="book_name" onClick="change_font()">Book Name <span class="sub_name">*</span></label>
        <div><input type="text" name="book_name" style="font-family:'Kruti Dev 010'" id="book_name" value=""  />
        	  <input type="hidden" name="book_id" value="">
        	  <input type="checkbox" name="english" id="english" onChange="change_font()">English
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
         <label  class="desc" for="sub_name">Status<span class="sub_name">*</span></label>
        <div>
        <select name="status">
        	<option value=""></option>
        	<option value="0">Available</option>
            <option value="1">Issued</option>
            <option value="2">Maintenance</option>
            <option value="3">Removed</option>
        </select>
     	</div>
    </li>
    <li id="fo1li10" class="date notranslate">
         <label  class="desc" for="sub_name">Fund Type<span class="sub_name">*</span></label>
        <div>
        <select name="status">
        	<option value=""></option>
        	<option value="General">General</option>
            <option value="U.G.C. Special">U.G.C. Special</option>
            <option value="UGC General">UGC General</option>
            <option value="U.G.C. Book Bank">U.G.C. Book Bank</option>
            <option value="UGC Basic">UGC Basic</option>
        </select>
     	</div>
    </li>
  
<div><li class="buttons"><input type="submit" class="btTxt submit" name="submit" value="Submit"></li></div>
<table border="0" style="margin-bottom:10px; width:780px;">
<?php

echo '<tr align="center"><th colspan="13">';

pagelist($_REQUEST['id'],10,10);

echo '</th></tr>';

?>
     <tr style="background:#000; font-weight:bold; font-size:14px; color:#FFF;">
    	<th style="color:#FFF;">Sno</th>
        <th style="color:#FFF;">Serial No</th>
        <th style="color:#FFF;">Book Name</th>
        <th style="color:#FFF;">Language</th>
        <th style="color:#FFF;">Subject</th>
        <th style="color:#FFF;">Almirah</th>
        <th style="color:#FFF;">Tray</th>
        <th style="color:#FFF;">Purchase Date</th>
        <th style="color:#FFF;">Author Name</th>
        <th style="color:#FFF;">Salesman Name</th>
        <th style="color:#FFF;">Publisher Name</th>
        <th style="color:#F00;">Status</th>
    </tr>		
 	<?php
	if(!isset($_REQUEST['type'])){
  
		$_REQUEST['type']='';
  
	}
  
	customer($_REQUEST['id'],$_REQUEST['type']);
  
	echo '<tr align="center"><th colspan="13">';
  
	pagelist($_REQUEST['id'],10,10);
  
	echo '</th></tr>';
  ?>		
 	</table>
</form></div></div>	
<?php
break;
	}

}
page_footer_store();
?>