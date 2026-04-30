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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>NAAC</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        header {
            background-color: #004d7a;
            color: white;
            padding: 20px;
            text-align: center;
        }
        header h1 {
            margin: 0;
            font-size: 36px;
        }
        header h3 {
            margin: 0;
            font-size: 18px;
        }
        .container {
            margin-top: 20px;
        }
        ul {
            padding-left: 20px;
        }
        li {
            margin-bottom: 10px;
        }
        .description {
            margin-left: 20px;
            color: #555;
        }
        .back-button {
            margin-bottom: 20px;
        }
    </style>
  </head>
  <body>
    <header>
        <h1>NAAC</h1>
        <h3>(National Assessment & Accreditation Council)</h3>
    </header>

    <div class="container card">
        <!-- Back Button -->
        

        <!-- Criteria Heading -->
        <div class="d-flex justify-content-between align-items-center bg-secondary text-white p-2 m-2">
			<h2 class="mb-0">Criteria 1: Curricular Aspects</h2>
			<a href="naac.php" class="btn btn-danger">Back</a>
		</div>

        <ul>
            <li>
                <strong>Key Indicator 1.1:</strong> Curricular Planning and Implementation
                <p class="description">
                    Evaluates how effectively an institution plans and implements its curriculum, 
                    including alignment with goals, teaching methods, and feedback mechanisms.
                </p>
            </li>
            <li>
                <strong>Key Indicator 1.2:</strong> Academic Flexibility
                <p class="description">
                    Measures the institution's ability to provide flexibility in academic programs, 
                    offering elective courses, interdisciplinary options, and CBCS (Choice Based Credit System).
                </p>
            </li>
            <li>
                <strong>Key Indicator 1.3:</strong> Curriculum Enrichment
                <p class="description">
                    Focuses on enriching the curriculum through value-added courses, extracurricular activities, 
                    and meeting industry demands for holistic development.
                </p>
            </li>
            <li>
                <strong>Key Indicator 1.4:</strong> Feedback System
                <p class="description">
                    Examines mechanisms for collecting and using feedback from stakeholders 
                    to improve the curriculum and learning experience.
                </p>
            </li>
        </ul>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
<?php
page_footer_start();
page_footer_end();
?>
