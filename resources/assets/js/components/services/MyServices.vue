<template>
    <h2 class="text-center">My Services Page</h2>
    <hr>
    <br>
    <div class="col-md-3">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Another link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
            </li>
        </ul>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="div-counter">
                    <p class="counter-count">{{ services.length }}</p>
                    <p class="employee-p">Services</p>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="div-counter">
                    <p class="counter-count">652</p>
                    <p class="order-p">Orders</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-4" v-for="service in services">
            	<div class="thumbnail">
            		<h4 class="text-center"><span class="label label-info">{{ service.category.name }}</span></h4>
                    <div class="img-container">
                        <img class="img-responsive" v-bind:src="service.image">
                    </div>
            		<div class="caption">
            			<div class="row">
            				<div class="col-md-8 col-xs-8">
            					<h5><strong>{{ service.name }}</strong></h5>
            				</div>
            				<div class="col-md-4 col-xs-4 price text-right">
            					<h5><label>$ {{ service.price }}</label></h5>
            				</div>
            			</div>
            			<p>{{ (service.dis).slice(0,30) }}</p>
            			<div class="row">
            				<div class="col-md-6" v-if="service.status == 0">
            					<a class="btn btn-info btn-product"><span class="glyphicon glyphicon-time"></span> Wating</a>
            				</div>
            				<div class="col-md-6" v-if="service.status == 1">
            					<a class="btn btn-primary btn-product"><span class="glyphicon glyphicon-star"></span> Accepted</a>
            				</div>
            				<div class="col-md-6" v-if="service.status == 2">
            					<a class="btn btn-danger btn-product"><span class="glyphicon glyphicon-folder-close"></span> Denied</a>
            				</div>
            				<div class="col-md-6">
            					<a class="btn btn-success btn-product" href="#"><span class="glyphicon glyphicon-shopping-cart"></span> Buy</a>
            				</div>
            			</div>
            			<p></p>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</template>

<style media="screen">
    .btn-product{
        width: 100%;
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

    .employee-p,.customer-p,.order-p,.design-p
    {
        font-size: 24px;
        color: #000000;
        line-height: 34px;
    }
</style>

<script>
export default {
    data: function () {
        return {
            services: [],
        }
    },
    ready:function () {
        this.getMyServices();
    },
    methods: {
        getMyServices: function () {
            this.$http.get('/MyServices').then(function (response) {
                console.log(response);
                this.services = response.body;
            }, function (response) {
                console.log(response);
            });
        }
    }
}
</script>
