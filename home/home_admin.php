<?php 
include "atas.php"; 
?>
<?php
?>
<div class="right_col" role="main">
          <!-- top tiles -->
            <div class="tile_count">
              <div class="col-md-3 col-sm-8  tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Pengunjung Online</span>
                <div class="count green"><?php echo $visitors['online_visitors']; ?></div>
              </div>
              <div class="col-md-3 col-sm-8  tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Pengunjung Hari Ini</span>
                <div class="count"><?php echo $visitors['today_visitors']; ?></div>
                <?php 
                  if($visitors['today_visitors'] > 0 && $visitors['yesterday_visitors'] > 0){
                    $precentage = ($visitors['today_visitors']/$visitors['yesterday_visitors'])*100;
                  }else{
                    $precentage = 0;
                  }
                ?>
                <span class="count_bottom"><i class="green"><?php echo $precentage;?>% </i> Dari Kemarin</span>
              </div>
              <div class="col-md-3 col-sm-8 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Pengunjung Bulan Ini</span>
                <div class="count"><?php echo $visitors['total_cur_month']; ?></div>
                <?php 
                  if($visitors['total_cur_month'] > 0 && $visitors['total_last_month'] > 0){
                    $precentage = ($visitors['total_cur_month']/$visitors['total_last_month'])*100;
                  }else{
                    $precentage = 0;
                  }
                ?>
                <span class="count_bottom"><i class="green"><?php echo $precentage;?>% </i> Dari Bulan Kemarin</span>
              </div>
              <div class="col-md-3 col-sm-8 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Pengunjung</span>
                <div class="count"><?php echo $visitors['total_visitors']; ?></div>
                <?php 
                  if($visitors['total_cur_month'] > 0 && $visitors['total_last_month'] > 0){
                    $precentage = ($visitors['total_cur_month']/$visitors['total_last_month'])*100;
                  }else{
                    $precentage = 0;
                  }
                ?>
              </div>
            </div>
          <!-- /top tiles -->

            <div class="col-md-12 col-sm-12 ">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-6">
                    <h3>Aktifitas Pengunjung <small>Grafik</small></h3>
                  </div>
                  <div class="col-md-6">
                    <div id="rangedatevisitor" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="fa fa-calendar"></i>
                      <span></span> <b class="caret"></b>
                    </div>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 ">
                  <div id="chart" style="width: 100%; min-height: 400px; height:350px;"></div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>

          <br />

         
                <!-- end of weather widget -->
        </div>
<?php include "bawah.php"; ?>
<script>

  var theme = {
        color: [
            '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
            '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
        ],

        title: {
            itemGap: 8,
            textStyle: {
                fontWeight: 'normal',
                color: '#408829'
            }
        },

        dataRange: {
            color: ['#1f610a', '#97b58d']
        },

        toolbox: {
            color: ['#408829', '#408829', '#408829', '#408829']
        },

        tooltip: {
            backgroundColor: 'rgba(0,0,0,0.5)',
            axisPointer: {
                type: 'line',
                lineStyle: {
                    color: '#408829',
                    type: 'dashed'
                },
                crossStyle: {
                    color: '#408829'
                },
                shadowStyle: {
                    color: 'rgba(200,200,200,0.3)'
                }
            }
        },

        dataZoom: {
            dataBackgroundColor: '#eee',
            fillerColor: 'rgba(64,136,41,0.2)',
            handleColor: '#408829'
        },
        grid: {
            borderWidth: 0
        },

        categoryAxis: {
            axisLine: {
                lineStyle: {
                    color: '#408829'
                }
            },
            splitLine: {
                lineStyle: {
                    color: ['#eee']
                }
            }
        },

        valueAxis: {
            axisLine: {
                lineStyle: {
                    color: '#408829'
                }
            },
            splitArea: {
                show: true,
                areaStyle: {
                    color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
                }
            },
            splitLine: {
                lineStyle: {
                    color: ['#eee']
                }
            }
        },
        timeline: {
            lineStyle: {
                color: '#408829'
            },
            controlStyle: {
                normal: { color: '#408829' },
                emphasis: { color: '#408829' }
            }
        },

        k: {
            itemStyle: {
                normal: {
                    color: '#68a54a',
                    color0: '#a9cba2',
                    lineStyle: {
                        width: 1,
                        color: '#408829',
                        color0: '#86b379'
                    }
                }
            }
        },
        map: {
            itemStyle: {
                normal: {
                    areaStyle: {
                        color: '#ddd'
                    },
                    label: {
                        textStyle: {
                            color: '#c12e34'
                        }
                    }
                },
                emphasis: {
                    areaStyle: {
                        color: '#99d2dd'
                    },
                    label: {
                        textStyle: {
                            color: '#c12e34'
                        }
                    }
                }
            }
        },
        force: {
            itemStyle: {
                normal: {
                    linkStyle: {
                        strokeColor: '#408829'
                    }
                }
            }
        },
        chord: {
            padding: 4,
            itemStyle: {
                normal: {
                    lineStyle: {
                        width: 1,
                        color: 'rgba(128, 128, 128, 0.5)'
                    },
                    chordStyle: {
                        lineStyle: {
                            width: 1,
                            color: 'rgba(128, 128, 128, 0.5)'
                        }
                    }
                },
                emphasis: {
                    lineStyle: {
                        width: 1,
                        color: 'rgba(128, 128, 128, 0.5)'
                    },
                    chordStyle: {
                        lineStyle: {
                            width: 1,
                            color: 'rgba(128, 128, 128, 0.5)'
                        }
                    }
                }
            }
        },
        gauge: {
            startAngle: 225,
            endAngle: -45,
            axisLine: {
                show: true,
                lineStyle: {
                    color: [[0.2, '#86b379'], [0.8, '#68a54a'], [1, '#408829']],
                    width: 8
                }
            },
            axisTick: {
                splitNumber: 10,
                length: 12,
                lineStyle: {
                    color: 'auto'
                }
            },
            axisLabel: {
                textStyle: {
                    color: 'auto'
                }
            },
            splitLine: {
                length: 18,
                lineStyle: {
                    color: 'auto'
                }
            },
            pointer: {
                length: '90%',
                color: 'auto'
            },
            title: {
                textStyle: {
                    color: '#333'
                }
            },
            detail: {
                textStyle: {
                    color: 'auto'
                }
            }
        },
        textStyle: {
            fontFamily: 'Arial, Verdana, sans-serif'
        }
    };

    var cb = function (start, end, label) {
        $('#rangedatevisitor span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        var start_date =  start.format('YYYY-MM-DD');
        var end_date =  end.format('YYYY-MM-DD');
        console.log('start '+start_date)
        getVisitor(start_date, end_date);
    };

    var optionSet1 = {
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        maxDate: moment(),
        dateLimit: {
            days: 60
        },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'MM/DD/YYYY',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    };

    $('#rangedatevisitor span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    $('#rangedatevisitor').daterangepicker(optionSet1, cb);
    var startinit=  $('#rangedatevisitor').data('daterangepicker').startDate.format('YYYY-MM-DD');
    var endinit =  $('#rangedatevisitor').data('daterangepicker').endDate.format('YYYY-MM-DD');
    getVisitor(startinit, endinit);
    function getVisitor(start_date, end_date){
        $.ajax({
            url:"home/get_visitors.php",
            method:"POST",
            dataType:"json",
            data:{start_date:start_date, end_date:end_date},
            success:function(datas){
                setDataVisitors(datas.date_visit, datas.total);
            }
        });
    }
    function setDataVisitors(date_visit, total){
        if ($('#chart').length) {
            var echartLine = echarts.init(document.getElementById('chart'), theme);
            echartLine.setOption({
                title: {
                    text: 'Line Graph',
                    subtext: 'Subtitle'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    x: 220,
                    y: 40,
                    data: ['Total Pengunjung']
                },
                toolbox: {
                    show: true,
                    feature: {
                        magicType: {
                            show: true,
                            title: {
                                line: 'Line',
                                bar: 'Bar',
                                stack: 'Stack',
                                tiled: 'Tiled'
                            },
                            type: ['line', 'bar', 'stack', 'tiled']
                        },
                        restore: {
                            show: true,
                            title: "Restore"
                        },
                        saveAsImage: {
                            show: true,
                            title: "Save Image"
                        }
                    }
                },
                calculable: true,
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    data: date_visit
                }],
                yAxis: [{
                    type: 'value'
                }],
                series: [{
                    name: 'Total Pengunjung',
                    type: 'line',
                    smooth: true,
                    itemStyle: {
                        normal: {
                            areaStyle: {
                                type: 'default'
                            }
                        }
                    },
                    data: total
                }]
            });

            $(window).on('resize', function(e){
                if(e != null && echartLine != undefined){
                echartLine.resize();
                }
            });
        }
    }

</script>
