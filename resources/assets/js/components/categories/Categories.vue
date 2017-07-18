<template>
    <navbar></navbar>
    <div v-if="isLoading" class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="row nicediv" style="padding: 20px !important;">
                <h3>Categories</h3>
                <hr>
                <div class="col-xs-4 col-lg-4" v-for="category in categories">
                    <div class="thumbnail">
                        <img class="group list-group-image" :src="category.image" style="width: 280px;height: 150px;" />
                        <div class="caption">
                            <h4 class="group inner list-group-item-heading">
                                {{ category.name }}
                            </h4>
                            <p class="group inner list-group-item-text">
                                {{ (category.description).substring(0, 50) + '...' }}
                            </p>
                            <br>
                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <a class="btn btn-info btn-block" v-link="{name: '/Cat', params: {cat_id: category.id, cat_name: category.name}}">View Category</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <spinner v-ref:spinner size="xl" fixed text="Loading..."></spinner>
</template>

<script>
import SingleService from './../users/SingleService.vue';
export default {
    components: {
        spinner: require('vue-strap/dist/vue-strap.min').spinner,
        navbar: require('./../navbar.vue'),
    },
    data: function () {
        return {
            isLoading: false,
            categories: [],
        }
    },
    ready: function () {
        this.$refs.spinner.show();
        this.getAllCategories();
    },
    methods: {
        getAllCategories: function (length) {
            this.$http.get('/getAllCategories').then(function (response) {
                this.categories = response.body.categories;
                this.isLoading = true;
                this.$refs.spinner.hide();
            }, function (response) {
                alert('There Is An Error Please Contact Us');
                if (response.body == 'You Need To login.') {
                    alert(response.body);
                    window.location = '/login';
                }
                window.location = '/404';
            });
        },
    }
}
</script>


<style media="screen">
    .nicediv {
        box-shadow: 1px 1px 5px #ccc !important;
        padding: 5px 5px !important;
        margin-bottom: 22px !important;
    }


    .glyphicon { margin-right:5px; }

</style>
