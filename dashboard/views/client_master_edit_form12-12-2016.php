<!--==============================Form=================================-->

<form name="editForm" id="editForm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="hfClientId" id="hfClientId" value="<?php echo set_value('hfClientId',$ClientId); ?>"/>
<input type="hidden" name="hfActive" id="hfActive" value="<?php echo set_value('hfActive',$Active); ?>" />
<div class="inner_form">
<h2>Edit Client Master</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>Details</legend>

<div class="Txtblks">Client Name</div>
<div class="fldblks"><input type="text" name="txtClientName" id="txtClientName" class="fild" value="<?php echo set_value('txtClientName',$ClientName); ?>" tabindex="1" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Address</div>
<div class="fldblks"><textarea name="txtAddress" id="txtAddress" class="fild"  tabindex="2"><?php echo set_value('txtAddress',$Address); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Branch</div>
<div class="fldblks">
	<select name="cmbBranch" id="cmbBranch" class="fild" tabindex="3">
	<option value="">Select Branch</option>
	<?php  
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
	<select name="cmbState" id="cmbState" class="fild" tabindex="3" onchange="getDistrictByStateId()">
	<option value="">Select State</option>
	<?php  
		   $this->db->where('bActive','1');
		   $this->db->where('bDelete','0');
    $sql = $this->db->get('state_master');  
    if($sql)
    {
        if(($sql->num_rows) > 0)
        {
            $rows=$sql->result_array();
            
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
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">District</div>
<div class="fldblks">
	<select name="cmbDistrict" id="cmbDistrict" class="fild" tabindex="4" onchange="getCityByDistrictIdAndStateId()">
	<option value="">Select District</option>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">City</div>
<div class="fldblks">
	<select name="cmbCity" id="cmbCity" class="fild" tabindex="5" onchange="getLocationByCityDistrictState()">
	<option value="">Select City</option>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Location</div>
<div class="fldblks">
	<select name="cmbLocation" id="cmbLocation" class="fild" tabindex="6">
	<option value="">Select Location</option>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Landmark</div>
<div class="fldblks"><textarea name="txtLandmark" id="txtLandmark" class="fild" tabindex="7"><?php echo set_value('txtLandmark',$Landmark); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Source</div>
<div class="fldblks">
	<select name="cmbSource" id="cmbSource" class="fild" tabindex="8">
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
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Contact Person1 Name</div>
<div class="fldblks"><input type="text" name="txtContactPerson1Name" id="txtContactPerson1Name" class="fild" value="<?php echo set_value('txtContactPerson1Name',$ContactPerson1Name); ?>" tabindex="9" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person1 Designation</div>
<div class="fldblks"><input type="text" name="txtContactPerson1Designation" id="txtContactPerson1Designation" class="fild" value="<?php echo set_value('txtContactPerson1Designation',$ContactPerson1Designation); ?>" tabindex="10" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 1 Phone 1</div>
<div class="fldblks"><input type="text" name="txtContactPerson1PhoneNo1" id="txtContactPerson1PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson1PhoneNo1',$ContactPerson1PhoneNo1); ?>" tabindex="11" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 1 Phone 2</div>
<div class="fldblks"><input type="text" name="txtContactPerson1PhoneNo2" id="txtContactPerson1PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson1PhoneNo2',$ContactPerson1PhoneNo2); ?>" tabindex="12" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 1 Email</div>
<div class="fldblks"><input type="text" name="txtContactPerson1Email" id="txtContactPerson1Email" class="fild" value="<?php echo set_value('txtContactPerson1Email',$ContactPerson1Email); ?>" tabindex="13" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Contact Person2 Name</div>
<div class="fldblks"><input type="text" name="txtContactPerson2Name" id="txtContactPerson2Name" class="fild" value="<?php echo set_value('txtContactPerson2Name',$ContactPerson2Name); ?>" tabindex="14" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person2 Designation</div>
<div class="fldblks"><input type="text" name="txtContactPerson2Designation" id="txtContactPerson2Designation" class="fild" value="<?php echo set_value('txtContactPerson2Designation',$ContactPerson2Designation); ?>" tabindex="15" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 2 Phone 1</div>
<div class="fldblks"><input type="text" name="txtContactPerson2PhoneNo1" id="txtContactPerson2PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson2PhoneNo1',$ContactPerson2PhoneNo1); ?>" tabindex="16" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 2 Phone 2</div>
<div class="fldblks"><input type="text" name="txtContactPerson2PhoneNo2" id="txtContactPerson2PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson2PhoneNo2',$ContactPerson2PhoneNo2); ?>" tabindex="17" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 2 Email</div>
<div class="fldblks"><input type="text" name="txtContactPerson2Email" id="txtContactPerson2Email" class="fild" value="<?php echo set_value('txtContactPerson2Email',$ContactPerson2Email); ?>" tabindex="18" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">Contact Person3 Name</div>
<div class="fldblks"><input type="text" name="txtContactPerson3Name" id="txtContactPerson3Name" class="fild" value="<?php echo set_value('txtContactPerson3Name',$ContactPerson3Name); ?>" tabindex="19" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person3 Designation</div>
<div class="fldblks"><input type="text" name="txtContactPerson3Designation" id="txtContactPerson3Designation" class="fild" value="<?php echo set_value('txtContactPerson3Designation',$ContactPerson3Designation); ?>" tabindex="20" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 3 Phone 1</div>
<div class="fldblks"><input type="text" name="txtContactPerson3PhoneNo1" id="txtContactPerson3PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson3PhoneNo1',$ContactPerson3PhoneNo1); ?>" tabindex="21" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 3 Phone 2</div>
<div class="fldblks"><input type="text" name="txtContactPerson3PhoneNo2" id="txtContactPerson3PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson3PhoneNo2',$ContactPerson3PhoneNo2); ?>" tabindex="22" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 3 Email</div>
<div class="fldblks"><input type="text" name="txtContactPerson3Email" id="txtContactPerson3Email" class="fild" value="<?php echo set_value('txtContactPerson3Email',$ContactPerson3Email); ?>" tabindex="23" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>



<div class="Txtblks">Contact Person4 Name</div>
<div class="fldblks"><input type="text" name="txtContactPerson4Name" id="txtContactPerson4Name" class="fild" value="<?php echo set_value('txtContactPerson4Name',$ContactPerson4Name); ?>" tabindex="24" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person4 Designation</div>
<div class="fldblks"><input type="text" name="txtContactPerson4Designation" id="txtContactPerson4Designation" class="fild" value="<?php echo set_value('txtContactPerson4Designation',$ContactPerson4Designation); ?>" tabindex="25" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 4 Phone 1</div>
<div class="fldblks"><input type="text" name="txtContactPerson4PhoneNo1" id="txtContactPerson4PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson4PhoneNo1',$ContactPerson4PhoneNo1); ?>" tabindex="26" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 4 Phone 2</div>
<div class="fldblks"><input type="text" name="txtContactPerson4PhoneNo2" id="txtContactPerson4PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson4PhoneNo2',$ContactPerson4PhoneNo2); ?>" tabindex="27" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 4 Email</div>
<div class="fldblks"><input type="text" name="txtContactPerson4Email" id="txtContactPerson4Email" class="fild" value="<?php echo set_value('txtContactPerson4Email',$ContactPerson4Email); ?>" tabindex="28" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">Contact Person5 Name</div>
<div class="fldblks"><input type="text" name="txtContactPerson5Name" id="txtContactPerson5Name" class="fild" value="<?php echo set_value('txtContactPerson5Name',$ContactPerson5Name); ?>" tabindex="29" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person5 Designation</div>
<div class="fldblks"><input type="text" name="txtContactPerson5Designation" id="txtContactPerson5Designation" class="fild" value="<?php echo set_value('txtContactPerson5Designation',$ContactPerson5Designation); ?>" tabindex="30" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 5 Phone 1</div>
<div class="fldblks"><input type="text" name="txtContactPerson5PhoneNo1" id="txtContactPerson5PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson5PhoneNo1',$ContactPerson5PhoneNo1); ?>" tabindex="31" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 5 Phone 2</div>
<div class="fldblks"><input type="text" name="txtContactPerson5PhoneNo2" id="txtContactPerson5PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson5PhoneNo2',$ContactPerson5PhoneNo2); ?>" tabindex="32" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 5 Email</div>
<div class="fldblks"><input type="text" name="txtContactPerson5Email" id="txtContactPerson5Email" class="fild" value="<?php echo set_value('txtContactPerson5Email',$ContactPerson5Email); ?>" tabindex="33" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">Contact Person6 Name</div>
<div class="fldblks"><input type="text" name="txtContactPerson6Name" id="txtContactPerson6Name" class="fild" value="<?php echo set_value('txtContactPerson6Name',$ContactPerson6Name); ?>" tabindex="34" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person6 Designation</div>
<div class="fldblks"><input type="text" name="txtContactPerson6Designation" id="txtContactPerson6Designation" class="fild" value="<?php echo set_value('txtContactPerson6Designation',$ContactPerson6Designation); ?>" tabindex="35" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 6 Phone 1</div>
<div class="fldblks"><input type="text" name="txtContactPerson6PhoneNo1" id="txtContactPerson6PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson6PhoneNo1',$ContactPerson6PhoneNo1); ?>" tabindex="36" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 6 Phone 2</div>
<div class="fldblks"><input type="text" name="txtContactPerson6PhoneNo2" id="txtContactPerson6PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson6PhoneNo2',$ContactPerson6PhoneNo2); ?>" tabindex="37" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 6 Email</div>
<div class="fldblks"><input type="text" name="txtContactPerson6Email" id="txtContactPerson6Email" class="fild" value="<?php echo set_value('txtContactPerson6Email',$ContactPerson6Email); ?>" tabindex="38" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>



<div class="Txtblks">Contact Person7 Name</div>
<div class="fldblks"><input type="text" name="txtContactPerson7Name" id="txtContactPerson7Name" class="fild" value="<?php echo set_value('txtContactPerson7Name',$ContactPerson7Name); ?>" tabindex="39" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person7 Designation</div>
<div class="fldblks"><input type="text" name="txtContactPerson7Designation" id="txtContactPerson7Designation" class="fild" value="<?php echo set_value('txtContactPerson7Designation',$ContactPerson7Designation); ?>" tabindex="40" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 7 Phone 1</div>
<div class="fldblks"><input type="text" name="txtContactPerson7PhoneNo1" id="txtContactPerson7PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson7PhoneNo1',$ContactPerson7PhoneNo1); ?>" tabindex="41" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 7 Phone 2</div>
<div class="fldblks"><input type="text" name="txtContactPerson7PhoneNo2" id="txtContactPerson7PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson7PhoneNo2',$ContactPerson7PhoneNo2); ?>" tabindex="42" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 7 Email</div>
<div class="fldblks"><input type="text" name="txtContactPerson7Email" id="txtContactPerson7Email" class="fild" value="<?php echo set_value('txtContactPerson7Email',$ContactPerson7Email); ?>" tabindex="43" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">Contact Person8 Name</div>
<div class="fldblks"><input type="text" name="txtContactPerson8Name" id="txtContactPerson8Name" class="fild" value="<?php echo set_value('txtContactPerson8Name',$ContactPerson8Name); ?>" tabindex="44" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person8 Designation</div>
<div class="fldblks"><input type="text" name="txtContactPerson8Designation" id="txtContactPerson8Designation" class="fild" value="<?php echo set_value('txtContactPerson8Designation',$ContactPerson8Designation); ?>" tabindex="45" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 8 Phone 1</div>
<div class="fldblks"><input type="text" name="txtContactPerson8PhoneNo1" id="txtContactPerson8PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson8PhoneNo1',$ContactPerson8PhoneNo1); ?>" tabindex="46" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 8 Phone 2</div>
<div class="fldblks"><input type="text" name="txtContactPerson8PhoneNo2" id="txtContactPerson8PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson8PhoneNo2',$ContactPerson8PhoneNo2); ?>" tabindex="47" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 8 Email</div>
<div class="fldblks"><input type="text" name="txtContactPerson8Email" id="txtContactPerson8Email" class="fild" value="<?php echo set_value('txtContactPerson8Email',$ContactPerson8Email); ?>" tabindex="48" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">Contact Person9 Name</div>
<div class="fldblks"><input type="text" name="txtContactPerson9Name" id="txtContactPerson9Name" class="fild" value="<?php echo set_value('txtContactPerson9Name',$ContactPerson9Name); ?>" tabindex="49" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person9 Designation</div>
<div class="fldblks"><input type="text" name="txtContactPerson9Designation" id="txtContactPerson9Designation" class="fild" value="<?php echo set_value('txtContactPerson9Designation',$ContactPerson9Designation); ?>" tabindex="50" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 9 Phone 1</div>
<div class="fldblks"><input type="text" name="txtContactPerson9PhoneNo1" id="txtContactPerson9PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson9PhoneNo1',$ContactPerson9PhoneNo1); ?>" tabindex="51" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 9 Phone 2</div>
<div class="fldblks"><input type="text" name="txtContactPerson9PhoneNo2" id="txtContactPerson9PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson9PhoneNo2',$ContactPerson9PhoneNo2); ?>" tabindex="52" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 9 Email</div>
<div class="fldblks"><input type="text" name="txtContactPerson9Email" id="txtContactPerson9Email" class="fild" value="<?php echo set_value('txtContactPerson9Email',$ContactPerson9Email); ?>" tabindex="53" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">Contact Person 10 Name</div>
<div class="fldblks"><input type="text" name="txtContactPerson10Name" id="txtContactPerson10Name" class="fild" value="<?php echo set_value('txtContactPerson10Name',$ContactPerson10Name); ?>" tabindex="54" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 10 Designation</div>
<div class="fldblks"><input type="text" name="txtContactPerson10Designation" id="txtContactPerson10Designation" class="fild" value="<?php echo set_value('txtContactPerson10Designation',$ContactPerson10Designation); ?>" tabindex="55" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 10 Phone 1</div>
<div class="fldblks"><input type="text" name="txtContactPerson10PhoneNo1" id="txtContactPerson10PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson10PhoneNo1',$ContactPerson10PhoneNo1); ?>" tabindex="56" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 10 Phone 2</div>
<div class="fldblks"><input type="text" name="txtContactPerson10PhoneNo2" id="txtContactPerson10PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson10PhoneNo2',$ContactPerson10PhoneNo2); ?>" tabindex="57" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 10 Email</div>
<div class="fldblks"><input type="text" name="txtContactPerson10Email" id="txtContactPerson10Email" class="fild" value="<?php echo set_value('txtContactPerson10Email',$ContactPerson10Email); ?>" tabindex="58" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>



<div class="Txtblks">Remarks</div>
<div class="fldblks"><textarea name="txtRemarks" id="txtRemarks" class="fild"  tabindex="59"><?php echo set_value('txtRemarks',$Remarks); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Active</div>
<div class="fldblks"><input type="checkbox" name="chkActive" id="chkActive" onclick="ChangeActive();" value="1" <?php echo set_checkbox('chkActive', '1', ($Active=='1' ? TRUE:'')); ?> /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<!------------------------------------------------------------------------------------------------------------------------------------------------------------>

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this)" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_client_master"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

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
	getDistrictByStateId();
});
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
		$('#cmbLocation').children('option:not(:first)').remove();
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
	$('#cmbLocation').children('option:not(:first)').remove();

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
			
			getLocationByCityDistrictState();
		}
	});
}	
</script>

<script type="text/javascript" language="javascript">
function getLocationByCityDistrictState()
{
	$('#cmbLocation').children('option:not(:first)').remove();
	
	if($("#cmbCity").val()=='')
	{	
		alert("Please Select City");
		$("#cmbCity").focus();
		return false;
	}
	else
	{
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
}	
</script>

<script type="text/javascript" language="javascript">
function FormValidate(btn)
{
    if($("#txtClientName").val()=='')
    {	
        alert("Please enter Client Name");
        $("#txtClientName").focus();
        return false;
    }
    else
    {
		var data = $("#editForm").serialize();
		
		btn.disabled = true;
		btn.value = 'Submitting...';
		
		var url = "<?php echo base_url(); ?>index.php/dashboard/edit_client_master";
		
		$.post(url,data,function(data){	
		
		    if(data)
			{
				if(data.status==1)
				{					
					btn.disabled = false;
					btn.value = 'Submit';
					alert(data.msg);
					var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_client_master";
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


<script>
   
   
     
//$( "#cmbDistrict" ).blur(function() {  
//    $("html, body").animate({ scrollTop: 500 }, 600);
//    
//    return false;
//});
//
// 
//$( "#txtContactPerson2PhoneNo1" ).blur(function() {  
//    $("html, body").animate({ scrollTop: 1000 }, 600);
//    
//    return false;
//});
//
//
//$( "#txtContactPerson4Designation" ).blur(function() {  
//    $("html, body").animate({ scrollTop: 1400 }, 600);
//    
//    return false;
//});
//
//$( "#txtContactPerson5Designation" ).blur(function() {  
//    $("html, body").animate({ scrollTop: 1600 }, 600);
//    
//    return false;
//});
//
//
//$( "#txtContactPerson6PhoneNo1" ).blur(function() {  
//    $("html, body").animate({ scrollTop: 2000 }, 600);
//    
//    return false;
//});
//
//
//$( "#txtContactPerson8PhoneNo2" ).blur(function() {  
//    $("html, body").animate({ scrollTop: 2400 }, 600);
//    
//    return false;
//});
//
//
//$( "#txtContactPerson9Name" ).blur(function() {  
//    $("html, body").animate({ scrollTop: 2800 }, 600);
//    
//    return false;
//});

</script>