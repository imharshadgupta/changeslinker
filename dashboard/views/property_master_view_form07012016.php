<!--==============================Form=================================-->

<form name="editForm" id="editForm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="hfPropertyTypeId" id="hfPropertyTypeId" value="<?php echo set_value('hfPropertyTypeId',$PropertyTypeId); ?>"/>
<input type="hidden" name="hfActive" id="hfActive" value="<?php echo set_value('hfActive',$Active); ?>" />
<div class="inner_form">
<h2>View Property Details</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>General Details</legend>

<div class="Txtblks">Date</div>
<div class="fldblks"><input type="text" name="txtDate" id="txtDate" class="fild" style="width:302px;" value="<?php echo set_value('txtDate',$Date); ?>" tabindex="1" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Name</div>
<div class="fldblks"><input type="text" name="txtPropertyName" id="txtPropertyName" class="fild" value="<?php echo set_value('txtPropertyName',$PropertyName); ?>" tabindex="2" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Client</div>
<div class="fldblks">
	<select name="cmbClient" id="cmbClient" class="fild chzn-select" tabindex="3" disabled>
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
				<option value="<?php echo $Client_Id; ?>" <?php echo set_select("cmbClient","$Client_Id",($ClientId=="$Client_Id" ? TRUE:'')); ?>><?php echo $Client_Name; ?></option>
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
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Branch</div>
<div class="fldblks">
	<select name="cmbBranch" id="cmbBranch" class="fild" disabled>
	<option value="">Select Branch</option>
	<?php  
		   $this->db->order_by('cBranchName', 'asc');
		   $this->db->where('bActive','1');
		   $this->db->where('bDelete','0');
    $sql = $this->db->get('branch_master');  
    if($sql)
    {
        if(($sql->num_rows) > 0)
        {
            $rows=$sql->result_array();
            
            foreach($rows as $row): 
            
                $Branch_Id = trim($row['iBranchId']);
                $Branch_Name = trim($row['cBranchName']);
            ?>
            <option value="<?php echo $Branch_Id; ?>" <?php echo set_select("cmbBranch","$Branch_Id",($BranchId=="$Branch_Id" ? TRUE:'')); ?>><?php echo $Branch_Name; ?></option>
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
	<select name="cmbState" id="cmbState" class="fild" tabindex="4" onchange="getDistrictByStateId()" disabled>
	<option value="">Select State</option>
	<?php 
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
				<option value="<?php echo $State_Id; ?>" <?php echo set_select("cmbState","$State_Id",($StateId=="$State_Id" ? TRUE:'')); ?>><?php echo $State_Name; ?></option>
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

<div class="Txtblks">District</div>
<div class="fldblks">
	<select name="cmbDistrict" id="cmbDistrict" class="fild" tabindex="5" onchange="getCityByDistrictIdAndStateId()" disabled>
	<option value="">Select District</option>
	<select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">City</div>
<div class="fldblks">
	<select name="cmbCity" id="cmbCity" class="fild" tabindex="6" disabled>
	<option value="">Select City</option>
	<select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Location</div>
<div class="fldblks">
	<select name="cmbLocation" id="cmbLocation" class="fild" tabindex="7" disabled>
	<option value="">Select Location</option>
	<select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Address</div>
<div class="fldblks"><textarea name="txtPropertyAddress" id="txtPropertyAddress" class="fild" tabindex="8" readonly><?php echo set_value('txtPropertyAddress',$PropertyAddress); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Source</div>
<div class="fldblks">
	<select name="cmbSource" id="cmbSource" class="fild" tabindex="8" disabled>
	<option value="">Select Source</option>
	<?php 
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
				<option value="<?php echo $Source_Id; ?>" <?php echo set_select("cmbSource","$Source_Id",($SourceId=="$Source_Id" ? TRUE:'')); ?>><?php echo $Source_Name; ?></option>
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

<div class="Txtblks">Property Category</div>
<div class="fldblks">
	<select name="cmbPropertyCategory" id="cmbPropertyCategory" class="fild" tabindex="9" disabled>
	<option value="">Select Property Category</option>
	<?php 
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('property_category_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Property_Cat_Id = trim($row['iPropertyCategoryId']);
				$Property_Cat_Name = trim($row['cPropertyCategoryName']);
			?>
				<option value="<?php echo $Property_Cat_Id; ?>" <?php echo set_select("cmbPropertyCategory","$Property_Cat_Id",($PropertyCatId=="$Property_Cat_Id" ? TRUE:'')); ?>><?php echo $Property_Cat_Name; ?></option>
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

<div class="Txtblks">Property Type</div>
<div class="fldblks">
	<select name="cmbPropertyType" id="cmbPropertyType" class="fild" tabindex="10" disabled>
	<option value="">Select Property Type</option>
	<?php 
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('property_type_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Property_Type_Id = trim($row['iPropertyTypeId']);
				$Property_Type_Name = trim($row['cPropertyTypeName']);
			?>
				<option value="<?php echo $Property_Type_Id; ?>" <?php echo set_select("cmbPropertyType","$Property_Type_Id",($PropertyTypeId=="$Property_Type_Id" ? TRUE:'')); ?>><?php echo $Property_Type_Name; ?></option>
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

<div class="Txtblks">Property Status</div>
<div class="fldblks">
	<select name="cmbPropertyStatus" id="cmbPropertyStatus" class="fild" tabindex="11" disabled>
	<option value="">Select Property Status</option>
	<?php 
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('property_status_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Property_Status_Id = trim($row['iPropertyStatusId']);
				$Property_Status_Name = trim($row['cPropertyStatusName']);
			?>
				<option value="<?php echo $Property_Status_Id; ?>" <?php echo set_select("cmbPropertyStatus","$Property_Status_Id",($PropertyStatusId=="$Property_Status_Id" ? TRUE:'')); ?>><?php echo $Property_Status_Name; ?></option>
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

<div class="Txtblks">Property Purpose</div>
<div class="fldblks">
<select name="cmbPropertyPurpose" id="cmbPropertyPurpose" class="fild" tabindex="12" disabled>
<option value="">Select Property Purpose</option>
<option value="Sale" <?php echo set_select("cmbPropertyPurpose","Sale",($PropertyPurpose=="Sale" ? TRUE:'')); ?>>Sale</option>
<option value="Rental" <?php echo set_select("cmbPropertyPurpose","Rental",($PropertyPurpose=="Rental" ? TRUE:'')); ?>>Rental</option>
<select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Legal Status</div>
<div class="fldblks">
<select name="cmbPropertyLegalStatus" id="cmbPropertyLegalStatus" class="fild" tabindex="13" disabled>
<option value="">Select Property Legal Status</option>
<option value="Clear" <?php echo set_select("cmbPropertyLegalStatus","Clear",($PropertyLegalStatus=="Clear" ? TRUE:'')); ?>>Clear</option>
<option value="Not Clear" <?php echo set_select("cmbPropertyLegalStatus","Not Clear",($PropertyLegalStatus=="Not Clear" ? TRUE:'')); ?>>Not Clear</option>
<select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Remarks</div>
<div class="fldblks"><textarea name="txtPropertyRemarks" id="txtPropertyRemarks" class="fild" tabindex="14" readonly><?php echo set_value('txtPropertyRemarks',$PropertyRemarks); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<fieldset><legend>Specifications</legend>

<div class="Txtblks">Total Plot Area</div>
<div class="fldblks"><textarea name="txtTotalPlotArea" id="txtTotalPlotArea" class="fild" tabindex="15" readonly><?php echo set_value('txtTotalPlotArea',$TotalPlotArea); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Building Area</div>
<div class="fldblks"><textarea name="txtBuildingArea" id="txtBuildingArea" class="fild" tabindex="16" readonly><?php echo set_value('txtBuildingArea',$BuildingArea); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">No. of floors in Building</div>
<div class="fldblks"><input type="text" name="txtNoOfFloorsInBuilding" id="txtNoOfFloorsInBuilding" class="fild" value="<?php echo set_value('txtNoOfFloorsInBuilding',$NoOfFloorsInBuilding); ?>" tabindex="17" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Ground Coverage</div>
<div class="fldblks"><textarea name="txtGroundCoverage" id="txtGroundCoverage" class="fild" tabindex="18" readonly><?php echo set_value('txtGroundCoverage',$GroundCoverage); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Floor Offered</div>
<div class="fldblks"><input type="text" name="txtFloorOffered" id="txtFloorOffered" class="fild" value="<?php echo set_value('txtFloorOffered',$FloorOffered); ?>" tabindex="19" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Plate Area Of Floor Offered</div>
<div class="fldblks"><textarea name="txtPlateAreaOfFloorOffered" id="txtPlateAreaOfFloorOffered" class="fild" tabindex="20" readonly><?php echo set_value('txtPlateAreaOfFloorOffered',$PlateAreaOfFloorOffered); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Toilet</div>
<div class="fldblks">
<select name="cmbToilet" id="cmbToilet" class="fild" tabindex="21" disabled>
<option value="">Select Toilet</option>
<option value="Public" <?php echo set_select("cmbToilet","Public",($Toilet=="Public" ? TRUE:'')); ?>>Public</option>
<option value="Dedicated" <?php echo set_select("cmbToilet","Dedicated",($Toilet=="Dedicated" ? TRUE:'')); ?>>Dedicated</option>
<select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Parking</div>
<div class="fldblks"><textarea name="txtParking" id="txtParking" class="fild" tabindex="22" readonly><?php echo set_value('txtParking',$Parking); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Carpet Area</div>
<div class="fldblks"><textarea name="txtCarpetArea" id="txtCarpetArea" class="fild" tabindex="23" readonly><?php echo set_value('txtCarpetArea',$CarpetArea); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Built Up Area</div>
<div class="fldblks"><textarea name="txtBuiltUpArea" id="txtBuiltUpArea" class="fild" tabindex="24" readonly><?php echo set_value('txtBuiltUpArea',$BuiltUpArea); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Super Built Up Area</div>
<div class="fldblks"><textarea name="txtSuperBuiltUpArea" id="txtSuperBuiltUpArea" class="fild" tabindex="25" readonly><?php echo set_value('txtSuperBuiltUpArea',$SuperBuiltUpArea); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Frontage</div>
<div class="fldblks"><textarea name="txtFrontage" id="txtFrontage" class="fild" tabindex="26" readonly><?php echo set_value('txtFrontage',$Frontage); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Depth</div>
<div class="fldblks"><input type="text" name="txtDepth" id="txtDepth" class="fild" value="<?php echo set_value('txtDepth',$Depth); ?>" tabindex="27" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Height</div>
<div class="fldblks"><input type="text" name="txtHeight" id="txtHeight" class="fild" value="<?php echo set_value('txtHeight',$Height); ?>" tabindex="28" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">Property Furnished Status</div>
<div class="fldblks">
<select name="cmbPropertyFurnishedStatus" id="cmbPropertyFurnishedStatus" class="fild" tabindex="33">
<option value="">Select Furnished Status</option>
<option value="Furnished" <?php echo set_select("cmbPropertyFurnishedStatus","Furnished",($PropertyFurnishedStatus=="Furnished" ? TRUE:'')); ?>>Furnished</option>
<option value="Unfurnished" <?php echo set_select("cmbPropertyFurnishedStatus","Unfurnished",($PropertyFurnishedStatus=="Unfurnished" ? TRUE:'')); ?>>Unfurnished</option>
</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">Power Load</div>
<div class="fldblks"><textarea name="txtPowerLoad" id="txtPowerLoad" class="fild" tabindex="46" readonly><?php echo set_value('txtPowerLoad',$PowerLoad); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Power Backup</div>
<div class="fldblks"><textarea name="txtPowerBackup" id="txtPowerBackup" class="fild" tabindex="47" readonly><?php echo set_value('txtPowerBackup',$PowerBackup); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<fieldset><legend>Commercials</legend>

<div class="Txtblks">Agreement Type</div>
<div class="fldblks">
	<select name="cmbAgreementType" id="cmbAgreementType" class="fild" tabindex="29" disabled>
	<option value="">Select Agreement Type</option>
	<?php 
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('agreement_type_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Agreement_Type_Id = trim($row['iAgreementTypeId']);
				$Agreement_Type_Name = trim($row['cAgreementTypeName']);
			?>
				<option value="<?php echo $Agreement_Type_Id; ?>" <?php echo set_select("cmbAgreementType","$Agreement_Type_Id",($AgreementTypeId=="$Agreement_Type_Id" ? TRUE:'')); ?>><?php echo $Agreement_Type_Name; ?></option>
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

<div class="Txtblks">Demand (Per Sq.Feet)(INR)</div>
<div class="fldblks"><textarea name="txtDemandPerSqFeet" id="txtDemandPerSqFeet" class="fild" tabindex="30" readonly><?php echo set_value('txtDemandPerSqFeet',$DemandPerSqFeet); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Demand (Gross)(INR)</div>
<div class="fldblks"><textarea name="txtDemandGross" id="txtDemandGross" class="fild" tabindex="31" readonly><?php echo set_value('txtDemandGross',$DemandGross); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Security Deposit</div>
<div class="fldblks"><textarea name="txtSecurityDeposit" id="txtSecurityDeposit" class="fild" tabindex="32" readonly><?php echo set_value('txtSecurityDeposit',$SecurityDeposit); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Escalation</div>
<div class="fldblks">
	<select name="cmbEscalation" id="cmbEscalation" class="fild" tabindex="33" disabled>
	<option value="">Select Escalation</option>
	<?php 
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
				<option value="<?php echo $Escalation_Id; ?>" <?php echo set_select("cmbEscalation","$Escalation_Id",($EscalationId=="$Escalation_Id" ? TRUE:'')); ?>><?php echo $Escalation_Name; ?></option>
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

<div class="Txtblks">Security Deposit</div>
<div class="fldblks"><textarea name="txtSecurityDeposit" id="txtSecurityDeposit" class="fild" tabindex="34" readonly><?php echo set_value('txtSecurityDeposit',$SecurityDeposit); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">CAM (INR)</div>
<div class="fldblks"><input type="text" name="txtCAM" id="txtCAM" class="fild" value="<?php echo set_value('txtCAM',$CAM); ?>" tabindex="35" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Service Tax on Lesser (INR)</div>
<div class="fldblks"><input type="text" name="txtServiceTaxOnLessor" id="txtServiceTaxOnLessor" class="fild" value="<?php echo set_value('txtServiceTaxOnLessor',$ServiceTaxOnLessor); ?>" tabindex="36" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Service Tax on Lessee (INR)</div>
<div class="fldblks"><input type="text" name="txtServiceTaxOnLessee" id="txtServiceTaxOnLessee" class="fild" value="<?php echo set_value('txtServiceTaxOnLessee',$ServiceTaxOnLessee); ?>" tabindex="37" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Tax on Lesser (INR)</div>
<div class="fldblks"><input type="text" name="txtPropertyTaxOnLessor" id="txtPropertyTaxOnLessor" class="fild" value="<?php echo set_value('txtPropertyTaxOnLesser',$PropertyTaxOnLessor); ?>" tabindex="38" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Tax on Lessee (INR)</div>
<div class="fldblks"><input type="text" name="txtPropertyTaxOnLessee" id="txtPropertyTaxOnLessee" class="fild" value="<?php echo set_value('txtPropertyTaxOnLessee',$PropertyTaxOnLessee); ?>" tabindex="39" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Stamp Duty & Registration</div>
<div class="fldblks">
<select name="cmbStampDutyAndRegistration" id="cmbStampDutyAndRegistration" class="fild" tabindex="40" disabled>
<option value="">Select Stamp Duty & Registration</option>
<option value="50-50" <?php echo set_select("cmbStampDutyAndRegistration","50-50",($StampDutyAndRegistration=="50-50" ? TRUE:'')); ?>>50-50</option>
<option value="On Lesser" <?php echo set_select("cmbStampDutyAndRegistration","On Lesser",($StampDutyAndRegistration=="On Lesser" ? TRUE:'')); ?>>On Lesser</option>
<option value="On Lessee" <?php echo set_select("cmbStampDutyAndRegistration","On Lessee",($StampDutyAndRegistration=="On Lessee" ? TRUE:'')); ?>>On Lessee</option>
<select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Lock In</div>
<div class="fldblks">
<select name="cmbLockIn" id="cmbLockIn" class="fild" tabindex="41" disabled>
<option value="">Select Lock In</option>
<option value="Required" <?php echo set_select("cmbLockIn","Required",($LockIn=="Required" ? TRUE:'')); ?>>Required</option>
<option value="Not Required" <?php echo set_select("cmbLockIn","Not Required",($LockIn=="Not Required" ? TRUE:'')); ?>>Not Required</option>
<select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Lock In Duration</div>
<div class="fldblks"><textarea name="txtLockInDuration" id="txtLockInDuration" class="fild" tabindex="42" readonly><?php echo set_value('txtLockInDuration',$LockInDuration); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Rent Free Period</div>
<div class="fldblks">
<select name="cmbRentFreePeriod" id="cmbRentFreePeriod" class="fild" tabindex="43" disabled>
<option value="">Select Rent Free Period</option>
<option value="45 Days" <?php echo set_select("cmbRentFreePeriod","45 Days",($RentFreePeriod=="45 Days" ? TRUE:'')); ?>>45 Days</option>
<option value="60 Days" <?php echo set_select("cmbRentFreePeriod","60 Days",($RentFreePeriod=="60 Days" ? TRUE:'')); ?>>60 Days</option>
<option value="90 Days" <?php echo set_select("cmbRentFreePeriod","90 Days",($RentFreePeriod=="90 Days" ? TRUE:'')); ?>>90 Days</option>
<option value="120 Days" <?php echo set_select("cmbRentFreePeriod","120 Days",($RentFreePeriod=="120 Days" ? TRUE:'')); ?>>120 Days</option>
<option value="Above 6 Months" <?php echo set_select("cmbRentFreePeriod","Above 6 Months",($RentFreePeriod=="Above 6 Months" ? TRUE:'')); ?>>Above 6 Months</option>
<select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Notice Period</div>
<div class="fldblks"><input type="text" name="txtNoticePeriod" id="txtNoticePeriod" class="fild" value="<?php echo set_value('txtNoticePeriod',$NoticePeriod); ?>" tabindex="44" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Possession Status</div>
<div class="fldblks"><input type="text" name="txtPossessionStatus" id="txtPossessionStatus" class="fild" value="<?php echo set_value('txtPossessionStatus',$PossessionStatus); ?>" tabindex="45" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">Current Tenant</div>
<div class="fldblks"><textarea name="txtCurrentTenant" id="txtCurrentTenant" class="fild" tabindex="48" readonly><?php echo set_value('txtCurrentTenant',$CurrentTenant); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Lease up to</div>
<div class="fldblks"><input type="text" name="txtLeaseUpToDate" id="txtLeaseUpToDate" class="fild" style="width:302px;" value="<?php echo set_value('txtLeaseUpToDate',$LeaseUpToDate); ?>" tabindex="49" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Previous Tenant</div>
<div class="fldblks"><textarea name="txtPreviousTenant" id="txtPreviousTenant" class="fild" tabindex="50" readonly><?php echo set_value('txtPreviousTenant',$PreviousTenant); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>


<fieldset><legend>Terms & Condition</legend>

<div class="Txtblks">Agreement Date</div>
<div class="fldblks"><input type="text" name="txtAgreementDate" id="txtAgreementDate" class="fild" style="width:302px;" value="<?php echo set_value('txtAgreementDate',$AgreementDate); ?>" readonly="readonly" tabindex="51" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Agreement Place</div>
<div class="fldblks"><input type="text" name="txtAgreementPlace" id="txtAgreementPlace" class="fild" value="<?php echo set_value('txtAgreementPlace',$AgreementPlace); ?>" tabindex="52" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 1 During Agreement</div>
<div class="fldblks"><input type="text" name="txtPerson1DuringAgreement" id="txtPerson1DuringAgreement" class="fild" value="<?php echo set_value('txtPerson1DuringAgreement',$Person1DuringAgreement); ?>" tabindex="53" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 2 During Agreement</div>
<div class="fldblks"><input type="text" name="txtPerson2DuringAgreement" id="txtPerson2DuringAgreement" class="fild" value="<?php echo set_value('txtPerson2DuringAgreement',$Person2DuringAgreement); ?>" tabindex="54" readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<fieldset>
<legend>Existing Agreement</legend>
	<?php 
	if((isset($AgreementFileName)) && (!empty($AgreementFileName)))
	{
	?>
		<div align="left">
			<div class="Txtblks">&nbsp;</div>
			<div class="Txtblks" style="text-align:left;"><strong>SNo.</strong></div>
			<div class="fldblks" style="text-align:left;"><strong>Title</strong></div>
			<div class="clear"></div>
		</div>
		<div align="left">
			<div class="Txtblks">&nbsp;</div>
			<div class="Txtblks" style="text-align:left;">1.</div>
			<div class="fldblks" style="text-align:left;"><?php echo $AgreementFileName; ?></div>

			<!--<div class="fldblks"><input type='button' value='Delete' id='delButton' onclick="DeleteExistingAgreement('<?php //echo $PropertyId; ?>','<?php //echo $AgreementFileName; ?>','<?php //echo $AgreementFilePath; ?>')"></div>-->
			<div class="clear"></div>
		</div>
	<?php 
	}
	else
	{
	?>
		<div align="left">
			<div class="Txtblks">&nbsp;</div>
			<div class="Txtblks" style="text-align:left;"><strong>No Agreement file exists.</strong></div>
			<div class="fldblks">&nbsp;</div>
			<div class="clear"></div>
		</div>
    <?php 
	}
	?>
</fieldset>

<div class="Txtblks">Paste Terms and Conditions here</div>
<div class="fldblks"><textarea name="txtTermsAndConditions" id="txtTermsAndConditions" class="fild" tabindex="56" readonly><?php echo set_value('txtTermsAndConditions',$TermsAndConditions); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<!------------------------------------------------------------------------------------------------------------------------------------------------------------->

<fieldset>
<legend>Existing Uploaded Docs</legend>
	<?php 
	if(count($AttachmentRows)>0)
	{
	?>
    <div align="left">
    	<div class="Txtblks">&nbsp;</div>
        <div class="Txtblks" style="text-align:left;text-decoration:underline;"><strong>SNo.</strong></div>
        <div class="fldblks" style="text-align:left;text-decoration:underline;"><strong>Title</strong></div>
		<div class="fldblks" style="text-align:left;text-decoration:underline;"><strong>Image</strong></div>
        <div class="clear"></div>
    </div>

	<?php 
	}
	else
	{
	?>
    <div align="left">
    	<div class="Txtblks">&nbsp;</div>
        <div class="Txtblks" style="text-align:left;"><strong>No doc exists.</strong></div>
        <div class="fldblks">&nbsp;</div>
        <div class="clear"></div>
    </div>
    <?php 
	}
	?>
	
	<?php 
	$i=1;
	foreach($AttachmentRows as $docrow)
	{
		$PropertyAttachmentId = trim($docrow['iPropertyAttachmentId']);
		$PropertyId = trim($docrow['iPropertyId']);
		$AttachmentTitle = trim($docrow['cAttachmentTitle']);
		$AttachmentFilePath = trim($docrow['cAttachmentFilePath']);
		$AttachmentFileName = trim($docrow['cAttachmentFileName']);
		
		$ImgUrl =  base_url($AttachmentFilePath);
	?>
    	<div align="left">
        	<div class="Txtblks">&nbsp;</div>
            <div class="Txtblks" style="text-align:left;"><?php echo $i; ?>.</div>
            <div class="fldblks" style="text-align:left;"><?php echo $AttachmentTitle; ?></div>
			<div class="fldblks" style="text-align:left;"><img src="<?php echo $ImgUrl; ?>" title="<?php echo $AttachmentTitle; ?>" height="50" width="100" /></div>	
        <!--<div class="fldblks"><input type='button' value='Delete' id='delButton' onclick="DeleteEmpExistingDoc('<?php //echo $DocId; ?>','<?php //echo $EmpId; ?>')"></div>-->
            <div class="clear"></div>
		</div>
		
	<?php
    	$i++;
	}
	?>

</fieldset>

<div class="Txtblks">Active</div>
<div class="fldblks"><input type="checkbox" name="chkActive" id="chkActive" onclick="ChangeActive();" value="1" <?php echo set_checkbox('chkActive', '1', ($Active=='1' ? TRUE:'')); ?>  readonly /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<!------------------------------------------------------------------------------------------------------------------------------------------------------------->

<div class="submit"><a href="<?php echo base_url(); ?>index.php/dashboard/listing_property_master"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

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
	$("#txtDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});
	
	$("#txtLeaseUpToDate").datepicker({ 
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
	
	ChangeClient();
	getDistrictByStateId();
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
			}
			else
			{
				$("#dvDesignation").text('');
				$("#dvPhoneNo1").text('');
				$("#dvPhoneNo2").text('');
				$("#dvEmail").text('');
			}
		});
	}
	else
	{
		$("#dvDesignation").text('');
		$("#dvPhoneNo1").text('');
		$("#dvPhoneNo2").text('');
		$("#dvEmail").text('');
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
					
					if(districtid == "<?php echo $DistrictId; ?>"){
						opt.val(districtid);
						opt.text(districtname);
						$(opt).attr('selected', 'selected');
					}		
					else
					{
						opt.val(districtid);
						opt.text(districtname);
					}
					
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
				
				if(cityid == "<?php echo $CityId; ?>"){
					opt.val(cityid);
					opt.text(cityname);
					$(opt).attr('selected', 'selected');
				}		
				else
				{
					opt.val(cityid);
					opt.text(cityname);
				}
				
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
			
				//alert(locationid+","+locationname);
				
				var opt = $('<option />'); 									
			
				if(locationid == "<?php echo $LocationId; ?>"){
					opt.val(locationid);
					opt.text(locationname);
					$(opt).attr('selected', 'selected');
				}		
				else
				{
					opt.val(locationid);
					opt.text(locationname);
				}
					
				$('#cmbLocation').append(opt);
								
			});
		}
	});
}	
</script>