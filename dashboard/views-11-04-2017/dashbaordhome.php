
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/jquery-ui.js"></script>

<script>
    $(function () {
        $("#accordion").accordion({header: "h3", collapsible: true, active: false});
        $("#accordion1").accordion();
    });
</script>
<style>

    #customers {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin-bottom:30px;
        background-color: #fff;
    }
    #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }
    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: center;
        background-color: #ff5a00;
        color: white;
    }
    .button {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        background-color: #3399FF;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        margin-bottom: 20px;
    }
    .button:hover {
        background-color: #ff5a00;
    }
    .row1 {
        float: left;
        width: 50%;
        margin-left: 3px;
    }
    .row2 {
        float: right;
        width: 48%;
    }
    
    .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover { border: 0px solid;}
    
</style>


<?php
//echo '<pre>';
//print_r($query);
//echo '</pre>';
?>

<div class="table_wrap" style="overflow:hidden;">
    <h2 align="center">Dashboard</h2>

    <div>
        <div style="text-align:center;">
            <a class="button" href="<?php echo base_url(); ?>index.php/dashboard/listing_client_master">Go To Clients List</a>
            <a class="button" href="<?php echo base_url(); ?>index.php/dashboard/add_form_task_assign">Add Reminder</a>
            <a class="button" href="<?php echo base_url(); ?>index.php/dashboard/dwdcrreportform">Task Report</a>
            <a class="button" href="<?php echo base_url(); ?>index.php/dashboard/dwweeklyreportform">Weekly Report</a>
        </div>
        <div class="row1">

            <div id="accordion1">
                <h3>Today's Statistics</h3>
                <div>
                    <table id="customers">

                        <?php
                        if (!empty($query['task'])) {
                            foreach ($query['task'] as $tasktype) {
                                ?>
                                <tr>
                                    <td><?php echo $tasktype['cTaskName']; ?></td>
                                    <td><a href="<?php echo base_url().'index.php/dashboard/todaystatistics?typeid='.$tasktype['iTaskId'];?>" target="_blank"><?php echo $tasktype['tasktypecount']; ?></a></td>     
                                </tr>      
                                <?php
                            }
                        } else {
                            echo '<tr>
                      <td colspan="2">No Result Found.</td>     
                    </tr>';
                        }
                        ?>
                    </table>
                </div>
            </div>

        </div>
        <div class="row2">
<!--            <table id="customers">
                <tr>
                    <th colspan="2">Reminders</th>
                </tr>
            <?php
            if (!empty($query['reminder'])) {




                foreach ($query['reminder'] as $reminderdata) {
                    $iTaskAssignId = $reminderdata['iTaskAssignId'];
                    ?>

                                                        <tr>

                                                            <td><a href="<?php echo base_url(); ?>index.php/dashboard/edit_form_task_assign/<?php echo $iTaskAssignId; ?>">
                    <?php echo $reminderdata['cTaskSummary']; ?></a></td>
                                                            <td><a href="<?php echo base_url(); ?>index.php/dashboard/edit_form_task_assign/<?php echo $iTaskAssignId; ?>"><?php echo $reminderdata['dTaskTargetDateTime']; ?> </a></td>   

                                                        </tr>  

                    <?php
                }
            } else {
                echo '<tr>
                      <td colspan="2">No Result Found.</td>     
                    </tr>';
            }
            ?>
            </table>-->

<!--            <table id="customers">
                <tr>
                    <th colspan="2">10 Oldest RF</th>
                </tr>
            <?php
            $rf = 1;
            if (!empty($query['rf'])) {
                foreach ($query['rf'] as $rfdata) {
                    ?>
                                                        <tr>
                                                            <td><?php echo $rf; ?></td>
                                                            <td><?php echo $rfdata['cRequirementTitle']; ?></td>     
                                                        </tr>      
                    <?php
                    $rf++;
                }
            } else {
                echo '<tr>
                      <td colspan="2">No Result Found.</td>     
                    </tr>';
            }
            ?>
            </table>-->

<!--            <table id="customers">
                <tr>
                    <th colspan="2">10 Oldest PSR</th>
                </tr>
            <?php
            $psr = 1;
            if (!empty($query['psr'])) {
                foreach ($query['psr'] as $psrdata) {
                    ?>
                                                        <tr>
                                                            <td><?php echo $psr; ?></td>
                                                            <td><?php echo $psrdata['cPropertyName']; ?></td>     
                                                        </tr>      
                    <?php
                    $psr++;
                }
            } else {
                echo '<tr>
                      <td colspan="2">No Result Found.</td>     
                    </tr>';
            }
            ?>
            </table>-->

<!--            <table id="customers">
                <tr>
                    <th colspan="2">10 Latest RF</th>
                </tr>
            <?php
            $rf = 1;
            if (!empty($query['rf_latest'])) {
                foreach ($query['rf_latest'] as $rfdata) {
                    ?>
                                                        <tr>
                                                            <td><?php echo $rf; ?></td>
                                                            <td><?php echo $rfdata['cRequirementTitle']; ?></td>     
                                                        </tr>      
                    <?php
                    $rf++;
                }
            } else {
                echo '<tr>
                      <td colspan="2">No Result Found.</td>     
                    </tr>';
            }
            ?>
            </table>-->
<!--            <table id="customers">
                <tr>
                    <th colspan="2">10 Latest PSR</th>
                </tr>
            <?php
            $psr = 1;
            if (!empty($query['psr_latest'])) {
                foreach ($query['psr_latest'] as $psrdata) {
                    ?>
                                                        <tr>
                                                            <td><?php echo $psr; ?></td>
                                                            <td><?php echo $psrdata['cPropertyName']; ?></td>     
                                                        </tr>      
                    <?php
                    $psr++;
                }
            } else {
                echo '<tr>
                      <td colspan="2">No Result Found.</td>     
                    </tr>';
            }
            ?>
            </table>-->

            <div id="accordion">
                <h3>Reminders</h3>
                <div>
                    <table id="customers">

                        <?php
                        if (!empty($query['reminder'])) {




                            foreach ($query['reminder'] as $reminderdata) {
                                $iTaskAssignId = $reminderdata['iTaskAssignId'];
                                ?>

                                <tr>

                                    <td><a href="<?php echo base_url(); ?>index.php/dashboard/edit_form_task_assign/<?php echo $iTaskAssignId; ?>">
                                            <?php echo $reminderdata['cTaskSummary']; ?></a></td>
                                    <td><a href="<?php echo base_url(); ?>index.php/dashboard/edit_form_task_assign/<?php echo $iTaskAssignId; ?>"><?php echo $reminderdata['dTaskTargetDateTime']; ?> </a></td>   

                                </tr>  

                                <?php
                            }
                        } else {
                            echo '<tr>
                      <td colspan="2">No Result Found.</td>     
                    </tr>';
                        }
                        ?>
                    </table>
                </div>

                <h3>10 Oldest RF</h3>
                <div>
                    <table id="customers">         
                        <?php
                        $rf = 1;
                        if (!empty($query['rf'])) {
                            foreach ($query['rf'] as $rfdata) {
                                ?>
                                <tr>
                                    <td><?php echo $rf; ?></td>
                                    <td><?php echo $rfdata['cRequirementTitle']; ?></td>     
                                </tr>      
                                <?php
                                $rf++;
                            }
                        } else {
                            echo '<tr>
                      <td colspan="2">No Result Found.</td>     
                    </tr>';
                        }
                        ?>
                    </table>
                </div>

                <!------->

                <h3>10 Oldest PSR</h3>
                <div>
                    <table id="customers">

                        <?php
                        $psr = 1;
                        if (!empty($query['psr'])) {
                            foreach ($query['psr'] as $psrdata) {
                                ?>
                                <tr>
                                    <td><?php echo $psr; ?></td>
                                    <td><?php echo $psrdata['cPropertyName']; ?></td>     
                                </tr>      
                                <?php
                                $psr++;
                            }
                        } else {
                            echo '<tr>
                      <td colspan="2">No Result Found.</td>     
                    </tr>';
                        }
                        ?>
                    </table>
                </div>

                <!---------->

                <h3>10 Latest RF</h3>
                <div>
                    <table id="customers">

                        <?php
                        $rf = 1;
                        if (!empty($query['rf_latest'])) {
                            foreach ($query['rf_latest'] as $rfdata) {
                                ?>
                                <tr>
                                    <td><?php echo $rf; ?></td>
                                    <td><?php echo $rfdata['cRequirementTitle']; ?></td>     
                                </tr>      
                                <?php
                                $rf++;
                            }
                        } else {
                            echo '<tr>
                      <td colspan="2">No Result Found.</td>     
                    </tr>';
                        }
                        ?>
                    </table>
                </div>

                <!---------->

                <h3>10 Latest PSR</h3>
                <div>
                    <table id="customers">

                        <?php
                        $psr = 1;
                        if (!empty($query['psr_latest'])) {
                            foreach ($query['psr_latest'] as $psrdata) {
                                ?>
                                <tr>
                                    <td><?php echo $psr; ?></td>
                                    <td><?php echo $psrdata['cPropertyName']; ?></td>     
                                </tr>      
                                <?php
                                $psr++;
                            }
                        } else {
                            echo '<tr>
                      <td colspan="2">No Result Found.</td>     
                    </tr>';
                        }
                        ?>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


<style type="text/css">
    #accordion h3 {
        text-align: center;
        background-color: #ff5a00;
        color: #FFF;       
        font-weight: bold;
    }
    
     #accordion1 h3 {
        text-align: center;
        background-color: #ff5a00;
        color: #FFF;       
        font-weight: bold;
    }

    .ui-accordion .ui-accordion-content { padding: 0px;}
</style>






