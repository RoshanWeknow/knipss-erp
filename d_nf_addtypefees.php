<?php
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$msg='';
$tab=1;
if(isset($_POST['submit'])){
	$_POST['head_name'] = trim($_POST['head_name']);
	if($_POST['head_name']==''){
		$msg .='<li>Please Head Name</li>';
	}
	else{
		if($_POST['edit_id']!=''){
			$sql = 'update d_fees_head_master set 
			head_name = "'.$_POST['head_name'].'",
			sort_no = "'.$_POST['sort_no'].'",
			status = "'.$_POST['status'].'" 
			where sno='.$_POST['edit_id'];
		}
		else{			
			$sql = 'select * from d_fees_head_master where head_name="'.$_POST['head_name'].'"';
			$result = execute_query($db, $sql);
			if(mysqli_num_rows($result)!=0){
				$msg .= '<li>Duplicate.</li>';
			}
			$sql = 'insert into d_fees_head_master(head_name, sort_no, status) 
			value("'.$_POST['head_name'].'", "'.$_POST['sort_no'].'","'.$_POST['status'].'")';
		}
		if($msg==''){
			execute_query($db, $sql);
			if(mysqli_error($db)){
				$msg .= '<li>Error # 1 : '.mysqli_error($db).' >> '.$sql.' </li>';
			}
			else{
				$msg = '<li>Data Saved</li>'; 
				$_POST['status']=0;
				$_POST['head_name']='';
				$_POST['sort_no']='';
				$_POST['edit_id']='';

			}
		}
	}
}
elseif(isset($_GET['id'])){
	$sql = 'select * from d_fees_head_master where sno='.$_GET['id'];
	$details=mysqli_fetch_array(execute_query($db, $sql));
	$_POST['head_name'] = $details['head_name'];
	$_POST['sort_no'] = $details['sort_no'];
	$_POST['status'] = $details['status'];
	$_POST['edit_id'] = $details['sno'];
}
else{
	$_POST['status']=0;
	$_POST['head_name']='';
	$_POST['sort_no']='';
	$_POST['edit_id']='';
}
if(isset($_GET['del'])){
	$sql = 'delete from d_fees_head_master where sno='.$_GET['del'];
	$delete=execute_query($db, $sql);
	$msg = '<li>Fee Type Deleted.</li>';
	
}
page_header_end();
page_sidebar();
?>
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto"> 
			
<form action="<?php echo $_SERVER['PHP_SELF'];?>" name="data_form" enctype="multipart/form-data" method="post">
	<?php echo $msg; ?>
	<div class="bg-primary text-white p-2"><h3>Add Fee Type</h3></div>
	<table width="100%"  class="table table-striped table-hover rounded">
		<tr>
			<td>Fees Head Name</td>
			<td><input type="text" name="head_name" id="head_name" class="form-control" value="<?php echo $_POST['head_name'];?>" tabindex="<?php echo $tab++; ?>"/> </td>
			<td>Sorting No</td>
			<td><input type="text" name="sort_no" id="sort_no" class="form-control" value="<?php echo $_POST['sort_no'];?>" tabindex="<?php echo $tab++; ?>"/> </td>
			<td>Status</td>
			<td>
				<select name="status" id="status" class="form-control" tabindex="<?php echo $tab++; ?>"> 
					<option value="0" <?php if($_POST['status']==0){echo ' selected="selected" ';} ?> >Enabled</option>
					<option value="1" <?php if($_POST['status']==1){echo ' selected="selected" ';} ?> >Disabled</option>
				</select>		
			
		</tr>
	</table>
	<input type="submit" class="submit btn btn-primary" name="submit" value="Submit" onClick="return confirmSubmit()"/>
</div>
</div>
<div class="card card-body">    
        	<div class="row d-flex my-auto"> 
	<table width="100%" class="table table-responsive table-striped">
		<thead>
		<tr class="bg-primary text-white">
			<th>Sno</th>
			<th>Head Name</th>
			<th>Sorting No</th>
			<th>Status</th>
			<th colspan="2">Edit/Delete</th>
	   </tr>
		</thead>
	   <?php
		$sql = 'select * from d_fees_head_master order by sno';
		$res = execute_query($db, $sql);
		$i=1;
		if($res){
		while($fees=mysqli_fetch_array($res)){
			if($fees['status']==1){
				$col = '#F00';
			}
			else{
				$col = '';
			}
		echo '<tr style="background:'.$col.'">
		<td>'.$i++.'</td>
		<td>'.$fees['head_name'].'</td>
		<td>'.$fees['sort_no'].'</td>
		<td>'.($fees['status']==0?'Active':'Disabled').'</td>
		<td><a href="d_nf_addtypefees.php?id='.$fees['sno'].'">Edit</a></td>
		<td><a href="d_nf_addtypefees.php?del='.$fees['sno'].'" onclick="return confirm(\'Are you sure?\');">Delete</a></td>
		</tr>';
	}
		}
		?>
	</table>
    <input type="hidden" value="<?php echo $_POST['edit_id']; ?>" name="edit_id" ></div>
</form>
</div>
</div>
</div>
<?php

page_footer_start();
?>
