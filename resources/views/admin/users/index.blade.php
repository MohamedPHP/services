@extends('admin.layouts.app')




@section('content')
    <div class="row">
        <div class="col-md-6">
            <h2>Users <small>users page</small></h2>
        </div>
        <div class="col-md-6">
            <div style="margin-top: 25px;">
                <form action="{{ url('/admincp/users') }}" method="get">
                    <div class="col-md-12">
                        <input type="text" value="{{ Request::get('q') }}" name="q" class="form-control" placeholder="Search... Hit Enter">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <hr>
    <div class="row" style="border-left: 3px solid #3c763d; padding: 15px;">
        <div class="col-md-12" style="margin: 0 0 15px 0;">
            <div class="btn-group" style="margin-top: 15px;">
                <a class="btn btn-primary" href="{{ url('/admincp/users', ['sort' => '']) }}">Reset Sorting</a>
                <a class="btn btn-default" href="{{ url('/admincp/users', ['sort' => 'byAdmins']) }}">By Admins</a>
                <a class="btn btn-default" href="{{ url('/admincp/users', ['sort' => 'byNormalUsers']) }}">By NormalUsers</a>
                <a class="btn btn-default" href="{{ url('/admincp/users', ['sort' => 'ByRegistrationDateDESC']) }}">By Registration DateDESC</a>
                <a class="btn btn-default" href="{{ url('/admincp/users', ['sort' => 'ByRegistrationDateASC']) }}">By Registration DateACS</a>
            </div>
        </div>
        <div class="col-md-12">
            @include('admin.layouts.messages')
        </div>
        <div class="col-md-12">
            {{-- `name`, `email`, `password`, `admin` --}}
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>email</th>
                        <th>services count</th>
                        <th>P Orders</th>
                        <th>I Orders</th>
                        <th>admin</th>
                        <th>Registeration Date</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>#{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><a href="{{ url('/admincp/services', ['sort' => 'UserServices']) }}?user_id={{$user->id}}">{{ $user->services_count }}</a></td>
                            <td><a href="{{ url('/admincp/orders', ['sort' => 'UserPOrders']) }}?user_order={{$user->id}}">{{ $user->my_orders_count }}</a></td>
                            <td><a href="{{ url('/admincp/orders', ['sort' => 'UserIOrders']) }}?user_id={{$user->id}}">{{ $user->get_my_service_order_count }}</a></td>
                            <td>
                                @if ($user->admin == 1)
                                    <span class="label label-danger">Admin</span>
                                @else
                                    <span class="label label-info">User</span>
                                @endif
                            </td>
                            <td>
                                {{ $user->created_at->format('d-M-Y') }}
                            </td>
                            <td>
                                <a href="{{ route('user.edit', ['user_id' => $user->id]) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                <a href="#" class="btn btn-danger delete"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Pagination Code --}}
           <div class="text-center">
               {{ $users->appends(Request::except('page'))->render() }}
           </div>
        </div>
    </div>
@endsection
