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
//session_start();
//echo $_SESSION['RightToAdd_51'];

$righttoadd="";
$righttoedit="";
$righttodelete="";

if(isset($_SESSION['RightToAdd_51'])) {
    $righttoadd = $_SESSION['RightToAdd_51'];
}
if(isset($_SESSION['RightToEdit_51'])) {
   $righttoedit = $_SESSION['RightToEdit_51'];
}
if(isset($_SESSION['RightToDelete_51'])) {
    $righttodelete = $_SESSION['RightToDelete_51'];
}

//echo "righttoadd : $righttoadd";
//$my_session_variable = $this->session->all_userdata();
//echo $my_session_variable['RightToAdd_51'];

?>

<div class="table_wrap">
    <h2 align="center">Website Logos</h2>
    <?php if($righttoadd=='1'){ ?>     
    <div style="width:100%; height:25px; border:0px solid #FF0000;">
        <div align="right" style="float:left; width:97%; height:25px; border:0px solid #000000;">
            <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/add_form_website_logo_master"><img src="<?php echo base_url(); ?>images/addnew.jpg" title="Add New" width="20" height="20" /></a>
        </div>
    </div> 
    <?php } ?>
    
    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
				<th>SNo.</th>
                <th>Website Logo</th>
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
                $i=1; 
				foreach($query->result_array() as $row): 
				    
					$WebsiteLogoId = trim($row['iWebsiteLogoId']);
					$WebsiteLogoName = trim($row['cWebsiteLogoFileName']);
                    $WebsiteLogoPath = trim($row['cWebsiteLogoFilePath']);
					$Active = trim($row['bActive']);
			?>
            
            <tr class="gradeA">
                <td style="text-align:center;"><?php echo $i; ?></td>
                <td style="text-align:center;"><img src="<?php echo base_url(); ?>/uploads/website_logos/<?php echo $WebsiteLogoName; ?>" 
                height="50" width="80"  />
                </td>
                <td style="text-align:center;"><?php echo $Active; ?></td>
                
                <?php if($righttoedit=='1'){ ?> 
                <td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/edit_form_website_logo_master/<?php echo $WebsiteLogoId; ?>"><span class="ui-icon ui-icon-pencil"></span></a></td>
                 <?php } ?>
                 
                 <?php if($righttodelete=='1'){ ?>
                <td align="center"><a href="<?php echo base_url(); ?>index.php/dashboard/delete_website_logo_master/<?php echo $WebsiteLogoId; ?>" onclick="return confirmDelete()"><span class="ui-icon ui-icon-trash"></span></a></td>
                <?php } ?>
            </tr>            
            
            <?php
                $i++; 
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