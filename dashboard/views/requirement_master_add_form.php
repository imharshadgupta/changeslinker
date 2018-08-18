<!--==============================Form=================================-->

<form name="addForm" id="addForm" method="post" action="<?php echo base_url(); ?>index.php/dashboard/add_requirement_master" enctype="multipart/form-data">
<div class="inner_form">
<h2>Add RF Details</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>

<fieldset><legend>&nbsp;</legend>

<div class="Txtblks">Date</div>
<div class="fldblks"><input type="text" name="txtDate" id="txtDate" class="fild" style="width:302px;" value="<?php echo set_value('txtDate'); ?>" tabindex="1" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Title</div>
<div class="fldblks"><input type="text" name="txtRequirementTitle" id="txtRequirementTitle" class="fild" value="<?php echo set_value('txtRequirementTitle'); ?>" tabindex="2" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Client</div>
<div class="fldblks">
	<select name="cmbClient" id="cmbClient" class="fild chzn-select" onchange="ChangeClient()" tabindex="3">
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



<div class="Txtblks">Contact Person</div>
<div class="fldblks">
<select name="cmbContactPerson" id="cmbContactPerson" class="fild" onchange="ChangeContactPerson()" tabindex="4">
<option value="">Select Contact Person</option>
</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Designation :-</div>
<div class="Txtblks" style="font-size:15px; font-weight:bold; text-align:left;" id="dvDesignation"></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Phone No. 1 :-</div>
<div class="Txtblks" style="font-size:15px; font-weight:bold; text-align:left;" id="dvPhoneNo1"></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Phone No. 2 :-</div>
<div class="Txtblks" style="font-size:15px; font-weight:bold; text-align:left;" id="dvPhoneNo2"></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Email :-</div>
<div class="Txtblks" style="font-size:15px; font-weight:bold; text-align:left;" id="dvEmail"></div>
<input type="hidden" id="dvEmaildata" name="dvEmaildata" >
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<fieldset><legend>General Details</legend>

<div class="Txtblks">Branch</div>
<div class="fldblks">
	<select name="cmbBranch" id="cmbBranch" class="fild" tabindex="10">
	<option value="">Select Branch</option>
	<?php
		$this->db->order_by('cBranchName', 'asc');
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
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">State</div>
<div class="fldblks">
	<select name="cmbState" id="cmbState" class="fild" tabindex="11" onchange="getDistrictByStateId()">
	<option value="">Select State</option>
	<?php 
		$this->db->order_by('cStateName', 'asc');
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('state_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$State_Id = trim($row['iStateId']);
				$State_Name = trim($row['cStateName']);
			?>
				<option value="<?php echo $State_Id; ?>"><?php echo $State_Name; ?></option>
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

<div class="Txtblks">District</div>
<div class="fldblks">
	<select name="cmbDistrict" id="cmbDistrict" class="fild" tabindex="12" onchange="getCityByDistrictIdAndStateId()">
	<option value="">Select District</option>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">City</div>
<div class="fldblks">
	<select name="cmbCity" id="cmbCity" class="fild" tabindex="13" onchange="getLocationByCityIdAndDistrictIdAndStateId()">
	<option value="">Select City</option>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Location</div>
<div class="fldblks">
	<select name="cmbLocation" id="cmbLocation" class="fild" tabindex="14">
	<option value="">Select Location</option>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">Area</div>
<div class="fldblks"><textarea name="txtArea" id="txtArea" class="fild" tabindex="15"><?php echo set_value('txtArea'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Height</div>
<div class="fldblks"><input type="text" name="txtHeight" id="txtHeight" class="fild" value="<?php echo set_value('txtHeight'); ?>" tabindex="16" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Furnished Status</div>
<div class="fldblks">
<select name="cmbFurnishedStatus" id="cmbFurnishedStatus" class="fild" tabindex="17" >
	<option value="">Select Status</option>
        
	<option value="Furnished">Furnished</option>
	<option value="Unfurnished">Unfurnished</option>
	<option value="Semi-Furnished">Semi-Furnished</option>
        <option value="Any">Any</option>
        
</select>
	
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Frontage</div>
<div class="fldblks"><input type="text" name="txtFrontage" id="txtFrontage" class="fild" value="<?php echo set_value('txtFrontage'); ?>" tabindex="18" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Source</div>
<div class="fldblks">
	<select name="cmbSource" id="cmbSource" class="fild" tabindex="19">
	<option value="">Select Source</option>
	<?php 
		$this->db->order_by('cSourceName', 'asc');
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('source_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Source_Id = trim($row['iSourceId']);
				$Source_Name = trim($row['cSourceName']);
			?>
				<option value="<?php echo $Source_Id; ?>"><?php echo $Source_Name; ?></option>
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

<!--
<div class="Txtblks">Property Purpose</div>
<div class="fldblks">
<select name="cmbPropertyPurpose" id="cmbPropertyPurpose" class="fild" tabindex="16">
<option value="">Select Property Purpose</option>
<option value="Sale">Sale</option>
<option value="Rental">Rental</option>
<select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>
-->

<div class="Txtblks">Business Purpose</div>
<div class="fldblks">
	<select name="cmbBusinessPurpose" id="cmbBusinessPurpose" class="fild" tabindex="20">
	<option value="">Select Business Purpose</option>
	<?php 
		$this->db->order_by('cBusinessPurposeName', 'asc');
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('business_purpose_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$BusinessPurpose_Id = trim($row['iBusinessPurposeId']);
				$BusinessPurpose_Name = trim($row['cBusinessPurposeName']);
			?>
				<option value="<?php echo $BusinessPurpose_Id; ?>"><?php echo $BusinessPurpose_Name; ?></option>
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

<div class="Txtblks">Property Category</div>
<div class="fldblks">
	<select name="cmbPropertyCategory" id="cmbPropertyCategory" class="fild" tabindex="21">
	<option value="">Select Property Category</option>
	<?php 
		$this->db->order_by('cPropertyCategoryName', 'asc');
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('property_category_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$PropertyCategory_Id = trim($row['iPropertyCategoryId']);
				$PropertyCategory_Name = trim($row['cPropertyCategoryName']);
			?>
				<option value="<?php echo $PropertyCategory_Id; ?>"><?php echo $PropertyCategory_Name; ?></option>
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

<div class="Txtblks">Requirement Type</div>
<div class="fldblks">
<select name="cmbRequirementType" id="cmbRequirementType" class="fild" tabindex="22">
<option value="">Select Requirement Type</option>
<option value="Purchase">Purchase</option>
<option value="Lease">Lease</option>
<option value="Any">Any</option>

</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Budget</div>
<div class="fldblks"><input type="text" name="txtBudgetPerMonth" id="txtBudgetPerMonth" class="fild" value="<?php echo set_value('txtBudgetPerMonth'); ?>" tabindex="23" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Floor Level Preference</div>
<div class="fldblks"><input type="text" name="txtFloorLevelPreference" id="txtFloorLevelPreference" class="fild" value="<?php echo set_value('txtFloorLevelPreference'); ?>" tabindex="24" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Escalation</div>
<div class="fldblks">
	<select name="cmbEscalation" id="cmbEscalation" class="fild" tabindex="25">
	<option value="">Select Escalation</option>
	<?php 
		$this->db->order_by('cEscalationName', 'asc');
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('escalation_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Escalation_Id = trim($row['iEscalationId']);
				$Escalation_Name = trim($row['cEscalationName']);
			?>
				<option value="<?php echo $Escalation_Id; ?>"><?php echo $Escalation_Name; ?></option>
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

<div class="Txtblks">Lease Period Preference</div>
<div class="fldblks"><textarea name="txtLeasePeriodPreference" id="txtLeasePeriodPreference" class="fild" tabindex="26"><?php echo set_value('txtLeasePeriodPreference'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Rent Free Fit Out Period</div>
<div class="fldblks"><textarea name="txtRentFreeFitOutPeriod" id="txtRentFreeFitOutPeriod" class="fild" tabindex="27"><?php echo set_value('txtRentFreeFitOutPeriod'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Power Load</div>
<div class="fldblks"><textarea name="txtPowerLoad" id="txtPowerLoad" class="fild" tabindex="28"><?php echo set_value('txtPowerLoad'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Power Backup</div>
<div class="fldblks">
<select name="cmbPowerBackup" id="cmbPowerBackup" class="fild" tabindex="29">
<option value="">Select Power Backup</option>
<option value="Required">Required</option>
<option value="Not Required">Not Required</option>
</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Expected Launch Date</div>
<div class="fldblks"><input type="text" name="txtExpectedLaunchDate" id="txtExpectedLaunchDate" class="fild" style="width:302px;" value="<?php echo set_value('txtExpectedLaunchDate'); ?>" readonly="readonly" tabindex="30" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Tagline for Website</div>
<div class="fldblks"><input type="text" name="txtRequirementTaglineForWebsite" id="txtRequirementTaglineForWebsite" class="fild" value="<?php echo set_value('txtRequirementTaglineForWebsite'); ?>" tabindex="31" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Remarks</div>
<div class="fldblks"><textarea name="txtRemarks" id="txtRemarks" class="fild"  tabindex="32"><?php echo set_value('txtRemarks'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<fieldset><legend>Landlord Scope of Work</legend>

<div class="Txtblks">Registration Expenses To Be Borne By</div>
<div class="fldblks">
<select name="cmbRegistrationExpensesToBeBorneBy" id="cmbRegistrationExpensesToBeBorneBy" class="fild" tabindex="33">
<option value="">Select Registration Expenses To Be Borne By</option>
<option value="50-50">50-50</option>
<option value="By Lessor">By Lessor </option>
<option value="By Lessee">By Lessee </option>
</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Taxation To Be Borne By</div>
<div class="fldblks">
<select name="cmbTaxationToBeBorneBy" id="cmbTaxationToBeBorneBy" class="fild" tabindex="34">
<option value="">Select Taxation To Be Borne By</option>
<option value="50-50">50-50</option>
<option value="By Lessor">By Lessor </option>
<option value="By Lessee">By Lessee </option>
</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Lock In Period</div>
<div class="fldblks"><input type="text" name="txtLockInPeriod" id="txtLockInPeriod" class="fild" value="<?php echo set_value('txtLockInPeriod'); ?>" tabindex="35" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Estimated Interior Budget</div>
<div class="fldblks"><input type="text" name="txtEstimatedInteriorBudget" id="txtEstimatedInteriorBudget" class="fild" value="<?php echo set_value('txtEstimatedInteriorBudget'); ?>" tabindex="36" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Parking Preference</div>
<div class="fldblks">
<select name="cmbParkingPreference" id="cmbParkingPreference" class="fild" tabindex="37">
<option value="">Select Parking Preference</option>
<option value="Two Wheelers Only">Two Wheelers Only</option>
<option value="Four Wheelers Only">Four Wheelers Only</option>
<option value="All Vehicles">All Vehicles</option>
<option value="No Parking">No Parking</option>
</select></div>
<div class="Txtblks">&nbsp;</div>`
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<fieldset><legend>Commercials / Terms & Conditions</legend>

<div class="Txtblks">Agreement Date</div>
<div class="fldblks"><input type="text" name="txtAgreementDate" id="txtAgreementDate" class="fild" style="width:302px;" value="<?php echo set_value('txtAgreementDate'); ?>" readonly="readonly" tabindex="38" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Agreement Place</div>
<div class="fldblks"><input type="text" name="txtAgreementPlace" id="txtAgreementPlace" class="fild" value="<?php echo set_value('txtAgreementPlace'); ?>" tabindex="39" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 1 During Agreement</div>
<div class="fldblks"><input type="text" name="txtPerson1DuringAgreement" id="txtPerson1DuringAgreement" class="fild" value="<?php echo set_value('txtPerson1DuringAgreement'); ?>" tabindex="40" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 2 During Agreement</div>
<div class="fldblks"><input type="text" name="txtPerson2DuringAgreement" id="txtPerson2DuringAgreement" class="fild" value="<?php echo set_value('txtPerson2DuringAgreement'); ?>" tabindex="41" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Attach Agreement Copy</div>
					 <input type="hidden" name="hfAgreementFilePath" id="hfAgreementFilePath" value="" />
					 <input type="hidden" name="hfAgreementFileName" id="hfAgreementFileName" value="" />
<div class="fldblks"><input type="file" name="txtAgreement" id="txtAgreement" class="fild" tabindex="42" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks" id="dvAgreementFile" style="display:none; font-size:10px; text-align:left; border:0px solid blue;">
	<div style="font-size:12px; font-weight:bold; float:left; width:25%; border:0px solid red;">Uploaded :</div>
	<div id="dvAgreementName" style="font-size:12px; float:left; width:60%; border:0px solid red;"> </div>
	<div style="float:left; width:15%; border:0px solid red;"><a href="#" onclick="DeleteAgreement();"><img src="<?php echo base_url(); ?>images/remove.png" align="center" height="18" width="42" /></a></div>
</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks"><input type="button" name="btnUploadAgreement" id="btnUploadAgreement" value="Upload Agreement" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Service Charges for Linkers</div>
<div class="fldblks"><textarea name="txtServiceChargesForLinkers" id="txtServiceChargesForLinkers" class="fild" tabindex="44"><?php echo set_value('txtServiceChargesForLinkers'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Paste Terms and Conditions here</div>
<div class="fldblks"><textarea name="txtTermsAndConditions" id="txtTermsAndConditions" class="fild" tabindex="43"><?php echo set_value('txtTermsAndConditions'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Accept T&C</div>
<div class="fldblks"><input type="checkbox" name="chkAcceptTermsAndConditions" id="chkAcceptTermsAndConditions" value="1" <?php echo set_checkbox('chkAcceptTermsAndConditions', '1'); ?> /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

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

<!------------------------------------------------------------------------------------------------------------------------------------------------------------>

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this);" />


&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/dashboard"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

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
	$("#txtDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		maxDate: 0,
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});
        
        
        var Mydate = new Date();  
	
	var day = Mydate.getDate();
	var dayval =  day < 10 ? '0' + day : '' + day;
	
	var month = Mydate.getMonth() + 1;
	var monval =  month < 10 ? '0' + month : '' + month;

	var newdat = (monval +"/"+ dayval+"/"+Mydate.getFullYear());
	var splitdt = newdat.split("/");
	
	var defaultcurrdt = splitdt[1]+"/"+splitdt[0]+"/"+splitdt[2];
	$("#txtDate").val(defaultcurrdt);
        
	
	$("#txtExpectedLaunchDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});
	
	$("#txtAgreementDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});
	
	$('#btnUploadAgreement').click(function(e) {
		
		//e.preventDefault();
		
		$("#btnUploadAgreement").val("uploading...");
		
		$.ajaxFileUpload({
			url 			: "<?php echo site_url(); ?>/dashboard/upload_requirement_agreement_file", 
			secureuri		:false,
			fileElementId	:'txtAgreement',
			dataType		: 'json',
			success	: function (data, status)
			{
				//alert(data.status);
				if(data.status != 'error')
				{
					$("#hfAgreementFilePath").val(data.agreement_file_path);
				    $("#hfAgreementFileName").val(data.agreement_file_name);
				    $("#dvAgreementName").html('('+data.agreement_file_name+')');
				    $("#dvAgreementFile").css("display", "block");
				    $("#txtAgreement").disabled = true;
				    $("#btnUploadAgreement").val("Upload Agreement");
				    alert(data.msg);	
				}
			}
		});
		return false;
	});
});	
</script>

<script type="text/javascript" language="javascript">
function ChangeClient()
{
	if($("#cmbClient").val()!='')
	{
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url();?>index.php/dashboard/getcontactpersonbyclient",
			data: "cmbClient="+$("#cmbClient").val(),
			success: function(details){
				
				$('#cmbContactPerson').children('option:not(:first)').remove();
				$("#dvDesignation").text('');
				$("#dvPhoneNo1").text('');
				$("#dvPhoneNo2").text('');
				$("#dvEmail").text('');
                                $("#dvEmaildata").val('');
                                
			
				$.each(details,function(contactpersoncolumn,contactpersonname) {	 
				
					var opt = $('<option />'); 									
				
						opt.val(contactpersoncolumn);
						opt.text(contactpersonname);
						
					$('#cmbContactPerson').append(opt); 		
				});
			}
		});
	}
	else
	{
		$('#cmbContactPerson').children('option:not(:first)').remove();
		$("#dvDesignation").text('');
		$("#dvPhoneNo1").text('');
		$("#dvPhoneNo2").text('');
		$("#dvEmail").text('');
                $("#dvEmaildata").val('');
	}
}
</script>

<script type="text/javascript" language="javascript">
function ChangeContactPerson()
{
	if($("#cmbContactPerson").val()!='')
	{
		var url = "<?php echo base_url(); ?>index.php/dashboard/getcontactdetailsbycontactperson";
		
		$.post(url,{cmbClient:$("#cmbClient").val(),cmbContactPerson:$("#cmbContactPerson").val()},function(responsedata,status){	
			
			if(responsedata!='noresultfound')
			{
				var resdata = responsedata.split('~');
				
				var ContactPersonName = resdata[0];
				var ContactPersonDesignation = resdata[1];
				var ContactPersonPhoneNo1 = resdata[2];
				var ContactPersonPhoneNo2 = resdata[3];
				var ContactPersonEmail = resdata[4];
				
				$("#dvDesignation").text(ContactPersonDesignation);
				$("#dvPhoneNo1").text(ContactPersonPhoneNo1);
				$("#dvPhoneNo2").text(ContactPersonPhoneNo2);
				$("#dvEmail").text(ContactPersonEmail);
                                $("#dvEmaildata").val(ContactPersonEmail);
			}
			else
			{
				$("#dvDesignation").text('');
				$("#dvPhoneNo1").text('');
				$("#dvPhoneNo2").text('');
				$("#dvEmail").text('');
                                $("#dvEmaildata").val('');
			}
		});
	}
	else
	{
		$("#dvDesignation").text('');
		$("#dvPhoneNo1").text('');
		$("#dvPhoneNo2").text('');
		$("#dvEmail").text('');
                $("#dvEmaildata").val('');
	}
}
</script>


<script type="text/javascript" language="javascript">
function getDistrictByStateId()
{	
	if($("#cmbState").val()=='')
	{	
		alert("Please Select State");
		$("#cmbState").focus();
		$('#cmbDistrict').children('option:not(:first)').remove();
		$('#cmbCity').children('option:not(:first)').remove();
		return false;
	}
	else
	{
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url();?>index.php/dashboard/getdistrictbystate",
			data: "cmbState="+$("#cmbState").val(),
			success: function(details){
				
				$('#cmbDistrict').children('option:not(:first)').remove();
				
				$.each(details,function(districtid,districtname) {	 
				
					var opt = $('<option />'); 									
				
						opt.val(districtid);
						opt.text(districtname);
						
					$('#cmbDistrict').append(opt); 		
				});
				
				getCityByDistrictIdAndStateId();
			}
		});
	}
}	
</script>

<script type="text/javascript" language="javascript">
function getCityByDistrictIdAndStateId()
{
	$('#cmbCity').children('option:not(:first)').remove();	

	$.ajax({
		type: "POST",
		dataType: 'json',
		url: "<?php echo base_url();?>index.php/dashboard/getcitybystateanddistrict",
		data: "cmbState="+$("#cmbState").val()+"&cmbDistrict="+$("#cmbDistrict").val(),
		success: function(details){
			
			$('#cmbCity').children('option:not(:first)').remove();
			
			$.each(details,function(cityid,cityname) {	 
			
				var opt = $('<option />'); 									
				
					opt.val(cityid);
					opt.text(cityname);
				
				$('#cmbCity').append(opt); 		    			
			});
			
			getLocationByCityIdAndDistrictIdAndStateId();
		}
	});
}	
</script>

<script type="text/javascript" language="javascript">
function getLocationByCityIdAndDistrictIdAndStateId()
{
	$('#cmbLocation').children('option:not(:first)').remove();	

	$.ajax({
		type: "POST",
		dataType: 'json',
		url: "<?php echo base_url();?>index.php/dashboard/getlocationbystateanddistrictandcity",
		data: "cmbState="+$("#cmbState").val()+"&cmbDistrict="+$("#cmbDistrict").val()+"&cmbCity="+$("#cmbCity").val(),
		success: function(details){
			$('#cmbLocation').children('option:not(:first)').remove();
			
			$.each(details,function(locationid,locationname) {	 
			
				var opt = $('<option />'); 									
				
					opt.val(locationid);
					opt.text(locationname);
				$('#cmbLocation').append(opt); 		    			
			});
		}
	});
}	
</script>

<script type="text/javascript" language="javascript">
function FormValidate(btn)
{
    var cmbClientid = $("#cmbClient").val();
    
    
    if($("#txtDate").val()=='')
    {	
        alert("Please select Date");
        $("#txtDate").focus();
        return false;
    }
	else if($("#txtRequirementTitle").val()=='')
    {	
        alert("Please enter Requirement Title");
        $("#txtRequirementTitle").focus();
        return false;
    }
	else if($("#cmbClient").val()=='')
    {	
        alert("Please select Client");
        $("#cmbClient").focus();
        return false;
    }
    else
    {
		var data = $("#addForm").serialize();
		
		var url = "<?php echo base_url(); ?>index.php/dashboard/add_requirement_master";
		
		btn.disabled = true;
		btn.value = 'Submitting...';
	
		$.post(url,data,function(responsedata,status){
		  
		  //alert(responsedata);
		  
			if(responsedata)
			{
				if(responsedata.status == 1)
				{					
					btn.disabled = false;
					btn.value = 'Submit';
					alert(responsedata.msg);
					var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_requirement_master/"+cmbClientid;
					$(location).attr('href',redirecturl);	
				}
				else if(responsedata.status == 0)
				{					
					btn.disabled = false;
					btn.value = 'Submit';
					alert("Title already exist!");
					// var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_requirement_master/"+cmbClientid;
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
}
</script>


<script>
    
//$( "#cmbFurnishedStatus" ).blur(function() {  
//    $("html, body").animate({ scrollTop: 800 }, 600);
//    
//    return false;
//});

 
$( "#txtDate" ).blur(function() {  
       $("#ui-datepicker-div").hide();
    return false;
});



</script>