<template>
    <navbar></navbar>
    <div v-if="isLoading" class="container">
        <br><br><br>
        <div class="col-md-10 col-md-offset-1">
            <div class="row nicediv" style="padding: 20px !important;">
                <h3>Balance of
                    <a v-link="{name: 'User', params:{user_id: user.id, name:user.name}}" style="color: #777;font-weight: 300; text-decoration: none;cursor: pointer;">
                        <span>{{ user.name }}</span>
                    </a>
                </h3>
                <hr>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="circle-tile ">
                                <a href="javascript:;"><div class="circle-tile-heading orange"><i class="fa fa-credit-card fa-fw fa-3x"></i></div></a>
                                <div class="circle-tile-content orange">
                                    <div class="circle-tile-description text-faded"> payments</div>
                                    <div class="circle-tile-number text-faded ">{{ payments }}$</div>
                                    <a class="circle-tile-footer" href="#">More Info <i class="fa fa-chevron-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="circle-tile ">
                                <a href="javascript:;"><div class="circle-tile-heading blue"><i class="fa fa-bolt fa-fw fa-3x"></i></div></a>
                                <div class="circle-tile-content blue">
                                    <div class="circle-tile-description text-faded"> charges </div>
                                    <div class="circle-tile-number text-faded ">{{ charges }}$</div>
                                    <a class="circle-tile-footer" href="#">More Info <i class="fa fa-chevron-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="circle-tile ">
                                <a href="javascript:;"><div class="circle-tile-heading dark-blue"><i class="fa fa-dollar fa-fw fa-3x"></i></div></a>
                                <div class="circle-tile-content dark-blue">
                                    <div class="circle-tile-description text-faded"> My Balance </div>
                                    <div class="circle-tile-number text-faded ">{{ profits + (charges - payments) }}$</div>
                                    <a class="circle-tile-footer" href="#">More Info <i class="fa fa-chevron-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="circle-tile ">
                                <a href="javascript:;"><div class="circle-tile-heading dark-blue"><i class="fa fa-money fa-fw fa-3x"></i></div></a>
                                <div class="circle-tile-content dark-blue">
                                    <div class="circle-tile-description text-faded"> All profits </div>
                                    <div class="circle-tile-number text-faded ">{{ profits + waitProfits + doneProfits }}$</div>
                                    <a class="circle-tile-footer" href="#">More Info <i class="fa fa-chevron-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="circle-tile ">
                                <a href="javascript:;"><div class="circle-tile-heading dark-blue"><i class="fa fa-money fa-fw fa-3x"></i></div></a>
                                <div class="circle-tile-content dark-blue">
                                    <div class="circle-tile-description text-faded"> profits </div>
                                    <div class="circle-tile-number text-faded ">{{ profits }}$</div>
                                    <a class="circle-tile-footer" href="#">More Info <i class="fa fa-chevron-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="circle-tile ">
                                <a href="javascript:;"><div class="circle-tile-heading dark-blue"><i class="fa fa-money fa-fw fa-3x"></i></div></a>
                                <div class="circle-tile-content dark-blue">
                                    <div class="circle-tile-description text-faded"> Wait profits </div>
                                    <div class="circle-tile-number text-faded ">{{ waitProfits }}$</div>
                                    <a class="circle-tile-footer" href="#">More Info <i class="fa fa-chevron-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="circle-tile ">
                                <a href="javascript:;"><div class="circle-tile-heading dark-blue"><i class="fa fa-money fa-fw fa-3x"></i></div></a>
                                <div class="circle-tile-content dark-blue">
                                    <div class="circle-tile-description text-faded"> Done profits </div>
                                    <div class="circle-tile-number text-faded ">{{ doneProfits }}$</div>
                                    <a class="circle-tile-footer" href="#">More Info <i class="fa fa-chevron-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="alert alert-warning"><strong>All The Mony You Can Get Will Be From The Profits Only</strong></div>
                    <input type="number" class="form-control" v-model="profitsField">
                    <br>
                    <button type="button" @click="getProfits" class="btn btn-default" :disabled="isdisabled">Get Profits</button>
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
            profits:0,
            payments:0,
            charges:0,
            profitsField:'',
            isdisabled: false,
            waitProfits: 0,
            doneProfits: 0,
        }
    },
    ready: function () {
        this.$refs.spinner.show();
        this.getAllBalance();
    },
    methods: {
        getAllBalance: function () {
            this.$http.get('/getAllBalance').then(function (response) {
                this.user = response.body.user;
                this.profits = response.body.profits;
                this.profitsField = response.body.profits;
                this.payments = response.body.payments;
                this.waitProfits = response.body.waitProfits;
                this.doneProfits = response.body.doneProfits;
                this.charges = response.body.charges;

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
        getProfits: function () {
            this.isdisabled = true;
            var form = new FormData();
            form.append('profits', this.profitsField);
            this.$http.post('/getProfits', form).then(function (response) {
                if (response.body.status == 'done') {
                    this.profits -= response.body.gotProfit;
                    this.profitsField = this.profits;
                    this.waitProfits = response.body.waitProfits;
                    this.doneProfits = response.body.doneProfits;
                    swal("Good job!", "Balance Charging Proccess Successed!", "success");
                    this.isdisabled = false;
                }
                if (response.body == "try again later") {
                    alertify.error(response.body);
                }
                if (response.body == "Error You Can't Get Balance More Than You Have") {
                    alertify.error(response.body);
                    this.isdisabled = false;
                }
            }, function (response) {
                if (typeof(response.body) == 'object') {
                    for (var key in response.body) {
                        alertify.error(response.body[key]);
                    }
                    this.isdisabled = false;
                }
                if (response.body == 'You Need To login.') {
                    alert(response.body);
                    window.location = '/login';
                }
            });
        }
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
    .circle-tile {
        margin-bottom: 15px;
        text-align: center;
    }
    .circle-tile-heading {
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 100%;
        color: #FFFFFF;
        height: 80px;
        margin: 0 auto -40px;
        position: relative;
        transition: all 0.3s ease-in-out 0s;
        width: 80px;
    }
    .circle-tile-heading .fa {
        line-height: 80px;
    }
    .circle-tile-content {
        padding-top: 50px;
    }
    .circle-tile-number {
        font-size: 26px;
        font-weight: 700;
        line-height: 1;
        padding: 5px 0 15px;
    }
    .circle-tile-description {
        text-transform: uppercase;
    }
    .circle-tile-footer {
        background-color: rgba(0, 0, 0, 0.1);
        color: rgba(255, 255, 255, 0.5);
        display: block;
        padding: 5px;
        transition: all 0.3s ease-in-out 0s;
    }
    .circle-tile-footer:hover {
        background-color: rgba(0, 0, 0, 0.2);
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
    }
    .circle-tile-heading.dark-blue:hover {
        background-color: #2E4154;
    }
    .circle-tile-heading.green:hover {
        background-color: #138F77;
    }
    .circle-tile-heading.orange:hover {
        background-color: #DA8C10;
    }
    .circle-tile-heading.blue:hover {
        background-color: #2473A6;
    }
    .circle-tile-heading.red:hover {
        background-color: #CF4435;
    }
    .circle-tile-heading.purple:hover {
        background-color: #7F3D9B;
    }
    .tile-img {
        text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.9);
    }

    .dark-blue {
        background-color: #34495E;
    }
    .green {
        background-color: #16A085;
    }
    .blue {
        background-color: #2980B9;
    }
    .orange {
        background-color: #c0392b;
    }
    .red {
        background-color: #E74C3C;
    }
    .purple {
        background-color: #8E44AD;
    }
    .dark-gray {
        background-color: #7F8C8D;
    }
    .gray {
        background-color: #95A5A6;
    }
    .light-gray {
        background-color: #BDC3C7;
    }
    .yellow {
        background-color: #F1C40F;
    }
    .text-dark-blue {
        color: #34495E;
    }
    .text-green {
        color: #16A085;
    }
    .text-blue {
        color: #2980B9;
    }
    .text-orange {
        color: #F39C12;
    }
    .text-red {
        color: #E74C3C;
    }
    .text-purple {
        color: #8E44AD;
    }
    .text-faded {
        color: rgba(255, 255, 255, 0.7);
    }





</style>
