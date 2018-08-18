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
function confirmTaskUpdate()
{
	var del = confirm('Are you sure to update this task as Done ?');
  
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
    <h2 align="center">Pending Task</h2>    
    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
				<th>SNo.</th>
				<th>Shared Date</th>
				<th>Shared By</th>
				<th>Client Req</th>
				<th>Client Prop</th>
				<th>Department</th>
				<th>Task Summary</th>
				<th>Reminder Date</th> 
				<th>Target Date</th>
				
				<?php 
				if(($this->session->userdata('UserType')!='Admin'))
				{
				?>
                <th>UPDATE</th>
				<?php
				}?>
            </tr>
            </thead>
            <tbody>
            <?php
				$SNo=1;
				foreach($query->result_array() as $row): 
				
					$TaskAssignId = trim($row['iTaskAssignId']);
					$DepartmentName = trim($row['cDepartmentName']);
					$TaskAssignedByName = trim($row['cTaskAssignedByName']);
					
					$getTaskAssignDateTime = trim($row['dTaskAssignDateTime']);
					$TaskAssignDateTime = date('d/m/Y h:i:s a', strtotime($getTaskAssignDateTime));
					
					$ReqClientName = trim($row['cReqClientName']);
					
					$PropClientName = trim($row['cPropClientName']);
					
					$TaskSummary = trim($row['cTaskSummary']);
					
					$getTaskTargetDateTime = trim($row['dTaskTargetDateTime']);
					$TaskTargetDateTime = date('d/m/Y h:i:s a', strtotime($getTaskTargetDateTime));
					
					$TaskDone = trim($row['bTaskDone']);
					
					$getReminderDateTime = trim($row['dReminderDateTime']);
					$ReminderDateTime = date('d/m/Y h:i:s a', strtotime($getReminderDateTime));
			?>
            
			<tr class="gradeA">
                <td style="text-align:center;"><?php echo $SNo; ?>.</td>
				<td style="text-align:left;"><?php echo $TaskAssignDateTime; ?></td>
				<td style="text-align:left;"><?php echo $TaskAssignedByName; ?></td>
				<td style="text-align:left;"><?php echo $ReqClientName; ?></td>
				<td style="text-align:left;"><?php echo $PropClientName; ?></td>
				<td style="text-align:left;"><?php echo $DepartmentName; ?></td>
				<td style="text-align:left;"><?php echo $TaskSummary; ?></td>
				<td style="text-align:left;"><?php echo $ReminderDateTime; ?></td>
				<td style="text-align:left;"><?php echo $TaskTargetDateTime; ?></td>
				
				<?php 
				if(($this->session->userdata('UserType')!='Admin'))
				{
				?>
				<td style="text-align:center;"><div class="submit"><a href="<?php echo base_url(); ?>index.php/dashboard/update_task_assigned/<?php echo $TaskAssignId; ?>"><input type="button" name="btnUpdate" id="btnUpdate" class="btn" onclick="return confirmTaskUpdate()" value="Update as Done" /></a></div></td>
				<?php
				}?>
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