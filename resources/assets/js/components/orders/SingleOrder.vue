<template>
    <navbar></navbar>
    <br>
    <br>
    <div v-if="isLoading" class="container">
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8 col-md-offset-2">
            <div class="item-container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-12">
                                <div><i class="fa fa-clock-o"></i> {{ service.created_at }}</div>
                                <hr>
                                <div><i class="fa fa-money"></i> Number of times purchased ( {{ number_of_times_purchased }} )</div>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <img style="height: 167px;width: 100%;" class="img-responsive img-thumbnail img-rounded" v-bind:src="service.image" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="product-title">
                            <div class="row">
                                <div class="col-md-12">
                                    {{ service.name }}
                                    <br>
                                    <div>
                                        <status :status="status"></status>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="product-rating"><i class="fa fa-star gold"></i> <i class="fa fa-star gold"></i> <i class="fa fa-star gold"></i> <i class="fa fa-star gold"></i> <i class="fa fa-star-o"></i> </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="product-price">$ {{ service.price }}</div>
                            </div>
                            <hr>
                            <div class="col-md-12" v-if="user_id.id == AuthUser.id && status == 1">
                                <button @click="changeStatus(2)" type="button" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> Accept Order</button>
                                <button @click="changeStatus(3)" type="button" class="btn btn-danger"><i class="fa fa-window-close" aria-hidden="true"></i> Reject Order</button>
                            </div>

                            <div class="col-md-12" v-if="order_user.id == AuthUser.id && status == 2">
                                <button @click="finishOrder(4)" type="button" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> Finish Order</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="product-info">
                <ul id="myTab" class="nav nav-tabs nav_tabs">
                    <li class="active"><a href="#service-one" data-toggle="tab">DESCRIPTION</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="service-one" style="line-height: 1.7; color: #999;">
                        <br>
                        {{ service.dis }}
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8 col-md-offset-2">
            <all_comments :order="order"></all_comments>
        </div>
    </div>
    <spinner v-ref:spinner size="xl" fixed text="Loading..."></spinner>
</template>

<script>
import Status from './Status.vue';
import AllComments from './../comments/AllComments.vue';
export default {
    components: {
        spinner: require('vue-strap/dist/vue-strap.min').spinner,
        status: Status,
        all_comments: AllComments,
        navbar: require('./../navbar.vue'),
    },
    data: function () {
        return {
            service: '',
            order: '',
            isLoading: false,
            status: '',
            number_of_times_purchased: '',
            user_id: '',
            order_user: '',
            AuthUser: '',
            btns: true,
        }
    },
    ready: function () {
        this.$refs.spinner.show();
        this.GetOrderById();
    },
    methods: {
        GetOrderById: function () {
            this.$http.get('/GetOrderById/' + this.$route.params.order_id).then(function (response) {
                this.order = response.body.order;
                this.service = response.body.order.service;
                this.status = response.body.order.status;
                this.number_of_times_purchased = response.body.number_of_times_purchased;
                this.user_id = response.body.user_id;
                this.order_user = response.body.order_user;
                this.AuthUser = response.body.AuthUser;
                this.isLoading = true;
                if (this.order.status == 2 || this.order.status == 3) {
                    this.btns = false;
                }
                this.$refs.spinner.hide();
            }, function (response) {
                alert('There Is An Error Please Contact Us');
                this.$router.go({
                    path: '/',
                });
            });
        },
        changeStatus: function (status) {
            this.$refs.spinner.show();
            this.$http.get('/ChangeStatus/' + this.$route.params.order_id + '/' + status).then(
                function (response) {
                    this.btns = false;
                    this.status = response.body.status;
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
        finishOrder: function (status) {
            this.$refs.spinner.show();
            this.$http.get('/finishOrder/' + this.$route.params.order_id + '/' + status).then(
                function (response) {
                    this.status = response.body.status;
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
    },
    route: {
        canReuse: false,
    }
}
</script>

<style lang="css">
    /*********************************************
                Theme Elements
    *********************************************/
    button {
        margin-right: 10px;
    }
    .gold{
    color: #FFBF00;
    }
    /*********************************************
                    PRODUCTS
    *********************************************/
    .product{
    border: 1px solid #dddddd;
    height: 321px;
    }
    .product>img{
    max-width: 230px;
    }
    .product-rating{
    font-size: 20px;
    margin-bottom: 25px;
    }
    .product-title{
    font-size: 18px;
    }
    .product-desc{
    font-size: 14px;
    }
    .product-price{
    font-size: 22px;
    }
    .product-stock{
    color: #74DF00;
    font-size: 20px;
    margin-top: 10px;
    }
    .product-info{
        margin-top: 50px;
    }
    /*********************************************
                    VIEW
    *********************************************/
    .content-wrapper {
    max-width: 1140px;
    background: #fff;
    margin: 0 auto;
    margin-top: 25px;
    margin-bottom: 10px;
    border: 0px;
    border-radius: 0px;
    }
    .container-fluid{
    max-width: 1140px;
    margin: 0 auto;
    }
    .view-wrapper {
    float: right;
    max-width: 70%;
    margin-top: 25px;
    }
    .container {
    padding-left: 0px;
    padding-right: 0px;
    max-width: 100%;
    }
    /*********************************************
                ITEM
    *********************************************/
    .service1-items {
    padding: 0px 0 0px 0;
    float: left;
    position: relative;
    overflow: hidden;
    max-width: 100%;
    height: 321px;
    width: 130px;
    }
    .service1-item {
    height: 107px;
    width: 120px;
    display: block;
    float: left;
    position: relative;
    padding-right: 20px;
    border-right: 1px solid #DDD;
    border-top: 1px solid #DDD;
    border-bottom: 1px solid #DDD;
    }
    .service1-item > img {
    max-height: 110px;
    max-width: 110px;
    opacity: 0.6;
    transition: all .2s ease-in;
    -o-transition: all .2s ease-in;
    -moz-transition: all .2s ease-in;
    -webkit-transition: all .2s ease-in;
    }
    .service1-item > img:hover {
    cursor: pointer;
    opacity: 1;
    }
    .service-image-left {
    padding-right: 50px;
    }
    .service-image-right {
    padding-left: 50px;
    }
    .service-image-left > center > img,.service-image-right > center > img{
    max-height: 155px;
    }
</style>
