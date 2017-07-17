<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
    <i class="fa fa-bell"></i>
    <span class="label label-success calc">{{ count(getNotificationObjects()) }}</span>
</a>
<ul class="dropdown-menu notify-drop">
    <div class="notify-drop-title">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">Count (<b>{{ count(getNotificationObjects()) }}</b>)</div>
            <div class="col-md-6 col-sm-6 col-xs-6 text-right"><a href="" class="rIcon allRead" data-tooltip="tooltip" data-placement="bottom" title="Mark All As Read"><i class="fa fa-dot-circle-o"></i></a></div>
        </div>
    </div>
    <!-- end notify title -->
    <!-- notify content -->
    <div class="drop-content">
        @foreach (getNotificationObjects() as $value)
            @if ($value->type == 'ReceiveOrder')
                <li>
                    <div class="col-md-12 col-sm-12 col-xs-12 pd-l0 text-center">
                        <a v-link="{name:'User', params:{user_id: {{ $value->getSender->id }}, name: '{{ $value->getSender->name }}'}}">{{ $value->getSender->name }}</a>
                        Ordered Service
                        <a v-link="{name: 'Order', params:{order_id: {{ $value->notify_id }}}}">View Order</a>
                        <span class="label label-default">{{ $value->created_at->format('Y, m, d') }}</span>
                    </div>
                </li>
            @endif
            @if ($value->type == 'ReceiveMessage')
                <li>
                    <div class="col-md-12 col-sm-12 col-xs-12 pd-l0 text-center">
                        <a v-link="{name:'User', params:{user_id: {{ $value->getSender->id }}, name: '{{ $value->getSender->name }}'}}">{{ $value->getSender->name }}</a>
                        Messaged You
                        <a v-link="{name: '/GetMessageById', params:{msg_id: {{ $value->notify_id }}, message_title: 'Notification' }}">View Message</a>
                        <span class="label label-default">{{ $value->created_at->format('Y, m, d') }}</span>
                    </div>
                </li>
            @endif
            @if ($value->type == 'NewComment')
                <li>
                    <div class="col-md-12 col-sm-12 col-xs-12 pd-l0 text-center">
                        <a v-link="{name:'User', params:{user_id: {{ $value->getSender->id }}, name: '{{ $value->getSender->name }}'}}">{{ $value->getSender->name }}</a>
                        Commented On Order
                        <a v-link="{name: 'Order', params:{order_id: {{ $value->notify_id }}}}">View Order</a>
                        <span class="label label-default">{{ $value->created_at->format('Y, m, d') }}</span>
                    </div>
                </li>
            @endif
            @if ($value->type == 'CompletedOrder')
                <li>
                    <div class="col-md-12 col-sm-12 col-xs-12 pd-l0 text-center">
                        <a v-link="{name:'User', params:{user_id: {{ $value->getSender->id }}, name: '{{ $value->getSender->name }}'}}">{{ $value->getSender->name }}</a>
                        Finished Order
                        <a v-link="{name: 'Order', params:{order_id: {{ $value->notify_id }}}}">View Order</a>
                        <span class="label label-default">{{ $value->created_at->format('Y, m, d') }}</span>
                    </div>
                </li>
            @endif
            @if ($value->type == 'AcceptedOrder')
                <li>
                    <div class="col-md-12 col-sm-12 col-xs-12 pd-l0 text-center">
                        <a v-link="{name:'User', params:{user_id: {{ $value->getSender->id }}, name: '{{ $value->getSender->name }}'}}">{{ $value->getSender->name }}</a>
                        Accepted Order
                        <a v-link="{name: 'Order', params:{order_id: {{ $value->notify_id }}}}">View Order</a>
                        <span class="label label-default">{{ $value->created_at->format('Y, m, d') }}</span>
                    </div>
                </li>
            @endif
            @if ($value->type == 'RejectedOrder')
                <li>
                    <div class="col-md-12 col-sm-12 col-xs-12 pd-l0 text-center">
                        <a v-link="{name:'User', params:{user_id: {{ $value->getSender->id }}, name: '{{ $value->getSender->name }}'}}">{{ $value->getSender->name }}</a>
                        Rejected your Order
                        <a v-link="{name: 'Order', params:{order_id: {{ $value->notify_id }}}}">View Order</a>
                        <span class="label label-default">{{ $value->created_at->format('Y, m, d') }}</span>
                    </div>
                </li>
            @endif
        @endforeach
    </div>
    <div class="notify-drop-footer text-center">
        <a v-link="{path:'/AllNotifications'}"><i class="fa fa-eye"></i> All Notifications</a>
    </div>
</ul>
