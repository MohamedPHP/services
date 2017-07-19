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
            <form class="form-inline" action="{{ route('changestatus.admin') }}" method="post">
                {{ csrf_field() }}
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary confirmed">Change Status</button>
                </div>
                <div class="form-group">
                    <select class="form-control" name="status">
                        <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>Wating</option>
                        <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Seen</option>
                        <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Accepted</option>
                        <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>Rejected</option>
                        <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>Done</option>
                    </select>
                </div>
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="user_id" value="{{ $order->userThatRequestTheService->id }}">
                <input type="hidden" name="receiver_id" value="{{ $order->getServiceOwner->id }}">
            </form>
            <br>
            <div class="alert alert-info"><strong>! Important !</strong> When You Change the status of the order the profits of sernder and the receiver will be effected also so <strong>Take care</strong></div>
            <hr>
            <div class="row">
                <div class="col-md-6">
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
                                    <th>Profits</th>
                                    <th>Charges</th>
                                    <th>Payments</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ (\App\Paypal::where('user_id', $order->getServiceOwner->id)->sum('price') + \App\Payment::where('receiver_id', $order->getServiceOwner->id)->where('isfinished', 1)->sum('price')) - \App\Payment::where('user_id', $order->getServiceOwner->id)->where('isfinished', '!=', 2)->sum('price') }}$</td>
                                    <td>{{ \App\Payment::where('receiver_id', $order->getServiceOwner->id)->where('isfinished', 1)->sum('price') > 0 ? \App\Payment::where('receiver_id', $order->getServiceOwner->id)->where('isfinished', 1)->sum('price') : 0 }}$</td>
                                    <td>{{ \App\Paypal::where('user_id', $order->getServiceOwner->id)->sum('price') > 0 ? \App\Paypal::where('user_id', $order->getServiceOwner->id)->sum('price') : 0 }}$</td>
                                    <td>{{ \App\Payment::where('user_id', $order->getServiceOwner->id)->where('isfinished', '!=', 2)->sum('price') > 0 ? \App\Payment::where('user_id', $order->getServiceOwner->id)->where('isfinished', '!=', 2)->sum('price') : 0 }}$</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
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
                                    <th>Profits</th>
                                    <th>Charges</th>
                                    <th>Payments</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ (\App\Paypal::where('user_id', $order->userThatRequestTheService->id)->sum('price') + \App\Payment::where('receiver_id', $order->userThatRequestTheService->id)->where('isfinished', 1)->sum('price')) - \App\Payment::where('user_id', $order->userThatRequestTheService->id)->where('isfinished', '!=', 2)->sum('price') }}$</td>
                                    <td>{{ \App\Payment::where('receiver_id', $order->userThatRequestTheService->id)->where('isfinished', 1)->sum('price') > 0 ? \App\Payment::where('receiver_id', $order->userThatRequestTheService->id)->where('isfinished', 1)->sum('price') : 0 }}$</td>
                                    <td>{{ \App\Paypal::where('user_id', $order->userThatRequestTheService->id)->sum('price') > 0 ? \App\Paypal::where('user_id', $order->userThatRequestTheService->id)->sum('price') : 0 }}$</td>
                                    <td>{{ \App\Payment::where('user_id', $order->userThatRequestTheService->id)->where('isfinished', '!=', 2)->sum('price') > 0 ? \App\Payment::where('user_id', $order->userThatRequestTheService->id)->where('isfinished', '!=', 2)->sum('price') : 0 }}$</td>
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
                <br>
                <div class="col-md-12">
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
