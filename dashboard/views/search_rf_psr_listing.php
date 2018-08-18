<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        var oTable = $('#example').dataTable({
            "bJQueryUI": true,
            "aaSorting":[[0, "asc"]],
            "sPaginationType": "full_numbers",
            "aLengthMenu": [[20, 50, 100], [20, 50, 100]],
            "iDisplayLength": 20
        });
    });
</script>

<div class="inner_form">
    <h2>RF-PSR Search</h2>
    <form name="searchForm" id="searchForm" method="post" action="<?php echo base_url(); ?>index.php/dashboard/searchrfpsr">
        <div class="mfrminner">
            <div class="Txtblks">Search For</div>
            <div class="fldblks">
                <select name="cmbSearchFor" id="cmbSearchFor" class="fild chzn-select" style="width:200px;" onchange="ChangeSearchFor()">
                    <option value="">Select Search For</option>
                    <option value="RF" <?php
if (isset($_POST['cmbSearchFor']) && $_POST['cmbSearchFor'] == "RF") {
    echo 'selected';
}
?>>RF</option>
                    <option value="PSR" <?php
if (isset($_POST['cmbSearchFor']) && $_POST['cmbSearchFor'] == "PSR") {
    echo 'selected';
}
?>>PSR</option>
                </select> 
            </div>



            <div class="Txtblks">RF/PSR</div>
            <div class="fldblks">
                <select name="cmbRFPSR" id="cmbRFPSR" class="fild chzn-select" style="width:200px;">
                    <option value="">Select RF/PSR</option>
                </select>
                &nbsp;&nbsp;<input type='button' class="btn" value="Submit" onclick="ValidateSearch();" /></div>
            <div class="clear"></div>

            <div class="Txtblks">&nbsp;</div>
            <div class="fldblks">&nbsp;</div>
            <div class="Txtblks">&nbsp;</div>
            <div class="fldblks">&nbsp;</div>
            <div class="clear"></div>

            <div class="table_wrap">	

<?php
if (isset($query) && isset($RFPSRId) && ($SearchFor == 'RF')) {
    ?>
                    <div class="tbls_wrp">		
                        <div class="tbls">   
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                <thead>
                                    <tr>
                        <!--				<th>SNo.</th>-->
                                        <th>Property Name</th>
                                        <th>Client</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Location</th>
                                        <th>Property Category</th>
                                        <th>Property Type</th>
                                         
                                        <th>Property Status</th>
                                        <th>Availablity Status</th>
                                        <th><img src="<?php echo base_url(); ?>images/View.png"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $SNo = 1;
                                    foreach ($query->result_array() as $row) {
                                        $PropertyId = trim($row['iPropertyId']);
                                        $PropertyName = trim($row['cPropertyName']);
                                        $ClientName = trim($row['cClientName']);
                                        $StateName = trim($row['cStateName']);
                                        $DistrictName = trim($row['cDistrictName']);
                                        $CityName = trim($row['cCityName']);
                                        $LocationName = trim($row['cLocationName']);
                                        $PropertyCategoryName = trim($row['cPropertyCategoryName']);
                                        $PropertyTypeName = trim($row['cPropertyTypeName']);
                                        $PropertyStatusName = trim($row['cPropertyStatusName']);
                                        $cAvailabilityStatus=($row['cAvailabilityStatus']) ? $row['cAvailabilityStatus'] : '';
                                        ?>
                                        <tr class="gradeA">
        <!--					<td style="text-align:center;"><?php echo $SNo; ?>.</td>-->
                                            <td style="text-align:left;"><?php echo $PropertyName; ?></td>
                                            <td style="text-align:left;"><?php echo $ClientName; ?></td>
                                            <td style="text-align:left;"><?php echo $StateName; ?></td>
                                            <td style="text-align:left;"><?php echo $CityName; ?></td>
                                            <td style="text-align:left;"><?php echo $LocationName; ?></td>
                                            <td style="text-align:left;"><?php echo $PropertyCategoryName; ?></td>
                                            <td style="text-align:left;"><?php echo $PropertyTypeName; ?></td>
                                             
                                            <td style="text-align:left;"><?php echo $PropertyStatusName; ?></td> <td style="text-align:left;"><?php echo $cAvailabilityStatus ?></td>
                                            <td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/viewproperty/<?php echo $PropertyId; ?>"><span class="ui-icon ui-icon-search"></span></a></td>
                                        </tr>            
        <?php
        $SNo++;
    }
    ?>
                                </tbody>
                            </table>   
                        </div>  

                        <div style="height:2px;"></div>
                    </div>
    <?php
}
?>	



<?php
if (isset($query) && isset($RFPSRId) && ($SearchFor == 'PSR')) {
    ?>
                    <div class="tbls_wrp">		
                        <div class="tbls">   
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                <thead>
                                    <tr>
                        <!--				<th>SNo.</th>-->
                                        <th>Date</th>
                                        <th>RF Title</th>
                                        <th>Client</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Location</th>
                                        <th>Property Category</th>
                                          <th>Availablity Status</th>
                                        <th><img src="<?php echo base_url(); ?>images/View.png"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $SNo = 1;
                                    foreach ($query->result_array() as $row) {
                                        $RequirementId = trim($row['iRequirementId']);

                                        $dt = trim($row['dDate']);
                                        $splitdt = explode('-', $dt);
                                        $Date = $splitdt[2] . "/" . $splitdt[1] . "/" . $splitdt[0];

                                        $RequirementTitle = trim($row['cRequirementTitle']);
                                        $ClientName = trim($row['cClientName']);
                                        $StateName = trim($row['cStateName']);
                                        $DistrictName = trim($row['cDistrictName']);
                                        $CityName = trim($row['cCityName']);
                                        $LocationName = trim($row['cLocationName']);
                                        $PropertyCategoryName = trim($row['cPropertyCategoryName']);
                                         $cAvailabilityStatus=($row['cAvailabilityStatus']) ? $row['cAvailabilityStatus'] : '';
                                        ?>

                                        <tr class="gradeA">
        <!--					<td style="text-align:center;"><?php echo $SNo; ?>.</td>-->
                                            <td style="text-align:left;"><?php echo $Date; ?></td>
                                            <td style="text-align:left;"><?php echo $RequirementTitle; ?></td>
                                            <td style="text-align:left;"><?php echo $ClientName; ?></td>
                                            <td style="text-align:left;"><?php echo $StateName; ?></td>
                                            <td style="text-align:left;"><?php echo $CityName; ?></td>
                                            <td style="text-align:left;"><?php echo $LocationName; ?></td>
                                            <td style="text-align:left;"><?php echo $PropertyCategoryName; ?></td>
                                            <td style="text-align:left;"><?php echo $cAvailabilityStatus ?></td>
                                            <td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/viewrequisition/<?php echo $RequirementId; ?>"><span class="ui-icon ui-icon-search"></span></a></td>
                                        </tr>            
        <?php
        $SNo++;
    }
    ?>
                                </tbody>
                            </table>   
                        </div>  

                        <div style="height:2px;"></div>
                    </div>
    <?php
}
?>	
            </div> 
        </div>
        <div class="clear"></div>
    </form>
</div>


<script type="text/javascript" language="javascript">
    function ChangeSearchFor(cmbclient)
    {   
        $('#cmbRFPSR').children('option:not(:first)').remove();
         //$('#cmbRFPSR').children('option').remove();
         //$('#cmbRFPSR').html('');
         
        
        if($("#cmbSearchFor").val()!='')
        {
            //$(".chzn-select").data("placeholder","Select").chosen();
            if($("#cmbSearchFor").val()=='RF')
            {
                $.ajax({
                    async : false,
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo base_url(); ?>index.php/dashboard/get_all_requirement_ajax",
                    data: "",
                    success: function(details){
                        
                       // $('#cmbRFPSR').html('');
                        $('#cmbRFPSR').children('option:not(:first)').remove();
			
                        $.each(details,function(sno,clientid_name) {	 
                            
                            //console.log(clientid_name);
                            
                            //alert(clientid_name[0]);
                            var opt = $('<option />'); 									
                            opt.val(sno);
                            opt.text(clientid_name);
                            $('#cmbRFPSR').append(opt); 
                            
                        });
                        $('#cmbRFPSR').val(cmbclient);$('.chzn-select').trigger('liszt:updated');
                       // $(".chzn-select").chosen(); 
                       // $(".chzn-select-deselect").chosen({allow_single_deselect:true}); 
                                       
                    }
                });
            }
                

		
            if($("#cmbSearchFor").val()=='PSR')
            {
                $.ajax({
                    async : false,
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo base_url(); ?>index.php/dashboard/get_all_property_ajax",
                    data: "",
                    success: function(details){
                        
                   
				//$('#cmbRFPSR').html('');	
                        $('#cmbRFPSR').children('option:not(:first)').remove();
			
                        $.each(details,function(sno,clientid_name) {
                            
                        
                            
                            //alert(clientid_name[0]);
                            var opt = $('<option />'); 									
                            opt.val(sno);
                            opt.text(clientid_name);
                            $('#cmbRFPSR').append(opt); 
                            
                        });
                         $('.chzn-select').trigger('liszt:updated');
                        $('#cmbRFPSR').val(cmbclient);
                        
                        //$(".chzn-select").chosen(); 
                       // $(".chzn-select-deselect").chosen({allow_single_deselect:true}); 
                                        
                                        
                    }
                });
            }
            
            
             $(".chzn-select").chosen(); 
       //$(".chzn-select-deselect").chosen({allow_single_deselect:true}); 
                
                  
                
        }
    }
</script>

<!--<script type="text/javascript" language="javascript">
    function ChangeClient(cmbRFPSR)
    {
        $('#cmbRFPSR').children('option:not(:first)').remove();
		
        if($("#cmbClient").val()!='')
        {	
            if($("#cmbSearchFor").val()=='RF')
            {
                $.ajax({
                    async : false,
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo base_url(); ?>index.php/dashboard/getrfbyclientid",
                    data: "cmbClient="+$("#cmbClient").val(),
                    success: function(details){
					
                        $('#cmbRFPSR').children('option:not(:first)').remove();
					
                        $.each(details,function(reqid,reqname) {	 
					
                            var opt = $('<option />'); 									
                            opt.val(reqid);
                            opt.text(reqname);
                            $('#cmbRFPSR').append(opt); 		    			
                        });
                        $('#cmbRFPSR').val(cmbRFPSR);
                    }
                });
            }
		
            if($("#cmbSearchFor").val()=='PSR')
            {
                $.ajax({
                    async : false,
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo base_url(); ?>index.php/dashboard/getpsrbyclientid",
                    data: "cmbClient="+$("#cmbClient").val(),
                    success: function(details){
					
                        $('#cmbRFPSR').children('option:not(:first)').remove();
					
                        $.each(details,function(propid,propname) {	 
					
                            var opt = $('<option />'); 									
                            opt.val(propid);
                            opt.text(propname);
                            $('#cmbRFPSR').append(opt); 		    			
                        });
                        $('#cmbRFPSR').val(cmbRFPSR);
                    }
                });
            }
        }
    }	
</script>-->

<script type="text/javascript" language="javascript">
    function ValidateSearch()
    {
        if($("#cmbSearchFor").val()=='')
        {	
            alert("Please select Search For");
            $("#cmbSearchFor").focus();
            return false;
        }	
       
        else if($("#cmbRFPSR").val()=='')
        {	
            alert("Please select RF/PSR");
            $("#cmbRFPSR").focus();
            return false;
        }
        else
        {
            $("#searchForm").submit();
        }
    }



</script>


<?php
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

if ($_POST['cmbRFPSR']!="" && $_POST['cmbSearchFor'] != "") {
    ?>
    <input type="hidden" id="clientidd" value="<?php echo $_POST['cmbClient']; ?>">
    <input type="hidden" id="cmbRFPSRID" value="<?php echo $_POST['cmbRFPSR']; ?>">
    <script>
            

             
        function setPlayerEditSelect(eID, val)
        {       
            var ele=document.getElementById(eID);
            for(var ii=0; ii<ele.length; ii++)
                if(ele.options[ii].value==val) {
                    ele.options[ii].selected=true;
                    // code for designer select
                    var txtVal = $("#"+ eID +" option:selected").text();
                    $("#"+ eID).prev().text(txtVal);
                    return true;
                }
            return false
        }
             
           
     
                                
  
                        
              
        $(document).ready(function() {
                   
            //setTimeout(function(){
            //var clientidd = $("#clientidd").val();
                 
            //  alert(clientidd);
                 
           // $('#cmbClient option[value="'+clientidd+'"]').attr('selected', 'selected');
            // },1000)      ;
           
        	
                
            //$(".chzn-select").data("placeholder","Select").chosen();
            if($("#cmbSearchFor").val()=='RF')
            {
                $.ajax({
                    async : false,
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo base_url(); ?>index.php/dashboard/get_all_requirement_ajax",
                    data: "",
                    success: function(details){
                        
                       
                        $.each(details,function(sno,clientid_name) {	 
                            
                   
                          //  var opt = $('<option />'); 									
                           // opt.val(sno);
                           // opt.text(clientid_name);
                            //$('#cmbRFPSR').append(opt); 
                            
                        });
                       $('.chzn-select').trigger('liszt:updated');
                
                                       
                    }
                });
            }
                

		
            if($("#cmbSearchFor").val()=='PSR')
            {
                $.ajax({
                    async : false,
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo base_url(); ?>index.php/dashboard/get_all_property_ajax",
                    data: "",
                    success: function(details){
                        
                 
			
                        $.each(details,function(sno,clientid_name) {
                            
                        
                            
                          
                          //  var opt = $('<option />'); 									
                          //  opt.val(sno);
                          //  opt.text(clientid_name);
                            //$('#cmbRFPSR').append(opt); 
                            
                        });
                         $('.chzn-select').trigger('liszt:updated');
                    
                        
                     
                    }
                });
            }
            
            
        
        
           
           
          
            
            
         
           
        });

        window.onload =  function(){ setTimeout( function(){

           	
            if($("#cmbSearchFor").val()=='RF')
            {
                $.ajax({
                    async : false,
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo base_url(); ?>index.php/dashboard/get_all_requirement_ajax",
                    data: "",
                    success: function(details){
                        
                      
                        
			
                        $.each(details,function(sno,clientid_name) {	 
                            
                            
                            var opt = $('<option />'); 									
                            opt.val(sno);
                            opt.text(clientid_name);
                            $('#cmbRFPSR').append(opt); 
                            
                              var clientidds = $("#cmbRFPSRID").val();
            $('#cmbRFPSR option[value="'+clientidds+'"]').attr('selected', 'selected');
                            
                        });
                        $('.chzn-select').trigger('liszt:updated');
                   
                                       
                    }
                });
            }
                

		
            if($("#cmbSearchFor").val()=='PSR')
            {
                $.ajax({
                    async : false,
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo base_url(); ?>index.php/dashboard/get_all_property_ajax",
                    data: "",
                    success: function(details){
                        
                   
				
			
                        $.each(details,function(sno,clientid_name) {
                            
                        
                            
                            //alert(clientid_name[0]);
                            var opt = $('<option />'); 									
                            opt.val(sno);
                            opt.text(clientid_name);
                            $('#cmbRFPSR').append(opt); 
                              var clientidds = $("#cmbRFPSRID").val();
            $('#cmbRFPSR option[value="'+clientidds+'"]').attr('selected', 'selected');
                            
                        });
                         $('.chzn-select').trigger('liszt:updated');
                        
                        
                           
                    }
                });
            }
            
      
        
             
           
             //   var clientidds = $("#cmbRFPSRID").val();
              //  $('#cmbRFPSR option[value="'+clientidds+'"]').attr('selected', 'selected');





            },1500) };
    </script>
    <?php
}
?>


<style type="text/css">
    tr.odd.gradeA td.sorting_1 { background-color: #CCC;}
    tr.even.gradeA td.sorting_1 { background-color: #FFF;}
</style>


<script type="text/javascript" language="javascript"> 
            $(".chzn-select").chosen(); 
            $(".chzn-select-deselect").chosen({allow_single_deselect:true});  
</script>
