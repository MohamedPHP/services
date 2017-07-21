@extends('admin.layouts.app')




@section('content')
    <div class="row">
        <div class="col-md-6">
            <h2>Profits Page</h2>
        </div>
        <div class="col-md-6">
            <div style="margin-top: 25px;">
                <form action="{{ url('/admincp/profits', ['sort' => 'SearchByDate']) }}" method="get">
                    <div class="col-md-10">
                        <input type="date" value="{{ Request::get('q') }}" name="q" class="form-control" placeholder="Search By Date... Hit Enter">
                        <p class="help-block">search by day that the payment will approve on</p>
                    </div>
                    <div class="col-md-2" >
                        <button style="margin-left: -32px;border-bottom-left-radius: 0;border-top-left-radius: 0;" type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <hr>
    <div class="row" style="border-left: 3px solid #3c763d; box-shadow: 1px 1px 3px #777;">
        <div class="col-md-12" style="margin: 0 0 15px 0;">
            <div class="btn-group" style="margin-top: 15px;">
                <a class="btn btn-primary" href="{{ url('/admincp/profits', ['sort' => '']) }}">Reset Sorting</a>
                <a class="btn btn-default" href="{{ url('/admincp/profits', ['sort' => 'TodaysProfits']) }}">
                    Wating To day Profits <span class="label label-default">{{ $timeNow }}</span>
                    <span class="label label-success">
                         <strong>{{ $todaysProfitsCount }}</strong>
                    </span>
                </a>
                <a class="btn btn-default" href="{{ url('/admincp/profits', ['sort' => 'TodaysProfitsSent']) }}">
                    Done To day Profits <span class="label label-default">{{ $timeNow }}</span>
                    <span class="label label-success">
                         <strong>{{ $todaysProfitsSentCount }}</strong>
                    </span>
                </a>
                <a class="btn btn-default" href="{{ url('/admincp/profits', ['sort' => 'byApproved']) }}">By Approved</a>
                <a class="btn btn-default" href="{{ url('/admincp/profits', ['sort' => 'byWating']) }}">By Wating</a>
                <a class="btn btn-default" href="{{ url('/admincp/profits', ['sort' => 'byDateASC']) }}">Old To New</a>
                <a class="btn btn-default" href="{{ url('/admincp/profits', ['sort' => 'byDateDESC']) }}">New To Old</a>
            </div>
        </div>
        <div class="col-md-12">
            @include('admin.layouts.messages')
        </div>
        <div class="col-md-12">
            {{-- `name`, `dis`, `image`, `price`, `views`, `status`, `cat_id`, `user_id` --}}
            <table class="table table-bordered table-hover">
                <thead class="tablehead">
                    <!-- `id`, `price`, `status`, `user_id`, `created_at` -->
                    <tr>
                        <th style="width: 137px;">Proccess Number</th>
                        <th>Price</th>
                        <th>Username</th>
                        <th>status</th>
                        <th>Date of receipt of profits</th>
                        <th>Creation date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($profits) > 0)
                    @foreach ($profits as $profit)
                        <tr class="text-center">
                            <td>#{{ $profit->id }}</td>
                            <td>{{ $profit->price }}$</td>
                            <td><a href="{{ route('user.edit', ['user_id' => $profit->user->id]) }}"><i class="fa fa-user"></i> {{ $profit->user->name }}</a></td>
                            <td>
                                @if ($profit->status == 0)
                                    <span class="label label-default">Wating</span>
                                @endif
                                @if ($profit->status == 1)
                                    <span class="label label-info">Done</span>
                                @endif
                            </td>
                            <td>
                                {{ \Moment\Moment::setLocale('ar_TN') }}
                                {{ (new \Moment\Moment($profit->created_at->format('Y-m-d'), 'CET'))->addDays(env('profitDay'))->format('Y-m-d') }}
                            </td>
                            <td><i class="fa fa-clock-o"></i> {{ $profit->created_at }}</td>
                            <td>
                                @if ($profit->status == 0)
                                    <a href="{{ route('admin.profit.approve', ['id' => $profit->id]) }}" class="btn btn-success">Approve Payment</a>
                                @else
                                    <span class="label label-danger">Nothing To Do</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @else
                        <div class="alert alert-danger"> There Is No Profit Orders </div>
                    @endif
                </tbody>
            </table>
            {{-- Pagination Code --}}
           <div class="text-center">
               {{ $profits->appends(Request::except('page'))->render() }}
           </div>
        </div>
    </div>
    <br><br>
@endsection
