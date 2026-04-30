<?php 
include("scripts/settings.php");

$msg='';

page_header_start();
page_header_end();
page_sidebar();
?>
<!DOCTYPE html>
<html lang="en">
<head>

    
    <style>
        html{
           
        }
        a{
            text-decoration:none;
        }
        header{ /* delete me plz */
            
            width:100%;
            
            height: 70px;
            background-color:whitesmoke;
        }
        
        .wrap{
			font-family: cursive;
            letter-spacing:4px;
            font-weight:700;
            text-transform:uppercase; 
            height:80vh;
            background-color:dodgerblue;
            background-image:url('img/m_bg4.jpg');
            background-repeat:no-repeat;
            background-attachment:fixed;
            background-size:cover;
            background-position:center;
            border-radius:13px;
            display:grid;
            gap:1.8rem;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            grid-auto-row:100px;
            place-content:center;
            align-content:space-around;
            justify-content:center;
            padding:40px;
        }
        
        .btnn{
            padding:15px 0 0;
            border-radius:10px;
            /* font-size:0.8rem; */
            width:100%;
            height:100px;
            background-color:lightgray;
            text-align:center;
            color:black; 
            width:100%; 
            /* box-shadow:3px 3px 10px #333; */
            box-shadow:3px 3px 10px skyblue;
            display:flex;
            flex-direction:column;
            align-items:center;
            position: relative;
        }
        .btnn:hover{
            box-shadow:0 0 0 transparent;
            
        }
        
        .btnn1{
            width:100%;
            height: 100%;
            background-color:lightgray;            
            background-image:url('img/m_1.png');
            background-size:contain;
            background-repeat:no-repeat;
            background-position:center;
        }
        .btnn2{
            width:100%;
            height: 100%;
            background-color:lightgray;             
            background-image:url('img/m_2.png');
            background-size:contain;
            background-repeat:no-repeat;
            background-position:center;
        }
        .btnn3{
            width:100%;
            height: 100%;
            background-color:lightgray;             
            background-image:url('img/m_3.png');
            background-size:contain;
            background-repeat:no-repeat;
            background-position:center;
        }
        .btnn4{
            width:100%;
            height: 100%;
            background-color:lightgray;            
            background-image:url('img/m_4.png');
            background-size:contain;
            background-repeat:no-repeat;
            background-position:center;
        }
        .btnn5{
            width:100%;
            height: 100%;
            background-color:lightgray;              
            background-image:url('img/m_5.png');
            background-size:contain;
            background-repeat:no-repeat;
            background-position:center;
        }
        .btnn6{
            width:100%;
            height: 100%;
            background-color:lightgray;             
            background-image:url('img/m_6.png');
            background-size:contain;
            background-repeat:no-repeat;
            background-position:center;
        }
        .btnn7{
            width:100%;
            height: 100%;
            background-color:lightgray;             
            background-image:url('img/m_7.png');
            background-size:contain;
            background-repeat:no-repeat;
            background-position:center;
        }
        .btnn8{
            width:100%;
            height: 100%;
            background-color:lightgray;            
            background-image:url('img/m_8.png');
            background-size:contain;
            background-repeat:no-repeat;
            background-position:center;
        }
        .btnnin{
            margin-top:5px;
            border-radius:0 0 10px 10px;
            padding:4px 0px;
            background-color: gray;
            color:white;
            font-weight:900; 
            width:100%; 
            height:40px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:1.2rem;
            box-shadow:3px 3px 10px skyblue;
        }
        .btnn:hover .btnnin{
            background-color:hsla(197, 71%, 73%, 0.498);
            color:#0F0700;
            box-shadow:none;
        }
        footer{/* delete me plz */
            width:100%;
            height:70px;
            background-color:whitesmoke;
        }
        
        </style>
        <!-- google font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>

    <div class="wrap">
        <a class="btnn " href="lib_issue.php"  >
            <div class="btnn1"></div>
            <div class="btnnin">Issue</div>	
        </a>
        <a class="btnn " href="lib_reissue.php"  >
            <div class="btnn2"></div>
            <div class="btnnin">Re-Issue</div>	
        </a>
        <a class="btnn " href="lib_return.php"  >
            <div class="btnn3"></div>
            <div class="btnnin">Return</div>	
        </a>
        <a class="btnn " href="lib_fine_impose.php" >
            <div class="btnn4"></div>
            <div class="btnnin">Fine Impose</div>	
        </a>
        <a class="btnn " href="lib_fine_wave.php"  >
                <div class="btnn5"></div>
                <div class="btnnin">Fine Wave</div>	
            </a>
            <a class="btnn " href="lib_fine_payment.php"  >
                <div class="btnn6"></div>
                <div class="btnnin">Fine Payment</div>	
            </a>
	</div>
<?php
page_footer_start();
page_footer_end();
?>
</body>
</html>