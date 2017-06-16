<template>
    <div class="thumbnail">
        <h4 class="text-center">
            <span class="label label-info">{{ service.category.name }}</span>
            <span class="label label-success"><i class="fa fa-eye"></i> {{ (service.views).length }}</span>
        </h4>
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

            <div class="row">
                <div class="col-md-6">
                    <buy_btn :service="service"></buy_btn>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-info btn-product" v-link="{name: 'ServiceDetails', params: {service_id: service.id, service_name: service.name}}"><span class="glyphicon glyphicon-eye-open"></span> View</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Buybtn from './../services/Buybtn.vue';
export default {
    props: ['service'],
    components: {
        buy_btn: Buybtn,
    },
    methods: {
        AddOrder: function () {
            this.$http.get('/AddOrder/' + this.service.id).then(
                function (response) {
                    swal("Good job!", "Order Request Has Been Sent!", "success");
                },
                function (response) {
                    alertify.error("Your Request Has Been Rejected From The Server for one of these resones <br />1- You Requested It Before <br />2- This is your service <br />3- server error", 5000);
                }
            );
        }
    }
}
</script>
