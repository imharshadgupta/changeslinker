<!--==============================Form=================================-->

<form name="editForm" id="editForm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="hfCallRecordId" id="hfCallRecordId" value="<?php echo set_value('hfCallRecordId',$CallRecordId); ?>"/>
<!--<input type="hidden" name="hfActive" id="hfActive" value="<?php //echo set_value('hfActive',$Active); ?>" />-->
<div class="inner_form">
<h2>Edit Details</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>General Details</legend>

<div class="Txtblks">Call Type</div>
<div class="fldblks">
	<select name="cmbCallType" id="cmbCallType" class="fild" tabindex="1">
	<option value="">Select Call Type</option>
	<?php 
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('call_type_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$CallType_Id = trim($row['iCallTypeId']);
				$CallType_Name = trim($row['cCallTypeName']);
			?>
				<option value="<?php echo $CallType_Id; ?>" <?php echo set_select("cmbCallType","$CallType_Id",($CallTypeId=="$CallType_Id" ? TRUE:'')); ?>><?php echo $CallType_Name; ?></option>
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

<div class="Txtblks">Contact No.</div>
<div class="fldblks"><input type="text" name="txtContactNo" id="txtContactNo" class="fild" value="<?php echo set_value('txtContactNo',$ContactNo); ?>" tabindex="2" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person Name</div>
<div class="fldblks"><input type="text" name="txtPersonName" id="txtPersonName" class="fild" value="<?php echo set_value('txtPersonName',$PersonName); ?>" tabindex="3" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property</div>
<div class="fldblks">
	<select name="cmbProperty" id="cmbProperty" class="fild" tabindex="4">
	<option value="">Select Property</option>
	<?php 
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('property_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Property_Id = trim($row['iPropertyId']);
				$Property_Name = trim($row['cPropertyName']);
			?>
				<option value="<?php echo $Property_Id; ?>" <?php echo set_select("cmbProperty","$Property_Id",($PropertyId=="$Property_Id" ? TRUE:'')); ?>><?php echo $Property_Name; ?></option>
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

<div class="Txtblks">Call Date Time</div>
<div class="fldblks"><input type="text" name="txtCallDateTime" id="txtCallDateTime" class="fild" style="width:302px;" value="<?php echo set_value('txtCallDateTime',$CallDateTime); ?>" readonly="readonly" tabindex="5" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Call Summary</div>
<div class="fldblks"><input type="text" name="txtCallSummary" id="txtCallSummary" class="fild" value="<?php echo set_value('txtCallSummary',$CallSummary); ?>" tabindex="6" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Next Call Date Time</div>
<div class="fldblks"><input type="text" name="txtNextCallDateTime" id="txtNextCallDateTime" class="fild" style="width:302px;" value="<?php echo set_value('txtNextCallDateTime',$NextCallDateTime); ?>" readonly="readonly" tabindex="7" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this)" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_call_record"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

<div class="clear"></div>

</div>
	<div class="clear"></div>
</div>
</form>

<script type="text/javascript" language="javascript">
function ChangeActive()
{
	if(document.getElementById('chkActive').checked == true)
	{
		$("#hfActive").val(1);
	}
	else
	{
		$("#hfActive").val(0);
	}
}
</script>

<script type="text/javascript" language="javascript">
$(document).ready(function(){
	
	$('#txtCallDateTime').datetimepicker({
		dateFormat: 'dd/mm/yy',
		controlType: 'select',
		oneLine: true,
		timeFormat: 'hh:mm tt',
		showOn: 'button',
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
        buttonImageOnly: true,
	});
	var CallDateTime = new Date("<?php echo $CallDateTime; ?>");
	$('#txtCallDateTime').datetimepicker('setDate', CallDateTime);
	
  //var theDate = new Date('2011-09-15 20:30:00');
	
	$('#txtNextCallDateTime').datetimepicker({
		dateFormat: 'dd/mm/yy',
		controlType: 'select',
		oneLine: true,
		timeFormat: 'hh:mm tt',
		showOn: 'button',
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
        buttonImageOnly: true
	});
	var NextCallDateTime = new Date("<?php echo $NextCallDateTime; ?>");
	$('#txtNextCallDateTime').datetimepicker('setDate', NextCallDateTime);
});	
</script>

<script type="text/javascript" language="javascript">
function FormValidate(btn)
{
    if($("#txtCallTypeName").val()=='')
    {	
        alert("Please enter Call Type");
        $("#txtCallTypeName").focus();
        return false;
    }
    else
    {
		var data = $("#editForm").serialize();
		
		btn.disabled = true;
		btn.value = 'Submitting...';
		
		var url = "<?php echo base_url(); ?>index.php/dashboard/edit_call_record";
		
		$.post(url,data,function(data){	
		
		    if(data)
			{
				if(data.status==1)
				{					
					btn.disabled = false;
					btn.value = 'Submit';
					alert(data.msg);
					var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_call_record";
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