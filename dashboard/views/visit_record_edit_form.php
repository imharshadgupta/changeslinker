<!--==============================Form=================================-->

<form name="editForm" id="editForm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="hfVisitRecordId" id="hfVisitRecordId" value="<?php echo set_value('hfVisitRecordId',$VisitRecordId); ?>"/>
<!--<input type="hidden" name="hfActive" id="hfActive" value="<?php //echo set_value('hfActive',$Active); ?>" />-->
<div class="inner_form">
<h2>Edit Details</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>General Details</legend>

<div class="Txtblks">Meeting with Person Name</div>
<div class="fldblks"><input type="text" name="txtPersonName" id="txtPersonName" class="fild" value="<?php echo set_value('txtPersonName',$PersonName); ?>" tabindex="1" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property</div>
<div class="fldblks">
	<select name="cmbProperty" id="cmbProperty" tabindex="2" class="fild">
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

<div class="Txtblks">Visit Date Time</div>
<div class="fldblks"><input type="text" name="txtVisitDateTime" id="txtVisitDateTime" class="fild" style="width:302px;" value="<?php echo set_value('txtVisitDateTime',$VisitDateTime); ?>" tabindex="3" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Visit Summary</div>
<div class="fldblks"><input type="text" name="txtVisitSummary" id="txtVisitSummary" class="fild" value="<?php echo set_value('txtVisitSummary',$VisitSummary); ?>" tabindex="4" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Next Visit Date Time</div>
<div class="fldblks"><input type="text" name="txtNextVisitDateTime" id="txtNextVisitDateTime" class="fild" style="width:302px;" value="<?php echo set_value('txtNextVisitDateTime',$NextVisitDateTime); ?>" tabindex="5" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this)" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_visit_record"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

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
	$('#txtVisitDateTime').datetimepicker({
		dateFormat: 'dd/mm/yy',
		controlType: 'select',
		oneLine: true,
		timeFormat: 'hh:mm tt',
		showOn: 'button',
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
        buttonImageOnly: true
	});

	var VisitDateTime = new Date("<?php echo $VisitDateTime; ?>");
	$('#txtVisitDateTime').datetimepicker('setDate', VisitDateTime);
	
	$('#txtNextVisitDateTime').datetimepicker({
		dateFormat: 'dd/mm/yy',
		controlType: 'select',
		oneLine: true,
		timeFormat: 'hh:mm tt',
		showOn: 'button',
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
        buttonImageOnly: true
	});
	
	var NextVisitDateTime = new Date("<?php echo $NextVisitDateTime; ?>");
	$('#txtNextVisitDateTime').datetimepicker('setDate', NextVisitDateTime);
});	
</script>

<script type="text/javascript" language="javascript">
function FormValidate(btn)
{
    if($("#txtPersonName").val()=='')
    {	
        alert("Please enter Meeting with Person Name");
        $("#txtPersonName").focus();
        return false;
    }
    else
    {
		var data = $("#editForm").serialize();
		
		btn.disabled = true;
		btn.value = 'Submitting...';
		
		var url = "<?php echo base_url(); ?>index.php/dashboard/edit_visit_record";
		
		$.post(url,data,function(data){	
		
		    if(data)
			{
				if(data.status==1)
				{					
					btn.disabled = false;
					btn.value = 'Submit';
					alert(data.msg);
					var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_visit_record";
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