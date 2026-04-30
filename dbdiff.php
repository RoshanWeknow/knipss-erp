<?php
error_reporting(E_ALL);
//error_reporting(0);
$db_updated_name = 'cloudice_knipss_2021';
$db_to_update_name = 'cloudice_knipss_2016';

$db_updated = mysqli_connect("localhost", "cloudice", "clou@123", $db_updated_name);
if(!$db_updated){
	die("Error 1 : Contact Administrator.");
}

$db_to_update = mysqli_connect("localhost", "cloudice", "clou@123", $db_to_update_name);
if(!$db_to_update){
	die("Error 1 : Contact Administrator.");
}

$i=1;
$sql_final = '';
echo '<table width="100%" border="1">
<tr>
	<th>S.No.</th>
	<th>Updated Database ('.$db_updated_name.')</th>
	<th>Database To Be Update ('.$db_to_update_name.')</th>
	<th></th>
</tr>';
$sql = 'show tables';
$result = mysqli_query($db_updated, $sql);
while($row = mysqli_fetch_array($result)){
	$table_to_be_update_array = array();
	$table_updated_array = array();
	$cols_missing_array = array();
	$msg = '<ul>';
	$a=1;
	echo '<tr><th>'.$i++.'</th><th>'.$row[0].'
		<table width="100%" border="1">
			<tr>
				<th>S.No.</th>
				<th>Field</th>
				<th>Type</th>
				<th>Null</th>
				<th>Key</th>
				<th>Default</th>
				<th>Extra</th>
			</tr>';
	
	$table_exists=1;
	$count_mismatch=0;
	
	$sql = 'describe '.$row[0];
	$res_desc = mysqli_query($db_updated, $sql);
	$count = mysqli_num_rows($res_desc);
	
	$sql_create = 'create table `'.$row[0].'` (';
	$sql = 'show tables like "'.$row[0].'"';
	$res_chk = mysqli_query($db_to_update, $sql);
	if(mysqli_num_rows($res_chk)!=1){
		$msg .= '<li style="color:#F00">Does Not Exists.</li>';
		
		$table_exists=0;
	}
	else{
		$sql = 'describe '.$row[0];
		$res_desc1 = mysqli_query($db_to_update, $sql);
		$chk_count = mysqli_num_rows($res_desc1);
		$msg .= '<li>Table Exists</li>';
		if($chk_count!=$count){
			$msg .= '<li style="color:#F00">Column count does not match.</li>';
			if($sql_final==''){
				$sql_final = ' ';
			}
			$count_mismatch=1;
			while($test_row = mysqli_fetch_assoc($res_desc1)){
				$table_to_be_update_array[] = $test_row;	
			}
			while($test_row = mysqli_fetch_assoc($res_desc)){
				$table_updated_array[] = $test_row;	
			}
			foreach($table_updated_array as $k=>$v){
				//print_r($v);
				//echo $v['Field'].'<br><br>';
				$id = searchForId($v['Field'], $table_to_be_update_array);
				if(!$id){
					$cols_missing_array[] = $v['Field'];
				}
			}
			if(sizeof($cols_missing_array)>0){
				$alter_query = "alter table `$row[0]` add `";
				$cols_missing_array = implode("` varchar(100) null, add `", $cols_missing_array);
				$alter_query .= $cols_missing_array."` varchar(100) null";
				$msg .= '<li style="color:#F00">'.$alter_query.'</li>';
				$sql_final .= '<li>'.$alter_query.';</li><br>';
			}
			mysqli_data_seek($res_desc, 0);
			mysqli_data_seek($res_desc1, 0);
		}
		else{
			$cols_mismatch_updated = array();
			$cols_mismatch_to_be_updated = array();
			$sql = 'describe '.$row[0];
			$res_desc1 = mysqli_query($db_to_update, $sql);
			while($test_row = mysqli_fetch_assoc($res_desc1)){
				$table_to_be_update_array[] = $test_row;	
			}
			while($test_row = mysqli_fetch_assoc($res_desc)){
				$table_updated_array[] = $test_row;	
			}
			foreach($table_updated_array as $k=>$v){
				$id = searchForId($v['Field'], $table_to_be_update_array);
				if(!$id){
					$cols_mismatch_updated[] = $v['Field'];
				}
				foreach($table_to_be_update_array as $key_chk => $val_chk){
					if($v['Field']==$val_chk['Field']){
						if($v['Type']!=$val_chk['Type']){
							$msg .= '<li style="color:#F00">Data Type Mismatch. >> '.$v['Field'].' >> '.$v['Type'].'</li>';
							
							$alter_data_type_query = "alter table `$row[0]` MODIFY `".$v['Field']."` ".$v['Type'];
							$msg .= '<li style="color:#F00">'.$alter_data_type_query.'</li>';
							$sql_final .= '<li>'.$alter_data_type_query.';</li><br>';

						}

					}
				}
			}
			foreach($table_to_be_update_array as $k=>$v){
				//print_r($v);
				//echo $v['Field'].'<br><br>';
				$id = searchForId($v['Field'], $table_updated_array);
				if(!$id){
					$cols_mismatch_to_be_updated[] = $v['Field'];
				}
			}
			if(sizeof($cols_mismatch_updated)>0){
				$msg .= '<li style="color:#F00">In updated : Column names does not match.<ul>';
				foreach($cols_mismatch_updated as $mk=>$mv){
					echo '<li>'.$mk.'>>'.$mv.'</li>';
				}
				echo '</ul></li>';
				if($sql_final==''){
					$sql_final = ' ';
				}
			}
			if(sizeof($cols_mismatch_to_be_updated)>0){
				$msg .= '<li style="color:#F00">In To Be Updated : Column names does not match.<ul>';
				foreach($cols_mismatch_to_be_updated as $mk=>$mv){
					echo '<li>'.$mk.'>>'.$mv.'</li>';
				}
				echo '</ul></li>';
				if($sql_final==''){
					$sql_final = ' ';
				}
			}
			mysqli_data_seek($res_desc, 0);
			mysqli_data_seek($res_desc1, 0);
		}
	}
	
	while($row_desc = mysqli_fetch_array($res_desc)){
		echo '
		<tr>
			<th>'.$a++.'</th>
			<td>'.$row_desc['Field'].'</td>
			<th>'.$row_desc['Type'].'</th>
			<th>'.$row_desc['Null'].'</th>
			<th>'.$row_desc['Key'].'</th>
			<th>'.$row_desc['Default'].'</th>
			<th>'.$row_desc['Extra'].'</th>
		</tr>';
		if($table_exists==0){
			if($row_desc['Null']=="YES"){
				$row_desc['Null'] = "NULL";
			}
			else{
				$row_desc['Null']='';
			}
			if($row_desc['Key']=="PRI"){
				$row_desc['Key'] = "PRIMARY KEY";
			}
			else{
				$row_desc['Key']='';
			}
			if($row_desc['Extra']=="auto_increment"){
				$row_desc['Extra'] = "AUTO_INCREMENT";
			}
			else{
				$row_desc['Extra'] = '';
			}
			$sql_create .= ' `'.$row_desc['Field'].'` '.$row_desc['Type'].' '.$row_desc['Null'].' '.$row_desc['Extra'].' '.$row_desc['Key'];
			if($a>$count){
				$sql_create .= ')';
			}
			else{
				$sql_create .= ', ';
			}
		}
		elseif($count_mismatch==1){
			$table_to_be_update_array=0;
		}
		
	}
	if($sql_create!='create table `'.$row[0].'` ('){
		$msg .= '<li>'.$sql_create.'</li>';
		$sql_final .= '<li>'.$sql_create.';</li><br>';
	}	
			
	echo '
		</table>
	</th>';

	if($table_exists==1){
		$b=1;
		echo '<th>'.$row[0].'
		<table width="100%" border="1">
			<tr>
				<th>S.No.</th>
				<th>Field</th>
				<th>Type</th>
				<th>Null</th>
				<th>Key</th>
				<th>Default</th>
				<th>Extra</th>
			</tr>';
		while($row_desc1 = mysqli_fetch_array($res_desc1)){
				echo '
				<tr>
					<th>'.$b++.'</th>
					<td>'.$row_desc1['Field'].'</td>
					<th>'.$row_desc1['Type'].'</th>
					<th>'.$row_desc1['Null'].'</th>
					<th>'.$row_desc1['Key'].'</th>
					<th>'.$row_desc1['Default'].'</th>
					<th>'.$row_desc1['Extra'].'</th>
				</tr>';
			
		}
				
			
	echo '
		</table>
	</th>';
	}
	else{
		$msg .= '<td><li style="color:#F00">Does Not Exists.</li>&nbsp;</td>';
	}
	$msg .= '</ul>';
	echo '<td>'.$msg;
	
	echo '</td></tr>';
}
if($sql_final==''){
	echo '<h3 style="color:#0F0;">Congrats no error found</h3>';
}
else{
	echo '<h3 style="color:#F00;">Error found</h3>';
}
echo '<tr><td colspan="4">'.$sql_final.'</td></tr>';

echo '</table>';
	
function searchForId($id, $array) {
   foreach ($array as $key => $val) {
	   //print_r($val);
	   if ($val['Field'] == $id) {
       		//print_r($val);
           return $val['Field'];
       }
   }
   return null;
}

?>