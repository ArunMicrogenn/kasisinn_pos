<?php

$label = $_POST['label'];
$outletid = $_POST['outletid'];
$tableid = $_POST['tableid'];
?>
	   <div class="box-content">
		    <form id="Discountform"> 
			 <input type="hidden" value="<?php echo $tableid; ?>" name="Tableid" id="Tableid" >
			 <input type="hidden" value="<?php echo $outletid; ?>" name="outletid" id="outletid" >
			   <?php 
			   $tr="delete Temp_discount where tableid='".$tableid."' and outletid='".$outletid."'";
			   $exetru = $this->db->query($tr);
			   
			   $sql1="exec KotResBillItem_dis ".$tableid.",".$outletid;				
			   $result1 = $this->db->query($sql1);
			   foreach ($result1->result_array() as $row1) 
				{  if($row1['discountnotapplicable'] !='1')
					{
					$itemid[]=$row1['itemid'];
					$Kotid[]=$row1['kotdetid'];
					}
				}
				$itemids = implode(",", $itemid);
				$Kotids = implode(",", $Kotid);  ?>  
				<table class="table table-striped table-bordered bootstrap-datatable datatable">
				   <thead style="font-size:12px;background: #3c8dbc; color: #fff">
				   <th style="width:10px;font-size:12px;text-align: center;">#No</th>
				   <th style="font-size:12px;text-align: center;">Category</th>				   
				   <th style="width:70px;font-size:12px;text-align: center;">Amount</th>				   
				   <th style="font-size:12px;text-align: center;width:50px">Disc %</th>
				   <th style="font-size:12px;text-align: center;width:50px">Disc Amt</th>		
				</thead> 
				<tbody>
				<?php 
				$sql2="select ic.Itemcategoryid,ic.itemcategory from itemmas itm 
				INNER JOIN itemgroup ig on ig.Itemgroupid=itm.Itemgroupid INNER 
				JOIN Itemcategory ic on ic.itemcategoryid=ig.Itemcategoryid 
				where itm.Itemdetid in  (".$itemids.")   
				group by ic.Itemcategoryid,ic.itemcategory";
				$result2 =  $this->db->query($sql2);  
				$i=1;
				foreach ($result2->result_array() as $row2) { 
				
					 $qry3="select sum(det.Amount)as Amount from Trans_reskot_mas mas
					Inner join Trans_resKot_det det on det.Kotid=mas.Kotid
					INNER JOIN itemmas stm on stm.Itemdetid=det.itemid and det.restypeid=stm.restypeid
					INNER JOIN itemgroup ig on ig.Itemgroupid=stm.Itemgroupid 
					INNER JOIN Itemcategory ic on ic.itemcategoryid=ig.Itemcategoryid  
					where mas.Tableid='".$tableid."' and isnull(mas.Raised,0)=0 
					and ISNULL(mas.cancelornorm,'')<>'C' and ic.Itemcategoryid='".$row2['Itemcategoryid']."'
					and det.kotdetid in (".$Kotids.") and mas.restypeid='".$outletid."'
					group by ic.Itemcategoryid,ic.itemcategory";				
					$restrr3 = $this->db->query($qry3);	
					foreach ($restrr3->result_array() as $row3) 				
					{
					$catamt=$row3['Amount'];
					}
					echo '<tr style="font-size:11px;">';
					echo '<td>'.$i.'</td>';
					echo '<td>'.$row2['itemcategory'].'</td>';
					echo '<td style="text-align: Right;">'.$catamt.'</td>';?>
					<td ><input  style="text-align: Right;width:50px;height:25px;font-size:11px;" type="text" onchange="Clearamt(this.id)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength='2' value="0" name="per<?php echo $row2['Itemcategoryid'] ?>" id="per<?php echo $row2['Itemcategoryid'] ?>" class="form-control" min="0" max="99"> </td>	
					<td> <input style="text-align: Right;width:50px;height:25px;font-size:11px;" type="text" onchange="Clearper(this.id)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="0" name="amt<?php echo $row2['Itemcategoryid'] ?>" id="amt<?php echo $row2['Itemcategoryid'] ?>" class="form-control"></td>
					<?php echo '</tr>'; 
					echo '</tr>'; 		
					$i=$i+1;				
				    } echo '<td></td>';?>
			 <td><input style="text-align: left;height:25px;font-size:11px;"type="Text" required class="form-control" placeholder="Reason" name="disreason"id="disreason"></td>
			 <td></td>
			 <td></td>
            <td><input style="font-size:11px;" onclick="apply()" type="submit" name="discountsubmit" id="discountsubmit" value="Apply"></td>
			</tbody>			
			</table>
			<input type="hidden" value="0" name="itemwise" id='itemwise'/>
         </form>			
         </div>
		 		<script>			 
			function Clearper(a)
              { 
			  var res = a.split("amt");
			  document.getElementById("per"+res[1]).value = 0;
			  var amt= +document.getElementById(a).value; 
			  var total= document.getElementById("total"+res[1]).value;
			  var str = document.getElementById("disamt").value ;
			  str = str && Math.round(str);
			  total = total && Math.round(total);
			 	
				  if(str  < amt)
				  {
					  alert("User credit Level exited");
					  document.getElementById("amt"+res[1]).value = 0;
				  } 
				  if(total  < amt)
				  {
					  alert("Discount Amount Greater than Bill Amount");
					  document.getElementById("amt"+res[1]).value = 0;
				  } 			  
			  
			  }
			  
			  function Clearamt(a)
              { 
			  var res = a.split("per");
			  document.getElementById("amt"+res[1]).value = 0;
			  var amt=+document.getElementById(a).value; 
			  var total= document.getElementById("total"+res[1]).value;
			  var str1 = document.getElementById("disper").value;
			  str1 = str1 && Math.round(str1);
			   total = total && Math.round(total);
			 // console.log	(str1,amt,total);
				  if(str1  < amt)
				  {
					  alert("User credit Level exited");
					  document.getElementById("per"+res[1]).value = 0;
				  }
			  }
		</script>