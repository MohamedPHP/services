@extends('admin.layouts.app')




@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2>Edit User Page</h2>
        </div>
    </div>
    <hr>
    @include('admin.layouts.messages')
    <div class="row" style="border-left: 3px solid #3c763d; padding: 15px;">
        <div class="col-md-12" style="margin: 0 0 20px 0">
            <div class="page-header">
              <h3>User Balance Informations</h3>
            </div>
            <div class="panel panel-primary">
                <!-- Default panel contents -->
                <div class="panel-heading">Service Owner</div>
                <div class="panel-body">
                    <p>Service Owner Balance Informations <a href="{{ url('/') . '#!/User/'  . $user->id . '/' . $user->name }}" class="btn-link"><i class="fa fa-user"></i> {{ $user->name }}</a></p>
                </div>

                <!-- Table -->
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>Balance</th>
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
                        $profits      = \App\Payment::where('receiver_id', Auth::user()->id)->where('isfinished', 1)->sum('price') > 0 ? \App\Payment::where('receiver_id', Auth::user()->id)->where('isfinished', 1)->sum('price') : 0;
                        // الارباح الي انا بعت طلب اني اخدها
                        $gotProfits   = \App\Profit::where('user_id', Auth::user()->id)->sum('price') > 0  ? \App\Profit::where('user_id', Auth::user()->id)->sum('price') : 0;
                        // الارباح الي انا بعت طلب و مستني تتوافق
                        $waitProfits  = \App\Profit::where('user_id', Auth::user()->id)->where('status', 0)->sum('price') > 0  ? \App\Profit::where('user_id', Auth::user()->id)->where('status', 0)->sum('price') : 0;
                        // الارباح الي انا بعت طلب علشان اخدها و اتوافقت
                        $doneProfits  = \App\Profit::where('user_id', Auth::user()->id)->where('status', 1)->sum('price') > 0  ? \App\Profit::where('user_id', Auth::user()->id)->where('status', 1)->sum('price') : 0;
                        // المدفوعات
                        $payments     = \App\Payment::where('user_id', Auth::user()->id)->where('isfinished', '!=', 2)->sum('price') > 0 ? \App\Payment::where('user_id', Auth::user()->id)->where('isfinished', '!=', 2)->sum('price') : 0;
                        // اجمالي عمليات الشحن
                        $charges      = \App\Paypal::where('user_id', Auth::user()->id)->sum('price') > 0 ? \App\Paypal::where('user_id', Auth::user()->id)->sum('price') : 0;
                        @endphp
                        <tr>
                            <td>{{ ($charges - $payments) + ($profits - $gotProfits) }}$</td>
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
        <div class="col-md-12" style="margin: 0 0 20px 0">
            <div class="page-header">
              <h3>Edit User Informations</h3>
            </div>
            <form action="{{ route('user.update', ['user_id' => $user->id]) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="please add user name..." value="{{ old('name') !== null ? old('name') : $user->name}}" required>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="please add user email..." value="{{ old('email') !== null ? old('email') : $user->email}}" required>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    @if ($user->image != '')
                        <br>
                        <img class="img-rounded img-thumbnail" src="{{ asset($user->image) }}" alt="{{$user->image}}" style="width: 300px;height: 250px;">
                    @endif
                </div>

                <div class="form-group{{ $errors->has('admin') ? ' has-error' : '' }}">
                    <label for="admin">Permisions</label>
                    <select class="form-control" name="admin">
                        <option value="0" {{ $user->admin == 0 ? 'selected' : '' }} >User</option>
                        <option value="1" {{ $user->admin == 1 ? 'selected' : '' }} >Admin</option>
                    </select>
                    @if ($errors->has('admin'))
                        <span class="help-block">
                            <strong>{{ $errors->first('admin') }}</strong>
                        </span>
                    @endif
                </div>


                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
        <div class="col-md-12" style="margin: 0 0 20px 0">
            <div class="page-header">
              <h3>Latest 5 Incoming Orders <small>Of The User {{ $user->name }} <a class="btn btn-link" href="{{ url('/admincp/orders', ['sort' => 'UserIOrders']) }}?user_id={{$user->id}}">View All</a></small></h3>
            </div>
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
                    @foreach ($ordersI as $order)
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
        </div>
        <div class="col-md-12" style="margin: 0 0 20px 0">
            <div class="page-header">
              <h3>Latest 5 Purchase Orders <small>Of The User {{ $user->name }} <a class="btn btn-link" href="{{ url('/admincp/orders', ['sort' => 'UserPOrders']) }}?user_order={{$user->id}}">View All</a></small></h3>
            </div>
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
                    @foreach ($ordersP as $order)
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
        </div>
        <div class="col-md-12" style="margin: 0 0 20px 0">
            <div class="page-header">
              <h3>Latest 5 Services <small>Of The User {{ $user->name }}</small></h3>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>name</th>
                        <th>price</th>
                        <th>status</th>
                        <th>user_id</th>
                        <th>Created At</th>
                        <th>Orders Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)
                    <tr class="service">
                        {{-- #!/ServiceDetails/22/Luffy%20des%205 --}}
                        <td><a href="{{ url('/') . '#!/ServiceDetails/'  . $service->id . '/' . $service->name}}">{{ $service->name }}</a></td>
                        <td>{{ $service->price }}$</td>
                        <td>
                            @if ($service->status == 0)
                                <span class="label label-info">Wating <i class="fa fa-clock-o"></i></span>
                            @elseif ($service->status == 1)
                                <span class="label label-success">Accepted <i class="fa fa-star"></i></span>
                            @elseif ($service->status == 2)
                                <span class="label label-danger">Rejected <i class="fa fa-ban"></i></span>
                            @endif
                        </td>
                        <td><a href="{{ url('/') . '#!/User/'  . $service->user->id . '/' . $service->user->name}}" class="btn-link">{{ $service->user->name }}</a></td>
                        <td>{{ $service->created_at->format('D-M-Y') }}</td>
                        <td><a href="{{ route('getServiceOrders', ['service_id' => $service->id]) }}">{{ $service->orders_count }}</a></td>
                        <td>
                            <a href="{{ route('service.edit', ['id' => $service->id]) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                            @if ($service->status == 0)
                                <a href="{{ route('service.accept', ['id' => $service->id]) }}" class="btn btn-info confirmed"><i class="fa fa-unlock"></i></a>
                                <a href="{{ route('service.reject', ['id' => $service->id]) }}" class="btn btn-warning confirmed"><i class="fa fa-lock"></i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
