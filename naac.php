<?php 
include("scripts/settings.php");
$msg = '';

page_header_start();
page_header_end();
page_sidebar();
?>

	<!doctype html>
	<html lang="en">
	  <head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

		<title>NAAC</title>
		<style>
			body {
				font-family: Arial, sans-serif;
				background-color: #f4f4f9;
				margin: 0;
				padding: 0;
				box-sizing: border-box;
			 background: url('image/bg_a.jpg') no-repeat center center fixed;
				background-size: cover;
				background-size: cover;
				background:linear-gradient(to right,white,skyblue);
				
			}
		
			.header {
				background-color: #004d7a;
				color: white;
				padding: 10px;
				text-align: center;
				font-size: 28px;
			}
			.container {
			max-width: 1150px; /* Increase the width */
		   margin-top:10px;/* Add more spacing at the top and bottom */
			padding: 30px; /* Increase padding */
			background: rgba(255, 255, 255, 0.7); /* Slightly opaque background */
			border-radius: 15px; /* Rounded corners */
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); /* More prominent shadow */
			text-align: center;
			opacity: 0;
			transform: translateY(50px);
			animation: containerSlideIn 1s ease-out forwards;
		}
		
		h2 {
			font-size: 36px; /* Larger heading size */
			font-weight: bold;
			color: #004d7a;
			margin-bottom: 30px;
			text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
		}
			 @keyframes containerSlideIn {
				from {
					opacity: 0;
					transform: translateY(50px);
				}
				to {
					opacity: 1;
					transform: translateY(0);
				}
			}
			/* Table style */
			table {
				width: 100%;
				border-collapse: collapse;
				margin-top: 20px;
			}

			table th, table td {
				text-align: center;
				padding: 15px;
				font-size: 18px;
				border: 1px solid #ddd;
				color: #333;
			}

			table th {
				background-color: #ff6f61;
				color: white;
				font-weight: bold;
			}

			table tr:nth-child(even) {
				background-color: #f9f9f9;
			}

			table tr:hover {
				background-color: #f1f1f1;
			}

			table td {
				font-weight: bold;
			}

			.button-container {
				display: flex;
				flex-wrap: wrap;
				justify-content: center;
				gap: 50px;
				width: 100%;
				margin-top: 80px;
			}
			
				 /* Button animation from the second page */
		@keyframes button {
			from { background-position: -800px, center; }
			to { background-position: 800px, center; }
		}
		
			.button {
				position: relative;
				background-color: #004d7a;
				color: white;
				font-size: 18px;
				padding: 15px 30px;
				border: none;
				border-radius: 8px;
				cursor: pointer;
				transition: all 0.3s ease;
				text-align: center;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
				width: 250px;
				margin-bottom: 20px;
				
				 animation: buttonAnimation 1s ease-out infinite alternate;
				  background: 
		   linear-gradient(130deg, transparent 5%, rgba(0, 40, 100, 0.6) 25%, rgba(0, 77, 122, 0.8) 50%, rgba(0, 40, 100, 0.6) 75%, transparent 95%) no-repeat, /* Darker blue gradient */
			linear-gradient(#003366 0%, #004d7a 100%); /* Matching header colors */
	   
		background-position: center, center;
		
		box-shadow: #000 3px 3px 7px;
		font-size: 1.3rem;
		position: relative;
		display: inline-block;
		width: 300px; /* Adjust the width */
		height: 150px; /* Adjust the height */
		background: green; /* Subtle gradient background */
		border: 2px solid #cccccc; /* Border for the button */
		border-radius: 20px; /* Rounded corners to match the oval shape */
		 /* Ensures the stripe does not overflow */
		text-align: center;
		cursor: pointer;
		outline: none;
		padding: 0;
		box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Adds a slight shadow */
		transition: transform 0.3s, box-shadow 0.3s; /* Smooth hover effects */
				 
			}
			
			  .button:hover {
			transform: scale(1.05); /* Scale up the column */
			box-shadow: 0 4px 15px rgba(255, 255, 255, 0.8); /* White box shadow */
			color: #FFD700;
		}
			/* Animation for the button */
	@keyframes buttonAnimation {
		0% {
			transform: scale(1);
			box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
		}
		100% {
			transform: scale(1.1);
			box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
		}
	}

	 
	  /* Hover effect for button */
			.button:hover {
				background-color: #ff4a39;
				transform: scale(1.15) translateY(-5px); /* Added scale-up effect */
				box-shadow: 0 12px 20px rgba(0, 0, 0, 0.4); /* More prominent shadow on hover */
			}

			/* Active state for button */
			.button:active {
				transform: scale(1.1); /* Slight shrink when clicked */
				box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Slight shadow effect */
			}

			.button:hover {
				background-color: #ff4a39;
				transform: scale(1.05);
			}

		   
	

			
			
			.tooltip {
		position: absolute;
		bottom: 100%; /* Positioned above the button */
		left: 50%; /* Centered horizontally */
		transform: translateX(-50%) translateY(10px); /* Start with offset */
		 background: linear-gradient(135deg, #003366, #004080); /* Dark blue gradient */
  color: #f0f8ff; /* Light text for good contrast */
  
		padding: 15px;
		border-radius: 10px;
		box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
		font-size: 14px;
		visibility: hidden;
		opacity: 0;
		transition: all 0.4s ease-in-out; /* Smooth transition */
		margin-bottom: 10px;
		width: 320px; /* Increased width */
		height: auto; /* Allow height to adjust automatically */
		white-space: normal; /* Allow the text to wrap */
		text-align: left; /* Left-align text */
		overflow-y: auto; /* Make it scrollable if content exceeds max height */
		z-index: 10;/* Make sure it appears above other elements */
		animation: fadeInScale 0.5s ease-out;
	}

	/* Tooltip animation */
	@keyframes fadeInScale {
		0% {
			opacity: 0;
			transform: translateX(-50%) translateY(20px) scale(0.95);
		}
		100% {
			opacity: 1;
			transform: translateX(-50%) translateY(-10px) scale(1);
		}
	}

	/* Tooltip content specific adjustments */
	.tooltip ul {
		list-style-type: disc;
		margin: 0;
		padding-left: 20px;
	}

	.tooltip li {
		margin-bottom: 5px;
	}

	/* Tooltip on button hover */
	.button:hover .tooltip {
		visibility: visible;
		opacity: 1;
		transform: translateX(-50%) translateY(-10px); /* Move up above the button */
	}
	
	@media (max-width: 768px) {
				.button-container {
					width: 90%;
				}
			}

			@media (max-width: 500px) {
				.button-container {
					width: 100%;
				}
			}
		  /* Header styling */
		header {
			background: linear-gradient(90deg, #004d7a, #003366);
			 background-position: center, center;
    animation: button 5s linear infinite;
	
			color: white;
			padding: 20px;
			text-align: center;
			font-size: 28px;
			font-weight: bold;
			text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
			animation: headerGlow 3s infinite alternate;
			
		}

		header h3 {
			font-size: 18px;
			font-weight: 300;
		}

		@keyframes headerGlow {
			from {
				text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
			}
			to {
				text-shadow: 0 0 20px rgba(255, 255, 255, 1);
			}
		}

		/* Table styling */
		table {
			width: 100%;
			border-collapse: collapse;
			margin: 20px auto;
			background-color: rgba(255, 255, 255, 0.9);
			border-radius: 10px;
			overflow: hidden;
			box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
			
			animation: tableFadeIn 1.5s ease-out;
		}

		@keyframes tableFadeIn {
			from {
				opacity: 0;
				transform: translateY(20px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		table th {
			background: linear-gradient(90deg, #ff6f61, #ff4a39);
			  background: 
       linear-gradient(130deg, transparent 5%, rgba(0, 40, 100, 0.6) 25%, rgba(0, 77, 122, 0.8) 50%, rgba(0, 40, 100, 0.6) 75%, transparent 95%) no-repeat, /* Darker blue gradient */
        linear-gradient(#003366 0%, #004d7a 100%);
		
    background-position: center, center;
    animation: button 5s linear infinite;
			color: white;
			font-size: 16px;
			font-weight: bold;
			text-transform: uppercase;
			padding: 15px;
			text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
		}

		table td {
			padding: 15px;
			font-size: 18px;
			font-weight: bold;
			color: #333;
		}

		table tr {
			transition: all 0.3s ease-in-out;
		}

		table tr:hover {
			background: rgba(255, 111, 97, 0.1);
			transform: scale(1.02);
			cursor: pointer;
		}

		table tr:nth-child(even) {
			background-color: #f9f9f9;
		}
		 h2 {
			font-size: 36px; /* Larger heading size */
			font-weight: bold;
			color: #004d7a;
			margin-bottom: 30px;
			text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
		}

	   /* Button Container */
	.button-container {
		display: flex;
		justify-content: center;
		align-items: center;
		margin-top: 60px ;
	}

	
	/* Header Stripe */
	.header-stripe {
		position: absolute;
		top: 80%;
		left: 0;
		transform: translateY(-50%);
		width: 100%;
		height: 40%; /* Stripe height relative to the button */
		background: linear-gradient(90deg, #004d7a, #003366); 
		color: white;
		font-weight: bold;
		font-size: 1.2rem;
		line-height: 40px;
		text-align: center;
		text-transform: uppercase;
		border-radius:20px;
	}

	.header {
  text-align: center; /* Center align the header */
  /* Add some space around the header */
}

.header h1 {
  font-family: 'Pinyon Script', cursive; /* Elegant cursive font */
  font-size: 48px; /* Increase size for emphasis */
  font-weight: bold; /* Bold for better visibility */
  color: white; /* Dark blue to match the theme */
}

.header h3 {
  font-family: 'Montserrat', sans-serif; /* Consistent with main title */
  font-size: 24px; /* Adjust size for subtitle */
  font-weight: 600; /* Semi-bold for emphasis */
  color: white; /* Slightly lighter blue */
}
.content{
	margin:0px !important;
	padding:0px !important;
}
.container-fluid{
	margin:0px !important;
	padding:0px !important;
}


	
		</style>
	  </head>
	  <body>
		<div class="header p-4">
			<h1>NAAC</h1>
			<h3>(National Assessment & Accreditation Council)</h3>
		</div>

		<div class="card col-md-11 mx-auto p-2 mt-3 rounded shadow p-3 mb-5 bg-body-tertiary rounded">
			<h2 class="text-center pt-3">Distribution of Metrics and KIs across Criteria</h2>
			<table>
				<thead>
					<tr>
						<th>Criteria</th>
						<th>Key Indicators (KIs)</th>
						<th>Qualitative Metrics (QlM)</th>
						<th>Quantitative Metrics (QnM)</th>
						<th>Total Metrics (QlM + QnM)</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>7</td>
						<td>32</td>
						<td>22</td>
						<td>34</td>
						<td>56</td>
					</tr>
				</tbody>
			</table>

			<div class="button-container">
				<button class="button" style="background-image:url(image/c1_3.webp); background-position:center;background-size:cover;" onclick="window.location.href='naac_Criteria1.php'">
					 <div class="header-stripe">Criteria 1</div>
					<div class="tooltip" >
						<ul  style="text-align: left; list-style-type: disc; margin: 0; padding: 0 20px;">
							<li><strong>Key Indicator 1.1:</strong> Curricular Planning and Implementation</li>
							<li><strong>Key Indicator 1.2:</strong> Academic Flexibility</li>
							<li><strong>Key Indicator 1.3:</strong> Curriculum Enrichment</li>
							<li><strong>Key Indicator 1.4:</strong> Feedback System</li>
						</ul>
					</div>
				</button>

				<button class="button" style="background-image:url(image/c3c.jpg); background-position:center;background-size:cover;"onclick="window.location.href='naac_Criteria2.php'">
					<div class="header-stripe">Criteria 2</div>
					<div class="tooltip" style="width:31vw;">
						<ul  style="text-align: left; list-style-type: disc; margin: 0; padding: 0 20px;" >
							<li><strong>Key Indicator 2.1:</strong> Student Enrolment and Profile</li>
							<li><strong>Key Indicator 2.2:</strong> Student Teacher Ratio</li>
							<li><strong>Key Indicator 2.3:</strong> Teaching-Learning Process</li>
							<li><strong>Key Indicator 2.4:</strong> Teacher Profile and Quality</li>
							<li><strong>Key Indicator 2.5:</strong> Evaluation Process and Reforms</li>
							<li><strong>Key Indicator 2.6:</strong> Student Performance and Learning Outcome</li>
							<li><strong>Key Indicator 2.7:</strong> Student Satisfaction Survey</li>
						</ul>
					</div>
				</button>

				<button class="button"  style="background-image:url(image/c3b.webp); background-position:center;background-size:cover;"onclick="window.location.href='naac_Criteria3.php'">
					 <div class="header-stripe">Criteria 3</div>
					<div class="tooltip">
						<ul  style="text-align: left; list-style-type: disc; margin: 0; padding: 0 20px;">
							<li><strong>Key Indicator 3.1:</strong> Resource Mobilization for Research</li>
							<li><strong>Key Indicator 3.2:</strong> Innovation Ecosystem</li>
							<li><strong>Key Indicator 3.3:</strong> Research Publication and Awards</li>
							<li><strong>Key Indicator 3.4:</strong> Extension Activities</li>
							<li><strong>Key Indicator 3.5:</strong> Collaboration</li>
						</ul>
					</div>
				</button>

				<button class="button" style="background-image:url(image/c4a.jpg); background-position:bottom;background-size:cover;" onclick="window.location.href='naac_Criteria4.php'">
					 <div class="header-stripe">Criteria 4</div>
					<div class="tooltip">
						<ul  style="text-align: left; list-style-type: disc; margin: 0; padding: 0 20px;">
							<li><strong>Key Indicator 4.1:</strong> Physical Facilities</li>
							<li><strong>Key Indicator 4.2:</strong> Library as a Learning Resource</li>
							<li><strong>Key Indicator 4.3:</strong> IT Infrastructure</li>
							<li><strong>Key Indicator 4.4:</strong> Maintenance of Campus Infrastructure</li>
						</ul>
					</div>
				</button>

				<button class="button" style="background-image:url(image/c5d.jpg); background-position:center;background-size:cover;"onclick="window.location.href='naac_Criteria5.php'">
					 <div class="header-stripe">Criteria 5</div>
					<div class="tooltip">
						<ul  style="text-align: left; list-style-type: disc; margin: 0; padding: 0 20px;">
							<li><strong>Key Indicator 5.1:</strong> Student Support</li>
							<li><strong>Key Indicator 5.2:</strong> Student Progression</li>
							<li><strong>Key Indicator 5.3:</strong> Student Participation and Activities</li>
							<li><strong>Key Indicator 5.4:</strong> Alumni Engagement</li>
						</ul>
					</div>
				</button>

				<button class="button" style="background-image:url(image/c6b.jpg); background-position:top;background-size:cover;"onclick="window.location.href='naac_Criteria6.php'">
					 <div class="header-stripe">Criteria 6</div>
					<div class="tooltip">
						<ul  style="text-align: left; list-style-type: disc; margin: 0; padding: 0 20px;">
							<li><strong>Key Indicator 6.1:</strong> Institutional Vision and Leadership</li>
							<li><strong>Key Indicator 6.2:</strong> Strategy Development and Deployment</li>
							<li><strong>Key Indicator 6.3:</strong> Faculty Empowerment Strategies</li>
							<li><strong>Key Indicator 6.4:</strong> Financial Management and Resource Mobilization</li>
							<li><strong>Key Indicator 6.5:</strong> Internal Quality Assurance System</li>
						</ul>
					</div>
				</button>

				<button class="button" style="background-image:url(image/c7d.jpg); background-position:bottom;background-size:cover;"onclick="window.location.href='naac_Criteria7.php'">
					<div class="header-stripe">Criteria 7</div>
					<div class="tooltip">
						<ul  style="text-align: left; list-style-type: disc; margin: 0; padding: 0 20px;">
							<li><strong>Key Indicator 7.1:</strong> Institutional Values and Social Responsibilities</li>
							<li><strong>Key Indicator 7.2:</strong> Best Practices</li>
							<li><strong>Key Indicator 7.3:</strong> Institutional Distinctiveness</li>
						</ul>
					</div>
				</button>
			</div>
			

		</div>

		<!-- Optional JavaScript; choose one of the two! -->

		<!-- Option 1: Bootstrap Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

	  </body>
	</html>
	
	<?php
page_footer_start();
page_footer_end();
?>