<!DOCTYPE html>
<html lang="en">
 <head>
 <title>Linkers - Login</title>
 <meta charset="utf-8">
 <meta name="format-detection" content="telephone=no" />
 <link rel="icon" href="<?php echo base_url(); ?>/images/favicon.ico" >
 <link rel="shortcut icon" href="<?php echo base_url(); ?>/images/favicon.ico"  />
 <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>/css/style.css">
 <link rel="stylesheet" href="<?php echo base_url(); ?>/css/font-awesome.css">

<!--[if lt IE 8]>
   <div style=' clear: both; text-align:center; position: relative;'>
     <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
       <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
    </a>
  </div>
<![endif]-->
     <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>

	<link  type="text/css" media="screen" href="css/ie.css">
    <![endif]-->
    <style type="text/css">
	body { background-color:#e2e6ea;}
	</style>
    
     </head>
     <body>
<!--==============================header=================================-->
<form name="form1" action="<?php echo site_url();?>/login/validate" method="post">
<div class="formlogin">
<h2>Login</h2>
<div class="lgninner">

<?php /*?>
<div class="Txtblks">User Type *</div>
<div class="fldblks">
	<select name="cmbUserType" id="cmbUserType" tabindex="1" class="fild">
	<option value="">Select User Type</option>
    <option value="Admin" <?php echo set_select("cmbUserType","Admin"); ?>>Admin</option>
     <option value="Manager" <?php echo set_select("cmbUserType","Manager"); ?>>Manager</option>
	<option value="Employee" <?php echo set_select("cmbUserType","Employee"); ?>>Employee</option>
    <option value="Accountant" <?php echo set_select("cmbUserType","Accountant"); ?>>Accountant</option>
	</select>
</div>
<?php */?>

<div class="Txtblks">Username *</div>
<div class="fldblks"><input type="text" name="txtUserName" id="txtUserName" value="<?php echo set_value('txtUserName'); ?>" tabindex="2" class="fild"></div>
<div class="Txtblks">Password *</div>
<div class="fldblks"><input type="password" name="txtPassword"  id="txtPassword" value="<?php echo set_value('txtPassword'); ?>" tabindex="3" class="fild"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks"><input type="submit" name="btnSubmit" value="Submit" class="btn"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks"><a href="<?php echo base_url('login/forgotpassword') ?>">Forgot Password</a></div>
<div class="clear"></div>

</div>
<div class="Txtblks" style="text-align:center; color:#FF0000;"><?php echo validation_errors(); ?><br /><?php echo $this->session->flashdata('msg');?></div>
<div class="Txtblks">&nbsp;</div>
<div class="clear"></div>
</div>
</form>

<!--=======content================================-->
<!--==============================footer=================================-->
</body>
</html>