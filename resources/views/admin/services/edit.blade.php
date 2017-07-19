@extends('admin.layouts.app')




@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
              <h2>Edit Service <small>{{ $service->name }} see in front end <a href="{{ url('/') . '#!/ServiceDetails/'  . $service->id . '/' . $service->name}}">{{ $service->name }}</a></small></h2>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <hr>
    <div class="row" style="border-left: 3px solid #3c763d; box-shadow: 1px 1px 3px #777;padding: 20px;">
        <table class="table">
          <thead class="thead-inverse">
            <tr>
                <td>Service Owner</td>
                <td>Number Of Orders</td>
                <td>Number Of votes</td>
                <td>Number Of views</td>
                <td>Number Of Stars</td>
                <td>Reject</td>
                <td>Delete</td>
            </tr>
          </thead>
          <tbody>
            <tr>
                <td><a href="{{ url('/') . '#!/User/'  . $service->user->id . '/' . $service->user->name}}" class="btn-link"><i class="fa fa-user"></i> {{ $service->user->name }}</a></td>
                <td><i class="fa fa-signal"></i> {{ $service->orders_count }}</td>
                <td><i class="fa fa-users"></i> {{ $service->votes_count }}</td>
                <td><i class="fa fa-eye"></i> {{ $service->views_count }}</td>
                <td><i class="fa fa-star"></i> {{ $service->sum }}</td>
                <td><a href="{{ route('service.reject', ['id' => $service->id]) }}" class="btn btn-warning confirmed"><i class="fa fa-lock"></i></a></td>
                <td><a href="{{ route('service.delete', ['id' => $service->id]) }}" class="btn btn-danger delete"><i class="fa fa-trash-o"></i></a></td>
            </tr>
        </tbody>
        </table>
    </div>
    <br>
    @include('admin.layouts.messages')
    <div class="row" style="border-left: 3px solid #3c763d; box-shadow: 1px 1px 3px #777;padding: 20px;">
        <form action="{{ route('service.update', ['id' => $service->id]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="please add services name..." value="{{ old('name') !== null ? old('name') : $service->name}}">
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                <label for="image">image</label>
                <input type="file" class="form-control" id="image" name="image">
                @if ($errors->has('image'))
                    <span class="help-block">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
                @endif
                <br>
                <img class="img-rounded img-thumbnail" src="{{ asset($service->image) }}" alt="{{$service->image}}" style="width: 300px;height: 250px;">
            </div>
            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                <label for="price">price</label>
                <select id="price" name="price" class="form-control">
                    <!-- 5, 10, 15, 20, 25, 30, 40, 50 -->
                    <option value="5" {{ $service->price == 5 ? 'selected' : '' }}>5 $</option>
                    <option value="10" {{ $service->price == 10 ? 'selected' : '' }}>10 $</option>
                    <option value="15" {{ $service->price == 15 ? 'selected' : '' }}>15 $</option>
                    <option value="20" {{ $service->price == 20 ? 'selected' : '' }}>20 $</option>
                    <option value="25" {{ $service->price == 25 ? 'selected' : '' }}>25 $</option>
                    <option value="30" {{ $service->price == 30 ? 'selected' : '' }}>30 $</option>
                    <option value="40" {{ $service->price == 40 ? 'selected' : '' }}>40 $</option>
                    <option value="50" {{ $service->price == 50 ? 'selected' : '' }}>50 $</option>
                </select>
                @if ($errors->has('price'))
                    <span class="help-block">
                        <strong>{{ $errors->first('price') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('cat_id') ? ' has-error' : '' }}">
                <label for="prcat_idice">Category</label>
                <select id="cat_id" name="cat_id" class="form-control">
                @foreach ($cats as $cat)
                    <option value="{{ $cat->id }}" {{ $cat->id == $service->cat_id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
                </select>
                @if ($errors->has('cat_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('cat_id') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('dis') ? ' has-error' : '' }}">
                <label for="discription">discription</label>
                <textarea type="text" rows="8" cols="80" class="form-control" id="discription" name="dis" placeholder="please add services discription...">{{ old('dis') !== null ? old('dis') : $service->dis}}</textarea>
                @if ($errors->has('dis'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dis') }}</strong>
                    </span>
                @endif
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
    <hr>
    <div class="row" style="border-left: 3px solid #3c763d; box-shadow: 1px 1px 3px #777;padding: 20px;">
        <h2 class="text-center text-success">Orders</h2>
        <hr>
        <table class="table table-bordered table-hover">
            <thead class="tablehead">
                <tr>
                    <th>Process Number</th>
                    <th>Order Status</th>
                    <th>Order Time</th>
                </tr>
            </thead>
          <tbody>
              @foreach ($service->orders as $order)
                  <tr>
                      <th>#{{ $order->id }}</th>
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
                      <td>{{ $order->created_at }}</td>
                  </tr>
              @endforeach
        </tbody>
        </table>
    </div>
    <br>
@endsection
