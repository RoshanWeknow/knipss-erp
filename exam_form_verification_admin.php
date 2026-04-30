<?php 
include("scripts/settings.php");
page_header_start();
$response=1;
$msg='';
page_header_end();
page_sidebar();


?>
	<div class="col-md-12 card">
		<h2 class="bg-secondary text-center text-white p-3">EXAM VERIFICATION </h2>
		<div class="row">
			
			<div class="col-md-3 text-center" style="display: flex; justify-content: center; align-items: center;">
				<div style="display: inline-flex; align-items: center; justify-content: center; border: 3px solid orange; border-radius: 30px; background-color: gray; padding: 10px 20px; margin: 10px; color: white; font-family: Arial, sans-serif; font-size: 1em; width: 200px; height: 100px;">
					<a href="exam_verification_report.php" style="color: white; text-decoration: none;" target="_blank">
						EXAM FORM VERIFICATION REPORT
					</a>
				</div>
			</div>
			
			<div class="col-md-3 text-center" style="display: flex; justify-content: center; align-items: center;">
				<div style="display: inline-flex; align-items: center; justify-content: center; border: 3px solid orange; border-radius: 30px; background-color: gray; padding: 10px 20px; margin: 10px; color: white; font-family: Arial, sans-serif; font-size: 1em; width: 200px; height: 100px;">
					<a href="back_exam_verification_report.php" style="color: white; text-decoration: none;" target="_blank">
						BACK EXAM FORM VERIFICATION REPORT
					</a>
				</div>
			</div>
		</div>
	</div>
<?php 
page_footer_start(); 
page_footer_end(); 
?>
