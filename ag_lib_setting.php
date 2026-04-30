<?php 
include("scripts/settings.php");
//session_start();
 function header_lib(){
global $db;	?>
<!DOCTYPE html>

<html>
	<head>
		<title></title>
		
		<!-- CSS Bootstrap -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		
		<!-- CSS Style -->
		
		<style>
			:root{
				--head-text-color:black;
				--sub-head-text-color:#D988B9;
				--background-color: #26801E;
				--text-color: blue;
				--hover-text-color:black;
				--dd-bg-color:white;
			}
			*{
				padding:0px;
				margin:0px;
				box-sizing:border-box;
				border:0px solid black;
			}
			.wrap{
				position:sticky;
				width:30%;
				text-align:center;
			}

			h2{
				font-size:18px;
				padding-top:10px;
				font-weight:550;
			}
			img{
				width:60px;
				margin:5px 10px;
			}
			.detail_col{
				padding:2px;
				background-color:var(--background-color);
				border-radius:10px 10px 5px 5px;
			}

			body {
				font-family: "Lato", sans-serif;
			}


			.sidenav {
				height: 68.6vh;
				position: relative;
				z-index: 1;
				top: 0;
				left: 0;
				background-color: white;
				overflow-x: hidden;
				padding: 5px;
				border-radius:5px;
			}

			.sidenav a, .dropdown-btn {
				padding: 5px 8px 5px 15px;
				text-decoration: none;
				font-size: 20px;
				color:var(--text-color);
				display: block;
				border: none;
				background: none;
				width: 100%;
				text-align: left;
				cursor: pointer;
				outline: none;
			}
			.dropdown-btn{
				margin:2px;
				border-radius:5px;
			}
			.sidenav a:hover, .dropdown-btn:hover {
				border:0px; 
			}
			.sidenavbg a:hover, .dropdown-btn:hover {
				box-shadow:1px 0px 5px skyblue;
				border:0px; 
			}
			

			.fa-caret-right {
				float: left;
				padding-right: 8px;
				padding-top:8px;
				color:black;
			}
			.fa-caret-down {
				float: left;
				padding-right: 8px;
				padding-top:8px;
				color:black;
			}

			@media screen and (max-height: 450px) {
				.sidenav {padding-top: 15px;}
				.sidenav a {font-size: 18px;}
			}
			.form_col{
				margin-left:0%;
				padding:0px;
				border-radius:10px;
			}
			.form_head{
				background-color:var(--background-color);
				color:white;
				border-radius:5px 5px 0px 0px;
				height:100px;

			}
			.sub_head{
				background-color:skyblue;
				color:var(--background-color);
			}
			.fa-caret-right{
				color:black;
			}
			
			.dropdown-content{
				display:none;
			}
		</style>
	</head>
	<body>

	<div class="d-flex">
		<div class="wrap" style="border-right:0px solid black; box-shadow:0px 0px 10px black; border-radius:5px; margin:5px; width:20%;">
			<div class="person_info" style="border-bottom:1px solid black; background-color:var(--background-color); color:white; border-radius:5px;">
				<h6 style="padding-top:8px; font-size:18px;"><b>KNIPSS (CENTRAL LIBRARY)</b></h6>
				<div style="padding:0px 10px;"><hr></div>
				<div class="d-flex justify-content-around" style="text-align:center;">
					<div><img src="image/knipsslogo.png" alt="" style="border-radius:50%;"></div>
					<div class="">
						Welcome<br/>
						Central Library <br/>
						Rajesh Pandey<br/>
					</div>
					<div><img src="image/" alt="" style="border-radius:50%;"></div>
				</div>
				<div style="text-align:center; padding:5px;" class="">(<?php echo $_SESSION['username']; ?>)</div>
				
				
			</div>
			<div class="detail_col" style="padding:0px;">
				<div class="sidenav">
					<!-- First Dropdown -->
					<div class="dropdown">
						<?php
							$parentsql="SELECT * FROM lib_navigation WHERE parent='R' ORDER BY sort_no";
							$parentres=mysqli_query($db,$parentsql);
							while($row=mysqli_fetch_assoc($parentres)){
								?>
									<button class="dropdown-btn" style="color:#061cd3; font-size:1.2rem;"><i class="fa-solid fa-caret-right"></i><a href="<?php echo $row['hyper_link']?>"><?php echo $row['link_description']?></a></button>
									
									<?php
										$parentsno=$row['sno'];
										$childsql="SELECT * FROM lib_navigation WHERE parent='$parentsno'";
										$childres=mysqli_query($db,$childsql);
										?>
											<div class="dropdown-content">
												<?php
													$j = 0;
													while($childrow=mysqli_fetch_assoc($childres)){
														$j++;
														?>
															<a class="sidenavbg" style="color:black; font-size:1rem;" href="<?php echo $childrow['hyper_link']?>"> <?php echo $j; ?>.&nbsp;<?php echo $childrow['link_description']?></a>
														<?php
													}
												?>
											</div>
									<?php
							}
									?>
					</div>
					<?php
						//those that don't have any parent should show here
						$npsql="SELECT * from lib_navigation WHERE parent='NP'";
						$npres=mysqli_query($db,$npsql);
						if(mysqli_num_rows($npres)>0){
							while($nprow=mysqli_fetch_assoc($npres)){
								?>
									<a href="<?php echo $nprow['hyper_link']?>"><i class="fa-solid fa-caret-right"></i><?php echo $nprow['link_description']?></a>
								<?php
							}
						}
					?>

					<!-- Second Dropdown
					<a href="#"><i class="fa-solid fa-caret-right"></i>Option</a>
					
					 -->

				</div>	
			</div>
		</div>

		<div class="form_col" style="width:80%;">
			<table width="100%" style="border-bottom: 1px solid black;background-color: var(--background-color); color: white;border-radius: 5px;}" class=" text-white mt-1 me-2">
				<tr>
					<th width="12%" rowspan="2"><img style="padding:15px; height:70px; width:70px; " src="image/knipsslogo.png" alt="logo" class="img-fluid d-block m-auto" /> </th>
					<th width="88%">
						<h5 class="" style="text-align: center; margin:0px; " ><span style="font-size:24px;white-space:nowrap;" class="head-name"><b>Kamla Nehru Institute Of Physical & Social Sciences,Sultanpur, Uttar Pradesh</b></span> </h5>
					</th>
					<th><a href="signout.php" class="btn btn-danger me-2" >Logout</button></th>
				</tr>
			</table>
<?php }; ?>		
			
<?php function footer_lib(){ ?>			
</div>
	</div>
	<div class="footer" style="background-color:var(--background-color); text-align:center; padding:10px; color:white; ">
		© <?php echo date("Y"); ?>  <a href="http://www.weknowtech.in" target="_blank" style="text-decoration:none;color:white;"><img style="width:20px;" src="images/logo-15.png"  class="img-rounded">Weknow Technologies Pvt. Ltd.</a>
	</div>
		
	<!-- JS -->
		<!-- <script src="js/script.js">	
	</script> -->
	<script>
			var dropdownBtns = document.querySelectorAll(".dropdown-btn");

			dropdownBtns.forEach(function (dropdownBtn) {
				var dropdownContent = dropdownBtn.nextElementSibling;
				console.log(dropdownContent,dropdownBtn);
				dropdownBtn.addEventListener("click", function () {
					// // Close all other dropdowns
					// dropdownBtns.forEach(function (otherBtn) {
					// 	var otherContent = otherBtn.nextElementSibling;
					// 	if (otherBtn !== dropdownBtn && otherContent.style.display === "block") {
					// 		otherContent.style.display = "none";
					// 	}
					// });

					// Toggle display of the current dropdown
					dropdownContent.style.display = (dropdownContent.style.display === "block") ? "none" : "block";
				});
			});
	
	</script>

<?php }; ?>
	
	</body>
</html>
