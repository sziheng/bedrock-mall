$(function () {

    $.ajax({
        type: "GET",
        url: 'http://'+window.location.host+'/order/ajaxorder',
        dataType: "json",
        success: function (data) {
            var json = data;
            $(".today-count").text(json.order0.count);
            $(".today-price").text(json.order0.price);
            $(".today-avg").text(json.order0.avg);

            $(".yesterday-count").text(json.order1.count);
            $(".yesterday-price").text(json.order1.price);
            $(".yesterday-avg").text(json.order1.avg);

            $(".seven-count").text(json.order7.count);
            $(".seven-price").text(json.order7.price);
            $(".seven-avg").text(json.order7.avg);

            $(".month-count").text(json.order30.count);
            $(".month-price").text(json.order30.price);
            $(".month-avg").text(json.order30.avg);

            $.ajax({
                type: "GET",
                async: false,
                url: 'http://'+window.location.host+'/order/ajaxtransaction',
                dataType: "json",
                success: function (json) {
                    var lineChart = echarts.init(document.getElementById("echarts-line-chart"));
                    var lineoption = {
                        title: {
                            text: '最近7日交易走势'
                        },
                        tooltip: {
                            trigger: 'axis',
                            confine: true
                        },
                        legend: {
                            data: ['成交额', '成交量']
                        },
                        grid: {
                            x: 50,
                            x2: 50,
                            y2: 30
                        },
                        calculable: true,
                        xAxis: [
                            {
                                type: 'category',
                                boundaryGap: false,
                                data: json.price_key
                            }
                        ],
                        yAxis: [
                            {
                                type: 'value',
                                axisLabel: {
                                    formatter: '{value}'
                                }
                            }
                        ],
                        series: [
                            {
                                name: '成交额',
                                type: 'line',
                                showAllSymbol:true,
                                data: json.price_value,
                                markPoint: {
                                    data: [
                                        {type: 'max', name: '最大值'},
                                        {type: 'min', name: '最小值'}
                                    ]
                                },
                                markLine: {
                                    data: [
                                        {type: 'average', name: '平均值'}
                                    ]
                                }
                            },
                            {
                                name: '成交量',
                                type: 'line',
                                showAllSymbol:true,
                                data: json.count_value,
                                markLine: {
                                    data: [
                                        {type: 'average', name: '平均值'}
                                    ]
                                }
                            }
                        ]
                    };
                    lineChart.setOption(lineoption);
                    lineChart.resize();

                    $("#echarts-line-chart-loading").hide();
                    $("#echarts-line-chart").show();
                }
            });
        }
    });
});