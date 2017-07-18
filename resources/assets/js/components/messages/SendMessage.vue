<template>
    <navbar></navbar>
    <div v-if="isLoading" class="container">
        	<div class="col-sm-12 col-md-12">
        		<h2 class="text-center text-primary">Send Message</h2>
        	</div>
        </div>
        <hr>
        <div class="row">
        	<div class="col-sm-8 col-md-offset-2">
                <div class="row">
                    <div class="col-md-12">
                        <form>
                            <input type="text" class="form-control" name="title" v-model="title" placeholder="Message Title">
                            <br>
                            <textarea class="form-control" name="message" rows="4" v-model="content" placeholder="Message Content"></textarea>
                            <br>
                            <button type="submit" @click="SendMessage" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
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
        navbar: require('./../navbar.vue'),
    },
    data: function () {
        return {
            isLoading: false,
            title: '',
            content: '',
        }
    },
    ready: function () {
        this.$refs.spinner.show();
        this.ReadyDocument();
    },
    methods: {
        ReadyDocument: function () {
            this.isLoading = true;
            this.$refs.spinner.hide();
        },
        SendMessage: function (e) {
            e.preventDefault();
            var formdata = new FormData();
            formdata.append('title', this.title);
            formdata.append('content', this.content);
            formdata.append('user_id', this.$route.params.user_id);
            this.$http.post('/SendMessage', formdata).then(
                function (response) {
                    if (response.body == 'useridissame') {
                        alertify.error("You Can't Send Message To Your Self");
                    }else {
                        this.title = '';
                        this.content = '';
                        alertify.success("Message Has Been Sent Successfully");
                    }
                },
                function (response) {
                    if (response.body == 'You Need To login.') {
                        alert(response.body);
                        window.location = '/login';
                    }
                    for (var key in response.body) {
                        alertify.error(response.body[key]);
                    }
                }
            );
        }
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

<style>

</style>
