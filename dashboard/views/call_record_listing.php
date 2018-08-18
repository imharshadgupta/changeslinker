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

<?php
//$righttoadd = trim($this->session->userdata('RightToAdd_18'));
//$righttoedit = trim($this->session->userdata('RightToEdit_18'));
//$righttodelete = trim($this->session->userdata('RightToDelete_18'));

$righttoadd = $_SESSION['RightToAdd_18'];
$righttoedit = $_SESSION['RightToEdit_18'];
$righttodelete = $_SESSION['RightToDelete_18'];

?>

<div class="table_wrap">
    <h2 align="center">Calls Record</h2>
    <?php if($righttoadd=='1'){ ?>     
    <div style="width:100%; height:25px; border:0px solid #FF0000;">
        <div align="right" style="float:left; width:97%; height:25px; border:0px solid #000000;">
            <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/add_form_call_record"><img src="<?php echo base_url(); ?>images/addnew.jpg" title="Add New" width="20" height="20" /></a>
        </div>
    </div> 
    <?php } ?>
    
    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
				<th>SNo.</th>
				<th>Caller Name</th>
				<th>Designation</th>
				<th>Call Date Time</th>
				<th>Call To Person</th>
				<th>Contact No.</th>
				<th>Summary</th>

				<?php if($righttoedit=='1'){ ?> 
                <th>EDIT</th>
                <?php } ?>
                <?php if($righttodelete=='1'){ ?>
                <th>DELETE</th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
                
            <?php 
				$SNo=1;
				foreach($query->result_array() as $row): 
				
					$CallRecordId = trim($row['iCallRecordId']);
					$CallerName = trim($row['cName']);
					$CallerDesignation = trim($row['cDesignation']);
					$getCallDateTime = trim($row['dCallDateTime']);
					$CallDateTime = date('d/m/Y h:i:s a', strtotime($getCallDateTime));
					
					$CallTypeName = trim($row['cCallTypeName']);
					$ContactNo = trim($row['cContactNo']);
					$PersonName = trim($row['cPersonName']);
					$PropertyName = trim($row['cPropertyName']);
					$CallSummary = trim($row['cCallSummary']);
					$NextCallDateTime = trim($row['dNextCallDateTime']);
			?>
            
            <tr class="gradeA">
                <td style="text-align:center;"><?php echo $SNo; ?>.</td>
				<td style="text-align:left;"><?php echo $CallerName; ?></td>
				<td style="text-align:left;"><?php echo $CallerDesignation; ?></td>
				<td style="text-align:left;"><?php echo $CallDateTime; ?></td>
                <td style="text-align:left;"><?php echo $PersonName; ?></td>
				<td style="text-align:left;"><?php echo $ContactNo; ?></td>
				<td style="text-align:left;"><?php echo $CallSummary; ?></td>
                
                <?php if($righttoedit=='1'){ ?> 
                <td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/edit_form_call_record/<?php echo $CallRecordId; ?>"><span class="ui-icon ui-icon-pencil"></span></a></td>
                 <?php } ?>
                 
                 <?php if($righttodelete=='1'){ ?>
                <td align="center"><a href="<?php echo base_url(); ?>index.php/dashboard/delete_call_record/<?php echo $CallRecordId; ?>" onclick="return confirmDelete()"><span class="ui-icon ui-icon-trash"></span></a></td>
                <?php } ?>
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