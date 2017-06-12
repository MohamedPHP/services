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
                    <a class="btn btn-success btn-product"><span class="glyphicon glyphicon-shopping-cart"></span> Buy</a>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-info btn-product" v-link="{name: 'ServiceDetails', params: {service_id: service.id, service_name: service.name}}"><span class="glyphicon glyphicon-eye-open"></span> View</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['service'],
}
</script>
