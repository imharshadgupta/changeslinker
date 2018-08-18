<script type="text/javascript" language="javascript">
$(document).ready(function() {
	var oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"aaSorting":[[2, "desc"]],
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
//$righttoadd = trim($this->session->userdata('RightToAdd_29'));
//$righttoedit = trim($this->session->userdata('RightToEdit_29'));
//$righttodelete = trim($this->session->userdata('RightToDelete_29'));


$righttoadd = $_SESSION['RightToAdd_29'];
$righttoedit = $_SESSION['RightToEdit_29'];
$righttodelete = $_SESSION['RightToDelete_29'];
?>

<div class="table_wrap">
    <h2 align="center">Source</h2>
    <?php if($righttoadd=='1'){ ?>     
    <div style="width:100%; height:25px; border:0px solid #FF0000;">
        <div align="right" style="float:left; width:97%; height:25px; border:0px solid #000000;">
            <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/add_form_source_master"><img src="<?php echo base_url(); ?>images/addnew.jpg" title="Add New" width="20" height="20" /></a>
        </div>
    </div> 
    <?php } ?>
    
    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
				<th>SNo.</th>
				<th>Source Name</th>
				<th>Active</th>
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
				
					$SourceId = trim($row['iSourceId']);
					$SourceName = trim($row['cSourceName']);
					$Active = trim($row['bActive']);
			?>
            
            <tr class="gradeA">
                <td style="text-align:center;"><?php echo $SNo; ?>.</td>
				<td style="text-align:left;"><?php echo $SourceName; ?></td>
                <td style="text-align:center;"><?php echo $Active; ?></td>
                
                <?php if($righttoedit=='1'){ ?> 
                <td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/edit_form_source_master/<?php echo $SourceId; ?>"><span class="ui-icon ui-icon-pencil"></span></a></td>
                 <?php } ?>
                 
                 <?php if($righttodelete=='1'){ ?>
                <td align="center"><a href="<?php echo base_url(); ?>index.php/dashboard/delete_source_master/<?php echo $SourceId; ?>" onclick="return confirmDelete()"><span class="ui-icon ui-icon-trash"></span></a></td>
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