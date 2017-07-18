<template>
    <navbar></navbar>
    <div v-if="isLoading" class="container">
        <h2 class="text-center">My Services Page</h2>
        <hr>
        <br>
        <div class="col-md-3">
            <nav class="nav-sidebar">
                <p class="alert alert-success">Double Click To Reverse The Filters</p>
                <input type="text" class="form-control" v-model="searchword" placeholder="Search by name or price...">
                <br>
                <ul class="nav">
                    <li><a class="nav-link" @click="sort('')" href="javascript:;">All Services</a></li>
                    <li><a class="nav-link" @click="sort('name')" href="javascript:;">Name</a></li>
                    <li><a class="nav-link" @click="sort('price')" href="javascript:;">Price</a></li>
                    <li><a class="nav-link" @click="sort('status')" href="javascript:;">Wating Services</a></li>
                    <li><a class="nav-link" @click="sort('created_at')" href="javascript:;">Created At</a></li>
                </ul>
            </nav>
            <nav class="nav-sidebar">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="div-counter text-center">
                            <p class="counter-count">{{ services.length }}</p>
                            <p class="employee-p">Services</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="div-counter text-center">
                            <p class="counter-count">{{ purchaseOrders }}</p>
                            <p class="order-p">Purchase Orders</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="div-counter text-center">
                            <p class="counter-count">{{ incomingOrders }}</p>
                            <p class="employee-p">Incoming Orders</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="div-counter text-center">
                            <p class="counter-count">{{ approvedCounter }}</p>
                            <p class="employee-p">Approved Services</p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </nav>
        </div>
        <div class="col-md-9">
            <div class="row nicediv">
                <div class="alert alert-info"><strong>Welcome {{ user.name + ' Here IS Your All Services You Added..' }}</strong></div>
                <hr>
                <h3>Services</h3>
                <hr>
                <div v-if="services.length > 0">
                    <div class="col-sm-6 col-md-4" v-for="service in services | orderBy sortKey reverse | filterBy searchword in 'name' 'price'" track-by="$index">
                        <single_service :service="service"></single_service>
                    </div>
                    <button v-if="nomore" @click="ShowMore" type="button" class="btn btn-primary btn-block">Show More</button>
                </div>
                <div v-else>
                    <br>
                    <div class="col-md-12">
                        <div class="alert alert-danger">There Is No Services In This category</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <spinner v-ref:spinner size="xl" fixed text="Loading..."></spinner>
</template>

<script>

import SingleService from './SingleService.vue';

export default {
    components: {
        single_service: SingleService,
        spinner: require('vue-strap/dist/vue-strap.min').spinner,
        navbar: require('./../navbar.vue'),
    },
    data: function () {
        return {
            services: [],
            sortKey: '',
            reverse: 1,
            user: '',
            purchaseOrders: '',
            incomingOrders: '',
            approvedCounter: '',
            isLoading: false,
            nomore: true,
        }
    },
    ready:function () {
        this.$refs.spinner.show();
        this.getMyServices();
    },
    methods: {
        getMyServices: function (length) {
            if (typeof length == 'undefined') {
                var endlength = '';
            }else {
                var endlength = '/'+length;
            }
            this.$http.get('/MyServices' + endlength).then(function (response) {
                if (typeof length == 'undefined') {
                    this.services = response.body.services;
                }else {
                    if (response.body.services.length > 0) {
                        this.services = this.services.concat(response.body.services);
                    }else {
                        this.nomore = false;
                    }
                }
                this.user = response.body.user;
                this.isLoading = true;
                this.purchaseOrders = response.body.purchaseOrders;
                this.incomingOrders = response.body.incomingOrders;
                this.approvedCounter = response.body.approvedCounter;
                this.$refs.spinner.hide();
            }, function (response) {
                alert('There Is An Error Please Contact Us');
                this.$router.go({
                    path: '/',
                });
            });
        },
        ShowMore: function () {
            var length = this.services.length;
            this.getMyServices(length);
        },
        sort: function (sortval) {
            this.reverse = (this.sortKey == sortval) ? this.reverse * -1 : 1;
            this.sortKey = sortval;
        }
    },
    route:{
        canReuse: false,
        activate: function () {
            if (userIsLoggedIn != 1) {
                window.location = '/login';
            }
        }
    }
}
</script>




<style media="screen">
    .btn-product{
        width: 100%;
    }
    @media (max-width: 767px) {
        .btn-product {
            margin-bottom: 10px;
        }
    }
    @media (min-width: 768px) {
        .btn-product {
            margin-bottom: 10px;
        }
    }
    .nicediv {
        box-shadow: 2px 2px 5px #ccc;
        padding: 5px 20px;
        margin-bottom: 30px;
    }
    .img-container {
        height: 200px;
    }
    .img-container img {
        height: 100%;
        width: 100%;
    }
    .counter
    {
        background-color: #eaecf0;
        text-align: center;
    }
    .div-counter
    {
        margin-top: 70px;
        margin-bottom: 70px;
    }
    .counter-count
    {
        font-size: 18px;
        background-color: #00b3e7;
        border-radius: 50%;
        position: relative;
        color: #ffffff;
        text-align: center;
        line-height: 92px;
        width: 92px;
        height: 92px;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        display: inline-block;
    }
    .nav-sidebar {
        width: 100%;
        padding: 8px 0;
        box-shadow: 1px 1px 2px #ccc;
    }
    .nav-sidebar a {
        color: #333;
        -webkit-transition: all 0.08s linear;
        -moz-transition: all 0.08s linear;
        -o-transition: all 0.08s linear;
        transition: all 0.08s linear;
        -webkit-border-radius: 4px 0 0 4px;
        -moz-border-radius: 4px 0 0 4px;
        border-radius: 4px 0 0 4px;
    }
    .nav-sidebar .active a {
        cursor: default;
        background-color: #428bca;
        color: #fff;
        text-shadow: 1px 1px 1px #666;
    }
    .nav-sidebar .active a:hover {
        background-color: #428bca;
    }
    .nav-sidebar .text-overflow a,
    .nav-sidebar .text-overflow .media-body {
        white-space: nowrap;
        overflow: hidden;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis;
    }</style>
