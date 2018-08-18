<?php
// die;
if($client_id!="")
{
    $client_ids = $client_id;
}else{
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
              "bProcessing": true,
               "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 6,7,8,9 ] }
            ],
              "bServerSide": true,
               "sAjaxSource": "<?php echo base_url();?>index.php/dashboard/listing_property_master_datatable/<?php echo $client_ids; ?>",
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

<div class="table_wrap">
    <h2 align="center">Property</h2>
         
    <div style="width:100%; height:25px; border:0px solid #FF0000;">
        <div align="right" style="float:left; width:97%; height:25px; border:0px solid #000000;">
            <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/add_form_property_master"><img src="<?php echo base_url(); ?>images/addnew.jpg" title="Add New" width="20" height="20" /></a>
        </div>
    </div> 
    
    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
				<th>SNo.</th>
				<th>Property</th>
				<th>Status</th>
				<th>T&C</th>
                                <th>Inspection</th>
                                <th>Delivery</th>
				<th>Active</th>
                                <th>Staff<br>Name</th>
				<th><img src="<?php echo base_url();?>images/View.png"></th>
                                <th><img src="<?php echo base_url();?>images/edit.gif"></th>                                
				<th><img src="<?php echo base_url();?>images/pdf.png"></th>
				<th><img widht="16" height="16" src="<?php echo base_url();?>images/print_med.gif"></th>
                                
            </thead>
           <tbody>
            </tbody>
            </table>   
		</div>        
        <div style="height:2px;"></div>
    </div>
</div>        

<!-- ui-dialog -->
<div id="dialog"> </div>

<!--
<Script>
    $(function(){
    $('#popssss').click(function(){
        $('#popssss1').bPopup();
    });
});
</script>

<a href="javascript:void(0)" id="popssss">tetetete</a>

<div id="popssss1" style="display: none;">
    <span class="button b-close"><span>X</span></span>
    If you can't get it up use<br />
    <span class="logo">bPopup</span>
</div>

<style>>
#popssss1, .bMulti {
    background-color: #FFF;
    border-radius: 10px 10px 10px 10px;
    box-shadow: 0 0 25px 5px #999;
    color: #111;
    display: none;
    min-width: 450px;
    min-height: 250px;
    padding: 25px;
}

#popssss1 .logo {
    color: #2B91AF;
    font: bold 325% 'Petrona',sans;
}

.button.b-close, .button.bClose {
    border-radius: 7px 7px 7px 7px;
    box-shadow: none;
    font: bold 131% sans-serif;
    padding: 0 6px 2px;
    position: absolute;
    right: -7px;
    top: -7px;
}

.button {
    background-color: #FFF;
    border-radius: 10px;
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.3);
    color: #FFF;
    cursor: pointer;
    display: inline-block;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
}

</style>-->






<div id="dialog3" style="top: 243.5px;    overflow: auto;    min-width: 800px!important;    left: 533px;
    position: absolute;
    z-index: 9999;
    opacity: 1;
    display: block;
    height: auto;background: #FFF;" align="center" > </div>


<style>
    
    iframe{min-width:800px; height: 500px;}
    
   .iframe{min-width:800px;height: 500px;}
   
   table#example tr.odd,table#example tr.odd td.sorting_1 { background-color: #ccc;}
   table#example tr.even td.sorting_1 { background-color: #FFF;}
    
</style>


<script>
    
    function bclose() {
        parent.$("#dialog3").bPopup().close();
        return false;
    }
    
function fn_close_popup(){
	//document.getElementById('dialog2').style.display='none';
	jQuery('#dialog3').bPopup().close();
}
</script>
<script>
//
//    $(function(){
//                $('.iframe111').bind('click', function(e){
//
//                    alert('aaaaaaaaaaa'); return false;
//
//                e.preventDefault();
//    //		alert(1);
//                t = this;
//                $('#dialog3').bPopup({content:'iframe'
//                , loadUrl: t.href
//                ,follow: [false, false] 
//                ,onOpen(){
//    //			alert('Press ESC Key to Close Window')
//                }
//                } );
//                });
//        });
        
        
        $('.iframe').bind('click', function(e){
                  
                    
                    
                e.preventDefault();
//		alert(1);
		t = this;
		$('#dialog3').bPopup({content:'iframe'
		, loadUrl: t.href
		,follow: [false, false] 
		,onOpen(){
//			alert('Press ESC Key to Close Window')
		}
		} );
		});

//
//$(".iframesss").click(function(){
//    
//    
//    
//              alert('aaaa')      ;return false
//                    
//                //e.preventDefault();
////		alert(1);
//		t = this;
//		$('#dialog3').bPopup({content:'iframe'
//		, loadUrl: t.href
//		,follow: [false, false] 
//		,onOpen(){
////			alert('Press ESC Key to Close Window')
//		}
//		} );
//})

//
//$(function(){
//    $('.iframesss').on('click', function(e){
//       alert('aaaa');
//        return false;
//    });
//});
//
//$(document).ready(function() {
//    $('#example').dataTable();
//} );






$('#example tbody').on( 'click', '.iframesss', function () {
    
                    
                //e.preventDefault();
//		alert(1);
		t = this;
		$('#dialog3').bPopup({content:'iframe'
		, loadUrl: t.href
		,follow: [false, false] 
		,onOpen(){
//			alert('Press ESC Key to Close Window')
		}
		});
                return false;

})

</script>