<template>
    <a @click="AddToWishList" class="btn btn-danger"><span class="glyphicon glyphicon-star"></span> Add To WishList</a>
</template>

<script>
export default {
    props: ['service'],
    methods: {
        AddToWishList: function () {
            this.$http.get('/AddToWishList/' + this.service.id).then(
                function (response) {
                    if (response.body == 'AddedToWishList') {
                        swal("Good job!", "Added To Wish List!", "success");
                    }
                    if (response.body == 'you already added this service to wishlist') {
                        alertify.error(response.body);
                    }
                    if (response.body == 'this is your service') {
                        alertify.error(response.body);
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
