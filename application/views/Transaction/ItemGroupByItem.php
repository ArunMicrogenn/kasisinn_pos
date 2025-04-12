
<fieldset  id="Itemname1" style="background-color:#FFFFFF ;overflow-x:hidden; overflow-y: scroll;height:375px; width:100%;">
    <?php 
    $sql="select itm.itemdetid,itm.Itemname from itemmas itm where Itemgroupid='".$ID."' and restypeid=".$_SESSION['MPOSOUTLET'];
    $result=$this->db->query($sql);  
    foreach ($result->result_array() as $row)
    {  ?>
        <div onclick="ItemInsert(this.id);" class="btn-group" id="<?php echo $row['itemdetid']; ?>" name="<?php echo $row['itemdetid']; ?>" role="group" aria-label="Third group" style="width:24.2%;margin-top:5px !important"> 
        <a id="item" style="border-radius:4px;font-size:11px;width:100%" class="btn btn-info"><?php echo $row['Itemname']; ?></a> 
        </div> 
    <?php } ?>                                
</fieldset>

