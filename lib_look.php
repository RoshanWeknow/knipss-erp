<?php 
//include("scripts/settings.php");
include("lib_setting.php");
$msg='';
// page_header_start();
// page_header_end();
// page_sidebar();
header_lib();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/software_look.css">
</head>
<div class="row bg-light" style="--bs-gutter-x: -0.5rem !important;">
	<div class="col-md-12 bg-light">
		<div class="content bg-light " style="over-flow:hidden;">
			<div style="--bs-gutter-x: -73px !important;overflow-x:hidden !important;margin-start:30px;" class="row">
				<?php
				if($_SESSION['username']=='sadmin'){
					//$sql = 'select * from lib_navigation where parent="167" order by sort_no';
					$sql = 'SELECT * FROM lib_navigation WHERE parent="167" ORDER BY ABS(sort_no)';
					$result_dash_icons = execute_query($db, $sql);
					echo mysqli_error($db);
					while($row_dash_icons = mysqli_fetch_assoc($result_dash_icons)){
						echo '<div class="zoom " "><a href="'.$row_dash_icons['hyper_link'].'"  target="_blank">
						<div class="zoom "><strong>'.$row_dash_icons['link_description'].'</strong></div></a>
						</div>';
					}
				}
				else{
					$file_list = array();
					$sql = execute_query($db,'select file_name from user_access where user_id = '.$_SESSION['usersno']);
					$file_sql = '';
					foreach($sql as $key=> $val){
						$file_sql .= $val['file_name'].',';
					}
					$file_sql1 = 'SELECT DISTINCT(parent) from lib_navigation where sno in ('.substr($file_sql, 0, strlen($file_sql)-1).')';
					$sql = execute_query($db,$file_sql1);
					if($sql){
						while($file_name = mysqli_fetch_assoc($sql)){
							//print_r($file_name);
							if($file_name['parent']!=''){
								$sql1 = execute_query($db,'select * from lib_navigation where sno = '.$file_name['parent']. ' and parent="167"');	
								if($sql1 && mysqli_num_rows($sql1)>0){
									$row_dash_icons = mysqli_fetch_assoc($sql1);
									echo '<div class="col-md-2 text-center"><a href="'.$row_dash_icons['hyper_link'].'" target="_blank">
									<div class="zoom text_color" target="_blank">'.$row_dash_icons['link_description'].'</div></a>
									</div>';
								}
							}
						}
					}
						
				}
				?>
			</div>
		</div>
	</div>
</div>
<?php
// page_footer_start();
// page_footer_end();
footer_lib();
?>