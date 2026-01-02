<?php
$current_month;
$year = "2022";
$month = "12";
$d = cal_days_in_month(0, $month, $year);

$i=1;
?>

<div class="mobile-menu-overlay"></div>

<div class="main-container">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
        <!-- Simple Datatable start -->
                <div class="pd-20 d-flex">
                    <h4>Attendance</h4>
                </div>
                <div class="pb-20" style="width:100%;max-height: calc(100vh - 300px);overflow:auto">
                    <table class="table" style="font-size:12px">
                      <thead style="white-space: nowrap;">
                        <tr>
                                <th style="width:50px;left:0;position:sticky;top:0;z-index:2;background-color:#fff;">Name:</th>
                            <?php while($i <= $d): ?>
                                <th><?php
                                        $data_variable = $i.'-'.$month.'-'.$year;
                                        $date=date('d-m-Y',strtotime($data_variable));
                                        $nameOfDay = date('D', strtotime($date));
                                        echo $nameOfDay;
                                    ?>
                                    <?=  $month.'-'.$i  ?>
                                </th>
                            <?php $i++;  endwhile; ?>
                        </tr>
                      </thead>
                    
                      <tbody>
                          <?php foreach($employee_list as $row): ?>
                        <tr>
                            <th><?= $row['fullname'] ?></th>
                            <?php $b=1; while($b <= $d): ?>
                                <td> <input type="checkbox" name="" value="<?= $month.'-'.$b ?>" id=""> </td>
                            <?php $b++;  endwhile; ?>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                </div>
            </div>
            <!-- Simple Datatable End -->
    </div>
    
<style>
table{
    border-collapse:separate;
    box-sizing: border-box;
    border-spacing:0;
}
table thead tr{
    position:sticky;
    top:0;
    background-color:#fff;
}
table thead{
    position:sticky;
    left:0;
    background-color:#fff;
    z-index:2;
    
}
table thead tr th{
    border-bottom:1px solid #ccc !important;
}
table tbody tr th{
    position:sticky;
    left:0;
    z-index:1;
    background-color:#fff;
}

</style>
