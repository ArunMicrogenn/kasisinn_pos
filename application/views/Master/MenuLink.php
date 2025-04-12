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
                        <div class="page-title">Item Menu Link</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right">
                        <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                        </li>
                        <li><a class="parent-item" href="">Master</a>&nbsp;<i class="fa fa-angle-right"></i>
                        </li>
                        <li class="active">Item Menu Link</li>
                    </ol>
                </div>
            </div>
    
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-topline-purple">
                                <div class="card-head">
                                    <header>Item Menu Link</header>
                                    <div class="tools">
                                        <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                                    </div>
                                </div>
                                
                        <div class="row">								
                            <div class="col-md-3 col-sm-3">									
                                <div class="card-body " id="bar-parent10">                                      
                                    <div class="form-group row">
                                    <label>Item Category </label>                                            
                                    <?php 
                                    $sql="select * from Itemcategory where companyid='".$_SESSION['MPOSCOMPANYID']."' and isnull(inactive,0)=0";                                   
                                    $result=$this->db->query($sql);                                           								
                                    ?>
                                        <select onchange="itemcategory(this.value)" class="form-control  select2" name="itemcategory" id="itemcategory">
                                        <option value="0" disabled selected>Select Item Category</option>
                                      <?php	foreach ($result->result_array() as $row)	
											{ ?>                                                   
                                            <option value="<?php echo $row['itemcategoryid'] ?>"><?php echo $row['itemcategory']; ?></option>
                                        <?php } ?>	
                                        </select>
                                    
                                    </div> 
                                </div>								  
                        </div> 
                        <div class="col-md-3 col-sm-3">									
                                <div class="card-body " id="bar-parent10">                                      
                                    <div class="form-group row">
                                    <label>Item Group </label>
                                        <select class="form-control  select2" onchange="itemgroup(this.value)" name="itemgroup" id="itemgroup">	
                                        <option value="0" selected disabled>Select Item Group</option>											   
                                        </select>                                            
                                    </div> 
                                </div>								  
                        </div> 
                        <div class="col-md-3 col-sm-3">									
                                <div class="card-body " id="bar-parent10">   
                                    <div class="form-group row">
                                    <label>Item Name </label>
                                        <select class="form-control  select2" name="itemname" id="itemname">		
                                            <option value="0" selected disabled>Select Item Name</option>
                                        </select>                                            
                                    </div> 
                                
                                </div>								  
                        </div>
                        <div class="col-md-3 col-sm-3">	
                            <div class="card-body " id="bar-parent10">   
                            <div class="form-group row">										
                            <button type="submit" onclick="submits()" class="btn btn-primary">Show</button>		
                            </div> 	</div> 									
                        </div> 							  
                        </div>
                                <div class="card-body ">
                                <div class="table-responsive" id="tableview">
                                    
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
?>
<script>
    function itemcategory(a)
	{
		var itemcategoryid=a;
		$.ajax({url:"<?php echo scs_index ?>GetVal/Item_Group/"+itemcategoryid, type: "POST",dataType: "html",success:function(result){		
		$("#itemgroup").html(result);
	///	alert (result);
	    }
	  });
		
	}
    function itemgroup(a)
	{
		var itemgroupid=a;
		$.ajax({url:"<?php echo scs_index ?>GetVal/Items/"+itemgroupid, type: "POST",dataType: "html",success:function(result){		
		$("#itemname").html(result);
	///	alert (result);
	    }
	  });
		
	}
    function submits()
	{  var itemnameid= document.getElementById("itemname").value;
       if(itemnameid==''|| itemnameid=='0')
	   {
 	  //  alert("Please select Itemname..!");
	      swal("Please select Itemname..!", "Retry!", "warning");
	   }
	   else
	   {
		$.ajax({url:"<?php echo scs_index ?>GetVal/ItemsDetails/"+itemnameid, type: "POST",dataType: "html",success:function(result){		
		$("#tableview").html(result);
	    }
	      });
	   }
	
	}
    function copyrate(a,b)
	{   var rateid =b;
	    var id=a;		
		$.ajax({url:"<?php echo scs_index ?>GetVal/CopyRate/"+rateid, type: "POST",dataType: "html",success:function(result){		
		var obj=$.parseJSON(result);
		var data = obj.split('-');
		document.getElementById('R'+id).value = data[0];	  
		document.getElementById('SR'+id).value = data[0];	  
		document.getElementById('S'+id).value = data[1];	  
	    }
	      });		  
	}
    function updateitems(a,b)
    {
       var headid=a;
	   var itemnameid=b;
	   var rate= document.getElementById('R'+headid).value;
	   var SRrate= document.getElementById('SR'+headid).value;	   
	   var APP = document.getElementById('APP'+headid).checked;
	    if (APP == true)
		{
			APP='1';
		} 
		else
		{
			APP='0'; 
		}
	   if(rate=='')
	   {
		   rate='0.00';
	   }
	   var taxid= document.getElementById('S'+headid).value;
	     $.ajax({url:"<?php echo scs_index ?>GetVal/UpdateItems?action=insert&headid="+headid+"&SRrate="+SRrate+"&APP="+APP+"&itemnameid="+itemnameid+"&rate="+rate+"&taxid="+taxid, type: "POST",dataType: "html",success:function(result){
		// alert("Update Successfully..!");
		swal("Update Successfully..!", "", "success");
	    }
	   });
    }
</script>
<?php
$this->pcss->wjs();
?>