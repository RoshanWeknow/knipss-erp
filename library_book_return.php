7<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$response=1;
$msg='';
if(isset($_POST['save'])) {
	if($_POST['serial_no']!=''){
		$sql="select *, library_book_transaction.sno as number from library_book_transaction join student_info on library_book_transaction.stu_id = student_info.sno join library_book_info  on library_book_info.sno = library_book_transaction.book_id where library_book_info.serial_no like '".$_POST['serial_no']."%' and library_book_transaction.status=0";
	}	
	elseif($_POST['roll_no']!=''){
		$sql="select *, library_book_transaction.sno as number  from library_book_transaction join student_info on library_book_transaction.stu_id = student_info.sno join library_book_info  on library_book_info.sno = library_book_transaction.book_id where roll_no like '".$_POST['roll_no']."%' and library_book_transaction.status=0";
	}	
	else{
		$sql="select *, library_book_transaction.sno as number  from library_book_transaction join student_info on library_book_transaction.stu_id = student_info.sno join library_book_info  on library_book_info.sno = library_book_transaction.book_id and library_book_transaction.status=0";
	}
	$sql .= ' limit 0,30';
	$result = execute_query(connect(), $sql);
	//echo $sql;
	$i=1;
	$msg .= '<table width="100%" class="table table-striped table-hover rounded"><tr class="bg-primary text-white"><th>Roll No</th><th>Student Name</th><th>Serial No</th> <th>Book Name</th><th>Issue Date</th></tr>';
	while($stu = mysqli_fetch_array($result)){
		$msg .= '<tr><th>'.$i++.'</th><td>'.$stu['stu_name'].'</td><td>'.$stu['serial_no'].'</td><td>'.$stu['book_name'].'</td><td>'.$stu['issue_date'].'</td><td><a href="library_book_return.php?id='.$stu['number'].'">EDIT</td></tr>';
	}
	$msg .= '</table>';
	$response=1;
}

if(isset($_GET['id'])){
	$sql='select * from library_book_transaction where sno="'.$_GET['id'].'"';
	$row=mysqli_fetch_array(execute_query(connect(), $sql));
	$book=mysqli_fetch_array(execute_query(connect(), 'select * from library_book_info where sno="'.$row['book_id'].'"'));
	$almirah = mysqli_fetch_array(execute_query(connect(), "select * from library_almirah where sno='".$book['itemrack']."'"));
	$tray = mysqli_fetch_array(execute_query(connect(), "select * from library_almirah_tray where sno='".$book['tray']."'"));
	$sub = mysqli_fetch_array(execute_query(connect(), "select * from library_subject where sno='".$book['category']."'"));
	$stu=mysqli_fetch_array(execute_query(connect(), 'select * from student_info where sno="'.$row['stu_id'].'"'));
	$response=2;
	}
if(isset($_POST['reissue'])){
	$sql='UPDATE `library_book_transaction`set `dor`="'.$_POST['sale_date'].'",`date_of_reissue`="'.$_POST['sale_date'].'", `status`="1" where sno="'.$_POST['tran_id'].'"';
	execute_query(connect(), $sql);
	
	$sql1='SELECT * FROM `library_edor` where sno=1';
	$row=mysqli_fetch_array(execute_query(connect(), $sql1));
	$edor=$_POST['sale_date'];
	$ed=strtotime(date("Y-m-d", strtotime($edor)) . " +".$row['days']."days");
	$e_dor=date('Y-m-d',$ed);
	
	$sql='INSERT INTO `library_book_transaction`(`stu_id`, `book_id`, `issue_date`, `e_dor`, `no_invoice`, `dor`, `qty`, `status`) VALUES (
	"'.$_POST['stu_id'].'","'.$_POST['book_id'].'","'.$_POST['sale_date'].'","'.$e_dor.'","1","0","1","0")';
	execute_query(connect(), $sql);
	//echo $sql;
	
	$sql_update = 'update library_book_info set `status`=1 where sno="'.$_POST['book_id'].'"';
	execute_query(connect(), $sql_update);
	
	$msg .='<h3>Transaction is Successful</h3>';
	
	/*$sql1='select * from library_book_transaction where sno="'.$_POST['tran_id'].'"';
	$row=mysqli_fetch_array(execute_query(connect(), $sql1));
	$inv_no=$row['no_invoice']+1;
	$inv=$inv_no;
	
	$sql1='SELECT * FROM `library_edor` where sno=1';
	$row=mysqli_fetch_array(execute_query(connect(), $sql1));
	$edor=$_POST['issue_date'];
	$ed=strtotime(date("Y-m-d", strtotime($edor)) . " +".$row['days']."days");
	$e_dor=date('Y-m-d',$ed);
	
	$sql='insert `library_book_transaction` set `e_dor`="'.$e_dor.'", `no_invoice`="'.$inv.'", date_of_reissue="'.$_POST['sale_date'].'" where sno="'.$_POST['tran_id'].'"';
	execute_query(connect(), $sql);
	$msg .='<h2>Book Reissue  Successfully</h2>';
	//echo $sql;*/
}
if(isset($_POST['return'])){
	$sql='UPDATE `library_book_transaction`set `dor`="'.$_POST['sale_date'].'", `status`="1" where sno="'.$_POST['tran_id'].'"';
	execute_query(connect(), $sql);
	//echo $sql;
	
	$sql='UPDATE `library_book_info`set `status`="0" where serial_no="'.$_POST['serial'].'"';
	execute_query(connect(), $sql);
	$msg .='<h2>Book Return  Successfully</h2>';
	//echo $sql;
}
page_header_end();
page_sidebar();
?>

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

			$('#category').val(ui.item.category);

			$('#language').val(ui.item.language);
				
			$('#itemrack').val(ui.item.itemrack);
			
			$('#tray').val(ui.item.tray);
			
			$('#itemrack').val(ui.item.itemrack);
		
			$('#serial').val(ui.item.serial);
		
			$("#ajax_loader").show();

			$("#final_result").load("purchase_ajax_new.php?supplier_sno="+ui.item.id, function(){ $("#ajax_loader").hide(); });

			return false;

		}

	};





$("input#book_name").live("keydown.autocomplete", function() {

	$(this).autocomplete(options);
	});

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
	case 1:{
?>

<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="addnewsubject" enctype="multipart/form-data" method="post" onSubmit="" >
					<h2><img style="width:40px;" src="images/add.png" />Book Return/Reissue</span>
					<a href="transaction_report.php" style="float:right" class="btn btn-primary text-white">Book (Return/Reissue) Report</a></h2>
					
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Serial No <span class="sub_name">*</span></label>
								<input type="text" name="serial_no" id="serial_no"  class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							<div class="col-md-4">							
								<label>Roll No <span class="sub_name">*</span></label>
								<input type="text" class="form-control" name="roll_no" id="roll_no" value=""  />
							</div>
							
						</div>
						<input type="submit" class="btn btn-primary submit" name="save" value="Submit" />
					</div>
				</form>
			</div>
		</div>
		<div class="card card-body">
			<?php echo $msg; ?>
		</div>
	</div>	
<?php 
	break;
}
case 2:{

?>
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
				<form action="library_book_return.php" class="wufoo leftLabel page1" name="addnewsubject" enctype=	"multipart/form-data" 	method="post" onSubmit="" >
					<h2><img style="width:40px;" src="images/add.png" />Add New <span class="orange">Book</span></h2>
					<?php
					if(isset($_POST['submit']) &&$msg!='') {
						echo $msg;
						$msg='';
					}
					?>
					<li id="fo1li10" class="date notranslate">
							<label class="desc" id="title10" for="Field10">
							Issue 	Date
							</label>
							<div><input type="text" name="issue_date" readonly="readonly" id="issue_date"class="form-control" value="<?php echo $row['issue_date'] ?>"  onkeyup= 						"formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
					</li>
					<li class="notranslate">
						<label  class="desc" for="book_name">Book Name <span class="sub_name">*</span>
						</label>
						<div>
							<input type="text" name="book_name" style="font-family:'Kruti Dev 010'" id="book_name"class="form-control" readonly="readonly" value="<?php echo $book['book_name'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							<input type="hidden" name="book_id" id="book_id" value="<?php echo $book['sno'] ?>" onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							<input type="hidden" name="issue_date" id="issue_date" value="<?php echo $row['e_dor'] ?>">
							<input type="hidden" name="tran_id" id="tran_id" value="<?php echo $row['sno'] ?>">
						</div>
					</li>
					<li class="notranslate"><label  class="desc" for="sub_name">Category <span class="sub_name">*</span></label>
						<div><input type="text" name="category" id="category" readonly="readonly"  class="form-control" value="<?php echo 	 $sub['subject_name'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
						</div>
					</li>
				   
					<li class="notranslate"><label  class="desc" for="language">Language Of Book <span class="sub_name">*</span></label>
						<div><input type="text" name="language" id="language" readonly="readonly" class="form-control" value="<?php echo $book['language'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
						</div>
					</li>
					<li class="notranslate"><label  class="desc" for="sub_name">Itemrack <span class="sub_name">*</span></label>
						<div><input type="text" name="itemrack" id="itemrack" readonly="readonly" class="form-control" value="<?php echo $almirah['almirah_name'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
						</div>
					</li>
					<li class="notranslate"><label  class="desc" for="sub_name">Tray <span class="sub_name">*</span></label>
						<div><input type="text" name="tray" id="tray" readonly="readonly" class="form-control" value="<?php echo $tray['tray_name'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
						</div>
					</li>
					
					<li class="notranslate"><label  class="desc" for="sub_name">Serial No <span class="sub_name">*</span></label>
						<div><input type="text" name="serial" id="serial" readonly="readonly" class="form-control" value="<?php echo $book['serial_no'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
						</div>
					</li>
					
					<li class="notranslate"><label  class="desc" for="s_name">Roll No <span class="sub_name">*</span></label>
						<div><input type="text" name="roll_no" id="roll_no" readonly="readonly" class="form-control" value="<?php echo $stu['roll_no'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
						<input type="hidden" name="stu_id" id="stu_id" value="<?php echo $stu['sno'] ?>" onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
						</div>
					</li>
					<li class="notranslate"><label  class="desc" for="stu_name">Student Name <span class="sub_name">*</span></label>
						<div><input type="text" name="stu_name" id="stu_name" readonly="readonly" class="form-control" value="<?php echo $stu['stu_name'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
						</div>
					</li>
					<li class="notranslate"><label  class="desc" for="edition">Father's Name <span class="sub_name">*</span></label>
						<div><input type="text" name="f_name" id="f_name" readonly="readonly" class="form-control" value="<?php echo $stu['father_name'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
						</div>
					</li>
					<li id="fo1li10" class="date notranslate">
							<label class="desc" id="title10" for="Field10">
								Submit Date
							</label>
							<span>
								<script type="text/javascript" language="javascript">
									DateInput('sale_date', false, 'YYYY-MM-DD', '<?php echo date("Y-m-d"); ?>')
								</script>
							</span>
					</li>
					<div>
						<table>
							<tr>
								<td><input type="submit" class="btTxt submit" name="return" value="Return" onClick="return confirmSubmit()"/></td>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
								<td>
									<input type="submit" class="btTxt submit" name="reissue" value="Reissue" onClick="return confirmSubmit()"/>
								</td>
							</tr>
						</table>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
	break;
		}
	}
	?>
	<?php
	page_footer_start();
	page_footer_end();
	?>
</body>
