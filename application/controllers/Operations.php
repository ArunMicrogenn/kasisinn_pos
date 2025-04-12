<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Operations extends CI_Controller {
 
     function Bill_Cancellation()
     {
          $data=array('F_Class'=>'Operations','F_Ctrl'=>'Bill_Cancellation');
         // $this->load->view('Operations/Bill_Cancellation',$data);
          $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
     }
     function Billcancel()
     {
          $update="update Trans_ResKotBillraise_mas set CANCEL=1,CANCELAMT=totalamount,Settled=1,totalamount=0,cancelreason='".$_POST['label']."' where billid='".$_POST['billid']."'";
          $update1="Update Tablemas set Status='K' where Tableid='".$_POST['Table']."'";
          $query="select DISTINCT  det.Kotid from Trans_ResKotBillraise_mas mas
                 inner join Trans_ResKotBillraise_det det on mas.Billid=det.billid
                 where mas.Billid='".$_POST['billid']."'"; 
          $result=$this->db->query($query);											
          foreach ($result->result_array() as $row)
          {
           $update2="update Trans_reskot_mas set Raised=0 where kotid='".$row['Kotid']."'";           
           $result=$this->db->query($update2);		
          }
          
          $result1=$this->db->query($update.$update1);
     }
     function Settlement_Cancellation()
     {
          $data=array('F_Class'=>'Operations','F_Ctrl'=>'Settlement_Cancellation');
          $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
     }
     function Billsettelementcancel()
     {
          $sql = "select isnull(roomgrcid,0) as roomgrcid, isnull(grcid,0) as grcid, isnull(roomid,0) as roomid,restypeid,* from trans_reskotbillraise_mas where billid='".$_POST['billid']."'";
          $res = $this->db->query($sql);
          foreach($res->result_array() as $row){
               $roomgrcid = $row['roomgrcid'];
               $grcid = $row['grcid'];
               $roomid = $row['roomid'];
               $restypeid = $row['restypeid'];
               if($roomgrcid !=0 and $grcid !=0)
               {
                    $sql2 = "select * from room_status where roomgrcid='".$roomgrcid."' and 
                    grcid='".$grcid."' and roomid='".$roomid."' and status='Y' and isnull(billsettle,0)<>1";
                    $res2 = $this->db->query($sql2);
                    $no = $res2->num_rows();
                    if($no !=0){
                         $up = "delete from trans_credit_entry where roomgrcid='".$roomgrcid."' and grcid='".$grcid."'
                         and resttypeid='".$restypeid."'";
                         $update="update trans_reskotbillraise_mas set settled = 0  where billid='".$_POST['billid']."'";
                         $update1="update trans_reskotsettlement set cancel=1, narration='".$_POST['label']."' where Billid ='".$_POST['billid']."' and Cancel='0' ";
                         $update2="Update Tablemas set Status='B' where Tableid='".$_POST['Table']."'";         
                         $result =$this->db->query( $up.$update.$update1.$update2);	
                    }else{
                         echo "Room Is already checked out!";
                    }
               }
               else{
                    $update="update trans_reskotbillraise_mas set settled = 0  where billid='".$_POST['billid']."'";
                    $update1="update trans_reskotsettlement set cancel=1, narration='".$_POST['label']."' where Billid ='".$_POST['billid']."' and Cancel='0' ";
                    $update2="Update Tablemas set Status='B' where Tableid='".$_POST['Table']."'";         
                    $result=$this->db->query( $update.$update1.$update2);	
               }
          }

          	
     }
     function Table_Move()
     {          
          $data=array('F_Class'=>'Operations','F_Ctrl'=>'Table_Move');
          $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
     }
     function Table_Move_Save()
     {
          $sql="Exec_TableMove '".$_POST['FromTable']."','".$_POST['Totable']."' ";
          $result=$this->db->query( $sql);
     }
     function ItemwiseTableMove()
     {
        echo  $del="Exec_TempItemwiseTableMove  '".$_POST['FromTable']."','".$_POST['Totable']."' ";
          $delexe = $this->db->query($del);	

     }

     function Resettlement()
     {
          $data=array('F_Class'=>'Operations','F_Ctrl'=>'Resettlement');
          $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
     }

     function Resettlement_edit($billid,$tableid)
     {
          $data=array('F_Class'=>'Operations','F_Ctrl'=>'Resettlement_edit','billid'=>$billid,'tableid'=>$tableid);
          $this->load->view($data['F_Class'].'/'.$data['F_Ctrl'],$data);
     }
}
?>