<!--------------------------------------
  Home CMS iNomad Travel Blog Admin
  Brian Boehm 2020 
-------------------------------------->

<!-- Header
------------------------------------->
<?php require APPROOT . "/views/includes/admin_header.php"?>

<!-- Navigation
------------------------------------->
<?php include APPROOT . "/views/includes/admin_nav.php"?>

<!-- Main Section
------------------------------------->
<div id="page-wrapper">

  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">
          <b><?php echo $data['h1'] ?>
          <small><?php echo $data['description']; ?></small>
        </h1>
      </div>
    </div>
    <!-- /.row -->

    <!-- widgets -->
    <div class="row">

      <!-- posts -->
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">

          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-file-text fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <div class='huge'><?php echo $data['post_count']; ?></div>
                <div>Posts</div>
              </div>
            </div>
          </div>
          <a href="<?php echo URLROOT; ?>/admin/posts">
            <div class="panel-footer">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <!-- users -->
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-pink">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-users fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <div class='huge'><?php echo $data['user_count']; ?></div>
                <div> Users</div>
              </div>
            </div>
          </div>
          <a href="<?php echo URLROOT; ?>/admin/users">
            <div class="panel-footer">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <!-- admins -->
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-violet">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-user fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <div class='huge'><?php echo $data['admin_count']; ?></div>
                <div> Admins</div>
              </div>
            </div>
          </div>
          <a href="<?php echo URLROOT; ?>/admin/users">
            <div class="panel-footer">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <!-- categories -->
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-dark-blue">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                  <i class="fa fa-list fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <div class='huge'><?php echo $data['cat_count']; ?></div>
                <div>Categories</div>
              </div>
            </div>
          </div>
          <a href="<?php echo URLROOT; ?>/admin/categories">
            <div class="panel-footer">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>

    </div>
    <!-- /.widgets -->

    <!-- charts -->
    <div class="row">
      <script type="text/javascript">
        // create chart
        (function() {

          am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_material);
            am4core.useTheme(am4themes_animated);
            // Themes end

            var chart = am4core.create("chartdiv", am4charts.XYChart);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            chart.data = [
              // add data to chart with php
              <?php
                for ($i = 0; $i < count($data['chart_text']); $i++) {
                  echo "{'category': '{$data['chart_text'][$i]}', 'content': {$data['chart_content'][$i]}}, ";
                }
              ?>
            ];

            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.dataFields.category = "category";
            categoryAxis.renderer.minGridDistance = 40;
            categoryAxis.fontSize = 11;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.min = 0;
            valueAxis.max = <?php echo $data['max_count'] * 1.5; ?>;
            valueAxis.strictMinMax = true;
            valueAxis.renderer.minGridDistance = 30;

            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.categoryX = "category";
            series.dataFields.valueY = "content";
            series.columns.template.tooltipText = "{valueY.value}";
            series.columns.template.tooltipY = 0;
            series.columns.template.strokeOpacity = 0;

            // as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
            series.columns.template.adapter.add("fill", function(fill, target) {
              return chart.colors.getIndex(target.dataItem.index);
            });

          }); 

        }) ();
      </script>
      <!-- chart container -->
      <div id="chartdiv" style="width: auto; height: 500px; padding: 20px;"></div>
    </div>
    <!-- /. charts -->

  </div>
  <!-- /.container-fluid -->
</div>

<!-- Footer
------------------------------------->
<?php include APPROOT . "/views/includes/admin_footer.php"?>