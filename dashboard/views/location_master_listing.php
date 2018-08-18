<script type="text/javascript" language="javascript">
$(document).ready(function() {
	var oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"aaSorting":[[6, "desc"]],
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
//$righttoadd = trim($this->session->userdata('RightToAdd_10'));
//$righttoedit = trim($this->session->userdata('RightToEdit_10'));
//$righttodelete = trim($this->session->userdata('RightToDelete_10'));


$righttoadd = $_SESSION['RightToAdd_10'];
$righttoedit = $_SESSION['RightToEdit_10'];
$righttodelete = $_SESSION['RightToDelete_10'];
?>

<div class="table_wrap">
    <h2 align="center">Locations</h2>
    <?php if($righttoadd=='1'){ ?>     
    <div style="width:100%; height:25px; border:0px solid #FF0000;">
        <div align="right" style="float:left; width:97%; height:25px; border:0px solid #000000;">
            <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/add_form_location_master"><img src="<?php echo base_url(); ?>images/addnew.jpg" title="Add New" width="20" height="20" /></a>
        </div>
    </div> 
    <?php } ?>
    
    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
				<th>SNo.</th>
				<th>Location</th>
				<th>City</th>
				<th>District</th>
				<th>State</th>
				<th>Landmark</th>
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
				
					$LocationId = trim($row['iLocationId']);
					$LocationName = trim($row['cLocationName']);
					$CityName = trim($row['cCityName']);
					$DistrictName = trim($row['cDistrictName']);
					$StateName = trim($row['cStateName']);
					$StateAbbreviation = trim($row['cStateAbbreviation']);
					$Landmark = trim($row['cLandmark']);
					$Active = trim($row['bActive']);
			?>
            
            <tr class="gradeA">
                <td style="text-align:center;"><?php echo $SNo; ?>.</td>
				<td style="text-align:left;"><?php echo $LocationName; ?></td>
				<td style="text-align:left;"><?php echo $CityName; ?></td>
				<td style="text-align:left;"><?php echo $DistrictName; ?></td>
				<td style="text-align:left;"><?php echo $StateAbbreviation; ?></td>
				<td style="text-align:left;"><?php echo $Landmark; ?></td>
                <td style="text-align:center;"><?php echo $Active; ?></td>
                
                <?php if($righttoedit=='1'){ ?> 
                <td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/edit_form_location_master/<?php echo $LocationId; ?>"><span class="ui-icon ui-icon-pencil"></span></a></td>
                 <?php } ?>
                 
                 <?php if($righttodelete=='1'){ ?>
                <td align="center"><a href="<?php echo base_url(); ?>index.php/dashboard/delete_location_master/<?php echo $LocationId; ?>" onclick="return confirmDelete()"><span class="ui-icon ui-icon-trash"></span></a></td>
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