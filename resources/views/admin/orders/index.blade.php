@extends('admin.layouts.app')




@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2>Orders Page</h2>
        </div>
    </div>
    <hr>
    <div class="row" style="border-left: 3px solid #3c763d; box-shadow: 1px 1px 3px #777;">
        <div class="col-md-12" style="margin: 0 0 15px 0;">
            @if (Route::current()->getName() == 'order.index')
                <div class="btn-group" style="margin-top: 15px;">
                    <a class="btn btn-primary" href="{{ url('/admincp/orders', ['sort' => '']) }}">Reset Sorting</a>
                    <a class="btn btn-default" href="{{ url('/admincp/orders', ['sort' => 'byDone']) }}">Done Orders</a>
                    <a class="btn btn-default" href="{{ url('/admincp/orders', ['sort' => 'byAccepted']) }}">Accepted</a>
                    <a class="btn btn-default" href="{{ url('/admincp/orders', ['sort' => 'byWating']) }}">Wating</a>
                    <a class="btn btn-default" href="{{ url('/admincp/orders', ['sort' => 'bySeen']) }}">Seen</a>
                    <a class="btn btn-default" href="{{ url('/admincp/orders', ['sort' => 'byRejected']) }}">Rejected</a>
                    <a class="btn btn-default" href="{{ url('/admincp/orders', ['sort' => 'byAddDateASC']) }}">DateASC</a>
                    <a class="btn btn-default" href="{{ url('/admincp/orders', ['sort' => 'byAddDateDESC']) }}">DateDESC</a>
                </div>
            @elseif (Route::current()->getName() == 'getServiceOrders')
                <div class="btn-group" style="margin-top: 15px;">
                    <a class="btn btn-primary" href="{{ url('/admincp/order/getServiceOrders', ['service_id' => Request::segment(4), 'sort' => '']) }}">Reset Sorting</a>
                    <a class="btn btn-default" href="{{ url('/admincp/order/getServiceOrders', ['service_id' => Request::segment(4), 'sort' => 'byDone']) }}">Done Orders</a>
                    <a class="btn btn-default" href="{{ url('/admincp/order/getServiceOrders', ['service_id' => Request::segment(4), 'sort' => 'byAccepted']) }}">Accepted</a>
                    <a class="btn btn-default" href="{{ url('/admincp/order/getServiceOrders', ['service_id' => Request::segment(4), 'sort' => 'byWating']) }}">Wating</a>
                    <a class="btn btn-default" href="{{ url('/admincp/order/getServiceOrders', ['service_id' => Request::segment(4), 'sort' => 'bySeen']) }}">Seen</a>
                    <a class="btn btn-default" href="{{ url('/admincp/order/getServiceOrders', ['service_id' => Request::segment(4), 'sort' => 'byRejected']) }}">Rejected</a>
                    <a class="btn btn-default" href="{{ url('/admincp/order/getServiceOrders', ['service_id' => Request::segment(4), 'sort' => 'byAddDateASC']) }}">DateASC</a>
                    <a class="btn btn-default" href="{{ url('/admincp/order/getServiceOrders', ['service_id' => Request::segment(4), 'sort' => 'byAddDateDESC']) }}">DateDESC</a>
                </div>
            @endif
        </div>
        <div class="col-md-12">
            @include('admin.layouts.messages')
        </div>
        <div class="col-md-12">
            {{-- `name`, `dis`, `image`, `price`, `views`, `status`, `cat_id`, `user_id` --}}
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Service Name</th>
                        <th>Service Owner</th>
                        <th>Service Requester</th>
                        <th>Order Date</th>
                        <th>Order Status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td><a href="{{ url('/') . '#!/ServiceDetails/'  . $order->service->id . '/' . $order->service->name}}">{{ $order->service->name }}</a></td>
                            <td><a href="{{ url('/') . '#!/User/'  . $order->getServiceOwner->id . '/' . $order->getServiceOwner->name }}" class="btn-link"><i class="fa fa-user"></i> {{ $order->getServiceOwner->name }}</a></td>
                            <td><a href="{{ url('/') . '#!/User/'  . $order->userThatRequestTheService->id . '/' . $order->userThatRequestTheService->name }}" class="btn-link"><i class="fa fa-user"></i> {{ $order->userThatRequestTheService->name }}</a></td>
                            <td><i class="fa fa-clock-o"></i> {{ $order->created_at->format('D-M-Y') }}</td>
                            <td>
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
                            </td>
                            <td>
                                <a href="{{ route('order.view', ['id' => $order->id]) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Pagination Code --}}
           <div class="text-center">
               {{ $orders->appends(Request::except('page'))->render() }}
           </div>
        </div>
    </div>
    <br><br>
@endsection
