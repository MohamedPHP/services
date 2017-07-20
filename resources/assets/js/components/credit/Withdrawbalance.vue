<template>
    <navbar></navbar>
    <div v-if="isLoading" class="container">
        <br><br><br>
        <div class="col-md-10 col-md-offset-1">
            <div class="row nicediv" style="padding: 20px !important;">
                <h3>Withdrawbalance Of
                    <a v-link="{name: 'User', params:{user_id: user.id, name:user.name}}" style="color: #777;font-weight: 300; text-decoration: none;cursor: pointer;">
                        <span>{{ user.name }}</span>
                    </a>
                </h3>
                <hr>
                <h3 class="text-center text-success">total Withdraw Wating Is {{ sumWating }}$ And Done Is {{ sumDone }}$</h3>
                <hr>

                <div class="col-md-12">
                    <table class="table table-bordered table-hover" v-if="profits.length > 0">
                        <thead class="tablehead">
                            <!-- `id`, `price`, `status`, `user_id`, `created_at` -->
                            <tr>
                                <th style="width: 137px;">Proccess Number</th>
                                <th>Price</th>
                                <th>status</th>
                                <th>created_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="pay in profits" track-by="$index">
                                <td>{{ pay.id }}</td>
                                <td>{{ pay.price }}$</td>
                                <td>
                                    <span v-if="pay.status == 0" class="label label-default">Wating</span>
                                    <span v-if="pay.status == 1" class="label label-info">Done</span>
                                </td>
                                <td><i class="fa fa-clock-o"></i> {{ pay.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-else class="alert alert-danger">There is no charges For You Now</div>
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
            profits: [],
            sumWating: null,
            sumDone: null,
        }
    },
    ready: function () {
        this.$refs.spinner.show();
        this.getAllWithdrawbalance();
    },
    methods: {
        getAllWithdrawbalance: function () {
            this.$http.get('/getAllWithdrawbalance').then(function (response) {
                this.user = response.body.user;
                this.profits = response.body.profits;
                this.sumWating = response.body.sumWating;
                this.sumDone = response.body.sumDone;
                this.isLoading = true;
                this.$refs.spinner.hide();
            }, function (response) {
                alert('there is some error please contact us');
                if (response.body == 'You Need To login.') {
                    alert(response.body);
                    window.location = '/login';
                }
            });
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


<style media="screen">
    .nicediv {
        box-shadow: 1px 1px 5px #ccc !important;
        padding: 5px 5px !important;
        margin-bottom: 22px !important;
    }

</style>
