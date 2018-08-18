<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        var oTable = $('#example').dataTable({
            "bJQueryUI": true,
            "aaSorting":[[0, "asc"]],
            "sPaginationType": "full_numbers"
        });
    });
</script>

<script type="text/javascript" language="javascript">
    function confirmDelete()
    {
        var del = confirm('Are you sure want to delete this task?');
  
        if(del)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
</script>

<div class="table_wrap">
    <h2 align="center">Reminders</h2>    
    <div style="width:100%; height:25px; border:0px solid #FF0000;">
        <div align="right" style="float:left; width:97%; height:25px; border:0px solid #000000;">
            <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/add_form_task_assign"><img src="<?php echo base_url(); ?>images/addnew.jpg" title="Add New" width="20" height="20" /></a>
        </div>
    </div> 

    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                                <!--<th>SNo.</th>-->
                        <th>Assign Date</th>
                        <th>Assigned By</th>
                        <th>Assigned To</th>
                    <!--<th>Requirement</th>-->
                        <th>Client</th>
                <!--<th>Property</th>-->
                        <th>RF</th>
                        <th>PSR</th>
                        <th>Task Summary</th>
                        <th>Target Date</th>
                        <th>Task Status</th>

                        <th>EDIT</th>    
                    <!--<th>DELETE</th>-->
                    </tr>
                </thead>
                <tbody>

                    <?php
            
                    $SNo = 1;
                    foreach ($query->result_array() as $row):

                        $TaskAssignId = trim($row['iTaskAssignId']);

                        $getTaskAssignDateTime = trim($row['dTaskAssignDateTime']);
                        $TaskAssignDateTime = date('d/m/Y h:i:s a', strtotime($getTaskAssignDateTime));

                        $ReqClientName = trim($row['cReqClientName']);

                        $RequirementTitle = trim($row['cRequirementTitle']);

                        $PropClientName = trim($row['cPropClientName']);

                        $PropertyName = trim($row['cPropertyName']);

                        $TaskAssignedByName = trim($row['cTaskAssignedByName']);

                        $DepartmentName = trim($row['cDepartmentName']);

                        $TaskSummary = wordwrap($row['cTaskSummary'], 10);

                        if (!empty($row['dTaskTargetDateTime']) && ($row['dTaskTargetDateTime'] != '0000-00-00 00:00:00')) {
                            $getTaskTargetDateTime = trim($row['dTaskTargetDateTime']);
                            $TaskTargetDateTime = date('d/m/Y h:i:s a', strtotime($getTaskTargetDateTime));
                        } else {
                            $TaskTargetDateTime = "";
                        }

                        if (!empty($row['dReminderDateTime']) && ($row['dReminderDateTime'] != '0000-00-00 00:00:00')) {
                            $getSetReminderDateTime = trim($row['dReminderDateTime']);
                            $SetReminderDateTime = date('d/m/Y h:i:s a', strtotime($getSetReminderDateTime));
                        } else {
                            $SetReminderDateTime = "";
                        }

                        $TaskDone = trim($row['bTaskDone']);

                        $TaskDoneByName = trim($row['cTaskDoneByName']);
                        ?>

                        <tr class="gradeA">
                        <!--<td style="text-align:center;"><?php //echo $SNo; ?>.</td>-->
                            <td style="text-align:left;"><?php echo $TaskAssignDateTime; ?></td>
                            <td style="text-align:left;"><?php echo $TaskAssignedByName; ?></td>
                            <td style="text-align:left;"><?php echo $DepartmentName; ?></td>
                        <!--<td style="text-align:left;"><?php //echo $RequirementTitle; ?></td>-->
                            <td style="text-align:left;"><?php echo $ReqClientName; ?></td>
                    <!--<td style="text-align:left;"><?php //echo $PropertyName; ?></td>-->
                            <td style="text-align:left;"><?php echo $RequirementTitle; ?></td>
                            <td style="text-align:left;"><?php echo $PropertyName; ?></td>
                            <td style="text-align:left;"><?php echo $TaskSummary; ?></td>
                            <td style="text-align:left;"><?php echo $TaskTargetDateTime; ?></td>
                            <td style="text-align:center;"><?php echo $TaskDone; ?></td>


                            <td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/edit_form_task_assign/<?php echo $TaskAssignId; ?>"><span class="ui-icon ui-icon-pencil"></span></a></td>

    <!--<td align="center"><a href="<?php //echo base_url();  ?>index.php/dashboard/delete_task_assign/<?php //echo $TaskAssignId;  ?>" onclick="return confirmDelete()"><span class="ui-icon ui-icon-trash"></span></a></td>-->
                        </tr>            

    <?php
    $SNo++;
endforeach;
?>

                </tbody>
            </table>   
        </div>        
        <div style="height:2px;"></div>
    </div>
</div>        

<!-- ui-dialog -->
<div id="dialog"> </div>