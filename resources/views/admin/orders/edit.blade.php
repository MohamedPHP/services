@extends('admin.layouts.app')




@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
              <h2> Order No {{ '#' . $order->id }}
                  <small>
                      @if ($order->status == 0)
                          <span class="label label-default">
                              Wating..
                          </span>
                      @elseif ($order->status == 1)
                          <span class="label label-info">
                              Seen..
                          </span>
                      @elseif ($order->status == 2)
                          <span class="label label-success">
                              Accepted
                          </span>
                      @elseif ($order->status == 3)
                          <span class="label label-danger">
                              Rejected
                          </span>
                      @elseif ($order->status == 4)
                          <span class="label label-primary">
                              Done
                          </span>
                      @endif
                  </small>
              </h2>
            </div>
        </div>
    </div>
    <hr>
    <div class="row" style="border-left: 3px solid #3c763d; padding: 15px;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <!-- Default panel contents -->
                        <div class="panel-heading">Service Owner</div>
                        <div class="panel-body">
                            <p>Service Owner Balance Informations <a href="{{ url('/') . '#!/User/'  . $order->getServiceOwner->id . '/' . $order->getServiceOwner->name }}" class="btn-link"><i class="fa fa-user"></i> {{ $order->getServiceOwner->name }}</a></p>
                        </div>

                        <!-- Table -->
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Balance</th>
                                    <th>All Profits</th>
                                    <th>Profits</th>
                                    <th>Wating Withdraw</th>
                                    <th>Done Withdraw</th>
                                    <th>Charges</th>
                                    <th>Payments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                // كل الارباح الي انا كسبتها من بيع الخدمات
                                $profits      = \App\Payment::where('receiver_id', $order->getServiceOwner->id)->where('isfinished', 1)->sum('price') > 0 ? \App\Payment::where('receiver_id', $order->getServiceOwner->id)->where('isfinished', 1)->sum('price') : 0;
                                // الارباح الي انا بعت طلب اني اخدها
                                $gotProfits   = \App\Profit::where('user_id', $order->getServiceOwner->id)->sum('price') > 0  ? \App\Profit::where('user_id', $order->getServiceOwner->id)->sum('price') : 0;
                                // الارباح الي انا بعت طلب و مستني تتوافق
                                $waitProfits  = \App\Profit::where('user_id', $order->getServiceOwner->id)->where('status', 0)->sum('price') > 0  ? \App\Profit::where('user_id', $order->getServiceOwner->id)->where('status', 0)->sum('price') : 0;
                                // الارباح الي انا بعت طلب علشان اخدها و اتوافقت
                                $doneProfits  = \App\Profit::where('user_id', $order->getServiceOwner->id)->where('status', 1)->sum('price') > 0  ? \App\Profit::where('user_id', $order->getServiceOwner->id)->where('status', 1)->sum('price') : 0;
                                // المدفوعات
                                $payments     = \App\Payment::where('user_id', $order->getServiceOwner->id)->where('isfinished', '!=', 2)->sum('price') > 0 ? \App\Payment::where('user_id', $order->getServiceOwner->id)->where('isfinished', '!=', 2)->sum('price') : 0;
                                // اجمالي عمليات الشحن
                                $charges      = \App\Paypal::where('user_id', $order->getServiceOwner->id)->sum('price') > 0 ? \App\Paypal::where('user_id', $order->getServiceOwner->id)->sum('price') : 0;
                                @endphp
                                <tr>
                                    <td>{{ ($charges - $payments) + ($profits - $gotProfits) }}$</td>
                                    <td>{{ ($profits) }}$</td>
                                    <td>{{ ($profits - $gotProfits) }}$</td>
                                    <td>{{ $waitProfits }}$</td>
                                    <td>{{ $doneProfits }}$</td>
                                    <td>{{ $charges }}$</td>
                                    <td>{{ $payments }}$</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <!-- Default panel contents -->
                        <div class="panel-heading">Service Requester</div>
                        <div class="panel-body">
                            <p>Service Requester Balance Informations <a href="{{ url('/') . '#!/User/'  . $order->userThatRequestTheService->id . '/' . $order->userThatRequestTheService->name }}" class="btn-link"><i class="fa fa-user"></i> {{ $order->userThatRequestTheService->name }}</a></p>
                        </div>

                        <!-- Table -->
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Balance</th>
                                    <th>All Profits</th>
                                    <th>Profits</th>
                                    <th>Wating Withdraw</th>
                                    <th>Done Withdraw</th>
                                    <th>Charges</th>
                                    <th>Payments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                // كل الارباح الي انا كسبتها من بيع الخدمات
                                $profitsUserOrder      = \App\Payment::where('receiver_id', $order->userThatRequestTheService->id)->where('isfinished', 1)->sum('price') > 0 ? \App\Payment::where('receiver_id', $order->userThatRequestTheService->id)->where('isfinished', 1)->sum('price') : 0;
                                // الارباح الي انا بعت طلب اني اخدها
                                $gotProfitsUserOrder   = \App\Profit::where('user_id', $order->userThatRequestTheService->id)->sum('price') > 0  ? \App\Profit::where('user_id', $order->userThatRequestTheService->id)->sum('price') : 0;
                                // الارباح الي انا بعت طلب و مستني تتوافق
                                $waitProfitsUserOrder  = \App\Profit::where('user_id', $order->userThatRequestTheService->id)->where('status', 0)->sum('price') > 0  ? \App\Profit::where('user_id', $order->userThatRequestTheService->id)->where('status', 0)->sum('price') : 0;
                                // الارباح الي انا بعت طلب علشان اخدها و اتوافقت
                                $doneProfitsUserOrder  = \App\Profit::where('user_id', $order->userThatRequestTheService->id)->where('status', 1)->sum('price') > 0  ? \App\Profit::where('user_id', $order->userThatRequestTheService->id)->where('status', 1)->sum('price') : 0;
                                // المدفوعات
                                $paymentsUserOrder     = \App\Payment::where('user_id', $order->userThatRequestTheService->id)->where('isfinished', '!=', 2)->sum('price') > 0 ? \App\Payment::where('user_id', $order->userThatRequestTheService->id)->where('isfinished', '!=', 2)->sum('price') : 0;
                                // اجمالي عمليات الشحن
                                $chargesUserOrder      = \App\Paypal::where('user_id', $order->userThatRequestTheService->id)->sum('price') > 0 ? \App\Paypal::where('user_id', $order->userThatRequestTheService->id)->sum('price') : 0;
                                @endphp
                                <tr>
                                    <td>{{ ($chargesUserOrder - $paymentsUserOrder) + ($profitsUserOrder - $gotProfitsUserOrder) }}$</td>
                                    <td>{{ ($profitsUserOrder) }}$</td>
                                    <td>{{ ($profitsUserOrder - $gotProfitsUserOrder) }}$</td>
                                    <td>{{ $waitProfitsUserOrder }}$</td>
                                    <td>{{ $doneProfitsUserOrder }}$</td>
                                    <td>{{ $chargesUserOrder }}$</td>
                                    <td>{{ $paymentsUserOrder }}$</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h3>{{ $service->name }}</h3>
                    <span class="label label-default" style="font-size:15px;"><i class="fa fa-users" aria-hidden="true"></i> voters {{ $service->votes_count }}</span>
                    <span class="label label-primary" style="font-size:15px;"><i class="fa fa-star" aria-hidden="true"></i> stars {{ $service->sum }}</span>
                    <span class="label label-info" style="font-size:15px;">percentage {{ $service->sum != 0 ? ($service->sum * 100) / ($service->votes_count * 5) : 0 }} %</span>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{asset($service->image)}}" style="width: 300px;height: 250px;display:inline-block;" class="img-rounded img-thumbnail" >
                        </div>
                        <div class="col-md-8">
                            <p style="line-height: 1.5; color:#777;white-space: pre-line; display:inline-block;">{{$service->dis}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <a href="{{ route('service.edit', ['id' => $service->id]) }}" class="btn btn-success">Edit Service</a>
                    <a href="{{ url('/') . '#!/ServiceDetails/'  . $service->id . '/' . $service->name}}" class="btn btn-info">View In Frontend</a>
                </div>
                <div class="col-md-12" style="margin-top: 20px;">
                    <h4 class="text-muted text-left">Service Comments</h4>
                    <hr>
                    @foreach ($order->comments as $c)
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-md-3" style="border-left: 3px solid #223366;">
                                    @php
                                        $user = \App\User::find($c->user_id);
                                    @endphp
                                    <a href="{{ url('/') . '#!/User/'  . $user->id . '/' . $user->name }}" class="btn-link"><i class="fa fa-user"></i> {{ $user->name }}</a>
                                    <br>
                                    <br>
                                    <i class="fa fa-clock-o"></i> {{ $c->created_at->format('d-M-Y h:i') }}
                                </div>
                                <div class="col-md-9" style="border-left: 3px solid #3c763d;">
                                    {{$c->comment}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <br><br>
@endsection
