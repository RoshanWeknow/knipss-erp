<?php 
//include("scripts/settings.php");
include("lib_setting.php");
$msg = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            /* margin: 0;
            padding: 0;
            box-sizing: border-box; */
            font-family: Arial, Helvetica, sans-serif;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .catelog-cont {
            position: relative;
            font-size: 1.2rem;
            min-height:2in;
            width:4.5in;
            margin-bottom:1rem;
        }

        .left {
            width: 1.5in;
            text-align: center;
            padding: 0.3rem;
        }

        .right {
            width: 3in;
            padding: 0.3rem;
        }

        .middle {
            height: 50%;
        }
        
        @page {
            size: A4;
            margin-top:3rem;
        }
        table, figure {
            page-break-inside: avoid;
            /* table and picture hmesa ek hi page pe rhe usko insure karta hai ye */
            /* break-after: page; */

        }
        @page :left {
  margin-top: 0.3in;
}

/* Targets all odd-numbered pages */
@page :right {
  /* size: 11in; */
  margin-top: 0.3in;
}
		@media print {
            
		}
    </style>
</head>
<body>

    <?php
        $min_acc_no = $_POST['acc_no1'];
        $max_acc_no = $_POST['acc_no2'];
        $sql = 'SELECT * FROM lib_add_new_book WHERE accession_no BETWEEN '.$min_acc_no.' AND '.$max_acc_no;
        $result = execute_query($db, $sql);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <br>
            <div class="wrapper">
                <table class="catelog-cont">
                    <tr>
                        <td class="left" rowspan="2"><?php echo $row['ddc_code'].'<br>'.$row['book_no']?></td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="right"><?php echo $row['author_name'] ?></td>
                    </tr>
                    <tr class="middle">
                        <td rowspan="2" class="left" valign="top">
                            <?php
                                $sql2 = 'select accession_no from lib_add_new_book where mfn = "'.$row['mfn'].'"';
                                $res2 = mysqli_query($db, $sql2);
                                while($row2 = mysqli_fetch_assoc($res2)){
                                    echo $row2['accession_no'].', ';
                                };
                            ?>    
                        </td>
                        <td colspan="2" class="right"><?php echo $row['title'] .' / '. $row['author_name'] .' - '. $row['edition'].' - '.$row['publisher_name'].' - '.$row['pub_year'].'- '.$row['place'].'<br>' .$row['pagination'] .' Pg.<br>1. '.$row['subject'] ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
    <?php
        }
    }
    ?>
</body>
</html>
