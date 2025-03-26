@extends('voyager::master')

@section('css')
    <style>
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
            margin-bottom: 30px;
        }
        .chart-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }
        .chart-col {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 15px;
            margin-bottom: 30px;
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
        canvas {
            max-height: 350px;
            width: 100% !important;
            height: 350px !important;
        }
        @media (max-width: 768px) {
            .chart-col {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
@endsection

@section('content')
<div class="page-content container-fluid">
    <h1 class="page-title">
        <i class="voyager-bar-chart"></i> รายงานข้อมูลจาก Online Foods CSV
    </h1>
    
    <div class="chart-row">
        <div class="chart-col">
            <div class="chart-card">
                <div class="chart-title">การกระจายตามช่วงอายุ</div>
                <div class="chart-container">
                    <canvas id="ageChart"></canvas>
                </div>
            </div>
        </div>
        <div class="chart-col">
            <div class="chart-card">
                <div class="chart-title">การกระจายตามเพศ</div>
                <div class="chart-container">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>
        <div class="chart-col">
            <div class="chart-card">
                <div class="chart-title">การกระจายตามอาชีพ</div>
                <div class="chart-container">
                    <canvas id="occupationChart"></canvas>
                </div>
            </div>
        </div>
        <div class="chart-col">
            <div class="chart-card">
                <div class="chart-title">การกระจายตามรายได้</div>
                <div class="chart-container">
                    <canvas id="incomeChart"></canvas>
                </div>
            </div>
        </div>
        <div class="chart-col">
            <div class="chart-card">
                <div class="chart-title">ความคิดเห็น</div>
                <div class="chart-container">
                    <canvas id="feedbackChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ตั้งค่าทั่วไปสำหรับ Chart.js
            Chart.defaults.font.family = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif';
            Chart.defaults.responsive = true;
            Chart.defaults.maintainAspectRatio = false;
            
            // Age Distribution Chart
            const ageCtx = document.getElementById('ageChart').getContext('2d');
            new Chart(ageCtx, {
                type: 'bar',
                data: {
                    labels: @json($ageGroups['labels']),
                    datasets: [{
                        label: 'จำนวนคนตามช่วงอายุ',
                        data: @json($ageGroups['data']),
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(255, 159, 64, 0.6)',
                            'rgba(153, 102, 255, 0.6)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            
            // Gender Distribution Chart
            const genderCtx = document.getElementById('genderChart').getContext('2d');
            new Chart(genderCtx, {
                type: 'pie',
                data: {
                    labels: @json($genderDistribution['labels']),
                    datasets: [{
                        data: @json($genderDistribution['data']),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
            
            // Occupation Distribution Chart
            const occupationCtx = document.getElementById('occupationChart').getContext('2d');
            new Chart(occupationCtx, {
                type: 'bar',
                data: {
                    labels: @json($occupationDistribution['labels']),
                    datasets: [{
                        label: 'จำนวนคนตามอาชีพ',
                        data: @json($occupationDistribution['data']),
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            
            // Income Distribution Chart
            const incomeCtx = document.getElementById('incomeChart').getContext('2d');
            new Chart(incomeCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($incomeDistribution['labels']),
                    datasets: [{
                        data: @json($incomeDistribution['data']),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
            
            // Feedback Distribution Chart
            const feedbackCtx = document.getElementById('feedbackChart').getContext('2d');
            new Chart(feedbackCtx, {
                type: 'pie',
                data: {
                    labels: @json($feedbackDistribution['labels']),
                    datasets: [{
                        data: @json($feedbackDistribution['data']),
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(255, 99, 132, 0.6)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>
@endsection 