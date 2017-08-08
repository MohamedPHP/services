@extends('admin.layouts.app')




@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2>PageTitle</h2>
        </div>
    </div>
    <hr>
    {{-- users
services
allOrders
todayOrders
siteProfits
paymentsToday --}}
    <div class="row" style="border-left: 3px solid #3c763d; padding: 15px;">
        <div class="col-lg-2 col-sm-6">
            <div class="circle-tile">
                <a href="#">
                    <div class="circle-tile-heading dark-blue">
                        <i class="fa fa-users fa-fw fa-3x"></i>
                    </div>
                </a>
                <div class="circle-tile-content dark-blue">
                    <div class="circle-tile-description text-faded">
                        Users
                    </div>
                    <div class="circle-tile-number text-faded">
                        {{ $users }}
                        <span id="sparklineA"></span>
                    </div>
                    <a href="{{ url('admincp/users') }}" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="circle-tile">
                <a href="#">
                    <div class="circle-tile-heading green">
                        <i class="fa fa-money fa-fw fa-3x"></i>
                    </div>
                </a>
                <div class="circle-tile-content green">
                    <div class="circle-tile-description text-faded">
                        Site Profits
                    </div>
                    <div class="circle-tile-number text-faded">
                        {{ $siteProfits }} $
                    </div>
                    <a href="#" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="circle-tile">
                <a href="#">
                    <div class="circle-tile-heading blue">
                        <i class="fa fa-dollar fa-fw fa-3x"></i>
                    </div>
                </a>
                <div class="circle-tile-content blue">
                    <div class="circle-tile-description text-faded">
                        Payments Today
                    </div>
                    <div class="circle-tile-number text-faded">
                        {{ $paymentsToday }}
                    </div>
                    <a href="#" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="circle-tile">
                <a href="#">
                    <div class="circle-tile-heading blue">
                        <i class="fa fa-tasks fa-fw fa-3x"></i>
                    </div>
                </a>
                <div class="circle-tile-content blue">
                    <div class="circle-tile-description text-faded">
                        Services
                    </div>
                    <div class="circle-tile-number text-faded">
                        {{ $services }}
                        <span id="sparklineB"></span>
                    </div>
                    <a href="{{ url('admincp/services') }}" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="circle-tile">
                <a href="#">
                    <div class="circle-tile-heading red">
                        <i class="fa fa-shopping-cart fa-fw fa-3x"></i>
                    </div>
                </a>
                <div class="circle-tile-content red">
                    <div class="circle-tile-description text-faded">
                        Orders
                    </div>
                    <div class="circle-tile-number text-faded">
                        {{ $allOrders }}
                        <span id="sparklineC"></span>
                    </div>
                    <a href="{{ url('admincp/orders') }}" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6">
            <div class="circle-tile">
                <a href="#">
                    <div class="circle-tile-heading purple">
                        <i class="fa fa-crosshairs fa-fw fa-3x"></i>
                    </div>
                </a>
                <div class="circle-tile-content purple">
                    <div class="circle-tile-description text-faded">
                        Today Orders
                    </div>
                    <div class="circle-tile-number text-faded">
                        {{ $todayOrders }}
                        <span id="sparklineD"></span>
                    </div>
                    <a href="#" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="border-left: 3px solid #3c763d; padding: 15px;">
        <h3 class="text-success text-center">Chart</h3>
        <hr>
        <canvas id="myChart" height="100"></canvas>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('admin/js/chart.js') }}"></script>
    <script type="text/javascript">
    // console.log({{ $chartServices }});
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July", "August","September", "October", "November", "December"],
            datasets: [{
                label: "Number of services at month",
                backgroundColor: 'rgba(41, 128, 185, 0.79)',
                borderColor: 'rgba(41, 128, 185, 0);',
                data: [
                    @foreach ($chartServices as $chart)
                        {{ $chart['counting'] }},
                    @endforeach
                ],
            }],
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true,
                        stepSize: 2,
                    }
                }]
            }
        }
    });
    </script>
@endsection
