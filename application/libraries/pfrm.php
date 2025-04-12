<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pfrm {
    public function FrmHead6($Title,$load,$view)
        { ?>
          <div class="page-content-wrapper">
            <div class="page-content">
                <div class="page-bar">
                    <div class="page-title-breadcrumb">
                        <div class=" pull-left">
                            <div class="page-title">Session Wise Report</div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right">
                            <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                            </li>
                            <li><a class="parent-item" href="">Report</a>&nbsp;<i class="fa fa-angle-right"></i>
                            </li>
                            <li class="active">Session Wise Report</li>
                        </ol>
                    </div>
                </div>
        <?php
		//	 echo  '<form name="scsfrm" id="scsfrm" >';
		//	 echo '<input type="hidden" name="Mname" id="Mname" value="'.$load.'"  >';
		//	 echo '<input type="hidden" name="Scs_index" id="Scs_index" value="'.scs_index.'"  >';
		    $load = "Transaction/RoomstatusOnline";
			$printing="'printing'";
			$excel="'exporttable'";
			$pdf="'exportpdf'";
			echo '<section class="content">
				   <div class="box">
				   <div class="box-header with-border">
					<h3 class="box-title">'.$Title.'</h3>
					
					 
					<a href="#" id="Rload" onclick="printDiv('.$printing.')" class="btn btn-success btn-sm pull-right" > Print</a>
					<a href="#"  id='.$excel.' class="btn btn-success btn-sm pull-right" >Excel</a>
					<a href="#"  id='.$pdf.'  class="btn btn-success btn-sm pull-right" >Pdf</a>
					<a href="'.scs_index.$load.'" id="Rload" class="btn btn-danger btn-sm pull-right" >Back</a> </div>
					<div class="box-body">';		 
			 	   
        }
}

?>