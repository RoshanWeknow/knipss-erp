<?php
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$msg='';
if(isset($_POST['submit'])){
	$sql = 'insert into class_detail(class_description,year,total_seat,category,type) values("'.$_POST['class_desc'].'","'.$_POST['year'].'","'.$_POST['tot_seat'].'","'.$_POST['category'].'","'.$_POST['type'].'")';
	execute_query(connect(), $sql);
	$sql_class="select * from class_detail order by sno desc limit 1";
	$class_id=mysqli_fetch_array(execute_query(connect(), $sql_class));
	$comma =0;
	if($_POST['type']!='SELF'){
		$sql = "select * from head_type";
	}
	else{
		$sql = "select * from head_type_self";
	}
	$result_head = execute_query(connect(), $sql);
	$sql='insert into fees_detail(class_id,head_id,fee_amount) values';
	while($row_head = mysqli_fetch_array($result_head)){
		$head = 'head'.$row_head['sno'];
		if($comma==0){			
			$sql .= '("'.$class_id['sno'].'","'.$row_head['sno'].'","'.$_POST[$head].'")';
			$comma=1;
		}
		else {
			$sql .= ',("'.$class_id['sno'].'","'.$row_head['sno'].'","'.$_POST[$head].'")';
		}
	}
	//echo $sql;
	execute_query(connect(), $sql);
	if($msg==''){
		$sql='insert into fees_detail(class_id, head_id,fee_amount) value ("'.$class_id['sno'].'", "computer", "'.$_POST['computer'].'"), ("'.$class_id['sno'].'","self", "'.$_POST['self'].'"), ("'.$class_id['sno'].'","vocational", "'.$_POST['vocational'].'")';
		execute_query(connect(), $sql);
		$comma =0;
		$sql = "select * from add_subject";
		$result_subject = execute_query(connect(), $sql);
		$sql='insert into subject_fees(class_id,subject_id,fees,type,code) values';
		while($row_subject = mysqli_fetch_array($result_subject)){
			$practfees = 'pract_'.$row_subject['sno'];
			$gen = 'type_'.$row_subject['sno'];
			$code = 'code_'.$row_subject['sno'];
			$check = 'check_'.$row_subject['sno'];
			if(isset($_POST[$check])){
				if($comma==0){
					$sql .= '("'.$class_id['sno'].'","'.$row_subject['sno'].'","'.$_POST[$practfees].'","'.$_POST[$gen].'","'.$_POST[$code].'")';
					$comma=1;
				}
				else {
					$sql .= ',("'.$class_id['sno'].'","'.$row_subject['sno'].'","'.$_POST[$practfees].'","'.$_POST[$gen].'","'.$_POST[$code].'")';
				}
			}
		}
		execute_query(connect(), $sql);
		$msg .= '<li>New class Added</li>';
	}
	else {
		 $msg .= '<li>Please enter full information</li>';
	}
}
?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<script type="text/javascript" language="javascript">
function changeid(id){
	var elem='';
	elem = 'show_'+id;
	check = 'check_'+id;
	if(document.getElementById(check).checked== true){			
		document.getElementById(elem).style.display = 'block';
	}
	else {
		document.getElementById(elem).style.display = 'none';
	}
}
	
function change_head(val){
	if(val=='SELF'){
		document.getElementById("heads_self").style.display = 'block';
		document.getElementById("heads").style.display = 'none';
	}
	else{
		document.getElementById("heads_self").style.display = 'none';
		document.getElementById("heads").style.display = 'block';		
	}
}
	
</script>
<?php

page_sidebar();

?>
<body id="public">
	<div id="wrapper">	
		<div id="content" class="card card-body ">    
        	<div id="container" class="row d-flex my-auto">    	
				<form action="addnewclass.php" class="wufoo leftLabel page1" name="addnewclass" enctype="multipart/form-data" method="post" onSubmit="" >
					<h2><img style="width:40px;" src="images/add.png" />Add New <span class="orange">Class</span></h2>
					<?php echo $msg;?>
					<div class="row">
						<div class="col-md-3">
							<label  class="desc" for="c_name">Class Description <span class="orange">*</span></label>
							<input type="text" name="class_desc" id="class_desc"class="form-control" value=""  onkeyup="formvalidation(this.value,'varchar',45,'class_desc')"/>
						</div>
						<div class="col-md-3">
							<label  class="desc" for="c_name">Year <span class="orange">*</span></label>
							<input type="text" name="year" id="year"class="form-control" value=""  onkeyup="formvalidation(this.value,'varchar',45,'year')"/>
						</div>
						<div class="col-md-3">
							<label  class="desc" for="c_name">Total Seat <span class="orange">*</span></label>
							<input type="text" name="tot_seat" id="tot_seat"class="form-control" value=""  onkeyup="formvalidation(this.value,'varchar',45,'tot_seat')"/>
						</div>
						<div class="col-md-3">
							<label  class="desc" for="c_name">Category <span class="orange">*</span></label>
							<input type="text" name="category" id="category"class="form-control" value=""  onkeyup="formvalidation(this.value,'varchar',45,'category')"/>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label  class="desc" for="c_name">Type <span class="orange">*</span></label>
							 <select name="type" id="type" onChange="change_head(this.value);" class="form-control">
								<option value="UG">UG</option>
								<option value="PG">PG</option>
								<option value="SELF">SELF</option>
							 </select>
						</div>
						<div class="col-md-3">
							<label  class="desc" for="c_name">Computer<span class="orange">*</span></label>
							<input type="text" name="computer" id=" computer"class="form-control" value=""  onkeyup="formvalidation(this.value,'varchar',45,' computer')"/>
						</div>
						<div class="col-md-3">
							<label  class="desc" for="c_name">Self<span class="orange">*</span></label>
							<input type="text" name="self" id=" self"class="form-control" value=""  onkeyup="formvalidation(this.value,'varchar',45,' self')"/>
						</div>
						<div class="col-md-3">
							<label  class="desc" for="c_name">Vocational Fees<span class="orange">*</span></label>
							<input type="text" name="vocational" id=" self"class="form-control" value=""/>
						</div>
					</div>
					<div class="card card-body" class="desc notranslate" for="s_class" style="display: block;" id="heads">
						<h3 >Heads</h3>
						<table class="table table-striped">
							<?php
							$sql = 'select * from head_type';
							$res = execute_query(connect(), $sql);
							$i=1;
							while($row = mysqli_fetch_array($res)) {
								echo '<tr>
								<td class="inp1">'.$row['fee_type'].'</td>
								<td class="inp1"><div><input type="text" name="head'.$row['sno'].'" value=""/></td>
								</tr>';
							}
							?>
						</table>
					</div>
					<div class="notranslate desc" style="display: none;" id="heads_self"><label  for="s_class">
						<h3 >Heads</h3>
						<table class="table table-striped">
							<?php
							$sql = 'select * from head_type_self';
							$res = execute_query(connect(), $sql);
							$i=1;
							while($row = mysqli_fetch_array($res)) {
								echo '<tr>
								<td class="inp1">'.$row['fee_type'].'</td>
								<td class="inp1"><div><input type="text" name="head'.$row['sno'].'" value=""/></td>
								</tr>';
							}
							?>
						</table>
					</div>
					
					<h3>Subjects</h3>

						<?php	
							$sql1 = 'select * from add_subject';
							$res1 = execute_query(connect(), $sql1);
							$count = mysqli_num_rows($res1);
							$s=1;	
							while($row1 = mysqli_fetch_array($res1)) {
								echo '
								
									<div class="col-md-12  border rounded m-1 p-2">
										<div class="row">
											<div class="col-md-1">
												<input type="checkbox" name="check_'.$row1['sno'].'" id="check_'.$row1['sno'].'" onchange="changeid(this.value)"  value="'.$row1['sno'].'"/>
											</div>
											<div  class="col-md-3">
												<label  class="desc" for="ch_sub">'.$row1['subject'].'</label>
											</div>
											<div id="show_'.$row1['sno'].'" class="col-md-8" style="display:none">
												<table width="100%" class="table table-striped table-hover rounded">
													<tr >
														<td class="inp1">														
															<input type="text" class="form-control" name="code_'.$row1['sno'].'" value="Subject Code" onfocus="this.value=\'\'"/>
														</td>
														<td class="inp1">
															<input type="text" class="form-control" name="pract_'.$row1['sno'].'" value="Practical Fees" onfocus="this.value=\'\'"/>
														</td>
														<td class="inp1">
															<select name="type_'.$row1['sno'].'" id="type_'.$row1['sno'].'" class="inp1 form-control" >
																<option selected="selected" value="self">Self-Finance</option>
																<option value="aided">Aided</option> 
															</select>
														</td>
													</tr>	
												</table>
											</div>
										</div>
									</div>
								';
							}
							?>    	 

							<input type="submit" class="btn btn-primary submit" name="submit" value="Submit"/>
							<input type="hidden" name="subject_count" id="subject_count" value="<?php echo $count; ?>" />
							<input type="hidden" name="box_count1" value="<?php echo ($s-1); ?>" />
							<input type="hidden" name="box_count" value="<?php echo ($i-1); ?>" />

				</form>
			</div>
		</div>
	</div>

	<?php
	page_footer_start();
	page_footer_end();
	?>
</body>