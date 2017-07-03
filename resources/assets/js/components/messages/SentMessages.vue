<template lang="html">
    <div v-if="isLoading">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <h2 class="text-center text-primary">Messages You Sent</h2>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <menu :messages="messages" :type="'sent'"></menu>
            </div>
            <div class="col-md-9">
                <div class="nicedivvv" style="padding: 5px 15px;">
                    <div class="alert alert-success">Here Is All Messages You Sent To Other Users</div>
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
            this.$http.get('/SentMessages').then(function (response) {
                this.messages = response.body.messages;
                this.isLoading = true;
                this.$refs.spinner.hide();
            }, function (response) {
                alert('There Is An Error Please Contact Us');
                this.$router.go({
                    path: '/',
                });
            });
        },
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
