<template>
    <div v-if="isLoading">
        <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Wishlist</h4></div>
                <div class="panel-body">
                    <table class="table borderless table-hover table-inverse" v-if="wishlists.length > 0">
                        <thead>
                            <tr style="font-weight: bold;">
                                <td>service image</td>
                                <td>service name</td>
                                <td>owner name</td>
                                <td>service price</td>
                                <td>remove</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="wishlist in wishlists" track-by="$index">
                                <td class="col-md-2">
                                    <div class="media">
                                        <img class="img-thumbnail" v-bind:src="wishlist.service.image" style="width: 80%; height: 72px;">
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <h5 class="media-heading"> <a v-link="{name: 'ServiceDetails', params: {service_id: wishlist.service.id, service_name: wishlist.service.name}}">{{ wishlist.service.name }}</a></h5>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div class="btn-group btn-group-sm">
                                        <a class="btn btn-info" v-link="{name: 'User', params:{user_id: wishlist.owner.id, name:wishlist.owner.name}}"><i class="fa fa-user"></i> {{ wishlist.owner.name }}</a>
                                        <a v-link="{name: '/SendMessage', params:{user_id: wishlist.owner.id}}" class="btn btn-primary"><i class="fa fa-send"></i></a>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">$ {{ wishlist.service.price }}</td>
                                <td style="vertical-align: middle;">
                                    <button @click="DeleteWishList($index, wishlist.id)" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="alert alert-danger" v-else><strong>There IS No wishlists</strong></div>
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
    },
    data: function () {
        return {
            wishlists: '',
            isLoading: false,
        }
    },
    ready: function () {
        this.$refs.spinner.show();
        this.GetUserWishList();
    },
    methods: {
        GetUserWishList: function () {
            this.$http.get('/GetUserWishList').then(function (response) {
                this.wishlists = response.body.wishlists;
                this.isLoading = true;
                this.$refs.spinner.hide();
            }, function (response) {
                alert('There Is An Error Please Contact Us');
                this.$router.go({
                    path: '/',
                });
            });
        },
        DeleteWishList: function (index, id) {
            this.$http.get('/DeleteWishList/' + id).then(function (response) {
                if (response.body == 'service deleted') {
                    alertify.success('Service deleted from the wishlist');
                    this.wishlists.splice(index, 1);
                }
            }, function (response) {
                alert('There Is An Error Please Contact Us');
                this.$router.go({
                    path: '/',
                });
            });
        }
    }
}
</script>
