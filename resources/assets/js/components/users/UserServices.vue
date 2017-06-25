<template>
    <div v-if="isLoading">
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
                <div class="col-sm-6 col-md-4" v-for="service in services | orderBy sortKey reverse | filterBy searchword in 'name' 'price'" track-by="$index">
                    <single_service :service="service"></single_service>
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
    },
    data: function () {
        return {
            user: '',
            services: '',
            isLoading: false,
            sortKey: '',
            reverse: 1,
        }
    },
    ready: function () {
        this.$refs.spinner.show();
        this.getUserServices();
    },
    methods: {
        getUserServices: function () {
            this.$http.get('/getUserServices/' + this.$route.params.user_id).then(function (response) {
                this.user = response.body.user;
                this.services = response.body.services;
                this.isLoading = true;
                this.$refs.spinner.hide();
            }, function (response) {
                alert('There Is An Error Please Contact Us');
                this.$router.go({
                    path: '/',
                });
            });
        },
        sort: function (sortval) {
            this.reverse = (this.sortKey == sortval) ? this.reverse * -1 : 1;
            this.sortKey = sortval;
        }
    }
}
</script>

<style lang="css">

</style>
