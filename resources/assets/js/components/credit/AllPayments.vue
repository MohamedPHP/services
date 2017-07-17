<template>
    <navbar></navbar>
    <div v-if="isLoading" class="container">
        <br><br><br>
        <div class="col-md-10 col-md-offset-1">
            <div class="row nicediv" style="padding: 20px !important;">
                <h3>All Payments of
                    <a v-link="{name: 'User', params:{user_id: user.id, name:user.name}}" style="color: #777;font-weight: 300; text-decoration: none;cursor: pointer;">
                        <span>{{ user.name }}</span>
                    </a>
                </h3>
                <hr>
                <h3 class="text-center text-success">total Paied Money Is {{ sum }} $</h3>
                <hr>

                <div class="col-md-12">
                    <table class="table table-bordered table-hover" v-if="payments.length > 0">
                        <thead class="tablehead">
                            <tr>
                                <th>#ID</th>
                                <th>Price</th>
                                <th>Is Finished</th>
                                <th>Order View</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <!-- `user_id`, `order_id`, `price`, `isfinished` -->
                        <tbody>
                            <tr v-for="pay in payments" track-by="$index">
                                <td class="text-center">{{ pay.id }}</td>
                                <td class="text-center">{{ pay.price }} $ <i class="fa fa-money"></i></td>
                                <td class="text-center">
                                    <span v-if="pay.isfinished == 0" class="label label-warning">Suspended balance</span>
                                    <span v-if="pay.isfinished == 1" class="label label-success">Discounted balance</span>
                                    <span v-if="pay.isfinished == 2" class="label label-danger">Rejected Order</span>
                                </td>
                                <td class="text-center">
                                    <a v-link="{name: 'Order', params:{order_id: pay.order_id}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                </td>
                                <td class="text-center">{{ pay.created_at }} <i class="fa fa-clock-o"></i></td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-else class="alert alert-danger">There is no payments For You Now</div>
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
            user: {},
            payments: [],
            sum: null,
        }
    },
    ready: function () {
        this.$refs.spinner.show();
        this.getAllPayments();
    },
    methods: {
        getAllPayments: function () {
            this.$http.get('/getAllpayments').then(function (response) {
                this.user = response.body.user;
                this.payments = response.body.payments;
                this.sum = response.body.sum;
                this.isLoading = true;
                this.$refs.spinner.hide();
            }, function (response) {
                alert('there is some error please contact us');
                // window.location = '/';
            });
        },
    }
}
</script>


<style media="screen">
    .nicediv {
        box-shadow: 1px 1px 5px #ccc !important;
        padding: 5px 5px !important;
        margin-bottom: 22px !important;
    }

</style>
