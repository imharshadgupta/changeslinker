<!--==============================Form=================================-->

<form name="editForm" id="editForm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="hfWebsiteLogoId" id="hfWebsiteLogoId" value="<?php echo set_value('hfWebsiteLogoId',$WebsiteLogoId); ?>"/>
<input type="hidden" name="hfWebsiteLogoExistingFilePath" id="hfWebsiteLogoExistingFilePath" value="<?php echo set_value('hfWebsiteLogoExistingFilePath',$WebsiteLogoFilePath); ?>"/>
<input type="hidden" name="hfActive" id="hfActive" value="<?php echo set_value('hfActive',$Active); ?>" />
<div class="inner_form">
<h2>Edit Website Logos</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>

<fieldset>
<legend>Existing Logo</legend>
    <?php 
    if((isset($WebsiteLogoFileName)) && (!empty($WebsiteLogoFileName)))
    {
    ?>
        <div align="left">
            <div class="Txtblks">&nbsp;</div>
            <div class="fldblks" style="text-align:left;">
            <img src="<?php echo base_url(); ?>uploads/website_logos/<?php echo $WebsiteLogoFileName; ?>" align="center" height="100" width="150" />	
            </div>

            <?php /* ?><div class="fldblks"><input type='button' value='Delete' id='delButton' onclick="DeleteExistingWebsiteLogo('<?php echo $WebsiteLogoId; ?>','<?php echo $WebsiteLogoFileName; ?>','<?php echo $WebsiteLogoFilePath; ?>')"></div><?php */ ?>
            <div class="clear"></div>
        </div>
    <?php 
    }
    else
    {
    ?>
        <div align="left">
            <div class="Txtblks">&nbsp;</div>
            <div class="Txtblks" style="text-align:left;"><strong>No Website Logo exists.</strong></div>
            <div class="fldblks">&nbsp;</div>
            <div class="clear"></div>
        </div>
    <?php 
    }
    ?>
</fieldset>

<fieldset><legend>Website Logos</legend>

<div class="Txtblks">Upload Logo</div>
					 <input type="hidden" name="hfWebsiteLogoFilePath" id="hfWebsiteLogoFilePath" value="" />
					 <input type="hidden" name="hfWebsiteLogoFileName" id="hfWebsiteLogoFileName" value="" />
<div class="fldblks"><input type="file" name="txtWebsiteLogo" id="txtWebsiteLogo" class="fild" tabindex="1" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks" id="dvWebsiteLogoFile" style="display:none; font-size:10px; text-align:left; border:0px solid blue;">
	<div style="font-size:12px; font-weight:bold; float:left; width:25%; border:0px solid red;">Uploaded :</div>
	<div id="dvWebsiteLogoName" style="font-size:12px; float:left; width:60%; border:0px solid red;"> </div>
	<div style="float:left; width:15%; border:0px solid red;"><a href="#" onclick="DeleteWebsiteLogo();"><img src="<?php echo base_url(); ?>images/remove.png" align="center" height="18" width="20" /></a></div>
</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks"><input type="button" name="btnUploadWebsiteLogo" id="btnUploadWebsiteLogo" value="Upload Logo" /></div>
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
<div class="fldblks"><input type="checkbox" name="chkActive" id="chkActive" onclick="ChangeActive();" value="1" <?php echo set_checkbox('chkActive', '1', ($Active == '1' ? TRUE : '')); ?> /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this);" />

&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_website_logo_master"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

	<div class="clear"></div>
</div>
	<div class="clear"></div>
</div>
</form>

<script type="text/javascript" language="javascript">
$(document).ready(function(){
	
	$('#btnUploadWebsiteLogo').click(function(e) {	
		//e.preventDefault();
		$("#btnUploadWebsiteLogo").val("uploading...");
		
		$.ajaxFileUpload({
			url 			: "<?php echo site_url(); ?>/dashboard/upload_website_logo_file", 
			secureuri		:false,
			fileElementId	:'txtWebsiteLogo',
			dataType		: 'json',
			success	: function (data, status)
			{
				//alert(data.status);
				if(data.status != 'error')
				{
					$("#hfWebsiteLogoFilePath").val(data.website_logo_file_path);
				    $("#hfWebsiteLogoFileName").val(data.website_logo_file_name);
				  //$("#dvWebsiteLogoName").html('('+data.website_logo_file_name+')');
				    $("#dvWebsiteLogoName").html('<img src="<?php echo base_url(); ?>uploads/website_logos/'+data.website_logo_file_name+'" align="center" height="100" width="150" />');
				    $("#dvWebsiteLogoFile").css("display", "block");
				    $("#txtWebsiteLogo").disabled = true;
				    $("#btnUploadWebsiteLogo").val("Upload Logo");
				    alert(data.msg);	
				}
			}
		});
		return false;
	});
});	
</script>

<script type="text/javascript">
function DeleteWebsiteLogo(logono)
{
	var confdel = confirm("Are you sure to delete this document...?")
	
	if(confdel)
	{ 	
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/dashboard/delete_uploaded_website_logo",
			data: "WebsiteLogoName="+$("#hfWebsiteLogoFileName").val()+"&WebsiteLogoPath="+$("#hfWebsiteLogoFilePath").val(),
			success: function(data){
			
			    if(data=='TRUE')
				{
				 //alert("Attachment deleted successfully.");
				   $("#hfWebsiteLogoFilePath").val('');
				   $("#hfWebsiteLogoFileName").val('');
				   $("#dvWebsiteLogoName").html('');
				   $("#dvWebsiteLogoFile").css("display", "none");
				   $("#txtWebsiteLogo").disabled=false;
				   $("#txtWebsiteLogo").val('');
				   $("#txtWebsiteLogo").focus();
				}
				else
				{
					alert("Error in deleting doc.");
					return false;
				}
			}
		});
	}
}
</script>

<script type="text/javascript">
/*function DeleteExistingWebsiteLogo(WebsiteLogoId,WebsiteLogoName,WebsiteLogoPath)
{
    var confdel = confirm("Are you sure to delete this document...?")
    
    if(confdel)
    { 
        $.ajax({
            type: "POST",
            url: "<?php //echo base_url();?>index.php/dashboard/delete_existing_website_logo",
            data: "WebsiteLogoId="+WebsiteLogoId+"&WebsiteLogoName="+WebsiteLogoName+"&WebsiteLogoPath="+WebsiteLogoPath,
            success: function(data){
                
                if(data=='TRUE')
                {
                    alert("Website logo deleted successfully.");
                    var url = "<?php //echo base_url(); ?>index.php/dashboard/edit_form_website_logo_master/"+WebsiteLogoId;    
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
}*/
</script>

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
function FormValidate(btn)
{
  /*if($("#txtWebsiteLogo").val()=='')
    {	
        alert("Please select Website Logo");
        $("#txtWebsiteLogo").focus();
        return false;
    }
    else
    {*/
		var data = $("#editForm").serialize();
		
		var url = "<?php echo base_url(); ?>index.php/dashboard/edit_website_logo_master";
		
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
					var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_website_logo_master/";
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
  //}
}
</script>