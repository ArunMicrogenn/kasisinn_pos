<?php

	  if($_REQUEST['itemwise']==0)
	  {
	  $qry="select * from Trans_reskot_mas mas
	  inner join Trans_reskot_det det on mas.kotid=det.kotid
	  where mas.tableid='".$_REQUEST['Tableid']."' and mas.restypeid='".$_REQUEST['outletid']."' and isnull(mas.Raised,0)=0 and isnull(mas.cancelornorm,'')<>'C'";	
	  $result = $this->db->query($qry);  
	  foreach ($result->result_array() as $row)  
	  {
		  $itemid[]=$row['itemid'];
	  }
	  $itemids = implode(",", $itemid);
	  $totaldis=0;$totaltaxamt=0;
	 $qry2="select ic.Itemcategoryid,ic.itemcategory from itemmas itm 	
			INNER JOIN itemgroup ig on ig.Itemgroupid=itm.Itemgroupid 
			INNER JOIN Itemcategory ic on ic.itemcategoryid=ig.Itemcategoryid 
			where itemdetid in (".$itemids.") and isnull(itm.discountnotapplicable,0)=0
			group by ic.Itemcategoryid,ic.itemcategory";
     $restrr2 = $this->db->query($qry2);  
	 foreach ($restrr2->result_array() as $row2) 		 
	 {  $catdis=0;$totaltax=0;
	    $sql7="	   select sum(det.Amount) as Amount from Trans_reskot_mas mas
	   inner join Trans_reskot_det det on mas.kotid=det.kotid
	   inner join itemmas itm on itm.itemdetid=det.itemid and det.restypeid=itm.restypeid
	   inner join itemgroup ig on ig.itemgroupid=itm.Itemgroupid
	    where mas.tableid='".$_REQUEST['Tableid']."' and ig.itemcategoryid='".$row2['Itemcategoryid']."'
	   and isnull(itm.discountnotapplicable,0)=0 and isnull(mas.Raised,0)=0 and isnull(mas.cancelornorm,'')<>'C'
	   and isnull(det.cANCELORNORM,'')<>'C' and mas.restypeid='".$_REQUEST['outletid']."'";
		$reslt7 = $this->db->query($sql7);  
	    foreach ($reslt7->result_array() as $rows7) 		  
		{ $totalamt=$rows7['Amount']; }
	   
	   $sql5="select * from Trans_reskot_mas mas
	   inner join Trans_reskot_det det on mas.kotid=det.kotid
	   inner join itemmas itm on itm.itemdetid=det.itemid and det.restypeid=itm.restypeid
	   inner join itemgroup ig on ig.itemgroupid=itm.Itemgroupid
	    where mas.tableid='".$_REQUEST['Tableid']."' and ig.itemcategoryid='".$row2['Itemcategoryid']."'
	   and isnull(itm.discountnotapplicable,0)=0 and isnull(mas.Raised,0)=0 and isnull(mas.cancelornorm,'')<>'C'
	   and isnull(det.cANCELORNORM,'')<>'C' and mas.restypeid='".$_REQUEST['outletid']."'";    	
	   $reslt = $this->db->query($sql5);  
	   foreach ($reslt->result_array() as $rows1) 		
		{
		$Rate =$rows1['Rate']*$rows1['qty'];
		$discountamt=0;
		$per=0;
		 $qry1=" select sum(det.qty) as qty  from Trans_reskot_mas mas
	    inner join Trans_reskot_det det on mas.kotid=det.kotid
	    inner join itemmas itm on itm.itemdetid=det.itemid and det.restypeid=itm.restypeid
	    inner join itemgroup ig on ig.itemgroupid=itm.Itemgroupid
	    where mas.tableid='".$_REQUEST['Tableid']."' and ig.itemcategoryid='".$row2['Itemcategoryid']."'
	    and isnull(itm.discountnotapplicable,0)=0 and isnull(mas.Raised,0)=0 and isnull(mas.cancelornorm,'')<>'C'
	    and isnull(det.cANCELORNORM,'')<>'C' and mas.restypeid='".$_REQUEST['outletid']."'";
		$res1 = $this->db->query($qry1);  
		foreach ($res1->result_array() as $row1) 					  
		{  $qty=$row1['qty'];	}
		$catid=$row2['Itemcategoryid'] ;
		$disper = $_REQUEST['per'.$catid];
		$disamount = $_REQUEST['amt'.$catid];
		$amount=$Rate;
		if($disper != 0)
		{
		 $per=$disper;
		 $discountamt=$Rate * ($disper / 100);
		 $amount=$Rate- ($Rate * ($disper / 100));
		}
		
		if($disamount !=0)
		{
		   $first=($disamount/$totalamt)*100;
		   $per=$first;
		   $disamt= ($first * $amount)/100;
		     $discountamt=$disamt;
			 
		   $amount=$Rate-$disamt;		  
			
		}
		 $sql7="insert into Temp_discount (discamt,discper,Itemcategoryid,tableid,outletid,itemid,kotdetid,amt)
	      values('".$disamount."','".$disper."','".$catid."','".$_REQUEST['Tableid']."','".$_REQUEST['outletid']."','".$rows1['itemid']."','".$rows1['kotdetid']."','".$discountamt."')";
		$result7 = $this->db->query($sql7);
	   $sql4="select * from taxsetupmas mas
			 inner join taxsetupdet det on det.taxsetupid=mas.Taxsetupid
			 where mas.Taxsetupid='".$rows1['taxsetupid']."'";
	    $result4 = $this->db->query($sql4); $tax=0; $itemtax='0';
		foreach ($result4->result_array() as $row4) 
		 {
					$tax=($amount*$row4['percentage'])/100;
					$itemtax=$itemtax+$tax;
		 }
									///  
	
	    $totaltax=$totaltax + $itemtax	;
	    $catdis=$catdis+$discountamt;
		//$this->load->view('kotlist');		
	    }
		$totaldis=$totaldis+$catdis;
		$totaltaxamt=$totaltaxamt+$totaltax;
	 }echo $totaldis."-".$totaltaxamt;
	
	}
	 if($_REQUEST['itemwise']==1)
	 {
	  
	  $totaldis=0;$catdis=0;
	  $qry2="select * from temp_billlist where tableid='".$_REQUEST['Tableid']."' and kotid='".$_REQUEST['kotid']."' and itemid='".$_REQUEST['itemid']."' ";
	  $restrr2 = $this->db->query($qry2);
	  foreach ($restrr2->result_array() as $row2)
	  {  
	    $sql7="select sum(amount) as amt from temp_billlist where tableid='".$_REQUEST['Tableid']."' and itemid='".$_REQUEST['itemid']."' and kotid='".$_REQUEST['kotid']."'";
		$reslt7=$this->db->query($sql7);
		foreach ($reslt7->result_array() as $rows7)	  
		{ $totalamt=$rows7['amt']; }
	    $sql5="select * from temp_billlist where tableid='".$_REQUEST['Tableid']."' and itemid='".$_REQUEST['itemid']."' and kotid='".$_REQUEST['kotid']."'";
	    $reslt=$this->db->query($sql5);
		foreach ($reslt->result_array() as $rows1)	  
		{
		$Rate =$rows1['rate']*$rows1['qty'];
		$discountamt=0;
		$per=0;
		$qry1="select sum(qty) as qty from temp_billlist where tableid='".$_REQUEST['Tableid']."' and itemid='".$_REQUEST['itemid']."' and kotid='".$_REQUEST['kotid']."'";	
		$res1=$this->db->query($qry1);
		foreach ($res1->result_array() as $row1)	  
		{  $qty=$row1['qty'];
		}
		$catid=$row2['itemid'] ;
		$disper = $_REQUEST['per'.$catid];
		$disamount = $_REQUEST['amt'.$catid];
		$amount=$rows1['amount'];
		if($disper != 0)
		{
		 $per=$disper;
		 $discountamt=$Rate * ($disper / 100);
		 $amount=$Rate - ($Rate * ($disper / 100));
		}
		
		if($disamount !=0)
		{
		   $first=($disamount/$totalamt)*100;
		   $per=$first;
		   $disamt= ($first * $amount)/100;
		     $discountamt=$disamt;
			 
		   $amount=$Rate-$disamt;		  
			
		}
		if($totalamt >=$discountamt)
		{
		$upt="update temp_billlist set amount='".$amount."',discountreason='".$_REQUEST['disreason']."',disper='".$per."',disamount='".$discountamt."' where temp_id='".$rows1['temp_id']."'";
		$this->db->query($upt);	
		}		
	    else
		{$discountamt =0;}
	    $catdis=$catdis+$discountamt;
		//$this->load->view('kotlist');
	    }
		$totaldis=$totaldis+$catdis;
	   }echo $totaldis.'-khsgdfjkhskdfh';
	 }
	?>