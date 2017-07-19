@extends('admin.layouts.app')




@section('content')
    <div class="row">
        <div class="col-md-6">
            <h2>Services ( {{ $servicesCount }} )</h2>
        </div>
        <div class="col-md-6">
            <div style="margin-top: 25px;">
                <form action="{{ url('/admincp') }}" method="get">
                    <div class="col-md-12">
                        <input type="text" value="{{ Request::get('q') }}" name="q" class="form-control" placeholder="Search... Hit Enter">
                    </div>
                </form>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <hr>

    <div class="row" style="border-left: 3px solid #3c763d; box-shadow: 1px 1px 3px #777;">
        <div class="col-md-12" style="">
            <div class="btn-group" style="margin-top: 15px;">
                <a class="btn btn-primary" href="{{ url('/admincp/services', ['sort' => '']) }}">Reset Sorting</a>
                <a class="btn btn-default" href="{{ url('/admincp/services', ['sort' => 'byAccepted']) }}">By Accepted</a>
                <a class="btn btn-default" href="{{ url('/admincp/services', ['sort' => 'byWating']) }}">By Wating</a>
                <a class="btn btn-default" href="{{ url('/admincp/services', ['sort' => 'byAddDateASC']) }}">Date ASC</a>
                <a class="btn btn-default" href="{{ url('/admincp/services', ['sort' => 'byAddDateDESC']) }}">Date DESC</a>
                <a class="btn btn-default" href="{{ url('/admincp/services', ['sort' => 'byRating']) }}">By Rating</a>
                <a class="btn btn-default" href="{{ url('/admincp/services', ['sort' => 'byViewes']) }}">By Viewes</a>
                <a class="btn btn-default" href="{{ url('/admincp/services', ['sort' => 'byPriceHighToLow']) }}">High To Low</a>
                <a class="btn btn-default" href="{{ url('/admincp/services', ['sort' => 'byPriceLowToHigh']) }}">Low To High</a>
                <a class="btn btn-default" href="{{ url('/admincp/services', ['sort' => 'byName']) }}">Name</a>
                <a class="btn btn-default" href="{{ url('/admincp/services', ['sort' => 'byRejected']) }}">Rejected</a>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
            @include('admin.layouts.messages')
        </div>
        <div class="col-md-12">
            {{-- `name`, `dis`, `image`, `price`, `views`, `status`, `cat_id`, `user_id` --}}
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
                            <a href="{{ route('service.delete', ['id' => $service->id]) }}" class="btn btn-danger delete"><i class="fa fa-trash-o"></i></a>
                            @if ($service->status == 0)
                                <a href="{{ route('service.accept', ['id' => $service->id]) }}" class="btn btn-info confirmed"><i class="fa fa-unlock"></i></a>
                                <a href="{{ route('service.reject', ['id' => $service->id]) }}" class="btn btn-warning confirmed"><i class="fa fa-lock"></i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Pagination Code --}}
           <div class="text-center">
               {{ $services->appends(Request::except('page'))->render() }}
           </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
@endsection
