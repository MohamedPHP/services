@extends('admin.layouts.app')




@section('content')
    <div class="row">
        <div class="col-md-6">
            <h2>Profits Page</h2>
            <div class="alert alert-info">بص يا معلم المعلمين اولا كده و بالصلاة علي النبي هنا بيظهر كل طلبات سحب الفلوس الي الاعضاء بعتوها مهو هما عاوزين فلوسهم بئة و كدهالمهم عندك حاجات تحت كده تفلتر بيها النتايخ علشان سهولة الاستخدام </div>

        </div>
        <div class="col-md-6">
            <div style="margin-top: 25px;">
                <form action="{{ url('/admincp/profits', ['sort' => 'SearchByDate']) }}" method="get">
                    <div class="col-md-10">
                        <input type="date" value="{{ Request::get('q') }}" name="q" class="form-control" placeholder="Search By Date... Hit Enter">
                    </div>
                    <div class="col-md-2" >
                        <button style="margin-left: -32px;border-bottom-left-radius: 0;border-top-left-radius: 0;" type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
            <br>
            <div class="alert alert-warning">Search By The Sent Profit Order Day =====> البحث بتاريخ ارسال طلبات الارباح</div>
        </div>
        <div class="clearfix"></div>
    </div>

    <hr>
    <div class="row" style="border-left: 3px solid #3c763d; box-shadow: 1px 1px 3px #777;">
        <div class="col-md-12" style="margin: 0 0 15px 0;">
            <div class="btn-group" style="margin-top: 15px;">
                <a class="btn btn-primary" href="{{ url('/admincp/profits', ['sort' => '']) }}">Reset Sorting</a>
                <a class="btn btn-default" href="{{ url('/admincp/profits', ['sort' => 'TodaysProfits']) }}">
                    Today Profits {{ $timeNow }}
                    <span class="label label-success">
                         <strong>{{ $todaysProfitsCount }}</strong>
                    </span>
                </a>
                <a class="btn btn-default" href="{{ url('/admincp/profits', ['sort' => 'TodaysProfitsSent']) }}">
                    Today Profits Sent {{ $timeNow }}
                    <span class="label label-success">
                         <strong>{{ $todaysProfitsSentCount }}</strong>
                    </span>
                </a>
                <a class="btn btn-default" href="{{ url('/admincp/profits', ['sort' => 'byDateASC']) }}">By Date ASC</a>
                <a class="btn btn-default" href="{{ url('/admincp/profits', ['sort' => 'byDateDESC']) }}">By Date DESC</a>
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
                        <th>Done Time</th>
                        <th>created_at</th>
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
