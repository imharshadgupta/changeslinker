<script type="text/javascript" language="javascript">
$(document).ready(function() {
	var oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"iDisplayLength":50,
		"aaSorting":[],
		"bSort":false,
		"sPaginationType": "full_numbers"
	});
});
//	"aaSorting":[[0, "desc"]],
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

//$righttoadd = trim($this->session->userdata('RightToAdd_11'));
//$righttoedit = trim($this->session->userdata('RightToEdit_11'));
//$righttodelete = trim($this->session->userdata('RightToDelete_11'));

$righttoadd = $_SESSION['RightToAdd_11'];
$righttoedit = $_SESSION['RightToEdit_11'];
$righttodelete = $_SESSION['RightToDelete_11'];

$varbase_url = base_url();
?>

<div class="table_wrap">
    <h2 align="center">Clients</h2>
    <?php if($righttoadd=='1'){ ?>     
    <div style="width:100%; height:25px; border:0px solid #FF0000;">
        <div align="right" style="float:left; width:97%; height:25px; border:0px solid #000000;">
            <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/add_form_client_master"><img src="<?php echo base_url(); ?>images/addnew.jpg" title="Add New" width="20" height="20" /></a>
        </div>
    </div> 
    <?php } ?>
    
    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
            <thead>
            <tr>
				<th>SNo.</th>
				<th>Client <br />Name</th>
				<th>Phone <br />No.</th>
				<th>Active</th>
			  <th>Task</th>
			  <th>Curr.<br />Status</th>
<!--			  <th>Insp<br />ection</th>
			  <th>Deli<br />
very</th>-->
				<th>RF</th>
				<th>PSR</th>
				<th>VI<br />EW</th>
				<?php if($righttoedit=='1'){ ?> 
                <th>ED<br />IT</th>
                <?php } ?>
				<?php /* if($righttodelete=='1'){ ?>
                <!--<th>DELETE</th>-->
                <?php }*/ ?>
				<th>HIS<br />TORY</th>
            </tr>
            </thead>
            <tbody>
                
            <?php 
				$SNo=1;
				foreach($query->result_array() as $row): 
				
					$ClientId = trim($row['iClientId']);	
					$ClientName = html_entity_decode($row['cClientName']);	
					$Active = trim($row['bActive']);
					$phone = trim($row['ph1']);
					if(trim($row['ph12']))
					{
						$phone = $phone."<br />,".trim($row['ph12']);
					}
					if(trim($row['ph2']))
					{
						$phone = $phone."<br />,".trim($row['ph2']);
					}
					if(trim($row['ph22']))
					{
						$phone = $phone."<br />,".trim($row['ph22']);
					}
					if(trim($row['ph3']))
					{
						$phone = $phone."<br>,".trim($row['ph3']);
					}
					if(trim($row['ph32']))
					{
						$phone = $phone."<br />,".trim($row['ph32']);
					}
					if(trim($row['ph4']))
					{
						$phone = $phone."<br />,".trim($row['ph4']);
					}
					if(trim($row['ph42']))
					{
						$phone = $phone."<br>,".trim($row['ph42']);
					}
					if(trim($row['ph5']))
					{
						$phone = $phone."<br />,".trim($row['ph5']);
					}
					if(trim($row['ph52']))
					{
						$phone = $phone."<br />,".trim($row['ph52']);
					}
					if(trim($row['ph6']))
					{
						$phone = $phone."<br>,".trim($row['ph6']);
					}
					if(trim($row['ph62']))
					{
						$phone = $phone."<br />,".trim($row['ph62']);
					}
					if(trim($row['ph7']))
					{
						$phone = $phone."<br />,".trim($row['ph7']);
					}
					if(trim($row['ph72']))
					{
						$phone = $phone."<br>,".trim($row['ph72']);
					}
					if(trim($row['ph8']))
					{
						$phone = $phone."<br />,".trim($row['ph8']);
					}
					if(trim($row['ph82']))
					{
						$phone = $phone."<br />,".trim($row['ph82']);
					}	
					if(trim($row['ph9']))
					{
						$phone = $phone."<br>,".trim($row['ph9']);
					}
					if(trim($row['ph92']))
					{
						$phone = $phone."<br />,".trim($row['ph92']);
					}if(trim($row['ph10']))
					{
						$phone = $phone."<br />,".trim($row['ph10']);
					}
					if(trim($row['ph102']))
					{
						$phone = $phone."<br />,".trim($row['ph102']);
					}
			?>
            
            <tr class="gradeA">
                <td style="text-align:center;"><?php echo $SNo; ?>.<br />&nbsp;</td>
				<td style="text-align:left;"><?php echo $ClientName; ?></td>
                <td style="text-align:left;"><?php echo $phone; ?></td>
                <td style="text-align:center;"><?php echo $Active; ?></td>
                
				<td>
				<a  class="iframe" href="<?php echo base_url(); ?>index.php/dashboard/add_form_dcr_single/0/popup"  >+</a>
</td>
				<td style="text-align:center;"><?= $row['totdcrrf'] ?></td>
				
<!--				<td style="text-align:center;"><?= $row['tot_inspections'] ?></td>

				<td style="text-align:center;"><?= $row['tot_dealdone'] ?></td>-->
				
				<td style="text-align:center;"><a href="<?php echo $varbase_url; ?>index.php/dashboard/listing_requirement_master/<?php echo $ClientId; ?>"><?= $row['totrf'] ?></a></td>
				
				<td style="text-align:center;"><a href="<?php echo $varbase_url; ?>index.php/dashboard/listing_property_master/<?php echo $ClientId; ?>"><?= $row['totprc'] ?></a></td>
				
				
				<td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo $varbase_url; ?>index.php/dashboard/viewclient/<?php echo $ClientId; ?>" target="_blank"><span class="ui-icon ui-icon-search"></span></a></td>
				
                <?php if($righttoedit=='1'){ ?> 
                <td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo $varbase_url; ?>index.php/dashboard/edit_form_client_master/<?php echo $ClientId; ?>" target="_blank"><span class="ui-icon ui-icon-pencil"></span></a></td>
                 <?php 
} ?>
                 
                <?php /*if($righttodelete=='1'){ ?>
                <!--<td align="center"><a href="<?php //echo base_url(); ?>index.php/dashboard/delete_client_master/<?php // echo $ClientId; ?>" onclick="return confirmDelete()"><span class="ui-icon ui-icon-trash"></span></a></td>-->
                <?php }*/ ?>
				
				<td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo $varbase_url; ?>index.php/dashboard/clienthistory/<?php echo $ClientId; ?>" target="_blank" title="Print History"><span class="ui-icon ui-icon-print"></span></a></td>
		   </tr>            
			
            <?php
					$SNo++;
				endforeach; 
			?>
            </tbody>
            </table>   
		</div>        
    </div>
</div>        
<script>
function fn_close_popup(){
	//document.getElementById('dialog2').style.display='none';
	jQuery('#dialog2').bPopup().close();
}
</script>
<script>
(function($){
	$(function(){
		$('.iframe').bind('click', function(e){
		e.preventDefault();
//		alert(1);
		t = this;
		$('#dialog2').bPopup({content:'iframe'
		, loadUrl: t.href
		,follow: [false, false] 
		,onOpen(){
//			alert('Press ESC Key to Close Window')
		}
		} );
		});
	});



})(jQuery);

//x = jQuery(window).height()-40;
//y = jQuery(window).width()-40;

x = 700;
y = 990;
document.write('<style>.b-iframe{ width:'+y+'px; height:'+x+'px;}</style>')
</script>
<!-- ui-dialog -->
<div id="dialog" > </div>
<div id="dialog2" style="top:20px; width:990px; overflow:auto" align="center" > </div>