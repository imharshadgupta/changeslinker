<!--==============================Form=================================-->

<form name="addForm" id="addForm" method="post" action="" enctype="multipart/form-data">
<div class="inner_form">
<h2>Add Details</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>General Details</legend>

<div class="Txtblks">Date</div>
<div class="fldblks"><input type="text" name="txtDate" id="txtDate" value="<?php echo set_value('txtDate'); ?>" tabindex="1" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Client</div>
<div class="fldblks">
	<select name="cmbClientReq" id="cmbClientReq" class="chzn-select fild"  tabindex="2">
		<option value="">Select Client</option>
		<?php 
			$sql = $this->db->query("SELECT requirement_master.iClientId,client_master.cClientName FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId WHERE requirement_master.iClientId<>0 AND requirement_master.bActive=1 AND requirement_master.bDelete=0 GROUP BY requirement_master.iClientId ORDER BY client_master.cClientName");  
			
			if($sql)
			{
				if(($sql->num_rows) > 0)
				{
					$rows = $sql->result_array();
					
					foreach($rows as $row): 
					
					$Client_Id = trim($row['iClientId']);
					$Client_Name = trim($row['cClientName']);
				?>
					<option value="<?php echo $Client_Id; ?>"><?php echo $Client_Name; ?></option>
				<?php
					endforeach;	
				}
			}
		?>
		</select>
	</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Requirement</div>
<div class="fldblks">
	<select name="cmbRequirement" id="cmbRequirement" class="chzn-select fild" tabindex="3">
	<option value="">Select Requirement</option>
        <?php
foreach ($allrequirement as $key => $row):

    ?>
                            <option value="<?php echo $key; ?>"><?php echo $row; ?></option>
                            <?php
                        endforeach;
                        ?>
	</select>
</div>


<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>					
				
<div class="Txtblks">Property</div>
<div class="fldblks">
	<select name="cmbProperty" id="cmbProperty" class="fild chzn-select" tabindex="5">
	<option value="">Select Property</option>
        <?php
foreach ($allproperty as $key => $row):
    ?>
                            <option value="<?php echo $key; ?>"><?php echo $row; ?></option>
    <?php
endforeach;
?>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Deal Lost Reason</div>
<div class="fldblks"><textarea name="txtDealSummaryLostReason" id="txtDealSummaryLostReason" class="fild" tabindex="6"><?php echo set_value('txtDealSummaryLostReason'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Follow Up Date</div>
<div class="fldblks"><input type="text" name="txtFollowUpDate" id="txtFollowUpDate" value="<?php echo set_value('FollowUpDate'); ?>" tabindex="7" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<!--
<div class="Txtblks">Active</div>
<div class="fldblks"><input type="checkbox" name="chkActive" id="chkActive" value="1" <?php //echo set_checkbox('chkActive', '1', TRUE); ?> /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>
-->

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<!------------------------------------------------------------------------------------------------------------------------------------------------------------>

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this);" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_deal_lost"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

<div class="clear"></div>
</div>
	<div class="clear"></div>
</div>

<script type="text/javascript" language="javascript"> 
$(".chzn-select").chosen(); 
$(".chzn-select-deselect").chosen({allow_single_deselect:true}); 
</script>
</form>

<script type="text/javascript">  
$(document).ready(function(){ 
	$("#txtDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});	
	
	$("#txtFollowUpDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});
});
</script>

<script type="text/javascript" language="javascript">
function getRequirementByClient()
{	
	var cmbClientReq = $("#cmbClientReq").val();
	
	if(cmbClientReq!='')
	{	
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url(); ?>index.php/dashboard/getrequirementbyclient",
			data: "cmbClient="+cmbClientReq,
			success: function(details){
				
				$('#cmbRequirement').children('option:not(:first)').remove();
				
				$.each(details,function(reqid,reqname) {
				    var opt = $('<option />'); 									
					opt.val(reqid);
					opt.text(reqname);
					$('#cmbRequirement').append(opt); 			  
				});
				
				$('#cmbRequirement').trigger("liszt:updated");	
			}
		});
	}
	else
	{
		$('#cmbRequirement').val('');
	}
}
</script>

<script type="text/javascript" language="javascript">
function getPropertyByClient()
{	
	var cmbClientProp = $("#cmbClientProp").val(); 
	
	if(cmbClientProp!='')
	{
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url(); ?>index.php/dashboard/getpropertybyclient",
			data: "cmbClient="+cmbClientProp,
			success: function(details){
				//alert(details);
			    $('#cmbProperty').children('option:not(:first)').remove();
				
				$.each(details,function(propid,propname) {
				    var opt = $('<option />'); 									
					opt.val(propid);
					opt.text(propname);
					$('#cmbProperty').append(opt);			  
				});
				
				$('#cmbProperty').trigger("liszt:updated");
			}
		});
	}
	else
	{
		$('#cmbProperty').val('');
	}
}
</script>

<script type="text/javascript" language="javascript">
function FormValidate(btn)
{
    
    if($("#cmbProperty").val()=='')
    {	
        alert("Please select Property");
        $("#cmbProperty").focus();
        return false;
    }
    
    else
    {
        
		var data = $("#addForm").serialize();
		
		var url = "<?php echo base_url(); ?>/index.php/dashboard/add_deal_lost";

		btn.disabled = true;
		btn.value = 'Submitting...';
	
		$.post(url,data,function(data){	
		  
		    if(data)
			{
				if(data.status == 1)
				{					
					btn.disabled = false;
					btn.value = 'Submit';
					alert(data.msg);
					var redirecturl = "<?php echo base_url(); ?>/index.php/dashboard/listing_deal_lost";
					$(location).attr('href',redirecturl);	
				}	
				else
				{
					btn.disabled = false;
					btn.value = 'Submit';
					alert(data.msg);
				} 
			}
		},'json');
    }
}
</script>