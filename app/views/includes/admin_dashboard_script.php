<script type="text/javascript">

  (function() {

    // animate panels
    $(document).ready(function() {
      $('.slide').each(function(i) {
        let slide = $(this);
        setTimeout(() => {
          slide.animate({'top': 0, 'opacity': 1}, 500)
        }, 150*i);
      });
    });

    // render chart
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