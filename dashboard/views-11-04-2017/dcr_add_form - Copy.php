
<!--==========================================================Form==========================================================================================-->

<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<form name="addForm" id="addForm" method="post" action="" enctype="multipart/form-data">
<div class="inner_form">

<h2>Add New Task</h2>
<div class="mfrminner">

<fieldset> <legend>DCR Summary</legend>

<div class="Txtblks">Date</div>
<div class="fldblks"><input type="text" name="txtDCRDate" id="txtDCRDate" class="fild" style="width:300px;" readonly="" value="<?php echo set_value('txtDCRDate'); ?>" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">Remarks</div>
<div class="fldblks"><textarea name="txtDCRRemarks" id="txtDCRRemarks" class="fild"><?php echo set_value('txtDCRRemarks'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<!------------------------------------------------------------------------------------------------------------------------------------------------------------>

<fieldset>
	<legend>DCR Details</legend>
    
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks"><input type='button' value='Add New' id='addButton'>&nbsp;<input type='button' value='Cancel' id='removeButton'></div>
    <div class="clear"></div>
	
	<div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="clear"></div>
    
	<div style="height:33px; border:0px solid green;">
		<div style="width:5%; height:5%; text-align:center; float:left; border:0px solid red; text-decoration:underline;"><label><strong>SNo.</strong></label></div>
		<div style="width:1%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:15%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;"><label><strong>Task</strong></label></div>
		<div style="width:1%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:17%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;"><label><strong>Client</strong></label></div>
		<div style="width:1%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:20%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;"><label><strong>Property</strong></label></div>
		<div style="width:1%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:15%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;" ><label><strong>Requirement</strong></label></div>
		<div style="width:1%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:19%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;"><label><strong>Summary</strong></label></div>
		<div class="clear"></div>
	</div>

	<div id='TextBoxesGroup'>
		<div id="TextBoxDiv1" class="row" style="height:35px; border:0px solid green;">
			<div style="width:5%; height:100%; text-align:center; float:left; border:0px solid red;">1.</div>
			<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
			<div style="width:15%; height:100%; float:left; border:0px solid blue;">
				<select name="cmbTask[]" id="cmbTask1" class="selected_task chzn-select fild" tabindex="1">
				<option value="">Select Task</option>
				<?php 
					$this->db->where('bActive', 1);
					$this->db->where('bDelete', 0);
					$sql =  $this->db->get('task_master');  
					if($sql)
					{
						if(($sql->num_rows) > 0)
						{
							$rows = $sql->result_array();
							
							foreach($rows as $row): 
							
							$Task_Id = trim($row['iTaskId']);
							$Task_Name = trim($row['cTaskName']);
						?>
							<option value="<?php echo $Task_Id; ?>"><?php echo $Task_Name; ?></option>
						<?php
							endforeach;	
						}
					}
				?>
				</select>
			</div>
			<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
			<div style="width:17%; height:100%; float:left; border:0px solid blue;">
				<select name="cmbClient[]" id="cmbClient1" class="selected_client chzn-select fild" tabindex="2">
				<option value="">Select Client</option>
				<?php 
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
			<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
			<div style="width:20%; height:100%; float:left; border:0px solid blue;">
				<select name="cmbProperty[]" id="cmbProperty1" class="selected_property chzn-select fild" tabindex="3">
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
							<option value="<?php echo $Property_Id; ?>"><?php echo $Property_Name; ?></option>
						<?php
							endforeach;	
						}
					}
				?>
				</select>
			</div>
			<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
			<div style="width:15%; height:100%; float:left; border:0px solid blue;">
				<select name="cmbRequirement[]" id="cmbRequirement1" class="selected_requirement chzn-select fild" tabindex="4">
				<option value="">Select Requirement</option>
				<?php 
					$this->db->where('bActive', 1);
					$this->db->where('bDelete', 0);
					$sql =  $this->db->get('requirement_master');  
					if($sql)
					{
						if(($sql->num_rows) > 0)
						{
							$rows = $sql->result_array();
							
							foreach($rows as $row): 
							
							$Requirement_Id = trim($row['iRequirementId']);
							$Requirement_Name = trim($row['cRequirementName']);
						?>
							<option value="<?php echo $Requirement_Id; ?>"><?php echo $Requirement_Name; ?></option>
						<?php
							endforeach;	
						}
					}
				?>
				</select>
			</div>
			<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
			<div style="width:19%; height:100%; float:left; border:0px solid blue;"><textarea name="txtDCRSummary[]" id="txtDCRSummary1" class="fild" col="10" rows="1" tabindex="5" onblur="add_row();"><?php echo set_value('txtDCRSummary1'); ?></textarea></div>
			<div class="clear"></div>
			
			<div class="Txtblks"><hr /></div>
			<div class="fldblks"><hr /></div>
			<div class="Txtblks"><hr /></div>
			<div class="fldblks"><hr /></div>
			<div class="clear"></div>
		</div>
	</div>
	
	<div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="clear"></div>
	
</fieldset>

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this);" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_dcr"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

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
$(document).ready(function(){

	//var counter = 2;
  
	$("#addButton").click(function() {
	
       var  newTextBoxDiv = $(document.createElement('div')).attr({"id":"TextBoxDiv"+counter, "class":"row", "height":"100px", "border":"1px solid green"});
	   
	   var  maincontent1="<div style='width:5%; height:100%; text-align:center; float:left; border:0px solid red;'>"+counter+".</div>";
		    maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
	        maincontent1+="<div style='width:15%; height:100%; float:left; border:0px solid blue;'>";
		    maincontent1+="<select name='cmbTask[]' id='cmbTask"+counter+"' data-placeholder='Select Task...' class='selected_task chzn-select fild'>";
			maincontent1+="<option value=''>Select Task</option>";	
			<?php 
			$this->db->where('bActive', 1);
			$this->db->where('bDelete', 0);
			$sql =  $this->db->get('task_master');  
			if($sql)
			{
				if(($sql->num_rows) > 0)
				{
					$rows = $sql->result_array();
					
					foreach($rows as $row): 
					
					$Task_Id = trim($row['iTaskId']);
					$Task_Name = trim($row['cTaskName']);
				?>
					maincontent1+="<option value='<?php echo $Task_Id; ?>'><?php echo $Task_Name; ?></option>";
				<?php
					endforeach;	
				}
			}
			?>
			maincontent1+="</select></div>";
		
			maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
			maincontent1+="<div style='width:17%; height:100%; float:left; border:0px solid blue;'>";
			maincontent1+="<select name='cmbClient[]' id='cmbClient"+counter+"' data-placeholder='Select Client...' class='selected_client chzn-select fild'>";
			maincontent1+="<option value=''>Select Client</option>";	
			<?php 
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
					maincontent1+="<option value='<?php echo $Client_Id; ?>'><?php echo $Client_Name; ?></option>";
				<?php
					endforeach;	
				}
			}
			?>
			maincontent1+="</select></div>";
			maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
	
			maincontent1+="<div style='width:20%; height:100%; float:left; border:0px solid blue;'>";
			maincontent1+="<select name='cmbProperty[]' id='cmbProperty"+counter+"' data-placeholder='Select Property...' class='selected_property chzn-select fild'>";
			maincontent1+="<option value=''>Select Property</option>";	
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
					maincontent1+="<option value='<?php echo $Property_Id; ?>'><?php echo $Property_Name; ?></option>";
				<?php
					endforeach;	
				}
			}
			?>
			maincontent1+="</select></div>";
			
			maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
		
			maincontent1+="<div style='width:15%; height:100%; float:left; border:0px solid blue;'>";
			maincontent1+="<select name='cmbRequirement[]' id='cmbRequirement"+counter+"' data-placeholder='Select Requirement...' class='selected_requirement chzn-select fild'>";
			maincontent1+="<option value=''>Select Requirement</option>";	
			<?php 
			$this->db->where('bActive', 1);
			$this->db->where('bDelete', 0);
			$sql =  $this->db->get('requirement_master');  
			if($sql)
			{
				if(($sql->num_rows) > 0)
				{
					$rows = $sql->result_array();
					
					foreach($rows as $row): 
					
					$Requirement_Id = trim($row['iRequirementId']);
					$Requirement_Title = trim($row['cRequirementTitle']);
				?>
					maincontent1+="<option value='<?php echo $Requirement_Id; ?>'><?php echo $Requirement_Title; ?></option>";
				<?php
					endforeach;	
				}
			}
			?>
			maincontent1+="</select></div>";
			
			maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
			
			maincontent1+="<div style='width:19%; height:100%; float:left; border:0px solid blue;'><textarea name='txtDCRSummary[]' id='txtDCRSummary"+counter+"' class='dcr_summary fild' col='10' rows='1' onblur='add_row();' tabindex='4'><?php echo set_value('txtDCRSummary[]'); ?></textarea></div>";

			maincontent1+="<div class='clear'></div>";
			
			maincontent1+="<div class='Txtblks'><hr /></div>";
			maincontent1+="<div class='fldblks'><hr /></div>";
			maincontent1+="<div class='Txtblks'><hr /></div>";
			maincontent1+="<div class='fldblks'><hr /></div>";
		 
			newTextBoxDiv.after().html(maincontent1);
		  
			newTextBoxDiv.appendTo("#TextBoxesGroup");
			
			$('.nextcalldatetime').datetimepicker({
				dateFormat: 'dd/mm/yy',
				controlType: 'select',
				oneLine: true,
				timeFormat: 'hh:mm tt',
				showOn: 'button',
				buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
				buttonImageOnly: true
			});
			
			$(".chzn-select").chosen(); 
			$(".chzn-select-deselect").chosen({allow_single_deselect:true});
			
			counter++;
     });
	 		
    $("#removeButton").click(function() {

		if(counter==2){
		  alert("No more fields to remove");
		  return false;
		}   
		
		counter--;
		
		$("#TextBoxDiv"+counter).remove();	
	});

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

	$("#txtDCRDate").datepicker({ 
	  dateFormat: 'dd/mm/yy',
	  showOn: "button",
	  changeMonth: true,
	  changeYear: true,
	  yearRange:"-100:+10",
	  buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
	  buttonImageOnly: true 
	});
	
	$('#txtNextCallDateTime1').datetimepicker({
		dateFormat: 'dd/mm/yy',
		controlType: 'select',
		oneLine: true,
		timeFormat: 'hh:mm tt',
		showOn: 'button',
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true
	});
});
</script>

<script type="text/javascript" language="javascript">
var counter = 2;

function add_row() 
{	
   var  newTextBoxDiv = $(document.createElement('div')).attr({"id":"TextBoxDiv"+counter, "class":"row", "height":"100px", "border":"1px solid green"});
	   
   var  maincontent1="<div style='width:5%; height:100%; text-align:center; float:left; border:0px solid red;'>"+counter+".</div>";
		maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
		maincontent1+="<div style='width:15%; height:100%; float:left; border:0px solid blue;'>";
		maincontent1+="<select name='cmbTask[]' id='cmbTask"+counter+"' data-placeholder='Select Task...' class='selected_task chzn-select fild'>";
		maincontent1+="<option value=''>Select Task</option>";	
		<?php 
			$this->db->where('bActive', 1);
			$this->db->where('bDelete', 0);
			$sql =  $this->db->get('task_master');  
			if($sql)
			{
				if(($sql->num_rows) > 0)
				{
					$rows = $sql->result_array();
					
					foreach($rows as $row): 
					
					$Task_Id = trim($row['iTaskId']);
					$Task_Name = trim($row['cTaskName']);
				?>
					maincontent1+="<option value='<?php echo $Task_Id; ?>'><?php echo $Task_Name; ?></option>";
				<?php
					endforeach;	
				}
			}
			?>
		maincontent1+="</select></div>";
	
		maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
		maincontent1+="<div style='width:17%; height:100%; float:left; border:0px solid blue;'>";
		maincontent1+="<select name='cmbClient[]' id='cmbClient"+counter+"' data-placeholder='Select Client...' class='selected_client chzn-select fild'>";
		maincontent1+="<option value=''>Select Client</option>";	
						<?php 
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
								maincontent1+="<option value='<?php echo $Client_Id; ?>'><?php echo $Client_Name; ?></option>";
							<?php
								endforeach;	
							}
						}
						?>
		maincontent1+="</select></div>";
		maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";

		maincontent1+="<div style='width:20%; height:100%; float:left; border:0px solid blue;'>";
		maincontent1+="<select name='cmbProperty[]' id='cmbProperty"+counter+"' data-placeholder='Select Property...' class='selected_property chzn-select fild'>";
		maincontent1+="<option value=''>Select Property</option>";	
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
								maincontent1+="<option value='<?php echo $Property_Id; ?>'><?php echo $Property_Name; ?></option>";
							<?php
								endforeach;	
							}
						}
						?>
		maincontent1+="</select></div>";
		
		maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
	
		maincontent1+="<div style='width:15%; height:100%; float:left; border:0px solid blue;'>
		maincontent1+="<select name='cmbRequirement[]' id='cmbRequirement"+counter+"' data-placeholder='Select Requirement...' class='selected_requirement chzn-select fild'>";
		maincontent1+="<option value=''>Select Requirement</option>";	
		<?php 
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('requirement_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Requirement_Id = trim($row['iRequirementId']);
				$Requirement_Title = trim($row['cRequirementTitle']);
			?>
				maincontent1+="<option value='<?php echo $Requirement_Id; ?>'><?php echo $Requirement_Title; ?></option>";
			<?php
				endforeach;	
			}
		}
		?>
		maincontent1+="</select></div>";
		maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
		maincontent1+="<div style='width:19%; height:100%; float:left; border:0px solid blue;'><textarea name='txtDCRSummary[]' id='txtDCRSummary"+counter+"' class='dcr_summary fild' col='10' rows='1' onblur='add_row();' tabindex='4'><?php echo set_value('txtDCRSummary[]'); ?></textarea></div>";
		maincontent1+="<div class='clear'></div>";
		
		maincontent1+="<div class='Txtblks'><hr /></div>";
		maincontent1+="<div class='fldblks'><hr /></div>";
		maincontent1+="<div class='Txtblks'><hr /></div>";
		maincontent1+="<div class='fldblks'><hr /></div>";
	 
		newTextBoxDiv.after().html(maincontent1);
	  
		newTextBoxDiv.appendTo("#TextBoxesGroup");
		
		$('.nextcalldatetime').datetimepicker({
			dateFormat: 'dd/mm/yy',
			controlType: 'select',
			oneLine: true,
			timeFormat: 'hh:mm tt',
			showOn: 'button',
			buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
			buttonImageOnly: true
		});
		
		$(".chzn-select").chosen(); 
		$(".chzn-select-deselect").chosen({allow_single_deselect:true});
		
		counter++;
}
</script>

<script type="text/javascript" language="javascript">
function FormValidate(btn)
{
    if($("#txtDCRDate").val()=='')
    {	
        alert("Please select Date");
        $("#txtDCRDate").focus();
        return false;
    }
    else
    {
		var data = $("#addForm").serialize();
		
		var url = "<?php echo base_url(); ?>index.php/dashboard/add_dcr";
		
		btn.disabled = true;
		btn.value = 'Submitting...';
		
		$.post(url,data,function(responsedata,status){	
			
			if(responsedata)
			{
				if(responsedata.status == 1)
				{					
					btn.disabled = false;
					btn.value = 'Submit';
					alert(responsedata.msg);
					var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_dcr";
					$(location).attr('href',redirecturl);	
				}	
				else
				{
					btn.disabled = false;
					btn.value = 'Submit';
					alert(responsedata.msg);
				} 
			}
		},'json');
    }
}
</script>