<?php

class Myclass extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
    function Outlet($ID=0){
     
         $qry=" exec  Get_Outlet ".$ID.",".$_SESSION['MPOSCOMPANYID'];
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      }
      function Itemcategory($ID=0)
      { $qry=" exec  Get_Itemcategory ".$ID;
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      }
      function Itemgroup($ID=0)
      { $qry=" exec  Get_Itemgroup ".$ID.",".$_SESSION['MPOSCOMPANYID'];
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      }
      function ItemSubGroup1($ID=0)
      {
        $qry=" exec  Get_ItemSubGroup1 ".$ID;
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      }
      function ItemSubGroup2($ID=0)
      {
        $qry=" exec  Get_ItemSubGroup2 ".$ID;
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      }
      function FoodType($ID=0)
      {
        $qry=" exec  Get_FoodType ".$ID;
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      }
      Public function Company($ID=0)
      {
        $qry=" exec  Get_Companypos ".$ID;
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      }
      Public function Items($ID=0)
      {
        $qry=" exec  Get_Items ".$ID;
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      }
      Public function OutletItems($ID=0,$ResId=0)
      {
        $qry=" exec Get_OutletItems ".$ID.",".$ResId;
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      }
      Public function Tables($ID=0)
      {
        $qry=" exec Get_Tables ".$ID;
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      }
      Public function Outlet_Tables($ID=0,$ResId=0)
      {
        $qry=" exec  Get_Outlet_Tables ".$ID.",".$ResId;
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      }       
      Public Function Employee($ID=0)
      {
        $qry=" exec  Get_Employee ".$ID;
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      }  
      Public Function Customers($ID=0)
      {
        $qry=" exec  Get_Customers ".$ID;
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      } 
      Public Function Configuration($ID=0)
      {
        $qry="select * from Headings where isnull(id,0)='".$ID."' and isnull(companyid,0)='".$_SESSION['MPOSCOMPANYID']."'"; 
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      } 
      Public Function SMSTemplates($ID=0)
      {              
        $qry="select * from mas_smsmessagepos where isnull(companyid,0)='".$_SESSION['MPOSCOMPANYID']."'";    
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      } 
      Public Function Session($ID=0)
      {              
        $qry=" exec  Get_Session ".$ID; 
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      } 
       public function Taxtype($ID=0)
       {
        $qry=" exec  Get_Taxtype ".$ID; 
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
       }
       public function Paymode($ID=0)
       {
        $qry=" exec  Get_Paymodepos ".$ID; 
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
       }
       public function GetBank($ID=0)
       {
        $qry=" exec Get_Bank ".$ID; 
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
       }

       Public Function Users($ID=0)
       {
         $qry=" exec  Get_Userss ".$ID;
         $res=$this->db->query($qry);
         $Res= json_encode($res->result());
         $Res=json_decode($Res,true);
         return $Res;
       }
       Public Function UserGroup($ID=0)
       {
         $qry=" exec  Get_UserGroupPOs ".$ID;
         $res=$this->db->query($qry);
         $Res= json_encode($res->result());
         $Res=json_decode($Res,true);
         return $Res;
       }
	   public function TaxSetup($ID=0)
      {
       $qry=" exec Get__Taxsetup ".$ID; 
       $res=$this->db->query($qry);
       $Res= json_encode($res->result());
       $Res=json_decode($Res,true);
      //  print_r($Res);
       return $Res;
      }

      public function ClearTaxSetup()
      {
       $qry=" exec clear__temptaxsetup ";
       $res=$this->db->query($qry);
       $Res= json_encode($res->result());
       $Res=json_decode($Res,true);
      //  print_r($Res);
       return $Res;
      }
      public function SplInstruction($ID=0)
      {
        $qry=" exec Get_SplInstruction ".$ID; 
        $res=$this->db->query($qry);
        $Res= json_encode($res->result());
        $Res=json_decode($Res,true);
        return $Res;
      }

}
?>