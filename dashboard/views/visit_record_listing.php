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
//$righttoadd = trim($this->session->userdata('RightToAdd_19'));
//$righttoedit = trim($this->session->userdata('RightToEdit_19'));
//$righttodelete = trim($this->session->userdata('RightToDelete_19'));

$righttoadd = $_SESSION['RightToAdd_19'];
$righttoedit = $_SESSION['RightToEdit_19'];
$righttodelete = $_SESSION['RightToDelete_19'];

?>

<div class="table_wrap">
    <h2 align="center">Visits Record</h2>
    <?php if($righttoadd=='1'){ ?>     
    <div style="width:100%; height:25px; border:0px solid #FF0000;">
        <div align="right" style="float:left; width:97%; height:25px; border:0px solid #000000;">
            <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/add_form_visit_record"><img src="<?php echo base_url(); ?>images/addnew.jpg" title="Add New" width="20" height="20" /></a>
        </div>
    </div> 
    <?php } ?>
    
    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
				<th>SNo.</th>
				<th>Employee Name</th>
				<th>Designation</th>
				<th>Visit Date Time</th>
				<th>Visit with Person Name</th>
				<th>Property</th>
				<th>Visit Summary</th>
					
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
				
					$VisitRecordId = trim($row['iVisitRecordId']);
					$EmployeeName = trim($row['cName']);
					$EmployeeDesignation = trim($row['cDesignation']);
					
					$getVisitDateTime = trim($row['dVisitDateTime']);
					$VisitDateTime = date('d/m/Y h:i:s a', strtotime($getVisitDateTime));
					
					$PersonName = trim($row['cPersonName']);
					$PropertyName = trim($row['cPropertyName']);
					$VisitSummary = trim($row['cVisitSummary']);
					$NextVisitDateTime = trim($row['dNextVisitDateTime']);
			?>
            
            <tr class="gradeA">
                <td style="text-align:center;"><?php echo $SNo; ?>.</td>
				<td style="text-align:left;"><?php echo $EmployeeName; ?></td>
				<td style="text-align:left;"><?php echo $EmployeeDesignation; ?></td>
				<td style="text-align:left;"><?php echo $VisitDateTime; ?></td>
                <td style="text-align:left;"><?php echo $PersonName; ?></td>
				<td style="text-align:left;"><?php echo $PropertyName; ?></td>
				<td style="text-align:left;"><?php echo $VisitSummary; ?></td>
                
                <?php if($righttoedit=='1'){ ?> 
                <td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/edit_form_visit_record/<?php echo $VisitRecordId; ?>"><span class="ui-icon ui-icon-pencil"></span></a></td>
                 <?php } ?>
                 
                 <?php if($righttodelete=='1'){ ?>
                <td align="center"><a href="<?php echo base_url(); ?>index.php/dashboard/delete_visit_record/<?php echo $VisitRecordId; ?>" onclick="return confirmDelete()"><span class="ui-icon ui-icon-trash"></span></a></td>
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