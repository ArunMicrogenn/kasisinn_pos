<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead(); 
$this->pcss->css();
$this->pweb->ptop(); 
$this->pcss->hjs();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session,$F_Ctrl,$F_Class);
?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <div class="page-title-breadcrumb">
                    <div class=" pull-left">
                        <div class="page-title">Data Purging</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right">
                        <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                        </li>
                        <li><a class="parent-item" href="">Settings</a>&nbsp;<i class="fa fa-angle-right"></i>
                        </li>
                        <li class="active">Data Purging</li>
                    </ol>
                </div>
            </div>
    
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-topline-purple">										 
                                <div class="row">								
                                    <div class="col-md-3 col-sm-3">									
                                        <div class="card-body " id="bar-parent10">                                      
                                            <div class="form-group row">													                                       
                                            <?php 
                                            $sql="select * from company where  isnull(inactive,0)=0";                                          
                                            $result=$this->db->query($sql);								
                                            ?>
                                                <select  class="form-control  select2" name="Company" id="Company">
                                                <option value="0" disabled selected>Select Company</option>
                                    <?php			foreach ($result->result_array() as $row) { ?>                                                   
                                                    <option value="<?php echo $row['companyid'] ?>"><?php echo $row['Hotelcode'].'-'.$row['company']; ?></option>
                                    <?php } ?>	
                                                </select>													
                                            </div> 
                                        </div>								  
                                </div> 								
                                
                                <div class="col-md-3 col-sm-3">	
                                        <label class = "mdl-switch mdl-js-switch mdl-js-ripple-effect" 
                                            for = "switch-9">
                                            <input type = "checkbox" id = "switch-9" onclick="checkboxs()"   class = "mdl-switch__input">           
                                        </label> With All Mosters
                                    </div> 
                                <div class="col-md-3 col-sm-3">	
                                    <div class="card-body " id="bar-parent10">   
                                    <div class="form-group row">										
                                    <button type="submit" onclick="datapurging()"  class="btn btn-primary">Data Purging</button>		
                                    </div> 	</div> 									
                                </div> 							  
                                </div>                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <?php 
$this->pweb->wfoot($this->Menu,$this->session);	
$this->pcss->wjs();
?>
<script>
	var selected=0;
	function checkboxs() {
		  var checkBox = document.getElementById("switch-9");		 
		  if (checkBox.checked == true){
			selected ='1';
		  } else {
			selected ='0';
		  }
		}
	function datapurging()
	{
		// alert(selected);
		 var Company= document.getElementById("Company").value;
		 if(Company==0)
		 { swal("Please select Company..!", "Try again!", "warning");  }
		 else
		 {
		
        swal({
            title: "Are you Sure?",
                    text: "You will not be able to recover this Datas",
                    icon: "warning",
                    buttons: ["No","Yes"], 
                    dangerMode: true,            
            }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
						  type: 'POST',
						  url:'<?php echo scs_index ?>Settings/Datapurging_Save',  //GET ITEM Price any url
						  data: {Company: Company,selected : selected},
						  success: function(message) { 
						    swal("cleared!", "Hotel Code "+Company+" Datas has been cleared.", "success");
						  //.then(() => {
						//	window.location.href = 'Bill_Cancellation'; 
						//	});	
						  }
					   }); 
                    }                   
                });
 
		 }
	}
	</script>