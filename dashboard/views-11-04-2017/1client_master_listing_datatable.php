<?php
if ($client_id != "") {
    $client_ids = $client_id;
} else {
    $client_ids = '';
}
?>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        var oTable = $('#example').dataTable({
            "bJQueryUI": true,
            "aaSorting":[[0, "desc"]],
            "sPaginationType": "full_numbers",
            "bPaginate": true,
            "bLengthChange": true,
            "aLengthMenu": [[20, 50, 100], [20, 50, 100]],
            "iDisplayLength": 20,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false,
             "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 6,7,8,9 ] }
            ],
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo base_url(); ?>index.php/dashboard/listing_client_master_datatable",
            // "aoColumns": [ {"bSearchable": false},{"bSearchable": false},{"bSearchable": false}, {"bSearchable": false}, {"bSearchable": true},{"bSearchable": true}]
               
               
               
               
        });
    });
</script>


<script type="text/javascript" language="javascript">
    function confirmDelete()
    {
        var del = confirm('Are you sure want to delete this detail?');
  
        if(del)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
</script>

<?php
//$righttoadd = trim($this->session->userdata('RightToAdd_11'));
//$righttoedit = trim($this->session->userdata('RightToEdit_11'));
//$righttodelete = trim($this->session->userdata('RightToDelete_11'));


$righttoadd = $_SESSION['RightToAdd_11'];
$righttoedit = $_SESSION['RightToEdit_11'];
$righttodelete = $_SESSION['RightToDelete_11'];

$varbase_url = base_url();
?>

<div class="table_wrap">
    <h2 align="center">Clients</h2>
<?php if ($righttoadd == '1') { ?>     
        <div style="width:100%; height:25px; border:0px solid #FF0000;">
            <div align="right" style="float:left; width:97%; height:25px; border:0px solid #000000;">
                <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/add_form_client_master"><img src="<?php echo base_url(); ?>images/addnew.jpg" title="Add New" width="20" height="20" /></a>
            </div>
        </div> 
<?php } ?>

    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                <thead>
                    <tr>
                        
                        <th>Client</th>
                        <th>Phone</th>
                        <th>Active</th>                        
                        <th>Status</th>
                        <th>RF</th>
                        <th>PSR</th>
                        <th>Task</th>
                        <th><img src="<?php echo base_url();?>images/View.png"></th>
<?php //if($righttoedit=='1'){  ?> 
                        
                        <?php //} ?>
                        <?php /* if($righttodelete=='1'){ ?>
                          <!--<th>DELETE</th>-->
                          <?php } */ ?>
                        <?php if ($righttoedit == '1') { ?> 
                            <th><img src="<?php echo base_url();?>images/edit.gif"></th>
                            <th><img widht="16" height="16" src="<?php echo base_url();?>images/print_med.gif"></th>
                        <?php } else { ?>
                            <th><img widht="16" height="16" src="<?php echo base_url();?>images/print_med.gif"></th>
                            <?php } ?>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>   
        </div>        
    </div>
</div>        
<script>
    function fn_close_popup(){
        //document.getElementById('dialog2').style.display='none';
        jQuery('#dialog2').bPopup().close();
    }
</script>
<script>
    (function($){
        $(function(){
            $('.iframe').bind('click', function(e){
                e.preventDefault();
                //		alert(1);
                t = this;
                $('#dialog2').bPopup({content:'iframe'
                    , loadUrl: t.href
                    ,follow: [false, false] 
                    ,onOpen(){
                        //			alert('Press ESC Key to Close Window')
                    }
                } );
            });
        });



    })(jQuery);

    //x = jQuery(window).height()-40;
    //y = jQuery(window).width()-40;

    x = 700;
    y = 990;
    document.write('<style>.b-iframe{ width:'+y+'px; height:'+x+'px;}</style>');




    $('#example tbody').on( 'click', '.iframe', function () {
    
                    
        //e.preventDefault();
        //		alert(1);
        t = this;
        $('#dialog2').bPopup({content:'iframe'
            , loadUrl: t.href
            ,follow: [false, false] 
            ,onOpen(){
                //			alert('Press ESC Key to Close Window')
            }
        });
        return false;

    })




</script>
<!-- ui-dialog -->
<div id="dialog" > </div>
<div id="dialog2" style="top:20px; width:990px; overflow:auto" align="center" > </div>



<style>

    iframe{min-width:800px; height: 500px;}

    .iframe{min-width:800px;height: 500px;}

    table#example tr.odd,table#example tr.odd td.sorting_1 { background-color: #ccc;}
    table#example tr.even td.sorting_1 { background-color: #FFF;}

</style>