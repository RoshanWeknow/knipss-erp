<?php 
//include("scripts/settings.php");
include("ag_lib_setting.php");
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
				
					$sql = 'SELECT * FROM lib_navigation WHERE parent IN ("56","57","65","66","71") ORDER BY ABS(sort_no)';
					$result_dash_icons = execute_query($db, $sql);
					echo mysqli_error($db);
					while($row_dash_icons = mysqli_fetch_assoc($result_dash_icons)){
						echo '<div class="zoom " "><a href="'.$row_dash_icons['hyper_link'].'"  target="_blank">
						<div class="zoom "><strong>'.$row_dash_icons['link_description'].'</strong></div></a>
						</div>';
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