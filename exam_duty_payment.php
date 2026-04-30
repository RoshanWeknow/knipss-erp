<?php
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg = '';
$tab = 1;
$responce = 0;

page_header_start();
page_header_end();
page_sidebar();    
?>
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Custom Styles -->
<style>
    .section-title {
        background: linear-gradient(90deg, #6c757d, #adb5bd);
        color: white;
        padding: 12px;
        font-size: 22px;
        font-weight: 600;
        border-radius: 5px;
        text-align: center;
        margin-bottom: 20px;
    }

    .card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 35px;
        justify-content: center; /* Center all cards */
        padding: 10px;
    }

    .card-box {
        width: 150px;
        height: 140px;
        background-color: #6c757d;
        border-radius: 12px;
        text-align: center;
        padding: 15px;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .card-box:hover {
        background-color: #495057;
        transform: translateY(-4px);
    }

    .icon-circle {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .faculty { background-color: #f94144; }
    .attendance { background-color: #f3722c; }
    .report { background-color: #f8961e; }
    .datewise { background-color: #43aa8b; }
    .facultywise { background-color: #577590; }

    .label-text {
        font-size: 13px;
        color: #ffffff;
        font-weight: bold;
        margin-top: 8px;
    }

    .card-container a {
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .card-box {
            width: 45%;
        }
    }

    @media (max-width: 480px) {
        .card-box {
            width: 100%;
        }
    }
</style>

<div class="row">
    <div class="col-md-11 mx-auto">
        <div class="card">
            <div class="card-header">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" target="_blank">
                    <?php echo $msg; ?>
                    <div class="col-md-12">
                        <div class="section-title">Examination Duty Payment</div>
                        <div class="row">
                            <div class="col-md-12 card-container">

                                <a href="faculty_master.php" target="_blank">
                                    <div class="card-box">
                                        <div class="icon-circle faculty">
                                            <i class="fa-solid fa-chalkboard-user"></i>
                                        </div>
                                        <div class="label-text">Faculty Master</div>
                                    </div>
                                </a>

                                <a href="exam_daily_examination_attendence.php" target="_blank">
                                    <div class="card-box">
                                        <div class="icon-circle attendance">
                                            <i class="fa-solid fa-calendar-check"></i>
                                        </div>
                                        <div class="label-text">Daily Attendance</div>
                                    </div>
                                </a>
								<a href="exam_daily_attendence_report.php" target="_blank">
                                    <div class="card-box">
                                        <div class="icon-circle attendance">
                                            <i class="fa-solid fa-calendar-check"></i>
                                        </div>
                                        <div class="label-text">Daily Attendance Report</div>
                                    </div>
                                </a>

                                <a href="faculty schedule report.php" target="_blank">
                                    <div class="card-box">
                                        <div class="icon-circle report">
                                            <i class="fa-solid fa-table-list"></i>
                                        </div>
                                        <div class="label-text">Schedule Report</div>
                                    </div>
                                </a>

                                <a href="datewise.php" target="_blank">
                                    <div class="card-box">
                                        <div class="icon-circle datewise">
                                            <i class="fa-solid fa-clock"></i>
                                        </div>
                                        <div class="label-text">Datewise Report</div>
                                    </div>
                                </a>

                                <a href="facultywise duty.php" target="_blank">
                                    <div class="card-box">
                                        <div class="icon-circle facultywise">
                                            <i class="fa-solid fa-users"></i>
                                        </div>
                                        <div class="label-text">Facultywise Duty</div>
                                    </div>
                                </a>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
page_footer_start();
page_footer_end();
?>
