<template>
    <div v-if="isLoading">

        <div class="col-md-3">
            <main_sidebar :cats="cats" :sidebarsection1="sidebarsection1" :sidebarsection2="sidebarsection2" :sidebarsection3="sidebarsection3"></main_sidebar>
        </div>
        <div class="col-md-9">
            <div class="row nicediv" style="padding-bottom: 15px !important;">
                <p class="alert alert-success">Double Click To Reverse The Filters</p>
                <div class="col-md-6">
                    <input type="text" class="form-control" v-model="searchword" placeholder="Search by name or price...">
                </div>
                <div class="col-md-6">
                    <div class="btn-group">
                        <a class="btn btn-info" @click="sort('')" href="javascript:;">All Services</a>
                        <a class="btn btn-default" @click="sort('name')" href="javascript:;">Name</a>
                        <a class="btn btn-default" @click="sort('sum')" href="javascript:;">Rating</a>
                        <a class="btn btn-default" @click="sort('price')" href="javascript:;">Price</a>
                        <a class="btn btn-default" @click="sort('created_at')" href="javascript:;">Created At</a>
                    </div>
                </div>
            </div>
            <div class="row nicediv">
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
import SingleService from './../users/SingleService.vue';
import SideBar from './SideBar.vue';
export default {
    components: {
        single_service: SingleService,
        spinner: require('vue-strap/dist/vue-strap.min').spinner,
        main_sidebar: SideBar,
    },
    data: function () {
        return {
            services: '',
            cats: '',
            sidebarsection1: [],
            sidebarsection2: [],
            sidebarsection3: [],
            isLoading: false,
            nomore: true,
            sortKey: '',
            reverse: 1,
        }
    },
    ready: function () {
        this.$refs.spinner.show();
        this.getAllServices();
    },
    methods: {
        getAllServices: function (length) {
            if (typeof length == 'undefined') {
                var endlength = '';
            }else {
                var endlength = '/'+length;
            }
            this.$http.get('/getAllServices' + endlength).then(function (response) {
                if (typeof length == 'undefined') {
                    this.services = response.body.services;
                }else {
                    if (response.body.services.length > 0) {
                        this.services = this.services.concat(response.body.services);
                    }else {
                        this.nomore = false;
                    }
                }
                if (typeof length == 'undefined') {
                    this.cats = response.body.cats;
                    this.sidebarsection1 = response.body.sidebarsection1;
                    this.sidebarsection2 = response.body.sidebarsection2;
                    this.sidebarsection3 = response.body.sidebarsection3;
                }
                this.isLoading = true;
                this.$refs.spinner.hide();
            }, function (response) {
                alert('There Is An Error Please Contact Us');
                window.location = '/404';
            });
        },
        ShowMore: function () {
            var length = this.services.length;
            this.getAllServices(length);
        },
        sort: function (sortval) {
            this.reverse = (this.sortKey == sortval) ? this.reverse * -1 : 1;
            this.sortKey = sortval;
        }
    }
}
</script>


<style media="screen">
    .nicediv {
        box-shadow: 1px 1px 5px #ccc !important;
        padding: 5px 5px !important;
        margin-bottom: 22px !important;
    }
</style>
