<?php 
include("scripts/settings.php");

$msg='';

page_header_start();
page_header_end();
page_sidebar();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">



</head>
	<div class="col-md-12">
			
			<div class="content">
				<div class="row">
					<?php
					if($_SESSION['username']=='sadmin'){
						//echo 'hello';
						$sql = 'select * from navigation where parent ="209"';
						$result_dash_icons = execute_query($db, $sql);
						echo mysqli_error($db);
						while($row_dash_icons = mysqli_fetch_assoc($result_dash_icons)){
							echo '<div class="col-md-2 text-center" style="display: flex; justify-content: center; align-items: center;">
													<div style="display: inline-flex; align-items: center; justify-content: center; border: 3px solid orange; border-radius: 30px; background-color: gray; padding: 10px 20px; margin: 10px; color: white; font-family: Arial, sans-serif; font-size: 1em; width: 200px; height: 100px;">
														<a href="' . $row_dash_icons['hyper_link'] . '" style="color: white; text-decoration: none;">
															 ' . $row_dash_icons['link_description'] . '
														</a>
													</div>
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
						$file_sql1 = 'SELECT DISTINCT(parent) from navigation where sno in ('.substr($file_sql, 0, strlen($file_sql)-1).')';
						$sql = execute_query($db,$file_sql1);
						if($sql){
							while($file_name = mysqli_fetch_assoc($sql)){
								//print_r($file_name);
								if($file_name['parent']!=''){
									$sql1 = execute_query($db,'select * from navigation where sno = '.$file_name['parent']. ' and parent="163"');	
									if($sql1 && mysqli_num_rows($sql1)>0){
										$row_dash_icons = mysqli_fetch_assoc($sql1);
										echo '<div class="col-md-2 text-center" style="display: flex; justify-content: center; align-items: center;">
													<div style="display: inline-flex; align-items: center; justify-content: center; border: 3px solid orange; border-radius: 30px; background-color: gray; padding: 10px 20px; margin: 10px; color: white; font-family: Arial, sans-serif; font-size: 1em; width: 200px; height: 80px;">
														<a href="' . $row_dash_icons['hyper_link'] . '" style="color: white; text-decoration: none;">
															<i class="' . $row_dash_icons['icon_image'] . '" aria-hidden="true"></i> ' . $row_dash_icons['link_description'] . '
														</a>
													</div>
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
		
<?php
page_footer_start();
page_footer_end();
?>