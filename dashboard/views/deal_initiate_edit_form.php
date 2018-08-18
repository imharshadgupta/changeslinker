<!--==============================Form=================================-->

<form name="editForm" id="editForm" method="post" action="<?php echo base_url(); ?>index.php/dashboard/edit_deal_initiate" enctype="multipart/form-data" target="_blank">
    <input type="hidden" name="hfDealInitiateId" id="hfDealInitiateId" value="<?php echo set_value('hfDealInitiateId', $DealInitiateId); ?>"/>
    <input type="hidden" name="hfActive" id="hfActive" value="<?php echo set_value('hfActive', $Active); ?>" />
    <div class="inner_form">
        <h2>Edit Details</h2>
        <div class="mfrminner">
            <div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg'); ?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
            <fieldset><legend>General Details</legend>

                <div class="Txtblks">Initiate Date</div>
                <div class="fldblks"><input type="text" name="txtInitiateDate" id="txtInitiateDate" class="fild" style="width:302px;" value="<?php echo set_value('txtInitiateDate', $DealInitiateDate); ?>" readonly="readonly" tabindex="1" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Branch</div>
                <div class="fldblks">
                    <select name="cmbBranch" id="cmbBranch" class="fild chzn-select" tabindex="2">
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

                <div class="Txtblks">Client</div>
                <div class="fldblks">
                    <select name="cmbClientReq" id="cmbClientReq" class="chzn-select fild" tabindex="3">
                        <option value="">Select Client</option>
                        <?php
                        $sql = $this->db->query("SELECT requirement_master.iClientId,client_master.cClientName FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId WHERE requirement_master.iClientId<>0 AND requirement_master.bActive=1 AND requirement_master.bDelete=0 GROUP BY requirement_master.iClientId ORDER BY client_master.cClientName");

                        if ($sql) {
                            if (($sql->num_rows) > 0) {
                                $rows = $sql->result_array();

                                foreach ($rows as $row):

                                    $Client_Id = trim($row['iClientId']);
                                    $Client_Name = trim($row['cClientName']);
                                    ?>
                                    <option value="<?php echo $Client_Id; ?>" <?php echo set_select("cmbClientReq", "$Client_Id", ($ClientReqId == "$Client_Id" ? TRUE : '')); ?>><?php echo $Client_Name; ?></option>
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
                        <?php
                        foreach ($allrequirement as $key => $row):
                            ?>
                            <option value="<?php echo $key; ?>" <?php
                            if ($RequirementId == $key) {
                                echo "selected=selected";
                            }
                            ?>><?php echo $row; ?></option>
                                    <?php
                                endforeach;
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

                        <?php
                        foreach ($allproperty as $key => $row):
                            ?>
                            <option value="<?php echo $key; ?>" <?php
                            if ($PropertyId == $key) {
                                echo "selected=selected";
                            }
                            ?>><?php echo $row; ?></option>
                                    <?php
                                endforeach;
                                ?>
                    </select>
                </div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Lease Start Date</div>
                <div class="fldblks"><input type="text" name="txtLeaseStartDate" id="txtLeaseStartDate" class="fild" style="width:302px;" value="<?php echo set_value('txtLeaseStartDate', $LeaseStartDate); ?>" readonly="readonly" tabindex="7" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Lease End Date</div>
                <div class="fldblks"><input type="text" name="txtLeaseEndDate" id="txtLeaseEndDate" class="fild" style="width:302px;" value="<?php echo set_value('txtLeaseEndDate', $LeaseEndDate); ?>" readonly="readonly" tabindex="8" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Lease Renewal Reminder Date</div>
                <div class="fldblks"><input type="text" name="txtLeaseRenewalReminderDate" id="txtLeaseRenewalReminderDate" class="fild" style="width:302px;" value="<?php echo set_value('txtLeaseRenewalReminderDate', $LeaseRenewalReminderDate); ?>" readonly="readonly" tabindex="9" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Reminder for Renewal</div>
                <div class="fldblks"><input type="text" name="txtReminderForRenewal" id="txtReminderForRenewal" class="fild" value="<?php echo set_value('txtReminderForRenewal', $ReminderForRenewal); ?>" tabindex="10" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Paste Terms & Conditions</div>
                <div class="fldblks"><textarea name="txtTermsAndConditions" id="txtTermsAndConditions" class="fild" tabindex="11"><?php echo set_value('txtTermsAndConditions', $TermsAndConditions); ?></textarea></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Possession Date</div>
                <div class="fldblks"><input type="text" name="txtPossessionDate" id="txtPossessionDate" class="fild" style="width:302px;" value="<?php echo set_value('txtPossessionDate', $PossessionDate); ?>" readonly="readonly" tabindex="12" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Possession Done</div>
                <div class="fldblks">
                    <select name="cmbPossessionDone" id="cmbPossessionDone" class="fild chzn-select" tabindex="13">
                        <option value="">Select Possession Done</option>
                        <option value="Yes" <?php echo set_select("cmbPossessionDone", "Yes", ($PossessionDone == "Yes" ? TRUE : '')); ?>>Yes</option>
                        <option value="No" <?php echo set_select("cmbPossessionDone", "No", ($PossessionDone == "No" ? TRUE : '')); ?>>No</option>
                    </select></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Payment Date</div>
                <div class="fldblks"><input type="text" name="txtPaymentDate" id="txtPaymentDate" class="fild" style="width:302px;" value="<?php echo set_value('txtPaymentDate', $PaymentDate); ?>" readonly="readonly" tabindex="14" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Payment Received Completely</div>
                <div class="fldblks">
                    <select name="cmbPaymentReceivedCompletely" id="cmbPaymentReceivedCompletely" class="fild chzn-select" tabindex="15">
                        <option value="">Select Payment Received Completely</option>
                        <option value="Yes" <?php echo set_select("cmbPaymentReceivedCompletely", "Yes", ($PaymentReceivedCompletely == "Yes" ? TRUE : '')); ?>>Yes</option>
                        <option value="No" <?php echo set_select("cmbPaymentReceivedCompletely", "No", ($PaymentReceivedCompletely == "No" ? TRUE : '')); ?>>No</option>
                    </select></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Tagline for Website</div>
                <div class="fldblks"><input type="text" name="txtTaglineForWebsite" id="txtTaglineForWebsite" class="fild" value="<?php echo set_value('txtTaglineForWebsite', $TaglineForWebsite); ?>" tabindex="16" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Deal Done Date</div>
                <div class="fldblks"><input type="text" name="txtDealDoneDate" id="txtDealDoneDate" class="fild" style="width:302px;" value="<?php echo set_value('txtDealDoneDate', $DealDoneDate); ?>" readonly="readonly" tabindex="17" /></div>
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


            <fieldset>
                <legend>Existing Uploaded Images</legend>
                <?php
                if (count($AttachmentRows) > 0) {
                    ?>
                    <div align="left">
                        <div class="Txtblks">&nbsp;</div>
                        <div class="Txtblks" style="text-align:left;"><strong>Title</strong></div>
                        <div class="fldblks" style="text-align:left;"><strong>Image</strong></div>
                        <div class="fldblks">&nbsp;</div>
                        <div class="clear"></div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div align="left">
                        <div class="Txtblks">&nbsp;</div>
                        <div class="Txtblks" style="text-align:left;"><strong>No image exists.</strong></div>
                        <div class="fldblks">&nbsp;</div>
                        <div class="clear"></div>
                    </div>
                    <?php
                }
                ?>

                <?php
                $i = 1;
                foreach ($AttachmentRows as $docrow) {
                    
                    
                    $PropertyAttachmentId = trim($docrow['iDealAttachmentId']);
                    $PropertyId = trim($docrow['iDealInitiateId']);
                    $AttachmentTitle = trim($docrow['cAttachmentTitle']);
                    $AttachmentFilePath = trim($docrow['cAttachmentPath']);
                    $AttachmentFileName = trim($docrow['cAttachmentName']);

                    $ImgUrl = base_url($AttachmentFilePath);
                    ?>

                    <div align="left">
                        <div class="Txtblks">&nbsp;</div>
                        <div class="Txtblks" style="text-align:left;"><?php //echo $i;         ?><?php echo $AttachmentTitle; ?></div>
                        <div class="fldblks" style="text-align:left;"><img src="<?php echo $ImgUrl; ?>" title="<?php echo $AttachmentTitle; ?>" height="50" width="100" /></div>
                        <div class="fldblks"><input type='button' value='Delete' id='delButton' onclick="DeleteExistingAttachment('<?php echo $PropertyAttachmentId; ?>', '<?php echo $PropertyId; ?>', '<?php echo $AttachmentFileName; ?>', '<?php echo $AttachmentFilePath; ?>')"></div>
                        <div class="clear"></div>
                    </div>

                    <?php
                    $i++;
                }
                ?>

            </fieldset>

            <fieldset>
                <legend>Upload Attachments</legend>

                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="Txtblks">&nbsp;</div>
<!--                <div class="fldblks"><input type='button' value='Add New' id='addButton'>&nbsp;<input type='button' value='Cancel' id='removeButton'></div>-->
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

            <div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this)" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_deal_initiate">
                    <input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

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

<script type="text/javascript">
    $(document).ready(function () {
        $("#txtInitiateDate").datepicker({
            dateFormat: 'dd/mm/yy',
            showOn: "button",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+10",
            buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
            buttonImageOnly: true
        });
        $("#txtLeaseStartDate").datepicker({
            dateFormat: 'dd/mm/yy',
            showOn: "button",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+10",
            buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
            buttonImageOnly: true
        });
        $("#txtLeaseEndDate").datepicker({
            dateFormat: 'dd/mm/yy',
            showOn: "button",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+100",
            buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
            buttonImageOnly: true
        });
        $("#txtLeaseRenewalReminderDate").datepicker({
            dateFormat: 'dd/mm/yy',
            showOn: "button",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+100",
            buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
            buttonImageOnly: true
        });
        $("#txtPossessionDate").datepicker({
            dateFormat: 'dd/mm/yy',
            showOn: "button",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+10",
            buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
            buttonImageOnly: true
        });
        $("#txtPaymentDate").datepicker({
            dateFormat: 'dd/mm/yy',
            showOn: "button",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+10",
            buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
            buttonImageOnly: true
        });

        $("#txtDealDoneDate").datepicker({
            dateFormat: 'dd/mm/yy',
            showOn: "button",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+10",
            buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
            buttonImageOnly: true
        });

        getRequirementByClient();
        getPropertyByClient();

        /*$('#txtLeasePartyLessee').autocomplete({
         source:"<?php echo base_url(); ?>index.php/dashboard/suggestparties", 
         minLength:1,
         /*select: function(event, ui) {
         var party_id = ui.item.value;
         getPropertyByPropertyOwnerId(party_id);
         }*
         });
         
         $('#txtProperty').autocomplete({
         source:"<?php echo base_url(); ?>index.php/dashboard/suggestproperties", 
         minLength:1,
         /*select: function(event, ui) {
         var party_id = ui.item.value;
         getPropertyByPropertyOwnerId(party_id);
         }*
         });*/

        //---------------------------------------------------------------------------------------------------------------------------------------------------------

        var counter = 2;

        $("#addButton").click(function () {

            /*if(counter>10){
             alert("Only 10 doc fields are allowed");
             return false;
             }*/

            var newTextBoxDiv = $(document.createElement('div')).attr("id", 'TextBoxDiv' + counter);

            newTextBoxDiv.after().html('<div class="Txtblks"><label>Attach ' + counter + ' : </label></div>' + '<div class="fldblks"><input type="hidden" name="hfAttachmentPath[]" id="hfAttachment' + counter + 'Path" /><input type="hidden" name="hfAttachmentName[]" id="hfAttachment' + counter + 'Name" /><input type="file" name="txtAttachment' + counter + '" id="txtAttachment' + counter + '" class="fild" value="" /></div><div class="Txtblks"><label>Title ' + counter + ' : </label></div><div class="fldblks"><input type="text" name="txtTitleAttachment' + counter + '" id="txtTitleAttachment' + counter + '" class="fild" style="width:200px;" value="" />&nbsp;<input type="button" name="btnUploadAttachment' + counter + '" id="btnUploadAttachment' + counter + '" value="Upload ' + counter + '" onclick="UploadAttachment(' + counter + ')" /></div><div class="clear"></div><div class="Txtblks">&nbsp;</div><div class="fldblks">&nbsp;</div><div class="Txtblks">&nbsp;</div><div class="fldblks" id="dvAttachment' + counter + 'File" style="display:none; font-size:10px; text-align:left; border:0px solid blue;"><div style="font-size:12px; font-weight:bold; float:left; width:25%; border:0px solid red; ">Uploaded ' + counter + ' :</div><div id="dvAttachment' + counter + 'Name" style="font-size:12px; float:left; width:60%; border:0px solid red;"> </div><div style="float:left; width:15%; border:0px solid red;"><a href="#" onclick="DeleteAttachment(' + counter + ');"><img src="<?php echo base_url(); ?>images/remove.png" align="center" height="18" width="18" /></a></div></div><div class="clear"></div>');

            newTextBoxDiv.appendTo("#TextBoxesGroup");

            counter++;
        });

        $("#removeButton").click(function () {

            if (counter == 2) {
                alert("No more image fields to remove");
                return false;
            }

            counter--;

            $("#TextBoxDiv" + counter).remove();
        });

    });
</script>

<script type="text/javascript" language="javascript">
    function getRequirementByClient()
    {
        var cmbClientReq = $("#cmbClientReq").val();

        if (cmbClientReq != '')
        {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo base_url(); ?>index.php/dashboard/getrequirementbyclient",
                data: "cmbClient=" + cmbClientReq,
                success: function (details) {

                    $('#cmbRequirement').children('option:not(:first)').remove();

                    $.each(details, function (reqid, reqname) {

                        var opt = $('<option />');

                        if (reqid == "<?php echo $RequirementId; ?>") {
                            opt.val(reqid);
                            opt.text(reqname);
                            $(opt).attr('selected', 'selected');
                        } else
                        {
                            opt.val(reqid);
                            opt.text(reqname);
                        }

                        $('#cmbRequirement').append(opt);
                    });

                    $('#cmbRequirement').trigger("liszt:updated");
                }
            });
        } else
        {
            $('#cmbRequirement').val('');
        }
    }
</script>

<script type="text/javascript" language="javascript">
    function getPropertyByClient()
    {
        var cmbClientProp = $("#cmbClientProp").val();

        if (cmbClientProp != '')
        {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo base_url(); ?>index.php/dashboard/getpropertybyclient",
                data: "cmbClient=" + cmbClientProp,
                success: function (details) {
                    //alert(details);
                    $('#cmbProperty').children('option:not(:first)').remove();

                    $.each(details, function (propid, propname) {

                        var opt = $('<option />');

                        if (propid == "<?php echo $PropertyId; ?>") {
                            opt.val(propid);
                            opt.text(propname);
                            $(opt).attr('selected', 'selected');
                        } else
                        {
                            opt.val(propid);
                            opt.text(propname);
                        }
                        $('#cmbProperty').append(opt);
                    });

                    $('#cmbProperty').trigger("liszt:updated");
                }
            });
        } else
        {
            $('#cmbProperty').val('');
        }
    }
</script>

<script type="text/javascript" language="javascript">
    function UploadAttachment(attachno)
    {
        $("#btnUploadAttachment" + attachno).val("uploading...");

        $.ajaxFileUpload({
            url: "<?php echo site_url(); ?>/dashboard/upload_deal_attachment/" + attachno,
            secureuri: false,
            fileElementId: 'txtAttachment' + attachno,
            dataType: 'json',
            success: function (data, status)
            {
                if (data.status != 'error')
                {
                    $("#hfAttachment" + attachno + "Path").val(data.attachment_file_path);
                    $("#hfAttachment" + attachno + "Name").val(data.attachment_file_name);
                    $("#dvAttachment" + attachno + "Name").html('(' + data.attachment_file_name + ')');
                    $("#dvAttachment" + attachno + "File").css("display", "block");
                    $("#txtAttachment" + attachno).disabled = true;
                    $("#btnUploadAttachment" + attachno).val("Upload" + attachno);
                    alert(data.msg);
                }
            }
        });
    }
</script>

<script type="text/javascript">
    function DeleteAttachment(attachno)
    {
        var confdel = confirm("Are you sure to delete this image...?")

        if (confdel)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/dashboard/delete_uploaded_deal_attachment",
                data: "AttachmentName=" + $("#hfAttachment" + attachno + "Name").val() + "&AttachmentPath=" + $("#hfAttachment" + attachno + "Path").val(),
                success: function (data) {

                    if (data == 'TRUE')
                    {
                        //alert("Attachment deleted successfully.");					 
                        $("#hfAttachment" + attachno + "Path").val('');
                        $("#hfAttachment" + attachno + "Name").val('');
                        $("#dvAttachment" + attachno + "Name").html('');
                        $("#dvAttachment" + attachno + "File").css("display", "none");
                        $("#txtAttachment" + attachno).disabled = false;
                        $("#txtAttachment" + attachno).focus();
                    } else
                    {
                        alert("Error in deleting image.");
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
        $('#cmbLesser').children('option:not(:first)').remove();

        if ($("#cmbProperty").val() == '')
        {
            alert("Please Select Property");
            $("#cmbProperty").focus();
            return false;
        } else
        {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo base_url(); ?>index.php/dashboard/getpropertyownerbyproperty",
                data: "cmbProperty=" + $("#cmbProperty").val(),
                success: function (details) {

                    $('#cmbLesser').children('option:not(:first)').remove();

                    $.each(details, function (lesserid, lessername) {

                        var opt = $('<option />');

                        if (lesserid == "<?php echo $LesserId; ?>") {
                            opt.val(lesserid);
                            opt.text(lessername);
                            $(opt).attr('selected', 'selected');
                        } else
                        {
                            opt.val(lesserid);
                            opt.text(lessername);
                        }

                        $('#cmbLesser').append(opt);
                    });
                }
            });
        }
    }
</script>

<script type="text/javascript" language="javascript">
    function FormValidate(btn)
    {
        if ($("#txtProperty").val() == '')
        {
            alert("Please select Property");
            $("#txtProperty").focus();
            return false;
        } else if ($("#txtTaglineForWebsite").val() == '')
        {
            alert("Please enter tagline for website");
            $("#txtTaglineForWebsite").focus();
            return false;
        } else
        {
            var data = $("#editForm").serialize();

            btn.disabled = true;
            btn.value = 'Submitting...';

            var url = "<?php echo base_url(); ?>index.php/dashboard/edit_deal_initiate";

            $.post(url, data, function (data) {

                if (data)
                {
                    if (data.status == 1)
                    {
                        btn.disabled = false;
                        btn.value = 'Submit';
                        alert(data.msg);
                        var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_deal_initiate";
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

<script type="text/javascript" language="javascript">
    $(".chzn-select").chosen();
    $(".chzn-select-deselect").chosen({allow_single_deselect: true});
</script>


<script type="text/javascript">
function DeleteExistingAttachment(AttachmentId,PropertyId,AttachmentName,AttachmentPath)
{
	var confdel = confirm("Are you sure to delete this image...?")
	
	if(confdel)
	{ 
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/dashboard/delete_existing_deal_done_attachment",
			data: "AttachmentId="+AttachmentId+"&PropertyId="+PropertyId+"&AttachmentName="+AttachmentName+"&AttachmentPath="+AttachmentPath,
			success: function(datas){
                            
                            var data = $.trim(datas);
                            
                          
				
				if(data=='1')
				{
					alert("Attachment deleted successfully.");
					var url = "<?php echo base_url(); ?>index.php/dashboard/edit_form_deal_initiate/"+PropertyId;    
					$(location).attr('href',url);
				}
				else
				{
					alert("Error in deleting file.");
					return false;
				}
			}
		});
	}
}
</script>

<script type="text/javascript">
function DeleteAttachment(attachno)
{
	var confdel = confirm("Are you sure to delete this image...?")
	
	if(confdel)
	{ 	
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/dashboard/delete_uploaded_dealdone_attachment",
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
					alert("Error in deleting image.");
					return false;
				}
			}
		});
	}
}
</script>