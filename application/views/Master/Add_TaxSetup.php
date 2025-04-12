<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->css();
$this->pweb->ptop();

?>

<style>
  .container ul {
    list-style: none;
  }

  .box {
    border: 3px solid #fecea8;
    background-color: #E8175d;
    border-radius: .5em;
    padding: 5px;
    cursor: pointer;
    margin-top: 2px;
    color: #2a3638;
    text-align: center;
  }

  .box1 {
    border: 3px solid #fecea8;
    background-color: skybluraqua;
    border-radius: .5em;
    padding: 5px;
    cursor: move;
    margin-top: 2px;
    color: #fff;
    text-align: center;
    width: 250px;
  }

  .box.over {
    border: 3px dotted #666;
  }

  .box input {
    border: transparent;
  }

  form input {
    margin-top: 10px;
    margin-bottom: 10px;
  }

  .no-border {
    border: 0;
    outline: 0 !important;
    border-bottom: 1px solid #E8175d;
  }
</style>
<?php
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu($this->Menu, $this->session, $F_Ctrl, $F_Class);

?>
<?php
// $up = "truncate table  temp__selectedTaxtype ";
// $this->db->query($up);
// $up1 = "truncate table  temp__selectedTaxtype_det ";
// $this->db->query($up1);
?>


<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <div class="page-title-breadcrumb">
        <div class=" pull-left">
          <div class="page-title">Tax Setup</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
          <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.html">Home</a>&nbsp;<i
              class="fa fa-angle-right"></i>
          </li>
          <li><a class="parent-item" href="">Master</a>&nbsp;<i class="fa fa-angle-right"></i>
          </li>
          <li class="active">Tax Setup</li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card card-box">
          <div class="card-head">
            <header>Tax Setup</header>
          </div>
          <form action="<?php echo scs_index; ?>MsSql/TaxsetUp" id="Taxsetup-form" method="POST"  >
            <div class="card-body">
              <div>
              <input type="hidden" class="form-control"   value="<?php echo @$ID; ?>" NAME="ID" placeholder="TaxSetup" maxlength="15" required>
                <div class="row">
                  <div class="col">
                    <input type="text" class="form-control"  value="<?php echo @$Name; ?>" NAME="taxsetupname" placeholder="TaxSetup" maxlength="15" required>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control" value="<?php echo @$remarks;?>" name="remarks" placeholder="Remarks" maxlength="50">
                  </div>
                </div>

              </div>
              <div class="container row">
                <div class="col-3">
                  <ul>
                    <?php
                    $sql = "select * from taxtype where companyid='" . $_SESSION['MPOSCOMPANYID'] . "' and isnull(inactive,0)<>1 ";
                    $res = $this->db->query($sql);
                    $count = 1;
                    foreach ($res->result_array() as $row) {
                      ?>
                      <li class="box taxtype" id="taxtype<?php echo $count++; ?>"
                        onclick="getTaxtype('<?php echo $row['taxid']; ?>', '<?php echo $count; ?>');"> <?php echo $row['taxtype']; ?></li>
                      <?php
                    }
                    ?>
                  </ul> 
                </div>

                <div class="col-6" id="box2">
                <?php 
                $sql1 = "select * from taxsetupdet m
                inner join taxtype d on m.Accid = d.taxid
                 where taxsetupid='".@$ID."' order by m.accid";
                $res1 = $this->db->query($sql1);
                $no1 = $res1->num_rows();
                if($no1 !=0){
                    foreach($res1->result_array() as $row1){
                    echo 
                    '
                        <div class="form-group row" id="'.$row1['Accid'].'">
                        <label class="col-sm-3 col-form-label" for="'.$row1['taxtype'].'"> '.$row1['taxtype'].' </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control no-border" id="'.$row1['taxtype'].'" aria-describedby="tax" onchange="getTempSelected('.$row1['Accid'].',this.value);" ondblclick="getTempSelected('.$row1['Accid'].',this.value);" placeholder="'.$row1['taxtype'].'" value="'.$row1['percentage'].'" data-toggle="tooltip" data-placement="right" title="Double Click" required>                             
                                </div>
                                <div class="col-sm-1"><span class="btn btn-danger" onclick="deleterow('.$row1['Accid'].')" style="padding:10px; border-radius:5px;">X</span></div>
                        </div>
                    ';
                    }
                  }
                    ?>
                </div>
                <div class="col-3" id="box3">

                </div>
                <div class="col-3"><input type="submit" name="EXEC" value="<?php echo $BUT;?>" id="submitbtn" disabled class="btn btn-primary float-right"/></div>
              </div>


            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$this->pweb->wfoot($this->Menu, $this->session);
?> <!-- end footer -->
<script>

  // const listItems = document.getElementsByClassName("taxtype");

  // Array.from(listItems).forEach(element => {
  //  element.addEventListener('click', ()=>{
  //   console.log(element.innerHTML);
  //  });
  // });

  const getTaxtype = (id, count) => {
    document.getElementById("taxtype" + (count - 1)).style.pointerEvents = "none";
    $.ajax({
      type: "POST",
      url: "<?php echo scs_index ?>/Master/getTaxtype",
      data: "id=" + id,
      success: function (html) {
        $("#box2").append(html)
      }
    });
  }

  const getTempSelected = (id, value) => {
    $.ajax({
      type: "POST",
      url: "<?php echo scs_index ?>/Master/getSelectedTaxtype",
      data: "id=" + id + "&value=" + value,
      success: function (html) {
        $("#box3").html(html)
      }
    })
  }


  const saveFinalTaxtype = (Flevelid, Lselectedid, tempid, checked) => {
    document.getElementById("submitbtn").disabled = false;
    let checkedid = 0;
    if (checked === true) {
      checkedid = 1;
    }
    $.ajax({
      type: "POST",
      url: "<?php echo scs_index ?>/Master/saveFinalTaxtype",
      data: "Fleveid=" + Flevelid + "&Lselectedid=" + Lselectedid + "&tempid=" + tempid + '&checked=' + checkedid,
      success: function (message) {
        console.log("success");
      }
    });
  }


  const deleterow = (a)=>{
    $.ajax({
      type: "POST",
      url: "<?php echo scs_index ?>/Master/deleterow",
      data: "id="+a,
      success: function (result) {
        $("#"+result).remove();
      }
    });
  }

</script>
<?php
$this->pcss->wjs();
?>
</body>

</html>