<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph">

            <div class="row x_title">
                <div class="col-md-6">
                    <h3>Contas
                        <small class="red">A Pagar</small>
                        <small>&</small>
                        <small class="green"> Receber</small>
                    </h3>
                </div>
            </div>

            <div class="col-md-9 col-sm-9 col-xs-12">
                <div id="chart_plot_01" class="demo-placeholder"></div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 bg-white">
                <div class="x_title">
                    <h2>Contas Máxima/Mínima</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-6">
                    <div>
                        <p>Máxima a Receber</p>
                        <div class="">
                            <div class="progress">
                                <div class="progress-bar bg-green max_rec" role="progressbar"></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p>Máxima a Pagar</p>
                        <div class="">
                            <div class="progress">
                                <div class="progress-bar bg-red max_pay" role="progressbar"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-6">
                    <div>
                        <p>Mínima a Receber</p>
                        <div class="">
                            <div class="progress text-center">
                                <div class="progress-bar bg-green min_rec" role="progressbar"></div>
                                <span class="min_rec_text"></span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p>Mínima a Pagar</p>
                        <div class="">
                            <div class="progress text-center">
                                <div class="progress-bar bg-red min_pay" role="progressbar"></div>
                                <span class="min_pay_text"></span>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="clearfix"></div>
        </div>
    </div>

</div>
<br/>
<script src="/webroot/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js" type="text/javascript"></script>
<script src="/webroot/vendors/iCheck/icheck.min.js" type="text/javascript"></script>
<script src="/webroot/vendors/Chart.js/dist/Chart.min.js" type="text/javascript"></script>
<script src="/webroot/vendors/Flot/jquery.flot.js" type="text/javascript"></script>
<script src="/webroot/vendors/Flot/jquery.flot.pie.js" type="text/javascript"></script>
<script src="/webroot/vendors/Flot/jquery.flot.time.js" type="text/javascript"></script>
<script src="/webroot/vendors/Flot/jquery.flot.stack.js" type="text/javascript"></script>
<script src="/webroot/vendors/Flot/jquery.flot.resize.js" type="text/javascript"></script>
<script src="/webroot/vendors/DateJS/build/date.js" type="text/javascript"></script>
<script src="/webroot/vendors/flot.orderbars/js/jquery.flot.orderBars.js" type="text/javascript"></script>
<script src="/webroot/vendors/flot-spline/js/jquery.flot.spline.min.js" type="text/javascript"></script>
<script src="/webroot/vendors/flot.curvedlines/curvedLines.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function () {

        var contasPagar = [];
        var contasReceber = [];
        var dataInicio = '<?=date('Y-m-d')?>';
        var dataFim = '<?=date('Y-m-d', strtotime("+1 month", strtotime(date('Y-m-d'))))?>';
        var dataInfo = [0, 0, 0, 0, -1];

        var chart = function () {
            if ("undefined" != typeof $.plot) {
                var g = {
                    series: {
                        lines: {show: !1, fill: !0},
                        splines: {show: !0, tension: .4, lineWidth: 1, fill: .4},
                        points: {radius: 0, show: !0},
                        shadowSize: 2
                    },
                    grid: {
                        verticalLines: !0,
                        hoverable: !0,
                        clickable: !0,
                        tickColor: "#d5d5d5",
                        borderWidth: 1,
                        color: "#fff"
                    },
                    colors: ["rgba(185, 38, 38, 0.38)", "rgba(3, 88, 106, 0.38)"],
                    xaxis: {
                        tickColor: "rgba(51, 51, 51, 0.06)",
                        mode: "time",
                        tickSize: [1, "day"],
                        axisLabel: "Date",
                        axisLabelUseCanvas: !0,
                        axisLabelFontSizePixels: 12,
                        axisLabelFontFamily: "Verdana, Arial",
                        axisLabelPadding: 10
                    },
                    yaxis: {ticks: 8, tickColor: "rgba(51, 51, 51, 0.06)"},
                    tooltip: !1
                };

                $("#chart_plot_01").length && (console.log("Plot1"), $.plot($("#chart_plot_01"), [contasPagar, contasReceber], g))
            }
        }

        var bars = function () {
            console.log((dataInfo[0] / dataInfo[4] * 100));
            $('.max_rec').css('width', (dataInfo[0] / dataInfo[4] * 100) + '%');
            $('.max_pay').css('width', (dataInfo[2] / dataInfo[4] * 100) + '%');
            $('.min_rec').css('width', (dataInfo[1] / dataInfo[4] * 100) + '%');
            $('.min_pay').css('width', (dataInfo[3] / dataInfo[4] * 100) + '%');

            $('.max_rec').html('R$ ' + (dataInfo[0].replace('.', ',')));
            $('.max_pay').html('R$ ' + (dataInfo[2].replace('.', ',')));
            $('.min_rec_text').html('R$ ' + (dataInfo[1].replace('.', ',')));
            $('.min_pay_text').html('R$ ' + (dataInfo[3].replace('.', ',')));

            $('.min_pay, .min_rec').css('color', '#545454');


        }

        var loadChartData = function () {
            $.getJSON('/Contas/relatorioMensal&d1=' + dataInicio + '&d2=' + dataFim, function (data) {
                $.each(data.dataMonth, function (key, val) {
                    var date = val.data_vencimento.split('-');
                    if (val.tipo == '-1')
                        contasPagar.push([gd(date[0], date[1], date[2]), val.saldo])
                    else
                        contasReceber.push([gd(date[0], date[1], date[2]), val.saldo])
                });

                dataInfo[4] = -1;
                $.each(data.dataPeriod, function (key, val) {
                    if (dataInfo[4] < val.max)
                        dataInfo[4] = parseFloat(val.max);
                    if (val.tipo == '1') {
                        dataInfo[0] = val.max;
                        dataInfo[1] = val.min;
                    } else if (val.tipo == '-1') {
                        dataInfo[2] = val.max;
                        dataInfo[3] = val.min;
                    }
                    console.log(dataInfo);
                });
                chart();
                bars();
            });
        }

        loadChartData();
    });

</script>
