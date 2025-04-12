<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead(); 
$this->pcss->css();
$this->pweb->ptop1(); 
$this->pcss->hjs();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session,$F_Ctrl,$F_Class);

if(@$_SESSION['MPOSOUTLET']=='')
{ date_default_timezone_set('Asia/Kolkata');  ?>
    <script>
     swal("Outlets Empty..!", "Kindly Add Outlet..!", "warning") 
            .then(() => {
                   window.location="<?php echo scs_index ?>Master/Outlet";
         });
    </script>
    <?php 
}
$sql = "SELECT * FROM Date_change_bar WHERE convert(VARCHAR,Newdate,106)=convert(VARCHAR,getdate(),106) and companyid=" . $_SESSION['MPOSCOMPANYID'];
$result = $this->db->query($sql);
$no = $result->num_rows();

$sql1 = "select * from headings where isnull(Enablepreviousdaykotbilling,0)=1 and id='".$_SESSION['MPOSOUTLET']."'  and companyid=".$_SESSION['MPOSCOMPANYID'];
$result1 = $this->db->query($sql1);
$lastaudit = $result1->num_rows();
if ($lastaudit == '0') {

    if ($no == 0) { ?>
        <script>
            swal("Kindly to Do Day End Process..!", "Accounts Date and System date Mismatch..", "warning")
                .then(() => {
                    window.location.href = '<?php echo scs_index ?>Date_end_process';
                });		
        </script>
    <?php }
}
?>

<style>
	.main_div{
    padding: 30px;
}
input,
select,
textarea {
    background: none;
    color: #c6c6c6;
    font-size: 18px;
    padding: 10px 10px 10px 15px;
    display: block;
    width: 320px;
    border: none;
    border-radius: 10px;
    border: 1px solid #c6c6c6;
}
input:hover{
    border: 1px solid #337ab7;
}
select:hover{
    border: 1px solid #337ab7;
}

input:focus ~ label, input:valid ~ label,select:focus ~ label,select:valid ~ label,
textarea:focus ~ label,
textarea:valid ~ label {
    top: -10px;
    font-size: 12px;
    color: #337ab7;
    left: 11px;
}
input:focus ~ .bar:before,
select:focus ~ .bar:before,
textarea:focus ~ .bar:before {
    width: 320px;
}

input[readonly] ~ label {
    top: -10px;
    font-size: 12px;
    color: #337ab7;
    background-color:#e9ecef;
    left: 11px;
}
input[type="password"] {
    letter-spacing: 0.3em;
}

.group{
    position: relative;
}
label {
    color: #337ab7;
    font-size: 12px;
    font-weight: normal;
    position: absolute;
    pointer-events: none;
    left: 15px;
    top: 6px;
    transition: 300ms ease all;
    background-color: #fff;
    padding: 0 2px;
}
	</style>
        <div class="page-content-wrapper">
            <div class="page-content">
                <form action="" id="cartForm" method="POST">
                    <input type="hidden"  name="outletid" value="<?php echo $_SESSION['MPOSOUTLET']; ?>" />
                    <input type="hidden"  id="lastEdit" value="0" />
                    <input type="hidden"  name="GuestName" id="GuestName" value="" />
                    <input type="hidden"  name="GuestMobile" id="GuestMobile" value="" />
                    <input type="hidden"  name="GuestGst" id="GuestGst" value="" />
                <div class="row">
                    <div class="col-sm-2 p-1">
                        <div class="panel">
                            <div class="col-md-12 p-1">		                                       						 
                                <fieldset id="TableSearch" style="background-color:#FFFFFF; width:100%; " >
                                    <div class="TableSearch">												  
                                        <input type="text" class="form-control"  required />	
                                        <label>Table Search</label>
                                    </div>								
                                </fieldset>
                                <fieldset id="Table" class="fieldsetlg" style="background-color:#FFFFFF;overflow:auto;width:100%;"  >									
                                <?php 
											$MPOSOUTLET=0;
								if(@$_SESSION['MPOSOUTLET'])
								{
									$MPOSOUTLET=$_SESSION['MPOSOUTLET'];
								}
								
                                $REC=$this->Myclass->Outlet_Tables(0,$MPOSOUTLET);
                                foreach($REC as $tbl)
                                {
                                    if($tbl['Status']=='K')
                                    {
                                    ?>
                                    <div onclick="TableSelect('<?php echo $tbl['Status']; ?>','<?php echo $tbl['Tableid']; ?>','<?php echo $tbl['Tablename']; ?>')" class="btn-group" id="Table<?php echo $tbl['Tableid']; ?>" name="Table<?php echo $tbl['Tableid']; ?>" role="group" aria-label="Third group" style="width:32%;margin-top:5px !important"> 
                                        <a  style="width:100%;font-size:11px;border-radius:4px;padding:6px 1px"  class="btn btn-primary"><?php echo $tbl['Tablename']; ?></a> 
                                    </div>	 
                                 <?php }
                                    else if($tbl['Status']=='B')
                                    {   ?>
                                        <div onclick="TableSelect('<?php echo $tbl['Status']; ?>','<?php echo $tbl['Tableid']; ?>','<?php echo $tbl['Tablename']; ?>')" class="btn-group" id="Table<?php echo $tbl['Tableid']; ?>" name="Table<?php echo $tbl['Tableid']; ?>" role="group" aria-label="Third group" style="width:32%;margin-top:5px !important"> 
                                            <a  style="width:100%;font-size:11px;border-radius:4px;padding:6px 1px"  class="btn btn-warning"><?php echo $tbl['Tablename']; ?></a> 
                                        </div>	 
                                     <?php
                                    }
                                    else { ?>
                                       <div onclick="TableSelect('<?php echo $tbl['Status']; ?>','<?php echo $tbl['Tableid']; ?>','<?php echo $tbl['Tablename']; ?>')" class="btn-group" id="Table<?php echo $tbl['Tableid']; ?>" name="Table<?php echo $tbl['Tableid']; ?>" role="group" aria-label="Third group" style="width:32%;margin-top:5px !important"> 
                                        <a  style="width:100%;font-size:11px;border-radius:4px;padding:6px 1px"  class="btn btn-info"><?php echo $tbl['Tablename']; ?></a> 
                                      </div>	
                                    <?php } ?>
                                <?php } ?>                                                        
                                </fieldset>		
                            </div>
                        </div>	
                    </div>	
                    <div class="col-sm-6 p-1">
                        <div class="row pl-3 pr-3">
                            <div style="width:90%;">
                                <div class="ItemSearch">										  
                                    <input type="text" class="form-control"  name="ItemSearch" id="ItemSearch" required />									
                                    <label>Item Search</label>
                                </div>
                            </div>                           
                            <div style="width:10%;color:#0057b7" class="pl-3">                                              
                               <div onclick="openItem()" > <i class="fa fa-cutlery" aria-hidden="true"></i></div>
                            </div>
                        </div>
                        <div class="panel">   
                            <!---------- Item Group ------------->                          
                            <div class="col-md-12  p-1" >
                               									 
                                <fieldset id="groupButtons"  style="background-color:#FFFFFF;overflow-x:hidden; overflow-y: scroll;height:160px; width:100%; " >
                                    <?php 
                                    $REC=$this->Myclass->Itemgroup(0);
                                    foreach($REC as $Ig)
                                    {  ?>
                                    <div onclick="itemgroup(this.id)" class="btn-group" id="<?php echo $Ig['Itemgroupid'] ?>" name="<?php echo $Ig['Itemgroupid'] ?>" role="group" aria-label="Third group" style="width:24.2%;margin-top:5px !important"> 
                                        <a style="font-size: 9px;border-radius:4px;width:100%" class="btn btn-primary"><?php echo $Ig['Itemgroup']; ?></a> 
                                    </div>   
                                    <?php } ?>                                                                   											
                                </fieldset>
                            </div>	
                             <!----------End Item Group ------------->  
                                <!---------- Item  ------------->
                            <div class="col-md-12 p-1">
                                <fieldset  id="Itemname1" style="background-color:#FFFFFF ;overflow-x:hidden; overflow-y: scroll;height:375px; width:100%;">
                                    <?php 
                                    $IREC=$this->Myclass->OutletItems(0,$MPOSOUTLET);
                                    foreach($IREC as $ITM)
                                    {  ?>
                                        <div onclick="ItemInsert(this.id);" class="btn-group" id="<?php echo $ITM['itemdetid']; ?>" name="<?php echo $ITM['itemdetid']; ?>" role="group" aria-label="Third group" style="width:24.2%;margin-top:5px !important"> 
                                        <a id="item" style="border-radius:4px;font-size:11px;width:100%" class="btn btn-info"><?php echo $ITM['Itemname']; ?></a> 
                                        </div> 
                                    <?php } ?>                                
                                </fieldset>
                                <div  id="Itemname" style=" display:none;background-color:#FFFFFF;" > 	 </div>
                               <!----- Settlement ------------>
                                <fieldset  id="Seelement" style="display:none;background-color:#FFFFFF ;overflow-x:hidden; overflow-y: scroll;height:375px; width:100%;">
                                    <div class="row pr-3 pl-4">    
                                        <div class="col-md-3">                                            
                                        <?php 
                                        $i=1;
                                        $IREC=$this->Myclass->Paymode(0);
                                        foreach($IREC as $ITM)
                                        {   $i++; ?>
                                            <div class="row">                                     
                                                <div onclick="Paymode('<?php echo $ITM['Payid']; ?>','<?php echo $ITM['prefix']; ?>');" class="btn-group" role="group" aria-label="Third group" style="width:100%;margin-top:5px !important"> 
                                                <a id="Pybutton<?php echo $ITM['Payid']; ?>" style="border-radius:4px;font-size:11px;width:100%" class="btn btn-info"><?php echo $ITM['Paymode']; ?></a> 
                                                <input type="hidden" id="Py<?php echo $ITM['Payid']; ?>" name="Py<?php echo $ITM['Payid']; ?>" value="0" />
                                                <input type="hidden" id="Bank<?php echo $ITM['Payid']; ?>" name="Bank<?php echo $ITM['Payid']; ?>" value="0" />
                                                <input type="hidden" id="cardNo<?php echo $ITM['Payid']; ?>" name="cardNo<?php echo $ITM['Payid']; ?>" value="0" />
                                                <input type="hidden" id="cardValidate<?php echo $ITM['Payid']; ?>" name="cardValidate<?php echo $ITM['Payid']; ?>"  />
                                                </div> 
                                            </div>
                                        <?php } ?>   
                                        </div>
                                        <div class="col-md-9">                                                                                     
                                            <div class="group mt-3">	
                                                <input type="hidden" name="Billid" id="Billid"	value="0"/>
                                                <input type="text" class="form-control" style="font-size: 15px;text-align:right" name="BillAmt"  id="BillAmt" required />																	
                                                <label>Total Bill Amount</label>
                                            </div>   
                                            <div style="display:none;" id="GivenAmtDiv" class="group mt-3">										  
                                                <input type="text" class="form-control" style="font-size: 15px; text-align:right" name="GivenAmt" id="GivenAmt"  autocomplete="off" pattern="^[0-9]*$" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1'); givenAmount()"  />																	
                                                <label>Given Amount</label>
                                            </div> 
                                            <div style="display:none;"  id="BalaceAmtDiv" class="group mt-3">										  
                                                <input type="text" class="form-control" style="font-size: 15px; text-align:right" name="BalaceAmt" value="0.00" id="BalaceAmt" autocomplete="off" pattern="^[0-9]*$" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  />																	
                                                <label>Balance Amount</label>
                                            </div> 
                                            <div style="display:none;"  id="TipsAmtDiv"  class="group mt-3">										  
                                                <input type="text" class="form-control" value="0" style="font-size: 15px; text-align:right" name="TipsAmt" id="TipsAmt"  autocomplete="off" pattern="^[0-9]*$" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  />																	
                                                <label>Tips Amount</label>
                                            </div> 
                                            <div class="btn-group" onclick="settlementSave()"  role="group" aria-label="Third group" style="width:100%;margin-top:5px !important"> 
                                                <a id="Pybutton" style="border-radius:4px;font-size:11px;width:100%" class="btn btn-primary">Settlement</a>                                                
                                            </div> 
                                        </div> 
                                    </div>                                                            
                                </fieldset>
                            <!----- End Settlement ------------>
                            </div>
                            <!----------End Item  ------------->								
                        </div>
                    </div>
                    <div class="col-sm-4 p-1">	
                        <div class="panel">
                            <div class="col-md-12 p-1">
                                <fieldset>	
                                    <div class="row">
                                        <div class="col-md-4">		
                                            <div class="group">											  
                                              <input type="text" class="form-control" id="Table_Name" required autocomplete="off" name="Table_Name" />																	
                                              <label>Table</label>
                                            </div>	
                                            <input type="hidden" name="Table_Id" id="Table_Id" />
                                        </div>	
                                        <div class="col-md-4">		
                                            <div class="group">										  
                                            <input type="text" class="form-control" name="pax"  autocomplete="off" id="pax" pattern="^[0-9]*$" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  />																	
                                            <label>Pax</label>
                                            </div>         
                                        </div>								  
                                        <div class="col-md-4">	
                                            <div class="group">	
                                                <select class="form-control  select2"  name="steward"  required id="steward">
                                                    <?php 
                                                        $sql="select * from employee where isnull(inactive,0)=0 and Companyid='".$_SESSION['MPOSCOMPANYID']."'"; 
                                                        $result=$this->db->query($sql);											
                                                        foreach ($result->result_array() as $row)
                                                        {
                                                    ?>
                                                    <option value="<?php echo $row['Employeeid'] ?>"><?php echo $row['Employee'] ?></option>    
                                                    <?php } ?>                                                    
                                                </select>                                            
                                            </div>                                            
                                        </div>	
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-12  p-1">
                                <fieldset id="kotlist"  style="height:332px; width:100%;background-color:#FFFFFF" >
                                    <table class="table table-borderless" width="100%" style="margin-bottom:-1px;">
                                        <thead>
                                            <tr>
                                            <th width="50%" class="p-0"  style="font-size:12px;color:#188ae2;text-align: center; border-top:0 !important">ITEM NAME</th>
                                            <th width="22%" class="p-0"  style="font-size:12px;color:#188ae2;text-align: center;border-top:0 !important" >QTY</th>
                                            <th width="10%" class="p-0"  style="font-size:12px;color:#188ae2;text-align: center; border-top:0 !important" >RATE</th>
                                            <th width="21%"  class="p-0"  style="font-size:12px;color:#188ae2;text-align: right; border-top:0 !important" >AMOUNT</th>
                                            </tr>
                                        </thead>                                        
                                    </table>	
                                    <div style="overflow:auto;height:310Px" id="TempKot" name="TempKot">                                        												
                                    </div>
                                </fieldset>									
                            </div>
                            <div class="col-md-12  p-1" >
                                <fieldset style="height:120px;background-color:#FFFFFF; border-top: 2px solid #989898 !important" >							  
                                   
                                    <div style="overflow:auto;height:310Px" id="CartDetails" name="CartDetails">                                        												
                                   
                                </fieldset>
                                <fieldset style="height:75px;background-color:#FFFFFF;" >
                                    <!--div style="background-color:#dbd3d3;" class="form-popup" id="myForm1">
                                        <div id="splitbills"></div>
                                        <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
                                    </div-->
                                    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                        <tr>
                                        <td class="p-1"> <button type="button" onclick="makeKot1()" style="border-radius:4px;" value="makeKot" id="makeKot" class="btn btn-primary  btn-block "><i class="fa fa-cart-plus" aria-hidden="true"></i>Make Kot</button></td>
                                        <td class="p-1"> <button type="button" onclick="makeBill()" style="border-radius:4px;" value="makeBills" id="makeBills" class="btn btn-primary  btn-block"><i class="fa fa-money" aria-hidden="true"></i>Make Bill</button></td>
                                        <td class="p-1"> <button type="button" onclick="makeKotSettlement()" style="border-radius:4px;" value="makeKotSettlementid" id="makeKotSettlementid" class="btn btn-primary  btn-block"><i class="fa fa-money" aria-hidden="true"></i>Save&Settle</button></td>
                                        
                                        <!--td>   if need double button
                                            <button type="button" onclick="nckot()" style="border-radius:4px;" value="NC Kot" id="nckot" class="btn btn-info  btn-block"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            NC Kot</button></td-->							
                                        </tr>
                                        <tr>
                                            <td class="p-1"> <button type="button" onclick="splitBillPopup()" style="border-radius:4px;" value="makeKot" id="makeKot" class="btn btn-primary  btn-block "><i class="fa fa-cart-plus" aria-hidden="true"></i>Split Bill</button></td> 
                                            <td class="p-1"></td>
                                            <td class="p-1"></td>
                                        </tr>
                                        <!--tr>
                                        <td class="p-1"> <button type="button" onclick="splitBillPopup()" style="border-radius:4px;" value="makeKot" id="makeKot" class="btn btn-primary  btn-block "><i class="fa fa-cart-plus" aria-hidden="true"></i>Split Bill</button></td>
                                        <td class="p-1"> <button type="button" onclick="makeBill()" style="border-radius:4px;" value="makeBills" id="makeBills" class="btn btn-primary  btn-block"><i class="fa fa-money" aria-hidden="true"></i>Make Bill</button></td>
                                        <td class="p-1"> <button type="button" onclick="splitBillPopup()" style="border-radius:4px;" value="makeBills" id="makeBills" class="btn btn-primary  btn-block"><i class="fa fa-money" aria-hidden="true"></i></button></td>
                                            <-td>   if need double button
                                            <button type="button" onclick="nckot()" style="border-radius:4px;" value="NC Kot" id="nckot" class="btn btn-info  btn-block"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            NC Kot</button></td>							
                                        </tr>			 -->
                                        </tbody>
                                    </table> 
                                </fieldset>
                            </div>		
                        </div>
                    </div>							
                </div>
                </form>
            </div>
        </div>
        <!-- end page content -->
        <div class="chat-sidebar-container" data-close-on-body-click="false">
                <div class="chat-sidebar">
                    <ul class="nav nav-tabs">
                    	<li class="nav-item">
                            <a href="#quick_sidebar_tab_1" class="nav-link active tab-icon"  data-toggle="tab">Outlets
                            </a>
                        </li>                 
                    </ul>
                    <div class="tab-content">
                    	<div class="tab-pane chat-sidebar-settings in show active animated shake" role="tabpanel" id="quick_sidebar_tab_1">
							<div class="slimscroll-style">
								<div class="theme-light-dark">
									<!--h6>Sidebar Theme</h6-->							
									<a type="button" data-theme="dark" class="btn btn-settings">Restaurant</a>
									<a type="button" data-theme="dark" class="btn btn-settings mt-1">Resto Bar</a>
									<a type="button" data-theme="dark" class="btn btn-settings mt-1">Room Service</a>
								</div>								
							</div>
						</div>                      
                    </div>
                </div>
            </div>
       <!-- end page content -->
       <!-- The Modal -->
			<div id="myModal" class="modal">
			  <!-- Modal content -->
			  <div class="modal-content">
                    <div class="modal-header">		
                        <h4 class="modal-title">Discount</h4>		  
                        <button type="button" class="close" onclick="popupClose()" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <div class="container-fluid">                      
                        <div id="kotdetails"> </div>                       
                    </div>		
                    </div>		   
			  </div>
			</div>
        <!-- EDN --->
            <!-- The bank Modal -->
			<div id="bankModal" class="modal">
			  <!-- Modal content -->
			  <div class="modal-content">
                    <div class="modal-header">		
                        <h4 class="modal-title">Card / Bank Details</h4>		  
                        <!--button type="button" class="close"  data-dismiss="modal">&times;</button-->
                    </div>
                    <div class="modal-body">
                    <div class="container-fluid">    
                        <fieldset>		                   
                        <div id="bankdetails"> </div>    
                        </fieldset>		                    
                    </div>		
                    </div>		   
			  </div>
			</div>
            <!-----GuestModal-------->
            <div id="GuestModal" class="modal">
			  <!-- Modal content -->
			  <div class="modal-content">
                    <div class="modal-header">		
                        <h4 class="modal-title">Guest Name Details</h4>		  
                        <button type="button" class="close" onclick="popupClose()"  data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <div class="container-fluid">    
                        <fieldset>		                   
                        <div id="guestNameDetails"> </div>    
                        </fieldset>		                    
                    </div>		
                    </div>		   
			  </div>
			</div>
            <!----------GuestModal End --------->
            
            <!-----Instructionmodal-------->
            <div id="Instructionmodal" class="modal">
			  <!-- Modal content -->
			  <div class="modal-content">
                    <div class="modal-header">		
                        <h4  class="modal-title"><span id="SplInsItemname"></span></h4>		                        
                        <button type="button" class="close" onclick="popupClose()"  data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <div class="container-fluid">    
                        <fieldset>		                   
                        <div>
                            <form id="SplForm" >                                
                                <div class="col-md-12  mt-3">                     
                                    <div class="group mt-3">
                                        <select style="width: 100%;" id="SplInst" name="SplInst[]" class="form-control select2-multiple Books_Illustrations" multiple>
                                        <?php 
                                            $REC=$this->Myclass->SplInstruction(0);
                                            foreach($REC as $row)
                                            {  ?>
                                            <option value="<?php echo $row['SplInstruction'] ?>"><?php echo $row['SplInstruction'] ?></option>
                                            <?php } ?>                                           
                                        </select>
                                        <label>Select Instruction</label>                                       
                                    </div>                                   
                                    <div class="group mt-3">												  
                                        <input Type="text" value="" class="form-control" required name="KInstruction" id="KInstruction" >
                                        <label>Kitchen Instruction</label>
                                    </div> 
                                    <input type="hidden" value="" name="SplItemid" id="SplItemid" >
                                    <input type="hidden" value="" name="SplTable" id="SplTable" >
                                    <div class="btn-group mt-3  mb-3" onclick="SplSave()" role="group" aria-label="Third group" style="width:100%;margin-top:5px !important"> 
                                        <a id="Pybutton" style="border-radius:4px;font-size:11px;width:100%" class="btn btn-primary">Save</a>                                                
                                    </div>   
                                </div>
                            </form>         
                        </div>    
                        </fieldset>		                    
                    </div>		
                    </div>		   
			  </div>
			</div>
            <!----------Instructionmodal End --------->
             <!-----Instructionmodal-------->
             <div id="ViewInstructionmodal" class="modal">
			  <!-- Modal content -->
			  <div class="modal-content">
                    <div class="modal-header">		
                        <h4  class="modal-title"><span id="SplInsItemname"></span></h4>		                        
                        <button type="button" class="close" onclick="popupClose()"  data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <div class="container-fluid">    
                        <fieldset>		                   
                        <div id="ViewInstructionmodalForm">
                                   
                        </div>    
                        </fieldset>		                    
                    </div>		
                    </div>		   
			  </div>
			</div>
            <!----------Instructionmodal End --------->
            <!-----GuestModal-------->
            <div id="openItemUp" class="modal">
			  <!-- Modal content -->
			  <div class="modal-content">
                    <div class="modal-header">		
                        <h4 class="modal-title">Open Item</h4>		  
                        <button type="button" class="close" onclick="popupClose()"  data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <div class="container-fluid">    
                        <fieldset>		                   
                        <div id="openItemDetails"> </div>    
                        </fieldset>		                    
                    </div>		
                    </div>		   
			  </div>
			</div>
            <!-----GuestModal-------->

            <!-----Split Bill Modal-------->
            <div id="splitbillUI" class="modal">
			  <!-- Modal content -->
			  <div class="modal-content" style="width: 60%;">
                    <div class="modal-header">		
                        <h4 class="modal-title">Split Bill</h4>		  
                        <button type="button" class="close" onclick="popupClose()"  data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <div class="container-fluid">    
                        <fieldset>		                   
                        <div id="splitbillUIDetails"> </div>    
                        </fieldset>		                    
                    </div>		
                    </div>		   
			  </div>
			</div>
            <!-----Split bill modal end-------->
            
        <!-- EDN --->
<?php 
$this->pweb->wfoot1($this->Menu,$this->session);	
$this->pcss->wjs();
?>
<script>
    var PaymodeId=0;
    var paidAmt=0;


    function makeKot1()
    {       
       Tableid = document.getElementById("Table_Id").value;
        steward = document.getElementById("steward").value;
        nooftempitems = document.getElementById("nooftempitems").value;
        Pax = document.getElementById("pax").value;
        if(Tableid==0)
	    {
    		bool=false;
            swal({ icon: 'warning',
            title: 'Kindly Enter The Table',
            text: 'Redirecting...',}
            );
		    return false;
	    }        
        else if(Pax==0)
	    {
    		bool=false;
            swal({ icon: 'warning',
            title: 'Kindly Enter The Pax',
            text: 'Redirecting...',}
            );
		    return false;
	    }        
        else if(steward=='')
	    {
    		bool=false;
            swal({ icon: 'warning',
            title: 'Kindly Select the Steward',
            text: 'Redirecting...',}
            );
		    return false;
	    }
        else if(nooftempitems=='0')
        {
            bool=false;
            swal({ icon: 'warning',
            title: 'Kindly Select Any Items',
            text: 'Redirecting...',});
		    return false;
        }
        else
        {
            $.ajax({
            type: 'post',
            url: '<?php echo scs_index ?>KotSave',
            data: $('form').serialize(),
            success: function () {
                swal({
                        title: 'KOT Added Successfully...!',
                        text: 'Redirecting...',
                        icon: 'success',
                        timer: 2000,
                        buttons: false,
                    }).then(() => {
                        location.reload(true);
                      });
            }
          });

        }
    }
  
    function makeBill()
    {
        Tableid = document.getElementById("Table_Id").value;
        steward = document.getElementById("steward").value;
        Pax = document.getElementById("pax").value;
        noofkotitems = document.getElementById("noofkotitems").value;
        nooftempitems = document.getElementById("nooftempitems").value;
        if(Tableid==0)
	    {
    		bool=false;
            swal({ icon: 'warning',
            title: 'Kindly Enter The Table',
            text: 'Redirecting...',}
            );
		    return false;
	    }        
        else if(Pax==0 || Pax=='')
	    {
    		bool=false;
            swal({ icon: 'warning',
            title: 'Kindly Enter The Pax',
            text: 'Redirecting...',}
            );
		    return false;
	    }        
        else if(steward=='')
	    {
    		bool=false;
            swal({ icon: 'warning',
            title: 'Kindly Select the Steward',
            text: 'Redirecting...',}
            );
		    return false;
	    }
        else if(noofkotitems=='0' && nooftempitems=='0')
	    {
    		bool=false;
            swal({ icon: 'warning',
            title: 'Kindly Select Any Items',
            text: 'Redirecting...',}
            );
		    return false;
	    }        
        else
        {
            $.ajax({
            type: 'post',
            url: '<?php echo scs_index ?>BillSave',            
            data: $('form').serialize()+ "&Settlement=0",
            success: function (respose) {
                swal({
                        title: 'Bill Save Successfully...!',
                        text: 'Redirecting...',
                        icon: 'success',
                        timer: 2000,
                        buttons: false,
                    }).then(() => {
                        window.open('<?php echo scs_index; ?>Receipts/BillPrint/'+respose, '_blank');
                        location.reload(true);
                      });
            }
          });

        }
    }
    function makeKotSettlement()
    {
        Tableid = document.getElementById("Table_Id").value;
        steward = document.getElementById("steward").value;
        Pax = document.getElementById("pax").value;
        noofkotitems = document.getElementById("noofkotitems").value;
        nooftempitems = document.getElementById("nooftempitems").value;
        if(Tableid==0)
	    {
    		bool=false;
            swal({ icon: 'warning',
            title: 'Kindly Enter The Table',
            text: 'Redirecting...',}
            );
		    return false;
	    }        
        else if(Pax==0 || Pax=='')
	    {
    		bool=false;
            swal({ icon: 'warning',
            title: 'Kindly Enter The Pax',
            text: 'Redirecting...',}
            );
		    return false;
	    }        
        else if(steward=='')
	    {
    		bool=false;
            swal({ icon: 'warning',
            title: 'Kindly Select the Steward',
            text: 'Redirecting...',}
            );
		    return false;
	    }
        else if(noofkotitems=='0' && nooftempitems=='0')
	    {
    		bool=false;
            swal({ icon: 'warning',
            title: 'Kindly Select Any Items',
            text: 'Redirecting...',}
            );
		    return false;
	    }   
        else
        {
            $.ajax({
            type: 'post',
            url: '<?php echo scs_index ?>BillSave',
            data: $('form').serialize()+ "&Settlement=1",
            success: function (respose) {
                swal({
                        title: 'Bill Save Successfully...!',
                        text: 'Redirecting...',
                        icon: 'success',
                        timer: 2000,
                        buttons: false,
                    }).then(() => {
                        window.open('<?php echo scs_index; ?>Receipts/BillPrint/'+respose, '_blank');
                        location.reload(true);
                      });
             }
           });
        }
    }
    function TableSelect(a,b,c)
    {   document.getElementById("Table_Id").value=b;
        document.getElementById("Table_Name").value=c;
        if(a=='K')
        {
            document.getElementById("groupButtons").disabled = false;            
            document.getElementById("makeBills").disabled = false;
            document.getElementById("makeKot").disabled = false;  
            document.getElementById("Seelement").style.display = "none";

            $.ajax({url:"<?php echo scs_index ?>Transaction/paxDetails/"+b,
                 type: "POST",
                 dataType: "json",
                 success:function(result){                
                    //$("#CartDetails").html(result);               
                    document.getElementById("pax").value=result.noofpax;
                   // document.getElementById("steward").value=result.Employeeid;
                    $("#steward").val(result.Employeeid).change();
                    document.getElementById('steward').readOnly = true;
                    document.getElementById('pax').readOnly = true;   
                    document.getElementById('Table_Name').readOnly = true;                    

                 }
                });              
                document.getElementById("Itemname1").style.display = "block";
                document.getElementById("Itemname").style.display = "none";     
                $.ajax({url:"<?php echo scs_index ?>Transaction/TempKotlist/"+b, type: "POST",dataType: "html",success:function(result){
                
                $("#TempKot").html(result);

                        $.ajax({url:"<?php echo scs_index ?>Transaction/CartSumDetails/"+b, type: "POST",dataType: "html",success:function(result){                
                        $("#CartDetails").html(result);
                        //alert (result);
                        }
                        });
                }
                }); 
        }
        else if(a=='B')
        { 
            
            document.getElementById("groupButtons").disabled = true;            
            document.getElementById("makeBills").disabled = true;
            document.getElementById("makeKot").disabled = true;
            document.getElementById("makeKotSettlementid").disabled = true;
            $.ajax({url:"<?php echo scs_index ?>Transaction/BillDetailsforSettlement/"+b,
                 type: "POST",
                 dataType: "json",
                 success:function(result){                
                    //$("#CartDetails").html(result);               
                    document.getElementById("pax").value=result.noofpax;
                    //document.getElementById("steward").value=result.Employeeid;
                    $("#steward").val(result.Employeeid).change();
                    document.getElementById('steward').readOnly = true;
                    document.getElementById('pax').readOnly = true;   
                    document.getElementById('Table_Name').readOnly = true;     
                    document.getElementById("BillAmt").value=result.Totalamount;
                    document.getElementById("Billid").value=result.Billid;
                    document.getElementById('BillAmt').readOnly = true;     
                 }
                });
            document.getElementById("Itemname1").style.display = "none";
            document.getElementById("Itemname").style.display = "none";  
            document.getElementById("Seelement").style.display = "block";
            $.ajax({url:"<?php echo scs_index ?>Transaction/BillKotlist/"+b, type: "POST",dataType: "html",success:function(result){
                
                $("#TempKot").html(result);

                        $.ajax({url:"<?php echo scs_index ?>Transaction/BillSumDetails/"+b, type: "POST",dataType: "html",success:function(result){                
                        $("#CartDetails").html(result);
                        //alert (result);
                        }
                        });
                }
                });               
        }
        else
        {
            document.getElementById("groupButtons").disabled = false;            
            document.getElementById("makeBills").disabled = false;
            document.getElementById("makeKot").disabled = false;             
            document.getElementById("Seelement").style.display = "none";          
            document.getElementById('pax').readOnly = false;
            document.getElementById('Table_Name').readOnly = false;                    
            document.getElementById("pax").value="";                  
            document.getElementById("Itemname1").style.display = "block";
            document.getElementById("Itemname").style.display = "none";     
            $.ajax({url:"<?php echo scs_index ?>Transaction/TempKotlist/"+b, type: "POST",dataType: "html",success:function(result){
            
            $("#TempKot").html(result);

                    $.ajax({url:"<?php echo scs_index ?>Transaction/CartSumDetails/"+b, type: "POST",dataType: "html",success:function(result){                
                    $("#CartDetails").html(result);
                    //alert (result);
                    }
                    });
            }
            }); 
        } 
    }
    function itemgroup(a)
    {     
      Tableid = document.getElementById("Table_Id").value;
      if(Tableid==0)
	  {
		bool=false;
        swal({ icon: 'warning',
            title: 'Please Select The Table',
            text: 'Redirecting...',}
            );
		return false;
	  };

      document.getElementById("Itemname1").style.display = "none";
      document.getElementById("Itemname").style.display = "block"; 
      $.ajax({url:"<?php echo scs_index ?>Transaction/ItemGroupByItem/"+a, type: "POST",dataType: "html",success:function(result){
		
		$("#Itemname").html(result);
		//alert (result);
	    }
	  });      
    }
    function ItemInsert(i)
    {     
      Tableid = document.getElementById("Table_Id").value;
      if(Tableid==0)
	  {
		bool=false;
        swal({ icon: 'warning',
            title: 'Please Select The Table',
            text: 'Redirecting...',}
            );
		return false;
	  }
      else
      {
        $.ajax({url:"<?php echo scs_index ?>Transaction/TempKot/"+i+"/"+Tableid+"/Add", type: "POST",dataType: "html",success:function(result){
		
		$("#TempKot").html(result);
             $.ajax({url:"<?php echo scs_index ?>Transaction/CartSumDetails/"+Tableid, type: "POST",dataType: "html",success:function(result){
                
                $("#CartDetails").html(result);
                //alert (result);
                }
                });
	    }
	      }); 
      }      
    }
    function remove(a,b)
    {     
        $.ajax({url:"<?php echo scs_index ?>Transaction/TempKot/"+a+"/"+b+"/Remove", type: "POST",dataType: "html",success:function(result){	
		$("#TempKot").html(result);
             $.ajax({url:"<?php echo scs_index ?>Transaction/CartSumDetails/"+Tableid, type: "POST",dataType: "html",success:function(result){
                $("#CartDetails").html(result);
                //alert (result);
                }
                });
	    }
	      }); 
    }
    function less(a,b)
    {     
        $.ajax({url:"<?php echo scs_index ?>Transaction/TempKot/"+a+"/"+b+"/Less", type: "POST",dataType: "html",success:function(result){
		
		$("#TempKot").html(result);
             $.ajax({url:"<?php echo scs_index ?>Transaction/CartSumDetails/"+Tableid, type: "POST",dataType: "html",success:function(result){                
                $("#CartDetails").html(result);
                //alert (result);
                }
                });
	    }
	      }); 
    }
    function KotCancel(a,b)
    { 
        Tableid = document.getElementById("Table_Id").value;
        swal({
            title: "Cancel Entier Kot?",
            text: "You Need to Cancel Entier KOT or this Item Only",
            icon: "info",
            closeOnEsc: false,
            buttons: ["Cancel Entier Kot","This Item Only"], 
           // dangerMode: true,                       
            }).then((willDelete) => {
            if (willDelete) {
                    swal({
                    title: "Are you Sure?",
                    text: "Sure You need to Cancel this Item",
                    icon: "warning",
                    buttons: ["No","Yes"], 
                    dangerMode: true,                       
                    }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({url:"<?php echo scs_index ?>Transaction/KotItemCancel/"+a+"/"+b+"/"+Tableid, type: "POST",dataType: "html",success:function(result){		
                            $("#TempKot").html(result);

                                 $.ajax({url:"<?php echo scs_index ?>Transaction/CartSumDetails/"+Tableid, type: "POST",dataType: "html",success:function(result){
                                    $("#CartDetails").html(result);
                                    //alert (result);
                                    }
                                    });

                            swal("Item Delete Successfully !", {
                            icon: "success",
                            timer: 2000,
                             buttons: false,
                            });                       
                        }
                        });                       
                    }                     
                    });
            } else {
                swal({
                    title: "Are you Sure?",
                    text: "Sure You need to Cancel this KOT",
                    icon: "warning",
                    buttons: ["No","Yes"], 
                    dangerMode: true,                       
                    }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({url:"<?php echo scs_index ?>Transaction/KotCancel/"+a+"/"+b+"/"+Tableid, type: "POST",dataType: "html",success:function(result){		
                            $("#TempKot").html(result);
                               
                            $.ajax({url:"<?php echo scs_index ?>Transaction/CartSumDetails/"+Tableid, type: "POST",dataType: "html",success:function(result){
                                $("#CartDetails").html(result);
                                //alert (result);
                                }
                                });

                            swal("KOT Cancel Successfully !", {
                            icon: "success",
                            timer: 2000,
                             buttons: false,
                            });                       
                        }
                        });                       
                    }
                    });
            }
            });

 
        
    }
    function KotEdit(a,b)
    {        
        
        document.getElementById("Add"+a).style.display = "block";        
        document.getElementById("QtyIn"+a).style.display = "block";        
        document.getElementById("Qty"+a).style.display = "none";     
        $('#QtyIn'+a).focus();        
        $('#QtyIn'+a).select();       
        let lastEdit = document.getElementById("lastEdit").value;
        if(lastEdit !='0')
        {            
            document.getElementById("Add"+lastEdit).style.display = "none";        
            document.getElementById("QtyIn"+lastEdit).style.display = "none";        
            document.getElementById("Qty"+lastEdit).style.display = "block";    
        }
        document.getElementById("lastEdit").value=a;        
    }
    function RunningKOTEdit(a,b)
    {      
        document.getElementById("Add"+a).style.display = "none";        
        document.getElementById("QtyIn"+a).style.display = "none";        
        document.getElementById("Qty"+a).style.display = "block";
        Tableid = document.getElementById("Table_Id").value;  
        let QtyIn = document.getElementById("QtyIn"+a).value;
        if(QtyIn =='0')
        {
            swal("Qty will allow more then 0", {
                            icon: "error",
                            });  
            return;
        }
        $.ajax({url:"<?php echo scs_index ?>Transaction/TempKotQty/"+a+"/"+QtyIn+"/"+Tableid+"/"+b, type: "POST",dataType: "html",success:function(result){
		
		$("#TempKot").html(result);

              $.ajax({url:"<?php echo scs_index ?>Transaction/CartSumDetails/"+Tableid, type: "POST",dataType: "html",success:function(result){
                $("#CartDetails").html(result);
                //alert (result);
                }
                });

            swal("Qty Updated Successfully !", {
                       icon: "success",
                         });  
	    }
	      }); 
    }
   function DiscountPopUp(a)
   {    
        $.ajax({
            type: 'POST',
            url: '<?php echo scs_index ?>Transaction/GetDiscountDetails',  //GET ITEM Price any url
            data: {label: <?php echo $_SESSION['MPOSOUTLET']; ?> ,tableid : a},
            success: function(message) { 
            // alert(message);
                $('#kotdetails').html(message);		  
            },
            // dataType: 'json'
        }); 
         
        var modal = document.getElementById("myModal");      
        modal.style.display = "block";
   }
   function popupClose()
   {
      var modal = document.getElementById("myModal");   
      var Guestmodal = document.getElementById("GuestModal");   
      var openItemUp = document.getElementById("openItemUp");     
      var splitbillUI = document.getElementById("splitbillUI"); 
      var Instructionmodal = document.getElementById("Instructionmodal");      
      var ViewInstructionmodal = document.getElementById("ViewInstructionmodal");      
    
        Guestmodal.style.display = "none";  
        openItemUp.style.display = "none";   
        modal.style.display = "none";     
        splitbillUI.style.display= "none";  
        Instructionmodal.style.display = "none";      
        ViewInstructionmodal.style.display = "none";   
   }
   function guestNamePopUp(a)
   {
    $.ajax({
            type: 'POST',
            url: '<?php echo scs_index ?>Transaction/guestNameDetails',  //GET ITEM Price any url
            data: {label: <?php echo $_SESSION['MPOSOUTLET']; ?> ,tableid : a},
            success: function(message) { 
            // alert(message);
                $('#guestNameDetails').html(message);		  
            },
            // dataType: 'json'
        }); 
    var Guestmodal = document.getElementById("GuestModal");      
    Guestmodal.style.display = "block";    
   }
   function Instruction(a,b,c)
   {  
     var Instructionmodal = document.getElementById("Instructionmodal");      
     Instructionmodal.style.display = "block";        
     document.getElementById("SplItemid").value=a;
     document.getElementById("SplTable").value=b;     
     document.getElementById("SplInsItemname").innerHTML=c;
   }
   function InstructionView(a,b,c)
   {   
    var ViewInstructionmodal = document.getElementById("ViewInstructionmodal");      
    ViewInstructionmodal.style.display = "block";    
     $.ajax({
            type: 'POST',
            url: '<?php echo scs_index ?>Transaction/InstructionViews',  //GET ITEM Price any url
            data: {tableid:b,SplItemid:a },
            success: function(message) { 
            // alert(message);
                $('#ViewInstructionmodalForm').html(message);		  
            },
            // dataType: 'json'
        }); 
   }

   function apply() {	
     $("#Discountform").on('submit', function (e) {
      e.preventDefault();
      $.ajax({
         type: 'POST',
         url: "<?php echo scs_index ?>Transaction/discountapply",
         data: $('#Discountform').serialize(),
         success: function (result) {
             // alert("Working");	
             Tableid = document.getElementById("Table_Id").value;
             $.ajax({url:"<?php echo scs_index ?>Transaction/CartSumDetails/"+Tableid, type: "POST",dataType: "html",success:function(result){
                $("#CartDetails").html(result);
                //alert (result);
                }
                });		 		
            }
          });
          var modal = document.getElementById("myModal");
		  modal.style.display = "none";
        });		
      }
      function openItemSave()
      {
        $("#openItemForm").on('submit', function (e) {
            e.preventDefault();         

            $.ajax({
                type: 'POST',
                url: "<?php echo scs_index ?>Transaction/openItemFormSave",
                data: $('#openItemForm').serialize(),
                success: function (result) {                 
                    var openItemUp = document.getElementById("openItemUp");
                    openItemUp.style.display = "none";		
                    $.ajax({url:"<?php echo scs_index ?>Transaction/TempKotlist/"+Tableid, type: "POST",dataType: "html",success:function(result){
                        $("#TempKot").html(result);
                        $.ajax({url:"<?php echo scs_index ?>Transaction/CartSumDetails/"+Tableid, type: "POST",dataType: "html",success:function(result){
                            $("#CartDetails").html(result);
                            //alert (result);
                            }
                            });
                             }
                        }); 	 		
                    }
                });             
                });	
                
   
                return;  
      }
      function guestDetailsSave()
      {
        popupGuestName =document.getElementById("popupGuestName").value;
        popupGuestMobile =document.getElementById("popupGuestMobile").value;
        popupGuestGST=document.getElementById("popupGuestGST").value;
        document.getElementById("GuestName").value=popupGuestName;
        document.getElementById("GuestMobile").value=popupGuestMobile;
        document.getElementById("GuestGst").value=popupGuestGST;
        var modal = document.getElementById("GuestModal");
        modal.style.display = "none";   	
      }
      function SplSave()
      {
        var SplInst;
        SplInst=$(".Books_Illustrations").val();     
        $.ajax({
            type: 'POST',
            url: '<?php echo scs_index ?>Transaction/SplInstructionUpdate',
            data:{ SplTable: document.getElementById("SplTable").value, SplItemid: document.getElementById("SplItemid").value, KInstruction : document.getElementById("KInstruction").value, SplInst :SplInst} ,
            success: function (message) {
                $.ajax({url:"<?php echo scs_index ?>Transaction/TempKotlist/"+document.getElementById("SplTable").value, type: "POST",dataType: "html",success:function(result){
                        $("#TempKot").html(result);             
                             }
                        }); 
                    }
          });
          var Instructionmodal = document.getElementById("Instructionmodal");      
          Instructionmodal.style.display = "none";      
      }
      function Paymode(a,b)
      {  
        PaymodeId = a;    
        const element = document.getElementById("Pybutton"+a);
        if (element.className == "btn btn-info") {
            element.className = "btn btn-primary";
        } else if(document.getElementById("Py"+a).value =='0') {
            element.className = "btn btn-info";
        }
        else
        {
            element.className = "btn btn-primary";
        }
        if(b=='RCD')
        {
            $.ajax({
            type: 'POST',
            url: '<?php echo scs_index ?>Transaction/BankDetails',  //GET ITEM Price any url
            data: {label: <?php echo $_SESSION['MPOSOUTLET']; ?> ,PaymodeId : a},
            success: function(message) { 
            // alert(message);
                $('#bankdetails').html(message);		  
            },
            // dataType: 'json'
            });
            var modal = document.getElementById("bankModal");      
             modal.style.display = "block";
        }

        document.getElementById("GivenAmtDiv").style.display = "block"; 
        document.getElementById("GivenAmt").value =document.getElementById("Py"+a).value;  
        document.getElementById("BalaceAmtDiv").style.display = "block";
        document.getElementById("TipsAmtDiv").style.display = "block";      
          
       var BalaceAmt = +document.getElementById("BalaceAmt").value;  
       if(BalaceAmt=='0.00' || BalaceAmt=='0' ||BalaceAmt=='')
       {
        document.getElementById("BalaceAmt").value= document.getElementById("BillAmt").value;
       }
      }
      function givenAmount()
      {
        paidAmt=0;
        document.getElementById("Py"+PaymodeId).value=document.getElementById("GivenAmt").value;
        const element = document.getElementById("Pybutton"+PaymodeId);
        for (let i = 1; i < 10; i++) {
             let Py = document.getElementById("Py"+i);
             let Pyamt = (0 * 1); 
             if(Py)
             {
                Pyamt = document.getElementById("Py"+i).value;              
             }
             else
             {
                Pyamt = (0 * 1);
             }
             paidAmt = (paidAmt * 1)+(Pyamt * 1);    
        }  
        let BillAmt= +document.getElementById("BillAmt").value;
      
        let balcTotal=(BillAmt)-(paidAmt);
        if(balcTotal < 0)
        {
            swal("Should not allow more than bill value", {
                            icon: "error",
                            });  
            document.getElementById("Py"+PaymodeId).value=0;
            document.getElementById("GivenAmt").value=0;
            return;
        }
        document.getElementById("BalaceAmt").value=balcTotal;
        if(paidAmt ==0 || paidAmt=='')
        {
            element.className = "btn btn-info"; 
        }
        else
        {
            element.className = "btn btn-primary";
        }
      }
      function cardBankdetails(a)
      {
        var cardNo= document.getElementById("popupcardNo"+a).value;
        var bankId= document.getElementById("popupbank"+a).value;
        var popupValidate= document.getElementById("popupValidate"+a).value;
        if(cardNo == '')
        {
            swal("Enter Card Number", {
                            icon: "warning",
                            });  
            return;
        }
        if(popupValidate == '')
        {
            swal("Enter Card Validate", {
                            icon: "warning",
                            });  
            return;
        }        
        document.getElementById("Bank"+a).value=bankId;        
        document.getElementById("cardNo"+a).value=cardNo;
        document.getElementById("cardValidate"+a).value=popupValidate;        
        var modal2 = document.getElementById("bankModal");        
        modal2.style.display = "none";
      }
      function settlementSave()
      {
        if(document.getElementById('BalaceAmt').value =='0')
        {
            $.ajax({
            type: 'POST',
            url: "<?php echo scs_index ?>Transaction/SettlementSave",
            data: $('#cartForm').serialize(),        
            success: function(response) {
                swal({
                        title: 'Settlement Save Successfully...!',
                        text: 'Redirecting...',
                        icon: 'success',
                        timer: 2000,
                        buttons: false,
                    }).then(() => {
                        window.open('<?php echo scs_index; ?>Receipts/SettlementPrint/'+response, '_blank');
                        location.reload(true);
                      }); },
            });
        }
        else
        {
            swal("Incorrect Amount", {
                            icon: "error",
                            }); 
            return;
        }
      }
      function openItem()
      {
        Tableid = document.getElementById("Table_Id").value;    
        if(Tableid==0)
	    {
    		bool=false;
            swal({ icon: 'warning',
            title: 'Kindly Enter The Table',
            text: 'Redirecting...',}
            );
		    return false;
	    }  
        $.ajax({
            type: 'POST',
            url: '<?php echo scs_index ?>Transaction/OpenItemUI',  //GET ITEM Price any url
            data: {label: <?php echo $_SESSION['MPOSOUTLET']; ?>,Table:Tableid },
            success: function(message) { 
            // alert(message);
                $('#openItemDetails').html(message);		  
            },
            // dataType: 'json'
        }); 
        var openItemUp = document.getElementById("openItemUp");      
        openItemUp.style.display = "block";
        return    
      }
      function splitBillPopup()
      {
        Tableid = document.getElementById("Table_Id").value;    
        if(Tableid==0)
	    {
    		bool=false;
            swal({ icon: 'warning',
            title: 'Kindly Enter The Table',
            text: 'Redirecting...',}
            );
		    return false;
	    }  
        $.ajax({
            type: 'POST',
            url: '<?php echo scs_index ?>Transaction/SplitbillUI',  //GET ITEM Price any url
            data: {label: <?php echo $_SESSION['MPOSOUTLET']; ?>,Table:Tableid },
            success: function(message) { 
            // alert(message);
                $('#splitbillUIDetails').html(message);	
                $.ajax({url:"<?php echo scs_index ?>Transaction/splitbilllist?Tableid="+Tableid, type: "POST",dataType: "html",success:function(result){
		     		$("#splitsecontload").html(result);
					//alert (result);
					}
				    });	  
            },
            // dataType: 'json'
        }); 
        var splitbillUI = document.getElementById("splitbillUI");      
        splitbillUI.style.display = "block";
      //  splitbillUIDetails
      }
      let count = 0;
      function splitIntoTemp(){
        count = count+1;
        $.ajax({
            type: 'POST',
            url: '<?php echo scs_index ?>Transaction/splitbilllistTemp?count='+count,  //GET ITEM Price any url
            data: $('#split').serialize(),
            success: function(html) { 
		     		$("#splitedbilllist").html(html); 
                     $.ajax({url:"<?php echo scs_index ?>Transaction/splitbilllist?Tableid="+Tableid, type: "POST",dataType: "html",success:function(result){
		     		$("#splitsecontload").html(result);
					//alert (result);
					}
				    });	  
            },
        }); 
      }
  
</script>

