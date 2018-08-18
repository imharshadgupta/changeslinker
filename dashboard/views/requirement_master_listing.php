<script type="text/javascript" language="javascript">
$(document).ready(function() {
	var oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"aaSorting":[[0, "desc"]],
		"sPaginationType": "full_numbers"
	});
});
</script>

<script type="text/javascript" language="javascript">
function confirmDelete()
{
	var del = confirm('Are you sure want to delete this detail?');
  
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
    <h2 align="center">Requisitions</h2>
        
    <div style="width:100%; height:25px; border:0px solid #FF0000;">
        <div align="right" style="float:left; width:97%; height:25px; border:0px solid #000000;">
            <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/add_form_requirement_master"><img src="<?php echo base_url(); ?>images/addnew.jpg" title="Add New" width="20" height="20" /></a>
        </div>
    </div> 
    
    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
				<th>SNo.</th>
				<th>Date</th>
				<th>Title</th>
				<!--<th>Client</th>-->
				<th>Current Status</th>
				<th>Accept T&C</th>
				<th>Active</th>
                <th>VIEW</th>
				<th>EDIT</th>
            <!--<th>DELETE</th>-->
				<th>HISTORY</th>
            </tr>
            </thead>
            <tbody>
                
            <?php 
				$SNo=1;
				foreach($query->result_array() as $row): 
				
					$RequirementId = trim($row['iRequirementId']);
					
					$dt = trim($row['dDate']);
					$splitdt = explode('-',$dt);
					$Date = $splitdt[2]."/".$splitdt[1]."/".$splitdt[0];
					
					$RequirementTitle = trim($row['cRequirementTitle']);
					
					$ClientName = trim($row['cClientName']);
					
					if(!empty($row['cCurrentStatusName']))
					{
						$CurrentStatusName = trim($row['cCurrentStatusName']);
					}
					else
					{
						$CurrentStatusName = "NA";
					}
					
					$AcceptTermsAndConditions = trim($row['bAcceptTermsAndConditions']);
					
					$Active = trim($row['bActive']);
			?>
            
            <tr class="gradeA">
				<td style="text-align:center;"><?php echo $SNo; ?>.</td>
                <td style="text-align:left;"><?php echo $Date; ?></td>
				<td style="text-align:left;"><?php echo $RequirementTitle; ?></td>
				<!--<td style="text-align:left;"><?php // echo $ClientName; ?></td>-->
                <td style="text-align:left;"><?php echo $CurrentStatusName; ?></td>
				<td style="text-align:center;"><?php echo $AcceptTermsAndConditions; ?></td>
				<td style="text-align:center;"><?php echo $Active; ?></td>
                
				<td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/viewrequisition/<?php echo $RequirementId; ?>"><span class="ui-icon ui-icon-search"></span></a></td>
				
                <td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/edit_form_requirement_master/<?php echo $RequirementId; ?>"><span class="ui-icon ui-icon-pencil"></span></a></td>
                     
            <!--<td align="center"><a href="<?php //echo base_url(); ?>index.php/dashboard/delete_requirement_master/<?php //echo $RequirementId; ?>" onclick="return confirmDelete()"><span class="ui-icon ui-icon-trash"></span></a></td>-->
            				
				<td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/requisitionhistory/<?php echo $RequirementId; ?>" title="Print History"><span class="ui-icon ui-icon-print"></span></a></td>
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