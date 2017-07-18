<template lang="html">
    <navbar></navbar>
    <div v-if="isLoading" class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <h2 class="text-center text-primary">MessageDetails</h2>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <menu></menu>
            </div>
            <div class="col-md-9">
                <div class="left-panel">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <h2>{{ message.title }}</h2>
                                    <p>{{ message.content }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="left-panel">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h3>Sender Informations</h3>
                                <div class="col-md-12">
                                    <h4>
                                        From
                                        <a v-link="{name: 'User', params:{user_id: message.get_sender.id, name:message.get_sender.name}}">{{ message.get_sender.name }}</a>
                                        to
                                        <a v-link="{name: 'User', params:{user_id: message.get_receiver.id, name:message.get_receiver.name}}">{{ message.get_receiver.name }}</a>
                                    </h4>
                                    <div class="btn-group">
                                        <a class="btn btn-warning" v-link="{name: '/SendMessage', params:{user_id: message.get_sender.id}}">Message {{ message.get_sender.name }}</a>
                                    </div>
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
import Menu from './Menu.vue';
export default {
    components: {
        spinner: require('vue-strap/dist/vue-strap.min').spinner,
        menu: Menu,
        navbar: require('./../navbar.vue'),
    },
    data: function () {
        return {
            message: '',
            isLoading: false,
        }
    },
    ready: function () {
        this.$refs.spinner.show();
        this.GetMessageById();
    },
    methods: {
        GetMessageById: function () {
            this.$http.get('/GetMessageById/' + this.$route.params.msg_id + '/' + this.$route.params.message_title).then(function (response) {
                this.message = response.body.message;
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
a, p, h2{text-decoration:none;}

/* PANEL */
.left-panel .panel-default{border-bottom-left-radius:7px; border-bottom-right-radius:7px; border-bottom:2px #DDD solid;}
.left-panel .panel-default .panel-body {padding:15; margin:0;}
.left-panel .panel-default .panel-body .col-md-12{margin:0; padding:0;}
.left-panel .panel-default .panel-body .thumbnail{border:none; margin:0; padding:0; position:relative;}
.left-panel .panel:hover img {opacity:.8;}
.left-panel .panel-default .panel-body .icerik-bilgi{margin:30px;}
.icerik-bilgi .btn-primary{float:right; margin-bottom:30px;}
.icerik-bilgi h2{margin-bottom:30px; color:#333;}
.icerik-bilgi h2:hover{color:#E74C3C; text-decoration:none;}
.icerik-bilgi a:hover{text-decoration:none;}
.icerik-bilgi p{margin-bottom:30px; line-height:25px; font-size:16px;}
</style>
