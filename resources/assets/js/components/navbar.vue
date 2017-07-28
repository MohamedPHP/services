<template>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="/">
                    Services
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a v-link="{ path: '/' }">Home</a></li>
                    <li><a v-link="{ path: '/Categories' }">Categories</a></li>
                </ul>

                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                    <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
                </form>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right" v-if="userIsLoggedIn == 1">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Orders <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a v-link="{ path: '/IncomingOrders' }"><i class="fa fa-btn fa-truck"></i>Incoming Orders</a></li>
                            <li><a v-link="{ path: '/PurchaseOrders' }"><i class="fa fa-btn fa-cart-plus"></i>Purchase Orders</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Services <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a v-link="{ path: '/AddService' }"><i class="fa fa-btn fa-plus"></i>Add Service</a></li>
                            <li><a v-link="{ path: '/MyServices' }"><i class="fa fa-btn fa-user"></i>My Services</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-envelope" aria-hidden="true"></i> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a v-link="{name: '/Inbox'}"><i class="fa fa-inbox"></i> Inbox</a>
                            </li>
                            <li>
                                <a v-link="{name: '/SentMessages'}"><i class="fa fa-send"></i> Sent Messages</a>
                            </li>
                            <li>
                                <a v-link="{name: '/UnreadMessages'}"><i class="fa fa-eye-slash"></i> Unread Messages</a>
                            </li>
                            <li>
                                <a v-link="{name: '/ReadMessages'}"><i class="fa fa-eye"></i> Read Messages</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-money" aria-hidden="true"></i> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a v-link="{ path: '/AddCredit' }"><i class="fa fa-btn fa-exchange"></i>Charge Balance</a></li>
                            <li><a v-link="{ path: '/AllCharges' }"><i class="fa fa-btn fa-check"></i>My Charges</a></li>
                            <li><a v-link="{ path: '/AllPayments' }"><i class="fa fa-btn fa-money"></i>AllPayments</a></li>
                            <li><a v-link="{ path: '/Profits' }"><i class="fa fa-btn fa-plus-circle"></i>Profits</a></li>
                            <li><a v-link="{ path: '/Withdrawbalance' }"><i class="fa fa-btn fa-plus-circle"></i>Withdraw balance</a></li>
                            <li><a v-link="{ path: '/Balance' }">Balance</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a @click="getNotificationList" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="label label-success calc">{{ notiCount }}</span>
                        </a>
                        <ul class="dropdown-menu notify-drop">
                            <div class="notify-drop-title">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">Count (<b>{{ notiCount }}</b>)</div>
                                    <div class="col-md-6 col-sm-6 col-xs-6 text-right"><a href="/MarkAllAsSeen" class="rIcon allRead" data-tooltip="tooltip" data-placement="bottom" title="Mark All As Read"><i class="fa fa-dot-circle-o"></i></a></div>
                                </div>
                            </div>
                            <!-- end notify title -->
                            <!-- notify content -->
                            <div class="drop-content">
                                <spinner v-ref:spinner size="md" text="Loading..."></spinner>
                                <li v-for="note in notificationList" track-by="$index">
                                    <div class="col-md-12 col-sm-12 col-xs-12 pd-l0 text-center">
                                        <a v-link="{name: 'User', params:{user_id: note.get_sender.id, name:note.get_sender.name}}">{{ note.get_sender.name }}</a>
                                        <span v-if="note.type == 'ReceiveOrder'" class="text-muted" style="font-size: 11px;">
                                            <a v-link="{name: 'Order', params:{order_id: note.notify_id}}">- Requested Order.. </a>
                                        </span>
                                        <span v-if="note.type == 'ReceiveMessage'" class="text-muted" style="font-size: 11px;">
                                            <a v-link="{name: '/GetMessageById', params: {msg_id: note.notify_id, message_title: note.type}}">- Sent Message..</a>
                                        </span>
                                        <span v-if="note.type == 'NewComment'" class="text-muted" style="font-size: 11px;">
                                            <a v-link="{name: 'Order', params:{order_id: note.notify_id}}">- Made A Comment ..</a>
                                        </span>
                                        <span v-if="note.type == 'CompletedOrder'" class="text-muted" style="font-size: 11px;">
                                            <a v-link="{name: 'Order', params:{order_id: note.notify_id}}">- Completed Order..</a>
                                        </span>
                                        <span v-if="note.type == 'AcceptedOrder'" class="text-muted" style="font-size: 11px;">
                                            <a v-link="{name: 'Order', params:{order_id: note.notify_id}}">- Accepted Your Order..</a>
                                        </span>
                                        <span v-if="note.type == 'RejectedOrder'" class="text-muted" style="font-size: 11px;">
                                            <a v-link="{name: 'Order', params:{order_id: note.notify_id}}">- Rejected Order..</a>
                                        </span>
                                        <span v-if="note.type == 'ChangeStatusFromAdmin'" class="text-muted" style="font-size: 11px;">
                                            <a v-link="{name: 'Order', params:{order_id: note.notify_id}}">- (Admin) Changed Status..</a>
                                        </span>
                                        <span v-if="note.type == 'AcceptService'" class="text-muted" style="font-size: 11px;">
                                            <a v-link="{name: 'ServiceDetails', params: {service_id: note.notify_id, service_name: 'Notification'}}">- Approved Service..</a>
                                        </span>
                                        <span v-if="note.type == 'RejectedService'" class="text-muted" style="font-size: 11px;">
                                            <a v-link="{name: 'ServiceDetails', params: {service_id: note.notify_id, service_name: 'Notification'}}">- Rejected Service..</a>
                                        </span>
                                        <span v-if="note.seen == 0" class="badge" style="background-color: #c0392b">unseen</span>
                                        <span v-if="note.seen == 1" class="badge" style="background-color: #2ecc71">seen</span>
                                        <span class="label label-default">{{note.created_at}}</span>
                                    </div>
                                </li>
                            </div>
                            <div class="notify-drop-footer text-center">
                                <a v-link="{path:'/AllNotifications'}"><i class="fa fa-eye"></i> All Notifications</a>
                            </div>
                        </ul>

                    </li>

                    <li>
                        <a v-link="{name: '/Wishlist'}">
                            <i class="fa fa-heart"></i>
                            <span class="label label-danger calc">{{ favCount }}</span>
                        </a>
                    </li>
                    <li>
                        <a v-link="{name: '/Inbox'}">
                            <i class="fa fa-inbox"></i>
                            <span class="label label-warning calc">{{ inboxCount }}</span>
                        </a>
                    </li>
                    <li>
                        <a v-link="{ path: '/IncomingOrders' }">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="label label-primary calc">{{ ordersCount }}</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Mohamed Zayed <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#"><i class="fa fa-btn fa-edit"></i>Edit Data</a></li>
                            <li><a href="#"><i class="fa fa-btn fa-money"></i>Balance</a></li>
                            <li><a href="/admincp"><i class="fa fa-btn fa-users"></i>Admin CP</a></li>
                            <li><a v-link="{ path: '/AddCredit' }"><i class="fa fa-btn fa-exchange"></i>Charge Balance</a></li>
                            <li><a href="/logout"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right" v-else>
                    <li><a href="/login">Login</a></li>
                    <li><a href="/register">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    data: function () {
        return {
            favCount: 0,
            inboxCount: 0,
            ordersCount:0,
            notiCount:0,
            notificationList:[],
            userIsLoggedIn:'',
        }
    },
    components: {
        spinner: require('vue-strap/dist/vue-strap.min').spinner,
    },
    ready: function () {
        $('body').css('overflowY', 'visible');
        $('body').css('overflowX', 'hidden');
        this.userIsLoggedIn = userIsLoggedIn;
        if (this.userIsLoggedIn == 1) {
            this.getAllInfo();
        }
    },
    methods: {
        getAllInfo: function () {
            this.$http.get('getAllInfo').then(function (response) {
                this.favCount = response.body.favCount;
                this.inboxCount = response.body.inboxCount;
                this.ordersCount = response.body.ordersCount;
                this.notiCount = response.body.notiCount;
            }, function (response) {
                alert('There Is An Error [ 1000 ] Please Contact Us');
                if (response.body == 'You Need To login.') {
                    alert(response.body);
                    window.location = '/login';
                }
            });
        },
        getNotificationList :function () {
            if (this.userIsLoggedIn == 1) {
                this.$refs.spinner.show();
                this.$http.get('getNotificationList').then(function (response) {
                    this.notificationList = response.body;
                    this.$refs.spinner.hide();
                }, function (response) {
                    if (response.body == 'You Need To login.') {
                        alert(response.body);
                        window.location = '/login';
                    }
                });
            }else {
                window.location = '/login';
            }
        }
    },
    events: {
        AddToparentFavHeader: function (val) {
            this.favCount = val;
        },
        ServiceRemovedFromWishList: function (val) {
            this.favCount = val;
        }
    },
    route: {
        canReuse: false,
    }
}
</script>

<style lang="css">
</style>
