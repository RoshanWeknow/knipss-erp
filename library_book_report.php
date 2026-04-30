<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
page_header_start();
$msg='';
$response =1;
if(isset($_GET['id'])){
	if($_GET['id']!=''){
		$response=2;
	}
}
if(isset($_POST['submit1'])){
	$sql='UPDATE `library_book_info` SET `book_name`="'.$_POST['book_name'].'", `subject`="'.$_POST['subject'].'", `language`="'.$_POST['language'].'", `serial_no`="'.$_POST['sno'].'", `publishing_year`="'.$_POST['p_year'].'", `edition`="'.$_POST['edition'].'", `pub_name`="'.$_POST['p_name'].'", `price`="'.$_POST['price'].'", `fund_type`="'.$_POST['f_type'].'", `isbn_no`="'.$_POST['isbn_no'].'" where sno="'.$_POST['info_id'].'"';
	execute_query(connect(), $sql);
	//echo $sql;
}

if(isset($_POST['submit'])){
	$sql='select * from library_book_info order by abs(serial_no)';
	if($_POST['book_id']!=''){
		$sql .=' and sno="'.$_POST['book_id'].'"';
		}
	}
else {
	$sql='select * from library_book_info order by abs(serial_no)';
}
$result=execute_query(connect(), $sql);
//echo $sql;
page_footer_end();
page_sidebar();

?>

<script language="javascript" type="text/javascript">
function calc_total(){

	var qty = document.getElementById('quantity').value;

	var price = document.getElementById('price').value;

	var transport_charge = document.getElementById('transport_charge').value;

	var total = (parseFloat(qty)*parseFloat(price))+parseFloat(transport_charge);

	document.getElementById('total').value = total;

}



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



function new_customer(){

	var custid = document.getElementById('supplier_sno').value;

	if(custid == ''){

		$("#final_result").load("purchase_ajax_new.php", function(){ $("#ajax_loader").hide(); });

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
$(function() {

	var options = {

		source: "sale_ajax.php",

		minLength: 1,

		select: function( event, ui ) {

			log( ui.item ?

				"Selected: " + ui.item.value + " aka " + ui.item.label :

				"Nothing selected, input was " + this.value );

		},

		select: function( event, ui ) {

			var id = document.getElementById('current').value;

		  	$("[name='part_desc"+id+"']").val(ui.item.label);

		  	$('#part_desc'+id+'_sno').val(ui.item.id);

			$('#part_desc'+id+'_unitprice').val(ui.item.purchase_price);



			$('#part_desc'+id+'_vat').val(ui.item.vat);

			$('#part_desc'+id+'_excise').val(ui.item.excise);

			$('#part_desc'+id+'_price').val(ui.item.sale_price);

			$('#part_desc'+id+'_unit').val(ui.item.unit);

			return false;

		}

	};





$("input#part_desc").live("keydown.autocomplete", function() {

	$(this).autocomplete(options);

});
	$( "#sale_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$("#sale_date").change(function(){
		$( "#sale_date" ).datepicker("option", "showAnim", "slide");
	});
});
});
});
</script>

<?php
switch($response){
	case $response == 1 : {
?>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">     	
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="addnewsubject" enctype="multipart/form-data" method="post" onSubmit="" >
					<h2><img  style="width:50px;" src="images/add.png" />Book <span class="orange">Report</span></h2>

					<?php
					if(isset($_POST['submit']) &&$msg!='') {
						echo $msg;
						$msg='';
					}
					?>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Book Name</label>
								<input type="text" name="book_name" id="book_name"class="form-control" value="" style="font-family:'Kruti Dev 010'"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
								<input type="hidden" name="book_id" id="book_id" value="" onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							
						</div>
						<input type="submit" class="btn btn-primary submit" name="submit" value="Submit">
					</div>
				</form>
			</div>
		</div>
		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white ">
					<th >Sno</th>
					<th >Book Name</th>
					<th >Language</th>
					<th >Category</th>
					<th >Itemrack</th>
					<th >Tray</th>
					<th >Serial No</th>
					<th ></th>
				</tr>
				<?php 
				$i=1;
				while($row=mysqli_fetch_array($result)){
					if($row['auth_id']!=''){
						$auth=mysqli_fetch_array(execute_query(connect(), 'select * from library_author where sno="'.$row['auth_id'].'"'));
					}
					$stu=mysqli_fetch_array(execute_query(connect(), 'select sum(qty) as quantity from library_book_purchase_invoice where book_id="'.$row['sno'].'"'));
					if($i%2==0){
									$col = '#CCC';
								}
								else{
									$col = '#EEE';
								}
					echo'
						<tr >
							<td>'.$i.'</td>';
							if($row['language']=='Hindi'){
								echo '<td style="font-family:\'kruti Dev 010\'; font: \'kruti Dev 010\';">'.$row['book_name'].'</td>';
							}
							else { 
								echo'<td>'.$row['book_name'].'</td>';
							}
							echo'<td>'.$row['language'].'</td>
							<td>'.$row['category'].'</td>
							<td>'.$row['itemrack'].'</td>
							<td>'.$row['tray'].'</td>
							<td>'.$row['serial_no'].'</td>
							<td><a href="library_book_report.php?id='.$row['sno'].'">Edit</a></td>
						</tr>
					';
				$i++;
					}
				?>
			</table>
		</div>
	</div>
	<?php
	break;
		}
	case $response == 2 : {
	if($_GET['id']!=''){
		$sql='select * from library_book_info where sno="'.$_GET['id'].'"';
		$row=mysqli_fetch_array(execute_query(connect(), $sql));
		$auth=mysqli_fetch_array(execute_query(connect(), 'select * from library_author where sno="'.$row['auth_id'].'"'));
		$stu=mysqli_fetch_array(execute_query(connect(), 'select * from library_saler where sno="'.$row['salesman_id'].'"'));
		$pur=mysqli_fetch_array(execute_query(connect(), 'select * from library_book_purchase_invoice where book_id="'.$row['sno'].'"'));
		}				
	?>
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">   	
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="addnewsubject" enctype="multipart/form-data" method="post" onSubmit="" >
					<h2><img style="width:40px;" src="images/add.png" />Edit <span class="orange">Book Report</span></h2>

					<?php
					if(isset($_POST['submit']) &&$msg!='') {
						echo $msg;
						$msg='';
					}
					?>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Book Name <span class="sub_name">*</span></label>
								<input type="text" name="book_name" id="book_name1"class="form-control" value="<?php echo $row['book_name'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
								<input type="hidden" name="biik_id" id="book_id" value="">
								<input type="hidden" name="info_id" id="info_id" value="<?php echo $row['sno'] ?>">
							</div>
							<div class="col-md-4">							
								<label>Subject <span class="sub_name">*</span></label>
								<input type="text" name="subject" id="subject"class="form-control" value="<?php echo $row['subject'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							<div class="col-md-4">							
								<label>Language Of Book <span class="sub_name">*</span></label>
								<input type="text" name="language" id="language"class="form-control" value="<?php echo $row['language'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Serial No <span class="sub_name">*</span></label>
								<input type="text" name="sno" id="sno"class="form-control" value="<?php echo $row['serial'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							<div class="col-md-4">							
								<label>Author Name <span class="sub_name">*</span></label>
								<input type="text" name="auth_name" id="auth_name"class="form-control" readonly="readonly" value="<?php echo $auth['name'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
								<input type="hidden" name="auth_id" id="auth_id" value="">
							</div>
							<div class="col-md-4">							
								<label>Publishing Year <span class="sub_name">*</span></label>
								<input type="text" name="p_year" id="p_year"class="form-control" value="<?php echo $row['publishing_year'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Edition <span class="sub_name">*</span></label>
								<input type="text" name="edition" id="edition"class="form-control" value="<?php echo $row['edition'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							<div class="col-md-4">							
								<label>Publisher Name <span class="sub_name">*</span></label>
								<input type="text" name="p_name" id="p_name"class="form-control" value="<?php echo $row['pub_name'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							<div class="col-md-4">							
								<label>Salesman Name <span class="sub_name">*</span></label>
								<input type="text" name="s_name" id="s_name"class="form-control" readonly="readonly" value="<?php echo $stu['name'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
								<input type="hidden" name="s_id" id="s_id" value="">
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Price <span class="sub_name">*</span></label>
								<input type="text" name="price" id="price"class="form-control" value="<?php echo $row['price'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							<div class="col-md-4">							
								<label>Quantity <span class="sub_name">*</span></label>
								<input type="text" name="qty" id="qty"class="form-control" value="<?php echo $pur['qty'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							<div class="col-md-4">							
								<label>Fund Type <span class="sub_name">*</span></label>
								<input type="text" name="f_type" id="f_type"class="form-control" value="<?php echo $row['fund_type'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>ISBN Number <span class="sub_name">*</span></label>
								<input type="text" name="isbn_no" id="isbn_no"class="form-control" value="<?php echo $row['isbn_no'] ?>"  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							
						</div>
						<input type="submit" class="btn btn-primary submit" name="submit1" value="Submit" onClick="return confirmSubmit()"/>	
					</div>
				</form>
			</div>	
		</div>
	</div>
	<?php
	break; 
		}
			}
	page_footer_start();
	page_footer_end();
	?>
</body>	