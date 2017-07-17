<template>
    <!-- `name`, `dis`, `image`, `price`, `cat_id` -->
    <navbar></navbar>
    <div v-if="isLoading" class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Add Service Form</h3>
            </div>
            <div class="panel-body">
                <h2 class="text-center text-primary">Add Service</h2>
                <hr>
                <br>
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="name">Name</label>
                        <div class="col-md-10">
                            <input id="name" name="name" v-model="name" type="text" placeholder="service name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="image">image</label>
                        <div class="col-md-10">
                            <input id="image" name="image" v-el:image type="file" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="price">price</label>
                        <div class="col-md-10">
                            <select id="price" name="price" v-model="price" class="form-control">
                                <!-- 5, 10, 15, 20, 25, 30, 40, 50 -->
                                <option value="5" selected>5 $</option>
                                <option value="10">10 $</option>
                                <option value="15">15 $</option>
                                <option value="20">20 $</option>
                                <option value="25">25 $</option>
                                <option value="30">30 $</option>
                                <option value="40">40 $</option>
                                <option value="50">50 $</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="price">Categoury</label>
                        <div class="col-md-10">
                            <select id="cat_id" name="cat_id" v-model="cat_id" class="form-control">
                                <option value="1" selected>programming</option>
                                <option value="2">designers</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="dis">Description</label>
                        <div class="col-md-10">
                            <textarea id="dis" name="dis" v-model="dis" placeholder="service description" class="form-control" rows="8" cols="80"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="AddService"></label>
                        <div class="col-md-10">
                            <button type="submit" @click="AddService" id="AddService" name="AddService" class="btn btn-primary">Add Service</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <spinner v-ref:spinner size="xl" fixed text="Loading..."></spinner>
</template>

<script>
    export default {
        data: function () {
            return {
                name: '',
                dis: '',
                price: '',
                cat_id: '',
                isLoading: false,
            }
        },
        components: {
            spinner: require('vue-strap/dist/vue-strap.min').spinner,
            navbar: require('./../navbar.vue'),
        },
        ready: function () {
            this.$refs.spinner.show();
            this.isLoading = true;
            this.$refs.spinner.hide();
        },
        methods: {
            AddService: function (e) {
                e.preventDefault();
                var formdata = new FormData();
                formdata.append('name', this.name);
                formdata.append('dis', this.dis);
                formdata.append('image', this.$els.image.files[0]);
                formdata.append('price', this.price);
                formdata.append('cat_id', this.cat_id);
                this.$http.post('/AddService', formdata).then(function (response) {
                    if (response.body == 'service added') {
                        swal("Good job!", "service added!", "success");
                        this.name = '';
                        this.dis = '';
                        $('input[name=image]').val(null);
                    }else if (response.body == 'error saving the service') {
                        alertify.error("error saving the service");
                    }else if (response.body == 'selectrightprice') {
                        alertify.error("please select the right price");
                        this.$router.go({
                            path: '/',
                        });
                    }
                }, function (response) {
                    for (var key in response.body) {
                        alertify.error(response.body[key]);
                    }
                });
            }
        }
    }
</script>
