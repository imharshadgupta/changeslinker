<?php 
    //$clientsdata = $this->getrequirementbyclient();
    //$propertydata = $this->getpropertybyclient();
       

//echo '<pre>';
//print_r($clientsdata);die;

?>
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><?php echo $message; ?><?php echo validation_errors(); ?></div>
<form name="addForm" id="addForm" method="post" action="<?php echo base_url(); ?>index.php/dashboard/add_dcr" enctype="multipart/form-data"  onsubmit="parent.fn_close_popup();">
<input type="hidden" name="txtDCRMode" id="txtDCRMode" value="New" />

<div class="inner_form">

<h2>Add New Task</h2>
<div class="mfrminner">

<fieldset> <legend>Task </legend>


	

			<div style="width:19%; text-align:right; float:left; border:0px solid red;"><label><strong>Task Date :</strong></label></div>
			<div style="width:1%; float:left; border:0px solid red;">&nbsp;</div>
			<div style="width:70%; float:left; border:0px solid blue;">

<input type="text" name="txtDCRDate" id="txtDCRDate" class="fild" style="width:300px;" readonly="" value="<?php echo set_value('txtDCRDate'); ?>" />
			</div>
			<div style="width:10%; float:left; border:0px solid red;">&nbsp;</div>
<br />
<br />
	
	
	<div id='TextBoxesGroup'>
		<div id="TextBoxDiv1" class="row" style="height:35px; border:0px solid green;">
			<div style="width:19%; text-align:right; float:left; border:0px solid red;"><label><strong>Task :</strong></label></div>
			<div style="width:1%; float:left; border:0px solid red;">&nbsp;</div>
			<div style="width:70%; float:left; border:0px solid blue;">
				<select name="cmbTask[]" id="cmbTask1" class="selected_task chzn-select fild" tabindex="1">
				<option value="">Select Task</option>
				<?php 
					$this->db->order_by("cTaskName", "asc");
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
			<div style="width:10%; float:left; border:0px solid red;">&nbsp;</div>


			<div style="width:19%; text-align:right; float:left; border:0px solid red;"><label><strong>Client :</strong></label></div>
			<div style="width:1%; float:left; border:0px solid red;">&nbsp;</div>

			<div style="width:70%; float:left; border:0px solid blue;">
				<select name="cmbClientReq[]" id="cmbClientReq1" class="selected_client_req chzn-select fild"  tabindex="2">
				<option value="">Select Client</option>
				<?php 
				  //$sql = $this->db->query("SELECT requirement_master.iClientId,client_master.cClientName FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId WHERE requirement_master.iClientId<>0 AND requirement_master.bActive=1 AND requirement_master.bDelete=0 GROUP BY requirement_master.iClientId ORDER BY client_master.cClientName");	
					
					$sql = $this->db->query("SELECT client_master.iClientId,client_master.cClientName FROM client_master WHERE client_master.bActive=1 AND client_master.bDelete=0 ORDER BY client_master.cClientName ASC");
					
					if($sql)
					{
						if(($sql->num_rows) > 0)
						{
							$rows = $sql->result_array();
							
							foreach($rows as $row): 
							
							$Client_Id = trim($row['iClientId']);
							$Client_Name = trim($row['cClientName']);
							if( $selclient_id == $Client_Id ) { 
						?>
							<option value="<?php echo $Client_Id; ?>" selected="selected"><?php echo $Client_Name; ?></option>
						<?php
							}else{
						?>
							<option value="<?php echo $Client_Id; ?>"><?php echo $Client_Name; ?></option>
						<?php
							}
						
							endforeach;	
						}
					}
				?>
				</select>	
			</div>
			<div style="width:10%; float:left; border:0px solid red;">&nbsp;</div>
			
						<div style="width:19%; text-align:right; float:left; border:0px solid red;"><label><strong>Reqirement :</strong></label></div>
			<div style="width:1%; float:left; border:0px solid red;">&nbsp;</div>

			<div style="width:70%; float:left; border:0px solid blue;">
				<select name="cmbRequirement[]" id="cmbRequirement1" class="selected_requirement chzn-select fild" tabindex="3">
				<option value="">Select Requirement</option>
                                
                                
                                <?php
                                
                                foreach($allrequirement as $key=>$row): 
							
							//$Task_Id = trim($row['iTaskId']);
							//$Task_Name = trim($row['cTaskName']);
							
						?>
							<option value="<?php echo $key; ?>"><?php echo $row; ?></option>
						<?php
							endforeach;
                                                        ?>
                                
                                
				</select>
			</div>
			
<!--			<div style="width:10%; float:left; border:0px solid red;">&nbsp;</div>-->
			
<!--			<div style="width:19%; text-align:right; float:left; border:0px solid red;"><label><strong>Client Prop :</strong></label></div>
			<div style="width:1%; float:left; border:0px solid red;">&nbsp;</div>
			
			<div style="width:70%; float:left; border:0px solid blue;">
				<select name="cmbClientProp[]" id="cmbClientProp1" class="selected_client_prop chzn-select fild"  tabindex="4">
				<option value="">Select Client</option>
				<?php
				  //$sql = $this->db->query("SELECT property_master.iClientId,client_master.cClientName FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId WHERE property_master.iClientId<>0 AND property_master.bActive=1 AND property_master.bDelete=0 GROUP BY property_master.iClientId ORDER BY client_master.cClientName");
					
					//$sql = $this->db->query("SELECT client_master.iClientId,client_master.cClientName FROM client_master WHERE client_master.bActive=1 AND client_master.bDelete=0 ORDER BY client_master.cClientName ASC");
					
					if($sql)
					{
						if(($sql->num_rows) > 0)
						{
							$rows = $sql->result_array();
							
							foreach($rows as $row): 
							
							$Client_Id = trim($row['iClientId']);
							$Client_Name = html_entity_decode($row['cClientName']);
						?>
							<option value="<?php echo $Client_Id; ?>"><?php echo $Client_Name; ?></option>
						<?php
							endforeach;	
						}
					}
				?>
				</select>	
			</div>
			-->
			<div style="width:10%; float:left; border:0px solid red;">&nbsp;</div>
			
						<div style="width:19%; text-align:right; float:left; border:0px solid red;"><label><strong>Property :</strong></label></div>
			<div style="width:1%; float:left; border:0px solid red;">&nbsp;</div>

			<div style="width:70%; float:left; border:0px solid blue;">
				<select name="cmbProperty[]" id="cmbProperty1" class="selected_property chzn-select fild" tabindex="5">
				<option value="">Select Property</option>
                                
                                <?php
                                
                                foreach($allproperty as $key=>$row): 
							
							
							
						?>
							<option value="<?php echo $key; ?>"><?php echo $row; ?></option>
						<?php
							endforeach;
                                                        ?>
                                
                                
				</select>
			</div>
			
			<div style="width:10%; float:left; border:0px solid red;">&nbsp;</div>
			
						<div style="width:19%; text-align:right; float:left; border:0px solid red;"><label><strong>Current Status :</strong></label></div>
			<div style="width:1%; float:left; border:0px solid red;">&nbsp;</div>

			<div style="width:70%; float:left; border:0px solid blue;">
			<select name="cmbCurrentStatus[]" id="cmbCurrentStatus1" class="selected_current_status chzn-select fild" tabindex="6">
			<option value="">Select Status</option>
			<?php 
				$this->db->order_by("cCurrentStatusName", "asc");
				$this->db->where('bActive', 1);
				$this->db->where('bDelete', 0);
				$sql =  $this->db->get('current_status_master');  
				if($sql)
				{
					if(($sql->num_rows) > 0)
					{
						$rows = $sql->result_array();
						
						foreach($rows as $row): 
						
						$CurrentStatus_Id = trim($row['iCurrentStatusId']);
						$CurrentStatus_Name = trim($row['cCurrentStatusName']);
					?>
						<option value="<?php echo $CurrentStatus_Id; ?>"><?php echo $CurrentStatus_Name; ?></option>
					<?php
						endforeach;	
					}
				}
			?>
			</select>
			</div>
			
			<div style="width:10%; float:left; border:0px solid red;">&nbsp;</div>
			
						<div style="width:19%; text-align:right; float:left; border:0px solid red;"><label><strong>Summary :</strong></label></div>
			<div style="width:1%; float:left; border:0px solid red;">&nbsp;</div>

			<div style="width:70%; float:left; border:0px solid blue;"><textarea name="txtDCRSummary[]" id="txtDCRSummary1" class="fild" col="12" rows="1" tabindex="7" ><?php echo set_value('txtDCRSummary1'); ?></textarea></div>
			
			
			<div style="width:10%; float:left; border:0px solid red;">&nbsp;</div>

			<div class="clear"></div>
		</div>
		
	</div>
	
</fieldset>

<div class="submit">
    
  <input type="button" name="btnSubmit" class="btn" value="Submit"   onclick="FormValidate(this);"/>
<? if( $ispopup =='popup' ){ ?>
<a href="#" onclick="parent.fn_close_popup();"><input type="button" name="btnBack" id="btnBack" class="btn" value="Close" /></a>
<? }else{ ?>
<!--<a href="<?php // echo base_url(); ?>index.php/dashboard/listing_dcr"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a>-->
<? } ?>
</div>

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
	   
	   var  maincontent1="<div style='width:3%; height:100%; text-align:center; float:left; border:0px solid red;'>"+counter+".</div>";
		    maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
	        maincontent1+="<div style='width:12%; height:100%; float:left; border:0px solid blue;'>";
		    maincontent1+="<select name='cmbTask[]' id='cmbTask"+counter+"' data-placeholder='Select Task...' class='selected_task chzn-select fild'>";
			maincontent1+="<option value=''>Select Task</option>";	
			<?php 
			$this->db->order_by("cTaskName", "asc");
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
			maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
			maincontent1+="<select name='cmbClientReq[]' id='cmbClientReq"+counter+"' data-placeholder='Select Client...' class='selected_client_req chzn-select fild' onchange='getRequirementByClient(this);'>";
			maincontent1+="<option value=''>Select Client</option>";	
			<?php 
		  //$sql = $this->db->query("SELECT requirement_master.iClientId,client_master.cClientName FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId WHERE requirement_master.iClientId<>0 AND requirement_master.bActive=1 AND requirement_master.bDelete=0 GROUP BY requirement_master.iClientId ORDER BY client_master.cClientName");
			
			$sql = $this->db->query("SELECT client_master.iClientId,client_master.cClientName FROM client_master WHERE client_master.bActive=1 AND client_master.bDelete=0 ORDER BY client_master.cClientName ASC");
			
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
			maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
			maincontent1+="<select name='cmbRequirement[]' id='cmbRequirement"+counter+"' data-placeholder='Select Requirement...' class='selected_requirement chzn-select fild'>";
			maincontent1+="<option value=''>Select Requirement</option>";	
			maincontent1+="</select></div>";
			
		    maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
			maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
			maincontent1+="<select name='cmbClientProp[]' id='cmbClientProp"+counter+"' data-placeholder='Select Client...' class='selected_client_prop chzn-select fild' onchange='getPropertyByClient(this);'>";
			maincontent1+="<option value=''>Select Client</option>";	
			<?php 
		  //$sql = $this->db->query("SELECT property_master.iClientId,client_master.cClientName FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId WHERE property_master.iClientId<>0 AND property_master.bActive=1 AND property_master.bDelete=0 GROUP BY property_master.iClientId ORDER BY client_master.cClientName");
			
			$sql = $this->db->query("SELECT client_master.iClientId,client_master.cClientName FROM client_master WHERE client_master.bActive=1 AND client_master.bDelete=0 ORDER BY client_master.cClientName ASC");
			
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
			maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
			maincontent1+="<select name='cmbProperty[]' id='cmbProperty"+counter+"' data-placeholder='Select Property...' class='selected_property chzn-select fild'>";
			maincontent1+="<option value=''>Select Property</option>";	
			maincontent1+="</select></div>";
			
		    maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
			maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
			maincontent1+="<select name='cmbCurrentStatus[]' id='cmbCurrentStatus"+counter+"' data-placeholder='Select Status...' class='selected_current_status chzn-select fild'>";
			maincontent1+="<option value=''>Select Status</option>";	
			<?php 
			$this->db->order_by("cCurrentStatusName", "asc");
			$this->db->where('bActive', 1);
			$this->db->where('bDelete', 0);
			$sql =  $this->db->get('current_status_master');  
			if($sql)
			{
				if(($sql->num_rows) > 0)
				{
					$rows = $sql->result_array();
					
					foreach($rows as $row): 
					
					$CurrentStatus_Id = trim($row['iCurrentStatusId']);
					$CurrentStatus_Name = trim($row['cCurrentStatusName']);
				?>
					maincontent1+="<option value='<?php echo $CurrentStatus_Id; ?>'><?php echo $CurrentStatus_Name; ?></option>";
				<?php
					endforeach;	
				}
			}
			?>
			maincontent1+="</select></div>";
		
			maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
			maincontent1+="<div style='width:11%; height:100%; float:left; border:0px solid blue;'><textarea name='txtDCRSummary[]' id='txtDCRSummary"+counter+"' class='dcr_summary fild' col='12' rows='1' '><?php echo set_value('txtDCRSummary[]'); ?></textarea></div>";

			maincontent1+="<div class='clear'></div>";
			
			maincontent1+="<div class='Txtblks'>&nbsp;</div>";
			maincontent1+="<div class='fldblks'>&nbsp;</div>";
			maincontent1+="<div class='Txtblks'>&nbsp;</div>";
			maincontent1+="<div class='fldblks'>&nbsp;</div>";
			
			maincontent1+="<div class='clear'></div>";
			

			newTextBoxDiv.after().html(maincontent1);
		  
			newTextBoxDiv.appendTo("#TextBoxesGroup");
			
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

	//---------------------------------------------------------------------------------------------------------------------------------------------------------
	
	$("#txtDCRDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		maxDate: 0,
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});
	
   //var currentDate = new Date();  
   //alert(currentDate);
   //$("#txtDCRDate").datepicker("setDate",currentDate);
   
    var Mydate = new Date();  
	
	var day = Mydate.getDate();
	var dayval =  day < 10 ? '0' + day : '' + day;
	
	var month = Mydate.getMonth() + 1;
	var monval =  month < 10 ? '0' + month : '' + month;

	var newdat = (monval +"/"+ dayval+"/"+Mydate.getFullYear());
	var splitdt = newdat.split("/");
	
	var defaultcurrdt = splitdt[1]+"/"+splitdt[0]+"/"+splitdt[2];
	
	$("#txtDCRDate").val(defaultcurrdt);
});
</script>

<script type="text/javascript" language="javascript">
var counter = 2;

function add_row() 
{	
   var newTextBoxDiv = $(document.createElement('div')).attr({"id":"TextBoxDiv"+counter, "class":"row", "height":"100px", "border":"1px solid green"});
	   
   var  maincontent1="<div style='width:3%; height:100%; text-align:center; float:left; border:0px solid red;'>"+counter+".</div>";
		maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
		maincontent1+="<div style='width:12%; height:100%; float:left; border:0px solid blue;'>";
		maincontent1+="<select name='cmbTask[]' id='cmbTask"+counter+"' data-placeholder='Select Task...' class='selected_task chzn-select fild'>";
		maincontent1+="<option value=''>Select Task</option>";	
		<?php 
		$this->db->order_by("cTaskName", "asc");
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
		maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
		maincontent1+="<select name='cmbClientReq[]' id='cmbClientReq"+counter+"' data-placeholder='Select Client...' class='selected_client_req chzn-select fild' onchange='getRequirementByClient(this);'>";
		maincontent1+="<option value=''>Select Client</option>";	
		<?php 
	  //$sql = $this->db->query("SELECT requirement_master.iClientId,client_master.cClientName FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId WHERE requirement_master.iClientId<>0 AND requirement_master.bActive=1 AND requirement_master.bDelete=0 GROUP BY requirement_master.iClientId ORDER BY client_master.cClientName");  
		
		$sql = $this->db->query("SELECT client_master.iClientId,client_master.cClientName FROM client_master WHERE client_master.bActive=1 AND client_master.bDelete=0 ORDER BY client_master.cClientName ASC");
		
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
		maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
		maincontent1+="<select name='cmbRequirement[]' id='cmbRequirement"+counter+"' data-placeholder='Select Requirement...' class='selected_requirement chzn-select fild'>";
		maincontent1+="<option value=''>Select Requirement</option>";	
		maincontent1+="</select></div>";
		
	    maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
		maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
		maincontent1+="<select name='cmbClientProp[]' id='cmbClientProp"+counter+"' data-placeholder='Select Client...' class='selected_client_prop chzn-select fild' onchange='getPropertyByClient(this);'>";
		maincontent1+="<option value=''>Select Client</option>";	
		<?php 
	  //$sql = $this->db->query("SELECT property_master.iClientId,client_master.cClientName FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId WHERE property_master.iClientId<>0 AND property_master.bActive=1 AND property_master.bDelete=0 GROUP BY property_master.iClientId ORDER BY client_master.cClientName");  
		
		$sql = $this->db->query("SELECT client_master.iClientId,client_master.cClientName FROM client_master WHERE client_master.bActive=1 AND client_master.bDelete=0 ORDER BY client_master.cClientName ASC");
		
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
		maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
		maincontent1+="<select name='cmbProperty[]' id='cmbProperty"+counter+"' data-placeholder='Select Property...' class='selected_property chzn-select fild'>";
		maincontent1+="<option value=''>Select Property</option>";	
		maincontent1+="</select></div>";
		
		maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
		maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
		maincontent1+="<select name='cmbCurrentStatus[]' id='cmbCurrentStatus"+counter+"' data-placeholder='Select Status...' class='selected_current_status chzn-select fild'>";
		maincontent1+="<option value=''>Select Status</option>";	
		<?php 
		$this->db->order_by("cCurrentStatusName", "asc");
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('current_status_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$CurrentStatus_Id = trim($row['iCurrentStatusId']);
				$CurrentStatus_Name = trim($row['cCurrentStatusName']);
			?>
				maincontent1+="<option value='<?php echo $CurrentStatus_Id; ?>'><?php echo $CurrentStatus_Name; ?></option>";
			<?php
				endforeach;	
			}
		}
		?>
		maincontent1+="</select></div>";
		
		maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
		maincontent1+="<div style='width:11%; height:100%; float:left; border:0px solid blue;'><textarea name='txtDCRSummary[]' id='txtDCRSummary"+counter+"' class='dcr_summary fild' col='12' rows='1' '><?php echo set_value('txtDCRSummary[]'); ?></textarea></div>";

		maincontent1+="<div class='clear'></div>";
		
		maincontent1+="<div class='Txtblks'>&nbsp;</div>";
		maincontent1+="<div class='fldblks'>&nbsp;</div>";
		maincontent1+="<div class='Txtblks'>&nbsp;</div>";
		maincontent1+="<div class='fldblks'>&nbsp;</div>";
		
		maincontent1+="<div class='clear'></div>";
		
		newTextBoxDiv.after().html(maincontent1);
	  
		newTextBoxDiv.appendTo("#TextBoxesGroup");
		
		$(".chzn-select").chosen(); 
		$(".chzn-select-deselect").chosen({allow_single_deselect:true});
		
	counter++;
}
</script>

<script type="text/javascript" language="javascript">
function getRequirementByClient(e)
{	
	var cmbClientReq = $(e).closest(".row").find(".selected_client_req").val();
	
	if(cmbClientReq!='')
	{	
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url(); ?>index.php/dashboard/getrequirementbyclient",
			data: "cmbClient="+cmbClientReq,
			success: function(details){
				
				$(e).closest(".row").find(".selected_requirement").children('option:not(:first)').remove();
				
				$.each(details,function(reqid,reqname) {
				    var opt = $('<option />'); 									
					opt.val(reqid);
					opt.text(reqname);
					$(e).closest(".row").find(".selected_requirement").append(opt);				  
				});
				
				$(e).closest(".row").find(".selected_requirement").trigger("liszt:updated");	
			}
		});
	}
	else
	{
		$(e).closest(".row").find(".selected_requirement").val('');
	}
}
</script>

<script type="text/javascript" language="javascript">
function getPropertyByClient(e)
{	
	var cmbClientProp = $(e).closest(".row").find(".selected_client_prop").val();
	
	if(cmbClientProp!='')
	{
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url(); ?>index.php/dashboard/getpropertybyclient",
			data: "cmbClient="+cmbClientProp,
			success: function(details){
				//alert(details);
			    $(e).closest(".row").find(".selected_property").children('option:not(:first)').remove();
				
				$.each(details,function(propid,propname) {
				    var opt = $('<option />'); 									
					opt.val(propid);
					opt.text(propname);
					$(e).closest(".row").find(".selected_property").append(opt);				  
				});
				
				$(e).closest(".row").find(".selected_property").trigger("liszt:updated");
			}
		});
	}
	else
	{
		$(e).closest(".row").find(".selected_property").val('');
	}
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
	  /*var data = $("#addForm").serialize();
		
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
		},'json');*/
		
	   //---------------------------------------------------------------------------------------------------------
	  
	    $.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/dashboard/check_user_dcr_date",
			data: "txtDCRDate="+$("#txtDCRDate").val(),
			success: function(msg){
				msg = msg.trim();
			    if(msg=="alreadyexists")
				{
				
					var replaceconf = confirm('Task of this date already exists ! Do you want to add another Task..?');
		
					if(replaceconf)
					{
						$("#txtDCRMode").val('Replace');
						
						var data = $("#addForm").serialize();
						
						var url = "<?php echo base_url(); ?>index.php/dashboard/add_dcr";
						
						$.post(url,data,function(responsedata,status){	
						
							btn.disabled = true;
							btn.value = 'Submitting...';	
						    if(responsedata)
							{
								if(responsedata.status == 1)
								{					
									btn.disabled = false;
									btn.value = 'Submit';
									alert(responsedata.msg);
									// var redirecturl = "<?php // echo base_url(); ?>index.php/dashboard";
									// $(location).attr('href',redirecturl);	
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
					else
					{
						return false;
					}
				}
				else
				{
					var data = $("#addForm").serialize();
					var url = "<?php echo base_url(); ?>index.php/dashboard/add_dcr";
					btn.disabled = true;
					btn.value = 'Submitting...';

					$.post(url,data,function(responsedata, status){	
						console.log("responsedata ", responsedata);
						console.log("status ", responsedata);
						responsedata = responsedata.trim();
					    if(responsedata)
						{
							console.log(responsedata);
							if(responsedata.status == 1)
							{					
								btn.disabled = false;
								btn.value = 'Submit';
								alert(responsedata.msg);
								var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_dcr";
								$('#btnBack').click();
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
		});
    }
}
</script>
				<script> 
				// document.getElementById('cmbClientReq1').onchange();
				</script>
					<script> 
                                    window.addEventListener("keyup", function(e){ if(e.keyCode == 27) history.back(); }, false);
                                    
                                    
                                $( "#btnBack" ).click(function() {
                                    parent.$("#dialog2").bPopup().close();
                                    return false;                                 
                                });
                                    
                                    
                                    
                             </script>
                             