<!--=================================================Form======================================================-->

<form name="addForm" id="addForm" method="post" action="" enctype="multipart/form-data">
    <div class="inner_form">
        <h2>Add Details</h2>
        <div class="mfrminner">
            <div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg'); ?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
            <fieldset><legend>General Details</legend>

                <div class="Txtblks">Share Date</div>
                <div class="fldblks"><input type="text" name="txtTaskAssignDateTime" id="txtTaskAssignDateTime" class="fild" style="width:290px;" value="<?php echo set_value('txtTaskAssignDateTime'); ?>" readonly="readonly" tabindex="1" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <!--<div class="Txtblks">To Department</div>
                <div class="fldblks">
                        <select name="cmbDepartment" id="cmbDepartment" class="fild" tabindex="2">
                        <option value="">Select Department</option>
                <?php
                $this->db->where('bActive', 1);
                $this->db->where('bDelete', 0);
                $sql = $this->db->get('department_master');
                if ($sql) {
                    if (($sql->num_rows) > 0) {
                        $rows = $sql->result_array();

                        foreach ($rows as $row):

                            $Department_Id = trim($row['iDepartmentId']);
                            $Department_Name = trim($row['cDepartmentName']);
                            ?>
                                                            <option value="<?php echo $Department_Id; ?>"><?php echo $Department_Name; ?></option>
                            <?php
                        endforeach;
                    }
                }
                ?>
                        </select>
                </div>-->

                <div class="Txtblks">To User</div>
                <div class="fldblks">
                    <select name="cmbDepartment" id="cmbDepartment" class="fild chzn-select" tabindex="2">
                        <option value="">Select User</option>
<?php
$this->db->where('bActive', 1);
$this->db->where('bDelete', 0);
$sql = $this->db->get('user_master');
if ($sql) {
    if (($sql->num_rows) > 0) {
        $rows = $sql->result_array();

        foreach ($rows as $row):

            $Department_Id = trim($row['iUserId']);
            $Department_Name = trim($row['cName']);
            ?>
                                    <option value="<?php echo $Department_Id; ?>"><?php echo $Department_Name; ?></option>
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
                <!--	<select name="cmbClientReq" id="cmbClientReq" class="chzn-select fild" onchange="getRequirementByClient();" tabindex="3">-->
                    <select name="cmbClientReq" id="cmbClientReq" class="chzn-select fild" tabindex="3">
                        <option value="">Select Client</option>
<?php
$this->db->order_by("cClientName", "asc");
$this->db->where('bActive', 1);
$this->db->where('bDelete', 0);
$sql = $this->db->get('client_master');
if ($sql) {
    if (($sql->num_rows) > 0) {
        $rows = $sql->result_array();

        foreach ($rows as $row):

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

                <div class="Txtblks">Requirement</div>
                <div class="fldblks">
                    <select name="cmbRequirement" id="cmbRequirement" class="chzn-select fild" tabindex="4">
                        <option value="">Select Requirement</option>

<?php
$this->db->where('bActive', 1);
$this->db->where('bDelete', 0);
$sql = $this->db->get('requirement_master');
if ($sql) {
    if (($sql->num_rows) > 0) {
        $rows = $sql->result_array();

        foreach ($rows as $row):

            $Department_Ids = trim($row['iRequirementId']);
            $Department_Names = trim($row['cRequirementTitle']);
            ?>
                                    <option value="<?php echo $Department_Ids; ?>"><?php echo $Department_Names; ?></option>
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

                <div class="Txtblks">Property</div>
                <div class="fldblks">
                    <select name="cmbProperty" id="cmbProperty" class="fild chzn-select" tabindex="6">
                        <option value="">Select Property</option>
<?php
$this->db->where('bActive', 1);
$this->db->where('bDelete', 0);
$sql = $this->db->get('property_master');
if ($sql) {
    if (($sql->num_rows) > 0) {
        $rows = $sql->result_array();

        foreach ($rows as $row):

            $Client_Ids = trim($row['iPropertyId']);
            $Client_Names = trim($row['cPropertyName']);
            ?>
                                    <option value="<?php echo $Client_Ids; ?>"><?php echo $Client_Names; ?></option>
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

                <div class="Txtblks">Task</div>
                <div class="fldblks">
                    <select name="cmbTask" id="cmbTask" class="fild chzn-select" tabindex="7">
                        <option value="">Select Task</option>
                        <?php
                        $this->db->where('bActive', 1);
                        $this->db->where('bDelete', 0);
                        $sql = $this->db->get('task_master');
                        if ($sql) {
                            if (($sql->num_rows) > 0) {
                                $rows = $sql->result_array();

                                foreach ($rows as $row):

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
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Task Summary</div>
                <div class="fldblks"><textarea name="txtTaskSummary" id="txtTaskSummary" class="fild" tabindex="8"><?php echo set_value('txtTaskSummary'); ?></textarea></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Target Date</div>
                <div class="fldblks"><input type="text" name="txtTaskTargetDateTime" id="txtTaskTargetDateTime" class="fild" style="width:290px;" value="<?php echo set_value('txtTaskTargetDateTime'); ?>" readonly="readonly" tabindex="9" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>

                <div class="Txtblks">Reminder Date</div>
                <div class="fldblks"><input type="text" name="txtReminderDateTime" id="txtReminderDateTime" class="fild" style="width:290px;" value="<?php echo set_value('txtReminderDateTime'); ?>" readonly="readonly" tabindex="10" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>


                <div class="Txtblks">Task Done</div>
                <div class="fldblks"><input type="checkbox" name="taskdonestatus" id="taskdonestatus" class="fild" style="width:13px;" value="1"  tabindex="10" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>


                <div class="Txtblks">Done Date</div>
                <div class="fldblks"><input type="text" name="donedate" id="donedate" class="fild" style="width:290px;" value="<?php echo set_value('donedate'); ?>" readonly="readonly" tabindex="10" /></div>
                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>
                <div class="clear"></div>


                <div class="Txtblks">Done Details</div>
                <div class="fldblks"><textarea name="donedetails" id="donedetails" class="fild" tabindex="8"><?php echo set_value('txtTaskSummary'); ?></textarea></div>
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

            <div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this);" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_task_assign"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</form>

<script type="text/javascript" language="javascript">
    $(document).ready(function(){
        $('#txtTaskAssignDateTime').datetimepicker({
            dateFormat: 'dd/mm/yy',
            controlType: 'select',
            oneLine: true,
            timeFormat: 'hh:mm tt',
            showOn: 'button',
            buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
            buttonImageOnly: true
        });
        //var currentDate = new Date();  
        //$("#txtTaskAssignDateTime").datepicker("setDate",currentDate);
        var Mydate = new Date();  
	
        var day = Mydate.getDate();
        var dayval =  day < 10 ? '0' + day : '' + day;
	
        var month = Mydate.getMonth() + 1;
        var monval =  month < 10 ? '0' + month : '' + month;

        var newdat = (monval +"/"+ dayval+"/"+Mydate.getFullYear());
        var splitdt = newdat.split("/");
	
        var defaultcurrdt = splitdt[1]+"/"+splitdt[0]+"/"+splitdt[2];
	
        $("#txtTaskAssignDateTime").val(defaultcurrdt);
	
        $('#txtTaskTargetDateTime').datetimepicker({
            dateFormat: 'dd/mm/yy',
            controlType: 'select',
            oneLine: true,
            timeFormat: 'hh:mm tt',
            showOn: 'button',
            buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
            buttonImageOnly: true
        });
	
        $('#txtReminderDateTime').datetimepicker({
            dateFormat: 'dd/mm/yy',
            controlType: 'select',
            oneLine: true,
            timeFormat: 'hh:mm tt',
            showOn: 'button',
            buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
            buttonImageOnly: true
        });
        
        $('#donedate').datepicker({
            dateFormat: 'dd/mm/yy',
            controlType: 'select',
            oneLine: true, 		
            showOn: 'button',
            buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
            buttonImageOnly: true
        });
        
        
        
    });	
</script>

<script type="text/javascript" language="javascript">
    function getRequirementByClient()
    {	
        var cmbClientReq = $("#cmbClientReq").val();
	
        if(cmbClientReq!='')
        {	
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo base_url(); ?>index.php/dashboard/getrequirementbyclient",
                data: "cmbClient="+cmbClientReq,
                success: function(details){
				
                    $('#cmbRequirement').children('option:not(:first)').remove();
				
                    $.each(details,function(reqid,reqname) {
                        var opt = $('<option />'); 									
                        opt.val(reqid);
                        opt.text(reqname);
                        $('#cmbRequirement').append(opt); 			  
                    });
				
                    $('#cmbRequirement').trigger("liszt:updated");	
                }
            });
        }
        else
        {
            $('#cmbRequirement').val('');
        }
    }
</script>

<script type="text/javascript" language="javascript">
    function getPropertyByClient()
    {	
        var cmbClientProp = $("#cmbClientProp").val(); 
	
        if(cmbClientProp!='')
        {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo base_url(); ?>index.php/dashboard/getpropertybyclient",
                data: "cmbClient="+cmbClientProp,
                success: function(details){
                    //alert(details);
                    $('#cmbProperty').children('option:not(:first)').remove();
				
                    $.each(details,function(propid,propname) {
                        var opt = $('<option />'); 									
                        opt.val(propid);
                        opt.text(propname);
                        $('#cmbProperty').append(opt);			  
                    });
				
                    $('#cmbProperty').trigger("liszt:updated");
                }
            });
        }
        else
        {
            $('#cmbProperty').val('');
        }
    }
</script>

<script type="text/javascript" language="javascript">
    function FormValidate(btn)
    {
        if($("#cmbUser").val()=='')
        {	
            alert("Please select User");
            $("#cmbUser").focus();
            return false;
        }
        else if($("#txtTaskSummary").val()=='')
        {	
            alert("Please enter Task Summary");
            $("#txtTaskSummary").focus();
            return false;
        }
        else
        {
        
        
      
            var data = $("#addForm").serialize();
		
            var url = "<?php echo base_url(); ?>index.php/dashboard/add_task_assign";
		
            btn.disabled = true;
            btn.value = 'Submitting...';
                
                
            $.ajax({
                type:"post",
                //dataType:"json",
                url: url,
                data: data,
                success: function(responsedatas) {
                
                    var responsedata =  jQuery.parseJSON(responsedatas.trim());   
              
                    if(responsedata.status == 1)
                    {	
                        var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_task_assign";
                                
                        btn.disabled = false;
                        btn.value = 'Submit';
                        alert(responsedata.msg);
                        window.location.href = redirecturl;
					
                        //$(location).attr('href',redirecturl);	
                    }	
                    else
                    {
                        btn.disabled = false;
                        btn.value = 'Submit';
                        alert(responsedata.msg);
                    } 
                
                }                
            });
                
                
                
            return false;  
		
            $.post(url,data,function(responsedata,status){	
			
                alert(responsedata);
			
                if(responsedata)
                {
                    if(responsedata.status == 1)
                    {	
                        var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_task_assign";
                                    
                        window.location.href = redirecturl;
                        alert('aaaaaaaaaaaaa');
                        return false;
        
                                    
                        btn.disabled = false;
                        btn.value = 'Submit';
                        alert(responsedata.msg);
					
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

<script type="text/javascript" language="javascript"> 
    $(".chzn-select").chosen(); 
    $(".chzn-select-deselect").chosen({allow_single_deselect:true}); 
</script>