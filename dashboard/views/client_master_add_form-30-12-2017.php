<!--==============================Form=================================-->

<form name="addForm" id="addForm" method="post" action="" enctype="multipart/form-data">
    <div class="inner_form">
        <h2>Add Details</h2>
        <div class="mfrminner">
            <div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg'); ?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
            <fieldset><legend>General Details</legend>

                <div class="Txtblks">Client Name</div>
                <div class="fldblks"><input type="text" name="txtClientName" id="txtClientName" class="fild" value="<?php echo set_value('txtClientName'); ?>" tabindex="1" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Address</div>
                <div class="fldblks"><textarea name="txtAddress" id="txtAddress" class="fild"  tabindex="2"><?php echo set_value('txtAddress'); ?></textarea></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Branch</div>
                <div class="fldblks">
                    <select name="cmbBranch" id="cmbBranch" class="fild" tabindex="3">
                        <option value="">Select Branch</option>
                        <?php
                        $this->db->where('bActive', 1);
                        $this->db->where('bDelete', 0);
                        $sql = $this->db->get('branch_master');
                        if ($sql) {
                            if (($sql->num_rows) > 0) {
                                $rows = $sql->result_array();

                                foreach ($rows as $row):

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
                    <select name="cmbState" id="cmbState" class="fild" tabindex="3" onchange="getDistrictByStateId()">
                        <option value="">Select State</option>
                        <?php
                        $this->db->where('bActive', 1);
                        $this->db->where('bDelete', 0);
                        $sql = $this->db->get('state_master');
                        if ($sql) {
                            if (($sql->num_rows) > 0) {
                                $rows = $sql->result_array();

                                foreach ($rows as $row):

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
                <div class="fldblks"><textarea name="txtLandmark" id="txtLandmark" class="fild" tabindex="7"><?php echo set_value('txtLandmark'); ?></textarea></div>
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


                <div class="Txtblks">Contact Person1 Name</div> 
                <div class="fldblks"><input type="text" name="txtContactPerson1Name" id="txtContactPerson1Name" class="fild" value="<?php echo set_value('txtContactPerson1Name'); ?>" tabindex="9" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Person1 Designation</div>
                <div class="fldblks"><input type="text" name="txtContactPerson1Designation" id="txtContactPerson1Designation" class="fild" value="<?php echo set_value('txtContactPerson1Designation'); ?>" tabindex="10" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Person 1 Phone 1</div>
                <div class="fldblks"><input type="text" name="txtContactPerson1PhoneNo1" id="txtContactPerson1PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson1PhoneNo1'); ?>" tabindex="11" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Person 1 Phone 2</div>
                <div class="fldblks"><input type="text" name="txtContactPerson1PhoneNo2" id="txtContactPerson1PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson1PhoneNo2'); ?>" tabindex="12" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Person 1 Email</div>
                <div class="fldblks"><input type="text" name="txtContactPerson1Email" id="txtContactPerson1Email" class="fild" value="<?php echo set_value('txtContactPerson1Email'); ?>" tabindex="13" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>


                <div id="resultforcontactperson"></div>










                <div class="Txtblks">Remarks</div>
                <div class="fldblks"><textarea name="txtRemarks" id="txtRemarks" class="fild"  tabindex="59"><?php echo set_value('txtRemarks'); ?></textarea></div>
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

            <!------------------------------------------------------------------------------------------------------------------------------------------------------------>

            <div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this);" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_client_master"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</form>

<script type="text/javascript" language="javascript">
    function getDistrictByStateId()
    {
        $('#cmbDistrict').children('option:not(:first)').remove();
        $('#cmbCity').children('option:not(:first)').remove();
        $('#cmbLocation').children('option:not(:first)').remove();

        if ($("#cmbState").val() == '')
        {
            alert("Please Select State");
            $("#cmbState").focus();
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
                        opt.val(districtid);
                        opt.text(districtname);
                        $('#cmbDistrict').append(opt);
                    });
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

        if ($("#cmbDistrict").val() == '')
        {
            alert("Please Select District");
            $("#cmbDistrict").focus();
            return false;
        } else
        {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo base_url(); ?>index.php/dashboard/getcitybystateanddistrict",
                data: "cmbState=" + $("#cmbState").val() + "&cmbDistrict=" + $("#cmbDistrict").val(),
                success: function (details) {

                    $('#cmbCity').children('option:not(:first)').remove();

                    $.each(details, function (cityid, cityname) {

                        var opt = $('<option />');
                        opt.val(cityid);
                        opt.text(cityname);
                        $('#cmbCity').append(opt);
                    });
                }
            });
        }
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
                        var opt = $('<option />');
                        opt.val(locationid);
                        opt.text(locationname);
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
            var data = $("#addForm").serialize();

            var url = "<?php echo base_url(); ?>index.php/dashboard/add_client_master";

            btn.disabled = true;
            btn.value = 'Submitting...';

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
        var newhtml = "";

        var i = "";



        for (i = 2; i <= ths; i++)
        {
            //newhtml +='<input style="width:150px;" type="text" name="nooffloor'+ths+'">';

            newhtml += '<div class="Txtblks">Contact Person' + i + ' Name</div><div class="fldblks"><input type="text" name="txtContactPerson' + i + 'Name" id="txtContactPerson' + i + 'Name" class="fild" value="<?php echo set_value('txtContactPerson2Name'); ?>" tabindex="14" /></div><div class="Txtblks">&nbsp;</div><div class="fldblks">&nbsp;</div><div class="clear"></div><div class="Txtblks">Person' + i + ' Designation</div><div class="fldblks"><input type="text" name="txtContactPerson' + i + 'Designation" id="txtContactPerson' + i + 'Designation" class="fild" value="<?php echo set_value('txtContactPerson2Designation'); ?>" tabindex="15" /></div><div class="Txtblks">&nbsp;</div><div class="fldblks">&nbsp;</div><div class="clear"></div><div class="Txtblks">Person ' + i + ' Phone 1</div><div class="fldblks"><input type="text" name="txtContactPerson' + i + 'PhoneNo1" id="txtContactPerson' + i + 'PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson2PhoneNo1'); ?>" tabindex="16" /></div><div class="Txtblks">&nbsp;</div><div class="fldblks">&nbsp;</div><div class="clear"></div><div class="Txtblks">Person ' + i + ' Phone 2</div><div class="fldblks"><input type="text" name="txtContactPerson' + i + 'PhoneNo2" id="txtContactPerson' + i + 'PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson2PhoneNo2'); ?>" tabindex="17" /></div><div class="Txtblks">&nbsp;</div><div class="fldblks">&nbsp;</div><div class="clear"></div><div class="Txtblks">Person ' + i + ' Email</div><div class="fldblks"><input type="text" name="txtContactPerson' + i + 'Email" id="txtContactPerson' + i + 'Email" class="fild" value="<?php echo set_value('txtContactPerson2Email'); ?>" tabindex="18" /></div><div class="Txtblks">&nbsp;</div><div class="fldblks">&nbsp;</div><div class="clear"></div>';
            newhtml += '<br>';
            newhtml += '<br>';
        }

        $("#no_of_floorid").show();
        $("#resultforcontactperson").html(newhtml);






    }




</script>