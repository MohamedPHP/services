<template>
    <navbar></navbar>
    <div v-if="isLoading" class="container">
        <br><br><br>
        <div class="col-md-8 col-md-offset-2">
            <div class="row nicediv" style="padding: 20px !important;">
                <h3>Add Credit To User
                <a v-link="{name: 'User', params:{user_id: user.id, name:user.name}}" style="color: #777;font-weight: 300; text-decoration: none;cursor: pointer;">
                    <span>{{ user.name }}</span>
                </a>
                </h3>
                <hr>
                <div class="form-group">
                    <label class="control-label"  for="username">Price in $</label>
                    <input type="number" required v-model="price" class="form-control" placeholder="price...">
                </div>
                <button type="button" :disabled="disabled" @click="AddCreditNow" class="btn btn-default btn-block">Add Credit</button>
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
            user: {},
            price: 10,
            disabled: false,
        }
    },
    ready: function () {
        this.$refs.spinner.show();
        this.getAuthUser();
    },
    methods: {
        getAuthUser: function () {
            this.$http.get('/getAuthUser').then(function (response) {
                this.user = response.body.user;
                this.isLoading = true;
                this.$refs.spinner.hide();
            }, function (response) {
                alert('there is some error please contact us');
                window.location = '/';
            });
        },
        AddCreditNow: function () {
            this.disabled = true;
            this.$refs.spinner.show();
            var formData = new FormData();
            formData.append('price', this.price);
            this.$http.post('/AddCreditNow', formData).then(function (response) {
                if (response.body.status == 'done') {
                    this.$refs.spinner.hide();
                    this.disabled = false;
                    swal("Good job!", "Balance Charging Proccess Successed!", "success");
                }
            }, function (response) {
                swal("Error !", "There is Some errors please try again later!", "error");
                for (var key in response.body) {
                    alertify.error(response.body[key]);
                }
                this.disabled = false;
            });
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
