<script type="text/javascript" language="javascript">
$(document).ready(function() {
	var oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"aaSorting":[[4, "asc"]],
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
    <h2 align="center">Success Stories</h2>
       
    <div style="width:100%; height:25px; border:0px solid #FF0000;">
        <div align="right" style="float:left; width:97%; height:25px; border:0px solid #000000;">
            <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/add_form_success_story"><img src="<?php echo base_url(); ?>images/addnew.jpg" title="Add New" width="20" height="20" /></a>
        </div>
    </div> 
    
    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
				<th>Property Name</th>
				<th>Lessor Name</th>
				<th>Lessee Name</th>
				<th>Content</th>
				<th>Active</th>
				
                <th>EDIT</th>   
            <!--<th>DELETE</th>-->
            </tr>
            </thead>
            <tbody>
                
            <?php 
				foreach($query->result_array() as $row): 
				
					$SuccessStoryId = trim($row['iSuccessStoryId']);
					$PropertyName = trim($row['cPropertyName']);
					$LessorName = trim($row['cLessorName']);
					$LesseeName = trim($row['cLesseeName']);
					$Content = trim($row['cContent']);
					$Active = trim($row['bActive']);
			?>
            
            <tr class="gradeA">
                <td style="text-align:left;"><?php echo $PropertyName; ?></td>
				<td style="text-align:left;"><?php echo $LessorName; ?></td>
				<td style="text-align:left;"><?php echo $LesseeName; ?></td>
				<td style="text-align:left;"><?php echo $Content; ?></td>
                <td style="text-align:center;"><?php echo $Active; ?></td>
                
                <td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/edit_form_success_story/<?php echo $SuccessStoryId; ?>"><span class="ui-icon ui-icon-pencil"></span></a></td>
                 
           <!--<td align="center"><a href="<?php //echo base_url(); ?>index.php/dashboard/delete_success_story/<?php //echo $SuccessStoryId; ?>" onclick="return confirmDelete()"><span class="ui-icon ui-icon-trash"></span></a></td>-->
            </tr>            
            
            <?php endforeach; ?>
            
            </tbody>
            </table>   
		</div>        
        <div style="height:2px;"></div>
    </div>
</div>        

<!-- ui-dialog -->
<div id="dialog"> </div>