<!-- Chart -->
<div class="crartdiv" id="chartdiv" style="display: block; width: 100%; height: 100%;"></div>
<div class="crartdiv" id="chartdiv2" style="display: block; width: 100%; height: 100%; display: none;"></div>
<div class="crartdiv" id="chartdiv3" style="display: block; width: 100%; height: 100%; display: none;"></div>
@push('js')
    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/plugins/exporting.js"></script>
    <script>
        function chart(selector, data = []) {
            am5.ready(function() {

                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new(selector);


                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);


                // Create chart
                // https://www.amcharts.com/docs/v5/charts/xy-chart/
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: true,
                    panY: true,
                    wheelX: "panX",
                    wheelY: "zoomX",
                    layout: root.verticalLayout,
                    pinchZoomX: true
                }));


                // Add cursor
                // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
                    behavior: "none"
                }));
                cursor.lineY.set("visible", false);


                // The data


                // Create axes
                // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                    categoryField: "date",
                    startLocation: 0.5,
                    endLocation: 0.5,
                    renderer: am5xy.AxisRendererX.new(root, {}),
                    tooltip: am5.Tooltip.new(root, {})
                }));

                xAxis.data.setAll(data);

                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    renderer: am5xy.AxisRendererY.new(root, {})
                }));


                function createSeries(name, field, color) {
                    var series = chart.series.push(am5xy.LineSeries.new(root, {
                        name: name,
                        stacked: false,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: field,
                        categoryXField: "date",
                        // fill: am5.color(color),
                        // stroke: am5.color(color),
                        tooltip: am5.Tooltip.new(root, {
                            pointerOrientation: "horizontal",
                            labelText: "[bold]{name}[/]\n{valueY}"
                        })
                    }));


                    series.fills.template.setAll({
                        fillOpacity: 0.3,
                        visible: true
                    });

                    <?php /*series.bullets.push(function() {
                                                                return am5.Bullet.new(root, {
                                                                  locationY: 0,
                                                                  sprite: am5.Circle.new(root, {
                                                                    radius: 4,
                                                                    stroke: root.interfaceColors.get("background"),
                                                                    strokeWidth: 2,
                                                                    fill: series.get("fill")
                                                                  })
                                                                });
                                                              });*/
                    ?>


                    series.data.setAll(data);
                    series.appear(1000);
                }

                createSeries("Answered", "answer", "#add8e6");
                createSeries("Unanswered", "unanswer", "#ffc0cb");

                // Add scrollbar
                // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
                // chart.set("scrollbarX", am5.Scrollbar.new(root, {
                //   orientation: "horizontal"
                // }));

                // Add legend
                // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
                var legend = chart.children.push(am5.Legend.new(root, {
                    x: am5.percent(50),
                    centerX: am5.percent(45),
                    layout: root.gridLayout
                }));

                legend.data.setAll(chart.series.values);

                // Make stuff animate on load
                // https://www.amcharts.com/docs/v5/concepts/animations/
                chart.appear(1000, 100);

                var exporting = am5plugins_exporting.Exporting.new(root, {
                    menu: am5plugins_exporting.ExportingMenu.new(root, {}),
                    dataSource: data,
                    numericFields: ["read", "unread"],
                    numberFormat: "#,###",
                    // dateFields: ["date"],
                    // dateFormat: "dd-MM-yyyy",
                    dataFields: {
                        read: "Read",
                        unread: "Unread",
                        date: "Date"
                    },
                    dataFieldsOrder: ["read", "unread"],
                    filePrefix: "Wa Business"
                });

            }); // end am5.ready()
        }
    </script>
@endpush
