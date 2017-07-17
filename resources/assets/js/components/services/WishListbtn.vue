<template>
    <a @click="AddToWishList" class="btn btn-danger"><span class="glyphicon glyphicon-heart"></span>WishList</a>
</template>

<script>
export default {
    props: ['service'],
    methods: {
        AddToWishList: function () {
            this.$http.get('/AddToWishList/' + this.service.id).then(
                function (response) {
                    if (response.body.status == 'AddedToWishList') {
                        this.$dispatch('AddToparentFav', response.body.sum);
                        swal("Good job!", "Added To Wish List!", "success");
                    }
                    if (response.body.status == 'you already added this service to wishlist') {
                        alertify.error(response.body.status);
                    }
                    if (response.body.status == 'this is your service') {
                        alertify.error(response.body.status);
                    }
                    if (response.body.status == 'you need to login') {
                        alertify.error(response.body.status);
                    }
                },
                function (response) {
                    alert('There Is An Error Please Contact Us');
                    this.$router.go({
                        path: '/',
                    });
                }
            );
        }
    }
}
</script>
