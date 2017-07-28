<template lang="html">
    <navbar></navbar>
    <div v-if="isLoading" class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <h2 class="text-center text-primary">Notifications</h2>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="nicedivvv" style="padding: 5px 15px;">
                    <div class="alert alert-success">Here Is All Notifications</div>
                    <a style="color:#fff" href="/MarkAllAsSeen" class="btn btn-success">Mark All As Seen</a>
                </div>
                <div class="nicedivvv" style="padding: 10px 15px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="list-group" v-for="notification in notifications" track-by="$index">
                                <a v-if="notification.type == 'ReceiveOrder'" v-link="{name: 'Order', params:{order_id: notification.notify_id }}" class="list-group-item read">
                                    <span v-if="notification.seen == 0" class="glyphicon glyphicon-ban-circle"></span>
                                    <span v-if="notification.seen == 1" class="glyphicon glyphicon-check"></span>
                                    <span class="name" style="min-width: 120px;display: inline-block;">
                                        {{ notification.type }}
                                    </span>
                                    <span class="">{{ notification.get_sender.name }}</span>
                                    <span class="text-muted" style="font-size: 11px;">
                                        - {{ notification.get_sender.name }} Ordered Service ..
                                    </span>
                                    <span class="badge">
                                        {{ notification.created_at }}
                                    </span>
                                    <span v-if="notification.seen == 0" class="badge" style="background-color: #c0392b">unseen</span>
                                    <span v-if="notification.seen == 1" class="badge" style="background-color: #2ecc71">seen</span>
                                </a>
                                <a v-if="notification.type == 'ReceiveMessage'" v-link="{name: '/GetMessageById', params:{msg_id: notification.notify_id, message_title: 'Notification' }}" class="list-group-item read">
                                    <span v-if="notification.seen == 0" class="glyphicon glyphicon-ban-circle"></span>
                                    <span v-if="notification.seen == 1" class="glyphicon glyphicon-check"></span>
                                    <span class="name" style="min-width: 120px;display: inline-block;">
                                        {{ notification.type }}
                                    </span>
                                    <span class="">{{ notification.get_sender.name }}</span>
                                    <span class="text-muted" style="font-size: 11px;">
                                        - {{ notification.get_sender.name }} Messaged You ....
                                    </span>
                                    <span class="badge">
                                        {{ notification.created_at }}
                                    </span>
                                    <span v-if="notification.seen == 0" class="badge" style="background-color: #c0392b">unseen</span>
                                    <span v-if="notification.seen == 1" class="badge" style="background-color: #2ecc71">seen</span>
                                </a>
                                <a v-if="notification.type == 'NewComment'" v-link="{name: 'Order', params:{order_id: notification.notify_id}}" class="list-group-item read">
                                    <span v-if="notification.seen == 0" class="glyphicon glyphicon-ban-circle"></span>
                                    <span v-if="notification.seen == 1" class="glyphicon glyphicon-check"></span>
                                    <span class="name" style="min-width: 120px;display: inline-block;">
                                        {{ notification.type }}
                                    </span>
                                    <span class="">{{ notification.get_sender.name }}</span>
                                    <span class="text-muted" style="font-size: 11px;">
                                        - {{ notification.get_sender.name }} Made A New Comment....
                                    </span>
                                    <span class="badge">
                                        {{ notification.created_at }}
                                    </span>
                                    <span v-if="notification.seen == 0" class="badge" style="background-color: #c0392b">unseen</span>
                                    <span v-if="notification.seen == 1" class="badge" style="background-color: #2ecc71">seen</span>
                                </a>
                                <a v-if="notification.type == 'CompletedOrder'" v-link="{name: 'Order', params:{order_id: notification.notify_id}}" class="list-group-item read">
                                    <span v-if="notification.seen == 0" class="glyphicon glyphicon-ban-circle"></span>
                                    <span v-if="notification.seen == 1" class="glyphicon glyphicon-check"></span>
                                    <span class="name" style="min-width: 120px;display: inline-block;">
                                        {{ notification.type }}
                                    </span>
                                    <span class="">{{ notification.get_sender.name }}</span>
                                    <span v-if="notification.type == 'CompletedOrder'" class="text-muted" style="font-size: 11px;">
                                        - {{ notification.get_sender.name }} Completed The Order He Requested....
                                    </span>
                                    <span class="badge">
                                        {{ notification.created_at }}
                                    </span>
                                    <span v-if="notification.seen == 0" class="badge" style="background-color: #c0392b">unseen</span>
                                    <span v-if="notification.seen == 1" class="badge" style="background-color: #2ecc71">seen</span>
                                </a>
                                <a v-if="notification.type == 'AcceptedOrder'" v-link="{name: 'Order', params:{order_id: notification.notify_id}}" class="list-group-item read">
                                    <span v-if="notification.seen == 0" class="glyphicon glyphicon-ban-circle"></span>
                                    <span v-if="notification.seen == 1" class="glyphicon glyphicon-check"></span>
                                    <span class="name" style="min-width: 120px;display: inline-block;">
                                        {{ notification.type }}
                                    </span>
                                    <span class="">{{ notification.get_sender.name }}</span>
                                    <span v-if="notification.type == 'AcceptedOrder'" class="text-muted" style="font-size: 11px;">
                                        - {{ notification.get_sender.name }} Accepted The Order....
                                    </span>
                                    <span class="badge">
                                        {{ notification.created_at }}
                                    </span>
                                    <span v-if="notification.seen == 0" class="badge" style="background-color: #c0392b">unseen</span>
                                    <span v-if="notification.seen == 1" class="badge" style="background-color: #2ecc71">seen</span>
                                </a>
                                <a v-if="notification.type == 'RejectedOrder'" v-link="{name: 'Order', params:{order_id: notification.notify_id}}" class="list-group-item read">
                                    <span v-if="notification.seen == 0" class="glyphicon glyphicon-ban-circle"></span>
                                    <span v-if="notification.seen == 1" class="glyphicon glyphicon-check"></span>
                                    <span class="name" style="min-width: 120px;display: inline-block;">
                                        {{ notification.type }}
                                    </span>
                                    <span class="">{{ notification.get_sender.name }}</span>
                                    <span class="text-muted" style="font-size: 11px;">
                                        - {{ notification.get_sender.name }} Rejected The Order....
                                    </span>
                                    <span class="badge">
                                        {{ notification.created_at }}
                                    </span>
                                    <span v-if="notification.seen == 0" class="badge" style="background-color: #c0392b">unseen</span>
                                    <span v-if="notification.seen == 1" class="badge" style="background-color: #2ecc71">seen</span>
                                </a>
                                <a v-if="notification.type == 'ChangeStatusFromAdmin'" v-link="{name: 'Order', params:{order_id: notification.notify_id}}" class="list-group-item read">
                                    <span v-if="notification.seen == 0" class="glyphicon glyphicon-ban-circle"></span>
                                    <span v-if="notification.seen == 1" class="glyphicon glyphicon-check"></span>
                                    <span class="name" style="min-width: 120px;display: inline-block;">
                                        {{ notification.type }}
                                    </span>
                                    <span class="">{{ notification.get_sender.name }}</span>
                                    <span class="text-muted" style="font-size: 11px;">
                                        - {{ notification.get_sender.name }} Admin Changed The Order Status....
                                    </span>
                                    <span class="badge">
                                        {{ notification.created_at }}
                                    </span>
                                    <span v-if="notification.seen == 0" class="badge" style="background-color: #c0392b">unseen</span>
                                    <span v-if="notification.seen == 1" class="badge" style="background-color: #2ecc71">seen</span>
                                </a>
                                <a v-if="notification.type == 'AcceptService'" v-link="{name: 'ServiceDetails', params: {service_id: notification.notify_id, service_name: 'Notification'}}" class="list-group-item read">
                                    <span v-if="notification.seen == 0" class="glyphicon glyphicon-ban-circle"></span>
                                    <span v-if="notification.seen == 1" class="glyphicon glyphicon-check"></span>
                                    <span class="name" style="min-width: 120px;display: inline-block;">
                                        {{ notification.type }}
                                    </span>
                                    <span class="">{{ notification.get_sender.name }}</span>
                                    <span class="text-muted" style="font-size: 11px;">
                                        - {{ notification.get_sender.name }} Approved Service....
                                    </span>
                                    <span class="badge">
                                        {{ notification.created_at }}
                                    </span>
                                    <span v-if="notification.seen == 0" class="badge" style="background-color: #c0392b">unseen</span>
                                    <span v-if="notification.seen == 1" class="badge" style="background-color: #2ecc71">seen</span>
                                </a>
                                <a v-if="notification.type == 'RejectedService'" v-link="{name: 'ServiceDetails', params: {service_id: notification.notify_id, service_name: 'Notification'}}" class="list-group-item read">
                                    <span v-if="notification.seen == 0" class="glyphicon glyphicon-ban-circle"></span>
                                    <span v-if="notification.seen == 1" class="glyphicon glyphicon-check"></span>
                                    <span class="name" style="min-width: 120px;display: inline-block;">
                                        {{ notification.type }}
                                    </span>
                                    <span class="">{{ notification.get_sender.name }}</span>
                                    <span class="text-muted" style="font-size: 11px;">
                                        - {{ notification.get_sender.name }} Rejected The Service....
                                    </span>
                                    <span class="badge">
                                        {{ notification.created_at }}
                                    </span>
                                    <span v-if="notification.seen == 0" class="badge" style="background-color: #c0392b">unseen</span>
                                    <span v-if="notification.seen == 1" class="badge" style="background-color: #2ecc71">seen</span>
                                </a>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <button v-if="nomore" @click="ShowMore" type="button" class="btn btn-primary btn-block">Show More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <spinner v-ref:spinner size="xl" fixed text="Loading..."></spinner>
</template>

<script>
export default {
    components: {
        spinner: require('vue-strap/dist/vue-strap.min').spinner,
        navbar: require('./../navbar.vue'),
    },
    data: function () {
        return {
            isLoading: false,
            notifications: [],
            nomore: true,
        }
    },
    ready: function () {
        this.$refs.spinner.show();
        this.getUserNotifications();
    },
    methods: {
        getUserNotifications: function (length) {
            if (typeof length == 'undefined') {
                var endlength = '';
            }else {
                var endlength = '/'+length;
            }
            this.$http.get('/getUserNotifications' + endlength).then(function (response) {
                if (typeof length == 'undefined') {
                    this.notifications = response.body.notifications;
                }else {
                    if (response.body.notifications.length > 0) {
                        this.notifications = this.notifications.concat(response.body.notifications);
                    }else {
                        this.nomore = false;
                    }
                }
                this.$refs.spinner.hide();
                this.isLoading = true;
            }, function (response) {
                alert(" Error 1000 ");
                if (response.body == 'You Need To login.') {
                    alert(response.body);
                    window.location = '/login';
                }
                this.$router.go({
                    path: '/',
                });
            });
        },
        ShowMore: function () {
            var length = this.notifications.length;
            this.getUserNotifications(length);
        },
    },
    route:{
        activate: function () {
            if (userIsLoggedIn != 1) {
                window.location = '/login';
            }
        }
    }
}
</script>

<style lang="css">
.nicedivvv {
    width: 100%;
    padding: 8px 0;
    box-shadow: 1px 1px 2px #ccc;
}
</style>
