<template lang="html">
    <navbar></navbar>
    <div v-if="isLoading" class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <h2 class="text-center text-primary">Messages You Road</h2>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <menu :messages="messages" :type="'read'"></menu>
            </div>
            <div class="col-md-9">
                <div class="nicedivvv" style="padding: 5px 15px;">
                    <div class="alert alert-success">Here Is All Messages You <strong>road</strong></div>
                </div>
                <div class="nicedivvv" style="padding: 10px 15px;">
                    <single_message :messages="messages"></single_message>
                </div>
            </div>
        </div>
    </div>
    <spinner v-ref:spinner size="xl" fixed text="Loading..."></spinner>
</template>

<script>
import Menu from './Menu.vue';
import SingleMessage from './SingleMessage.vue';
export default {
    components: {
        spinner: require('vue-strap/dist/vue-strap.min').spinner,
        menu: Menu,
        single_message: SingleMessage,
        navbar: require('./../navbar.vue'),
    },
    data: function () {
        return {
            messages: '',
            isLoading: false,
        }
    },
    ready: function () {
        this.$refs.spinner.show();
        this.SentMessages();
    },
    methods: {
        SentMessages: function () {
            this.$http.get('/ReadMessages').then(function (response) {
                this.messages = response.body.messages;
                this.isLoading = true;
                this.$refs.spinner.hide();
            }, function (response) {
                alert('There Is An Error Please Contact Us');
                if (response.body == 'You Need To login.') {
                    alert(response.body);
                    window.location = '/login';
                }
                this.$router.go({
                    path: '/',
                });
            });
        },
    },
    route:{
        activate: function () {
            if (userIsLoggedIn != 1) {
                window.location = '/login';
            }
        }
    }
}
</script>

<style lang="css">
.nicedivvv {
    width: 100%;
    padding: 8px 0;
    box-shadow: 1px 1px 2px #ccc;
}
</style>
