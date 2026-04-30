<?php
include("scripts/settings.php");
$msg='';
$tab=1;
$responce = 0;


page_header_start();
page_header_end();
page_sidebar();	
?>
<!-- FONT AWESOME  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<style>
		.abs_btn{
			border-radius:10px;
		}
		.abs_btn:hover{
			opacity:0.9;
		}
		.ufm_btn{
			border-radius:10px;
		}
		.ufm_btn:hover {
			opacity:0.9;
		}
		.abs_icn{
			font-size:45px;
		}
		.abs_text{
			font-size:15px;
			margin:15px;
		}
	</style>
		<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
						
							<div class="col-md-12">
								<h2 class="bg-primary text-white p-2">ABS/UFM</h2>
								<div class="row">
									 <div class=" col-md-4 d-flex">
										<a href="exam_abs.php"><div class="abs_btn px-5 py-4 m-4 bg-primary text-white text-center"><i class="fa-solid fa-user-tie abs_icn" ></i><br/><span class="abs_text">ABS</span></div></a>
										<a href="exam_ufm.php"><div class="ufm_btn px-5 py-4 m-4 bg-primary text-white text-center"><i class="fa-solid fa-lock abs_icn"></i><br/><span class="abs_text">UFM</span></div></a>
									</div>
								</div>
								
							</div>
					
                    </div>
				</div>
			</div>
		</div>
	
	