<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg = '';
$tab = 1;
$response = 1;
page_header_start();
page_header_end();
page_sidebar();
?>
<div class="row">
    <div class="col-md-12">
        <div class="card-body">
            <table class="table table-striped table-hover" id="general_stat_table">
                <thead>
                    <tr class="bg-primary text-white">
                        <th scope="col">Sr. No</th>
                        <th scope="col">Class</th>
                        <th scope="col">Total Students</th>
                        <th scope="col">Paper Code</th>
                        <th scope="col">Title of Paper</th>
                        <th scope="col">Type</th>
                        <th scope="col">Count Students (Type)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    // Query to join tables, calculate counts, and include type from exam_student_paper_info
                    $sql = 'SELECT 
                                e.course_name, 
                                c.class_description,
                                COUNT(DISTINCT e.sno) AS total_students,
                                p.paper_code,
                                p.title_of_paper,
                                p.type,
                                COUNT(p.exam_student_info_sno) AS count_students
                            FROM 
                                exam_student_info e
                            INNER JOIN 
                                exam_student_paper_info p 
                            ON 
                                e.sno = p.exam_student_info_sno
                            INNER JOIN 
                                class_detail c 
                            ON 
                                e.course_name = c.sno
                            WHERE 
                                e.verify_status = "1" 
                                AND e.exam_roll_no IS NOT NULL
                            GROUP BY 
                                e.course_name, p.paper_code, p.type
                            ORDER BY 
                                c.group_short';
                    $result_stu = execute_query($db, $sql);
                    while ($row = mysqli_fetch_assoc($result_stu)) {
                    ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['class_description']; ?></td>
                            <td><?php echo $row['total_students']; ?></td>
                            <td><?php echo $row['paper_code']; ?></td>
                            <td><?php echo $row['title_of_paper']; ?></td>
                            <td><?php echo $row['type']; ?></td>
                            <td><?php echo $row['count_students']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
page_footer_end();
?>
