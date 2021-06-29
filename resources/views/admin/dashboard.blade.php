@extends('layouts.backend.app')

@section('title', 'Dashboard')

@push('css')
    
@endpush

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>DASHBOARD</h2>
    </div>

    <!-- Widgets -->
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-green hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">attach_money</i>
                </div>
                <div class="content">
                    <div class="text">CASH</div>
                    <div class="number">{{ number_format(round($cash, 2), 2) }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-teal hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">TOTAL PENDING</div>
                    <div class="number">{{ number_format(round($totalPending, 2), 2) }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">playlist_add_check</i>
                </div>
                <div class="content">
                    <div class="text">TOTAL CREDIT</div>
                    <div class="number">{{ number_format(round($totalCredit, 2), 2) }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-purple hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">fiber_new</i>
                </div>
                <div class="content">
                    <div class="text">TODAY&apos;S SALES</div>
                    <div class="number">{{ number_format(round($todaySales, 2), 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    {{--  <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>SALES CHART</h2>
                </div>
                <div class="body">
                    <canvas id="myChart" width="400" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>  --}}
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>SALES & PROFIT CHART of YEAR "{{ now()->year }}"</h2>
                </div>
                <div class="body">
                    {{--  <canvas id="line_chart" width="400" height="116"></canvas>  --}}
                    <canvas id="line_chart" height="85"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    
<!-- ChartJs -->
    <script src="{{ asset('assets/backend/plugins/chartjs/Chart.bundle.js') }}"></script>
    {{--  <script src="{{ asset('assets/backend/js/pages/charts/chartjs.js') }}"></script>  --}}
    
<!-- This Chart is for canvas id="myChart"  -->
    <script>
        
        /*var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });*/

<!-- Create Sales & Profit Chart from ajax request  -->
    
        $(function (){
            getData();  // get things started when the DOM is ready
        });
        
        function getData() {
            $.ajax({
                url: "{{route('admin.dashboard.chart')}}",
                type: "GET",
                cache: false,
                success: function(response)
                {
                    createChart(response);  // call createChart function, passing the response to it
                }
            });
        }
        
        // createChart receives the response, and uses it for the chart data
        function createChart(data) {
            var chartData = data;           
            var ctx = document.getElementById('line_chart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    //labels: ["January", "February", "March", "April", "May", "June", "July", 
                                //"August", "September", "October", "November", "December"],                                        
                    labels: chartData.months, // The chartData got from the ajax response containing all month names in the database
                    datasets: [{
                        label: "Sales", // The chartData got from the ajax response containing data for the total sales in the corresponding months
                        //data: [65, 59, 80, 81, 56, 55, 40],
                        data: chartData.sales_data,
                        borderColor: 'rgba(0, 188, 212, 0.75)',
                        backgroundColor: 'rgba(0, 188, 212, 0.3)',
                        pointBorderColor: 'rgba(0, 188, 212, 0)',
                        pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                        pointBorderWidth: 1
                    }, {
                            label: "Profit",
                            //data: [28, 48, 40, 19, 86, 27, 90],
                            data: chartData.profit_data, // The chartData got from the ajax response containing data for the total profit in the corresponding months
                            borderColor: 'rgba(233, 30, 99, 0.75)',
                            backgroundColor: 'rgba(233, 30, 99, 0.3)',
                            pointBorderColor: 'rgba(233, 30, 99, 0)',
                            pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
                            pointBorderWidth: 1
                        }]
                },
                options: {
                    responsive: true,
                    //legend: false
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
                 
    </script>

@endpush