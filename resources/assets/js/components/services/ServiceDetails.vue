<template>
    <br>
    <br>
    <div v-if="isLoading">
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
            <div class="item-container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <img class="img-responsive img-thumbnail img-rounded" v-bind:src="service.image" style="height: 200px;width: 100%;" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="product-title">
                            <div class="row">
                                <div class="col-md-12">
                                    {{ service.name }}
                                </div>
                            </div>
                        </div>
                        <div class="product-rating">
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <rating :service="service" :user_vote="userVote"></rating>
                                </div>
                                <div class="col-md-8 col-sm-12 col-xs-12" style="font-size: 18px;">
                                    <span class="label label-default pull-right"><i class="fa fa-users" aria-hidden="true"></i> voters {{ service.votes_count }}</span>
                                    <span class="label label-primary pull-right"><i class="fa fa-star" aria-hidden="true"></i> stars {{ sum }}</span>
                                    <span class="label label-info pull-right">percentage {{ sum != 0 ? (sum * 100) / (service.votes_count * 5) : 0 }} %</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-price">$ {{ service.price }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-group wishlist">
                                    <div class="btn-group cart">
                                        <buy_btn :service="service"></buy_btn>
                                    </div>
                                    <wishlist_btn :service="service"></wishlist_btn>
                                </div>
                            </div>
                        </div>
                        <hr>

                    </div>
                </div>
                <hr>
                <div class="row" style="color: #555;line-height: 1.7;font-size: 13px;">
                    <div class="col-md-12">
                        <h4>Description</h4>
                        <hr>
                        <p style="white-space: pre-line;">
                            {{ service.dis }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="product-info">
                <ul id="myTab" class="nav nav-tabs nav_tabs">
                    <li class="active"><a href="#service-two" data-toggle="tab">My Services In This Category</a></li>
                    <li><a href="#service-three" data-toggle="tab">Other Services In This Category</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="service-two">
                        <br>
                        <br>
                        <div class="row">
                            <div v-if="mySameCat.length > 0">
                                <div class="col-sm-4 col-md-4" v-for="service in mySameCat" track-by="$index">
                                    <my_same_cat :service="service"></my_same_cat>
                                </div>
                            </div>
                            <div class="alert alert-danger" v-if="mySameCat.length == 0">
                                There Is No Services In This Categoury.
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="service-three">
                        <br>
                        <br>
                        <div class="row">
                            <div v-if="otherSameCat.length > 0">
                                <div class="col-sm-4 col-md-4" v-for="service in otherSameCat" track-by="$index">
                                    <other_same_cat :service="service"></other_same_cat>
                                </div>
                            </div>
                            <div class="alert alert-danger" v-if="otherSameCat.length == 0">
                                There Is No Services In This Categoury.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <side_bar :service="service" :most_rated_services="mostRatedServices" :most_viewed_services="mostViewedServices" :sidebarsection2="sidebarsection2"></side_bar>
        </div>
    </div>
    <spinner v-ref:spinner size="xl" fixed text="Loading..."></spinner>
</template>

<script>
import mySameCat from './../users/SingleService.vue';
import otherSameCat from './../users/SingleService.vue';
import Sidebar from './Sidebar.vue';
import Buybtn from './Buybtn.vue';
import WishListbtn from './WishListbtn.vue';
import Rating from './Rating.vue';
export default {
    components: {
        my_same_cat:mySameCat,
        other_same_cat:otherSameCat,
        side_bar:Sidebar,
        buy_btn:Buybtn,
        wishlist_btn:WishListbtn,
        rating:Rating,
        spinner: require('vue-strap/dist/vue-strap.min').spinner,
    },
    data: function () {
        return {
            service: '',
            mySameCat: '',
            otherSameCat: '',
            userVote: '',
            sum: '',
            mostRatedServices: [],
            mostViewedServices: [],
            sidebarsection2: [],
            isLoading: false,
        }
    },
    ready: function () {
        this.$refs.spinner.show();
        this.getServiceByID();
    },
    methods: {
        getServiceByID: function () {
            this.$http.get('/service/' + this.$route.params.service_id).then(function (response) {
                if (response.body != 'error') {
                    this.service      = response.body.service;
                    this.mySameCat    = response.body.mySameCat;
                    this.otherSameCat = response.body.otherSameCat;
                    this.userVote     = response.body.userVote;
                    this.sum          = response.body.sum;
                    this.mostRatedServices = response.body.mostRatedServices;
                    this.mostViewedServices= response.body.mostViewedServices;
                    this.sidebarsection2   = response.body.sidebarsection2;
                    this.isLoading    = true;
                    this.$refs.spinner.hide();
                }else {
                    // window.location = "/";
                }
            }, function (response) {
                alert('There Is An Error Please Contact Us');
                this.$router.go({
                    path: '/',
                });
            });
        }
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
    font-size: 20px;
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
