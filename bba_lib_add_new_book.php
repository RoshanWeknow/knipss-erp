<?php 
//include("scripts/settings.php");
include("bba_lib_setting.php");
$msg='';
// page_header_start();
// page_header_end();
// page_sidebar();
header_lib();
$msg = '';
$cont = '';
?>
<?php
	if(isset($_POST['submit'])){
		if(isset($_POST['edit']) && $_POST['edit'] != ''){
			$sql = 'update lib_add_new_book set 
					library_location="'.$_POST['library_location'].'",
					building_name="'.$_POST['building_name'].'",
					almirah_name="'.$_POST['almirah_name'].'",
					tray_name="'.$_POST['tray_name'].'",
					book_category="'.$_POST['book_category'].'",
					accession_no="'.$_POST['accession_no'].'",
					ddc_code="'.$_POST['ddc_code'].'",
					book_no="'.$_POST['book_no'].'",
					mfn="'.$_POST['mfn'].'",
					entry_language="'.$_POST['entry_language'].'",
					subject="'.$_POST['subject'].'",
					serial_no="'.$_POST['serial_no'].'",
					author_name="'.$_POST['author_name'].'",
					publication_year="'.$_POST['publication_year'].'",
					edition="'.$_POST['edition'].'",
					accession_no901="'.$_POST['accession_no901'].'",
					isbn_no="'.$_POST['isbn_no'].'",
					unit_cost="'.$_POST['unit_cost'].'",
					currency="'.$_POST['currency'].'",
					fund_type="'.$_POST['fund_type'].'",
					source="'.$_POST['source'].'",
					vendor="'.$_POST['vendor'].'",
					invoice_no="'.$_POST['invoice_no'].'",
					invoice_date="'.$_POST['invoice_date'].'",
					po_no="'.$_POST['po_no'].'",
					publication_category="'.$_POST['publication_category'].'",
					date_of_purchase="'.$_POST['date_of_purchase'].'",
					title="'.$_POST['title'].'",
					multiscript_title="'.$_POST['multiscript_title'].'",
					sub_title="'.$_POST['sub_title'].'",
					language="'.$_POST['language'].'",
					uniform_title="'.$_POST['uniform_title'].'",
					trans_title="'.$_POST['trans_title'].'",
					var_title="'.$_POST['var_title'].'",
					gmd="'.$_POST['gmd'].'",
					current_edition="'.$_POST['current_edition'].'",
					shelf_location="'.$_POST['shelf_location'].'",
					rem_of_edit="'.$_POST['rem_of_edit'].'",
					inventory_category="'.$_POST['inventory_category'].'",
					pagination="'.$_POST['pagination'].'",
					illustration="'.$_POST['illustration'].'",
					dimension="'.$_POST['dimension'].'",
					accomp_material="'.$_POST['accomp_material'].'",
					quantity="'.$_POST['quantity'].'",
					publisher_name="'.$_POST['publisher_name'].'",
					place="'.$_POST['place'].'",
					salesman_name="'.$_POST['salesman_name'].'",
					pub_year="'.$_POST['pub_year'].'",
					country="'.$_POST['country'].'",
					edited_by="'.$_SESSION['username'].'",
					edition_time="'.date('Y-m-d H:m:s').'"
					where sno = '.$_POST['edit'];
			//echo $sql;
			mysqli_query($db, $sql);
			if(mysqli_errno($db)){
				echo "Updation failed".mysqli_errno($db).mysqli_error($db);
			}
			else {
				echo "<h4 style=\"color:green;\">Successfully updated</h4><br><h4 style=\"color:#FF0000;\"><a href=\"lib_modify_new_book.php\">Modify Another Book</a></h4>";
			}
		}
		else{
			$accession_no = $_POST['accession_no'];
			$quantity = $_POST['quantity'];
			if($quantity < 2){
				$sql = 'insert into lib_add_new_book(library_location,building_name,almirah_name,tray_name,book_category,accession_no,ddc_code,book_no,mfn,entry_language, subject,serial_no,author_name ,publication_year, edition, accession_no901, isbn_no, unit_cost, currency, fund_type, source, vendor, invoice_no, invoice_date, po_no, publication_category, date_of_purchase, title, multiscript_title, sub_title, language, uniform_title, trans_title, var_title, gmd, current_edition, shelf_location, rem_of_edit, inventory_category, pagination, illustration, dimension, accomp_material, quantity, publisher_name, place, salesman_name, pub_year, country, created_by, creation_time)values("'.$_POST['library_location'].'","'.$_POST['building_name'].'","'.$_POST['almirah_name'].'","'.$_POST['tray_name'].'","'.$_POST['book_category'].'","'.$accession_no.'","'.$_POST['ddc_code'].'","'.$_POST['book_no'].'","'.$_POST['mfn'].'","'.$_POST['entry_language'].'","'.$_POST['subject'].'","'.$_POST['serial_no'].'","'.$_POST['author_name'].'","'.$_POST['publication_year'].'", "'.$_POST['edition'].'", "'.$_POST['accession_no901'].'", "'.$_POST['isbn_no'].'", "'.$_POST['unit_cost'].'", "'.$_POST['currency'].'", "'.$_POST['fund_type'].'", "'.$_POST['source'].'", "'.$_POST['vendor'].'", "'.$_POST['invoice_no'].'", "'.$_POST['invoice_date'].'", "'.$_POST['po_no'].'", "'.$_POST['publication_category'].'", "'.$_POST['date_of_purchase'].'", "'.$_POST['title'].'", "'.$_POST['multiscript_title'].'", "'.$_POST['sub_title'].'", "'.$_POST['language'].'", "'.$_POST['uniform_title'].'", "'.$_POST['trans_title'].'", "'.$_POST['var_title'].'", "'.$_POST['gmd'].'", "'.$_POST['current_edition'].'", "'.$_POST['shelf_location'].'", "'.$_POST['rem_of_edit'].'", "'.$_POST['inventory_category'].'", "'.$_POST['pagination'].'", "'.$_POST['illustration'].'", "'.$_POST['dimension'].'", "'.$_POST['accomp_material'].'", "'.$quantity.'", "'.$_POST['publisher_name'].'", "'.$_POST['place'].'", "'.$_POST['salesman_name'].'", "'.$_POST['pub_year'].'", "'.$_POST['country'].'", "'.$_SESSION['username'].'","'.date('Y-m-d H:m:s').'")';
				//echo $sql;
				mysqli_query($db, $sql);
				if(mysqli_errno($db)){
					$msg = "Insertion failed".mysqli_errno($db).mysqli_error($db);
					$cont = 1;
				}
				else{
					$msg = '<h4 style="color:green;">Book Saved</h4>';
					$cont = 1;
				}
				/*if($cont = 1){
					$sql2 = 'insert into lib_old_book_info(Lib_location,building_name,almirah_name,tray_name,book_category,accession_no,ddc_code,BookNo,MFN,entry_language, Subject_Heading,serial_no,AuthorName,publication_year, Present_Edition, accession_no901, isbn_no, UnitCost, currency, fund_type, source, vendor, invoice_no, invoice_date, po_no, PubCategory, date_of_purchase, Title, Multiscript, sub_title, language, uniform_title, trans_title, var_title, gmd, current_edition, Shelf_location, rem_of_edit, Inv_Categ, Pages, illustration, dimension, accomp_material, quantity, Publisher_Name, place, salesman_name, pub_year, country, created_by, creation_time)values("'.$_POST['library_location'].'","'.$_POST['building_name'].'","'.$_POST['almirah_name'].'","'.$_POST['tray_name'].'","'.$_POST['book_category'].'","'.$accession_no.'","'.$_POST['ddc_code'].'","'.$_POST['book_no'].'","'.$_POST['mfn'].'","'.$_POST['entry_language'].'","'.$_POST['subject'].'","'.$_POST['serial_no'].'","'.$_POST['author_name'].'","'.$_POST['publication_year'].'", "'.$_POST['edition'].'", "'.$_POST['accession_no901'].'", "'.$_POST['isbn_no'].'", "'.$_POST['unit_cost'].'", "'.$_POST['currency'].'", "'.$_POST['fund_type'].'", "'.$_POST['source'].'", "'.$_POST['vendor'].'", "'.$_POST['invoice_no'].'", "'.$_POST['invoice_date'].'", "'.$_POST['po_no'].'", "'.$_POST['publication_category'].'", "'.$_POST['date_of_purchase'].'", "'.$_POST['title'].'", "'.$_POST['multiscript_title'].'", "'.$_POST['sub_title'].'", "'.$_POST['language'].'", "'.$_POST['uniform_title'].'", "'.$_POST['trans_title'].'", "'.$_POST['var_title'].'", "'.$_POST['gmd'].'", "'.$_POST['current_edition'].'", "'.$_POST['shelf_location'].'", "'.$_POST['rem_of_edit'].'", "'.$_POST['inventory_category'].'", "'.$_POST['pagination'].'", "'.$_POST['illustration'].'", "'.$_POST['dimension'].'", "'.$_POST['accomp_material'].'", "'.$quantity.'", "'.$_POST['publisher_name'].'", "'.$_POST['place'].'", "'.$_POST['salesman_name'].'", "'.$_POST['pub_year'].'", "'.$_POST['country'].'", "'.$_SESSION['username'].'","'.date('Y-m-d H:m:s').'")';
					echo $sql2;
					mysqli_query($db, $sql2);
					if(mysqli_errno($db)){
						$msg = "Insertion failed".mysqli_errno($db).mysqli_error($db);
					}
					else{
						$msg = '<h4 style="color:green;">Book Saved</h4>';
					}
				}*/
				
			}
			elseif($quantity > 1){
				$i = 1;
				while($i <= $quantity ){
					$sql = 'insert into lib_add_new_book(library_location,building_name,almirah_name,tray_name,book_category,accession_no,ddc_code,book_no,mfn,entry_language, subject,serial_no,author_name ,publication_year, edition, accession_no901, isbn_no, unit_cost, currency, fund_type, source, vendor, invoice_no, invoice_date, po_no, publication_category, date_of_purchase, title, multiscript_title, sub_title, language, uniform_title, trans_title, var_title, gmd, current_edition, shelf_location, rem_of_edit, inventory_category, pagination, illustration, dimension, accomp_material, quantity, publisher_name, place, salesman_name, pub_year, country, created_by, creation_time)values("'.$_POST['library_location'].'","'.$_POST['building_name'].'","'.$_POST['almirah_name'].'","'.$_POST['tray_name'].'","'.$_POST['book_category'].'","'.$accession_no.'","'.$_POST['ddc_code'].'","'.$_POST['book_no'].'","'.$_POST['mfn'].'","'.$_POST['entry_language'].'","'.$_POST['subject'].'","'.$_POST['serial_no'].'","'.$_POST['author_name'].'","'.$_POST['publication_year'].'", "'.$_POST['edition'].'", "'.$_POST['accession_no901'].'", "'.$_POST['isbn_no'].'", "'.$_POST['unit_cost'].'", "'.$_POST['currency'].'", "'.$_POST['fund_type'].'", "'.$_POST['source'].'", "'.$_POST['vendor'].'", "'.$_POST['invoice_no'].'", "'.$_POST['invoice_date'].'", "'.$_POST['po_no'].'", "'.$_POST['publication_category'].'", "'.$_POST['date_of_purchase'].'", "'.$_POST['title'].'", "'.$_POST['multiscript_title'].'", "'.$_POST['sub_title'].'", "'.$_POST['language'].'", "'.$_POST['uniform_title'].'", "'.$_POST['trans_title'].'", "'.$_POST['var_title'].'", "'.$_POST['gmd'].'", "'.$_POST['current_edition'].'", "'.$_POST['shelf_location'].'", "'.$_POST['rem_of_edit'].'", "'.$_POST['inventory_category'].'", "'.$_POST['pagination'].'", "'.$_POST['illustration'].'", "'.$_POST['dimension'].'", "'.$_POST['accomp_material'].'", "'.$quantity.'", "'.$_POST['publisher_name'].'", "'.$_POST['place'].'", "'.$_POST['salesman_name'].'", "'.$_POST['pub_year'].'", "'.$_POST['country'].'", "'.$_SESSION['username'].'","'.date('Y-m-d H:m:s').'")';
					//echo $sql;
					mysqli_query($db, $sql);
					if(mysqli_errno($db)){
					echo '<h4 style="color:red;">Book Not Saved</h4>'.mysqli_errno($db).mysqli_error($db);
					}
					else{
						echo'<h4 style="color:green;">Book Saved</h4>';
						
					}
					/*
					$sql2 = 'insert into lib_old_book_info(Lib_location,building_name,almirah_name,tray_name,book_category,accession_no,ddc_code,BookNo,MFN,entry_language, Subject_Heading,serial_no,AuthorName,publication_year, Present_Edition, accession_no901, isbn_no, UnitCost, currency, fund_type, source, vendor, invoice_no, invoice_date, po_no, PubCategory, date_of_purchase, Title, Multiscript, sub_title, language, uniform_title, trans_title, var_title, gmd, current_edition, Shelf_location, rem_of_edit, Inv_Categ, Pages, illustration, dimension, accomp_material, quantity, Publisher_Name, place, salesman_name, pub_year, country, created_by, creation_time)values("'.$_POST['library_location'].'","'.$_POST['building_name'].'","'.$_POST['almirah_name'].'","'.$_POST['tray_name'].'","'.$_POST['book_category'].'","'.$accession_no.'","'.$_POST['ddc_code'].'","'.$_POST['book_no'].'","'.$_POST['mfn'].'","'.$_POST['entry_language'].'","'.$_POST['subject'].'","'.$_POST['serial_no'].'","'.$_POST['author_name'].'","'.$_POST['publication_year'].'", "'.$_POST['edition'].'", "'.$_POST['accession_no901'].'", "'.$_POST['isbn_no'].'", "'.$_POST['unit_cost'].'", "'.$_POST['currency'].'", "'.$_POST['fund_type'].'", "'.$_POST['source'].'", "'.$_POST['vendor'].'", "'.$_POST['invoice_no'].'", "'.$_POST['invoice_date'].'", "'.$_POST['po_no'].'", "'.$_POST['publication_category'].'", "'.$_POST['date_of_purchase'].'", "'.$_POST['title'].'", "'.$_POST['multiscript_title'].'", "'.$_POST['sub_title'].'", "'.$_POST['language'].'", "'.$_POST['uniform_title'].'", "'.$_POST['trans_title'].'", "'.$_POST['var_title'].'", "'.$_POST['gmd'].'", "'.$_POST['current_edition'].'", "'.$_POST['shelf_location'].'", "'.$_POST['rem_of_edit'].'", "'.$_POST['inventory_category'].'", "'.$_POST['pagination'].'", "'.$_POST['illustration'].'", "'.$_POST['dimension'].'", "'.$_POST['accomp_material'].'", "'.$quantity.'", "'.$_POST['publisher_name'].'", "'.$_POST['place'].'", "'.$_POST['salesman_name'].'", "'.$_POST['pub_year'].'", "'.$_POST['country'].'", "'.$_SESSION['username'].'","'.date('Y-m-d H:m:s').'")';
					echo $sql2;
					mysqli_query($db, $sql2);
					$i++;
					$accession_no++;
					*/
				}
				if(mysqli_errno($db)){
					echo "Insertion failed".mysqli_errno($db).mysqli_error($db);
				}
				else{
					echo'<h4 style="color:green;">Book Saved</h4>';
				}
			}
		}
	}	
		
	if(isset($_GET['del'])){
		$sql = 'delete from lib_add_new_book where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from lib_add_new_book where sno = '.$_GET['edit'];
	$qry = mysqli_query($db, $sql);
	$res = mysqli_fetch_assoc($qry);
}
?>
<style>
	h4{
		margin:5px;
		color:red;
		text-decoration:underline;
	}
</style>
<style>
.frmSearch {
    background-color: #c6f7d0;
    margin: 2px 0px;
    border-radius: 4px;
}

#roll-list {
    float: left;
    list-style: none;
    margin-top: -3px;
    padding: 0;
    width: 190px;
    position: absolute;
	z-index: 10;
}

#roll-list li {
    padding: 10px;
    background: #f0f0f0;
    border-bottom: #bbb9b9 1px solid;
}

#roll-list li:hover {
    background: #ece3d2;
    cursor: pointer;
}

#search-box1 {
    padding: 10px;
    border: #a8d4b1 1px solid;
    border-radius: 4px;
}

</style>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="user_form" name="user_form">
					<h2><img style="width:40px;" src="images/add.png" />Add New <span class="orange">Book</span></h2>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr>
							<th colspan="6"><h4>Book Location</h4><th>
						</tr>
						<tr>
							<th width="15%">Library Name</th>
							<th width="18%">
								<select class="form-control" name="library_location" id="library_location" class="form-control"  onchange="updateCombinedValue()">
									<option value="">----Select----</option>
									<?php 
										$sql  = 'select * from lib_add_library';
										$lib_list = mysqli_query($db, $sql);
										if($lib_list){
											while($list = mysqli_fetch_assoc($lib_list)){
												echo '<option value="'.$list['library_name'].'">'.$list['library_name'].'</option>';

											}
										}
									?>
										
									
								</select>
							</th>
							<th width="15%">Faculty\Building Name</th>
							<th width="18%">
								<select class="form-control" name="building_name" id="building_name" class="form-control"  onchange="book_shelf_location()">
									<option value="">----Select----</option>
										<?php 
											$sql  = 'select * from lib_add_building';
											$lib_list = mysqli_query($db, $sql);
											if($lib_list){
												while($list = mysqli_fetch_assoc($lib_list)){
													echo '<option  value = "'.$list['building_name'].'">'.$list['building_name'].'</option>';
												}
											}
										?>
								</select>
							</th>
							<th width="15%">Almirah Name</th>
							<th width="18%">
								<select class="form-control" name="almirah_name" id="almirah_name" class="form-control"  onchange="book_shelf_location()">
									<option value="">----Select----</option>
										<?php 
											$sql  = 'select * from lib_master_almirah';
											$lib_list = mysqli_query($db, $sql);
											if($lib_list){
												while($list = mysqli_fetch_assoc($lib_list)){
													echo '<option  value = "'.$list['almirah_name'].'">'.$list['almirah_name'].'</option>';
												}
											}
										?>					
								</select>
							</th>
						</tr>
						<tr>
							<th width="15%">Tray Name</th>
							<th width="18%">
								<select class="form-control" name="tray_name" id="tray_name" class="form-control"  onchange="book_shelf_location()">
									<option value="">----Select----</option>
										<?php 
											$sql  = 'select * from lib_master_tray';
											$lib_list = mysqli_query($db, $sql);
											if($lib_list){
												while($list = mysqli_fetch_assoc($lib_list)){
													echo '<option  value = "'.$list['tray_name'].'">'.$list['tray_name'].'</option>';
												}
											}
										?>
								</select>
							</th>
							<th width="15%">Book Category</th>
							<th width="18%"><select class="form-control" name="book_category" id="book_category" class="form-control">
									<option value="">----Select----</option>
									<option value="SOW">SOW</option>
									<option value="DOT">DOT</option>
									<option value="RDS">RDS</option>
									<option value="BBO">BBO</option>
									<option value="LWT">Weed-Out</option>
									<option value="REM">REM</option>
								</select>
							</th>
							<th width="15%">Accession No.</th>
							<th width="18%"><input type="number" name="accession_no" id="accession_no" value="<?php echo isset($_GET['edit'])? $res['accession_no']: '' ?>" class="form-control" ></th>
						</tr>
						<tr>
							<th colspan="6"><h4>Book Information</h4><th>
						</tr>
						<tr>
							<th width="15%">Types of study material</th>
							<th width="18%">
								<select class="form-control" name="book_writer" id="book_writer" onchange="toggleAddDetails()">
									<option value="">----Select----</option>
									<option value="books" <?php if(isset($_GET['id']) && isset($res['book_writer'])){if($res['book_writer']=="books"){ echo 'selected ';}}?>>Books</option>
									<option value="general" <?php if(isset($_GET['id']) && isset($res['book_writer'])){if($res['book_writer']=="general"){ echo 'selected ';}}?>>General</option>
									<option value="thesis" <?php if(isset($_GET['id']) && isset($res['book_writer'])){if($res['book_writer']=="thesis"){ echo 'selected ';}}?>>Thesis</option>
									<option value="report" <?php if(isset($_GET['id']) && isset($res['book_writer'])){if($res['book_writer']=="report"){ echo 'selected ';}}?>>Report</option>
									<option value="magazine" <?php if(isset($_GET['id']) && isset($res['book_writer'])){if($res['book_writer']=="magazine"){ echo 'selected ';}}?>>Magazine</option>
								</select>
							</th>
							
							<th>Subject</th>
							<td>
							   <div class="frmSearch">
									<input type="text" class="form-control" name="subject" id="subject" placeholder="" value="<?php echo isset($_GET['edit'])? $res['subject']: '' ?>" />
									<div id="a_suggesstion-box"></div>
									<script>
									function select_subject(val) {
										console.log(val);
										$("#subject").val(val);
										$("#a_suggesstion-box").hide();
										let subject = $("#subject").val();
										accession_details(subject);
									}


									// accession no book name
									function accession_details(val){
										console.log(val);
										$.ajax({
											url: 'autocomplete_for_ddc.php', // PHP script to handle the AJAX request
											type: 'POST', // or 'POST' depending on your setup
											data: { subject: val }, // Send the selected roll number as a parameter
											success: function(response) {
												let return_data = JSON.parse(response);
												// Handle the response data and update the UI as needed
												// You can update the details in the third column of the table here
												$('#ddc_code').val(return_data[0]);
												$('#book_no').val(return_data[1]);
												$('#mfn').val(return_data[2]);
											}
										});
									}
									</script>
								</div>
							</td>
						
							<th>DDC Code</th>
							<td>
								<input type="text" class="form-control" id="ddc_code" name="ddc_code"  value="<?php echo isset($_GET['edit'])? $res['ddc_code']: '' ?>" >
							</td>
							
							
						</tr>
						<tr>
							<th>Book No</th>
							<td>
								<input type="text" class="form-control" id="book_no" name="book_no"  value="<?php echo isset($_GET['edit'])? $res['book_no']: '' ?>" >
							</td>
							
							<th>MFN</th>
							<td>
								<input type="text" class="form-control" id="mfn" name="mfn"  value="<?php echo isset($_GET['edit'])? $res['mfn']: '' ?>" >
							</td>
							<td>
								<a href="https://classify.oclc.org/classify2/" target="_blank">Search DDC Code ...</a>
							</td>
							
						</tr>
						<tr >
							<th>Entry Language</th>
							<th width="18%"><input type="text" name="entry_language" id="entry_language" value="<?php echo isset($_GET['edit'])? $res['entry_language']: '' ?>" class="form-control" ></th>
							
							<!--<th>Subject</th>
							<th width="18%"><input type="text" name="subject" id="subject" value="<?php //echo isset($_GET['edit'])? $res['subject']: '' ?>" class="form-control" ></th> -->
							<th>Serial No.</th>
							<th width="18%"><input type="text" name="serial_no" id="serial_no" value="<?php echo isset($_GET['edit'])? $res['serial_no']: '' ?>" class="form-control" ></th>
		
							<th id="Author_Name">Author Name</th>
							<th id="Editor" style="display: none;">Editor Name</th>
							<th id="c_thesis" style="display: none;">Research Scholar</th>
							<th id="d_report" style="display: none;">Presenter</th>
							<th id="e_magazine" style="display: none;">Publisher</th>
							<th width="18%"><input type="text" name="author_name" id="author_name" value="" class="form-control"></th>









			<tr>
							<th>Publication Year</th>							
							<th width="18%"><input type="text" name="publication_year" id="publication_year" value="<?php echo isset($_GET['edit'])? $res['publication_year']: '' ?>" class="form-control" ></th>						
							<th>Edition</th>
							<th width="18%"><input type="text" name="edition" id="edition" value="<?php echo isset($_GET['edit'])? $res['edition']: '' ?>" class="form-control" ></th>
							<th>Accession No.-901</th>
							<th width="18%"><input type="text" name="accession_no901" id="accession_no901" value="<?php echo isset($_GET['edit'])? $res['accession_no901']: '' ?>" class="form-control" ></th>
						</tr>
						<tr>
							<th>ISBN Number </th>
							<th><input type="text" name="isbn_no" id="isbn_no" value="<?php echo isset($_GET['edit'])? $res['isbn_no']: '' ?>" class="form-control" ></th>						
							<th>Unit Cost</th>
							<th><input type="text" name="unit_cost" id="unit_cost" value="<?php echo isset($_GET['edit'])? $res['unit_cost']: '' ?>" class="form-control" ></th>
							<th>Currency</th>
							<th><input type="text" name="currency" id="currency" value="<?php echo isset($_GET['edit'])? $res['currency']: '' ?>" class="form-control" ></th>
						</tr>
						<tr>
							<th>Fund Type</th>
							<th><input type="text" name="fund_type" id="fund_type" value="<?php echo isset($_GET['edit'])? $res['fund_type']: '' ?>" class="form-control" ></th>
							<th>Source /Vendor Name </th>
							<th><input type="text" name="source" id="source" value="<?php echo isset($_GET['edit'])? $res['source']: '' ?>" class="form-control" ></th>	
							<!--<th>Vendor Name</th>
							<th><input type="text" name="vendor" id="vendor" value="<?php echo isset($_GET['edit'])? $res['vendor']: '' ?>" class="form-control" ></th>-->
							<th>Year of Subscribtion</th>
							<th><input type="text" name="publication_category" id="publication_category" value="<?php echo isset($_GET['edit'])? $res['publication_category']: '' ?>" class="form-control" ></th>
						</tr>
						<tr>
							<th>Invoice No</th>
							<th><input type="text" name="invoice_no" id="invoice_no" value="<?php echo isset($_GET['edit'])? $res['invoice_no']: '' ?>" class="form-control" ></th>
							<th>Invoice Date</th>
							<th><!--<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('invoice_date', 'invoice_date', true, 'YYYY-MM-DD', '<?php //if(isset($_POST['invoice_date'])){echo $_POST['invoice_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>--->
								<input type="date" class="form-control" name="invoice_date" id="invoice_date" value="">
								</th>
							<th>P.O./ Order  No.</th>
							<th><input type="text" name="po_no" id="po_no" value="<?php echo isset($_GET['edit'])? $res['po_no']: '' ?>" class="form-control" ></th>
						</tr>
						<tr>
							<th>Subscribtion Rate</th>
							<th><input type="text" name="publication_category" id="publication_category" value="<?php echo isset($_GET['edit'])? $res['publication_category']: '' ?>" class="form-control" ></th>
							<th>Publication Category</th>
							<th><input type="text" name="publication_category" id="publication_category" value="<?php echo isset($_GET['edit'])? $res['publication_category']: '' ?>" class="form-control" ></th>
							<th>Date of Purchase*</th>
							<th><!--<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('date_of_purchase', 'date_of_purchase', true, 'YYYY-MM-DD', '<?php //if(isset($_POST['date_of_purchase'])){echo $_POST['date_of_purchase'];}else{echo date("Y-m-d"); } ?>', 2));
								</script> -->
								<input type="date" class="form-control" name="date_of_purchase" id="date_of_purchase" value="">
							</th>
							<th></th>
							<th></th>
						</tr>
						<tr>
							<th colspan="6"><h4>Title Section</h4><th>
						</tr>
						<tr >
							<th>Title</th>
							<th><input type="text" name="title" id="title" value="<?php echo isset($_GET['edit'])? $res['title']: '' ?>" class="form-control" ></th>
							<th>Multiscript Title</th>
							<th><input type="text" name="multiscript_title" id="multiscript_title" value="<?php echo isset($_GET['edit'])? $res['multiscript_title']: '' ?>" class="form-control" ></th>
							<th>Sub Title</th>
							<th><input type="text" name="sub_title" id="sub_title" value="<?php echo isset($_GET['edit'])? $res['sub_title']: '' ?>" class="form-control" ></th>
						</tr>
						<tr >
							<th>Language</th>
							<th><select class="form-control" name="language" id="language" class="form-control">
									<option value="">----Select----</option>
									<option value="1" <?php if(isset($_GET['edit']) && $res['language']=="English"){ echo 'selected ';}?>>English</option>
									<option value="2" <?php if(isset($_GET['edit']) && $res['language']=="Hindi"){ echo 'selected ';}?>>Hindi</option>
								</select>
							</th>
							<th> Uniform Title</th>
							<th><input type="text" name="uniform_title" id="uniform_title" value="<?php echo isset($_GET['edit'])? $res['uniform_title']: '' ?>" class="form-control" ></th>
							<th>Trans. Title</th>
							<th><input type="text" name="trans_title" id="trans_title" value="<?php echo isset($_GET['edit'])? $res['trans_title']: '' ?>" class="form-control" ></th>
						</tr>
						<tr >
							<th>Var. Title</th>
							<th><input type="text" name="var_title" id="var_title" value="<?php echo isset($_GET['edit'])? $res['var_title']: '' ?>" class="form-control" ></th>
							<th>G.M.D.</th>
							<th><select class="form-control" name="gmd" id="gmd" class="form-control">
									<option value="">----Select----</option>
								</select></th>
							<th></th>
							<th></th>
						</tr>
						<tr>
							<th colspan="6"><h4>Edition</h4><th>
						</tr>
						<tr >
							<th>Current Edition</th>
							<th><input type="text" name="current_edition" id="current_edition" value="<?php echo isset($_GET['edit'])? $res['current_edition']: '' ?>" class="form-control" ></th>
							<th>Shelf Location</th>
							<th><input type="text" name="shelf_location" id="shelf_location" value="<?php echo isset($_GET['edit'])? $res['shelf_location']: '' ?>" class="form-control" ></th>
							<th>Reminder Of Edit</th>
							<th><input type="text" name="rem_of_edit" id="rem_of_edit" value="<?php echo isset($_GET['edit'])? $res['rem_of_edit']: '' ?>" class="form-control" ></th>
						</tr>
						<tr >
							
							<th>Inventory Category</th>
							<th><input type="text" name="inventory_category" id="inventory_category" value="<?php echo isset($_GET['edit'])? $res['inventory_category']: '' ?>" class="form-control" ></th>
						</tr><tr></tr>
						<tr>
							<th colspan="6"><h4>Pagination & Physical Description</h4><th>
						</tr>
						<tr >
							<th>Pagination</th>
							<th><input type="text" name="pagination" id="pagination" value="<?php echo isset($_GET['edit'])? $res['pagination']: '' ?>" class="form-control" ></th>
							<th>Illustration</th>
							<th><input type="text" name="illustration" id="illustration" value="<?php echo isset($_GET['edit'])? $res['illustration']: '' ?>" class="form-control" ></th>
							<th>Dimension</th>
							<th><input type="text" name="dimension" id="dimension" value="<?php echo isset($_GET['edit'])? $res['dimension']: '' ?>" class="form-control" ></th>
						</tr>
						<tr >
							<th>Accomp. Material</th>
							<th><input type="text" name="accomp_material" id="accomp_material" value="<?php echo isset($_GET['edit'])? $res['accomp_material']: '' ?>" class="form-control" ></th>
							<th >Quantity</th>
							<th><input type="number" name="quantity" id="quantity" value="<?php echo isset($_GET['edit'])? $res['quantity']: '' ?>" class="form-control" readonly></th>
							
						</tr><tr></tr>
						<tr>
							<th colspan="6"><h4>Publisher Details</h4><th>
						</tr>
						<tr >
							<th>Publisher Name</th>
							<th><input type="text" name="publisher_name" id="publisher_name" value="<?php echo isset($_GET['edit'])? $res['publisher_name']: '' ?>" class="form-control" ></th>
							<th>Place</th>
							<th><input type="text" name="place" id="place" value="<?php echo isset($_GET['edit'])? $res['place']: '' ?>" class="form-control" ></th>
							<th>Salesman Name</th>
							<th><input type="text" name="salesman_name" id="salesman_name" value="<?php echo isset($_GET['edit'])? $res['salesman_name']: '' ?>" class="form-control" ></th>
						</tr>
						<tr>
							<th>Year Of Publication</th>
							<th><input type="text" name="pub_year" id="pub_year" value="<?php echo isset($_GET['edit'])? $res['pub_year']: '' ?>" class="form-control" ></th>
							<th>Country Name</th>
							<th><input type="text" name="country" id="country" value="<?php echo isset($_GET['edit'])? $res['country']: '' ?>" class="form-control" ></th>
						</tr>
						
					</table>
					<input type="submit" class="btn btn-primary submit" name="submit" value="Submit" onClick="return confirmSubmit()"/>
					<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
				</form>
			</div>
		</div>
	</div>
	
<!-- Add your existing HTML and PHP code for the select dropdown and submit button here -->
<!-- Make sure you include the necessary JavaScript libraries like jQuery for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
<script src='https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/js/jquery.circliful.min.js'></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script>
    $(document).ready(function() {
		//-----------------------------------------
		$("#subject").keyup(function() {
			$.ajax({
				type: "POST",
				url: "autocomplete_for_ddc.php",
				data: 'accession_keyword=' + $(this).val(),
				beforeSend: function() {
					$("#subject").css("background", "#FFF url(path/to/LoaderIcon.gif) no-repeat 165px");
				},
				success: function(data) {
					$("#a_suggesstion-box").show();
					$("#a_suggesstion-box").html(data);
					$("#subject").css("background", "#FFF");
				}
			});
		});
    });

        function book_shelf_location() {
            // Get the selected values from the select boxes
            var select1Value = document.getElementById('library_location').value;
            var select2Value = document.getElementById('building_name').value;
            var select3Value = document.getElementById('almirah_name').value;
            var select4Value = document.getElementById('tray_name').value;

            // Combine the values
            var combinedValue = select1Value + ' / ' + select2Value + ' / ' + select3Value + ' / ' + select4Value;

            // Update the third input box
            document.getElementById('shelf_location').value = combinedValue;
        }

	function toggleAddDetails() {
		var selectBox = document.getElementById("book_writer");
		var authorTh = document.getElementById("Author_Name");
		var editorTh = document.getElementById("Editor");
		var thesisTh = document.getElementById("c_thesis");
		var reportTh = document.getElementById("d_report");
		var magazineTh = document.getElementById("e_magazine");

		// Hide all elements first
		authorTh.style.display = "none";
		editorTh.style.display = "none";
		thesisTh.style.display = "none";
		reportTh.style.display = "none";
		magazineTh.style.display = "none";

		// Show the specific element based on the selection
		if (selectBox.value === "books" || selectBox.value === "") {
			authorTh.style.display = "table-cell";
		} else if (selectBox.value === "general") {
			editorTh.style.display = "table-cell";
		} else if (selectBox.value === "thesis") {
			thesisTh.style.display = "table-cell";
		} else if (selectBox.value === "report") {
			reportTh.style.display = "table-cell";
		} else if (selectBox.value === "magazine") {
			magazineTh.style.display = "table-cell";
		}
	}

	// Call the function on page load to set the initial state
	window.onload = function() {
		toggleAddDetails();
	};
</script>
<?php
// page_footer_start();
// page_footer_end();
footer_lib();
?>
</body>