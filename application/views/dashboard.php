<?php
defined('BASEPATH') or exit('No direct script access allowed');
 $billAmount = 0;
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            <?php
            $sql = "select Paymode from Mas_Paymode";
            $exe = $this->db->query($sql);
            foreach ($exe->result_array() as $res) {
                $paymode = $res['Paymode'];
                $sql1 = "Exec daysettlement__dashboard_pos '".date('Y-m-d')."','".date('Y-m-d')."', '".$res['Paymode']."','".$_SESSION['MPOSCOMPANYID']."' ";
                $exe = $this->db->query($sql1);
                foreach ($exe->result_array() as $row) {
                $billAmount = $row['cash']; ?>
                        ['<?php echo $paymode; ?>', <?php echo $billAmount; ?>],
                <?php }
            } ?>
        ]);

        var options = {
            title: 'Day Settlement',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
    }
   
</script>

<script  type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Transaction", "Amount", { role: "style" } ],
        <?php 
            $sql3= "Exec weeklysettlement__dashboard '".date('Y-m-d', strtotime('-15 Days'))."', '".date('Y-m-d')."','".$_SESSION['MPOSCOMPANYID']."' ";
            $exec = $this->db->query($sql3);
            foreach($exec->result_array() as $roww){?>
            [ '<?php echo date('d-m-Y',strtotime($roww['SettleDate']))?>', <?php echo $roww['totalAmount'] ?>,"#58c747"],
            <?php
            }
        ?>

      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Weekly Settlement",
        width: 500,
        height: 500,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
    }

</script>




<?php

$this->pweb->phead();
$this->pcss->css();
$this->pweb->ptop();
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu1($this->Menu, $this->session);
$Outlet = $this->Myclass->Outlet(0);
@$data = $Outlet[0];
@session_start();
echo @$_SESSION['MPOSOUTLET'] = $data['id'];
?>

<!-- start page content -->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <?php $_SESSION['MPOSOUTLET']; ?>
            <div class="col-sm-12 col-md-12 col-lg-12" style="display:flex !important; width=100% !important;">

                <div id="piechart_3d" style="width: 50%; height: 500px;"></div>
                <div id="columnchart_values" style="width: 48%px; height: 500px;"></div>
            </div>
        </div>
    </div>
</div>
<!-- end page content -->


<!-- end chat sidebar -->

<!-- end page container -->
<!-- start footer -->
<?php
$this->pweb->wfoot($this->Menu, $this->session);
$this->pcss->wjs();
?>
</body>

</html>