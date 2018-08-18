<!--==============================Form=================================-->

<form name="editForm" id="editForm" method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="hfClientId" id="hfClientId" value="<?php echo set_value('hfClientId', $ClientId); ?>"/>
    <input type="hidden" name="hfActive" id="hfActive" value="<?php echo set_value('hfActive', $Active); ?>" />
    <div class="inner_form">
        <h2>Edit Client Master</h2>
        <div class="mfrminner">
            <div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg'); ?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
            <fieldset><legend>Details</legend>

                <div class="Txtblks">Client Name</div>
                <div class="fldblks"><input type="text" name="txtClientName" id="txtClientName" class="fild" value="<?php echo set_value('txtClientName', $ClientName); ?>" tabindex="1" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Address</div>
                <div class="fldblks"><textarea name="txtAddress" id="txtAddress" class="fild"  tabindex="2"><?php echo set_value('txtAddress', $Address); ?></textarea></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Branch</div>
                <div class="fldblks">
                    <select name="cmbBranch" id="cmbBranch" class="fild" tabindex="3">
                        <option value="">Select Branch</option>
                        <?php
                        $this->db->where('bActive', '1');
                        $this->db->where('bDelete', '0');
                        $sql = $this->db->get('branch_master');
                        if ($sql) {
                            if (($sql->num_rows) > 0) {
                                $rows = $sql->result_array();

                                foreach ($rows as $row):

                                    $Branch_Id = trim($row['iBranchId']);
                                    $Branch_Name = trim($row['cBranchName']);
                                    ?>
                                    <option value="<?php echo $Branch_Id; ?>" <?php echo set_select("cmbBranch", "$Branch_Id", ($BranchId == "$Branch_Id" ? TRUE : '')); ?>><?php echo $Branch_Name; ?></option>
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
                        $this->db->where('bActive', '1');
                        $this->db->where('bDelete', '0');
                        $sql = $this->db->get('state_master');
                        if ($sql) {
                            if (($sql->num_rows) > 0) {
                                $rows = $sql->result_array();

                                foreach ($rows as $row):

                                    $State_Id = trim($row['iStateId']);
                                    $State_Name = trim($row['cStateName']);
                                    ?>
                                    <option value="<?php echo $State_Id; ?>" <?php echo set_select("cmbState", "$State_Id", ($StateId == "$State_Id" ? TRUE : '')); ?>><?php echo $State_Name; ?></option>
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
                <div class="fldblks"><textarea name="txtLandmark" id="txtLandmark" class="fild" tabindex="7"><?php echo set_value('txtLandmark', $Landmark); ?></textarea></div>
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
                        $sql = $this->db->get('source_master');
                        if ($sql) {
                            if (($sql->num_rows) > 0) {
                                $rows = $sql->result_array();

                                foreach ($rows as $row):

                                    $Source_Id = trim($row['iSourceId']);
                                    $Source_Name = trim($row['cSourceName']);
                                    ?>
                                    <option value="<?php echo $Source_Id; ?>" <?php echo set_select("cmbSource", "$Source_Id", ($SourceId == "$Source_Id" ? TRUE : '')); ?>><?php echo $Source_Name; ?></option>
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


                <div class="Txtblks">Business Purpose</div>
                <div class="fldblks">
                    <select name="cmbBusinessPurpose" id="cmbBusinessPurpose" class="fild" tabindex="20">
                        <option value="">Select Business Purpose</option>
                        <?php
                        $this->db->order_by('cBusinessPurposeName', 'asc');
                        $this->db->where('bActive', 1);
                        $this->db->where('bDelete', 0);
                        $sql = $this->db->get('business_purpose_master');
                        if ($sql) {
                            if (($sql->num_rows) > 0) {
                                $rows = $sql->result_array();

                                foreach ($rows as $row):

                                    $BusinessPurpose_Id = trim($row['iBusinessPurposeId']);
                                    $BusinessPurpose_Name = trim($row['cBusinessPurposeName']);
                                    ?>
                                    <option value="<?php echo $BusinessPurpose_Id; ?>" <?php echo set_select("cmbBusinessPurpose", "$BusinessPurpose_Id", ($BusinessPurposeId == "$BusinessPurpose_Id" ? TRUE : '')); ?>><?php echo $BusinessPurpose_Name; ?></option>
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



                <div class="Txtblks">Select Number of Contact Person</div>
                <div class="fldblks">
                    <select name="noofcontact" id="noofcontact" class="fild" tabindex="5" onchange="addcontactperson(this.value)">
                        <option value="">Select Number of Contact Person</option>
                        <?php for ($j = 1; $j <= 20; $j++) { ?>
                            <option value="<?php echo $j; ?>" <?php if ($j == $propertyno_building_details) { ?> selected="selected" <?php } ?>><?php echo $j; ?></option>
                        <?php } ?>
                    </select>
                </div>


                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div id="editresultdata">

                    <?php if ($ContactPerson1Name != "") { ?>
                        <div id="divdinfo1">
                            <div class="Txtblks">Contact Person1 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson1Name" id="txtContactPerson1Name" class="fild personname" value="<?php echo set_value('txtContactPerson1Name', $ContactPerson1Name); ?>" tabindex="9" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person1 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson1Designation" id="txtContactPerson1Designation" class="fild" value="<?php echo set_value('txtContactPerson1Designation', $ContactPerson1Designation); ?>" tabindex="10" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 1 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson1PhoneNo1" id="txtContactPerson1PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson1PhoneNo1', $ContactPerson1PhoneNo1); ?>" tabindex="12" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 1 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson1PhoneNo2" id="txtContactPerson1PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson1PhoneNo2', $ContactPerson1PhoneNo2); ?>" tabindex="12" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 1 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson1Email" id="txtContactPerson1Email" class="fild" value="<?php echo set_value('txtContactPerson1Email', $ContactPerson1Email); ?>" tabindex="13" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>

                    <?php if ($ContactPerson2Name != "") { ?>
                        <div id="divdinfo2">
                            <div class="Txtblks">Contact Person2 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson2Name" id="txtContactPerson2Name" class="fild personname" value="<?php echo set_value('txtContactPerson2Name', $ContactPerson2Name); ?>" tabindex="14" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>



                            <div class="Txtblks">Person2 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson2Designation" id="txtContactPerson2Designation" class="fild" value="<?php echo set_value('txtContactPerson2Designation', $ContactPerson2Designation); ?>" tabindex="15" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 2 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson2PhoneNo1" id="txtContactPerson2PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson2PhoneNo1', $ContactPerson2PhoneNo1); ?>" tabindex="16" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 2 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson2PhoneNo2" id="txtContactPerson2PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson2PhoneNo2', $ContactPerson2PhoneNo2); ?>" tabindex="17" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 2 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson2Email" id="txtContactPerson2Email" class="fild" value="<?php echo set_value('txtContactPerson2Email', $ContactPerson2Email); ?>" tabindex="18" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                        </div>

                    <?php } ?>

                    <?php if ($ContactPerson3Name != "") { ?>

                        <div id="divdinfo3">
                            <div class="Txtblks">Contact Person3 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson3Name" id="txtContactPerson3Name" class="fild personname" value="<?php echo set_value('txtContactPerson3Name', $ContactPerson3Name); ?>" tabindex="19" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person3 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson3Designation" id="txtContactPerson3Designation" class="fild" value="<?php echo set_value('txtContactPerson3Designation', $ContactPerson3Designation); ?>" tabindex="20" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 3 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson3PhoneNo1" id="txtContactPerson3PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson3PhoneNo1', $ContactPerson3PhoneNo1); ?>" tabindex="21" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 3 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson3PhoneNo2" id="txtContactPerson3PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson3PhoneNo2', $ContactPerson3PhoneNo2); ?>" tabindex="22" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 3 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson3Email" id="txtContactPerson3Email" class="fild" value="<?php echo set_value('txtContactPerson3Email', $ContactPerson3Email); ?>" tabindex="23" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>

                    <?php if ($ContactPerson4Name != "") { ?>
                        <div id="divdinfo4">
                            <div class="Txtblks">Contact Person4 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson4Name" id="txtContactPerson4Name" class="fild personname" value="<?php echo set_value('txtContactPerson4Name', $ContactPerson4Name); ?>" tabindex="24" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person4 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson4Designation" id="txtContactPerson4Designation" class="fild" value="<?php echo set_value('txtContactPerson4Designation', $ContactPerson4Designation); ?>" tabindex="25" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 4 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson4PhoneNo1" id="txtContactPerson4PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson4PhoneNo1', $ContactPerson4PhoneNo1); ?>" tabindex="26" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 4 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson4PhoneNo2" id="txtContactPerson4PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson4PhoneNo2', $ContactPerson4PhoneNo2); ?>" tabindex="27" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 4 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson4Email" id="txtContactPerson4Email" class="fild" value="<?php echo set_value('txtContactPerson4Email', $ContactPerson4Email); ?>" tabindex="28" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>

                    <?php if ($ContactPerson5Name != "") { ?>
                        <div id="divdinfo5">
                            <div class="Txtblks">Contact Person5 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson5Name" id="txtContactPerson5Name" class="fild personname" value="<?php echo set_value('txtContactPerson5Name', $ContactPerson5Name); ?>" tabindex="29" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person5 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson5Designation" id="txtContactPerson5Designation" class="fild" value="<?php echo set_value('txtContactPerson5Designation', $ContactPerson5Designation); ?>" tabindex="30" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 5 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson5PhoneNo1" id="txtContactPerson5PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson5PhoneNo1', $ContactPerson5PhoneNo1); ?>" tabindex="31" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 5 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson5PhoneNo2" id="txtContactPerson5PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson5PhoneNo2', $ContactPerson5PhoneNo2); ?>" tabindex="32" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 5 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson5Email" id="txtContactPerson5Email" class="fild" value="<?php echo set_value('txtContactPerson5Email', $ContactPerson5Email); ?>" tabindex="33" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>

                    <?php if ($ContactPerson6Name != "") { ?>
                        <div id="divdinfo6">
                            <div class="Txtblks">Contact Person6 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson6Name" id="txtContactPerson6Name" class="fild personname" value="<?php echo set_value('txtContactPerson6Name', $ContactPerson6Name); ?>" tabindex="34" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person6 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson6Designation" id="txtContactPerson6Designation" class="fild" value="<?php echo set_value('txtContactPerson6Designation', $ContactPerson6Designation); ?>" tabindex="35" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 6 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson6PhoneNo1" id="txtContactPerson6PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson6PhoneNo1', $ContactPerson6PhoneNo1); ?>" tabindex="36" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 6 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson6PhoneNo2" id="txtContactPerson6PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson6PhoneNo2', $ContactPerson6PhoneNo2); ?>" tabindex="37" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 6 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson6Email" id="txtContactPerson6Email" class="fild" value="<?php echo set_value('txtContactPerson6Email', $ContactPerson6Email); ?>" tabindex="38" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                        </div>

                    <?php } ?>

                    <?php if ($ContactPerson7Name != "") { ?>
                        <div id="divdinfo7">
                            <div class="Txtblks">Contact Person7 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson7Name" id="txtContactPerson7Name" class="fild personname" value="<?php echo set_value('txtContactPerson7Name', $ContactPerson7Name); ?>" tabindex="39" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person7 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson7Designation" id="txtContactPerson7Designation" class="fild" value="<?php echo set_value('txtContactPerson7Designation', $ContactPerson7Designation); ?>" tabindex="40" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 7 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson7PhoneNo1" id="txtContactPerson7PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson7PhoneNo1', $ContactPerson7PhoneNo1); ?>" tabindex="41" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 7 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson7PhoneNo2" id="txtContactPerson7PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson7PhoneNo2', $ContactPerson7PhoneNo2); ?>" tabindex="42" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 7 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson7Email" id="txtContactPerson7Email" class="fild" value="<?php echo set_value('txtContactPerson7Email', $ContactPerson7Email); ?>" tabindex="43" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>

                    <?php if ($ContactPerson8Name != "") { ?>
                        <div id="divdinfo8">
                            <div class="Txtblks">Contact Person8 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson8Name" id="txtContactPerson8Name" class="fild personname" value="<?php echo set_value('txtContactPerson8Name', $ContactPerson8Name); ?>" tabindex="44" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person8 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson8Designation" id="txtContactPerson8Designation" class="fild" value="<?php echo set_value('txtContactPerson8Designation', $ContactPerson8Designation); ?>" tabindex="45" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 8 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson8PhoneNo1" id="txtContactPerson8PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson8PhoneNo1', $ContactPerson8PhoneNo1); ?>" tabindex="46" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 8 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson8PhoneNo2" id="txtContactPerson8PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson8PhoneNo2', $ContactPerson8PhoneNo2); ?>" tabindex="47" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 8 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson8Email" id="txtContactPerson8Email" class="fild" value="<?php echo set_value('txtContactPerson8Email', $ContactPerson8Email); ?>" tabindex="48" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>

                    <?php if ($ContactPerson9Name != "") { ?>
                        <div id="divdinfo9">
                            <div class="Txtblks">Contact Person9 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson9Name" id="txtContactPerson9Name" class="fild personname" value="<?php echo set_value('txtContactPerson9Name', $ContactPerson9Name); ?>" tabindex="49" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person9 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson9Designation" id="txtContactPerson9Designation" class="fild" value="<?php echo set_value('txtContactPerson9Designation', $ContactPerson9Designation); ?>" tabindex="50" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 9 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson9PhoneNo1" id="txtContactPerson9PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson9PhoneNo1', $ContactPerson9PhoneNo1); ?>" tabindex="51" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 9 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson9PhoneNo2" id="txtContactPerson9PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson9PhoneNo2', $ContactPerson9PhoneNo2); ?>" tabindex="52" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 9 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson9Email" id="txtContactPerson9Email" class="fild" value="<?php echo set_value('txtContactPerson9Email', $ContactPerson9Email); ?>" tabindex="53" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>

                    <?php if ($ContactPerson10Name != "") { ?>
                        <div id="divdinfo10">
                            <div class="Txtblks">Contact Person 10 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson10Name" id="txtContactPerson10Name" class="fild personname" value="<?php echo set_value('txtContactPerson10Name', $ContactPerson10Name); ?>" tabindex="54" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 10 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson10Designation" id="txtContactPerson10Designation" class="fild" value="<?php echo set_value('txtContactPerson10Designation', $ContactPerson10Designation); ?>" tabindex="55" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 10 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson10PhoneNo1" id="txtContactPerson10PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson10PhoneNo1', $ContactPerson10PhoneNo1); ?>" tabindex="56" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 10 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson10PhoneNo2" id="txtContactPerson10PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson10PhoneNo2', $ContactPerson10PhoneNo2); ?>" tabindex="57" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 10 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson10Email" id="txtContactPerson10Email" class="fild" value="<?php echo set_value('txtContactPerson10Email', $ContactPerson10Email); ?>" tabindex="58" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>




                    <!------------------------->
                    <?php if ($ContactPerson11Name != "") { ?>
                        <div id="divdinfo11">
                            <div class="Txtblks">Contact Person 11 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson11Name" id="txtContactPerson11Name" class="fild personname" value="<?php echo set_value('txtContactPerson11Name', $ContactPerson11Name); ?>" tabindex="54" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 11 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson11Designation" id="txtContactPerson11Designation" class="fild" value="<?php echo set_value('txtContactPerson11Designation', $ContactPerson11Designation); ?>" tabindex="55" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 11 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson11PhoneNo1" id="txtContactPerson11PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson11PhoneNo1', $ContactPerson11PhoneNo1); ?>" tabindex="56" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 11 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson11PhoneNo2" id="txtContactPerson11PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson11PhoneNo2', $ContactPerson11PhoneNo2); ?>" tabindex="57" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 11 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson11Email" id="txtContactPerson11Email" class="fild" value="<?php echo set_value('txtContactPerson11Email', $ContactPerson11Email); ?>" tabindex="58" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>



                    <?php if ($ContactPerson12Name != "") { ?>
                        <div id="divdinfo12">
                            <div class="Txtblks">Contact Person 12 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson12Name" id="txtContactPerson12Name" class="fild personname" value="<?php echo set_value('txtContactPerson12Name', $ContactPerson12Name); ?>" tabindex="54" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 12 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson12Designation" id="txtContactPerson12Designation" class="fild" value="<?php echo set_value('txtContactPerson12Designation', $ContactPerson12Designation); ?>" tabindex="55" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 12 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson12PhoneNo1" id="txtContactPerson12PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson12PhoneNo1', $ContactPerson12PhoneNo1); ?>" tabindex="56" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 12 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson12PhoneNo2" id="txtContactPerson12PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson12PhoneNo2', $ContactPerson12PhoneNo2); ?>" tabindex="57" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 12 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson12Email" id="txtContactPerson12Email" class="fild" value="<?php echo set_value('txtContactPerson12Email', $ContactPerson12Email); ?>" tabindex="58" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>

                    <?php if ($ContactPerson13Name != "") { ?>
                        <div id="divdinfo13">
                            <div class="Txtblks">Contact Person 13 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson13Name" id="txtContactPerson13Name" class="fild personname" value="<?php echo set_value('txtContactPerson13Name', $ContactPerson13Name); ?>" tabindex="54" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 13 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson13Designation" id="txtContactPerson13Designation" class="fild" value="<?php echo set_value('txtContactPerson13Designation', $ContactPerson13Designation); ?>" tabindex="55" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 13 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson13PhoneNo1" id="txtContactPerson13PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson13PhoneNo1', $ContactPerson13PhoneNo1); ?>" tabindex="56" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 13 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson13PhoneNo2" id="txtContactPerson13PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson13PhoneNo2', $ContactPerson13PhoneNo2); ?>" tabindex="57" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 13 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson13Email" id="txtContactPerson13Email" class="fild" value="<?php echo set_value('txtContactPerson13Email', $ContactPerson13Email); ?>" tabindex="58" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>


                    <?php if ($ContactPerson14Name != "") { ?>
                        <div id="divdinfo14">
                            <div class="Txtblks">Contact Person 14 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson14Name" id="txtContactPerson14Name" class="fild personname" value="<?php echo set_value('txtContactPerson14Name', $ContactPerson14Name); ?>" tabindex="54" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 14 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson14Designation" id="txtContactPerson14Designation" class="fild" value="<?php echo set_value('txtContactPerson14Designation', $ContactPerson14Designation); ?>" tabindex="55" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 14 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson14PhoneNo1" id="txtContactPerson14PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson14PhoneNo1', $ContactPerson14PhoneNo1); ?>" tabindex="56" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 14 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson14PhoneNo2" id="txtContactPerson14PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson14PhoneNo2', $ContactPerson14PhoneNo2); ?>" tabindex="57" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 14 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson14Email" id="txtContactPerson14Email" class="fild" value="<?php echo set_value('txtContactPerson14Email', $ContactPerson14Email); ?>" tabindex="58" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>



                    <?php if ($ContactPerson15Name != "") { ?>
                        <div id="divdinfo15">
                            <div class="Txtblks">Contact Person 15 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson15Name" id="txtContactPerson15Name" class="fild personname" value="<?php echo set_value('txtContactPerson15Name', $ContactPerson15Name); ?>" tabindex="54" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 15 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson15Designation" id="txtContactPerson15Designation" class="fild" value="<?php echo set_value('txtContactPerson15Designation', $ContactPerson15Designation); ?>" tabindex="55" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 15 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson15PhoneNo1" id="txtContactPerson15PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson15PhoneNo1', $ContactPerson15PhoneNo1); ?>" tabindex="56" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 15 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson15PhoneNo2" id="txtContactPerson15PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson15PhoneNo2', $ContactPerson15PhoneNo2); ?>" tabindex="57" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 15 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson15Email" id="txtContactPerson15Email" class="fild" value="<?php echo set_value('txtContactPerson15Email', $ContactPerson15Email); ?>" tabindex="58" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>



                    <?php if ($ContactPerson16Name != "") { ?>
                        <div id="divdinfo16">
                            <div class="Txtblks">Contact Person 16 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson16Name" id="txtContactPerson16Name" class="fild personname" value="<?php echo set_value('txtContactPerson16Name', $ContactPerson16Name); ?>" tabindex="54" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 16 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson16Designation" id="txtContactPerson16Designation" class="fild" value="<?php echo set_value('txtContactPerson16Designation', $ContactPerson16Designation); ?>" tabindex="55" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 16 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson16PhoneNo1" id="txtContactPerson16PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson16PhoneNo1', $ContactPerson16PhoneNo1); ?>" tabindex="56" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 16 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson16PhoneNo2" id="txtContactPerson16PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson16PhoneNo2', $ContactPerson16PhoneNo2); ?>" tabindex="57" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 16 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson16Email" id="txtContactPerson16Email" class="fild" value="<?php echo set_value('txtContactPerson16Email', $ContactPerson16Email); ?>" tabindex="58" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>



                    <?php if ($ContactPerson17Name != "") { ?>
                        <div id="divdinfo17">
                            <div class="Txtblks">Contact Person 17 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson17Name" id="txtContactPerson17Name" class="fild personname" value="<?php echo set_value('txtContactPerson17Name', $ContactPerson17Name); ?>" tabindex="54" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 17 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson17Designation" id="txtContactPerson17Designation" class="fild" value="<?php echo set_value('txtContactPerson17Designation', $ContactPerson17Designation); ?>" tabindex="55" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 17 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson17PhoneNo1" id="txtContactPerson17PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson17PhoneNo1', $ContactPerson17PhoneNo1); ?>" tabindex="56" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 17 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson17PhoneNo2" id="txtContactPerson17PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson17PhoneNo2', $ContactPerson17PhoneNo2); ?>" tabindex="57" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 17 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson17Email" id="txtContactPerson17Email" class="fild" value="<?php echo set_value('txtContactPerson17Email', $ContactPerson17Email); ?>" tabindex="58" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>

                    <?php if ($ContactPerson18Name != "") { ?>
                        <div id="divdinfo18">
                            <div class="Txtblks">Contact Person 18 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson18Name" id="txtContactPerson18Name" class="fild personname" value="<?php echo set_value('txtContactPerson18Name', $ContactPerson18Name); ?>" tabindex="54" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 18 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson18Designation" id="txtContactPerson18Designation" class="fild" value="<?php echo set_value('txtContactPerson18Designation', $ContactPerson18Designation); ?>" tabindex="55" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 18 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson18PhoneNo1" id="txtContactPerson18PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson18PhoneNo1', $ContactPerson18PhoneNo1); ?>" tabindex="56" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 18 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson18PhoneNo2" id="txtContactPerson18PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson18PhoneNo2', $ContactPerson18PhoneNo2); ?>" tabindex="57" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 18 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson18Email" id="txtContactPerson18Email" class="fild" value="<?php echo set_value('txtContactPerson18Email', $ContactPerson18Email); ?>" tabindex="58" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>


                    <?php if ($ContactPerson19Name != "") { ?>
                        <div id="divdinfo19">
                            <div class="Txtblks">Contact Person 19 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson19Name" id="txtContactPerson19Name" class="fild personname" value="<?php echo set_value('txtContactPerson19Name', $ContactPerson19Name); ?>" tabindex="54" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 19 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson19Designation" id="txtContactPerson19Designation" class="fild" value="<?php echo set_value('txtContactPerson19Designation', $ContactPerson19Designation); ?>" tabindex="55" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 19 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson19PhoneNo1" id="txtContactPerson19PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson19PhoneNo1', $ContactPerson19PhoneNo1); ?>" tabindex="56" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 19 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson19PhoneNo2" id="txtContactPerson19PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson19PhoneNo2', $ContactPerson19PhoneNo2); ?>" tabindex="57" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 19 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson19Email" id="txtContactPerson19Email" class="fild" value="<?php echo set_value('txtContactPerson19Email', $ContactPerson19Email); ?>" tabindex="58" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>

                    <?php if ($ContactPerson20Name != "") { ?>
                        <div id="divdinfo20">
                            <div class="Txtblks">Contact Person 20 Name</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson20Name" id="txtContactPerson20Name" class="fild personname" value="<?php echo set_value('txtContactPerson20Name', $ContactPerson20Name); ?>" tabindex="54" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 20 Designation</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson20Designation" id="txtContactPerson20Designation" class="fild" value="<?php echo set_value('txtContactPerson20Designation', $ContactPerson20Designation); ?>" tabindex="55" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 20 Phone 1</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson20PhoneNo1" id="txtContactPerson20PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson20PhoneNo1', $ContactPerson20PhoneNo1); ?>" tabindex="56" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 20 Phone 2</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson20PhoneNo2" id="txtContactPerson20PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson20PhoneNo2', $ContactPerson20PhoneNo2); ?>" tabindex="57" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>

                            <div class="Txtblks">Person 20 Email</div>
                            <div class="fldblks"><input type="text" name="txtContactPerson20Email" id="txtContactPerson20Email" class="fild" value="<?php echo set_value('txtContactPerson20Email', $ContactPerson20Email); ?>" tabindex="58" /></div>
                            <div class="Txtblks">&nbsp;</div>
                            <div class="fldblks">&nbsp;</div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>
                </div>

                <div id="resultforcontactperson"></div>


                <div class="Txtblks">Remarks</div>
                <div class="fldblks"><textarea name="txtRemarks" id="txtRemarks" class="fild"  tabindex="59"><?php echo set_value('txtRemarks', $Remarks); ?></textarea></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Active</div>
                <div class="fldblks"><input type="checkbox" name="chkActive" id="chkActive" onclick="ChangeActive();" value="1" <?php echo set_checkbox('chkActive', '1', ($Active == '1' ? TRUE : '')); ?> /></div>
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
        if (document.getElementById('chkActive').checked == true)
        {
            $("#hfActive").val(1);
        } else
        {
            $("#hfActive").val(0);
        }
    }
</script>

<script type="text/javascript" language="javascript">
    $(document).ready(function () {
        getDistrictByStateId();
    });
</script>

<script type="text/javascript" language="javascript">
    function getDistrictByStateId()
    {
        if ($("#cmbState").val() == '')
        {
            alert("Please Select State");
            $("#cmbState").focus();
            $('#cmbDistrict').children('option:not(:first)').remove();
            $('#cmbCity').children('option:not(:first)').remove();
            $('#cmbLocation').children('option:not(:first)').remove();
            return false;
        } else
        {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo base_url(); ?>index.php/dashboard/getdistrictbystate",
                data: "cmbState=" + $("#cmbState").val(),
                success: function (details) {

                    $('#cmbDistrict').children('option:not(:first)').remove();

                    $.each(details, function (districtid, districtname) {

                        var opt = $('<option />');

                        if (districtid == "<?php echo $DistrictId; ?>") {
                            opt.val(districtid);
                            opt.text(districtname);
                            $(opt).attr('selected', 'selected');
                        } else
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
            url: "<?php echo base_url(); ?>index.php/dashboard/getcitybystateanddistrict",
            data: "cmbState=" + $("#cmbState").val() + "&cmbDistrict=" + $("#cmbDistrict").val(),
            success: function (details) {

                $('#cmbCity').children('option:not(:first)').remove();

                $.each(details, function (cityid, cityname) {

                    var opt = $('<option />');

                    if (cityid == "<?php echo $CityId; ?>") {
                        opt.val(cityid);
                        opt.text(cityname);
                        $(opt).attr('selected', 'selected');
                    } else
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

        if ($("#cmbCity").val() == '')
        {
            alert("Please Select City");
            $("#cmbCity").focus();
            return false;
        } else
        {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo base_url(); ?>index.php/dashboard/getlocationbystateanddistrictandcity",
                data: "cmbState=" + $("#cmbState").val() + "&cmbDistrict=" + $("#cmbDistrict").val() + "&cmbCity=" + $("#cmbCity").val(),
                success: function (details) {

                    $('#cmbLocation').children('option:not(:first)').remove();

                    $.each(details, function (locationid, locationname) {

                        //alert(locationid+","+locationname);

                        var opt = $('<option />');

                        if (locationid == "<?php echo $LocationId; ?>") {
                            opt.val(locationid);
                            opt.text(locationname);
                            $(opt).attr('selected', 'selected');
                        } else
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
        if ($("#txtClientName").val() == '')
        {
            alert("Please enter Client Name");
            $("#txtClientName").focus();
            return false;
        } else
        {
            var data = $("#editForm").serialize();

            btn.disabled = true;
            btn.value = 'Submitting...';

            var url = "<?php echo base_url(); ?>index.php/dashboard/edit_client_master";

            $.post(url, data, function (data) {

                if (data)
                {
                    if (data.status == 1)
                    {
                        btn.disabled = false;
                        btn.value = 'Submit';
                        alert(data.msg);
                        var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_client_master";
                        $(location).attr('href', redirecturl);
                    } else
                    {
                        btn.disabled = false;
                        btn.value = 'Submit';
                        alert(data.msg);
                    }
                }
            }, 'json');
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


    function addcontactperson(ths)
    {

        var selected = parseInt(ths);
        var total = parseInt('20');

        var totalcount = total - selected;

        //alert(totalcount);

        // alert(selected);

        var totaldiv = 20;
        for (ii = 1; ii <= totalcount; ii++)
        {
            $("#divdinfo" + totaldiv).remove();
            totaldiv = totaldiv - 1;


        }



        var newhtml = "";

        var i = "";


//        $.ajax({
//			type: "POST",
//			dataType: 'json',
//			url: "<?php echo base_url(); ?>index.php/dashboard/getdistrictbystate",
//			data: "cmbState="+$("#cmbState").val(),
//			success: function(details){
//				
//				$('#cmbDistrict').children('option:not(:first)').remove();
//				
//				$.each(details,function(districtid,districtname) {	 
//				
//					var opt = $('<option />'); 									
//					
//					if(districtid == "<?php echo $DistrictId; ?>"){
//						opt.val(districtid);
//						opt.text(districtname);
//						$(opt).attr('selected', 'selected');
//					}		
//					else
//					{
//						opt.val(districtid);
//						opt.text(districtname);
//					}
//					
//					$('#cmbDistrict').append(opt); 		
//				});
//				
//				getCityByDistrictIdAndStateId();
//			}
//		});


        var personnamess = $(".personname").length;
        var newadd = selected - personnamess;

        var iplussx = personnamess + 1;


        //  var mm = "";
        for (k = 1; k <= newadd; k++)
        {

            var i = personnamess + k;

            newhtml += '<div class="Txtblks">Contact Person' + i + ' Name</div><div class="fldblks"><input type="text" name="txtContactPerson' + i + 'Name" id="txtContactPerson' + i + 'Name" class="fild" value="<?php echo set_value('txtContactPerson2Name'); ?>" tabindex="14" /></div><div class="Txtblks">&nbsp;</div><div class="fldblks">&nbsp;</div><div class="clear"></div><div class="Txtblks">Person' + i + ' Designation</div><div class="fldblks"><input type="text" name="txtContactPerson' + i + 'Designation" id="txtContactPerson' + i + 'Designation" class="fild" value="<?php echo set_value('txtContactPerson2Designation'); ?>" tabindex="15" /></div><div class="Txtblks">&nbsp;</div><div class="fldblks">&nbsp;</div><div class="clear"></div><div class="Txtblks">Person ' + i + ' Phone 1</div><div class="fldblks"><input type="text" name="txtContactPerson' + i + 'PhoneNo1" id="txtContactPerson' + i + 'PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson2PhoneNo1'); ?>" tabindex="16" /></div><div class="Txtblks">&nbsp;</div><div class="fldblks">&nbsp;</div><div class="clear"></div><div class="Txtblks">Person ' + i + ' Phone 2</div><div class="fldblks"><input type="text" name="txtContactPerson' + i + 'PhoneNo2" id="txtContactPerson' + i + 'PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson2PhoneNo2'); ?>" tabindex="17" /></div><div class="Txtblks">&nbsp;</div><div class="fldblks">&nbsp;</div><div class="clear"></div><div class="Txtblks">Person ' + i + ' Email</div><div class="fldblks"><input type="text" name="txtContactPerson' + i + 'Email" id="txtContactPerson' + i + 'Email" class="fild" value="<?php echo set_value('txtContactPerson2Email'); ?>" tabindex="18" /></div><div class="Txtblks">&nbsp;</div><div class="fldblks">&nbsp;</div><div class="clear"></div>';
            newhtml += '<br>';
            newhtml += '<br>';
            i++;

        }

        $("#no_of_floorid").show();
        $("#resultforcontactperson").append(newhtml);



    }



    setTimeout(function () {
        var personname = $(".personname").length;
        $("#noofcontact option[value='" + personname + "']").prop('selected', true);
    }, 500);


</script>