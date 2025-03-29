@extends('voyager::master')

@section('css')
    <style>
        .chart-container {
            position: relative;
            height: auto; /* Adjust height automatically */
            width: 100%;
            margin-bottom: 20px; /* Reduce margin for better spacing */
            overflow: visible;
            min-height: 300px; /* Set a minimum height */
        }
        .chart-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px; /* Adjust margin for better spacing */
        }
        .chart-col {
            flex: 0 0 100%; /* Make each chart take full width on smaller screens */
            max-width: 100%;
            padding: 0 10px; /* Adjust padding for better spacing */
            margin-bottom: 20px; /* Reduce margin for better spacing */
        }
        .chart-card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 20px;
            height: 100%;
        }
        .chart-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }
        @media (min-width: 768px) {
            .chart-col {
                flex: 0 0 50%; /* Make each chart take half width on larger screens */
                max-width: 50%;
            }
        }
    </style>
@endsection

@section('content')
<div class="page-content container-fluid">
    <h1 class="page-title">
        <i class="voyager-dashboard"></i> Customer Feedback Report
    </h1>
    
    <div class="chart-row">
        <div class="chart-col">
            <div class="chart-card">
                <div class="chart-title">กราฟลูกค้าตามช่วงอายุ</div>
                <div class="chart-container" id="ageChart"></div>
            </div>
        </div>
        <div class="chart-col">
            <div class="chart-card">
                <div class="chart-title">สัดส่วนลูกค้าตามเพศ</div>
                <div class="chart-container" id="genderChart"></div>
            </div>
        </div>
        <div class="chart-col">
            <div class="chart-card">
                <div class="chart-title">การกระจายตามอาชีพ</div>
                <div class="chart-container" id="occupationChart"></div>
            </div>
        </div>
        <div class="chart-col">
            <div class="chart-card">
                <div class="chart-title">การกระจายตามรายได้</div>
                <div class="chart-container" id="incomeChart"></div>
            </div>
        </div>
        <div class="chart-col">
            <div class="chart-card">
                <div class="chart-title">ความคิดเห็น</div>
                <div class="chart-container" id="feedbackChart"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Age Distribution Chart
            Highcharts.chart('ageChart', {
                chart: {
                    type: 'column',
                    marginBottom: 80,
                    spacingBottom: 30
                },
                title: {
                    text: null
                },
                xAxis: {
                    categories: @json($ageGroups['labels']),
                    crosshair: true,
                    labels: {
                        rotation: 0,
                        style: {
                            fontSize: '12px',
                            textOverflow: 'none',
                            width: 'auto'
                        },
                        y: 30,
                        autoRotation: false,
                        reserveSpace: true
                    },
                    tickLength: 5,
                    lineWidth: 1,
                    offset: 5,
                    visible: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'จำนวนคน'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y} คน</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        colorByPoint: true,
                        colors: ['#4285F4', '#34A853', '#FBBC05', '#EA4335']
                    }
                },
                series: [{
                    name: 'ช่วงอายุ',
                    data: @json($ageGroups['data']),
                    showInLegend: false
                }],
                credits: {
                    enabled: false
                }
            });
            
            // Gender Distribution Chart
            Highcharts.chart('genderChart', {
                chart: {
                    type: 'pie',
                    marginBottom: 30
                },
                title: {
                    text: null
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        colors: ['#FF69B4', '#4285F4'],
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'เพศ',
                    colorByPoint: true,
                    data: @json($genderDistribution['labels']).map((label, index) => ({
                        name: label,
                        y: @json($genderDistribution['data'])[index]
                    }))
                }],
                credits: {
                    enabled: false
                }
            });
            
            // Occupation Distribution Chart
            Highcharts.chart('occupationChart', {
                chart: {
                    type: 'bar',
                    marginLeft: 120,
                    spacingLeft: 20
                },
                title: {
                    text: null
                },
                xAxis: {
                    categories: @json($occupationDistribution['labels']),
                    title: {
                        text: null
                    },
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'จำนวนคน',
                        align: 'high'
                    }
                },
                tooltip: {
                    pointFormat: '<b>{point.y} คน</b>'
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        },
                        colorByPoint: true,
                        pointWidth: 20
                    }
                },
                series: [{
                    name: 'อาชีพ',
                    data: @json($occupationDistribution['data']),
                    showInLegend: false
                }],
                credits: {
                    enabled: false
                }
            });
            
            // Income Distribution Chart
            Highcharts.chart('incomeChart', {
                chart: {
                    type: 'pie',
                    marginBottom: 30
                },
                title: {
                    text: null
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        innerSize: '60%',
                        depth: 45,
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'รายได้',
                    colorByPoint: true,
                    data: @json($incomeDistribution['labels']).map((label, index) => ({
                        name: label,
                        y: @json($incomeDistribution['data'])[index]
                    }))
                }],
                credits: {
                    enabled: false
                }
            });
            
            // Feedback Distribution Chart
            Highcharts.chart('feedbackChart', {
                chart: {
                    type: 'pie',
                    marginBottom: 30
                },
                title: {
                    text: null
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        colors: ['#34A853', '#EA4335'],
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'ความคิดเห็น',
                    colorByPoint: true,
                    data: @json($feedbackDistribution['labels']).map((label, index) => ({
                        name: label,
                        y: @json($feedbackDistribution['data'])[index]
                    }))
                }],
                credits: {
                    enabled: false
                }
            });
        });
    </script>
@endsection