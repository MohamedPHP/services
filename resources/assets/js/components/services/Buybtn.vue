<template>
    <a @click="AddOrder" class="btn btn-success btn-product"><span class="glyphicon glyphicon-shopping-cart"></span> Buy</a>
</template>

<script>
export default {
    props: ['service'],
    methods: {
        AddOrder: function () {
            this.$http.get('/AddOrder/' + this.service.id).then(
                function (response) {
                    swal("Good job!", "Order Request Has Been Sent!", "success");
                },
                function (response) {
                    alertify.error("Your Request Has Been Rejected From The Server for one of these resones <br />1- You Requested It Before <br />2- This is your service <br />3- server error", 5000);
                }
            );
        }
    }
}
</script>
