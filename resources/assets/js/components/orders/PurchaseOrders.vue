<template>
    <div v-if="isLoading">
        <h2 class="text-center text-success">Purchase Orders</h2>
        <hr>
        <div class="col-md-10 col-md-offset-1">
            <div class="row">
                <div class="col-md-5">
                    <input type="text" class="form-control" v-model="service_name" placeholder="search by the service name ...">
                </div>
                <div class="col-md-7">
                    <div class="btn-group">
                        <button type="button" @click="filter('')" class="btn btn-default">All Data</button>
                        <button type="button" @click="filter('0')" class="btn btn-default">Wating</button>
                        <button type="button" @click="filter('1')" class="btn btn-info">Seen</button>
                        <button type="button" @click="filter('2')" class="btn btn-success">Accepted</button>
                        <button type="button" @click="filter('3')" class="btn btn-danger">Rejected</button>
                        <button type="button" @click="filter('4')" class="btn btn-primary">Done</button>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="col-md-10 col-md-offset-1">
            <table class="table table-bordered table-hover" v-if="orders.length > 0">
                <thead class="tablehead">
                    <tr>
                        <th>Process Number</th>
                        <th>Survice Name</th>
                        <th>Survice Provider</th>
                        <th>Order Time</th>
                        <th>Order Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="order in orders | filterBy filterData in 'status' | filterBy service_name in 'service.name'" track-by="$index">
                        <th>#{{ order.id }}</th>
                        <td><a class="btn btn-link" v-link="{name: 'ServiceDetails', params: {service_id: order.service.id, service_name: order.service.name}}"><span class="glyphicon glyphicon-eye-open"></span> {{ order.service.name }}</a></td>
                        <td><a class="btn btn-link" v-link="{name: 'User', params:{user_id: order.get_service_owner.id, name:order.get_service_owner.name}}"><i class="fa fa-user"></i> {{ order.get_service_owner.name }}</a></td>
                        <td>{{ order.created_at }}</td>
                        <td>
                            <status :status="order.status"></status>
                        </td>
                        <td>
                            <a v-link="{name: 'Order', params:{order_id: order.id}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="alert alert-danger">There is no Orders For You Now</div>
        </div>
    </div>
    <spinner v-ref:spinner size="xl" fixed text="Loading..."></spinner>
</template>

<script>
import Status from './Status.vue';

export default {
    components: {
        spinner: require('vue-strap/dist/vue-strap.min').spinner,
        status: Status,
    },
    data: function () {
        return {
            isLoading: false,
            orders: '',
            user: '',
            filterData: '',
            service_name: '',
        }
    },
    ready: function () {
        this.$refs.spinner.show();
        this.getMyPurchaseOrders();
    },
    methods: {
        getMyPurchaseOrders: function () {
            this.$http.get('getMyPurchaseOrders').then(
                function (response) {
                    this.orders = response.body.orders;
                    this.user = response.body.user;
                    this.isLoading = true;
                    this.$refs.spinner.hide();
                },
                function (response) {
                    alert('There Is An Error Please Contact Us');
                    this.$router.go({
                        path: '/',
                    });
                }
            );
        },
        filter: function (value) {
            this.filterData = value;
        }
    },
}
</script>


<style media="screen">
    .tablehead {
        background-color: #444;
        color: #fff;
    }
</style>
