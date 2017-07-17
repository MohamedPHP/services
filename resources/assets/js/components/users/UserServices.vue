<template>
    <navbar></navbar>
    <div v-if="isLoading" class="container">
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
                    <li><a class="nav-link" @click="sort('created_at')" href="javascript:;">Created At</a></li>
                </ul>
            </nav>
            <nav class="nav-sidebar">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="div-counter text-center">
                            <p class="counter-count">{{ services.length }}</p>
                            <p class="employee-p">Services</p>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="col-md-9">
            <div class="row nicediv">
                <div class="alert alert-warning"><h3>Welcome To {{ user.name }} Profile</h3> <p>You Can contact him at {{ user.email }}</p></div>
                <hr>
                <h3>Services</h3>
                <hr>
                <div v-if="services.length > 0">
                    <div class="col-sm-6 col-md-4" v-for="service in services | orderBy sortKey reverse | filterBy searchword in 'name' 'price'" track-by="$index">
                        <single_service :service="service"></single_service>
                    </div>
                    <button v-if="nomore" @click="ShowMore" type="button" class="btn btn-primary btn-block">Show More</button>
                    <div class="col-md-12" v-if="!nomore">
                        <button type="button" class="btn btn-danger btn-block">no more services to show</button>
                    </div>
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
            user: '',
            services: '',
            isLoading: false,
            nomore: true,
            sortKey: '',
            reverse: 1,
        }
    },
    ready: function () {
        this.$refs.spinner.show();
        this.getUserServices();
    },
    methods: {
        getUserServices: function (length) {
            if (typeof length == 'undefined') {
                var endlength = '';
            }else {
                var endlength = '/'+length;
            }
            this.$http.get('/getUserServices/' + this.$route.params.user_id + endlength).then(function (response) {
                this.user = response.body.user;
                if (typeof length == 'undefined') {
                    this.services = response.body.services;
                }else {
                    if (response.body.services.length > 0) {
                        this.services = this.services.concat(response.body.services);
                    }else {
                        this.nomore = false;
                    }
                }
                this.isLoading = true;
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
            this.getUserServices(length);
        },
        sort: function (sortval) {
            this.reverse = (this.sortKey == sortval) ? this.reverse * -1 : 1;
            this.sortKey = sortval;
        }
    },
    events: {
        AddToparentFav: function (val) {
            this.$broadcast('AddToparentFavHeader', val);
        },
    }
}
</script>

<style lang="css">

</style>
