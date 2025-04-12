<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead(); 
$this->pcss->css();
$this->pweb->ptop(); 
$this->pcss->hjs();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session,$F_Ctrl,$F_Class);
?>

<!-- start page content -->
<div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class=" pull-left">
                                <div class="page-title">Table Move</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="">Operations</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">Table Move</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-topline-aqua">
							<form method="POST">								
                                <div class="row">		
                                <div class="col-md-4"> 					
                                    <fieldset  style="background-color:#FFFFFF ;overflow-x:hidden; overflow-y: scroll;height:375px; width:100%;">
                                       
                                                                         
                                <?php 
                                $REC=$this->Myclass->Outlet_Tables(0,$_SESSION['MPOSOUTLET']);
                                foreach($REC as $tbl)
                                {
                                    if($tbl['Status']=='K')
                                    {
                                    ?>
                                    <div onclick="TableSelect('<?php echo $tbl['Tableid']; ?>','<?php echo $tbl['Tablename']; ?>')" class="btn-group" id="Table<?php echo $tbl['Tableid']; ?>" name="Table<?php echo $tbl['Tableid']; ?>" role="group" aria-label="Third group" style="width:32%;margin-top:5px !important"> 
                                        <a  style="width:100%;font-size:11px;border-radius:4px;padding:6px 1px"  class="btn btn-primary"><?php echo $tbl['Tablename']; ?></a> 
                                    </div>	 
                                 <?php }
                               
                                     ?>
                                <?php } ?>                                                        
                               
                                     
                                    </fieldset>   
                                </div>
                                <div class="col-md-4"> 
                                    <fieldset  id="Seelement" style="display:none;background-color:#FFFFFF ;height:375px; width:100%;">
                                       <table class="mt-2" style="width:100%;font-size:11px;">
                                            <thead style="background: #97144d; color: #fff">
                                                <tr>
                                                <th  style="width:5%;text-align: center;">Table Move Selection <span id="selectedTable"></span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><button type="button" onclick="TableWise()" style="border-radius:4px;" value="makeKot" id="makeKot" class="btn btn-primary  btn-block mt-2">Table Wise Move</button></td>
                                                </tr>
                                                <tr>
                                                    <td><button type="button" onclick="ItemWise()" style="border-radius:4px;" value="makeKot" id="makeKot" class="btn btn-primary  btn-block mt-2">Item Wise Move</button></td>
                                                </tr>
                                            </tbody>
                                        </table>                                        
                                    </fieldset>   
                                </div>	
                                <div class="col-md-4"> 					
                                    <fieldset  id="Totablelist" style="display:none;background-color:#FFFFFF ;overflow-x:hidden; overflow-y: scroll;height:375px; width:100%;">                                                                                                                
                                <?php 
                                $REC=$this->Myclass->Outlet_Tables(0,$_SESSION['MPOSOUTLET']);
                                foreach($REC as $tbl)
                                {
                                    if($tbl['Status']=='S')
                                    {
                                    ?>
                                    <div onclick="ToTableSelect('<?php echo $tbl['Tableid']; ?>','<?php echo $tbl['Tablename']; ?>')" class="btn-group" id="Table<?php echo $tbl['Tableid']; ?>" name="Table<?php echo $tbl['Tableid']; ?>" role="group" aria-label="Third group" style="width:32%;margin-top:5px !important"> 
                                        <a  style="width:100%;font-size:11px;border-radius:4px;padding:6px 1px"  class="btn btn-primary"><?php echo $tbl['Tablename']; ?></a> 
                                    </div>	 
                                 <?php }
                               
                                     ?>
                                <?php } ?>                                                        
                               
                                     
                                    </fieldset>   
                                </div>					
							  </div>
                              </form>
                            </div>
						
                        </div>
                    </div>               
                    
                    
                    
                </div>
            </div>

            <div id="myModal2" class="modal">
			  <!-- Modal content -->
			  <div class="modal-content" style="overflow-y:scroll;width:80%;height:80%;text-align:Right">
				<span id="close2" class="close">&times;</span>
				<div id="itemwisemove"></div>
			  </div>
	    	</div>

<?php 
$this->pweb->wfoot($this->Menu,$this->session);	
$this->pcss->wjs();
?>
<script>
    var fromtable='';
    var fromtableid='';
    var totable='';
    var isitemwise=0;
    function TableSelect(a,b)
    {  $("#selectedTable").html(b);
        fromtable=b;
        fromtableid=a;
        document.getElementById("Seelement").style.display = "block";        
    }
    function TableWise()
    {
        document.getElementById("Totablelist").style.display = "block";     
        isitemwise=0;
    }
    function ItemWise()
    {
        document.getElementById("Totablelist").style.display = "block";     
        isitemwise=1;
    }
    function ToTableSelect(a,b)
    {
        if(isitemwise =='0')
        {
        var totable=b;
        swal({
            title: "Are you sure want to transfer?",
                    text: "From "+fromtable+" To "+totable,
                    icon: "warning",
                    buttons: ["No","Yes"], 
                    dangerMode: true,            
            }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
						  type: 'POST',
						  url: '<?php echo scs_index ?>Operations/Table_Move_Save',  //GET ITEM Price any url
						  data: {FromTable: fromtableid,Totable : a},
						  success: function(message) { 
						    swal("Success !","Redirecting.....","success")
						  .then(() => {
							window.location.href = '<?php echo scs_index ?>Operations/Table_Move'; 
							});	
						  }
					   }); 
                    }                   
                });
        }
        else
        {
            //alert("ff");
            $.ajax({
                    type: 'POST',
                    url: '<?php echo scs_index ?>Operations/ItemwiseTableMove',  //GET ITEM Price any url
                    data: {FromTable: fromtableid,Totable : a},
                    success: function(message) { 
                    }
					}); 
            var modal2 = document.getElementById("myModal2");
            modal2.style.display = "block";
        }

    }
    var span2 = document.getElementById("close2");
    span2.onclick = function() {
	 var modal2 = document.getElementById("myModal2");
	 modal2.style.display = "none";
		  };
</script>