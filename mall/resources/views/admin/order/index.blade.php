@extends('admin.layout.main')
@section('content')

    <link href="/css/style.css" rel="stylesheet">
    <script src="/js/order.js"></script>
    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>订单管理 <small>订单概述</small></h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="ibox float-e-margins" style="border: 1px solid #e7eaec">
                                <div class="ibox-title">
                                    <span class="label label-primary pull-left">今日成交</span>
                                    <span class="pull-right">人均消费 : ¥ <span class="today-avg"></span></span>
                                    <h5></h5>
                                </div>
                                <div class="ibox-content">

                                    <div class="row">
                                        <div class="col-md-6 text-center">
                                            成交量
                                            <h2 class="no-margins today-count">--</h2>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            成交额
                                            <h2 class="no-margins">¥ <span class="today-price">--</span></h2>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="ibox float-e-margins" style="border: 1px solid #e7eaec">
                                <div class="ibox-title">
                                    <span class="label label-success pull-left">昨日成交</span>
                                    <span class="pull-right">人均消费 : ¥ <span class="yesterday-avg">--</span></span>
                                    <h5></h5>
                                </div>
                                <div class="ibox-content">

                                    <div class="row">
                                        <div class="col-md-6 text-center">
                                            成交量
                                            <h2 class="no-margins yesterday-count">--</h2>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            成交额
                                            <h2 class="no-margins">¥ <span class="yesterday-price">--</span></h2>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="ibox float-e-margins" style="border: 1px solid #e7eaec">
                                <div class="ibox-title">
                                    <span class="label label-warning pull-left">近7日成交</span>
                                    <span class="pull-right">人均消费 : ¥ <span class="seven-avg">--</span></span>
                                    <h5></h5>
                                </div>
                                <div class="ibox-content">

                                    <div class="row">
                                        <div class="col-md-6 text-center">
                                            成交量
                                            <h2 class="no-margins seven-count">--</h2>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            成交额
                                            <h2 class="no-margins">¥ <span class="seven-price">--</span></h2>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="ibox float-e-margins" style="border: 1px solid #e7eaec">
                                <div class="ibox-title">
                                    <span class="label label-danger pull-left">近1个月成交</span>
                                    <span class="pull-right">人均消费 : ¥ <span class="month-avg">--</span></span>
                                    <h5></h5>
                                </div>
                                <div class="ibox-content">

                                    <div class="row">
                                        <div class="col-md-6 text-center">
                                            成交量
                                            <h2 class="no-margins month-count">--</h2>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            成交额
                                            <h2 class="no-margins">¥ <span class="month-price">--</span></h2>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="ibox float-e-margins" style="border: 1px solid #e7eaec">
                                <div class="ibox-title">
                                    <h5>交易走势图</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="echarts" id="echarts-line-chart" style="display: none"></div>

                                    <div class="spiner-example" id="echarts-line-chart-loading">
                                        <div class="sk-spinner sk-spinner-wave">
                                            <div class="sk-rect1"></div>
                                            <div class="sk-rect2"></div>
                                            <div class="sk-rect3"></div>
                                            <div class="sk-rect4"></div>
                                            <div class="sk-rect5"></div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection