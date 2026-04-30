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
        .back-button {
            margin-bottom: 20px;
        }
        .section-header {
            background-color: #6c757d;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 5px;
        }
        .section-header h2 {
            margin: 0;
        }
    </style>
  </head>
  <body>
    <!-- Header Section -->
    <header>
        <h1>NAAC</h1>
        <h3>(National Assessment & Accreditation Council)</h3>
    </header>

    <!-- Main Content -->
    <div class="container card">
        <!-- Criteria Heading and Back Button -->
        <div class="section-header">
            <h2>Criteria 6: Governance, Leadership and Management</h2>
            <a href="naac.php" class="btn btn-danger">Back</a>
        </div>

        <!-- Key Indicators List -->
        <ul style="text-align: left; list-style-type: disc; margin: 0; padding: 0 20px;">
            <li><strong>Key Indicator 6.1:</strong> Institutional Vision and Leadership</li>
            <li><strong>Key Indicator 6.2:</strong> Strategy Development and Deployment</li>
            <li><strong>Key Indicator 6.3:</strong> Faculty Empowerment Strategies</li>
            <li><strong>Key Indicator 6.4:</strong> Financial Management and Resource Mobilization</li>
            <li><strong>Key Indicator 6.5:</strong> Internal Quality Assurance System</li>
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
