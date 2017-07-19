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
                    <a v-link="{name: 'ServiceDetails', params: {service_id: service.id, service_name: service.name}}"><h5><strong>{{ (service.name).substring(0, 15) }}</strong></h5></a>
                </div>
                <div class="col-md-4 col-xs-4 price text-right">
                    <h5><label>$ {{ service.price }}</label></h5>
                </div>
            </div>

            <div class="row text-center">
                <div class="col-md-12 col-sm-12 col-xs-12" style="font-size: 18px; margin-bottom: 6px;">
                    <span class="label label-default"><i class="fa fa-users" aria-hidden="true"></i> voters {{ service.votes_count }}</span>
                    <span class="label label-primary"><i class="fa fa-star" aria-hidden="true"></i> stars {{ service.sum }}</span>
                    <span class="label label-info">{{ service.sum != 0 ? (service.sum * 100) / (service.votes_count * 5) : 0 }} %</span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <buy_btn :service="service"></buy_btn>
                </div>
                <div class="col-md-6">
                    <wishlist_btn :service="service"></wishlist_btn>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Buybtn from './../services/Buybtn.vue';
import WishListbtn from './../services/WishListbtn.vue';
export default {
    props: ['service'],
    components: {
        buy_btn: Buybtn,
        wishlist_btn: WishListbtn,
    }
}
</script>
