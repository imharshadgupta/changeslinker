<!--==============================Form=================================-->

<form name="addForm" id="addForm" method="post" action="" enctype="multipart/form-data">
<div class="inner_form">
<h2>Add Details</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>General Details</legend>

<div class="Txtblks">Initiate Date</div>
<div class="fldblks"><input type="text" name="txtInitiateDate" id="txtInitiateDate" class="fild" style="width:302px;" value="<?php echo set_value('txtInitiateDate'); ?>" readonly="readonly" tabindex="1" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Branch</div>
<div class="fldblks">
	<select name="cmbBranch" id="cmbBranch" class="fild" tabindex="2">
	<option value="">Select Branch</option>
	<?php 
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('branch_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Branch_Id = trim($row['iBranchId']);
				$Branch_Name = trim($row['cBranchName']);
			?>
				<option value="<?php echo $Branch_Id; ?>"><?php echo $Branch_Name; ?></option>
			<?php
				endforeach;	
			}
		}
	?>
	<select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Client Req</div>
<div class="fldblks">
	<select name="cmbClientReq" id="cmbClientReq" class="chzn-select fild" onchange="getRequirementByClient();" tabindex="3">
		<option value="">Select Client</option>
		<?php 
			$this->db->order_by("cClientName", "asc");
			$this->db->where('bActive', 1);
			$this->db->where('bDelete', 0);
			$sql =  $this->db->get('client_master');  
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
	<select name="cmbRequirement" id="cmbRequirement" class="chzn-select fild" tabindex="4">
	<option value="">Select Requirement</option>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>		

<div class="Txtblks">Client Prop</div>
<div class="fldblks">
	<select name="cmbClientProp" id="cmbClientProp" class="chzn-select fild" onchange="getPropertyByClient();" tabindex="5">
	<option value="">Select Client</option>
	<?php
		$this->db->order_by("cClientName", "asc");
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('client_master');  
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
				
<div class="Txtblks">Property</div>
<div class="fldblks">
	<select name="cmbProperty" id="cmbProperty" class="fild chzn-select" tabindex="6">
	<option value="">Select Property</option>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Lease Start Date</div>
<div class="fldblks"><input type="text" name="txtLeaseStartDate" id="txtLeaseStartDate" class="fild" style="width:302px;" value="<?php echo set_value('txtLeaseStartDate'); ?>" readonly="readonly" tabindex="6" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Lease End Date</div>
<div class="fldblks"><input type="text" name="txtLeaseEndDate" id="txtLeaseEndDate" class="fild" style="width:302px;" value="<?php echo set_value('txtLeaseEndDate'); ?>" readonly="readonly" tabindex="7" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Lease Renewal Reminder Date</div>
<div class="fldblks"><input type="text" name="txtLeaseRenewalReminderDate" id="txtLeaseRenewalReminderDate" class="fild" style="width:302px;" value="<?php echo set_value('txtLeaseRenewalReminderDate'); ?>" readonly="readonly" tabindex="8" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Reminder for Renewal</div>
<div class="fldblks"><input type="text" name="txtReminderForRenewal" id="txtReminderForRenewal" class="fild" value="<?php echo set_value('txtReminderForRenewal'); ?>" tabindex="9" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Paste Terms & Conditions</div>
<div class="fldblks"><textarea name="txtTermsAndConditions" id="txtTermsAndConditions" class="fild" tabindex="10"><?php echo set_value('txtTermsAndConditions'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Possession Date</div>
<div class="fldblks"><input type="text" name="txtPossessionDate" id="txtPossessionDate" class="fild" style="width:302px;" value="<?php echo set_value('txtPossessionDate'); ?>" readonly="readonly" tabindex="11" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Possession Done</div>
<div class="fldblks">
<select name="cmbPossessionDone" id="cmbPossessionDone" class="fild" tabindex="12">
<option value="">Select Possession Done</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
<select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Payment Date</div>
<div class="fldblks"><input type="text" name="txtPaymentDate" id="txtPaymentDate" class="fild" style="width:302px;" value="<?php echo set_value('txtPaymentDate'); ?>" readonly="readonly" tabindex="13" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Payment Received Completely</div>
<div class="fldblks">
<select name="cmbPaymentReceivedCompletely" id="cmbPaymentReceivedCompletely" class="fild" tabindex="14">
<option value="">Select Payment Received Completely</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
<select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Tagline for Website</div>
<div class="fldblks"><input type="text" name="txtTaglineForWebsite" id="txtTaglineForWebsite" class="fild" value="<?php echo set_value('txtTaglineForWebsite'); ?>" tabindex="15" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Deal Done Date</div>
<div class="fldblks"><input type="text" name="txtDealDoneDate" id="txtDealDoneDate" class="fild" style="width:302px;" value="<?php echo set_value('txtDealDoneDate'); ?>" readonly="readonly" tabindex="16" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Active</div>
<div class="fldblks"><input type="checkbox" name="chkActive" id="chkActive" value="1" <?php echo set_checkbox('chkActive', '1', TRUE); ?> /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<fieldset>
	<legend>Upload Attachments</legend>
    
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks"><input type='button' value='Add New' id='addButton'>&nbsp;<input type='button' value='Cancel' id='removeButton'></div>
    <div class="clear"></div>
    
    <div id='TextBoxesGroup'>
        <div id="TextBoxDiv1">
        	<div class="Txtblks">
	        	<label>Attach 1 : </label>
            </div>
            <div class="fldblks">
				<input type="hidden" name="hfAttachmentPath[]" id="hfAttachment1Path" value="" />
				<input type="hidden" name="hfAttachmentName[]" id="hfAttachment1Name"  value="" />
            	<input type="file" name="txtAttachment1" id="txtAttachment1" class="fild" tabindex="14" />
            </div>
            <div class="Txtblks">
	        	<label>Title 1 :  </label>
            </div>
            <div class="fldblks">
            	<input type="textbox" name="txtAttachmentTitle[]" id="txtAttachmentTitle1" class="fild" style="width:200px;" tabindex="69" />&nbsp;<input type="button" name="btnUploadAttachment1" id="btnUploadAttachment1" value="Upload 1" onclick="UploadAttachment('1');" />
            </div>
            <div class="clear"></div>
			
			<div class="Txtblks">&nbsp;</div>
			<div class="fldblks">&nbsp;</div>
			<div class="Txtblks">&nbsp;</div>
			<div class="fldblks" id="dvAttachment1File" style="display:none; font-size:10px; text-align:left; border:0px solid blue;">
				<div style="font-size:12px; font-weight:bold; float:left; width:25%; border:0px solid red; ">Uploaded 1 :</div>
				<div id="dvAttachment1Name" style="font-size:12px; float:left; width:60%; border:0px solid red;"> </div>
				<div style="float:left; width:15%; border:0px solid red;"><a href="#" onclick="DeleteAttachment('1');"><img src="<?php echo base_url(); ?>images/remove.png" align="center" height="18" width="18" /></a></div>
			</div>
			<div class="clear"></div>

        </div>
    </div>
	
	<div class="Txtblks">&nbsp;</div>
	<div class="fldblks"><!--<input type="button" name="btnUploadAttachment" id="btnUploadAttachment" value="Upload" onclick="UploadAttach();" />--></div>
	<div class="Txtblks">&nbsp;</div>
	<div class="fldblks">&nbsp;</div>
	<div class="clear"></div>

</fieldset>

<!------------------------------------------------------------------------------------------------------------------------------------------------------------>

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this);" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_deal_initiate"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

<div class="clear"></div>
</div>
	<div class="clear"></div>
</div>

<script type="text/javascript" language="javascript"> 
$(".chzn-select").chosen(); 
$(".chzn-select-deselect").chosen({allow_single_deselect:true}); 
</script>
</form>

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

<script type="text/javascript">  
$(document).ready(function(){ 
	$("#txtInitiateDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});	
	$("#txtLeaseStartDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});	
	$("#txtLeaseEndDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});	
	$("#txtLeaseRenewalReminderDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});	
	$("#txtPossessionDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});	
	$("#txtPaymentDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});	
	
	$("#txtDealDoneDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});	
	
  /*$('#txtLeasePartyLessee').autocomplete({
		source:"<?php echo base_url();?>index.php/dashboard/suggestparties", 
		minLength:1,
	  /*select: function(event, ui) {
			var party_id = ui.item.value;
			getPropertyByPropertyOwnerId(party_id);
        }*
	});
	
	$('#txtProperty').autocomplete({
		source:"<?php echo base_url();?>index.php/dashboard/suggestproperties", 
		minLength:1,
	  /*select: function(event, ui) {
			var party_id = ui.item.value;
			getPropertyByPropertyOwnerId(party_id);
        }*
	});*/

	var counter = 2;
  
	$("#addButton").click(function () {
  
	  /*if(counter>10){
			alert("Only 10 doc fields are allowed");
			return false;
		}*/   
	  
        var newTextBoxDiv = $(document.createElement('div')).attr("id", 'TextBoxDiv'+counter); 
	   
	    newTextBoxDiv.after().html('<div class="Txtblks"><label>Attach '+counter+' : </label></div>'+ '<div class="fldblks"><input type="hidden" name="hfAttachmentPath[]" id="hfAttachment'+counter+'Path" /><input type="hidden" name="hfAttachmentName[]" id="hfAttachment'+counter+'Name" /><input type="file" name="txtAttachment'+counter+'" id="txtAttachment'+counter+'" class="fild" value="" /></div><div class="Txtblks"><label>Title '+counter+ ' : </label></div><div class="fldblks"><input type="text" name="txtTitleAttachment'+counter+'" id="txtTitleAttachment'+counter+'" class="fild" style="width:200px;" value="" />&nbsp;<input type="button" name="btnUploadAttachment'+counter+'" id="btnUploadAttachment'+counter+'" value="Upload '+counter+'" onclick="UploadAttachment('+counter+')" /></div><div class="clear"></div><div class="Txtblks">&nbsp;</div><div class="fldblks">&nbsp;</div><div class="Txtblks">&nbsp;</div><div class="fldblks" id="dvAttachment'+counter+'File" style="display:none; font-size:10px; text-align:left; border:0px solid blue;"><div style="font-size:12px; font-weight:bold; float:left; width:25%; border:0px solid red; ">Uploaded '+counter+' :</div><div id="dvAttachment'+counter+'Name" style="font-size:12px; float:left; width:60%; border:0px solid red;"> </div><div style="float:left; width:15%; border:0px solid red;"><a href="#" onclick="DeleteAttachment('+counter+');"><img src="<?php echo base_url(); ?>images/remove.png" align="center" height="18" width="18" /></a></div></div><div class="clear"></div>');
	  
	    newTextBoxDiv.appendTo("#TextBoxesGroup");
    	
		counter++;
     });
  
	$("#removeButton").click(function () {

		if(counter==2){
		  alert("No more attachment fields to remove");
		  return false;
		}   
	
		counter--;
		
		$("#TextBoxDiv"+counter).remove();
	});	
});
</script>

<script type="text/javascript" language="javascript">
function UploadAttachment(attachno) 
{
   $("#btnUploadAttachment"+attachno).val("uploading...");
	
    $.ajaxFileUpload({
		url 			: "<?php echo site_url(); ?>/dashboard/upload_deal_attachment/"+attachno, 
		secureuri		: false,
		fileElementId	: 'txtAttachment'+attachno,
		dataType		: 'json',
		success	: function (data, status)
		{
			if(data.status != 'error')
			{
			   $("#hfAttachment"+attachno+"Path").val(data.attachment_file_path);
			   $("#hfAttachment"+attachno+"Name").val(data.attachment_file_name);
			   $("#dvAttachment"+attachno+"Name").html('('+data.attachment_file_name+')');
			   $("#dvAttachment"+attachno+"File").css("display", "block");
			   $("#txtAttachment"+attachno).disabled = true;
			   $("#btnUploadAttachment"+attachno).val("Upload"+attachno);
			   alert(data.msg);
			}
		}
	});
}
</script>

<script type="text/javascript">
function DeleteAttachment(attachno)
{
	var confdel = confirm("Are you sure to delete this document...?")
	
	if(confdel)
	{ 	
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/dashboard/delete_uploaded_deal_attachment",
			data: "AttachmentName="+$("#hfAttachment"+attachno+"Name").val()+"&AttachmentPath="+$("#hfAttachment"+attachno+"Path").val(),
			success: function(data){
			
			    if(data=='TRUE')
				{
				 //alert("Attachment deleted successfully.");					 
				   $("#hfAttachment"+attachno+"Path").val('');
				   $("#hfAttachment"+attachno+"Name").val('');
				   $("#dvAttachment"+attachno+"Name").html('');
				   $("#dvAttachment"+attachno+"File").css("display", "none");
				   $("#txtAttachment"+attachno).disabled=false;
				   $("#txtAttachment"+attachno).focus();
				}
				else
				{
					alert("Error in deleting doc.");
					return false;
				}
			}
		});
	}
}
</script>

<script type="text/javascript" language="javascript">
function getPropertyOwnerByPropertyId()
{
	$('#cmbPartyLessor').children('option:not(:first)').remove();
		
	if($("#Property").val()=='')
	{	
		alert("Please Select Property");
		$("#cmbProperty").focus();
		return false;
	}
	else
	{
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url();?>index.php/dashboard/getpropertyownerbyproperty",
			data: "cmbProperty="+$("#cmbProperty").val(),
			success: function(details){
				
				$('#cmbPartyLessor').children('option:not(:first)').remove();
				
				$.each(details,function(lesserid,lessername) {	 
				
					var opt = $('<option />'); 									
					opt.val(lesserid);
					opt.text(lessername);
					$('#cmbPartyLessor').append(opt); 		    			
				});
			}
		});
	}
}	
</script>

<script type="text/javascript" language="javascript">
function FormValidate(btn)
{
    if($("#txtInspectionDate").val()=='')
    {	
        alert("Please select Inspection Date");
        $("#txtInspectionDate").focus();
        return false;
    }
    else
    {
		var data = $("#addForm").serialize();
		
		var url = "<?php echo base_url(); ?>/index.php/dashboard/add_deal_initiate";

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
					var redirecturl = "<?php echo base_url(); ?>/index.php/dashboard/listing_deal_initiate";
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