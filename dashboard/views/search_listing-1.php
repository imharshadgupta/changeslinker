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
    <h2>Property Search</h2>
    <form name="searchForm" id="searchForm" method="post" action="<?php echo base_url(); ?>index.php/dashboard/search">

        <input type="hidden" value="1" id="searchcheckcity" name="searchcheckcity">
        <input type="hidden" value="1" id="searchchecklocation" name="searchchecklocation">
        <div class="mfrminner">
            <div class="Txtblks">Filter</div>
            <div class="fldblks">
                <select name="cmbFilter" id="cmbFilter" class="fild chzn-select" style="width:200px;">
                    <option value="">Select Filter</option>
                    <option value="Property" <?php
if (isset($Filter)) {
    echo set_select("cmbFilter", "Property", ($Filter == "Property" ? TRUE : ''));
}
?>>Property</option>
                    <option value="Client" <?php
                            if (isset($Filter)) {
                                echo set_select("cmbFilter", "Client", ($Filter == "Client" ? TRUE : ''));
                            }
?>>Client</option>
                    <option value="Requisition" <?php
                            if (isset($Filter)) {
                                echo set_select("cmbFilter", "Requisition", ($Filter == "Requisition" ? TRUE : ''));
                            }
?>>Requisition</option>
                </select>
            </div>
            <div class="Txtblks">Search</div>
            <div class="fldblks">
                <input type="text" name="txtSearch" id="txtSearch" class="fild" style="width:200px;" value="<?php echo set_value('txtSearch'); ?>" tabindex="1" />
                &nbsp;&nbsp;</div>
            <div class="clear"></div>

            <div class="Txtblks">Property Category</div>
            <div class="fldblks">
                <select name="cmbPropertyCategory" id="cmbPropertyCategory" class="fild chzn-select" tabindex="11">
                    <option value="">Select Property Category</option>
                    <?php
                    $this->db->order_by('cPropertyCategoryName', 'asc');
                    $this->db->where('bActive', 1);
                    $this->db->where('bDelete', 0);
                    $sql = $this->db->get('property_category_master');
                    if ($sql) {
                        if (($sql->num_rows) > 0) {
                            $rows = $sql->result_array();

                            foreach ($rows as $row):

                                $Property_Cat_Id = trim($row['iPropertyCategoryId']);
                                $Property_Cat_Name = trim($row['cPropertyCategoryName']);
                                ?>
                                <option value="<?php echo $Property_Cat_Id; ?>" <?php if ($_POST['cmbPropertyCategory'] == $Property_Cat_Id) echo ' selected="selected"'; ?>><?php echo $Property_Cat_Name; ?></option>
                                <?php
                            endforeach;
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="Txtblks">Property Type</div>
            <div class="fldblks">
                <select name="cmbPropertyType" id="cmbPropertyType" class="fild chzn-select" tabindex="12">
                    <option value="">Select Property Type</option>
                    <?php
                    $this->db->order_by('cPropertyTypeName', 'asc');
                    $this->db->where('bActive', 1);
                    $this->db->where('bDelete', 0);
                    $sql = $this->db->get('property_type_master');
                    if ($sql) {
                        if (($sql->num_rows) > 0) {
                            $rows = $sql->result_array();

                            foreach ($rows as $row):

                                $Property_Type_Id = trim($row['iPropertyTypeId']);
                                $Property_Type_Name = trim($row['cPropertyTypeName']);
                                ?>
                                <option value="<?php echo $Property_Type_Id; ?>" <?php if ($_POST['cmbPropertyType'] == $Property_Type_Id) echo ' selected="selected"'; ?>><?php echo $Property_Type_Name; ?></option>
                                <?php
                            endforeach;
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="clear"></div>

            <div class="Txtblks"> Property Status</div>
            <div class="fldblks">
                <select name="cmbPropertyStatus" id="cmbPropertyStatus" class="fild chzn-select" tabindex="13">
                    <option value="">Select Property Status</option>
                    <?php
                    $this->db->order_by('cPropertyStatusName', 'asc');
                    $this->db->where('bActive', 1);
                    $this->db->where('bDelete', 0);
                    $sql = $this->db->get('property_status_master');
                    if ($sql) {
                        if (($sql->num_rows) > 0) {
                            $rows = $sql->result_array();

                            foreach ($rows as $row):

                                $Property_Status_Id = trim($row['iPropertyStatusId']);
                                $Property_Status_Name = trim($row['cPropertyStatusName']);
                                ?>
                                <option value="<?php echo $Property_Status_Id; ?>" <?php if ($_POST['cmbPropertyStatus'] == $Property_Status_Id) echo ' selected="selected"'; ?>><?php echo $Property_Status_Name; ?></option>
                                <?php
                            endforeach;
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="Txtblks">State</div>
            <div class="fldblks">
                <select name="cmbState" id="cmbState" class="fild chzn-select" tabindex="5" onchange="getCityByDistrictIdAndStateId()">
                    <option value="">Select State</option>
                    <?php
                    $this->db->order_by('cStateName', 'asc');
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
                                <option value="<?php echo $State_Id; ?>" <?php if ($_POST['cmbState'] == $State_Id) echo ' selected="selected"'; ?>><?php echo $State_Name; ?></option>
                                <?php
                            endforeach;
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="clear"></div>




            <div class="Txtblks"> City</div>
            <div class="fldblks">
                <select name="cmbCity" id="cmbCity" class="fild chzn-select" tabindex="7" onchange="getLocationByCityIdAndDistrictIdAndStateId()">



                    <?php //if(isset($_POST['cmbCity']) && $_POST['cmbCity']!="") {   ?>
<!--                    <option value="<?php echo $_POST['cmbCity']; ?>"><?php echo $cmbCity; ?></option>-->
                    <?php // }  ?>
                    <option value="">Select City</option>


                </select>
            </div>

            <div class="Txtblks">Location</div>
            <div class="fldblks">
                <select name="cmbLocation" id="cmbLocation" class="fild chzn-select" tabindex="8">
                    <option value="">Select Location</option>
                </select>
                <br>
                <input type='button' class="btn" value="Submit" onclick="ValidateSearch();" style="margin-top: 20px;" /></div>
            <div class="clear"></div>

            <div class="Txtblks">&nbsp;</div>
            <div class="fldblks">&nbsp;</div>
            <div class="Txtblks">&nbsp;</div>
            <div class="fldblks">&nbsp;</div>
            <div class="clear"></div>

            <div class="table_wrap">

                <?php
                if (isset($query) && isset($Filter) && ($Filter == 'Property')) {
                    ?>
                    <div class="tbls_wrp">
                        <div class="tbls">
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                <thead>
                                    <tr>
                        <!--				<th>SNo.</th>-->
                                        <th>Property</th>
                                        <th>Client</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Location</th>
                                        <th>Category</th>
                                        <th>Type</th>
                                        <th>Status</th>
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
                                            <td style="text-align:left;"><?php echo $PropertyStatusName; ?></td>
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
                if (isset($query) && isset($Filter) && ($Filter == 'Client')) {
                    ?>
                    <div class="tbls_wrp">
                        <div class="tbls">
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                <thead>
                                    <tr>
                        <!--				<th>SNo.</th>-->
                                        <th>Client</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Location</th>
                                        <th><img src="<?php echo base_url(); ?>images/View.png"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $SNo = 1;
                                    foreach ($query->result_array() as $row) {
                                        $ClientId = trim($row['iClientId']);
                                        $ClientName = trim($row['cClientName']);
                                        $StateName = trim($row['cStateName']);
                                        $DistrictName = trim($row['cDistrictName']);
                                        $CityName = trim($row['cCityName']);
                                        $LocationName = trim($row['cLocationName']);
                                        ?>
                                        <tr class="gradeA">
        <!--					<td style="text-align:center;"><?php echo $SNo; ?>.</td>-->
                                            <td style="text-align:left;"><?php echo $ClientName; ?></td>
                                            <td style="text-align:left;"><?php echo $StateName; ?></td>
                                            <td style="text-align:left;"><?php echo $CityName; ?></td>
                                            <td style="text-align:left;"><?php echo $LocationName; ?></td>
                                            <td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/viewclient/<?php echo $ClientId; ?>"><span class="ui-icon ui-icon-search"></span></a></td>
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
                if (isset($query) && isset($Filter) && ($Filter == 'Requisition')) {
                    ?>
                    <div class="tbls_wrp">
                        <div class="tbls">
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                <thead>
                                    <tr>
                        <!--				<th>SNo.</th>-->
                        <!--				<th>Date</th>-->
                                        <th>Client</th>
                                        <th>Contact Person 1</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Location</th>
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

                                        $ClientName = trim($row['cClientName']);
                                        $ContactPerson1 = trim($row['cContactPerson1']);
                                        $StateName = trim($row['cStateName']);
                                        $DistrictName = trim($row['cDistrictName']);
                                        $CityName = trim($row['cCityName']);
                                        $LocationName = trim($row['cLocationName']);
                                        ?>

                                        <tr class="gradeA">
        <!--					<td style="text-align:center;"><?php echo $SNo; ?>.</td>-->
        <!--					<td style="text-align:left;"><?php echo $Date; ?></td>-->
                                            <td style="text-align:left;"><?php echo $ClientName; ?></td>
                                            <td style="text-align:left;"><?php echo $ContactPerson1; ?></td>
                                            <td style="text-align:left;"><?php echo $StateName; ?></td>
                                            <td style="text-align:left;"><?php echo $CityName; ?></td>
                                            <td style="text-align:left;"><?php echo $LocationName; ?></td>
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
</div>

</form>

<script type="text/javascript" language="javascript">
    function ValidateSearch()
    {
        if($("#cmbFilter").val()=='')
        {
            alert("Please select Filter");
            $("#cmbFilter").focus();
            return false;
        }
        //	else if($("#txtSearch").val()=='')
        //    {
        //        alert("Please enter the text");
        //        $("#txtSearch").focus();
        //        return false;
        //    }
        else
        {
            $("#searchForm").submit();
        }
    }
</script>



<script type="text/javascript" language="javascript">
    function getDistrictByStateId()
    {
        $('#cmbDistrict').children('option:not(:first)').remove();
        $('#cmbCity').children('option:not(:first)').remove();

        if($("#cmbState").val()=='')
        {
            alert("Please Select State");
            $("#cmbState").focus();
            return false;
        }
        else
        {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo base_url(); ?>index.php/dashboard/getdistrictbystate",
                data: "cmbState="+$("#cmbState").val(),
                success: function(details){

                    $('#cmbDistrict').children('option:not(:first)').remove();

                    $.each(details,function(districtid,districtname) {

                        var opt = $('<option />');
                        opt.val(districtid);
                        opt.text(districtname);
                        $('#cmbDistrict').append(opt);
                    });
                    $('.chzn-select').trigger('liszt:updated');
                }
            });
        }
    }
</script>


<input type="hidden" value="1" id="searchcheckcity" name="searchcheckcity">
<input type="hidden" value="1" id="searchchecklocation" name="searchchecklocation">

<script type="text/javascript" language="javascript">
    function getCityByDistrictIdAndStateId()
    {
        // alert('aaaaaaaaaa');
        $('#cmbCity').children('option:not(:first)').remove();

        if(!$("#cmbDistrict").val()=='')
        {
            alert("Please Select District");
            $("#cmbDistrict").focus();
            return false;
        }
        else
        {
            // alert('aaaaaaaaaa');

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo base_url(); ?>index.php/dashboard/getcitybystateanddistrict",
                data: "cmbState="+$("#cmbState").val()+'&searchcheckcity='+$("#searchcheckcity").val(),
                success: function(details){

                    $('#cmbCity').children('option:not(:first)').remove();

                    $.each(details,function(cityid,cityname) {

                        var opt = $('<option />');
                        opt.val(cityid);
                        opt.text(cityname);
                        $('#cmbCity').append(opt);
                    });
                    $('.chzn-select').trigger('liszt:updated');
                }
            });
        }
    }
</script>

<script type="text/javascript" language="javascript">
    function getLocationByCityIdAndDistrictIdAndStateId()
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
                url: "<?php echo base_url(); ?>index.php/dashboard/getlocationbystateanddistrictandcity",
                data: "cmbState="+$("#cmbState").val()+"&searchcheckcity="+$("#searchcheckcity").val()+"&cmbCity="+$("#cmbCity").val(),
                success: function(details){

                    $('#cmbLocation').children('option:not(:first)').remove();

                    $.each(details,function(locationid,locationname) {

                        var opt = $('<option />');
                        opt.val(locationid);
                        opt.text(locationname);
                        $('#cmbLocation').append(opt);
                    });
                    $('.chzn-select').trigger('liszt:updated');
                }
            });
        }
    }
</script>

<?php
if ($_POST['cmbCity'] && $_POST['cmbState']) {
    ?>
    <input type="hidden" value="<?php echo $_POST['cmbState']; ?>" id="cmbStateids">
    <input type="hidden" value="<?php echo $_POST['cmbCity']; ?>" id="cmbCityids" name="cmbCityids">  
    <input type="hidden" value="<?php echo $_POST['cmbLocation']; ?>" id="cmbLocationids" name="cmbLocationids">

    <script>

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo base_url(); ?>index.php/dashboard/getcitybystateanddistrict",
            data: "cmbState="+$("#cmbStateids").val()+'&searchcheckcity='+$("#searchcheckcity").val(),
            success: function(details){

                $('#cmbCity').children('option:not(:first)').remove();

                $.each(details,function(cityid,cityname) {

                    var opt = $('<option />'); 
                    opt.val(cityid);
                    opt.text(cityname);
                    $('#cmbCity').append(opt);
                            
                    var cmbCityids = $("#cmbCityids").val();
                    $('#cmbCity option[value="'+cmbCityids+'"]').attr('selected', 'selected');
                            
                });
                $('.chzn-select').trigger('liszt:updated');
            }
        });
                                    
                                    
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo base_url(); ?>index.php/dashboard/getlocationbystateanddistrictandcity",
            data: "cmbState="+$("#cmbStateids").val()+"&searchcheckcity="+$("#searchcheckcity").val()+"&cmbCity="+$("#cmbCityids").val(),
            success: function(details){

                $('#cmbLocation').children('option:not(:first)').remove();

                $.each(details,function(locationid,locationname) {

                    var opt = $('<option />');
                    opt.val(locationid);
                    opt.text(locationname);
                    $('#cmbLocation').append(opt);
                        
                    var cmbLocationids = $("#cmbLocationids").val();
                    $('#cmbLocation option[value="'+cmbLocationids+'"]').attr('selected', 'selected');
                        
                });
                $('.chzn-select').trigger('liszt:updated');
                            
                 
                        
                          
                                
            }
        });
                        
        setTimeout(function(){
                        
          
                        
        },4000);
                                    
                       
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