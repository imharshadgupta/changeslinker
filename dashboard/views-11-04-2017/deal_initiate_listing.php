<script type="text/javascript" language="javascript">
$(document).ready(function() {
	var oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"aaSorting":[[0, "desc"]],
		"sPaginationType": "full_numbers",
                "aLengthMenu": [[20, 50, 100], [20, 50, 100]],
                "iDisplayLength": 20,

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

<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<?php echo base_url();?>js/jquery-ui.js"></script>
  
  
  <div id="dialogid" style="display: none;"> <span style="float:right;margin-top: 90px; cursor: pointer;" id="closeids">Close</span>
      <p><strong>Please contact.</strong></p><p> Ph. 0731-4044406, Cell: 8349998444</p>
  </div>-->
 


<div class="table_wrap">
    <h2 align="center">Done Deals</h2>
         
    <div style="width:100%; height:25px; border:0px solid #FF0000;">
        <div align="right" style="float:left; width:97%; height:25px; border:0px solid #000000;">
            <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/add_form_deal_initiate"><img src="<?php echo base_url(); ?>images/addnew.jpg" title="Add New" width="20" height="20" /></a>
        </div>
    </div> 
   
    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
<!--				<th>SNo.</th>-->
				<th>Initiate Date</th>
				<th>Property Name</th> 
                <th>EDIT</th>                
            <!--<th>DELETE</th>-->
            </tr>
            </thead>
            <tbody>
                
            <?php 
				$SNo=1;
				foreach($query->result_array() as $row): 
				
					$DealInitiateId = trim($row['iDealInitiateId']);
					
					$getdDealInitiateDate = trim($row['dDealInitiateDate']);
					$DealInitiateDate = date('d/m/Y', strtotime($getdDealInitiateDate));
					
					$PropertyName = trim($row['cPropertyName']);				
			?>
            
            <tr class="gradeA">
<!--                <td style="text-align:center;"><?php //echo $SNo; ?>.</td>-->
				<td style="text-align:center;"><?php echo $DealInitiateDate; ?></td>
				<td style="text-align:center;"><?php echo $PropertyName; ?></td>
                
                <td align="center">
                    <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/edit_form_deal_initiate/<?php echo $DealInitiateId; ?>"><span class="ui-icon ui-icon-pencil"></span></a>
<!--                    <span class="ui-icon ui-icon-pencil"></span>-->
                </td>
                                 
            <!--<td align="center"><a href="<?php //echo base_url(); ?>index.php/dashboard/delete_deal_initiate/<?php //echo $DealInitiateId; ?>" onclick="return confirmDelete()"><span class="ui-icon ui-icon-trash"></span></a></td>-->
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


<style type="text/css">
    tr.even.gradeA td.sorting_1 { background-color: #FFFFFF; }
    tr.odd.gradeA td.sorting_1 { background-color: #CCCCCC; }
    
    #dialogid .ui-dialog .ui-dialog-titlebar-close span { margin: -9px!important;}
    #dialogid .ui-dialog-titlebar-close { display: none!important;}
.ui-dialog-titlebar { display: none!important;}
    
</style>

<script>
  $( function() {
      
      $(".ui-icon-pencil1111111").click(function(){
          $( "#dialogid" ).dialog();
          $( "#dialogid" ).show();
                    $(".ui-dialog").show();
      })
      
      $("#closeids").click(function(){
                    $( "#dialogid" ).hide();
                    $(".ui-dialog").hide();

      })
      
    
    
  } );
  </script>