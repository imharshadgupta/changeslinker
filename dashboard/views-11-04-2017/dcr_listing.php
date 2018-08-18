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
    <h2 align="center">Task Listing</h2>
      
    <div style="width:100%; height:25px; border:0px solid #FF0000;">
        <div align="right" style="float:left; width:97%; height:25px; border:0px solid #000000;">
            <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/add_form_dcr"><img src="<?php echo base_url(); ?>images/addnew.jpg" title="Add New" width="20" height="20" /></a>
        </div>
    </div> 
    
    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
				<th>Id</th>
				<th>Date</th>
				<th>User</th>
				<th>Remarks</th>
                <th>EDIT</th>
            <!--<th>DELETE</th>-->
            </tr>
            </thead>
            <tbody>
                
            <?php 
				$SNo=1;
				foreach($query->result_array() as $row): 
				
					$DCRId = trim($row['iDCRId']);
					
					$DCRDt = trim($row['dDCRDate']);
					if(!empty($DCRDt))
					{
						$splitdcrdt = explode('-',$DCRDt);
						$DCRDate = $splitdcrdt[2]."/".$splitdcrdt[1]."/".$splitdcrdt[0];
					}
					else
					{
						$DCRDate="";
					}
					
					$Name = trim($row['cName']);
					
					$DCRRemarks = trim($row['cDCRRemarks']);
			?>
            
            <tr class="gradeA">
                <td style="text-align:center;"><?php echo $DCRId; ?>.</td>
				<td style="text-align:left;"><?php echo $DCRDate; ?></td>
				<td style="text-align:left;"><?php echo $Name; ?></td>
				<td style="text-align:left;"><?php echo $DCRRemarks; ?></td>
                 
                <td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/edit_form_dcr/<?php echo $DCRId; ?>"><span class="ui-icon ui-icon-pencil"></span></a></td>
                 
            <!--<td align="center"><a href="<?php //echo base_url(); ?>index.php/dashboard/delete_dcr/<?php //echo $DCRId; ?>" onclick="return confirmDelete()"><span class="ui-icon ui-icon-trash"></span></a></td>-->
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