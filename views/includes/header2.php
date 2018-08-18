<!DOCTYPE html>
<html lang="en">
<head>
<title>Dashboard</title>
<meta charset="utf-8">
<meta name="format-detection" content="telephone=no" />
<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico">
<link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.ico" />

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery-ui-multiselect-widget-master/jquery.multiselect.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery-ui-multiselect-widget-master/jquery.multiselect.filter.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery-ui-multiselect-widget-master/demos/assets/style.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery-ui-multiselect-widget-master/demos/assets/prettify.css" />
<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" />
    
<!--<link href="<?php //echo base_url(); ?>assets/jquery-ui-1.10.2.custom/css/smoothness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />-->
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/datatable/css/demo_table_jui.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/datatable/themes/smoothness/jquery-ui-1.8.4.custom.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" media="screen">
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/font-awesome.css">
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/menu_style.css" media="screen">

<style type="text/css">@import url("<?php echo base_url(); ?>css/tabbed.css");</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/blue.css" media="screen" />    

<script type="text/javascript" src="<?php echo base_url(); ?>js/switch.js"></script>

<!--<script src="<?php //echo base_url(); ?>assets/jquery-ui-1.10.2.custom/ui/jquery.ui.datepicker.js"></script>-->	

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/chosen-master/chosen/chosen.css" media="screen" />

<script type="text/javascript" src="<?php echo base_url(); ?>assets/chosen-master/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bpopup/jquery.bpopup.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.bpopup.js"></script>

<!--[if IE 9]>
<script type="text/javascript" src="js/placeholder.js"></script>
<![endif]-->

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

</head>
<body>     
     
<!--======================================header=================================-->
     
<header>

<div class="container_12">
    <div class="grid_12">
    	<h1><a href="#"><img src="<?php echo base_url(); ?>images/logo.png"></a></h1>
     	
    <div class="grid_13">
    	<!--<h1><a href="#"><img src="<?php //echo base_url(); ?>images/careerpluslogo.jpg"></a></h1>-->
    </div>
            
	<div class="clear"></div>

	<div align="center">Welcome, <strong><?php echo $this->session->userdata('username'); ?></strong></div>
   
<div class="container">
	<a class="toggleMenu" href="#">Menu</a>
	<ul class="nav">	
	 	<li class="test">
            <a href="<?php echo base_url(); ?>index.php/dashboard" class="drop">HOME</a>
		</li>
		<li class="test">
            <a href="#" class="drop">TASKS</a>
            <ul>
			<?php 
			if($this->session->userdata('usertype')=='SuperAdmin')
			{
			?>
				<li class="test">
					<a href="<?php echo base_url(); ?>index.php/dashboard/schoollisting">School</a> 
				</li>
			<?php
			}
			?>
				
			<li class="test">
				<a href="<?php echo base_url(); ?>index.php/dashboard/tclisting">TC</a> 
			</li>
			</ul>
		</li>
    <?php
  /*$sql = $this->db->query("SELECT distinct user_rights_details.iParentMenuId,menu_master.iMenuId,menu_master.cMenuName,menu_master.cMenuUrl FROM user_rights_details 
	LEFT JOIN menu_master ON user_rights_details.iParentMenuId=menu_master.iMenuId WHERE user_rights_details.iUserId='".$this->session->userdata('userid')."' AND user_rights_details.cUserName='".$this->session->userdata('username')."' ORDER BY menu_master.iDisplaySequence");
	
	if($sql)
	{
		if(($sql->num_rows) > 0)
		{
                $parent_menus = $sql->result_array();
            
                foreach($parent_menus as $parent_menu): 
				
                    $ParentMenuId=trim($parent_menu['iMenuId']);
                    $ParentMenuName=trim($parent_menu['cMenuName']);
                    $ParentMenuUrl = trim($parent_menu['cMenuUrl']);
            ?>
        
            <li class="test">
                <a href="#" class="drop"><?php echo $ParentMenuName; ?></a>
                <ul>
            
        	<?php
            $childquery = $this->db->query("SELECT user_rights_details.iMenuId,user_rights_details.bAdd,user_rights_details.bEdit,user_rights_details.bDelete,
menu_master.cMenuName,menu_master.cMenuUrl FROM user_rights_details LEFT JOIN menu_master ON user_rights_details.iMenuId=menu_master.iMenuId WHERE 
user_rights_details.iUserId='".$this->session->userdata('userid')."' AND user_rights_details.cUserName='".$this->session->userdata('username')."' AND user_rights_details.`iParentMenuId`=\"$ParentMenuId\" ORDER BY menu_master.iDisplaySequence");
	
            if(($childquery->num_rows) > 0)
            {
                //echo $childquery->num_rows."<br />";
                $child_menus = $childquery->result_array();
                
                foreach($child_menus as $child_menu):
                
                    $ChildMenuId=trim($child_menu['iMenuId']);
                    $ChildMenuName=trim($child_menu['cMenuName']);
                    $ChildMenuUrl=trim($child_menu['cMenuUrl']);
                    
                    $RightToAdd = trim($child_menu['bAdd']);
                    $RightToEdit = trim($child_menu['bEdit']);
                    $RightToDelete = trim($child_menu['bDelete']);
					
                   	//$SessChildMenuName = str_replace(' ','_', $ChildMenuName); // Find space in ChildMenuName & replace it with underscore.

                    $userrightsdata = array(
                        'RightToAdd'."_$ChildMenuId" => $RightToAdd,
                        'RightToEdit'."_$ChildMenuId" => $RightToEdit,
                        'RightToDelete'."_$ChildMenuId" => $RightToDelete
                    );
                    
                    $this->session->set_userdata($userrightsdata);
					
				  //echo $this->session->userdata('RightToAdd')."=>".$this->session->userdata('RightToEdit')."=>".$this->session->userdata('RightToDelete');
                  // $this->session->userdata('RightToAdd')."=>".$this->session->userdata('RightToEdit')."=>".$this->session->userdata('RightToDelete')	
				?>
                <li><?php echo anchor("$ChildMenuUrl","$ChildMenuName"); ?></li>

                <?php
                endforeach;	
                ?>
            <?php
            }			          
            ?>
        
            </ul>
        </li>
        <?php endforeach; ?>
	<?php
		}
	}*/
	?>
	
    <li class="test">
        <a href="<?php echo base_url(); ?>index.php/login/logout">LOGOUT</a>
    </li>        
    
	<script type="text/javascript" src="<?php echo base_url(); ?>js/menu_jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/script.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery-ui-1.10.2.custom/js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery-ui-1.10.2.custom/js/jquery-ui-1.10.2.custom.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/datatable/js/jquery.dataTables.js"></script>
        
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery-ui-multiselect-widget-master/src/jquery.multiselect.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery-ui-multiselect-widget-master/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery-ui-multiselect-widget-master/demos/assets/prettify.js"></script>
    </ul>
    
    </div>
        
    </div>
</div>
</header>
    
<!--==============================End header=================================-->