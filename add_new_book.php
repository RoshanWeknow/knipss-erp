<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$msg='';
$response =1;
if($_GET['id']=='return'){
	$response =2;
}
if(isset($_POST['submit'])){
	if($_POST['auth_name']=='')
		$vailid='<h3>Plese Enter Author Name</h3>';
		}
	if($_POST['s_name']==''){
		$vailid='<h3>Plese Enter Seller Name</h3>';
		}
	if($_POST['book_name']==''){
		$vailid='<h3>Plese Enter Book Name</h3>';
		}
	if($_POST['qty']==''){
		$vailid='<h3>Plese Enter Quantity</h3>';
		}
	if($_POST['price']==''){
		$vailid='<h3>Plese Enter Price</h3>';
	}

if($vailid==''){
	if($_POST['submit']){
		if($_POST['auth_id']==''){
			$sql='INSERT INTO `library_author`(`name`) VALUES("'.$_POST['auth_name'].'")';
			execute_query(connect(), $sql);
			$sql='select * from library_author order by sno desc limit 1';
			$auth=mysqli_fetch_array(execute_query(connect(), $sql));
			$auth_id=$auth['sno'];
		}
		else {
			$auth_id=$_POST['auth_id'];
		}
	}
	if($_POST['submit']){
		if($_POST['s_id']==''){
			$sql='INSERT INTO `library_saler`(`name`) VALUES("'.$_POST['s_name'].'")';
			execute_query(connect(), $sql);
			$sql='select * from library_saler order by sno desc limit 1';
			$saler=mysqli_fetch_array(execute_query(connect(), $sql));
			$saler_id=$saler['sno'];
		}
		else {
			$saler_id=$_POST['s_id'];
		}
	}
	if($_POST['submit']){
		$sql='INSERT INTO `library_book_info`(`book_name`, `subject`, `language`, `category`, `serial_no`, `publishing_year`, `auth_id`, `salesman_id`, `edition`, `pub_name`, `price`, `fund_type`, `isbn_no`, `create_by`) VALUES("'.$_POST['book_name'].'","'.$_POST['subject'].'","'.$_POST['language'].'","'.$_POST['category'].'","'.$_POST['sno'].'","'.$_POST['p_year'].'","'.$auth_id.'","'.$saler_id.'","'.$_POST['edition'].'","'.$_POST['p_name'].'","'.$_POST['price'].'","'.$_POST['f_type'].'","'.$_POST['isbn_no'].'", "'.$_POST['dop'].'")';
		execute_query(connect(), $sql);
	}
	$sql='select * from library_book_info order by sno desc limit 1';
	$book=mysqli_fetch_array(execute_query(connect(), $sql));
	$book_id=$book['sno'];
	if($_POST['submit']){
			$sql='INSERT INTO `library_book_purchase_invoice`(`book_id`, `qty`) VALUES("'.$book_id.'", "'.$_POST['qty'].'")';
			execute_query(connect(), $sql);
			$msg='<h3>Book Added Successful</h3>';
	}
}
page_header_end();
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
	});
$(function() {

	var options = {

		source: "sale_ajax.php?id=auth",

		minLength: 1,

		select: function( event, ui ) {

			log( ui.item ?

				"Selected: " + ui.item.value + " aka " + ui.item.label :

				"Nothing selected, input was " + this.value );

		},

		select: function( event, ui ) {

		    $("[name='auth_name']").val(ui.item.label);

			$('#auth_id').val(ui.item.id);

			$("#ajax_loader").show();

			$("#final_result").load("purchase_ajax_new.php?supplier_sno="+ui.item.id, function(){ $("#ajax_loader").hide(); });

			return false;

		}

	};
	
$("input#auth_name").live("keydown.autocomplete", function() {

	$(this).autocomplete(options);
	});

$(function() {

	var options = {

		source: "sale_ajax.php?id=seller",

		minLength: 1,

		select: function( event, ui ) {

			log( ui.item ?

				"Selected: " + ui.item.value + " aka " + ui.item.label :

				"Nothing selected, input was " + this.value );

		},

		select: function( event, ui ) {

		    $("[name='s_name']").val(ui.item.label);

			$('#s_id').val(ui.item.id);

			$("#final_result").load("purchase_ajax_new.php?supplier_sno="+ui.item.id, function(){ $("#ajax_loader").hide(); });

			return false;

		}

	};





$("input#s_name").live("keydown.autocomplete", function() {

	$(this).autocomplete(options);

});
});
});
</script>

<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="add_new_book.php" class="wufoo leftLabel page1"  name="addnewsubject" enctype="multipart/form-data" method="post" onSubmit="" >
					<h2><img style="width:40px;" src="images/add.png" />Add New <span class="orange">Book</span></h2>

					<?php
					if(isset($_POST['submit']) &&$msg!='') {
						echo $msg;

						$msg='';
					}
						echo $vailid;
					?>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Book Name <span class="sub_name">*</span></label>
								<input type="text" name="book_name" id="book_name"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
								<input type="hidden" name="biik_id" id="book_id" value="">
							</div>
							<div class="col-md-4">							
								<label>Date of Purchase<span class="name">*</span></label>
								
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('dop', 'dop', true, 'YYYY-MM-DD', '<?php if(isset($_POST['dop'])){echo $_POST['dop'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
							</div>
							<div class="col-md-4">							
								<label>Subject <span class="sub_name">*</span></label>
								<input type="text" name="subject" id="subject"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Language Of Book <span class="sub_name">*</span></label>
								<input type="text" name="language" id="language"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							<div class="col-md-4">							
								<label>Category <span class="sub_name">*</span></label>
								<select name="category" class="form-control">
								  <?php
									$sql = 'select * from library_category';
									$res = execute_query(connect(), $sql);
									while($row = mysqli_fetch_array($res)) {
										echo '<option value="'.$row['sno'].'">'.$row['desc'].'</option> ';
									}
								  ?>
								</select>
							</div>
							<div class="col-md-4">							
								<label>Serial No <span class="sub_name">*</span></label>
								<input type="text" name="sno" id="sno"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Author Name <span class="sub_name">*</span></label>
								<input type="text" name="auth_name" id="auth_name"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
								<input type="hidden" name="auth_id" id="auth_id" value="">
							</div>
							<div class="col-md-4">							
								<label>Publishing Year <span class="sub_name">*</span></label>
								<input type="text" name="p_year" id="p_year"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							<div class="col-md-4">							
								<label>Edition <span class="sub_name">*</span></label>
								<input type="text" name="edition" id="edition"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Publisher Name <span class="sub_name">*</span></label>
								<input type="text" name="p_name" id="p_name"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							<div class="col-md-4">							
								<label>Salesman Name <span class="sub_name">*</span></label>
								<input type="text" name="s_name" id="s_name"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
								<input type="hidden" name="s_id" id="s_id" value="">
							</div>
							<div class="col-md-4">							
								<label>Price <span class="sub_name">*</span></label>
								<input type="text" name="price" id="price"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							
						</div>
						<div class="row">							
							
							<div class="col-md-4">							
								<label>Quantity <span class="sub_name">*</span></label>
								<input type="text" name="qty" id="qty"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							<div class="col-md-4">							
								<label>Fund Type <span class="sub_name">*</span></label>
								<input type="text" name="f_type" id="f_type"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
							<div class="col-md-4">							
								<label>ISBN Number <span class="sub_name">*</span></label>
								<input type="text" name="isbn_no" id="isbn_no"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
							</div>
						</div>
						
						<input type="submit" class="btn btn-primary submit" name="submit" value="Submit" onClick="return confirmSubmit()"/>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
page_footer_start();
page_footer_end();
?>